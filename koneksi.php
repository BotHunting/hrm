<?php
// Konfigurasi koneksi database
$host = "sql12.freesqldatabase.com"; // Host database (biasanya localhost)
$username = "sql12773598"; // Nama pengguna database
$password = "IXRNLTKKCt"; // Kata sandi database
$database = "sql12773598"; // Nama database

// Membuat koneksi ke database
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
