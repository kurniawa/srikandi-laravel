<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ArtisanController extends Controller
{
    function index() {

        $data = [
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
        ];

        return view('artisans.index', $data);
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
