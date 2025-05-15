<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asumiendo que ya tienes clientes con ID 1 (BCP), 2 (Interbank), y 3 (BBVA)
        DB::table('agencias')->insert([
            [
                'nombre' => 'BCP - Miraflores',
                'cliente_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'BCP - San Isidro',
                'cliente_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Interbank - La Molina',
                'cliente_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'BBVA - Surco',
                'cliente_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'BBVA - San Borja',
                'cliente_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
