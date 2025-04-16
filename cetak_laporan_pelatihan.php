<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';

// Query untuk mendapatkan daftar pelatihan
$query_get_pelatihan = "SELECT * FROM pelatihan";
$result_get_pelatihan = mysqli_query($koneksi, $query_get_pelatihan);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pelatihan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- Gaya kustom untuk cetak -->
    <style>
        @media print {
            .btn-cetak {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
        <h1>Cetak Laporan Pelatihan</h1>
    </header>
    <main>
        <?php if ($result_get_pelatihan && mysqli_num_rows($result_get_pelatihan) > 0) : ?>
            <?php while ($pelatihan = mysqli_fetch_assoc($result_get_pelatihan)) : ?>
                <section>
                    <h2><?php echo $pelatihan['nama_pelatihan']; ?></h2>
                    <table id="tabel-pelatihan-<?php echo $pelatihan['id_pelatihan']; ?>" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Peserta</th>
                                <th>Nilai</th>
                                <th>Biaya</th>
                                <th>Honor Pelatihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query untuk mendapatkan peserta pelatihan
                            $id_pelatihan = $pelatihan['id_pelatihan'];
                            $query_get_peserta = "SELECT k.nama, pp.nilai, pp.biaya, pp.honor_pelatihan FROM peserta_pelatihan pp INNER JOIN karyawan k ON pp.id_karyawan = k.id_karyawan WHERE pp.id_pelatihan='$id_pelatihan'";
                            $result_get_peserta = mysqli_query($koneksi, $query_get_peserta);
                            ?>
                            <?php if ($result_get_peserta && mysqli_num_rows($result_get_peserta) > 0) : ?>
                                <?php while ($peserta = mysqli_fetch_assoc($result_get_peserta)) : ?>
                                    <tr>
                                        <td><?php echo $peserta['nama']; ?></td>
                                        <td><?php echo $peserta['nilai']; ?></td>
                                        <td><?php echo $peserta['biaya']; ?></td>
                                        <td><?php echo $peserta['honor_pelatihan']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>
            <?php endwhile; ?>
        <?php endif; ?>

        <!-- Tombol cetak laporan -->
        <button onclick="cetakLaporan()" class="btn-cetak">Cetak Laporan</button>

        <!-- Skrip untuk DataTables -->
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <!-- Skrip kustom -->
        <script>
            $(document).ready(function() {
                // Inisialisasi DataTables untuk setiap tabel pelatihan
                <?php if ($result_get_pelatihan && mysqli_num_rows($result_get_pelatihan) > 0) : ?>
                    <?php while ($pelatihan = mysqli_fetch_assoc($result_get_pelatihan)) : ?>
                        $('#tabel-pelatihan-<?php echo $pelatihan['id_pelatihan']; ?>').DataTable();
                    <?php endwhile; ?>
                <?php endif; ?>
            });

            // Fungsi untuk mencetak laporan
            function cetakLaporan() {
                window.print();
            }
        </script>
        <a href="laporan_pelatihan.php">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
    </main>
</body>

</html>