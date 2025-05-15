<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'Operaciones',
            'Programación Lima',
            'Presupuestos',
            'Supervisor',
            'Técnicos LIMA',
            'Técnicos PROV',
            'Sistemas y TI',
            'Programación Provincia',
            'Taller',
            'Ingeniería',
            'Almacén',
            'Call Center',
            'RRHH',
        ];

        foreach ($areas as $nombre) {
            DB::table('areas')->insert([
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
