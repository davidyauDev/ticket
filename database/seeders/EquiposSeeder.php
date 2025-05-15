<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        DB::table('equipos')->insert([
            [
                'serie' => 'LAC17(602791702)',
                'modelo' => 'LAC 17',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'serie' => 'LAC19(602791703)',
                'modelo' => 'LAC 19',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'serie' => 'LAC21(602791704)',
                'modelo' => 'LAC 21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
