<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cashflow;
use App\Models\Menu;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    function index(Request $request) {
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

        for ($i=$get_day; $i >= 1 ; $i--) {
            $starting_time = "$get_year-$get_month-$i";
            $ending_time = "$get_year-$get_month-$i 23:59:59";

            $cashflows = Cashflow::whereBetween('created_at', [$starting_time, $ending_time])->orderByDesc("created_at")->get();
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

            // SALDO
            $saldos = Saldo::whereBetween("created_at", [$starting_time, $ending_time])->get();
            $saldo_awal = 0;
            $saldo_akhir = 0;
            if (count($saldos)) {
                foreach ($saldos as $saldo) {
                    $saldo_awal += $saldo->saldo_awal;
                    $saldo_akhir += $saldo->saldo_akhir;
                }
            }
            $col_saldos->push([
                'saldo_awal' => $saldo_awal,
                'saldo_akhir' => $saldo_akhir,
            ]);
        }

        $data = [
            // 'goback' => 'home',
            // 'user_role' => $user_role,
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'spk_menus' => Menu::get_spk_menus(),
            // 'user' => Auth::user(),
            'cart' => $cart,
            'col_cashflows' => $col_cashflows,
            'col_saldos' => $col_saldos,
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
        ];
        // dd($data);
        return view('cashflows.index', $data);
    }
}
