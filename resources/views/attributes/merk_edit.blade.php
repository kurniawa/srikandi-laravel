@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>
    <div class="flex justify-between items-center">
        <div class="bg-white shadow drop-shadow rounded p-2 flex gap-1 text-slate-400 items-center">
            <h1 class="text-xl font-bold">Edit Merk</h1>
        </div>
    </div>

    <div class="mt-2 border rounded p-1">
        <form action="{{ route('attributes.merks.update', $merk->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-1">
                <div class="col-span-1">
                    <input type="text" name="nama" id="nama" placeholder="nama cap" value="{{ $merk->nama }}" class="rounded w-full">
                </div>
                <div class="col-span-1">
                    <input type="text" name="codename" id="codename" placeholder="codename cap" value="{{ $merk->codename }}" class="rounded w-full">
                </div>
            </div>
            <div class="flex justify-center mt-2">
                <div class="rounded p-2 bg-orange-300 text-white font-bold">
                    <button type="submit">Konfirmasi</button>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

