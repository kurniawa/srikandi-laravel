<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = [
            ['nama' => 'Adi Kurniawan', 'username' => 'cibinongguy', 'password' => 'ffloveakunsomuch','role'=>'Developer', 'clearance_level'=>1],
            ['nama' => 'Adi Kurniawan', 'username' => 'kuruniawa', 'password' => 'ddloveakunsomuch','role'=>'SuperAdmin', 'clearance_level'=>2],
            ['nama' => 'Aldebaran', 'username' => 'aldebaran', 'password' => 'aldebaran','role'=>'Admin', 'clearance_level'=>3],
            ['nama' => 'Andin', 'username' => 'andin', 'password' => 'andin','role'=>'User', 'clearance_level'=>5],
            ['nama' => 'Udin', 'username' => 'udin', 'password' => 'udin','role'=>'Client', 'clearance_level'=>5],
        ];

        for ($i = 0; $i < count($user); $i++) {
            $password=$user[$i]['password'];
            if ($user[$i]['username']!=='Dian' || $user[$i]['username']!=='Albert21') {
                $password=bcrypt($password);
            }
            DB::table('users')->insert([
                'nama' => $user[$i]['nama'],
                'username' => $user[$i]['username'],
                'password' => $password,
                'role' => $user[$i]['role'],
                'clearance_level' => $user[$i]['clearance_level'],
            ]);
        }

    }
}
