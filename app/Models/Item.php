<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function matas() {
        return $this->belongsToMany(Mata::class, 'item_matas', 'item_id', 'mata_id');
    }

    function item_matas() {
        return $this->hasMany(ItemMata::class, 'mata_id', 'id');
    }

    function item_mainans() {
        return $this->hasMany(ItemMainan::class, 'mainan_id', 'id');
    }

    function item_photos() {
        return $this->hasMany(ItemPhoto::class, 'photo_id', 'id')->orderBy('photo_index');
    }
}
