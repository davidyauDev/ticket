<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = range(1, 10);
        $areaIds = DB::table('areas')->pluck('id')->toArray();
        $estadoIds = DB::table('estados')->pluck('id')->toArray();
        $equipoIds = DB::table('equipos')->pluck('id')->toArray();
        $agenciaIds = DB::table('agencias')->pluck('id')->toArray();

        for ($i = 1; $i <= 2; $i++) {
            $codigo = 'TCK-' . str_pad($i, 6, '0', STR_PAD_LEFT);
            $createdBy = fake()->randomElement($userIds);
            $areaId = fake()->randomElement($areaIds);
            $estadoId = fake()->randomElement($estadoIds);
            $equipoId = fake()->randomElement($equipoIds);
            $agenciaId = fake()->randomElement($agenciaIds);

            $ticketId = DB::table('tickets')->insertGetId([
                'codigo' => $codigo,
                'asunto' => fake()->sentence(4),
                'falla_reportada' => fake()->sentence(6),
                'tipo' => fake()->randomElement(['ticket', 'consulta']),
                'tecnico_dni' => fake()->numerify('########'),
                'tecnico_nombres' => fake()->firstName(),
                'tecnico_apellidos' => fake()->lastName(),
                'comentario' => null,
                'observacion_consulta' => null,
                'equipo_id' => $equipoId,
                'agencia_id' => $agenciaId,
                'area_id' => $areaId,
                'assigned_to' => null,
                'created_by' => $createdBy,
                'estado_id' => $estadoId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('ticket_historial')->insert([
                'ticket_id' => $ticketId,
                'usuario_id' => $createdBy,
                'from_area_id' => null,
                'to_area_id' => $areaId,
                'asignado_a' => null,
                'estado_id' => $estadoId,
                'accion' => 'registrado',
                'is_current' => true,
                'comentario' => 'Ticket registrado',
                'started_at' => now(),
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
