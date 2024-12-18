function toggleMenu(menu_id, close_layer_id) {
    $(`#${menu_id}`).toggle(350);
    $(`#${close_layer_id}`).show();
}

function hideMenuCloseLayer(menu_id, close_layer_id) {
    // console.log("hideMenuCloseLayer");
    $(`#${menu_id}`).hide(350);
    $(`#${close_layer_id}`).hide();
}

function toggle_element(element_id) {
    // console.log($(`#${element_id}`));
    $(`#${element_id}`).toggle(300);
}

function toggle_light(
    btn_id,
    id,
    classes_to_remove,
    classes_to_add,
    display_ref
) {
    $(`#${id}`).toggle(300);
    setTimeout(() => {
        let display = $(`#${id}`).css("display");
        // console.log(display);
        let detail_button = document.getElementById(btn_id);
        if (display === display_ref) {
            classes_to_remove.forEach((element) => {
                detail_button.classList.remove(element);
            });
            classes_to_add.forEach((element) => {
                detail_button.classList.add(element);
            });
        } else {
            classes_to_remove.forEach((element) => {
                detail_button.classList.add(element);
            });
            classes_to_add.forEach((element) => {
                detail_button.classList.remove(element);
            });
        }
    }, 500);
}

function toggle_light_instant(
    // btn_id,
    class_id
    // classes_to_remove,
    // classes_to_add,
    // display_ref
) {
    $(`.${class_id}`).toggle();
    // setTimeout(() => {
    //     let display = $(`.${class_id}`).css("display");
    //     // console.log(display);
    //     let detail_button = document.getElementById(btn_id);
    //     if (display === display_ref) {
    //         classes_to_remove.forEach((element) => {
    //             detail_button.classList.remove(element);
    //         });
    //         classes_to_add.forEach((element) => {
    //             detail_button.classList.add(element);
    //         });
    //     } else {
    //         classes_to_remove.forEach((element) => {
    //             detail_button.classList.add(element);
    //         });
    //         classes_to_add.forEach((element) => {
    //             detail_button.classList.remove(element);
    //         });
    //     }
    // }, 100);
}

function set_time_range(timerange) {
    // console.log(timerange);
    let from_day, from_month, from_year;
    let to_day, to_month, to_year;
    if (timerange === "now") {
        const date = new Date();
        from_day = date.getDate();
        from_month = date.getMonth() + 1;
        from_year = date.getFullYear();
        to_day = from_day;
        to_month = from_month;
        to_year = from_year;
    } else if (timerange === "7d") {
        const to_date = new Date();
        const from_date = new Date(new Date().setDate(to_date.getDate() - 7));
        from_day = from_date.getDate();
        from_month = from_date.getMonth() + 1;
        from_year = from_date.getFullYear();
        to_day = to_date.getDate();
        to_month = to_date.getMonth() + 1;
        to_year = to_date.getFullYear();
    } else if (timerange === "30d") {
        const to_date = new Date();
        const from_date = new Date(new Date().setDate(to_date.getDate() - 30));
        from_day = from_date.getDate();
        from_month = from_date.getMonth() + 1;
        from_year = from_date.getFullYear();
        to_day = to_date.getDate();
        to_month = to_date.getMonth() + 1;
        to_year = to_date.getFullYear();
    } else if (timerange === "bulan_ini") {
        const date = new Date();
        from_day = 1;
        from_month = date.getMonth() + 1;
        from_year = date.getFullYear();
        to_day = date.getDate();
        to_month = date.getMonth() + 1;
        to_year = date.getFullYear();
    } else if (timerange === "bulan_lalu") {
        const date = new Date();
        from_day = 1;
        from_month = date.getMonth();
        from_year = date.getFullYear();
        to_month = date.getMonth();
        to_year = date.getFullYear();
        to_day = new Date(to_year, to_month, 0).getDate();
        if (from_month === 0) {
            from_month = 12;
            from_year--;
        }
        // console.log(from_month, to_month);
    } else if (timerange === "tahun_ini") {
        const date = new Date();
        from_day = 1;
        from_month = 1;
        from_year = date.getFullYear();
        to_day = date.getDate();
        to_month = date.getMonth() + 1;
        to_year = date.getFullYear();
    } else if (timerange === "tahun_lalu") {
        const date = new Date();
        from_day = 1;
        from_month = 1;
        from_year = date.getFullYear() - 1;
        to_day = 31;
        to_month = 12;
        to_year = from_year;
    } else if (timerange === "triwulan") {
        const date = new Date();
        const actual_month = date.getMonth() + 1;
        from_day = 1;
        from_year = date.getFullYear();
        to_year = from_year;
        if (actual_month <= 3) {
            from_month = 1;
            to_month = 3;
        } else if (actual_month <= 6) {
            from_month = 4;
            to_month = 6;
        } else if (actual_month <= 9) {
            from_month = 7;
            to_month = 9;
        } else if (actual_month <= 12) {
            from_month = 10;
            to_month = 12;
        }
        to_day = new Date(to_year, to_month, 0).getDate();
    } else if (timerange === "triwulan_lalu") {
        const date = new Date();
        const actual_month = date.getMonth() + 1;
        from_day = 1;
        from_year = date.getFullYear();
        to_year = from_year;
        if (actual_month <= 3) {
            from_month = 10;
            to_month = 12;
            from_year--;
            to_year--;
        } else if (actual_month <= 6) {
            from_month = 1;
            to_month = 3;
        } else if (actual_month <= 9) {
            from_month = 4;
            to_month = 6;
        } else if (actual_month <= 12) {
            from_month = 7;
            to_month = 9;
        }
        to_day = new Date(to_year, to_month, 0).getDate();
    }

    document.getElementById("from_day").value = from_day;
    document.getElementById("from_month").value = from_month;
    document.getElementById("from_year").value = from_year;
    document.getElementById("to_day").value = to_day;
    document.getElementById("to_month").value = to_month;
    document.getElementById("to_year").value = to_year;
}

