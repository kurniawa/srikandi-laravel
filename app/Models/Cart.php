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
        return $this->hasMany(CartItem::class);
    }

    function user() {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
}
