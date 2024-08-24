@extends('layouts.main')
@section('content')
    <main>
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        {{-- <form action="{{ route('items.store', $from) }}" method="POST"> --}}
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <div class="p-2">
                <div class="grid grid-cols-2 gap-2">
                    <div class="">
                        <label for="tipe_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe
                            barang</label>
                        <input type="text" id="tipe_barang" name="tipe_barang" value="{{ $tipe_barang }}" readonly
                            class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5">
                        <label for="tipe_perhiasan"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe perhiasan</label>
                        <select id="tipe_perhiasan" name="tipe_perhiasan"
                            onchange="pilihanJenisPerhiasan(this.value);generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">--</option>
                            {{-- @foreach ($tipe_perhiasans as $tipe_perhiasan)
                        @if (old('tipe_perhiasan'))
                        @if (old('tipe_perhiasan') == $tipe_perhiasan->id)
                        <option value='{ "id":{{ $tipe_perhiasan->id }}, "nama": "{{ $tipe_perhiasan->nama }}" }' selected>{{ $tipe_perhiasan->nama }}</option>
                        @endif
                        @else
                        <option value='{ "id":{{ $tipe_perhiasan->id }}, "nama": "{{ $tipe_perhiasan->nama }}" }'>{{ $tipe_perhiasan->nama }}</option>
                        @endif
                        @endforeach --}}

                            @foreach ($tipe_perhiasans as $tipe_perhiasan)
                                @if (old('tipe_perhiasan'))
                                    @if (old('tipe_perhiasan') == $tipe_perhiasan->nama)
                                        <option value='{{ $tipe_perhiasan->nama }}' selected>{{ $tipe_perhiasan->nama }}
                                        </option>
                                    @endif
                                @else
                                    <option value='{{ $tipe_perhiasan->nama }}'>{{ $tipe_perhiasan->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label id="label_jenis_perhiasan" for="jenis_perhiasan"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">jenis ...</label>
                        <input type="text" name="jenis_perhiasan" id="jenis_perhiasan"
                            value="{{ old('jenis_perhiasan') ? old('jenis_perhiasan') : '' }}" onchange="generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5">
                        <label for="deskripsi"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">deskripsi (opt.)</label>
                        <input type="text" id="deskripsi" name="deskripsi" onchange="generateNama()"
                            value="{{ old('deskripsi') ? old('deskripsi') : '' }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-5">
                        <label for="warna_emas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">warna
                            emas</label>
                        <select id="warna_emas" name="warna_emas" onchange="generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @if (old('warna_emas'))
                                @if (old('warna_emas') == 'kuning')
                                    <option value="kuning" selected>kuning</option>
                                @else
                                    <option value="kuning">kuning</option>
                                @endif
                                @if (old('warna_emas') == 'rose gold')
                                    <option value="rose gold" selected>rose gold</option>
                                @else
                                    <option value="rose gold">rose gold</option>
                                @endif
                                @if (old('warna_emas') == 'putih')
                                    <option value="putih" selected>putih</option>
                                @else
                                    <option value="putih">putih</option>
                                @endif
                                @if (old('warna_emas') == 'chrome')
                                    <option value="chrome" selected>chrome</option>
                                @else
                                    <option value="chrome">chrome</option>
                                @endif
                            @else
                                <option value="kuning">kuning</option>
                                <option value="rose gold">rose gold</option>
                                <option value="putih">putih</option>
                                <option value="chrome">chrome</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-5">
                        <label id="label_kadar_formatted" for="kadar_formatted"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">kadar(%)</label>
                        <input type="text" inputmode="numeric" id="kadar_formatted"
                            value="{{ old('kadar_formatted') ? old('kadar_formatted') : '' }}"
                            onchange="formatNumber(this, 'kadar');generateNama()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="kadar" name="kadar" value="{{ old('kadar') ? old('kadar') : '' }}">
                    </div>
                    <div class="mb-5">
                        <label id="label_berat_formatted" for="berat_formatted"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">berat</label>
                        <input type="text" inputmode="numeric" id="berat_formatted"
                            value="{{ old('berat_formatted') ? old('berat_formatted') : '' }}"
                            onchange="formatNumber(this, 'berat');hitungHargaGrOrT();generateNama();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="berat" name="berat" value="{{ old('berat') ? old('berat') : '' }}">
                    </div>
                    <div class="mb-5">
                        <label id="label_harga_g_formatted" for="harga_g_formatted"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga/g</label>
                        <input type="text" id="harga_g_formatted"
                            value="{{ old('harga_g_formatted') ? old('harga_g_formatted') : '' }}"
                            onchange="formatNumber(this, 'harga_g');hitungHargaT();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="harga_g" name="harga_g"
                            value="{{ old('harga_g') ? old('harga_g') : '' }}">
                    </div>
                    <div class="mb-5">
                        <label id="label_ongkos_g_formatted" for="ongkos_g_formatted"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ongkos/g</label>
                        <input type="text" id="ongkos_g_formatted"
                            value="{{ old('ongkos_g_formatted') ? old('ongkos_g_formatted') : '' }}"
                            onchange="formatNumber(this, 'ongkos_g')"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="ongkos_g" name="ongkos_g"
                            value="{{ old('ongkos_g') ? old('ongkos_g') : '' }}">
                    </div>
                    <div class="mb-5">
                        <label id="label_harga_t_formatted" for="harga_t_formatted"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga_t</label>
                        <input type="text" id="harga_t_formatted"
                            value="{{ old('harga_t_formatted') ? old('harga_t_formatted') : '' }}"
                            onchange="formatNumber(this, 'harga_t');hitungHargaGr();"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <input type="hidden" id="harga_t" name="harga_t"
                            value="{{ old('harga_t') ? old('harga_t') : '' }}">
                    </div>
                </div>
                <div class="mb-5 border border-emerald-300 rounded p-1">
                    <label id="label_shortname" for="shortname"
                        class="block text-sm font-medium text-gray-900 dark:text-white">shortname</label>
                    <input type="text" id="shortname" name="shortname"
                        value="{{ old('shortname') ? old('shortname') : '' }}"
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <label id="label_longname" for="longname"
                        class="mt-1 block text-sm font-medium text-gray-900 dark:text-white">longname</label>
                    <textarea id="longname" name="longname" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('longname') ? old('longname') : '' }}</textarea>
                    {{-- <input type="text" id="longname" name="longname" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"> --}}
                </div>
                <div class="mb-5">
                    <label for="keterangan"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">keterangan (opt.)</label>
                    <textarea id="keterangan" rows="4" name="keterangan" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('keterangan') ? old('keterangan') : '' }}</textarea>
                </div>
                {{-- ATRIBUT LAIN --}}
                <div class="border border-indigo-300 p-2 rounded">
                    <div class="text-center">
                        <h3 class="font-bold">Atribut Lainnya</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="mb-3">
                            <label for="kondisi"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">kondisi</label>
                            <select id="kondisi" name="kondisi" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if (old('kondisi'))
                                    @if (old('kondisi') == '9')
                                        <option value="9" selected>9 - mulus</option>
                                    @else
                                        <option value="9">9 - mulus</option>
                                    @endif
                                    @if (old('kondisi') == '8')
                                        <option value="8" selected>8 - sedikit cacat/hampir tidak terlihat</option>
                                    @else
                                        <option value="8">8 - sedikit cacat/hampir tidak terlihat</option>
                                    @endif
                                    @if (old('kondisi') == '7')
                                        <option value="7" selected>7 - cacat jelas terlihat</option>
                                    @else
                                        <option value="7">7 - cacat jelas terlihat</option>
                                    @endif
                                    @if (old('kondisi') == '6')
                                        <option value="6" selected>6 - cacat banget</option>
                                    @else
                                        <option value="6">6 - cacat banget</option>
                                    @endif
                                    @if (old('kondisi') == '5')
                                        <option value="5" selected>5 - ancur / rusak</option>
                                    @else
                                        <option value="5">5 - ancur / rusak</option>
                                    @endif
                                @else
                                    <option value="9">9 - mulus</option>
                                    <option value="8">8 - sedikit cacat/hampir tidak terlihat</option>
                                    <option value="7">7 - cacat jelas terlihat</option>
                                    <option value="6">6 - cacat banget</option>
                                    <option value="5">5 - ancur / rusak</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label id="label_cap" for="cap"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">cap</label>
                            <input type="text" id="cap" name="cap"
                                value="{{ old('cap') ? old('cap') : '' }}" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="mb-3">
                            <label for="range_usia"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">range_usia</label>
                            <select id="range_usia" name="range_usia" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if (old('range_usia'))
                                    @if (old('range_usia') == 'dewasa')
                                        <option value="dewasa" selected>dewasa</option>
                                    @else
                                        <option value="dewasa">dewasa</option>
                                    @endif
                                    @if (old('range_usia') == 'anak')
                                        <option value="anak" selected>anak</option>
                                    @else
                                        <option value="anak">anak</option>
                                    @endif
                                    @if (old('range_usia') == 'bayi')
                                        <option value="bayi" selected>bayi</option>
                                    @else
                                        <option value="bayi">bayi</option>
                                    @endif
                                @else
                                    <option value="dewasa">dewasa</option>
                                    <option value="anak">anak</option>
                                    <option value="bayi">bayi</option>
                                @endif
                            </select>
                        </div>
                        <div id="div_ukuran" class="mb-3 hidden">
                            <label id="label_ukuran" for="ukuran"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ukuran(mm.)</label>
                            <input type="text" id="ukuran" name="ukuran"
                                value="{{ old('ukuran') ? old('ukuran') : '' }}" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div id="div_merk" class="mb-3 hidden">
                            <label id="label_merk" for="merk"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">merk</label>
                            <select id="merk" name="merk" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @if (old('merk'))
                                    @if (old('merk') == 'Antam')
                                        <option value="Antam" selected>Antam</option>
                                    @else
                                        <option value="Antam">Antam</option>
                                    @endif
                                    @if (old('merk') == 'UBS')
                                        <option value="UBS" selected>UBS</option>
                                    @else
                                        <option value="UBS">UBS</option>
                                    @endif
                                @else
                                    <option value="">--</option>
                                    <option value="Antam">Antam</option>
                                    <option value="UBS">UBS</option>
                                @endif
                            </select>
                        </div>
                        <div id="div_plat" class="mb-3 hidden">
                            <label id="label_plat" for="plat"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">plat</label>
                            <input type="number" step="1" max="9" min="0" id="plat"
                                name="plat" value="{{ old('plat') ? old('plat') : '' }}" onchange="generateNama()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>

                    <div id="div_mata" class="hidden">
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
                            {{-- <div id="data-mata-0" class="data-mata">
                            <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                                <div class="mb-1">
                                    <input type="text" id="warna_mata-0" name="warna_mata[]" value="{{ old('warna_mata.0') ? old('warna_mata.0') : '' }}" placeholder="warna_mata" class="warna-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                <div class="mb-1">
                                    <select id="level_warna" name="level_warna[]" class="level-warna bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @if (old('level_warna.0'))
                                        @if (old('level_warna.0') == 'neutral')
                                        <option value="neutral" selected>neutral</option>
                                        @else
                                        <option value="neutral">neutral</option>
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
                                        <option value="neutral">neutral</option>
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
                        </div> --}}
                        </div>
                    </div>

                    <div id="div_mainan" class="mt-2 hidden">
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
                            {{-- <div id="data-mainan-0" class="data-mainan">
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
                        </div> --}}
                        </div>
                    </div>
                </div>

            </div>

            {{-- TOMBOL ATRIBUT --}}
            <div class="fixed z-30 bottom-0 bg-violet-200 rounded w-4/5 px-2">
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="checkbox_mata" id="checkbox_mata"
                            onclick="toggleCheckbox(this, 'div_mata'); existElementMata(this); generateNama();"><label
                            for="checkbox_mata">mata</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="checkbox_mainan" id="checkbox_mainan"
                            onclick="toggleCheckbox(this, 'div_mainan'); existElementMainan(this); generateNama();"><label
                            for="checkbox_mainan"><label for="checkbox_mainan">mainan</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="toggle_ukuran" id="toggle_ukuran"
                            onclick="toggleCheckbox(this, 'div_ukuran')"><label for="toggle_ukuran">ukuran</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="toggle_merk" id="toggle_merk"
                            onclick="toggleCheckbox(this, 'div_merk')"><label for="toggle_merk">merk</label>
                    </div>
                    <div class="flex gap-1 items-center">
                        <input type="checkbox" name="toggle_plat" id="toggle_plat"
                            onclick="toggleCheckbox(this, 'div_plat')"><label for="toggle_plat">plat</label>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <button type="submit" class="loading-spinner bg-emerald-300 text-white p-5 rounded font-bold">+
                    Tambah Item Baru</button>
            </div>
        </form>

        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
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

        let index_mata = 0;

        function addMata() {
            //     document.getElementById('data_mata').insertAdjacentHTML('beforeend',
            //         `<div id="data-mata-${index_mata}">
        //     <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
        //         <div class="mb-1">
        //             <input type="text" id="warna_mata-${index_mata}" name="warna_mata[]" placeholder="warna_mata" class="warna-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        //         </div>
        //         <div class="mb-1">
        //             <select id="level_warna" name="level_warna[]" class="level-warna bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        //                 <option value="neutral">neutral</option>
        //                 <option value="tua">tua</option>
        //                 <option value="muda">muda</option>
        //             </select>
        //         </div>
        //         <div class="mb-1">
        //             <select id="opacity" name="opacity[]" class="opacity-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        //                 <option value="transparent">transparent</option>
        //                 <option value="non-transparent">non-transparent</option>
        //                 <option value="half-transparent">half-transparent</option>
        //             </select>
        //         </div>
        //         <div class="mb-1">
        //             <input type="text" id="jumlah_mata" name="jumlah_mata[]" placeholder="jumlah_mata" class="jumlah-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        //         </div>
        //     </div>
        //     <div class="flex justify-end mt-1">
        //         <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mata-${index_mata}')">
        //             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
        //                 <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
        //             </svg>
        //         </button>
        //     </div>
        // </div>`
            //     );

            //     setAutocompleteWarnaMata(`warna_mata-${index_mata}`, label_matas);
            addMata__(index_mata, label_matas);
            index_mata++;

        }

        // function setAutocompleteWarnaMata(element_id, source) {
        //     // console.log('run autocomplete mata');
        //     $(`#${element_id}`).autocomplete({
        //         source: source,
        //     });
        // }

        // setAutocompleteWarnaMata(`warna_mata-0`, label_matas);

        let index_mainan = 0;

        function addMainan() {
            //     document.getElementById('data_mainan').insertAdjacentHTML('beforeend',
            //         `<div id="data-mainan-${index_mainan}" class="data-mainan">
        //     <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
        //         <div class="mb-1">
        //             <input type="text" id="tipe_mainan-${index_mainan}" name="tipe_mainan[]" placeholder="tipe_mainan" class="tipe-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        //         </div>
        //         <div class="mb-1">
        //             <input type="text" id="jumlah_mainan-${index_mainan}" name="jumlah_mainan[]" placeholder="jumlah_mainan" class="jumlah-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        //         </div>
        //     </div>
        //     <div class="flex justify-end mt-1">
        //         <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mainan-${index_mainan}')">
        //             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
        //                 <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
        //             </svg>
        //         </button>
        //     </div>
        // </div>`
            //     );

            //     setAutocompleteMainan(`tipe_mainan-${index_mainan}`);
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
            console.log(checkbox_mainan.checked);
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
