<?php

namespace App\Http\Controllers;

use App\Models\Cap;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\ItemMainan;
use App\Models\ItemMata;
use App\Models\ItemPhoto;
use App\Models\JenisPerhiasan;
use App\Models\Mainan;
use App\Models\Mata;
use App\Models\Menu;
use App\Models\Photo;
use App\Models\TipePerhiasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    function store($from, Request $request) {
        $post = $request->post();
        // dump($from);
        // dd($post);

        $request->validate([
            'tipe_barang'=> 'required',
            'harga_t'=> 'required|numeric',
            'nama_short'=> 'required',
            'nama_long'=> 'required',
        ]);
        $harga_t = (float)$post['harga_t'] * 100;

        $tipe_perhiasan = null;
        $jenis_perhiasan = null;
        $warna_emas = null;
        $kadar = null;
        $berat = null;
        $harga_g = null;
        // $edisi = null;
        // $nampan = null;
        if ($post['tipe_barang'] === 'perhiasan') {
            $request->validate([
                'tipe_perhiasan' => 'required',
                'jenis_perhiasan' => 'required',
                'warna_emas' => 'required',
                'plat' => 'nullable|numeric',
                'kadar' => 'required|numeric',
                'berat' => 'required|numeric',
                'harga_g' => 'required|numeric',
                'nama_short' => 'required',
                'nama_long' => 'required',
                'kondisi' => 'nullable',
                'cap' => 'nullable',
                'range_usia' => 'nullable',
                'ukuran' => 'nullable|numeric',
                'merk' => 'nullable',
                'plat' => 'nullable|numeric',
                'edisi' => 'nullable',
                'nampan' => 'nullable',
                'deskripsi' => 'nullable',
                'keterangan' => 'nullable',
                'status' => 'nullable',
            ]);
            $tipe_perhiasan = $post['tipe_perhiasan'];
            $jenis_perhiasan = $post['jenis_perhiasan'];
            // CEK relasi tipe_perhiasan dengan jenis_perhiasan
            $exist_jenis_perhiasan = JenisPerhiasan::where('tipe_perhiasan', $tipe_perhiasan)->where('nama', $jenis_perhiasan)->first();
            if (!$exist_jenis_perhiasan) {
                $get_tipe_perhiasan = TipePerhiasan::where('nama', $tipe_perhiasan)->first();
                JenisPerhiasan::create([
                    'tipe_perhiasan_id' => $get_tipe_perhiasan->id,
                    'tipe_perhiasan' => $tipe_perhiasan,
                    'nama' => $jenis_perhiasan,
                ]);
            }
            // END - CEK relasi tipe_perhiasan dengan jenis_perhiasan
            $warna_emas = $post['warna_emas'];
            $kadar = (float)$post['kadar'] * 100;
            $berat = (float)$post['berat'] * 100;
            $harga_g = (float)$post['harga_g'] * 100;
            $harga_t = (float)$post['berat'] * (float)$post['harga_g'] * 100;
        }

        // VALIDASI MATA
        foreach ($post['warna_mata'] as $key_warna_mata => $warna_mata) {
            if ($warna_mata) {
                if ($post['jumlah_mata'][$key_warna_mata] == 0 || $post['jumlah_mata'][$key_warna_mata] === null) {
                    $request->validate(['error'=>'required'], ['error.required'=>'-jumlah_mata tidak sesuai-']);
                }
            }
        }

        // VALIDASI MAINAN
        foreach ($post['tipe_mainan'] as $key_tipe_mainan => $tipe_mainan) {
            if ($tipe_mainan) {
                if ($post['jumlah_mainan'][$key_tipe_mainan] === null || $post['jumlah_mainan'][$key_tipe_mainan] == 0 ) {
                    $request->validate(['error'=>'required'],['error.required'=>'-jumlah_mainan tidak sesuai-']);
                }
            }
        }

        // cek apakah ada item yang sama
        $item_exist = Item::where('nama_long', $post['nama_long'])->get();

        if (count($item_exist) !== 0) { // pindah ke halaman untuk memilih item yang mirip-mirip
            dump('item exist');
            dd($item_exist);
        }

        $item_new = Item::create([
            'tipe_barang' => $post['tipe_barang'],
            'tipe_perhiasan' => $tipe_perhiasan,
            'jenis_perhiasan' => $jenis_perhiasan,
            'warna_emas' => $warna_emas,
            'kadar' => $kadar,
            'berat' => $berat,
            'harga_g' => $harga_g,
            'harga_t' => $harga_t,
            'nama_short' => $post['nama_short'],
            'nama_long' => $post['nama_long'],
            'kondisi' => $post['kondisi'],
            'cap' => $post['cap'],
            'range_usia' => $post['range_usia'],
            'ukuran' => $post['ukuran'],
            'merk' => $post['merk'],
            'plat' => $post['plat'],
            // 'edisi',
            // 'nampan',
            'stock' => 1,
            // 'kode_item',
            // 'barcode',
            // 'deskripsi',
            // 'keterangan',
            // 'status',
        ]);

        // MATA
        foreach ($post['warna_mata'] as $key_warna_mata => $warna_mata) {
            if ($warna_mata) {
                $mata = Mata::where('warna', $warna_mata)->where('level_warna', $post['level_warna'][$key_warna_mata])->where('opacity', $post['opacity'][$key_warna_mata])->first();
                if (!$mata) {
                    $mata = Mata::create([
                        'warna' => $warna_mata,
                        'level_warna' => $post['level_warna'][$key_warna_mata],
                        'opacity' => $post['opacity'][$key_warna_mata],
                    ]);
                }
                ItemMata::create([
                    'item_id' => $item_new->id,
                    'mata_id' => $mata->id,
                    'jumlah_mata' => $post['jumlah_mata'][$key_warna_mata],
                ]);
            }
        }

        // MAINAN
        foreach ($post['tipe_mainan'] as $key_tipe_mainan => $tipe_mainan) {
            if ($tipe_mainan) {
                $mainan = Mainan::where('nama', $tipe_mainan)->first();
                if (!$mainan) {
                    $mainan = Mainan::create([
                        'nama' => $tipe_mainan,
                    ]);
                }
                ItemMainan::create([
                    'item_id' => $item_new->id,
                    'mainan_id' => $mainan->id,
                    'jumlah_mainan' => $post['jumlah_mainan'][$key_tipe_mainan]
                ]);
            }
        }

        $success_ = '-item baru telah diinput-';

        if ($from === 'cart') {
            // MULAI INPUT KE CART
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->first();
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => $user->id,
                ]);
            }
            CartItem::create([
                'cart_id' => $cart->id,
                'item_id' => $item_new->id,
                'harga_t' => (string)$harga_t,
            ]);

            if ($cart->harga_total) {
                $cart->harga_total = (string)((float)$cart->harga_total + $harga_t);
            } else {
                $cart->harga_total = (string)($harga_t);
            }
            $cart->save();

            $success_ .= '-item telah diinput ke cart-';
            // END - INPUT KE CART
        }

        $feedback = [
            'success_' => $success_,
        ];

        if ($from === 'cart') {
            return redirect()->route('carts.index', $user->id)->with($feedback);
        } else {
            return redirect()->route('items.show', $item_new->id)->with($feedback);
        }
    }

    function show(Item $item) {
        // dd($item);
        // $item_photos = ItemPhoto::where('item_id', $item->id)->orderBy('photo_index')->get();
        $user = Auth::user();
        // dump($item->item_matas);
        // dd($item->item_matas[0]->mata);
        $cart = Cart::where('user_id', $user->id)->first();
        // dd($item->user->id);
        // $related_user = null;

        // if (Auth::user()) {
        //     if (Auth::user()->id == $item->user->id) {
        //         $related_user = Auth::user();
        //     }
        // }

        // $peminat_items = PeminatItem::where('item_id', $item->id)->orderBy('created_at')->get();


        $data = [
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'spk_menus' => Menu::get_spk_menus(),
            'item' => $item,
            // 'item_photos' => $item_photos,
            'cart' => $cart,
            'user' => $user,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];
        // dd($data);
        return view('items.show', $data);
    }

    function edit(Item $item) {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        // if (count($item->item_photos)) {
        //     foreach ($item->item_photos as $item_photo) {
        //         $photo = Photo::find($item_photo->photo_id);
        //         $photos->push($photo);
        //     }
        // }

        $item_photos = collect();
        $photos = collect();

        for ($i=0 ; $i < 5 ; $i++) {
            $item_photo = ItemPhoto::where('item_id', $item->id)->where('photo_index', $i)->first();

            $item_photos->push($item_photo);

            $photo = null;
            if ($item_photo) {
                $photo = Photo::find($item_photo->photo_id);
            }
            $photos->push($photo);
        }

        $arr_warna_emas = ['kuning', 'rose gold', 'putih', 'chrome'];
        $obj_kondisi = [
            ['value' => '99', 'label' => '99 - mulus'],
            ['value' => '80', 'label' => '80 - sedikit cacat/hampir tidak terlihat'],
            ['value' => '70', 'label' => '70 - cacat jelas terlihat'],
            ['value' => '60', 'label' => '60 - cacat banget'],
            ['value' => '50', 'label' => '50 - ancur / rusak'],
        ];
        $arr_range_usia = ['dewasa', 'anak', 'bayi'];
        $arr_merks = ['', 'Antam', 'UBS'];
        $arr_level_warnas = ['neutral', 'tua', 'muda'];
        $arr_opacities = ['transparent', 'half-transparent', 'non-transparent'];

        $tipe_perhiasans = TipePerhiasan::all();
        $jenis_perhiasans = JenisPerhiasan::select('id', 'nama as label', 'nama as value', 'tipe_perhiasan_id', 'tipe_perhiasan')->get();
        $caps = Cap::select('id', 'nama as label', 'nama as value', 'codename')->get();
        $warna_matas = Mata::select('warna as label', 'warna as value')->groupBy('warna')->get();
        $mainans = Mainan::select('id', 'nama as label', 'nama as value')->get();

        $data = [
            'menus' => Menu::get(),
            'route_now' => 'home',
            'profile_menus' => Menu::get_profile_menus(Auth::user()),
            'parent_route' => 'home',
            'back' => true,
            'backRoute' => 'items.show',
            'backRouteParams' => [$item->id],
            'spk_menus' => Menu::get_spk_menus(),
            'item' => $item,
            'cart' => $cart,
            'user' => $user,
            'item_photos' => $item_photos,
            'photos' => $photos,
            'arr_warna_emas' => $arr_warna_emas,
            'obj_kondisi' => $obj_kondisi,
            'arr_range_usia' => $arr_range_usia,
            'arr_merks' => $arr_merks,
            'arr_level_warnas' => $arr_level_warnas,
            'arr_opacities' => $arr_opacities,
            'tipe_perhiasans' => $tipe_perhiasans,
            'jenis_perhiasans' => $jenis_perhiasans,
            'caps' => $caps,
            'warna_matas' => $warna_matas,
            'mainans' => $mainans,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];
        // if (count($item->matas)) {
        //     $test = ItemMata::where('item_id', $item->id)->get();
        //     dump($test);
        //     dump(count($item->matas));
        //     dump('item->matas true');
        //     dump($item->item_matas);
        // }
        // dd(count($item->item_matas));
        return view('items.edit', $data);
    }

    function update(Item $item, Request $request) {
        $post = $request->post();
        // dump($from);
        // dd($post);

        $request->validate([
            'tipe_barang'=> 'required',
            'harga_t'=> 'required|numeric',
            'nama_short'=> 'required',
            'nama_long'=> 'required',
        ]);
        $harga_t = (float)$post['harga_t'] * 100;

        $tipe_perhiasan = null;
        $jenis_perhiasan = null;
        $warna_emas = null;
        $kadar = null;
        $berat = null;
        $harga_g = null;
        // $edisi = null;
        // $nampan = null;
        if ($post['tipe_barang'] === 'perhiasan') {
            $request->validate([
                'tipe_perhiasan' => 'required',
                'jenis_perhiasan' => 'required',
                'warna_emas' => 'required',
                'plat' => 'nullable|numeric',
                'kadar' => 'required|numeric',
                'berat' => 'required|numeric',
                'harga_g' => 'required|numeric',
                'nama_short' => 'required',
                'nama_long' => 'required',
                'kondisi' => 'nullable',
                'cap' => 'nullable',
                'range_usia' => 'nullable',
                'ukuran' => 'nullable|numeric',
                'merk' => 'nullable',
                'plat' => 'nullable|numeric',
                'edisi' => 'nullable',
                'nampan' => 'nullable',
                'deskripsi' => 'nullable',
                'keterangan' => 'nullable',
                'status' => 'nullable',
            ]);
            $tipe_perhiasan = $post['tipe_perhiasan'];
            $jenis_perhiasan = $post['jenis_perhiasan'];
            // CEK relasi tipe_perhiasan dengan jenis_perhiasan
            $exist_jenis_perhiasan = JenisPerhiasan::where('tipe_perhiasan', $tipe_perhiasan)->where('nama', $jenis_perhiasan)->first();
            if (!$exist_jenis_perhiasan) {
                $get_tipe_perhiasan = TipePerhiasan::where('nama', $tipe_perhiasan)->first();
                JenisPerhiasan::create([
                    'tipe_perhiasan_id' => $get_tipe_perhiasan->id,
                    'tipe_perhiasan' => $tipe_perhiasan,
                    'nama' => $jenis_perhiasan,
                ]);
            }
            // END - CEK relasi tipe_perhiasan dengan jenis_perhiasan
            $warna_emas = $post['warna_emas'];
            $kadar = (float)$post['kadar'] * 100;
            $berat = (float)$post['berat'] * 100;
            $harga_g = (float)$post['harga_g'] * 100;
            $harga_t = (float)$post['berat'] * (float)$post['harga_g'] * 100;
        }

        // VALIDASI MATA
        foreach ($post['warna_mata'] as $key_warna_mata => $warna_mata) {
            if ($warna_mata) {
                if ($post['jumlah_mata'][$key_warna_mata] == 0 || $post['jumlah_mata'][$key_warna_mata] === null) {
                    $request->validate(['error'=>'required'], ['error.required'=>'-jumlah_mata tidak sesuai-']);
                }
            }
        }

        // VALIDASI MAINAN
        foreach ($post['tipe_mainan'] as $key_tipe_mainan => $tipe_mainan) {
            if ($tipe_mainan) {
                if ($post['jumlah_mainan'][$key_tipe_mainan] === null || $post['jumlah_mainan'][$key_tipe_mainan] == 0 ) {
                    $request->validate(['error'=>'required'],['error.required'=>'-jumlah_mainan tidak sesuai-']);
                }
            }
        }

        $item->update([
            'tipe_barang' => $post['tipe_barang'],
            'tipe_perhiasan' => $tipe_perhiasan,
            'jenis_perhiasan' => $jenis_perhiasan,
            'warna_emas' => $warna_emas,
            'kadar' => $kadar,
            'berat' => $berat,
            'harga_g' => $harga_g,
            'harga_t' => $harga_t,
            'nama_short' => $post['nama_short'],
            'nama_long' => $post['nama_long'],
            'kondisi' => $post['kondisi'],
            'cap' => $post['cap'],
            'range_usia' => $post['range_usia'],
            'ukuran' => $post['ukuran'],
            'merk' => $post['merk'],
            'plat' => $post['plat'],
            // 'edisi',
            // 'nampan',
            'stock' => 1,
            // 'kode_item',
            // 'barcode',
            // 'deskripsi',
            // 'keterangan',
            // 'status',
        ]);

        // MATA
        // HAPUS item_matas sebelumnya kalau ada
        if (count($item->matas)) {
            foreach ($item->item_matas as $item_mata) {
                $item_mata->delete();
            }
        }
        foreach ($post['warna_mata'] as $key_warna_mata => $warna_mata) {
            if ($warna_mata) {
                $mata = Mata::where('warna', $warna_mata)->where('level_warna', $post['level_warna'][$key_warna_mata])->where('opacity', $post['opacity'][$key_warna_mata])->first();
                if (!$mata) {
                    $mata = Mata::create([
                        'warna' => $warna_mata,
                        'level_warna' => $post['level_warna'][$key_warna_mata],
                        'opacity' => $post['opacity'][$key_warna_mata],
                    ]);
                }
                ItemMata::create([
                    'item_id' => $item->id,
                    'mata_id' => $mata->id,
                    'jumlah_mata' => $post['jumlah_mata'][$key_warna_mata],
                ]);
            }
        }

        // MAINAN
        // HAPUS MAINAN sebelumnya kalau exist
        if (count($item->mainans)) {
            foreach ($item->item_mainans as $item_mainan) {
                $item_mainan->delete();
            }
        }
        foreach ($post['tipe_mainan'] as $key_tipe_mainan => $tipe_mainan) {
            if ($tipe_mainan) {
                $mainan = Mainan::where('nama', $tipe_mainan)->first();
                if (!$mainan) {
                    $mainan = Mainan::create([
                        'nama' => $tipe_mainan,
                    ]);
                }
                ItemMainan::create([
                    'item_id' => $item->id,
                    'mainan_id' => $mainan->id,
                    'jumlah_mainan' => $post['jumlah_mainan'][$key_tipe_mainan]
                ]);
            }
        }

        $success_ = '-finished update process-';

        $feedback = [
            'success_' => $success_,
        ];

        return redirect()->route('items.show', $item->id)->with($feedback);
    }

}
