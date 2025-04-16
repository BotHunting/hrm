-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 16 Apr 2025 pada 13.02
-- Versi server: 8.0.40
-- Versi PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim_hrm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_karyawan` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_karyawan`, `tanggal`, `jam_masuk`, `jam_keluar`, `keterangan`, `nama`) VALUES
(69, 2024001, '2024-02-27', '11:42:01', '11:42:40', 'Hadir', 'Jamal'),
(70, 2024002, '2024-02-27', '11:43:11', '11:43:19', 'Hadir', 'Malika'),
(72, 2024003, '2024-02-27', '00:00:00', '00:00:00', 'Izin', NULL),
(73, 2024004, '2024-02-27', '00:00:00', '00:00:00', 'Izin', NULL),
(74, 2024005, '2024-02-27', '11:49:43', '11:49:52', 'Hadir', 'Putri'),
(75, 2024006, '2024-02-27', '11:49:57', '11:50:03', 'Hadir', 'Kim Jong Un'),
(76, 2024007, '2024-02-27', '11:50:08', '11:50:12', 'Hadir', 'Ajeng'),
(77, 2024008, '2024-02-27', '11:50:17', '11:50:40', 'Hadir', 'Linda'),
(78, 2024009, '2024-02-27', '00:00:00', '00:00:00', 'Sakit', NULL),
(79, 2024010, '2024-02-28', '16:36:02', '22:11:25', 'Hadir', 'Jhony'),
(80, 2024013, '2024-03-02', '15:58:17', '15:59:00', 'Hadir', 'user'),
(81, 2024011, '2024-03-02', '15:58:23', '15:58:54', 'Hadir', 'Thomas'),
(82, 2024012, '2024-03-02', '15:58:32', '15:58:58', 'Hadir', 'Arthur'),
(83, 2024014, '2024-03-02', '15:58:45', '15:59:02', 'Hadir', 'admin'),
(84, 2024015, '2024-03-02', '15:58:47', '15:59:04', 'Hadir', 'ceo'),
(85, 2024001, '2024-03-02', '16:56:51', NULL, 'Hadir', NULL),
(86, 2024007, '2024-03-02', '17:35:49', '17:44:24', 'Hadir', NULL),
(87, 2024006, '2024-03-02', '21:11:50', '21:11:53', 'Hadir', NULL),
(88, 2024014, '2024-03-03', '14:34:54', '14:34:58', 'Hadir', NULL),
(89, 2024014, '2024-03-04', '14:57:22', '15:11:53', 'Hadir', NULL),
(90, 2024014, '2024-03-05', '18:20:33', '18:20:44', 'Hadir', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_laporan`
--

CREATE TABLE `absensi_laporan` (
  `id` int NOT NULL,
  `id_karyawan` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alasan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi_laporan`
--

INSERT INTO `absensi_laporan` (`id`, `id_karyawan`, `nama`, `tanggal`, `jam_masuk`, `jam_keluar`, `keterangan`, `alasan`) VALUES
(40, 2024001, 'Jamal', '2024-02-27', '11:42:01', '11:42:40', 'Hadir', ''),
(41, 2024002, 'Malika', '2024-02-27', '11:43:11', '11:43:19', 'Hadir', ''),
(43, 2024003, 'Michael', '2024-02-27', '00:00:00', '00:00:00', 'Izin', 'pulang'),
(44, 2024004, 'Irfan', '2024-02-27', '00:00:00', '00:00:00', 'Izin', 'minggat'),
(45, 2024005, 'Putri', '2024-02-27', '11:49:43', '11:49:52', 'Hadir', ''),
(46, 2024006, 'Kim Jong Un', '2024-02-27', '11:49:57', '11:50:03', 'Hadir', ''),
(47, 2024007, 'Ajeng', '2024-02-27', '11:50:08', '11:50:12', 'Hadir', ''),
(48, 2024009, 'Mirna', '2024-02-27', '00:00:00', '00:00:00', 'Sakit', 'Keracunan'),
(49, 2024008, 'Linda', '2024-02-27', '11:50:17', '11:50:40', 'Hadir', ''),
(50, 2024010, 'Jhony', '2024-02-28', '16:36:02', '22:11:25', 'Hadir', ''),
(51, 2024011, 'Thomas', '2024-03-02', '15:58:23', '15:58:54', 'Hadir', ''),
(52, 2024012, 'Arthur', '2024-03-02', '15:58:32', '15:58:58', 'Hadir', ''),
(53, 2024013, 'user', '2024-03-02', '15:58:17', '15:59:00', 'Hadir', ''),
(54, 2024014, 'admin', '2024-03-02', '15:58:45', '15:59:02', 'Hadir', ''),
(55, 2024015, 'ceo', '2024-03-02', '15:58:47', '15:59:04', 'Hadir', ''),
(56, 2024007, 'Ajeng', '2024-03-02', '17:35:49', '17:44:24', 'Hadir', ''),
(57, 2024006, 'Kim Jong Un', '2024-03-02', '21:11:50', '21:11:53', 'Hadir', ''),
(58, 2024014, 'admin', '2024-03-03', '14:34:54', '14:34:58', 'Hadir', ''),
(59, 2024014, 'admin', '2024-03-04', '14:57:22', '15:11:53', 'Hadir', ''),
(60, 2024014, 'admin', '2024-03-05', '18:20:33', '18:20:44', 'Hadir', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gaji`
--

CREATE TABLE `gaji` (
  `id_gaji` int NOT NULL,
  `id_karyawan` int NOT NULL,
  `bulan` int NOT NULL,
  `tahun` int DEFAULT NULL,
  `gaji_pokok` int NOT NULL,
  `jumlah_absensi` int NOT NULL,
  `tunjangan_kinerja` int NOT NULL,
  `jumlah_honor` int NOT NULL,
  `pajak_penghasilan` int NOT NULL,
  `total_gaji` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gaji`
--

INSERT INTO `gaji` (`id_gaji`, `id_karyawan`, `bulan`, `tahun`, `gaji_pokok`, `jumlah_absensi`, `tunjangan_kinerja`, `jumlah_honor`, `pajak_penghasilan`, `total_gaji`, `nama`) VALUES
(14, 2024001, 1, 2024, 95000, 20, 71, 0, 2375, 2266825, 'Jamal'),
(18, 2024002, 1, 2024, 75000, 22, 78, 0, 1875, 2053725, 'Malika'),
(19, 2024002, 2, 2024, 85000, 22, 81, 0, 2125, 2289075, 'Malika'),
(20, 2024003, 1, 2024, 125000, 23, 76, 0, 3125, 3267075, 'Michael'),
(23, 2024004, 5, 2024, 96154, 21, 74, 0, 2404, 2401630, 'Irfan'),
(24, 2024007, 3, 2024, 288462, 21, 50, 0, 7212, 6310490, 'Ajeng');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gaji_laporan`
--

CREATE TABLE `gaji_laporan` (
  `id_gaji` int NOT NULL,
  `id_karyawan` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bulan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun` int NOT NULL,
  `gaji_pokok` int NOT NULL,
  `jumlah_absensi` int NOT NULL,
  `tunjangan_kinerja` int NOT NULL,
  `jumlah_honor` int NOT NULL,
  `pajak_penghasilan` int NOT NULL,
  `total_gaji` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gaji_laporan`
--

INSERT INTO `gaji_laporan` (`id_gaji`, `id_karyawan`, `nama`, `bulan`, `tahun`, `gaji_pokok`, `jumlah_absensi`, `tunjangan_kinerja`, `jumlah_honor`, `pajak_penghasilan`, `total_gaji`) VALUES
(2, 2024001, 'Jamal', '1', 2024, 130000, 20, 80, 0, 3250, 3012750),
(3, 2024001, 'Jamal', '2', 2024, 78000, 22, 74, 0, 3000, 2098850),
(4, 2024001, 'Jamal', '3', 2024, 100000, 21, 72, 0, 2500, 2471900),
(5, 2024001, 'Jamal', '2', 2024, 78000, 22, 74, 0, 3250, 2098850),
(6, 2024001, 'Jamal', '4', 2024, 95000, 20, 71, 0, 2375, 2266825),
(7, 2024002, 'Malika', '1', 2024, 96154, 21, 66, 0, 1875, 2360030),
(8, 2024002, 'Malika', '2', 2024, 85000, 22, 81, 0, 2125, 2289075),
(9, 2024003, 'Michael', '1', 2024, 125000, 23, 76, 0, 3125, 3267075),
(12, 2024004, 'Irfan', '5', 2024, 96154, 21, 74, 0, 2404, 2401630),
(13, 2024007, 'Ajeng', '3', 2024, 288462, 21, 50, 0, 7212, 6310490);

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telepon` int DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `upah` int DEFAULT NULL,
  `gaji_harian` int DEFAULT NULL,
  `foto` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `telepon`, `email`, `status`, `jabatan`, `upah`, `gaji_harian`, `foto`) VALUES
(2024001, 'Jamal', 'Laki-laki', '2017-02-15', 'Jakarta', 8245, 'malika@malika', 'Lajang', 'Pramusaji', 2000000, 76923, 0x323032343031372e6a7067),
(2024002, 'Malika', 'Perempuan', '2010-01-01', 'Johor', 83, 'malika@malika', 'Lajang', 'Stock Keeper', 2500000, 96154, 0x323032343031372e6a7067),
(2024003, 'Michael Gray', 'Laki-laki', '2008-03-10', 'Surabaya', 34568, 'awdawd@kjnkjn', 'Lajang', 'Koki Staff', 2500000, 96154, 0x323032343031372e6a7067),
(2024004, 'Irfan', 'Laki-laki', '2012-05-23', 'Jayapura', 531861, 'irfan@meme', 'Lajang', 'Bartender', 2500000, 96154, 0x323032343031372e6a7067),
(2024005, 'Putri', 'Perempuan', '2010-05-02', 'Sabah', 52151, 'putri@kjnasd', 'Lajang', 'Quality Control', 3250000, 125000, 0x323032343031372e6a7067),
(2024006, 'Kim Jong Un', 'Laki-laki', '2006-03-14', 'Korsel', 6516515, 'kim@jong', 'Menikah', 'Kapten Pelayanan', 4000000, 153846, 0x323032343031372e6a7067),
(2024007, 'Ajeng', 'Perempuan', '2008-01-28', 'Lampung', 8545, 'ajeng@ajeng', 'Lajang', 'Manajer Keuangan', 7500000, 288462, 0x75706c6f6164732f746f6d61732e6a7067),
(2024008, 'Linda Shelby', 'Perempuan', '2001-07-22', 'Riau', 84621, 'linda@linda', 'Lajang', 'Staf Pemasaran', 3250000, 125000, 0x323032343031372e6a7067),
(2024009, 'Lizzie Shelby', 'Perempuan', '2002-04-01', 'Jakarta', 824794, 'mirna@mirna', 'Lajang', 'Asisten Juru Masak', 2000000, 76923, 0x323032343031372e6a7067),
(2024010, 'John Shelby', 'Laki-laki', '2000-02-28', 'Ancol', 827, 'jony@yespapa', 'Lajang', 'Bartender', 2500000, 96154, 0x323032343031372e6a7067),
(2024011, 'Thomas Shelby', 'Laki-laki', '1999-02-25', 'Birmingham', 2147483647, 'thomas@selby', 'Lajang', 'Manajer SDM', 7500000, 288462, 0x75706c6f6164732f746f6d61732e6a7067),
(2024012, 'Arthur Shelby', 'Laki-laki', '1996-08-13', 'Birmingham', 214657, 'arthur@shelby', 'Lajang', 'Manajer Administrasi', 6000000, 230769, 0x696d6167652f323032343031322e6a7067),
(2024013, 'user', 'Laki-laki', '2000-04-13', 'user', 123456789, 'user@user', 'Lajang', 'Kapten Pelayanan', 4000000, 153846, 0x696d6167652f323032343031332e6a7067),
(2024014, 'admin', 'Perempuan', '1999-03-02', 'admin', 1234565789, 'admin@admin.com', 'Lajang', 'Manajer SDM', 7500000, 288462, 0x696d6167652f323032343031342e6a7067),
(2024015, 'ceo', 'Laki-laki', '2000-08-30', 'ceo', 3258465, 'ceo@ceo.com', 'Lajang', 'Pemilik Usaha', 0, 0, 0x696d6167652f323032343031352e6a7067),
(2024016, 'Polly Gray', 'Perempuan', '1980-03-02', 'london', 21314511, 'polly@selby', 'Menikah', 'Bartender', 2500000, 96154, 0x696d6167652f323032343031362e6a7067),
(2024017, 'Grace Burgess', 'Perempuan', '1991-02-24', 'Irland', 213457654, 'grace@selby', 'Lajang', 'Asisten Juru Masak', 2000000, 76923, 0x323032343031372e6a7067),
(2024018, 'Billy Kimber', 'Laki-laki', '2000-02-02', 'Boston', 31561511, 'Billy@Kimber', 'Lajang', 'Juru Masak', 3250000, 125000, 0x323032343031382e6a7067),
(2024019, 'Ada Shelby', 'Perempuan', '1999-06-12', 'London', 3155488, 'ada@shelby', 'Lajang', 'Juru Cuci', 1600000, 61538, 0x323032343031392e6a7067),
(2024020, 'Finn Shelby', 'Laki-laki', '2000-08-16', 'Moskow', 316497, 'finn@shelby', 'Lajang', 'Koki Staff', 2500000, 96154, 0x323032343032302e6a7067),
(2024021, 'Charlie Strong', 'Laki-laki', '1985-08-28', 'Londono', 3454846, 'Charlie@Strong', 'Lajang', 'Kurir', 2000000, 76923, 0x323032343032312e6a7067),
(2024022, 'Jeremiah Jesus', 'Laki-laki', '1986-07-18', 'Boston', 3254587, 'Jeremiah@Jesus', 'Menikah', 'Penasihat', 7500000, 288462, 0x323032343032322e6a7067),
(2024023, 'Curly', 'Laki-laki', '1980-04-09', 'birmingham', 31578, 'Curly@selby', 'Menikah', 'Stock Keeper', 2500000, 96154, 0x323032343032332e6a7067),
(2024024, 'Johnny Dogs', 'Laki-laki', '1982-04-08', 'Lisbon', 34678, 'Johnny@Dogs', 'Menikah', 'Manajer Produksi', 7500000, 288462, 0x323032343032342e6a7067),
(2024025, 'Gina Gray', 'Perempuan', '1996-07-06', 'New York', 31485, 'Gina@Gray', 'Menikah', 'Akuntan Usaha', 4000000, 153846, 0x323032343032352e6a7067),
(2024026, 'Aberama Gold', 'Laki-laki', '1984-04-19', 'Boston', 31248484, 'Aberama@Gold', 'Menikah', 'Security', 3000000, 115385, 0x323032343032362e6a7067),
(2024027, 'Alfie Solomons', 'Laki-laki', '1988-08-03', 'jerman', 712452, 'Alfie@Solomons', 'Lajang', 'Penasihat', 7500000, 288462, 0x323032343032372e6a7067),
(2024028, 'Oswald Mosley', 'Laki-laki', '1982-06-19', 'Boston', 34575, 'Oswald@Mosley', 'Lajang', 'Quality Control', 3250000, 125000, 0x323032343032382e6a7067),
(2024029, 'Luca Changretta', 'Laki-laki', '1985-02-04', 'mesopotamia', 3164898, 'Luca@Changretta', 'Lajang', 'Staf Pemasaran', 3250000, 125000, 0x323032343032392e6a7067);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kinerja`
--

CREATE TABLE `kinerja` (
  `id_kinerja` int NOT NULL,
  `id_karyawan` int DEFAULT NULL,
  `bulan` int DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `penilaian` int DEFAULT NULL,
  `kategori_penilaian` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kinerja`
--

INSERT INTO `kinerja` (`id_kinerja`, `id_karyawan`, `bulan`, `tahun`, `penilaian`, `kategori_penilaian`) VALUES
(33, 2024001, 1, 2024, 83, 'Sangat Baik'),
(36, 2024001, 2, 2024, 73, 'Baik'),
(37, 2024002, 1, 2024, 66, 'Baik'),
(38, 2024002, 2, 2024, 69, 'Baik'),
(39, 2024003, 1, 2024, 69, 'Baik'),
(40, 2024003, 2, 2024, 78, 'Baik'),
(41, 2024004, 1, 2024, 77, 'Baik'),
(42, 2024005, 1, 2024, 62, 'Baik'),
(43, 2024006, 1, 2024, 70, 'Baik'),
(44, 2024001, 3, 2024, 76, 'Baik'),
(45, 2024002, 3, 2024, 66, 'Baik'),
(46, 2024003, 3, 2024, 50, 'Cukup Kurang'),
(47, 2024004, 3, 2024, 75, 'Baik'),
(48, 2024005, 3, 2024, 50, 'Cukup Kurang'),
(49, 2024006, 3, 2024, 50, 'Cukup Kurang'),
(50, 2024007, 3, 2024, 50, 'Cukup Kurang'),
(51, 2024008, 3, 2024, 77, 'Baik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kinerja_laporan`
--

CREATE TABLE `kinerja_laporan` (
  `id_kinerja` int NOT NULL,
  `id_karyawan` int DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bulan` int DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `penilaian` decimal(5,0) DEFAULT NULL,
  `kategori_penilaian` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `saran_rekomendasi` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kinerja_laporan`
--

INSERT INTO `kinerja_laporan` (`id_kinerja`, `id_karyawan`, `nama`, `bulan`, `tahun`, `penilaian`, `kategori_penilaian`, `saran_rekomendasi`) VALUES
(34, 2024001, 'Jamal', 1, 2024, 83, 'Sangat Baik', 'good'),
(37, 2024001, 'Jamal', 2, 2024, 73, 'Baik', 'giat'),
(38, 2024002, 'Malika', 1, 2024, 66, 'Baik', 'semangat'),
(39, 2024002, 'Malika', 2, 2024, 69, 'Baik', 'giat'),
(40, 2024003, 'Michael', 1, 2024, 69, 'Baik', 'giat'),
(41, 2024003, 'Michael', 2, 2024, 78, 'Baik', 'amazing'),
(42, 2024004, 'Irfan', 1, 2024, 77, 'Baik', 'good'),
(43, 2024005, 'Putri', 1, 2024, 62, 'Baik', 'Nice'),
(44, 2024006, 'Kim Jong Un', 1, 2024, 70, 'Baik', 'Good'),
(45, 2024001, 'Jamal', 3, 2024, 76, 'Baik', 'good'),
(46, 2024002, 'Malika', 3, 2024, 66, 'Baik', 'nice'),
(47, 2024003, 'Michael', 3, 2024, 50, 'Cukup Kurang', 'good'),
(48, 2024004, 'Irfan', 3, 2024, 75, 'Baik', 'nice'),
(49, 2024005, 'Putri', 3, 2024, 50, 'Cukup Kurang', 'good'),
(50, 2024006, 'Kim Jong Un', 3, 2024, 50, 'Cukup Kurang', 'nice'),
(51, 2024007, 'Ajeng', 3, 2024, 50, 'Cukup Kurang', 'well'),
(52, 2024008, 'Linda', 3, 2024, 77, 'Baik', 'well');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelatihan`
--

CREATE TABLE `pelatihan` (
  `id_pelatihan` int NOT NULL,
  `nama_pelatihan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `lokasi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `durasi` int NOT NULL,
  `biaya` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelatihan`
--

INSERT INTO `pelatihan` (`id_pelatihan`, `nama_pelatihan`, `tanggal_mulai`, `tanggal_selesai`, `lokasi`, `durasi`, `biaya`) VALUES
(1, 'Master Sheff', '2024-02-12', '2024-02-20', 'Surabaya', 20, 1000000),
(2, 'Cooking Contest', '2024-02-23', '2024-02-23', 'Jakarta', 4, 200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_karyawan` int NOT NULL,
  `nama_pengguna` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_karyawan`, `nama_pengguna`, `password`, `jabatan`) VALUES
(2024001, '2024001', '$2y$10$p5Q/5uRgIse1PDztE9vNkudycSyLiOK0vOWNepy0kRkhQZF7D4Nia', 'karyawan'),
(2024002, '2024002', '$2y$10$XX8lEO/tljX5ncfIBMpBCeTTykI2.qiUrNvz.SJ2QTmxYwWkTx6z6', 'karyawan'),
(2024006, '2024006', '$2y$10$BjckGhv.O4Cdb4AyBnZHL.7bKpCiHIhdOEId/X93e7rHlnw/OUKY6', 'karyawan'),
(2024007, '2024007', '$2y$10$djwONVuU6McN2QCXmU7j3uYgnSCrJ.ocnVWYVPKq0Gr5HGNdS.xFe', 'admin'),
(2024011, '2024011', '$2y$10$Kemfsw0HEXJdJQRvGnolhudeuPYNiAKf6STgAo7Zv4NYlOsnU8YUa', 'admin'),
(2024013, 'user', '$2y$10$l3bDocJvljGwYXCwcLFY2.xOSNSNtirsDSkMFN7o0Ce2htD6cd8ky', 'karyawan'),
(2024014, 'admin', '$2y$10$Ve/H/uAvGQMVVOVqGksr8uah9H8y6paI814hgjjVWaLpu7zzTRiCO', 'admin'),
(2024015, 'ceo', '$2y$10$VXzWO1CXHsmzL.p18Ar2O.BqmqTnPhfIso1fDhpVznBdVX4Z29hhW', 'ceo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta_pelatihan`
--

CREATE TABLE `peserta_pelatihan` (
  `id_peserta` int NOT NULL,
  `id_pelatihan` int DEFAULT NULL,
  `id_karyawan` int DEFAULT NULL,
  `biaya` int DEFAULT NULL,
  `nilai` int DEFAULT NULL,
  `honor_pelatihan` int DEFAULT NULL,
  `nama_peserta` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pelatihan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peserta_pelatihan`
--

INSERT INTO `peserta_pelatihan` (`id_peserta`, `id_pelatihan`, `id_karyawan`, `biaya`, `nilai`, `honor_pelatihan`, `nama_peserta`, `nama_pelatihan`) VALUES
(40, 1, 2024001, 1000000, 75, 750000, 'Jamal', 'Master Sheff'),
(41, 1, 2024002, 1000000, 72, 720000, 'Malika', 'Master Sheff'),
(42, 1, 2024003, 1000000, 72, 720000, 'Michael', 'Master Sheff'),
(43, 2, 2024002, 200000, 79, 158000, 'Malika', 'Cooking Contest'),
(44, 2, 2024003, 200000, 78, 156000, 'Michael', 'Cooking Contest'),
(45, 2, 2024004, 200000, 36, 72000, 'Irfan', 'Cooking Contest'),
(46, 1, 2024004, 1000000, 51, 510000, 'Irfan', 'Master Sheff'),
(47, 2, 2024006, 200000, 30, 60000, 'Kim Jong Un', 'Cooking Contest');

-- --------------------------------------------------------

--
-- Struktur dari tabel `salary`
--

CREATE TABLE `salary` (
  `id_jabatan` int NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `upah` int NOT NULL,
  `gaji_harian` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `salary`
--

INSERT INTO `salary` (`id_jabatan`, `jabatan`, `upah`, `gaji_harian`) VALUES
(1, 'Juru Masak', 3250000, 125000),
(2, 'Asisten Juru Masak', 2600000, 100000),
(3, 'Juru Cuci', 1600000, 61538),
(4, 'Kapten Pelayanan', 4000000, 153846),
(5, 'Pemilik Usaha', 10000000, 384615),
(6, 'Penasihat', 7500000, 288462),
(7, 'Manajer SDM', 7500000, 288462),
(8, 'Manajer Keuangan', 7500000, 288462),
(9, 'Manajer Produksi', 7500000, 288462),
(10, 'Manajer Pemasaran', 7500000, 288462),
(11, 'Manajer Administrasi', 6000000, 230769),
(12, 'Stock Keeper', 2500000, 96154),
(13, 'Quality Control', 3250000, 125000),
(14, 'Pramusaji', 2000000, 76923),
(15, 'Kurir', 2000000, 76923),
(16, 'Akuntan Usaha', 4000000, 153846),
(17, 'Koki Staff', 2500000, 96154),
(18, 'Bartender', 2500000, 96154),
(19, 'Staf Pemasaran', 3250000, 125000),
(20, 'Security', 3000000, 115385);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_karyawan` (`id_karyawan`),
  ADD KEY `id_karyawan_2` (`id_karyawan`);

--
-- Indeks untuk tabel `absensi_laporan`
--
ALTER TABLE `absensi_laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `gaji_laporan`
--
ALTER TABLE `gaji_laporan`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `kinerja`
--
ALTER TABLE `kinerja`
  ADD PRIMARY KEY (`id_kinerja`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `kinerja_laporan`
--
ALTER TABLE `kinerja_laporan`
  ADD PRIMARY KEY (`id_kinerja`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  ADD PRIMARY KEY (`id_pelatihan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `peserta_pelatihan`
--
ALTER TABLE `peserta_pelatihan`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `id_pelatihan` (`id_pelatihan`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT untuk tabel `absensi_laporan`
--
ALTER TABLE `absensi_laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id_gaji` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `gaji_laporan`
--
ALTER TABLE `gaji_laporan`
  MODIFY `id_gaji` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kinerja`
--
ALTER TABLE `kinerja`
  MODIFY `id_kinerja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `kinerja_laporan`
--
ALTER TABLE `kinerja_laporan`
  MODIFY `id_kinerja` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  MODIFY `id_pelatihan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2024017;

--
-- AUTO_INCREMENT untuk tabel `peserta_pelatihan`
--
ALTER TABLE `peserta_pelatihan`
  MODIFY `id_peserta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `salary`
--
ALTER TABLE `salary`
  MODIFY `id_jabatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `gaji_laporan`
--
ALTER TABLE `gaji_laporan`
  ADD CONSTRAINT `gaji_laporan_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);

--
-- Ketidakleluasaan untuk tabel `kinerja`
--
ALTER TABLE `kinerja`
  ADD CONSTRAINT `kinerja_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);

--
-- Ketidakleluasaan untuk tabel `kinerja_laporan`
--
ALTER TABLE `kinerja_laporan`
  ADD CONSTRAINT `kinerja_laporan_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);

--
-- Ketidakleluasaan untuk tabel `peserta_pelatihan`
--
ALTER TABLE `peserta_pelatihan`
  ADD CONSTRAINT `peserta_pelatihan_ibfk_1` FOREIGN KEY (`id_pelatihan`) REFERENCES `pelatihan` (`id_pelatihan`),
  ADD CONSTRAINT `peserta_pelatihan_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
