<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemPhoto;
use App\Models\Photo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "230",
                "ongkos_g" => "2000000",
                "harga_g" => "55000088",
                "harga_t" => "126500202",
                "shortname" => "Anting Desi 37.5% 2.3gr",
                "longname" => "Anting Desi 37.5% 2.3gr c:375 ru:dewasa zu:9 m.p-lw.n-opac.t:1",
                "kondisi" => "9",
                "cap" => "375",
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "stock" => "1",
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "status" => null,
            ],
            [
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "100",
                "ongkos_g" => "2000000",
                "harga_g" => "60000000",
                "harga_t" => "60000000",
                "shortname" => "Anting Desi Polos 37.5% 1gr",
                "longname" => "Anting Desi Polos 37.5% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "stock" => "1",
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "status" => null,
                "photo_id" => "1",
                "photo_index" => "1",
            ],
            [
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "7000",
                "berat" => "100",
                "ongkos_g" => "2000000",
                "harga_g" => "60000000",
                "harga_t" => "60000000",
                "shortname" => "Anting Desi Polos 70% 1gr",
                "longname" => "Anting Desi Polos 70% 1gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "stock" => "1",
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "status" => null,
                "photo_id" => "1",
                "photo_index" => "1",
            ],
            [
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Cincin",
                "jenis_perhiasan" => "1/2 Rantai",
                "warna_emas" => "kuning",
                "kadar" => "9500",
                "berat" => "300",
                "ongkos_g" => "5000000",
                "harga_g" => "270000000",
                "harga_t" => "270000000",
                "shortname" => "Cincin 1/2 Rantai (mantap) 95% 3gr",
                "longname" => "Cincin 1/2 Rantai (mantap) 95% 3gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "stock" => "1",
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => "mantap",
                "keterangan" => null,
                "status" => null,
            ],
            [
                "tipe_barang" => "perhiasan",
                "tipe_perhiasan" => "Anting",
                "jenis_perhiasan" => "Desi Polos",
                "warna_emas" => "kuning",
                "kadar" => "3750",
                "berat" => "200",
                "ongkos_g" => "2000000",
                "harga_g" => "100000000",
                "harga_t" => "100000000",
                "shortname" => "Anting Desi Polos 37.5% 2gr",
                "longname" => "Anting Desi Polos 37.5% 2gr ru:dewasa zu:9",
                "kondisi" => "9",
                "cap" => null,
                "range_usia" => "dewasa",
                "ukuran" => null,
                "merk" => null,
                "plat" => null,
                "edisi" => null,
                "nampan" => null,
                "stock" => "1",
                "kode_item" => null,
                "barcode" => null,
                "deskripsi" => null,
                "keterangan" => null,
                "status" => null,
                "photo_id" => "1",
                "photo_index" => "1",
            ],
        ];

        $photos = [
            ['path' => 'items/photos/2-1719990217.jpg'],
        ];

        // 2-1719990217.jpg
        foreach ($photos as $photo) {
            Photo::create([
                "path" => $photo['path']
            ]);
        }
        foreach ($items as $item) {
            $new_item = Item::create([
                "tipe_barang" => $item['tipe_barang'],
                "tipe_perhiasan" => $item['tipe_perhiasan'],
                "jenis_perhiasan" => $item['jenis_perhiasan'],
                "warna_emas" => $item['warna_emas'],
                "kadar" => $item['kadar'],
                "berat" => $item['berat'],
                "ongkos_g" => $item['ongkos_g'],
                "harga_g" => $item['harga_g'],
                "harga_t" => $item['harga_t'],
                "shortname" => $item['shortname'],
                "longname" => $item['longname'],
                "kondisi" => $item['kondisi'],
                "cap" => $item['cap'],
                "range_usia" => $item['range_usia'],
                "ukuran" => $item['ukuran'],
                "merk" => $item['merk'],
                "plat" => $item['plat'],
                "edisi" => $item['edisi'],
                "nampan" => $item['nampan'],
                "stock" => $item['stock'],
                "kode_item" => $item['kode_item'],
                "barcode" => $item['barcode'],
                "deskripsi" => $item['deskripsi'],
                "keterangan" => $item['keterangan'],
                "status" => $item['status'],
            ]);

            if (isset($item['photo_id'])) {
                ItemPhoto::create([
                    "item_id" => $new_item->id,
                    "photo_id" => $item['photo_id'],
                    "photo_index" => $item['photo_index'],
                ]);
            }
        }
    }
}
