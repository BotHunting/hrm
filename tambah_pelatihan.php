<?php
// Mulai sesi
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

// Jika form untuk menambah data pelatihan disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    // Mendapatkan data dari form
    $nama_pelatihan = $_POST["nama_pelatihan"];
    $tanggal_mulai = $_POST["tanggal_mulai"];
    $tanggal_selesai = $_POST["tanggal_selesai"];
    $lokasi = $_POST["lokasi"];
    $durasi = $_POST["durasi"];
    $biaya = $_POST["biaya"];

    // Query untuk menambah data pelatihan ke database
    $query = "INSERT INTO pelatihan (nama_pelatihan, tanggal_mulai, tanggal_selesai, lokasi, durasi, biaya) 
              VALUES ('$nama_pelatihan', '$tanggal_mulai', '$tanggal_selesai', '$lokasi', '$durasi', '$biaya')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Set pesan notifikasi
        $_SESSION['pesan'] = "Data pelatihan berhasil ditambahkan!";
        // Redirect kembali ke halaman ini untuk menghindari resubmission form
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

?>

<main class="container mt-4">
    <!-- Formulir untuk menambah data pelatihan -->
    <section id="tambah-pelatihan">
        <h2 class="mb-4">Tambah Data Pelatihan Baru</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="nama_pelatihan" class="form-label">Nama Pelatihan:</label>
                <input type="text" id="nama_pelatihan" name="nama_pelatihan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi:</label>
                <input type="text" id="lokasi" name="lokasi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="durasi" class="form-label">Durasi (jam):</label>
                <input type="number" id="durasi" name="durasi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="biaya" class="form-label">Biaya:</label>
                <input type="number" id="biaya" name="biaya" class="form-control" required>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary me-2">Tambah Pelatihan</button>
            <a href="pelatihan.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
        </form>
        <div class="pesan mt-3"><?php echo $pesan; ?></div>
    </section>
</main>

<?php include 'footer.php' ?>