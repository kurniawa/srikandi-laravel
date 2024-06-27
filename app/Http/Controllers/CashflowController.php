<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\AcuanPembukuan;
use App\Models\Cart;
use App\Models\Cashflow;
use App\Models\Menu;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    function index(Request $request)
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $get_day = (int)date("d");
        $get_month = (int)date("m");
        $get_year = date("Y");

        $col_cashflows = collect();
        $col_saldos = collect();
        $col_accountings = collect();
        $col_total = collect();

        for ($i = $get_day; $i >= 1; $i--) {
            $from = "$get_year-$get_month-$i";
            $until = "$get_year-$get_month-$i 23:59:59";


            $cashflows = Cashflow::whereBetween('created_at', [$from, $until])->orderByDesc("created_at")->get();
            $day = $i;
            $month = $get_month;

            if (strlen((string)$i) < 2) {
                $day = "0$i";
            }

            if (strlen((string)$month) < 2) {
                $month = "0$month";
            }
            $col_cashflows->push([
                "hari" => $day,
                "bulan" => $month,
                "tahun" => $get_year,
                "cashflows" => $cashflows,
            ]);
            // Accounting
            $accountings = Accounting::whereBetween('created_at', [$from, $until])->orderByDesc("created_at")->get();
            // if (count($accountings)) {
            //     dump($accountings);
            // }
            $col_accountings->push([
                "hari" => $day,
                "bulan" => $month,
                "tahun" => $get_year,
                "accountings" => $accountings,
            ]);
            $pemasukan = 0;
            $pengeluaran = 0;
            foreach ($accountings as $accounting) {
                if ($accounting->tipe == 'pemasukan') {
                    $pemasukan += (int)$accounting->jumlah;
                } elseif ($accounting->tipe == 'pengeluaran') {
                    $pengeluaran += (int)$accounting->jumlah;
                }
            }
            $col_total->push(
                [
                    'total_pemasukan' => $pemasukan,
                    'total_pengeluaran' => $pengeluaran,

                ]
            );

            // SALDO
            // $saldos = Saldo::whereBetween("created_at", [$from, $until])->get();
            // $saldo_awal = 0;
            // $saldo_akhir = 0;
            // if (count($saldos)) {
            //     foreach ($saldos as $saldo) {
            //         $saldo_awal += $saldo->saldo_awal;
            //         $saldo_akhir += $saldo->saldo_akhir;
            //     }
            // }
            // $col_saldos->push([
            //     'saldo_awal' => $saldo_awal,
            //     'saldo_akhir' => $saldo_akhir,
            // ]);
        }

        // SALDO PADA WALLET
        $wallets = Saldo::select('nama_wallet')->groupBy('nama_wallet')->get();
        // dd($wallets);
        $saldos = collect();
        foreach ($wallets as $wallet) {
            $saldo = Saldo::where('nama_wallet', $wallet->nama_wallet)->latest()->first();
            $saldos->push($saldo);
        }
        // $saldos = Saldo::all();
        // END - SALDO PADA WALLET

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'col_cashflows' => $col_cashflows,
            'col_saldos' => $col_saldos,
            'col_accountings' => $col_accountings,
            'col_total' => $col_total,
            'saldos' => $saldos,
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
        ];
        // dd('stop');
        return view('cashflows.index', $data);
    }

    function transaksi($tipe_transaksi)
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $acuan_pembukuans = AcuanPembukuan::all();
        // dd($acuan_pembukuans);
        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'tipe' => $tipe_transaksi,
            'acuan_pembukuans' => $acuan_pembukuans,
        ];
        // dd($data);
        return view('cashflows.transaksi', $data);
    }


    function store_transaction(Request $request)
    {
        $post = $request->post();
        dd($post);
    }
}
