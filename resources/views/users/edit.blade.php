@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div class="flex gap-2 items-center">
            <div class="inline-block rounded p-2 bg-white shadow drop-shadow">
                <div class="flex items-center text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <h1 class="ml-1 font-bold">Edit Data User</h1>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('users.update', $user->id) }}"
            class="p-5 border rounded bg-white shadow drop-shadow mt-2">
            @csrf
            <div class="">
                <label for="displayName">Nama :</label>
                <div>
                    <input type="text" id="displayName" name="nama" class="rounded text-slate-600 w-full"
                        value="{{ old('nama') ? old('nama') : $user->nama }}" required />
                </div>
            </div>

            <div class="mt-3">
                <label for="username">Username :</label>
                <div>
                    <input type="text" id="username" name="username" class="rounded text-slate-600 w-full bg-slate-200"
                        value="{{ $user->username }}" readonly />
                </div>
            </div>

            <div class="mt-3">
                <label for="gender" class="block">Gender :</label>
                <div class="flex items-center">
                    @if (old('gender'))
                        @if (old('gender') == 'pria')
                            <input type="radio" name="gender" id="pria" value='pria' checked />
                            <label for="pria" class="ml-1">pria</label>
                            <input type="radio" name="gender" id="wanita"value='wanita' class="ml-3" />
                            <label for="wanita" class="ml-1">wanita</label>
                        @elseif (old('gender') == 'wanita')
                            <input type="radio" name="gender" id="pria" value='pria' />
                            <label for="pria" class="ml-1">pria</label>
                            <input type="radio" name="gender" id="wanita"value='wanita' class="ml-3" checked />
                            <label for="wanita" class="ml-1">wanita</label>
                        @endif
                    @else
                        @if ($user->gender == 'pria')
                            <input type="radio" name="gender" id="pria" value='pria' checked />
                            <label for="pria" class="ml-1">pria</label>
                            <input type="radio" name="gender" id="wanita"value='wanita' class="ml-3" />
                            <label for="wanita" class="ml-1">wanita</label>
                        @elseif ($user->gender == 'wanita')
                            <input type="radio" name="gender" id="pria" value='pria' />
                            <label for="pria" class="ml-1">pria</label>
                            <input type="radio" name="gender" id="wanita"value='wanita' class="ml-3" checked />
                            <label for="wanita" class="ml-1">wanita</label>
                        @else
                            <input type="radio" name="gender" id="pria" value='pria' />
                            <label for="pria" class="ml-1">pria</label>
                            <input type="radio" name="gender" id="wanita"value='wanita' class="ml-3" />
                            <label for="wanita" class="ml-1">wanita</label>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <label for="nik">NIK / Nomor ID :</label>
                <div>
                    <input name="nik" type="text" id="nik" class="rounded text-slate-600 w-full"
                        value="{{ old('nik') ? old('nik') : $user->nik }}" />
                </div>
            </div>

            <div class="mt-3">
                <label for="nomor_wa">No. WA :</label>
                @if (count($user->kontaks))
                    <div>
                        <input name="nomor_wa" type="text" id="nomor_wa" class="rounded text-slate-600 w-full"
                            value="{{ old('nomor_wa') ? old('nomor_wa') : $user->kontaks[0]->nomor }}" />
                    </div>
                @else
                    <div>
                        <input name="nomor_wa" type="text" id="nomor_wa" class="rounded text-slate-600 w-full"
                            value="{{ old('nomor_wa') ? old('nomor_wa') : '' }}" />
                    </div>
                @endif
            </div>

            <div class="mt-3">
                <label for="email">Email :</label>
                <div>
                    <input type="email" id="email" name="email" class="rounded text-slate-600 w-full"
                        value="{{ old('email') ? old('email') : $user->email }}" />
                </div>
            </div>

            <label for="alamat" class="block mt-3 font-semibold">Alamat</label>
            @if (count($user->alamats))
                <div class="p-2 border-4 border-indigo-200 rounded">
                    <label for="baris-1">Baris 1 :</label>
                    <div>
                        <input type="text" id="baris-1" name="alamat_baris_1" class="rounded text-slate-600 w-full"
                            value="{{ old('alamat_baris_1') ? old('alamat_baris_1') : $user->alamats[0]->alamat_baris_1 }}" />
                    </div>
                    <label for="baris-2">Baris 2 :</label>
                    <div>
                        <input type="text" id="baris-2" name="alamat_baris_2" class="rounded text-slate-600 w-full"
                            value="{{ old('alamat_baris_2') ? old('alamat_baris_2') : $user->alamats[0]->alamat_baris_2 }}" />
                    </div>
                    <label for="baris-3">Baris 3 :</label>
                    <div>
                        <input type="text" id="baris-3" name="alamat_baris_3" class="rounded text-slate-600 w-full"
                            value="{{ old('alamat_baris_3') ? old('alamat_baris_3') : $user->alamats[0]->alamat_baris_3 }}" />
                    </div>
                    <label for="provinsi">Provinsi :</label>
                    <div>
                        <input type="text" id="provinsi" name="provinsi" class="rounded text-slate-600 w-full"
                            value="{{ old('provinsi') ? old('provinsi') : $user->alamats[0]->provinsi }}" />
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="kota">Kota :</label>
                            <input type="text" id="kota" name="kota" class="rounded text-slate-600 w-full"
                                value="{{ old('kota') ? old('kota') : $user->alamats[0]->kota }}" />
                        </div>
                        <div>
                            <label for="kodepos">Kode POS :</label>
                            <input type="text" id="kodepos" name="kodepos" class="rounded text-slate-600 w-full"
                                value="{{ old('kodepos') ? old('kodepos') : $user->alamats[0]->kodepos }}" />
                        </div>
                    </div>
                </div>
            @else
                <div class="p-2 border-4 border-indigo-200 rounded">
                    <label for="baris-1">Baris 1 :</label>
                    <div>
                        <input type="text" id="baris-1" name="alamat_baris_1" class="rounded text-slate-600 w-full"
                            value="{{ old('alamat_baris_1') ? old('alamat_baris_1') : '' }}" />
                    </div>
                    <label for="baris-2">Baris 2 :</label>
                    <div>
                        <input type="text" id="baris-2" name="alamat_baris_2" class="rounded text-slate-600 w-full"
                            value="{{ old('alamat_baris_2') ? old('alamat_baris_2') : '' }}" />
                    </div>
                    <label for="baris-3">Baris 3 :</label>
                    <div>
                        <input type="text" id="baris-3" name="alamat_baris_3" class="rounded text-slate-600 w-full"
                            value="{{ old('alamat_baris_3') ? old('alamat_baris_3') : '' }}" />
                    </div>
                    <label for="provinsi">Provinsi :</label>
                    <div>
                        <input type="text" id="provinsi" name="provinsi" class="rounded text-slate-600 w-full"
                            value="{{ old('provinsi') ? old('provinsi') : '' }}" />
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="kota">Kota :</label>
                            <input type="text" id="kota" name="kota" class="rounded text-slate-600 w-full"
                                value="{{ old('kota') ? old('kota') : '' }}" />
                        </div>
                        <div>
                            <label for="kodepos">Kode POS :</label>
                            <input type="text" id="kodepos" name="kodepos" class="rounded text-slate-600 w-full"
                                value="{{ old('kodepos') ? old('kodepos') : '' }}" />
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-5 text-center">
                <button type="submit"
                    class="loading-spinner bg-emerald-300 rounded text-white font-bold px-3 py-2 hover:bg-emerald-400 disabled:opacity-25">Konfirmasi
                    Edit</button>
            </div>
        </form>
    </main>

    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    <script src="{{ asset('js/item.js') }}"></script>
@endsection
