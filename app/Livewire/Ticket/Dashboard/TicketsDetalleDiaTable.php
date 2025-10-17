<?php

namespace App\Livewire\Ticket\Dashboard;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TicketsDetalleDiaTable extends Component
{
    public $fecha;
    public array $showHistorial = [];

    public function mount()
    {
        $this->fecha = now()->toDateString();
    }

    public function render()
    {
        $tickets = DB::table('tickets')
            ->join('tecnicos', 'tickets.staff_id', '=', 'tecnicos.staff_id')
            ->leftJoin('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->leftJoin('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->leftJoin('estados', 'tickets.estado_id', '=', 'estados.id')
            ->leftJoin('agencias', 'tickets.agencia_id', '=', 'agencias.id')
            ->select([
                'tickets.id',
                'tickets.created_at',
                DB::raw("CONCAT(tickets.tecnico_nombres, ' ', tickets.tecnico_apellidos) as tecnico_nombres"),
                'agencias.nombre as agencia_nombre',
                'estados.nombre as estado_nombre',
                'modelos.descripcion as modelo_nombre',
            ])
            ->whereDate('tickets.created_at', $this->fecha)
            ->orderByDesc('tickets.created_at')
            ->get();
        $historiales = DB::table('ticket_historial')
            ->leftJoin('users as usuarios', 'ticket_historial.usuario_id', '=', 'usuarios.id')
            ->leftJoin('areas as from_area', 'ticket_historial.from_area_id', '=', 'from_area.id')
            ->leftJoin('areas as to_area', 'ticket_historial.to_area_id', '=', 'to_area.id')
            ->leftJoin('estados', 'ticket_historial.estado_id', '=', 'estados.id')
            ->select([
                'ticket_historial.id',
                'ticket_historial.ticket_id',
                'ticket_historial.accion',
                'ticket_historial.comentario',
                'ticket_historial.started_at',
                'ticket_historial.ended_at',
                'ticket_historial.is_current',
                'usuarios.name as usuario_nombre',
                'from_area.nombre as from_area',
                'to_area.nombre as to_area',
                'estados.nombre as estado_nombre',
            ])
            ->orderBy('ticket_historial.ticket_id')
            ->orderBy('ticket_historial.id')
            ->get()
            ->groupBy('ticket_id');


        return view('livewire.ticket.dashboard.tickets-detalle-dia-table', [
            'tickets' => $tickets,
            'historiales' => $historiales
        ]);
    }
}
