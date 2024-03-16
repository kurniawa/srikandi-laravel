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
            ['nama' => 'Adi Kurniawan', 'username' => 'cibinongguy', 'password' => 'ffloveakunsomuch','role'=>'Developer'],
            ['nama' => 'Adi Kurniawan', 'username' => 'kuruniawa', 'password' => 'ddloveakunsomuch','role'=>'SuperAdmin'],
            ['nama' => 'Aldebaran', 'username' => 'aldebaran', 'password' => 'aldebaranloveandin','role'=>'User'],
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
            ]);
        }

    }
}
