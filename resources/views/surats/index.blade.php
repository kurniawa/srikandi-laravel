@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <h1 class="text-2xl font-bold text-slate-500">Surat Pembelian</h1>
        <table class="w-full mt-5">
            <tr class="text-slate-400"><th>Tgl.</th><th>U</th><th>Cust.</th><th>T</th></tr>
            @foreach ($surat_pembelians as $key => $surat_pembelian)
            <tr class="border-t">
                <td class="pt-1" onclick="$('#surat_pembelian_items-{{ $key }}').toggle(300)">
                    <div class="flex justify-center font-bold">
                        @if ($surat_pembelian->status_bayar === 'lunas')
                        <div class="p-1 rounded text-white border-2 bg-emerald-400 border-emerald-500">
                        @else
                        <div class="p-1 rounded text-white border-2 bg-yellow-400 border-yellow-500">
                        @endif
                            <div class="text-center">{{ date("d-m", strtotime($surat_pembelian->tanggal_surat)) }}</div>
                            <div class="text-center">{{ date("Y", strtotime($surat_pembelian->tanggal_surat)) }}</div>
                        </div>
                    </div>
                </td>
                <td class="py-1"><div class="text-center">{{ $surat_pembelian->username }}</div></td>
                <td class="py-1"><div class="text-center">{{ $surat_pembelian->pelanggan_nama }}</div></td>
                <td class="py-1"><div class="text-center">{{ my_decimal_format($surat_pembelian->harga_total) }}</div></td>
            </tr>
            <tr class="border-b">
                <td colspan="4" class="pb-1">
                    <div id="surat_pembelian_items-{{ $key }}" class="border border-indigo-400 rounded p-2">
                        <h3 class="font-bold text-slate-500">Data Barang:</h3>
                        <div class="flex gap-1 justify-between items-center border-y">
                            @foreach ($surat_pembelian->items as $item)
                            <span>{{ $item->nama_short }}</span>
                            <div class="text-xs">
                                <div>@ {{ my_decimal_format($item->harga_g) }}</div>
                                <div>o: {{ my_decimal_format($item->ongkos_g) }}</div>
                                <div>{{ my_decimal_format($item->harga_t) }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-end mt-1">
                            <button class="bg-yellow-200 text-slate-400 px-2 py-1 rounded-xl border border-yellow-400">Detail</button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button>
    </main>
@endsection
