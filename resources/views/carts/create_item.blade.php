@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="grid grid-cols-2 gap-2">
        <div class="">
            <label for="tipe_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe barang</label>
            <input type="text" id="tipe_barang" name="tipe_barang" value="{{ $tipe_barang }}" readonly class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-5">
            <label for="tipe_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe perhiasan</label>
            <select id="tipe_perhiasan" onchange="pilihanJenisPerhiasan(this.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">--</option>
                @foreach ($tipe_perhiasans as $tipe_perhiasan)
                <option value='{ "id":{{ $tipe_perhiasan->id }}, "nama": "{{ $tipe_perhiasan->nama }}" }'>{{ $tipe_perhiasan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-5">
            <label id="label_jenis_perhiasan" for="jenis_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">jenis ...</label>
            <input type="text" id="jenis_perhiasan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-5">
            <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">deskripsi (opt.)</label>
            <input type="text" id="deskripsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-5">
            <label for="warna_emas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">warna emas</label>
            <select id="warna_emas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="kuning">kuning</option>
                <option value="rose gold">rose gold</option>
                <option value="putih">putih</option>
                <option value="chrome">chrome</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-2">

    </div>
</main>

<script>
    let jenis_perhiasans = {!! json_encode($jenis_perhiasans, JSON_HEX_TAG) !!}
    // console.log(jenis_perhiasans);
    // $('#tipe_perhiasan').autocomplete({
    //     source: jenis_perhiasans,
    //     select: function (event, ui) {
    //         document.getElementById('tipe_perhiasan').value = ui.item.value;
    //     }
    // });

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
                }
            })
            document.getElementById('label_jenis_perhiasan').textContent = `jenis ${tipe_perhiasan.nama}`
        }
    }
</script>
@endsection

