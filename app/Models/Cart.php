<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function cart_items(): HasMany {
        return $this->hasMany(CartItem::class)->orderByDesc('id');
    }

    function pelanggan() {
        return $this->hasOne(User::class, 'id', 'pelanggan_id');
    }

    function user() {
        return $this->hasOne(User::class);
    }

    static function insert_to_cart_helper($item, $user) {
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        }
        $photo_path = null;
        // dump($item->item_photos);
        if (count($item->item_photos)) {
            // dump($item->item_photos[0]->photo->path);
            if (Storage::exists($item->item_photos[0]->photo->path)) {
                // dump('storage exist');
                $time = time();
                $exploded_path = explode(".", $item->item_photos[0]->photo->path);
                $file_extension = $exploded_path[count($exploded_path) - 1];
                $filename = "$user->id-$time.$file_extension";
                $photo_path = "cart_items/photos/$filename";
                Storage::copy($item->item_photos[0]->photo->path, $photo_path);
            }
            // dd('stop');
        }

        CartItem::create([
            'cart_id' => $cart->id,
            'item_id' => $item->id,
            'harga_t' => $item->harga_t,
            'photo_path' => $photo_path,
        ]);

        if ($cart->harga_total) {
            $cart->harga_total = (string)((float)$cart->harga_total + (float)$item->harga_t);
        } else {
            $cart->harga_total = $item->harga_t;
        }

        $cart->save();

        // UPDATE STOCK
        $stock = (int)$item->stock - 1;

        if ($stock < 0) {
            $stock = 0;
        }

        $item->stock = $stock;
        $item->save();
        // END - UPDATE STOCK
    }

    static function delete_cart_items($cart_item_ids, $cart) {
        $success_ = '';
        foreach ($cart_item_ids as $cart_item_id) {
            $cart_item = CartItem::find($cart_item_id);
            // UPDATE STOCK
            $item = $cart_item->item;
            $stock = (int)$item->stock;
            $stock++;
            $item->stock = $stock;
            $item->save();
            // END - UPDATE STOCK
            $cart_item->delete();
        }
        if (count($cart->cart_items) === 0) {
            // Sebelum dihapus cari dulu apakah ada foto transaksi?
            if ($cart->photo_path) {
                if (Storage::exists($cart->photo_path)) {
                    Storage::delete($cart->photo_path);
                }
                $success_ .= "-Foto Transaksi dihapus-";
            }
            $cart->delete();
            $success_ .= '-Cart dihapus!-';
        }
        return $success_;
    }
}
