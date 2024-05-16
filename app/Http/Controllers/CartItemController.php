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
            'spk_menus' => Menu::get_spk_menus(),
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


}
