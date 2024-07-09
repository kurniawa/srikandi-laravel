@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <div class="mt-1">
            <form action="{{ route('items.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipe_barang" value="{{ $candidate_new_item['tipe_barang'] }}">
                <input type="hidden" name="tipe_perhiasan" value="{{ $candidate_new_item['tipe_perhiasan'] }}">
                <input type="hidden" name="jenis_perhiasan" value="{{ $candidate_new_item['jenis_perhiasan'] }}">
                <input type="hidden" name="warna_emas" value="{{ $candidate_new_item['warna_emas'] }}">
                <input type="hidden" name="kadar" value="{{ $candidate_new_item['kadar'] }}">
                <input type="hidden" name="berat" value="{{ $candidate_new_item['berat'] }}">
                <input type="hidden" name="harga_g" value="{{ $candidate_new_item['harga_g'] }}">
                <input type="hidden" name="ongkos_g" value="{{ $candidate_new_item['ongkos_g'] }}">
                <input type="hidden" name="harga_t" value="{{ $candidate_new_item['harga_t'] }}">
                <input type="hidden" name="nama_short" value="{{ $candidate_new_item['nama_short'] }}">
                <input type="hidden" name="nama_long" value="{{ $candidate_new_item['nama_long'] }}">
                <input type="hidden" name="kondisi" value="{{ $candidate_new_item['kondisi'] }}">
                <input type="hidden" name="cap" value="{{ $candidate_new_item['cap'] }}">
                <input type="hidden" name="range_usia" value="{{ $candidate_new_item['range_usia'] }}">
                <input type="hidden" name="ukuran" value="{{ $candidate_new_item['ukuran'] }}">
                <input type="hidden" name="merk" value="{{ $candidate_new_item['merk'] }}">
                <input type="hidden" name="plat" value="{{ $candidate_new_item['plat'] }}">
                {{-- <input type="hidden" name="stock" value="{{ $candidate_new_item['stock'] }}"> --}}

                <div>
                    <button type="submit" class="bg-emerald p-3">Lanjutkan Penginputan New Item</button>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-2 gap-2 mt-1">
            @foreach ($item_exists as $key => $item)
                <a href="{{ route('items.show', [$item->id, 'home']) }}"
                    class="loading-spinner p-2 bg-white rounded shadow drop-shadow relative">
                    <div>
                        @if (count($item->item_photos))
                            <img src="{{ asset('storage/' . $item->item_photos[0]->photo->path) }}" alt="item_photo"
                                class="w-full">
                        @else
                            <div class="bg-indigo-100 text-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-full">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div><span class="font-bold text-xs text-slate-500">{{ $item->nama_short }}</span></div>
                    <div class="font-bold text-slate-600"><span>Rp
                        </span><span>{{ number_format((float) $item->harga_t / 100, 2, ',', '.') }}</span></div>
                    {{-- <div class="text-slate-500">By: {{ $item->user->username }}</div> --}}
                </a>
            @endforeach
        </div>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
