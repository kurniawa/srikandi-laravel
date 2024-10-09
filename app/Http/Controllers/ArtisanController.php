<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Menu;
use App\Models\WarnaEmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ArtisanController extends Controller
{
    function index() {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'user' => $user,
            'cart' => $cart,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('commands.index', $data);
    }

    function input_initial_data_warna_emas() {
        WarnaEmas::query()->truncate();
        $warna_emas = [
            ['nama' => 'kuning'],
            ['nama' => 'rose gold'],
            ['nama' => 'putih'],
            ['nama' => 'chrome'],
        ];
        foreach ($warna_emas as $we) {
            WarnaEmas::create($we);
        }

        return back()->with('success_', '-truncate table warna_emas dan input data warna_emas-');
    }
    function migrate_fresh_seed(Request $request) {
        if (Auth::user()->role !== 'Developer') {
            $request->validate(['error'=>'required'],['error.required'=>'clearance?']);
        }
        Artisan::call('migrate:fresh --seed');
        dd(Artisan::output());
    }
    function symbolic_link(Request $request) {
        if (Auth::user()->role !== 'Developer') {
            $request->validate(['error'=>'required'],['error.required'=>'clearance?']);
        }
        Artisan::call('storage:link');
        dd(Artisan::output());
    }
    function optimize_clear(Request $request) {
        if (Auth::user()->role !== 'Developer') {
            $request->validate(['error'=>'required'],['error.required'=>'clearance?']);
        }
        Artisan::call('optimize:clear');
        dd(Artisan::output());
    }

    // function vendor_publish_laravelPWA(Request $request) {
    //     if (Auth::user()->role !== 'Developer') {
    //         $request->validate(['error'=>'required'],['error.required'=>'clearance?']);
    //     }
    //     Artisan::call('vendor:publish --provider="LaravelPWA\Providers\LaravelPWAServiceProvider"');
    //     dd(Artisan::output());
    // }
}
