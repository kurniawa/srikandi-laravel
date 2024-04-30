

function formatDecimal(params) {
    let str_params = params.toString();
    let splitted_params = str_params.split(".");
    // console.log(splitted_params);
    if (splitted_params.length === 2) {
        // console.log('desimal');
        params = parseFloat(params.toFixed(2));
    }
    // console.log(params);
    return params;
}

function generateNama() {
    let tipe_perhiasan = document.getElementById('tipe_perhiasan').value;
    let jenis_perhiasan = document.getElementById('jenis_perhiasan').value;
    let warna_emas = document.getElementById('warna_emas').value;
    if (warna_emas === 'kuning') {
        warna_emas = ''
    } else {
        warna_emas = ` <${warna_emas}>`;
    }
    let kadar = document.getElementById('kadar').value;
    let berat = document.getElementById('berat').value;
    let kondisi = document.getElementById('kondisi').value;
    let cap = document.getElementById('cap').value;
    if (cap) {
        cap = ` c:${cap}`;
    }
    let range_usia = document.getElementById('range_usia').value;
    if (range_usia) {
        range_usia = ` ru:${range_usia}`;
    }
    let ukuran = document.getElementById('ukuran').value;
    if (ukuran) {
        ukuran = ` uk:${ukuran}`
    }
    let merk = document.getElementById('merk').value;
    if (merk) {
        merk = `merk:${merk}`
    }
    let plat = document.getElementById('plat').value;
    if (plat) {
        plat = ` plat:${plat}`;
    }

    let nama_short = `${tipe_perhiasan} ${jenis_perhiasan}${warna_emas} ${kadar}% ${berat}gr`;
    let nama_long = `${tipe_perhiasan} ${jenis_perhiasan}${warna_emas} ${kadar}% ${berat}gr zu:${kondisi}${cap}${ukuran}${range_usia}${merk}${plat}`;
    // nama_long = nama_long.split("  ").join(" ");
    document.getElementById('nama_short').value = nama_short;
    document.getElementById('nama_long').value = nama_long;
}
