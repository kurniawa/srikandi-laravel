function toggleEWallet() {
    $("#dd-daftar-ewallet").toggle(300);
}

function hideEWallet() {
    $("#dd-daftar-ewallet").hide(300);
}

var div_input_non_tunai = document.getElementById(
    "daftar-input-pembayaran-non-tunai"
);
function tambahPembayaran(tipe, nama_instansi) {
    var html_input = "";
    if (tipe === "lain-lain") {
        html_input += `
        <div class="ml-5 flex mt-1">
            <input type="text" name="nama_instansi[]" placeholder="nama..." class="input w-1/4">
            <input type="text" class="input ml-1" onchange="formatNumber(this, 'jumlah-non-tunai-${nama_instansi}'); hitungTotalBayar()">
            <input type="hidden" name="jumlah[]" id="jumlah-non-tunai-${nama_instansi}" class="jumlah-bayar">
            <input type="hidden" name="tipe_instansi[]" value="${tipe}" readonly>
        </div>
        `;
    } else {
        html_input += `
        <div class="ml-5 flex mt-1">
            <input type="text" name="nama_instansi[]" value="${nama_instansi}" class="input bg-slate-100 w-1/4" readonly>
            <input type="text" class="input ml-1" onchange="formatNumber(this, 'jumlah-non-tunai-${nama_instansi}'); hitungTotalBayar()">
            <input type="hidden" name="jumlah[]" id="jumlah-non-tunai-${nama_instansi}" class="jumlah-bayar">
            <input type="hidden" name="tipe_instansi[]" value="${tipe}" readonly>
        </div>
        `;
        document.getElementById(nama_instansi).remove();
    }
    div_input_non_tunai.insertAdjacentHTML("beforeend", html_input);
    hideEWallet();
}

function toggleTunai(checkbox_tunai) {
    $ipt_tunai = $("#jumlah_tunai");
    if (checkbox_tunai.checked) {
        $ipt_tunai.show(300);
        // document.getElementById('instansi_tunai').disabled = false;
        // document.getElementById('tipe_tunai').disabled = false;
    } else {
        $ipt_tunai.hide(300);
    }
}

function toggleNonTunai(checkbox_non_tunai) {
    $div_non_tunai = $("#div-non-tunai");
    if (checkbox_non_tunai.checked) {
        $div_non_tunai.show(300);
    } else {
        $div_non_tunai.hide(300);
    }
}
