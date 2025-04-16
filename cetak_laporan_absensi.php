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

// Query untuk mendapatkan data absensi
$query_absensi = "SELECT karyawan.id_karyawan, karyawan.nama,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Izin' THEN 1 ELSE 0 END) AS izin,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS alpha
                  FROM karyawan
                  LEFT JOIN absensi_laporan ON karyawan.id_karyawan = absensi_laporan.id_karyawan
                  WHERE MONTH(absensi_laporan.tanggal) = $bulan AND YEAR(absensi_laporan.tanggal) = $tahun
                  GROUP BY karyawan.id_karyawan";

$result_absensi = mysqli_query($koneksi, $query_absensi);

if (!$result_absensi) {
    die("Query error: " . mysqli_error($koneksi));
}

// Query untuk mendapatkan data untuk grafik
$query_grafik = "SELECT karyawan.nama,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Izin' THEN 1 ELSE 0 END) AS izin,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
                        SUM(CASE WHEN absensi_laporan.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS alpha
                 FROM karyawan
                 LEFT JOIN absensi_laporan ON karyawan.id_karyawan = absensi_laporan.id_karyawan
                 WHERE MONTH(absensi_laporan.tanggal) = $bulan AND YEAR(absensi_laporan.tanggal) = $tahun
                 GROUP BY karyawan.id_karyawan";

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
    <title>Cetak Laporan Absensi Karyawan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        @media print {

            /* Sembunyikan tombol cetak ketika dicetak */
            #btn-cetak {
                display: none;
            }
        }

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
            border: 1px solid black;
            padding: 8px;
            text-align: center;
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
        <h1>Laporan Absensi Karyawan - Bulan <?php echo date("F", mktime(0, 0, 0, $bulan, 1)) . " " . $tahun; ?></h1>
    </header>
    <main>
        <!-- Bagian pertama: Tabel absensi -->
        <section id="laporan-absensi">
            <h2>Data Absensi</h2>
            <table>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                </tr>
                <?php
                // Menampilkan data absensi dalam tabel
                while ($row = mysqli_fetch_assoc($result_absensi)) {
                    echo "<tr>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['hadir'] . "</td>";
                    echo "<td>" . $row['izin'] . "</td>";
                    echo "<td>" . $row['sakit'] . "</td>";
                    echo "<td>" . $row['alpha'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>

        <!-- Bagian kedua: Grafik absensi -->
        <section class="grafik-container">
            <h2>Grafik Absensi</h2>
            <canvas id="grafikAbsensi"></canvas>
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
                label: 'Hadir',
                data: [<?php mysqli_data_seek($result_grafik, 0);
                        while ($row = mysqli_fetch_assoc($result_grafik)) {
                            echo $row['hadir'] . ',';
                        } ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Izin',
                data: [<?php mysqli_data_seek($result_grafik, 0);
                        while ($row = mysqli_fetch_assoc($result_grafik)) {
                            echo $row['izin'] . ',';
                        } ?>],
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: 'Sakit',
                data: [<?php mysqli_data_seek($result_grafik, 0);
                        while ($row = mysqli_fetch_assoc($result_grafik)) {
                            echo $row['sakit'] . ',';
                        } ?>],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: 'Alpha',
                data: [<?php mysqli_data_seek($result_grafik, 0);
                        while ($row = mysqli_fetch_assoc($result_grafik)) {
                            echo $row['alpha'] . ',';
                        } ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
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

        // Inisialisasi chart menggunakan id "grafikAbsensi"
        var myChart = new Chart(
            document.getElementById('grafikAbsensi'),
            config
        );
    </script>
    <a href="laporan_absensi.php">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
</body>

</html>