<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\AcuanPembukuan;
use App\Models\Cart;
use App\Models\Cashflow;
use App\Models\Item;
use App\Models\Menu;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
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
            
            $cashflows = Cashflow::whereBetween('cashflow_date', [$from, $until])->orderByDesc("cashflow_date")->get();
            // dump($from, $until);

            $col_cashflows->push([
                "hari" => $to_day_copy,
                "bulan" => $to_month_copy,
                "tahun" => $to_year_copy,
                "cashflows" => $cashflows,
            ]);
            // Accounting
            $accountings = Accounting::whereBetween('accounting_date', [$from, $until])->orderByDesc("accounting_date")->get();
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
        dump($post);
        Cashflow::validasi_metode_pembayaran($request);
        
        $request->validate([
            'tipe_transaksi' => 'required',
            'kategori' => 'required',
            'total_bayar' => 'required|numeric',
            'sisa_bayar' => 'required|numeric',
            "total_tagihan" => "required|numeric"
        ]);
        
        $user = Auth::user();

        /*
        Apabila tanggal bukan merupakan tanggal teraktual, melainkan tanggal sebelumnya, maka is_earlier_date = true
        Apabila $is_earlier_date === true, maka accounting_date dan cashflow_date tidak lagi sama dengan created_at
        Dengan demikian harus dihitung ulang terutama bagian saldo terakhir dari cashflow sebelumnya
        dan edit juga saldo_akhir dari cashflow-cashflow setelahnya.
        */
        
        $res_date_time = Cashflow::set_date_time($post);

        $timestamp_now = $res_date_time['timestamp_now'];
        $time_key = $res_date_time['time_key'];
        $accounting_date = $res_date_time['accounting_date'];
        $cashflow_date = $res_date_time['cashflow_date'];
        $is_earlier_date = $res_date_time['is_earlier_date'];

        dump($accounting_date);
        dd($accounting_date < $timestamp_now);

        // END - PENENTUAN accounting_date dan cashflow_date
        
        $kode_accounting = "$user->id.$time_key";
        // SEBAGIAN DATA DIPERSIAPKAN MENJADI NULL 
        $surat_pembelian = null;
        $surat_pembelian_id = null;
        $surat_pembelian_item = null;
        // END - SEBAGIAN DATA DIPERSIAPKAN MENJADI NULL

        $keterangan_transaksi = null;
        if (isset($post['keterangan_transaksi'])) {
            $keterangan_transaksi = $post['keterangan_transaksi'];
        }

        $create_new_item = true;
        $item = collect();
        if ($post['kategori'] == "Buyback Perhiasan") {
            if (isset($post['item_id'])) {
                $create_new_item = false;
                $item = Item::find($post['item_id']);
                if ($post['submit'] == 'pilih_dan_update_harga') {
                    $item->harga_g = $post['harga_g'];
                    $item->ongkos_g = $post['ongkos_g'];
                    $item->harga_t = $post['harga_t'];
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
            $data_create_sp = [
                "tanggal_surat" => $accounting_date,
                "item" => $item,
                "time_key" => $time_key,
                "kode_accounting" => $kode_accounting,
                "post" => $post,
                "user" => $user,
            ];
            list($surat_pembelian, $surat_pembelian_item) = SuratPembelian::create_sp($data_create_sp);
            $nama_barang = $surat_pembelian_item->longname;
            // END - PEMBUATAN SURAT PEMBELIAN
        }

        $success_ = '';
        if ($surat_pembelian) {
            $surat_pembelian_id = $surat_pembelian->id;
        }

        // dump($surat_pembelian, $surat_pembelian_item);
        // dd($surat_pembelian_id, $surat_pembelian_item_id);

        $data_create_cashflow = [
            'user_id' => $user->id,
            "time_key" => $time_key,
            "kode_accounting" => $kode_accounting,
            "surat_pembelian_id" => $surat_pembelian_id,
            "post" => $post,
            "cashflow_date" => $cashflow_date,
            "is_earlier_date" => $is_earlier_date,
        ];
        $total_bayar = Cashflow::create_cashflow($data_create_cashflow);

        $kategori_2 = null;
        if (isset($post['kategori_2'])) {
            if ($post['kategori_2']) {
                $kategori_2 = $post['kategori_2'];
            }
        }

        $success_ .= "Transaksi baru telah dibuat!";
        $feedback = [
            'success_' => $success_
        ];
        return redirect()->route('cashflow.index')->with($feedback);
    }

    function store_manual_buyback_transaction(Request $request) {
        $post = $request->post();
        // dd($post);
        // Validasi metode pembayaran
        Cashflow::validasi_metode_pembayaran($request);
        
        $request->validate([
            'tipe_transaksi' => 'required',
            'kategori' => 'required',
            'total_bayar' => 'required|numeric',
            'sisa_bayar' => 'required|numeric',
            'harga_g' => 'required|numeric',
            'harga_terima' => 'required|numeric',
            'berat_terima' => 'required|numeric',
            'total_potongan' => 'required|numeric',
            'harga_terima' => 'required|numeric',
        ]);

        /**
         * Validasi Item sekaligus return data_item yang nantinya siap untuk melakukan create, apabila item belum ada 
        */
        $item_data = Item::validasi_item($request);

        $user = Auth::user();
        $success_ = '';
        /**
         * Pengecekan apakah item telah exist sebelumnya, karena ini proses buyback, maka apabila item yang sama, akan
         * di ignore saja. Dan apabila item tidak exist, akan di create item baru.
         */
        $res_check_item_exist = Item::check_item_exist($item_data, $post);
        $item = $res_check_item_exist['found_item'];
        if (!$res_check_item_exist['is_exist']) {
            $item = Item::create($item_data);
        }
        // dump($item);
        // dd($res_check_item_exist['is_exist']);

        /*
        Apabila tanggal bukan merupakan tanggal teraktual, melainkan tanggal sebelumnya, maka is_earlier_date = true
        Apabila $is_earlier_date === true, maka accounting_date dan cashflow_date tidak lagi sama dengan created_at
        Dengan demikian harus dihitung ulang terutama bagian saldo terakhir dari cashflow sebelumnya
        dan edit juga saldo_akhir dari cashflow-cashflow setelahnya.
        */
        
        $res_date_time = Cashflow::set_date_time($post);

        $timestamp_now = $res_date_time['timestamp_now'];
        $time_key = $res_date_time['time_key'];
        $accounting_date = $res_date_time['accounting_date'];
        $cashflow_date = $res_date_time['cashflow_date'];
        $is_earlier_date = $res_date_time['is_earlier_date'];

        $kode_accounting = "$user->id.$time_key";

        // Pembuatan Surat Pembelian
        $params_create_sp = [
            "tanggal_surat" => $accounting_date,
            "item" => $item,
            "time_key" => $time_key,
            "kode_accounting" => $kode_accounting,
            "post" => $post,
            "user_id" => $user->id,
            "username" => $user->username,
        ];

        $surat_pembelian = SuratPembelian::create_sp_for_manual_buyback($params_create_sp);

        // Pembuatan Surat Pembelian Item
        $photo_path = null;
        if (isset($post['photo_path'])) {
            // fitur pengambilan foto manual buyback, menyusul
        }
        $params_create_spi = [
            'item' => $item,
            'surat_pembelian_id' => $surat_pembelian->id,
            'photo_path' => $photo_path,
            'jumlah' => 1,
            'accounting_date' => $accounting_date,
            'keterangan' => $post['keterangan_transaksi'],
            "kode_accounting" => $kode_accounting,
            "user_id" => $user->id,
            "username" => $user->username,
            "harga_terima" => $post['harga_terima'],
        ];
        $surat_pembelian_item = SuratPembelianItem::create_spi_for_manual_buyback($params_create_spi);

        $data_create_cashflow = [
            'user_id' => $user->id,
            "time_key" => $time_key,
            "kode_accounting" => $kode_accounting,
            "surat_pembelian_id" => $surat_pembelian->id,
            "post" => $post,
            "cashflow_date" => $cashflow_date,
            "is_earlier_date" => $is_earlier_date,
        ];

        $total_bayar = Cashflow::create_cashflow($data_create_cashflow);

        $success_ .= "Transaksi baru telah dibuat!";
        $feedback = [
            'success_' => $success_
        ];
        return redirect()->route('cashflow.index')->with($feedback);
    }

    function update_saldo_wallet(Request $request) {
        $post = $request->post();

        $wallet = Wallet::find($post['wallet_id']);
        $wallet->saldo = $post['saldo_wallet'];
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
