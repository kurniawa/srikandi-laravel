<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratPembelianItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function create_surat_pembelian_item($surat_pembelian, $cart_item_id, $kode_accounting)
    {
        // dd($cart_item_id);
        $cart_item = CartItem::find($cart_item_id);
        // dd($cart_item);
        $stock = $cart_item->item->stock - 1;

        if ($stock <= 0) {
            $cart_item->item->stock = 0;
            $cart_item->item->save();
        }

        $kondisi_bb = null;
        $berat_susut = null;
        $berat_bb = null;
        $potongan_susut = null;
        $potongan_ongkos = null;
        $potongan_tambahan = null;
        $persentase_potongan_tambahan = null;
        $total_potongan = null;
        $total_bb = null;
        $status_bb = null;
        $keterangan_lain = null;
        if ($cart_item->item->tipe_barang === 'perhiasan') {
            $kondisi_bb = 'sama';
            $berat_susut = 'tidak';
            $berat_bb = $cart_item->item->berat;
            $potongan_susut = 0;
            $potongan_ongkos = ($cart_item->ongkos_g * $cart_item->item->berat) / 100;
            $potongan_tambahan = 0;
            $persentase_potongan_tambahan = 0;
            $total_potongan = $potongan_ongkos;
            $total_bb = $cart_item->harga_total - $potongan_ongkos;
            $status_bb = 'ada';
        } elseif ($cart_item->item->tipe_barang === 'LM') {
            $kondisi_bb = 'sama';
            $status_bb = 'ada';
        }
        /**
         * ITEM PHOTO
         */
        $photo_path = null;
        $time = time();
        $user = Auth::user();
        if ($cart_item->photo_path) {
            if (Storage::exists($cart_item->photo_path)) {
                $exploded_path = explode(".", $cart_item->photo_path);
                $file_extension = $exploded_path[count($exploded_path) - 1];
                $filename = "$user->id-$time.$file_extension";
                $photo_path = "surat_pembelian_items/photos/$filename";
                while (Storage::exists($photo_path)) {
                    $time++;
                    $filename = "$user->id-$time.$file_extension";
                    $photo_path = "surat_pembelian_items/photos/$filename";
                }
                Storage::move($cart_item->photo_path, $photo_path);
            }
        } else {
            if (count($cart_item->item->item_photos)) {
                if (Storage::exists($cart_item->item->item_photos[0]->photo->path)) {
                    $exploded_path = explode(".", $cart_item->item->item_photos[0]->photo->path);
                    $file_extension = $exploded_path[count($exploded_path) - 1];
                    $filename = "$user->id-$time.$file_extension";
                    $photo_path = "surat_pembelian_items/photos/$filename";
                    while (Storage::exists($photo_path)) {
                        $time++;
                        $filename = "$user->id-$time.$file_extension";
                        $photo_path = "surat_pembelian_items/photos/$filename";
                    }
                    Storage::copy($cart_item->item->item_photos[0]->photo->path, $photo_path);
                }
            }
        }
        // if ($cart_item->item->tipe_barang === 'perhiasan' || $cart_item->item->tipe_barang === 'LM') {
        //     $item_photo = $cart_item->item->photo_utama[0]->path;
        // }
        /**
         * END - ITEM PHOTO
         */
        $surat_pembelian_item = SuratPembelianItem::create([
            'surat_pembelian_id' => $surat_pembelian->id,
            'item_id' => $cart_item->item->id,
            'tipe_barang' => $cart_item->item->tipe_barang,
            'tipe_perhiasan' => $cart_item->item->tipe_perhiasan,
            'jenis_perhiasan' => $cart_item->item->jenis_perhiasan,
            'warna_emas' => $cart_item->item->warna_emas,
            'kadar' => $cart_item->item->kadar,
            'berat' => $cart_item->item->berat,
            'ongkos_g' => $cart_item->item->ongkos_g,
            'harga_g' => $cart_item->item->harga_g,
            'harga_t' => $cart_item->item->harga_t,
            'shortname' => $cart_item->item->shortname,
            'longname' => $cart_item->item->longname,
            'kondisi' => $cart_item->item->kondisi,
            'cap' => $cart_item->item->cap,
            'range_usia' => $cart_item->item->range_usia,
            'ukuran' => $cart_item->item->ukuran,
            'merk' => $cart_item->item->merk,
            'plat' => $cart_item->item->plat,
            'edisi' => $cart_item->item->edisi,
            'nampan' => $cart_item->item->nampan,
            'kode_item' => $cart_item->item->kode_item,
            'barcode' => $cart_item->item->barcode,
            'deskripsi' => $cart_item->item->deskripsi,
            'keterangan' => $cart_item->item->keterangan,
            'photo_path' => $photo_path,
            'jumlah' => $cart_item->jumlah,
            // Data penjualan udah diisi juga sebagian, selama item memang bisa BB
            'status_bb' => $status_bb,
            'kondisi_bb' => $kondisi_bb,
            'berat_susut' => $berat_susut,
            'berat_bb' => $berat_bb,
            'potongan_susut' => $potongan_susut,
            'potongan_ongkos' => $potongan_ongkos,
            'potongan_tambahan' => $potongan_tambahan,
            'persentase_potongan_tambahan' => $persentase_potongan_tambahan,
            'total_potongan' => $total_potongan,
            'total_bb' => $total_bb,
            'keterangan_lain' => $keterangan_lain,
        ]);

        // ACCOUNTING
        $kategori_2 = 'Penjualan Perhiasan';
        if ($surat_pembelian_item->tipe_barang == "LM") {
            $kategori_2 = 'Penjualan LM';
        }
        Accounting::create([
            'kode_accounting' => $kode_accounting,
            'surat_pembelian_id' => $surat_pembelian->id,
            'surat_pembelian_item_id' => $surat_pembelian_item->id,
            'nama_barang' => $surat_pembelian_item->longname,
            'kadar' => $surat_pembelian_item->kadar,
            'berat' => $surat_pembelian_item->berat,
            'user_id' => $user->id,
            'tipe' => 'pemasukan',
            'kategori' => 'Penjualan Produk',
            'kategori_2' => $kategori_2,
            'deskripsi' => null,
            'jumlah' => $surat_pembelian_item->harga_t,
        ]);
        // END - ACCOUNTING

        // $cart_item->delete();

        return $surat_pembelian_item;
    }

    function item()
    {
        return $this->hasOne(Item::class, "id", "item_id");
    }

    static function penetapan_data_bb($item) {
        $data_bb = [
            "kondisi_bb" => null,
            "berat_susut" => null,
            "berat_bb" => null,
            "potongan_susut" => null,
            "potongan_ongkos" => null,
            "potongan_tambahan" => null,
            "persentase_potongan_tambahan" => null,
            "total_potongan" => null,
            "total_bb" => null,
            "status_bb" => null,
            "keterangan_lain" => null,
        ];
        if ($item->tipe_barang === 'perhiasan') {
            $data_bb["kondisi_bb"] = 'sama';
            $data_bb["berat_susut"] = 'tidak';
            $data_bb["berat_bb"] = $item->berat;
            $data_bb["potongan_susut"] = 0;
            $data_bb["potongan_ongkos"] = ((float)$item->ongkos_g * (float)$item->berat) / 100;
            $data_bb["potongan_tambahan"] = 0;
            $data_bb["persentase_potongan_tambahan"] = 0;
            $data_bb["total_potongan"] = $data_bb["potongan_ongkos"];
            $data_bb["total_bb"] = (float)$item->harga_t - $data_bb["potongan_ongkos"];
            $data_bb["status_bb"] = 'ada';
        } elseif ($item->tipe_barang === 'LM') {
            $data_bb["kondisi_bb"] = 'sama';
            $data_bb["status_bb"] = 'ada';
        }

        return $data_bb;
    }

    static function buyback_penetapan_data_bb($item) {
        $data_bb = [
            "kondisi_bb" => null,
            "berat_susut" => null,
            "berat_bb" => null,
            "potongan_susut" => null,
            "potongan_ongkos" => null,
            "potongan_tambahan" => null,
            "persentase_potongan_tambahan" => null,
            "total_potongan" => null,
            "total_bb" => null,
            "status_bb" => "buyback",
            "keterangan_lain" => null,
        ];
        return $data_bb;
    }

    static function buyback_photo_path($item, $time_key) {
        $photo_path = null;
        $user = Auth::user();
        $time = $time_key;
        if (count($item->item_photos)) {
            if (Storage::exists($item->item_photos[0]->photo->path)) {
                $exploded_path = explode(".", $item->item_photos[0]->photo->path);
                $file_extension = $exploded_path[count($exploded_path) - 1];
                $filename = "$user->id-$time.$file_extension";
                $photo_path = "surat_pembelian_items/photos/$filename";
                while (Storage::exists($photo_path)) {
                    $time++;
                    $filename = "$user->id-$time.$file_extension";
                    $photo_path = "surat_pembelian_items/photos/$filename";
                }
                Storage::copy($item->item_photos[0]->photo->path, $photo_path);
            }
        }

        return $photo_path;
    }

    static function buyback_create_spi($surat_pembelian, $item, $time_key) {
        $data_bb = self::buyback_penetapan_data_bb($item);
        $photo_path = self::buyback_photo_path($item, $time_key);
        $keterangan_lain = null;
        $jumlah = 1;
        if (isset($item->jumlah)) {
            $jumlah = $item->jumlah;
        }
        $surat_pembelian_item = SuratPembelianItem::create([
            'surat_pembelian_id' => $surat_pembelian->id,
            'item_id' => $item->id,
            'tipe_barang' => $item->tipe_barang,
            'tipe_perhiasan' => $item->tipe_perhiasan,
            'jenis_perhiasan' => $item->jenis_perhiasan,
            'warna_emas' => $item->warna_emas,
            'kadar' => $item->kadar,
            'berat' => $item->berat,
            'ongkos_g' => $item->ongkos_g,
            'harga_g' => $item->harga_g,
            'harga_t' => $item->harga_t,
            'shortname' => $item->shortname,
            'longname' => $item->longname,
            'kondisi' => $item->kondisi,
            'cap' => $item->cap,
            'range_usia' => $item->range_usia,
            'ukuran' => $item->ukuran,
            'merk' => $item->merk,
            'plat' => $item->plat,
            'edisi' => $item->edisi,
            'nampan' => $item->nampan,
            'kode_item' => $item->kode_item,
            'barcode' => $item->barcode,
            'deskripsi' => $item->deskripsi,
            'keterangan' => $item->keterangan,
            'photo_path' => $photo_path,
            'jumlah' => $jumlah,
            // Data penjualan udah diisi juga sebagian, selama item memang bisa BB
            'status_bb' => $data_bb["status_bb"],
            'kondisi_bb' => $data_bb["kondisi_bb"],
            'berat_susut' => $data_bb["berat_susut"],
            'berat_bb' => $data_bb["berat_bb"],
            'potongan_susut' => $data_bb["potongan_susut"],
            'potongan_ongkos' => $data_bb["potongan_ongkos"],
            'potongan_tambahan' => $data_bb["potongan_tambahan"],
            'persentase_potongan_tambahan' => $data_bb["persentase_potongan_tambahan"],
            'total_potongan' => $data_bb["total_potongan"],
            'total_bb' => $data_bb["total_bb"],
            'keterangan_lain' => $keterangan_lain,
            'tanggal_buyback' => date("Y-m-d H:i:s", $time_key),
        ]);

        return $surat_pembelian_item;
    }
}
