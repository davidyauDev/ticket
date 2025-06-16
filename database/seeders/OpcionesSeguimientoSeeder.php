<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpcionesSeguimientoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear opción padre
        $seguimiento = Option::create([
            'group' => 'seguimiento_tecnico',
            'label' => 'SEGUIMIENTO AL TECNICO',
            'value' => 'seguimiento_al_tecnico',
        ]);

        // Crear subopciones
        Option::insert([
            [
                'parent_id' => $seguimiento->id,
                'group' => 'seguimiento_tecnico',
                'label' => 'CONTADORES',
                'value' => 'contadores',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => $seguimiento->id,
                'group' => 'seguimiento_tecnico',
                'label' => 'BBVA - CABLE RED',
                'value' => 'bbva_cable_red',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => $seguimiento->id,
                'group' => 'seguimiento_tecnico',
                'label' => 'BBVA - VENTANILLA',
                'value' => 'bbva_ventanilla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => $seguimiento->id,
                'group' => 'seguimiento_tecnico',
                'label' => 'BBVA - PRUEBAS DE DEPURACIÓN',
                'value' => 'bbva_pruebas_depuracion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
