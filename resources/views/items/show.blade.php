@extends('layouts.main')
@section('content')
<main class="">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    @if (count($item->photos))
    <div id="default-carousel" class="relative w-full" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="relative w-full aspect-square overflow-hidden">
            @foreach ($item->photos as $key => $photo)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset("storage/$photo->path") }}" class="absolute block w-full aspect-square -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            @endforeach
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            @foreach ($item->photos as $key => $photo)
            @if ($key === 0)
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide {{ $key }}" data-carousel-slide-to="{{ $key }}"></button>
            @else
            <button type="button" class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50" aria-current="false" aria-label="Slide {{ $key }}" data-carousel-slide-to="{{ $key }}"></button>
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
        <div>
            <span class="font-bold text-lg text-slate-500">{{ $item->nama_short }}</span>
            @if ($item->deskripsi)
            <span class="italic">-{{ $item->deskripsi }}-</span>
            @endif
        </div>
        <div class="text-slate-500 flex justify-between">
            <span>@ {{ number_format((int)$item->harga_g / 100,2,',','.') }}</span>
            <span>stok: {{ $item->stock }}</span>
        </div>
        <div class="flex justify-between items-center">
            <div class="font-bold text-xl text-slate-600">
                <span>Rp. </span>{{ number_format((int)$item->harga_t / 100,2,',','.') }}
            </div>
            <div class="flex gap-2">
                <div class="bg-slate-100 rounded-full w-9 h-9 flex justify-center items-center">
                    <a href="{{ route('items.edit', $item->id) }}" class="loading-spinner text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </a>
                </div>
                <div class="bg-emerald-300 rounded-full w-9 h-9 flex justify-center items-center">
                    <a href="{{ route('items.add_photo', $item->id) }}" class="loading-spinner text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <h5 class="mt-3 font-bold">Data:</h5>
        <div class="mt-2 p-1 border border-emerald-400 rounded">
            <div class="flex gap-2">
                <div>
                    <table class="border-r">
                        <tr><td>we</td><td>:</td><td>{{ $item->warna_emas }}</td></tr>
                        <tr><td>k</td><td>:</td><td>{{ $item->kadar / 100 }}%</td></tr>
                        <tr><td>b</td><td>:</td><td>{{ $item->berat / 100 }}g</td></tr>
                        <tr><td>zu</td><td>:</td><td>{{ $item->kondisi }}</td></tr>
                        <tr><td>ru</td><td>:</td><td>{{ $item->range_usia }}</td></tr>
                        <tr><td>uk</td><td>:</td><td>{{ $item->ukuran }}</td></tr>
                        <tr><td>cap</td><td>:</td><td>{{ $item->cap }}</td></tr>
                    </table>
                </div>
                <div>
                    <table>
                        <tr><td>ongkos/g</td><td>:</td><td>{{ number_format((int)$item->ongkos_g / 100,2,',','.') }}</td></tr>
                        <tr><td>harga/g</td><td>:</td><td>{{ number_format((int)$item->harga_g / 100,2,',','.') }}</td></tr>
                        <tr><td>harga t</td><td>:</td><td>{{ number_format((int)$item->harga_t / 100,2,',','.') }}</td></tr>
                        <tr><td>merk</td><td>:</td><td>{{ $item->merk }}</td></tr>
                        <tr><td>plat</td><td>:</td><td>{{ $item->plat }}</td></tr>
                        <tr><td>edisi</td><td>:</td><td>{{ $item->edisi }}</td></tr>
                        <tr><td>nampan</td><td>:</td><td>{{ $item->nampan }}</td></tr>
                    </table>
                </div>
            </div>
            <div class="p-1 border rounded border-indigo-400 mt-3">
                <h3 class="font-bold">Mata</h3>
                <div>
                    @if (count($item->item_matas) > 0)
                    <div class="flex gap-2">
                        @foreach ($item->item_matas as $item_mata)
                        <span>{{ $item_mata->mata->warna }} :</span>
                        <span>{{ $item_mata->jumlah_mata }}</span>
                        <span class="italic text-slate-400">({{ $item_mata->mata->level_warna }}-{{ $item_mata->mata->opacity }})</span>
                        @endforeach
                    </div>
                    @else
                    <div>-</div>
                    @endif
                </div>
            </div>
            <div class="p-1 border rounded border-orange-400 mt-2">
                <h3 class="font-bold">Mainan</h3>
                <div>
                    @if (count($item->item_mainans) > 0)
                    <div class="flex gap-2">
                        @foreach ($item->item_mainans as $item_mainan)
                        <span>{{ $item_mainan->mainan->nama }} :</span>
                        <span>{{ $item_mainan->jumlah_mainan }}</span>
                        @endforeach
                    </div>
                    @else
                    <div>-</div>
                    @endif
                </div>
            </div>
        </div>
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

        {{-- @if ($item->sold)
        <div class="mt-2 bg-yellow-100 p-2">
            <h3 class="font-bold">Buyer / sold to:</h3>
            <div class="border rounded p-2">
                <p>{{ $item->buyer }}</p>
            </div>
        </div>
        @else
        <h3 class="font-bold">Buyer / sold to: - belum ada -</h3>
        @endif --}}

        <div class="mt-12">
            <form action="{{ route('carts.insert_to_cart', [$item->id, $user->id]) }}" method="POST" class="mt-2">
                @csrf
                @if ((int)$item->stock >= 1)
                <button type="submit" class="loading-spinner mt-2 py-2 bg-emerald-400 rounded w-full text-white flex items-center justify-center gap-1 font-bold">
                    <span>+ Keranjang</span>
                </button>
                @else
                <button type="button" class="mt-2 py-2 bg-slate-300 rounded w-full text-white flex items-center justify-center gap-1 font-bold" disabled>
                    <span>Stok habis</span>
                </button>
                @endif
            </form>

        </div>
        <div class="flex justify-center mt-2">
            <form action="{{ route('items.delete', $item->id) }}" method="POST" onsubmit="if(confirm('Anda yakin ingin menghapus barang ini?')){showLoadingSpinner();return true;} else {hideLoadingSpinner();return false;}">
                @csrf
                <button type="submit" class="py-2 bg-rose-300 text-white rounded-full flex items-center justify-center gap-1 w-8 h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</main>

{{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}

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

