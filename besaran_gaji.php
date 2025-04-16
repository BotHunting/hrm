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

// Query untuk mengambil data gaji dari tabel salary
$query = "SELECT * FROM salary";
$result = mysqli_query($koneksi, $query);
?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Besaran Gaji</h1>
    <div id="tambah-jabatan" class="mb-4">
        <a href="tambah_jabatan.php" class="btn btn-primary">Tambah Jabatan</a>
    </div>

    <!-- Tabel besaran gaji -->
    <div id="besaran-gaji">
        <h2>Besaran Gaji Berdasarkan Jabatan</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jabatan</th>
                        <th>Upah</th>
                        <th>Gaji Harian</th>
                        <th>Aksi</th> <!-- Tambahkan kolom aksi untuk tombol edit -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Memeriksa apakah query berhasil dieksekusi
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Menampilkan data gaji dalam bentuk tabel HTML
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_jabatan'] . "</td>";
                            echo "<td>" . $row['jabatan'] . "</td>";
                            echo "<td>Rp " . (isset($row['upah']) ? $row['upah'] : "0") . "</td>"; // Periksa apakah 'upah' ada sebelum mengakses nilainya
                            echo "<td>Rp " . $row['gaji_harian'] . "</td>";
                            echo "<td><a href='edit_jabatan.php?id_jabatan=" . $row['id_jabatan'] . "' class='btn btn-sm btn-info'>Edit</a></td>"; // Tombol edit
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data gaji</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="laporan.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
    </div>
</main>

<?php include 'footer.php' ?>