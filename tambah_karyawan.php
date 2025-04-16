<?php
session_start();

// Kode untuk koneksi ke database
include 'koneksi.php';
include 'header.php';

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Variabel pesan untuk menampilkan pesan sukses atau kesalahan
$pesan = '';

// Mendapatkan tahun saat ini
$tahun_sekarang = date("Y");

// Mendapatkan nomor urut terakhir dari database untuk tahun saat ini
$query_max_id = "SELECT MAX(RIGHT(id_karyawan, 3)) AS max_id FROM karyawan WHERE LEFT(id_karyawan, 4) = '$tahun_sekarang'";
$result_max_id = mysqli_query($koneksi, $query_max_id);
$row_max_id = mysqli_fetch_assoc($result_max_id);
$max_id = ($row_max_id['max_id']) ? $row_max_id['max_id'] + 1 : 1;

// Membuat format id_karyawan dengan tahun saat ini dan nomor urut 3 digit
$id_karyawan = $tahun_sekarang . sprintf("%03s", $max_id);

// Daftar pilihan status
$status_options = array("Lajang", "Menikah");

// Query untuk mendapatkan daftar jabatan dari tabel salary
$query_jabatan = "SELECT DISTINCT jabatan FROM salary";
$result_jabatan = mysqli_query($koneksi, $query_jabatan);
$jabatan_options = array();

// Mengisi array $jabatan_options dengan jabatan dari hasil query
while ($row = mysqli_fetch_assoc($result_jabatan)) {
    $jabatan_options[] = $row['jabatan'];
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    // Mendapatkan data dari form
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $alamat = $_POST["alamat"];
    $telepon = $_POST["telepon"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    $jabatan = $_POST["jabatan"];
    $foto = $_FILES["foto"];

    // Memeriksa apakah file foto diunggah
    if ($foto['size'] > 0) {
        // Memeriksa tipe file
        $allowed_types = array('jpg', 'jpeg', 'png');
        $file_extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_extension), $allowed_types)) {
            $pesan = "Error: Hanya file JPG, JPEG, atau PNG yang diperbolehkan.";
        } else {
            // Memeriksa ukuran file (maksimal 1 MB)
            if ($foto['size'] > 1048576) {
                $pesan = "Error: Ukuran file melebihi batas maksimal (1 MB).";
            } else {
                // Menyimpan file foto ke folder image dengan nama sesuai id_karyawan
                $nama_file = $id_karyawan . '.' . $file_extension;
                $target_dir = "image/";
                $target_file = $target_dir . $nama_file;
                if (move_uploaded_file($foto['tmp_name'], $target_file)) {
                    // Query untuk mendapatkan data upah dan gaji harian sesuai dengan jabatan yang dipilih
                    $query_gaji = "SELECT upah, gaji_harian FROM salary WHERE jabatan='$jabatan'";
                    $result_gaji = mysqli_query($koneksi, $query_gaji);
                    $row_gaji = mysqli_fetch_assoc($result_gaji);
                    $upah = $row_gaji['upah'];
                    $gaji_harian = $row_gaji['gaji_harian'];

                    // Query untuk menyimpan data karyawan beserta foto ke database
                    $query = "INSERT INTO karyawan (id_karyawan, nama, jenis_kelamin, tanggal_lahir, alamat, telepon, email, status, jabatan, upah, gaji_harian, foto) 
                              VALUES ('$id_karyawan', '$nama', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$telepon', '$email', '$status', '$jabatan', '$upah', '$gaji_harian', '$nama_file')";

                    // Eksekusi query
                    if (mysqli_query($koneksi, $query)) {
                        $pesan = "Karyawan berhasil ditambahkan!";
                        header("Location: karyawan.php");
                        exit();
                    } else {
                        $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
                    }
                } else {
                    $pesan = "Error: Gagal mengunggah file foto.";
                }
            }
        }
    } else {
        $pesan = "Error: Foto harus diunggah.";
    }
}
?>

<main class="container mt-4">
    <section id="tambah-karyawan" class="mt-4">
        <h2 class="text-center">Tambah Karyawan</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat:</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon:</label>
                        <input type="tel" class="form-control" id="telepon" name="telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-select" id="status" name="status" required>
                            <?php foreach ($status_options as $status_option) { ?>
                                <option value="<?php echo $status_option; ?>"><?php echo $status_option; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan:</label>
                        <select class="form-select" id="jabatan" name="jabatan" onchange="fetchGaji(this.value)" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jabatan_options as $jabatan_option) { ?>
                                <option value="<?php echo $jabatan_option; ?>"><?php echo $jabatan_option; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="upah" class="form-label">Upah:</label>
                        <input type="number" class="form-control" id="upah" name="upah" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="gaji_harian" class="form-label">Gaji Harian:</label>
                        <input type="number" class="form-control" id="gaji_harian" name="gaji_harian" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                    <div class="mb-3 d-grid">
                        <button type="submit" class="btn btn-primary" name="tambah">Tambah Karyawan</button>
                    </div>
                    <div class="mb-3 d-grid">
                        <a href="karyawan.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
                <p class="text-center"><?php echo $pesan; ?></p>
            </div>
        </div>
    </section>
</main>

<script>
    function fetchGaji(jabatan) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                document.getElementById('upah').value = data.upah;
                document.getElementById('gaji_harian').value = data.gaji_harian;
            }
        };
        xhttp.open("GET", "fetch_gaji.php?jabatan=" + jabatan, true);
        xhttp.send();
    }
</script>

<?php include 'footer.php' ?>