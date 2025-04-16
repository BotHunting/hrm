<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';

// Fungsi untuk mendapatkan daftar karyawan
function getDaftarKaryawan()
{
    global $koneksi; // Menggunakan koneksi yang telah dibuat sebelumnya

    $query = "SELECT * FROM karyawan";
    $result = mysqli_query($koneksi, $query);

    $daftar_karyawan = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $daftar_karyawan[] = $row;
    }
    return $daftar_karyawan;
}
?>

<?php include 'header.php' ?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Manajemen Karyawan</h2>
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li>Karyawan</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
        <div class="text-center">
            <a href="tambah_karyawan.php" class="btn btn-primary">Tambah Karyawan</a>
        </div>
        <div class="container">
            <div class="row">
                <?php
                // Memanggil fungsi untuk mengambil daftar karyawan
                $daftar_karyawan = getDaftarKaryawan();
                foreach ($daftar_karyawan as $karyawan) {
                    // Tentukan foto karyawan
                    $foto = (!empty($karyawan['foto'])) ? 'assets/img/pp/' . $karyawan['id_karyawan'] . '.jpg' : 'pp.jpg';
                ?>
                    <div class="col-lg-6 mt-4">
                        <div class="member d-flex align-items-start">
                            <div class="pic"><img src="<?php echo $foto; ?>" class="img-fluid" alt="Foto Karyawan"></div>
                            <div class="member-info">
                                <h4><?php echo $karyawan['nama']; ?></h4>
                                <span><?php echo $karyawan['jabatan']; ?></span>
                                <p>
                                    ID Karyawan: <?php echo $karyawan['id_karyawan']; ?><br>
                                    Jenis Kelamin: <?php echo $karyawan['jenis_kelamin']; ?><br>
                                    Tanggal Lahir: <?php echo $karyawan['tanggal_lahir']; ?><br>
                                    Alamat: <?php echo $karyawan['alamat']; ?><br>
                                    Telepon: <?php echo $karyawan['telepon']; ?><br>
                                    Email: <?php echo $karyawan['email']; ?><br>
                                    Status: <?php echo $karyawan['status']; ?><br>
                                    Upah: <?php echo $karyawan['upah']; ?><br>
                                    Gaji Harian: <?php echo $karyawan['gaji_harian']; ?>
                                </p>
                                <div class="social">
                                    <a href="edit_karyawan.php?id=<?php echo $karyawan['id_karyawan']; ?>" class="btn btn-info btn-sm">Edit</a>
                                    <a href="hapus_karyawan.php?id=<?php echo $karyawan['id_karyawan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">Hapus</a>
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""><i class="ri-linkedin-box-fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section><!-- End Team Section -->

</main><!-- End #main -->

<?php include 'footer.php' ?>