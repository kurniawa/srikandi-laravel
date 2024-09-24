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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'photo_index' => 'required|numeric'
        ]);

        $success_ = "";

        $time = time();
        $user = Auth::user();
        $file_name = "$user->id-$time" . "." . $file_photo->extension();
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

        return redirect()->route('items.add_photo', $item->id)->with($feedback);

    }

    function delete_photo(Item $item, ItemPhoto $item_photo, Photo $photo) {
        // dump(Storage::exists($item_photo->photo_path));
        // dump($item);
        // dump($item_photo);
        // dd($photo);
        $warnings_ = "";
        // CEK APAKAH PHOTO DIGUNAKAN OLEH ITEM LAIN
        $used_by_other_item = ItemPhoto::where('photo_id', $photo->id)->where('item_id', '!=', $item->id)->first();
        // END - CEK APAKAH PHOTO DIGUNAKAN OLEH ITEM LAIN
        // dd($used_by_other_item);
        if ($used_by_other_item) {
            $item_photo->delete();
            $warnings_ .= "-Foto digunakan pada item lain -> ItemPhoto dihapus-";
        } else {
            if (Storage::exists($photo->path)) {
                Storage::delete($photo->path);
            }
            $warnings_ .= "-File storage dihapus-";
            $photo->delete();
            // $item_photo->delete();
            $warnings_ .= "-Foto & ItemPhoto dihapus-";
        }


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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $success_ = "";

        $time = time();
        $user = Auth::user();
        $file_name = "$user->id-$time." . $file_photo->extension();
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
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

    function add_photo_from_sugestion(Item $item, Request $request) {
        $post = $request->post();
        // dump($post);
        // dd($item);
        $request->validate([
            'photo_id' => 'required|numeric',
            'photo_index' => 'required|numeric',
        ]);
        $success_ = '';
        $continue = false;
        // PENGECEKAN JUMLAH PHOTO DIBATASI HANYA LIMA
        $item_photos = ItemPhoto::where('item_id', $item->id)->get();
        if (count($item_photos) <= 5) {
            $continue = true;
        }
        // END - PENGECEKAN JUMLAH PHOTO DIBATASI HANYA LIMA
        if ($continue) {
            ItemPhoto::create([
                'item_id' => $item->id,
                'photo_id' => $post['photo_id'],
                'photo_index' => $post['photo_index']
            ]);
            $success_ .= '-ItemPhoto created-';
            $feedback = [
                'success_' => $success_
            ];
            return redirect()->route('items.add_photo', $item->id)->with($feedback);
        }
    }

}
