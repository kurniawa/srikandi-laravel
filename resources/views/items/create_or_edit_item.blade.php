@extends('layouts.main')
@section('content')
    <main>
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        {{-- <form action="{{ route('items.store', $from) }}" method="POST"> --}}
        @if ($mode == 'CREATE_NEW' || $mode == 'CREATE_BASED_ON_EXISTING')
        <form action="{{ route('items.store') }}" method="POST">
        @else
        <form action="{{ route('items.update', $item->id) }}" method="POST">
        @endif
            @csrf
            <div class="p-2">
                <div class="grid grid-cols-2 gap-2">
                    <div class="">
                        <label for="tipe_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe
                            barang</label>
                        <input type="text" id="tipe_barang" name="tipe_barang" value="{{ $tipe_barang }}" readonly
                            class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    {{-- Tipe Perhiasan --}}
                    <div class="mb-5">
                        <label for="tipe_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe perhiasan</label>
                        <select id="tipe_perhiasan" name="tipe_perhiasan"
                            onchange="pilihanJenisPerhiasan(this.value);generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">--</option>
                            @php
                                $tipe_perhiasan_value = old('tipe_perhiasan') ?? ((isset($item) && isset($item->tipe_perhiasan)) ? $item->tipe_perhiasan : '');
                            @endphp
                            @foreach ($tipe_perhiasans as $tp)
                                <option value="{{ $tp->nama }}" {{ $tp->nama == $tipe_perhiasan_value ? 'selected' : '' }}>{{ $tp->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Jenis Perhiasan --}}
                    <div class="mb-5">
                        <label id="label_jenis_perhiasan" for="jenis_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">jenis ...</label>
                        @php
                            $jenis_perhiasan_value = old('jenis_perhiasan') ?? ((isset($item) && isset($item->jenis_perhiasan)) ? $item->jenis_perhiasan : '');
                        @endphp
                        
                        <input type="text" name="jenis_perhiasan" id="jenis_perhiasan"
                                value="{{ $jenis_perhiasan_value }}" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    {{-- Deskripsi (optional) --}}
                    <div class="mb-5">
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">deskripsi (opt.)</label>
                        @php
                            $deskripsi_value = old('deskripsi') ?? ((isset($item) && isset($item->deskripsi)) ? $item->deskripsi : '');
                        @endphp
                        <input type="text" id="deskripsi" name="deskripsi" onchange="generateNama()"
                            value="{{ $deskripsi_value }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    {{-- Warna Emas --}}
                    <div class="mb-5">
                        <label for="warna_emas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">warna
                            emas</label>
                        <select id="warna_emas" name="warna_emas" onchange="generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @php
                                $we_value = old('warna_emas') ?? ((isset($item) && isset($item->warna_emas)) ? $item->warna_emas : '');
                            @endphp
                            @foreach ($label_warna_emas as $we)
                                <option value="{{ $we->nama }}" {{ $we_value == $we->nama ? 'selected' : '' }}>{{ $we->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    {{-- Kadar --}}
                    <div class="mb-5">
                        <label id="label_kadar_formatted" for="kadar_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">kadar(%)</label>
                        @php
                            $kadar_formatted_value = old('kadar_formatted') ?? ((isset($item) && isset($item->kadar)) ? format_decimal_id_and_trim($item->kadar) : '');
                            $kadar_value = old('kadar') ?? (isset($item->kadar) ? format_decimal_en_and_trim($item->kadar) : '');
                        @endphp
                        <input type="text" inputmode="numeric" id="kadar_formatted"
                            value="{{ $kadar_formatted_value }}"
                            onchange="formatNumber(this, 'kadar');generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="kadar" name="kadar" value="{{ $kadar_value }}">
                    </div>
                    {{-- Berat --}}
                    <div class="mb-5">
                        <label id="label_berat_formatted" for="berat_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">berat</label>
                        @php
                            $berat_formatted_value = old('berat_formatted') ?? ((isset($item) && isset($item->berat)) ? format_decimal_id_and_trim($item->berat) : '');
                            $berat_value = old('berat') ?? (isset($item->berat) ? format_decimal_en_and_trim($item->berat) : '');
                        @endphp
                        <input type="text" inputmode="numeric" id="berat_formatted"
                            value="{{ $berat_formatted_value }}"
                            onchange="formatNumber(this, 'berat');hitungHargaGrOrT();generateNama();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="berat" name="berat" value="{{ $berat_value }}">
                    </div>
                    {{-- Harga Per Gram --}}
                    <div class="mb-5">
                        <label id="label_harga_g_formatted" for="harga_g_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga/g</label>
                        @php
                            $harga_g_formatted_value = old('harga_g_formatted') ?? ((isset($item) && isset($item->harga_g)) ? format_dots_and_decimals($item->harga_g) : '');
                            $harga_g_value = old('harga_g') ?? ((isset($item) && isset($item->harga_g)) ? format_decimal_en_and_trim($item->harga_g) : '');
                        @endphp
                        <input type="text" inputmode="numeric" id="harga_g_formatted"
                            value="{{ $harga_g_formatted_value }}"
                            onchange="formatNumber(this, 'harga_g');hitungHargaT();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="harga_g" name="harga_g"
                            value="{{ $harga_g_value }}">
                    </div>
                    {{-- Ongkos Per Gram --}}
                    <div class="mb-5">
                        <label id="label_ongkos_g_formatted" for="ongkos_g_formatted"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ongkos/g</label>
                            @php
                                $ongkos_g_formatted_value = old('ongkos_g_formatted') ?? (isset($item->ongkos_g) ? format_dots_and_decimals($item->ongkos_g) : '');
                                $ongkos_g_value = old('ongkos_g') ?? (isset($item->ongkos_g) ? format_decimal_en_and_trim($item->ongkos_g) : '');
                            @endphp
                            <input type="text" inputmode="numeric" id="ongkos_g_formatted"
                                value="{{ $ongkos_g_formatted_value }}"
                                onchange="formatNumber(this, 'ongkos_g')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <input type="hidden" id="ongkos_g" name="ongkos_g"
                                value="{{ $ongkos_g_value }}">
                    </div>
                    {{-- Harga Total = Harga Per Gram * Berat --}}
                    <div class="mb-5">
                        <label id="label_harga_t_formatted" for="harga_t_formatted"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga_t</label>
                        @php
                            $hargaTFormatted = old('harga_t_formatted') ?? (isset($item->harga_t) ? format_dots_and_decimals($item->harga_t) : '');
                            $hargaTValue = old('harga_t') ?? (isset($item->harga_t) ? format_decimal_en_and_trim($item->harga_t) : '');
                        @endphp
                        <input type="text" inputmode="numeric" id="harga_t_formatted"
                            value="{{ $hargaTFormatted }}"
                            onchange="formatNumber(this, 'harga_t');hitungHargaGr();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="harga_t" name="harga_t" value="{{ $hargaTValue }}">
                    </div>
                </div>
                {{-- Shortname & Longname --}}
                <div class="mb-5 border border-emerald-300 rounded p-1">
                    <label id="label_shortname" for="shortname" class="block text-sm font-medium text-gray-900 dark:text-white">shortname</label>
                        <input type="text" id="shortname" name="shortname"
                            value="{{ old('shortname') ?? (isset($item->shortname) ? $item->shortname : '') }}"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <label id="label_longname" for="longname" class="mt-1 block text-sm font-medium text-gray-900 dark:text-white">longname</label>
                    <textarea id="longname" name="longname" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('longname') ?? (isset($item->longname) ? $item->longname : '') }}</textarea>
                </div>
                {{-- Keterangan --}}
                <div class="mb-5">
                    <label for="keterangan"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">keterangan (opt.)</label>
                    <textarea id="keterangan" rows="4" name="keterangan" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('keterangan') ?? (isset($item->keterangan) ? $item->keterangan : '') }}</textarea>
                </div>
                {{-- ATRIBUT LAIN --}}
                <div class="border border-indigo-300 p-2 rounded">
                    <div class="text-center">
                        <h3 class="font-bold">Atribut Lainnya</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2 gap-y-5">
                        {{-- Kondisi --}}
                        <div class="">
                            <label for="kondisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">kondisi</label>
                            @php
                                $kondisi_value = old('kondisi') ?? ((isset($item) && isset($item->kondisi)) ? $item->kondisi : '');
                            @endphp
                            
                            <select id="kondisi" name="kondisi" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($kondisi_options as $key => $kondisi_option)
                                    <option value="{{ $kondisi_option['value'] }}" {{ $kondisi_value == $kondisi_option['value'] ? 'selected' : '' }}>
                                        {{ $kondisi_option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Cap --}}
                        <div class="">
                            <label id="label_cap" for="cap"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">cap</label>
                            <input type="text" id="cap" name="cap"
                                value="{{ old('cap') ?? (isset($item->cap) ? $item->cap : '') }}" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        {{-- Range Usia --}}
                        <div>
                            <label for="range_usia"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">range_usia</label>
                            <select id="range_usia" name="range_usia" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @php
                                    $range_usia_value = old('range_usia') ?? (isset($item->range_usia) ? $item->range_usia : '');
                                @endphp
                                @foreach ($range_usia_options as $value)
                                    <option value="{{ $value }}" {{ $range_usia_value == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nampan/Location --}}
                        <div>
                            <label for="location"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">nampan/loc</label>
                                @php
                                    $location_value = old('location') ?? (isset($item->location) ? $item->location : '');
                                @endphp
                            <input type="text" id="location" name="location"
                            value="{{ old('location') ?? (isset($item->location) ? $item->location : '') }}" onchange="generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        {{-- Ukuran --}}
                        <div id="div_ukuran" class="{{ isset($item->ukuran) && $item->ukuran ? '' : 'hidden' }}">
                            <label id="label_ukuran" for="ukuran"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ukuran(mm.)</label>
                            <input type="text" id="ukuran" name="ukuran"
                                value="{{ old('ukuran') ?? (isset($item->ukuran) ? $item->ukuran : '') }}" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        {{-- Merk --}}
                        <div id="div_merk" class="{{ isset($item->merk) && $item->merk ? '' : 'hidden' }}">
                            <label id="label_merk" for="merk"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">merk</label>
                            <select id="merk" name="merk" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @php
                                    $merk_value = old('merk') ?? (isset($item->merk) ? $item->merk : '');
                                @endphp
                                    <option value="">--</option>
                                @foreach ($merk_options as $value)
                                    <option value="{{ $value }}" {{ $merk_value == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Plat --}}
                        <div id="div_plat" class="{{ isset($item->plat) && $item->plat ? '' : 'hidden' }}">
                            <label id="label_plat" for="plat"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">plat</label>
                            <input type="number" step="1" max="9" min="0" id="plat"
                                name="plat" value="{{ old('plat') ?? (isset($item->plat) ? $item->plat : '') }}" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>

                    {{-- Data Mata --}}
                    <div id="div_mata" class="mt-5{{ isset($item_matas) && ($item_matas != []) ? '' : ' hidden' }}">
                        <div class="flex gap-2 items-center">
                            <span>mata :</span>
                            <button type="button" class="bg-emerald-300 rounded-2xl text-white px-2 py-1"
                                onclick="addMata()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                        <div id="data_mata">
                            @if (isset($item_matas) && $item_matas != [])
                                @foreach ($item_matas as $key_item_mata => $item_mata)
                                <div id="data-mata-{{ $key_item_mata }}">
                                    <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                                        <div class="mb-1">
                                            <select name="warna_mata[]" onchange="generateNama()" class="warna-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                                @php
                                                    $warna_mata_value = old("warna_mata.$key_item_mata") ?? $item_mata['warna'] ?? '';
                                                @endphp
                                                @foreach ($label_matas as $label_mata)
                                                    <option value="{{ $label_mata->value }}" {{ $label_mata->value == $warna_mata_value ? 'selected' : '' }}>{{ $label_mata->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <select id="level_warna" name="level_warna[]" onchange="generateNama()" class="level-warna bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @php
                                                    $level_warna_value = old("level_warna.$key_item_mata") ?? $item_mata['level_warna'] ?? '';
                                                @endphp
                                                @foreach ($level_warna_options as $level_warna_option)
                                                    <option value="{{ $level_warna_option }}" {{ $level_warna_value == $level_warna_option ? 'selected' : '' }}>{{ $level_warna_option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <select id="opacity" name="opacity[]" onchange="generateNama()" class="opacity-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @php
                                                    $opacity_value = old("opacity.$key_item_mata") ?? $item_mata['opacity'] ?? '';
                                                @endphp
                                                @foreach ($opacity_options as $opacity_option)
                                                    <option value="{{ $opacity_option }}" {{ $item_mata['opacity'] == $opacity_option ? 'selected' : '' }}>{{ $opacity_option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <input type="text" inputmode="numeric" id="jumlah_mata" name="jumlah_mata[]" placeholder="jumlah_mata" 
                                            onchange="generateNama()"
                                            value="{{ old("jumlah_mata.$key_item_mata") ?? $item_mata['jumlah'] ?? '' }}"
                                            class="jumlah-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-1">
                                        <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mata-{{ $key_item_mata }}');generateNama()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Data Mainan --}}
                    <div id="div_mainan" class="mt-2{{ isset($item_mainans) && ($item_mainans != []) ? '' : ' hidden' }}">
                        <div class="flex gap-2 items-center">
                            <span>mainan :</span>
                            <button type="button" class="bg-emerald-300 rounded-2xl text-white px-2 py-1"
                                onclick="addMainan()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                        <div id="data_mainan">
                            @foreach ($item_mainans as $key_item_mainan => $item_mainan)
                            <div id="data-mainan-{{ $key_item_mainan }}" class="data-mainan">
                                <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                                    <div class="mb-1">
                                        <input type="text" id="tipe_mainan-{{ $key_item_mainan }}" name="tipe_mainan[]" placeholder="tipe_mainan" 
                                        onchange="generateNama()"
                                        value="{{ old("tipe_mainan.$key_item_mainan") ?? $item_mainan['nama'] }}"
                                        class="tipe-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                    <div class="mb-1">
                                        <input type="text" inputmode="numeric" id="jumlah_mainan-{{ $key_item_mainan }}" name="jumlah_mainan[]" 
                                        placeholder="jumlah_mainan" onchange="generateNama()" 
                                        value="{{ old("jumlah_mainan.$key_item_mainan") ?? $item_mainan['jumlah'] }}"
                                        class="jumlah-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="flex justify-end mt-1">
                                    <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mainan-{{ $key_item_mainan }}');generateNama()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- TOMBOL ATRIBUT --}}
            <div class="fixed z-30 bottom-0 bg-violet-200 rounded w-4/5 px-2">
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="checkbox_mata" id="checkbox_mata"
                            onclick="toggleCheckbox(this, 'div_mata'); existElementMata(this); generateNama();"
                            {{ isset($item_matas) && ($item_matas != []) ? 'checked' : '' }}>
                        <label for="checkbox_mata">mata</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="checkbox_mainan" id="checkbox_mainan"
                            onclick="toggleCheckbox(this, 'div_mainan'); existElementMainan(this); generateNama();"
                            {{ isset($item_mainans) && ($item_mainans != []) ? 'checked' : '' }}>
                        <label for="checkbox_mainan"><label for="checkbox_mainan">mainan</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="toggle_ukuran" id="toggle_ukuran"
                            onclick="toggleCheckbox(this, 'div_ukuran')"
                            {{ isset($item->ukuran) && $item->ukuran ? 'checked' : '' }}>
                        <label for="toggle_ukuran">ukuran</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="toggle_merk" id="toggle_merk"
                            onclick="toggleCheckbox(this, 'div_merk')"
                            {{ isset($item->merk) && $item->merk ? 'checked' : '' }}>
                            <label for="toggle_merk">merk</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="toggle_plat" id="toggle_plat"
                            onclick="toggleCheckbox(this, 'div_plat')"
                            {{ isset($item->plat) && $item->plat ? 'checked' : '' }}>
                            <label for="toggle_plat">plat</label>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <button type="submit" class="loading-spinner bg-emerald-300 text-white p-2 rounded font-bold">
                    @if ($mode == "CREATE_NEW" || $mode == "CREATE_BASED_ON_EXISTING")
                    +Tambah Item Baru
                    @else
                    Konfirmasi Edit    
                    @endif
                </button>
            </div>
        </form>

        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
        
        {{-- <input type="text" id="label_mata-{{ $key_item_mata }}" name="warna_mata[]"
        value="{{ old("warna_mata.$key_item_mata") ?? $item_mata['warna'] ?? '' }}"
        placeholder="warna_mata" onchange="generateNama()"
        class="warna-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> --}}
    </main>

    <script>
        let jenis_perhiasans = {!! json_encode($jenis_perhiasans, JSON_HEX_TAG) !!}
        let caps = {!! json_encode($caps, JSON_HEX_TAG) !!}
        let label_matas = {!! json_encode($label_matas, JSON_HEX_TAG) !!}
        let matas = {!! json_encode($matas, JSON_HEX_TAG) !!}
        let label_mainans = {!! json_encode($label_mainans, JSON_HEX_TAG) !!}
        // console.log(label_mainans);
        // console.log(jenis_perhiasans);
        // $('#tipe_perhiasan').autocomplete({
        //     source: jenis_perhiasans,
        //     select: function (event, ui) {
        //         document.getElementById('tipe_perhiasan').value = ui.item.value;
        //     }
        // });
        $('#cap').autocomplete({
            source: caps,
            select: function(event, ui) {
                document.getElementById('cap').value = ui.item.value;
                generateNama();
            }
        })

        function pilihanJenisPerhiasan(tipe_perhiasan) {
            // console.log(data_tipe_perhiasan);
            // console.log(JSON.parse(data_tipe_perhiasan));
            // var tipe_perhiasan = JSON.parse(data_tipe_perhiasan);

            var pilihan_jenis_perhiasans = jenis_perhiasans.filter((o) => o.tipe_perhiasan == tipe_perhiasan);
            // console.log(pilihan_jenis_perhiasans);
            $('#jenis_perhiasan').autocomplete({
                source: pilihan_jenis_perhiasans,
                select: function(event, ui) {
                    document.getElementById('jenis_perhiasan').value = ui.item.value;
                    generateNama();
                }
            })
            document.getElementById('label_jenis_perhiasan').textContent = `jenis ${tipe_perhiasan}`;
        }
        const tipe_perhiasan_value = document.getElementById('tipe_perhiasan').value;
        if (tipe_perhiasan_value) {
            pilihanJenisPerhiasan(tipe_perhiasan_value);
        }

        let index_mata = 0;

        function addMata() {
            addMata__(index_mata, label_matas);
            index_mata++;

        }

        let index_mainan = 0;

        function addMainan() {
            addMainan__(index_mainan, label_mainans);
            index_mainan++;
        }

        function existElementMata(checkbox_mata) {
            if (checkbox_mata.checked) {
                let input_label_matas = document.querySelectorAll('.warna-mata');
                // console.log(input_label_matas.length);
                if (!input_label_matas.length) {
                    addMata();
                }
            }
        }

        function existElementMainan(checkbox_mainan) {
            // console.log(checkbox_mainan.checked);
            if (checkbox_mainan.checked) {
                let input_tipe_label_mainans = document.querySelectorAll('.tipe-mainan');
                // console.log(input_tipe_label_mainans.length);
                if (!input_tipe_label_mainans.length) {
                    addMainan();
                }
            }
        }

        function setAutocompleteMainan(element_id) {
            $(`#${element_id}`).autocomplete({
                source: label_mainans,
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
    <script src="{{ asset('js/item.js') }}"></script>
@endsection
