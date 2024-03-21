<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    function store($from, Request $request) {
        $post = $request->post();
        dump($from);
        dd($post);

        $request->validate([
            'tipe_barang'=> 'required',
            'harga_t'=> 'required|numeric',
            'nama_short'=> 'required',
            'nama_long'=> 'required',
        ]);
        $harga_t = (float)$post['harga_t'] * 100;

        $tipe_perhiasan = null;
        $jenis_perhiasan = null;
        $warna_emas = null;
        $kadar = null;
        $berat = null;
        $harga_gr = null;
        if ($post['tipe_barang'] === 'perhiasan') {
            $request->validate([
                'tipe_perhiasan' => 'required',
                'jenis_perhiasan' => 'required',
                'warna_emas' => 'required',
                'kadar' => 'required|numeric',
                'berat' => 'required|numeric',
                'harga_gr' => 'required|numeric',
            ]);
            $tipe_perhiasan = $post['tipe_perhiasan'];
            $jenis_perhiasan = $post['jenis_perhiasan'];
            $warna_emas = $post['warna_emas'];
            $kadar = (float)$post['kadar'] * 100;
            $berat = (float)$post['berat'] * 100;
            $harga_gr = (float)$post['harga_gr'] * 100;
        }

        // cek apakah ada item yang sama
        $item_exist = Item::where('nama_long', $post['nama_long'])->get();

        if (count($item_exist) !== 0) {

        }

        $item_new = Item::create([
            'tipe_barang' => $post['tipe_barang'],
            'tipe_perhiasan' => $tipe_perhiasan,
            'jenis_perhiasan' => $jenis_perhiasan,
            'warna_emas' => $warna_emas,
            'kadar' => $kadar,
            'berat' => $berat,
            'harga_gr' => $harga_gr,
            'harga_t' => $harga_t,
        ]);
    }
}
