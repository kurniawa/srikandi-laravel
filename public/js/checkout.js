function cariDataPelangganF(users) {
    let pelanggan_nama = document.getElementById('cari_pelanggan_nama');
    if (pelanggan_nama) {
        pelanggan_nama = pelanggan_nama.value.trim();
    }
    let pelanggan_username = document.getElementById('cari_pelanggan_username');
    if (pelanggan_username) {
        pelanggan_username = pelanggan_username.value.trim();
    }

    let found_pelanggan = null;

    // console.log(pelanggan_nama);
    if (pelanggan_nama && pelanggan_username) {
        // var pilihan_jenis_perhiasans = jenis_perhiasans.filter((o) => o.tipe_perhiasan_id == tipe_perhiasan.id);
        found_pelanggan = users.filter((o) => o.username == pelanggan_username);
    } else if (pelanggan_nama && !pelanggan_username) {
        found_pelanggan = users.filter((o) => o.nama == pelanggan_nama);
    } else if (!pelanggan_nama && pelanggan_username) {
        found_pelanggan = users.filter((o) => o.username == pelanggan_username);
    }

    // console.log(found_pelanggan);
    if (found_pelanggan.length === 1) {
        document.getElementById('pelanggan_nama').value = found_pelanggan[0].nama;
        document.getElementById('pelanggan_nama_di_dalam_form').value = found_pelanggan[0].nama;
        document.getElementById('pelanggan_username').value = found_pelanggan[0].username;
        document.getElementById('pelanggan_username_di_dalam_form').value = found_pelanggan[0].username;
        document.getElementById('pelanggan_nik').value = found_pelanggan[0].nik;
        document.getElementById('pelanggan_nik_di_dalam_form').value = found_pelanggan[0].nik;
        $('#tampilan_data_pelanggan').show(300);
        $('#tampilan_pelanggan_guest').hide(300);
        toggle_light('btn-ganti', 'form-cari-data-pelanggan', ['text-slate-500'], ['text-white', 'bg-slate-400'], 'block');
        return true;
    } else {
        document.getElementById('feedback_cari_pelanggan').textContent = '- ditemukan lebih dari satu pelanggan dengan nama yang sama atau ada kesalahan -';
        return false;
    }
}
