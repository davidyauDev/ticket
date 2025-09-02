<?php

namespace App\Console\Commands;

use App\Mail\TicketNotificadoMail;
use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReassignUnresolvedTickets extends Command
{
    protected $signature = 'tickets:reassign';
    protected $description = 'Reasigna automáticamente tickets sin resolver en 30 minutos';

    public function handle(): void
    {
        $tickets = Ticket::where('estado_id', 2)
            ->whereNotNull('assigned_to')
            ->get();

        Log::info('Reasignando tickets sin resolver', [
            'count' => $tickets->count(),
            'timestamp' => now(),
        ]);

        foreach ($tickets as $ticket) {
            $areaId = $ticket->area_id;
            $usuariosPrevios = TicketHistorial::where('ticket_id', $ticket->id)->pluck('asignado_a')->toArray();
            $usuariosDisponibles = User::where('area_id', $areaId)
                ->whereNotIn('id', array_merge($usuariosPrevios, [$ticket->assigned_to]))
                ->where('available', true)
                ->orderBy('priority')
                ->get();
            Log::info($usuariosDisponibles->toArray());
            Log::info($usuariosPrevios);
            if ($usuariosDisponibles->isNotEmpty()) {
                $nuevoResponsable = $usuariosDisponibles->first()->id;
                $nuevoResponsableName = $usuariosDisponibles->first()->name;
                $ticket->update([
                    'assigned_to' => $nuevoResponsable,
                    'assigned_at' => now(),
                    'estado_id' => 2,
                ]);
                Mail::to('yauridavid00@gmail.com')->queue(new TicketNotificadoMail($ticket));
                TicketHistorial::create([
                    'ticket_id'    => $ticket->id,
                    'usuario_id'   => $nuevoResponsable,
                    'from_area_id' => $ticket->area_id,
                    'to_area_id'   => $ticket->area_id,
                    'asignado_a'   => $ticket->assigned_to,
                    'estado_id'    => $ticket->estado_id,
                    'accion'       => "Reasignado automáticamente a {$nuevoResponsableName}",
                    'comentario'   => "Ticket reasignado automáticamente a {$nuevoResponsableName} debido a inactividad.",
                    'started_at'   => now(),
                    'ended_at'     => null,
                    'is_current'   => false,
                ]);
            }
        }
    }
}
