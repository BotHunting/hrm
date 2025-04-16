<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Mengambil nilai jabatan dari parameter GET
$jabatan = $_GET['jabatan'];

// Query untuk mendapatkan data upah dan gaji harian berdasarkan jabatan
// $query = "SELECT upah, gaji_harian FROM salary WHERE jabatan='$jabatan'";
$query = "SELECT karyawan.nama, salary.upah, salary.gaji_harian from salary left outer join karyawan on karyawan.jabatan = salary.jabatan WHERE salary.jabatan = '$jabatan'";
$result = mysqli_query($koneksi, $query);

// Inisialisasi array untuk menyimpan hasil
$data = array();

// Jika query berhasil dieksekusi dan data ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $data['upah'] = $row['upah'];
    $data['gaji_harian'] = $row['gaji_harian'];
} else {
    // Jika tidak ada data yang ditemukan, atur nilai default menjadi 0
    $data['upah'] = 0;
    $data['gaji_harian'] = 0;
}

// Mengembalikan data dalam format JSON
echo json_encode($data);
