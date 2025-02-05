<?php

namespace App\Http\Controllers;

use App\Models\Cap;
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
use Illuminate\Support\Facades\Log;

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
        $users = DB::table('users')->get();File::put(storage_path('backup/users.json'), $users->toJson()); // seeder: aman
        $item_types = DB::table('item_types')->get();File::put(storage_path('backup/item_types.json'), $item_types->toJson()); // seeder: aman
        $tipe_perhiasans = DB::table('tipe_perhiasans')->get();File::put(storage_path('backup/tipe_perhiasans.json'), $tipe_perhiasans->toJson()); // seeder: aman
        $jenis_perhiasans = DB::table('jenis_perhiasans')->get();File::put(storage_path('backup/jenis_perhiasans.json'), $jenis_perhiasans->toJson()); // seeder: aman
        $warna_emas = DB::table('warna_emas')->get();File::put(storage_path('backup/warna_emas.json'), $warna_emas->toJson()); // seeder: aman
        $kadars = DB::table('kadars')->get();File::put(storage_path('backup/kadars.json'), $kadars->toJson()); // seeder: aman
        $caps = DB::table('caps')->get();File::put(storage_path('backup/caps.json'), $caps->toJson()); // seeder: aman
        $age_ranges = DB::table('age_ranges')->get();File::put(storage_path('backup/age_ranges.json'), $age_ranges->toJson()); // seeder: aman
        $merks = DB::table('merks')->get();File::put(storage_path('backup/merks.json'), $merks->toJson()); // seeder: aman
        $matas = DB::table('matas')->get();File::put(storage_path('backup/matas.json'), $matas->toJson()); // seeder: aman
        $mainans = DB::table('mainans')->get();File::put(storage_path('backup/mainans.json'), $mainans->toJson()); // seeder: aman

        $items = DB::table('items')->get();File::put(storage_path('backup/items.json'), $items->toJson()); // seeder: aman
        $photos = DB::table('photos')->get();File::put(storage_path('backup/photos.json'), $photos->toJson()); // seeder: aman
        $item_photos = DB::table('item_photos')->get();File::put(storage_path('backup/item_photos.json'), $item_photos->toJson()); // seeder: aman (PhotoSeeder)
        $item_mainans = DB::table('item_mainans')->get();File::put(storage_path('backup/item_mainans.json'), $item_mainans->toJson()); // seeder: aman (ItemSeeder)
        $item_matas = DB::table('item_matas')->get();File::put(storage_path('backup/item_matas.json'), $item_matas->toJson()); // seeder: aman (ItemSeeder)
        
        $feedback = [
            'success_' => '-table users, items, photos, item_photos, item_mainans, item_matas berhasil di backup-'
        ];

        return back()->with($feedback);
    }

    function update_jenis_perhiasans_d_caps() {
        // UPDATE Data Jenis Perhiasan
        $items = Item::all();
        foreach ($items as $item) {
            $is_jenis_perhiasan_exist = JenisPerhiasan::where('tipe_perhiasan', $item->tipe_perhiasan)->where('nama', $item->jenis_perhiasan)->first();
            if (!$is_jenis_perhiasan_exist) {
                $tipe_perhiasan = TipePerhiasan::where('nama', $item->tipe_perhiasan)->first();
                JenisPerhiasan::create([
                    'nama' => $item->jenis_perhiasan,
                    'tipe_perhiasan' => $item->tipe_perhiasan,
                    'tipe_perhiasan_id' => $tipe_perhiasan->id,
                ]);
            }
            
            if ($item->cap !== null) {
                $is_cap_exist = Cap::where('nama', $item->cap)->first();
                if (!$is_cap_exist) {
                    Cap::create([
                        'nama' => $item->cap,
                        'codename' => 'c.' . $item->cap,
                    ]);
                }
            }
        }


        $feedback = [
            'success_' => '-jenis_perhiasans dan caps updated-'
        ];

        return back()->with($feedback);
        // END - UPDATE Data Jenis Perhiasan
    }

    function update_name_in_caps() {
        $caps = Cap::select('id', 'name', 'nama', 'codename')->get();
        foreach ($caps as $cap) {
            $nama = $cap->nama;
            if (str_contains($cap->nama, 'gambar')) {
                $nama = str_replace('gambar ', 'g-', $cap->nama);
            }

            $codename = $cap->codename;
            if (str_contains($cap->codename, 'gbr.')) {
                $codename = str_replace('gbr.', 'g-', $cap->codename);
            }
            
            $name = $cap->name;
            if (str_contains($name, 'c.')) {
                $name = str_replace('c.', '', $name);
            }
            if (str_contains($name, 'gbr.')) {
                $name = str_replace('gbr.', '', $name);
            }

            $type = $cap->type;
            if (str_contains($cap->nama, 'g-')) {
                $type = 'picture';
            } else {
                $type = 'character';
            }
            // $cap->name = $name;
            // if (!$nama) {
            //     dump($cap);
            //     dd($nama);
            // }
            $cap->name = $name;
            $cap->type = $type;
            $cap->nama = $nama;
            $cap->codename = $codename;
            $cap->save();
        }
    }

    function re_sorting_barcodes_in_caps() {
        // phpinfo();
        // dd('');
        try {
            DB::table('caps')->update(['barcode' => null]);
            $caps = Cap::select('id', 'barcode')->orderBy('type')->orderBy('name')->get();
            // dump($caps);
            $barcode = 1;
            foreach ($caps as $cap) {
                // dump($cap->barcode);
                $cap->barcode = $barcode;
                $cap->save();
    
                // dd($cap->barcode);
                $barcode++;
            }

            return back()->with('success_', 're_sorting_barcodes in caps finished');

        } catch (\Throwable $th) {
            dump('Error during transaction: ' . $th->getMessage());
            dd('trace', $th->getTraceAsString());
            // Log::error('Error during transaction: ' . $th->getMessage(), [
            //     'trace' => $th->getTraceAsString(),
            // ]);
        }

        
    }

    function resorting_jenisPerhiasan_berdasarkan_tipePerhiasan_dan_nama() {
        $tipe_perhiasans = TipePerhiasan::select('nama')->get();
        // dump($tipe_perhiasans);
        $sorted_jenis_perhiasans = collect();
        foreach ($tipe_perhiasans as $tipe_perhiasan) {
            $jenis_perhiasans = JenisPerhiasan::select('tipe_perhiasan_id', 'tipe_perhiasan', 'nama')->where('tipe_perhiasan', $tipe_perhiasan->nama)->orderBy('nama')->get();
            $sorted_jenis_perhiasans = $sorted_jenis_perhiasans->merge($jenis_perhiasans);
        }

        // dd($sorted_jenis_perhiasans);
        if (count($sorted_jenis_perhiasans)) {
            File::put(storage_path('backup/jenis_perhiasans.json'), $sorted_jenis_perhiasans->toJson());
            JenisPerhiasan::truncate();
            // Path ke file JSON
            $path = storage_path('backup/jenis_perhiasans.json');
    
            // Periksa apakah file JSON ada
            if (!File::exists($path)) {
                dd("File $path tidak ditemukan.");
            }
    
            // Baca data dari file JSON
            $json = File::get($path);
            $data = json_decode($json, true);
    
            // Insert data ke tabel 'jenis_perhiasans'
            $continue_to_apply_barcodes = false;
            if (!empty($data)) {
                DB::table('jenis_perhiasans')->insert($data);
                $continue_to_apply_barcodes = true;
                dump('Data berhasil dimasukkan ke tabel jenis_perhiasans.');
            } else {
                dd('Tidak ada data yang ditemukan di file JSON.');
            }
    
            if ($continue_to_apply_barcodes) {
                // Seeding barcode pada data jenis_perhiasan berdasarkan tipe_perhiasan nya
                $tipe_perhiasans = TipePerhiasan::select('nama')->get();
                foreach ($tipe_perhiasans as $tipe_perhiasan) {
                    $jenis_perhiasans = JenisPerhiasan::where('tipe_perhiasan', $tipe_perhiasan->nama)->orderBy('nama')->get();
                    $barcode = 1;
                    foreach ($jenis_perhiasans as $jenis_perhiasan) {
                        // Menghindari angka 4 pada barcode
                        $barcode = str_contains((string)$barcode, '4') ? (++$barcode) : $barcode;
                        $jenis_perhiasan->barcode = (string)$barcode;
                        $jenis_perhiasan->save();
                        $barcode++;
                    }
                }
            }
        }

    }

}

