@extends('layouts.main')
@section('content')
    <main class="p-2">
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        <div class="mt-1">
            <form action="{{ route($route1) }}" method="POST">
                <div class="border-2 border-emerald-300 p-2 bg-white rounded shadow drop-shadow">
                    <div>
                        <div class="text-slate-400">
                            <div class="font-bold text-xs">S: {{ $candidate_new_item['shortname'] }}</div>
                            <div class="font-bold text-xs">L: {{ $candidate_new_item['longname'] }}</div>
                        </div>
                        <table class="font-bold text-slate-500 text-xs">
                            <tr><td>Harga/g</td><td>:</td><td><span>Rp {{ my_decimal_format($candidate_new_item['harga_g']) }}</span></td></tr>
                            <tr><td>Ongkos/g</td><td>:</td><td><span>Rp {{ my_decimal_format($candidate_new_item['ongkos_g']) }}</span></td></tr>
                            <tr><td>Harga T.</td><td>:</td><td><span>Rp {{ my_decimal_format($candidate_new_item['harga_t']) }}</span></td></tr>
                        </table>
                    </div>
                    {{-- <div class="text-slate-500">By: {{ $candidate_new_item['']user->username }}</div> --}}
                </div>
                @csrf
                @if (isset($tipe_transaksi))
                    <input type="hidden" name="tipe_transaksi" value="{{ $tipe_transaksi }}">
                @endif
                <input type="hidden" name="tipe_barang" value="{{ $candidate_new_item['tipe_barang'] }}">
                <input type="hidden" name="tipe_perhiasan" value="{{ $candidate_new_item['tipe_perhiasan'] }}">
                <input type="hidden" name="jenis_perhiasan" value="{{ $candidate_new_item['jenis_perhiasan'] }}">
                <input type="hidden" name="warna_emas" value="{{ $candidate_new_item['warna_emas'] }}">
                <input type="hidden" name="deskripsi" value="{{ $candidate_new_item['deskripsi'] }}">
                <input type="hidden" name="kadar" value="{{ (float)$candidate_new_item['kadar'] / 100 }}">
                <input type="hidden" name="berat" value="{{ (float)$candidate_new_item['berat'] / 100 }}">
                <input type="hidden" name="harga_g" value="{{ (float)$candidate_new_item['harga_g'] / 100 }}">
                <input type="hidden" name="ongkos_g" value="{{ (float)$candidate_new_item['ongkos_g'] / 100 }}">
                <input type="hidden" name="harga_t" value="{{ (float)$candidate_new_item['harga_t'] / 100 }}">
                <input type="hidden" name="shortname" value="{{ $candidate_new_item['shortname'] }}">
                <input type="hidden" name="longname" value="{{ "$candidate_new_item[longname] " . "v" . count($similar_items) + 1 }}">
                <input type="hidden" name="kondisi" value="{{ $candidate_new_item['kondisi'] }}">
                <input type="hidden" name="cap" value="{{ $candidate_new_item['cap'] }}">
                <input type="hidden" name="range_usia" value="{{ $candidate_new_item['range_usia'] }}">
                <input type="hidden" name="ukuran" value="{{ $candidate_new_item['ukuran'] }}">
                <input type="hidden" name="merk" value="{{ $candidate_new_item['merk'] }}">
                <input type="hidden" name="plat" value="{{ $candidate_new_item['plat'] }}">
                <input type="hidden" name="keterangan" value="{{ $candidate_new_item['keterangan'] }}">
                {{-- <input type="hidden" name="stock" value="{{ $candidate_new_item['stock'] }}"> --}}

                {{-- DATA METODE PEMBAYARAN --}}
                @if ($buyback_mode)
                    @if (isset($jumlah_tunai))
                        <input type="hidden" name="jumlah_tunai" value="{{ $jumlah_tunai }}">
                    @endif

                    @if (isset($jumlah_non_tunai))
                        @for ($i = 0; $i < count($jumlah_non_tunai); $i++)
                            <input type="hidden" name="jumlah_non_tunai[]" value="{{ $jumlah_non_tunai[$i] }}">
                            <input type="hidden" name="nama_instansi[]" value="{{ $nama_instansi[$i] }}">
                            <input type="hidden" name="tipe_instansi[]" value="{{ $tipe_instansi[$i] }}">
                        @endfor
                    @endif

                    <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">
                    <input type="hidden" name="sisa_bayar" value="{{ $sisa_bayar }}">
                @endif
                {{-- END - DATA METODE PEMBAYARAN --}}

                <div class="text-center mt-5">
                    @if ($buyback_mode)
                        @if ($buyback_mode == 'yes')
                            <input type="hidden" name="kategori" value="Buyback Perhiasan">
                            @if (isset($keterangan_transaksi))
                            <input type="hidden" name="keterangan_transaksi" value="{{ $keterangan_transaksi }}">
                            @else
                            <input type="hidden" name="keterangan_transaksi" value="">
                            @endif
                            <button type="submit" name="tetap_buyback" value="yes" class="bg-emerald-300 p-4 text-white font-bold rounded">Tetap Buyback dengan Data diatas</button>
                        @endif
                    @else
                        <button type="submit" class="bg-emerald-300 p-4 text-white font-bold rounded">Tetap Tambah Baru dengan Data diatas</button>
                    @endif
                </div>
            </form>
        </div>
        <div class="mt-5 flex">
            <div class="shadow drop-shadow p-2 rounded">
                Pilihan Item Yang Sama:
            </div>
        </div>
        <div>
            @foreach ($similar_items as $key => $item)
                <div class="flex mt-3">
                    <div class="bg-white shadow drop-shadow size-6 font-bold text-slate-400 flex justify-center items-center">
                        <span>{{ $key+1 }}.</span>
                    </div>
                </div>
                <form action="{{ route($route2, $item['id']) }}" method="GET" class="mt-2">
                    <div class="border-2 border-pink-300 p-2 bg-white rounded shadow drop-shadow">
                        <div class="text-slate-400">
                            <div class="font-bold text-xs">S: {{ $item['shortname'] }}</div>
                            <div class="font-bold text-xs">L: {{ $item['longname'] }}</div>
                        </div>

                        <div class="grid grid-cols-12 gap-2 items-center">
                            <div class="col-span-4">
                                @if ($item['photo_path'])
                                    <img src="{{ asset('storage/' . $item['photo_path']) }}" alt="item_photo" class="w-full">
                                @else
                                    <div class="bg-indigo-100 text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-full">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="col-span-4">
                                <div class="border-2 p-2 rounded border-indigo-300">
                                    <div class="font-bold mb-2 text-slate-500">Harga 1:</div>
                                    <div class="font-bold text-slate-600 text-xs">{{ my_decimal_format($item['harga_g']) }} /g</div>
                                    <div class="font-bold text-slate-600 text-xs">{{ my_decimal_format($item['ongkos_g']) }} /g</div>
                                    <div class="font-bold text-slate-600 text-xs">{{ my_decimal_format($item['harga_t']) }}</div>
                                </div>
                            </div>

                            <div class="col-span-4">
                                <div class="border-2 p-2 rounded border-orange-300">
                                    <div class="font-bold mb-2 text-slate-500">Harga 2:</div>
                                    <div class="font-bold text-slate-600 text-xs">{{ my_decimal_format($candidate_new_item['harga_g']) }} /g</div>
                                    <div class="font-bold text-slate-600 text-xs">{{ my_decimal_format($candidate_new_item['ongkos_g']) }} /g</div>
                                    <div class="font-bold text-slate-600 text-xs">{{ my_decimal_format($candidate_new_item['harga_t']) }}</div>
                                    <input type="hidden" name="harga_g" value="{{ (float)$candidate_new_item['harga_g'] / 100 }}">
                                    <input type="hidden" name="ongkos_g" value="{{ (float)$candidate_new_item['ongkos_g'] / 100 }}">
                                    <input type="hidden" name="harga_t" value="{{ (float)$candidate_new_item['harga_t'] / 100 }}">
                                    <input type="hidden" name="buyback_mode" value="yes">
                                </div>
                            </div>
                        </div>

                        {{-- DATA METODE PEMBAYARAN --}}
                        @if ($buyback_mode)
                            @if (isset($jumlah_tunai))
                                <input type="hidden" name="jumlah_tunai" value="{{ $jumlah_tunai }}">
                            @endif

                            @if (isset($jumlah_non_tunai))
                                @for ($i = 0; $i < count($jumlah_non_tunai); $i++)
                                    <input type="hidden" name="jumlah_non_tunai[]" value="{{ $jumlah_non_tunai[$i] }}">
                                    <input type="hidden" name="nama_instansi[]" value="{{ $nama_instansi[$i] }}">
                                    <input type="hidden" name="tipe_instansi[]" value="{{ $tipe_instansi[$i] }}">
                                @endfor
                            @endif

                            <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">
                            <input type="hidden" name="sisa_bayar" value="{{ $sisa_bayar }}">
                        @endif
                        {{-- END - DATA METODE PEMBAYARAN --}}

                        @if ($buyback_mode)
                            <div class="flex justify-end gap-2 mt-2">
                                {{-- <button type="submit" name="submit" class="bg-pink-300 text-white py-2 px-5 rounded" value="pilih_dan_update_harga">Pilih & Update Harga</button> --}}
                                <input type="hidden" name="tipe_transaksi" value="{{ $tipe_transaksi }}">
                                @if (isset($keterangan_transaksi))
                                <input type="hidden" name="keterangan_transaksi" value="{{ $keterangan_transaksi }}">
                                @else
                                <input type="hidden" name="keterangan_transaksi" value="">
                                @endif
                                <input type="hidden" name="kategori" value="{{ $kategori }}">
                                <button type="submit" name="submit" class="bg-orange-400 text-white py-2 px-5 rounded" value="pilih">Pilih</button>
                            </div>
                        @else
                            <div class="flex justify-center mt-2">
                                <div>
                                    <div class="text-center">
                                        <button type="submit" name="submit" class="bg-pink-300 text-white py-2 px-5 rounded" value="add_to_cart_and_price_update">+ Keranjang & Update Harga</button>
                                    </div>
                                    <div class="text-center mt-2">
                                        <button type="submit" name="submit" class="bg-emerald-300 text-white py-2 px-5 rounded" value="add_to_cart">+ Keranjang</button>
                                    </div>
                                    <div class="text-center mt-2">
                                        <button type="submit" name="submit" class="bg-yellow-300 text-slate-500 py-2 px-5 rounded" value="add_to_cart">Lihat Detail</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="text-slate-500">By: {{ $item['user']->username }}</div> --}}

                    </div>
                </form>
            @endforeach
        </div>
        {{-- <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button> --}}
    </main>
@endsection
