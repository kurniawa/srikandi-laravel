@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>


    <h3 class="text-xl font-bold text-slate-500">Data Pelanggan</h3>
    <div class="flex justify-between mt-3 items-center">
        @if ($cart->pelanggan_id)
        <table>
            <tr>
                <td><label for="nama_pelanggan">Nama</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="nama_pelanggan" id="nama_pelanggan" value="guest" class="border rounded p-1" value="{{ $cart->user->nama }}"></td>
            </tr>
            <tr>
                <td><label for="username_pelanggan">Username</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="username_pelanggan" id="username_pelanggan" value="{{ $cart->user->username }}" class="border rounded p-1"></td>
            </tr>
        </table>
        @else
        <div id="tampilan_pelanggan_guest" class="mt-3 text-slate-500">- Pelanggan guest -</div>
        <table id="tampilan_data_pelanggan" class="hidden bg-slate-200">
            <tr>
                <td><label for="nama_pelanggan">Nama</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="nama_pelanggan" id="nama_pelanggan" value="guest" class="border rounded p-1 bg-slate-100" readonly></td>
            </tr>
            <tr>
                <td><label for="username_pelanggan">Username</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="username_pelanggan" id="username_pelanggan" class="border rounded p-1 bg-slate-100" readonly></td>
            </tr>
        </table>
        @endif
        <div>
            <button type="button" id="btn-ganti" class="border-2 rounded px-2 py-1 text-slate-500 font-bold" onclick="toggle_light(this.id, 'form-cari-data-pelanggan', ['text-slate-500'], ['text-white', 'bg-slate-400'], 'block'); ">ganti</button>
        </div>
    </div>

    <div action="" id="form-cari-data-pelanggan" class="mt-3 hidden">
        <table>
            <tr>
                <td><label for="cari_nama_pelanggan">Nama</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="cari_nama_pelanggan" id="cari_nama_pelanggan" class="border rounded p-1"></td>
            </tr>
            <tr>
                <td><label for="cari_username_pelanggan">Username</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="cari_username_pelanggan" id="cari_username_pelanggan" class="border rounded p-1"></td>
            </tr>
            <tr>
                <td colspan="3"><div id="feedback_cari_pelanggan" class="text-xs text-red-500"></div></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="flex justify-center mt-2">
                        <button type="submit" class="p-1 rounded-xl border-2 border-emerald-300 text-emerald-500 font-bold text-sm" onclick="cariDataPelanggan()">Tetapkan</button>
                    </div>
                </td>
            </tr>
        </table>
    </div>

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
                <option value="{{ $i }}" {{ old('hari') == $i ? 'selected' : '' }}>{{ $i }}</option>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                </svg>
            </div>
            <select name="bulan" id="bulan" class="border py-1 rounded" disabled>
                @if (old('bulan'))
                @for ($i = 1; $i < 13; $i++)
                <option value="{{ $i }}" {{ old('bulan') == $i ? 'selected' : '' }}>{{ $i }}</option>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                </svg>
            </div>
            <input type="text" name="tahun" class="border rounded p-1 w-1/3" value="{{ old('tahun') ? old('tahun') : date('Y') }}" readonly>
            {{-- kalau nanti ada fungsi pengubahan tanggal surat, maka ini boleh dihapus --}}
            <input type="hidden" name="hari" value="{{ date('d') }}" readonly>
            <input type="hidden" name="bulan" value="{{ date('m') }}" readonly>
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
                        <div class="font-bold text-slate-600 text-xs">Rp {{ number_format((string)((float)$cart_item->item->harga_g / 100), 2, ',', '.') }} / g</div>
                        <div class="font-bold text-slate-500">Rp {{ number_format((string)((float)$cart_item->item->harga_t / 100), 2, ',', '.') }}</div>
                        <input type="hidden" name="harga_t[]" value="{{ (string)((float)$cart_item->harga_t / 100) }}" class="binder_harga_t">
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
            <div class="text-xl font-bold text-red-600">Rp <span id="harga_total_formatted">{{ number_format((string)((float)$harga_total / 100), 2, ',', '.') }}</span></div>
            <input type="hidden" name="harga_total" id="harga_total" value="{{ (string)((float)$harga_total / 100) }}">
        </div>
        <input type="hidden" name="nama_pelanggan" id="nama_pelanggan_di_dalam_form" value="{{ $cart->pelanggan_id ? $cart->user->nama : 'guest' }}">
        <input type="hidden" name="username_pelanggan" id="username_pelanggan_di_dalam_form" value="{{ $cart->pelanggan_id ? $cart->user->username : 'guest' }}">

        {{-- PEMBAYARAN --}}
        <h5 class="font-bold text-lg text-slate-500 my-3">Metode Pembayaran</h5>
        <div class="flex items-center">
            <input type="checkbox" id="checkbox-tunai" name="tunai" value="yes" onclick="toggleTunai(this)">
            <label for="checkbox-tunai" class="ml-2">Tunai</label>
        </div>
        <input type="text" id="jumlah_tunai" class="input ml-5 hidden" onchange="formatNumber(this, 'jumlah-tunai'); hitungTotalBayar()">
        <input type="hidden" name="jumlah_tunai" id="jumlah-tunai" class="jumlah-bayar">
        <div class="flex items-center mt-2">
            <input type="checkbox" id="checkbox-non-tunai" name="non_tunai" value="yes" onclick="toggleNonTunai(this)">
            <label for="checkbox-non-tunai" class="ml-2">Non-Tunai</label>
        </div>
        <div id="div-non-tunai" class="hidden">
            <div id="daftar-input-pembayaran-non-tunai"></div>
            <div class="relative w-3/4 ml-5 mt-1">
                <div class="border rounded p-3 flex items-center justify-between hover:cursor-pointer hover:bg-slate-100" onclick="toggleEWallet()">
                    <span>Pilih Bank/E-Wallet</span>
                    <div class="border rounded bg-white shadow drop-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                <div id="dd-daftar-ewallet" class="border absolute top-12 bg-white w-full z-10 hidden">
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','bca')" id="bca"><img src="{{ asset('img/logo-bank-bca.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','bri')" id="bri"><img src="{{ asset('img/logo-bank-bri.png') }}" class="h-full"><span class="font-bold text-blue-800 text-base ml-2">BRI</span></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','mandiri')" id="mandiri"><img src="{{ asset('img/logo-bank-mandiri.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','bni')" id="bni"><img src="{{ asset('img/logo-bank-bni.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','cimb')" id="cimb"><img src="{{ asset('img/logo-bank-cimb.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','ocbc')" id="ocbc"><img src="{{ asset('img/logo-bank-ocbc.jpg') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','bjb')" id="bjb"><img src="{{ asset('img/logo-bank-bjb.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('bank','maybank')" id="maybank"><img src="{{ asset('img/logo-bank-maybank.svg') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','gopay')" id="gopay"><img src="{{ asset('img/logo-ewallet-gopay.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','shopee')" id="shopee"><img src="{{ asset('img/logo-ewallet-shopee.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','dana')" id="dana"><img src="{{ asset('img/logo-ewallet-dana.png') }}" class="h-full"></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('ewallet','ovo')" id="ovo"><img src="{{ asset('img/logo-ewallet-ovo.png') }}" class="h-full"><span class="font-bold text-violet-800 text-base ml-2">OVO</span></div>
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('lain-lain','lain-lain')"><span class="font-bold text-base ml-2">Lain - lain</span></div>
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <div class="">
                <span class="font-bold text-orange-500">Sisa Bayar</span>
                <div class="font-bold text-lg"><span>Rp </span><span id="sisa-bayar">{{ number_format((string)((float)$harga_total / 100), 2, ',', '.') }}</span></div>
            </div>
            <div class="ml-2">
                <span class="font-bold text-emerald-500">Total Bayar</span>
                <div class="font-bold text-lg"><span>Rp </span><span id="total-bayar">0</span></div>
            </div>
        </div>
        <input type="hidden" id="ipt-total-bayar" name="total_bayar" value="0" readonly>
        <input type="hidden" id="ipt-sisa-bayar" name="sisa_bayar" value="{{ (string)((float)$harga_total / 100) }}" readonly>

        {{-- END PEMBAYARAN --}}
        <div class="relative flex justify-center mt-9 z-10">
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
    <script src="{{ asset('js/methode_pembayaran.js') }}"></script>
    <div class="w-1/4"></div>
</main>

<script>
    const users = {!! json_encode($users, JSON_HEX_TAG) !!};
    let total_tagihan = {!! json_encode($harga_total, JSON_HEX_TAG) !!}
    console.log(users);

    function cariDataPelanggan() {
        let nama_pelanggan = document.getElementById('cari_nama_pelanggan');
        if (nama_pelanggan) {
            nama_pelanggan = nama_pelanggan.value.trim();
        }
        let username_pelanggan = document.getElementById('cari_username_pelanggan');
        if (username_pelanggan) {
            username_pelanggan = username_pelanggan.value.trim();
        }

        let found_pelanggan = null;

        // console.log(nama_pelanggan);
        if (nama_pelanggan && username_pelanggan) {
            // var pilihan_jenis_perhiasans = jenis_perhiasans.filter((o) => o.tipe_perhiasan_id == tipe_perhiasan.id);
            found_pelanggan = users.filter((o) => o.username == username_pelanggan);
        } else if (nama_pelanggan && !username_pelanggan) {
            found_pelanggan = users.filter((o) => o.nama == nama_pelanggan);
        } else if (!nama_pelanggan && username_pelanggan) {
            found_pelanggan = users.filter((o) => o.username == username_pelanggan);
        }

        console.log(found_pelanggan);
        if (found_pelanggan.length === 1) {
            document.getElementById('nama_pelanggan').value = found_pelanggan[0].nama;
            document.getElementById('nama_pelanggan_di_dalam_form').value = found_pelanggan[0].nama;
            document.getElementById('username_pelanggan').value = found_pelanggan[0].username;
            document.getElementById('username_pelanggan_di_dalam_form').value = found_pelanggan[0].username;
            $('#tampilan_data_pelanggan').show(300);
            $('#tampilan_pelanggan_guest').hide(300);
            toggle_light('btn-ganti', 'form-cari-data-pelanggan', ['text-slate-500'], ['text-white', 'bg-slate-400'], 'block');
        } else {
            document.getElementById('feedback_cari_pelanggan').textContent = '- ditemukan lebih dari satu pelanggan dengan nama yang sama atau ada kesalahan -'
        }
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
        let sisa_bayar = (parseFloat(total_tagihan/ 100)) - total_bayar;

        // console.log(total_tagihan);
        // console.log(total_tagihan / 100);
        // console.log(parseFloat(total_tagihan / 100));
        // console.log(total_bayar);
        // console.log(sisa_bayar);

        console.log('pangkasDesimal')
        console.log(pangkasDesimal(sisa_bayar));

        document.getElementById('total-bayar').textContent = formatNumberX(preformatDotToComa(pangkasDesimal(total_bayar)));
        document.getElementById('sisa-bayar').textContent = formatNumberX(preformatDotToComa(pangkasDesimal(sisa_bayar)));
        document.getElementById('ipt-total-bayar').value = pangkasDesimal(total_bayar).toString();
        document.getElementById('ipt-sisa-bayar').value = pangkasDesimal(sisa_bayar).toString();
    }
</script>
@endsection
