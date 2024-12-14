<?php

namespace Database\Seeders;

use App\Models\Accounting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddUsernameToAccountingsTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Accounting::all() as $accounting) {
            $accounting->username = User::find($accounting->user_id)->username;
            $accounting->save();
        }
    }
}
