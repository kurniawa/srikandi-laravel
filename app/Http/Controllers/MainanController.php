<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Mainan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainanController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $mainans = Mainan::all();

        $data = [
            'user' => $user,
            'cart' => $cart,
            'mainans' => $mainans,
        ];

        return view('attributes.mainan_index', $data);
    }

    function store(Request $request) {
        $post = $request->post();
        // dd($post);
        $request->validate(['nama'=>'required']);

        $success_ = "";
        $codename = "mai." . $post['nama'];
        if ($post['codename']) {
            $codename = $post['codename'];
        }

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_mainan = Mainan::where('nama', $post['nama'])->orWhere('codename', $codename)->first();
        if ($exist_mainan) {
            $request->validate(['error'=>'required'],['error.required'=>'Mainan sudah ada']);
        }
        // END - VALIDASI EXIST

        Mainan::create([
            'nama' => $post['nama'],
            'codename' => $codename,
        ]);

        $success_ .= 'New Mainan created';

        $feedback = [
            'success_' => $success_,
        ];

        return back()->with($feedback);
    }

    function edit(Mainan $mainan) {
        // dd($mainan);
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'user' => $user,
            'cart' => $cart,
            'mainan' => $mainan,
        ];

        return view('attributes.mainan_edit', $data);
    }

    function update(Mainan $mainan, Request $request) {
        $post = $request->post();
        // dump($post);
        // dd($mainan);
        $request->validate(['nama'=>'required']);

        $success_ = "";
        $codename = "mai." . $post['nama'];
        if ($post['codename']) {
            $codename = $post['codename'];
        }

        // VALIDASI NAMA ATAU CODENAME YANG SAMA
        $exist_mainan = Mainan::where('id', '!=', $mainan->id)->where(function ($query) use ($post, $codename) {
            $query->where('nama', $post['nama']);
            $query->orWhere('codename', $codename);
        })->first();
        
        if ($exist_mainan) {
            $request->validate(['error'=>'required'],['error.required'=>'Mainan sudah ada']);
        }
        // END VALIDASI EXIST

        $mainan->update([
            'nama' => $post['nama'],
            'codename' => $codename,
        ]);

        $success_ .= 'Data mainan diupdate';

        $feedback = [
            'success_' => $success_,
        ];

        return redirect()->route('attributes.mainans.index')->with($feedback);
    }

    function destroy(Mainan $mainan) {
        $warnings_ = "";
        $mainan->delete();
        $warnings_ .= "Data mainan dihapus!";

        $feedback = [
            'warnings_' => $warnings_,
        ];
        
        return back()->with($feedback);
    }
}
