@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>
    <div class="flex justify-between items-center">
        <div class="bg-white shadow drop-shadow rounded p-2 flex gap-1 text-slate-400 items-center">
            <h1 class="text-xl font-bold">Harga Pasaran</h1>
        </div>
        <a href="{{ route('attributes.harga_pasaran.create') }}">
            <button class="bg-emerald-400 p-1 rounded text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </a>
    </div>

    <div class="border-2 border-indigo-300 rounded p-1 mt-2">
        <div class="text-center mt-2">
            <h3 class="font-bold text-slate-500">Harga Terkini</h3>
        </div>
        <div class="">
            @foreach ($col_harga_pasarans as $harga_pasarans)
            <div class="flex mt-2">
                <div class="bg-white shadow drop-shadow p-1 rounded text-slate-400 font-bold text-sm">{{ $harga_pasarans[0]->kategori }}</div>
            </div>
            <table class="table-slim w-full">
                <tr><th>tgl.</th><th>hrg. beli</th><th>hrg. buyback</th></tr>
                <tr>
                    <td class="text-center">{{ date('d.m.Y', strtotime($harga_pasarans[0]->created_at)) }}</td>
                    <td class="text-center">{{ my_decimal_format($harga_pasarans[0]->harga_beli) }}</td>
                    <td class="text-center">{{ my_decimal_format($harga_pasarans[0]->harga_buyback) }}</td>
                    <td>
                        <a href="{{ route('attributes.harga_pasaran.edit', $harga_pasarans[0]->id) }}">
                            <button class="p-1 rounded bg-blue-400 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                        </a>
                    </td>
                </tr>
            </table>
            @endforeach
        </div>
    </div>

    <div class="border-2 border-orange-300 rounded p-1 mt-5">
        <div class="text-center mt-2">
            <h3 class="font-bold text-slate-500">Histori Harga</h3>
        </div>
        <div class="mt-2">
            @foreach ($col_harga_pasarans as $harga_pasarans)
            <div class="flex mt-2">
                <div class="bg-white shadow drop-shadow p-1 rounded text-slate-400 font-bold text-sm">{{ $harga_pasarans[0]->kategori }}</div>
            </div>
            <table class="table-slim w-full">
                <tr><th>tgl.</th><th>hrg. beli</th><th>hrg. buyback</th></tr>
                @foreach ($harga_pasarans as $harga_pasaran)
                <tr>
                    <td class="text-center">{{ date('d.m.Y', strtotime($harga_pasaran->created_at)) }}</td>
                    <td class="text-center">{{ my_decimal_format($harga_pasaran->harga_beli) }}</td>
                    <td class="text-center">{{ my_decimal_format($harga_pasaran->harga_buyback) }}</td>
                    <td>
                        <a href="{{ route('attributes.harga_pasaran.edit', $harga_pasaran->id) }}">
                            <button class="p-1 rounded bg-blue-400 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                        </a>
                    </td>
                </tr>
                    
                @endforeach
            </table>
            @endforeach
        </div>
    </div>
</main>
@endsection

