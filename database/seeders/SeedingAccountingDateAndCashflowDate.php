<?php

namespace Database\Seeders;

use App\Models\Accounting;
use App\Models\Cashflow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedingAccountingDateAndCashflowDate extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accountings = Accounting::all();
        foreach ($accountings as $accounting) {
            $accounting->accounting_date = $accounting->created_at;
            $accounting->save();
        }

        $cashflows = Cashflow::all();
        foreach ($cashflows as $cashflow) {
            $cashflow->cashflow_date = $cashflow->created_at;
            $cashflow->save();
        }
    }
}
