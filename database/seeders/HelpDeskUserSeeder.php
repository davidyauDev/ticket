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
         $rawUsers = [
            // Primer grupo
            ['Ricardo Alberto Zumaeta Peralta', '73715231', '980755152', 'ricardo.zumaeta@cechriza.net'],
            ['Félix Manuel Galagarza Gutierrez', '21463768', '991692712', 'felix.galagarza@cechriza.com'],
            ['Juan Carlos Angel Asencio Méndez', '44534138', '989166695', 'juan.asencios@cechriza.com'],
            ['Sergio Gerardo Manturano Cornejo', '74304671', '940379859', 'sergio.manturano@cechriza.net'],
            ['Carlos Joal Silva Salazar', '47029459', '943152057', 'joal.silva@cechriza.com'],
            ['Jorge Luis Chavez Torres', '9607103', '986622214', 'jorge.chavez@cechriza.net'],
            ['Emilio Arturo Mejia Avalos', '8563353', '991692718', 'arturo.mejia@cechriza.net'],
            ['Ruben Alejandro Zarate Rios', '47368502', '980755746', 'ruben.zarate@cechriza.net'],
            ['Jenyfer Milagros Rojas Torres', '70311069', '978762114', 'jenyfer.rojas@cechriza.com'],
            ['Eliseo Jose Yauyo Salazar', '10145773', '982537652', 'eliseo.yauyo@cechriza.com'],
            ['Diego Luis Zavala Taboada', '44758233', '991692709', 'diego.zavala@cechriza.com'],
            ['Jeison Hernan Condori Baltazar', '44262275', '978760500', 'jeison.condori@cechriza.com'],

            // Segundo grupo (nuevo)
            ['Hector Fernando Blas Cadillo', '78287290', '965492169', 'hector.blas@cechriza.net'],
            ['Omar Humberto Julian Grillo Huapaya', '41829688', '983275980', 'omar.grillo@cechriza.net'],
            ['Eduardo Lopez Tanta', '70117279', '983275979', 'eduardo.lopez@ydieza.com'],
            ['Carlos Haderly Meza Baldera', '70015264', '963346853', 'carlos.meza@cechriza.net'],
            ['Jaime Jorge Cuba Ochoa', '71225845', '978760347', 'jaime.cuba@cechriza.net'],
            ['Antonio Hugo Luque Torres', '45486985', '941082339', 'antonio.luque@cechriza.net'],
            ['Julio Vitelio García Mayta', '47089716', '965395177', 'julio.garcia@ydieza.com'],
            ['John Alexys Gonzales Villanueva', '45428953', '989083979', 'john.gonzales@cechriza.net'],
            ['Nestor Erasmo Ramos Huillca', '47113210', '966365068', 'nestor.ramos@cechriza.net'],
            ['Dacio Wilder Delgado Pariona', '25845892', '986622215', 'dacio.delgado@cechriza.net'],
            ['Wilfredo Orlando Saenz Carrillo', '8662685', '991692713', 'orlando.saenz@cechriza.net'],
            ['Miguel Gonzalo Carpio Chavez', '42196014', '943720650', 'miguel.carpio@cechriza.net'],
        ];

        foreach ($rawUsers as [$fullName, $dni, $phone, $email]) {
            $parts = explode(' ', $fullName);

            // Extraer nombres y apellidos
            $firstname = $parts[0] . ' ' . $parts[1];
            $lastname = implode(' ', array_slice($parts, 2));

            // Definir area_id según reglas
            $areaId = 2; // default
            if (in_array($dni, ['9607103', '8563353'])) {
                $areaId = 1;
            } elseif (in_array($dni, ['44262275', '70311069', '10145773'])) {
                $areaId = 4;
            }

            User::create([
                'name' => $firstname,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'dni' => $dni,
                'phone' => $phone,
                'email' => $email,
                'password' => Hash::make('Cechriza2930'),
                'area_id' => $areaId,
            ]);
        }
       
}
}
