<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteTicketsExport implements WithMultipleSheets
{
    protected $mes;

    public function __construct($mes = null)
    {
        if ($mes === '' || $mes === 'null' || $mes === null) {
            $this->mes = null;
        } else {
            $this->mes = (int) $mes;
        }
    }

    public function sheets(): array
    {
        return [
            new TicketsListFilteredSheet($this->mes),
            // new TicketsResumenSheet($this->mes),
            // new TicketsTecnicosSheet($this->mes),
            // new TicketsAreasSheet($this->mes),
            // new TicketsDetalleLlamadasSheet($this->mes),
            // new TicketsTopClientesSheet($this->mes),
            // new TicketsTopAgenciasSheet($this->mes),
            // new TicketsTopModelosSheet($this->mes),
            // new TicketsTopEquiposSheet($this->mes),
        ];
    }
}
