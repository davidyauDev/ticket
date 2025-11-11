<?php

namespace App\Jobs;

use App\Mail\TicketNotificadoMail;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReassignTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticketId;
    public $initialAssigneeId; // Usado solo para el log o el historial

    public function __construct($ticketId, $initialAssigneeId)
    {
        $this->ticketId = $ticketId;
        $this->initialAssigneeId = $initialAssigneeId;
    }

    public function handle(): void
    {
        $ticket = Ticket::find($this->ticketId);
        $ticketId = $this->ticketId;

        if (!$ticket) {
            Log::info("Ticket #{$ticketId}: No encontrado. Finalizando ciclo.");
            return;
        }
        if ($ticket->estado_id != 2) {
            Log::info("Ticket #{$ticketId}: Estado {$ticket->estado_id} (Atendido/Cerrado). Finalizando ciclo.");
            return;
        }

        $usuariosPrevios = TicketHistorial::where('ticket_id', $ticket->id)->pluck('asignado_a')->toArray();

        $responsables = DB::table('responsables_modelo')
            ->where('id_modelo', $ticket->id_modelo)
            ->orderBy('prioridad', 'asc')
            ->get();

        $proximoResponsableModelo = $responsables
            ->whereNotIn('id_user', $usuariosPrevios)
            ->first();

        if ($proximoResponsableModelo) {

            $nextAssigneeId = $proximoResponsableModelo->id_user;
            $nextAssignee = User::find($nextAssigneeId);
            $ticket->assigned_to = $nextAssigneeId;
            $ticket->save();

            TicketHistorial::create([
                'ticket_id'    => $ticket->id,
                'usuario_id'   => $nextAssigneeId,
                'from_area_id' => $ticket->area_id,
                'to_area_id'   => $ticket->area_id,
                'asignado_a'   => $nextAssigneeId,
                'estado_id'    => $ticket->estado_id,
                'accion'       => "Reasignado automáticamente a {$nextAssignee->name}",
                'comentario'   => "Ticket reasignado automáticamente a {$nextAssignee->name} según prioridad del modelo.",
                'started_at'   => now(),
                'ended_at'     => null,
                'is_current'   => false,
            ]);
            Mail::to($nextAssignee->email)->queue(new TicketNotificadoMail($ticket));
            $this->notificarPorWhatsApp($nextAssignee, $ticket);

            self::dispatch($ticketId, $nextAssigneeId)
                ->delay(now()->addMinutes(15));

            return;
        } else {

            $responsablesTotal = $responsables->pluck('id_user')->toArray();

            Log::error("Ticket #{$ticketId}: CICLO AGOTADO. No se encontró un responsable elegible.", [
                'Responsables_Totales' => $responsablesTotal,
                'Usuarios_Previos' => $usuariosPrevios,
                'Razón' => 'Todos los responsables ya han sido asignados (Historial de usuarios previos coincide con el total de responsables).',
            ]);
            return;
        }
    }

    private function notificarPorWhatsApp(User $usuario, Ticket $ticket): void
    {
        Log::info($usuario->phone);
        
        // Obtener la sesión activa de WhatsApp
        $activeSession = DB::table('whats_app_sessions')
            ->where('status', 'active')
            ->first();
        
        if (!$activeSession) {
            Log::error("No hay sesión activa de WhatsApp disponible para notificar al usuario {$usuario->id}");
            return;
        }
        
        $response = Http::asForm()->post(env('WHATSAPP_API_URL', 'http://172.19.0.17/whatsapp/api/send'), [
            'sessionId' => $activeSession->session_id,
            'to'        => '51' . $usuario->phone,
            'message'   => "Se te asignó un ticket OST #{$ticket->osticket} - {$ticket->motivo_derivacion}\n" .
                "Agencia: {$ticket->agencia->nombre}\n" .
                "Técnico: {$ticket->tecnico_nombres} {$ticket->tecnico_apellidos}\n\n" .
                "*Por favor, revisa el sistema MESA DE AYUDA para más detalles.*\n" .
                "Gracias.",
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data['success']) && !empty($data['status'])) {
                Log::info("WhatsApp enviado correctamente", $data);
            } else {
                Log::warning("WhatsApp con fallo parcial", $data);
            }
        } else {
            Log::error("Error HTTP al enviar WhatsApp", [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        }
    }
}
