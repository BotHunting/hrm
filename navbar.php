<?php
// Tentukan judul berdasarkan halaman yang dibuka
$page_titles = array(
    "karyawan.php" => "Karyawan",
    "absensi.php" => "Absensi",
    "kinerja.php" => "Kinerja",
    "pelatihan.php" => "Pelatihan",
    "gaji.php" => "Penggajian",
    "laporan.php" => "Pelaporan",
    "pengguna.php" => "Pengguna",
    "profil.php" => "Profil",
    "logout.php" => "Logout"
);

// Dapatkan nama halaman saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Cek jabatan pengguna untuk menentukan tab yang akan ditampilkan
$allowed_tabs = array();
switch ($_SESSION["jabatan"]) {
    case "karyawan":
        $allowed_tabs = array("absensi.php", "kinerja.php", "pelatihan.php", "profil.php", "logout.php");
        break;
    case "admin":
        $allowed_tabs = array_diff(array_keys($page_titles));
        break;
    case "ceo":
        $allowed_tabs = array("karyawan.php", "gaji.php", "laporan.php", "pengguna.php", "profil.php", "logout.php");
        break;
    default:
        $allowed_tabs = array(); // Tidak ada tab yang ditampilkan jika jabatan tidak sesuai
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_titles[$current_page]) ? $page_titles[$current_page] : "Navbar"; ?></title>
    <link rel="icon" href="image/logo.png" type="image/png">
</head>

<body>
    <div class="navbar">
        <a href="index.php"><img src="image/logo.jpeg" alt="Logo"></a>
        <?php
        // Menampilkan tab sesuai dengan jabatan pengguna
        foreach ($allowed_tabs as $tab) {
            echo '<a href="' . $tab . '">' . $page_titles[$tab] . '</a>';
        }
        ?>
        <span class="profile" onclick="openOverlay()">
            <?php
            // Ambil ID Karyawan berdasarkan nama pengguna yang login
            $username = $_SESSION['username'];
            $sql_pengguna = "SELECT id_karyawan FROM pengguna WHERE nama_pengguna = '$username'";
            $result_pengguna = mysqli_query($koneksi, $sql_pengguna);
            $row_pengguna = mysqli_fetch_assoc($result_pengguna);
            $id_karyawan = $row_pengguna['id_karyawan'];

            // Ambil foto karyawan
            $foto_path = 'image/' . $id_karyawan . '.jpg'; // Path foto di folder "image"
            if (!file_exists($foto_path)) {
                $foto_path = 'image/pp.jpg'; // Jika foto tidak ditemukan, gunakan foto default
            }
            echo '<img src="' . $foto_path . '" alt="Profile Picture">';
            ?>
        </span>
    </div>

    <!-- Overlay content -->
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <?php
            // Menampilkan tab overlay sesuai dengan jabatan pengguna
            foreach ($allowed_tabs as $tab) {
                echo '<a href="' . $tab . '">' . $page_titles[$tab] . '</a>';
            }
            ?>
        </div>
    </div>

    <script>
        // JavaScript untuk toggle overlay
        function openOverlay() {
            var overlay = document.getElementById("overlay");
            overlay.style.display = "block";

            // Tambahkan event listener untuk menutup overlay saat mengklik area di luar konten overlay
            overlay.addEventListener("click", function(event) {
                if (event.target === overlay) {
                    closeOverlay();
                }
            });
        }

        function closeOverlay() {
            var overlay = document.getElementById("overlay");
            overlay.style.display = "none";
        }
    </script>

</body>

</html>