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

// Inisialisasi pesan kesalahan
$pesan = '';

// Ambil data karyawan dari database
$sql_karyawan = "SELECT id_karyawan FROM karyawan";
$result_karyawan = mysqli_query($koneksi, $sql_karyawan);

// Proses tambah pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_karyawan = $_POST['id_karyawan'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $password = $_POST['password'];
    $jabatan = $_POST['jabatan'];

    // Panggil fungsi tambah pengguna
    $hasil_tambah = tambahPengguna($id_karyawan, $nama_pengguna, $password, $jabatan);

    if ($hasil_tambah) {
        $pesan = "Pengguna berhasil ditambahkan.";
    } else {
        $pesan = "Gagal menambahkan pengguna. Silakan coba lagi.";
    }
}

// Fungsi untuk menambah pengguna ke database
function tambahPengguna($id_karyawan, $nama_pengguna, $password, $jabatan)
{
    global $koneksi;

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query SQL untuk menambah pengguna
    $sql = "INSERT INTO pengguna (id_karyawan, nama_pengguna, password, jabatan) VALUES ('$id_karyawan', '$nama_pengguna', '$hashed_password', '$jabatan')";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        return true;
    } else {
        return false;
    }
}
?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Tambah Pengguna</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="row g-3">
        <div class="col-md-6">
            <label for="id_karyawan" class="form-label">ID Karyawan:</label>
            <select id="id_karyawan" name="id_karyawan" class="form-select" required>
                <?php
                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result_karyawan)) {
                    echo "<option value='" . $row['id_karyawan'] . "'>" . $row['id_karyawan'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="nama_pengguna" class="form-label">Nama Pengguna:</label>
            <input type="text" id="nama_pengguna" name="nama_pengguna" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="jabatan" class="form-label">Jabatan:</label>
            <select id="jabatan" name="jabatan" class="form-select" required>
                <option value="karyawan">Karyawan</option>
                <option value="admin">Admin</option>
                <option value="ceo">CEO</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
            <a href="pengguna.php" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
    <p class="pesan"><?php echo $pesan; ?></p>
</main>

<?php include 'footer.php' ?>