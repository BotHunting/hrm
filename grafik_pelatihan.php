<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';
include 'navbar.php';

// Query untuk mendapatkan data peserta pelatihan
$query_get_peserta = "SELECT nama_peserta, nilai FROM peserta_pelatihan";
$result_get_peserta = mysqli_query($koneksi, $query_get_peserta);

// Validasi apakah data peserta ditemukan
if ($result_get_peserta && mysqli_num_rows($result_get_peserta) > 0) {
    // Menginisialisasi array untuk menyimpan data peserta
    $data_peserta = array();

    // Mengisi array dengan data peserta dari hasil query
    while ($row = mysqli_fetch_assoc($result_get_peserta)) {
        $data_peserta[] = $row;
    }
} else {
    // Jika data peserta tidak ditemukan
    echo "Data peserta pelatihan tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Pelatihan</title>
    <!-- Load library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <h1>Grafik Pelatihan</h1>
    </header>
    <main>
        <!-- Tampilan grafik -->
        <canvas id="grafikPeserta"></canvas>
    </main>

    <script>
        // Mengambil data peserta dari PHP dan menyimpannya dalam variabel JavaScript
        var dataPeserta = <?php echo json_encode($data_peserta); ?>;

        // Mendefinisikan label (nama peserta) dan data (nilai) untuk grafik
        var labels = [];
        var nilai = [];

        // Mengisi label dan data dari data peserta
        dataPeserta.forEach(function(item) {
            labels.push(item.nama_peserta);
            nilai.push(item.nilai);
        });

        // Mendefinisikan data untuk grafik
        var data = {
            labels: labels,
            datasets: [{
                label: 'Nilai Peserta',
                data: nilai,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna latar belakang grafik
                borderColor: 'rgba(54, 162, 235, 1)', // Warna garis grafik
                borderWidth: 1
            }]
        };

        // Mendefinisikan konfigurasi untuk grafik
        var options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Mendapatkan elemen canvas untuk grafik
        var ctx = document.getElementById('grafikPeserta').getContext('2d');

        // Membuat grafik menggunakan Chart.js
        var myChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik
            data: data, // Data untuk grafik
            options: options // Konfigurasi untuk grafik
        });
    </script>
</body>

</html>