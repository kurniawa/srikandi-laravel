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
                    <h1 class="ml-1 font-bold">Detail User</h1>
                </div>
            </div>
        </div>

        @if ($user->profile_picture_path)
            <div class="flex justify-center mt-5">
                <div class="bg-slate-50 shadow drop-shadow text-slate-400 w-3/4 rounded-full overflow-hidden">
                    <img src="{{ asset('storage/' . $user->profile_picture_path) }}" alt="">
                </div>
            </div>
            <form action="{{ route('users.delete_profile_picture', $user->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin hapus Profile Picture ini?')" class="mt-2">
                @csrf
                <div class="flex justify-center">
                    <button class="loading-spinner bg-rose-300 font-bold text-white p-1 rounded-lg">Hapus Profile
                        Picture</button>
                </div>
            </form>
        @else
            <div class="flex justify-center mt-5">
                <div class="bg-slate-50 shadow drop-shadow text-slate-400 w-3/4 rounded-full overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-full">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            </div>
            <form method="POST" action="{{ route('users.update_profile_picture', $user->id) }}" class="mb-1"
                enctype="multipart/form-data">
                @csrf
                {{-- PROFILE PICTURE --}}
                <!-- Foto Profile -->
                <div id="div-preview-profile-photo" class="mt-3 hidden">
                    <div class="flex justify-end">
                        <button type="button" class="loading-spinner bg-rose-300 text-white rounded-full p-1"
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

                    <div class="mt-3 text-center">
                        <button type="submit"
                            class="loading-spinner bg-emerald-300 text-white font-bold rounded-lg p-2">Update Profile
                            Picture</button>
                    </div>
                </div>

                <div id="label-input-profile-photo" class="flex justify-center">
                    <label for="input-profile-photo"
                        class="border-2 border-rose-300 rounded p-2 mt-2 hover:cursor-pointer text-slate-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>

                            <div class="ml-1 font-bold">Foto Profile</div>
                        </div>
                    </label>
                </div>
                <input id="input-profile-photo" name="photo" type="file" accept=".jpg, .jpeg, .png"
                    onchange="previewImage(this.files[0], 'div-preview-profile-photo', 'preview-profile-photo', 'label-input-profile-photo')"
                    class="hidden" />

            </form>
        @endif
        {{-- <div class="flex justify-end">
        <a href="{{ route("users.edit_profile_picture", [$user->id]) }}" class="text-slate-400" >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </a>
    </div> --}}

        <div class="mx-2">
            <div class="mt-5">
                <label class="text-slate-500">Nama :</label>
                <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $user->nama }}</div>
            </div>

            <div class="mt-3">
                <label class="text-slate-500">Username :</label>
                <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $user->username }}</div>
            </div>

            <div class="mt-3">
                <label class="text-slate-500">Gender :</label>
                @if ($user->gender)
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $user->gender }}</div>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mt-3">
                <label class="text-slate-500">NIK / Nomor ID :</label>
                @if ($user->nik)
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $user->nik }}</div>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mt-3">
                <label class="text-slate-500">No. WA :</label>
                @if (count($user->kontaks))
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">
                        {{ $user->kontaks[0]->nomor }}
                    </div>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mt-3">
                <label class="text-slate-500">Email :</label>
                @if ($user->email)
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">{{ $user->email }}</div>
                @else
                    <span>-</span>
                @endif
            </div>

            <div class="mt-3">
                <label class="text-slate-500">Alamat :</label>
                @if (count($user->alamats))
                    <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">
                        <div>{{ $user->alamats[0]->alamat_baris_1 }}</div>
                        <div>{{ $user->alamats[0]->alamat_baris_2 }}</div>
                        <div>{{ $user->alamats[0]->alamat_baris_3 }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <div>
                            <label class="text-slate-500">Provinsi :</label>
                            @if ($user->alamats[0]->provinsi)
                                <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">
                                    {{ $user->alamats[0]->provinsi }}</div>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div>
                            <label class="text-slate-500">Kota :</label>
                            @if ($user->alamats[0]->kota)
                                <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">
                                    {{ $user->alamats[0]->kota }}
                                </div>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div>
                            <label class="text-slate-500">Kode POS :</label>
                            @if ($user->alamats[0]->kodepos)
                                <div class="border border-slate-300 rounded p-2 font-bold text-slate-400">
                                    {{ $user->alamats[0]->kodepos }}</div>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>
                @else
                    <span>-</span>
                @endif
            </div>
        </div>

        <div class="flex justify-center mt-5">
            <a href="{{ route('users.edit', $user->id) }}"
                class="loading-spinner bg-slate-300 text-white p-2 rounded-lg font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Edit Data User</span>
            </a>
        </div>
        <div class="flex justify-center mt-2">
            <a href="{{ route('users.change_password', $user->id) }}"
                class="loading-spinner bg-indigo-300 text-white p-2 rounded-lg font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                </svg>
                <span>Change Password</span>
            </a>
        </div>
        <form action="{{ route('users.delete', $user->id) }}" method="POST" class="mt-2"
            onsubmit="return confirm('Yakin ingin hapus user ini?')">
            @csrf
            <div class="flex justify-center">
                <button class="loading-spinner flex items-center gap-2 p-2 bg-rose-300 text-white font-bold rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    <span>Hapus User</span>
                </button>
            </div>
        </form>

        @if ($user->id_photo_path)
            <div class="flex justify-center mt-5">
                <div class="border-2 text-slate-400 w-4/5 p-2 rounded-lg">
                    <img src="{{ asset('storage/' . $user->id_photo_path) }}" alt="">
                </div>
            </div>
            <form action="{{ route('users.delete_id_photo', $user->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin hapus ID Photo ini?')" class="mt-2">
                @csrf
                <div class="flex justify-center">
                    <button class="loading-spinner bg-rose-300 font-bold text-white p-1 rounded-lg">Hapus ID Photo</button>
                </div>
            </form>
        @else
            <div class="flex justify-center mt-3">
                <div class="w-3/4 text-slate-200 border-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-full">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                    </svg>
                </div>
            </div>
            {{-- ID PICTURE / PHOTO --}}
            <form method="POST" action="{{ route('users.update_id_photo', $user->id) }}" class="mb-1"
                enctype="multipart/form-data">
                @csrf
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
                    <div class="flex justify-center py-3 border-2 border-rose-300 rounded">
                        <div class="w-2/3">
                            <img src="" alt="avatar_foto" id="preview-id-photo" />
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <button type="submit"
                            class="loading-spinner bg-emerald-300 text-white font-bold rounded-lg p-2">Update ID
                            Photo</button>
                    </div>
                </div>

                <div id="label-input-id-photo" class="flex justify-center">
                    <label for="input-id-photo"
                        class="border-2 border-indigo-300 rounded p-2 mt-2 hover:cursor-pointer text-slate-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>

                            <div class="ml-1">Foto ID</div>
                        </div>
                    </label>
                </div>
                <input id="input-id-photo" name="photo" type="file" accept=".jpg, .jpeg, .png"
                    onchange="previewImage(this.files[0], 'div-preview-id-photo', 'preview-id-photo', 'label-input-id-photo')"
                    class="hidden" />

            </form>
        @endif

        <div class="mt-5">
            <h3 class="font-bold text-slate-400">Histori Pembelian</h3>
        </div>
        @if (count($surat_pembelians))
            <div class="mt-2">
                <table class="w-full">
                    @foreach ($surat_pembelians as $key => $surat_pembelian)
                        <tr class="border-t">
                            <td class="pt-1" onclick="$('#surat_pembelian_items-{{ $key }}').toggle(300)">
                                <div class="flex justify-center font-bold">
                                    @if ($surat_pembelian->status_buyback == 'all')
                                        <div class="rounded text-white border-2 bg-slate-400 border-slate-500">
                                        @elseif ($surat_pembelian->status_buyback == 'sebagian')
                                            <div class="rounded text-white border-2 bg-orange-400 border-orange-500">
                                            @else
                                                @if ($surat_pembelian->status_bayar === 'lunas')
                                                    <div
                                                        class="rounded text-white border-2 bg-emerald-400 border-emerald-500">
                                                    @else
                                                        <div
                                                            class="rounded text-white border-2 bg-yellow-400 border-yellow-500">
                                                @endif
                                    @endif
                                    <div class="text-center"><span
                                            class="whitespace-nowrap text-xs font-bold">{{ date('d-m', strtotime($surat_pembelian->tanggal_surat)) }}</span>
                                    </div>
                                    <div class="text-center text-xs font-bold">
                                        {{ date('Y', strtotime($surat_pembelian->tanggal_surat)) }}</div>
                                </div>
            </div>
            </td>
            <td class="py-1">
                <div class="bg-indigo-300 text-white p-1 text-xs rounded">
                    {{ $surat_pembelian->nomor_surat }}</div>
            </td>
            <td class="py-1">
                <div class="text-center text-slate-500">
                    {{ my_decimal_format($surat_pembelian->harga_total) }}
                </div>
            </td>
            </tr>
            <tr class="border-b">
                <td colspan="4" class="pb-1">
                    <div id="surat_pembelian_items-{{ $key }}"
                        class="hidden border border-indigo-400 rounded p-2 bg-indigo-50">
                        <h3 class="font-bold text-slate-500">Data Barang:</h3>
                        <div class="grid grid-cols-12 gap-1 justify-between items-center border-y text-slate-400">
                            @foreach ($surat_pembelian->items as $item)
                                @if ($item->status_buyback)
                                    <div class="col-span-8">
                                        <div>{{ $item->nama_short }}</div>
                                        <div class="text-xs font-bold">({{ $item->status_buyback }} ->
                                            {{ my_decimal_format($item->harga_buyback) }})</div>
                                    </div>
                                @else
                                    <span class="col-span-8">{{ $item->nama_short }}</span>
                                @endif
                                <div class="col-span-4 text-xs">
                                    <div>@ {{ my_decimal_format($item->harga_g) }}</div>
                                    <div>o: {{ my_decimal_format($item->ongkos_g) }}</div>
                                    <div>{{ my_decimal_format($item->harga_t) }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-end mt-1 gap-2 items-center">
                            <form action="{{ route('surat_pembelian.buyback', $surat_pembelian->id) }}" method="GET">
                                <button type="submit" class="loading-spinner bg-indigo-300 text-white p-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>
                                </button>
                            </form>
                            <form action="{{ route('surat_pembelian.delete', $surat_pembelian->id) }}"
                                onsubmit="return confirm('Yakin ingin hapus SuratPembelian ini?')">
                                <button type="submit" class="loading-spinner bg-rose-300 text-white p-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                            <div>
                                <a href="{{ route('surat_pembelian.print_out', $surat_pembelian->id) }}"
                                    class="loading-spinner">
                                    <button class="bg-slate-300 text-white p-1 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('surat_pembelian.show', $surat_pembelian->id) }}"
                                    class="loading-spinner bg-yellow-200 text-slate-400 px-2 py-1 rounded-xl border border-yellow-400">Detail</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </table>
        </div>
    @else
        <p class="italic text-slate-400">- belum ada pembelian -</p>
        @endif
    </main>

    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    <script src="{{ asset('js/item.js') }}"></script>

@endsection
