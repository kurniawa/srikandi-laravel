<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function matas()
    {
        return $this->belongsToMany(Mata::class, 'item_matas', 'item_id', 'mata_id');
    }

    function item_matas()
    {
        return $this->hasMany(ItemMata::class, 'item_id', 'id');
    }

    function mainans()
    {
        return $this->belongsToMany(Mainan::class, 'item_mainans', 'item_id', 'mainan_id');
    }

    function item_mainans()
    {
        return $this->hasMany(ItemMainan::class, 'item_id', 'id');
    }

    function photos()
    {
        return $this->belongsToMany(Photo::class, 'item_photos', 'item_id', 'photo_id');
    }

    function item_photos()
    {
        return $this->hasMany(ItemPhoto::class)->orderBy('photo_index');
    }

    static function cek_item_exists($post)
    {
        $item_exists = Item::where('tipe_barang', $post['tipe_barang'])
            ->where('nama_long', $post['nama_long'])
            ->get();

        // $similiar_items = collect();
        // dump($item_exists);
        // if (count($item_exists)) {
        //     foreach ($item_exists as $key_item => $item_exist) {
        //         $exist_same_mata = true;
        //         if (count($item_exist->item_matas)) {
        //             if (isset($post['checkbox_mata']) && isset($post['warna_mata'])) {
        //                 if ($post['checkbox_mata'] == 'on') {
        //                     foreach ($post['warna_mata'] as $key => $post_warna_mata) {
        //                         $filtered = $item_exist->matas->where('warna', $post_warna_mata);
        //                         if (!count($filtered)) {
        //                             $exist_same_mata = false;
        //                         }

        //                         // dump($post_warna_mata);
        //                         // dump($item_exist->matas);
        //                         dump($filtered);
        //                         $filtered = $item_exist->matas->filter(function ($item, $index) use ($post_warna_mata) {
        //                             if ($item->warna == $post_warna_mata) {
        //                                 return $item;
        //                             } else {
        //                                 return null;
        //                             }
        //                         });
        //                         dd($filtered);
        //                     }
        //                     // foreach ($post['level_warna'] as $post_level_warna) {
        //                     //     $filtered = $item_exist->matas->where('level_warna', $post_level_warna);
        //                     //     if (!count($filtered)) {
        //                     //         $exist_same_mata = false;
        //                     //     }
        //                     // }
        //                     // foreach ($post['opacity'] as $post_opacity) {
        //                     //     $filtered = $item_exist->matas->where('opacity', $post_opacity);
        //                     //     if (!count($filtered)) {
        //                     //         $exist_same_mata = false;
        //                     //     }
        //                     // }
        //                     // foreach ($post['jumlah_mata'] as $post_jumlah_mata) {
        //                     //     $filtered = $item_exist->item_matas->where('jumlah_mata', $post_jumlah_mata);
        //                     //     if (!count($filtered)) {
        //                     //         $exist_same_mata = false;
        //                     //     }
        //                     // }
        //                 } else {
        //                     $exist_same_mata = false;
        //                 }
        //             } else {
        //                 $exist_same_mata = false;
        //             }
        //         }
        //         $exist_same_mainan = true;
        //         if ($exist_same_mata) {
        //             if (count($item_exist->mainans)) {
        //                 if (isset($post['checkbox_mainan']) && isset($post['tipe_mainan'])) {
        //                     if ($post['checkbox_mainan'] == 'on') {
        //                         foreach ($post['tipe_mainan'] as $post_tipe_mainan) {
        //                             # code...
        //                         }
        //                     } else {
        //                         $exist_same_mainan = false;
        //                     }
        //                 } else {
        //                     $exist_same_mainan = false;
        //                 }
        //             }
        //         }
        //     }
        // }
    }
}
