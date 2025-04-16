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
?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Laporan</h2>
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li>Laporan</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <section id="services" class="services">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="icon-box">
                        <i class="bi bi-briefcase"></i>
                        <h4><a href="kuantitas_sdm.php">Laporan Kuantitas SDM</a></h4>
                        <p>Laporan tentang jumlah karyawan dan distribusi mereka dalam berbagai posisi atau departemen.</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-card-checklist"></i>
                        <h4><a href="laporan_absensi.php">Laporan Absensi</a></h4>
                        <p>Laporan tentang kehadiran karyawan dalam periode waktu tertentu.</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-bar-chart"></i>
                        <h4><a href="laporan_kinerja.php">Laporan Kinerja</a></h4>
                        <p>Laporan tentang kinerja karyawan berdasarkan penilaian atau evaluasi.</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-binoculars"></i>
                        <h4><a href="laporan_pelatihan.php">Laporan Pelatihan</a></h4>
                        <p>Laporan tentang pelatihan yang diikuti oleh karyawan dan hasilnya.</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-brightness-high"></i>
                        <h4><a href="laporan_gaji.php">Laporan Gaji</a></h4>
                        <p>Laporan tentang pembayaran gaji kepada karyawan, termasuk detail komponen gaji.</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-calendar4-week"></i>
                        <h4><a href="besaran_gaji.php">Besaran Gaji</a></h4>
                        <p>Informasi tentang besaran gaji yang berlaku di perusahaan untuk setiap jabatan atau level.</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Services Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">

            <div class="section-title">
                <h2>Features</h2>
                <p>Check our Features</p>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">Laporan Kuantitas SDM</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-2">Laporan Absensi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-3">Laporan Kinerja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-4">Laporan Pelatihan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-5">Laporan Gaji</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-6">Besaran Gaji</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-1">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Analisis Jumlah Karyawan</h3>
                                    <p class="fst-italic">Pantau jumlah karyawan per divisi, jenis kelamin, dan status pekerjaan untuk memahami struktur SDM perusahaan Anda</p>
                                    <p>Gunakan data ini untuk mengevaluasi kebutuhan rekrutmen, perencanaan suksesi, dan strategi pengembangan SDM yang efektif</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/features-1.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-2">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Rekapitulasi Kehadiran Karyawan</h3>
                                    <p class="fst-italic">Dapatkan ringkasan tingkat absensi karyawan per bulan, divisi, dan individu</p>
                                    <p>Analisa pola absensi, identifikasi potensi masalah, dan tingkatkan disiplin karyawan dengan laporan ini</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/features-2.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-3">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Evaluasi Pencapaian Karyawan</h3>
                                    <p class="fst-italic">Pantau performa karyawan melalui penilaian berkala dan identifikasi area yang perlu ditingkatkan</p>
                                    <p>Gunakan data ini untuk memberikan umpan balik yang konstruktif, mendorong pengembangan diri karyawan, dan meningkatkan kinerja tim secara keseluruhan</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/features-3.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-4">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Rekapitulasi Program Pelatihan</h3>
                                    <p class="fst-italic">Lacak partisipasi karyawan dalam program pelatihan dan ukur efektivitasnya</p>
                                    <p>Identifikasi kebutuhan pelatihan di masa depan, tingkatkan skillset karyawan, dan dukung pengembangan karir mereka</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/features-4.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-5">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Rincian Distribusi Gaji</h3>
                                    <p class="fst-italic">Dapatkan informasi detail mengenai gaji karyawan per divisi, jabatan, dan periode pembayaran</p>
                                    <p>Lakukan analisis kesetaraan gaji, kelola anggaran gaji, dan pastikan kepatuhan terhadap peraturan ketenagakerjaan</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/features-5.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-6">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Struktur Gaji Karyawan</h3>
                                    <p class="fst-italic">Lihat tabel gaji standar berdasarkan divisi, jabatan, dan tingkat pengalaman</p>
                                    <p>Gunakan informasi ini untuk menentukan gaji yang kompetitif, meningkatkan retensi karyawan, dan membangun struktur gaji yang adil dan transparan</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/features-6.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Features Section -->

</main><!-- End #main -->

<?php include 'footer.php' ?>