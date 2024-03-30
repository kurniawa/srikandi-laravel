<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemMainan;
use App\Models\ItemMata;
use App\Models\Mainan;
use App\Models\Mata;
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
        $kondisi = null;
        $cap = null;
        $range_usia = null;
        $ukuran = null;
        $merk = null;
        $plat = null;
        // $edisi = null;
        // $nampan = null;
        if ($post['tipe_barang'] === 'perhiasan') {
            $request->validate([
                'tipe_perhiasan' => 'required',
                'jenis_perhiasan' => 'required',
                'warna_emas' => 'required',
                'plat' => 'nullable|numeric',
                'kadar' => 'required|numeric',
                'berat' => 'required|numeric',
                'harga_gr' => 'required|numeric',
                'nama_short' => 'required',
                'nama_long' => 'required',
                'kondisi' => 'nullable',
                'cap' => 'nullable',
                'range_usia' => 'nullable',
                'ukuran' => 'nullable|numeric',
                'merk' => 'nullable',
                'plat' => 'nullable|numeric',
                'edisi' => 'nullable',
                'nampan' => 'nullable',
                'deskripsi' => 'nullable',
                'keterangan' => 'nullable',
                'status' => 'nullable',
            ]);
            $tipe_perhiasan = $post['tipe_perhiasan'];
            $jenis_perhiasan = $post['jenis_perhiasan'];
            $warna_emas = $post['warna_emas'];
            $kadar = (float)$post['kadar'] * 100;
            $berat = (float)$post['berat'] * 100;
            $harga_gr = (float)$post['harga_gr'] * 100;
            $harga_t = (float)$post['berat'] * (float)$post['harga_gr'] * 100;
        }

        // cek apakah ada item yang sama
        $item_exist = Item::where('nama_long', $post['nama_long'])->get();

        if (count($item_exist) !== 0) {
            dump('item exist');
            dd($item_exist);
        }

        $item_new = Item::create([
            'tipe_barang' => $post['tipe_barang'],
            'tipe_perhiasan' => $tipe_perhiasan,
            'jenis_perhiasan' => $jenis_perhiasan,
            'range_usia' => $post['range_usia'],
            'warna_emas' => $warna_emas,
            'kadar' => $kadar,
            'berat' => $berat,
            'harga_gr' => $harga_gr,
            'harga_t' => $harga_t,
            'kondisi' => $post['kondisi'],
            'cap' => $post['cap'],
            'range_usia' => $post['range_usia'],
            'ukuran' => $post['ukuran'],
            'merk' => $post['merk'],
            'plat' => $post['plat'],
        ]);

        // MATA
        foreach ($post['warna_mata'] as $key_warna_mata => $warna_mata) {
            if ($warna_mata) {
                if ($post['jumlah_mata'][$key_warna_mata] == 0 || $post['jumlah_mata'][$key_warna_mata] === null) {
                    $request->validate(['error'=>'required'], ['error.required'=>'-jumlah_mata tidak sesuai-']);
                }
                $mata = Mata::where('warna', $warna_mata)->where('level_warna', $post['level_warna'][$key_warna_mata])->where('opacity', $post['opacity'][$key_warna_mata])->first();
                if (!$mata) {
                    $mata = Mata::create([
                        'warna' => $warna_mata,
                        'level_warna' => $post['level_warna'][$key_warna_mata],
                        'opacity' => $post['opacity'][$key_warna_mata],
                    ]);
                }
                ItemMata::create([
                    'item_id' => $item_new->id,
                    'mata_id' => $mata->id,
                    'jumlah_mata' => $post['jumlah_mata'][$key_warna_mata],
                ]);
            }
        }

        // MAINAN
        foreach ($post['tipe_mainan'] as $key_tipe_mainan => $tipe_mainan) {
            if ($tipe_mainan) {
                if ($post['jumlah_mainan'][$key_tipe_mainan] === null || $post['jumlah_mainan'][$key_tipe_mainan] == 0 ) {
                    $request->validate(['error'=>'required'],['error.required'=>'-jumlah_mainan tidak sesuai-']);
                }
                $mainan = Mainan::where('nama', $tipe_mainan)->first();
                if (!$mainan) {
                    $mainan = Mainan::create([
                        'nama' => $tipe_mainan,
                    ]);
                }
                ItemMainan::create([
                    'item_id' => $item_new->id,
                    'mainan_id' => $mainan->id,
                    'jumlah_mainan' => $post['jumlah_mainan'][$key_tipe_mainan]
                ]);
            }
        }
    }
}
