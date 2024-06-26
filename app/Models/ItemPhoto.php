<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPhoto extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    function photo() {
        return $this->hasOne(Photo::class, 'id', 'photo_id');
    }
}
