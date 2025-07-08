<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReassignUnresolvedTickets extends Command
{
    protected $signature = 'tickets:reassign';
    protected $description = 'Reasigna automáticamente tickets sin resolver en 30 minutos';

    public function handle(): void
    {
        $tickets = Ticket::where('estado_id', 2)
            ->whereNotNull('assigned_to')
            // ->where('updated_at', '<=', now()->subMinutes(30))
            ->get();

        foreach ($tickets as $ticket) {
            $areaId = $ticket->area_id;
            $usuariosDisponibles = User::where('area_id', $areaId)
                ->where('id', '!=', $ticket->assigned_to)
                ->where('available', true)
                ->get();

            if ($usuariosDisponibles->isNotEmpty()) {
                $nuevoResponsable = $usuariosDisponibles->first()->id;

                $ticket->update([
                    'assigned_to' => $nuevoResponsable,
                    'assigned_at' => now(),
                    'estado_id' => 2, // marcado como reasignado
                ]);
            }
        }
    }

    protected function determinarNuevoResponsable(Ticket $ticket): int
    {
        // Aquí tu lógica personalizada para elegir al nuevo usuario
        return 1; // ejemplo fijo
    }
}
