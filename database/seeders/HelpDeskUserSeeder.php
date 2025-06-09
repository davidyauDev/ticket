<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HelpDeskUserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario admin
        User::create([
            'name' => 'Admin',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@cechriza.net',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Lista de usuarios
        $usuarios = [
            // CIMA -> id: 2
            ['name' => 'EDUARDO LOPEZ', 'area_id' => 2],
            ['name' => 'FREDY PORTUGAL', 'area_id' => 2],

            // MONEDAS -> id: 3
            ['name' => 'OMAR GRILLO', 'area_id' => 3],
            ['name' => 'ANTONIO LUQUE', 'area_id' => 3],

            // MAQUINAS CHICAS -> id: 4
            ['name' => 'ARTURO MEJIA', 'area_id' => 4],
            ['name' => 'JORGE CHAVEZ', 'area_id' => 4, 'email' => 'jorge.chavez@cechriza.net'],

            // Otros con correos específicos
            ['name' => 'JOAL SILVA', 'email' => 'joal.silva@cechriza.com', 'area_id' => 8],
            ['name' => 'CARLOS CORDOVA', 'email' => 'carlos.cordova@cechriza.com', 'area_id' => 7],
            ['name' => 'FELIX GALAGARZA', 'email' => 'felix.galagarza@cechriza.com', 'area_id' => 8],
            ['name' => 'JUAN ASENCIOS', 'email' => 'juan.asencios@cechriza.com', 'area_id' => 8],
        ];

        foreach ($usuarios as $usuario) {
            $partes = explode(' ', $usuario['name']);
            $firstname = ucfirst(strtolower($partes[0]));
            $lastname = isset($partes[1]) ? ucfirst(strtolower($partes[1])) : '';

            // Si ya se especificó un email lo usamos, si no lo generamos
            $correoBase = strtolower($partes[0] . ($partes[1] ?? ''));
            $email = $usuario['email'] ?? ($correoBase . '@cechriza.net');

            User::create([
                'name' => $usuario['name'],
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => Hash::make('123456'),
                'role' => 'user',
                'area_id' => $usuario['area_id'] ?? null,
            ]);
        }
    }
}
