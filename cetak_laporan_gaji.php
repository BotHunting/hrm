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

// Memeriksa apakah ada parameter bulan dan tahun yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
}

// Query untuk mendapatkan data gaji karyawan
$query_gaji = "SELECT id_karyawan, nama, bulan, tahun, gaji_pokok, jumlah_absensi, tunjangan_kinerja, jumlah_honor, pajak_penghasilan, total_gaji
               FROM gaji_laporan
               WHERE bulan = $bulan AND tahun = $tahun";

$result_gaji = mysqli_query($koneksi, $query_gaji);

if (!$result_gaji) {
    die("Query error: " . mysqli_error($koneksi));
}

// Inisialisasi variabel total gaji
$total_gaji = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Gaji Karyawan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        /* Stylesheet untuk styling halaman cetak */
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
    </style>
</head>

<body>
    <header>
        <h1>Laporan Gaji Karyawan - Bulan <?php echo date("F", mktime(0, 0, 0, $bulan, 1)) . " " . $tahun; ?></h1>
    </header>
    <main>
        <table>
            <tr>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Gaji Pokok</th>
                <th>Jumlah Absensi</th>
                <th>Tunjangan Kinerja (%)</th>
                <th>Jumlah Honor</th>
                <th>Pajak Penghasilan</th>
                <th>Total Gaji</th>
            </tr>
            <?php
            // Menampilkan data gaji dalam tabel
            while ($row = mysqli_fetch_assoc($result_gaji)) {
                echo "<tr>";
                echo "<td>" . $row['id_karyawan'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . date("F", mktime(0, 0, 0, $row['bulan'], 1)) . "</td>";
                echo "<td>" . $row['tahun'] . "</td>";
                echo "<td>Rp " . $row['gaji_pokok'] . "</td>";
                echo "<td>" . $row['jumlah_absensi'] . "</td>";
                echo "<td>" . $row['tunjangan_kinerja'] . " %</td>";
                echo "<td>Rp " . $row['jumlah_honor'] . "</td>";
                echo "<td>Rp " . $row['pajak_penghasilan'] . "</td>";
                echo "<td>Rp " . $row['total_gaji'] . "</td>";
                echo "</tr>";

                // Tambahkan total gaji
                $total_gaji += $row['total_gaji'];
            }
            ?>
            <tr>
                <td colspan="9" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>Rp <?php echo $total_gaji; ?></strong></td>
            </tr>
        </table>
    </main>
    <button id="btn-cetak" onclick="cetakLaporan()">Cetak Laporan</button>
    <script>
        // Fungsi untuk mencetak laporan
        function cetakLaporan() {
            window.print();
        }
    </script>
    <a href="laporan_gaji.php">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
</body>

</html>