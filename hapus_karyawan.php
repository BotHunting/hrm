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

// Variabel pesan untuk menampilkan pesan sukses atau kesalahan
$pesan = '';

// Jika terdapat parameter id dalam URL
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Mendapatkan data karyawan berdasarkan ID
    $query_get_karyawan = "SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan'";
    $result_get_karyawan = mysqli_query($koneksi, $query_get_karyawan);

    // Jika data karyawan ditemukan
    if ($result_get_karyawan && mysqli_num_rows($result_get_karyawan) > 0) {
        $karyawan = mysqli_fetch_assoc($result_get_karyawan);
    } else {
        $pesan = "Data karyawan tidak ditemukan!";
    }

    // Jika form disubmit dengan konfirmasi penghapusan
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hapus"])) {
        $query_hapus = "DELETE FROM karyawan WHERE id_karyawan='$id_karyawan'";
        if (mysqli_query($koneksi, $query_hapus)) {
            $_SESSION['pesan'] = "Karyawan dengan ID $id_karyawan berhasil dihapus!";
            header("Location: karyawan.php");
            exit();
        } else {
            $pesan = "Gagal menghapus karyawan: " . mysqli_error($koneksi);
        }
    }
} else {
    $pesan = "Parameter ID tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Karyawan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Gaya CSS Anda */
        header {
            background-color: #FFD700;
            /* Kuning emas */
            color: #000;
            /* Hitam */
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <h1>Hapus Karyawan</h1>
    </header>
    <main>
        <section id="hapus-karyawan">
            <h2>Apakah Anda yakin ingin menghapus karyawan berikut?</h2>
            <p>Nama: <?php echo $karyawan['nama']; ?></p>
            <p>Jenis Kelamin: <?php echo $karyawan['jenis_kelamin']; ?></p>
            <p>Tanggal Lahir: <?php echo $karyawan['tanggal_lahir']; ?></p>
            <p>Alamat: <?php echo $karyawan['alamat']; ?></p>
            <p>Telepon: <?php echo $karyawan['telepon']; ?></p>
            <p>Email: <?php echo $karyawan['email']; ?></p>
            <p>Status: <?php echo $karyawan['status']; ?></p>
            <p>Jabatan: <?php echo $karyawan['jabatan']; ?></p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_karyawan; ?>" method="post">
                <button type="submit" name="hapus">Ya</button>
                <a href="karyawan.php">Tidak</a>
            </form>
            <p><?php echo $pesan; ?></p>
        </section>
    </main>
</body>

</html>