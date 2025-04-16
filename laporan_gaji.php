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

// Query untuk mendapatkan data gaji karyawan
$query_gaji = "SELECT id_karyawan, nama, bulan, tahun, gaji_pokok, jumlah_absensi, tunjangan_kinerja, jumlah_honor, pajak_penghasilan, total_gaji
               FROM gaji_laporan
               WHERE bulan = $bulan AND tahun = $tahun";

$result_gaji = mysqli_query($koneksi, $query_gaji);

if (!$result_gaji) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Laporan Gaji Karyawan</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mb-4">
        <div class="form-row">
            <div class="col-md-3 mb-3">
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
            <div class="col-md-3 mb-3">
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
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Gaji Pokok</th>
                    <th>Jumlah Absensi</th>
                    <th>Tunjangan Kinerja (%)</th>
                    <th>Jumlah Honor</th>
                    <th>Pajak Penghasilan</th>
                    <th>Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result_gaji)) {
                    echo "<tr>";
                    echo "<td>" . $row['id_karyawan'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . date("F", mktime(0, 0, 0, $row['bulan'], 1)) . "</td>";
                    echo "<td>" . $row['tahun'] . "</td>";
                    echo "<td>Rp " . $row['gaji_pokok'] . "</td>";
                    echo "<td>" . $row['jumlah_absensi'] . "</td>";
                    echo "<td>" . $row['tunjangan_kinerja'] . "</td>";
                    echo "<td>Rp " . $row['jumlah_honor'] . "</td>";
                    echo "<td>Rp " . $row['pajak_penghasilan'] . "</td>";
                    echo "<td>Rp " . $row['total_gaji'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <form action="cetak_laporan_gaji.php" method="post">
        <input type="hidden" name="bulan" value="<?php echo $bulan; ?>">
        <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
        <button type="submit" name="cetak" class="btn btn-primary">Cetak Laporan</button>
        <a href="laporan.php" class="btn btn-secondary mt-3">Kembali</a>
    </form>

</main>

<?php include 'footer.php' ?>