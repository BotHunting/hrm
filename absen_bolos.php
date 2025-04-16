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

// Mendapatkan daftar karyawan dari database
$query_daftar_karyawan = "SELECT id_karyawan, nama FROM karyawan";
$result_daftar_karyawan = mysqli_query($koneksi, $query_daftar_karyawan);

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data yang dikirimkan melalui form
    $id_karyawan = $_POST["id_karyawan"];
    $tanggal = date("Y-m-d");
    $jam_masuk = "00:00:00";
    $jam_keluar = "00:00:00";
    $keterangan = "Alpha"; // Keterangan absen "Alpha"
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
            $pesan = "Absen dengan keterangan 'Alpha' berhasil dicatat.";
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
                        <label for="id_karyawan" class="form-label">Pilih Karyawan:</label><br>
                        <select id="id_karyawan" name="id_karyawan" class="form-select" required>
                            <option value="">Pilih Karyawan</option>
                            <?php
                            // Menampilkan daftar karyawan dalam bentuk dropdown
                            while ($row = mysqli_fetch_assoc($result_daftar_karyawan)) {
                                echo "<option value='" . $row['id_karyawan'] . "'>" . $row['nama'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Alpha:</label><br>
                        <textarea id="alasan" name="alasan" rows="4" cols="50" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Absen Alpha</button>
                </form>
                <p><?php echo $pesan; ?></p>
                <a href="absensi.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php' ?>