<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Merk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerkController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $merks = Merk::all();

        $data = [
            'cart' => $cart,
            'user' => $user,
            'merks' => $merks,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('attributes.merk_index', $data);
    }

    function store(Request $request) {
        $post = $request->post();
        // dd($post);
        $request->validate(['nama'=>'required']);

        $success_ = "";
        $codename = "m." . $post['nama'];
        if ($post['codename']) {
            $codename = $post['codename'];
        }

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_merk = Merk::where('nama', $post['nama'])->orWhere('codename', $codename)->first();
        if ($exist_merk) {
            $request->validate(['error'=>'required'],['error.required'=>'merk sudah ada']);
        }
        // END - VALIDASI EXIST

        Merk::create([
            'nama' => $post['nama'],
            'codename' => $codename,
        ]);

        $success_ .= 'New merk created';

        $feedback = [
            'success_' => $success_,
        ];

        return back()->with($feedback);
    }

    function edit(merk $merk) {
        // dd($merk);
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'cart' => $cart,
            'user' => $user,
            'merk' => $merk,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('attributes.merk_edit', $data);
    }

    function update(merk $merk, Request $request) {
        $post = $request->post();
        // dump($post);
        // dd($merk);
        $request->validate(['nama'=>'required']);

        $success_ = "";
        $codename = "m." . $post['nama'];
        if ($post['codename']) {
            $codename = $post['codename'];
        }

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_merk = Merk::where('id', '!=', $merk->id)->where(function ($query) use ($post, $codename) {
            $query->where('nama', $post['nama']);
            $query->orWhere('codename', $codename);
        })->first();
        
        if ($exist_merk) {
            $request->validate(['error'=>'required'],['error.required'=>'merk sudah ada']);
        }
        // END VALIDASI EXIST

        $merk->update([
            'nama' => $post['nama'],
            'codename' => $codename,
        ]);

        $success_ .= 'Data merk diupdate';

        $feedback = [
            'success_' => $success_,
        ];

        return redirect()->route('attributes.merks.index')->with($feedback);
    }

    function destroy(merk $merk) {
        $warnings_ = "";
        $merk->delete();
        $warnings_ .= "Data merk dihapus!";

        $feedback = [
            'warnings_' => $warnings_,
        ];
        
        return back()->with($feedback);
    }
}
