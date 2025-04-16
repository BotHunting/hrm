<?php
// Mulai sesi


// Tentukan judul berdasarkan halaman yang dibuka
$page_titles = array(
    "karyawan.php" => "Karyawan",
    "absensi.php" => "Absensi",
    "kinerja.php" => "Kinerja",
    "pelatihan.php" => "Pelatihan",
    "gaji.php" => "Penggajian",
    "laporan.php" => "Pelaporan",
    "pengguna.php" => "Pengguna",
    "profil.php" => "Profil"
);

// Dapatkan nama halaman saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Cek apakah pengguna sudah login
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    $login_logout_text = "Logout";
    $login_logout_url = "logout.php";
} else {
    $login_logout_text = "Login";
    $login_logout_url = "login.php";
}

// Cek jabatan pengguna untuk menentukan tab yang akan ditampilkan
$allowed_tabs = array();
if (isset($_SESSION["jabatan"])) {
    switch ($_SESSION["jabatan"]) {
        case "karyawan":
            $allowed_tabs = array("absensi.php", "kinerja.php", "pelatihan.php", "profil.php");
            break;
        case "admin":
            $allowed_tabs = array_diff(array_keys($page_titles));
            break;
        case "ceo":
            $allowed_tabs = array("karyawan.php", "gaji.php", "laporan.php", "pengguna.php", "profil.php");
            break;
        default:
            $allowed_tabs = array(); // Tidak ada tab yang ditampilkan jika jabatan tidak sesuai
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SIM Saksana Antakara</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center">
            <h1 class="logo me-auto"><a href="index.php">CV. Saksana Antakara</a></h1>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="testimonials.php">Testimonials</a></li>
                    <li><a href="portfolio.php">Galery</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li class="dropdown"><a href="#"><span>Menu</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <?php
                            // Menampilkan tombol yang diizinkan berdasarkan jabatan pengguna
                            foreach ($allowed_tabs as $tab) {
                                echo "<li><a href=\"$tab\"";
                                // Menandai tab yang aktif
                                if ($current_page === $tab) {
                                    echo " class=\"active\"";
                                }
                                echo ">" . $page_titles[$tab] . "</a></li>";
                            }
                            ?>
                        </ul>
                    <li><a href="contact.php" class="active">Contact</a></li>
                    <li><a href="<?php echo $login_logout_url; ?>" class="getstarted"><?php echo $login_logout_text; ?></a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->