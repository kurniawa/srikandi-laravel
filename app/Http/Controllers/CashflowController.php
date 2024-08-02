<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\AcuanPembukuan;
use App\Models\Cart;
use App\Models\Cashflow;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Saldo;
use App\Models\Wallet;
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
        // dd($data);
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
        $wallets_non_tunai = Wallet::where('kategori', 'non-tunai')->get();
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
            'wallets_non_tunai' => $wallets_non_tunai,
            'user' => $user,
            'data' => Item::get_data_for_create_item('perhiasan'),
        ];
        // dd($data);
        return view('cashflows.transaksi', $data);
    }


    function store_transaction(Request $request)
    {
        $post = $request->post();
        dd($post);
        if ($post['kategori'] == "Buyback Perhiasan") {
            $candidate_new_item = Item::validasi_item($request);
            // Strategi:
            // 1. Bikin item baru. Kalau ada similiar items, maka pilih dari similiar items atau tetap dengan item yang sudah diinput.
            // 2. Create Surat Pembelian baru
            // 3. Langsung proses buyback surat tersebut
            list($item_exist, $data) = Item::check_item_exist($candidate_new_item, $post);
            // if (count($item_exist)) {
            //     // dump($data);
            //     $data['route1'] = 'items.store';
            //     $data['route2'] = 'items.show';
            //     // dd($data);
            //     return view('items.found_similiar_items', $data);
            // }
            if (count($item_exist)) {
                // dump($item_exist);
                $data['route1'] = 'cashflow.store_and_buyback';
                $data['route2'] = 'items.show';
                // dd($data);
                return view('items.found_similiar_items', $data);
            }
        }
        // dd($post['kategori']);
        $request->validate([
            'tipe_transaksi' => 'required',
            'kategori' => 'required',
            'total_tagihan' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'sisa_bayar' => 'required|numeric',
        ]);
        $success_ = '';
        $user = Auth::user();
        $time_key = time();
        $kode_accounting = "$user->id.$time_key";
        $total_bayar = Cashflow::create_cashflow($user->id, $time_key, $kode_accounting, null, $post);

        $kategori_2 = null;
        if (isset($post['kategori_2'])) {
            if ($post['kategori_2']) {
                $kategori_2 = $post['kategori_2'];
            }
        }

        Accounting::create([
            'kode_accounting' => $kode_accounting,
            'surat_pembelian_id' => null,
            'surat_pembelian_item_id' => null,
            'nama_barang' => null,
            'user_id' => $user->id,
            'tipe' => $post['tipe_transaksi'],
            'kategori' => $post['kategori'],
            'kategori_2' => $kategori_2,
            'deskripsi' => $post['deskripsi'],
            'jumlah' => $total_bayar,
        ]);

        $success_ .= "Transaksi baru telah dibuat!";
        $feedback = [
            'success_' => $success_
        ];
        return redirect()->route('cashflow.index')->with($feedback);
    }

    function store_and_buyback(Request $request) {
        $post = $request->post();
        dd($post);
        $candidate_new_item = Item::validasi_item($request);
        $item_new = Item::create($candidate_new_item);
        Item::store_itemMata_dan_itemMainan($post, $item_new);
    }

    // function show_item_and_buyback(Item $item) {
    //     $user = Auth::user();
    //     $cart = null;
    //     if ($user) {
    //         $cart = Cart::where('user_id', $user->id)->first();
    //     }

    //     $data = [
    //         'menus' => Menu::get(),
    //         'route_now' => 'items.show',
    //         'profile_menus' => Menu::get_profile_menus(Auth::user()),
    //         'item' => $item,
    //         'cart' => $cart,
    //         'user' => $user,
    //         'run_buyback_sequence' => 'yes',
    //     ];
    //     // dd($data);
    //     return view('items.show', $data);
    // }

    // function show_item_and_buyback_store(Item $item) {
        
    // }
}
