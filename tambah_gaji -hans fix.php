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

// Variabel pesan untuk menampilkan pesan sukses atau kesalahan
$pesan = '';

// Mendapatkan daftar karyawan untuk pilihan id karyawan
$query_karyawan = "SELECT karyawan.id_karyawan, karyawan.nama, salary.gaji_harian FROM karyawan left outer join salary on salary.jabatan = karyawan.jabatan";
$result_karyawan = mysqli_query($koneksi, $query_karyawan);

//cek gaji karyawan
if (isset($_GET['id_karyawan'])) {
    $cariID = $_GET['id_karyawan'];

    $cek_gaji = "SELECT karyawan.nama, karyawan.upah, salary.gaji_harian from salary left outer join karyawan on karyawan.jabatan = salary.jabatan where karyawan.id_karyawan = '$cariID'";
    $result_gaji1 = mysqli_query($koneksi,$cek_gaji);
}else {
    $result_gaji1 = [];
}


// Array pilihan bulan dengan nilai integer
$bulan_options = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);

// Inisialisasi variabel untuk menyimpan data gaji
$id_karyawan = '';
$bulan = '';
$tahun = date('Y'); // Tahun saat ini
$gaji_pokok = '';
$jumlah_absensi = '';
$tunjangan_kinerja = '';
$jumlah_honor = '';

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    // Mendapatkan data dari form
    $id_karyawan = $_POST["id_karyawan"];
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    $gaji_pokok = $_POST["gaji_pokok"];
    $jumlah_absensi = $_POST["jumlah_absensi"];
    $tunjangan_kinerja = $_POST["tunjangan_kinerja"];
    $jumlah_honor = $_POST["jumlah_honor"];

    // Menghitung pajak penghasilan (2.5% dari jumlah gaji)
    $pajak_penghasilan = $gaji_pokok * 0.025;

    // Menghitung total gaji
    $total_gaji = ($gaji_pokok * $jumlah_absensi) + (($tunjangan_kinerja/100) * 520000) + $jumlah_honor - $pajak_penghasilan;

    // Query untuk mendapatkan nama karyawan
    $query_nama = "SELECT nama FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result_nama = mysqli_query($koneksi, $query_nama);
    $row_nama = mysqli_fetch_assoc($result_nama);
    $nama = $row_nama['nama'];

    // Cek apakah data sudah ada di tabel gaji_laporan berdasarkan bulan dan tahun
    $query_check = "SELECT * FROM gaji_laporan WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
    $result_check = mysqli_query($koneksi, $query_check);
    if (mysqli_num_rows($result_check) > 0) {
        // Jika sudah ada, update data di tabel gaji_laporan
        $query_update = "UPDATE gaji_laporan SET gaji_pokok = '$gaji_pokok', jumlah_absensi = '$jumlah_absensi', tunjangan_kinerja = '$tunjangan_kinerja', jumlah_honor = '$jumlah_honor', total_gaji = '$total_gaji' WHERE id_karyawan = '$id_karyawan' AND bulan = '$bulan' AND tahun = '$tahun'";
        if (mysqli_query($koneksi, $query_update)) {
            $pesan = "Data gaji berhasil diperbarui!";
        } else {
            $pesan = "Error: " . $query_update . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Jika belum ada, tambahkan data baru di tabel gaji dan gaji_laporan
        $query_gaji = "INSERT INTO gaji (id_karyawan, nama, bulan, tahun, gaji_pokok, jumlah_absensi, tunjangan_kinerja, jumlah_honor, pajak_penghasilan, total_gaji) 
                      VALUES ('$id_karyawan', '$nama', '$bulan', '$tahun', '$gaji_pokok', '$jumlah_absensi', '$tunjangan_kinerja', '$jumlah_honor', '$pajak_penghasilan', '$total_gaji')";

        $query_gaji_laporan = "INSERT INTO gaji_laporan (id_karyawan, nama, bulan, tahun, gaji_pokok, jumlah_absensi, tunjangan_kinerja, jumlah_honor, pajak_penghasilan, total_gaji) 
                               VALUES ('$id_karyawan', '$nama', '$bulan', '$tahun', '$gaji_pokok', '$jumlah_absensi', '$tunjangan_kinerja', '$jumlah_honor', '$pajak_penghasilan', '$total_gaji')";

        if (mysqli_query($koneksi, $query_gaji) && mysqli_query($koneksi, $query_gaji_laporan)) {
            $pesan = "Data gaji berhasil ditambahkan!";
        } else {
            $pesan = "Error: " . $query_gaji . "<br>" . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Gaji Karyawan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Abu-abu */
            margin: 0;
            padding: 0;
            color: #000; /* Hitam */
        }

        header {
            background-color: #FFD700; /* Kuning emas */
            color: #000; /* Hitam */
            padding: 20px;
            text-align: center;
        }

        h1, h2 {
            margin: 0;
            font-size: 36px;
        }

        main {
            padding: 20px;
        }

        #tambah-gaji {
            max-width: 400px;
            margin: 0 auto;
            background-color: #FFFACD; /* Kuning muda */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        label {
            font-weight: bold;
            color: #000; /* Hitam */
        }

        input[type="text"],
        input[type="number"],
        select,
        button {
            margin-top: 10px;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('arrow.png'); /* Gambar panah untuk dropdown */
            background-position: right center;
            background-repeat: no-repeat;
            background-size: 20px;
            padding-right: 30px;
        }

        button {
            background-color: #FFD700; /* Kuning emas */
            color: #000; /* Hitam */
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #CCA300; /* Kuning tua */
        }

        p {
            text-align: center;
            margin-top: 10px;
        }
        
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff; /* Biru */
            text-decoration: none;
        }

        a:hover {
            color: #0056b3; /* Biru tua */
        }
    </style>
