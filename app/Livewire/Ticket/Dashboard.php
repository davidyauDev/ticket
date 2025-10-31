<?php

namespace App\Livewire\Ticket;

use App\Exports\ReporteTicketsExport;
use Livewire\Component;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;
use App\Models\Ticket;

class Dashboard extends Component
{
    public string $activeTab = 'resumen';
    public int|null $selectedMonth = null;

    // Métricas principales
    public $totalTickets = 0;
    public $ticketsCerrados = 0;
    public $ticketsPendientes = 0;

    protected $queryString = ['activeTab'];

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->cargarMetricas();
    }

    public function cargarMetricas()
    {
        // Obtener todos los tickets del año actual
        $añoActual = Carbon::now()->year;

        $this->totalTickets = Ticket::whereYear('created_at', $añoActual)->count();

        $this->ticketsCerrados = Ticket::whereYear('created_at', $añoActual)
            ->where('estado_id', 5) // Estado cerrado
            ->count();

        $this->ticketsPendientes = $this->totalTickets - $this->ticketsCerrados;
    }

    public function getNombreMesProperty()
    {
        return $this->selectedMonth
            ? Carbon::create()->month($this->selectedMonth)->translatedFormat('F')
            : 'Todos los meses';
    }


    public function exportarExcel($mes = null)
    {
        $nombreArchivo = 'reporte_tickets_' . ($mes ?: 'todos') . '.xlsx';
        return Excel::download(new ReporteTicketsExport($mes), $nombreArchivo);
    }


    public function exportarPDF($mes = null)
    {
        $pdfExport = new \App\Exports\ReporteTicketsPDFExport($mes);
        return $pdfExport->generar();
    }


    public function render()
    {
        return view('livewire.ticket.dashboard');
    }
}
