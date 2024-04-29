<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratPembelianController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

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
            'back' => true,
            'backRoute' => 'home',
            'backRouteParams' => null,
        ];
        // dd($data);
        return view('surats.index', $data);
    }
}
