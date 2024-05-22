<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    function add_photo(Cart $cart, CartItem $cart_item) {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        $data = [
            'menus' => Menu::get(),
            'route_now' => 'cart_items.add_photo',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            'back' => true,
            'backRoute' => 'carts.index',
            'backRouteParams' => [$user->id],
            'cart' => $cart,
            'user' => $user,
            'cart_item' => $cart_item,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];

        return view('carts.cart_item-add_photo', $data);
    }

    function delete(Cart $cart, CartItem $cart_item) {
        // dump($cart);
        // dd($cart_item);
        $dangers_ = "";

        $cart_item->delete();
        $dangers_ .= "-CartItem dihapus-";

        // HITUNG ulang harga total tagihan pada cart
        if (count($cart->cart_items)) {
            $total_tagihan = 0;
            foreach ($cart->cart_items as $cart_item) {
                $total_tagihan += (float)$cart_item->harga_t;
            }

            $cart->harga_total = (string)$total_tagihan;
            $cart->save();
            $dangers_ .= "-Harga Total Tagihan diupdate-";

        } else {
            $cart->delete();
            $dangers_ .= "-Tidak ada item, cart dihapus-";
        }

        $feedback = [
            'dangers_' => $dangers_
        ];

        return back()->with($feedback);
    }

}
