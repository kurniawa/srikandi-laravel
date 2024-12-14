@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <div class="flex gap-1">
            <div class="bg-white shadow drop-shadow p-1 rounded flex gap-1 text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 1 0 0 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h1 class="font-bold">Accounting / Cash Flow</h1>
            </div>
            <x-filter-button></x-filter-button>
        </div>
        {{-- FILTER --}}
        <x-filter-tanggal></x-filter-tanggal>
        {{-- END - FILTER --}}
        
        <table class="w-full mt-5">
            <tr class="text-slate-500">
                <th></th>
                <th><span class="bg-rose-300 rounded font-bold text-white p-1">Rp {{ my_decimal_format($grand_total_pengeluaran) }}</span></th>
                <th><span class="bg-emerald-300 rounded font-bold text-white p-1">Rp {{ my_decimal_format($grand_total_pemasukan) }}</span></th>
            </tr>
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
                @if ($key % 2 == 0)
                <tr class="text-slate-400 font-bold bg-amber-100">
                @else
                <tr class="text-slate-400 font-bold bg-emerald-50">
                @endif
                    {{-- <th class="border-b">
                        <div class="text-left">
                            <div class="inline-block rounded-t-2xl bg-emerald-400 text-white text-xs p-1">
                                {{ $col_accounting['hari'] }}-{{ $col_accounting['bulan'] }}-{{ $col_accounting['tahun'] }}
                            </div>
                        </div>
                    </th> --}}
                    <th class="border-b">
                        <div class="flex">
                            <div class="bg-emerald-400 text-white text-xs font-bold rounded p-1">
                                <div>{{ $col_accounting['hari'] }}-{{ $col_accounting['bulan'] }}</div>
                                <div>{{ $col_accounting['tahun'] }}</div>
                            </div>
                        </div>
                    </th>
                    <th class="text-rose-400"><span class="border-2 border-rose-300 p-1 text-sm rounded-lg">{{ my_decimal_format($col_total[$key]['total_pengeluaran']) }}</span></th>
                    <th class="text-emerald-400"><span class="border-2 border-emerald-300 p-1 text-sm rounded-lg">{{ my_decimal_format($col_total[$key]['total_pemasukan']) }}</span></th>
                    {{-- <th class="text-sm text-yellow-500">{{ my_decimal_format($col_wallets[$key]['wallet_awal']) }}</th>
                    <th class="text-sm text-indigo-500">{{ my_decimal_format($col_wallets[$key]['wallet_akhir']) }}</th> --}}
                </tr>
                @foreach ($col_accounting['accountings'] as $accounting)
                    @if ($key % 2 == 0)
                    <tr class="border-t text-xs font-bold text-slate-500 bg-amber-100">
                    @else
                    <tr class="border-t text-xs font-bold text-slate-500 bg-emerald-50">
                    @endif
                    {{-- <tr class="border-t text-xs font-bold text-slate-500"> --}}
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
                    @if ($key % 2 == 0)
                    <tr class="bg-amber-100">
                    @else
                    <tr class="bg-emerald-50">
                    @endif
                        @if ($accounting->tipe === 'pemasukan')
                            <td></td>
                            <td></td>
                            <td class="py-1">
                                <div class="text-center text-emerald-600 font-bold text-sm">
                                    {{ my_decimal_format($accounting->jumlah) }}</div>
                            </td>
                        @else
                            <td></td>
                            <td>
                                <div class="text-center text-rose-600 font-bold text-sm">
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
        @auth
        @if ($user->clearance_level >= 5)
        <div>
            <div class="mt-5 p-2 border rounded-lg">
                <table class="text-slate-400 font-bold w-full">
                    @foreach ($wallets as $key_wallet => $wallet)
                        @if ($wallet->saldo !== null)
                            <tr>
                                <td>{{ $wallet->nama_wallet }}</td>
                                <td>:</td>
                                <td>Rp {{ my_decimal_format($wallet->saldo) }}</td>
                                <td>
                                    <button type="button" onclick="toggle_element('form-edit-saldo-wallet-{{ $key_wallet }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr id="form-edit-saldo-wallet-{{ $key_wallet }}" class="hidden">
                                <td colspan="4">
                                    <form action="{{ route('cashflow.update_saldo_wallet') }}" method="POST" onsubmit="submitWithPreserveScroll(this, 'update_saldo_wallet')">
                                        @csrf
                                        <input type="text" name="formatted_saldo_wallet" id="formatted_saldo_wallet-{{ $key_wallet }}" placeholder="new saldo ..." 
                                            class="rounded-lg border-slate-400"
                                            onchange="formatNumber(this, 'saldo_wallet-{{ $key_wallet }}')">
                                        <input type="hidden" name="saldo_wallet" id="saldo_wallet-{{ $key_wallet }}">
                                        <input type="hidden" name="wallet_id" id="wallet_id-{{ $key_wallet }}" value="{{ $wallet->id }}">
                                        <div class="mt-1 text-center">
                                            <button type="submit" class="bg-emerald-300 text-white rounded p-1">Konfirmasi</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        @endif
        @endauth
        <script>
            getScrollLocation('update_saldo_wallet');
        </script>
    </main>
@endsection
