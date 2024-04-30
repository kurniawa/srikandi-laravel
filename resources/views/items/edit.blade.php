@extends('layouts.main')
@section('content')
<main>
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    @for ($i = 0; $i < 5; $i++)
    @if ($item_photos[$i])
    <div class="flex gap-2">
        <div class="w-28 max-h-28 mb-2">
            <img src="{{ asset("storage/" . $item_photos[$i]->photo->path) }}" alt="item_photo" class="w-full">
        </div>
        <form action="{{ route('items.delete_photo', [$item->id, $item_photos[$i]->id]) }}" method="POST" onsubmit="return confirm('Anda yakin ingin hapus photo_item ini?')" class="flex items-center">
            @csrf
            <button type="submit" class="bg-pink-300 text-pink-500 rounded p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        </form>
    </div>
    @else
    <form method="POST" action="{{ route('items.add_photo', $item->id) }}" class="mb-1" enctype="multipart/form-data">
        @csrf
        <label for="input-photo-{{ $i }}" class="inline-block">
            <div class="text-white bg-sky-300 rounded p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-20 h-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
            </div>
        </label>
        <input id="input-photo-{{ $i }}" type="file" name="photo" onchange="previewImage(this.files[0], 'div-preview-photo-{{ $i }}', 'preview-photo-{{ $i }}')" class="hidden">
        <input type="hidden" name="photo_index" value="{{ $i }}">
        <div id="div-preview-photo-{{ $i }}" class="hidden">
            <div class="flex justify-end">
                <button type="button" class="text-red-400" onclick="removeImage('input-photo-{{ $i }}', 'div-preview-photo-{{ $i }}', 'preview-photo-{{ $i }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <img id="preview-photo-{{ $i }}"></img>
            <div class="flex justify-center mt-1">
                <button type="submit" class="bg-emerald-300 text-emerald-500 font-bold rounded px-3 py-1 text-sm">Tambah</button>
            </div>
        </div>
    </form>
    @endif
    @endfor

    <form action="{{ route('items.update', $item->id) }}" method="POST">
        @csrf
        <div class="p-2">
            <div class="grid grid-cols-2 gap-2">
                <div class="">
                    <label for="tipe_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe barang</label>
                    <input type="text" id="tipe_barang" name="tipe_barang" value="{{ $item->tipe_barang }}" readonly class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-5">
                    <label for="tipe_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe perhiasan</label>
                    <select id="tipe_perhiasan" name="tipe_perhiasan" onchange="pilihanJenisPerhiasan(this.value);generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">--</option>
                        @foreach ($tipe_perhiasans as $tipe_perhiasan)
                        @if (old('tipe_perhiasan'))
                        @if (old('tipe_perhiasan') == $tipe_perhiasan->nama)
                        <option value='{{ $tipe_perhiasan->nama }}' selected>{{ $tipe_perhiasan->nama }}</option>
                        @endif
                        @else
                        @if ($item->tipe_perhiasan == $tipe_perhiasan->nama)
                        <option value='{{ $tipe_perhiasan->nama }}' selected>{{ $tipe_perhiasan->nama }}</option>
                        @else
                        <option value='{{ $tipe_perhiasan->nama }}'>{{ $tipe_perhiasan->nama }}</option>
                        @endif
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-5">
                    @if (old('tipe_perhiasan'))
                    <label id="label_jenis_perhiasan" for="jenis_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">jenis {{ old('tipe_perhiasan') }}</label>
                    @else
                    <label id="label_jenis_perhiasan" for="jenis_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">jenis {{ $item->tipe_perhiasan }}</label>
                    @endif
                    @if (old('jenis_perhiasan'))
                    <input type="text" name="jenis_perhiasan" id="jenis_perhiasan" value="{{ old('jenis_perhiasan') }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @else
                    <input type="text" name="jenis_perhiasan" id="jenis_perhiasan" value="{{ $item->jenis_perhiasan }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @endif
                </div>
                <div class="mb-5">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">deskripsi (opt.)</label>
                    @if (old('deskripsi'))
                    <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @else
                    <input type="text" id="deskripsi" name="deskripsi" value="{{ $item->deskripsi }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @endif
                </div>
                <div class="mb-5">
                    <label for="warna_emas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">warna emas</label>
                    <select id="warna_emas" name="warna_emas" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @if (old('warna_emas'))
                        @foreach ($arr_warna_emas as $warna_emas)
                        @if (old('warna_emas') == $warna_emas)
                        <option value="{{ $warna_emas }}" selected>{{ $warna_emas }}</option>
                        @else
                        <option value="{{ $warna_emas }}">{{ $warna_emas }}</option>
                        @endif
                        @endforeach
                        @else
                        @foreach ($arr_warna_emas as $warna_emas)
                        @if ($item->warna_emas == $warna_emas)
                        <option value="{{ $warna_emas }}" selected>{{ $warna_emas }}</option>
                        @else
                        <option value="{{ $warna_emas }}">{{ $warna_emas }}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-5">
                    <label id="label_kadar_formatted" for="kadar_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">kadar(%)</label>
                    @if (old('kadar'))
                    <input type="text" id="kadar_formatted" value="{{ old('kadar_formatted') }}" onchange="formatNumber(this, 'kadar');generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="kadar" name="kadar" value="{{ old('kadar') }}">
                    @else
                    <input type="text" id="kadar_formatted" value="{{ $item->kadar }}" onchange="formatNumber(this, 'kadar');generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="kadar" name="kadar" value="{{ $item->kadar }}">
                    @endif
                </div>
                <div class="mb-5">
                    <label id="label_berat_formatted" for="berat_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">berat</label>
                    @if (old('berat'))
                    <input type="text" id="berat_formatted" value="{{ old('berat_formatted') }}" onchange="formatNumber(this, 'berat');hitungHargaGrOrT();generateNama();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="berat" name="berat" value="{{ old('berat') }}">
                    @else
                    <input type="text" id="berat_formatted" value="{{ $item->berat }}" onchange="formatNumber(this, 'berat');hitungHargaGrOrT();generateNama();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="berat" name="berat" value="{{ $item->berat }}">
                    @endif
                </div>
                <div class="mb-5">
                    <label id="label_harga_g_formatted" for="harga_g_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga_g</label>
                    @if (old('harga_g'))
                    <input type="text" id="harga_g_formatted" value="{{ old('harga_g_formatted') }}" onchange="formatNumber(this, 'harga_g');hitungHargaT();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="harga_g" name="harga_g" value="{{ old('harga_g') }}">
                    @else
                    <input type="text" id="harga_g_formatted" value="{{ $item->harga_g }}" onchange="formatNumber(this, 'harga_g');hitungHargaT();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="harga_g" name="harga_g" value="{{ $item->harga_g }}">
                    @endif
                </div>
                <div class="mb-5">
                    <label id="label_harga_t_formatted" for="harga_t_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga_t</label>
                    @if (old('harga_t'))
                    <input type="text" id="harga_t_formatted" value="{{ old('harga_t_formatted') }}" onchange="formatNumber(this, 'harga_t');hitungHargaGr();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="harga_t" name="harga_t" value="{{ old('harga_t') }}">
                    @else
                    <input type="text" id="harga_t_formatted" value="{{ $item->harga_t }}" onchange="formatNumber(this, 'harga_t');hitungHargaGr();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="harga_t" name="harga_t" value="{{ $item->harga_t }}">
                    @endif
                </div>
            </div>
            <div class="mb-5 border border-emerald-300 rounded p-1">
                <label id="label_nama_short" for="nama_short" class="block text-sm font-medium text-gray-900 dark:text-white">nama_short</label>
                @if (old('nama_short'))
                <input type="text" id="nama_short" name="nama_short" value="{{ old('nama_short') }}" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                @else
                <input type="text" id="nama_short" name="nama_short" value="{{ $item->nama_short }}" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                @endif
                <label id="label_nama_long" for="nama_long" class="mt-1 block text-sm font-medium text-gray-900 dark:text-white">nama_long</label>
                @if (old('nama_long'))
                <textarea id="nama_long" name="nama_long" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('nama_long') }}</textarea>
                @else
                <textarea id="nama_long" name="nama_long" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $item->nama_long }}</textarea>
                @endif
                {{-- <input type="text" id="nama_long" name="nama_long" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"> --}}
            </div>
            <div class="mb-5">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">keterangan (opt.)</label>
                @if (old('keterangan'))
                <textarea id="keterangan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{ old('keterangan') }}
                </textarea>
                @else
                <textarea id="keterangan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    {{ $item->keterangan }}
                </textarea>
                @endif
            </div>
            {{-- ATRIBUT LAIN --}}
            <div class="border border-indigo-300 p-2 rounded">
                <div class="text-center">
                    <h3 class="font-bold">Atribut Lainnya</h3>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-3">
                        <label for="kondisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">kondisi</label>
                        <select id="kondisi" name="kondisi" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @if (old('kondisi'))
                            @foreach ($obj_kondisi as $kondisi)
                            @if (old('kondisi') == $kondisi['value'])
                            <option value="{{ $kondisi['value'] }}" selected>{{ $kondisi['label'] }}</option>
                            @else
                            <option value="{{ $kondisi['value'] }}">{{ $kondisi['label'] }}</option>
                            @endif
                            @endforeach
                            @else
                            @foreach ($obj_kondisi as $kondisi)
                            @if ($item->kondisi == $kondisi['value'])
                            <option value="{{ $kondisi['value'] }}" selected>{{ $kondisi['label'] }}</option>
                            @else
                            <option value="{{ $kondisi['value'] }}">{{ $kondisi['label'] }}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label id="label_cap" for="cap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">cap</label>
                        @if (old('cap'))
                        <input type="text" id="cap" name="cap" value="{{ old('cap') }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @else
                        <input type="text" id="cap" name="cap" value="{{ $item->cap }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="range_usia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">range_usia</label>
                        <select id="range_usia" name="range_usia" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @if (old('range_usia'))
                            @foreach ($arr_range_usia as $range_usia)
                            @if (old('range_usia') == $range_usia)
                            <option value="{{ $range_usia }}" selected>{{ $range_usia }}</option>
                            @else
                            <option value="{{ $range_usia }}">{{ $range_usia }}</option>
                            @endif
                            @endforeach
                            @else
                            @foreach ($arr_range_usia as $range_usia)
                            @if ($item->range_usia == $range_usia)
                            <option value="{{ $range_usia }}" selected>{{ $range_usia }}</option>
                            @else
                            <option value="{{ $range_usia }}">{{ $range_usia }}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div id="div_ukuran" class="mb-3 hidden">
                        <label id="label_ukuran" for="ukuran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ukuran(mm.)</label>
                        @if (old('ukuran'))
                        <input type="text" id="ukuran" name="ukuran" value="{{ old('ukuran') }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @else
                        <input type="text" id="ukuran" name="ukuran" value="{{ $item->ukuran }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @endif
                    </div>
                    <div id="div_merk" class="mb-3 hidden">
                        <label id="label_merk" for="merk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">merk</label>
                        <select id="merk" name="merk" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @if (old('merk'))
                            @foreach ($arr_merks as $merk)
                            @if (old('merk') == $merk)
                            <option value="{{ $merk }}" selected>{{ $merk }}</option>
                            @else
                            <option value="{{ $merk }}">{{ $merk }}</option>
                            @endif
                            @endforeach
                            @else
                            @foreach ($arr_merks as $merk)
                            @if ($item->merk == $merk)
                            <option value="{{ $merk }}" selected>{{ $merk }}</option>
                            @else
                            <option value="{{ $merk }}">{{ $merk }}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div id="div_plat" class="mb-3 hidden">
                        <label id="label_plat" for="plat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">plat</label>
                        @if (old('plat'))
                        <input type="number" step="1" max="9" min="0" id="plat" name="plat" value="{{ old('plat') }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @else
                        <input type="number" step="1" max="9" min="0" id="plat" name="plat" value="{{ $item->plat }}" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @endif
                    </div>
                </div>

                <div id="div_mata" class="hidden">
                    <div class="flex gap-2 items-center">
                        <span>mata :</span>
                        <button type="button" class="bg-emerald-300 rounded-2xl text-white px-2 py-1" onclick="addMata()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>
                    <div id="data_mata">
                        <div id="data-mata-0" class="data-mata">
                            <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                                <div class="mb-1">
                                    <input type="text" id="warna_mata-0" name="warna_mata[]" value="{{ old('warna_mata.0') ? old('warna_mata.0') : '' }}" placeholder="warna_mata" class="warna-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                <div class="mb-1">
                                    <select id="level_warna" name="level_warna[]" class="level-warna bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @if (old('level_warna.0'))
                                        @if (old('level_warna.0') == 'netral')
                                        <option value="netral" selected>netral</option>
                                        @else
                                        <option value="netral">netral</option>
                                        @endif
                                        @if (old('level_warna.0') == 'tua')
                                        <option value="tua" selected>tua</option>
                                        @else
                                        <option value="tua">tua</option>
                                        @endif
                                        @if (old('level_warna.0') == 'muda')
                                        <option value="muda" selected>muda</option>
                                        @else
                                        <option value="muda">muda</option>
                                        @endif
                                        @else
                                        <option value="netral">netral</option>
                                        <option value="tua">tua</option>
                                        <option value="muda">muda</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <select id="opacity" name="opacity[]" class="opacity-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @if (old('opacity'))
                                        @if (old('opacity') == 'transparent')
                                        <option value="transparent" selected>transparent</option>
                                        @else
                                        <option value="transparent">transparent</option>
                                        @endif
                                        @if (old('opacity') == 'non-transparent')
                                        <option value="non-transparent" selected>non-transparent</option>
                                        @else
                                        <option value="non-transparent">non-transparent</option>
                                        @endif
                                        @if (old('opacity') == 'half-transparent')
                                        <option value="half-transparent" selected>half-transparent</option>
                                        @else
                                        <option value="half-transparent">half-transparent</option>
                                        @endif
                                        @else
                                        <option value="transparent">transparent</option>
                                        <option value="non-transparent">non-transparent</option>
                                        <option value="half-transparent">half-transparent</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <input type="text" id="jumlah_mata" name="jumlah_mata[]" value="{{ old('jumlah_mata.0') ? old('jumlah_mata.0') : '' }}" placeholder="jumlah_mata" class="jumlah-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                            </div>
                            <div class="flex justify-end mt-1">
                                <button class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mata-0')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="div_mainan" class="mt-2 hidden">
                    <div class="flex gap-2 items-center">
                        <span>mainan :</span>
                        <button type="button" class="bg-emerald-300 rounded-2xl text-white px-2 py-1" onclick="addMainan()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>
                    <div id="data_mainan">
                        <div id="data-mainan-0" class="data-mainan">
                            <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                                <div class="mb-1">
                                    <input type="text" id="tipe_mainan-0" name="tipe_mainan[]" value="{{ old('tipe_mainan.0') ? old('tipe_mainan.0') : '' }}" placeholder="tipe_mainan" class="tipe-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                <div class="mb-1">
                                    <input type="text" id="jumlah_mainan-0" name="jumlah_mainan[]" value="{{ old('jumlah_mainan.0') ? old('jumlah_mainan.0') : '' }}" placeholder="jumlah_mainan" class="jumlah-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                            </div>
                            <div class="flex justify-end mt-1">
                                <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mainan-0')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- TOMBOL ATRIBUT --}}
        <div class="fixed z-30 bottom-0 bg-violet-200 rounded w-4/5 px-2">
            <div class="grid grid-cols-3 gap-2">
                <div class="flex gap-1 items-center">
                    <input type="checkbox" name="toggle_mata" id="toggle_mata" onclick="toggleCheckbox(this, 'div_mata')"><label for="toggle_mata">mata</label>
                </div>
                <div class="flex gap-1 items-center">
                    <input type="checkbox" name="toggle_mainan" id="toggle_mainan" onclick="toggleCheckbox(this, 'div_mainan')"><label for="toggle_mainan"><label for="toggle_mainan">mainan</label>
                </div>
                <div class="flex gap-1 items-center">
                    <input type="checkbox" name="toggle_ukuran" id="toggle_ukuran" onclick="toggleCheckbox(this, 'div_ukuran')"><label for="toggle_ukuran">ukuran</label>
                </div>
                <div class="flex gap-1 items-center">
                    <input type="checkbox" name="toggle_merk" id="toggle_merk" onclick="toggleCheckbox(this, 'div_merk')"><label for="toggle_merk">merk</label>
                </div>
                <div class="flex gap-1 items-center">
                    <input type="checkbox" name="toggle_plat" id="toggle_plat" onclick="toggleCheckbox(this, 'div_plat')"><label for="toggle_plat">plat</label>
                </div>
            </div>
        </div>

        <div class="text-center mt-10">
            <button type="submit" class="bg-emerald-300 text-white px-3 py-2 rounded font-bold">+ Tambah Item Baru</button>
        </div>
    </form>

    <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button>
</main>

<script>
    let jenis_perhiasans = {!! json_encode($jenis_perhiasans, JSON_HEX_TAG) !!}
    let caps = {!! json_encode($caps, JSON_HEX_TAG) !!}
    let warna_matas = {!! json_encode($warna_matas, JSON_HEX_TAG) !!}
    let mainans = {!! json_encode($mainans, JSON_HEX_TAG) !!}
    // console.log(mainans);
    // console.log(jenis_perhiasans);
    // $('#tipe_perhiasan').autocomplete({
    //     source: jenis_perhiasans,
    //     select: function (event, ui) {
    //         document.getElementById('tipe_perhiasan').value = ui.item.value;
    //     }
    // });
    $('#cap').autocomplete({
        source: caps,
        select: function (event, ui) {
            document.getElementById('cap').value = ui.item.value;
            generateNama();
        }
    })

    function pilihanJenisPerhiasan(tipe_perhiasan) {
        // console.log(data_tipe_perhiasan);
        // console.log(JSON.parse(data_tipe_perhiasan));
        // var tipe_perhiasan = JSON.parse(data_tipe_perhiasan);

        var pilihan_jenis_perhiasans = jenis_perhiasans.filter((o) => o.tipe_perhiasan == tipe_perhiasan);
        console.log(pilihan_jenis_perhiasans);
        $('#jenis_perhiasan').autocomplete({
            source: pilihan_jenis_perhiasans,
            select: function (event, ui) {
                document.getElementById('jenis_perhiasan').value = ui.item.value;
                generateNama();
            }
        })
        document.getElementById('label_jenis_perhiasan').textContent = `jenis ${tipe_perhiasan}`;
    }

    let index_mata = 1;
    function addMata() {
        document.getElementById('data_mata').insertAdjacentHTML('beforeend',
        `<div id="data-mata-${index_mata}">
            <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                <div class="mb-1">
                    <input type="text" id="warna_mata-${index_mata}" name="warna_mata[]" placeholder="warna_mata" class="warna-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-1">
                    <select id="level_warna" name="level_warna[]" class="level-warna bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="netral">netral</option>
                        <option value="tua">tua</option>
                        <option value="muda">muda</option>
                    </select>
                </div>
                <div class="mb-1">
                    <select id="opacity" name="opacity[]" class="opacity-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="transparent">transparent</option>
                        <option value="non-transparent">non-transparent</option>
                        <option value="half-transparent">half-transparent</option>
                    </select>
                </div>
                <div class="mb-1">
                    <input type="text" id="jumlah_mata" name="jumlah_mata[]" placeholder="jumlah_mata" class="jumlah-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
            <div class="flex justify-end mt-1">
                <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mata-${index_mata}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
            </div>
        </div>`
        );

        setAutocompleteWarnaMata(`warna_mata-${index_mata}`, warna_matas);
        index_mata++;

    }

    function setAutocompleteWarnaMata(element_id, source) {
        // console.log('run autocomplete mata');
        $(`#${element_id}`).autocomplete({
            source: source,
        });
    }

    setAutocompleteWarnaMata(`warna_mata-0`, warna_matas);

    let index_mainan = 1;
    function addMainan() {
        document.getElementById('data_mainan').insertAdjacentHTML('beforeend',
        `<div id="data-mainan-${index_mainan}" class="data-mainan">
            <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                <div class="mb-1">
                    <input type="text" id="tipe_mainan-${index_mainan}" name="tipe_mainan[]" placeholder="tipe_mainan" class="tipe-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-1">
                    <input type="text" id="jumlah_mainan-${index_mainan}" name="jumlah_mainan[]" placeholder="jumlah_mainan" class="jumlah-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
            <div class="flex justify-end mt-1">
                <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mainan-${index_mainan}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
            </div>
        </div>`
        );

        setAutocompleteMainan(`tipe_mainan-${index_mainan}`);
        index_mainan++;
    }

    function setAutocompleteMainan(element_id) {
        $(`#${element_id}`).autocomplete({
            source: mainans,
        });
    }

    setAutocompleteMainan('tipe_mainan-0')

    function removeElement(id) {
        document.getElementById(id).remove();
    }

    function toggleCheckbox(checkbox, element_id) {
        // console.log(checkbox.checked)
        if (checkbox.checked) {
            $(`#${element_id}`).show(300)
        } else {
            $(`#${element_id}`).hide(300)

        }
    }

    function hitungHargaT() {
        let berat = parseFloat(document.getElementById('berat').value);
        let harga_g = parseFloat(document.getElementById('harga_g').value);
        // console.log(berat);
        // console.log(harga_g);
        if (!isNaN(berat) && !isNaN(harga_g)) {
            let harga_t = formatDecimal(berat * harga_g);
            let harga_t_formatted = document.getElementById('harga_t_formatted');
            harga_t_formatted.value = harga_t.toString().split('.').join(',');
            formatNumber2('harga_t_formatted', 'harga_t');
        }
    }

    function hitungHargaGr() {
        let berat = parseFloat(document.getElementById('berat').value);
        let harga_t = parseFloat(document.getElementById('harga_t').value);
        // console.log(berat);
        // console.log(harga_t);
        if (!isNaN(berat) && !isNaN(harga_t)) {
            let harga_g = formatDecimal(harga_t / berat);
            let harga_g_formatted = document.getElementById('harga_g_formatted');
            harga_g_formatted.value = harga_g.toString().split('.').join(',');
            // console.log(harga_g)
            formatNumber2('harga_g_formatted', 'harga_g');
        }
    }

    function hitungHargaGrOrT() {
        let berat = parseFloat(document.getElementById('berat').value);
        let harga_g = parseFloat(document.getElementById('harga_g').value);
        let harga_t = parseFloat(document.getElementById('harga_t').value);
        if (!isNaN(berat) && !isNaN(harga_g)) {
            let harga_t = formatDecimal(berat * harga_g);
            let harga_t_formatted = document.getElementById('harga_t_formatted');
            harga_t_formatted.value = harga_t.toString().split('.').join(',');
            formatNumber2('harga_t_formatted', 'harga_t');
        } else if (!isNaN(berat) && !isNaN(harga_t)) {
            let harga_g = formatDecimal(harga_t / berat);
            let harga_g_formatted = document.getElementById('harga_g_formatted');
            harga_g_formatted.value = harga_g.toString().split('.').join(',')
            formatNumber2('harga_g_formatted', 'harga_g');
        }
    }

</script>

<script src="{{ asset('js/create_item.js') }}"></script>
@endsection
