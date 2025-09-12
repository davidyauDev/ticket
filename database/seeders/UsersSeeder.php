<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UsersSeeder extends Seeder
{
    public function run()
    {

        $jsonPath = base_path('database/data/ost_staff_202505021105.json');
        $jsonData = File::get($jsonPath);
        $staffData = json_decode($jsonData, true)['select * from ost_staff os '];

        foreach ($staffData as $user) {
            DB::table('tecnicos')->insert([
                'staff_id' => $user['staff_id'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'name' => $user['firstname'],
                'email' => $user['email'],
                'dni' => isset($user['dni']) ? intval($user['dni']) : null,
                'direccion' => $user['direccion'],
                'phone' => $user['phone'],
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
