<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMainan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    function mainan() {
        return $this->hasOne(Mainan::class, 'id', 'mainan_id');
    }
}
