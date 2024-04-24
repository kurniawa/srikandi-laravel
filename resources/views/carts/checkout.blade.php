@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>


    <form action="{{ route('carts.proses_checkout', $cart->id) }}" method="POST">
        @csrf
        <h3 class="text-xl font-bold text-slate-500">Data Pelanggan</h3>
        <div class="flex justify-between mt-3 items-center">
            @if ($cart->customer_id)
            <table>
                <tr>
                    <td><label for="nama_pelanggan">Nama Pelanggan</label></td><td><span class="mx-2">:</span></td>
                    <td><input type="text" name="nama_pelanggan" id="nama_pelanggan" value="guest" class="border rounded p-1"></td>
                </tr>
                <tr>
                    <td><label for="username_pelanggan">Username</label></td><td><span class="mx-2">:</span></td>
                    <td><input type="text" name="username_pelanggan" id="username_pelanggan" value="guest" class="border rounded p-1"></td>
                </tr>
            </table>
            @else
            <div class="mt-3 text-slate-500">- Pelanggan guest -</div>
            @endif
            <div>
                <button type="button" id="btn-ganti" class="border-2 rounded px-2 py-1 text-slate-500 font-bold" onclick="toggle_light(this.id, 'form-cari-data-pelanggan', ['text-slate-500'], ['text-white', 'bg-slate-400'], 'block')">ganti</button>
            </div>
        </div>

        <div id="form-cari-data-pelanggan" class="mt-3 hidden">
            <table>
                <tr>
                    <td><label for="cari_nama_pelanggan">Nama Pelanggan</label></td><td><span class="mx-2">:</span></td>
                    <td><input type="text" name="cari_nama_pelanggan" id="cari_nama_pelanggan" class="border rounded p-1"></td>
                </tr>
                <tr>
                    <td><label for="cari_username_pelanggan">Username</label></td><td><span class="mx-2">:</span></td>
                    <td><input type="text" name="cari_username_pelanggan" id="cari_username_pelanggan" class="border rounded p-1"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="flex justify-center mt-2">
                            <button type="button" class="p-1 rounded-xl border-2 border-emerald-300 text-emerald-500 font-bold text-sm" onclick="cariDataPelanggan()">Tetapkan</button>
                        </div>
                    </td>
                </tr>
            </table>

        </div>

        <h3 class="text-xl font-bold text-slate-500 mt-5">Checkout</h3>
        <div class="mt-5">
            @foreach ($cart_items as $key => $cart_item)
            <div class="grid grid-cols-12 border-y py-3">
                <div class="col-span-3 foto-barang">

                </div>
                <div class="col-span-9 flex justify-between">
                    <div>
                        <div class="font-bold text-slate-500">{{ $cart_item->item->nama_short }}</div>
                        <div class="font-bold text-slate-600 text-xs">Rp {{ number_format((string)((float)$cart_item->item->harga_gr / 100), 2, ',', '.') }} / g</div>
                        <div class="font-bold text-slate-500">Rp {{ number_format((string)((float)$cart_item->item->harga_t / 100), 2, ',', '.') }}</div>
                        <input type="hidden" name="harga_t[]" value="{{ (string)((float)$cart_item->item->harga_t / 100) }}" class="binder_harga_t">
                    </div>
                    <div class="w-6 h-6 flex justify-center border font-bold text-slate-500">1</div>
                    {{-- <div class="flex justify-end">
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
                            <button type="button" class="border-r border-y rounded-r-xl w-6 h-6 flex items-center justify-center text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                    </div> --}}
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-end mt-2 gap-3">
            <span class="text-xl font-bold text-red-600">Total:</span>
            <div class="text-xl font-bold text-red-600">Rp <span id="harga_total_formatted">{{ number_format((string)((float)$cart->harga_total / 100), 2, ',', '.') }}</span></div>
            <input type="hidden" name="harga_total" id="harga_total" value="{{ (string)((float)$cart->harga_total / 100) }}">
        </div>
        <div class="flex justify-center mt-9">
            <button type="submit" class="rounded-lg px-3 py-2 bg-emerald-400 text-white border-2 border-emerald-500 font-bold">PROSES PEMBAYARAN</button>
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
    const users = {!! json_encode($users, JSON_HEX_TAG) !!};
    console.log(users);

    function cariDataPelanggan() {
        const nama_pelanggan = document.getElementById('cari-nama-pelanggan').value.trim();
        const username_pelanggan = document.getElementById('cari-username-pelanggan').value.trim();

        let found_pelanggan = null;

        if (nama_pelanggan && username_pelanggan) {
            // var pilihan_jenis_perhiasans = jenis_perhiasans.filter((o) => o.tipe_perhiasan_id == tipe_perhiasan.id);
            found_pelanggan = users.filter((o) => o.username == username_pelanggan);
        }

        console.log(found_pelanggan);
    }
</script>
@endsection

