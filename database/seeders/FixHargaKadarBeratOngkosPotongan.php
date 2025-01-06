<?php

namespace Database\Seeders;

use App\Models\HargaPasaran;
use App\Models\Item;
use App\Models\Kadar;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixHargaKadarBeratOngkosPotongan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (HargaPasaran::all() as $harga_pasaran) {
            $harga_pasaran->kadar = $harga_pasaran->kadar / 100;
            $harga_pasaran->harga_beli = $harga_pasaran->harga_beli / 100;
            $harga_pasaran->harga_buyback = $harga_pasaran->harga_buyback / 100;
            $harga_pasaran->save();
        }

        foreach (Item::all() as $item) {
            $item->kadar = $item->kadar / 100;
            $item->berat = $item->berat / 100;
            $item->ongkos_g = $item->ongkos_g / 100;
            $item->harga_g = $item->harga_g / 100;
            $item->harga_t = $item->harga_t / 100;
            $item->save();
        }

        foreach (Kadar::all() as $kadar) {
            $kadar->kadar = $kadar->kadar / 100;
            $kadar->save();
        }

        foreach (SuratPembelian::all() as $surat_pembelian) {
            $sisa_bayar = $surat_pembelian->sisa_bayar;
            $total_buyback = $surat_pembelian->total_buyback;

            if ($sisa_bayar) {
                $sisa_bayar = $sisa_bayar/100;
            }

            if ($total_buyback) {
                $total_buyback = $total_buyback / 100;
            }

            $surat_pembelian->harga_total = $surat_pembelian->harga_total / 100;
            $surat_pembelian->total_bayar = $surat_pembelian->total_bayar / 100;
            $surat_pembelian->sisa_bayar = $sisa_bayar;
            $surat_pembelian->total_buyback = $total_buyback;
            $surat_pembelian->save();
        }

        foreach (SuratPembelianItem::all() as $spi) {
            $berat_susut = $spi->berat_susut;
            $berat_buyback = $spi->berat_buyback;
            $potongan_ongkos = $spi->potongan_ongkos;
            $potongan_mata = $spi->potongan_mata;
            $potongan_rusak = $spi->potongan_rusak;
            $potongan_susut = $spi->potongan_susut;
            $potongan_lain = $spi->potongan_lain;
            $total_potongan = $spi->total_potongan;
            $harga_buyback = $spi->harga_buyback;
            if ($berat_susut) {
                $berat_susut /= 100;
            }
            if ($berat_buyback) {
                $berat_buyback /= 100;
            }
            if ($potongan_ongkos) {
                $potongan_ongkos /= 100;
            }
            if ($potongan_mata) {
                $potongan_mata /= 100;
            }
            if ($potongan_rusak) {
                $potongan_rusak /= 100;
            }
            if ($potongan_susut) {
                $potongan_susut /= 100;
            }
            if ($potongan_lain) {
                $potongan_lain /= 100;
            }
            if ($total_potongan) {
                $total_potongan /= 100;
            }
            if ($harga_buyback) {
                $harga_buyback /= 100;
            }
            $spi->kadar = $spi->kadar / 100;
            $spi->berat = $spi->berat / 100;
            $spi->ongkos_g = $spi->ongkos_g / 100;
            $spi->harga_g = $spi->harga_g / 100;
            $spi->harga_t = $spi->harga_t / 100;
            $spi->berat_susut = $berat_susut;
            $spi->berat_buyback = $berat_buyback;
            $spi->potongan_ongkos = $potongan_ongkos;
            $spi->potongan_mata = $potongan_mata;
            $spi->potongan_rusak = $potongan_rusak;
            $spi->potongan_susut = $potongan_susut;
            $spi->potongan_lain = $potongan_lain;
            $spi->total_potongan = $total_potongan;
            $spi->harga_buyback = $harga_buyback;
            $spi->save();
        }

        foreach (Wallet::all() as $wallet) {
            $saldo = $wallet->saldo;
            if ($saldo) {
                $saldo /= 100;
            }
            $wallet->saldo = $saldo;
            $wallet->save();
        }
    }
}
