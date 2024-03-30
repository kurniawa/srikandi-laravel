@extends('layouts.main')
@section('content')
<main>
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <form action="{{ route('items.store', $from) }}" method="POST">
        @csrf
        <div class="p-2">
            <div class="grid grid-cols-2 gap-2">
                <div class="">
                    <label for="tipe_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe barang</label>
                    <input type="text" id="tipe_barang" name="tipe_barang" value="{{ $tipe_barang }}" readonly class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-5">
                    <label for="tipe_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe perhiasan</label>
                    <select id="tipe_perhiasan" onchange="pilihanJenisPerhiasan(this.value);generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">--</option>
                        @foreach ($tipe_perhiasans as $tipe_perhiasan)
                        <option value='{ "id":{{ $tipe_perhiasan->id }}, "nama": "{{ $tipe_perhiasan->nama }}" }'>{{ $tipe_perhiasan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-5">
                    <label id="label_jenis_perhiasan" for="jenis_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">jenis ...</label>
                    <input type="text" name="jenis_perhiasan" id="jenis_perhiasan" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-5">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">deskripsi (opt.)</label>
                    <input type="text" id="deskripsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-5">
                    <label for="warna_emas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">warna emas</label>
                    <select id="warna_emas" name="warna_emas" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="kuning">kuning</option>
                        <option value="rose gold">rose gold</option>
                        <option value="putih">putih</option>
                        <option value="chrome">chrome</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-5">
                    <label id="label_kadar_formatted" for="kadar_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">kadar(%)</label>
                    <input type="text" id="kadar_formatted" onchange="formatNumber(this, 'kadar');generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="kadar" name="kadar">
                </div>
                <div class="mb-5">
                    <label id="label_berat_formatted" for="berat_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">berat</label>
                    <input type="text" id="berat_formatted" onchange="formatNumber(this, 'berat');hitungHargaGrOrT();generateNama();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="berat" name="berat">
                </div>
                <div class="mb-5">
                    <label id="label_harga_gr_formatted" for="harga_gr_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga_gr</label>
                    <input type="text" id="harga_gr_formatted" onchange="formatNumber(this, 'harga_gr');hitungHargaT();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="harga_gr" name="harga_gr">
                </div>
                <div class="mb-5">
                    <label id="label_harga_t_formatted" for="harga_t_formatted" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">harga_t</label>
                    <input type="text" id="harga_t_formatted" onchange="formatNumber(this, 'harga_t');hitungHargaGr();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" id="harga_t" name="harga_t">
                </div>
            </div>
            <div class="mb-5 border border-emerald-300 rounded p-1">
                <label id="label_nama_short" for="nama_short" class="block text-sm font-medium text-gray-900 dark:text-white">nama_short</label>
                <input type="text" id="nama_short" name="nama_short" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <label id="label_nama_long" for="nama_long" class="mt-1 block text-sm font-medium text-gray-900 dark:text-white">nama_long</label>
                <textarea id="nama_long" name="nama_long" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                {{-- <input type="text" id="nama_long" name="nama_long" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"> --}}
            </div>
            <div class="mb-5">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">keterangan (opt.)</label>
                <textarea id="keterangan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
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
                            <option value="99">99 - mulus</option>
                            <option value="80">80 - sedikit cacat/hampir tidak terlihat</option>
                            <option value="70">70 - cacat jelas terlihat</option>
                            <option value="60">60 - cacat banget</option>
                            <option value="50">50 - ancur / rusak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label id="label_cap" for="cap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">cap</label>
                        <input type="text" id="cap" name="cap" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-3">
                        <label for="range_usia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">range_usia</label>
                        <select id="range_usia" name="range_usia" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="dewasa">dewasa</option>
                            <option value="anak">anak</option>
                            <option value="bayi">bayi</option>
                        </select>
                    </div>
                    <div id="div_ukuran" class="mb-3 hidden">
                        <label id="label_ukuran" for="ukuran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ukuran(mm.)</label>
                        <input type="text" id="ukuran" name="ukuran" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div id="div_merk" class="mb-3 hidden">
                        <label id="label_merk" for="merk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">merk</label>
                        <select id="merk" name="merk" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">--</option>
                            <option value="Antam">Antam</option>
                            <option value="UBS">UBS</option>
                        </select>
                    </div>
                    <div id="div_plat" class="mb-3 hidden">
                        <label id="label_plat" for="plat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">plat</label>
                        <input type="number" step="1" max="9" min="0" id="plat" name="plat" onchange="generateNama()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                                    <input type="text" id="warna_mata" name="warna_mata[]" placeholder="warna_mata" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                <div class="mb-1">
                                    <select id="level_warna" name="level_warna[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="netral">netral</option>
                                        <option value="tua">tua</option>
                                        <option value="muda">muda</option>
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <select id="opacity" name="opacity[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="transparent">transparent</option>
                                        <option value="non-transparent">non-transparent</option>
                                        <option value="half-transparent">half-transparent</option>
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <input type="text" id="jumlah_mata" name="jumlah_mata[]" placeholder="jumlah_mata" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                                    <input type="text" id="tipe_mainan" name="tipe_mainan[]" placeholder="tipe_mainan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                <div class="mb-1">
                                    <input type="text" id="jumlah_mainan" name="jumlah_mainan[]" placeholder="jumlah_mainan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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

    function pilihanJenisPerhiasan(data_tipe_perhiasan) {
        // console.log(data_tipe_perhiasan);
        // console.log(JSON.parse(data_tipe_perhiasan));
        var tipe_perhiasan = JSON.parse(data_tipe_perhiasan);

        if (tipe_perhiasan.id) {
            // console.log(tipe_perhiasan.id)
            var pilihan_jenis_perhiasans = jenis_perhiasans.filter((o) => o.tipe_perhiasan_id == tipe_perhiasan.id);
            // console.log(pilihan_jenis_perhiasans);
            $('#jenis_perhiasan').autocomplete({
                source: pilihan_jenis_perhiasans,
                select: function (event, ui) {
                    document.getElementById('jenis_perhiasan').value = ui.item.value;
                    generateNama();
                }
            })
            document.getElementById('label_jenis_perhiasan').textContent = `jenis ${tipe_perhiasan.nama}`
        }
    }

    let index_mata = 1;
    function addMata() {
        document.getElementById('data_mata').insertAdjacentHTML('beforeend',
        `<div id="data-mata-${index_mata}">
            <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                <div class="mb-1">
                    <input type="text" id="warna_mata" name="warna_mata" placeholder="warna_mata" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-1">
                    <select id="level_warna" name="level_warna" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="netral">netral</option>
                        <option value="tua">tua</option>
                        <option value="muda">muda</option>
                    </select>
                </div>
                <div class="mb-1">
                    <select id="opacity" name="opacity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="transparent">transparent</option>
                        <option value="non-transparent">non-transparent</option>
                        <option value="half-transparent">half-transparent</option>
                    </select>
                </div>
                <div class="mb-1">
                    <input type="text" id="jumlah_mata" name="jumlah_mata" placeholder="jumlah_mata" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
        index_mata++;

    }

    function setAutocompleteWarnaMata(element_id, source) {

    }

    let index_mainan = 0;
    function addMainan() {
        document.getElementById('data_mainan').insertAdjacentHTML('beforeend',
        `<div id="data-mainan-${index_mainan}" class="data-mainan">
            <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
                <div class="mb-1">
                    <input type="text" id="tipe_mainan" name="tipe_mainan[]" placeholder="tipe_mainan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div class="mb-1">
                    <input type="text" id="jumlah_mainan" name="jumlah_mainan[]" placeholder="jumlah_mainan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
        index_mainan++;
    }

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
        let harga_gr = parseFloat(document.getElementById('harga_gr').value);
        // console.log(berat);
        // console.log(harga_gr);
        if (!isNaN(berat) && !isNaN(harga_gr)) {
            let harga_t = formatDecimal(berat * harga_gr);
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
            let harga_gr = formatDecimal(harga_t / berat);
            let harga_gr_formatted = document.getElementById('harga_gr_formatted');
            harga_gr_formatted.value = harga_gr.toString().split('.').join(',');
            // console.log(harga_gr)
            formatNumber2('harga_gr_formatted', 'harga_gr');
        }
    }

    function hitungHargaGrOrT() {
        let berat = parseFloat(document.getElementById('berat').value);
        let harga_gr = parseFloat(document.getElementById('harga_gr').value);
        let harga_t = parseFloat(document.getElementById('harga_t').value);
        if (!isNaN(berat) && !isNaN(harga_gr)) {
            let harga_t = formatDecimal(berat * harga_gr);
            let harga_t_formatted = document.getElementById('harga_t_formatted');
            harga_t_formatted.value = harga_t.toString().split('.').join(',');
            formatNumber2('harga_t_formatted', 'harga_t');
        } else if (!isNaN(berat) && !isNaN(harga_t)) {
            let harga_gr = formatDecimal(harga_t / berat);
            let harga_gr_formatted = document.getElementById('harga_gr_formatted');
            harga_gr_formatted.value = harga_gr.toString().split('.').join(',')
            formatNumber2('harga_gr_formatted', 'harga_gr');
        }
    }

    function formatDecimal(params) {
        let str_params = params.toString();
        let splitted_params = str_params.split(".");
        // console.log(splitted_params);
        if (splitted_params.length === 2) {
            // console.log('desimal');
            params = parseFloat(params.toFixed(2));
        }
        // console.log(params);
        return params;
    }

    function generateNama() {
        let string_array_tipe_perhiasan = document.getElementById('tipe_perhiasan').value;
        let json_tipe_perhiasan = JSON.parse(string_array_tipe_perhiasan);
        let tipe_perhiasan = json_tipe_perhiasan.nama;
        let jenis_perhiasan = document.getElementById('jenis_perhiasan').value;
        let warna_emas = document.getElementById('warna_emas').value;
        if (warna_emas === 'kuning') {
            warna_emas = ''
        } else {
            warna_emas = `<${warna_emas}>`;
        }
        let kadar = document.getElementById('kadar').value;
        let berat = document.getElementById('berat').value;
        let kondisi = document.getElementById('kondisi').value;
        let cap = document.getElementById('cap').value;
        let range_usia = document.getElementById('range_usia').value;
        let ukuran = document.getElementById('ukuran').value;
        let merk = document.getElementById('merk').value;
        let plat = document.getElementById('plat').value;

        let nama_short = `${tipe_perhiasan} ${jenis_perhiasan} ${warna_emas} ${kadar}% ${berat}gr.`;
        let nama_long = `${tipe_perhiasan} ${jenis_perhiasan} ${warna_emas} ${kadar}% ${berat}gr. zu:${kondisi} c:${cap} ru:${range_usia} merk:${merk} plat:${plat}`;
        // nama_long = nama_long.split("  ").join(" ");
        document.getElementById('nama_short').value = nama_short;
        document.getElementById('nama_long').value = nama_long;
    }
</script>
@endsection

