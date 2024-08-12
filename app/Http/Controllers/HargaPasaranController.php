<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\HargaPasaran;
use App\Models\Kadar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HargaPasaranController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }
        $kadars = Kadar::all();
        // dd($kategoris);
        $col_harga_pasarans = collect();
        foreach ($kadars as $kadar) {
            $harga_pasarans = HargaPasaran::where('kategori', $kadar->kategori)->limit(500)->orderByDesc('created_at')->get();
            $col_harga_pasarans->push($harga_pasarans);
        }

        $data = [
            'user' => $user,
            'cart' => $cart,
            'col_harga_pasarans' => $col_harga_pasarans,
        ];
        // dd($col_harga_pasarans);
        return view('attributes.harga_pasaran_index', $data);
    }

    function create() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        // $kategoris = ['LM', 'CT', '3750', '4200', '7000', '7500'];
        $kadars = Kadar::all();

        $data = [
            'user' => $user,
            'cart' => $cart,
            'kadars' => $kadars,
        ];
        return view('attributes.harga_pasaran_create', $data);
    }

    function store(Request $request) {
        $post = $request->post();
        // dd($post);
        // VALIDASI KALAU ADA HARGA CT, MAKA HARUS ADA HARGA LAINNYA
        for ($i=0; $i < count($post['harga_beli']); $i++) { 
            if ($post['harga_beli'][$i]) {
                if (!$post['harga_buyback'][$i]) {
                    $request->validate(['error'=>'required'],['error.required'=>'-data belum lengkap-']);
                }
            }
            if ($i >= 1) {
                if ($post['harga_beli'][1]) {
                    if (!$post['harga_beli'][$i] || !$post['harga_buyback'][$i]) {
                        $request->validate(['error'=>'required'],['error.required'=>'-data belum lengkap-']);
                    }
                }
            }
        }
        // END - VALIDASI
        $success_ = '';
        for ($i=0; $i < count($post['harga_beli']); $i++) { 
            if ($post['harga_beli'][$i]) {
                HargaPasaran::create([
                    "kategori" => $post['kategori'][$i],
                    "kadar" => $post['kadar'][$i],
                    "harga_beli" => (string)((float)$post['harga_beli'][$i] * 100),
                    "harga_buyback" => (string)((float)$post['harga_buyback'][$i] * 100),
                ]);
            }
        }
        $success_ .= 'New HargaPasaran added';

        $feedback = [
            'success_' => $success_
        ];

        return redirect()->route('attributes.harga_pasaran.index')->with($feedback);
    }

    function edit(HargaPasaran $harga_pasaran) {
        // dd($harga_pasaran);

        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'user' => $user,
            'cart' => $cart,
            'harga_pasaran' => $harga_pasaran,
        ];

        return view('attributes.harga_pasaran_edit', $data);
    }

    function update(HargaPasaran $harga_pasaran, Request $request) {
        $post = $request->post();
        // dump($post);
        // dump($harga_pasaran);
        $request->validate([
            'harga_beli' => 'required|numeric',
            'harga_buyback' => 'required|numeric',
            'kategori' => 'required',
            'kadar' => 'required',
        ]);

        $success_ = '';
        // dd((string)((float)$post['harga_beli'] * 100));
        $harga_pasaran->update([
            'harga_beli' => (string)((float)$post['harga_beli'] * 100),
            'harga_buyback' => (string)((float)$post['harga_buyback'] * 100),
        ]);

        $success_ .= 'HargaPasaran diupdate';

        $feedback = [
            'success_' => $success_
        ];

        return redirect()->route('attributes.harga_pasaran.index')->with($feedback);
    }
}
