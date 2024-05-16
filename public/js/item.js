
function pilihanJenisPerhiasan__(tipe_perhiasan, jenis_perhiasans) {
    // console.log(data_tipe_perhiasan);
    // console.log(JSON.parse(data_tipe_perhiasan));
    // var tipe_perhiasan = JSON.parse(data_tipe_perhiasan);

    var pilihan_jenis_perhiasans = jenis_perhiasans.filter((o) => o.tipe_perhiasan == tipe_perhiasan);
    console.log(pilihan_jenis_perhiasans);
    $('#jenis_perhiasan').autocomplete({
        source: pilihan_jenis_perhiasans,
        select: function (event, ui) {
            document.getElementById('jenis_perhiasan').value = ui.item.value;
            generateNama();
        }
    })
    document.getElementById('label_jenis_perhiasan').textContent = `jenis ${tipe_perhiasan}`;
}

function setAutocompleteWarnaMata(element_id, source) {
    // console.log('run autocomplete mata');
    $(`#${element_id}`).autocomplete({
        source: source,
    });
}

function addMata__(index_mata, warna_matas) {
    document.getElementById('data_mata').insertAdjacentHTML('beforeend',
    `<div id="data-mata-${index_mata}">
        <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
            <div class="mb-1">
                <input type="text" id="warna_mata-${index_mata}" name="warna_mata[]" placeholder="warna_mata" class="warna-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="mb-1">
                <select id="level_warna" name="level_warna[]" class="level-warna bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="netral">netral</option>
                    <option value="tua">tua</option>
                    <option value="muda">muda</option>
                </select>
            </div>
            <div class="mb-1">
                <select id="opacity" name="opacity[]" class="opacity-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="transparent">transparent</option>
                    <option value="non-transparent">non-transparent</option>
                    <option value="half-transparent">half-transparent</option>
                </select>
            </div>
            <div class="mb-1">
                <input type="text" id="jumlah_mata" name="jumlah_mata[]" placeholder="jumlah_mata" class="jumlah-mata bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <div class="flex justify-end mt-1">
            <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mata-${index_mata}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                </svg>
            </button>
        </div>
    </div>`
    );

    setAutocompleteWarnaMata(`warna_mata-${index_mata}`, warna_matas);
}

function setAutocompleteMainan(element_id, mainans) {
    $(`#${element_id}`).autocomplete({
        source: mainans,
    });
}

function addMainan__(index_mainan, mainans) {
    document.getElementById('data_mainan').insertAdjacentHTML('beforeend',
    `<div id="data-mainan-${index_mainan}" class="data-mainan">
        <div class="grid grid-cols-2 gap-2 mt-2 border-t border-b border-violet-300 p-1">
            <div class="mb-1">
                <input type="text" id="tipe_mainan-${index_mainan}" name="tipe_mainan[]" placeholder="tipe_mainan" class="tipe-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="mb-1">
                <input type="text" id="jumlah_mainan-${index_mainan}" name="jumlah_mainan[]" placeholder="jumlah_mainan" class="jumlah-mainan bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <div class="flex justify-end mt-1">
            <button type="button" class="bg-pink-300 text-white px-2 py-1 rounded-2xl" onclick="removeElement('data-mainan-${index_mainan}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                </svg>
            </button>
        </div>
    </div>`
    );

    setAutocompleteMainan(`tipe_mainan-${index_mainan}`, mainans);
}

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
    let nama_long = `${tipe_perhiasan} ${jenis_perhiasan}${warna_emas} ${kadar}% ${berat}gr${cap}${ukuran}${range_usia}${merk}${plat}`;
    // nama_long = nama_long.split("  ").join(" ");
    document.getElementById('nama_short').value = nama_short;
    document.getElementById('nama_long').value = nama_long;
}

function removeElement(id) {
    document.getElementById(id).remove();
}

function toggleCheckbox(checkbox, element_id) {
    // console.log(checkbox.checked)
    if (checkbox.checked) {
        $(`#${element_id}`).show(300)
    } else {
        $(`#${element_id}`).hide(300)

    }
}

function hitungHargaT() {
    let berat = parseFloat(document.getElementById('berat').value);
    let harga_g = parseFloat(document.getElementById('harga_g').value);
    // console.log(berat);
    // console.log(harga_g);
    if (!isNaN(berat) && !isNaN(harga_g)) {
        let harga_t = formatDecimal(berat * harga_g);
        let harga_t_formatted = document.getElementById('harga_t_formatted');
        harga_t_formatted.value = harga_t.toString().split('.').join(',');
        formatNumber2('harga_t_formatted', 'harga_t');
    }
}

function hitungHargaGr() {
    let berat = parseFloat(document.getElementById('berat').value);
    let harga_t = parseFloat(document.getElementById('harga_t').value);
    // console.log(berat);
    // console.log(harga_t);
    if (!isNaN(berat) && !isNaN(harga_t)) {
        let harga_g = formatDecimal(harga_t / berat);
        let harga_g_formatted = document.getElementById('harga_g_formatted');
        harga_g_formatted.value = harga_g.toString().split('.').join(',');
        // console.log(harga_g)
        formatNumber2('harga_g_formatted', 'harga_g');
    }
}

function hitungHargaGrOrT() {
    let berat = parseFloat(document.getElementById('berat').value);
    let harga_g = parseFloat(document.getElementById('harga_g').value);
    let harga_t = parseFloat(document.getElementById('harga_t').value);
    if (!isNaN(berat) && !isNaN(harga_g)) {
        let harga_t = formatDecimal(berat * harga_g);
        let harga_t_formatted = document.getElementById('harga_t_formatted');
        harga_t_formatted.value = harga_t.toString().split('.').join(',');
        formatNumber2('harga_t_formatted', 'harga_t');
    } else if (!isNaN(berat) && !isNaN(harga_t)) {
        let harga_g = formatDecimal(harga_t / berat);
        let harga_g_formatted = document.getElementById('harga_g_formatted');
        harga_g_formatted.value = harga_g.toString().split('.').join(',')
        formatNumber2('harga_g_formatted', 'harga_g');
    }

}

function previewImage(image_file, div_preview_photo, preview_photo, label_input_photo) {
    if (image_file) {
        // console.log(image_file)
        document.getElementById(preview_photo).src = URL.createObjectURL(image_file);
        $(`#${div_preview_photo}`).show();
        $(`#${label_input_photo}`).hide();
    }
}

function removeImage(input_image, div_preview_photo, preview_photo, label_input_photo) {
    document.getElementById(preview_photo).src = "";
    $(`#${div_preview_photo}`).hide(300);
    $(`#${label_input_photo}`).show(300);
    const input_image_element = document.getElementById(input_image);
    // console.log(input_image_element);
    // console.log(input_image_element.value);
    input_image_element.value = null;
    // console.log(input_image_element.value);
}