</head>
<body>
    <header>
        <h1>Manajemen Gaji Karyawan</h1>
    </header>
    <main>
        <!-- Formulir untuk menambah data gaji -->
        <section id="tambah-gaji">
            <h2>Tambah Data Gaji Baru</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" id="form_id">
                <label for="id_karyawan">Pilih ID Karyawan:</label><br>
                <select id="id_karyawan" name="id_karyawan" onchange="document.getElementById('form_id').submit();">
                    <?php
                    while ($row = mysqli_fetch_assoc($result_karyawan)) { ?>
                        <!-- echo "<option value='".$row['id_karyawan']."'>".$row['id_karyawan']." - ".$row['nama']."</option>"; -->
                        <option <?php if(!empty($cariID)){ echo $cariID == $row['id_karyawan'] ? 'selected':''; } ?> value="<?php echo $row['id_karyawan'];?>"><?php echo $row['id_karyawan']."-".$row['nama']; ?></option>
                    <?php }
                    ?>
                </select><br>
                <label for="bulan">Pilih Bulan:</label><br>
                <select id="bulan" name="bulan" required>
                    <?php
                    foreach ($bulan_options as $key => $bulan_name) {
                        echo "<option value='$key'>$bulan_name</option>";
                    }
                    ?>
                </select><br>
                <label for="tahun">Tahun:</label><br>
                <input type="text" id="tahun" name="tahun" value="<?php echo $tahun; ?>" required><br>
                <label for="gaji_pokok">Gaji Pokok:</label><br>
                <?php 
                foreach ($result_gaji1 as $key1) { ?>
                <input type="number" id="gaji_pokok" name="gaji_pokok" value="<?php echo $key1['gaji_harian'] ?>" required>
                <?php } ?><br>
                <label for="jumlah_absensi">Jumlah Absensi:</label><br>
                <input type="number" id="jumlah_absensi" name="jumlah_absensi" required><br>
                <label for="tunjangan_kinerja">Tunjangan Kinerja (%):</label><br>
                <input type="number" id="tunjangan_kinerja" name="tunjangan_kinerja" required><br>
                <label for="jumlah_honor">Honor Pelatihan:</label><br>
                <input type="number" id="jumlah_honor" name="jumlah_honor" required><br><br>
                <button type="submit" name="tambah">Tambah Data Gaji</button>
                <a href="gaji.php">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
            </form>
            <p><?php echo $pesan; ?></p>
        </section>
    </main>
</body>
</html>
