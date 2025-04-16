<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Mendapatkan nama tabel yang akan diambil datanya
if (isset($_GET['table_name'])) {
    $table_name = $_GET['table_name'];

    // Query untuk mengambil semua data dari tabel
    $query = "SELECT * FROM $table_name";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Inisialisasi array untuk menyimpan hasil
    $data = array();

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {
        // Mengambil data dari hasil query dan menyimpannya dalam array
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        // Mengembalikan hasil dalam format JSON
        echo json_encode($data);
    } else {
        // Jika query gagal dieksekusi, kirim pesan kesalahan
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    // Jika nama tabel tidak diberikan, kirim pesan kesalahan
    echo "Nama tabel tidak diberikan.";
}
