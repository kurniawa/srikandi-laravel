<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-commands';

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
        $this->info(now());
        $this->info(now()->toISOString());
        $example_object_push = [
            'user_id' => 2,
            'username' => 'kuruniawa',
            'surat_pembelian_id' => 88,
            'kode_accounting' => 'code',
        ];
        $example_object_push['cart_item_id'] = 99;
        var_dump($example_object_push);
    }
}
