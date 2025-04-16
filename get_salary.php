<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Mendapatkan id karyawan dari parameter GET
if (isset($_GET['id_karyawan'])) {
    $id_karyawan = $_GET['id_karyawan'];

    // Query SQL untuk mengambil data gaji pokok berdasarkan id karyawan
    $query = "SELECT gaji_harian FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result = mysqli_query($koneksi, $query);

    // Mengambil data gaji pokok dari hasil query
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $gaji_harian = $row['gaji_harian'];

        // Membuat array response
        $response = array("gaji_harian" => $gaji_harian);
        echo json_encode($response);
    } else {
        // Jika id karyawan tidak ditemukan
        $response = array("error" => "ID Karyawan tidak ditemukan");
        echo json_encode($response);
    }
} else {
    // Jika parameter id_karyawan tidak tersedia
    $response = array("error" => "ID Karyawan tidak disediakan");
    echo json_encode($response);
}