function table_to_excel(table_id) {
    $(`#${table_id}`).table2excel({
        filename: `${table_id}.xls`,
    });
}

function formatHarga(harga) {
    // console.log(harga);
    let harga_ohne_titik = harga.replace(".", "");
    if (harga_ohne_titik.length < 4) {
        return harga;
    }
    let hargaRP = "";
    let akhir = harga_ohne_titik.length;
    let posisi = akhir - 3;
    let jmlTitik = Math.ceil(harga_ohne_titik.length / 3 - 1);
    // console.log(jmlTitik);
    for (let i = 0; i < jmlTitik; i++) {
        hargaRP = "." + harga_ohne_titik.slice(posisi, akhir) + hargaRP;
        // console.log(hargaRP);
        akhir = posisi;
        posisi = akhir - 3;
    }
    hargaRP = harga_ohne_titik.slice(0, akhir) + hargaRP;
    return hargaRP;
}

// function formatNumber(number, element) {
//     // console.log('formatNumber');
//     // console.log(element);
//     if (isNaN(number)) {
//         console.log("NAN");
//         number = 0;
//     }
//     var formatted_number = formatHarga(number.toString());
//     if (element == null) {
//         return formatted_number;
//     } else {
//         element.textContent = formatted_number;
//         return true;
//     }
// }

function formatCurrencyRp(number, element) {
    // console.log(element);
    var formatted_number = formatHarga(number.toString());
    if (element == null) {
        return formatted_number;
    } else {
        element.innerHTML = `<div><div class="d-flex justify-content-between"><span>Rp</span><span>${formatted_number},-</span></div></div>`;
        // console.log(element);
        return true;
    }
}

function formatNumberK(number, element) {
    // console.log(element);

    number = Math.ceil(number / 1000);
    // console.log(number);
    var formatted_number = formatHarga(number.toString());
    if (element == null) {
        return formatted_number;
    } else {
        element.textContent = formatted_number + "k";
        return true;
    }
}

function formatNumberHargaRemoveDecimal(harga) {
    // console.log(harga);
    let harga_2 = "";
    if (harga.includes(".")) {
        let harga_1 = harga.slice(0, harga.indexOf("."));
        harga_2 = harga.slice(harga.indexOf("."), harga.length);
        // console.log(harga_1); console.log(harga_2);
        harga = harga_1;
        if (parseInt(harga_2[1]) >= 5) {
            harga = (parseInt(harga) + 1).toString();
        }
    }
    let harga_ohne_titik = harga.replace(".", "");
    if (harga_ohne_titik.length < 4) {
        return harga;
    }
    let hargaRP = "";
    let akhir = harga_ohne_titik.length;
    let posisi = akhir - 3;
    let jmlTitik = Math.ceil(harga_ohne_titik.length / 3 - 1);
    // console.log(jmlTitik);
    for (let i = 0; i < jmlTitik; i++) {
        hargaRP = "." + harga_ohne_titik.slice(posisi, akhir) + hargaRP;
        // console.log(hargaRP);
        akhir = posisi;
        posisi = akhir - 3;
    }
    hargaRP = harga_ohne_titik.slice(0, akhir) + hargaRP;
    // console.log(hargaRP);
    return hargaRP;
    // console.log(harga_2);
    // return (parseFloat(hargaRP) + harga_2).toString();
}

