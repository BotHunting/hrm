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

// Variabel pesan untuk menampilkan pesan sukses atau kesalahan
$pesan = '';

// Array pilihan bulan
$bulan_options = array(
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
);

// Cek jabatan pengguna yang sedang login
$jabatan = $_SESSION["jabatan"];
?>

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Penilaian Kinerja Karyawan</h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Kinerja Karyawan</li>
            </ol>
        </div>

    </div>
</section><!-- End Breadcrumbs -->

<main id="main" class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <?php if ($jabatan !== 'karyawan') : ?>
                <a href="tambah_kinerja.php" class="btn btn-primary">Tambah Penilaian Kinerja</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Daftar penilaian kinerja -->
    <section id="daftar-penilaian" class="mt-4">
        <h2>Daftar Penilaian Kinerja</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Karyawan</th>
                        <th>Nama</th>
                        <th>Bulan</th>
                        <th>Penilaian Kinerja</th>
                        <th>Kategori Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data penilaian kinerja terakhir dari setiap karyawan
                    $query = "SELECT kinerja.*, karyawan.nama
                                  FROM kinerja
                                  INNER JOIN (
                                      SELECT id_karyawan, MAX(bulan) AS max_bulan
                                      FROM kinerja
                                      GROUP BY id_karyawan
                                  ) AS max_kinerja
                                  ON kinerja.id_karyawan = max_kinerja.id_karyawan
                                  AND kinerja.bulan = max_kinerja.max_bulan
                                  INNER JOIN karyawan
                                  ON kinerja.id_karyawan = karyawan.id_karyawan";

                    $result = mysqli_query($koneksi, $query);

                    // Memeriksa apakah query berhasil dieksekusi
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Menampilkan data penilaian kinerja terakhir dari setiap karyawan
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_karyawan'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $bulan_options[$row['bulan'] - 1] . "</td>";
                            echo "<td>" . $row['penilaian'] . "</td>";
                            echo "<td>" . $row['kategori_penilaian'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Jika tidak ada data
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php include 'footer.php' ?>