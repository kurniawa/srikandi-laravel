<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\ItemPhoto;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    function add_photo(Item $item, Request $request) {
        $post = $request->post();
        $file_photo = $request->file('photo');
        // dump($post);
        // dump($photo);
        // dd($item);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_index' => 'required|numeric'
        ]);

        $success_ = "";

        $time = time();
        $user = Auth::user();
        $file_name = "$time-$user->id" . "." . $file_photo->extension();
        $file_photo->storeAs('items/photos', $file_name);

        $photo = Photo::create([
            "path" => "items/photos/$file_name",
        ]);

        $item_photo = ItemPhoto::create([
            "item_id" => $item->id,
            "photo_id" => $photo->id,
            "photo_index" => $post['photo_index'],
        ]);

        $success_ .= "-ItemPhoto $item_photo->photo_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);

    }

    function delete_photo(Item $item, ItemPhoto $item_photo, Photo $photo) {
        // dump(Storage::exists($item_photo->photo_path));
        // dd($item_photo);
        $warnings_ = "";
        if (Storage::exists($photo->path)) {
            Storage::delete($photo->path);
        }
        $warnings_ .= "-File storage dihapus-";

        $photo->delete();
        // $item_photo->delete();
        $warnings_ .= "-Photo & ItemPhoto dihapus-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }

    function add_cart_item_photo(CartItem $cart_item, Request $request) {
        // $post = $request->post();
        $file_photo = $request->file('photo');
        // dump($post);
        // dump($photo);
        // dd($cart_item);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $success_ = "";

        $time = time();
        $user = Auth::user();
        $file_name = "$time-$user->id." . $file_photo->extension();
        $file_photo->storeAs('cart_items/photos', $file_name);

        $cart_item->photo_path = "cart_items/photos/$file_name";
        $cart_item->save();

        $success_ .= "-CartItem->photo_path $cart_item->photo_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);

    }

    function delete_cart_item_photo(CartItem $cart_item) {
        $warnings_ = "";
        if (Storage::exists($cart_item->photo_path)) {
            Storage::delete($cart_item->photo_path);
        }
        $warnings_ .= "-File storage dihapus-";

        $cart_item->photo_path = null;
        $cart_item->save();
        // $item_photo->delete();
        $warnings_ .= "-cart_item->photo_path dihapus-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }

    function add_cart_photo(Cart $cart, Request $request) {
        // $post = $request->post();
        $file_photo = $request->file('photo');
        // dump($post);
        // dump($photo);
        // dd($cart);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $success_ = "";

        list($file_name, $photo_path) = Photo::cek_photo_path('carts/photos', $file_photo->extension());
        // dd($file_name, $photo_path);
        $file_photo->storeAs('carts/photos', $file_name);

        $cart->photo_path = $photo_path;
        $cart->save();

        $success_ .= "-cart->photo_path $cart->photo_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);

    }

    function delete_cart_photo(Cart $cart) {
        $warnings_ = "";
        if (Storage::exists($cart->photo_path)) {
            Storage::delete($cart->photo_path);
        }
        $warnings_ .= "-File storage dihapus-";

        $cart->photo_path = null;
        $cart->save();
        // $item_photo->delete();
        $warnings_ .= "-cart->photo_path dihapus-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }

}
