<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Kode untuk koneksi ke database
include 'koneksi.php';
include 'header.php'; // Kode untuk navbar

// Variabel pesan untuk menampilkan pesan sukses atau kesalahan
$pesan = '';

// Variabel untuk pilihan status dan jabatan
$status_options = array("Lajang", "Menikah");

// Query untuk mendapatkan daftar jabatan dari tabel salary
$query_jabatan = "SELECT DISTINCT jabatan FROM salary";
$result_jabatan = mysqli_query($koneksi, $query_jabatan);
$jabatan_options = [];
while ($row = mysqli_fetch_assoc($result_jabatan)) {
    $jabatan_options[] = $row['jabatan'];
}

// Jika terdapat parameter id dalam URL
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Mendapatkan data karyawan berdasarkan ID
    $query_get_karyawan = "SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan'";
    $result_get_karyawan = mysqli_query($koneksi, $query_get_karyawan);

    // Jika data karyawan ditemukan
    if ($result_get_karyawan && mysqli_num_rows($result_get_karyawan) > 0) {
        $karyawan = mysqli_fetch_assoc($result_get_karyawan);

        // Jika form disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["simpan"])) {
            // Mendapatkan data dari form
            $nama = $_POST["nama"];
            $jenis_kelamin = $_POST["jenis_kelamin"];
            $tanggal_lahir = $_POST["tanggal_lahir"];
            $alamat = $_POST["alamat"];
            $telepon = $_POST["telepon"];
            $email = $_POST["email"];
            $status = $_POST["status"];
            $jabatan = $_POST["jabatan"];
            $upah = $_POST["upah"];
            $gaji_harian = $_POST["gaji_harian"];

            // Jika tidak ada file foto yang diunggah
            if (empty($_FILES["foto"]["name"])) {
                // Query untuk memperbarui data karyawan ke database tanpa mengubah foto
                $query = "UPDATE karyawan SET 
                          nama='$nama', 
                          jenis_kelamin='$jenis_kelamin', 
                          tanggal_lahir='$tanggal_lahir', 
                          alamat='$alamat', 
                          telepon='$telepon', 
                          email='$email', 
                          status='$status', 
                          jabatan='$jabatan', 
                          upah='$upah', 
                          gaji_harian='$gaji_harian' 
                          WHERE id_karyawan='$id_karyawan'";

                // Eksekusi query
                if (mysqli_query($koneksi, $query)) {
                    // Set pesan notifikasi
                    $_SESSION['pesan'] = "Data karyawan berhasil diperbarui!";
                    // Redirect ke halaman profil.php
                    header("Location: profil.php");
                    exit();
                } else {
                    $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
                }
            } else {
                // File upload handling
                $target_dir = "assets/img/pp/"; // Direktori penyimpanan foto
                $target_file = $target_dir . $id_karyawan . ".jpg"; // Nama file disesuaikan dengan id_karyawan dan format JPG
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = $_FILES["foto"]["tmp_name"];
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $pesan = "File bukan gambar.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["foto"]["size"] > 1000000) {
                    $pesan = "Maaf, file terlalu besar. Maksimal 1 MB.";
                    $uploadOk = 0;
                }

                // Allow only JPG file format
                if ($imageFileType != "jpg") {
                    $pesan = "Maaf, hanya file JPG yang diperbolehkan.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $pesan = "Maaf, file tidak diunggah.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                        $pesan = "The file " . htmlspecialchars(basename($_FILES["foto"]["name"])) . " has been uploaded.";
                    } else {
                        $pesan = "Maaf, terjadi kesalahan saat mengunggah file.";
                    }
                }

                // Jika foto berhasil diunggah, lanjutkan dengan memperbarui data karyawan ke database
                if ($uploadOk == 1) {
                    // Query untuk memperbarui data karyawan ke database
                    $query = "UPDATE karyawan SET 
                              nama='$nama', 
                              jenis_kelamin='$jenis_kelamin', 
                              tanggal_lahir='$tanggal_lahir', 
                              alamat='$alamat', 
                              telepon='$telepon', 
                              email='$email', 
                              status='$status', 
                              jabatan='$jabatan', 
                              upah='$upah', 
                              gaji_harian='$gaji_harian' 
                              WHERE id_karyawan='$id_karyawan'";

                    // Eksekusi query
                    if (mysqli_query($koneksi, $query)) {
                        // Set pesan notifikasi
                        $_SESSION['pesan'] = "Data karyawan berhasil diperbarui!";
                        // Redirect ke halaman profil.php
                        header("Location: profil.php");
                        exit();
                    } else {
                        $pesan = "Error: " . $query . "<br>" . mysqli_error($koneksi);
                    }
                }
            }
        }
    } else {
        $pesan = "Data karyawan tidak ditemukan!";
    }
} else {
    // Jika tidak ada parameter id
    $pesan = "Parameter ID tidak ditemukan!";
}
?>

<main class="container mt-4">
    <section id="edit-karyawan">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_karyawan; ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <div class="gambar-karyawan">
                        <?php
                        // Ambil foto karyawan
                        $foto = 'assets/img/pp/' . $id_karyawan . '.jpg'; // Sesuaikan dengan path foto di folder "image"
                        if (!file_exists($foto)) {
                            $foto = 'pp.jpg'; // Jika foto tidak ditemukan, gunakan foto default
                        }
                        ?>
                        <img id="previewFoto" src="<?php echo $foto; ?>" class="img-fluid mb-3" alt="Profil Photo">
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Edit Foto</button>
                            <input type="file" id="fileInput" name="foto" style="display: none;" onchange="previewImage(event)">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" id="nama" name="nama" value="<?php echo $karyawan['nama']; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki" <?php echo ($karyawan['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php echo ($karyawan['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $karyawan['tanggal_lahir']; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat:</label>
                        <textarea id="alamat" name="alamat" class="form-control" required><?php echo $karyawan['alamat']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon:</label>
                        <input type="tel" id="telepon" name="telepon" value="<?php echo $karyawan['telepon']; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $karyawan['email']; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select id="status" name="status" class="form-select" required>
                            <?php foreach ($status_options as $status_option) { ?>
                                <option value="<?php echo $status_option; ?>" <?php echo ($karyawan['status'] == $status_option) ? 'selected' : ''; ?>><?php echo $status_option; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan:</label>
                        <select id="jabatan" name="jabatan" class="form-select" onchange="fetchGaji()" required>
                            <?php foreach ($jabatan_options as $jabatan_option) { ?>
                                <option value="<?php echo $jabatan_option; ?>" <?php echo ($karyawan['jabatan'] == $jabatan_option) ? 'selected' : ''; ?>><?php echo $jabatan_option; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="upah" class="form-label">Upah:</label>
                        <input type="text" id="upah" name="upah" value="<?php echo $karyawan['upah']; ?>" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="gaji_harian" class="form-label">Gaji Harian:</label>
                        <input type="text" id="gaji_harian" name="gaji_harian" value="<?php echo $karyawan['gaji_harian']; ?>" class="form-control" readonly>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <a href="profil.php" class="btn btn-secondary">Kembali</a> <!-- Tautan untuk kembali ke halaman utama -->
                </div>
            </div>
        </form>
        <p>
            <?php echo $pesan; ?>
        </p>
    </section>
</main>

<script>
    function fetchGaji() {
        var jabatan = document.getElementById('jabatan').value;
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

    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.getElementById('previewFoto');
            img.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>

<?php include 'footer.php' ?>