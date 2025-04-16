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

// Cek jabatan pengguna yang sedang login
$jabatan = $_SESSION["jabatan"];

// Memanggil fungsi untuk mengambil daftar seluruh karyawan
$daftar_karyawan = array(); // inisialisasi array kosong untuk menyimpan data karyawan
$query_daftar_karyawan = "SELECT * FROM karyawan";
$result_daftar_karyawan = mysqli_query($koneksi, $query_daftar_karyawan);

// Mengisi array $daftar_karyawan dengan data dari database
if ($result_daftar_karyawan) {
    while ($row = mysqli_fetch_assoc($result_daftar_karyawan)) {
        $daftar_karyawan[] = $row;
    }
} else {
    $pesan = "Error: " . $query_daftar_karyawan . "<br>" . mysqli_error($koneksi);
}
?>

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Manajemen Absensi Karyawan</h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Absensi Karyawan</li>
            </ol>
        </div>

    </div>
</section><!-- End Breadcrumbs -->

<main id="main">
    <!-- Tombol untuk tambah absensi -->
    <div id="tambah-absensi" class="container mt-4 mb-4">
        <div class="row">
            <div class="col-md-6">
                <a href="absen_masuk.php" class="btn btn-primary me-2">Absen Masuk</a>
                <a href="absen_keluar.php" class="btn btn-primary me-2">Absen Keluar</a>
            </div>
            <div class="col-md-6">
                <a href="absen_izin.php" class="btn btn-primary me-2">Izin</a>
                <a href="absen_sakit.php" class="btn btn-primary me-2">Sakit</a>
                <?php if ($jabatan !== 'karyawan') : ?>
                    <a href="tambah_absensi.php" class="btn btn-primary">Tambah Absensi</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Daftar data absensi -->
    <section id="daftar-absensi" class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Daftar Data Absensi</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID Karyawan</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam Masuk</th>
                            <th scope="col">Jam Keluar</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Menampilkan daftar absensi untuk setiap karyawan
                        foreach ($daftar_karyawan as $karyawan) {
                            echo "<tr>";
                            echo "<td>" . $karyawan['id_karyawan'] . "</td>";
                            echo "<td>" . $karyawan['nama'] . "</td>";
                            // Memanggil data absensi terakhir untuk setiap karyawan dari tabel absensi
                            $query_daftar_absensi = "SELECT * FROM absensi WHERE id_karyawan = '{$karyawan['id_karyawan']}' ORDER BY tanggal DESC LIMIT 1";
                            $result_daftar_absensi = mysqli_query($koneksi, $query_daftar_absensi);
                            if ($result_daftar_absensi && mysqli_num_rows($result_daftar_absensi) > 0) {
                                $absensi = mysqli_fetch_assoc($result_daftar_absensi);
                                echo "<td>" . $absensi['tanggal'] . "</td>";
                                echo "<td>" . $absensi['jam_masuk'] . "</td>";
                                echo "<td>" . $absensi['jam_keluar'] . "</td>";
                                echo "<td>" . $absensi['keterangan'] . "</td>";
                            } else {
                                // Jika karyawan tidak memiliki data absensi
                                echo "<td colspan='5'>Belum melakukan absensi</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php' ?>