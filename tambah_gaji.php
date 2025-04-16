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

// Mendapatkan daftar karyawan untuk pilihan id karyawan
$query_karyawan = "SELECT karyawan.id_karyawan, karyawan.nama, karyawan.jabatan, salary.gaji_harian FROM karyawan LEFT OUTER JOIN salary ON salary.jabatan = karyawan.jabatan";
$result_karyawan = mysqli_query($koneksi, $query_karyawan);

// Array pilihan bulan dengan nilai integer
$bulan_options = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);

// Inisialisasi variabel untuk menyimpan data gaji
$id_karyawan = '';
$bulan = '';
$tahun = date('Y'); // Tahun saat ini
$gaji_pokok = '';
$jumlah_absensi = '';
$tunjangan_kinerja = '';
$jumlah_honor = '';

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    // Mendapatkan data dari form
    $id_karyawan = $_POST["id_karyawan"];
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    $gaji_pokok = $_POST["gaji_pokok"];
    $jumlah_absensi = $_POST["jumlah_absensi"];
    $tunjangan_kinerja = $_POST["tunjangan_kinerja"];
    $jumlah_honor = $_POST["jumlah_honor"];

    // Menghitung pajak penghasilan (2.5% dari jumlah gaji)
    $pajak_penghasilan = $gaji_pokok * 0.025;

    // Menghitung total gaji
    $total_gaji = ($gaji_pokok * $jumlah_absensi) + (($tunjangan_kinerja / 100) * 520000) + $jumlah_honor - $pajak_penghasilan;

    // Query untuk mendapatkan nama karyawan
    $query_nama = "SELECT nama FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result_nama = mysqli_query($koneksi, $query_nama);
    $row_nama = mysqli_fetch_assoc($result_nama);
    $nama = $row_nama['nama'];

    // Cek apakah data sudah ada di tabel gaji_laporan berdasarkan bulan dan tahun
    $query_check = "SELECT * FROM gaji_laporan WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
    $result_check = mysqli_query($koneksi, $query_check);
    if (mysqli_num_rows($result_check) > 0) {
        // Jika sudah ada, update data di tabel gaji_laporan
        $query_update = "UPDATE gaji_laporan SET gaji_pokok = '$gaji_pokok', jumlah_absensi = '$jumlah_absensi', tunjangan_kinerja = '$tunjangan_kinerja', jumlah_honor = '$jumlah_honor', total_gaji = '$total_gaji' WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
        if (mysqli_query($koneksi, $query_update)) {
            $pesan = "Data gaji berhasil diperbarui!";
        } else {
            $pesan = "Error: " . $query_update . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Jika belum ada, tambahkan data baru di tabel gaji dan gaji_laporan
        $query_gaji = "INSERT INTO gaji (id_karyawan, nama, bulan, tahun, gaji_pokok, jumlah_absensi, tunjangan_kinerja, jumlah_honor, pajak_penghasilan, total_gaji) 
                      VALUES ('$id_karyawan', '$nama', '$bulan', '$tahun', '$gaji_pokok', '$jumlah_absensi', '$tunjangan_kinerja', '$jumlah_honor', '$pajak_penghasilan', '$total_gaji')";

        $query_gaji_laporan = "INSERT INTO gaji_laporan (id_karyawan, nama, bulan, tahun, gaji_pokok, jumlah_absensi, tunjangan_kinerja, jumlah_honor, pajak_penghasilan, total_gaji) 
                               VALUES ('$id_karyawan', '$nama', '$bulan', '$tahun', '$gaji_pokok', '$jumlah_absensi', '$tunjangan_kinerja', '$jumlah_honor', '$pajak_penghasilan', '$total_gaji')";

        if (mysqli_query($koneksi, $query_gaji) && mysqli_query($koneksi, $query_gaji_laporan)) {
            $pesan = "Data gaji berhasil ditambahkan!";
        } else {
            $pesan = "Error: " . $query_gaji . "<br>" . mysqli_error($koneksi);
        }
    }
}
?>

<main class="container mt-4">
    <section id="tambah-gaji" class="mt-4">
    <h1 class="text-center">Tambah Data Gaji Baru</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="mb-3">
                        <label for="id_karyawan">Pilih ID Karyawan:</label>
                        <select id="id_karyawan" name="id_karyawan" onchange="getSalary(this.value);" class="form-control">
                            <option value="">Pilih ID Karyawan</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_karyawan)) {
                                echo "<option value='" . $row['id_karyawan'] . "'>" . $row['id_karyawan'] . " - " . $row['nama'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulan">Pilih Bulan:</label>
                        <select id="bulan" name="bulan" onchange="getPerformance(this.value);" class="form-control" required>
                            <?php
                            foreach ($bulan_options as $key => $bulan_name) {
                                echo "<option value='$key'>$bulan_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun">Tahun:</label>
                        <input type="text" id="tahun" name="tahun" value="<?php echo $tahun; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="gaji_pokok">Gaji Pokok:</label>
                        <input type="number" id="gaji_pokok" name="gaji_pokok" readonly class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_absensi">Jumlah Absensi:</label>
                        <input type="number" id="jumlah_absensi" name="jumlah_absensi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tunjangan_kinerja">Tunjangan Kinerja (%):</label>
                        <input type="number" id="tunjangan_kinerja" name="tunjangan_kinerja" readonly class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_honor">Honor Pelatihan:</label>
                        <input type="number" id="jumlah_honor" name="jumlah_honor" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah Data Gaji</button>
                        <a href="gaji.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
                <p class="mt-3"><?php echo $pesan; ?></p>
            </div>
        </div>
    </section>
</main>

<script>
    // Fungsi untuk mengambil data gaji pokok berdasarkan id karyawan
    function getSalary(id_karyawan) {
        if (id_karyawan) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_salary.php?id_karyawan=" + id_karyawan, true);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    document.getElementById("gaji_pokok").value = response.gaji_harian;
                }
            };
            xhr.send();
        } else {
            document.getElementById("gaji_pokok").value = "";
        }
    }

    // Fungsi untuk mengambil data penilaian kinerja berdasarkan bulan
    function getPerformance(bulan) {
        var id_karyawan = document.getElementById("id_karyawan").value;
        if (id_karyawan && bulan) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_performance.php?id_karyawan=" + id_karyawan + "&bulan=" + bulan, true);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    document.getElementById("tunjangan_kinerja").value = response.penilaian;
                }
            };
            xhr.send();
        } else {
            document.getElementById("tunjangan_kinerja").value = "";
        }
    }
</script>

<?php include 'footer.php' ?>