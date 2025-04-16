<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';

// Memastikan parameter id_pengguna tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: pengguna.php");
    exit;
}

$id_pengguna = $_GET['id'];

// Memanggil fungsi untuk mendapatkan data pengguna berdasarkan id
$query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Pengguna tidak ditemukan.";
    exit;
}

$data_pengguna = mysqli_fetch_assoc($result);

// Proses hapus jika pengguna menekan tombol "Ya"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    // Query SQL untuk menghapus data pengguna
    $query_delete = "DELETE FROM pengguna WHERE id_pengguna = '$id_pengguna'";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if ($result_delete) {
        header("location: pengguna.php");
    } else {
        echo "Terjadi kesalahan saat menghapus data pengguna.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pengguna</title>
    <link rel="stylesheet" href="style.css">
    <style>
        header {
            background-color: #ffcc00;
            /* Kuning muda */
            color: #000;
            /* Hitam */
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 36px;
        }

        main {
            padding: 20px;
        }

        .confirmation {
            background-color: #ffffff;
            /* Putih */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        input[type="submit"] {
            background-color: #ff0000;
            /* Merah */
            color: #fff;
            /* Putih */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #cc0000;
            /* Merah gelap saat hover */
        }

        input[type="button"] {
            background-color: #009933;
            /* Hijau */
            color: #fff;
            /* Putih */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="button"]:hover {
            background-color: #00802b;
            /* Hijau gelap saat hover */
        }
    </style>
</head>

<body>
    <header>
        <h1>Hapus Pengguna</h1>
    </header>
    <main>
        <div class="confirmation">
            <p>Apakah Anda yakin ingin menghapus pengguna <strong><?php echo $data_pengguna['nama_pengguna']; ?></strong>?</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_pengguna; ?>" method="post">
                <input type="submit" name="confirm_delete" value="Ya">
                <input type="button" value="Tidak" onclick="window.location.href='pengguna.php';">
            </form>
        </div>
    </main>
</body>

</html>