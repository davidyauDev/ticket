<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObservacionSeeder extends Seeder
{
    public function run(): void
    {
        $observaciones = [
            'Exceso de suciedad en interior de máquina',
            'Desgaste de piezas de transporte (consumibles)',
            'Rechazo por suciedad o mancha en sensores',
            'Repuestos dañados (No consumibles)',
            'Desconfiguración por parte del usuario',
            'Cable de poder averiado',
            'Repuestos fuera de lugar o rotos por mal uso',
            'Objeto ajeno en interior de máquina',
            'Derivar a taller por caída',
            'Equipo requiere revisión en taller',
            'Equipo necesita mantenimiento general',
            'Software desactualizado',
            'Billete falso o adulterado',
            'Falla o desgaste de sensores',
            'Equipo no encontrado',
            'Otra falla u avería',
            'Otros',
            'Visita frustrada Cliente',
            'Visita Frustrada Cechriza',
            'Ninguna falla',
        ];

        foreach ($observaciones as $descripcion) {
            DB::table('observaciones')->insert([
                'descripcion' => $descripcion,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
                                    