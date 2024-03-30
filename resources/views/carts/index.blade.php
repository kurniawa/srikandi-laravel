@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex justify-end">
        <a href="{{ route('carts.pilih_tipe_barang', 'cart') }}" class="loading-spinner bg-emerald-400 text-white rounded px-2 py-1">+ New Item</a>
    </div>

    <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button>
    {{-- @if ($back === true)
    <div class="fixed bottom-0 left-0">
        <div class="flex">
            <form action="{{ route($backroute) }}" method="GET">
                <button type="submit" class="loading-spinner bg-orange-400 text-white w-10 h-10 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @endif --}}
</main>
@endsection

