<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\AcuanPembukuan;
use App\Models\Cart;
use App\Models\Cashflow;
use App\Models\Item;
use App\Models\Menu;
use App\Models\SuratPembelian;
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

        $get = $request->query();
        $from_day = '1';
        $from_month = date("m");
        $from_year = date("Y");

        $to_day = date("d");
        $to_month = date("m");
        $to_year = date("Y");

        $to_day_copy = $to_day;
        $to_month_copy = $to_month;
        $to_year_copy = $to_year;

        if (count($get)) {
            // dump($get);
            $from_day = $get['from_day'];
            $from_month = $get['from_month'];
            $from_year = $get['from_year'];

            $to_day = $get['to_day'];
            $to_month = $get['to_month'];
            $to_year = $get['to_year'];

            $to_day_copy = (int)$to_day;
            $to_month_copy = (int)$to_month;
            $to_year_copy = (int)$to_year;
        }

        $col_cashflows = collect();
        $col_saldos = collect();
        $col_accountings = collect();
        $col_total = collect();

        $grand_total_pemasukan = 0;
        $grand_total_pengeluaran = 0;

        $from = "$from_year-$from_month-$from_day";
        $until = "$to_year-$to_month-$to_day 23:59:59";
        $datediff = strtotime($until) - strtotime($from);
        $date_count = (int)($datediff / (60 * 60 * 24)) + 1; // always round up
        // dump($date_count);

        $last_date_is_reached = false;
        $last_date_to_time = strtotime($from);
        // dump($last_date_to_time); // last date is the earliest because we want a descending sorting
        while (!$last_date_is_reached) {
            $day_2_digit = $to_day_copy;
            if (strlen($to_day_copy) < 2) {
                $day_2_digit = "0$to_day_copy";
            }
            $month_2_digit = $to_month_copy;
            if (strlen($to_month_copy) < 2) {
                $month_2_digit = "0$to_month_copy";
            }
            $from = "$to_year_copy-$month_2_digit-$day_2_digit";
            $until = "$to_year_copy-$month_2_digit-$day_2_digit 23:59:59";
            
            $cashflows = Cashflow::whereBetween('created_at', [$from, $until])->orderByDesc("created_at")->get();
            // dump($from, $until);

            $col_cashflows->push([
                "hari" => $to_day_copy,
                "bulan" => $to_month_copy,
                "tahun" => $to_year_copy,
                "cashflows" => $cashflows,
            ]);
            // Accounting
            $accountings = Accounting::whereBetween('created_at', [$from, $until])->orderByDesc("created_at")->get();
            // if (count($accountings)) {
            //     dump($accountings);
            // }
            $col_accountings->push([
                "hari" => $to_day_copy,
                "bulan" => $to_month_copy,
                "tahun" => $to_year_copy,
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
            $grand_total_pemasukan += $pemasukan;
            $grand_total_pengeluaran += $pengeluaran;

            $from_as_time = strtotime($from);
            $next_looping_time = $from_as_time - 86400;
            if ($next_looping_time < $last_date_to_time) {
                $last_date_is_reached = true;
            } else {
                $to_day_copy = (int)date('d', $next_looping_time);
                $to_month_copy = (int)date('m', $next_looping_time);
                $to_year_copy = (int)date('Y', $next_looping_time);
            }
        }

        

        // SALDO PADA WALLET
        $wallets = Wallet::all();
        // dd($wallets);
        // END - SALDO PADA WALLET

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            'cart' => $cart,
            'user' => $user,
            'col_cashflows' => $col_cashflows,
            'col_saldos' => $col_saldos,
            'col_accountings' => $col_accountings,
            'col_total' => $col_total,
            'wallets' => $wallets,
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
            'grand_total_pemasukan' => $grand_total_pemasukan,
            'grand_total_pengeluaran' => $grand_total_pengeluaran,
        ];
        // dump(Cashflow::whereBetween('created_at', ["2024-8-8", "2024-8-8 23:59:59"])->orderByDesc("created_at")->get());
        // dd($data);
        // dd($wallets);
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
        $wallets_non_tunai = Wallet::where('kategori_wallet', 'non-tunai')->get();
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
            'user' => $user,
            'tipe' => $tipe_transaksi,
            'acuan_pembukuans' => $acuan_pembukuans,
            'wallets_non_tunai' => $wallets_non_tunai,
            'data' => Item::get_data_for_create_item('perhiasan'),
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd($data);
        return view('cashflows.transaksi', $data);
    }


    function store_transaction(Request $request)
    {
        $post = $request->post();
        // dd($post);
        Cashflow::validasi_metode_pembayaran($request);
        
        $request->validate([
            'tipe_transaksi' => 'required',
            'kategori' => 'required',
            'total_bayar' => 'required|numeric',
            'sisa_bayar' => 'required|numeric',
        ]);

        if (isset($post['kategori']) && $post["kategori"] == "Buyback Perhiasan") {
            $request->validate([
                "harga_g" => "required|numeric",
                'harga_terima' => 'required|numeric'
            ]);
        } else {
            $request->validate(["total_tagihan" => "required|numeric"]);
        }
        
        $user = Auth::user();
        $time_key = time();
        $kode_accounting = "$user->id.$time_key";
        // SEBAGIAN DATA DIPERSIAPKAN MENJADI NULL 
        $surat_pembelian = null;
        $surat_pembelian_id = null;
        $surat_pembelian_item = null;
        $surat_pembelian_item_id = null;
        $kadar = null;
        $berat = null;
        $nama_barang = null;
        // END - SEBAGIAN DATA DIPERSIAPKAN MENJADI NULL

        $keterangan_transaksi = null;
        if (isset($post['keterangan_transaksi'])) {
            $keterangan_transaksi = $post['keterangan_transaksi'];
        }

        $create_new_item = true;
        $item = collect();
        if ($post['kategori'] == "Buyback Perhiasan") {
            $request->validate([
                'berat_terima' => 'required|numeric',
                'total_potongan' => 'required|numeric',
                'harga_terima' => 'required|numeric',
            ]);
            if (isset($post['item_id'])) {
                $create_new_item = false;
                $item = Item::find($post['item_id']);
                if ($post['submit'] == 'pilih_dan_update_harga') {
                    $item->harga_g = (string)((int)$post['harga_g'] * 100);
                    $item->ongkos_g = (string)((int)$post['ongkos_g'] * 100);
                    $item->harga_t = (string)((int)$post['harga_t'] * 100);
                    $item->save();
                }
            }

            if ($create_new_item) {
                $candidate_new_item = Item::validasi_item($request);
                if (isset($post['tambah_item_baru_dan_buyback'])) {
                    // dd($candidate_new_item);
                    $item = Item::create($candidate_new_item);
                } else {
                    // $candidate_new_item = Item::validasi_item($request);
                    // Strategi:
                    // 1. Bikin item baru. Kalau ada similiar items, maka pilih dari similiar items atau tetap dengan item yang sudah diinput.
                    // 2. Create Surat Pembelian baru
                    // 3. Langsung proses buyback surat tersebut

                    list($item_exist, $data) = Item::check_item_exist($candidate_new_item, $post);
                    // dump($data);
                    // dd($item_exist);

                    // if (count($item_exist)) {
                    //     // dump($data);
                    //     $data['route1'] = 'items.store';
                    //     $data['route2'] = 'items.show';
                    //     // dd($data);
                    //     return view('items.found_similar_items', $data);
                    // }
                    if (count($item_exist)) {
                        // dump($item_exist);
                        $data = Cashflow::add_data_metode_pembayaran($request, $data);
                        $data['tipe_transaksi'] = $post['tipe_transaksi'];
                        $data['keterangan_transaksi'] = $keterangan_transaksi;
                        $data['route1'] = 'cashflow.store_transaction';
                        $data['route2'] = 'items.show';
                        $data['berat_terima'] = (string)((float)$post['berat_terima'] * 100);
                        $data['total_potongan'] = (string)((float)$post['total_potongan'] * 100);
                        $data['harga_terima'] = (string)((float)$post['harga_terima'] * 100);
                        // $data['berat_terima'] = $post['berat_terima'];
                        // $data['total_potongan'] = $post['total_potongan'];
                        // $data['harga_terima'] = $post['harga_terima'];
                        // dump(casual_decimal_format(190));
                        // dd($data);
                        return redirect()->route('transactions.found_similar_items', $data);
                        // return view('items.found_similar_items', $data);
                    } else {
                        $candidate_new_item = Item::empty_string_become_null($candidate_new_item);
                        $item = Item::create($candidate_new_item);
                    }
                }
            }
            // PEMBUATAN SURAT PEMBELIAN
            list($surat_pembelian, $surat_pembelian_item) = SuratPembelian::create_sp($request, $item, $time_key, $kode_accounting);
            $nama_barang = $surat_pembelian_item->longname;
            // END - PEMBUATAN SURAT PEMBELIAN
        }

        $success_ = '';
        if ($surat_pembelian) {
            $surat_pembelian_id = $surat_pembelian->id;
        }

        if ($surat_pembelian_item) {
            $surat_pembelian_item_id = $surat_pembelian_item->id;
            $kadar = $surat_pembelian_item->kadar;
            $berat = $surat_pembelian_item->berat;
        }

        // dump($surat_pembelian, $surat_pembelian_item);
        // dd($surat_pembelian_id, $surat_pembelian_item_id);

        $total_bayar = Cashflow::create_cashflow($user->id, $time_key, $kode_accounting, $surat_pembelian_id, $post);

        $kategori_2 = null;
        if (isset($post['kategori_2'])) {
            if ($post['kategori_2']) {
                $kategori_2 = $post['kategori_2'];
            }
        }

        $accounting = Accounting::create([
            'kode_accounting' => $kode_accounting,
            'surat_pembelian_id' => $surat_pembelian_id,
            'surat_pembelian_item_id' => $surat_pembelian_item_id,
            'nama_barang' => $nama_barang,
            'kadar' => $kadar,
            'berat' => $berat,
            'user_id' => $user->id,
            'username' => $user->username,
            'tipe' => $post['tipe_transaksi'],
            'kategori' => $post['kategori'],
            'kategori_2' => $kategori_2,
            'deskripsi' => $keterangan_transaksi,
            'jumlah' => $total_bayar,
        ]);

        // dd($accounting);

        $success_ .= "Transaksi baru telah dibuat!";
        $feedback = [
            'success_' => $success_
        ];
        return redirect()->route('cashflow.index')->with($feedback);
    }

    function update_saldo_wallet(Request $request) {
        $post = $request->post();

        $wallet = Wallet::find($post['wallet_id']);
        $wallet->saldo = (string)((int)$post['saldo_wallet'] * 100);
        $wallet->save();
        
        return back()->with('success_', '- Saldo wallet diupdate! -');
    }

    // function store_and_buyback_perhiasan(Request $request) {
    //     $post = $request->post();
    //     dd($post);
    //     $candidate_new_item = Item::validasi_item($request);
    //     $item_new = Item::create($candidate_new_item);
    //     Item::store_itemMata_dan_itemMainan($post, $item_new);
    // }

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
