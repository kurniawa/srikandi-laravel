<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function matas()
    {
        return $this->belongsToMany(Mata::class, 'item_matas', 'item_id', 'mata_id');
    }

    function item_matas()
    {
        return $this->hasMany(ItemMata::class, 'item_id', 'id');
    }

    function mainans()
    {
        return $this->belongsToMany(Mainan::class, 'item_mainans', 'item_id', 'mainan_id');
    }

    function item_mainans()
    {
        return $this->hasMany(ItemMainan::class, 'item_id', 'id');
    }

    function photos()
    {
        return $this->belongsToMany(Photo::class, 'item_photos', 'item_id', 'photo_id');
    }

    function item_photos()
    {
        return $this->hasMany(ItemPhoto::class)->orderBy('photo_index');
    }

    static function get_data_for_create_item($tipe_barang) {
        $tipe_perhiasans = TipePerhiasan::all();
        $jenis_perhiasans = JenisPerhiasan::select('id', 'nama as label', 'nama as value', 'tipe_perhiasan_id', 'tipe_perhiasan')->get();
        $caps = Cap::select('id', 'nama as label', 'nama as value', 'codename')->get();
        $label_matas = Mata::select('warna as label', 'warna as value')->groupBy('warna')->get();
        $matas = Mata::all();
        $label_mainans = Mainan::select('id', 'nama as label', 'nama as value', 'codename')->get();

        $data = [
            "tipe_barang" => $tipe_barang,
            "tipe_perhiasans" => $tipe_perhiasans,
            "jenis_perhiasans" => $jenis_perhiasans,
            "caps" => $caps,
            "label_matas" => $label_matas,
            "matas" => $matas,
            "label_mainans" => $label_mainans,
        ];

        return $data;
    }

    static function validasi_item($request) {
        $post = $request->post();
        $request->validate([
            'tipe_barang' => 'required',
            'harga_t' => 'required|numeric',
            'shortname' => 'required',
            'longname' => 'required',
        ]);
        $harga_t = (float)$post['harga_t'] * 100;

        $tipe_perhiasan = null;
        $jenis_perhiasan = null;
        $warna_emas = null;
        $kadar = null;
        $berat = null;
        $harga_g = null;
        $ongkos_g = null;
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
                'ongkos_g' => 'required|numeric',
                'shortname' => 'required',
                'longname' => 'required',
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
            $ongkos_g = (float)$post['ongkos_g'] * 100;
            $harga_g = (float)$post['harga_g'] * 100;
            $harga_t = (float)$post['berat'] * (float)$post['harga_g'] * 100;
        }

        // VALIDASI MATA
        if (isset($post['checkbox_mata'])) {
            if ($post['checkbox_mata'] == 'on') {
                foreach ($post['warna_mata'] as $key_warna_mata => $warna_mata) {
                    if ($warna_mata) {
                        if ($post['jumlah_mata'][$key_warna_mata] == 0 || $post['jumlah_mata'][$key_warna_mata] === null) {
                            $request->validate(['error' => 'required'], ['error.required' => '-jumlah_mata tidak sesuai-']);
                        }
                    }
                }
            }
        }

        // VALIDASI MAINAN
        if (isset($post['checkbox_mainan'])) {
            if ($post['checkbox_mainan'] == 'on') {
                foreach ($post['tipe_mainan'] as $key_tipe_mainan => $tipe_mainan) {
                    if ($tipe_mainan) {
                        if ($post['jumlah_mainan'][$key_tipe_mainan] === null || $post['jumlah_mainan'][$key_tipe_mainan] == 0) {
                            $request->validate(['error' => 'required'], ['error.required' => '-jumlah_mainan tidak sesuai-']);
                        }
                    }
                }
            }
        }

        $item_data = [
            'tipe_barang' => $post['tipe_barang'],
            'tipe_perhiasan' => $tipe_perhiasan,
            'jenis_perhiasan' => $jenis_perhiasan,
            'warna_emas' => $warna_emas,
            'kadar' => $kadar,
            'berat' => $berat,
            'harga_g' => $harga_g,
            'ongkos_g' => $ongkos_g,
            'harga_t' => $harga_t,
            'shortname' => $post['shortname'],
            'longname' => $post['longname'],
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
            'deskripsi' => $post['deskripsi'],
            'keterangan' => $post['keterangan'],
            // 'status',
        ];

        return $item_data;
    }

    // static function check_item_exist($candidate_new_item, $post) {
    //     $item_exists = Item::where('longname', $post['longname'])->get();
    //     if (count($item_exists)) {
    //         $data = [
    //             'menus' => Menu::get(),
    //             'profile_menus' => Menu::get_profile_menus(Auth::user()),
    //             'cart' => Cart::where('user_id', Auth::user()->id)->first(),
    //             'similiar_items' => $item_exists,
    //             'candidate_new_item' => $candidate_new_item
    //         ];

    //         return view('items.found_similiar_items', $data);
    //     }
    // }

    static function check_item_exist($candidate_new_item, $post) {
        $item_exists = Item::where('longname', $post['longname'])->get();
        // dump($item_exists);
        $data = null;
        if (count($item_exists)) {
            // DATA MATA
            $checkbox_mata = null;
            $warna_mata = [];
            if (isset($post['checkbox_mata'])) {
                if ($post['checkbox_mata'] == 'on') {
                    $warna_mata = $post['warna_mata'];
                }
            }
            // END - DATA MATA

            // DATA MAINAN
            $checkbox_mainan = null;
            $tipe_mainan = [];
            if (isset($post['checkbox_mainan'])) {
                if ($post['checkbox_mainan'] == 'on') {
                    $tipe_mainan = $post['tipe_mainan'];
                }
            }
            // END - DATA MAINAN

            $data = [
                'menus' => Menu::get(),
                'profile_menus' => Menu::get_profile_menus(Auth::user()),
                'cart' => Cart::where('user_id', Auth::user()->id)->first(),
                'similiar_items' => $item_exists,
                'candidate_new_item' => $candidate_new_item,
                'checkbox_mata' => $checkbox_mata,
                'warna_mata' => $warna_mata,
                'checkbox_mainan' => $checkbox_mainan,
                'tipe_mainan' => $tipe_mainan,
            ];
            
            // return view('items.buyback_found_similiar_items', $data);
        }

        return array($item_exists, $data);
    }

    static function store_itemMata_dan_itemMainan($post, $item_new) {
        // MATA
        if (isset($post['checkbox_mata'])) {
            if ($post['checkbox_mata'] == 'on') {
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
            }
        }

        // MAINAN
        if (isset($post['checkbox_mainan'])) {
            if ($post['checkbox_mainan'] == 'on') {
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
            }
        }
    }
}
