<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';
include 'header.php';

// Fungsi untuk mengambil data gaji terakhir tiap karyawan
function getDaftarGajiTerakhir()
{
    global $koneksi;
    $query = "SELECT * FROM gaji WHERE (id_karyawan, tahun, bulan) IN (SELECT id_karyawan, MAX(tahun), MAX(bulan) FROM gaji GROUP BY id_karyawan)";
    $result = mysqli_query($koneksi, $query);
    $daftar_gaji = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $daftar_gaji[] = $row;
        }
    }
    return $daftar_gaji;
}
?>

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Manajemen Gaji Karyawan</h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Gaji Karyawan</li>
            </ol>
        </div>

    </div>
</section><!-- End Breadcrumbs -->

<main class="container mt-4">
    <h1 class="text-center">Manajemen Gaji Karyawan</h1>
    <div id="tambah-gaji" class="text-center mt-3">
        <a href="tambah_gaji.php" class="btn btn-primary">Tambah Data Gaji</a>
    </div>
    <!-- Daftar data gaji -->
    <section id="daftar-gaji" class="mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID Karyawan</th>
                        <th>Nama</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Gaji Pokok</th>
                        <th>Jumlah Absensi</th>
                        <th>Tunjangan Kinerja (%)</th>
                        <th>Honor Pelatihan</th>
                        <th>Pajak Penghasilan</th>
                        <th>Total Gaji</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Memanggil fungsi untuk mengambil data gaji terakhir tiap karyawan
                    $daftar_gaji = getDaftarGajiTerakhir();
                    foreach ($daftar_gaji as $gaji) {
                        echo "<tr>";
                        echo "<td>" . $gaji['id_karyawan'] . "</td>";
                        echo "<td>" . $gaji['nama'] . "</td>";
                        echo "<td>" . date("F", mktime(0, 0, 0, $gaji['bulan'], 1)) . "</td>"; // Mengubah INT periode menjadi format bulan
                        echo "<td>" . $gaji['tahun'] . "</td>";
                        echo "<td>Rp " . $gaji['gaji_pokok'] . "</td>";
                        echo "<td>" . $gaji['jumlah_absensi'] . "</td>";
                        echo "<td>" . $gaji['tunjangan_kinerja'] . "</td>";
                        echo "<td>Rp " . $gaji['jumlah_honor'] . "</td>";
                        echo "<td>Rp " . $gaji['pajak_penghasilan'] . "</td>";
                        echo "<td>Rp " . $gaji['total_gaji'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php include 'footer.php' ?>