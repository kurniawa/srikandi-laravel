@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>
    <div class="flex justify-between items-center">
        <div class="bg-white shadow drop-shadow rounded p-2 flex gap-1 text-slate-400 items-center">
            <h1 class="text-xl font-bold">Tipe Perhiasan</h1>
        </div>
        <a href="{{ route('attributes.tipe_perhiasans.create') }}">
            <button class="bg-emerald-400 p-1 rounded text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </a>
    </div>

    <div class="mt-2 p-1 border-2 rounded border-emerald-300">
        <form action="{{ route('attributes.tipe_perhiasans.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2">
                <div class="col-span-1">
                    <select name="tipe_perhiasan" id="tipe_perhiasan-new" class="p-1 rounded">
                        @foreach ($tipe_perhiasans as $tipe_perhiasan)
                            <option value="{{ $tipe_perhiasan->id }}">{{ $tipe_perhiasan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1">
                    <input type="text" name="jenis_perhiasan" id="jenis_perhiasan-new" class="rounded" placeholder="Jenis Perhiasan">
                </div>
            </div>
            <div class="flex items-center mt-5">
                <button class="bg-emerald-300 text-white font-bold p-2 rounded">+Tambah Jenis Perhiasan</button>
            </div>
        </form>
    </div>

    @foreach ($col_jenis_perhiasans as $col_jenis_perhiasan)
        <div class="mt-2">
            <div class="flex items-center">
                <div class="p-1 rounded bg-white shadow drop-shadow">
                    <div class="w-10 h-10">
                        <img src="{{ asset("img/icon-tipe-perhiasan/" . strtolower(implode("_", explode(" ", $col_jenis_perhiasan['tipe_perhiasan']))) . ".png") }}" alt="test" class="w-full h-full">
                    </div>
                </div>
                <span class="ml-2 font-bold text-slate-500">{{ $col_jenis_perhiasan['tipe_perhiasan'] }}</span>
                
            </div>
        </div>
        <table class="mt-2 table-slim w-full">
            <tr>
                <th>no.</th><th>nama</th>
                {{-- <th>name_id</th><th>codename</th><th></th> --}}
            </tr>
            @foreach ($col_jenis_perhiasan['jenis_perhiasans'] as $key => $jenis_perhiasan)
            <tr>
                <td>{{ $key+1 }}.</td>
                <td>{{ $jenis_perhiasan->nama }}</td>
                {{-- <td>{{ $jenis_perhiasan->name_id }}</td>
                <td>{{ $jenis_perhiasan->codename }}</td> --}}
                <td>
                    <a href="{{ route('attributes.tipe_perhiasans.edit', $jenis_perhiasan->id) }}">
                        <button class="text-white p-1 rounded bg-blue-400">
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
</main>
@endsection

