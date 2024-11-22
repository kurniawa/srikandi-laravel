<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\JenisPerhiasan;
use App\Models\Mainan;
use App\Models\Mata;
use App\Models\Menu;
use App\Models\TipePerhiasan;
use App\Models\WarnaEmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

    function update_codename_in_table_matas() {
        $matas = Mata::all();

        $level_warnas = Mata::select('level_warna')->groupBy('level_warna')->get();
        $opacities = Mata::select('opacity')->groupBy('opacity')->get();

        // dump($level_warnas);
        // dd($opacities);

        $is_mata_orange_exist = Mata::where('warna', 'orange')->first();
        if (!$is_mata_orange_exist) {
            foreach ($level_warnas as $lw) {
                foreach ($opacities as $op) {
                    Mata::create([
                        'warna' => 'orange',
                        'level_warna' => $lw->level_warna,
                        'opacity' => $op->opacity,
                        'codename' => 'm.or'
                    ]);
                }
            }
        }

        foreach ($matas as $mata) {
            if ($mata->warna == 'putih') {
                $mata->codename = 'm.p';
            } elseif ($mata->warna == 'merah') {
                $mata->codename = 'm.m';
            } elseif ($mata->warna == 'biru') {
                $mata->codename = 'm.b';
            } elseif ($mata->warna == 'kuning') {
                $mata->codename = 'm.k';
            } elseif ($mata->warna == 'orange') {
                $mata->codename = 'm.or';
            } elseif ($mata->warna == 'ungu') {
                $mata->codename = 'm.u';
            } elseif ($mata->warna == 'hijau') {
                $mata->codename = 'm.hijau';
            } elseif ($mata->warna == 'pink') {
                $mata->codename = 'm.pink';
            } elseif ($mata->warna == 'lila') {
                $mata->codename = 'm.lila';
            } elseif ($mata->warna == 'hitam') {
                $mata->codename = 'm.hitam';
            } elseif ($mata->warna == 'coklat') {
                $mata->codename = 'm.c';
            }
            $mata->save();
        }

        $feedback = [
            'success_' => '-codename in table matas updated and mata orange added-'
        ];
        
        return back()->with($feedback);
    }

    function update_codename_in_table_mainans() {
        $mainans = Mainan::all();

        foreach ($mainans as $mainan) {
            if ($mainan->codename === null) {
                if (str_contains($mainan->nama, " ")) {
                    $arr_nama = explode(" ", $mainan->nama);
                    for ($i=0; $i < count($arr_nama); $i++) { 
                        $arr_nama[$i] = ucfirst($arr_nama[$i]);
                    }
                    $new_nama = implode(" ", $arr_nama);
                    $codename = "m-" . str_replace(" ", "", $new_nama);
                    $mainan->nama = $new_nama;
                }
                // dd($codename);
            } else {
                $codename = $mainan->codename;
                $codename = str_replace('mai.', 'm-', $codename);
            }
            $mainan->codename = $codename;
            $mainan->save();
        }

        $feedback = [
            'success_' => '-codename in table mainans updated-'
        ];
        
        return back()->with($feedback);
    }

    function backup_data() {
        $users = DB::table('users')->get();
        File::put(storage_path('backup/users.json'), $users->toJson());

        $mainans = DB::table('mainans')->get();
        File::put(storage_path('backup/mainans.json'), $mainans->toJson());
        
        $items = DB::table('items')->get();
        // FIX keterangan mata pada items
        foreach ($items as $item) {
            $arr_longnames = explode(" ", $item->longname);
            $confirm_update_longname = false;
            foreach ($arr_longnames as $key => $longname) {
                if (str_contains($longname, 'm.p-lw.n-opac.t')) {
                    // dump($longname);
                    $explodes = explode(":", $longname);
                    $explodes[0] = "m.p:";
                    $explodes[1] = "$explodes[1](1)";
                    $arr_longnames[$key] = "$explodes[0]$explodes[1]";
                    $confirm_update_longname = true;
                    // dump($longname);
                    // dd($arr_longnames);
                }
                if (str_contains($longname, 'm.pink-lw.n-opac.t')) {
                    // dump($longname);
                    $explodes = explode(":", $longname);
                    $explodes[0] = "m.pink:";
                    $explodes[1] = "$explodes[1](55)";
                    $arr_longnames[$key] = "$explodes[0]$explodes[1]";
                    $confirm_update_longname = true;
                    // dump($longname);
                    // dd($arr_longnames);
                }
                if (str_contains($longname, 'mai.')) {
                    // dump($longname);
                    $arr_longnames[$key] = str_replace("mai.", "m-", $longname);
                    $confirm_update_longname = true;
                    // dump($longname);
                    // dd($arr_longnames);
                }
            }
            if ($confirm_update_longname) {
                $new_longname = implode(" ", $arr_longnames);
                DB::table('items')->where('id', $item->id)->update(['longname' => $new_longname]);
                // dd($new_longname);
            }
            
        }
        // END - FIX keterangan mata pada items
        File::put(storage_path('backup/items.json'), $items->toJson());

        $photos = DB::table('photos')->get();
        File::put(storage_path('backup/photos.json'), $photos->toJson());

        $item_photos = DB::table('item_photos')->get();
        File::put(storage_path('backup/item_photos.json'), $item_photos->toJson());

        $item_mainans = DB::table('item_mainans')->get();
        File::put(storage_path('backup/item_mainans.json'), $item_mainans->toJson());

        $item_matas = DB::table('item_matas')->get();
        File::put(storage_path('backup/item_matas.json'), $item_matas->toJson());
        
        $feedback = [
            'success_' => '-table users, items, photos, item_photos, item_mainans, item_matas berhasil di backup-'
        ];

        return back()->with($feedback);
    }

    function update_jenis_perhiasan() {
        // UPDATE Data Jenis Perhiasan
        $items = Item::all();
        $jenis_perhiasan_to_insert = [];
        // $jenis_perhiasan_available = [];
        foreach ($items as $item) {
            $is_jenis_perhiasan_exist = JenisPerhiasan::where('tipe_perhiasan', $item->tipe_perhiasan)->where('nama', $item->jenis_perhiasan)->first();
            if (!$is_jenis_perhiasan_exist) {
                $tipe_perhiasan = TipePerhiasan::where('nama', $item->tipe_perhiasan)->first();
                $jenis_perhiasan_to_insert[] = [
                    'nama' => $item->jenis_perhiasan,
                    'tipe_perhiasan' => $item->tipe_perhiasan,
                    'tipe_perhiasan_id' => $tipe_perhiasan->id,
                ];
            } 
            
            // else {
            //     $tipe_perhiasan = TipePerhiasan::where('nama', $item->tipe_perhiasan)->first();
            //     $jenis_perhiasan_available[] = [
            //         'nama' => $item->jenis_perhiasan,
            //         'tipe_perhiasan' => $item->tipe_perhiasan,
            //         'tipe_perhiasan_id' => $tipe_perhiasan->id,
            //     ];
            // }
        }
        // dump($jenis_perhiasan_available);
        // dd($jenis_perhiasan_to_insert);
        if (count($jenis_perhiasan_to_insert)) {
            DB::table('jenis_perhiasans')->insert($jenis_perhiasan_to_insert);
        }

        $feedback = [
            'success_' => '-jenis_perhiasans updated-'
        ];
        return back()->with($feedback);
        // END - UPDATE Data Jenis Perhiasan
    }
}
