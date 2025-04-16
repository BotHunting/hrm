<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';
include 'header.php';

// Array pilihan bulan dengan nilai integer
$bulan_options = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);

// Inisialisasi variabel pesan
$pesan = '';

// Periksa apakah ada pesan dalam session
if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']); // Hapus pesan dari session
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    // Mendapatkan data dari form
    $id_karyawan = $_POST["id_karyawan"];
    $nama = $_POST["nama"];
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    $penilaian_kinerja = $_POST["penilaian"];
    $saran_rekomendasi = $_POST["saran_rekomendasi"];

    // Tentukan kategori penilaian berdasarkan rentang nilai
    $kategori_penilaian = '';
    if ($penilaian_kinerja >= 81 && $penilaian_kinerja <= 100) {
        $kategori_penilaian = 'Sangat Baik';
    } elseif ($penilaian_kinerja >= 61 && $penilaian_kinerja <= 80) {
        $kategori_penilaian = 'Baik';
    } elseif ($penilaian_kinerja >= 51 && $penilaian_kinerja <= 60) {
        $kategori_penilaian = 'Cukup Baik';
    } elseif ($penilaian_kinerja >= 41 && $penilaian_kinerja <= 50) {
        $kategori_penilaian = 'Cukup Kurang';
    } elseif ($penilaian_kinerja >= 21 && $penilaian_kinerja <= 40) {
        $kategori_penilaian = 'Kurang';
    } elseif ($penilaian_kinerja >= 1 && $penilaian_kinerja <= 20) {
        $kategori_penilaian = 'Sangat Kurang';
    }

    // Query untuk memeriksa apakah data sudah ada untuk bulan dan tahun yang sama di tabel kinerja
    $query_check_existing_kinerja = "SELECT * FROM kinerja WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
    $result_check_existing_kinerja = mysqli_query($koneksi, $query_check_existing_kinerja);

    if ($result_check_existing_kinerja && mysqli_num_rows($result_check_existing_kinerja) > 0) {
        // Jika data sudah ada, lakukan pembaruan
        $query_update_kinerja = "UPDATE kinerja SET penilaian = '$penilaian_kinerja', kategori_penilaian = '$kategori_penilaian' WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
        if (mysqli_query($koneksi, $query_update_kinerja)) {
            $_SESSION['pesan'] = "Penilaian kinerja berhasil diperbarui!";
        } else {
            $pesan = "Error: " . mysqli_error($koneksi);
        }
    } else {
        // Jika data belum ada, lakukan penyisipan baru di tabel kinerja
        // Query untuk menambahkan penilaian kinerja ke tabel kinerja
        $query_kinerja = "INSERT INTO kinerja (id_karyawan, bulan, tahun, penilaian, kategori_penilaian) 
                          VALUES ('$id_karyawan', '$bulan', '$tahun', '$penilaian_kinerja', '$kategori_penilaian')";

        if (mysqli_query($koneksi, $query_kinerja)) {
            $_SESSION['pesan'] = "Penilaian kinerja berhasil ditambahkan!";
        } else {
            $pesan = "Error: " . mysqli_error($koneksi);
        }
    }

    // Query untuk memeriksa apakah data sudah ada untuk bulan, tahun, dan id_karyawan yang sama di tabel kinerja_laporan
    $query_check_existing_kinerja_laporan = "SELECT * FROM kinerja_laporan WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
    $result_check_existing_kinerja_laporan = mysqli_query($koneksi, $query_check_existing_kinerja_laporan);

    if ($result_check_existing_kinerja_laporan && mysqli_num_rows($result_check_existing_kinerja_laporan) > 0) {
        // Jika data sudah ada, lakukan pembaruan
        $row = mysqli_fetch_assoc($result_check_existing_kinerja_laporan);
        $id_kinerja = $row['id_kinerja']; // ID kinerja yang sudah ada

        // Query untuk memperbarui nilai penilaian dan saran/rekomendasi di tabel kinerja_laporan
        $query_update_kinerja_laporan = "UPDATE kinerja_laporan SET penilaian = '$penilaian_kinerja', kategori_penilaian = '$kategori_penilaian', saran_rekomendasi = '$saran_rekomendasi' WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
        if (mysqli_query($koneksi, $query_update_kinerja_laporan)) {
            $_SESSION['pesan'] = "Penilaian kinerja berhasil diperbarui!";
        } else {
            $pesan = "Error: " . mysqli_error($koneksi);
        }
    } else {
        // Jika data belum ada, lakukan penyisipan baru di tabel kinerja_laporan
        // Query untuk menambahkan penilaian kinerja ke tabel kinerja_laporan
        $query_kinerja_laporan = "INSERT INTO kinerja_laporan (id_karyawan, nama, bulan, tahun, penilaian, kategori_penilaian, saran_rekomendasi) 
                                  VALUES ('$id_karyawan', '$nama', '$bulan', '$tahun', '$penilaian_kinerja', '$kategori_penilaian', '$saran_rekomendasi')";

        if (mysqli_query($koneksi, $query_kinerja_laporan)) {
            $_SESSION['pesan'] = "Penilaian kinerja berhasil ditambahkan!";
        } else {
            $pesan = "Error: " . mysqli_error($koneksi);
        }
    }

    // Redirect ke halaman ini sendiri untuk menghilangkan pesan query dalam URL
    header("Location: tambah_kinerja.php");
    exit();
}
?>

