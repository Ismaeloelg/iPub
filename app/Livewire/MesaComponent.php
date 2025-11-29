<?php

namespace App\Livewire;

use App\Models\Mesa;
use Livewire\Component;

class MesaComponent extends Component
{
    public $mesas;

    public function mount()
    {
        $this->mesas = Mesa::with('comandas')->get();
    }



    protected $listeners = ['mesaCerrada' => 'recargarMesas'];

    public function recargarMesas($mesaId)
    {
        // Recarga todas las mesas o solo la que se cerró
        $this->mesas = Mesa::with('comandas')->get();
    }


    public function abrirMesa($mesaId)
    {
        $mesa = Mesa::find($mesaId);
        if ($mesa) {
            $mesa->estado = 'ocupada';
            $mesa->save();
            $this->mesas = Mesa::all();

            return redirect()->route('comanda', ['mesa' => $mesaId]);
        }
    }

    public function ticketActual()
    {
        return $this->tickets()->where('cerrado_en')->first();
    }

    public function render()
    {
        return view('livewire.mesa-component');
    }
}
