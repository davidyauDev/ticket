<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            ['nombre' => 'Recursos Humanos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tecnología', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Finanzas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