// $items = DB::table('items')->get();
// // FIX keterangan mata pada items
// foreach ($items as $item) {
//     $arr_longnames = explode(" ", $item->longname);
//     $confirm_update_longname = false;

//     // set initial value for variable to update
//     $new_longname = $item->longname;
//     // END - set initial value for variable to update
//     foreach ($arr_longnames as $key => $longname) {
//         if (str_contains($longname, 'm.p-lw.n-opac.t')) {
//             // dump($longname);
//             $explodes = explode(":", $longname);
//             $explodes[0] = "m.p:";
//             $explodes[1] = "$explodes[1](1)";
//             $arr_longnames[$key] = "$explodes[0]$explodes[1]";
//             $confirm_update_longname = true;
//             // dump($longname);
//             // dd($arr_longnames);
//         }
//         if (str_contains($longname, 'm.pink-lw.n-opac.t')) {
//             // dump($longname);
//             $explodes = explode(":", $longname);
//             $explodes[0] = "m.pink:";
//             $explodes[1] = "$explodes[1](55)";
//             $arr_longnames[$key] = "$explodes[0]$explodes[1]";
//             $confirm_update_longname = true;
//             // dump($longname);
//             // dd($arr_longnames);
//         }
//         if (str_contains($longname, 'mai.')) {
//             // dump($longname);
//             $arr_longnames[$key] = str_replace("mai.", "m-", $longname);
//             $confirm_update_longname = true;
//             // dump($longname);
//             // dd($arr_longnames);
//         }
//     }

//     if ($confirm_update_longname) {
//         $new_longname = implode(" ", $arr_longnames);
//         DB::table('items')->where('id', $item->id)->update([
//             'longname' => $new_longname,
//         ]);
//         // dd($new_longname);
//     }

//     if (str_contains($item->cap, "gambar")) {
//         $new_cap = str_replace("gambar ", "g-", $item->cap);
//         $old_longname = DB::table('items')->select('longname')->where('id', $item->id)->first();
//         // dump($old_longname);
//         // dd($old_longname->longname);
//         if (str_contains($old_longname->longname, "gambar")) {
//             $new_longname = str_replace("gambar ", "g-", $old_longname->longname);
//             DB::table('items')->where('id', $item->id)->update([
//                 'longname' => $new_longname,
//                 'cap' => $new_cap,
//             ]);
//         }
//     }
    
// }
// // END - FIX keterangan mata pada items
