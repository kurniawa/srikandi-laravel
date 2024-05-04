<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemPhoto;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    function add_photo(Item $item, Request $request) {
        $post = $request->post();
        $file_photo = $request->file('photo');
        // dump($post);
        // dump($photo);
        // dd($item);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_index' => 'required|numeric'
        ]);

        $success_ = "";

        $file_name = time() . "." . $file_photo->extension();
        $file_photo->storeAs('items/photos', $file_name);

        $photo = Photo::create([
            "path" => "items/photos/$file_name",
        ]);

        $item_photo = ItemPhoto::create([
            "item_id" => $item->id,
            "photo_id" => $photo->id,
            "photo_index" => $post['photo_index'],
        ]);

        $success_ .= "-ItemPhoto $item_photo->photo_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);

    }

    function delete_photo(Item $item, ItemPhoto $item_photo, Photo $photo) {
        // dump(Storage::exists($item_photo->photo_path));
        // dd($item_photo);
        $warnings_ = "";
        if (Storage::exists($photo->path)) {
            Storage::delete($photo->path);
        }
        $warnings_ .= "-File storage dihapus-";

        $photo->delete();
        // $item_photo->delete();
        $warnings_ .= "-Photo & ItemPhoto dihapus-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }


}
