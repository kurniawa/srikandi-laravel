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

    <div>
        @foreach ($bb_accountings as $bb_accounting)
            <div>{{ $bb_accounting["tanggal"] }}</div>
            <div class="grid grid-cols-12 items-center">
                @foreach ($bb_accounting["gol_kadars"] as $gol_kadar)
                    <div class="col-span-3">{{ $gol_kadar }}</div>
                    <div class="col-span-5">
                        @foreach ($bb_accounting['accountings'][$gol_kadar] as $accounting)
                            <div>{{ $accounting['nama_barang'] }}</div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

</main>
@endsection

