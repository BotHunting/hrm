<?php
// Konfigurasi koneksi database
$host = "localhost"; // Host database (biasanya localhost)
$username = "root"; // Nama pengguna database
$password = ""; // Kata sandi database
$database = "sim_hrm"; // Nama database

// Membuat koneksi ke database
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
