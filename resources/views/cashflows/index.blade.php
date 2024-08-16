@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <div class="flex">
            <div class="bg-white shadow drop-shadow p-1 rounded flex gap-1 text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 1 0 0 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h1 class="font-bold">Accounting / Cash Flow</h1>
            </div>
        </div>
        
        <table class="w-full mt-5">
            <tr class="text-slate-500">
                <th></th>
                <th>Pengeluaran</th>
                <th>Pemasukan</th>
            </tr>
            {{-- @foreach ($col_cashflows as $key => $col_cashflow)
                <tr class="text-slate-400 font-bold">
                    <th class="border-b">
                        <div class="text-left">
                            <div class="inline-block rounded-t-2xl bg-emerald-400 text-white text-xs p-1">
                                {{ $col_cashflow['hari'] }}-{{ $col_cashflow['bulan'] }}-{{ $col_cashflow['tahun'] }}</div>
                        </div>
                    </th>
                    <th class="text-sm text-yellow-500">{{ my_decimal_format($col_wallets[$key]['wallet_awal']) }}</th>
                    <th class="text-sm text-indigo-500">{{ my_decimal_format($col_wallets[$key]['wallet_akhir']) }}</th>
                </tr>
                @foreach ($col_cashflow['cashflows'] as $cashflow)
            <tr class="border-t text-xs font-bold text-slate-500">
                @if ($cashflow->surat_pembelian_id)
                    <td colspan="2" class="py-1">
                        <div class="text-center">{{ $cashflow->user->username }} -
                            {{ $cashflow->surat_pembelian->pelanggan_nama }} - <a
                                href="{{ route('surat_pembelian.show', $cashflow->id) }}"
                                class="text-sky-400 font-bold">{{ $cashflow->surat_pembelian->nomor_surat }}</a> -
                            {{ $cashflow->nama_wallet }}</div>
                    </td>
                @else
                    @if ($cashflow->accounting->kategori_2)
                        <td colspan="2" class="py-1">
                            <div class="text-center">{{ $cashflow->user->username }} -
                                {{ $cashflow->surat_pembelian->pelanggan_nama }} -
                                {{ $cashflow->accounting->kategori_2 }} - {{ $cashflow->nama_wallet }}</div>
                        </td>
                    @else
                        <td colspan="2" class="py-1">
                            <div class="text-center">{{ $cashflow->user->username }} -
                                {{ $cashflow->surat_pembelian->pelanggan_nama }} -
                                {{ $cashflow->accounting->kategori }} - {{ $cashflow->nama_wallet }}</div>
                        </td>
                    @endif
                @endif
                <td class="py-1">
                    @if ($cashflow->tipe === 'pemasukan')
                        <div class="text-center text-emerald-400 font-bold">
                            {{ my_decimal_format($cashflow->jumlah) }}</div>
                    @else
                        <div class="text-center text-rose-400 font-bold">{{ my_decimal_format($cashflow->jumlah) }}
                        </div>
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
            @endforeach --}}
            @foreach ($col_accountings as $key => $col_accounting)
                <tr class="text-slate-400 font-bold">
                    <th class="border-b">
                        <div class="text-left">
                            <div class="inline-block rounded-t-2xl bg-emerald-400 text-white text-xs p-1">
                                {{ $col_accounting['hari'] }}-{{ $col_accounting['bulan'] }}-{{ $col_accounting['tahun'] }}
                            </div>
                        </div>
                    </th>
                    <th class="text-rose-400">{{ my_decimal_format($col_total[$key]['total_pengeluaran']) }}</th>
                    <th class="text-emerald-400">{{ my_decimal_format($col_total[$key]['total_pemasukan']) }}</th>
                    {{-- <th class="text-sm text-yellow-500">{{ my_decimal_format($col_wallets[$key]['wallet_awal']) }}</th>
                    <th class="text-sm text-indigo-500">{{ my_decimal_format($col_wallets[$key]['wallet_akhir']) }}</th> --}}
                </tr>
                @foreach ($col_accounting['accountings'] as $accounting)
                    <tr class="border-t text-xs font-bold text-slate-500">
                        <td colspan="3" class="py-1">
                            @if ($accounting->user)
                                @if ($accounting->surat_pembelian)
                                <div class="text-center">{{ $accounting->user->username }} - {{ $accounting->surat_pembelian->pelanggan_nama ? $accounting->surat_pembelian->pelanggan_nama : ''}} -
                                @else
                                <div class="text-center">{{ $accounting->user->username }} -
                                @endif
                                @if ($accounting->surat_pembelian_id)
                                    <a href="{{ route('surat_pembelian.show', $accounting->surat_pembelian_id) }}" class="text-sky-400 font-bold">{{ $accounting->surat_pembelian->nomor_surat }}</a>
                                    <span>-</span>
                                @endif
                                @if ($accounting->kategori_2)
                                    {{ $accounting->kategori_2 }}
                                @else
                                    {{ $accounting->kategori }}
                                @endif
                            </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        @if ($accounting->tipe === 'pemasukan')
                            <td></td>
                            <td></td>
                            <td class="py-1">
                                <div class="text-center text-emerald-300 font-bold">
                                    {{ my_decimal_format($accounting->jumlah) }}</div>
                            </td>
                        @else
                            <td></td>
                            <td>
                                <div class="text-center text-rose-300 font-bold">
                                    {{ my_decimal_format($accounting->jumlah) }}
                                </div>
                            </td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </table>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
        <div class="mt-5">
            <table class="text-slate-400 font-bold border">
                @foreach ($wallets as $wallet)
                    @if ($wallet->saldo !== null)
                        <tr>
                            <td>{{ $wallet->nama }}</td>
                            <td>:</td>
                            <td>Rp {{ my_decimal_format($wallet->saldo) }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </main>
@endsection
