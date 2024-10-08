@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex">
        <div class="bg-white shadow drop-shadow p-2 rounded">
            <h3 class="text-xl font-bold text-slate-500">Edit Harga Pasaran</h3>
        </div>
    </div>

    <form action="{{ route('attributes.harga_pasaran.update', $harga_pasaran) }}" method="POST" class="mt-5 border rounded p-2 text-slate-500">
        @csrf
        <div class="flex gap-1 mt-5 items-center">
            <h3 class="font-bold text-slate-500">Tanggal</h3>
            <span class="text-slate-500 text-xs italic">(dd-mm-yyyy)</span>
        </div>
        <div class="flex gap-1 items-center mt-2 bg-slate-300 p-1">
            <select name="hari" id="hari" class="border py-1 rounded">
                @if (old('hari'))
                    @for ($i = 1; $i < 32; $i++)
                        <option value="{{ $i }}" {{ old('hari') == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                @else
                    @for ($i = 1; $i < 32; $i++)
                        @if ($i == date('d', strtotime($harga_pasaran->created_at)))
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
            <select name="bulan" id="bulan" class="border py-1 rounded">
                @if (old('bulan'))
                    @for ($i = 1; $i < 13; $i++)
                        <option value="{{ $i }}" {{ old('bulan') == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                @else
                    @for ($i = 1; $i < 13; $i++)
                        @if ($i == date('m', strtotime($harga_pasaran->created_at)))
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
            <input type="text" inputmode="numeric" name="tahun" class="border rounded p-1 w-1/3"
                value="{{ old('tahun') ? old('tahun') : date('Y', strtotime($harga_pasaran->created_at)) }}">
            {{-- kalau nanti ada fungsi pengubahan tanggal surat, maka ini boleh dihapus --}}
            {{-- <input type="hidden" name="hari" value="{{ date('d') }}" readonly>
            <input type="hidden" name="bulan" value="{{ date('m') }}" readonly> --}}
            {{-- select tidak bisa readonly, oleh karena itu tertulis disable, sedangkan disable artinya tidak terbaca oleh post() --}}
        </div>

        <div class="grid grid-cols-12 gap-1 text-xs font-bold mt-3">
            <div class="col-span-2 flex justify-center"><span>kategori</span></div>
            <div class="col-span-5 flex justify-center"><span>harga beli</span></div>
            <div class="col-span-5 flex justify-center"><span>harga buyback</span></div>
                @if ($harga_pasaran->kategori == 'CT')
                <div class="col-span-2 flex items-center justify-center"><span>{{ $harga_pasaran->kategori }}(99)</span></div>
                @else
                <div class="col-span-2 flex items-center justify-center"><span>{{ $harga_pasaran->kategori }}</span></div>
                @endif

                @if ($harga_pasaran->kategori == 'CT')
                <div class="col-span-5">
                    <input type="text" inputmode="numeric" name="harga_beli-formatted" value="{{ casual_decimal_format($harga_pasaran->harga_beli) }}" class="w-full rounded" onchange="formatNumber(this, 'harga_beli-{{ $harga_pasaran->kategori }}'); generateHargaPasaran()">
                    <input type="hidden" name="harga_beli" value="{{ $harga_pasaran->harga_beli / 100 }}" id="harga_beli-{{ $harga_pasaran->kategori }}">
                </div>
                @else
                <div class="col-span-5">
                    <input type="text" inputmode="numeric" name="harga_beli-formatted" value="{{ casual_decimal_format($harga_pasaran->harga_beli) }}" id="harga_beli-{{ $harga_pasaran->kategori }}-formatted" class="w-full rounded" onchange="formatNumber(this, 'harga_beli-{{ $harga_pasaran->kategori }}')">
                    <input type="hidden" name="harga_beli" value="{{ $harga_pasaran->harga_beli / 100 }}" id="harga_beli-{{ $harga_pasaran->kategori }}">
                </div>
                @endif

                <div class="col-span-5">
                    <input type="text" inputmode="numeric" name="harga_buyback-formatted" value="{{ casual_decimal_format($harga_pasaran->harga_buyback) }}" id="harga_buyback-{{ $harga_pasaran->kategori }}-formatted" class="w-full rounded" onchange="formatNumber(this, 'harga_buyback-{{ $harga_pasaran->kategori }}')">
                    <input type="hidden" name="harga_buyback" value="{{ $harga_pasaran->harga_buyback / 100 }}" id="harga_buyback-{{ $harga_pasaran->kategori }}">
                </div>

                <input type="hidden" name="kategori" id="kategori-{{ $harga_pasaran->kategori }}" value="{{ $harga_pasaran->kategori }}">
                <input type="hidden" name="kadar" id="kadar-{{ $harga_pasaran->kadar }}" value="{{ $harga_pasaran->kadar }}">
        </div>
        <div class="border-2 border-yellow-300 rounded-lg p-2 text-xs mt-2">
            <p>Harga merupakan harga per gram dari berat bersih, tanpa mata atau pernak-pernik lainnya.</p>
        </div>
        <div class="mt-3 flex justify-center">
            <button type="submit" class="p-2 rounded-lg bg-emerald-300 text-white font-bold">Konfirmasi</button>
        </div>
    </form>
</main>

<script>
    
</script>
@endsection

