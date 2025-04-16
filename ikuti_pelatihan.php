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

// Variabel pesan untuk menampilkan pesan sukses atau kesalahan
$pesan = '';

// Jika form untuk mengikuti pelatihan disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ikut"])) {
    // Mendapatkan data dari form
    $id_pelatihan = $_POST["id_pelatihan"];
    $karyawan_terpilih = $_POST["karyawan"];

    // Mendapatkan nama pelatihan
    $query_get_nama_pelatihan = "SELECT nama_pelatihan, biaya FROM pelatihan WHERE id_pelatihan='$id_pelatihan'";
    $result_get_nama_pelatihan = mysqli_query($koneksi, $query_get_nama_pelatihan);
    $row_pelatihan = mysqli_fetch_assoc($result_get_nama_pelatihan);
    $nama_pelatihan = $row_pelatihan['nama_pelatihan'];
    $biaya = $row_pelatihan['biaya'];

    // Looping untuk setiap karyawan yang dipilih
    foreach ($karyawan_terpilih as $id_karyawan) {
        // Mendapatkan nama karyawan
        $query_get_nama_karyawan = "SELECT nama FROM karyawan WHERE id_karyawan='$id_karyawan'";
        $result_get_nama_karyawan = mysqli_query($koneksi, $query_get_nama_karyawan);
        $row_karyawan = mysqli_fetch_assoc($result_get_nama_karyawan);
        $nama_karyawan = $row_karyawan['nama'];

        // Query untuk menambahkan karyawan yang mengikuti pelatihan ke database
        $query = "INSERT INTO peserta_pelatihan (id_pelatihan, id_karyawan, nama_peserta, nama_pelatihan, biaya) 
                  VALUES ('$id_pelatihan', '$id_karyawan', '$nama_karyawan', '$nama_pelatihan', '$biaya')";

        // Eksekusi query
        if (mysqli_query($koneksi, $query)) {
            // Set pesan notifikasi
            $_SESSION['pesan'] = "Karyawan berhasil mendaftar pelatihan!";
        } else {
            $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    }

    // Redirect kembali ke halaman pelatihan
    header("Location: pelatihan.php");
    exit();
}

// Ambil id_pelatihan dari parameter URL
$id_pelatihan = $_GET['id'];

// Query untuk mendapatkan detail pelatihan berdasarkan id_pelatihan
$query_get_pelatihan = "SELECT * FROM pelatihan WHERE id_pelatihan='$id_pelatihan'";
$result_get_pelatihan = mysqli_query($koneksi, $query_get_pelatihan);

// Validasi apakah data pelatihan ditemukan
if ($result_get_pelatihan && mysqli_num_rows($result_get_pelatihan) > 0) {
    $pelatihan = mysqli_fetch_assoc($result_get_pelatihan);
} else {
    // Jika data pelatihan tidak ditemukan, redirect ke halaman pelatihan
    header("Location: pelatihan.php");
    exit();
}

// Query untuk mendapatkan daftar karyawan yang belum terdaftar pada pelatihan ini
$query_get_karyawan = "SELECT * FROM karyawan WHERE id_karyawan NOT IN 
                        (SELECT id_karyawan FROM peserta_pelatihan WHERE id_pelatihan='$id_pelatihan')";
$result_get_karyawan = mysqli_query($koneksi, $query_get_karyawan);
?>

<main class="container mt-4">
    <h1 class="text-center">Ikuti Pelatihan</h1>
    <section id="ikuti-pelatihan">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id_pelatihan" value="<?php echo $id_pelatihan; ?>">
            <div class="mb-3">
                <label for="karyawan" class="form-label">Pilih Karyawan:</label><br>
                <select id="karyawan" name="karyawan[]" multiple class="form-control" required>
                    <?php
                    // Memeriksa apakah ada karyawan yang tersedia untuk mendaftar pelatihan
                    if ($result_get_karyawan && mysqli_num_rows($result_get_karyawan) > 0) {
                        // Menampilkan opsi karyawan dalam dropdown
                        while ($row = mysqli_fetch_assoc($result_get_karyawan)) {
                            echo "<option value='" . $row['id_karyawan'] . "'>" . $row['nama'] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled selected>Tidak ada karyawan yang tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <button type="submit" name="ikut" class="btn btn-primary">Ikuti Pelatihan</button>
                <a href="pelatihan.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        <p><?php echo $pesan; ?></p>
    </section>
</main>

<?php include 'footer.php' ?>