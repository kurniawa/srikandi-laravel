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
        return $this->hasMany(ItemMata::class, 'item_id', 'id');
    }

    function mainans() {
        return $this->belongsToMany(Mainan::class, 'item_mainans', 'item_id', 'mainan_id');
    }

    function item_mainans() {
        return $this->hasMany(ItemMainan::class, 'item_id', 'id');
    }

    function photos() {
        return $this->belongsToMany(Photo::class, 'item_photos', 'item_id', 'photo_id');
    }

    function item_photos() {
        return $this->hasMany(ItemPhoto::class, 'photo_id', 'id')->orderBy('photo_index');
    }
}
