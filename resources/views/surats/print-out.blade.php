@extends('layouts.main')
@section('content')
<style>

</style>
<main>
    <div class="flex justify-between items-center">
        {{-- KOP / CAP TOKO EMAS SRIKANDI --}}
        <div>
            <div class="flex gap-2 items-center">
                <div class="w-24">
                    <img src="{{ asset('img/icons-simbol-toko/diamond.png') }}" alt="" class="w-full">
                </div>
                <div>
                    <h1 class="text-slate-400 text-xl font-bold font-playfair-display">Toko Emas</h1>
                    <h2 class="font-almendra text-3xl">SRIKANDI</h2>
                    <div>
                        <p class="font-bold text-xs text-slate-400">Pasar Cibinong</p>
                        <p class="text-xs text-slate-400">Pertokoan Cibinong Indah</p>
                        <p class="text-xs text-slate-400">Blok A-10, no. 27</p>
                    </div>

                </div>
            </div>
        </div>
        {{-- DATA PELANGGAN --}}
        <div>
            @if ($surat_pembelian->pelanggan_id)
            <span>- {{ $surat_pembelian->pelanggan_nama }} -</span>
            @else
            <span class="text-slate-400 italic font-bold text-xs">- guest -</span>
            @endif
            <div>
                <div class="text-xs font-bold text-slate-400">e-invoice</div>
                <table class="text-sm text-slate-400 border border-collapse">
                    <tr class="border border-collapse"><td>Tanggal</td><td>:</td><td>{{ date("d-m-Y", strtotime($surat_pembelian->tanggal_surat)) }}</td></tr>
                    <tr class="border border-collapse"><td>Invoice-ID</td><td>:</td><td class=" font-bold">{{ $surat_pembelian->nomor_surat }}</td></tr>
                </table>
            </div>
        </div>
        {{-- FOTO TRANSAKSI --}}
        <div class="w-1/3 flex justify-end">
            @if ($surat_pembelian->photo_path)
            <div class="w-4/5 border-2 border-slate-200 rounded-lg overflow-hidden p-1">
                <img src="{{ asset("storage/" . $surat_pembelian->photo_path) }}" alt="item_photo" class="w-full">
            </div>
            @else
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
            @endif

        </div>
    </div>

    <div class="mt-2">
        <div class="grid grid-cols-12 text-sm font-bold text-slate-400 font-playfair-display">
            <div class="col-span-1">No.</div>
            <div class="col-span-9 text-center">Data Barang</div>
            <div class="col-span-2">Jml./Ongkos/Hrg.</div>
        </div>
        @foreach ($surat_pembelian->items as $key => $item)
        <div class="grid grid-cols-12 border-y py-3">
            <div class="col-span-2 foto-barang flex items-center">
                <div class="text-slate-500">{{ $key + 1 }}.</div>
                @if ($item->photo_path)
                <div class="w-full flex justify-center">
                    <img src="{{ asset("storage/" . $item->photo_path) }}" alt="item_photo" class="w-full">
                </div>
                @else
                <div class="w-full flex justify-center text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-1/2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </div>
                @endif
            </div>
            <div class="col-span-10 flex justify-between items-center">
                <div>
                    <div class="font-bold text-slate-500">{{ $item->shortname }}</div>
                    <div class="grid grid-cols-5 text-slate-400 text-xs gap-x-2">
                        @if ($item->warna_emas)
                        <span>we:{{ $item->warna_emas }}</span>
                        @endif
                        @if ($item->kadar)
                        <span>k:{{ $item->kadar / 100 }}%</span>
                        @endif
                        @if ($item->berat)
                        <span>b:{{ $item->berat / 100 }}g</span>
                        @endif
                        @if ($item->kondisi)
                        <span>zu:{{ $item->kondisi }}</span>
                        @endif
                        @if ($item->range_usia)
                        <span>ru:{{ $item->range_usia }}</span>
                        @endif
                        @if ($item->ukuran)
                        <span>uk:{{ $item->ukuran }}mm</span>
                        @endif
                        @if ($item->cap)
                        <span>cap:{{ $item->cap }}</span>
                        @endif
                        @if ($item->merk)
                        <span>merk:{{ $Item->merk }}</span>
                        @endif
                        @if ($item->plat)
                        <span>plat:{{ $item->plat }}</span>
                        @endif
                        @if ($item->edisi)
                        <span>edisi:{{ $item->edisi }}</span>
                        @endif
                        @if ($item->nampan)
                        <span>nampan:{{ $item->nampan }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-slate-500">
                    <div class="w-6 h-6 flex justify-center border font-bold text-slate-500">1</div>
                    @if ($item->harga_g)
                    <div class="text-sm text-slate-500">Rp {{ my_decimal_format($item->harga_g) }} /g</div>
                    @endif
                    @if ($item->ongkos_g)
                    <div class="text-sm text-slate-500">ongkos: Rp {{ my_decimal_format($item->ongkos_g) }} /g</div>
                    @endif
                    <div class="font-bold text-slate-500">Rp {{ my_decimal_format($item->harga_t) }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="flex justify-between mt-2 gap-3 items-center    ">
        {{-- DATA USER --}}
        <span class="text-xs text-slate-400">CS: {{ $surat_pembelian->user->nama }}</span>
        <div class="flex gap-1">
            <span class="text-xl font-bold text-red-600">Total:</span>
            <div class="text-xl font-bold text-red-600">Rp <span id="harga_total_formatted">{{ my_decimal_format($surat_pembelian->harga_total) }}</span></div>
        </div>
    </div>

    {{-- SYARAT & KETENTUAN --}}
    <div class="border p-1 border-red-300">
        <div class="text-xs font-bold text-red-400">PERHATIAN</div>
        <div class="pl-3">
            <ol class="list-decimal list-outside text-xs text-red-400">
                <li>E-invoice ini tercatat/tersimpan dalam sistem. Selama pelanggan terdaftar dalam sistem, maka penjualan kembali tanpa surat masih bisa dilakukan apabila foto transaksi cukup jelas dan sesuai dengan pemilik surat/barang.</li>
                <li>Perhiasan telah ditimbang ulang dan disaksikan oleh pembeli. Keakuratan hingga 2 angka di belakang koma.</li>
                <li>Pada saat penjualan kembali, berat perhiasan bisa saja berkurang/menyusut. Penyebab penyusutan diantaranya: gesekan, barang rusak sehingga ada bagian yang hilang, dll. Apabila terjadi penyusutan yang cukup signifikan, maka harga jual kembali pun akan disesuaikan.</li>
            </ol>

        </div>
    </div>

    <div class="mt-5 flex justify-center no-print">
        <button class="bg-emerald-300 text-white rounded-lg border-2 border-emerald-400 px-3 py-1" onclick="window.print(); return false;">Cetak</button>
    </div>
    <div class="mt-2 flex justify-center no-print">
        <button class="bg-rose-300 text-white rounded-lg border-2 border-rose-400 px-3 py-1" onclick="window.history.back(); return false;">Kembali</button>
    </div>
</main>

<script src="{{ asset('js/checkout.js') }}"></script>

<script>
    let total_tagihan = {!! json_encode($surat_pembelian->harga_total, JSON_HEX_TAG) !!}
    // console.log(users);

</script>

<style>
    @media print {
        .no-print {
            display: none;
        }

        @page {
            size: A4;
            /* DIN A4 standard, Europe */
            margin: 5mm 5mm 0 5mm;
            padding-top: 0;
        }

        html,
        body {
            width: 210mm;
            /* height: 297mm; */
            height: 282mm;
            /* font-size: 11px; */
            background: #FFF;
            overflow: visible;
            padding-top: 0mm;
        }
    }
</style>
@endsection

