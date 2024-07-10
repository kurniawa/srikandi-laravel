@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>

        <h3 class="text-xl font-bold text-slate-500">Foto Transaksi</h3>
        @if ($cart->photo_path)
            <div class="w-full">
                <img src="{{ asset('storage/' . $cart->photo_path) }}" alt="item_photo" class="w-full">
            </div>
            <form action="{{ route('photos.delete_cart_photo', $cart->id) }}" method="POST"
                onsubmit="return confirm('Anda yakin ingin hapus foto cart ini?')" class="mt-2">
                @csrf
                <div class="flex justify-center">
                    <button type="submit"
                        class="loading-spinner bg-pink-300 text-white rounded p-1 flex gap-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </form>
        @else
            <form method="POST" action="{{ route('photos.add_cart_photo', $cart->id) }}" class="mb-1"
                enctype="multipart/form-data">
                @csrf
                <label for="input-photo" class="block hover:cursor-pointer mt-2" id="label-input-photo">
                    <div class="flex justify-center">
                        <div class="text-white bg-slate-300 rounded-lg p-1 w-1/4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-full">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                    </div>
                </label>
                <input id="input-photo" type="file" name="photo"
                    onchange="previewImage(this.files[0], 'div-preview-photo', 'preview-photo', 'label-input-photo')"
                    class="hidden">
                {{-- <input type="hidden" name="photo_index" value="{{ $key }}"> --}}
                <div id="div-preview-photo" class="hidden">
                    <div class="flex justify-end">
                        <button type="button" class="text-red-400"
                            onclick="removeImage('input-photo', 'div-preview-photo', 'preview-photo', 'label-input-photo')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex justify-center">
                        <img id="preview-photo"></img>
                    </div>
                    <div class="flex justify-center mt-1">
                        <button type="submit"
                            class="loading-spinner bg-emerald-300 text-white border-2 border-emerald-400 font-bold rounded px-3 py-1 text-sm animate-pulse">+
                            Tambah Foto</button>
                    </div>
                </div>
            </form>
        @endif

        <h3 class="text-xl font-bold text-slate-500">Data Pelanggan</h3>

        <x-form-cari-data-pelanggan :pelangganid="$pelangganid" :pelanggannama="$pelanggannama" :pelangganusername="$pelangganusername" :pelanggannik="$pelanggannik"
            :route="null" :params="null"></x-form-cari-data-pelanggan>

        <form action="{{ route('carts.proses_checkout', $cart->id) }}" method="POST">
            @csrf
            <div class="flex gap-1 mt-5 items-center">
                <h3 class="text-lg font-bold text-slate-500">Tanggal Surat</h3>
                <span class="text-slate-500 text-xs italic">(dd-mm-yyyy)</span>
            </div>
            <div class="flex gap-1 items-center mt-2 bg-slate-300 p-1">
                <select name="hari" id="hari" class="border py-1 rounded" disabled>
                    @if (old('hari'))
                        @for ($i = 1; $i < 32; $i++)
                            <option value="{{ $i }}" {{ old('hari') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    @else
                        @for ($i = 1; $i < 32; $i++)
                            @if ($i == date('d'))
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    @endif
                </select>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </div>
                <select name="bulan" id="bulan" class="border py-1 rounded" disabled>
                    @if (old('bulan'))
                        @for ($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}" {{ old('bulan') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    @else
                        @for ($i = 1; $i < 13; $i++)
                            @if ($i == date('m'))
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    @endif
                </select>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </div>
                <input type="text" name="tahun" class="border rounded p-1 w-1/3"
                    value="{{ old('tahun') ? old('tahun') : date('Y') }}" readonly>
                {{-- kalau nanti ada fungsi pengubahan tanggal surat, maka ini boleh dihapus --}}
                <input type="hidden" name="hari" value="{{ date('d') }}" readonly>
                <input type="hidden" name="bulan" value="{{ date('m') }}" readonly>
                {{-- select tidak bisa readonly, oleh karena itu tertulis disable, sedangkan disable artinya tidak terbaca oleh post() --}}
            </div>

            <h3 class="text-xl font-bold text-slate-500 mt-5">Checkout</h3>
            <div class="mt-5">
                @foreach ($cart_items as $key => $cart_item)
                    <div class="grid grid-cols-12 border-y py-3">
                        <div class="col-span-3 foto-barang flex items-center">
                            @if ($cart_item->photo_path)
                                <div class="w-full flex justify-center">
                                    <img src="{{ asset('storage/' . $cart_item->photo_path) }}" alt="item_photo"
                                        class="w-full">
                                </div>
                            @else
                                @if (count($cart_item->item->photos))
                                    <div class="w-full flex justify-center">
                                        <img src="{{ asset('storage/' . $cart_item->item->photos[0]->path) }}"
                                            alt="item_photo" class="w-full">
                                    </div>
                                @else
                                    <div class="w-full flex justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-1/2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                        </svg>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="col-span-9 flex justify-between">
                            <div>
                                <div class="font-bold text-slate-500">{{ $cart_item->item->shortname }}</div>
                                <div class="font-bold text-slate-600 text-xs">Rp
                                    {{ number_format((string) ((float) $cart_item->item->harga_g / 100), 2, ',', '.') }} /
                                    g
                                </div>
                                <div class="font-bold text-slate-500">Rp
                                    {{ number_format((string) ((float) $cart_item->item->harga_t / 100), 2, ',', '.') }}
                                </div>
                                <input type="hidden" name="harga_t[]"
                                    value="{{ (string) ((float) $cart_item->harga_t / 100) }}" class="binder_harga_t">
                                <input type="hidden" name="cart_item_ids[]" value="{{ $cart_item->id }}">
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
                <div class="text-xl font-bold text-red-600">Rp <span
                        id="harga_total_formatted">{{ number_format((string) ((float) $harga_total / 100), 2, ',', '.') }}</span>
                </div>
                <input type="hidden" name="harga_total" id="harga_total"
                    value="{{ (string) ((float) $harga_total / 100) }}">
            </div>
            <input type="hidden" name="pelanggan_nama" id="pelanggan_nama_di_dalam_form"
                value="{{ $cart->pelanggan_id ? $cart->pelanggan->nama : '' }}">
            <input type="hidden" name="pelanggan_username" id="pelanggan_username_di_dalam_form"
                value="{{ $cart->pelanggan_id ? $cart->pelanggan->username : '' }}">
            <input type="hidden" name="pelanggan_nik" id="pelanggan_nik_di_dalam_form"
                value="{{ $cart->pelanggan_id ? $cart->pelanggan->nik : '' }}">

            {{-- PEMBAYARAN --}}
            <h5 class="font-bold text-lg text-slate-500 my-3">Metode Pembayaran</h5>
            <div class="flex items-center">
                <input type="checkbox" id="checkbox-tunai" name="tunai" value="yes" onclick="toggleTunai(this)">
                <label for="checkbox-tunai" class="ml-2">Tunai</label>
            </div>
            <input type="text" id="jumlah_tunai" class="input ml-5 hidden"
                onchange="formatNumber(this, 'jumlah-tunai'); hitungTotalBayar()">
            <input type="hidden" name="jumlah_tunai" id="jumlah-tunai" class="jumlah-bayar">
            <div class="flex items-center mt-2">
                <input type="checkbox" id="checkbox-non-tunai" name="non_tunai" value="yes"
                    onclick="toggleNonTunai(this)">
                <label for="checkbox-non-tunai" class="ml-2">Non-Tunai</label>
            </div>
            <div id="div-non-tunai" class="hidden">
                <div id="daftar-input-pembayaran-non-tunai"></div>
                <div class="relative w-3/4 ml-5 mt-1">
                    <div class="border rounded p-3 flex items-center justify-between hover:cursor-pointer hover:bg-slate-100"
                        onclick="toggleEWallet()">
                        <span>Pilih Bank/E-Wallet</span>
                        <div class="border rounded bg-white shadow drop-shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    <div id="dd-daftar-ewallet" class="border absolute top-12 bg-white w-full z-20 hidden">
                        @foreach ($wallets_non_tunai as $wallet)
                            <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100"
                                onclick="tambahPembayaran('{{ $wallet->tipe }}', '{{ $wallet->nama }}')"
                                id="{{ $wallet->nama }}"><img
                                    src="{{ asset("img/logo-$wallet->tipe-$wallet->nama.png") }}" class="h-full"></div>
                        @endforeach
                        {{-- <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','BRI')" id="BRI"><img src="{{ asset('img/logo-bank-bri.png') }}" class="h-full"><span class="font-bold text-blue-800 text-base ml-2">BRI</span></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','Mandiri')" id="Mandiri"><img src="{{ asset('img/logo-bank-mandiri.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','BNI')" id="BNI"><img src="{{ asset('img/logo-bank-bni.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','CIMB')" id="CIMB"><img src="{{ asset('img/logo-bank-cimb.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','OCBC')" id="OCBC"><img src="{{ asset('img/logo-bank-ocbc.jpg') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','BJB')" id="BJB"><img src="{{ asset('img/logo-bank-bjb.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','Maybank')" id="Maybank"><img src="{{ asset('img/logo-bank-maybank.svg') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','GoPay')" id="GoPay"><img src="{{ asset('img/logo-ewallet-gopay.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','ShopeePay')" id="ShopeePay"><img src="{{ asset('img/logo-ewallet-shopee.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','Dana')" id="Dana"><img src="{{ asset('img/logo-ewallet-dana.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','OVO')" id="OVO"><img src="{{ asset('img/logo-ewallet-ovo.png') }}" class="h-full"><span class="font-bold text-violet-800 text-base ml-2">OVO</span></div> --}}
                        <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100"
                            onclick="tambahPembayaran('lain-lain','lain-lain')"><span
                                class="font-bold text-base ml-2">Lain - lain</span></div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <div class="">
                    <span id="label-sisa-bayar" class="font-bold text-orange-500">Sisa Bayar</span>
                    <div class="font-bold text-lg"><span>Rp </span><span
                            id="sisa-bayar">{{ number_format((string) ((float) $harga_total / 100), 2, ',', '.') }}</span>
                    </div>
                </div>
                <div class="ml-2">
                    <span class="font-bold text-emerald-500">Total Bayar</span>
                    <div class="font-bold text-lg"><span>Rp </span><span id="total-bayar">0</span></div>
                </div>
            </div>
            <input type="hidden" id="ipt-total-bayar" name="total_bayar" value="0" readonly>
            <input type="hidden" id="ipt-sisa-bayar" name="sisa_bayar"
                value="{{ (string) ((float) $harga_total / 100) }}" readonly>

            {{-- END PEMBAYARAN --}}
            <div class="relative flex justify-center mt-9 z-10">
                <button type="submit"
                    class="rounded-lg px-3 py-2 bg-emerald-400 text-white border-2 border-emerald-500 font-bold">PROSES
                    PEMBAYARAN</button>
            </div>
        </form>

        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
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
        <script src="{{ asset('js/methode_pembayaran.js') }}"></script>
        <div class="w-1/4"></div>
    </main>

    <script src="{{ asset('js/checkout.js') }}"></script>
    <script src="{{ asset('js/item.js') }}"></script>

    <script>
        const users = {!! json_encode($users, JSON_HEX_TAG) !!};
        let total_tagihan = {!! json_encode($harga_total, JSON_HEX_TAG) !!}
        // console.log(users);

        function cariDataPelanggan() {
            cariDataPelangganF(users);
        }

        function hitungTotalBayar() {
            let arr_jumlah_bayar = document.querySelectorAll('.jumlah-bayar');
            let total_bayar = 0;
            arr_jumlah_bayar.forEach(jumlah_bayar => {
                // console.log(jumlah_bayar.value);
                if (jumlah_bayar.value !== '') {
                    total_bayar = total_bayar + parseFloat(jumlah_bayar.value);
                }
            });
            // console.log(total_bayar);
            let sisa_bayar_real_value = (parseFloat(total_tagihan / 100)) - total_bayar;
            let sisa_bayar = sisa_bayar_real_value;
            if (sisa_bayar_real_value < 0) {
                document.getElementById('label-sisa-bayar').textContent = "KEMBALI";
                sisa_bayar = -sisa_bayar_real_value;
            } else {
                document.getElementById('label-sisa-bayar').textContent = "Sisa Bayar";

            }

            // console.log(total_tagihan);
            // console.log(total_tagihan / 100);
            // console.log(parseFloat(total_tagihan / 100));
            // console.log(total_bayar);
            // console.log(sisa_bayar);

            // console.log('pangkasDesimal')
            // console.log(pangkasDesimal(sisa_bayar));

            document.getElementById('total-bayar').textContent = formatNumberX(preformatDotToComa(pangkasDesimal(
                total_bayar)));
            document.getElementById('sisa-bayar').textContent = formatNumberX(preformatDotToComa(pangkasDesimal(
                sisa_bayar)));
            document.getElementById('ipt-total-bayar').value = pangkasDesimal(total_bayar).toString();
            document.getElementById('ipt-sisa-bayar').value = pangkasDesimal(sisa_bayar_real_value).toString();
        }
    </script>
@endsection
