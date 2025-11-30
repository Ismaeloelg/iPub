<?php

namespace App\Livewire;

use App\Models\Comanda;
use Livewire\Component;

class EditComandaComponent extends Component
{
    public Comanda $comanda;

    public $editando = false;
    public $cantidades = [];
    public $notasArray = [];

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount(Comanda $comanda)
    {
        $this->comanda = $comanda;
        $this->cantidades[$comanda->id] = $comanda->cantidad;
        $this->notasArray[$comanda->id] = $comanda->notas ?? '';
    }

    /**
     * Método privado para actualizar cantidad y stock
     */
    private function actualizarCantidadYStock($nuevoValor)
    {
        $comanda = $this->comanda;
        $stock = $comanda->stock;

        $cantidadAnterior = $comanda->cantidad;
        $diferencia = $nuevoValor - $cantidadAnterior;

        if ($diferencia > 0) {
            if ($stock->unidades < $diferencia) {
                session()->flash('mensaje', 'No hay suficiente stock disponible.');
                // Revertir cantidad en el input
                $this->cantidades[$comanda->id] = $cantidadAnterior;
                return false;
            }
            $stock->decrement('unidades', $diferencia);
        } elseif ($diferencia < 0) {
            $stock->increment('unidades', abs($diferencia));
        }

        $stock->save();
        $comanda->update(['cantidad' => $nuevoValor]);

        $this->dispatch('comandaEditada'); // Refrescar productos en el padre
        return true;
    }

    /**
     * Incrementar cantidad con botón
     */
    public function incrementarCantidad($id)
    {
        $nuevoValor = $this->cantidades[$id] + 1;
        $this->cantidades[$id] = $nuevoValor;
        $this->actualizarCantidadYStock($nuevoValor);
    }

    /**
     * Disminuir cantidad con botón
     */
    public function decrementarCantidad($id)
    {
        $nuevoValor = max(0, $this->cantidades[$id] - 1);
        $this->cantidades[$id] = $nuevoValor;
        $this->actualizarCantidadYStock($nuevoValor);
    }

    /**
     * Guardar cantidad desde input (Enter)
     */
    public function guardarCantidad($id)
    {
        $nuevoValor = intval($this->cantidades[$id]);
        $this->actualizarCantidadYStock($nuevoValor);
        session()->flash('mensaje', 'Cantidad guardada correctamente.');
    }

    /**
     * Guardar nota
     */
    public function guardarNota($id)
    {
        $this->validate([
            "notasArray.$id" => 'nullable|string|max:255',
        ]);

        $comanda = $this->comanda;
        $comanda->update([
            'notas' => $this->notasArray[$id],
        ]);

        $this->dispatch('comandaEditada');
        $this->notasArray[$id] = '';
        session()->flash('mensaje', 'Nota guardada correctamente.');
    }

    /**
     * Eliminar comanda
     */
    public function eliminar()
    {
        $stockId = $this->comanda->stock_id;
        $cantidad = $this->comanda->cantidad;

        $this->comanda->delete();

        $this->dispatch('comandaEliminada', $stockId, $cantidad);
        session()->flash('mensaje', 'Comanda eliminada correctamente.');
    }

    public function render()
    {
        return view('livewire.edit-comanda-component');
    }
}
