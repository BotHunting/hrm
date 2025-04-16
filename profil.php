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

// Ambil ID Karyawan berdasarkan nama pengguna yang login
$username = $_SESSION['username'];
$sql_pengguna = "SELECT id_karyawan FROM pengguna WHERE nama_pengguna = '$username'";
$result_pengguna = mysqli_query($koneksi, $sql_pengguna);
$row_pengguna = mysqli_fetch_assoc($result_pengguna);
$id_karyawan = $row_pengguna['id_karyawan'];

// Ambil data karyawan berdasarkan ID Karyawan
$sql_karyawan = "SELECT * FROM karyawan WHERE id_karyawan = '$id_karyawan'";
$result_karyawan = mysqli_query($koneksi, $sql_karyawan);
$row_karyawan = mysqli_fetch_assoc($result_karyawan);

// Ambil foto karyawan
$foto = 'assets/img/pp/' . $id_karyawan . '.jpg'; // Sesuaikan dengan path foto di folder "image"
if (!file_exists($foto)) {
    $foto = 'pp.jpg'; // Jika foto tidak ditemukan, gunakan foto default
}

// URL untuk edit karyawan dengan ID yang sesuai
$url_edit = "edit_karyawan.php?id=" . $id_karyawan;
?>

<main class="container mt-4">
    <section id="previewFoto">
        <h1 class="text-center mb-4">Profil</h1>
        <div class="card profile-card">
            <img src="<?php echo $foto; ?>" class="card-img-top img-fluid mx-auto d-block" alt="Profil Photo" style="max-width: 300px;">
            <div class="card-body">
                <h2 class="card-title">Data Karyawan</h2>
                <table class="table">
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>ID Karyawan</td>
                        <td><?php echo $row_karyawan['id_karyawan']; ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><?php echo $row_karyawan['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td><?php echo $row_karyawan['jenis_kelamin']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td><?php echo $row_karyawan['tanggal_lahir']; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?php echo $row_karyawan['alamat']; ?></td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td><?php echo $row_karyawan['telepon']; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $row_karyawan['email']; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php echo $row_karyawan['status']; ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td><?php echo $row_karyawan['jabatan']; ?></td>
                    </tr>
                    <tr>
                        <td>Gaji Harian</td>
                        <td><?php echo $row_karyawan['gaji_harian']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <a href="<?php echo $url_edit; ?>" class="btn btn-primary mt-3">Edit Profil</a>
    </section>
</main>


<?php include 'footer.php' ?>