@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <div class="sm:hidden">
            <div class="flex justify-between items-center">
                <div class="flex">
                    <div class="bg-white shadow drop-shadow rounded p-1">
                        <h1 class="text-2xl font-bold text-slate-500">Daftar Pelanggan</h1>
                    </div>
                </div>
                
                <div>
                    <a href="{{ route('pelanggans.create') }}" class="bg-emerald-300 text-white font-bold rounded-lg p-2">+NEW P</a>
                </div>
            </div>

            <form action="" method="GET">
                <div class="flex gap-2 items-center mt-2">
                    <div>
                        <input type="text" name="search_key" id="search_key" class="rounded"
                            placeholder="nama/username...">
                    </div>
                    <div>
                        <button class="flex bg-yellow-300 text-white gap-1 py-1 px-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <span>Cari</span>
                        </button>

                    </div>
                </div>
            </form>
        </div>

        <div class="hidden sm:block">
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <div class="flex">
                        <div class="bg-white shadow drop-shadow rounded p-1">
                            <h1 class="text-2xl font-bold text-slate-500">Daftar Pelanggan</h1>
                        </div>
                    </div>
                    <form action="" method="GET">
                        <div class="flex gap-2 items-center mt-2">
                            <div>
                                <input type="text" name="search_key" id="search_key" class="rounded"
                                    placeholder="nama/username...">
                            </div>
                            <div>
                                <button class="flex bg-yellow-300 text-white gap-1 py-1 px-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                    <span>Cari</span>
                                </button>
    
                            </div>
                        </div>
                    </form>
                </div>
    
                <div>
                    <a href="{{ route('pelanggans.create') }}"
                        class="bg-emerald-300 text-white font-bold rounded-lg px-2 py-1">+
                        NEW P</a>
                </div>
            </div>
        </div>
        <table class="w-full mt-5 text-slate-500">
            @foreach ($pelanggans as $key => $pelanggan)
                <tr class="border-t">
                    <td class="py-2">
                        <div class="text-center text-slate-500"></div>
                    </td>
                    <td class="py-2">
                        <div class="">{{ $pelanggan->nama }}</div>
                    </td>
                    <td class="py-2">
                        <div class="">{{ $pelanggan->username }}</div>
                    </td>
                    <td class="py-2">
                        <div class="flex justify-end">
                            <a href="{{ route('pelanggans.show', $pelanggan->id) }}"
                                class="bg-orange-300 text-white rounded px-2">Detail</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
