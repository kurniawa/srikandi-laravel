<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Cart;
use App\Models\Kadar;
use App\Models\Menu;
use App\Models\SuratPembelian;
use App\Models\SuratPembelianItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    function found_similiar_items(Request $request) {
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
        ];

        $data = array_merge($data, $get);
        // dump($get);
        // dd($data);

        return view("items.found_similiar_items", $data);
    }

    function rincian_transaksi(User $user, Request $request) {
        $get = $request->query();
        dump($get);
        // dd($user);

        $col_buybacks = collect();
        $golongan_kadar = Kadar::select("kategori")->where('tipe', 'perhiasan')->get();
        dump($golongan_kadar);
        if (count($get)) {
            # code...
        } else {
            $day = date("d");
            $month = date("m");
            $year = date("Y");
            if (strlen((string)$day) < 2) {
                $day = "0$day";
            }

            if (strlen((string)$month) < 2) {
                $month = "0$month";
            }
            $from = "$year-$month-$day";
            $until = "$year-$month-$day 23:59:59";

            $accountings_bb = Accounting::whereBetween("created_at", [$from, $until])->where('user_id', $user->id)->where('kategori', 'Buyback Perhiasan')->get();
            foreach ($accountings_bb as $accounting_bb) {
                $surat_pembelian_item = SuratPembelianItem::find($accounting_bb->surat_pembelian_item_id);
                foreach ($golongan_kadar as $golongan) {
                    
                }
            }

            dd($from);
        }

        return view('transactions.rincian');
    }
}
