<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SuratPembelianItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function create_surat_pembelian_item_and_cashflow($surat_pembelian, $cart_item_id) {
        // dd($cart_item_id);
        $cart_item = CartItem::find($cart_item_id);
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
        $item_photo = null;
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
            'nama_short' => $cart_item->item->nama_short,
            'nama_long' => $cart_item->item->nama_long,
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
            'item_photo' => $item_photo,
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

        if ($cart_item->photo_path) {
            SuratPembelianItemPhoto::create([
                'surat_pembelian_item_id' => $surat_pembelian_item->id,
                'path' => $cart_item->photo_path,
            ]);
        }

        $cart_item->delete();
    }

    function item() {
        return $this->hasOne(Item::class, "id", "item_id");
    }

    function photos() {
        return $this->hasMany(SuratPembelianItemPhoto::class);
    }
}
