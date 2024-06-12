@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>


    <div class="grid grid-cols-2 gap-2">
        <div>
            <div class="flex items-center gap-2">
                <div class="bg-white shadow drop-shadow p-2 rounded flex gap-2 items-center text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                    <h1 class="font-bold">Proses Buyback</h1>
                </div>
            </div>
            <div class="text-xs font-bold text-slate-400 mt-3">
                <div><label for="" class="">Nomor Surat/Invoice-ID</label></div>
                <div class="border rounded p-1">{{ $surat_pembelian->nomor_surat }}</div>
                <div><label for="" class="">Tanggal</label></div>
                <div class="border rounded p-1">{{ date("d-m-Y", strtotime($surat_pembelian->tanggal_surat)) }}</div>
                <div><label for="" class="">Pelanggan</label></div>
                <div class="border rounded p-1">{{ $surat_pembelian->pelanggan ? $surat_pembelian->pelanggan->nama : '- guest -' }}</div>
            </div>
        </div>
        <div>
            @if ($surat_pembelian->photo_path)
            <div class="border rounded p-2">
                <img src="{{ asset("storage/" . $surat_pembelian->photo_path) }}" alt="item_photo" class="w-full">
            </div>
            @else
            <div>

            </div>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-2 mt-3">
        <div class="bg-white shadow drop-shadow p-1 rounded flex gap-2 items-center text-slate-500">
            <h1 class="">Data Barang</h1>
        </div>
    </div>

    <form action="{{ route('surat_pembelian.proses_buyback', $surat_pembelian->id) }}" method="POST">
        @csrf
        @foreach ($surat_pembelian->items as $key => $surat_pembelian_item)
        <div class="grid grid-cols-12 border-y py-3 gap-1">
            <div class="col-span-3 foto-barang flex items-center gap-1">
                <div class="text-xs">{{ $key+1 }}.</div>
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
                    <input type="hidden" name="harga_t[]" id="harga_t-{{ $key }}" value="{{ $surat_pembelian_item->harga_t / 100 }}">
                </div>
                <div class="w-6 h-6 flex justify-center border font-bold text-slate-500">1</div>
            </div>
        </div>
        <div id="tombol-toggle-{{ $key }}" class="mt-2">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer checkbox-toggle-buyback" onclick="toggleBuyback({{ $key }}, this)">
                <input type="hidden" name="surat_pembelian_item_id[]" value="{{ $surat_pembelian_item->id }}">
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Buyback</span>
            </label>
        </div>
        <div id="buyback_form-{{ $key }}" class="grid-cols-12 bg-violet-100 text-slate-500 p-2 rounded hidden">
            <div class="flex text-slate-500 justify-center">
                <div class="bg-yellow-200 p-1 shadow drop-shadow"><h5>Data Buyback / Jual Kembali / Tukar</h5></div>
            </div>
            <table class="mt-2">
                <tr>
                    <td colspan="3">
                        <x-tanggal-multiple></x-tanggal-multiple>
                    </td>
                </tr>
                <tr>
                    <td>Buyback</td><td>:</td>
                    <td>
                        <select id="status_buyback" name="status_buyback[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @if (old('status_buyback'))
                            @if (old('status_buyback') == "buyback")
                            <option value="buyback" selected>Buyback</option>
                            @else
                            <option value="buyback">Buyback</option>
                            @endif
                            @if (old('status_buyback') == "tukar")
                            <option value="tukar" selected>Tukar</option>
                            @else
                            <option value="tukar">Tukar</option>
                            @endif
                            @if (old('status_buyback') == "tukar-kurang")
                            <option value="tukar-kurang" selected>Tukar Kurang</option>
                            @else
                            <option value="tukar-kurang">Tukar Kurang</option>
                            @endif
                            @if (old('status_buyback') == "tukar-tambah")
                            <option value="tukar-tambah" selected>Tukar Tambah</option>
                            @else
                            <option value="tukar-tambah">Tukar Tambah</option>
                            @endif
                            @else
                            <option value="buyback">Buyback</option>
                            <option value="tukar">Tukar</option>
                            <option value="tukar-kurang">Tukar Kurang</option>
                            <option value="tukar-tambah">Tukar Tambah</option>
                            @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Kondisi</td><td>:</td>
                    <td>
                        <select id="kondisi_buyback" name="kondisi_buyback[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @if (old('kondisi_buyback'))
                            @if (old('kondisi_buyback') == "9")
                            <option value="9" selected>9 - mulus</option>
                            @else
                            <option value="9">9 - mulus</option>
                            @endif
                            @if (old('kondisi_buyback') == "8")
                            <option value="8" selected>8 - sedikit cacat/hampir tidak terlihat</option>
                            @else
                            <option value="8">8 - sedikit cacat/hampir tidak terlihat</option>
                            @endif
                            @if (old('kondisi_buyback') == "7")
                            <option value="7" selected>7 - cacat jelas terlihat</option>
                            @else
                            <option value="7">7 - cacat jelas terlihat</option>
                            @endif
                            @if (old('kondisi_buyback') == "6")
                            <option value="6" selected>6 - cacat banget</option>
                            @else
                            <option value="6">6 - cacat banget</option>
                            @endif
                            @if (old('kondisi_buyback') == "5")
                            <option value="5" selected>5 - ancur / rusak</option>
                            @else
                            <option value="5">5 - ancur / rusak</option>
                            @endif
                            @else
                            <option value="9">9 - mulus</option>
                            <option value="8">8 - sedikit cacat/hampir tidak terlihat</option>
                            <option value="7">7 - cacat jelas terlihat</option>
                            <option value="6">6 - cacat banget</option>
                            <option value="5">5 - ancur / rusak</option>
                            @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><div class="whitespace-nowrap">Berat</div></td><td>:</td>
                    @if (old('berat_buyback'))
                    <td>
                        <input type="text" id="berat_buyback_formatted" class="rounded p-1" value="{{ old('berat_buyback_formatted') }}">
                        <input type="hidden" id="berat_buyback" name="berat_buyback[]" value="{{ old('berat_buyback') }}">
                    </td>
                    @else
                    <td>
                        <input type="text" id="berat_buyback_formatted" class="rounded p-1" value="{{ casual_decimal_format($surat_pembelian_item->berat) }}">
                        <input type="hidden" id="berat_buyback" name="berat_buyback[]" value="{{ $surat_pembelian_item->berat / 100 }}">
                    </td>
                    @endif
                </tr>
                <tr>
                    <td><div class="whitespace-nowrap">p-ongkos</div></td><td>:</td>
                    @if (old('potongan_ongkos'))
                    <td>
                        <input type="text" id="potongan_ongkos_formatted-{{ $key }}" class="rounded p-1" onchange="formatNumber(this, 'potongan_ongkos-{{ $key }}');hitungHargaBuyback({{ $key }})" value="{{ old('potongan_ongkos_formatted') }}">
                        <input type="hidden" name="potongan_ongkos[]" id="potongan_ongkos-{{ $key }}"  value="{{ old('potongan_ongkos') }}">
                    </td>
                    @else
                    <td>
                        <input type="text" id="potongan_ongkos_formatted-{{ $key }}" class="rounded p-1" onchange="formatNumber(this, 'potongan_ongkos-{{ $key }}');hitungHargaBuyback({{ $key }})" value="{{ casual_decimal_format((float)$surat_pembelian_item->ongkos_g * (float)$surat_pembelian_item->berat / 100) }}">
                        <input type="hidden" name="potongan_ongkos[]" id="potongan_ongkos-{{ $key }}" value="{{ (float)$surat_pembelian_item->ongkos_g * (float)$surat_pembelian_item->berat / 10000 }}">
                    </td>
                    @endif
                </tr>
                <tr>
                    <td><div class="whitespace-nowrap">p-mata</div></td><td>:</td>
                    @if (old('potongan_mata'))
                    <td>
                        <input type="text" id="potongan_mata_formatted-{{ $key }}" onchange="formatNumber(this, 'potongan_mata-{{ $key }}');hitungHargaBuyback({{ $key }})" class="rounded p-1" value="{{ old('potongan_mata_formatted') }}">
                        <input type="hidden" name="potongan_mata[]" id="potongan_mata-{{ $key }}" >
                    </td>
                    @else
                    <td>
                        <input type="text" id="potongan_mata_formatted-{{ $key }}" onchange="formatNumber(this, 'potongan_mata-{{ $key }}');hitungHargaBuyback({{ $key }})" class="rounded p-1">
                        <input type="hidden" name="potongan_mata[]" id="potongan_mata-{{ $key }}">
                    </td>
                    @endif
                </tr>
                <tr>
                    <td><div class="whitespace-nowrap">p-rusak</div></td><td>:</td>
                    @if (old('potongan_rusak'))
                    <td>
                        <input type="text" id="potongan_rusak_formatted-{{ $key }}" onchange="formatNumber(this, 'potongan_rusak-{{ $key }}');hitungHargaBuyback({{ $key }})" class="rounded p-1" value="{{ old('potongan_rusak_formatted') }}">
                        <input type="hidden" name="potongan_rusak[]" id="potongan_rusak-{{ $key }}" value="{{ old('potongan_rusak') }}">
                    </td>
                    @else
                    <td>
                        <input type="text" id="potongan_rusak_formatted-{{ $key }}" onchange="formatNumber(this, 'potongan_rusak-{{ $key }}');hitungHargaBuyback({{ $key }})" class="rounded p-1">
                        <input type="hidden" name="potongan_rusak[]" id="potongan_rusak-{{ $key }}">
                    </td>
                    @endif
                </tr>
                <tr>
                    <td><div class="whitespace-nowrap">p-susut</div></td><td>:</td>
                    @if (old('potongan_susut'))
                    <td>
                        <input type="text" id="potongan_susut_formatted-{{ $key }}" class="rounded p-1" onchange="formatNumber(this, 'potongan_susut-{{ $key }}');hitungHargaBuyback({{ $key }})" value="{{ old('potongan_susut_formatted') }}">
                        <input type="hidden" name="potongan_susut[]" id="potongan_susut-{{ $key }}"  value="{{ old('potongan_susut') }}">
                    </td>
                    @else
                    <td>
                        <input type="text" id="potongan_susut_formatted-{{ $key }}" onchange="formatNumber(this, 'potongan_susut-{{ $key }}');hitungHargaBuyback({{ $key }})" class="rounded p-1">
                        <input type="hidden" name="potongan_susut[]" id="potongan_susut-{{ $key }}">
                    </td>
                    @endif
                </tr>
                <tr>
                    <td><div class="whitespace-nowrap">p-lain</div></td><td>:</td>
                    @if (old('potongan_lain'))
                    <td>
                        <input type="text" id="potongan_lain_formatted-{{ $key }}" onchange="formatNumber(this, 'potongan_lain-{{ $key }}');hitungHargaBuyback({{ $key }})" class="rounded p-1" value="{{ old('potongan_lain_formatted') }}">
                        <input type="hidden" name="potongan_lain[]" id="potongan_lain-{{ $key }}"  value="{{ old('potongan_lain') }}">
                    </td>
                    @else
                    <td>
                        <input type="text" id="potongan_lain_formatted-{{ $key }}" onchange="formatNumber(this, 'potongan_lain-{{ $key }}');hitungHargaBuyback({{ $key }})" class="rounded p-1">
                        <input type="hidden" name="potongan_lain[]" id="potongan_lain-{{ $key }}">
                    </td>
                    @endif
                </tr>
                <tr>
                    <td><div class="whitespace-nowrap">keterangan</div></td><td>:</td>
                    @if (old('keterangan_buyback'))
                    <td>
                        <textarea name="keterangan_buyback[]" id="keterangan_buyback-{{ $key }}" rows="3" class="border rounded p-2">{{ old('keterangan_buyback') }}</textarea>
                    </td>
                    @else
                    <td>
                        <textarea name="keterangan_buyback[]" id="keterangan_buyback-{{ $key }}" rows="3" class="border rounded p-2"></textarea>
                    </td>
                    @endif
                </tr>
            </table>
            <div class="flex justify-end">
                <div>
                    <div class="font-bold text-indigo-400 text-end">Harga Terima</div>
                    <div class="font-bold text-rose-400 text-xl">
                        <span>Rp</span> <span id="harga_buyback_formatted-{{ $key }}"></span>
                        <input type="hidden" name="harga_buyback[]" id="harga_buyback-{{ $key }}">
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-3">
                <button type="submit" name="locked" value="{{ $key }}" class="bg-slate-400 p-2 rounded-lg text-white flex justify-center items-center gap-2 font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    <span>Locked</span>
                </button>
            </div>
        </div>
        @endforeach

        <div class="mt-3">
            <div class="flex justify-end">
                <div>
                    <span class="text-xl font-bold text-indigo-500">Harga Total Terima</span>
                    <div class="text-xl font-bold text-rose-500">Rp <span id="total_buyback_formatted"></span><input type="hidden" name="total_buyback" id="total_buyback" value=""></div>
                </div>
            </div>

            {{-- <input type="hidden" name="pelanggan_nama" id="pelanggan_nama_di_dalam_form" value="{{ $surat_pembelian->pelanggan_id ? $surat_pembelian->pelanggan_nama : '' }}">
            <input type="hidden" name="pelanggan_username" id="pelanggan_username_di_dalam_form" value="{{ $surat_pembelian->pelanggan_id ? $surat_pembelian->pelanggan_username : '' }}">
            <input type="hidden" name="pelanggan_nik" id="pelanggan_nik_di_dalam_form" value="{{ $surat_pembelian->pelanggan_id ? $surat_pembelian->pelanggan_nik : '' }}"> --}}

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

            {{-- <h5 class="font-bold text-lg text-slate-500 my-3">Histori Pembayaran</h5>
            <table class="table-slim w-full">
                @foreach ($surat_pembelian->cashflows as $cashflow)
                <tr><td>{{ $cashflow->kategori_wallet }}</td><td>{{ $cashflow->tipe_wallet }}</td><td>{{ $cashflow->nama_wallet }}</td><td>{{ my_decimal_format($cashflow->jumlah) }}</td></tr>
                @endforeach
            </table> --}}

            <div class="flex justify-end mt-5">
                {{-- <div class="">
                    @if ((float)$surat_pembelian->sisa_bayar < 0)
                    <span id="label-sisa-bayar" class="font-bold text-orange-500">Kembali</span>
                    <div class="font-bold text-lg"><span>Rp </span><span id="sisa-bayar">{{ my_decimal_format((float)$surat_pembelian->sisa_bayar * -1) }}</span></div>
                    @else
                    <span id="label-sisa-bayar" class="font-bold text-orange-500">Sisa Bayar</span>
                    <div class="font-bold text-lg"><span>Rp </span><span id="sisa-bayar">{{ my_decimal_format((float)$surat_pembelian->sisa_bayar ) }}</span></div>
                    @endif
                </div> --}}
                {{-- <div class="ml-2">
                    <span class="font-bold text-emerald-500">Total Bayar</span>
                    <div class="font-bold text-lg"><span>Rp </span><span id="total-bayar">{{ my_decimal_format((float)$surat_pembelian->total_bayar ) }}</span></div>
                </div> --}}
            </div>
            {{-- <input type="hidden" id="ipt-total-bayar" name="total_bayar" value="{{ (string)((float)$surat_pembelian->total_bayar / 100) }}" readonly>
            <input type="hidden" id="ipt-sisa-bayar" name="sisa_bayar" value="{{ (string)((float)$surat_pembelian->sisa_bayar / 100) }}" readonly> --}}

            {{-- END PEMBAYARAN --}}
            {{-- <div class="relative flex justify-center mt-9 z-10">
                <button type="submit" class="rounded-lg px-3 py-2 bg-emerald-400 text-white border-2 border-emerald-500 font-bold">PROSES PEMBAYARAN</button>
            </div> --}}
        </div>

        <div class="flex justify-center mt-3">
            <button type="submit" class="bg-emerald-300 text-white font-bold p-2 rounded-lg border-2 border-emerald-400">Konfirmasi Buyback</button>
        </div>
        <div class="flex justify-center mt-3">
            <a href="{{ route('surat_pembelian.show', $surat_pembelian->id) }}" class="flex gap-1 justify-center items-center bg-red-200 text-red-500 font-bold rounded-lg px-3 py-2 border-2 border-red-300">
                <span>Kembali</span>
            </a>
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

