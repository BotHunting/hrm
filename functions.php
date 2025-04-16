<?php
// Kode untuk koneksi ke database
include 'koneksi.php';

// Fungsi untuk menambah pengguna
function tambahPengguna($nama_pengguna, $password, $jabatan)
{
    // Di sini Anda bisa menambahkan logika untuk menyimpan data pengguna ke database
    // Misalnya, dengan menggunakan perintah SQL INSERT

    // Contoh sederhana: hanya mencetak informasi pengguna yang akan ditambahkan
    echo "Menambahkan pengguna dengan nama: $nama_pengguna, password: $password, jabatan: $jabatan";

    // Mengembalikan nilai true jika berhasil, false jika gagal
    return true;
}

// Fungsi untuk menambahkan data gaji baru
function tambahkanDataGaji($id_karyawan, $periode, $gaji_pokok, $jumlah_absensi, $tunjangan_kinerja, $honor_pelatihan, $pajak_penghasilan, $total_gaji)
{
    global $koneksi;
    $query = "INSERT INTO Gaji (id_karyawan, periode, gaji_pokok, jumlah_absensi, tunjangan_kinerja, honor_pelatihan, pajak_penghasilan, total_gaji) VALUES ('$id_karyawan', '$periode', '$gaji_pokok', '$jumlah_absensi', '$tunjangan_kinerja', '$honor_pelatihan', '$pajak_penghasilan', '$total_gaji')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengambil daftar penilaian kinerja dari database
function getDaftarPenilaianKinerja()
{
    global $koneksi;
    $query = "SELECT * FROM Kinerja";
    $result = mysqli_query($koneksi, $query);
    $daftar_kinerja = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $daftar_kinerja;
}
// Fungsi untuk menambahkan penilaian kinerja baru
function tambahkanPenilaianKinerja($id_karyawan, $periode, $penilaian, $saran_rekomendasi)
{
    global $koneksi;
    $query = "INSERT INTO Kinerja (id_karyawan, periode, penilaian_kinerja, saran_rekomendasi) VALUES ('$id_karyawan', '$periode', '$penilaian', '$saran_rekomendasi')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengambil daftar karyawan dari database
function getDaftarKaryawan()
{
    global $koneksi;
    $query = "SELECT * FROM Karyawan";
    $result = mysqli_query($koneksi, $query);
    $daftar_karyawan = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $daftar_karyawan;
}

// Fungsi untuk mengambil daftar pengguna dari database
function getDaftarPengguna()
{
    global $koneksi;
    $query = "SELECT * FROM Pengguna";
    $result = mysqli_query($koneksi, $query);
    $daftar_pengguna = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $daftar_pengguna;
}

// Fungsi untuk mengambil daftar absensi dari database
function getDaftarAbsensi()
{
    global $koneksi;
    $query = "SELECT * FROM Absensi";
    $result = mysqli_query($koneksi, $query);
    $daftar_absensi = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $daftar_absensi;
}

// Fungsi untuk mengambil daftar kinerja dari database
function getDaftarKinerja()
{
    global $koneksi;
    $query = "SELECT * FROM Kinerja";
    $result = mysqli_query($koneksi, $query);
    $daftar_kinerja = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $daftar_kinerja;
}

// Fungsi untuk mengambil daftar pelatihan dari database
function getDaftarPelatihan()
{
    global $koneksi;
    $query = "SELECT * FROM Pelatihan";
    $result = mysqli_query($koneksi, $query);
    $daftar_pelatihan = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $daftar_pelatihan;
}

// Fungsi untuk mengambil daftar data gaji dari database
function getDaftarGaji()
{
    global $koneksi;
    $query = "SELECT * FROM Gaji";
    $result = mysqli_query($koneksi, $query);
    $daftar_gaji = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $daftar_gaji;
}
// Fungsi untuk menambahkan karyawan baru
function tambahkanKaryawan($nama, $jenis_kelamin, $tanggal_lahir, $alamat, $telepon, $email, $status, $departemen)
{
    global $koneksi;
    $query = "INSERT INTO Karyawan (nama, jenis_kelamin, tanggal_lahir, alamat, telepon, email, status, departemen) VALUES ('$nama', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$telepon', '$email', '$status', '$departemen')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengedit informasi karyawan
function editInformasiKaryawan($id, $nama, $jenis_kelamin, $tanggal_lahir, $alamat, $telepon, $email, $status, $departemen)
{
    global $koneksi;
    $query = "UPDATE Karyawan SET nama='$nama', jenis_kelamin='$jenis_kelamin', tanggal_lahir='$tanggal_lahir', alamat='$alamat', telepon='$telepon', email='$email', status='$status', departemen='$departemen' WHERE id_karyawan=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menghapus karyawan
function hapusKaryawan($id)
{
    global $koneksi;
    $query = "DELETE FROM Karyawan WHERE id_karyawan=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}


// Fungsi untuk mengedit data absensi
function editDataAbsensi($id, $id_karyawan, $tanggal, $jam_masuk, $jam_keluar, $keterangan)
{
    global $koneksi;
    $query = "UPDATE Absensi SET id_karyawan='$id_karyawan', tanggal='$tanggal', jam_masuk='$jam_masuk', jam_keluar='$jam_keluar', keterangan='$keterangan' WHERE id_absensi=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menambahkan data absensi baru
function tambahkanAbsensi($id_karyawan, $tanggal, $jam_masuk, $jam_keluar, $keterangan)
{
    global $koneksi;
    $query = "INSERT INTO Absensi (id_karyawan, tanggal, jam_masuk, jam_keluar, keterangan) VALUES ('$id_karyawan', '$tanggal', '$jam_masuk', '$jam_keluar', '$keterangan')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menghapus data absensi
function hapusDataAbsensi($id)
{
    global $koneksi;
    $query = "DELETE FROM Absensi WHERE id_absensi=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mencari data absensi berdasarkan ID
function cariDataAbsensi($id)
{
    global $koneksi;
    $query = "SELECT * FROM Absensi WHERE id_absensi=$id";
    $result = mysqli_query($koneksi, $query);
    $absensi = mysqli_fetch_assoc($result);
    return $absensi;
}

// Fungsi untuk mencari karyawan berdasarkan ID
function cariKaryawan($id)
{
    global $koneksi;
    $query = "SELECT * FROM Karyawan WHERE id_karyawan=$id";
    $result = mysqli_query($koneksi, $query);
    $karyawan = mysqli_fetch_assoc($result);
    return $karyawan;
}

// Implementasi fitur tambah pengguna
if (isset($_POST['tambah'])) {
    $nama_pengguna = $_POST['nama_pengguna'];
    $password = $_POST['password'];
    $jabatan = $_POST['jabatan'];
    if (tambahkanPengguna($nama_pengguna, $password, $jabatan)) {
        echo "Pengguna berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan pengguna.";
    }
}

// Fungsi untuk menambahkan data gaji baru
function tambahkanGaji($id_karyawan, $periode, $gaji_pokok, $jumlah_absensi, $tunjangan_kinerja, $honor_pelatihan, $pajak_penghasilan)
{
    global $koneksi;
    $total_gaji = $gaji_pokok + $tunjangan_kinerja + $honor_pelatihan - $pajak_penghasilan;
    $query = "INSERT INTO Gaji (id_karyawan, periode, gaji_pokok, jumlah_absensi, tunjangan_kinerja, honor_pelatihan, pajak_penghasilan, total_gaji) VALUES ('$id_karyawan', '$periode', '$gaji_pokok', '$jumlah_absensi', '$tunjangan_kinerja', '$honor_pelatihan', '$pajak_penghasilan', '$total_gaji')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengedit data gaji
function editDataGaji($id, $id_karyawan, $periode, $gaji_pokok, $jumlah_absensi, $tunjangan_kinerja, $honor_pelatihan, $pajak_penghasilan)
{
    global $koneksi;
    $total_gaji = $gaji_pokok + $tunjangan_kinerja + $honor_pelatihan - $pajak_penghasilan;
    $query = "UPDATE Gaji SET id_karyawan='$id_karyawan', periode='$periode', gaji_pokok='$gaji_pokok', jumlah_absensi='$jumlah_absensi', tunjangan_kinerja='$tunjangan_kinerja', honor_pelatihan='$honor_pelatihan', pajak_penghasilan='$pajak_penghasilan', total_gaji='$total_gaji' WHERE id_gaji=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menghapus data gaji
function hapusDataGaji($id)
{
    global $koneksi;
    $query = "DELETE FROM Gaji WHERE id_gaji=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mencari data gaji berdasarkan ID
function cariDataGaji($id)
{
    global $koneksi;
    $query = "SELECT * FROM Gaji WHERE id_gaji=$id";
    $result = mysqli_query($koneksi, $query);
    $gaji = mysqli_fetch_assoc($result);
    return $gaji;
}

// Fungsi untuk menambahkan penilaian kinerja baru
function tambahkanPenilaian($id_karyawan, $periode, $penilaian, $saran_rekomendasi)
{
    global $koneksi;
    $query = "INSERT INTO Kinerja (id_karyawan, periode, penilaian, saran_rekomendasi) VALUES ('$id_karyawan', '$periode', '$penilaian', '$saran_rekomendasi')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengedit informasi penilaian kinerja
function editInformasiPenilaian($id, $id_karyawan, $periode, $penilaian, $saran_rekomendasi)
{
    global $koneksi;
    $query = "UPDATE Kinerja SET id_karyawan='$id_karyawan', periode='$periode', penilaian='$penilaian', saran_rekomendasi='$saran_rekomendasi' WHERE id_kinerja=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menghapus penilaian kinerja
function hapusPenilaian($id)
{
    global $koneksi;
    $query = "DELETE FROM Kinerja WHERE id_kinerja=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mencari penilaian kinerja berdasarkan ID
function cariPenilaian($id)
{
    global $koneksi;
    $query = "SELECT * FROM Kinerja WHERE id_kinerja=$id";
    $result = mysqli_query($koneksi, $query);
    $penilaian = mysqli_fetch_assoc($result);
    return $penilaian;
}

// Fungsi untuk menambahkan pelatihan baru
function tambahkanPelatihan($nama_pelatihan, $tanggal_mulai, $tanggal_selesai, $lokasi, $durasi, $biaya)
{
    global $koneksi;
    $query = "INSERT INTO Pelatihan (nama_pelatihan, tanggal_mulai, tanggal_selesai, lokasi, durasi, biaya) VALUES ('$nama_pelatihan', '$tanggal_mulai', '$tanggal_selesai', '$lokasi', '$durasi', '$biaya')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengedit informasi pelatihan
function editInformasiPelatihan($id, $nama_pelatihan, $tanggal_mulai, $tanggal_selesai, $lokasi, $durasi, $biaya)
{
    global $koneksi;
    $query = "UPDATE Pelatihan SET nama_pelatihan='$nama_pelatihan', tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai', lokasi='$lokasi', durasi='$durasi', biaya='$biaya' WHERE id_pelatihan=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menghapus pelatihan
function hapusPelatihan($id)
{
    global $koneksi;
    $query = "DELETE FROM Pelatihan WHERE id_pelatihan=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mencari pelatihan berdasarkan ID
function cariPelatihan($id)
{
    global $koneksi;
    $query = "SELECT * FROM Pelatihan WHERE id_pelatihan=$id";
    $result = mysqli_query($koneksi, $query);
    $pelatihan = mysqli_fetch_assoc($result);
    return $pelatihan;
}

// Fungsi untuk menambahkan pengguna baru
function tambahkanPengguna($nama_pengguna, $password, $jabatan)
{
    global $koneksi;
    $query = "INSERT INTO Pengguna (nama_pengguna, password, jabatan) VALUES ('$nama_pengguna', '$password', '$jabatan')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengedit informasi pengguna
function editInformasiPengguna($id, $nama_pengguna, $password, $jabatan)
{
    global $koneksi;
    $query = "UPDATE Pengguna SET nama_pengguna='$nama_pengguna', password='$password', jabatan='$jabatan' WHERE id_pengguna=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mengambil informasi pengguna berdasarkan ID Karyawan
function getPenggunaById($id_karyawan)
{
    global $koneksi;

    // Query SQL untuk mengambil informasi pengguna berdasarkan ID Karyawan
    $sql = "SELECT * FROM pengguna WHERE id_karyawan = '$id_karyawan'";

    // Eksekusi query
    $result = mysqli_query($koneksi, $sql);

    // Periksa apakah query berhasil dieksekusi dan apakah data pengguna ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // Mengembalikan nilai null jika pengguna tidak ditemukan
    }
}

// Fungsi untuk memperbarui informasi pengguna
function updatePengguna($id_karyawan, $nama_pengguna, $password, $jabatan)
{
    global $koneksi;

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query SQL untuk memperbarui informasi pengguna
    $sql = "UPDATE pengguna SET nama_pengguna = '$nama_pengguna', password = '$hashed_password', jabatan = '$jabatan' WHERE id_karyawan = '$id_karyawan'";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        return true; // Mengembalikan true jika pembaruan berhasil
    } else {
        return false; // Mengembalikan false jika terjadi kesalahan dalam pembaruan
    }
}

// Fungsi untuk menghapus pengguna
function hapusPengguna($id)
{
    global $koneksi;
    $query = "DELETE FROM Pengguna WHERE id_pengguna=$id";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk mencari pengguna berdasarkan ID
function cariPengguna($id)
{
    global $koneksi;
    $query = "SELECT * FROM Pengguna WHERE id_pengguna=$id";
    $result = mysqli_query($koneksi, $query);
    $pengguna = mysqli_fetch_assoc($result);
    return $pengguna;
}

// Fungsi untuk mendapatkan informasi karyawan berdasarkan ID Karyawan
function getKaryawanById($id_karyawan)
{
    global $koneksi;

    // Query untuk mendapatkan informasi karyawan berdasarkan ID Karyawan
    $query = "SELECT * FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah karyawan ditemukan
    if (mysqli_num_rows($result) > 0) {
        $karyawan = mysqli_fetch_assoc($result);
        return $karyawan;
    } else {
        return false; // Karyawan tidak ditemukan
    }
}


// Implementasi fitur tambah karyawan
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $departemen = $_POST['departemen'];
    if (tambahkanKaryawan($nama, $jenis_kelamin, $tanggal_lahir, $alamat, $telepon, $email, $status, $departemen)) {
        echo "Karyawan berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan karyawan.";
    }
}

// Implementasi fitur tambah penilaian kinerja
if (isset($_POST['tambah'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $periode = $_POST['periode'];
    $penilaian = $_POST['penilaian'];
    $saran_rekomendasi = $_POST['saran_rekomendasi'];
    if (tambahkanPenilaian($id_karyawan, $periode, $penilaian, $saran_rekomendasi)) {
        echo "Penilaian kinerja berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan penilaian kinerja.";
    }
}

// Implementasi fitur edit penilaian kinerja
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $id_karyawan = $_POST['id_karyawan'];
    $periode = $_POST['periode'];
    $penilaian = $_POST['penilaian'];
    $saran_rekomendasi = $_POST['saran_rekomendasi'];
    if (editInformasiPenilaian($id, $id_karyawan, $periode, $penilaian, $saran_rekomendasi)) {
        echo "Informasi penilaian kinerja berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui informasi penilaian kinerja.";
    }
}

// Implementasi fitur hapus penilaian kinerja
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if (hapusPenilaian($id)) {
        echo "Penilaian kinerja berhasil dihapus.";
    } else {
        echo "Gagal menghapus penilaian kinerja.";
    }
}
// Implementasi fitur edit karyawan
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $departemen = $_POST['departemen'];
    if (editInformasiKaryawan($id, $nama, $jenis_kelamin, $tanggal_lahir, $alamat, $telepon, $email, $status, $departemen)) {
        echo "Informasi karyawan berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui informasi karyawan.";
    }
}

// Implementasi fitur hapus karyawan
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if (hapusKaryawan($id)) {
        echo "Karyawan berhasil dihapus.";
    } else {
        echo "Gagal menghapus karyawan.";
    }
}

// Implementasi fitur tambah karyawan
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $departemen = $_POST['departemen'];
    if (tambahkanKaryawan($nama, $jenis_kelamin, $tanggal_lahir, $alamat, $telepon, $email, $status, $departemen)) {
        echo "Karyawan berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan karyawan.";
    }
}

// Implementasi fitur edit karyawan
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $departemen = $_POST['departemen'];
    if (editInformasiKaryawan($id, $nama, $jenis_kelamin, $tanggal_lahir, $alamat, $telepon, $email, $status, $departemen)) {
        echo "Informasi karyawan berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui informasi karyawan.";
    }
}

// Implementasi fitur hapus karyawan
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if (hapusKaryawan($id)) {
        echo "Karyawan berhasil dihapus.";
    } else {
        echo "Gagal menghapus karyawan.";
    }
}

// Implementasi fitur tambah data absensi
if (isset($_POST['tambah'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    $keterangan = $_POST['keterangan'];
    if (tambahkanAbsensi($id_karyawan, $tanggal, $jam_masuk, $jam_keluar, $keterangan)) {
        echo "Data absensi berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan data absensi.";
    }
}
// Implementasi fitur edit data absensi
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    $keterangan = $_POST['keterangan'];
    if (editDataAbsensi($id, $id_karyawan, $tanggal, $jam_masuk, $jam_keluar, $keterangan)) {
        echo "Data absensi berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui data absensi.";
    }
}

// Implementasi fitur hapus data absensi
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if (hapusDataAbsensi($id)) {
        echo "Data absensi berhasil dihapus.";
    } else {
        echo "Gagal menghapus data absensi.";
    }
}

// Implementasi fitur tambah data gaji
if (isset($_POST['tambah'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $periode = $_POST['periode'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $jumlah_absensi = $_POST['jumlah_absensi'];
    $tunjangan_kinerja = $_POST['tunjangan_kinerja'];
    $honor_pelatihan = $_POST['honor_pelatihan'];
    $pajak_penghasilan = $_POST['pajak_penghasilan'];
    if (tambahkanGaji($id_karyawan, $periode, $gaji_pokok, $jumlah_absensi, $tunjangan_kinerja, $honor_pelatihan, $pajak_penghasilan)) {
        echo "Data gaji berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan data gaji.";
    }
}

// Implementasi fitur edit data gaji
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $id_karyawan = $_POST['id_karyawan'];
    $periode = $_POST['periode'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $jumlah_absensi = $_POST['jumlah_absensi'];
    $tunjangan_kinerja = $_POST['tunjangan_kinerja'];
    $honor_pelatihan = $_POST['honor_pelatihan'];
    $pajak_penghasilan = $_POST['pajak_penghasilan'];
    if (editDataGaji($id, $id_karyawan, $periode, $gaji_pokok, $jumlah_absensi, $tunjangan_kinerja, $honor_pelatihan, $pajak_penghasilan)) {
        echo "Data gaji berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui data gaji.";
    }
}
// Implementasi fitur hapus data gaji
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if (hapusDataGaji($id)) {
        echo "Data gaji berhasil dihapus.";
    } else {
        echo "Gagal menghapus data gaji.";
    }
}

// Implementasi fitur tambah pelatihan
if (isset($_POST['tambah'])) {
    $nama_pelatihan = $_POST['nama_pelatihan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $lokasi = $_POST['lokasi'];
    $durasi = $_POST['durasi'];
    $biaya = $_POST['biaya'];
    if (tambahkanPelatihan($nama_pelatihan, $tanggal_mulai, $tanggal_selesai, $lokasi, $durasi, $biaya)) {
        echo "Pelatihan berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan pelatihan.";
    }
}
// Implementasi fitur edit pelatihan
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_pelatihan = $_POST['nama_pelatihan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $lokasi = $_POST['lokasi'];
    $durasi = $_POST['durasi'];
    $biaya = $_POST['biaya'];
    if (editInformasiPelatihan($id, $nama_pelatihan, $tanggal_mulai, $tanggal_selesai, $lokasi, $durasi, $biaya)) {
        echo "Informasi pelatihan berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui informasi pelatihan.";
    }
}

// Implementasi fitur hapus pelatihan
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if (hapusPelatihan($id)) {
        echo "Pelatihan berhasil dihapus.";
    } else {
        echo "Gagal menghapus pelatihan.";
    }
}

// Implementasi fitur tambah pengguna
if (isset($_POST['tambah'])) {
    $nama_pengguna = $_POST['nama_pengguna'];
    $password = $_POST['password'];
    $jabatan = $_POST['jabatan'];
    if (tambahkanPengguna($nama_pengguna, $password, $jabatan)) {
        echo "Pengguna berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan pengguna.";
    }
}

// Implementasi fitur edit pengguna
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $password = $_POST['password'];
    $jabatan = $_POST['jabatan'];
    if (editInformasiPengguna($id, $nama_pengguna, $password, $jabatan)) {
        echo "Informasi pengguna berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui informasi pengguna.";
    }
}

// Implementasi fitur hapus pengguna
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if (hapusPengguna($id)) {
        echo "Pengguna berhasil dihapus.";
    } else {
        echo "Gagal menghapus pengguna.";
    }
}

// Fungsi untuk mengupdate data karyawan, termasuk foto jika diubah
function updateKaryawan($id_karyawan, $foto)
{
    global $koneksi;

    // Mendapatkan data dari form
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $alamat = $_POST["alamat"];
    $telepon = $_POST["telepon"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    $jabatan = $_POST["jabatan"];

    // Query untuk mengupdate data karyawan
    $query = "UPDATE karyawan SET nama='$nama', jenis_kelamin='$jenis_kelamin', tanggal_lahir='$tanggal_lahir', alamat='$alamat', telepon='$telepon', email='$email', status='$status', jabatan='$jabatan', foto='$foto' WHERE id_karyawan='$id_karyawan'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo "Data karyawan berhasil diperbarui.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
