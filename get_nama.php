<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Memeriksa apakah parameter id_karyawan telah diterima dari permintaan GET
if (isset($_GET['id_karyawan'])) {
    // Mendapatkan nilai id_karyawan dari permintaan GET
    $id_karyawan = $_GET['id_karyawan'];

    // Query untuk mendapatkan nama karyawan berdasarkan id_karyawan
    $query_get_nama = "SELECT nama FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result_get_nama = mysqli_query($koneksi, $query_get_nama);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result_get_nama && mysqli_num_rows($result_get_nama) > 0) {
        // Mengambil data nama dari hasil query
        $row = mysqli_fetch_assoc($result_get_nama);
        $nama = $row['nama'];

        // Mengirimkan nama karyawan sebagai respon
        echo $nama;
    } else {
        // Jika tidak ada data yang ditemukan, kirim pesan error
        echo "Nama tidak ditemukan";
    }
} else {
    // Jika parameter id_karyawan tidak diterima, kirim pesan error
    echo "ID Karyawan tidak diterima";
}
