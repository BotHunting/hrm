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

// Inisialisasi pesan
$pesan = '';

// Periksa apakah ID Karyawan telah disediakan melalui parameter URL
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Ambil informasi pengguna berdasarkan ID Karyawan
    $pengguna = getPenggunaById($id_karyawan);

    // Periksa apakah pengguna ditemukan
    if ($pengguna) {
        // Simpan data lama
        $nama_pengguna_lama = $pengguna['nama_pengguna'];
        $jabatan_lama = $pengguna['jabatan'];

        // Form telah disubmit, perbarui informasi pengguna jika ada perubahan
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama_pengguna = $_POST['nama_pengguna'];
            $password = $_POST['password'];
            $jabatan = $_POST['jabatan'];

            // Periksa apakah ada perubahan data
            if ($nama_pengguna !== $nama_pengguna_lama || $jabatan !== $jabatan_lama) {
                // Panggil fungsi untuk memperbarui informasi pengguna
                $hasil_update = updatePengguna($id_karyawan, $nama_pengguna, $password, $jabatan);

                if ($hasil_update) {
                    $pesan = "Informasi pengguna berhasil diperbarui.";
                } else {
                    $pesan = "Gagal memperbarui informasi pengguna. Silakan coba lagi.";
                }
            } else {
                // Tidak ada perubahan data, gunakan data lama
                $pesan = "Tidak ada perubahan data yang dilakukan.";
            }
        }
    } else {
        // Jika pengguna tidak ditemukan, tampilkan pesan kesalahan
        $pesan = "Pengguna tidak ditemukan.";
    }
} else {
    // Jika parameter ID Karyawan tidak diberikan, tampilkan pesan kesalahan
    $pesan = "Parameter ID Karyawan tidak diberikan.";
}

?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Edit Pengguna</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_karyawan; ?>" method="post">
        <div class="mb-3">
            <label for="id_karyawan" class="form-label">ID Karyawan:</label>
            <input type="text" id="id_karyawan" name="id_karyawan" value="<?php echo $pengguna['id_karyawan']; ?>" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="nama_pengguna" class="form-label">Nama Pengguna:</label>
            <input type="text" id="nama_pengguna" name="nama_pengguna" value="<?php echo $pengguna['nama_pengguna']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan:</label>
            <select id="jabatan" name="jabatan" class="form-select" required>
                <option value="karyawan" <?php if ($pengguna['jabatan'] === 'karyawan') echo 'selected'; ?>>Karyawan</option>
                <option value="admin" <?php if ($pengguna['jabatan'] === 'admin') echo 'selected'; ?>>Admin</option>
                <option value="ceo" <?php if ($pengguna['jabatan'] === 'ceo') echo 'selected'; ?>>CEO</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="pengguna.php" class="btn btn-secondary">Kembali</a>
    </form>
    <p class="pesan"><?php echo $pesan; ?></p>
</main>

<?php include 'footer.php' ?>