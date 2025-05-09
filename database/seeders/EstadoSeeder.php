<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('estados')->insert([
        ['nombre' => 'Pendiente'],
        ['nombre' => 'Derivado'],
        ['nombre' => 'En proceso'],
        ['nombre' => 'Resuelto'],
        ['nombre' => 'Cerrado'],
    ]);
}

}
