@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex justify-end">
        <a href="{{ route('carts.pilih_tipe_barang', 'cart') }}" class="bg-emerald-400 text-white rounded px-2 py-1" onclick="showLoadingSpinner()">+ New Item</a>
    </div>
</main>
@endsection

