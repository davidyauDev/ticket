<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        DB::table('clientes')->insert([
            [ 
                'nombre' => 'BCP',
                'empresa_id' => 1, // Asumiendo que Cecheriza SAC tiene ID 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Interbank',
                'empresa_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'BBVA ',
                'empresa_id' => 2, // Asumiendo que Transporte Gómez SRL tiene ID 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
