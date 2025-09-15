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
use Illuminate\Support\Facades\Http;

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

                Mail::to("isaac.ramos@cechriza.com")->queue(new TicketNotificadoMail($ticket));
                $response = Http::asForm()->post('http://172.19.0.17/whatsapp/api/send', [
                'sessionId' => 'mi-sesion-12',
                'to'        => '51923158511',
                'message'   => 'Se te asigno un ticket OST #' . $ticket->osticket . ' - ' . $ticket->titulo . '. Por favor, revisa el sistema MESA DE AYUDA para más detalles. Gracias.',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['success'] && $data['status']) {
                    Log::info("WhatsApp enviado: " . $data['message']);
                } else {
                    Log::warning("Fallo parcial en envío WhatsApp", $data);
                }
            } else {
                Log::error("Error HTTP al enviar WhatsApp", [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }

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

                break; // salimos, ya lo reasignamos
            }
        }
    }
}
