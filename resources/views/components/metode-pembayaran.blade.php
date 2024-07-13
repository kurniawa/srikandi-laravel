<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
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
                @foreach ($walletsnontunai as $wallet)
                    <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100"
                        onclick="tambahPembayaran('{{ $wallet->tipe }}', '{{ $wallet->nama }}')"
                        id="{{ $wallet->nama }}"><img
                            src="{{ asset("img/logo-$wallet->tipe-$wallet->nama.png") }}" class="h-full"></div>
                @endforeach
                
                <div class="flex items-center h-11 border-b py-2 pl-2 hover:bg-slate-100" onclick="tambahPembayaran('lain-lain','lain-lain')"><span class="font-bold text-base ml-2">Lain - lain</span></div>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <div class="">
            <span id="label-sisa-bayar" class="font-bold text-orange-500">Sisa Bayar</span>
            <div class="font-bold text-lg"><span>Rp </span><span id="sisa_bayar_formatted"></span>
            </div>
        </div>
        <div class="ml-2">
            <span class="font-bold text-emerald-500">Total Bayar</span>
            <div class="font-bold text-lg"><span>Rp </span><span id="total_bayar_formatted">0</span></div>
        </div>
    </div>
    <input type="hidden" id="total_bayar_real" name="total_bayar" value="0" readonly>
    <input type="hidden" id="sisa_bayar_real" name="sisa_bayar" readonly>
    
    <script src="{{ asset('js/methode_pembayaran.js') }}"></script>
</div>
