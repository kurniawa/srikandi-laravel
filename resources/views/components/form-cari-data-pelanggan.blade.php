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
            <td><input type="text" inputmode="numeric" name="pelanggan_nik" id="pelanggan_nik" value="{{ $pelanggannik }}" class="border-0 p-0" readonly></td>
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
            <td><input type="text" inputmode="numeric" name="pelanggan_nik" id="pelanggan_nik" class="border rounded p-1 bg-slate-100" readonly></td>
        </tr>
    </table>
    @endif
    <div>
        <button type="button" id="btn-ganti" class="border-2 rounded px-2 py-1 text-slate-500 font-bold" onclick="toggle_light(this.id, 'form-cari-data-pelanggan', ['text-slate-500'], ['text-white', 'bg-slate-400'], 'block'); ">ganti</button>
    </div>
</div>

@if ($route)
<form action="{{ route($route, $params) }}" method="POST" onsubmit="return cariDataPelanggan()" id="form-cari-data-pelanggan" class="mt-3 hidden">
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
            <td><input type="text" inputmode="numeric" name="pelanggan_nik" id="cari_nik_pelanggan" class="border rounded p-1"></td>
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
@else
<div id="form-cari-data-pelanggan" class="mt-3 hidden">
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
            <td><input type="text" inputmode="numeric" name="pelanggan_nik" id="cari_nik_pelanggan" class="border rounded p-1"></td>
        </tr>
        <tr>
            <td colspan="3"><div id="feedback_cari_pelanggan" class="text-xs text-red-500"></div></td>
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
@endif
