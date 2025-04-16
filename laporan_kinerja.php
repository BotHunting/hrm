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

// Inisialisasi variabel bulan dan tahun dengan nilai default (bulan dan tahun saat ini)
$bulan = date('m');
$tahun = date('Y');

// Memeriksa apakah form untuk memilih bulan dan tahun disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
}

// Query untuk mendapatkan data kinerja karyawan
$query_kinerja = "SELECT id_karyawan, nama, bulan, tahun, penilaian, kategori_penilaian, saran_rekomendasi
                  FROM kinerja_laporan
                  WHERE bulan = $bulan AND tahun = $tahun";

$result_kinerja = mysqli_query($koneksi, $query_kinerja);

if (!$result_kinerja) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<main class="container mt-4">
    <section id="laporan-kinerja">
        <h1 class="text-center">Laporan Kinerja Karyawan</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bulan">Pilih Bulan:</label>
                        <select id="bulan" name="bulan" class="form-control">
                            <?php
                            // Menampilkan pilihan bulan
                            for ($i = 1; $i <= 12; $i++) {
                                $selected = ($i == $bulan) ? "selected" : "";
                                echo "<option value='$i' $selected>" . date("F", mktime(0, 0, 0, $i, 1)) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tahun">Pilih Tahun:</label>
                        <select id="tahun" name="tahun" class="form-control">
                            <?php
                            // Menampilkan pilihan tahun dari tahun sekarang hingga 10 tahun ke belakang
                            $tahun_sekarang = date("Y");
                            for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 10; $i--) {
                                $selected = ($i == $tahun) ? "selected" : "";
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Penilaian</th>
                        <th>Kategori Penilaian</th>
                        <th>Saran dan Rekomendasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menampilkan data kinerja dalam tabel
                    while ($row = mysqli_fetch_assoc($result_kinerja)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_karyawan'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . date("F", mktime(0, 0, 0, $row['bulan'], 1)) . "</td>";
                        echo "<td>" . $row['tahun'] . "</td>";
                        echo "<td>" . $row['penilaian'] . "</td>";
                        echo "<td>" . $row['kategori_penilaian'] . "</td>";
                        echo "<td>" . $row['saran_rekomendasi'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br>
        <!-- Tombol untuk mencetak laporan -->
        <form action="cetak_laporan_kinerja.php" method="post" class="mb-4">
            <input type="hidden" name="bulan" value="<?php echo $bulan; ?>">
            <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
            <button type="submit" name="cetak" class="btn btn-success">Cetak Laporan</button>
        </form>
        <a href="laporan.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
    </section>
</main>

<?php include 'footer.php' ?>