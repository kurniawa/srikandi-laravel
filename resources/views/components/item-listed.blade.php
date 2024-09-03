<div class="grid grid-cols-12 border-y py-3">
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    <div class="col-span-3 foto-barang flex items-center">
        @if ($suratpembelianitem->photo_path)
        <div class="w-full flex justify-center">
            <img src="{{ asset("storage/" . $suratpembelianitem->photo_path) }}" alt="item_photo" class="w-full">
        </div>
        @else
        @if ($suratpembelianitem->photo_path)
        <div class="w-full flex justify-center">
            <img src="{{ asset("storage/" . $suratpembelianitem->photo_path) }}" alt="item_photo" class="w-full">
        </div>
        @else
        <div class="w-full flex justify-center text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-1/2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
            </svg>
        </div>
        @endif
        @endif
    </div>
    <div class="col-span-9 flex justify-between">
        <div>
            <div class="font-bold text-slate-500">{{ $suratpembelianitem->shortname }}</div>
            <div class="font-bold text-slate-600 text-xs">Rp {{ my_decimal_format($suratpembelianitem->harga_g) }} / g</div>
            <div class="font-bold text-slate-500">Rp {{ my_decimal_format($suratpembelianitem->harga_t) }}</div>
            <input type="hidden" name="harga_t[]" value="{{ (string)((float)$suratpembelianitem->harga_t / 100) }}" class="binder_harga_t">
            <input type="hidden" name="cart_item_ids[]" value="{{ $suratpembelianitem->id }}">
        </div>
        <div class="w-6 h-6 flex justify-center border font-bold text-slate-500">1</div>
    </div>
</div>