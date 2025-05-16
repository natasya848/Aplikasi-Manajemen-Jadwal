-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 07:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekap`
--

-- --------------------------------------------------------

--
-- Table structure for table `histori`
--

CREATE TABLE `histori` (
  `id_histori` int(11) NOT NULL,
  `id_klien` int(11) DEFAULT NULL,
  `id_jadwal` int(11) DEFAULT NULL,
  `tanggal_kerja` date DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `histori`
--

INSERT INTO `histori` (`id_histori`, `id_klien`, `id_jadwal`, `tanggal_kerja`, `deskripsi`, `status`, `created_at`, `updated_at`, `deleted_at`, `updated_by`) VALUES
(3, 2, 1, '2025-04-28', 'Menjelaskan komposisi asli, tidak mengandung pengawet. TP BOONK', 0, '2025-04-27 07:33:21', '2025-04-27 07:20:15', NULL, NULL),
(4, 4, 6, '2025-05-06', 'Appointment grooming untuk hewan, membawa hewan melakukan layanan grooming.', 0, '2025-05-08 01:07:57', NULL, NULL, NULL),
(5, 3, 4, '2025-05-01', 'Produk best seller, hadir dalam kemasan baru. Test hasil dan ketahanan hasil catokan', 0, '2025-04-27 14:02:39', NULL, NULL, NULL),
(8, 3, 7, '2025-05-10', 'Tes ketahanan hasil catokan dengan angin dan panas', 0, '2025-04-27 14:30:59', NULL, NULL, NULL),
(9, 4, 6, '2025-05-06', 'Appointment grooming untuk hewan, membawa hewan melakukan layanan grooming.', 0, '2025-04-27 14:39:25', NULL, NULL, NULL),
(10, 3, 8, '2025-05-08', 'Ketahanan hasil catokan dibawah terik matahari dan angin.', 0, '2025-04-29 10:41:48', NULL, NULL, NULL),
(12, 1, 10, '2025-05-14', 'Review dengan vidio naik motor tanpa mengikat rambut, untuk membuktikan perbedaan rambut rontok', 0, '2025-05-12 13:47:41', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `id_klien` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `status` enum('Terjadwal','Selesai','Batal') NOT NULL DEFAULT 'Terjadwal',
  `catatan` text DEFAULT NULL,
  `pengingat` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `statusr` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `nama_produk`, `id_klien`, `tanggal`, `jam`, `status`, `catatan`, `pengingat`, `created_at`, `updated_at`, `deleted_at`, `statusr`) VALUES
(1, 'Makaroni Maut Lvl 10', 2, '2025-04-28', '18:30:00', 'Selesai', 'Menjelaskan komposisi asli, tidak mengandung pengawet.', '2025-04-26 10:40:00', '2025-04-26 15:22:53', NULL, NULL, 0),
(3, 'Sunscreen SPF 50+', 1, '2025-04-30', '13:20:00', 'Selesai', 'Review dengan sinar UV untuk membuktikan coverage sunscreen', '2025-04-28 23:20:00', '2025-04-26 15:07:06', NULL, NULL, 0),
(4, 'Libra Hair Styler 2.0', 3, '2025-05-01', '19:30:00', 'Selesai', 'Produk best seller, hadir dalam kemasan baru. Test hasil dan ketahanan hasil catokan', '2025-04-29 12:30:00', '2025-04-27 14:02:39', NULL, NULL, 0),
(6, 'Layanan Grooming', 4, '2025-05-06', '16:15:00', 'Selesai', 'Appointment grooming untuk hewan, membawa hewan melakukan layanan grooming.', '2025-05-05 14:30:00', '2025-04-29 10:21:50', NULL, NULL, 0),
(8, 'Taurus Hair Styler 2.0', 3, '2025-05-08', '23:45:00', 'Selesai', 'Ketahanan hasil catokan dibawah terik matahari dan angin.', '2025-05-06 13:50:00', '2025-04-27 14:46:38', NULL, NULL, 0),
(9, 'Pet Diapers', 4, '2025-05-10', '12:20:00', 'Terjadwal', 'Kegunaan pet diapers untuk hewan bayi.', '2025-05-08 10:20:00', '2025-05-08 02:18:13', NULL, NULL, 0),
(10, 'Sunslik anti rontok', 1, '2025-05-14', '23:45:00', 'Selesai', 'Review dengan vidio naik motor tanpa mengikat rambut, untuk membuktikan perbedaan rambut rontok', '2025-05-13 12:00:00', '2025-05-12 13:47:41', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `klien`
--

CREATE TABLE `klien` (
  `id_klien` int(11) NOT NULL,
  `nama_klien` varchar(255) DEFAULT NULL,
  `kontak` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klien`
--

INSERT INTO `klien` (`id_klien`, `nama_klien`, `kontak`, `catatan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lumine Glow Skincare', '081122334455', 'Sediakan before-after, hasil selama 7 hari pemakaian.', 0, '2025-04-23 14:31:32', NULL, NULL),
(2, 'Raja Basreng', '081398765432', 'Endorse makaroni pedas, 2 video review.', 0, '2025-04-24 02:43:11', NULL, NULL),
(3, 'NVMEE', '083263924735', 'Catokan rambut dengan berbagai fungsi berbeda yang sedang hits', 0, '2025-04-27 08:38:49', NULL, NULL),
(4, 'Meowgic', '083232859349', 'Toko perlengkapan hewan berbasis web', 0, '2025-04-29 10:24:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `id_konten` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('Ide','Proses','Revisi','Selesai') DEFAULT NULL,
  `id_jadwal` int(11) DEFAULT NULL,
  `url_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `statusr` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`id_konten`, `judul`, `deadline`, `status`, `id_jadwal`, `url_file`, `created_at`, `updated_at`, `deleted_at`, `statusr`) VALUES
