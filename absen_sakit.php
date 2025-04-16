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
    $jam_masuk = "00:00:00";
    $jam_keluar = "00:00:00";
    $keterangan = "Sakit"; // Keterangan absen "Sakit"
    $alasan = $_POST["alasan"];

    // Memeriksa apakah karyawan sudah absen hari ini
    $query_check_absensi = "SELECT * FROM absensi WHERE id_karyawan = '$id_karyawan' AND tanggal = '$tanggal'";
    $result_check_absensi = mysqli_query($koneksi, $query_check_absensi);

    if (mysqli_num_rows($result_check_absensi) > 0) {
        // Jika karyawan sudah absen hari ini, tampilkan pesan gagal
        $pesan = "Karyawan sudah melakukan absensi pada hari ini.";
    } else {
        // Jika karyawan belum absen hari ini, tambahkan data absensi ke dalam tabel absensi dan absensi_laporan
        $query_tambah_absen = "INSERT INTO absensi (id_karyawan, tanggal, jam_masuk, jam_keluar, keterangan) 
                               VALUES ('$id_karyawan', '$tanggal', '$jam_masuk', '$jam_keluar', '$keterangan')";
        $query_tambah_laporan = "INSERT INTO absensi_laporan (id_karyawan, nama, tanggal, jam_masuk, jam_keluar, keterangan, alasan) 
                                 VALUES ('$id_karyawan', (SELECT nama FROM karyawan WHERE id_karyawan = '$id_karyawan'), '$tanggal', 
                                         '$jam_masuk', '$jam_keluar', '$keterangan', '$alasan')";

        // Eksekusi query
        if (mysqli_query($koneksi, $query_tambah_absen) && mysqli_query($koneksi, $query_tambah_laporan)) {
            $pesan = "Absen dengan keterangan 'Sakit' berhasil dicatat.";
        } else {
            $pesan = "Error: " . $query_tambah_absen . "<br>" . mysqli_error($koneksi);
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
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Sakit:</label>
                        <textarea id="alasan" name="alasan" rows="4" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Absen Sakit</button>
                </form>
                <p class="mt-3"><?php echo $pesan; ?></p>
                <a href="absensi.php" class="mt-3">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php' ?>