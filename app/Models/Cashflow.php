<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function user() {
        return $this->hasOne(User::class, "id", "user_id");
    }

    function surat_pembelian_item() {
        return $this->hasOne(SuratPembelianItem::class, "id", "surat_pembelian_item_id");
    }
}
