<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteTicketsExport implements WithMultipleSheets
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function sheets(): array
{
    return [
        new TicketsTecnicosSheet($this->mes),
        new TicketsDetalleLlamadasSheet($this->mes),
        new TicketsTopClientesSheet($this->mes),
        new TicketsTopAgenciasSheet($this->mes),
        new TicketsTopModelosSheet($this->mes),
        new TicketsTopEquiposSheet($this->mes),
    ];
}
}
