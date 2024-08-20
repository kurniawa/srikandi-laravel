<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\JenisPerhiasan;
use App\Models\TipePerhiasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipePerhiasanController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $tipe_perhiasans = TipePerhiasan::all();
        $col_jenis_perhiasans = collect();
        foreach ($tipe_perhiasans as $tipe_perhiasan) {
            $jenis_perhiasans = JenisPerhiasan::where('tipe_perhiasan', $tipe_perhiasan->nama)->get();
            $col_jenis_perhiasans->push([
                'tipe_perhiasan' => $tipe_perhiasan->nama,
                'jenis_perhiasans' => $jenis_perhiasans,
            ]);
        }

        $data = [
            'user' => $user,
            'cart' => $cart,
            'col_jenis_perhiasans' => $col_jenis_perhiasans,
            'tipe_perhiasans' => $tipe_perhiasans,
            'all_items_x_photos' => Item::get_all_item_x_photos(),
        ];

        return view('attributes.tipe_perhiasan_index', $data);
    }

    function store(Request $request) {
        $post = $request->post();
        // dump($post);
        $request->validate([
            'tipe_perhiasan_id'=>'required|numeric',
            'jenis_perhiasan'=>'required',
        ]);

        $success_ = "";
        

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_tipe_perhiasan = JenisPerhiasan::where('tipe_perhiasan_id', $post['tipe_perhiasan_id'])->Where('nama', $post['jenis_perhiasan'])->first();
        // dd($exist_tipe_perhiasan);
        if ($exist_tipe_perhiasan) {
            $request->validate(['error'=>'required'],['error.required'=>'jenis_perhiasan sudah ada']);
        }
        // END - VALIDASI EXIST

        $tipe_perhiasan = TipePerhiasan::find($post['tipe_perhiasan_id']);
        JenisPerhiasan::create([
            'tipe_perhiasan_id' => $post['tipe_perhiasan_id'],
            'tipe_perhiasan' => $tipe_perhiasan->nama,
            'nama' => $post['jenis_perhiasan'],
        ]);

        $success_ .= 'New tipe_perhiasan created';

        $feedback = [
            'success_' => $success_,
        ];

        return back()->with($feedback);
    }

    function edit(TipePerhiasan $tipe_perhiasan) {
        // dd($tipe_perhiasan);
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'user' => $user,
            'cart' => $cart,
            'cap' => $tipe_perhiasan,
            'all_items_x_photos' => Item::get_all_item_x_photos(),
        ];

        return view('attributes.tipe_perhiasan_edit', $data);
    }

    function update(TipePerhiasan $tipe_perhiasan, Request $request) {
        $post = $request->post();
        // dump($post);
        // dd($tipe_perhiasan);
        $request->validate(['nama'=>'required']);

        $success_ = "";

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_tipe_perhiasan = TipePerhiasan::where('id', '!=', $tipe_perhiasan->id)->where(function ($query) use ($post) {
            $query->where('nama', $post['nama']);
            $query->orWhere('codename', $post['codename']);
        })->first();
        
        if ($exist_tipe_perhiasan) {
            $request->validate(['error'=>'required'],['error.required'=>'tipe_perhiasan sudah ada']);
        }
        // END VALIDASI EXIST

        $tipe_perhiasan->update([
            'nama' => $post['nama'],
            'codename' => $post['codename'],
        ]);

        $success_ .= 'Data tipe_perhiasan diupdate';

        $feedback = [
            'success_' => $success_,
        ];

        return redirect()->route('attributes.caps.index')->with($feedback);
    }

    function destroy(TipePerhiasan $tipe_perhiasan) {
        $warnings_ = "";
        $tipe_perhiasan->delete();
        $warnings_ .= "Data tipe_perhiasan dihapus!";

        $feedback = [
            'warnings_' => $warnings_,
        ];
        
        return back()->with($feedback);
    }
}
