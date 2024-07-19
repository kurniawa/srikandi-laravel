@extends('layouts.main')
@section('content')
<main class="p-2">
    <x-errors-any></x-errors-any>
    <x-validation-feedback></x-validation-feedback>

    <div class="flex">
        <div class="bg-white shadow drop-shadow p-2 rounded">
            <h3 class="text-xl font-bold text-slate-500">+Tambah Harga Pasaran</h3>
        </div>
    </div>

    <form action="{{ route('attributes.harga_pasaran.store') }}" method="POST" class="mt-5 border rounded p-2 text-slate-500">
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
            <select name="bulan" id="bulan" class="border py-1 rounded">
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
                value="{{ old('tahun') ? old('tahun') : date('Y') }}">
            {{-- kalau nanti ada fungsi pengubahan tanggal surat, maka ini boleh dihapus --}}
            {{-- <input type="hidden" name="hari" value="{{ date('d') }}" readonly>
            <input type="hidden" name="bulan" value="{{ date('m') }}" readonly> --}}
            {{-- select tidak bisa readonly, oleh karena itu tertulis disable, sedangkan disable artinya tidak terbaca oleh post() --}}
        </div>

        <div class="grid grid-cols-12 gap-1 text-xs font-bold mt-3">
            <div class="col-span-2 flex justify-center"><span>kategori</span></div>
            <div class="col-span-5 flex justify-center"><span>harga beli</span></div>
            <div class="col-span-5 flex justify-center"><span>harga buyback</span></div>
            @foreach ($kategoris as $kategori)
                @if ($kategori == 'CT')
                <div class="col-span-2 flex items-center justify-center"><span>{{ $kategori }}(99)</span></div>
                @else
                <div class="col-span-2 flex items-center justify-center"><span>{{ $kategori }}</span></div>
                @endif

                @if ($kategori == 'CT')
                <div class="col-span-5">
                    <input type="text" name="harga_beli-formatted[]" class="w-full rounded" onchange="formatNumber(this, 'harga_beli-{{ $kategori }}'); generateHargaPasaran()">
                    <input type="hidden" name="harga_beli[]" id="harga_beli-{{ $kategori }}">
                </div>
                @else
                <div class="col-span-5">
                    <input type="text" name="harga_beli-formatted[]" id="harga_beli-{{ $kategori }}-formatted" class="w-full rounded" onchange="formatNumber(this, 'harga_beli-{{ $kategori }}')">
                    <input type="hidden" name="harga_beli[]" id="harga_beli-{{ $kategori }}">
                </div>
                @endif

                <div class="col-span-5">
                    <input type="text" name="harga_buyback-formatted[]" id="harga_buyback-{{ $kategori }}-formatted" class="w-full rounded" onchange="formatNumber(this, 'harga_buyback-{{ $kategori }}')">
                    <input type="hidden" name="harga_buyback[]" id="harga_buyback-{{ $kategori }}">
                </div>

                <input type="hidden" name="kategori[]" value="{{ $kategori }}">
            @endforeach
        </div>
        <div class="mt-3 flex justify-center">
            <button type="submit" class="p-2 rounded-lg bg-emerald-300 text-white font-bold">Konfirmasi</button>
        </div>
    </form>
</main>

<script>
    const kategoris = {!! json_encode($kategoris, JSON_HEX_TAG) !!};

    function generateHargaPasaran() {
        const harga_ct = document.getElementById('harga_beli-CT').value;
        // console.log(harga_ct);
        kategoris.forEach(kategori => {
            if (kategori !== 'LM' && kategori !== 'CT') {
                // console.log(kategori);
                const harga_buyback_this = parseFloat(harga_ct) * ((parseFloat(kategori) / 100 - 10) / 100);
                const harga_beli_this = parseFloat(harga_ct) * ((parseFloat(kategori) / 100 + 10) / 100) + 100000;
                // console.log(harga_buyback_this);
                document.getElementById(`harga_buyback-${kategori}`).value = harga_buyback_this;
                // console.log(document.getElementById(`harga_buyback-${kategori}-formatted`));
                document.getElementById(`harga_buyback-${kategori}-formatted`).value = formatNumberMurni(harga_buyback_this.toString());

                document.getElementById(`harga_beli-${kategori}`).value = harga_beli_this;
                document.getElementById(`harga_beli-${kategori}-formatted`).value = formatNumberMurni(harga_beli_this.toString());
            }

            if (kategori == 'CT') {
                const harga_buyback_this = parseFloat(harga_ct) * 0.966;
                document.getElementById(`harga_buyback-${kategori}`).value = harga_buyback_this;
                document.getElementById(`harga_buyback-${kategori}-formatted`).value = formatNumberMurni(harga_buyback_this.toString());
            }
        });
    }
</script>
@endsection

