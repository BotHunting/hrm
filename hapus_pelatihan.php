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

// Mulai sesi
session_start();

// Variabel pesan untuk menampilkan pesan sukses atau kesalahan
$pesan = '';

// Jika parameter id_pelatihan diberikan dalam URL dan pengguna mengonfirmasi penghapusan
if (isset($_GET['id']) && isset($_GET['confirm'])) {
    $id_pelatihan = $_GET['id'];

    // Query untuk menghapus pelatihan dari database
    $query = "DELETE FROM pelatihan WHERE id_pelatihan='$id_pelatihan'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Set pesan notifikasi
        $_SESSION['pesan'] = "Pelatihan berhasil dihapus!";
        // Redirect kembali ke halaman pelatihan
        header("Location: pelatihan.php");
        exit();
    } else {
        $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Jika parameter id_pelatihan diberikan dalam URL tetapi pengguna belum mengonfirmasi penghapusan
if (isset($_GET['id'])) {
    $id_pelatihan = $_GET['id'];
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
} else {
    // Jika parameter id_pelatihan tidak diberikan dalam URL, redirect ke halaman pelatihan
    header("Location: pelatihan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pelatihan</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Hapus Pelatihan</h1>
    </header>
    <main>
        <section>
            <p>Apakah Anda yakin ingin menghapus pelatihan "<?php echo $pelatihan['nama_pelatihan']; ?>"?</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                <input type="hidden" name="id" value="<?php echo $id_pelatihan; ?>">
                <button type="submit" name="confirm">Ya</button>
                <a href="pelatihan.php" class="btn">Tidak</a>
            </form>
        </section>
    </main>
</body>

</html>