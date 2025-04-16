<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';

// Inisialisasi variabel bulan dan tahun dengan nilai default (bulan dan tahun saat ini)
$bulan = date('m');
$tahun = date('Y');

// Memeriksa apakah data bulan dan tahun dikirimkan melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
}

// Query untuk mendapatkan data kinerja karyawan
$query_kinerja = "SELECT id_karyawan, nama, bulan, tahun, penilaian, kategori_penilaian, saran_rekomendasi
                  FROM kinerja_laporan
                  WHERE bulan = $bulan AND tahun = $tahun";

$result_kinerja = mysqli_query($koneksi, $query_kinerja);

if (!$result_kinerja) {
    die("Query error: " . mysqli_error($koneksi));
}

// Query untuk mendapatkan data untuk grafik
$query_grafik = "SELECT nama, penilaian
                 FROM kinerja_laporan
                 WHERE bulan = $bulan AND tahun = $tahun";

$result_grafik = mysqli_query($koneksi, $query_grafik);

if (!$result_grafik) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Kinerja Karyawan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        /* Stylesheet untuk styling halaman cetak */
        @media print {

            /* Sembunyikan tombol cetak ketika dicetak */
            #btn-cetak {
                display: none;
            }
        }

        /* Gaya lainnya */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            /* Abu-abu */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #000;
            /* Hitam */
        }

        header {
            background-color: #ffcc00;
            /* Kuning muda */
            color: #000;
            /* Hitam */
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 36px;
        }

        main {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #ffcc00;
            /* Kuning muda */
            color: #000;
            /* Hitam */
        }

        .grafik-container {
            width: 50%;
            margin: 0;
        }
    </style>
    <!-- Load library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <h1>Laporan Kinerja Karyawan - Bulan <?php echo date("F", mktime(0, 0, 0, $bulan, 1)) . " " . $tahun; ?></h1>
    </header>
    <main>
        <!-- Bagian pertama: Tabel kinerja -->
        <section id="laporan-kinerja">
            <h2>Data Kinerja</h2>
            <table>
                <tr>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Penilaian</th>
                    <th>Kategori Penilaian</th>
                    <th>Saran dan Rekomendasi</th>
                </tr>
                <?php
                // Menampilkan data kinerja karyawan dalam tabel
                while ($row = mysqli_fetch_assoc($result_kinerja)) {
                    echo "<tr>";
                    echo "<td>" . $row['id_karyawan'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['bulan'] . "</td>";
                    echo "<td>" . $row['tahun'] . "</td>";
                    echo "<td>" . $row['penilaian'] . "</td>";
                    echo "<td>" . $row['kategori_penilaian'] . "</td>";
                    echo "<td>" . $row['saran_rekomendasi'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>

        <!-- Bagian kedua: Grafik penilaian karyawan -->
        <section class="grafik-container">
            <h2>Grafik Penilaian Karyawan</h2>
            <canvas id="grafikPenilaian"></canvas>
        </section>
    </main>

    <!-- Tombol untuk cetak laporan -->
    <button id="btn-cetak" onclick="cetakLaporan()">Cetak Laporan</button>

    <script>
        // Fungsi untuk mencetak laporan
        function cetakLaporan() {
            window.print();
        }

        // Ambil data dari PHP dan konversi menjadi format yang dapat digunakan oleh Chart.js
        var data = {
            labels: [<?php while ($row = mysqli_fetch_assoc($result_grafik)) {
                            echo '"' . $row['nama'] . '",';
                        } ?>],
            datasets: [{
                label: 'Penilaian',
                data: [<?php mysqli_data_seek($result_grafik, 0);
                        while ($row = mysqli_fetch_assoc($result_grafik)) {
                            echo $row['penilaian'] . ',';
                        } ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Konfigurasi untuk Chart.js
        var config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Inisialisasi chart menggunakan id "grafikPenilaian"
        var myChart = new Chart(
            document.getElementById('grafikPenilaian'),
            config
        );
    </script>
    <a href="laporan_kinerja.php">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
</body>

</html>