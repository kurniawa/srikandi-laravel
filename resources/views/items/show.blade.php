@extends('layouts.main')
@section('content')
<main class="">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    @if (count($item_photos) !== 0)
    <div id="default-carousel" class="relative w-full" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="relative w-full aspect-square overflow-hidden">
            @foreach ($item_photos as $key => $item_photo)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset("storage/$item_photo->photo_path") }}" class="absolute block w-full aspect-square -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            @endforeach
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            @foreach ($item_photos as $key => $item_photo)
            @if ($key === 0)
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide {{ $key }}" data-carousel-slide-to="{{ $key }}"></button>
            @else
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide {{ $key }}" data-carousel-slide-to="{{ $key }}"></button>
            @endif
            @endforeach
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
    @else
    <div class="bg-indigo-100 text-indigo-400">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
        </svg>
    </div>
    @endif
    <div class="p-2">
        <div class="font-bold text-xl">{{ $item->nama }}</div>
        <div class="flex justify-between items-center">
            <div class="font-bold text-2xl">
                <span>Rp. </span>{{ number_format((int)$item->harga * 100,2,',','.') }}
            </div>
            {{-- @if ($related_user !== null)
            <div class="bg-slate-100 rounded-full w-8 h-8 flex justify-center items-center">
                <a href="{{ route('items.edit', $item->id) }}" onclick="showLoadingSpinner()" class="text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </a>
            </div>
            @endif --}}
        </div>
        @if ($item->deskripsi)
        <div class="mt-2">
            <h3 class="font-bold">Deskripsi:</h3>
            <div class="border rounded p-2">
                <p>{{ $item->deskripsi }}</p>
            </div>
        </div>
        @else
        <div class="mt-2"><h3 class="font-bold">Deskripsi: - tidak ada -</h3></div>
        @endif
        <div class="mt-2 text-slate-400">
            @if ($item->keterangan)
            <h3 class="font-bold">Keterangan lain:</h3>
            <div class="border rounded p-2">
                <p>{{ $item->keterangan }}</p>
            </div>
            @else
            <h3 class="font-bold">Keterangan lain: - tidak ada -</h3>
            @endif
        </div>
        {{-- <div class="mt-2">
            @if (count($peminat_items) !== 0)
            <h3 class="font-bold">Daftar Peminat:</h3>
            <div class="border rounded p-2">
                <div class="grid grid-cols-2">
                    @foreach ($peminat_items as $peminat_item)
                    <div>> {{ $peminat_item->nama }}</div>
                    <form action="{{ route('items.hapus_peminat', [$item->id, $peminat_item->id]) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus peminat ini?')">
                        @csrf
                        <button type="submit" class="text-red-500 font-bold" name="nama" value="{{ $peminat_item->nama }}">X</button>
                        @if ($peminat_item->user_id !== null)
                        <input type="hidden" name="user_id" value="{{ $peminat_item->user_id }}">
                        @endif
                    </form>
                    @endforeach
                </div>
            </div>
            @else
            <h3 class="font-bold">Daftar Peminat: - belum ada -</h3>
            @endif
        </div> --}}
        @if ($item->sold)
        <div class="mt-2 bg-yellow-100 p-2">
            <h3 class="font-bold">Buyer / sold to:</h3>
            <div class="border rounded p-2">
                <p>{{ $item->buyer }}</p>
            </div>
        </div>
        @else
        <h3 class="font-bold">Buyer / sold to: - belum ada -</h3>
        @endif
        <div class="mt-12">
            @if (Auth::user())
            <form action="{{ route('items.mau', $item->id) }}" method="POST" onsubmit="showLoadingSpinner()">
                @csrf
                <button type="submit" class="py-2 bg-emerald-400 rounded-3xl w-full text-white flex items-center justify-center gap-1">
                    <span>Saya mau ini</span>
                </button>
            </form>
            @else
            <button id="toggle-button" type="button" class="py-2 border-2 border-emerald-400 rounded-3xl w-full text-emerald-500 font-bold flex items-center justify-center gap-1" onclick="toggle_light(this.id, 'form-konfirmasi', [], ['bg-emerald-200'], 'block')">
                <span>Saya mau ini</span>
            </button>
            <div id="form-konfirmasi" class="border-2 bg-emerald-50 rounded p-2 mt-2 hidden">
                <h5 class="font-bold">--> Isi data, karena Anda belum log in -</h5>
                <form action="{{ route('items.mau', $item->id) }}" method="POST" class="mt-2" onsubmit="showLoadingSpinner()">
                    @csrf
                    <div>
                        <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama peminat</label>
                        <div class="mt-2">
                            <input type="text" name="nama" id="nama" autocomplete="given-name" class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <button type="submit" class="mt-2 py-2 bg-emerald-400 rounded w-full text-white flex items-center justify-center gap-1">
                        <span>Konfirmasi</span>
                    </button>
                </form>

            </div>
            @endif
        </div>
        {{-- @if ($related_user !== null)
        <div class="flex justify-center mt-2">
            <form action="{{ route('items.delete', $item->id) }}" method="GET" onsubmit="if(confirm('Anda yakin ingin menghapus barang ini?')){showLoadingSpinner();return true;} else {hideLoadingSpinner();return false;}">
                @csrf
                <button type="submit" class="py-2 bg-pink-200 text-pink-400 rounded-full flex items-center justify-center gap-1 w-8 h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </form>
        </div>
        @endif --}}
    </div>
</main>

<script>
    function toggleWarna(toggle_button, id_to_toggle, class_warna) {
        console.log(toggle_button);
        $(`#${id_to_toggle}`).toggle(300);
        let toggleButton = document.getElementById(toggle_button);
        if (condition) {

        }
    }
</script>
@endsection