function pin_formatted_number_on_certain_element(value, element_id) {
    document.getElementById(element_id).textContent =
        formatNumberHargaRemoveDecimal(value.toString());
}

function formatNumber(ipt, hidden_id) {
    // console.log(ipt);
    // console.log(isNaN(ipt.value));
    // console.log(ipt.value[ipt.value.length - 2]);
    var num = ipt.value;
    // console.log(num);
    // console.log(ipt.value.length);
    // console.log(num[ipt.value.length - 2]);
    num = ipt.value.split(".").join("");
    num = num.split(",");
    // if (num[ipt.value.length - 2] === '.' || num[ipt.value.length - 3] === '.') {
    //     num = num.split('.');
    // } else {
    // }
    // console.log(num);

    // console.log(num);
    let hidden_num;
    if (num.length === 2) {
        if (num[1] !== "") {
            hidden_num = `${num[0]}.${num[1]}`;
        }
        // hidden_num = '';
        // num.forEach(n => {
        //     hidden_num += n;
        // });
    } else {
        hidden_num = num[0];
    }

    hidden_num = parseFloat(hidden_num);
    // console.log(num);
    document.getElementById(hidden_id).value = hidden_num;
    // console.log(document.getElementById(hidden_id).value);
    // console.log(ipt.value, num);
    if (!isNaN(hidden_num)) {
        let real_number_formatted = parseFloat(num[0]).toLocaleString("id-ID", {
            style: "decimal",
        });
        // console.log(real_number_formatted);
        if (num.length === 2) {
            ipt.value = `${real_number_formatted},${num[1]}`;
        } else {
            ipt.value = real_number_formatted;
        }
        // console.log(ipt.value);
    }
}

function formatNumberX(string_value) {
    let num = string_value.split(".").join("");
    num = num.split(",");
    let float_number;
    if (num.length === 2) {
        if (num[1] !== "") {
            float_number = `${num[0]}.${num[1]}`;
        }
    } else {
        float_number = num[0];
    }

    let formatted_number = float_number;
    if (!isNaN(float_number)) {
        let real_number_formatted = parseFloat(num[0]).toLocaleString("id-ID", {
            style: "decimal",
        });
        // console.log(real_number_formatted);
        formatted_number = `${real_number_formatted} ,-`;
        if (num.length === 2) {
            formatted_number = `${real_number_formatted} ,${num[1]}`;
        }
    }

    return formatted_number;
} // fungsi untuk return decimal number dalam bentuk string

function formatNumberMurni(string_value) {
    let num = string_value.split(".").join("");
    num = num.split(",");
    let float_number;
    if (num.length === 2) {
        if (num[1] !== "") {
            float_number = `${num[0]}.${num[1]}`;
        }
    } else {
        float_number = num[0];
    }

    let formatted_number = float_number;
    if (!isNaN(float_number)) {
        let real_number_formatted = parseFloat(num[0]).toLocaleString("id-ID", {
            style: "decimal",
        });
        // console.log(real_number_formatted);
        formatted_number = `${real_number_formatted}`;
        if (num.length === 2) {
            formatted_number = `${real_number_formatted},${num[1]}`;
        }
    }

    return formatted_number;
} // fungsi untuk return decimal number dalam bentuk string

function preformatDotToComa(float_value) {
    return float_value.toString().split(".").join(",");
}

