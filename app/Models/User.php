<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static function cari_data_pelanggan($nama, $username, $nik)
    {
        $feedback = "";
        $pelanggan = null;
        $error_cari_data_pelanggan = false;

        if (!$nama && !$username && !$nik) {
            return array($pelanggan, $error_cari_data_pelanggan, $feedback);
        }

        if ($username) {
            $pelanggan = User::where('username', $username)->first();
            if (!$pelanggan) {
                $error_cari_data_pelanggan = true;
                $feedback = "-username tidak ditemukan-";
            }
        } elseif ($nik) {
            $pelanggan = User::where('nik', $nik)->first();
            if (!$pelanggan) {
                $error_cari_data_pelanggan = true;
                $feedback = "-nik tidak ditemukan-";
            }
        } elseif ($nama) {
            $pelanggan = User::where('nama', $nama)->first();
            if (count($pelanggan) > 1) {
                $error_cari_data_pelanggan = true;
                $feedback = "-lebih dari satu pelanggan ditemukan-";
            } else {
                $pelanggan = $pelanggan[0];
            }
        }

        return array($pelanggan, $error_cari_data_pelanggan, $feedback);
    }

    static function histori_pembelian($pelanggan)
    {
        $surat_pembelians = SuratPembelian::where('pelanggan_username', $pelanggan->username)->get();
        $arr_surat_pembelian_items = array();
        foreach ($surat_pembelians as $surat_pembelian) {
            $surat_pembelian_items = SuratPembelianItem::where('surat_pembelian_id', $surat_pembelian->id)->get();
            if (count($surat_pembelian_items)) {
                $arr_surat_pembelian_items[] = $surat_pembelian_items;
            }
        }

        return array($surat_pembelians, $arr_surat_pembelian_items);
    }

    function kontaks(): HasMany
    {
        return $this->hasMany(UserKontak::class);
    }

    function alamats(): HasMany
    {
        return $this->hasMany(UserAlamat::class);
    }

    static function edit_user_validation($request, $user)
    {
        // Yang berhak mengubah data user adalah user admin
        $auth_user = Auth::user();
        if ($auth_user->clearance_level < 3) {
            $request->validate(['error' => 'required'], ['error.required' => '-You are not authorized-']);
        }
        // User admin tidak berhak mengubah data user admin lainnya dengan clearance level yang sama atau diatasnya.
        // Hanya User dengan clearance_level yang lebih tinggi yang dapat mengubah data.
        if ($auth_user->id != $user->id) {
            if ($auth_user->clearance_level <= $user->clearance_level) {
                $request->validate(['error' => 'required'], ['error.required' => '-You are not authorized-']);
            }
        }
    }
}
