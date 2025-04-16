<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Mendapatkan nilai id karyawan dan bulan dari URL
$id_karyawan = $_GET['id_karyawan'];
$bulan = $_GET['bulan'];

// Query untuk mengambil data penilaian kinerja dari tabel kinerja berdasarkan id karyawan dan bulan
$query = "SELECT penilaian FROM kinerja_laporan WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan'";
$result = mysqli_query($koneksi, $query);

// Inisialisasi array untuk menyimpan hasil
$response = array();

// Jika query berhasil dieksekusi
if ($result) {
    // Ambil data penilaian kinerja
    $row = mysqli_fetch_assoc($result);
    $penilaian = $row['penilaian'];

    // Tambahkan data ke dalam array response
    $response['penilaian'] = $penilaian;
} else {
    // Jika query gagal dieksekusi
    $response['error'] = "Gagal mengambil data penilaian kinerja";
}

// Mengembalikan data dalam format JSON
echo json_encode($response);
