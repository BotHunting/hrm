<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Query untuk mengambil daftar pelatihan
$query = "SELECT id_pelatihan, nama_pelatihan FROM pelatihan";
$result = mysqli_query($koneksi, $query);

// Buat opsi dropdown untuk setiap pelatihan
$options = '';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='" . $row['id_pelatihan'] . "'>" . $row['nama_pelatihan'] . "</option>";
}

// Kembalikan opsi dropdown
echo $options;
