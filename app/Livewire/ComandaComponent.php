<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Comanda;
use App\Models\HistoricoComandas;
use App\Models\Mesa;
use App\Models\Stock;
use App\Models\TicketMesa;
use Livewire\Component;

class ComandaComponent extends Component
{
    public $producto;
    public $ticket;
    public $pantalla = 'comanda';
    public $comandas = [];
    public $stockId;
    public $cantidad;
    public $precio;
    public $estado;
    public $notas;

    public $mesa;
    public $stocks;

    public $categorias;
    public $categoriaSeleccionada = null;
    public $productosFiltrados = [];
    public $comandaTemporal = [];

    protected $listeners = [
        'comandaEliminada' => 'actualizarProductosEliminado',
        'comandaEditada' => 'actualizarProductosEditado'
    ];

    // -------------------------
    // MÉTODOS DE ACTUALIZACIÓN
    // -------------------------
    public function actualizarProductosEliminado($stockId, $cantidad)
    {
        $stock = Stock::find($stockId);

        if ($stock) {
            $stock->unidades += $cantidad;
            $stock->save();
        }

        // Refrescar comandas
        $this->obtenerComandas();

        if ($this->categoriaSeleccionada) {
            $this->productosFiltrados = Categoria::find($this->categoriaSeleccionada)
                ->stocks()
                ->where('disponible', true)
                ->get();
        }
    }

    // -------------------------
    // MÉTODOS DE SELECCIÓN
    // -------------------------
    public function verProductos($categoriaId): void
    {
        if ($this->categoriaSeleccionada == $categoriaId) {
            $this->categoriaSeleccionada = null;
            $this->productosFiltrados = [];
            return;
        }

        $this->categoriaSeleccionada = $categoriaId;
        $this->productosFiltrados = Categoria::find($categoriaId)
            ->stocks()
            ->where('disponible', true)
            ->get();
    }

    public function seleccionarProducto($id)
    {
        if ($this->stockId == $id) {
            $this->cantidad = $this->cantidad + 1;
        } else {
            $this->stockId = $id;
            $this->cantidad = 1;
        }
    }

    public function agregarProducto($stockId)
    {
        $this->stockId = $stockId;
        $this->cantidad = 1; // cantidad por defecto
        $this->notas = null;

        $this->crearComanda(); // esto crea la comanda y actualiza el ticket

        if ($this->categoriaSeleccionada) {
            $this->productosFiltrados = Categoria::find($this->categoriaSeleccionada)
                ->stocks()
                ->where('disponible', true)
                ->get();
        }

    }

    // -------------------------
    // MÉTODO MOUNT
    // -------------------------
    public function mount(Mesa $mesa)
    {
        $this->mesa = $mesa;
        $this->stocks = Stock::all();
        $this->categorias = Categoria::withCount('stocks')->get();

        $this->obtenerComandas();

        if ($this->categorias->isNotEmpty()) {
            $this->categoriaSeleccionada = $this->categorias->first()->id;
            $this->productosFiltrados = Categoria::find($this->categoriaSeleccionada)
                ->stocks()
                ->where('disponible', true)
                ->get();
        }

        $ticket = TicketMesa::where('mesa_id', $this->mesa->id)
            ->whereNull('cerrado_en')
            ->first();

        if (!$ticket) {
            $ticket = TicketMesa::create([
                'mesa_id' => $this->mesa->id,
                'numero_ticket' => 'TCK-' . str_pad(TicketMesa::count() + 1, 5, '0', STR_PAD_LEFT),
                'total' => 0,
                'cerrado_en' => null,
            ]);
        }

        $this->ticket = $ticket;
    }

    // -------------------------
    // MÉTODO CREAR COMANDA
    // -------------------------
    public function crearComanda()
    {
        $this->validate([
            'stockId' => 'required|exists:stocks,id',
            'cantidad' => 'required|numeric|min:1',
            'notas' => 'nullable|string',
        ]);

        $stock = Stock::find($this->stockId);

        $comandaExistente = Comanda::where('mesa_id', $this->mesa->id)
            ->where('stock_id', $this->stockId)
            ->where('notas', $this->notas)
            ->first();

        if ($comandaExistente) {
            $comandaExistente->cantidad += $this->cantidad;
            $comandaExistente->save();
        } else {
            Comanda::create([
                'mesa_id' => $this->mesa->id,
                'stock_id' => $this->stockId,
                'cantidad' => $this->cantidad,
                'precio' => $stock->precio_venta,
                'notas' => $this->notas,
            ]);
        }

        $stock->unidades -= $this->cantidad;
        $stock->save();

        // -------------------------
        // ZONA TICKET
        // -------------------------
        $ticket = TicketMesa::where('mesa_id', $this->mesa->id)
            ->whereNull('cerrado_en')
            ->first();

        if (!$ticket) {
            $ticket = TicketMesa::create([
                'mesa_id' => $this->mesa->id,
                'numero_ticket' => 'TCK-' . str_pad(TicketMesa::count() + 1, 5, '0', STR_PAD_LEFT),
                'total' => 0,
                'cerrado_en' => null,
            ]);
        }

        $ticket->update([
            'total' => $this->mesa->comandas->sum(fn($c) => $c->precio * $c->cantidad)
        ]);

        $this->ticket = $ticket;

        // Limpiar inputs
        $this->reset(['stockId', 'cantidad', 'notas']);

        $this->obtenerComandas();
    }

    // -------------------------
//  CERRAR MESA / PAGAR
// -------------------------
    public function cerrarMesa()
    {
        if (!$this->ticket || $this->ticket->mesa->comandas->isEmpty()) {
            return; // nada que cerrar
        }

        // Marcar ticket como cerrado
        $this->ticket->update([
            'cerrado_en' => now()
        ]);

        // Guardar cada comanda en el histórico
        foreach ($this->mesa->comandas as $comanda) {
            HistoricoComandas::create([
                'mesa_id' => $comanda->mesa_id,
                'stock_id' => $comanda->stock_id,
                'cantidad' => $comanda->cantidad,
                'precio' => $comanda->precio,
                'notas' => $comanda->notas,
            ]);
        }

        // Eliminar las comandas de la mesa (ahora están en el histórico)
        $this->mesa->comandas()->delete();


        // Opcional: actualizar total final por si se añade algo al mismo tiempo
        $this->ticket->update([
            'total' => $this->mesa->comandas->sum(fn($c) => $c->precio * $c->cantidad)
        ]);

        // Limpiar estado local del componente
        $this->ticket = null;
        $this->comandas = [];
        return redirect()->route('home');
    }
    // -------------------------
    // OTROS MÉTODOS
    // -------------------------
    public function obtenerComandas()
    {
        $this->comandas = Comanda::where('mesa_id', $this->mesa->id)->get();
    }

    public function cambiarPantalla($pantalla)
    {
        $this->pantalla = $pantalla;
    }

    public function render()
    {
        return view('livewire.comanda-component', [
            'mesa' => $this->mesa,
            'ticket' => $this->ticket,
        ]);
    }
}
