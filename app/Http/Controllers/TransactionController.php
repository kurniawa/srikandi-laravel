<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Cart;
use App\Models\Cashflow;
use App\Models\Item;
use App\Models\Kadar;
use App\Models\Menu;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    function found_similar_items(Request $request) {
        $get = $request->query();
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        $data = array_merge($data, $get);
        // dump($get);
        // dd($data);

        return view("items.found_similar_items", $data);
    }

    function rincian_transaksi(User $user, Request $request) {
        $user = Auth::user();
        $cart = null;
        $target_user = $user;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $get = $request->query();
        // dump($get);
        // dd($user);

        // dump($golongan_kadar);
        $bb_accountings = array();

        $buy_accountings = array();

        $tanggal = null;
        $from_day = date("d");
        $from_month = date("m");
        $from_year = date("Y");

        $to_day = $from_day;
        $to_month = $from_month;
        $to_year = $from_year;

        if (isset($get['target_user_id']) && $get['target_user_id']) {
            $target_user = User::find($get['target_user_id']);
        }

        if (isset($get['from_day'])) {
            $request->validate([
                "from_day" => "required|numeric",
                "from_month" => "required|numeric",
                "from_year" => "required|numeric",
                "to_day" => "required|numeric",
                "to_month" => "required|numeric",
                "to_year" => "required|numeric",
            ]);

            $from_day = $get['from_day'];
            $from_month = $get['from_month'];
            $from_year = $get['from_year'];
            $to_day = $get['to_day'];
            $to_month = $get['to_month'];
            $to_year = $get['to_year'];
        } 

        if (strlen($from_day) < 2) {
            $from_day = "0$from_day";
        }

        if (strlen($from_month) < 2) {
            $from_month = "0$from_month";
        }

        if (strlen($to_day) < 2) {
            $to_day = "0$to_day";
        }

        if (strlen($to_month) < 2) {
            $to_month = "0$to_month";
        }


        $from = "$from_year-$from_month-$from_day";
        $until = "$to_year-$to_month-$to_day 23:59:59";
        
        if ($from_day == $to_day && $from_month == $to_month && $from_year == $to_year) {
            $tanggal = date("d-m-Y", strtotime($from));
        }

        $from_time = strtotime($from);
        $to_time = strtotime($until);
        $from_time_temp = $from_time;
        $to_time_temp = $from_time + 86399;

        // dump($from_time);
        // dd($to_time);
        for ($i=$from_time; $i < $to_time; $i+=86400) { 
            $from_str = date("Y-m-d", $from_time_temp);
            $to_str = date("Y-m-d H:i:s", $to_time_temp);

            // dump($from_str);
            // dd($to_str);
            $bb_accountings_this = Accounting::whereBetween("created_at", [$from_str, $to_str])->where('user_id', $target_user->id)->where('kategori', 'Buyback Perhiasan')->orderBy("kadar")->get();
            $bb_accountings_this_groupByKadar = $bb_accountings_this->groupBy('kadar');
            // dump($bb_accountings_this->groupBy("kadar"));
            // dump($bb_accountings_this->groupBy("kadar")->keys());
            $bb_accountings_array = array();
            $gol_kadars = $bb_accountings_this_groupByKadar->keys()->toArray();
            $total_berats = array();
            $total_hargas = array();
            $grand_total = 0;
            foreach ($gol_kadars as $gol_kadar) {
                $total_berat = 0;
                $total_harga = 0;
                foreach ($bb_accountings_this_groupByKadar[$gol_kadar] as $accounting) {
                    $total_berat += (int)$accounting->berat;
                    $total_harga += (int)$accounting->jumlah;
                    $grand_total += (int)$accounting->jumlah;
                }
                $bb_accountings_array[$gol_kadar] = $bb_accountings_this_groupByKadar[$gol_kadar]->toArray();
                $total_berats[] = $total_berat;
                $total_hargas[] = $total_harga;
            }

            if (count($bb_accountings_array)) {
                $bb_accountings[] = [
                    "tanggal" => $from_str,
                    "accountings" => $bb_accountings_array,
                    "gol_kadars" => $gol_kadars,
                    "total_berats" => $total_berats,
                    "total_hargas" => $total_hargas,
                    "grand_total" => $grand_total,
                ];
            }
            // dump($bb_accountings_this);
            
            $buy_accountings_this = Accounting::whereBetween("created_at", [$from_str, $to_str])->where('user_id', $target_user->id)->where('kategori_2', 'Penjualan Perhiasan')->orderBy("kadar")->get();
            $buy_accountings_this_groupByKadar = $buy_accountings_this->groupBy('kadar');
            // dump($buy_accountings_this->groupBy("kadar"));
            // dump($buy_accountings_this->groupBy("kadar")->keys());
            $buy_accountings_array = array();
            $gol_kadars = $buy_accountings_this_groupByKadar->keys()->toArray();
            $total_berats = array();
            $total_hargas = array();
            $grand_total = 0;
            foreach ($gol_kadars as $gol_kadar) {
                $total_berat = 0;
                $total_harga = 0;
                foreach ($buy_accountings_this_groupByKadar[$gol_kadar] as $accounting) {
                    $total_berat += (int)$accounting->berat;
                    $total_harga += (int)$accounting->jumlah;
                    $grand_total += (int)$accounting->jumlah;
                }
                $buy_accountings_array[$gol_kadar] = $buy_accountings_this_groupByKadar[$gol_kadar]->toArray();
                $total_berats[] = $total_berat;
                $total_hargas[] = $total_harga;
            }
            if (count($buy_accountings_array)) {
                $buy_accountings[] = [
                    "tanggal" => $from_str,
                    "accountings" => $buy_accountings_array,
                    "gol_kadars" => $gol_kadars,
                    "total_berats" => $total_berats,
                    "total_hargas" => $total_hargas,
                    "grand_total" => $grand_total,
                ];
            }

            $from_time_temp += 86400;
            $to_time_temp += 86400;
        }

        // dd($bb_perhiasans);
        // dump(strtotime($from));
        // dd(strtotime($until));

        $user_lists = User::where('clearance_level', '>=', 3)->get();
        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'bb_accountings' => $bb_accountings,
            // 'bb_perhiasans' => $bb_perhiasans,
            'buy_accountings' => $buy_accountings,
            // 'buy_perhiasans' => $buy_perhiasans,
            'tanggal' => $tanggal,
            'user_lists' => $user_lists,
            'target_user' => $target_user,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd(strtotime("2024-07-25 08:08:08"));
        // dump($bb_accountings);
        // dd($buy_accountings);

        return view('transactions.rincian', $data);
    }
}
