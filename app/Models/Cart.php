<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        if (count($item->item_photos)) {
            $photo_path = $item->item_photos[0]->photo->path;
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
    }
}
