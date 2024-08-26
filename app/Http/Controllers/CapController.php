<?php

namespace App\Http\Controllers;

use App\Models\Cap;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CapController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $caps = Cap::all();

        $data = [
            'user' => $user,
            'cart' => $cart,
            'caps' => $caps,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('attributes.cap_index', $data);
    }

    function store(Request $request) {
        $post = $request->post();
        // dd($post);
        $request->validate(['nama'=>'required']);

        $success_ = "";
        $codename = "c." . $post['nama'];
        if ($post['codename']) {
            $codename = $post['codename'];
        }

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_cap = Cap::where('nama', $post['nama'])->orWhere('codename', $codename)->first();
        if ($exist_cap) {
            $request->validate(['error'=>'required'],['error.required'=>'cap sudah ada']);
        }
        // END - VALIDASI EXIST

        Cap::create([
            'nama' => $post['nama'],
            'codename' => $codename,
        ]);

        $success_ .= 'New cap created';

        $feedback = [
            'success_' => $success_,
        ];

        return back()->with($feedback);
    }

    function edit(cap $cap) {
        // dd($cap);
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'user' => $user,
            'cart' => $cart,
            'cap' => $cap,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('attributes.cap_edit', $data);
    }

    function update(cap $cap, Request $request) {
        $post = $request->post();
        // dump($post);
        // dd($cap);
        $request->validate(['nama'=>'required']);

        $success_ = "";
        $codename = "c." . $post['nama'];
        if ($post['codename']) {
            $codename = $post['codename'];
        }

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_cap = Cap::where('id', '!=', $cap->id)->where(function ($query) use ($post, $codename) {
            $query->where('nama', $post['nama']);
            $query->orWhere('codename', $codename);
        })->first();
        
        if ($exist_cap) {
            $request->validate(['error'=>'required'],['error.required'=>'cap sudah ada']);
        }
        // END VALIDASI EXIST

        $cap->update([
            'nama' => $post['nama'],
            'codename' => $codename,
        ]);

        $success_ .= 'Data cap diupdate';

        $feedback = [
            'success_' => $success_,
        ];

        return redirect()->route('attributes.caps.index')->with($feedback);
    }

    function destroy(Cap $cap) {
        $warnings_ = "";
        $cap->delete();
        $warnings_ .= "Data cap dihapus!";

        $feedback = [
            'warnings_' => $warnings_,
        ];
        
        return back()->with($feedback);
    }
}
