<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Query untuk mengambil daftar peserta
$query = "SELECT id_peserta, nama_peserta FROM peserta";
$result = mysqli_query($koneksi, $query);

// Buat opsi dropdown untuk setiap peserta
$options = '';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='" . $row['id_peserta'] . "'>" . $row['nama_peserta'] . "</option>";
}

// Kembalikan opsi dropdown
echo $options;
