<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Kadar;
use App\Models\Mainan;
use App\Models\Mata;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TestCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->info(now());
        // $this->info(now()->toISOString());
        // $example_object_push = [
        //     'user_id' => 2,
        //     'username' => 'kuruniawa',
        //     'surat_pembelian_id' => 88,
        //     'kode_accounting' => 'code',
        // ];
        // $example_object_push['cart_item_id'] = 99;
        // var_dump($example_object_push);
        // var_dump(Str::uuid());

        // foreach (\App\Models\Cap::all() as $cap) {
        //     $name = $cap->codename;
        //     if (str_contains('g-', $name)) {
        //         $name = str_replace('g-', '', $name);
        //     }
        //     $cap->name = $name;
        //     $cap->save();
        // }

        /**Benerin Kadar menjadi Desimal */

        // $kadars = Kadar::all();
        // foreach ($kadars as $kadar) {
        //     $kadar->kadar = $kadar->kadar / 100;
        //     $kadar->barcode = (string)((int)$kadar->barcode / 100);
        //     $kadar->save();
        // }

        // /**Isi barcodes pada table matas */
        // $matas = Mata::all();
        // $barcode = 1;
        // foreach ($matas as $mata) {
        //     while (str_contains($barcode, '4')) {
        //         $barcode++;
        //     }
        //     $mata->barcode = (string)$barcode;
        //     $mata->save();
        //     $barcode++;
        // }

        // /**Isi barcodes pada table mainans */
        // $mainans = Mainan::all();
        // $barcode = 1;
        // foreach ($mainans as $mainan) {
        //     while (str_contains($barcode, '4')) {$barcode++;}
        //     $mainan->barcode = (string)$barcode;
        //     $mainan->save();
        //     $barcode++;
        // }

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

    }
}
