<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kuantitas SDM</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Stylesheet untuk styling halaman */
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
            width: 80%;
            margin: 0 auto;
            /* Tambahkan property ini untuk memusatkan konten */
        }

        #kuantitas-sdm {
            margin-top: 20px;
        }

        #myChart {
            width: 100%;
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
            text-align: center;
        }

        th {
            background-color: #ffcc00;
            /* Kuning muda */
            color: #000;
            /* Hitam */
        }

        tr:hover {
            background-color: #f2f2f2;
            /* Abu-abu saat hover */
        }

        /* Tombol cetak laporan */
        #btn-cetak {
            display: block;
            margin: 20px auto;
            background-color: #ffcc00;
            /* Kuning muda */
            color: #000;
            /* Hitam */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #btn-cetak:hover {
            background-color: #ffd700;
            /* Kuning muda */
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            /* Biru */
            text-decoration: none;
        }

        a:hover {
            color: #0056b3;
            /* Biru tua */
        }

        /* Responsif untuk tabel */
        @media screen and (max-width: 600px) {
            table {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Laporan Kuantitas SDM</h1>
    </header>
    <main>
        <section id="kuantitas-sdm">
            <!-- Tambahkan canvas untuk diagram garis -->
            <canvas id="myChart"></canvas>
            <table>
                <tr>
                    <th>Jabatan</th>
                    <th>Jumlah Karyawan</th>
                </tr>
                <?php
                // Kode untuk koneksi ke database
                include 'koneksi.php';

                // Query untuk mendapatkan jumlah karyawan dalam setiap jabatan
                $query = "SELECT jabatan, COUNT(*) AS jumlah_karyawan
                          FROM karyawan
                          GROUP BY jabatan";

                $result = mysqli_query($koneksi, $query);

                if (!$result) {
                    die("Query error: " . mysqli_error($koneksi));
                }

                // Array untuk menyimpan data jabatan dan jumlah karyawan
                $labels = [];
                $data = [];

                // Menampilkan data kuantitas SDM dalam tabel
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['jabatan'] . "</td>";
                    echo "<td>" . $row['jumlah_karyawan'] . "</td>";
                    echo "</tr>";

                    // Memasukkan data ke dalam array
                    $labels[] = $row['jabatan'];
                    $data[] = $row['jumlah_karyawan'];
                }
                ?>
            </table>
        </section>
    </main>
    <!-- Tombol untuk cetak laporan -->
    <button id="btn-cetak" onclick="cetakLaporan()">Cetak Laporan</button>
    <script>
        // Fungsi untuk mencetak laporan
        function cetakLaporan() {
            window.print();
        }

        // Membuat diagram garis menggunakan Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Jumlah Karyawan per Jabatan',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <a href="laporan.php">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
</body>

</html>