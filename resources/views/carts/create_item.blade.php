@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="grid grid-cols-2 gap-2">
        <div class="">
            <label for="tipe_barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe barang</label>
            <input type="text" id="tipe_barang" name="tipe_barang" value="{{ $tipe_barang }}" readonly class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-5">
            <label for="tipe_perhiasan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">tipe perhiasan</label>
            <input type="text" id="tipe_perhiasan" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
    </div>
</main>
@endsection

