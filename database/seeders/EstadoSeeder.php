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
        ['id' => 1, 'nombre' => 'Pendiente'],
        ['id' => 2, 'nombre' => 'Derivado'],
        ['id' => 3, 'nombre' => 'En proceso'],
        ['id' => 4, 'nombre' => 'Resuelto'],
        ['id' => 5, 'nombre' => 'Cerrado'],
    ]);
}

}
