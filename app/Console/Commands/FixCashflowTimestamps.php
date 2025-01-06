<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixCashflowTimestamps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-cashflow-timestamps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cashflows = DB::table('cashflows')
            ->orderBy('cashflow_date')
            ->get();

        $previousTimestamp = null;

        foreach ($cashflows as $cashflow) {
            $currentTimestamp = strtotime($cashflow->cashflow_date);

            if ($previousTimestamp !== null && $currentTimestamp <= $previousTimestamp) {
                // Tambah 1 detik ke timestamp
                $currentTimestamp = $previousTimestamp + 1;

                // Update database
                DB::table('cashflows')
                    ->where('id', $cashflow->id)
                    ->update([
                        'cashflow_date' => date('Y-m-d H:i:s', $currentTimestamp),
                    ]);
            }

            $previousTimestamp = $currentTimestamp;
        }

        $this->info('Timestamps have been fixed.');
    }
}
