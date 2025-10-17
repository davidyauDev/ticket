<?php

namespace App\Livewire\Ticket;

use App\Exports\ReporteTicketsExport;
use Livewire\Component;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;

class Dashboard extends Component
{
    public string $activeTab = 'resumen';
    public int|null $selectedMonth = null; 
    
    protected $queryString = ['activeTab'];

    public function mount()
    {
        $this->selectedMonth = now()->month; 
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
