<?php

namespace App\Livewire;

use App\Models\HistoricoComandas;
use Livewire\Component;
use App\Models\TicketMesa;

class TicketMesasComponent extends Component
{
    public $ticketId;
    public $ticket;

    protected $listeners = [
        'ticketActualizado' => 'cargarTicket',
    ];

    public function mount($ticketId)
    {
        $this->ticketId = $ticketId;
        $this->cargarTicket();
    }

    public function cargarTicket()
    {
        $this->ticket = TicketMesa::with('mesa.comandas.stock')->find($this->ticketId);

        // Actualizar total dinámicamente
        if ($this->ticket && $this->ticket->mesa) {
            $this->ticket->update([
                'total' => $this->ticket->mesa->comandas->sum(fn($c) => $c->precio * $c->cantidad)
            ]);
            $this->ticket->refresh();
        }
    }

    public function actualizarTicket()
    {
        $this->cargarTicket();
    }

    public function cerrarMesa()
    {
        if (!$this->ticket || $this->ticket->mesa->comandas->isEmpty()) {
            return;
        }

        $mesa = $this->ticket->mesa;

        // Guardar cada comanda en el histórico
        foreach ($mesa->comandas as $comanda) {
            HistoricoComandas::create([
                'mesa_id' => $comanda->mesa_id,
                'stock_id' => $comanda->stock_id,
                'cantidad' => $comanda->cantidad,
                'precio' => $comanda->precio,
                'notas' => $comanda->notas,
            ]);
        }


        // Cerrar ticket
        $this->ticket->update(['cerrado_en' => now()]);

        // Emitir evento...
        $this->dispatch('cerrarMesaDesdeTicket', $this->ticketId);

        // Recargar ticket
        $this->cargarTicket();
        // Eliminar las comandas de la mesa
        $mesa->comandas()->delete();
        $this->redirect(route('home'));
    }


    public function render()
    {
        return view('livewire.ticket-mesas-component');
    }
}
