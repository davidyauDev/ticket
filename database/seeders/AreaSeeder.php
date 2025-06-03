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
            'Mesa de Ayuda',
            'Ingeniería',
        ];

        $subareas = [
            'CIMA',
            'MONEDAS',
            'MAQUINAS CHICAS',
        ];

        foreach ($areas as $nombre) {
            // Insertar área principal
            $parentId = DB::table('areas')->insertGetId([
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
                'created_at' => now(),
                'updated_at' => now(),  
            ]);

            // Insertar subáreas específicas para cada área
            foreach ($subareas as $subNombre) {
                DB::table('areas')->insert([
                    'nombre' => $subNombre,
                    'slug' => Str::slug($subNombre . ' ' . $nombre),
                    'parent_id' => $parentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
