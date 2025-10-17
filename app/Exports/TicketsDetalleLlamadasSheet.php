<?php

namespace App\Exports;

use App\Models\Ticket;
use App\Models\TicketHistorial;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsDetalleLlamadasSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function array(): array
    {
        // 🔹 Consultar tickets con asignaciones y sus relaciones
        $query = Ticket::query()
            ->whereNotNull('assigned_to')
            ->whereYear('created_at', now()->year);

        if ($this->mes) {
            $query->whereMonth('created_at', $this->mes);
        }

        $calls = $query->with([
            'assignedUser:id,firstname,lastname',
            'equipo.modelo:id,descripcion'
        ])
            ->orderByDesc('created_at')
            ->get();

        // 🔹 Agrupar por técnico
        $grouped = [];

        foreach ($calls as $ticket) {
            $user = $ticket->assignedUser;
            $userName = $user
                ? trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? ''))
                : 'Sin Nombre Asignado';

            if (!isset($grouped[$userName])) {
                $grouped[$userName] = [
                    'total' => 0,
                    'calls' => []
                ];
            }

            // 🔹 Calcular tiempo efectivo
            $fechaInicio = $ticket->created_at;
            $historialCierre = TicketHistorial::where('ticket_id', $ticket->id)
                ->whereHas('estado', fn($q) => $q->where('nombre', 'cerrado'))
                ->orderByDesc('created_at')
                ->first();

            $fechaCierre = $historialCierre?->created_at;
            $tiempoEfectivo = null;

            if ($fechaInicio && $fechaCierre) {
                $duracionTotal = $fechaInicio->diffInSeconds($fechaCierre);

                $pausas = TicketHistorial::where('ticket_id', $ticket->id)
                    ->where('estado_id', 6)
                    ->whereNotNull('started_at')
                    ->whereNotNull('ended_at')
                    ->get();

                $segundosEnPausa = $pausas->reduce(function ($carry, $pausa) {
                    $startedAt = Carbon::parse($pausa->started_at);
                    $endedAt = Carbon::parse($pausa->ended_at);
                    return $carry + $startedAt->diffInSeconds($endedAt);
                }, 0);

                $tiempoEfectivo = $duracionTotal - $segundosEnPausa;

                $tiempoEfectivo = Carbon::now()
                    ->addSeconds($tiempoEfectivo)
                    ->diffForHumans(Carbon::now(), [
                        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                        'parts' => 3,
                    ]);
            }

            $modelo = $ticket->equipo?->modelo ?? 'Sin modelo';

            $grouped[$userName]['total']++;
            $grouped[$userName]['calls'][] = [
                'Código'        => 'TCK-' . str_pad($ticket->id, 7, '0', STR_PAD_LEFT),
                'Fecha'         => $ticket->created_at->format('d/m/Y H:i'),
                'Modelo'        => $modelo,
                'Tiempo de Solución' => $tiempoEfectivo ?? 'En progreso',
                'Comentario'    => $ticket->motivo_derivacion ?? $ticket->comentario ?? 'Sin comentario',
            ];
        }

        // 🔹 Construir la tabla final para Excel
        $excelData = [];
        $excelData[] = [' Detalle de Llamadas'];
        $excelData[] = ['Mes', $this->mes ? Carbon::create()->month($this->mes)->locale('es')->translatedFormat('F') : 'Todos los meses'];
        $excelData[] = [];

        foreach ($grouped as $technician => $tickets) {
            $excelData[] = ["Técnico: {$technician}", "Total llamadas: " . count($tickets['calls'])];
            $excelData[] = ['Código', 'Fecha', 'Modelo', 'Tiempo de Solución', 'Comentario'];

            foreach ($tickets['calls'] as $ticket) {
                $excelData[] = [
                    $ticket['Código'],
                    $ticket['Fecha'],
                    $ticket['Modelo'],
                    $ticket['Tiempo de Solución'],
                    $ticket['Comentario'],
                ];
            }

            $excelData[] = []; // espacio entre técnicos
        }


        return $excelData;
    }

    public function styles(Worksheet $sheet)
    {
        // 🔹 Estilos generales
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // 🔹 Detectar filas con encabezados
        $highestRow = $sheet->getHighestRow();
        for ($i = 1; $i <= $highestRow; $i++) {
            $cellA = $sheet->getCell("A{$i}")->getValue();

            // Nombre del técnico
            if (str_contains($cellA, 'Técnico:')) {
                $sheet->getStyle("A{$i}:E{$i}")->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle("A{$i}:E{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFE2E8F0');
            }

            // Encabezados de tabla
            if ($cellA === 'Código') {
                $sheet->getStyle("A{$i}:E{$i}")->getFont()->setBold(true);
                $sheet->getStyle("A{$i}:E{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFDDEBF7');
            }
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18, // Código
            'B' => 20, // Fecha
            'C' => 25, // Modelo
            'D' => 25, // Tiempo
            'E' => 50, // Comentario
        ];
    }

    public function title(): string
    {
        return 'Detalle de Llamadas';
    }
}
