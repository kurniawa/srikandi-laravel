<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cashflow;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCashflowTest extends TestCase
{
    // use RefreshDatabase;

    public function test_create_cashflow()
    {
        // Persiapkan data dummy
        // $wallet = Wallet::factory()->create([
        //     'kategori_wallet' => 'kategori_test',
        //     'tipe_wallet' => 'tipe_test',
        //     'nama_wallet' => 'wallet_test',
        //     'saldo' => 1000,
        // ]);

        $params = [
            'user_id' => 2,
            'time_key' => time(),
            'kode_accounting' => 'ACC001',
            'surat_pembelian_id' => 1,
            'cashflow_date' => "16-12-2024T15:00:00",
            'is_earlier_date' => true,
            'post' => [
                'kategori_wallet' => ['tunai', 'non-tunai'],
                'tipe_wallet' => ['laci', 'bank'],
                'nama_wallet' => ['cash', 'BCA'],
                'jumlah_pembayaran' => [1000000, 500000],
                'tipe_transaksi' => 'pengeluaran',
            ],
        ];

        // Panggil fungsi create_cashflow
        $cashflow_model = new \App\Models\Cashflow();
        $jumlah_terima_total = $cashflow_model->create_cashflow($params);

        // Assert hasil
        // $this->assertEquals(500, $jumlah_terima_total);
        // $this->assertDatabaseHas('cashflows', [
        //     'nama_wallet' => 'wallet_test',
        //     'saldo' => 1500,
        // ]);
    }
}
