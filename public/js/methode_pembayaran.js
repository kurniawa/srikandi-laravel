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
            <input type="text" inputmode="numeric" class="input ml-1" onchange="formatNumber(this, 'jumlah-non-tunai-${nama_instansi}'); hitungTotalBayar()">
            <input type="hidden" name="jumlah_non_tunai[]" id="jumlah-non-tunai-${nama_instansi}" class="jumlah-bayar">
            <input type="hidden" name="tipe_instansi[]" value="${tipe}" readonly>
        </div>
        `;
    } else {
        html_input += `
        <div class="ml-5 flex mt-1">
            <input type="text" name="nama_instansi[]" value="${nama_instansi}" class="input bg-slate-100 w-1/4" readonly>
            <input type="text" inputmode="numeric" class="input ml-1" onchange="formatNumber(this, 'jumlah-non-tunai-${nama_instansi}'); hitungTotalBayar()">
            <input type="hidden" name="jumlah_non_tunai[]" id="jumlah-non-tunai-${nama_instansi}" class="jumlah-bayar">
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

function hitungTotalBayar() {
    let arr_jumlah_bayar = document.querySelectorAll(".jumlah-bayar");
    let total_bayar = 0;
    arr_jumlah_bayar.forEach((jumlah_bayar) => {
        // console.log(jumlah_bayar.value);
        if (jumlah_bayar.value !== "") {
            total_bayar = total_bayar + parseFloat(jumlah_bayar.value);
        }
    });
    // console.log(total_bayar);
    let total_tagihan = 0;

    const kategori = document.getElementById("kategori").value;
    if (kategori == "Buyback Perhiasan") {
        total_tagihan = document.getElementById("harga_terima").value;
    } else if (kategori == "Penjualan Perhiasan") {
        total_tagihan = document.getElementById("harga_total_real").value;
    } else {
        total_tagihan = document.getElementById("total_tagihan_real").value;
    }
    // console.log("methode_pembayaran");
    // console.log(kategori);
    let sisa_bayar_real_value = parseFloat(total_tagihan) - total_bayar;
    let sisa_bayar = sisa_bayar_real_value;
    if (sisa_bayar_real_value < 0) {
        document.getElementById("label-sisa-bayar").textContent = "KEMBALI";
        sisa_bayar = -sisa_bayar_real_value;
    } else {
        document.getElementById("label-sisa-bayar").textContent = "Sisa Bayar";
    }

    // console.log(total_tagihan);
    // console.log(total_tagihan / 100);
    // console.log(parseFloat(total_tagihan / 100));
    // console.log(total_bayar);
    // console.log(sisa_bayar);

    // console.log('pangkasDesimal')
    // console.log(pangkasDesimal(sisa_bayar));

    document.getElementById("total_bayar_formatted").textContent =
        formatNumberX(preformatDotToComa(pangkasDesimal(total_bayar)));
    document.getElementById("sisa_bayar_formatted").textContent = formatNumberX(
        preformatDotToComa(pangkasDesimal(sisa_bayar))
    );
    document.getElementById("total_bayar_real").value =
        pangkasDesimal(total_bayar).toString();
    document.getElementById("sisa_bayar_real").value = pangkasDesimal(
        sisa_bayar_real_value
    ).toString();
}