function pangkasDesimal(str_value) {
    // Terkadang hasil perhitungan bisa jadi panjang sekali decimal ke belakang, jadi ini untuk pangkas jadi dua angka di belakang koma.
    let float_value = parseFloat(str_value);
    let get_decimal = float_value % 1;
    // console.log(get_decimal);
    // console.log(get_decimal.toString());
    if (get_decimal.toString().length > 4) {
        get_decimal = get_decimal.toFixed(2);
    }
    let get_real_number = (Math.trunc(float_value) * 100) / 100;
    // console.log(get_real_number);
    // console.log(get_real_number + get_decimal);
    if (get_decimal === 0) {
        return get_real_number;
    } else {
        let real_number = parseFloat(get_real_number) + parseFloat(get_decimal);
        // console.log(get_real_number);
        // console.log(get_decimal);
        // console.log(real_number);
        return real_number;
    }
}

function formatNumber2(formatted_id, hidden_id) {
    var formatted = document.getElementById(formatted_id);
    var num = formatted.value;
    num = formatted.value.split(".").join("");
    num = num.split(",");
    let hidden_num;
    if (num.length === 2) {
        if (num[1] !== "") {
            hidden_num = `${num[0]}.${num[1]}`;
        }
    } else {
        hidden_num = num[0];
    }

    hidden_num = parseFloat(hidden_num);
    document.getElementById(hidden_id).value = hidden_num;
    if (!isNaN(hidden_num)) {
        let real_number_formatted = parseFloat(num[0]).toLocaleString("id-ID", {
            style: "decimal",
        });
        if (num.length === 2) {
            formatted.value = `${real_number_formatted},${num[1]}`;
        } else {
            formatted.value = real_number_formatted;
        }
    }
}

function remove_element_confirm(id, confirm_message) {
    if (confirm(confirm_message)) {
        document.getElementById(id).remove();
    }
}

// FUNGSI - PHOTO
function preview_photo(
    input_id,
    container_preview_photo_id,
    preview_photo_id,
    label_choose_photo_id
) {
    const el_input = document.getElementById(input_id);
    const el_container_preview_photo = document.getElementById(
        container_preview_photo_id
    );
    const el_preview_photo = document.getElementById(preview_photo_id);
    const el_label_choose_photo = document.getElementById(
        label_choose_photo_id
    );
    // console.log(el_input.files[0]);
    const blob = URL.createObjectURL(el_input.files[0]);
    el_preview_photo.src = blob;
    el_container_preview_photo.classList.remove("hidden");
    el_label_choose_photo.classList.add("hidden");
}

function remove_photo(
    input_id,
    container_preview_photo_id,
    preview_photo_id,
    label_choose_photo_id
) {
    const el_input = document.getElementById(input_id);
    const el_container_preview_photo = document.getElementById(
        container_preview_photo_id
    );
    const el_preview_photo = document.getElementById(preview_photo_id);
    const el_label_choose_photo = document.getElementById(
        label_choose_photo_id
    );
    el_input.value = null;
    el_preview_photo.src = null;
    console.log(el_container_preview_photo);
    el_container_preview_photo.classList.add("hidden");
    el_label_choose_photo.classList.remove("hidden");
}

function formatCurrencyID(num) {
    num = (num / 100).toString();
    // console.log(num);
    // console.log(num.includes(","));
    // console.log(num.includes("."));
    if (num.includes(".")) {
        num = num.split(".");
        num[0] = parseFloat(num[0]).toLocaleString("id-ID", {style: "decimal",});
        num = `${num[0]},${num[1]}`
    } else {
        num = parseFloat(num).toLocaleString("id-ID", {style: "decimal",});
        num = `${num},-`;
    }

    return num;
}

const formatNumberDecID = (num) => {
    num = (num / 100).toString();
    if (num.includes(".")) {
        num = num.split(".");
        num[0] = parseFloat(num[0]).toLocaleString("id-ID", {style: "decimal",});
        num = `${num[0]},${num[1]}`
    } else {
        num = parseFloat(num).toLocaleString("id-ID", {style: "decimal",});
    }

    return num;
}

function submitWithPreserveScroll(target_element, position_name) {
    // Simpan posisi scroll saat ini di sessionStorage
    sessionStorage.setItem(position_name, window.scrollY);
    
    // Submit form
    target_element.form.submit();
}

// Setelah halaman dimuat, kembalikan ke posisi scroll yang tersimpan
function getScrollLocation(position_name) {
    // window.onload = function() {
    const scrollPosition = sessionStorage.getItem(position_name);
    if (scrollPosition) {
        window.scrollTo(0, scrollPosition);
    }
    // };
}

// export{formatCurrencyID, formatNumberDecID};
