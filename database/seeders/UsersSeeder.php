<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Cargar subáreas (donde parent_id NO es null)
        $subareas = DB::table('areas')
            ->whereNotNull('parent_id')
            ->pluck('id')
            ->toArray();

        // Cargar JSON
        $jsonPath = base_path('database/data/ost_staff_202505021105.json');
        $jsonData = File::get($jsonPath);
        $staffData = json_decode($jsonData, true)['select * from ost_staff os '];

        foreach ($staffData as $user) {
            DB::table('users')->insert([
                'staff_id' => $user['staff_id'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'name' => $user['firstname'],
                'email' => $user['email'],
                'password' => bcrypt('123456'),
                'dni' => isset($user['dni']) ? intval($user['dni']) : null,
                'direccion' => $user['direccion'],
                'phone' => $user['phone'],
                //'area_id' => $subareas ? $subareas[array_rand($subareas)] : null, // Solo subáreas
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
