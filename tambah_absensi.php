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

// Jika form untuk menambah data absensi disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    // Mendapatkan data dari form
    $id_karyawan = $_POST["id_karyawan"];
    $tanggal = $_POST["tanggal"];
    $jam_masuk = $_POST["jam_masuk"];
    $jam_keluar = $_POST["jam_keluar"];
    $keterangan = $_POST["keterangan"];

    // Query untuk mendapatkan nama karyawan berdasarkan ID karyawan
    $query_get_nama = "SELECT nama FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result_get_nama = mysqli_query($koneksi, $query_get_nama);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result_get_nama && mysqli_num_rows($result_get_nama) > 0) {
        $row = mysqli_fetch_assoc($result_get_nama);
        $nama = $row['nama'];

        // Query untuk menambah data absensi ke database
        $query = "INSERT INTO absensi (id_karyawan, nama, tanggal, jam_masuk, jam_keluar, keterangan) 
                  VALUES ('$id_karyawan', '$nama', '$tanggal', '$jam_masuk', '$jam_keluar', '$keterangan')";

        // Eksekusi query
        if (mysqli_query($koneksi, $query)) {
            // Set pesan notifikasi
            $_SESSION['pesan'] = "Data absensi berhasil ditambahkan!";
            // Redirect kembali ke halaman absensi.php
            header("Location: absensi.php");
            exit();
        } else {
            $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    } else {
        $pesan = "Error: Tidak dapat mengambil nama karyawan.";
    }
}
?>

<main id="main">
    <section id="tambah-absensi" class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Tambah Data Absensi Baru</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <label for="id_karyawan" class="form-label">ID Karyawan:</label>
                        <select id="id_karyawan" name="id_karyawan" class="form-select" required onchange="fetchNama()">
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
                        <input type="text" id="nama" name="nama" class="form-control" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal:</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jam_masuk" class="form-label">Jam Masuk:</label>
                        <input type="time" id="jam_masuk" name="jam_masuk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jam_keluar" class="form-label">Jam Keluar:</label>
                        <input type="time" id="jam_keluar" name="jam_keluar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan:</label>
                        <select id="keterangan" name="keterangan" class="form-select" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah Absensi</button>
                    <a href="absen_bolos.php" class="btn btn-secondary">Bolos</a> <!-- Tautan untuk menuju absen_bolos.php -->
                    <a href="absensi.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
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