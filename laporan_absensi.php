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

// Query untuk mendapatkan data absensi
$query_absensi = "SELECT id_karyawan, nama, tanggal, jam_masuk, jam_keluar, keterangan, alasan
                  FROM absensi_laporan
                  WHERE MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun";

$result_absensi = mysqli_query($koneksi, $query_absensi);

if (!$result_absensi) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<main class="container mt-4">
    <section id="laporan-absensi">
        <h2>Data Absensi</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
        <br>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Keterangan</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menampilkan data absensi dalam tabel
                    while ($row = mysqli_fetch_assoc($result_absensi)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_karyawan'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['tanggal'] . "</td>";
                        echo "<td>" . $row['jam_masuk'] . "</td>";
                        echo "<td>" . $row['jam_keluar'] . "</td>";
                        echo "<td>" . $row['keterangan'] . "</td>";
                        echo "<td>" . $row['alasan'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br>
        <!-- Tombol untuk mencetak laporan -->
        <form action="cetak_laporan_absensi.php" method="post">
            <input type="hidden" name="bulan" value="<?php echo $bulan; ?>">
            <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
            <button type="submit" name="cetak" class="btn btn-success">Cetak Laporan</button>
            <a href="laporan.php" class="btn btn-secondary mt-3">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
        </form>
    </section>
</main>

<?php include 'footer.php' ?>