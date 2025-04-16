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

// Jika form untuk mengedit data pelatihan disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    // Mendapatkan data dari form
    $id_pelatihan = $_POST["id_pelatihan"];
    $nama_pelatihan = $_POST["nama_pelatihan"];
    $tanggal_mulai = $_POST["tanggal_mulai"];
    $tanggal_selesai = $_POST["tanggal_selesai"];
    $lokasi = $_POST["lokasi"];
    $durasi = $_POST["durasi"];
    $biaya = $_POST["biaya"];

    // Query untuk mengupdate data pelatihan di database
    $query = "UPDATE pelatihan 
              SET nama_pelatihan='$nama_pelatihan', tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai', 
                  lokasi='$lokasi', durasi='$durasi', biaya='$biaya' 
              WHERE id_pelatihan='$id_pelatihan'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Set pesan notifikasi
        $_SESSION['pesan'] = "Data pelatihan berhasil diupdate!";
        // Redirect kembali ke halaman pelatihan
        header("Location: pelatihan.php");
        exit();
    } else {
        $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Ambil id_pelatihan dari parameter URL
$id_pelatihan = $_GET['id'];

// Query untuk mendapatkan detail pelatihan berdasarkan id_pelatihan
$query_get_pelatihan = "SELECT * FROM pelatihan WHERE id_pelatihan='$id_pelatihan'";
$result_get_pelatihan = mysqli_query($koneksi, $query_get_pelatihan);

// Validasi apakah data pelatihan ditemukan
if ($result_get_pelatihan && mysqli_num_rows($result_get_pelatihan) > 0) {
    $pelatihan = mysqli_fetch_assoc($result_get_pelatihan);
} else {
    // Jika data pelatihan tidak ditemukan, redirect ke halaman pelatihan
    header("Location: pelatihan.php");
    exit();
}
?>

<main class="container mt-4">
    <h1 class="text-center">Edit Pelatihan</h1>
    <section id="edit-pelatihan">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id_pelatihan" value="<?php echo $pelatihan['id_pelatihan']; ?>">
            <div class="mb-3">
                <label for="nama_pelatihan" class="form-label">Nama Pelatihan:</label>
                <input type="text" id="nama_pelatihan" name="nama_pelatihan" value="<?php echo $pelatihan['nama_pelatihan']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $pelatihan['tanggal_mulai']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $pelatihan['tanggal_selesai']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi:</label>
                <input type="text" id="lokasi" name="lokasi" value="<?php echo $pelatihan['lokasi']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="durasi" class="form-label">Durasi (jam):</label>
                <input type="number" id="durasi" name="durasi" value="<?php echo $pelatihan['durasi']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="biaya" class="form-label">Biaya:</label>
                <input type="text" id="biaya" name="biaya" value="<?php echo $pelatihan['biaya']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="pelatihan.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        <p><?php echo $pesan; ?></p>
    </section>
</main>


<?php include 'footer.php' ?>