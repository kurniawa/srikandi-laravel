@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <h3>Pilih Tipe Barang</h3>
    <div class="flex gap-2 border p-2 rounded">
        <a href="{{ route('carts.create_item', [$from, 'perhiasan']) }}" class="bg-emerald-400 text-white px-2 py-1 rounded" onclick="showLoadingSpinner()">perhiasan</a>
        <a href="{{ route('carts.create_item', [$from, 'LM']) }}" class="bg-emerald-400 text-white px-2 py-1 rounded" onclick="showLoadingSpinner()">LM</a>
    </div>
</main>
@endsection

