<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TicketMesa;
use Carbon\Carbon;

class VentasComponent extends Component
{
    public $ventasHoy = 0;
    public $ventasMes = 0;
    public $ventasAnuales = 0;

    public $ticketsHoy = [];
    public $ticketsMes = [];
    public $ticketsAnuales = [];

    public function mount()
    {
        $this->calcularVentas();
    }

    public function calcularVentas()
    {
        $hoy = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $inicioAnio = Carbon::now()->startOfYear();

        // Tickets cerrados hoy
        $this->ticketsHoy = TicketMesa::whereDate('cerrado_en', $hoy)->get();
        $this->ventasHoy = $this->ticketsHoy->sum('total');

        // Tickets cerrados en el mes actual
        $this->ticketsMes = TicketMesa::whereBetween('cerrado_en', [$inicioMes, now()])->get();
        $this->ventasMes = $this->ticketsMes->sum('total');

        // Tickets cerrados en el año actual
        $this->ticketsAnuales = TicketMesa::whereBetween('cerrado_en', [$inicioAnio, now()])->get();
        $this->ventasAnuales = $this->ticketsAnuales->sum('total');
    }

    public function render()
    {
        return view('livewire.ventas-component');
    }
}
