@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex">
        <div class="bg-white shadow drop-shadow p-2 rounded">
            <h3 class="text-xl font-bold text-slate-500">Transaksi {{ ucfirst($tipe) }}</h3>
        </div>
    </div>

    <form action="{{ route('cashflow.store_transaction') }}" method="POST" class="mt-5 border rounded p-2 text-slate-500">
        @csrf
        <div>
            <input type="text" name="tipe_transaksi" id="tipe_transaksi" value="{{ $tipe }}" readonly class="bg-slate-100 rounded-lg">
        </div>
        <div class="mt-3">
            <label for="kategori" class="font-bold">Kategori</label>
            <div>
                <select name="kategori" id="kategori" onchange="getCategories2(this.value)" class="p-2 rounded-lg"></select>
            </div>
        </div>
        <div id="div-buyback-perhiasan" class="mt-3 hidden">
            <x-section-buyback-perhiasan :data=$data></x-section-buyback-perhiasan>
        </div>
        <div id="div-category-2" class="mt-3"></div>
        <div id="div-total-tagihan" class="mt-3">
            <label for="harga" class="font-bold">Harga</label>
            <div>
                <input type="text" name="total_tagihan_formatted" id="total_tagihan_formatted" onchange="formatNumber(this, 'total_tagihan_real'); hitungSisaBayar()" class="rounded-lg">
                <input type="hidden" name="total_tagihan" id="total_tagihan_real">
            </div>
        </div>
        <div class="mt-2">
            <label for="keterangan_transaksi" class="font-bold">Keterangan Lain (.opt)</label>
            <div>
                <input type="text" name="keterangan_transaksi" id="keterangan_transaksi" class="rounded-lg border-slate-400 w-full">
            </div>
        </div>
        <x-metode-pembayaran :walletsnontunai=$wallets_non_tunai :tipe=$tipe></x-metode-pembayaran>
        <div class="mt-3 flex justify-center">
            <button type="submit" class="loading-spinner p-2 rounded-lg bg-emerald-300 text-white font-bold">Konfirmasi</button>
        </div>
    </form>

    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
</main>

<script>
    const tipe = {!! json_encode($tipe, JSON_HEX_TAG) !!};
    const acuan_pembukuans = {!! json_encode($acuan_pembukuans, JSON_HEX_TAG) !!};
    // console.log(acuan_pembukuans);
    const filtered_acuans = acuan_pembukuans.filter((o) => o.tipe == tipe);

    getCategories();

    function getCategories() {
        // console.log(filtered_acuans);

        const categories = new Array();
        filtered_acuans.forEach(acuan => {
            categories.push(acuan.kategori);
        });
        // console.log(categories);

        const filtered_categories = categories.filter((value, index) => categories.indexOf(value) === index);
        // console.log(filtered_categories);
        const select_category = document.getElementById('kategori');
        let html_select_category = "";
        filtered_categories.forEach(category => {
            html_select_category += `<option value="${category}">${category}</option>`;
        });
        select_category.innerHTML = html_select_category;
        getCategories2(filtered_categories[0]);
    }

    function getCategories2(category) {
        // console.log(category);
        if (category == "Buyback Perhiasan") {
            $("#div-buyback-perhiasan").show(300);
            $("#div-total-tagihan").hide(300);
            const div_category_2 = document.getElementById('div-category-2');
            // console.log(div_category_2.innerHTML);
            if (div_category_2.innerHTML) {
                div_category_2.innerHTML = "";
            }
            return true;
        } else {
            $("#div-buyback-perhiasan").hide(300);
            $("#div-total-tagihan").show(300);
        }
        const filtered_acuans_2 = filtered_acuans.filter((o) => o.kategori == category);
        // console.log(filtered_acuans_2);
        const categories_2 = new Array();
        filtered_acuans_2.forEach(acuan => {
            if (acuan.kategori_2) {
                categories_2.push(acuan.kategori_2);
            }
        });
        // console.log(categories_2);
        const div_category_2 = document.getElementById('div-category-2');
        if (categories_2.length) {
            // console.log('ada kategori 2');
            let html_select_category_2 = '<label class="font-bold">Kategori-2</label><div><select name="kategori_2" class="p-2 rounded-lg"><option value="">-</option>';
            categories_2.forEach(category => {
                html_select_category_2 += `<option value="${category}">${category}</option>`
            });
            html_select_category_2 += `</select></div>`;
            div_category_2.innerHTML = html_select_category_2;
        } else {
            div_category_2.innerHTML = "";
        }
    }

    function hitungSisaBayar() {
        let harga_total = document.getElementById("total_tagihan_real").value;
        const kategori = document.getElementById('kategori').value;
        // console.log(kategori);
        if (kategori == "Buyback Perhiasan") {
            harga_total = document.getElementById("harga_t").value;
        }
        const total_bayar = document.getElementById("total_bayar_real").value;
        const sisa_bayar = (parseFloat(harga_total) - parseFloat(total_bayar));
        document.getElementById('sisa_bayar_real').value = (pangkasDesimal(sisa_bayar) * 100).toString();
        document.getElementById('sisa_bayar_formatted').innerHTML = formatNumberX(preformatDotToComa(pangkasDesimal(sisa_bayar)));
        // console.log(harga_total);
        // console.log(total_bayar);
        // console.log(sisa_bayar);
    }
</script>
@endsection

