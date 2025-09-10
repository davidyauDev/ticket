<?php

namespace App\Services;

use App\Models\Agencia;
use App\Models\Area;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Models\Estado;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Handle ticket creation logic.
 */
class TicketService
{
    /**
     * Register a new ticket with full business logic.
     *
     * @param array $data
     * @return Ticket
     * @throws \Exception
     */
    public function registrar(array $data): Ticket
    {
        DB::beginTransaction();

        try {
            // Modelo relacionados (solo si es tipo ticket)
            if ($data['tipo'] !== 'consulta') {
                $empresa = Empresa::firstOrCreate(
                    ['id' => $data['ticketData']['id_empresa']],
                    ['nombre' => $data['ticketData']['empresa'] ?? 'Empresa Desconocida']
                );

                $cliente = Cliente::firstOrCreate(
                    ['id' => $data['ticketData']['id_cliente']],
                    ['nombre' => $data['ticketData']['cliente'] ?? 'Cliente Desconocido', 'empresa_id' => $empresa->id]
                );

                $serie = $data['ticketData']['serie'] ?? null;
                if (!empty($data['ticketData']['id_equipo'])) {
                    $equipo = Equipo::firstOrCreate(
                        ['id_equipo' => (int) $data['ticketData']['id_equipo']],
                        [
                            'serie'  => $serie,
                            'modelo_id' => $data['ticketData']['id_modelo'] ?? null,
                            'modelo' => $data['ticketData']['modelo'] ?? 'Modelo Desconocido',
                        ]
                    );
                }
                $agencia = Agencia::firstOrCreate(
                    ['id' => $data['ticketData']['id_agencia']],
                    ['nombre' => $data['ticketData']['agencia'] ?? 'Agencia Desconocida', 'cliente_id' => $cliente->id]
                );
            }

            $areaId = $data['estado_id'] == 2 ? $data['selectedArea'] : Auth::user()->area_id;
            $assignedTo = $data['estado_id'] != 2 ? Auth::id() : null;

            $ticketData = [
                'codigo' => $data['ticketData']['ticket_id'] ?? null,
                'osticket' => $data['ticketData']['number'] ?? null,
                'asunto' => $data['ticketData']['subject'] ?? null,
                'falla_reportada' => $data['ticketData']['falla_reportada'] ?? $data['notes'],
                'tecnico_dni' => $data['ticketData']['dni'] ?? null,
                'tecnico_nombres' => $data['ticketData']['nombres'] ?? null,
                'tecnico_apellidos' => $data['ticketData']['apellidos'] ?? null,
                'comentario' => $data['comentario'],
                'tipo' => $data['tipo'],
                'estado_id' => $data['estado_id'],
                'observacion_id' => $data['tipo'] === 'ticket' ? $data['observacion'] : null,
                'observacion_consulta' => $data['tipo'] === 'consulta' ? $data['observacion'] : null,
                'area_id' => $areaId,
                'assigned_to' => $assignedTo,
                'created_by' => Auth::id(),
                'equipo_id' => $equipo->id ?? null,
                'agencia_id' => $agencia->id ?? null,
                'cliente_id' => $cliente->id ?? null,
                'empresa_id' => $empresa->id ?? null,
                'tipo_soporte_id' => $data['tipo_soporte_id'] ?? null,
                'motivo_derivacion' => $data['motivo_derivacion'] ?? null
            ];

            $ticket = Ticket::create($ticketData);

            TicketHistorial::create([
                'ticket_id' => $ticket->id,
                'usuario_id' => Auth::id(),
                'from_area_id' => null,
                'to_area_id' => $ticket->area_id,
                'asignado_a' => $assignedTo,
                'estado_id' => $ticket->estado_id,
                'started_at' => now(),
                'accion' => $data['estado_id'] == 5 ? 'Creado y Cerrado' : ($data['estado_id'] == 2 ? 'Creado y Derivado' : 'Creado'),
                'comentario' => $data['comentario'],
                'is_current' => true,
            ]);

            if ($data['archivo']) {
                $ruta = $data['archivo']->store('tickets', 'public');
                $ticket->archivos()->create([
                    'nombre_original' => $data['archivo']->getClientOriginalName(),
                    'ruta' => $ruta,
                ]);
                $ticket->historiales()->latest()->first()?->archivos()->create([
                    'nombre_original' => $data['archivo']->getClientOriginalName(),
                    'ruta' => $ruta,
                ]);
            }

            if ($data['resuelto']) {
                $cerrado = Estado::where('nombre', 'Cerrado')->first();
                $ticket->update(['estado_id' => $cerrado->id]);
                TicketHistorial::create([
                    'ticket_id' => $ticket->id,
                    'usuario_id' => Auth::id(),
                    'estado_id' => $cerrado->id,
                    'started_at' => now(),
                    'ended_at' => now(),
                    'accion' => 'Ticket cerrado al momento de su creación',
                    'comentario' => 'Ticket cerrado al momento de su creación',
                    'is_current' => true,
                ]);
            }

            DB::commit();
            return $ticket;
        } catch (\Exception $e) {
            Log::error('Error en TicketService: ' . $e->getMessage());

            DB::rollBack();
            Log::error('Error en TicketService: ' . $e->getMessage());
            throw $e;
        }
    }
}
