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
    public function home(Request $request) {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $get = $request->query();
        $items = collect();
        if (count($get)) {
            // dump(count($get));
            // dump($get);
            if (isset($get['longname'])) {
                if ($get['longname'] !== null) {
                    $items = Item::select('id', 'shortname', 'longname', 'harga_g', 'ongkos_g', 'harga_t')->where('longname', 'like', "%$get[longname]%")->limit(100)->get();
                } else {
                    $items = Item::select('id', 'shortname', 'longname', 'harga_g', 'ongkos_g', 'harga_t')->limit(100)->get();
                }
            } else {
                $items = Item::select('id', 'shortname', 'longname', 'harga_g', 'ongkos_g', 'harga_t')->limit(100)->get();
            }
        } else {
            $items = Item::select('id', 'shortname', 'longname', 'harga_g', 'ongkos_g', 'harga_t')->limit(100)->get();
        }

        $data = [
            // 'menus' => Menu::get(),
            // 'profile_menus' => Menu::get_profile_menus($user),
            'user' => $user,
            'cart' => $cart,
            'items' => $items,
            'all_items_x_photos' => Item::get_all_item_x_photos(),
        ];
        // dump($items[0]);
        // dd($items[0]->item_photos);
        return view('app', $data);
    }

    function choose_action() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

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
            'user' => $user,
            'all_items_x_photos' => Item::get_all_item_x_photos(),
        ];
        // dump($items[0]);
        // dd($items[0]->item_photos);
        return view('choose_action', $data);
    }
}
