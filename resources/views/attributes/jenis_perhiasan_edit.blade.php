@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>
    <div class="flex justify-between items-center">
        <div class="bg-white shadow drop-shadow rounded p-2 flex gap-1 text-slate-400 items-center">
            <h1 class="text-xl font-bold">Edit Jenis Perhiasan</h1>
        </div>
    </div>

    <div class="mt-2 p-1 border-2 rounded border-orange-300">
        <form action="{{ route('attributes.jenis_perhiasans.update', $jenis_perhiasan->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-1 items-center">
                <div class="col-span-1">
                    <select name="tipe_perhiasan_id" id="select-tipe_perhiasan" class="p-1 rounded w-full">
                        @foreach ($tipe_perhiasans as $tipe_perhiasan)
                            @if ($tipe_perhiasan->nama == $jenis_perhiasan->tipe_perhiasan)
                            <option value="{{ $tipe_perhiasan->id }}" selected>{{ $tipe_perhiasan->nama }}</option>
                            @else
                            <option value="{{ $tipe_perhiasan->id }}">{{ $tipe_perhiasan->nama }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1">
                    <input type="text" name="jenis_perhiasan" class="rounded w-full" placeholder="Jenis Perhiasan" value="{{ $jenis_perhiasan->nama }}">
                </div>
            </div>
            <div class="flex justify-center mt-5">
                <button class="bg-orange-300 text-white font-bold p-2 rounded">Konfirmasi Edit</button>
            </div>
        </form>
    </div>
</main>
@endsection

