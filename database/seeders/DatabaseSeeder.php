<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@cechriza.net',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->call([
            EstadoSeeder::class,
            AreaSeeder::class,
            ObservacionSeeder::class,
            TipoSoporteSeeder::class,
            ModelSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
