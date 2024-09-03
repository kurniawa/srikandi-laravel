@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div class="mt-3 text-xs font-bold text-slate-400 border rounded p-1">
            <p class="">Nomor Surat/ Invoice-ID: {{ $surat_pembelian->nomor_surat }}</p>
            <p class="">By: {{ $surat_pembelian->user->username }}</p>
            <p class="">Customer: {{ $surat_pembelian->pelanggan->nama }} ({{ $surat_pembelian->pelanggan->username }})</p>
        </div>
        <form action="{{ route('surat_pembelian.proceed_cancel_buyback', [$surat_pembelian->id, $surat_pembelian_item->id]) }}" method="POST" class="mt-5">
            @csrf
            <x-item-listed :suratpembelianitem="$surat_pembelian_item"></x-item-listed>
            <div class="text-center">
                <p class="text-slate-600 font-bold">Anda yakin ingin membatalkan buyback item ini?</p>
                <button type="submit" class="bg-red-300 rounded p-2 text-white font-bold mt-2">Konfirmasi</button>
            </div>
            <div class="flex justify-center mt-5">
                <button type="button" onclick="window.history.back()" class="bg-red-400 rounded p-2 text-white font-bold">Kembali</button>
            </div>
        </form>
    </main>
@endsection
