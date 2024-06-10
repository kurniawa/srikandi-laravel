@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <div class="flex">
            <div class="bg-white shadow drop-shadow p-1 rounded">
                <h1 class="font-bold text-slate-500">Accounting / Cash Flow</h1>
            </div>
        </div>
        <div class="flex justify-end">
            <table class="text-slate-400 text-xs font-bold border">
                @foreach ($saldos as $saldo)
                <tr><td>{{ $saldo->nama_wallet }}</td><td>:</td><td>Rp {{ my_decimal_format($saldo->saldo_akhir) }}</td></tr>
                @endforeach
            </table>
        </div>
        <table class="w-full mt-5">
            <tr class="text-slate-500"><th></th><th>Saldo Awal</th><th>Saldo Akhir</th></tr>
            @foreach ($col_cashflows as  $key => $col_cashflow)
            <tr class="text-slate-400 font-bold">
                <th class="border-b">
                    <div class="text-left">
                        <div class="inline-block rounded-t-2xl bg-emerald-400 text-white text-xs p-1">{{ $col_cashflow["hari"] }}-{{ $col_cashflow["bulan"] }}-{{ $col_cashflow["tahun"] }}</div>
                    </div>
                    {{-- <div class="inline-block bg-emerald-400 rounded p-1 text-white">
                        <div>{{ $col_cashflow["hari"] }}-{{ $col_cashflow["bulan"] }}</div>
                        <div>{{ $col_cashflow["tahun"] }}</div>
                    </div> --}}
                </th>
                <th class="text-sm text-yellow-500">{{ my_decimal_format($col_saldos[$key]['saldo_awal']) }}</th>
                <th class="text-sm text-indigo-500">{{ my_decimal_format($col_saldos[$key]['saldo_akhir']) }}</th>
            </tr>
            @foreach ($col_cashflow["cashflows"] as $cashflow)
            <tr class="border-t text-xs font-bold text-slate-500">
                @if ($cashflow->surat_pembelian_id)
                <td colspan="2" class="py-1"><div class="text-center">{{ $cashflow->user->username }} - {{ $cashflow->surat_pembelian->pelanggan_nama }} - <a href="{{ route('surat_pembelian.show', $cashflow->id) }}" class="text-sky-400 font-bold">{{ $cashflow->surat_pembelian->nomor_surat }}</a> - {{ $cashflow->nama_wallet }}</div></td>
                @else
                @if ($cashflow->accounting->kategori_2)
                <td colspan="2" class="py-1"><div class="text-center">{{ $cashflow->user->username }} - {{ $cashflow->surat_pembelian->pelanggan_nama }} - {{ $cashflow->accounting->kategori_2 }} - {{ $cashflow->nama_wallet }}</div></td>
                @else
                <td colspan="2" class="py-1"><div class="text-center">{{ $cashflow->user->username }} - {{ $cashflow->surat_pembelian->pelanggan_nama }} - {{ $cashflow->accounting->kategori }} - {{ $cashflow->nama_wallet }}</div></td>
                @endif
                @endif
                {{-- <td class="py-1"><div>{{ pangkas_string_25($cashflow->surat_pembelian_item->item->nama_short) }}</div></td> --}}
                <td class="py-1">
                    @if ($cashflow->tipe === "pemasukan")
                    <div class="text-center text-emerald-400 font-bold">{{ my_decimal_format($cashflow->jumlah) }}</div>
                    @else
                    <div class="text-center text-rose-400 font-bold">{{ my_decimal_format($cashflow->jumlah) }}</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">
                    <div class="border-b"></div>
                </td>
            </tr>
            @endforeach
        </table>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
