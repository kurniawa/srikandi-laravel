<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\HargaPasaran;
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
        $kategoris = HargaPasaran::select('kategori')->groupBy('kategori')->get();
        // dd($kategoris);
        $col_harga_pasarans = collect();
        foreach ($kategoris as $kategori) {
            $harga_pasarans = HargaPasaran::where('kategori', $kategori->kategori)->limit(500)->orderByDesc('created_at')->get();
            $col_harga_pasarans->push($harga_pasarans);
        }

        $data = [
            'user' => $user,
            'cart' => $cart,
            'col_harga_pasarans' => $col_harga_pasarans,
        ];

        return view('attributes.harga_pasaran_index', $data);
    }

    function create() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $kategoris = ['LM', 'CT', '3750', '4200', '7000', '7500'];

        $data = [
            'user' => $user,
            'cart' => $cart,
            'kategoris' => $kategoris,
        ];
        return view('attributes.harga_pasaran_create', $data);
    }

    function store(Request $request) {
        $post = $request->post();
        dd($post);
    }

    function edit(HargaPasaran $harga_pasaran, Request $request) {
        $post = $request->post();
        dump($post);
        dd($harga_pasaran);
    }
}