(2, 'Sunscreen SPF 50+', '2025-04-30', 'Selesai', 3, NULL, '2025-04-30 02:28:12', NULL, NULL, 0),
(3, 'Makaroni Maut Lvl 10', '2025-04-28', 'Selesai', 1, NULL, '2025-04-27 07:20:15', NULL, NULL, 0),
(4, 'Layanan Grooming', '2025-05-06', 'Selesai', 6, NULL, '2025-04-27 14:39:25', NULL, NULL, 0),
(5, 'Libra Hair Styler 2.0', '2025-05-01', 'Selesai', 4, NULL, '2025-04-29 10:24:01', NULL, NULL, 0),
(8, 'Taurus Hair Styler 2.0', '2025-05-08', 'Selesai', 8, NULL, '2025-05-08 00:54:59', NULL, NULL, 0),
(9, 'Pet Diapers', '2025-05-10', 'Ide', 9, '1746670767_ca62856f4dc7997f52c8.jpeg', '2025-05-08 02:19:27', NULL, NULL, 0),
(10, 'Sunslik anti rontok', '2025-05-14', 'Selesai', 10, NULL, '2025-05-12 13:47:41', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `konten_plartform`
--

CREATE TABLE `konten_plartform` (
  `id_konten_plartform` int(11) NOT NULL,
  `id_konten` int(11) NOT NULL,
  `id_plartform` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konten_plartform`
--

INSERT INTO `konten_plartform` (`id_konten_plartform`, `id_konten`, `id_plartform`) VALUES
(1, 2, 2),
(2, 2, 5),
(5, 3, 6),
(6, 4, 6),
(7, 4, 7),
(8, 5, 6),
(9, 6, 7),
(10, 7, 2),
(11, 7, 6),
(12, 8, 7),
(13, 9, 2),
(14, 9, 5),
(15, 10, 2),
(16, 10, 6),
(17, 10, 7);

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `ip_address` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_activity`
--

INSERT INTO `log_activity` (`id_log`, `id_user`, `aktivitas`, `ip_address`, `waktu`) VALUES
(1, 2, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 04:51:23'),
(2, 2, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 04:51:30'),
(3, 2, 'Mengakses Tabel Histori', '::1', '2025-04-30 04:56:35'),
(4, 2, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 04:57:21'),
(5, 2, 'Mengakses Tabel Histori', '::1', '2025-04-30 04:57:24'),
(6, 2, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 04:57:28'),
(7, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:09:12'),
(8, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:33:30'),
(9, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:34:50'),
(10, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:37:41'),
(11, 1, 'Mengakses Laporan Keuangan', '::1', '2025-04-30 09:40:33'),
(12, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:40:35'),
(13, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:42:12'),
(14, 1, 'Mengakses Profil', '::1', '2025-04-30 09:42:49'),
(15, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:45:25'),
(16, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:45:28'),
(17, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:54:21'),
(18, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 09:54:36'),
(19, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:04:57'),
(20, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:05:02'),
(21, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:05:05'),
(22, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:05:12'),
(23, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:08:29'),
(24, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:09:40'),
(25, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:11:16'),
(26, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:11:27'),
(27, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:11:45'),
(28, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:11:47'),
(29, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:20:16'),
(30, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:20:23'),
(31, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:20:35'),
(32, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:23:26'),
(33, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:23:49'),
(34, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:24:25'),
(35, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:24:29'),
(36, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:25:06'),
(37, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:25:12'),
(38, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:25:22'),
(39, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:25:23'),
(40, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-04-30 10:27:03'),
(41, 1, 'Mengakses Profil', '::1', '2025-04-30 10:43:50'),
(42, 1, 'Logout dari sistem', '::1', '2025-04-30 10:43:52'),
(43, 1, 'Login ke sistem', '::1', '2025-04-30 10:43:58'),
(44, 1, 'Login ke sistem', '::1', '2025-04-30 14:19:13'),
(45, 1, 'Login ke sistem', '::1', '2025-05-02 08:32:48'),
(46, 1, 'Mengakses Profil', '::1', '2025-05-02 08:37:53'),
(47, 1, 'Logout dari sistem', '::1', '2025-05-02 08:37:55'),
(48, 1, 'Login ke sistem', '::1', '2025-05-05 09:12:49'),
(49, 1, 'Mengakses Tabel Konten', '::1', '2025-05-05 09:14:40'),
(50, 1, 'Mengakses Profil', '::1', '2025-05-05 09:18:26'),
(51, 1, 'Logout dari sistem', '::1', '2025-05-05 09:18:27'),
(52, 1, 'Login ke sistem', '::1', '2025-05-05 09:19:00'),
(53, 1, 'Mengakses Settings', '::1', '2025-05-05 09:19:43'),
(54, 1, 'Mengakses Settings', '::1', '2025-05-05 09:19:55'),
(55, 1, 'Mengakses Settings', '::1', '2025-05-05 09:21:30'),
(56, 1, 'Mengakses Settings', '::1', '2025-05-05 09:22:48'),
(57, 1, 'Mengakses Settings', '::1', '2025-05-05 09:28:29'),
(58, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-05 09:28:38'),
(59, 1, 'Mengakses Settings', '::1', '2025-05-05 09:28:41'),
(60, 1, 'Mengupdate pengaturan website: {\"nama\":\"Sistem Manajemen Jadwal\"}', '::1', '2025-05-05 09:29:00'),
(61, 1, 'Mengakses Settings', '::1', '2025-05-05 09:29:02'),
(62, 1, 'Mengakses Settings', '::1', '2025-05-05 09:31:41'),
(63, 1, 'Mengakses Settings', '::1', '2025-05-05 09:32:06'),
(64, 1, 'Mengakses Profil', '::1', '2025-05-05 09:32:13'),
(65, 1, 'Mengakses Settings', '::1', '2025-05-05 09:32:22'),
(66, 1, 'Mengupdate pengaturan website: {\"nama\":\"Sistem\"}', '::1', '2025-05-05 09:32:32'),
(67, 1, 'Mengakses Settings', '::1', '2025-05-05 09:32:33'),
(68, 1, 'Mengakses Settings', '::1', '2025-05-05 09:43:57'),
(69, 1, 'Mengakses Settings', '::1', '2025-05-05 09:45:44'),
(70, 1, 'Mengakses Settings', '::1', '2025-05-05 09:46:15'),
(71, 1, 'Mengakses Settings', '::1', '2025-05-05 09:48:11'),
(72, 1, 'Mengakses Settings', '::1', '2025-05-05 09:48:22'),
(73, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-05 09:48:35'),
(74, 1, 'Mengakses Tabel Todo', '::1', '2025-05-05 09:48:38'),
(75, 1, 'Mengakses Profil', '::1', '2025-05-05 09:48:41'),
(76, 1, 'Mengakses Settings', '::1', '2025-05-05 09:48:48'),
(77, 1, 'Mengakses Settings', '::1', '2025-05-05 09:50:11'),
(78, 1, 'Mengakses Settings', '::1', '2025-05-05 09:50:20'),
(79, 1, 'Mengakses Settings', '::1', '2025-05-05 09:51:35'),
(80, 1, 'Mengakses Settings', '::1', '2025-05-05 09:53:22'),
(81, 1, 'Mengakses Profil', '::1', '2025-05-05 09:53:28'),
(82, 1, 'Mengakses Profil', '::1', '2025-05-05 09:55:19'),
(83, 1, 'Mengakses Tabel Konten', '::1', '2025-05-05 09:55:40'),
(84, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-05 09:55:42'),
(85, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-05 09:55:45'),
(86, 1, 'Mengakses Settings', '::1', '2025-05-05 09:55:50'),
(87, 1, 'Mengakses Profil', '::1', '2025-05-05 09:55:55'),
(88, 1, 'Mengakses Settings', '::1', '2025-05-05 09:55:59'),
(89, 1, 'Mengakses Profil', '::1', '2025-05-05 09:56:02'),
(90, 1, 'Mengakses Profil', '::1', '2025-05-05 09:56:28'),
(91, 1, 'Mengakses Profil', '::1', '2025-05-05 09:56:53'),
(92, 1, 'Mengakses Settings', '::1', '2025-05-05 09:57:09'),
(93, 1, 'Mengakses Settings', '::1', '2025-05-05 09:57:12'),
(94, 1, 'Mengakses Profil', '::1', '2025-05-05 09:57:14'),
(95, 1, 'Mengakses Profil', '::1', '2025-05-05 09:57:44'),
(96, 1, 'Mengakses Profil', '::1', '2025-05-05 09:57:51'),
(97, 1, 'Mengakses Profil', '::1', '2025-05-05 09:58:13'),
(98, 1, 'Mengakses Profil', '::1', '2025-05-05 09:58:14'),
(99, 1, 'Mengakses Profil', '::1', '2025-05-05 09:58:26'),
(100, 1, 'Mengakses Profil', '::1', '2025-05-05 09:59:30'),
(101, 1, 'Mengakses Profil', '::1', '2025-05-05 10:00:46'),
(102, 1, 'Mengakses Profil', '::1', '2025-05-05 10:01:07'),
(103, 1, 'Mengakses Profil', '::1', '2025-05-05 10:01:28'),
(104, 1, 'Mengakses Settings', '::1', '2025-05-05 10:01:45'),
(105, 1, 'Mengakses Tabel Todo', '::1', '2025-05-05 10:01:50'),
(106, 1, 'Mengakses Tabel Konten', '::1', '2025-05-05 10:01:56'),
(107, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-05 10:01:58'),
(108, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-05 10:09:53'),
(109, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-05 10:10:26'),
(110, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-05 10:10:37'),
(111, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-05 10:12:03'),
(112, 1, 'Mengakses Tabel Data Jadwal yang Dihapus', '::1', '2025-05-05 10:14:01'),
(113, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-05 10:14:03'),
(114, 1, 'Mengakses Tabel Klien', '::1', '2025-05-05 10:15:23'),
(115, 1, 'Mengakses Tabel Klien', '::1', '2025-05-05 10:16:38'),
(116, 1, 'Mengakses Tabel Klien', '::1', '2025-05-05 10:17:03'),
(117, 1, 'Mengakses Tabel Data Klien yang Dihapus', '::1', '2025-05-05 10:20:21'),
(118, 1, 'Mengakses Tabel Klien', '::1', '2025-05-05 10:20:22'),
(119, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-05 10:20:28'),
(120, 1, 'Mengakses Tabel User', '::1', '2025-05-05 10:20:32'),
(121, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-05 10:20:37'),
(122, 1, 'Mengakses Tabel Histori', '::1', '2025-05-05 10:20:46'),
(123, 1, 'Mengakses Tabel Histori', '::1', '2025-05-05 10:22:17'),
(124, 1, 'Mengakses Tabel Data Histori yang Dihapus', '::1', '2025-05-05 10:25:52'),
(125, 1, 'Mengakses Tabel Data Histori yang Dihapus', '::1', '2025-05-05 10:26:10'),
(126, 1, 'Mengakses Tabel Todo', '::1', '2025-05-05 10:26:15'),
(127, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-05 10:26:20'),
(128, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-05 10:26:40'),
(129, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-05 10:26:40'),
(130, 1, 'Mengunduh Laporan Keuangan PDF dari 2025-04-11 sampai 2025-05-30', '::1', '2025-05-05 10:26:41'),
(131, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-05 10:26:54'),
(132, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-05 10:27:15'),
(133, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-05 10:27:20'),
(134, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-05 10:27:22'),
(135, 1, 'Login ke sistem', '::1', '2025-05-05 13:41:51'),
(136, 1, 'Mengakses Tabel Todo', '::1', '2025-05-05 13:42:01'),
(137, 1, 'Mengakses Tabel Konten', '::1', '2025-05-05 13:42:12'),
(138, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-05 13:49:23'),
(139, 1, 'Mengakses Settings', '::1', '2025-05-05 13:49:26'),
(140, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-05 13:49:34'),
(141, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-05 14:30:33'),
(142, 1, 'Mengakses Tabel Todo', '::1', '2025-05-05 14:30:39'),
(143, 1, 'Mengakses Settings', '::1', '2025-05-05 14:54:38'),
(144, 1, 'Mengakses Settings', '::1', '2025-05-05 14:54:57'),
(145, 1, 'Mengakses Tabel Konten', '::1', '2025-05-05 15:36:18'),
(146, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-05 15:36:19'),
(147, 1, 'Mengakses Tabel Konten', '::1', '2025-05-05 15:36:22'),
(148, 1, 'Login ke sistem', '::1', '2025-05-06 13:48:50'),
(149, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-06 13:48:54'),
(150, 1, 'Mengakses Tabel User', '::1', '2025-05-06 13:55:50'),
(151, 1, 'Mengakses Tabel User', '::1', '2025-05-06 13:56:21'),
(152, 1, 'Mengakses Tabel User', '::1', '2025-05-06 13:58:03'),
(153, 1, 'Mengakses Settings', '::1', '2025-05-06 14:24:32'),
(154, 1, 'Mengakses Settings', '::1', '2025-05-06 14:27:20'),
(155, 1, 'Mengakses Settings', '::1', '2025-05-06 14:34:19'),
(156, 1, 'Mengakses Profil', '::1', '2025-05-06 15:10:31'),
(157, 1, 'Mengakses Tabel Todo', '::1', '2025-05-06 15:10:36'),
(158, 1, 'Mengakses Tabel User', '::1', '2025-05-06 15:10:41'),
(159, 1, 'Mengakses Tabel User', '::1', '2025-05-06 15:13:26'),
(160, 1, 'Mengakses Tabel User', '::1', '2025-05-06 15:13:28'),
(161, 1, 'Mengakses Profil', '::1', '2025-05-06 15:13:35'),
(162, 1, 'Mengakses Profil', '::1', '2025-05-06 15:18:51'),
(163, 1, 'Mengakses Profil', '::1', '2025-05-06 15:28:07'),
(164, 1, 'Mengakses Profil', '::1', '2025-05-06 15:28:12'),
(165, 1, 'Logout dari sistem', '::1', '2025-05-06 15:28:14'),
(166, 1, 'Login ke sistem', '::1', '2025-05-06 15:28:20'),
(167, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-06 15:36:03'),
(168, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-06 15:40:43'),
(169, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-06 15:41:18'),
(170, 1, 'Mengakses Profil', '::1', '2025-05-06 15:41:44'),
(171, 1, 'Logout dari sistem', '::1', '2025-05-06 15:42:24'),
(172, 2, 'Login ke sistem', '::1', '2025-05-06 15:43:14'),
(173, 1, 'Login ke sistem', '::1', '2025-05-06 15:43:30'),
(174, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-06 16:06:02'),
(175, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-06 16:07:36'),
(176, 1, 'Mengakses Settings', '::1', '2025-05-06 16:08:28'),
(177, 1, 'Login ke sistem', '::1', '2025-05-07 11:59:57'),
(178, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 12:26:25'),
(179, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 12:28:43'),
(180, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 12:29:37'),
(181, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:32:53'),
(182, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:34:38'),
(183, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:34:40'),
(184, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:34:45'),
(185, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:34:48'),
(186, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:37:59'),
(187, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:46:17'),
(188, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:48:28'),
(189, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:50:28'),
(190, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:50:30'),
(191, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:51:45'),
(192, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:52:03'),
(193, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:52:05'),
(194, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:52:41'),
(195, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:53:27'),
(196, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:53:30'),
(197, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:53:35'),
(198, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 12:54:45'),
(199, 1, 'Login ke sistem', '::1', '2025-05-07 12:55:14'),
(200, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 12:55:38'),
(201, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 12:58:17'),
(202, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-07 12:58:42'),
(203, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 12:59:47'),
(204, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 12:59:48'),
(205, 1, 'Mengakses Settings', '::1', '2025-05-07 13:01:13'),
(206, 1, 'Mengakses Settings', '::1', '2025-05-07 13:01:30'),
(207, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 13:02:00'),
(208, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 13:02:39'),
(209, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-07 13:02:53'),
(210, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 13:04:03'),
(211, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-07 13:23:50'),
(212, 1, 'Mengakses Tabel Konten', '::1', '2025-05-07 13:24:04'),
(213, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 13:24:45'),
(214, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 13:24:53'),
(215, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 13:25:30'),
(216, 1, 'Mengakses Hak Akses', '::1', '2025-05-07 13:25:43'),
(217, 3, 'Login ke sistem', '::1', '2025-05-07 13:25:53'),
(218, 3, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 13:26:07'),
(219, 3, 'Mengakses Settings', '::1', '2025-05-07 13:26:15'),
(220, 3, 'Mengakses Settings', '::1', '2025-05-07 13:27:50'),
(221, 3, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 13:27:52'),
(222, 3, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 13:40:31'),
(223, 1, 'Login ke sistem', '::1', '2025-05-07 13:40:54'),
(224, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-07 13:40:58'),
(225, 1, 'Login ke sistem', '::1', '2025-05-08 00:34:50'),
(226, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 00:35:42'),
(227, 1, 'Mengakses Tabel Data Konten yang Dihapus', '::1', '2025-05-08 00:35:56'),
(228, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 00:35:58'),
(229, 1, 'Mengakses Tabel Data Konten yang Dihapus', '::1', '2025-05-08 00:36:19'),
(230, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 00:36:21'),
(231, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 00:36:27'),
(232, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 00:36:29'),
(233, 1, 'Mengakses Tabel Data Jadwal yang Dihapus', '::1', '2025-05-08 00:37:18'),
(234, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 00:37:19'),
(235, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 00:37:20'),
(236, 1, 'Mengakses Tabel Data Klien yang Dihapus', '::1', '2025-05-08 00:37:23'),
(237, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 00:37:24'),
(238, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:37:30'),
(239, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 00:37:34'),
(240, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 00:37:52'),
(241, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:37:57'),
(242, 1, 'Menghapus plartform ID: 6 (soft delete)', '::1', '2025-05-08 00:38:04'),
(243, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 00:38:04'),
(244, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:38:08'),
(245, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 00:38:19'),
(246, 1, 'Mengembalikan plartform ID: 6 (soft delete)', '::1', '2025-05-08 00:38:31'),
(247, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:38:31'),
(248, 1, 'Mengakses Hak Akses', '::1', '2025-05-08 00:38:33'),
(249, 1, 'Mengakses Tabel User', '::1', '2025-05-08 00:38:53'),
(250, 1, 'Mengakses Tabel User', '::1', '2025-05-08 00:39:20'),
(251, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:39:43'),
(252, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:39:54'),
(253, 1, 'Menambahkan rekap: Pengeluaran - Makeup sebesar Rp65.000', '::1', '2025-05-08 00:43:12'),
(254, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:43:12'),
(255, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:43:17'),
(256, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:44:16'),
(257, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:44:18'),
(258, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-08 00:45:57'),
(259, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:46:07'),
(260, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:46:14'),
(261, 1, 'Mengakses Tabel Data Rekap yang Dihapus', '::1', '2025-05-08 00:46:22'),
(262, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 00:46:23'),
(263, 1, 'Mengakses Tabel Histori', '::1', '2025-05-08 00:46:26'),
(264, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 00:52:59'),
(265, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 00:53:43'),
(266, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 00:54:59'),
(267, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 00:56:32'),
(268, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 00:57:18'),
(269, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 00:57:34'),
(270, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:58:14'),
(271, 1, 'Menghapus plartform ID: 6 (soft delete)', '::1', '2025-05-08 00:58:20'),
(272, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 00:58:20'),
(273, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:58:22'),
(274, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 00:58:34'),
(275, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:58:47'),
(276, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 00:58:49'),
(277, 1, 'Mengembalikan plartform ID: 6 (soft delete)', '::1', '2025-05-08 00:58:51'),
(278, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 00:58:52'),
(279, 1, 'Mengakses Tabel User', '::1', '2025-05-08 00:58:56'),
(280, 1, 'Mengakses Tabel User', '::1', '2025-05-08 00:59:28'),
(281, 1, 'Mengakses Tabel User', '::1', '2025-05-08 00:59:38'),
(282, 1, 'Mengakses Tabel User', '::1', '2025-05-08 01:00:56'),
(283, 1, 'Mengakses Tabel User', '::1', '2025-05-08 01:04:23'),
(284, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 01:05:57'),
(285, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 01:06:51'),
(286, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 01:07:07'),
(287, 1, 'Mengakses Tabel Histori', '::1', '2025-05-08 01:07:10'),
(288, 1, 'Menghapus histori ID: 11 (soft delete)', '::1', '2025-05-08 01:07:18'),
(289, 1, 'Mengakses Tabel Data Histori yang Dihapus', '::1', '2025-05-08 01:07:18'),
(290, 1, 'Mengakses Tabel Histori', '::1', '2025-05-08 01:07:22'),
(291, 1, 'Mengakses Tabel Data Histori yang Dihapus', '::1', '2025-05-08 01:07:35'),
(292, 1, 'Mengembalikan histori ID: 4 (soft delete)', '::1', '2025-05-08 01:07:57'),
(293, 1, 'Mengakses Tabel Histori', '::1', '2025-05-08 01:07:57'),
(294, 1, 'Mengakses Tabel Data Histori yang Dihapus', '::1', '2025-05-08 01:08:00'),
(295, 1, 'Menghapus permanen histori ID: 11', '::1', '2025-05-08 01:08:03'),
(296, 1, 'Mengakses Tabel Data Histori yang Dihapus', '::1', '2025-05-08 01:08:04'),
(297, 1, 'Mengakses Tabel Histori', '::1', '2025-05-08 01:08:05'),
(298, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:19'),
(299, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:22'),
(300, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:24'),
(301, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:26'),
(302, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:27'),
(303, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:28'),
(304, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:31'),
(305, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:32'),
(306, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:38'),
(307, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:41'),
(308, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:08:58'),
(309, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:09:08'),
(310, 1, 'Mengakses Tabel Data To do yang Dihapus', '::1', '2025-05-08 01:09:19'),
(311, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:09:20'),
(312, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:09:26'),
(313, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 01:09:55'),
(314, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-08 01:11:07'),
(315, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-08 01:11:51'),
(316, 1, 'Mengakses Laporan Keuangan', '::1', '2025-05-08 01:11:51'),
(317, 1, 'Mengunduh Laporan Keuangan Excel dari 2025-04-29 sampai 2025-05-09', '::1', '2025-05-08 01:12:04'),
(318, 1, 'Mengakses Laporan Jadwal', '::1', '2025-05-08 01:12:24'),
(319, 1, 'Mengakses Laporan Jadwal', '::1', '2025-05-08 01:12:46'),
(320, 1, 'Mengunduh Laporan Jadwal PDF dari 2025-05-01 sampai 2025-05-31', '::1', '2025-05-08 01:12:48'),
(321, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-08 01:13:04'),
(322, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-08 01:13:22'),
(323, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-08 01:13:30'),
(324, 1, 'Mengakses Settings', '::1', '2025-05-08 01:13:50'),
(325, 1, 'Mengakses Profil', '::1', '2025-05-08 01:14:02'),
(326, 1, 'Mengakses Hak Akses', '::1', '2025-05-08 01:14:27'),
(327, 1, 'Mengakses Profil', '::1', '2025-05-08 01:15:05'),
(328, 1, 'Logout dari sistem', '::1', '2025-05-08 01:16:12'),
(329, 1, 'Login ke sistem', '::1', '2025-05-08 01:26:38'),
(330, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 01:26:48'),
(331, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 01:30:50'),
(332, 1, 'Mengakses Profil', '::1', '2025-05-08 01:40:42'),
(333, 1, 'Logout dari sistem', '::1', '2025-05-08 01:40:46'),
(334, 1, 'Login ke sistem', '::1', '2025-05-08 01:44:53'),
(335, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 02:00:21'),
(336, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 02:02:14'),
(337, 1, 'Menghapus plartform ID: 6 (soft delete)', '::1', '2025-05-08 02:02:28'),
(338, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 02:02:29'),
(339, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 02:02:30'),
(340, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 02:02:37'),
(341, 1, 'Mengakses Tabel Data Plartform yang Dihapus', '::1', '2025-05-08 02:02:55'),
(342, 1, 'Mengembalikan plartform ID: 6 (soft delete)', '::1', '2025-05-08 02:03:57'),
(343, 1, 'Mengakses Tabel Plartform', '::1', '2025-05-08 02:03:57'),
(344, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 02:15:40'),
(345, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 02:16:37'),
(346, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 02:16:45'),
(347, 1, 'Mengakses Tabel Klien', '::1', '2025-05-08 02:16:55'),
(348, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 02:16:56'),
(349, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 02:18:13'),
(350, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 02:18:20'),
(351, 1, 'Mengakses Tabel Todo', '::1', '2025-05-08 02:18:21'),
(352, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 02:18:26'),
(353, 1, 'Menambahkan Konten:  () di ', '::1', '2025-05-08 02:19:27'),
(354, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 02:19:27'),
(355, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 02:21:55'),
(356, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 02:22:03'),
(357, 1, 'Mengakses Tabel Rekap', '::1', '2025-05-08 02:30:00'),
(358, 1, 'Login ke sistem', '::1', '2025-05-08 05:54:29'),
(359, 1, 'Mengakses Tabel Konten', '::1', '2025-05-08 06:15:48'),
(360, 1, 'Mengakses Tabel Jadwal', '::1', '2025-05-08 06:15:52'),
(361, 1, 'Mengakses Profil', '::1', '2025-05-08 06:29:15'),
(362, 1, 'Logout dari sistem', '::1', '2025-05-08 06:29:16'),
(363, 3, 'Login ke sistem', '::1', '2025-05-08 06:29:30'),
(364, 3, 'Mengakses Profil', '::1', '2025-05-08 06:29:50'),
(365, 3, 'Logout dari sistem', '::1', '2025-05-08 06:29:51'),
(366, 1, 'Login ke sistem', '::1', '2025-05-08 06:30:26'),
(367, 1, 'Mengakses Hak Akses', '::1', '2025-05-08 06:30:36'),
(368, 1, 'Mengakses Hak Akses', '::1', '2025-05-08 06:31:00'),
(369, 3, 'Login ke sistem', '::1', '2025-05-08 06:31:14'),
(370, 3, 'Mengakses Tabel Konten', '::1', '2025-05-08 06:32:57'),
(371, 3, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-08 06:38:43'),
(372, 3, 'Mengakses Profil', '::1', '2025-05-08 06:41:54'),
(373, 1, 'Login ke sistem', '::1', '2025-05-12 13:38:18'),
(374, 1, 'Mengakses Hak Akses', '::1', '2025-05-12 13:38:51'),
(375, 1, 'Mengakses Profil', '::1', '2025-05-12 13:38:57'),
(376, 1, 'Logout dari sistem', '::1', '2025-05-12 13:38:59'),
(377, 3, 'Login ke sistem', '::1', '2025-05-12 13:42:15'),
(378, 3, 'Mengakses Tabel Konten', '::1', '2025-05-12 13:42:39'),
(379, 3, 'Mengakses Tabel Jadwal', '::1', '2025-05-12 13:42:45'),
(380, 3, 'Mengakses Tabel Jadwal', '::1', '2025-05-12 13:44:53'),
(381, 3, 'Mengakses Tabel Jadwal', '::1', '2025-05-12 13:45:13'),
(382, 3, 'Mengakses Tabel Klien', '::1', '2025-05-12 13:45:28'),
(383, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:45:46'),
(384, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:45:52'),
(385, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:45:54'),
(386, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:45:57'),
(387, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:45:59'),
(388, 3, 'Mengakses Tabel Plartform', '::1', '2025-05-12 13:46:05'),
(389, 3, 'Mengakses Tabel Konten', '::1', '2025-05-12 13:46:30'),
(390, 3, 'Menambahkan Konten:  () di ', '::1', '2025-05-12 13:47:10'),
(391, 3, 'Mengakses Tabel Konten', '::1', '2025-05-12 13:47:10'),
(392, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:47:30'),
(393, 3, 'Mengakses Tabel Konten', '::1', '2025-05-12 13:47:34'),
(394, 3, 'Mengakses Tabel Konten', '::1', '2025-05-12 13:47:41'),
(395, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:47:46'),
(396, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:47:48'),
(397, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:47:51'),
(398, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:47:55'),
(399, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:47:58'),
(400, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:48:00'),
(401, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:48:02'),
(402, 3, 'Mengakses Tabel Todo', '::1', '2025-05-12 13:48:05'),
(403, 3, 'Mengakses Tabel Rekap', '::1', '2025-05-12 13:48:18'),
(404, 3, 'Menambahkan rekap: Pengeluaran - Makanan sebesar Rp89.000', '::1', '2025-05-12 13:48:55'),
(405, 3, 'Mengakses Tabel Rekap', '::1', '2025-05-12 13:48:55'),
(406, 3, 'Mengakses Tabel Histori', '::1', '2025-05-12 13:49:08'),
(407, 3, 'Mengakses Laporan Keuangan', '::1', '2025-05-12 13:49:28'),
(408, 3, 'Mengakses Laporan Keuangan', '::1', '2025-05-12 13:49:54'),
(409, 3, 'Mengakses Laporan Keuangan', '::1', '2025-05-12 13:49:54'),
(410, 3, 'Mengunduh Laporan Keuangan PDF dari 2025-05-01 sampai 2025-05-31', '::1', '2025-05-12 13:50:04'),
(411, 3, 'Mengunduh Laporan Keuangan Excel dari 2025-05-01 sampai 2025-05-31', '::1', '2025-05-12 13:50:10'),
(412, 3, 'Mengakses Laporan Jadwal', '::1', '2025-05-12 13:50:33'),
(413, 3, 'Mengakses Laporan Jadwal', '::1', '2025-05-12 13:52:19'),
(414, 3, 'Mengakses Laporan Jadwal', '::1', '2025-05-12 13:52:28'),
(415, 3, 'Mengakses Laporan Jadwal', '::1', '2025-05-12 13:52:38'),
(416, 3, 'Mengakses Laporan Keuangan', '::1', '2025-05-12 13:52:42'),
(417, 3, 'Mengakses Laporan Jadwal', '::1', '2025-05-12 13:52:49'),
(418, 3, 'Mengakses Laporan Jadwal', '::1', '2025-05-12 13:53:11'),
(419, 3, 'Mengakses Laporan Jadwal', '::1', '2025-05-12 13:53:15'),
(420, 3, 'Mengunduh Laporan Jadwal PDF dari 2025-04-01 sampai 2025-04-30', '::1', '2025-05-12 13:53:18'),
(421, 3, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-12 13:53:33'),
(422, 3, 'Mengakses Profil', '::1', '2025-05-12 13:53:47'),
(423, 3, 'Logout dari sistem', '::1', '2025-05-12 13:53:56'),
(424, 1, 'Login ke sistem', '::1', '2025-05-12 13:54:02'),
(425, 1, 'Mengakses Tabel User', '::1', '2025-05-12 13:54:21'),
(426, 1, 'Mengakses Tabel Data User yang Dihapus', '::1', '2025-05-12 13:54:26'),
(427, 1, 'Mengakses Tabel User', '::1', '2025-05-12 13:54:28'),
(428, 1, 'Mengakses Tabel User', '::1', '2025-05-12 13:54:39'),
(429, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-12 13:54:47'),
(430, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-12 13:54:54'),
(431, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-12 13:54:57'),
(432, 1, 'Mengakses Riwayat Aktivitas', '::1', '2025-05-12 13:55:03'),
(433, 1, 'Mengakses Settings', '::1', '2025-05-12 13:55:10'),
(434, 1, 'Mengakses Settings', '::1', '2025-05-12 13:55:17'),
(435, 1, 'Mengakses Profil', '::1', '2025-05-12 13:55:23'),
(436, 1, 'Mengakses Hak Akses', '::1', '2025-05-12 13:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_parent` tinyint(1) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `url`, `icon`, `is_parent`, `parent_id`, `urutan`) VALUES
(1, 'Dashboard', 'home/dashboard', 'bi bi-house-door', 0, NULL, 1),
(2, 'Data Master', '#', 'bi bi-stack', 1, NULL, 2),
(3, 'Data Transaksi', '#', 'bi bi-journal-text', 1, NULL, 3),
(4, 'To Do List', 'todo/tabel_todo', 'bi bi-list-check', 0, NULL, 4),
(5, 'Laporan', '#', 'bi bi-bar-chart-line', 1, NULL, 5),
(6, 'Riwayat Aktivitas', 'log/tabel_riwayat', 'bi bi-clock-history', 0, NULL, 6),
(7, 'Hak Akses', 'hakakses', 'bi-shield-lock', 0, NULL, 7),
(8, 'Settings', 'home/setting', 'bi bi-gear', 0, NULL, 8),
(9, 'Profile', 'home/profile', 'bi bi-person-circle', 0, NULL, 9),
(10, 'Konten', 'konten/tabel_konten', 'bi bi-file-earmark-text-fill', 0, 2, 1),
(11, 'Jadwal', 'jadwal/tabel_jadwal', 'bi bi-calendar-check-fill', 0, 2, 2),
(12, 'Klien', 'klien/tabel_klien', 'bi bi-people-fill', 0, 2, 3),
(13, 'Platform', 'plartform/tabel_plartform', 'bi bi-laptop', 0, 2, 4),
(14, 'User', 'user/tabel_user', 'bi bi-person-badge-fill', 0, 2, 5),
(15, 'Rekap Keuangan', 'rekap/tabel_rekap', 'bi bi-wallet2', 0, 3, 1),
(16, 'Histori Kerja', 'histori/tabel_histori', 'bi bi-clock-history', 0, 3, 2),
(17, 'Laporan Keuangan', 'laporan/keuangan', 'bi bi-wallet2', 0, 5, 1),
(18, 'Laporan Jadwal', 'laporan/jadwal', 'bi bi-file-earmark-bar-graph-fill', 0, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `plartform`
--

CREATE TABLE `plartform` (
  `id_plartform` int(11) NOT NULL,
  `nama_plartform` varchar(255) NOT NULL,
  `tarif` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plartform`
--

INSERT INTO `plartform` (`id_plartform`, `nama_plartform`, `tarif`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Instagram Story', 350000.00, 0, '2025-04-24 04:52:42', NULL, NULL),
(4, 'Instagram Feed', 500000.00, 0, '2025-04-26 04:25:46', NULL, NULL),
(5, 'Tiktok Vidio 1 Menit', 720000.00, 0, '2025-04-24 04:30:13', NULL, NULL),
(6, 'Tiktok Vidio 2 Menit', 1400000.00, 0, '2025-05-08 02:03:57', NULL, NULL),
(7, 'Youtube', 900000.00, 0, '2025-04-29 10:24:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rekap_keuangan`
--

CREATE TABLE `rekap_keuangan` (
  `id_rekap` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis` enum('Pemasukkan','Pengeluaran') DEFAULT NULL,
  `kategori` enum('Endorse','Transportasi','Makeup','Keperluan Pribadi','Makanan','Lainnya') DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekap_keuangan`
--

INSERT INTO `rekap_keuangan` (`id_rekap`, `tanggal`, `jenis`, `kategori`, `jumlah`, `deskripsi`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, '2025-04-27', 'Pemasukkan', 'Endorse', 1400000.00, 'Konten untuk platform: Tiktok Vidio 2 Menit', 0, '2025-04-27 07:21:27', NULL, NULL),
(7, '2025-04-27', 'Pemasukkan', 'Endorse', 2300000.00, 'Konten untuk platform: Tiktok Vidio 2 Menit, Youtube', 0, '2025-04-27 13:55:01', NULL, NULL),
(8, '2025-04-27', 'Pemasukkan', 'Endorse', 1400000.00, 'Konten untuk platform: Tiktok Vidio 2 Menit', 0, '2025-04-29 10:32:42', NULL, NULL),
(11, '2025-04-27', 'Pemasukkan', 'Endorse', 900000.00, 'Konten untuk platform: Youtube', 0, '2025-04-27 14:30:59', NULL, NULL),
(12, '2025-04-27', 'Pemasukkan', 'Endorse', 2300000.00, 'Konten untuk platform: Tiktok Vidio 2 Menit, Youtube', 0, '2025-04-27 14:39:25', NULL, NULL),
(13, '2025-04-27', 'Pemasukkan', 'Endorse', 900000.00, 'Konten untuk platform: Youtube', 0, '2025-04-27 14:46:38', NULL, NULL),
(15, '2025-04-29', 'Pengeluaran', 'Makanan', 385000.00, 'Ayce sama team.', 0, '2025-04-29 12:52:49', NULL, NULL),
(16, '2025-04-28', 'Pengeluaran', 'Transportasi', 37000.00, 'Gocar ke tempat grooming meowgic.', 0, '2025-04-29 01:16:06', NULL, NULL),
(17, '2025-05-08', 'Pengeluaran', 'Makeup', 65000.00, 'Setting spary', 0, '2025-05-08 00:43:12', NULL, NULL),
(18, '2025-05-08', 'Pemasukkan', 'Endorse', 900000.00, 'Konten untuk platform: Youtube', 0, '2025-05-08 00:54:59', NULL, NULL),
(19, '2025-05-12', 'Pemasukkan', 'Endorse', 2650000.00, 'Konten untuk platform: Instagram Story, Tiktok Vidio 2 Menit, Youtube', 0, '2025-05-12 13:47:41', NULL, NULL),
(20, '2025-05-12', 'Pengeluaran', 'Makanan', 89000.00, 'Salad sayur', 0, '2025-05-12 13:48:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Manajer');

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `can_view` tinyint(1) DEFAULT 0,
  `can_add` tinyint(1) DEFAULT 0,
  `can_edit` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_menu`
--

INSERT INTO `role_menu` (`id`, `id_role`, `id_menu`, `can_view`, `can_add`, `can_edit`, `can_delete`) VALUES
(19, 1, 1, 1, 1, 1, 1),
(20, 1, 2, 1, 1, 1, 1),
(21, 1, 10, 1, 1, 1, 1),
(22, 1, 11, 1, 1, 1, 1),
(23, 1, 12, 1, 1, 1, 1),
(24, 1, 13, 1, 1, 1, 1),
(25, 1, 14, 1, 1, 1, 1),
(26, 1, 3, 1, 1, 1, 1),
(27, 1, 15, 1, 1, 1, 1),
(28, 1, 16, 1, 1, 1, 1),
(29, 1, 5, 1, 1, 1, 1),
(30, 1, 17, 1, 1, 1, 1),
(31, 1, 18, 1, 1, 1, 1),
(32, 1, 4, 1, 1, 1, 1),
(33, 1, 6, 1, 1, 1, 1),
(34, 1, 7, 1, 1, 1, 1),
(35, 1, 8, 1, 1, 1, 1),
(36, 1, 9, 1, 1, 1, 1),
(55, 3, 1, 1, 1, 1, 1),
(56, 3, 2, 1, 1, 1, 1),
(57, 3, 10, 1, 1, 1, 0),
(58, 3, 11, 1, 1, 1, 0),
(59, 3, 12, 1, 1, 1, 0),
(60, 3, 13, 1, 1, 1, 0),
(61, 3, 14, 0, 0, 0, 0),
(62, 3, 3, 1, 1, 1, 1),
(63, 3, 15, 1, 1, 1, 1),
(64, 3, 16, 1, 1, 1, 1),
(65, 3, 5, 1, 1, 1, 1),
(66, 3, 17, 1, 1, 1, 1),
(67, 3, 18, 1, 1, 1, 1),
(68, 3, 4, 1, 1, 1, 1),
(69, 3, 6, 1, 1, 1, 1),
(70, 3, 7, 0, 1, 1, 1),
(71, 3, 8, 0, 1, 1, 1),
(72, 3, 9, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `nama`, `foto`) VALUES
(1, 'Sistem Manajemen ', '1746541638_a92fc543339487411982.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id_todo` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kegiatan` text DEFAULT NULL,
  `status` enum('Ide','Belum Mulai','Proses','Selesai') DEFAULT 'Ide',
  `prioritas` enum('Rendah','Sedang','Tinggi') NOT NULL DEFAULT 'Sedang',
  `id_klien` int(11) DEFAULT NULL,
  `id_jadwal` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `statusr` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id_todo`, `tanggal`, `kegiatan`, `status`, `prioritas`, `id_klien`, `id_jadwal`, `created_at`, `updated_at`, `statusr`) VALUES
(1, '2025-04-30', 'da', 'Proses', 'Sedang', 1, NULL, '2025-04-27 08:03:50', NULL, 1),
(2, '2025-04-29', 'Senam bareng IU', 'Ide', 'Tinggi', 0, NULL, '2025-04-27 08:30:21', NULL, 1),
(4, '2025-05-01', 'Jadwal: Libra Hair Styler 2.0 untuk klien ID 3', 'Belum Mulai', 'Sedang', 3, 4, '2025-04-27 08:53:29', NULL, 0),
(6, '2025-05-06', 'Jadwal: Layanan Grooming untuk klien Meowgic', 'Proses', 'Sedang', 4, 6, '2025-04-27 09:04:16', NULL, 0),
(8, '2025-05-08', 'Jadwal: Taurus Hair Styler 2.0 untuk klien NVMEE', 'Selesai', 'Sedang', 3, 8, '2025-04-27 14:46:05', '2025-05-08 00:54:59', 0),
(9, '2025-05-10', 'Jadwal: Pet Diapers untuk klien Meowgic', 'Belum Mulai', 'Sedang', 4, 9, '2025-05-08 02:18:13', NULL, 0),
(10, '2025-05-14', 'Jadwal: Sunslik anti rontok untuk klien Lumine Glow Skincare', 'Selesai', 'Sedang', 1, 10, '2025-05-12 13:44:53', '2025-05-12 13:47:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` enum('1','2','3') DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `id_role` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `nama_user`, `email`, `password`, `level`, `foto`, `status`, `id_role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 's.adm', 'super admin', 'sup@dm', 'c4ca4238a0b923820dcc509a6f75849b', '1', '1745988120_583ee7398de2a711c245.jpeg', 0, 0, '2025-04-30 04:42:00', NULL, NULL),
(2, 'adm1', 'admin', 'adm@1', 'c4ca4238a0b923820dcc509a6f75849b', '2', '1745988367_99a6b555573cf244a486.jpeg', 0, 0, '2025-04-30 04:46:07', NULL, NULL),
(3, 'mnj1', 'manajer', 'mnj@1', 'c4ca4238a0b923820dcc509a6f75849b', '3', '1745988316_455c5b7b0d42159195f5.jpeg', 0, 0, '2025-04-30 04:45:16', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `histori`
--
ALTER TABLE `histori`
  ADD PRIMARY KEY (`id_histori`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `klien`
--
ALTER TABLE `klien`
  ADD PRIMARY KEY (`id_klien`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`id_konten`);

--
-- Indexes for table `konten_plartform`
--
ALTER TABLE `konten_plartform`
  ADD PRIMARY KEY (`id_konten_plartform`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `plartform`
--
ALTER TABLE `plartform`
  ADD PRIMARY KEY (`id_plartform`);

--
-- Indexes for table `rekap_keuangan`
--
ALTER TABLE `rekap_keuangan`
  ADD PRIMARY KEY (`id_rekap`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id_todo`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `histori`
--
ALTER TABLE `histori`
  MODIFY `id_histori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `klien`
--
ALTER TABLE `klien`
  MODIFY `id_klien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `id_konten` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `konten_plartform`
--
ALTER TABLE `konten_plartform`
  MODIFY `id_konten_plartform` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=437;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `plartform`
--
ALTER TABLE `plartform`
  MODIFY `id_plartform` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rekap_keuangan`
--
ALTER TABLE `rekap_keuangan`
  MODIFY `id_rekap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id_todo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
