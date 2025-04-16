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

// Inisialisasi pesan kesalahan
$pesan = '';

// Ambil ID peserta dari parameter URL
$id_peserta = $_GET['id_peserta'];

// Query untuk mendapatkan data peserta pelatihan
$query_get_peserta = "SELECT * FROM peserta_pelatihan WHERE id_peserta='$id_peserta'";
$result_get_peserta = mysqli_query($koneksi, $query_get_peserta);

if ($result_get_peserta && mysqli_num_rows($result_get_peserta) > 0) {
    $peserta = mysqli_fetch_assoc($result_get_peserta);
    $biaya = $peserta['biaya'];
    $nilai = $peserta['nilai'];
    $honor_pelatihan = $peserta['honor_pelatihan'];
} else {
    // Jika data peserta tidak ditemukan, redirect ke halaman penilaian_pelatihan.php
    header("Location: penilaian_pelatihan.php");
    exit();
}

// Proses simpan nilai dan honor pelatihan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nilai = $_POST['nilai'];
    $honor_pelatihan = $nilai / 100 * $biaya;

    // Query untuk mengupdate nilai dan honor pelatihan di database
    $query_update_nilai = "UPDATE peserta_pelatihan 
                           SET nilai='$nilai', honor_pelatihan='$honor_pelatihan' 
                           WHERE id_peserta='$id_peserta'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query_update_nilai)) {
        // Set pesan notifikasi
        $pesan = "Data nilai dan honor pelatihan berhasil disimpan!";
    } else {
        $pesan = "Error: " . $query_update_nilai . "<br>" . mysqli_error($koneksi);
    }
}
?>

<main class="container mt-4">
    <!-- Formulir untuk mengisi nilai -->
    <section id="isi-nilai">
        <h2>Isi Nilai dan Honor Pelatihan</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_peserta=" . $id_peserta; ?>" method="post">
            <div class="mb-3">
                <label for="nilai" class="form-label">Nilai (1-100):</label>
                <input type="range" class="form-range" id="nilai" name="nilai" min="1" max="100" value="<?php echo $nilai; ?>" onchange="updateNilai()">
            </div>
            <div class="mb-3">
                <label for="biaya" class="form-label">Biaya Pelatihan:</label>
                <input type="text" class="form-control" id="biaya" name="biaya" value="<?php echo $biaya; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="honor_pelatihan" class="form-label">Honor Pelatihan:</label>
                <input type="text" class="form-control" id="honor_pelatihan" name="honor_pelatihan" value="<?php echo $honor_pelatihan; ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        <?php if (!empty($pesan)) { ?>
            <p><?php echo $pesan; ?></p>
        <?php } ?>
        <a href="penilaian_pelatihan.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
    </section>
</main>

<?php include 'footer.php' ?>