<script>
    const surat_pembelian = {!! json_encode($surat_pembelian, JSON_HEX_TAG) !!}
    const surat_pembelian_items = {!! json_encode($surat_pembelian->items, JSON_HEX_TAG) !!}
    // console.log(surat_pembelian_items);

    // let i = 0;
    // surat_pembelian_items.forEach(surat_pembelian_item => {
    //     hitungHargaBuyback(i);
    //     i++;
    // });

    function hitungHargaBuyback(index) {
        // console.log(index);
        let potongan_ongkos = document.getElementById(`potongan_ongkos-${index}`).value;
        if (potongan_ongkos) {
            if (isNaN(potongan_ongkos)) {
                potongan_ongkos = 0;
            } else {
                potongan_ongkos = parseFloat(potongan_ongkos);
            }
        } else {
            potongan_ongkos = 0;
        }
        let potongan_mata = document.getElementById(`potongan_mata-${index}`).value;
        if (potongan_mata) {
            if (isNaN(potongan_mata)) {
                potongan_mata = 0;
            } else {
                potongan_mata = parseFloat(potongan_mata);
            }
        } else {
            potongan_mata = 0;
        }
        let potongan_rusak = document.getElementById(`potongan_rusak-${index}`).value;
        if (potongan_rusak) {
            if (isNaN(potongan_rusak)) {
                potongan_rusak = 0;
            } else {
                potongan_rusak = parseFloat(potongan_rusak);
            }
        } else {
            potongan_rusak = 0;
        }
        let potongan_susut = document.getElementById(`potongan_susut-${index}`).value;
        if (potongan_susut) {
            if (isNaN(potongan_susut)) {
                potongan_susut = 0;
            } else {
                potongan_susut = parseFloat(potongan_susut);
            }
        } else {
            potongan_susut = 0;
        }
        let potongan_lain = document.getElementById(`potongan_lain-${index}`).value;
        if (potongan_lain) {
            if (isNaN) {
                potongan_lain = 0;
            } else {
                potongan_lain = parseFloat(potongan_lain);
            }
        } else {
            potongan_lain = 0;
        }
        let total_potongan = potongan_ongkos + potongan_mata + potongan_rusak + potongan_susut + potongan_lain;
        let harga_t = parseFloat(document.getElementById(`harga_t-${index}`).value);
        let harga_buyback = harga_t - total_potongan;
        document.getElementById(`harga_buyback_formatted-${index}`).textContent = formatNumberX(preformatDotToComa(pangkasDesimal(harga_buyback)));
        document.getElementById(`harga_buyback-${index}`).value = pangkasDesimal(harga_buyback);
        hitungTotalBuyback();
    }

    function hitungTotalBuyback() {
        const checkbox_toggle_buyback = document.querySelectorAll('.checkbox-toggle-buyback');
        // console.log(checkbox_toggle_buyback);
        let total_buyback = 0;
        checkbox_toggle_buyback.forEach((value, index) => {
            if (value.checked) {
                total_buyback += parseFloat(document.getElementById(`harga_buyback-${index}`).value)
            }
        });
        document.getElementById('total_buyback_formatted').textContent = formatNumberX(preformatDotToComa(pangkasDesimal(total_buyback)));
        document.getElementById('total_buyback').value = pangkasDesimal(total_buyback);
    }

    function toggleBuyback(index, buyback_toggle) {
        // console.log(index);
        // console.log(buyback);
        $buyback_form = $(`#buyback_form-${index}`);
        if (buyback_toggle.checked) {
            $buyback_form.show(300);
            // buyback_toggle.value = surat_pembelian_items[index].id;
            // buyback.value = surat_pembelian_items[index].id;
            hitungHargaBuyback(index);
        } else {
            // buyback_toggle.value = null;
            $buyback_form.hide(300);
            // buyback.value = "";
            cancelHargaBuyback(index);
        }
    }

    function cancelHargaBuyback(index) {
        document.getElementById(`harga_buyback_formatted-${index}`).textContent = "-";
        document.getElementById(`harga_buyback-${index}`).value = 0;
        hitungTotalBuyback();
    }
</script>
@endsection

