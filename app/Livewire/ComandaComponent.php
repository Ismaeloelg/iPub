<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Comanda;
use App\Models\Mesa;
use App\Models\Stock;
use App\Models\TicketMesa;
use Livewire\Component;

class ComandaComponent extends Component
{
    public $mesa;
    public $categorias;
    public $categoriaSeleccionada = null;
    public $productosFiltrados = [];
    public $comandas = [];
    public $ticket;

    public $stockId;
    public $cantidad;
    public $notas;
    public $pantalla = 'comanda';




    protected $listeners = [
        'comandaEliminada' => 'actualizarProductosEliminado',
        'comandaEditada' => 'actualizarProductosEditado',
        'cerrarMesaDesdeTicket' => 'limpiarEstadoTicket'
    ];

    public function mount(Mesa $mesa)
    {
        $this->mesa = $mesa;
        $this->categorias = Categoria::withCount('stocks')->get();
        $this->obtenerComandas();
        $this->refrescarProductosFiltrados();

        if ($this->categorias->isNotEmpty()) {
            $this->categoriaSeleccionada = $this->categorias->first()->id;
            $this->productosFiltrados = Categoria::find($this->categoriaSeleccionada)
                ->stocks()
                ->where('disponible', true)
                ->get();
        }

        $this->ticket = TicketMesa::firstOrCreate(
            ['mesa_id' => $this->mesa->id, 'cerrado_en' => null],
            [
                'numero_ticket' => 'TCK-' . str_pad(TicketMesa::count() + 1, 5, '0', STR_PAD_LEFT),
                'total' => 0,
            ]
        );
    }

    public function verProductos($categoriaId)
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

    public function agregarProducto($stockId)
    {
        $usuarioId = session('logged_user_id');
        $stock = Stock::find($stockId);

        if (!$stock) return;


        $comandaExistente = Comanda::where('mesa_id', $this->mesa->id)
            ->where('stock_id', $stockId)
            ->where('notas', $this->notas)
            ->first();

        if ($comandaExistente) {
            $comandaExistente->increment('cantidad');
        } else {
            Comanda::create([
                'mesa_id' => $this->mesa->id,
                'stock_id' => $stockId,
                'cantidad' => 1,
                'precio' => $stock->precio_venta,
                'notas' => $this->notas,
                'user_id' => $usuarioId,
            ]);
        }


        $stock->decrement('unidades');

        $this->obtenerComandas();
        $this->refrescarProductosFiltrados();
        // Avisar al ticket para refrescar
        $this->dispatch('ticketActualizado');

        $this->reset(['stockId', 'cantidad', 'notas']);
    }

    public function obtenerComandas()
    {
        $this->comandas = Comanda::where('mesa_id', $this->mesa->id)->get();
    }

    public function cambiarPantalla($pantalla)
    {
        $this->pantalla = $pantalla;
    }


    public function limpiarEstadoTicket($ticketId)
    {
        $this->ticket = null;
        $this->comandas = [];
    }

    public function actualizarProductosEliminado($stockId, $cantidad)
    {
        $stock = Stock::find($stockId);
        if ($stock) {
            $stock->increment('unidades', $cantidad);
        }
        $this->obtenerComandas();
        if ($this->categoriaSeleccionada) {
            $this->productosFiltrados = Categoria::find($this->categoriaSeleccionada)
                ->stocks()
                ->where('disponible', true)
                ->get();
        }
    }

    public function actualizarProductosEditado()
    {
        $this->obtenerComandas();
    }

    private function refrescarProductosFiltrados()
    {
        if ($this->categoriaSeleccionada) {
            $this->productosFiltrados = Categoria::find($this->categoriaSeleccionada)
                ->stocks()
                ->where('disponible', true)
                ->get();
        }
    }


    public function render()
    {
        return view('livewire.comanda-component', [
            'mesa' => $this->mesa,
            'ticket' => $this->ticket,
        ]);
    }
}
