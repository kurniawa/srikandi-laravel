<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class APIController extends Controller
{
    function search_items(Request $request) {
        $query = $request->input('q'); // Input dari frontend (misalnya "q" untuk query)
        
        $found_items = Item::select('id', 'shortname', 'longname', 'tipe_barang', 'harga_g', 'ongkos_g', 'harga_t')
        ->where('longname', 'like', "%$query%")
        ->orderBy('longname')->limit(10)->get();
        
        $results = collect();
        foreach ($found_items as $item) {
            $photo_path = null;
            if (count($item->photos)) {
                $photo_path = $item->photos[0]->path;
            }
            $url_path = "items/$item->id/show";
            $results->push([
                'id' => $item->id,
                'tipe_barang' => $item->tipe_barang,
                'shortname' => $item->shortname,
                'longname' => $item->longname,
                'harga_g' => $item->harga_g,
                'ongkos_g' => $item->ongkos_g,
                'harga_t' => $item->harga_t,
                'photo_path' => $photo_path,
                'url_path' => $url_path,
            ]);
        }

        return response()->json($results);
    }
}
