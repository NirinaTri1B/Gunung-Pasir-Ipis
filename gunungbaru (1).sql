-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2026 at 04:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gunungbaru`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul`, `foto`, `kategori`, `deleted_at`, `created_at`, `updated_at`) VALUES
('GAL001', 'pemandangan', '1780621979_puncak.jpg', 'Puncak', NULL, '2026-06-05 01:13:00', '2026-06-05 01:13:00'),
('GAL002', 'sunrise puncak', '1780621997_01.jpg', 'Puncak', NULL, '2026-06-05 01:13:17', '2026-06-05 01:13:17'),
('GAL003', 'pemandangan', '1780622025_02.jpg', 'Puncak', NULL, '2026-06-05 01:13:45', '2026-06-05 01:13:45'),
('GAL004', 'pemandangan', '1780622039_05.jpg', 'Puncak', NULL, '2026-06-05 01:13:59', '2026-06-05 01:13:59'),
('GAL005', 'sunrise puncak', '1780622056_04.jpg', 'Puncak', NULL, '2026-06-05 01:14:16', '2026-06-05 01:14:16'),
('GAL006', 'pemandangan', '1780622098_06.jpg', 'Puncak', NULL, '2026-06-05 01:14:58', '2026-06-05 01:14:58'),
('GAL007', 'pemandangan', '1780622277_07.jpg', 'Puncak', NULL, '2026-06-05 01:17:57', '2026-06-24 07:18:41'),
('GAL008', 'pemandangan', '1780622312_08.jpg', 'Puncak', NULL, '2026-06-05 01:18:32', '2026-06-24 07:18:50'),
('GAL009', 'track', '1780622332_03.jpg', 'Jalur Pendakian', NULL, '2026-06-05 01:18:52', '2026-06-05 01:18:52'),
('GAL010', 'pemandangan', '1780622903_gunung.jpg', 'Puncak', NULL, '2026-06-05 01:28:23', '2026-06-24 07:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `label` varchar(255) NOT NULL,
  `grup` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`id`, `key`, `value`, `label`, `grup`, `created_at`, `updated_at`) VALUES
