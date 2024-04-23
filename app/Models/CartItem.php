<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    function item() {
        return $this->hasOne(Item::class, 'id', 'item_id'); // foreignKey adalah id
    }
}
