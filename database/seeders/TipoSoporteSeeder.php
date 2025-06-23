<?php

namespace Database\Seeders;

use App\Models\TipoSoporte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSoporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Soporte para identificación de repuestos',
            'Soporte para armado de equipos',
            'Soporte para configuración de equipos',
            'Soporte para calibración de equipos',
            'Soporte para solución de fallas específicas',
        ];

        foreach ($tipos as $tipo) {
            TipoSoporte::create(['nombre' => $tipo]);
        }
    }
}
