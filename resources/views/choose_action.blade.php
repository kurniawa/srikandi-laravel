@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex">
        <div class="bg-white shadow drop-shadow p-2 rounded">
            <h3 class="text-xl font-bold text-slate-500">Pilih Transaksi</h3>
        </div>
    </div>

    <div class="mt-5 border rounded p-2">
        <div class="mt-3">
            <a href="{{ route('add_new_item.pilih_tipe_barang', 'items') }}" class="loading-spinner bg-indigo-300 text-white p-2 rounded">Tambah Item Baru</a>
        </div>
        <div class="mt-6">
            <a href="{{ route('cashflow.transaksi', 'pemasukan') }}" class="loading-spinner bg-emerald-300 text-white p-2 rounded">Pemasukan</a>
        </div>
        <div class="mt-6">
            <a href="{{ route('cashflow.transaksi', 'pengeluaran') }}" class="loading-spinner bg-rose-300 text-white p-2 rounded">Pengeluaran</a>
        </div>

    </div>
    {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
</main>
@endsection

