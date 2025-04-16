<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';
include 'navbar.php';

// Inisialisasi variabel bulan dan tahun dengan nilai default (bulan dan tahun saat ini)
$bulan = date('m');
$tahun = date('Y');

// Memeriksa apakah form untuk memilih bulan dan tahun disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
}

// Query untuk mendapatkan data absensi
$query = "SELECT absensi_laporan.id_karyawan, karyawan.nama,
                 SUM(CASE WHEN absensi_laporan.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
                 SUM(CASE WHEN absensi_laporan.keterangan = 'Izin' THEN 1 ELSE 0 END) AS izin,
                 SUM(CASE WHEN absensi_laporan.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
                 SUM(CASE WHEN absensi_laporan.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS alpha
          FROM absensi_laporan
          JOIN karyawan ON absensi_laporan.id_karyawan = karyawan.id_karyawan
          WHERE MONTH(absensi_laporan.tanggal) = $bulan AND YEAR(absensi_laporan.tanggal) = $tahun
          GROUP BY absensi_laporan.id_karyawan";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi Karyawan</title>
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Laporan Absensi Karyawan</h1>
    </header>
    <main>
        <section id="laporan-absensi">
            <h2>Data Absensi</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="bulan">Pilih Bulan:</label>
                <select id="bulan" name="bulan">
                    <?php
                    // Menampilkan pilihan bulan
                    for ($i = 1; $i <= 12; $i++) {
                        $selected = ($i == $bulan) ? "selected" : "";
                        echo "<option value='$i' $selected>" . date("F", mktime(0, 0, 0, $i, 1)) . "</option>";
                    }
                    ?>
                </select>

                <label for="tahun">Pilih Tahun:</label>
                <select id="tahun" name="tahun">
                    <?php
                    // Menampilkan pilihan tahun dari tahun sekarang hingga 10 tahun ke belakang
                    $tahun_sekarang = date("Y");
                    for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 10; $i--) {
                        $selected = ($i == $tahun) ? "selected" : "";
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>

                <button type="submit">Tampilkan</button>
            </form>
            <br>
            <table>
                <tr>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                </tr>
                <?php
                // Menampilkan data absensi dalam tabel
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id_karyawan'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['hadir'] . "</td>";
                    echo "<td>" . $row['izin'] . "</td>";
                    echo "<td>" . $row['sakit'] . "</td>";
                    echo "<td>" . $row['alpha'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>
    </main>
</body>

</html>