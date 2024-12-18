<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('carts.cart_item-add_photo', $data);
    }

    function delete(Cart $cart, CartItem $cart_item) {
        // dump($cart);
        // dd($cart_item);
        $dangers_ = "";

        $item = $cart_item->item;
        // Cek apakah cart_item ini ada fotonya?
        if ($cart_item->photo_path) {
            if (Storage::exists($cart_item->photo_path)) {
                Storage::delete($cart_item->photo_path);
            }
            $dangers_ .= "-Foto CartItem dihapus-";
        }
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

        // UPDATE STOCK
        $stock = (int)$item->stock;
        $stock++;
        $item->stock = $stock;
        $item->save();
        // END - UPDATE STOCK

        return back()->with($feedback);
    }

}
