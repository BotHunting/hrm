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

// Mendapatkan ID jabatan dari parameter URL
$id_jabatan = $_GET['id_jabatan'];

// Mendapatkan data jabatan berdasarkan ID
$query = "SELECT * FROM salary WHERE id_jabatan = '$id_jabatan'";
$result = mysqli_query($koneksi, $query);

// Memeriksa apakah query berhasil dieksekusi dan data ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    $jabatan = mysqli_fetch_assoc($result);
} else {
    // Jika data tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
    echo "Data jabatan tidak ditemukan.";
    exit; // Keluar dari script
}

// Pesan untuk notifikasi hasil proses edit
$pesan = '';

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Mendapatkan data yang diinput dari form
    $jabatan_baru = $_POST["jabatan"];
    $upah_baru = $_POST["upah"];
    $gaji_harian_baru = round($upah_baru / 26); // Menghitung gaji harian dari upah yang baru dan membulatkan hasilnya

    // Query untuk update data jabatan
    $query_update = "UPDATE salary SET jabatan = '$jabatan_baru', upah = '$upah_baru', gaji_harian = '$gaji_harian_baru' WHERE id_jabatan = '$id_jabatan'";

    // Eksekusi query update
    if (mysqli_query($koneksi, $query_update)) {
        $pesan = "Data jabatan berhasil diperbarui.";
    } else {
        $pesan = "Error: " . $query_update . "<br>" . mysqli_error($koneksi);
    }
}

// Inisialisasi variabel dengan nilai dari database
$upah = $jabatan['upah'];
$gaji_harian = $jabatan['gaji_harian'];
?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Edit Jabatan</h1>
    <section id="edit-jabatan">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_jabatan=<?php echo $id_jabatan; ?>" method="post">
            <div class="mb-3">
                <label for="jabatan">Nama Jabatan:</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $jabatan['jabatan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="upah">Upah:</label>
                <input type="number" class="form-control" id="upah" name="upah" value="<?php echo $upah; ?>" required oninput="hitungGajiHarian(this.value)">
            </div>
            <div class="mb-3">
                <label for="gaji_harian">Gaji Harian:</label>
                <input type="number" class="form-control" id="gaji_harian" name="gaji_harian" value="<?php echo $gaji_harian; ?>" required readonly>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>
            <a href="besaran_gaji.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
        </form>
        <p><?php echo $pesan; ?></p>
    </section>
</main>

<script>
    // Fungsi untuk menghitung gaji harian
    function hitungGajiHarian(upah) {
        document.getElementById("gaji_harian").value = Math.round(upah / 26);
    }
</script>

<?php include 'footer.php' ?>