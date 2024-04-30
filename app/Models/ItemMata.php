<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMata extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    function mata() {
        return $this->hasOne(Mata::class, 'id', 'mata_id');
    }
}
