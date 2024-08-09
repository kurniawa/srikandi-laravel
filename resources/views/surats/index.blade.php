@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <div class="flex items-center gap-2">
            <div class="bg-white shadow drop-shadow p-2 rounded flex gap-2 items-center text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>
                <h1 class="font-bold">Surat Pembelian</h1>
            </div>
            <div>
                <button id="btn-filter" class="border-2 border-yellow-300 rounded p-1 text-yellow-400"
                    onclick="toggle_light(this.id, 'div-filter', ['text-yellow-400'], ['bg-yellow-200', 'text-slate-300'], 'block')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </div>
        {{-- FILTER --}}
        <x-filter-tanggal></x-filter-tanggal>
        {{-- END - FILTER --}}
        <table class="w-full mt-5">
            <tr class="text-slate-400">
                <th>Tgl.</th>
                <th>U</th>
                <th>Cust.</th>
                <th>T</th>
            </tr>
            @foreach ($surat_pembelians as $key => $surat_pembelian)
                <tr class="border-t">
                    <td class="pt-1" onclick="$('#surat_pembelian_items-{{ $key }}').toggle(300)">
                        <div class="flex justify-center font-bold">
                            @if ($surat_pembelian->status_buyback == 'all')
                                <div class="rounded text-white border-2 bg-slate-400 border-slate-500">
                                @elseif ($surat_pembelian->status_buyback == 'sebagian')
                                    <div class="rounded text-white border-2 bg-orange-400 border-orange-500">
                                    @else
                                        @if ($surat_pembelian->status_bayar === 'lunas')
                                            <div class="rounded text-white border-2 bg-emerald-400 border-emerald-500">
                                            @else
                                                <div class="rounded text-white border-2 bg-yellow-400 border-yellow-500">
                                        @endif
                            @endif
                            <div class="text-center"><span
                                    class="whitespace-nowrap text-xs font-bold">{{ date('d-m', strtotime($surat_pembelian->tanggal_surat)) }}</span>
                            </div>
                            <div class="text-center text-xs font-bold">
                                {{ date('Y', strtotime($surat_pembelian->tanggal_surat)) }}</div>
                        </div>
                        </div>
                    </td>
                    <td class="py-1">
                        <div class="text-center text-slate-500">{{ $surat_pembelian->username }}</div>
                    </td>
                    <td class="py-1">
                        <div class="text-center text-slate-500 text-xs font-bold">{{ $surat_pembelian->pelanggan_nama }}
                        </div>
                    </td>
                    <td class="py-1">
                        <div class="text-center text-slate-500">
                            {{ my_decimal_format($surat_pembelian->harga_total) }}
                        </div>
                    </td>
                </tr>
                <tr class="border-b">
                    <td colspan="4" class="pb-1">
                        <div id="surat_pembelian_items-{{ $key }}"
                            class="hidden border border-indigo-400 rounded p-2 bg-indigo-50">
                            <h3 class="font-bold text-slate-500">Data Barang:</h3>
                            <div class="grid grid-cols-12 gap-1 justify-between items-center border-y text-slate-400">
                                @foreach ($surat_pembelian->items as $item)
                                    @if ($item->status_buyback)
                                        <div class="col-span-8">
                                            <div>{{ $item->shortname }}</div>
                                            <div class="text-xs font-bold">({{ $item->status_buyback }} ->
                                                {{ my_decimal_format($item->harga_buyback) }})</div>
                                        </div>
                                    @else
                                        <span class="col-span-8">{{ $item->shortname }}</span>
                                    @endif
                                    <div class="col-span-4 text-xs">
                                        <div>@ {{ my_decimal_format($item->harga_g) }}</div>
                                        <div>o: {{ my_decimal_format($item->ongkos_g) }}</div>
                                        <div>{{ my_decimal_format($item->harga_t) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-end mt-1 gap-2 items-center">
                                <form action="{{ route('surat_pembelian.buyback', $surat_pembelian->id) }}"
                                    method="GET">
                                    <button type="submit"
                                        class="loading-spinner bg-indigo-300 text-white p-1 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('surat_pembelian.delete', $surat_pembelian->id) }}"
                                    onsubmit="return confirm('Yakin ingin hapus SuratPembelian ini?')">
                                    <button type="submit" class="loading-spinner bg-rose-300 text-white p-1 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                                <div>
                                    <a href="{{ route('surat_pembelian.print_out', $surat_pembelian->id) }}"
                                        class="loading-spinner">
                                        <button class="bg-slate-300 text-white p-1 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('surat_pembelian.show', $surat_pembelian->id) }}"
                                        class="loading-spinner bg-yellow-200 text-slate-400 px-2 py-1 rounded-xl border border-yellow-400">Detail</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
