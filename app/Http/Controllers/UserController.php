<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Menu;
use App\Models\User;
use App\Models\UserAlamat;
use App\Models\UserKontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $users = User::where('clearance_level', '>=', 3)->orderBy('nama')->get();

        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'users' => $users,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('users.index', $data);
    }

    function users_create()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $users = User::where('clearance_level', '>=', 3)->orderBy('nama')->get();

        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'users' => $users,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('users.create', $data);
    }

    function users_store(Request $request)
    {
        $post = $request->post();
        $success_ = "";
        // dump($user);
        // dd($post);

        $request->validate([
            "nama" => "required|string",
            "username" => "nullable|string",
            "nik" => "nullable|numeric",
            "nomor_wa" => "nullable|numeric",
            "email" => "nullable|email",
        ]);

        $time = time();

        $file_profile_picture = null;
        $profile_picture_path = null;
        $filename_profile_picture = null;
        if ($request->file('profile_picture')) {
            $request->validate([
                "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120"
            ]);
            $file_profile_picture = $request->file('profile_picture');
            $filename_profile_picture = $time . "." . $file_profile_picture->extension();
            $profile_picture_path = "users/profile_pictures/$filename_profile_picture";
        }

        $file_id_photo = null;
        $id_photo_path = null;
        $filename_id_photo = null;
        if ($request->file('id_photo')) {
            $request->validate([
                "id_photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120"
            ]);
            $file_id_photo = $request->file('id_photo');
            $filename_id_photo = $time . "." . $file_id_photo->extension();
            $id_photo_path = "users/id_photos/$filename_id_photo";
        }

        $username = null;
        if (isset($post['username'])) {
            $request->validate([
                'username' => 'required|alpha_dash|unique:users,username'
            ]);
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

        $nik = null;
        if (isset($post["nik"])) {
            $nik = $post["nik"];
        }

        $nomor_wa = null;
        if (isset($post["nomor_wa"])) {
            $nomor_wa = $post["nomor_wa"];
        }
        $role = "Admin";
        $clearance_level = 3;

        $user = Auth::user();
        $user = User::create([
            "nama" => $post["nama"],
            "username" => $username,
            "nik" => $nik,
            "nomor_wa" => $nomor_wa,
            "password" => $password,
            "role" => $role,
            "clearance_level" => $clearance_level,
            "gender" => $gender,
            "profile_picture_path" => $profile_picture_path,
            "id_photo_path" => $id_photo_path,
            "created_by" => $user->username,
        ]);

        $success_ .= "-User baru dibuat-";

        if ($file_profile_picture) {
            $file_profile_picture->storeAs('users/profile_pictures', $user->id . "-" . $filename_profile_picture);
            $success_ .= "-Profile Picture terupload-";
        }

        if ($file_id_photo) {
            $file_id_photo->storeAs('users/id_photos', $user->id . "-" . $filename_id_photo);
            $success_ .= "-ID Photo terupload-";
        }

        UserAlamat::create_new_alamat($post, $user, false);

        UserKontak::create_new_kontak($post, $user, false);

        $feedback = [
            "success_" => $success_
        ];

        return redirect()->route('users.show', $user->id)->with($feedback);
    }

    function show(User $user_this)
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }
        list($surat_pembelians, $arr_surat_pembelian_items) = User::histori_pembelian($user);
        // dd($user->kontaks);
        // dd($user->alamats);
        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'user_this' => $user_this,
            'surat_pembelians' => $surat_pembelians,
            'arr_surat_pembelian_items' => $arr_surat_pembelian_items,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];
        // dd($user_this);
        return view('users.show', $data);
    }

    function edit(User $user_this)
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }
        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'user_this' => $user_this,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('users.edit', $data);
    }

    function update(User $user_this, Request $request)
    {
        $post = $request->post();
        // dump($user);
        // dd($post);
        $request->validate([
            "nama" => "required|string",
            "nik" => "nullable|numeric",
            "email" => "nullable|email",
        ]);

        User::edit_user_validation($request, $user_this);

        $success_ = "";

        $gender = null;
        if (isset($post['gender'])) {
            $gender = $post['gender'];
        }

        $user_this->update([
            "nama" => $post["nama"],
            // "username" => $post['username'], // Username tidak boleh sembarang diganti
            "nik" => $post["nik"],
            "gender" => $gender,

        ]);

        $success_ .= '-data user diupdate-';

        UserAlamat::update_alamat($post, $user_this);
        UserKontak::update_kontak($post, $user_this);

        $feedback = [
            'success_' => $success_
        ];
        return redirect()->route('users.show', $user_this->id)->with($feedback);
    }

    function edit_profile_picture(User $user_this)
    {
        // dd($user);
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }

        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'user_this' => $user_this,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('users.edit_profile_picture', $data);
    }

    function update_profile_picture(User $user_this, Request $request)
    {
        // $post = $request->post();
        $file_photo = $request->file('photo');
        // dd($file_photo);
        // dump($post);
        // dump($photo);
        // dd($cart_item);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $success_ = "";

        $time = time();
        $file_name = $user_this->id . "-" . $time . "." . $file_photo->extension();
        $file_photo->storeAs('users/profile_pictures', $file_name);

        $user_this->profile_picture_path = "users/profile_pictures/$file_name";
        $user_this->save();

        $success_ .= "-user->profile_picture_path $user_this->profile_picture_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }

    function delete_profile_picture(User $user_this)
    {
        $warnings_ = "";
        if (Storage::exists($user_this->profile_picture_path)) {
            Storage::delete($user_this->profile_picture_path);
        }
        $warnings_ .= "-File Profile Picture dihapus-";

        $user_this->profile_picture_path = null;
        $user_this->save();

        $warnings_ .= "-Data user diupdate-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }

    function update_id_photo(User $user_this, Request $request)
    {
        // $post = $request->post();
        $file_photo = $request->file('photo');
        // dd($file_photo);
        // dump($post);
        // dump($photo);
        // dd($cart_item);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $success_ = "";

        $time = time();
        $file_name = $user_this->id . "-" . $time . "." . $file_photo->extension();
        $file_photo->storeAs('users/id_photos', $file_name);

        $user_this->id_photo_path = "users/id_photos/$file_name";
        $user_this->save();

        $success_ .= "-user->id_photo_path $user_this->id_photo_path created-";

        $feedback = [
            "success_" => $success_
        ];

        return back()->with($feedback);
    }

    function delete_id_photo(User $user_this)
    {
        $warnings_ = "";
        if (Storage::exists($user_this->id_photo_path)) {
            Storage::delete($user_this->id_photo_path);
        }
        $warnings_ .= "-File ID Photo dihapus-";

        $user_this->id_photo_path = null;
        $user_this->save();

        $warnings_ .= "-Data user diupdate-";

        $feedback = [
            "warnings_" => $warnings_,
        ];

        return back()->with($feedback);
    }

    function delete(User $user_this, Request $request)
    {
        // dd($user_this);
        User::delete_user_validation($request, $user_this);

        $dangers_ = "";
        if ($user_this->profile_picture_path) {
            if (Storage::exists($user_this->profile_picture_path)) {
                Storage::delete($user_this->profile_picture_path);
            }
            $dangers_ .= "-ProfilePicture dihapus-";
        }

        if ($user_this->id_photo_path) {
            if (Storage::exists($user_this->id_photo_path)) {
                Storage::delete($user_this->id_photo_path);
            }
            $dangers_ .= "-ID-Photo dihapus-";
        }

        $user_this->delete();
        $dangers_ .= "-Data user dihapus-";

        $feedback = [
            "dangers_" => $dangers_
        ];

        return redirect()->route("users.index")->with($feedback);
    }

    function change_password(User $user_this)
    {
        $user = Auth::user();
        $cart = null;
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
        }
        $data = [
            'menus' => Menu::get(),
            'profile_menus' => Menu::get_profile_menus($user),
            'cart' => $cart,
            'user' => $user,
            'user_this' => $user_this,
            'all_items_x_photos' => Item::get_all_item_x_photos(null, null),
        ];

        return view('users.change_password', $data);
    }

    function update_password(User $user_this, Request $request)
    {
        // $post = $request->post();
        // dump($post);
        // dd($user_this);
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);


        #Match The Old Password
        // dump($user_this);
        // dump($user_this->password);
        // dd(Hash::check($request->old_password, $user_this->password));
        if (!Hash::check($request->old_password, $user_this->password)) {
            return back()->with("errors_", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId($user_this->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('users.show', $user_this->id)->with("success_", "Password changed successfully!");
    }
}
