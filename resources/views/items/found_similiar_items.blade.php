@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <div class="mt-1">
            <form action="{{ route($route1) }}" method="POST">
                @csrf
                <input type="hidden" name="tipe_barang" value="{{ $candidate_new_item['tipe_barang'] }}">
                <input type="hidden" name="tipe_perhiasan" value="{{ $candidate_new_item['tipe_perhiasan'] }}">
                <input type="hidden" name="jenis_perhiasan" value="{{ $candidate_new_item['jenis_perhiasan'] }}">
                <input type="hidden" name="warna_emas" value="{{ $candidate_new_item['warna_emas'] }}">
                <input type="hidden" name="deskripsi" value="{{ $candidate_new_item['deskripsi'] }}">
                <input type="hidden" name="kadar" value="{{ (float)$candidate_new_item['kadar'] / 100 }}">
                <input type="hidden" name="berat" value="{{ (float)$candidate_new_item['berat'] / 100 }}">
                <input type="hidden" name="harga_g" value="{{ (float)$candidate_new_item['harga_g'] / 100 }}">
                <input type="hidden" name="ongkos_g" value="{{ (float)$candidate_new_item['ongkos_g'] / 100 }}">
                <input type="hidden" name="harga_t" value="{{ (float)$candidate_new_item['harga_t'] / 100 }}">
                <input type="hidden" name="shortname" value="{{ $candidate_new_item['shortname'] }}">
                <input type="hidden" name="longname" value="{{ "$candidate_new_item[longname] " . "v" . count($similiar_items) + 1 }}">
                <input type="hidden" name="kondisi" value="{{ $candidate_new_item['kondisi'] }}">
                <input type="hidden" name="cap" value="{{ $candidate_new_item['cap'] }}">
                <input type="hidden" name="range_usia" value="{{ $candidate_new_item['range_usia'] }}">
                <input type="hidden" name="ukuran" value="{{ $candidate_new_item['ukuran'] }}">
                <input type="hidden" name="merk" value="{{ $candidate_new_item['merk'] }}">
                <input type="hidden" name="plat" value="{{ $candidate_new_item['plat'] }}">
                <input type="hidden" name="keterangan" value="{{ $candidate_new_item['keterangan'] }}">
                {{-- <input type="hidden" name="stock" value="{{ $candidate_new_item['stock'] }}"> --}}

                <div class="text-center">
                    <button type="submit" class="bg-emerald-300 p-4 text-white font-bold rounded">Lanjutkan Penginputan New Item</button>
                </div>
            </form>
        </div>
        <div class="mt-1 flex">
            <div class="shadow drop-shadow p-2 rounded">
                Pilihan Item Yang Sama:
            </div>

        </div>
        <div class="gap-2 mt-2">
            @foreach ($similiar_items as $key => $item)
                <a href="{{ route($route2, $item->id) }}">
                    <div class="loading-spinner p-2 bg-white rounded shadow drop-shadow grid grid-cols-12 gap-2">
                        <div class="col-span-4">
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
                        <div class="col-span-8">
                            <div class="text-slate-400">
                                @if ($item->longname)
                                    <div class="text-xs font-bold">{{ $item->longname }}</div>
                                @else
                                    <span class="font-bold text-xs text-slate-500">{{ $item->shortname }}</span>
                                @endif
                            </div>
                            <div class="font-bold text-slate-600 text-xs">Rp {{ my_decimal_format($item->harga_g) }}</div>
                            <div class="font-bold text-slate-600 text-xs">Rp {{ my_decimal_format($item->ongkos_g) }}</div>
                            <div class="font-bold text-slate-600">Rp {{ my_decimal_format($item->harga_t) }}</div>
                        </div>
                        {{-- <div class="text-slate-500">By: {{ $item->user->username }}</div> --}}

                    </div>
                </a>
            @endforeach
        </div>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