(1, 'profil_deskripsi', 'Gunung Pasir Ipis memiliki ketinggian sekitar 1.307 meter di atas permukaan laut (MDPL). Dengan jalur tracking yang relatif bersahabat namun tetap menantang, gunung ini cocok dikunjungi oleh pendaki pemula-menengah maupun wisatawan yang ingin menikmatikeindahan alam pegunungan. Sepanjang jalur pendakian, pengunjung disuguhi panorama hutan pinus, hamparan kebun warga, serta udara sejuk khas kawasan Ciater.', 'Deskripsi Profil Wisata', 'profil', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(2, 'jam_buka', '06.00 - 16.30 WIB', 'Jam Buka', 'operasional', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(3, 'hari_tutup', 'Senin & Kamis', 'Hari Tutup', 'operasional', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(4, 'batas_balik', '17.00 WIB', 'Batas Jam Balik', 'operasional', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(5, 'harga_tektok', '15000', 'Harga Tektok', 'tiket', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(6, 'harga_camping', '30000', 'Harga Camping', 'tiket', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(7, 'denda_sampah', '50000', 'Denda Sampah per Item', 'tiket', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(8, 'info_jalur', 'Jalur puncak memiliki medan yang terjal dan berbatasan langsung dengan jurang.\r\nSelalu perhatikan langkah kaki Anda dan tetap waspada terhadap kondisi medan yang dilalui.', 'Info Jalur Tracking', 'informasi', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(9, 'info_camp', 'Jarak tempuh sekitar 3.04 km dari basecamp dengan estimasi waktu perjalanan normal selama 90 menit.', 'Info Area Camp', 'informasi', '2026-06-04 11:22:28', '2026-06-04 12:00:02'),
(10, 'info_sampah', 'Wajib membawa kembali semua sampah bawaan. Jumlah sampah akan divalidasi saat turun,jika kekurangan akan dikenakan denda sebesar Rp 50.000/item atau mengambil kembali sampah yang tertinggal di jalur.', 'Info Manajemen Sampah', 'informasi', '2026-06-04 11:22:28', '2026-06-04 12:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_satwa`
--

CREATE TABLE `laporan_satwa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `nama_satwa` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_satwa`
--

INSERT INTO `laporan_satwa` (`id`, `id_user`, `nama_satwa`, `lokasi`, `deskripsi`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USR002', 'Babi Hutan', 'Pos 3', 'ganas', '1780817550_babi hutan.jpg', 'selesai', '2026-06-07 07:32:30', '2026-06-07 07:33:10'),
(2, 'USR002', 'babi hutan', 'Pos 1', 'ganas', '1781105987_babi hutan.jpg', 'selesai', '2026-06-10 15:39:47', '2026-06-10 15:42:05'),
(4, 'USR002', 'Babi Hutan', 'Pos 1', NULL, '1781107231_babi hutan.jpg', 'aktif', '2026-06-10 16:00:31', '2026-06-10 16:00:31'),
(10, 'USR002', 'Babi Hutan', 'Pos 2', NULL, '1781128812_babi hutan.jpg', 'selesai', '2026-06-10 22:00:12', '2026-06-10 22:02:45'),
(13, 'USR008', 'Lutung', 'Pos 2', NULL, '1781130219_lutung.jpg', 'selesai', '2026-06-10 22:23:39', '2026-06-10 22:33:28'),
(15, 'USR002', 'babi hutan', 'Pos 1', NULL, '1781645346_babi hutan.jpg', 'selesai', '2026-06-16 21:29:06', '2026-06-16 21:32:10'),
(16, 'USR002', 'Babi Hutan', 'Pos 2', NULL, '1781646532_babi hutan.jpg', 'selesai', '2026-06-16 21:48:52', '2026-06-16 22:26:49'),
(17, 'USR008', 'Babi Hutan', 'Pos 2', NULL, '1782282005_babi hutan.jpg', 'selesai', '2026-06-24 06:20:05', '2026-06-24 06:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_17_072854_create_laporan_satwas_table', 1),
(6, '2026_06_03_104822_create_galeri_table', 1),
(7, '2026_06_03_104843_create_registrasi_table', 1),
(8, '2026_06_03_104857_create_transaksi_table', 1),
(9, '2026_06_03_104914_create_sos_table', 1),
(10, '2026_06_03_104926_create_ulasan_table', 1),
(11, '2026_06_04_181921_create_konten_table', 1),
(12, '2026_06_05_093601_change_tgl_naik_to_datetime_in_registrasi', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `id_registrasi` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `jenis_pendakian` varchar(255) NOT NULL,
  `lama_menginap` int(11) NOT NULL,
  `jumlah_pendaki` int(11) NOT NULL,
  `jumlah_sampah` int(11) NOT NULL DEFAULT 0,
  `jumlah_sampah_akhir` int(11) NOT NULL DEFAULT 0,
  `status_sampah` enum('proses','sesuai','ambil_kembali','denda') NOT NULL DEFAULT 'proses',
  `total_denda` int(11) NOT NULL DEFAULT 0,
  `status_pendakian` enum('aktif','tidak aktif','selesai') NOT NULL DEFAULT 'tidak aktif',
  `tgl_naik` datetime NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`id_registrasi`, `id_user`, `jenis_pendakian`, `lama_menginap`, `jumlah_pendaki`, `jumlah_sampah`, `jumlah_sampah_akhir`, `status_sampah`, `total_denda`, `status_pendakian`, `tgl_naik`, `deskripsi`, `created_at`, `updated_at`) VALUES
('REG-20260604-786', 'USR002', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-04 00:00:00', NULL, '2026-06-04 14:23:14', '2026-06-05 02:47:50'),
('REG-20260605-133', 'USR007', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 11:01:34', NULL, '2026-06-05 04:01:34', '2026-06-10 05:13:23'),
('REG-20260605-146', 'USR005', 'tektok', 0, 1, 1, 0, 'denda', 50000, 'selesai', '2026-06-05 00:00:00', NULL, '2026-06-05 02:19:06', '2026-06-05 04:00:33'),
('REG-20260605-160', 'USR006', 'tektok', 0, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 10:29:54', NULL, '2026-06-05 03:29:54', '2026-06-05 04:01:07'),
('REG-20260605-208', 'USR005', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 11:00:56', NULL, '2026-06-05 04:00:56', '2026-06-05 04:02:30'),
('REG-20260605-218', 'USR008', 'tektok', 0, 3, 1, 0, 'proses', 0, 'aktif', '2026-06-05 09:54:06', NULL, '2026-06-05 02:54:06', '2026-06-05 02:54:06'),
('REG-20260605-406', 'USR002', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 11:00:53', NULL, '2026-06-05 04:00:53', '2026-06-05 04:01:39'),
('REG-20260605-452', 'USR009', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 11:02:09', NULL, '2026-06-05 04:02:09', '2026-06-12 07:50:53'),
('REG-20260605-537', 'USR009', 'tektok', 0, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 10:59:54', NULL, '2026-06-05 03:59:54', '2026-06-05 04:01:59'),
('REG-20260605-546', 'USR006', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 11:02:34', NULL, '2026-06-05 04:02:34', '2026-06-10 05:13:56'),
('REG-20260605-578', 'USR009', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 11:02:02', NULL, '2026-06-05 04:02:02', '2026-06-05 04:02:06'),
('REG-20260605-632', 'USR006', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 11:01:13', NULL, '2026-06-05 04:01:13', '2026-06-05 04:02:26'),
('REG-20260605-771', 'USR006', 'tektok', 0, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 00:00:00', NULL, '2026-06-05 02:19:14', '2026-06-05 02:48:48'),
('REG-20260605-788', 'USR007', 'camping', 2, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 00:00:00', NULL, '2026-06-05 02:19:22', '2026-06-05 04:01:02'),
('REG-20260605-865', 'USR002', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-05 09:52:50', NULL, '2026-06-05 02:52:50', '2026-06-05 04:00:07'),
('REG-20260605-904', 'USR002', 'camping', 1, 1, 1, 0, 'denda', 50000, 'selesai', '2026-06-05 11:02:37', NULL, '2026-06-05 04:02:37', '2026-06-12 10:55:24'),
('REG-20260610-432', 'USR005', 'camping', 1, 1, 100, 81, 'denda', 950000, 'selesai', '2026-06-10 13:52:36', NULL, '2026-06-10 06:52:36', '2026-06-10 07:14:03'),
('REG-20260610-667', 'USR005', 'camping', 2, 2, 14, 14, 'sesuai', 0, 'selesai', '2026-06-10 22:38:24', NULL, '2026-06-10 15:38:24', '2026-06-10 15:38:55'),
('REG-20260610-689', 'USR006', 'tektok', 0, 3, 15, 15, 'sesuai', 0, 'selesai', '2026-06-10 13:55:21', NULL, '2026-06-10 06:55:21', '2026-06-12 08:25:29'),
('REG-20260610-786', 'USR006', 'tektok', 0, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-10 13:48:36', NULL, '2026-06-10 06:48:36', '2026-06-10 06:52:01'),
('REG-20260612-211', 'USR005', 'tektok', 0, 2, 4, 3, 'denda', 50000, 'selesai', '2026-06-12 10:13:35', NULL, '2026-06-12 03:13:35', '2026-06-12 03:15:58'),
('REG-20260612-434', 'USR005', 'camping', 2, 2, 3, 3, 'sesuai', 0, 'selesai', '2026-06-12 14:52:14', NULL, '2026-06-12 07:52:14', '2026-06-12 08:21:39'),
('REG-20260612-661', 'USR007', 'camping', 2, 3, 4, 4, 'sesuai', 0, 'selesai', '2026-06-12 09:48:49', NULL, '2026-06-12 02:48:49', '2026-06-12 10:55:47'),
('REG-20260612-817', 'USR005', 'tektok', 0, 1, 3, 1, 'denda', 100000, 'selesai', '2026-06-12 09:40:36', NULL, '2026-06-12 02:40:36', '2026-06-12 02:41:05'),
('REG-20260612-983', 'USR005', 'camping', 2, 2, 4, 3, 'denda', 50000, 'selesai', '2026-06-12 15:22:32', NULL, '2026-06-12 08:22:32', '2026-06-12 08:23:43'),
('REG-20260615-275', 'USR002', 'camping', 1, 1, 1, 0, 'denda', 50000, 'selesai', '2026-06-15 16:06:59', NULL, '2026-06-15 09:06:59', '2026-06-15 09:07:35'),
('REG-20260615-389', 'USR007', 'camping', 1, 1, 1, 0, 'ambil_kembali', 0, 'aktif', '2026-06-15 14:55:47', NULL, '2026-06-15 07:55:47', '2026-06-15 08:07:45'),
('REG-20260615-493', 'USR005', 'tektok', 0, 2, 10, 10, 'sesuai', 0, 'selesai', '2026-06-15 15:23:45', NULL, '2026-06-15 08:23:45', '2026-06-15 08:23:51'),
('REG-20260615-731', 'USR006', 'tektok', 0, 1, 1, 0, 'denda', 50000, 'selesai', '2026-06-15 15:08:31', NULL, '2026-06-15 08:08:31', '2026-06-15 08:15:11'),
('REG-20260617-160', 'USR005', 'camping', 2, 2, 3, 3, 'sesuai', 0, 'selesai', '2026-06-17 08:39:38', NULL, '2026-06-17 01:39:38', '2026-06-23 23:07:25'),
('REG-20260617-360', 'USR002', 'camping', 1, 1, 1, 1, 'sesuai', 0, 'selesai', '2026-06-17 04:27:36', NULL, '2026-06-16 21:27:36', '2026-06-19 08:55:20'),
('REG-20260617-372', 'USR006', 'camping', 2, 3, 4, 3, 'denda', 50000, 'selesai', '2026-06-17 08:47:08', NULL, '2026-06-17 01:47:08', '2026-06-17 01:48:12'),
('REG-20260617-384', 'USR006', 'camping', 2, 2, 4, 3, 'denda', 50000, 'selesai', '2026-06-17 08:51:17', NULL, '2026-06-17 01:51:17', '2026-06-17 01:52:08'),
('REG-20260617-740', 'USR005', 'camping', 2, 2, 3, 3, 'sesuai', 0, 'selesai', '2026-06-17 08:39:39', NULL, '2026-06-17 01:39:39', '2026-06-23 23:07:34'),
('REG-20260617-840', 'USR005', 'camping', 2, 2, 4, 3, 'denda', 50000, 'selesai', '2026-06-17 08:34:39', NULL, '2026-06-17 01:34:39', '2026-06-17 01:35:58'),
('REG-20260617-947', 'USR005', 'camping', 2, 2, 3, 4, 'sesuai', 0, 'selesai', '2026-06-17 08:39:37', NULL, '2026-06-17 01:39:37', '2026-06-23 23:07:55'),
('REG-20260619-316', 'USR006', 'camping', 1, 4, 1, 1, 'sesuai', 0, 'selesai', '2026-06-19 15:38:37', NULL, '2026-06-19 08:38:37', '2026-06-23 23:07:45'),
('REG-20260619-461', 'USR002', 'camping', 2, 6, 1, 1, 'sesuai', 0, 'selesai', '2026-06-19 15:56:03', NULL, '2026-06-19 08:56:03', '2026-06-23 23:07:20'),
('REG-20260624-903', 'USR002', 'tektok', 0, 5, 10, 8, 'denda', 100000, 'selesai', '2026-06-24 13:29:03', NULL, '2026-06-24 06:29:03', '2026-06-24 06:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `sos`
--

CREATE TABLE `sos` (
  `id_sos` bigint(20) UNSIGNED NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `id_registrasi` varchar(255) DEFAULT NULL,
  `jenis_sos` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `pesan_tambahan` text DEFAULT NULL,
  `status` enum('aktif','ditangani','selesai') NOT NULL DEFAULT 'aktif',
  `id_petugas` varchar(255) DEFAULT NULL,
  `lat_petugas` varchar(255) DEFAULT NULL,
  `lng_petugas` varchar(255) DEFAULT NULL,
  `status_sos` enum('pending','waiting','on_the_way','selesai') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sos`
--

INSERT INTO `sos` (`id_sos`, `id_user`, `id_registrasi`, `jenis_sos`, `latitude`, `longitude`, `pesan_tambahan`, `status`, `id_petugas`, `lat_petugas`, `lng_petugas`, `status_sos`, `created_at`, `updated_at`) VALUES
(1, 'USR002', 'REG-20260604-786', 'Tersesat', '-6.5709853582731', '107.77169413453', NULL, 'selesai', 'USR004', '-6.5710775930732', '107.77154609235', 'selesai', '2026-06-04 14:23:44', '2026-06-05 01:54:51'),
(2, 'USR002', 'REG-20260604-786', 'Bahaya Lainnya', '-6.5657761202662', '107.82761891916', NULL, 'selesai', 'USR004', '-6.5710022555662', '107.77166677558', 'selesai', '2026-06-05 01:55:13', '2026-06-11 14:13:11'),
(3, 'USR008', 'REG-20260605-218', 'Cedera / Luka-luka', '-6.5710022555662', '107.77166677558', NULL, 'selesai', 'USR004', '-6.5710022555662', '107.77166677558', 'selesai', '2026-06-10 22:23:17', '2026-06-10 22:30:40'),
(4, 'USR002', 'REG-20260605-904', 'Tersesat', '-6.5658664661605', '107.82769817535', NULL, 'selesai', 'USR004', '-6.5658605452982', '107.82763577584', 'selesai', '2026-06-12 02:44:03', '2026-06-12 02:58:58'),
(5, 'USR009', 'REG-20260605-452', 'Cedera / Luka-luka', '-6.8554', '107.66548', NULL, 'selesai', 'USR004', '-6.85547', '107.665489', 'selesai', '2026-06-12 07:31:54', '2026-06-12 07:37:10'),
(6, 'USR002', 'REG-20260605-904', 'Cedera / Luka-luka', '-6.5658355532487', '107.82768442119', NULL, 'selesai', 'USR004', '-6.5659046935654', '107.82765707648', 'selesai', '2026-06-12 08:29:23', '2026-06-12 08:31:05'),
(7, 'USR002', 'REG-20260617-360', 'Cedera / Luka-luka', '-6.5720157347217', '107.77157416388', NULL, 'selesai', 'USR004', '-6.5723141544551', '107.77136821251', 'selesai', '2026-06-16 21:28:42', '2026-06-16 21:38:18'),
(8, 'USR002', 'REG-20260617-360', 'Cedera / Luka-luka', '-6.5723141544551', '107.77136821251', NULL, 'selesai', 'USR004', '-6.5723141544551', '107.77136821251', 'selesai', '2026-06-16 21:48:21', '2026-06-16 21:53:56'),
(9, 'USR002', 'REG-20260617-360', 'Cedera / Luka-luka', '-6.5718865', '107.771469', NULL, 'selesai', 'USR004', '-6.5718865', '107.771469', 'selesai', '2026-06-16 22:23:06', '2026-06-16 22:28:06'),
(10, 'USR002', 'REG-20260617-360', 'Cedera / Luka-luka', '-6.5657518277092', '107.82744429444', NULL, 'selesai', 'USR004', '-6.7469786163607', '107.67530045348', 'selesai', '2026-06-17 03:28:43', '2026-06-19 08:37:25'),
(11, 'USR005', 'REG-20260617-160', 'Tersesat', '-6.7469523483663', '107.67533173878', NULL, 'selesai', 'USR004', '-6.5707183614041', '107.77155675652', 'selesai', '2026-06-18 22:18:42', '2026-06-23 23:11:54'),
(12, 'USR002', 'REG-20260619-461', 'Cedera / Luka-luka', '-6.7469593447342', '107.67524505016', NULL, 'ditangani', 'USR004', NULL, NULL, 'waiting', '2026-06-19 08:57:21', '2026-06-19 08:57:43'),
(13, 'USR008', 'REG-20260605-218', 'Cedera / Luka-luka', '-6.5710022555662', '107.77166677558', NULL, 'selesai', 'USR004', '-6.5710022555662', '107.77166677558', 'selesai', '2026-06-24 06:19:23', '2026-06-24 06:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(255) NOT NULL,
  `id_registrasi` varchar(255) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_registrasi`, `total_bayar`, `metode_pembayaran`, `tgl_transaksi`, `created_at`, `updated_at`) VALUES
('TRS-20260604-254', 'REG-20260604-786', 30000, 'Qris', '2026-06-04 00:00:00', '2026-06-04 14:23:14', '2026-06-04 14:23:14'),
('TRS-20260605-173', 'REG-20260605-865', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 02:52:50', '2026-06-05 02:52:50'),
('TRS-20260605-286', 'REG-20260605-133', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:01:34', '2026-06-05 04:01:34'),
('TRS-20260605-353', 'REG-20260605-218', 45000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 02:54:06', '2026-06-05 02:54:06'),
('TRS-20260605-374', 'REG-20260605-406', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:00:53', '2026-06-05 04:00:53'),
('TRS-20260605-381', 'REG-20260605-160', 15000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 03:29:54', '2026-06-05 03:29:54'),
('TRS-20260605-474', 'REG-20260605-788', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 02:19:22', '2026-06-05 02:19:22'),
('TRS-20260605-517', 'REG-20260605-546', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:02:34', '2026-06-05 04:02:34'),
('TRS-20260605-525', 'REG-20260605-208', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:00:56', '2026-06-05 04:00:56'),
('TRS-20260605-678', 'REG-20260605-904', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:02:37', '2026-06-05 04:02:37'),
('TRS-20260605-714', 'REG-20260605-771', 15000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 02:19:14', '2026-06-05 02:19:14'),
('TRS-20260605-757', 'REG-20260605-146', 50000, 'Cash', '2026-06-05 00:00:00', '2026-06-05 04:00:33', '2026-06-05 04:00:33'),
('TRS-20260605-870', 'REG-20260605-537', 15000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 03:59:54', '2026-06-05 03:59:54'),
('TRS-20260605-943', 'REG-20260605-146', 15000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 02:19:06', '2026-06-05 02:19:06'),
('TRS-20260605-956', 'REG-20260605-452', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:02:09', '2026-06-05 04:02:09'),
('TRS-20260605-959', 'REG-20260605-578', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:02:02', '2026-06-05 04:02:02'),
('TRS-20260605-991', 'REG-20260605-632', 30000, 'Qris', '2026-06-05 00:00:00', '2026-06-05 04:01:13', '2026-06-05 04:01:13'),
('TRS-20260610-281', 'REG-20260610-432', 950000, 'Cash', '2026-06-10 00:00:00', '2026-06-10 07:14:03', '2026-06-10 07:14:03'),
('TRS-20260610-434', 'REG-20260610-786', 15000, 'Qris', '2026-06-10 00:00:00', '2026-06-10 06:48:36', '2026-06-10 06:48:36'),
('TRS-20260610-557', 'REG-20260610-667', 60000, 'Cash', '2026-06-10 00:00:00', '2026-06-10 15:38:24', '2026-06-10 15:38:24'),
('TRS-20260610-965', 'REG-20260610-689', 45000, 'Qris', '2026-06-10 00:00:00', '2026-06-10 06:55:21', '2026-06-10 06:55:21'),
('TRS-20260610-983', 'REG-20260610-432', 30000, 'Qris', '2026-06-10 00:00:00', '2026-06-10 06:52:36', '2026-06-10 06:52:36'),
('TRS-20260612-118', 'REG-20260612-817', 100000, 'Qris', '2026-06-12 00:00:00', '2026-06-12 02:41:05', '2026-06-12 02:41:05'),
('TRS-20260612-172', 'REG-20260612-983', 50000, 'Cash', '2026-06-12 00:00:00', '2026-06-12 08:23:43', '2026-06-12 08:23:43'),
('TRS-20260612-269', 'REG-20260612-211', 50000, 'Qris', '2026-06-12 00:00:00', '2026-06-12 03:15:58', '2026-06-12 03:15:58'),
('TRS-20260612-409', 'REG-20260612-661', 90000, 'Qris', '2026-06-12 00:00:00', '2026-06-12 02:48:49', '2026-06-12 02:48:49'),
('TRS-20260612-706', 'REG-20260612-211', 30000, 'Qris', '2026-06-12 00:00:00', '2026-06-12 03:13:35', '2026-06-12 03:13:35'),
('TRS-20260612-766', 'REG-20260605-904', 50000, 'Cash', '2026-06-12 00:00:00', '2026-06-12 10:55:24', '2026-06-12 10:55:24'),
('TRS-20260612-822', 'REG-20260612-983', 60000, 'Cash', '2026-06-12 00:00:00', '2026-06-12 08:22:32', '2026-06-12 08:22:32'),
('TRS-20260612-854', 'REG-20260612-817', 15000, 'Cash', '2026-06-12 00:00:00', '2026-06-12 02:40:36', '2026-06-12 02:40:36'),
('TRS-20260612-873', 'REG-20260612-434', 60000, 'Qris', '2026-06-12 00:00:00', '2026-06-12 07:52:14', '2026-06-12 07:52:14'),
('TRS-20260615-200', 'REG-20260615-731', 50000, 'Cash', '2026-06-15 00:00:00', '2026-06-15 08:15:11', '2026-06-15 08:15:11'),
('TRS-20260615-385', 'REG-20260615-493', 30000, 'Qris', '2026-06-15 00:00:00', '2026-06-15 08:23:45', '2026-06-15 08:23:45'),
('TRS-20260615-587', 'REG-20260615-275', 50000, 'Cash', '2026-06-15 00:00:00', '2026-06-15 09:07:35', '2026-06-15 09:07:35'),
('TRS-20260615-675', 'REG-20260615-275', 30000, 'Qris', '2026-06-15 00:00:00', '2026-06-15 09:06:59', '2026-06-15 09:06:59'),
('TRS-20260615-683', 'REG-20260615-389', 30000, 'Qris', '2026-06-15 00:00:00', '2026-06-15 07:55:47', '2026-06-15 07:55:47'),
('TRS-20260615-853', 'REG-20260615-731', 15000, 'Qris', '2026-06-15 00:00:00', '2026-06-15 08:08:31', '2026-06-15 08:08:31'),
('TRS-20260617-109', 'REG-20260617-740', 60000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:39:39', '2026-06-17 01:39:39'),
('TRS-20260617-115', 'REG-20260617-384', 60000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:51:17', '2026-06-17 01:51:17'),
('TRS-20260617-135', 'REG-20260617-840', 50000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:35:58', '2026-06-17 01:35:58'),
('TRS-20260617-444', 'REG-20260617-840', 60000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:34:39', '2026-06-17 01:34:39'),
('TRS-20260617-529', 'REG-20260617-372', 90000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:47:08', '2026-06-17 01:47:08'),
('TRS-20260617-538', 'REG-20260617-160', 60000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:39:38', '2026-06-17 01:39:38'),
('TRS-20260617-704', 'REG-20260617-372', 50000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:48:12', '2026-06-17 01:48:12'),
('TRS-20260617-736', 'REG-20260617-947', 60000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:39:37', '2026-06-17 01:39:37'),
('TRS-20260617-754', 'REG-20260617-384', 50000, 'Cash', '2026-06-17 00:00:00', '2026-06-17 01:52:08', '2026-06-17 01:52:08'),
('TRS-20260617-813', 'REG-20260617-360', 30000, 'Qris', '2026-06-17 00:00:00', '2026-06-16 21:27:36', '2026-06-16 21:27:36'),
('TRS-20260619-275', 'REG-20260619-316', 120000, 'Qris', '2026-06-19 00:00:00', '2026-06-19 08:38:37', '2026-06-19 08:38:37'),
('TRS-20260619-994', 'REG-20260619-461', 180000, 'Qris', '2026-06-19 00:00:00', '2026-06-19 08:56:03', '2026-06-19 08:56:03'),
('TRS-20260624-629', 'REG-20260624-903', 100000, 'Qris', '2026-06-24 00:00:00', '2026-06-24 06:29:54', '2026-06-24 06:29:54'),
('TRS-20260624-836', 'REG-20260624-903', 75000, 'Qris', '2026-06-24 00:00:00', '2026-06-24 06:29:03', '2026-06-24 06:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` bigint(20) UNSIGNED NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `komentar` text NOT NULL,
  `rating` int(11) NOT NULL,
  `balasan` text DEFAULT NULL,
  `tampilkan` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_user`, `komentar`, `rating`, `balasan`, `tampilkan`, `created_at`, `updated_at`) VALUES
(1, 'USR002', 'cantik', 5, NULL, 0, '2026-06-04 14:26:11', '2026-06-16 21:56:05'),
(2, 'USR005', 'tracknya mantap', 5, NULL, 0, '2026-06-05 01:50:55', '2026-06-19 08:42:35'),
(3, 'USR005', 'enakeun syahdu', 4, 'terimakasih kak', 1, '2026-06-05 01:51:06', '2026-06-24 07:18:13'),
(4, 'USR006', 'keren', 5, NULL, 1, '2026-06-07 07:15:17', '2026-06-24 07:18:07'),
(5, 'USR002', 'Keren', 4, NULL, 0, '2026-06-11 19:13:25', '2026-06-19 08:42:29'),
(7, 'USR002', 'cantik', 5, 'terimakasih', 1, '2026-06-16 21:49:10', '2026-06-24 07:18:01');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(255) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pendaki','karyawan','petugas_lapangan') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email`, `email_verified_at`, `password`, `role`, `alamat`, `no_telp`, `remember_token`, `created_at`, `updated_at`) VALUES
('USR001', 'Admin', 'admin@gmail.com', NULL, '$2y$10$2PBj3spuRn3u.jnRbBVWU.vWC6a7gKGlPOHCZjrfK81CwsWjv.9OG', 'admin', NULL, NULL, NULL, '2026-06-04 11:28:06', '2026-06-24 10:12:06'),
('USR002', 'elsa', 'elsa@gmail.com', NULL, '$2y$10$cnPgsdzxMLPhVLBvDCYEWOm4OpC.Fuyca2/vsOctFQ4QuFlqlnh6i', 'pendaki', 'soklat', '081234567890', NULL, '2026-06-04 11:28:26', '2026-06-04 14:22:58'),
('USR003', 'ridwan', 'petugas@gmail.com', NULL, '$2y$10$8MalwTrY2nhCG4/7on5f9.FjWPRAxQByFDKahAlWtJ5xPwKh.JRgK', 'karyawan', NULL, NULL, NULL, '2026-06-04 14:21:12', '2026-06-04 14:21:12'),
('USR004', 'PL Rudi', 'PLrudi@gmail.com', NULL, '$2y$10$pVAA5LPMoWkfBJFJChrVS.S06zrPRYW6dDYrx3.S3rqLKGaxea70a', 'petugas_lapangan', NULL, NULL, NULL, '2026-06-04 14:21:37', '2026-06-04 14:21:37'),
('USR005', 'Nirina', 'nirin@gmail.com', NULL, '$2y$10$AVE9jaqLdCFRH00ZosGPOe8fXba4mkkcul3X8fwn5hhAkoCDA/y/G', 'pendaki', 'belendung', '081234567891', NULL, '2026-06-05 01:50:21', '2026-06-05 02:11:06'),
('USR006', 'Bunga S', 'bunga@gmail.com', NULL, '$2y$10$qLDyoChgSzSKN8sr5YT3BeTgbHFDsV22AkPz25iISoPprtS6MJLmS', 'pendaki', 'ciater', '081234567891', NULL, '2026-06-05 02:11:34', '2026-06-05 02:17:44'),
('USR007', 'qisty', 'kisti@gmail.com', NULL, '$2y$10$TBinvJLJgCYNWnKiF7cZ/eMh11AryRmgpa4nnxOGlOoGoo10dS/zy', 'pendaki', 'karawang', '081234567894', NULL, '2026-06-05 02:11:52', '2026-06-05 02:16:41'),
('USR008', 'alya', 'alya@gmail.com', NULL, '$2y$10$2Ao2omE8bw7U1HV4C6ukSOIgskmBbtr561Mrn6QEIL8Kp.ZB6o9ai', 'pendaki', 'pagaden', '081234567895', NULL, '2026-06-05 02:12:09', '2026-06-05 02:12:40'),
('USR009', 'dipa', 'dipa@gmail.com', NULL, '$2y$10$hpmfUXVUsUmQH6p62tk6tuLY.eFN6DQFo83sHJYipFIBFqKqG3cbC', 'pendaki', 'haurgeulis', '081234567892', NULL, '2026-06-05 02:18:05', '2026-06-05 02:18:30'),
('USR010', 'Sintya Elsa', 'elsasintyad@gmail.com', NULL, '$2y$10$q06yq5AS7DU7BLGK/kCnJe6.DUR7HXLcfgCVMo1ZaTAKROP70A7Oa', 'pendaki', NULL, NULL, NULL, '2026-06-10 13:54:16', '2026-06-16 22:32:29'),
('USR011', 'zel', 'zeldifadillah@gmail.com', NULL, '$2y$10$f/Ze4s3GhPmyVIH56DElH.Bz9jrzh8bL3hK1gjNYTlrzCIjEGVGKS', 'pendaki', NULL, NULL, NULL, '2026-06-10 14:02:15', '2026-06-10 14:02:15'),
('USR012', 'diva saras', 'inzyradiva@gmail.com', NULL, '$2y$10$T/ySnkd2piVwpoNHRP.xW.65vdYJNFhI5t5YjSMvALiVsqoh3wXou', 'pendaki', NULL, NULL, NULL, '2026-06-10 14:30:11', '2026-06-10 14:30:11'),
('USR013', 'nadiya', 'navitanadiya@gmail.com', NULL, '$2y$10$tR8BVyy8TN.NFySr8toIheqgK7w7LEI/DHpW27B13Z7Q3DVLKhp4.', 'pendaki', NULL, NULL, NULL, '2026-06-11 06:22:41', '2026-06-11 06:24:20'),
('USR014', 'rahma', 'nirinsi2b@gmail.com', NULL, '$2y$10$TsHBOkyrKJnpllOcHZGeeenQfDVOj5ohe36JNFzm3HWqZiPx7Fes2', 'pendaki', NULL, NULL, NULL, '2026-06-11 08:14:22', '2026-06-11 08:15:56'),
('USR015', 'cio', 'cio@gmail.com', NULL, '$2y$10$braNI8hM5FV0WqiI6MZKcesc0FfFE256BEq4Dcx/4FHoQyGe80NWa', 'pendaki', NULL, NULL, NULL, '2026-06-11 11:31:43', '2026-06-11 11:31:43'),
('USR016', 'udin', 'udin@gmail.com', NULL, '$2y$10$2gdejxe9D0uJJK1r2KqzmOy47vUgLJUgaGHGBUKKC1BlNE22..Gt6', 'pendaki', NULL, NULL, NULL, '2026-06-12 03:18:06', '2026-06-12 03:18:06');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `auto_id_user` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    DECLARE last_id INT;

    -- Mencari angka terbesar dari ID yang sudah ada (misal USR005 -> ambil angka 5)
    SELECT IFNULL(MAX(CAST(SUBSTRING(id_user, 4) AS UNSIGNED)), 0)
    INTO last_id
    FROM user;

    -- Membuat ID baru dengan format USR + angka berurutan yang digenapkan 3 digit
    SET NEW.id_user = CONCAT('USR', LPAD(last_id + 1, 3, '0'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `konten_key_unique` (`key`);

--
-- Indexes for table `laporan_satwa`
--
ALTER TABLE `laporan_satwa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_satwa_id_user_foreign` (`id_user`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id_registrasi`),
  ADD KEY `registrasi_id_user_foreign` (`id_user`);

--
-- Indexes for table `sos`
--
ALTER TABLE `sos`
  ADD PRIMARY KEY (`id_sos`),
  ADD KEY `sos_id_user_foreign` (`id_user`),
  ADD KEY `sos_id_registrasi_foreign` (`id_registrasi`),
  ADD KEY `sos_id_petugas_foreign` (`id_petugas`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `transaksi_id_registrasi_foreign` (`id_registrasi`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `ulasan_id_user_foreign` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `laporan_satwa`
--
ALTER TABLE `laporan_satwa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sos`
--
ALTER TABLE `sos`
  MODIFY `id_sos` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan_satwa`
--
ALTER TABLE `laporan_satwa`
  ADD CONSTRAINT `laporan_satwa_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD CONSTRAINT `registrasi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `sos`
--
ALTER TABLE `sos`
  ADD CONSTRAINT `sos_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `user` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `sos_id_registrasi_foreign` FOREIGN KEY (`id_registrasi`) REFERENCES `registrasi` (`id_registrasi`) ON DELETE SET NULL,
  ADD CONSTRAINT `sos_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_id_registrasi_foreign` FOREIGN KEY (`id_registrasi`) REFERENCES `registrasi` (`id_registrasi`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
