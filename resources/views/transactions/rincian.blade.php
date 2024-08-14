@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex items-center gap-2">
        <div class="bg-white shadow drop-shadow p-2 rounded">
            <h3 class="text-xl font-bold text-slate-500">Rincian Transaksi</h3>
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

    <div class="text-xs italic mt-5 text-slate-500">user: {{ $user->username }}</div>

    <div>
        <div class="font-bold text-white bg-orange-400 border-2 border-orange-500 rounded text-center mt-2">Buyback</div>
        @if (count($bb_accountings))
            @foreach ($bb_accountings as $bb_accounting)
                <div class="grid grid-cols-12 items-center text-xs mb-2 py-2 border-t-2 text-slate-500">
                    <div class="col-span-3">
                        <div class="rounded text-white border-2 bg-orange-300 border-orange-400">
                            <div class="text-center">
                                <span class="whitespace-nowrap font-bold">
                                    {{ date('d-m', strtotime($bb_accounting["tanggal"])) }}
                                </span>
                            </div>
                            <div class="text-center font-bold">
                                {{ date('Y', strtotime($bb_accounting["tanggal"])) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-span-9 text-center font-bold text-base text-pink-400">Rp {{ my_decimal_format($bb_accounting["grand_total"]) }}</div>
                    @for ($i = 0; $i < count($bb_accounting["gol_kadars"]); $i++)
                        <div class="col-span-12 grid grid-cols-12 py-1 border-b items-center">
                            <div class="col-span-3 font-bold">
                                <div class="inline-block rounded bg-orange-100 p-1">
                                    <div class="text-center">{{ casual_decimal_format($bb_accounting["gol_kadars"][$i]) }}%</div>
                                    <div class="text-center">{{ casual_decimal_format($bb_accounting['total_berats'][$i]) }}g</div>
                                    <div class="text-center">{{ my_decimal_format($bb_accounting['total_hargas'][$i]) }}</div>
                                </div>
                            </div>
                            <div class="col-span-9">
                                @foreach ($bb_accounting['accountings'][$bb_accounting["gol_kadars"][$i]] as $accounting)
                                    <div>{{ $accounting['nama_barang'] }}</div>
                                    <div>{{ casual_decimal_format($accounting['berat']) }}g --> Rp {{ my_decimal_format($accounting['jumlah']) }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endfor
                    {{-- @foreach ($bb_accounting["gol_kadars"] as $key => $gol_kadar)
                        <div class="col-span-3">{{ $gol_kadar }}</div>
                        <div class="col-span-5">
                            @foreach ($bb_accounting['accountings'][$gol_kadar] as $accounting)
                                <div>{{ $accounting['nama_barang'] }}</div>
                            @endforeach
                        </div>
                        <div class="col-span-3">
                            @foreach ($bb_accounting['accountings'][$gol_kadar] as $accounting)
                                <div>{{ $accounting['berat'] }}</div>
                            @endforeach
                        </div>
                    @endforeach --}}
                </div>
            @endforeach
        @else
            <div class="italic text-sm text-slate-500">- Belum ada transaksi buyback -</div>
        @endif
    </div>

    <div>
        <div class="font-bold text-white bg-emerald-400 border-2 border-emerald-500 rounded text-center mt-2">Buy</div>
        @if (count($buy_accountings))
            @foreach ($buy_accountings as $buy_accounting)
                <div class="grid grid-cols-12 items-center text-xs mb-2 py-2 border-t-2 text-slate-500">
                    <div class="col-span-3">
                        <div class="rounded text-white border-2 bg-emerald-300 border-emerald-400">
                            <div class="text-center">
                                <span class="whitespace-nowrap font-bold">
                                    {{ date('d-m', strtotime($buy_accounting["tanggal"])) }}
                                </span>
                            </div>
                            <div class="text-center font-bold">
                                {{ date('Y', strtotime($buy_accounting["tanggal"])) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-span-9 text-center font-bold text-base text-pink-400">Rp {{ my_decimal_format($buy_accounting["grand_total"]) }}</div>
                    @for ($i = 0; $i < count($buy_accounting["gol_kadars"]); $i++)
                        <div class="col-span-12 grid grid-cols-12 py-1 border-b items-center">
                            <div class="col-span-3 font-bold">
                                <div class="inline-block rounded bg-emerald-100 p-1">
                                    <div class="text-center">{{ casual_decimal_format($buy_accounting["gol_kadars"][$i]) }}%</div>
                                    <div class="text-center">{{ casual_decimal_format($buy_accounting['total_berats'][$i]) }}g</div>
                                    <div class="text-center">{{ my_decimal_format($buy_accounting['total_hargas'][$i]) }}</div>
                                </div>
                            </div>
                            <div class="col-span-9">
                                @foreach ($buy_accounting['accountings'][$buy_accounting["gol_kadars"][$i]] as $accounting)
                                    <div>{{ $accounting['nama_barang'] }}</div>
                                    <div>{{ casual_decimal_format($accounting['berat']) }}g --> Rp {{ my_decimal_format($accounting['jumlah']) }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endfor
                    {{-- @foreach ($buy_accounting["gol_kadars"] as $key => $gol_kadar)
                        <div class="col-span-3">{{ $gol_kadar }}</div>
                        <div class="col-span-5">
                            @foreach ($buy_accounting['accountings'][$gol_kadar] as $accounting)
                                <div>{{ $accounting['nama_barang'] }}</div>
                            @endforeach
                        </div>
                        <div class="col-span-3">
                            @foreach ($buy_accounting['accountings'][$gol_kadar] as $accounting)
                                <div>{{ $accounting['berat'] }}</div>
                            @endforeach
                        </div>
                    @endforeach --}}
                </div>
            @endforeach
        @else
            <div class="italic text-sm text-slate-500">- Belum ada transaksi buy -</div>
        @endif
    </div>

</main>
@endsection

