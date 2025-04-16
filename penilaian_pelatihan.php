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

// Fungsi untuk mendapatkan data peserta pelatihan beserta nama pelatihan dan nama karyawan
function getDataPesertaPelatihan()
{
    global $koneksi;
    $query = "SELECT peserta_pelatihan.id_peserta, pelatihan.nama_pelatihan, karyawan.nama
              FROM peserta_pelatihan
              INNER JOIN pelatihan ON peserta_pelatihan.id_pelatihan = pelatihan.id_pelatihan
              INNER JOIN karyawan ON peserta_pelatihan.id_karyawan = karyawan.id_karyawan";
    $result = mysqli_query($koneksi, $query);
    $data_peserta_pelatihan = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data_peserta_pelatihan[] = $row;
        }
    }
    return $data_peserta_pelatihan;
}
?>

<main class="container mt-4">
    <!-- Tabel untuk menampilkan data peserta pelatihan -->
    <section id="peserta-pelatihan">
        <h2>Data Peserta Pelatihan</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID Peserta</th>
                        <th scope="col">Nama Pelatihan</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Memanggil fungsi untuk mendapatkan data peserta pelatihan
                    $data_peserta_pelatihan = getDataPesertaPelatihan();
                    foreach ($data_peserta_pelatihan as $peserta) {
                        echo "<tr>";
                        echo "<td>" . $peserta['id_peserta'] . "</td>";
                        echo "<td>" . $peserta['nama_pelatihan'] . "</td>";
                        echo "<td>" . $peserta['nama'] . "</td>";
                        echo "<td><a href='aksi_penilaian.php?id_peserta=" . $peserta['id_peserta'] . "' class='btn btn-primary'>Nilai</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="pelatihan.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
    </section>
</main>

<?php include 'footer.php' ?>