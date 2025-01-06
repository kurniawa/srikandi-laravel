<?php

namespace Database\Seeders;

use App\Models\Accounting;
use App\Models\Cashflow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixJumlahDanSaldo extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Accounting::all() as $accounting) {
            $accounting->jumlah = $accounting->jumlah / 100;
            $accounting->save();
        }

        foreach (Cashflow::all() as $cashflow) {
            $cashflow->jumlah = $cashflow->jumlah / 100;
            $cashflow->saldo = $cashflow->saldo / 100;
            $cashflow->save();
        }
    }
}