<main class="container mt-4">
    <section id="tambah-penilaian">
        <h2 class="mb-4">Tambah Penilaian Kinerja Baru</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="id_karyawan" class="form-label">ID Karyawan:</label>
                <select id="id_karyawan" name="id_karyawan" onchange="fetchNama()" class="form-select" required>
                    <?php
                    // Query untuk mendapatkan daftar karyawan
                    $query_get_karyawan = "SELECT id_karyawan, nama FROM karyawan";
                    $result_get_karyawan = mysqli_query($koneksi, $query_get_karyawan);

                    // Memeriksa apakah query berhasil dieksekusi
                    if ($result_get_karyawan && mysqli_num_rows($result_get_karyawan) > 0) {
                        // Menampilkan opsi karyawan dalam dropdown
                        while ($row = mysqli_fetch_assoc($result_get_karyawan)) {
                            echo "<option value='" . $row['id_karyawan'] . "'>" . $row['id_karyawan'] . " - " . $row['nama'] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled selected>Tidak ada karyawan</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="bulan" class="form-label">Bulan:</label>
                <select id="bulan" name="bulan" class="form-select" required>
                    <?php
                    // Menampilkan pilihan bulan dalam dropdown
                    foreach ($bulan_options as $bulan_number => $bulan_name) {
                        echo "<option value='$bulan_number'>$bulan_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun:</label>
                <input type="number" id="tahun" name="tahun" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="penilaian" class="form-label">Penilaian Kinerja:</label>
                <input type="range" id="penilaian" name="penilaian" min="1" max="100" value="50" required class="form-range">
            </div>
            <div class="mb-3">
                <label for="saran_rekomendasi" class="form-label">Saran dan Rekomendasi:</label>
                <textarea id="saran_rekomendasi" name="saran_rekomendasi" class="form-control" required></textarea>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary me-2">Tambah Penilaian Kinerja</button>
            <a href="kinerja.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
        </form>
        <p class="mt-3"><?php echo $pesan; ?></p>
    </section>
</main>

<script>
    function fetchNama() {
        var idKaryawan = document.getElementById('id_karyawan').value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('nama').value = this.responseText;
            }
        };
        xhttp.open("GET", "get_nama.php?id_karyawan=" + idKaryawan, true);
        xhttp.send();
    }
</script>
<?php include 'footer.php' ?>