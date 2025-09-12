<?php

namespace App\Console\Commands;

use App\Mail\TicketNotificadoMail;
use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReassignUnresolvedTickets extends Command
{
    protected $signature = 'tickets:reassign';
    protected $description = 'Reasigna automáticamente tickets sin resolver en 30 minutos según modelo y prioridad';

    public function handle(): void
    {
        $tickets = Ticket::where('estado_id', 2)
            ->whereNotNull('assigned_to')
            ->with('equipo.modelo') 
            ->get();

  

        foreach ($tickets as $ticket) {
             Log::info('Reasignando tickets sin resolver', [
            'count' => $ticket->equipo->modelo_id,
            'timestamp' => now(),
        ]);
            if (!$ticket->equipo || !$ticket->equipo->modelo_id) {
                continue; // si no hay modelo, no se reasigna
            }

            $modeloId = $ticket->equipo->modelo_id;

            // Usuarios que ya atendieron este ticket
            $usuariosPrevios = TicketHistorial::where('ticket_id', $ticket->id)->pluck('asignado_a')->toArray();

            // Buscar responsables por modelo ordenados por prioridad (usando Query Builder)
            $responsables = DB::table('responsables_modelo')
                ->where('id_modelo', $modeloId)
                ->orderBy('prioridad', 'asc')
                ->get();

            foreach ($responsables as $responsable) {
                $usuario = User::find($responsable->id_user);

                if (!$usuario) {
                    continue;
                }

                // Evitar asignar al mismo o a alguien que ya lo tuvo
                if (in_array($usuario->id, $usuariosPrevios) || $usuario->id == $ticket->assigned_to) {
                    continue;
                }

                // ✅ Encontramos el nuevo responsable
                $ticket->update([
                    'assigned_to' => $usuario->id,
                    'assigned_at' => now(),
                    'estado_id'   => 2,
                ]);

                Mail::to($usuario->email)->queue(new TicketNotificadoMail($ticket));

                TicketHistorial::create([
                    'ticket_id'    => $ticket->id,
                    'usuario_id'   => $usuario->id,
                    'from_area_id' => $ticket->area_id,
                    'to_area_id'   => $ticket->area_id,
                    'asignado_a'   => $usuario->id,
                    'estado_id'    => $ticket->estado_id,
                    'accion'       => "Reasignado automáticamente a {$usuario->name}",
                    'comentario'   => "Ticket reasignado automáticamente a {$usuario->name} según prioridad del modelo.",
                    'started_at'   => now(),
                    'ended_at'     => null,
                    'is_current'   => false,
                ]);

                Log::info("Ticket {$ticket->id} reasignado a {$usuario->name}");
                break; // salimos, ya lo reasignamos
            }
        }
    }
}
