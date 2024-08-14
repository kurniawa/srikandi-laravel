@extends('layouts.main')
@section('content')
    <main class="p-2 text-slate-600">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div class="inline-block rounded p-2 bg-white shadow drop-shadow">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>

                <h3 class="ml-1 font-bold">+ User Baru</h3>
            </div>
        </div>

        <form method="POST" action="{{ route('users.store') }}"
            class="p-5 border rounded bg-white shadow drop-shadow mt-2">
            @csrf
            <div class="">
                <label for="displayName">Nama :</label>
                <input type="text" id="displayName" name="nama" placeholder="Aldebaran Al Fahri"
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('nama') ? old('nama') : '' }}" required />
            </div>

            <div class="mt-3">
                <label for="username">Username :</label>
                <input type="text" id="username" name="username" placeholder="aldebaran"
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('username') ? old('username') : '' }}" />
            </div>
            <div class="italic text-xs">(akan otomatis dibuatkan, apabila tidak diisi)</div>

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
                        <input type="radio" name="gender" id="pria" value='pria' />
                        <label for="pria" class="ml-1">pria</label>
                        <input type="radio" name="gender" id="wanita"value='wanita' class="ml-3" />
                        <label for="wanita" class="ml-1">wanita</label>
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <label for="nik">NIK / Nomor ID :</label>
                <input name="nik" type="text" id="nik" placeholder="320101 . . ."
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('nik') ? old('nik') : '' }}" />
            </div>

            <div class="mt-3">
                <label for="nomor_wa">No. WA :</label>
                <input name="nomor_wa" type="text" id="nomor_wa" placeholder="0889 . . ."
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('nomor_wa') ? old('nomor_wa') : '' }}" />
            </div>

            <div class="mt-3">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="nagita@slavina.com"
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('email') ? old('email') : '' }}" />
            </div>

            <label for="alamat" class="block mt-3 font-semibold">Alamat</label>
            <div class="p-2 border-4 border-indigo-200 rounded">
                <label for="baris-1">Baris 1 :</label>
                <input type="text" id="baris-1" name="alamat_baris_1"
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('alamat_baris_1') ? old('alamat_baris_1') : '' }}" />
                <label for="baris-2">Baris 2 :</label>
                <input type="text" id="baris-2" name="alamat_baris_2"
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('alamat_baris_2') ? old('alamat_baris_2') : '' }}" />
                <label for="baris-3">Baris 3 :</label>
                <input type="text" id="baris-3" name="alamat_baris_3"
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('alamat_baris_3') ? old('alamat_baris_3') : '' }}" />
                <label for="provinsi">Provinsi :</label>
                <input type="text" id="provinsi" name="provinsi"
                    class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                    value="{{ old('provinsi') ? old('provinsi') : '' }}" />
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label for="kota">Kota :</label>
                        <input type="text" id="kota" name="kota"
                            class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                            value="{{ old('kota') ? old('kota') : '' }}" />
                    </div>
                    <div>
                        <label for="kodepos">Kode POS :</label>
                        <input type="text" id="kodepos" name="kodepos"
                            class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                            value="{{ old('kodepos') ? old('kodepos') : '' }}" />
                    </div>
                </div>
            </div>

            {{-- PROFILE PICTURE --}}
            <!-- Foto Profile -->
            <div id="div-preview-profile-photo" class="mt-3 hidden">
                <div class="flex justify-end">
                    <button type="button" class="bg-rose-300 text-white rounded-full p-1"
                        onclick="removeImage('input-profile-photo', 'div-preview-profile-photo', 'preview-profile-photo', 'label-input-profile-photo')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-center py-3 border-2 border-rose-300 rounded">
                    <div class="w-2/3">
                        <img src="" alt="avatar_foto" id="preview-profile-photo" />
                    </div>
                </div>
            </div>

            <div id="label-input-profile-photo" class="flex justify-center">
                <label for="input-profile-photo" class="border-2 border-rose-300 rounded p-2 mt-2 hover:cursor-pointer">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>

                        <div class="ml-1">Foto Profile</div>
                    </div>
                </label>
            </div>
            <input id="input-profile-photo" name="profile_picture" type="file" accept=".jpg, .jpeg, .png"
                onchange="previewImage(this.files[0], 'div-preview-profile-photo', 'preview-profile-photo', 'label-input-profile-photo')"
                class="hidden" />

            {{-- ID PICTURE / PHOTO --}}

            <div id="div-preview-id-photo" class="mt-3 hidden">
                <div class="flex justify-end">
                    <button type="button" class="bg-rose-300 text-white rounded-full p-1"
                        onclick="removeImage('input-id-photo', 'div-preview-id-photo', 'preview-id-photo', 'label-input-id-photo')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-center py-3 border-2 border-indigo-300 rounded">
                    <div class="w-2/3">
                        <img src="" alt="avatar_foto" id="preview-id-photo" />
                    </div>
                </div>
            </div>

            <div id="label-input-id-photo" class="flex justify-center">
                <label for="input-id-photo" class="border-2 border-indigo-300 rounded p-2 mt-2 hover:cursor-pointer">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>

                        <div class="ml-1">Foto ID</div>
                    </div>
                </label>
            </div>
            <input id="input-id-photo" name="id_photo" type="file" accept=".jpg, .jpeg, .png"
                onchange="previewImage(this.files[0], 'div-preview-id-photo', 'preview-id-photo', 'label-input-id-photo')"
                class="hidden" />

            <div class="mt-5 text-center">
                <button type="submit"
                    class="loading-spinner bg-emerald-300 rounded text-white font-bold px-3 py-2 hover:bg-emerald-400 disabled:opacity-25">+Tambah
                    User</button>
            </div>
        </form>

    </main>

    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    <script src="{{ asset('js/item.js') }}"></script>
@endsection
