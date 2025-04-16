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

// Inisialisasi variabel pesan
$pesan = '';

// Set zona waktu ke Indonesia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Ambil ID Karyawan dari sesi yang tersimpan
$username = $_SESSION['username'];
$sql_pengguna = "SELECT id_karyawan FROM pengguna WHERE nama_pengguna = '$username'";
$result_pengguna = mysqli_query($koneksi, $sql_pengguna);
$row_pengguna = mysqli_fetch_assoc($result_pengguna);
$id_karyawan = $row_pengguna['id_karyawan'];

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data yang dikirimkan melalui form
    $tanggal = date("Y-m-d");
    $jam_masuk = date("H:i:s");
    $keterangan = "Hadir"; // Keterangan default

    // Memeriksa apakah karyawan sudah absen hari ini
    $query_check_absensi = "SELECT * FROM absensi WHERE id_karyawan = '$id_karyawan' AND tanggal = '$tanggal'";
    $result_check_absensi = mysqli_query($koneksi, $query_check_absensi);

    if (mysqli_num_rows($result_check_absensi) > 0) {
        // Jika karyawan sudah absen, tampilkan pesan gagal
        $pesan = "Karyawan sudah melakukan absensi pada hari ini.";
    } else {
        // Jika karyawan belum absen, tambahkan data absensi ke dalam tabel absensi
        $query = "INSERT INTO absensi (id_karyawan, tanggal, jam_masuk, keterangan) 
                  VALUES ('$id_karyawan', '$tanggal', '$jam_masuk', '$keterangan')";

        // Eksekusi query
        if (mysqli_query($koneksi, $query)) {
            $pesan = "Absen masuk berhasil dicatat.";
        } else {
            $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    }
}
?>

<main id="main">
    <section id="form-absen" class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <label for="id_karyawan" class="form-label">ID Karyawan:</label>
                        <input type="text" id="id_karyawan" name="id_karyawan" value="<?php echo $id_karyawan; ?>" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Absen Masuk</button>
                </form>
                <p class="mt-3"><?php echo $pesan; ?></p>
                <a href="absensi.php" class="mt-3">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php' ?>