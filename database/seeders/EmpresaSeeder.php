<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::table('empresas')->insert([
            [
                'nombre' => 'Cecheriza SAC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ydieza SAC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
