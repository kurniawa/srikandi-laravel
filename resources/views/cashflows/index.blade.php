@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <h1 class="text-2xl font-bold text-slate-500">Accounting / Cash Flow</h1>
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
                <td colspan="2" class="py-1"><div class="text-center">{{ $cashflow->user->username }} - {{ $cashflow->surat_pembelian->pelanggan_nama }} - {{ $cashflow->nama_wallet }}</div></td>
                {{-- <td class="py-1"><div>{{ pangkas_string_25($cashflow->surat_pembelian_item->item->nama_short) }}</div></td> --}}
                <td class="py-1">
                    @if ($cashflow->tipe === "pemasukan")
                    <div class="text-center text-emerald-400 font-bold">{{ my_decimal_format($cashflow->jumlah) }}</div>
                    @else
                    <div class="text-center text-rose-400 font-bold">{{ my_decimal_format($cashflow->jumlah) }}</div>
                    @endif
                </td>
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
