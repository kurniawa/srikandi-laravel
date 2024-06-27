<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $pelanggans = User::where('clearance_level', 1)->orderBy('nama')->get();

        $data = [
            'menus' => Menu::get(),
            'route_now' => 'cart_items.add_photo',
            'profile_menus' => Menu::get_profile_menus($user),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            'back' => true,
            'backRoute' => 'carts.index',
            'backRouteParams' => [$user->id],
            'cart' => $cart,
            'user' => $user,
            'pelanggans' => $pelanggans,
            // 'cart_item' => $cart_item,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];

        return view('pelanggans.index', $data);
    }

    function pelanggans_create()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $pelanggans = User::where('clearance_level', 1)->orderBy('nama')->get();

        $data = [
            'menus' => Menu::get(),
            'route_now' => 'pelanggans.create',
            'profile_menus' => Menu::get_profile_menus($user),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            'back' => true,
            'backRoute' => 'pelanggans.index',
            'backRouteParams' => null,
            'cart' => $cart,
            'user' => $user,
            'pelanggans' => $pelanggans,
            // 'cart_item' => $cart_item,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];

        return view('pelanggans.create', $data);
    }

    function pelanggans_store(Request $request)
    {
        $post = $request->post();
        $success_ = "";
        // dump($user);
        // dd($post);

        $request->validate([
            "nama" => "required|string",
            "nik" => "nullable|numeric",
            "email" => "nullable|email",
        ]);

        $time = time();

        $file_profile_picture = null;
        $profile_picture_path = null;
        $filename_profile_picture = null;
        if ($request->file('profile_picture')) {
            $request->validate([
                "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
            $file_profile_picture = $request->file('profile_picture');
            $filename_profile_picture = $time . "." . $file_profile_picture->extension();
            $profile_picture_path = "pelanggans/profile_pictures/$filename_profile_picture";
        }

        $file_id_photo = null;
        $id_photo_path = null;
        $filename_id_photo = null;
        if ($request->file('id_photo')) {
            $request->validate([
                "id_photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
            $file_id_photo = $request->file('id_photo');
            $filename_id_photo = $time . "." . $file_id_photo->extension();
            $id_photo_path = "pelanggans/id_photos/$filename_id_photo";
        }

        $username = null;
        if (isset($post['username'])) {
            $username = $post["username"];
            // CEK USERNAME APAKAH SUDAH DIPAKAI
            $username_exist = User::where('username', $username)->first();
            if ($username_exist) {
                $request->validate(['error' => 'required'], ['error.required' => '-username sudah ada-']);
            }
        } else {
            $arr_nama = explode(" ", strtolower($post['nama']));
            $username = implode($arr_nama);
            // CEK USERNAME APAKAH SUDAH DIPAKAI
            $username_exist = User::where('username', $username)->first();
            $i = 2;
            while ($username_exist) {
                $username = "$username-$i";
                $username_exist = User::where('username', $username)->first();
                $i++;
            }
        }


        $password = bcrypt($username);

        // MULAI CREATE USER
        $gender = null;
        if (isset($post["gender"])) {
            $gender = $post["gender"];
        }
        $user = Auth::user();
        $pelanggan = User::create([
            "nama" => $post["nama"],
            "username" => $username,
            "password" => $password,
            "nik" => $post["nik"],
            "gender" => $gender,
            "nomor_wa" => $post["nomor_wa"],
            "alamat_baris_1" => $post["alamat_baris_1"],
            "alamat_baris_2" => $post["alamat_baris_2"],
            "alamat_baris_3" => $post["alamat_baris_3"],
            "provinsi" => $post["provinsi"],
            "kota" => $post["kota"],
            "kodepos" => $post["kodepos"],
            "profile_picture_path" => $profile_picture_path,
            "id_photo_path" => $id_photo_path,
            "created_by" => $user->username,
        ]);

        $success_ .= "-User baru dibuat-";

        if ($file_profile_picture) {
            $file_profile_picture->storeAs('pelanggans/profile_pictures', $filename_profile_picture);
            $success_ .= "-Profile Picture terupload-";
        }

        if ($file_id_photo) {
            $file_id_photo->storeAs('pelanggans/id_photos', $filename_id_photo);
            $success_ .= "-ID Photo terupload-";
        }

        $feedback = [
            "success_" => $success_
        ];

        return redirect()->route('pelanggans.show', $pelanggan->id)->with($feedback);
    }

    function show(User $pelanggan)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        list($surat_pembelians, $arr_surat_pembelian_items) = User::histori_pembelian($pelanggan);
        $data = [
            'menus' => Menu::get(),
            'route_now' => 'pelanggans.show',
            'profile_menus' => Menu::get_profile_menus($user),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            'back' => true,
            'backRoute' => 'pelanggans.index',
            'backRouteParams' => null,
            'cart' => $cart,
            'user' => $user,
            'pelanggan' => $pelanggan,
            'surat_pembelians' => $surat_pembelians,
            'arr_surat_pembelian_items' => $arr_surat_pembelian_items,
            // 'cart_item' => $cart_item,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];

        return view('pelanggans.show', $data);
    }

    function edit(User $pelanggan)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $data = [
            'menus' => Menu::get(),
            'route_now' => 'pelanggans.show',
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'pelanggan' => $pelanggan,
        ];

        return view('pelanggans.edit', $data);
    }

    function update(User $pelanggan, Request $request)
    {
        $post = $request->post();
        dump($pelanggan);
        dd($post);
        $request->validate([
            "nama" => "required|string",
            "nik" => "nullable|numeric",
            "email" => "nullable|email",
        ]);

        $success_ = "";

        $pelanggan->update([
            "nama" => $post["nama"],
            "username" => $post['username'],
            "nik" => $post["nik"],
            "gender" => $post['gender'],
            "nomor_wa" => $post["nomor_wa"],
            "alamat_baris_1" => $post["alamat_baris_1"],
            "alamat_baris_2" => $post["alamat_baris_2"],
            "alamat_baris_3" => $post["alamat_baris_3"],
            "provinsi" => $post["provinsi"],
            "kota" => $post["kota"],
            "kodepos" => $post["kodepos"],
        ]);

        $success_ .= '-data pelanggan diupdate-';
        $feedback = [
            'success_' => $success_
        ];
        return redirect()->route('pelanggans.show', $pelanggan->id)->with($feedback);
    }

    function edit_profile_picture(User $pelanggan)
    {
        // dd($pelanggan);
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        $data = [
            'menus' => Menu::get(),
            'route_now' => 'pelanggans.edit_profile_picture',
            'profile_menus' => Menu::get_profile_menus($user),
            'parent_route' => 'home',
            // 'spk_menus' => Menu::get_spk_menus(),
            'back' => true,
            'backRoute' => 'pelanggans.show',
            'backRouteParams' => [$pelanggan->id],
            'cart' => $cart,
            'user' => $user,
            'pelanggan' => $pelanggan,
            // 'cart_item' => $cart_item,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];

        return view('pelanggans.edit_profile_picture', $data);
    }

    function update_profile_picture(User $pelanggan, Request $request)
    {
        // $post = $request->post();
        $file_photo = $request->file('photo');
        // dd($file_photo);
        // dump($post);
        // dump($photo);
        // dd($cart_item);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $success_ = "";

        $time = time();
        $file_name = $time . "." . $file_photo->extension();
        $file_photo->storeAs('pelanggans/profile_pictures', $file_name);

        $pelanggan->profile_picture_path = "pelanggans/profile_pictures/$file_name";
        $pelanggan->save();

        $success_ .= "-Pelanggan->profile_picture_path $pelanggan->profile_picture_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }

    function delete_profile_picture(User $pelanggan)
    {
        $warnings_ = "";
        if (Storage::exists($pelanggan->profile_picture_path)) {
            Storage::delete($pelanggan->profile_picture_path);
        }
        $warnings_ .= "-File Profile Picture dihapus-";

        $pelanggan->profile_picture_path = null;
        $pelanggan->save();

        $warnings_ .= "-Data Pelanggan diupdate-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }

    function update_id_photo(User $pelanggan, Request $request)
    {
        // $post = $request->post();
        $file_photo = $request->file('photo');
        // dd($file_photo);
        // dump($post);
        // dump($photo);
        // dd($cart_item);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $success_ = "";

        $time = time();
        $file_name = $time . "." . $file_photo->extension();
        $file_photo->storeAs('pelanggans/id_photos', $file_name);

        $pelanggan->id_photo_path = "pelanggans/id_photos/$file_name";
        $pelanggan->save();

        $success_ .= "-Pelanggan->id_photo_path $pelanggan->id_photo_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }

    function delete_id_photo(User $pelanggan)
    {
        $warnings_ = "";
        if (Storage::exists($pelanggan->id_photo_path)) {
            Storage::delete($pelanggan->id_photo_path);
        }
        $warnings_ .= "-File ID Photo dihapus-";

        $pelanggan->id_photo_path = null;
        $pelanggan->save();

        $warnings_ .= "-Data Pelanggan diupdate-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }

    function delete(User $pelanggan)
    {
        // dd($pelanggan);
        $dangers_ = "";
        if ($pelanggan->profile_picture_path) {
            if (Storage::exists($pelanggan->profile_picture_path)) {
                Storage::delete($pelanggan->profile_picture_path);
            }
            $dangers_ .= "-ProfilePicture dihapus-";
        }

        if ($pelanggan->id_photo_path) {
            if (Storage::exists($pelanggan->id_photo_path)) {
                Storage::delete($pelanggan->id_photo_path);
            }
            $dangers_ .= "-ID-Photo dihapus-";
        }

        $pelanggan->delete();
        $dangers_ .= "-Data pelanggan dihapus-";

        $feedback = [
            "dangers_" => $dangers_
        ];

        return redirect()->route("pelanggans.index")->with($feedback);
    }
}
