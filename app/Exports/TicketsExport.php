<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TicketsExport implements FromCollection
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function collection()
    {
        // Ejemplo de datos de prueba (puedes luego usar Eloquent)
        return collect([
            ['Mes seleccionado', $this->mes ?? 'Todos los meses'],
            ['Nombre', 'Tickets Resueltos'],
            ['Jorge Luis Chavez', 35],
            ['Emilio Arturo Mejía', 23],
            ['Carlos Joal Silva', 5],
        ]);
    }
}
