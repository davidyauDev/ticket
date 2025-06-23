<?php

namespace Database\Seeders;

use App\Models\Estado;
use App\Models\TipoSoporte;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            ///EstadoSeeder::class,
            ////AreaSeeder::class,
            ////HelpDeskUserSeeder::class,
            ///EmpresaSeeder::class,
            //ClientSeeder::class,
            //AgenciaSeeder::class,
            //EquiposSeeder::class,
            ///ObservacionSeeder::class,
            //TicketSeeder::class,
            ///UsersSeeder::class,
            //OpcionesSeguimientoSeeder::class,
            TipoSoporteSeeder::class,
        ]);
    }
}
