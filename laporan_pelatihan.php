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

// Query untuk mendapatkan semua data pelatihan
$query_pelatihan = "SELECT * FROM pelatihan";
$result_pelatihan = mysqli_query($koneksi, $query_pelatihan);

// Query untuk mendapatkan semua data peserta pelatihan
$query_peserta = "SELECT * FROM peserta_pelatihan";
$result_peserta = mysqli_query($koneksi, $query_peserta);
?>

<main class="container mt-4">
    <h1 class="text-center mb-4">Laporan Pelatihan</h1>
    <?php
    while ($row_pelatihan = mysqli_fetch_assoc($result_pelatihan)) :
        $id_pelatihan = $row_pelatihan['id_pelatihan'];
        $query_peserta_pelatihan = "SELECT * FROM peserta_pelatihan WHERE id_pelatihan='$id_pelatihan'";
        $result_peserta_pelatihan = mysqli_query($koneksi, $query_peserta_pelatihan);
    ?>
        <section class="pelatihan mb-4">
            <h2><?php echo $row_pelatihan['nama_pelatihan']; ?></h2>
            <!-- Grafik -->
            <div class="row">
                <div class="col-md-6">
                    <canvas id="grafik_<?php echo $row_pelatihan['id_pelatihan']; ?>" class="grafik"></canvas>
                </div>
                <!-- Tabel peserta_pelatihan -->
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Peserta</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row_peserta_pelatihan = mysqli_fetch_assoc($result_peserta_pelatihan)) {
                                echo "<tr>";
                                echo "<td>" . $row_peserta_pelatihan['nama_peserta'] . "</td>";
                                echo "<td>" . $row_peserta_pelatihan['nilai'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    <?php endwhile; ?>

    <?php
    // Reset result_peserta_pelatihan agar bisa digunakan kembali
    mysqli_data_seek($result_pelatihan, 0);
    ?>

    <!-- Script untuk membuat grafik -->
    <?php
    while ($row_pelatihan = mysqli_fetch_assoc($result_pelatihan)) :
        $id_pelatihan = $row_pelatihan['id_pelatihan'];
        $query_peserta_pelatihan = "SELECT * FROM peserta_pelatihan WHERE id_pelatihan='$id_pelatihan'";
        $result_peserta_pelatihan = mysqli_query($koneksi, $query_peserta_pelatihan);
    ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx_<?php echo $row_pelatihan['id_pelatihan']; ?> = document.getElementById('grafik_<?php echo $row_pelatihan['id_pelatihan']; ?>').getContext('2d');
            var myChart_<?php echo $row_pelatihan['id_pelatihan']; ?> = new Chart(ctx_<?php echo $row_pelatihan['id_pelatihan']; ?>, {
                type: 'bar',
                data: {
                    labels: [<?php
                                while ($row = mysqli_fetch_assoc($result_peserta_pelatihan)) {
                                    echo '"' . $row['nama_peserta'] . '",';
                                }
                                ?>],
                    datasets: [{
                        label: 'Nilai',
                        data: [<?php
                                mysqli_data_seek($result_peserta_pelatihan, 0); // Reset pointer result_peserta_pelatihan
                                while ($row = mysqli_fetch_assoc($result_peserta_pelatihan)) {
                                    echo $row['nilai'] . ',';
                                }
                                ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    <?php endwhile; ?>

    <!-- Tombol cetak laporan -->
    <div class="text-center">
        <button onclick="window.location.href='cetak_laporan_pelatihan.php'" class="btn btn-primary mr-2">Cetak Laporan</button>
        <a href="laporan.php" class="btn btn-secondary">Kembali</a>
    </div>
</main>

<?php include 'footer.php' ?>