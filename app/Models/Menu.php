<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    use HasFactory;

    public static function get() {
        $user = Auth::user();

        if ($user) {
            if ($user->role !== 'developer') {
                $menus = collect([
                    // ['name'=>'Penjualan','route'=>'penjualans.index'],
                    // ['name'=>'Pembelian','route'=>'pembelians.index'],
                    // ['name'=>'Accounting','route'=>'accounting.index'],
                ]);
            } else {
                $menus = collect([
                    // ['name'=>'Penjualan','route'=>'penjualans.index'],
                    // ['name'=>'Pembelian','route'=>'pembelians.index'],
                    // ['name'=>'Accounting','route'=>'accounting.index'],
                    // ['name'=>'Artisan','route'=>'artisan.index'],
                ]);
            }
        } else {
            $menus = collect([
                // ['name'=>'Penjualan','route'=>'penjualans.index'],
                // ['name'=>'Pembelian','route'=>'pembelians.index'],
                // ['name'=>'Accounting','route'=>'accounting.index'],
                // ['name'=>'Artisan','route'=>'artisan.index'],
            ]);
        }

        return $menus;
    }

    public static function get_profile_menus($user) {
        $menus = collect();
        if (isset($user)) {
            if ($user !== null) {
                if ($user->clearance_level == 6) {
                    $menus->push(
                        // ['name'=>'Your Profile','route'=>'user.profile'],
                        // ['name'=>'Settings','route'=>'settings'],
                        ['name'=>'Surat / Transaksi','route'=>'surat_pembelian.index', 'params'=>$user->id],
                        ['name'=>'Accounting','route'=>'cashflow.index', 'params'=>$user->id],
                        ['name'=>'Artisan Commands','route'=>'artisans.index'],
                        ['name'=>'Log Out','route'=>'logout'],
                    );
                } else {
                    $menus->push(
                        // ['name'=>'Your Profile','route'=>'user.profile'],
                        // ['name'=>'Settings','route'=>'settings'],
                        ['name'=>'Daftar Pelanggan','route'=>'pelanggans.index'],
                        ['name'=>'Surat / Transaksi','route'=>'surat_pembelian.index', 'params'=>$user->id],
                        ['name'=>'Accounting','route'=>'cashflow.index', 'params'=>$user->id],
                        ['name'=>'Log Out','route'=>'logout'],
                    );
                }
            }
        } else {
            $menus->push(
                ['name'=>'Log in','route'=>'login']
            );
        }

        return $menus;
    }

    public static function get_pembelian_menus() {
        $menus = collect([
            ['name'=>'Pembelian','route'=>'pembelians.index'],
            ['name'=>'Barang','route'=>'barangs.index'],
            ['name'=>'Supplier','route'=>'suppliers.index'],
        ]);

        return $menus;
    }

    // public static function get_spk_menus() {
    //     $menus = collect([
    //         ['name'=>'SPK','route'=>'home'],
    //         ['name'=>'Pelanggan','route'=>'pelanggans.index'],
    //         ['name'=>'Ekspedisi','route'=>'ekspedisis.index'],
    //         ['name'=>'Produk','route'=>'produks.index'],
    //     ]);

    //     return $menus;
    // }

    public static function get_accounting_menus() {
        return [
            ['name'=>'Instansi','route'=>'accounting.index'],
            ['name'=>'Relasi Transaksi','route'=>'accounting.transactions_relations'],
        ];
    }
}
