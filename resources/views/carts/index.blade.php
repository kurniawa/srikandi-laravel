@extends('layouts.main', $cart)
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex justify-end">
        <a href="{{ route('carts.pilih_tipe_barang', 'cart') }}" class="loading-spinner bg-emerald-400 text-white rounded-lg px-2 py-1">+ New Item</a>
    </div>

    <h3 class="text-xl font-bold text-slate-500">Keranjang</h3>

    <form action="{{ route('carts.checkout', $cart->id) }}" method="GET" class="mt-5">
        <div class="flex gap-2 items-center my-2">
            <input type="checkbox" name="pilih_semua" id="pilih_semua" class="w-4 h-4" onclick="pilihSemuaCartItems(this)" checked>
            <label for="pilih_semua" class="text-slate-500">pilih semua</label>
        </div>
        @foreach ($cart->cart_items as $key => $cart_item)
        <div class="grid grid-cols-12 border-y py-3">
            <div class="col-span-3 foto-barang">
                <div class="flex h-full items-center">
                    <input type="checkbox" name="cart_item_id[]" value="{{ $cart_item->id }}" id="{{ $cart_item->id }}" class="binder_cart_items w-4 h-4" checked onclick="uncheckPilihSemuaCartItems(this)">
                </div>
            </div>
            <div class="col-span-9">
                <div class="font-bold text-slate-500">{{ $cart_item->item->nama_short }}</div>
                <div class="font-bold text-slate-600 text-xs">Rp {{ number_format((string)((float)$cart_item->item->harga_gr / 100), 2, ',', '.') }} / g</div>
                <div class="font-bold text-slate-500">Rp {{ number_format((string)((float)$cart_item->item->harga_t / 100), 2, ',', '.') }}</div>
                <input type="hidden" name="harga_t[]" value="{{ (string)((float)$cart_item->item->harga_t / 100) }}" class="binder_harga_t">
                <div class="flex justify-end">
                    <div class="flex">
                        <button type="submit" name="delete" value="{{ $cart_item->id }}" onclick="return confirm('Ingin hapus item ini dari keranjang?')" class="loading-spinner border-y border-l rounded-l-xl w-6 h-6 flex items-center justify-center text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                        <button type="button" class="border-y border-l w-6 h-6 flex items-center justify-center text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                            </svg>
                        </button>
                        <div class="w-6 h-6 flex justify-center border font-bold text-slate-300">1</div>
                        <button type="button" class="border-r border-y rounded-r-xl w-6 h-6 flex items-center justify-center text-slate-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="flex justify-end mt-2">
            <div class="text-xl font-bold text-red-600">Rp <span id="harga_total_formatted">{{ number_format((string)((float)$cart->harga_total / 100), 2, ',', '.') }}</span></div>
            <input type="hidden" name="harga_total" id="harga_total" value="{{ (string)((float)$cart->harga_total / 100) }}">
        </div>
        <div class="flex justify-center mt-9">
            <button type="submit" class="rounded-lg px-3 py-2 bg-emerald-400 text-white border-2 border-emerald-500 font-bold">Checkout</button>
        </div>
    </form>

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

<script>
    const cart_items_all = document.querySelectorAll('.binder_cart_items');
    const harga_t_all = document.querySelectorAll('.binder_harga_t');

    function pilihSemuaCartItems(checkbox_pilih_semua) {
        // console.log('pilihSemuaCartItems');
        // console.log(cart_items_all);
        // console.log(checkbox_pilih_semua.checked);
        if (checkbox_pilih_semua.checked) {
            cart_items_all.forEach(cart_item => {
                cart_item.checked = true;
            });
        } else {
            cart_items_all.forEach(cart_item => {
                cart_item.checked = false;
            });
        }

        countHargaTotal();
    }

    function countHargaTotal() {
        // console.log('countHargaTotal');
        let harga_total = 0;
        for (let i = 0; i < cart_items_all.length; i++) {
            if (cart_items_all[i].checked) {
                harga_total += parseFloat(harga_t_all[i].value);
                // console.log(harga_t_all[i].value)
            }
        }

        // console.log(harga_total);
        // console.log(preformatDotToComa(harga_total));
        document.getElementById('harga_total').value = harga_total.toString();
        document.getElementById('harga_total_formatted').textContent = formatNumberX(preformatDotToComa(harga_total));
    }

    function uncheckPilihSemuaCartItems(checkbox_this) {
        let is_terpilih_semua = true;
        let checkbox_pilih_semua = document.getElementById('pilih_semua');

        cart_items_all.forEach(cart_item => {
            if (!cart_item.checked) {
                is_terpilih_semua = false;
            }
        });

        // console.log(is_terpilih_semua);
        if (is_terpilih_semua) {
            checkbox_pilih_semua.checked = true;
            pilihSemuaCartItems(checkbox_pilih_semua);
        } else {
            countHargaTotal();
            checkbox_pilih_semua.checked = false;
        }
    }
</script>
@endsection

