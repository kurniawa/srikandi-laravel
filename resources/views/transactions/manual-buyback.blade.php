@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex">
        <div class="bg-white shadow drop-shadow p-2 rounded">
            <h3 class="text-xl font-bold text-slate-500">Manual Buyback</h3>
        </div>
    </div>

    <form action="{{ route('cashflow.store_manual_buyback_transaction') }}" method="POST" class="mt-5 border rounded p-2 text-slate-500">
        @csrf
        <label for="date" class="font-bold">Tanggal</label>
        <x-select-date></x-select-date>
        <div id="div-buyback-perhiasan" class="mt-3">
            <x-section-buyback-perhiasan :data=$data></x-section-buyback-perhiasan>
        </div>
        <div id="div-category-2" class="mt-3"></div>
        <div class="mt-2">
            <label for="keterangan_transaksi" class="font-bold">Keterangan Lain (.opt)</label>
            <div>
                <input type="text" name="keterangan_transaksi" id="keterangan_transaksi" class="rounded-lg border-slate-400 w-full">
            </div>
        </div>
        <x-metode-pembayaran :walletsnontunai=$wallets_non_tunai tipe="pengeluaran"></x-metode-pembayaran>
        <div class="mt-3 flex justify-center">
            <button type="submit" class="loading-spinner p-2 rounded-lg bg-emerald-300 text-white font-bold">Konfirmasi</button>
        </div>
        <input type="hidden" id="tipe_transaksi" name="tipe_transaksi" value="pengeluaran">
        <input type="hidden" id="kategori" name="kategori" value="Buyback Perhiasan">
    </form>

    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
</main>

<script>
    function hitungSisaBayar() {
        let harga_total = document.getElementById("harga_terima").value;
        const total_bayar = document.getElementById("total_bayar_real").value;
        const sisa_bayar = (parseFloat(harga_total) - parseFloat(total_bayar));
        document.getElementById('sisa_bayar_real').value = (pangkasDesimal(sisa_bayar) * 100).toString();
        document.getElementById('sisa_bayar_formatted').innerHTML = formatNumberX(preformatDotToComa(pangkasDesimal(sisa_bayar)));
        console.log(harga_total);
        // console.log(total_bayar);
        // console.log(sisa_bayar);
    }
</script>
@endsection

