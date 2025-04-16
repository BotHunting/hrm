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

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    // Mendapatkan data dari form
    $jabatan = $_POST["jabatan"];
    $upah = $_POST["upah"];

    // Menghitung gaji harian
    $gaji_harian = $upah / 26;

    // Query untuk menyimpan data jabatan ke database
    $query = "INSERT INTO salary (jabatan, upah, gaji_harian) VALUES ('$jabatan', '$upah', '$gaji_harian')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        $pesan = "Jabatan berhasil ditambahkan!";
    } else {
        $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Tambah Jabatan</h1>
    <section id="tambah-jabatan">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="jabatan">Jabatan:</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
            </div>
            <div class="mb-3">
                <label for="upah">Upah:</label>
                <input type="number" class="form-control" id="upah" name="upah" required>
            </div>
            <button type="submit" class="btn btn-primary" name="tambah">Tambah Jabatan</button>
        </form>
        <p><?php echo $pesan; ?></p>
        <a href="besaran_gaji.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
    </section>
</main>

<?php include 'footer.php' ?>