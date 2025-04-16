<?php
session_start();

// Inisialisasi pesan error
$pesan_error = '';

// Cek apakah pengguna sudah login, jika ya, redirect ke halaman utama
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("location: index.php");
    exit;
}

// Include file koneksi database
include 'koneksi.php';

// Proses login ketika form login disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form input
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query SQL untuk mencari pengguna berdasarkan username
    $query = "SELECT * FROM pengguna WHERE nama_pengguna = '$username'";
    $result = mysqli_query($koneksi, $query);

    // Cek apakah pengguna ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data pengguna dari hasil query
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Password benar, buat session dan redirect ke halaman utama
            $_SESSION["logged_in"] = true;
            $_SESSION["id_pengguna"] = $row['id_pengguna'];
            $_SESSION["username"] = $row['nama_pengguna'];
            $_SESSION["jabatan"] = $row['jabatan'];
            header("location: index.php");
            exit;
        } else {
            // Password salah
            $pesan_error = "Password yang Anda masukkan salah.";
        }
    } else {
        // Pengguna tidak ditemukan
        $pesan_error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ffcc00;
            color: #000;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 36px;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            width: auto;
            background-color: #ffcc00;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #ffd700;
        }

        .error {
            color: red;
        }

        footer {
            color: #000;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <h1>CV. Saksana Antakara</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($pesan_error)) : ?>
            <p class="error"><?php echo $pesan_error; ?></p>
        <?php endif; ?>
    </main>

    <!-- Animasi JavaScript -->
    <script>
        const header = document.querySelector('header');
        const logo = document.createElement('img');
        logo.src = 'assets/img/logo.gif'; // Ganti dengan nama file logo perusahaan
        logo.alt = 'Logo Perusahaan';
        logo.style.width = '150px'; // Sesuaikan ukuran logo
        logo.style.marginBottom = '10px'; // Sesuaikan jarak antara logo dan judul
        header.insertBefore(logo, header.childNodes[0]);
    </script>
</body>
<footer>
    <p>&copy; <?php echo date("Y"); ?> SIM HRM. Bot Hunting Company Limited.</p>
    <script type='text/javascript' src='https://assets.trakteer.id/js/trbtn-overlay.min.js'></script>
    <script type='text/javascript' class='troverlay'>
        (function() {
            var trbtnId = trbtnOverlay.init('Support Me', '#FFC147', 'https://trakteer.id/hunty/tip/embed/modal', 'https://cdn.trakteer.id/images/embed/trbtn-icon.png?date=18-11-2023', '35', 'floating-right');
            trbtnOverlay.draw(trbtnId);
        })();
    </script>
</footer>

</html>