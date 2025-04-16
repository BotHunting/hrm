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

// Fungsi untuk mendapatkan daftar pelatihan
function getDaftarPelatihan()
{
    global $koneksi;
    $query = "SELECT * FROM pelatihan";
    $result = mysqli_query($koneksi, $query);
    $daftar_pelatihan = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $daftar_pelatihan[] = $row;
        }
    }
    return $daftar_pelatihan;
}

// Fungsi untuk mendapatkan peserta pelatihan berdasarkan ID pelatihan
function getPesertaPelatihan($id_pelatihan)
{
    global $koneksi;
    $query = "SELECT karyawan.id_karyawan, karyawan.nama FROM karyawan INNER JOIN peserta_pelatihan ON karyawan.id_karyawan = peserta_pelatihan.id_karyawan WHERE peserta_pelatihan.id_pelatihan = $id_pelatihan";
    $result = mysqli_query($koneksi, $query);
    $peserta_pelatihan = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $peserta_pelatihan[] = $row;
        }
    }
    return $peserta_pelatihan;
}

// Cek jabatan pengguna yang sedang login
$jabatan = $_SESSION["jabatan"];
?>

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Manajemen Pelatihan</h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Pelatihan</li>
            </ol>
        </div>

    </div>
</section><!-- End Breadcrumbs -->

<main class="container mt-4">
    <div id="tambah-pelatihan">
        <?php if ($jabatan !== 'karyawan') : ?>
            <a href="tambah_pelatihan.php" class="btn btn-primary mr-2">Tambah Pelatihan</a>
            <a href="penilaian_pelatihan.php" class="btn btn-primary">Penilaian Pelatihan</a>
        <?php endif; ?>
    </div>

    <section id="daftar-pelatihan" class="mt-4">
        <h2>Daftar Pelatihan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pelatihan</th>
                    <th>Nama Pelatihan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Lokasi</th>
                    <th>Durasi (jam)</th>
                    <th>Biaya</th>
                    <?php if ($jabatan !== 'karyawan') : ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Memanggil fungsi untuk mengambil daftar pelatihan
                $daftar_pelatihan = getDaftarPelatihan();
                foreach ($daftar_pelatihan as $pelatihan) {
                    echo "<tr>";
                    echo "<td>" . $pelatihan['id_pelatihan'] . "</td>";
                    echo "<td>" . $pelatihan['nama_pelatihan'] . "</td>";
                    echo "<td>" . $pelatihan['tanggal_mulai'] . "</td>";
                    echo "<td>" . $pelatihan['tanggal_selesai'] . "</td>";
                    echo "<td>" . $pelatihan['lokasi'] . "</td>";
                    echo "<td>" . $pelatihan['durasi'] . "</td>";
                    echo "<td>Rp " . $pelatihan['biaya'] . "</td>";
                    if ($jabatan !== 'karyawan') {
                        echo "<td>
                                    <a href='edit_pelatihan.php?id=" . $pelatihan['id_pelatihan'] . "' class='btn btn-info'>Edit</a>
                                    <a href='hapus_pelatihan.php?id=" . $pelatihan['id_pelatihan'] . "' class='btn btn-danger'>Hapus</a>
                                    <a href='ikuti_pelatihan.php?id=" . $pelatihan['id_pelatihan'] . "' class='btn btn-primary'>Ikuti</a>
                                  </td>";
                    }
                    echo "</tr>";

                    // Tampilkan daftar peserta pelatihan
                    $peserta_pelatihan = getPesertaPelatihan($pelatihan['id_pelatihan']);
                    if (!empty($peserta_pelatihan)) {
                        echo "<tr>";
                        echo "<td colspan='" . ($jabatan !== 'karyawan' ? '8' : '7') . "'>";
                        echo "<h3>Peserta Pelatihan</h3>";
                        echo "<ul>";
                        foreach ($peserta_pelatihan as $peserta) {
                            echo "<li>" . $peserta['nama'] . "</li>";
                        }
                        echo "</ul>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</main>

<?php include 'footer.php' ?>