<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';
include 'functions.php';
include 'header.php';
?>

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Manajemen Pengguna</h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Pengguna</li>
            </ol>
        </div>

    </div>
</section><!-- End Breadcrumbs -->

<main class="container mt-4">
    <h1 class="text-center mb-4">Manajemen Pengguna</h1>
    <div id="tambah-pengguna" class="mb-4">
        <a href="tambah_pengguna.php" class="btn btn-primary">Tambah Pengguna</a>
    </div>
    <div id="daftar-pengguna">
        <h2>Daftar Pengguna</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Karyawan</th>
                        <th>Nama Pengguna</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Memanggil fungsi untuk mengambil daftar pengguna
                    $daftar_pengguna = getDaftarPengguna();
                    foreach ($daftar_pengguna as $pengguna) {
                        echo "<tr>";
                        echo "<td>" . $pengguna['id_karyawan'] . "</td>";
                        echo "<td>" . $pengguna['nama_pengguna'] . "</td>";
                        echo "<td>" . $pengguna['jabatan'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_pengguna.php?id=" . $pengguna['id_karyawan'] . "' class='btn btn-primary mr-2'>Edit</a>";
                        echo "<a href='hapus_pengguna.php?id=" . $pengguna['id_karyawan'] . "' class='btn btn-danger'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'footer.php' ?>