<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index() {
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

    function pelanggans_create() {
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

    function pelanggans_store(Request $request) {
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

    function show(User $pelanggan) {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

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
            // 'cart_item' => $cart_item,
            // 'related_user' => $related_user,
            // 'peminat_items' => $peminat_items,
        ];

        return view('pelanggans.show', $data);
    }

    function edit(User $pelanggan) {
        dd($pelanggan);
    }
}
