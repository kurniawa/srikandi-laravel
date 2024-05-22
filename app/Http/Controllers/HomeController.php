<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home() {
        $success_ = "";
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }
        $items = Item::limit(100)->get();

        // Update Saldo
        $time = time();
        $today = date("Y-m-d", $time);
        $now = date("Y-m-d H:i:s", $time);
        $saldo_today = Saldo::whereBetween('created_at', [$today, $now])->get();
        if (!count($saldo_today)) {
            // dd(date("Y-m-d", $time - 86400));
            $latest_saldo = Saldo::latest()->first();
            if ($latest_saldo) {
                // $latest_day = date("d", strtotime($latest_saldo->created_at));
                // $latest_month = date("m", strtotime($latest_saldo->created_at));
                // $latest_year = date("Y", strtotime($latest_saldo->created_at));
                $latest_date = date("Y-m-d", strtotime($latest_saldo->created_at));
                // dd($latest_date);
                $latest_saldos = Saldo::whereBetween("created_at", [$latest_date, "$latest_date 23:59:59"])->get();
                $datediff = round(($time - strtotime($latest_saldo->created_at)) / (60*60*24));
                $latest_time = strtotime($latest_saldo->created_at) + 86400;
                for ($i=0; $i < $datediff; $i++) {
                    foreach ($latest_saldos as $l_saldo) {
                        Saldo::create([
                            "kategori_wallet" => $l_saldo->kategori_wallet,
                            "tipe_wallet" => $l_saldo->tipe_wallet,
                            "nama_wallet" => $l_saldo->nama_wallet,
                            "saldo_awal" => $l_saldo->saldo_akhir,
                            "saldo_akhir" => $l_saldo->saldo_akhir,
                            "created_at" => date("Y-m-d H:i:s", $latest_time),
                        ]);
                    }
                    $latest_time += 86400;
                }
            }
        }
        $success_ .= "-Saldo diupdate-";

        // dd($success_);

        $feedback = [
            "success_" => $success_
        ];

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus($user),
            'parent_route' => 'home',
            'back' => false,
            'backRoute' => null,
            'backRouteParams' => null,
            // 'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'items' => $items,
        ];
        return view('app', $data)->with($feedback);
    }
}
