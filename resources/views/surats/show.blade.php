@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex justify-center items-center gap-2">
        <h1 class="text-slate-400 text-xl font-bold">Surat Pembelian</h1>
        <div class="flex">
            <a href="{{ route('surat_pembelian.print_out', $surat_pembelian->id) }}" class="border-2 border-slate-300 rounded-lg text-slate-300 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
            </a>
        </div>
    </div>

    <h3 class="text-xl font-bold text-slate-500">Foto Transaksi</h3>
    @if ($surat_pembelian->photo_path)
    <div class="w-full">
        <img src="{{ asset("storage/" . $surat_pembelian->photo_path) }}" alt="item_photo" class="w-full">
    </div>
    <form action="{{ route('surat_pembelian.delete_photo', $surat_pembelian->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin hapus foto cart ini?')" class="mt-2">
        @csrf
        <div class="flex justify-center">
            <button type="submit" class="bg-pink-300 text-white rounded p-1 flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                <span class="text-sm">Hapus Foto Transaksi</span>
            </button>
        </div>
    </form>
    @else
    <form method="POST" action="{{ route('surat_pembelian.update_photo', $surat_pembelian->id) }}" class="mb-1" enctype="multipart/form-data">
        @csrf
        <label for="input-photo" class="block hover:cursor-pointer mt-2" id="label-input-photo">
            <div class="flex justify-center">
                <div class="text-white bg-slate-300 rounded-lg p-1 w-1/4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
            </div>
        </label>
        <input id="input-photo" type="file" name="photo" onchange="previewImage(this.files[0], 'div-preview-photo', 'preview-photo', 'label-input-photo')" class="hidden">
        {{-- <input type="hidden" name="photo_index" value="{{ $key }}"> --}}
        <div id="div-preview-photo" class="hidden">
            <div class="flex justify-end">
                <button type="button" class="text-red-400" onclick="removeImage('input-photo', 'div-preview-photo', 'preview-photo', 'label-input-photo')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-center">
                <img id="preview-photo"></img>
            </div>
            <div class="flex justify-center mt-1">
                <button type="submit" class="bg-emerald-300 text-white border-2 border-emerald-400 font-bold rounded px-3 py-1 text-sm">+ Tambah Photo</button>
            </div>
        </div>
    </form>
    @endif

    <h3 class="text-lg font-bold text-slate-500">Data Pelanggan</h3>

    <div class="flex justify-between mt-1 items-center">
        @if ($pelangganid)
        <table class="text-sm border">
            <tr>
                <td><label for="pelanggan_nama">Nama</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_nama" id="pelanggan_nama" value="{{ $pelanggannama }}" class="border-0 p-0" readonly></td>
            </tr>
            <tr>
                <td><label for="pelanggan_username">Username</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_username" id="pelanggan_username" value="{{ $pelangganusername }}" class="border-0 p-0" readonly></td>
            </tr>
            <tr>
                <td><label for="pelanggan_nik">NIK</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_nik" id="pelanggan_nik" value="{{ $pelanggannik }}" class="border-0 p-0" readonly></td>
            </tr>
        </table>
        @else
        <div id="tampilan_pelanggan_guest" class="mt-3 text-slate-500">- Pelanggan guest -</div>
        <table id="tampilan_data_pelanggan" class="hidden bg-slate-200">
            <tr>
                <td><label for="pelanggan_nama">Nama</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_nama" id="pelanggan_nama" value="guest" class="border rounded p-1 bg-slate-100" readonly></td>
            </tr>
            <tr>
                <td><label for="pelanggan_username">Username</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_username" id="pelanggan_username" class="border rounded p-1 bg-slate-100" readonly></td>
            </tr>
            <tr>
                <td><label for="pelanggan_nik">NIK</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_nik" id="pelanggan_nik" class="border rounded p-1 bg-slate-100" readonly></td>
            </tr>
        </table>
        @endif
        <div>
            <button type="button" id="btn-ganti" class="border-2 rounded px-2 py-1 text-slate-500 font-bold" onclick="toggle_light(this.id, 'form-cari-data-pelanggan', ['text-slate-500'], ['text-white', 'bg-slate-400'], 'block'); ">ganti</button>
        </div>
    </div>

    <form action="{{ route('surat_pembelian.update_data_pelanggan', $surat_pembelian->id) }}" method="POST" id="form-cari-data-pelanggan" class="mt-3 hidden">
        @csrf
        <table>
            <tr>
                <td><label for="cari_pelanggan_nama">Nama</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_nama" id="cari_pelanggan_nama" class="border rounded p-1"></td>
            </tr>
            <tr>
                <td><label for="cari_pelanggan_username">Username</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_username" id="cari_pelanggan_username" class="border rounded p-1"></td>
            </tr>
            <tr>
                <td><label for="cari_nik_pelanggan">NIK</label></td><td><span class="mx-2">:</span></td>
                <td><input type="text" name="pelanggan_nik" id="cari_nik_pelanggan" class="border rounded p-1"></td>
            </tr>
            <tr>
                <td colspan="3"><div id="feedback_cari_pelanggan" class="text-xs text-red-500"></div></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="flex justify-center mt-2">
                        <button type="submit" class="loading-spinner p-1 rounded-xl border-2 border-emerald-300 text-emerald-500 font-bold text-sm">Tetapkan</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

    <div>
        <div class="flex gap-1 mt-5 items-center">
            <h3 class="text-lg font-bold text-slate-500">Tanggal Surat</h3>
            <span class="text-slate-500 text-xs italic">(dd-mm-yyyy)</span>
        </div>
        <div class="flex gap-1 items-center mt-2 bg-slate-300 p-1">
            <input type="text" name="" id="" value="{{ date("d-m-Y", strtotime($surat_pembelian->tanggal_surat)) }}" class="rounded bg-slate-100 font-bold text-slate-600" disabled>
        </div>

        <h3 class="text-lg font-bold text-slate-500 mt-5">Data Barang</h3>
        <div class="mt-5">
            @foreach ($surat_pembelian->items as $key => $surat_pembelian_item)
            <div class="grid grid-cols-12 border-y py-3">
                <div class="col-span-3 foto-barang flex items-center">
                    @if ($surat_pembelian_item->photo_path)
                    <div class="w-full flex justify-center">
                        <img src="{{ asset("storage/" . $surat_pembelian_item->photo_path) }}" alt="item_photo" class="w-full">
                    </div>
                    @else
                    @if ($surat_pembelian_item->photo_path)
                    <div class="w-full flex justify-center">
                        <img src="{{ asset("storage/" . $surat_pembelian_item->photo_path) }}" alt="item_photo" class="w-full">
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
                        <div class="font-bold text-slate-500">{{ $surat_pembelian_item->nama_short }}</div>
                        <div class="font-bold text-slate-600 text-xs">Rp {{ my_decimal_format($surat_pembelian_item->harga_g) }} / g</div>
                        <div class="font-bold text-slate-500">Rp {{ my_decimal_format($surat_pembelian_item->harga_t) }}</div>
                        <input type="hidden" name="harga_t[]" value="{{ (string)((float)$surat_pembelian_item->harga_t / 100) }}" class="binder_harga_t">
                        <input type="hidden" name="cart_item_ids[]" value="{{ $surat_pembelian_item->id }}">
                    </div>
                    <div class="w-6 h-6 flex justify-center border font-bold text-slate-500">1</div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-end mt-2 gap-3">
            <span class="text-xl font-bold text-red-600">Total:</span>
            <div class="text-xl font-bold text-red-600">Rp <span id="harga_total_formatted">{{ my_decimal_format($surat_pembelian->harga_total) }}</span></div>
            <input type="hidden" name="harga_total" id="harga_total" value="{{ (string)((float)$surat_pembelian->harga_total / 100) }}">
        </div>
        <input type="hidden" name="pelanggan_nama" id="pelanggan_nama_di_dalam_form" value="{{ $surat_pembelian->pelanggan_id ? $surat_pembelian->pelanggan_nama : '' }}">
        <input type="hidden" name="pelanggan_username" id="pelanggan_username_di_dalam_form" value="{{ $surat_pembelian->pelanggan_id ? $surat_pembelian->pelanggan_username : '' }}">
        <input type="hidden" name="pelanggan_nik" id="pelanggan_nik_di_dalam_form" value="{{ $surat_pembelian->pelanggan_id ? $surat_pembelian->pelanggan_nik : '' }}">

        {{-- PEMBAYARAN --}}
        {{-- <h5 class="font-bold text-lg text-slate-500 my-3">Metode Pembayaran</h5>
        <div class="flex items-center">
            <input type="checkbox" id="checkbox-tunai" name="tunai" value="yes" onclick="toggleTunai(this)">
            <label for="checkbox-tunai" class="ml-2">Tunai</label>
        </div>
        <input type="text" id="jumlah_tunai" class="input ml-5 hidden" onchange="formatNumber(this, 'jumlah-tunai'); hitungTotalBayar()">
        <input type="hidden" name="jumlah_tunai" id="jumlah-tunai" class="jumlah-bayar">
        <div class="flex items-center mt-2">
            <input type="checkbox" id="checkbox-non-tunai" name="non_tunai" value="yes" onclick="toggleNonTunai(this)">
            <label for="checkbox-non-tunai" class="ml-2">Non-Tunai</label>
        </div> --}}
        <h5 class="font-bold text-lg text-slate-500 my-3">Histori Pembayaran</h5>
        <table class="table-slim w-full">
            @foreach ($surat_pembelian->cashflows as $cashflow)
            <tr><td>{{ $cashflow->kategori_wallet }}</td><td>{{ $cashflow->tipe_wallet }}</td><td>{{ $cashflow->nama_wallet }}</td><td>{{ my_decimal_format($cashflow->jumlah) }}</td></tr>
            @endforeach
        </table>

        <div class="flex justify-end mt-5">
            <div class="">
                @if ((float)$surat_pembelian->sisa_bayar < 0)
                <span id="label-sisa-bayar" class="font-bold text-orange-500">Kembali</span>
                <div class="font-bold text-lg"><span>Rp </span><span id="sisa-bayar">{{ my_decimal_format((float)$surat_pembelian->sisa_bayar * -1) }}</span></div>
                @else
                <span id="label-sisa-bayar" class="font-bold text-orange-500">Sisa Bayar</span>
                <div class="font-bold text-lg"><span>Rp </span><span id="sisa-bayar">{{ my_decimal_format((float)$surat_pembelian->sisa_bayar ) }}</span></div>
                @endif
            </div>
            <div class="ml-2">
                <span class="font-bold text-emerald-500">Total Bayar</span>
                <div class="font-bold text-lg"><span>Rp </span><span id="total-bayar">{{ my_decimal_format((float)$surat_pembelian->total_bayar ) }}</span></div>
            </div>
        </div>
        <input type="hidden" id="ipt-total-bayar" name="total_bayar" value="{{ (string)((float)$surat_pembelian->total_bayar / 100) }}" readonly>
        <input type="hidden" id="ipt-sisa-bayar" name="sisa_bayar" value="{{ (string)((float)$surat_pembelian->sisa_bayar / 100) }}" readonly>

        {{-- END PEMBAYARAN --}}
        {{-- <div class="relative flex justify-center mt-9 z-10">
            <button type="submit" class="rounded-lg px-3 py-2 bg-emerald-400 text-white border-2 border-emerald-500 font-bold">PROSES PEMBAYARAN</button>
        </div> --}}
    </div>

    <form action="{{ route('surat_pembelian.delete', $surat_pembelian->id) }}" class="flex justify-center mt-5" onsubmit="return confirm('Yakin ingin hapus/batalkan surat_pembelian ini?')">
        <button class="flex gap-1 justify-center items-center bg-red-200 text-red-500 rounded-lg px-3 py-2 border-2 border-red-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            <span>Hapus/Batalkan</span>
        </button>
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

<script>
    let total_tagihan = {!! json_encode($surat_pembelian->harga_total, JSON_HEX_TAG) !!}
    // console.log(users);

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
        let sisa_bayar_real_value = (parseFloat(total_tagihan/ 100)) - total_bayar;
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

        document.getElementById('total-bayar').textContent = formatNumberX(preformatDotToComa(pangkasDesimal(total_bayar)));
        document.getElementById('sisa-bayar').textContent = formatNumberX(preformatDotToComa(pangkasDesimal(sisa_bayar)));
        document.getElementById('ipt-total-bayar').value = pangkasDesimal(total_bayar).toString();
        document.getElementById('ipt-sisa-bayar').value = pangkasDesimal(sisa_bayar_real_value).toString();
    }
</script>
@endsection

