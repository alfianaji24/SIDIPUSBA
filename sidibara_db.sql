-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2024 at 09:08 AM
-- Server version: 10.6.20-MariaDB
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puskesm6_dispa`
--

-- --------------------------------------------------------

--
-- Table structure for table `agamaquotes`
--

CREATE TABLE `agamaquotes` (
  `id` int(11) NOT NULL,
  `isi_quotes` varchar(255) NOT NULL,
  `suratriwayat` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `agamaquotes`
--

INSERT INTO `agamaquotes` (`id`, `isi_quotes`, `suratriwayat`, `created_at`, `updated_at`) VALUES
(1, 'Kebersihan Sebagian Dari Iman', 'HR. Muslim', '2020-12-31 23:20:34', '2022-08-20 09:48:22'),
(2, 'Dan dirikanlah shalat, tunaikanlah zakat dan ruku\'lah beserta orang-orang yang ruku\'', 'Al Baqarah:43', '2021-01-01 09:02:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agendas`
--

CREATE TABLE `agendas` (
  `id` int(11) NOT NULL,
  `nama_agenda` varchar(255) NOT NULL,
  `tempat_agenda` varchar(150) NOT NULL,
  `tgl_agenda` date NOT NULL,
  `waktu` varchar(10) NOT NULL,
  `jenis_agenda` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `customs`
--

CREATE TABLE `customs` (
  `id` int(11) NOT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `bgcolor` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `konten` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `customs`
--

INSERT INTO `customs` (`id`, `tipe`, `bgcolor`, `title`, `konten`, `status`, `created_at`, `updated_at`) VALUES
(1, 'col-sm-12', 'text-bg-dark', 'Your Custom', '<div class=\"px-4 py-5 my-5 text-center\">\n    <img class=\"d-block mx-auto mb-4\" src=\"https://getbootstrap.com/docs/5.2/assets/brand/bootstrap-logo.svg\" alt=\"\" width=\"72\" height=\"57\">\n    <h1 class=\"display-5 fw-bold\">Centered hero</h1>\n    <div class=\"col-lg-6 mx-auto\">\n      <p class=\"lead mb-4\">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>\n      <div class=\"d-grid gap-2 d-sm-flex justify-content-sm-center\">\n        <button type=\"button\" class=\"btn btn-primary btn-lg px-4 gap-3\">Primary button</button>\n        <button type=\"button\" class=\"btn btn-outline-secondary btn-lg px-4\">Secondary</button>\n      </div>\n    </div>\n  </div>', 1, '2022-08-06 13:31:03', '2023-02-10 16:56:24'),
(2, 'col-sm-12', 'text-bg-dark', 'Test', 'infonews', 1, '2023-02-10 16:03:10', '2023-08-16 17:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `dokters`
--

CREATE TABLE `dokters` (
  `id` int(11) NOT NULL,
  `nip_nik` varchar(150) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `tempat_lahir` varchar(150) NOT NULL DEFAULT '',
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `spesialis` varchar(150) NOT NULL,
  `kode_dokter` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `dosens`
--

CREATE TABLE `dosens` (
  `id` int(11) NOT NULL,
  `nip_nik` varchar(255) NOT NULL DEFAULT '',
  `nama_lengkap` varchar(255) NOT NULL DEFAULT '',
  `tempat_lahir` varchar(255) NOT NULL DEFAULT '',
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL DEFAULT '',
  `kode_dosen` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `galeris`
--

CREATE TABLE `galeris` (
  `id` int(11) NOT NULL,
  `label` varchar(150) NOT NULL,
  `deskripsi` varchar(150) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `galeris`
--

INSERT INTO `galeris` (`id`, `label`, `deskripsi`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Kegiatan AKSI BERGIZI yang dilaksanakan oleh Puskemas Balarja di SMPIT Al Itqon', 'Dalam kegiatan AKSI BERGIZI dibuka oleh Kepala Puskesmas Balaraja dr. Ai Siti Zakiyah, dilanjutkan dengan senam Bersama, sarapan Bersama, penyuluhan K', 'images/1692338508_c56cba5e67ec694edd9d.jpg', 1, '2023-08-18 13:01:49', '2023-08-21 09:28:15'),
(4, 'Kegiatan AKSI BERGIZI yang dilaksanakan oleh Puskemas Balarja di SMPIT Al Itqon', 'Dalam kegiatan AKSI BERGIZI dibuka oleh Kepala Puskesmas Balaraja dr. Ai Siti Zakiyah, dilanjutkan dengan senam Bersama, sarapan Bersama, penyuluhan K', 'images/1692338548_583c85285ac652c66d11.jpg', 1, '2023-08-18 13:02:43', '2023-08-21 09:28:17'),
(5, 'Penyuluhan PHBS Rumah Tangga', 'Penyuluhan mengenai PHBS di Rumah Tangga yang dilakukan oleh promkes Puskesmas Balaraja di Perumahan Duta Asri', 'images/1692584886_5038b57d2c6ed78a59f1.jpg', 1, '2023-08-21 09:28:09', '2023-08-21 09:28:09'),
(6, 'Kegiatan Penyuluhan saat MPLS di SMAN 19 Kab. Tangerang', 'Kegiatan penyuluhan yang dilakukan oleh dokter dari Puskesms Balaraja saat kegiatan MPLS di SMAN 19 Kab. Tangerang mengenai Kesehatan Reproduksi', 'images/1692585105_b6ffb5a4f98d444033da.jpg', 1, '2023-08-21 09:31:50', '2023-08-21 09:31:50'),
(7, 'Penyuluhan di PT Adis Dimention Footwear', 'Penyuluhan mengenai kesehatan reproduksi dan KB di PT Adis Dimention Footwear dilakukan oleh dokter dari Puskesmas Balaraja ', 'images/1692585258_f33343e924669c801b54.jpg', 1, '2023-08-21 09:35:11', '2023-08-21 09:35:11'),
(8, 'Kegiatan Prolanis', 'Penyuluhan kesehatan dan pemeriksaan kesehatan pada Lansia pada kegiatan prolanis yang dilakukan setiap bula di Aula puskesmas Balaraja', 'images/1692585349_a632af27493cebfe86c2.jpg', 1, '2023-08-21 09:36:24', '2023-08-21 09:36:24'),
(9, 'Kegiata DASHAT', 'Kegiatan dapur sehat yang diadakan di setiap Desa di Wilayah Kerja Puskesmas Balaraja dalam upaya pencegahan stunting', 'images/1692585416_6dd9504ea53aa03d5a78.jpg', 1, '2023-08-21 09:37:49', '2023-08-21 09:37:49'),
(10, 'Pencanangan Kampung PHBS', 'Penyuluhan mengenai PHBS yang dilanjutkan dengan pencanangan kampung ber-PHBS di Perumahan Permata Balaraja', 'images/1692585541_6236d99c3da9ee2e68f7.jpg', 1, '2023-08-21 09:39:03', '2023-08-21 09:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` int(11) NOT NULL,
  `nip_nik` varchar(150) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `tempat_lahir` varchar(150) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `jabatan` varchar(150) NOT NULL,
  `kode_guru` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `haribelajars`
--

CREATE TABLE `haribelajars` (
  `id` int(11) NOT NULL,
  `id_jampelajaran` int(11) NOT NULL DEFAULT 0,
  `senin` int(11) NOT NULL,
  `selasa` int(11) NOT NULL,
  `rabu` int(11) NOT NULL,
  `kamis` int(11) NOT NULL,
  `jumat` int(11) NOT NULL,
  `sabtu` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `harilayanans`
--

CREATE TABLE `harilayanans` (
  `id` int(11) NOT NULL,
  `id_jampelayanan` int(11) NOT NULL DEFAULT 0,
  `senin` int(11) NOT NULL,
  `selasa` int(11) NOT NULL,
  `rabu` int(11) NOT NULL,
  `kamis` int(11) NOT NULL,
  `jumat` int(11) NOT NULL,
  `sabtu` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `jadwaldokters`
--

CREATE TABLE `jadwaldokters` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL DEFAULT 0,
  `id_layanan` int(11) NOT NULL DEFAULT 0,
  `id_ruang` int(11) NOT NULL DEFAULT 0,
  `jam_ke` int(11) NOT NULL DEFAULT 0,
  `hari` varchar(20) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jadwalpelajarans`
--

CREATE TABLE `jadwalpelajarans` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL DEFAULT 0,
  `jam_ke` int(11) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `id_guru` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `jadwalsholats`
--

CREATE TABLE `jadwalsholats` (
  `id` bigint(20) NOT NULL,
  `id_bulan` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `imsak` varchar(10) NOT NULL,
  `subuh` varchar(10) NOT NULL,
  `terbit` varchar(10) NOT NULL,
  `dhuha` varchar(10) NOT NULL,
  `dzuhur` varchar(10) NOT NULL,
  `ashar` varchar(10) NOT NULL,
  `maghrib` varchar(10) NOT NULL,
  `isya` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `jadwalsholats`
--

INSERT INTO `jadwalsholats` (`id`, `id_bulan`, `date`, `imsak`, `subuh`, `terbit`, `dhuha`, `dzuhur`, `ashar`, `maghrib`, `isya`, `created_at`, `updated_at`) VALUES
(1, 3, '2023-03-01', '4:04', '4:14', '5:32', '6:01', '11:51', '15:16', '18:03', '19:18', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(2, 3, '2023-03-02', '4:04', '4:14', '5:32', '6:01', '11:52', '15:16', '18:04', '19:18', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(3, 3, '2023-03-03', '4:04', '4:14', '5:33', '6:02', '11:52', '15:17', '18:04', '19:19', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(4, 3, '2023-03-04', '4:05', '4:15', '5:33', '6:02', '11:52', '15:17', '18:05', '19:19', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(5, 3, '2023-03-05', '4:05', '4:15', '5:33', '6:02', '11:53', '15:18', '18:05', '19:20', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(6, 3, '2023-03-06', '4:05', '4:15', '5:34', '6:03', '11:53', '15:19', '18:06', '19:21', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(7, 3, '2023-03-07', '4:05', '4:15', '5:34', '6:03', '11:54', '15:19', '18:06', '19:21', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(8, 3, '2023-03-08', '4:06', '4:16', '5:35', '6:03', '11:54', '15:20', '18:07', '19:22', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(9, 3, '2023-03-09', '4:06', '4:16', '5:35', '6:04', '11:55', '15:20', '18:07', '19:22', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(10, 3, '2023-03-10', '4:06', '4:16', '5:35', '6:04', '11:55', '15:21', '18:08', '19:23', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(11, 3, '2023-03-11', '4:07', '4:17', '5:36', '6:05', '11:55', '15:21', '18:08', '19:23', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(12, 3, '2023-03-12', '4:07', '4:17', '5:36', '6:05', '11:56', '15:22', '18:09', '19:24', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(13, 3, '2023-03-13', '4:07', '4:17', '5:37', '6:06', '11:56', '15:22', '18:09', '19:24', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(14, 3, '2023-03-14', '4:08', '4:18', '5:37', '6:06', '11:57', '15:23', '18:10', '19:25', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(15, 3, '2023-03-15', '4:08', '4:18', '5:37', '6:06', '11:57', '15:23', '18:10', '19:25', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(16, 3, '2023-03-16', '4:09', '4:19', '5:38', '6:07', '11:58', '15:24', '18:11', '19:26', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(17, 3, '2023-03-17', '4:09', '4:19', '5:38', '6:07', '11:58', '15:24', '18:11', '19:27', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(18, 3, '2023-03-18', '4:09', '4:19', '5:39', '6:08', '11:59', '15:25', '18:12', '19:27', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(19, 3, '2023-03-19', '4:10', '4:20', '5:39', '6:08', '11:59', '15:25', '18:12', '19:28', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(20, 3, '2023-03-20', '4:10', '4:20', '5:40', '6:09', '12:00', '15:26', '18:13', '19:28', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(21, 3, '2023-03-21', '4:11', '4:21', '5:40', '6:09', '12:00', '15:27', '18:13', '19:29', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(22, 3, '2023-03-22', '4:11', '4:21', '5:41', '6:10', '12:01', '15:27', '18:14', '19:29', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(23, 3, '2023-03-23', '4:12', '4:22', '5:41', '6:10', '12:01', '15:28', '18:14', '19:30', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(24, 3, '2023-03-24', '4:12', '4:22', '5:42', '6:11', '12:02', '15:28', '18:15', '19:30', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(25, 3, '2023-03-25', '4:13', '4:23', '5:42', '6:11', '12:02', '15:28', '18:15', '19:31', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(26, 3, '2023-03-26', '4:13', '4:23', '5:43', '6:12', '12:03', '15:29', '18:16', '19:31', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(27, 3, '2023-03-27', '4:14', '4:24', '5:43', '6:12', '12:03', '15:29', '18:16', '19:31', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(28, 3, '2023-03-28', '4:14', '4:24', '5:44', '6:13', '12:04', '15:30', '18:17', '19:32', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(29, 3, '2023-03-29', '4:15', '4:25', '5:44', '6:13', '12:04', '15:30', '18:17', '19:32', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(30, 3, '2023-03-30', '4:16', '4:26', '5:45', '6:14', '12:05', '15:31', '18:18', '19:33', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(31, 3, '2023-03-31', '4:16', '4:26', '5:45', '6:14', '12:05', '15:31', '18:18', '19:33', '2023-03-04 09:36:09', '2023-03-04 09:36:09'),
(32, 5, '2023-05-01', '4:04', '4:14', '5:32', '6:01', '11:51', '15:16', '18:03', '19:18', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(33, 5, '2023-05-02', '4:04', '4:14', '5:32', '6:01', '11:52', '15:16', '18:04', '19:18', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(34, 5, '2023-05-03', '4:04', '4:14', '5:33', '6:02', '11:52', '15:17', '18:04', '19:19', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(35, 5, '2023-05-04', '4:05', '4:15', '5:33', '6:02', '11:52', '15:17', '18:05', '19:19', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(36, 5, '2023-05-05', '4:05', '4:15', '5:33', '6:02', '11:53', '15:18', '18:05', '19:20', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(37, 5, '2023-05-06', '4:05', '4:15', '5:34', '6:03', '11:53', '15:19', '18:06', '19:21', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(38, 5, '2023-05-07', '4:05', '4:15', '5:34', '6:03', '11:54', '15:19', '18:06', '19:21', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(39, 5, '2023-05-08', '4:06', '4:16', '5:35', '6:03', '11:54', '15:20', '18:07', '19:22', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(40, 5, '2023-05-09', '4:06', '4:16', '5:35', '6:04', '8:06', '15:20', '18:07', '19:22', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(41, 5, '2023-05-10', '4:06', '4:16', '5:35', '6:04', '11:55', '15:21', '18:08', '19:23', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(42, 5, '2023-05-11', '4:07', '4:17', '5:36', '6:05', '11:55', '15:21', '18:08', '19:23', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(43, 5, '2023-05-12', '4:07', '4:17', '5:36', '6:05', '11:56', '15:22', '18:09', '19:24', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(44, 5, '2023-05-13', '4:07', '4:17', '5:37', '6:06', '11:56', '15:22', '18:09', '19:24', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(45, 5, '2023-05-14', '4:08', '4:18', '5:37', '6:06', '11:57', '15:23', '18:10', '19:25', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(46, 5, '2023-05-15', '4:08', '4:18', '5:37', '6:06', '11:57', '15:23', '18:10', '19:25', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(47, 5, '2023-05-16', '4:09', '4:19', '5:38', '6:07', '11:58', '15:24', '18:11', '19:26', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(48, 5, '2023-05-17', '4:09', '4:19', '5:38', '6:07', '11:58', '15:24', '18:11', '19:27', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(49, 5, '2023-05-18', '4:09', '4:19', '5:39', '6:08', '11:59', '15:25', '18:12', '19:27', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(50, 5, '2023-05-19', '4:10', '4:20', '5:39', '6:08', '11:59', '15:25', '18:12', '19:28', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(51, 5, '2023-05-20', '4:10', '4:20', '5:40', '6:09', '12:00', '15:26', '18:13', '19:28', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(52, 5, '2023-05-21', '4:11', '4:21', '5:40', '6:09', '12:00', '15:27', '18:13', '19:29', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(53, 5, '2023-05-22', '4:11', '4:21', '5:41', '6:10', '12:01', '15:27', '18:14', '19:29', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(54, 5, '2023-05-23', '4:12', '4:22', '5:41', '6:10', '12:01', '15:28', '18:14', '19:30', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(55, 5, '2023-05-24', '4:12', '4:22', '5:42', '6:11', '12:02', '15:28', '18:15', '19:30', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(56, 5, '2023-05-25', '4:13', '4:23', '5:42', '6:11', '12:02', '15:28', '18:15', '19:31', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(57, 5, '2023-05-26', '4:13', '4:23', '5:43', '6:12', '12:03', '15:29', '18:16', '19:31', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(58, 5, '2023-05-27', '4:14', '4:24', '5:43', '6:12', '12:03', '15:29', '18:16', '19:31', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(59, 5, '2023-05-28', '4:14', '4:24', '5:44', '6:13', '12:04', '15:30', '18:17', '19:32', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(60, 5, '2023-05-29', '4:15', '4:25', '5:44', '6:13', '12:04', '15:30', '18:17', '19:32', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(61, 5, '2023-05-30', '4:16', '4:26', '5:45', '6:14', '12:05', '15:31', '18:18', '19:33', '2023-05-09 08:01:24', '2023-05-09 08:01:24'),
(62, 5, '2023-05-31', '4:16', '4:26', '5:45', '6:14', '12:05', '15:31', '18:18', '19:33', '2023-05-09 08:01:24', '2023-05-09 08:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `jampelajarans`
--

CREATE TABLE `jampelajarans` (
  `id` int(11) NOT NULL,
  `jam_ke` int(11) NOT NULL,
  `mulai` varchar(10) NOT NULL DEFAULT '',
  `selesai` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `jampelayanans`
--

CREATE TABLE `jampelayanans` (
  `id` int(11) NOT NULL,
  `jam_ke` int(11) NOT NULL DEFAULT 0,
  `mulai` varchar(10) NOT NULL DEFAULT '',
  `selesai` varchar(10) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `jenislayanans`
--

CREATE TABLE `jenislayanans` (
  `id` int(11) NOT NULL,
  `jenis_layanan` varchar(255) DEFAULT NULL,
  `tarif_layanan` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jumatans`
--

CREATE TABLE `jumatans` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `imam` varchar(150) NOT NULL,
  `khotib` varchar(150) NOT NULL,
  `muazin` varchar(150) NOT NULL,
  `judul_khotbah` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatanmasjids`
--

CREATE TABLE `kegiatanmasjids` (
  `id` int(11) NOT NULL,
  `nama_kegiatan` varchar(150) NOT NULL,
  `deskripsi_kegiatan` text NOT NULL,
  `tempat_kegiatan` varchar(150) NOT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `waktu` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `tingkat` int(11) NOT NULL,
  `nama_kelas` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `keuanganmasjids`
--

CREATE TABLE `keuanganmasjids` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `uraian` varchar(250) NOT NULL,
  `jenis` int(11) NOT NULL,
  `pemasukan` decimal(13,2) NOT NULL,
  `pengeluaran` decimal(13,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `kotas`
--

CREATE TABLE `kotas` (
  `id` char(4) NOT NULL DEFAULT '',
  `lokasi` varchar(255) DEFAULT NULL,
  `id_provinsi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kotas`
--

INSERT INTO `kotas` (`id`, `lokasi`, `id_provinsi`) VALUES
('0101', 'KAB. ACEH BARAT', 1),
('0102', 'KAB. ACEH BARAT DAYA', 1),
('0103', 'KAB. ACEH BESAR', 1),
('0104', 'KAB. ACEH JAYA', 1),
('0105', 'KAB. ACEH SELATAN', 1),
('0106', 'KAB. ACEH SINGKIL', 1),
('0107', 'KAB. ACEH TAMIANG', 1),
('0108', 'KAB. ACEH TENGAH', 1),
('0109', 'KAB. ACEH TENGGARA', 1),
('0110', 'KAB. ACEH TIMUR', 1),
('0111', 'KAB. ACEH UTARA', 1),
('0112', 'KAB. BENER MERIAH', 1),
('0113', 'KAB. BIREUEN', 1),
('0114', 'KAB. GAYO LUES', 1),
('0115', 'KAB. NAGAN RAYA', 1),
('0116', 'KAB. PIDIE', 1),
('0117', 'KAB. PIDIE JAYA', 1),
('0118', 'KAB. SIMEULUE', 1),
('0119', 'KOTA BANDA ACEH', 1),
('0120', 'KOTA LANGSA', 1),
('0121', 'KOTA LHOKSEUMAWE', 1),
('0122', 'KOTA SABANG', 1),
('0123', 'KOTA SUBULUSSALAM', 1),
('0201', 'KAB. ASAHAN', 2),
('0202', 'KAB. BATUBARA', 2),
('0203', 'KAB. DAIRI', 2),
('0204', 'KAB. DELI SERDANG', 2),
('0205', 'KAB. HUMBANG HASUNDUTAN', 2),
('0206', 'KAB. KARO', 2),
('0207', 'KAB. LABUHANBATU', 2),
('0208', 'KAB. LABUHANBATU SELATAN', 2),
('0209', 'KAB. LABUHANBATU UTARA', 2),
('0210', 'KAB. LANGKAT', 2),
('0211', 'KAB. MANDAILING NATAL', 2),
('0212', 'KAB. NIAS', 2),
('0213', 'KAB. NIAS BARAT', 2),
('0214', 'KAB. NIAS SELATAN', 2),
('0215', 'KAB. NIAS UTARA', 2),
('0216', 'KAB. PADANG LAWAS', 2),
('0217', 'KAB. PADANG LAWAS UTARA', 2),
('0218', 'KAB. PAKPAK BHARAT', 2),
('0219', 'KAB. SAMOSIR', 2),
('0220', 'KAB. SERDANG BEDAGAI', 2),
('0221', 'KAB. SIMALUNGUN', 2),
('0222', 'KAB. TAPANULI SELATAN', 2),
('0223', 'KAB. TAPANULI TENGAH', 2),
('0224', 'KAB. TAPANULI UTARA', 2),
('0225', 'KAB. TOBA SAMOSIR', 2),
('0226', 'KOTA BINJAI', 2),
('0227', 'KOTA GUNUNGSITOLI', 2),
('0228', 'KOTA MEDAN', 2),
('0229', 'KOTA PADANGSIDEMPUAN', 2),
('0230', 'KOTA PEMATANGSIANTAR', 2),
('0231', 'KOTA SIBOLGA', 2),
('0232', 'KOTA TANJUNGBALAI', 2),
('0233', 'KOTA TEBING TINGGI', 2),
('0301', 'KAB. AGAM', 3),
('0302', 'KAB. DHARMASRAYA', 3),
('0303', 'KAB. KEPULAUAN MENTAWAI', 3),
('0304', 'KAB. LIMA PULUH KOTA', 3),
('0305', 'KAB. PADANG PARIAMAN', 3),
('0306', 'KAB. PASAMAN', 3),
('0307', 'KAB. PASAMAN BARAT', 3),
('0308', 'KAB. PESISIR SELATAN', 3),
('0309', 'KAB. SIJUNJUNG', 3),
('0310', 'KAB. SOLOK', 3),
('0311', 'KAB. SOLOK SELATAN', 3),
('0312', 'KAB. TANAH DATAR', 3),
('0313', 'KOTA BUKITTINGGI', 3),
('0314', 'KOTA PADANG', 3),
('0315', 'KOTA PADANGPANJANG', 3),
('0316', 'KOTA PARIAMAN', 3),
('0317', 'KOTA PAYAKUMBUH', 3),
('0318', 'KOTA SAWAHLUNTO', 3),
('0319', 'KOTA SOLOK', 3),
('0401', 'KAB. BENGKALIS', 4),
('0402', 'KAB. INDRAGIRI HILIR', 4),
('0403', 'KAB. INDRAGIRI HULU', 4),
('0404', 'KAB. KAMPAR', 4),
('0405', 'KAB. KEPULAUAN MERANTI', 4),
('0406', 'KAB. KUANTAN SINGINGI', 4),
('0407', 'KAB. PELALAWAN', 4),
('0408', 'KAB. ROKAN HILIR', 4),
('0409', 'KAB. ROKAN HULU', 4),
('0410', 'KAB. SIAK', 4),
('0411', 'KOTA DUMAI', 4),
('0412', 'KOTA PEKANBARU', 4),
('0501', 'KAB. BINTAN', 5),
('0502', 'KAB. KARIMUN', 5),
('0503', 'KAB. KEPULAUAN ANAMBAS', 5),
('0504', 'KAB. LINGGA', 5),
('0505', 'KAB. NATUNA', 5),
('0506', 'KOTA BATAM', 5),
('0507', 'KOTA TANJUNG PINANG', 5),
('0508', 'PULAU TAMBELAN KAB. BINTAN', 5),
('0509', 'PEKAJANG KAB. LINGGA', 5),
('0510', 'PULAU SERASAN KAB. NATUNA', 5),
('0511', 'PULAU MIDAI KAB. NATUNA', 5),
('0512', 'PULAU LAUT KAB. NATUNA', 5),
('0601', 'KAB. BATANGHARI', 6),
('0602', 'KAB. BUNGO', 6),
('0603', 'KAB. KERINCI', 6),
('0604', 'KAB. MERANGIN', 6),
('0605', 'KAB. MUARO JAMBI', 6),
('0606', 'KAB. SAROLANGUN', 6),
('0607', 'KAB. TANJUNG JABUNG BARAT', 6),
('0608', 'KAB. TANJUNG JABUNG TIMUR', 6),
('0609', 'KAB. TEBO', 6),
('0610', 'KOTA JAMBI', 6),
('0611', 'KOTA SUNGAI PENUH', 6),
('0701', 'KAB. BENGKULU SELATAN', 7),
('0702', 'KAB. BENGKULU TENGAH', 7),
('0703', 'KAB. BENGKULU UTARA', 7),
('0704', 'KAB. KAUR', 7),
('0705', 'KAB. KEPAHIANG', 7),
('0706', 'KAB. LEBONG', 7),
('0707', 'KAB. MUKOMUKO', 7),
('0708', 'KAB. REJANG LEBONG', 7),
('0709', 'KAB. SELUMA', 7),
('0710', 'KOTA BENGKULU', 7),
('0801', 'KAB. BANYUASIN', 8),
('0802', 'KAB. EMPAT LAWANG', 8),
('0803', 'KAB. LAHAT', 8),
('0804', 'KAB. MUARA ENIM', 8),
('0805', 'KAB. MUSI BANYUASIN', 8),
('0806', 'KAB. MUSI RAWAS', 8),
('0807', 'KAB. MUSI RAWAS UTARA', 8),
('0808', 'KAB. OGAN ILIR', 8),
('0809', 'KAB. OGAN KOMERING ILIR', 8),
('0810', 'KAB. OGAN KOMERING ULU', 8),
('0811', 'KAB. OGAN KOMERING ULU SELATAN', 8),
('0812', 'KAB. OGAN KOMERING ULU TIMUR', 8),
('0813', 'KAB. PENUKAL ABAB LEMATANG ILIR', 8),
('0814', 'KOTA LUBUKLINGGAU', 8),
('0815', 'KOTA PAGAR ALAM', 8),
('0816', 'KOTA PALEMBANG', 8),
('0817', 'KOTA PRABUMULIH', 8),
('0901', 'KAB. BANGKA', 9),
('0902', 'KAB. BANGKA BARAT', 9),
('0903', 'KAB. BANGKA SELATAN', 9),
('0904', 'KAB. BANGKA TENGAH', 9),
('0905', 'KAB. BELITUNG', 9),
('0906', 'KAB. BELITUNG TIMUR', 9),
('0907', 'KOTA PANGKAL PINANG', 9),
('1001', 'KAB. LAMPUNG TENGAH', 10),
('1002', 'KAB. LAMPUNG UTARA', 10),
('1003', 'KAB. LAMPUNG SELATAN', 10),
('1004', 'KAB. LAMPUNG BARAT', 10),
('1005', 'KAB. LAMPUNG TIMUR', 10),
('1006', 'KAB. MESUJI', 10),
('1007', 'KAB. PESAWARAN', 10),
('1008', 'KAB. PESISIR BARAT', 10),
('1009', 'KAB. PRINGSEWU', 10),
('1010', 'KAB. TULANG BAWANG', 10),
('1011', 'KAB. TULANG BAWANG BARAT', 10),
('1012', 'KAB. TANGGAMUS', 10),
('1013', 'KAB. WAY KANAN', 10),
('1014', 'KOTA BANDAR LAMPUNG', 10),
('1015', 'KOTA METRO', 10),
('1101', 'KAB. LEBAK', 11),
('1102', 'KAB. PANDEGLANG', 11),
('1103', 'KAB. SERANG', 11),
('1104', 'KAB. TANGERANG', 11),
('1105', 'KOTA CILEGON', 11),
('1106', 'KOTA SERANG', 11),
('1107', 'KOTA TANGERANG', 11),
('1108', 'KOTA TANGERANG SELATAN', 11),
('1201', 'KAB. BANDUNG', 12),
('1202', 'KAB. BANDUNG BARAT', 12),
('1203', 'KAB. BEKASI', 12),
('1204', 'KAB. BOGOR', 12),
('1205', 'KAB. CIAMIS', 12),
('1206', 'KAB. CIANJUR', 12),
('1207', 'KAB. CIREBON', 12),
('1208', 'KAB. GARUT', 12),
('1209', 'KAB. INDRAMAYU', 12),
('1210', 'KAB. KARAWANG', 12),
('1211', 'KAB. KUNINGAN', 12),
('1212', 'KAB. MAJALENGKA', 12),
('1213', 'KAB. PANGANDARAN', 12),
('1214', 'KAB. PURWAKARTA', 12),
('1215', 'KAB. SUBANG', 12),
('1216', 'KAB. SUKABUMI', 12),
('1217', 'KAB. SUMEDANG', 12),
('1218', 'KAB. TASIKMALAYA', 12),
('1219', 'KOTA BANDUNG', 12),
('1220', 'KOTA BANJAR', 12),
('1221', 'KOTA BEKASI', 12),
('1222', 'KOTA BOGOR', 12),
('1223', 'KOTA CIMAHI', 12),
('1224', 'KOTA CIREBON', 12),
('1225', 'KOTA DEPOK', 12),
('1226', 'KOTA SUKABUMI', 12),
('1227', 'KOTA TASIKMALAYA', 12),
('1301', 'KOTA JAKARTA', 13),
('1302', 'KAB. KEPULAUAN SERIBU', 13),
('1401', 'KAB. BANJARNEGARA', 14),
('1402', 'KAB. BANYUMAS', 14),
('1403', 'KAB. BATANG', 14),
('1404', 'KAB. BLORA', 14),
('1405', 'KAB. BOYOLALI', 14),
('1406', 'KAB. BREBES', 14),
('1407', 'KAB. CILACAP', 14),
('1408', 'KAB. DEMAK', 14),
('1409', 'KAB. GROBOGAN', 14),
('1410', 'KAB. JEPARA', 14),
('1411', 'KAB. KARANGANYAR', 14),
('1412', 'KAB. KEBUMEN', 14),
('1413', 'KAB. KENDAL', 14),
('1414', 'KAB. KLATEN', 14),
('1415', 'KAB. KUDUS', 14),
('1416', 'KAB. MAGELANG', 14),
('1417', 'KAB. PATI', 14),
('1418', 'KAB. PEKALONGAN', 14),
('1419', 'KAB. PEMALANG', 14),
('1420', 'KAB. PURBALINGGA', 14),
('1421', 'KAB. PURWOREJO', 14),
('1422', 'KAB. REMBANG', 14),
('1423', 'KAB. SEMARANG', 14),
('1424', 'KAB. SRAGEN', 14),
('1425', 'KAB. SUKOHARJO', 14),
('1426', 'KAB. TEGAL', 14),
('1427', 'KAB. TEMANGGUNG', 14),
('1428', 'KAB. WONOGIRI', 14),
('1429', 'KAB. WONOSOBO', 14),
('1430', 'KOTA MAGELANG', 14),
('1431', 'KOTA PEKALONGAN', 14),
('1432', 'KOTA SALATIGA', 14),
('1433', 'KOTA SEMARANG', 14),
('1434', 'KOTA SURAKARTA', 14),
('1435', 'KOTA TEGAL', 14),
('1501', 'KAB. BANTUL', 15),
('1502', 'KAB. GUNUNGKIDUL', 15),
('1503', 'KAB. KULON PROGO', 15),
('1504', 'KAB. SLEMAN', 15),
('1505', 'KOTA YOGYAKARTA', 15),
('1601', 'KAB. BANGKALAN', 16),
('1602', 'KAB. BANYUWANGI', 16),
('1603', 'KAB. BLITAR', 16),
('1604', 'KAB. BOJONEGORO', 16),
('1605', 'KAB. BONDOWOSO', 16),
('1606', 'KAB. GRESIK', 16),
('1607', 'KAB. JEMBER', 16),
('1608', 'KAB. JOMBANG', 16),
('1609', 'KAB. KEDIRI', 16),
('1610', 'KAB. LAMONGAN', 16),
('1611', 'KAB. LUMAJANG', 16),
('1612', 'KAB. MADIUN', 16),
('1613', 'KAB. MAGETAN', 16),
('1614', 'KAB. MALANG', 16),
('1615', 'KAB. MOJOKERTO', 16),
('1616', 'KAB. NGANJUK', 16),
('1617', 'KAB. NGAWI', 16),
('1618', 'KAB. PACITAN', 16),
('1619', 'KAB. PAMEKASAN', 16),
('1620', 'KAB. PASURUAN', 16),
('1621', 'KAB. PONOROGO', 16),
('1622', 'KAB. PROBOLINGGO', 16),
('1623', 'KAB. SAMPANG', 16),
('1624', 'KAB. SIDOARJO', 16),
('1625', 'KAB. SITUBONDO', 16),
('1626', 'KAB. SUMENEP', 16),
('1627', 'KAB. TRENGGALEK', 16),
('1628', 'KAB. TUBAN', 16),
('1629', 'KAB. TULUNGAGUNG', 16),
('1630', 'KOTA BATU', 16),
('1631', 'KOTA BLITAR', 16),
('1632', 'KOTA KEDIRI', 16),
('1633', 'KOTA MADIUN', 16),
('1634', 'KOTA MALANG', 16),
('1635', 'KOTA MOJOKERTO', 16),
('1636', 'KOTA PASURUAN', 16),
('1637', 'KOTA PROBOLINGGO', 16),
('1638', 'KOTA SURABAYA', 16),
('1701', 'KAB. BADUNG', 17),
('1702', 'KAB. BANGLI', 17),
('1703', 'KAB. BULELENG', 17),
('1704', 'KAB. GIANYAR', 17),
('1705', 'KAB. JEMBRANA', 17),
('1706', 'KAB. KARANGASEM', 17),
('1707', 'KAB. KLUNGKUNG', 17),
('1708', 'KAB. TABANAN', 17),
('1709', 'KOTA DENPASAR', 17),
('1801', 'KAB. BIMA', 18),
('1802', 'KAB. DOMPU', 18),
('1803', 'KAB. LOMBOK BARAT', 18),
('1804', 'KAB. LOMBOK TENGAH', 18),
('1805', 'KAB. LOMBOK TIMUR', 18),
('1806', 'KAB. LOMBOK UTARA', 18),
('1807', 'KAB. SUMBAWA', 18),
('1808', 'KAB. SUMBAWA BARAT', 18),
('1809', 'KOTA BIMA', 18),
('1810', 'KOTA MATARAM', 18),
('1901', 'KAB. ALOR', 19),
('1902', 'KAB. BELU', 19),
('1903', 'KAB. ENDE', 19),
('1904', 'KAB. FLORES TIMUR', 19),
('1905', 'KAB. KUPANG', 19),
('1906', 'KAB. LEMBATA', 19),
('1907', 'KAB. MALAKA', 19),
('1908', 'KAB. MANGGARAI', 19),
('1909', 'KAB. MANGGARAI BARAT', 19),
('1910', 'KAB. MANGGARAI TIMUR', 19),
('1911', 'KAB. NGADA', 19),
('1912', 'KAB. NAGEKEO', 19),
('1913', 'KAB. ROTE NDAO', 19),
('1914', 'KAB. SABU RAIJUA', 19),
('1915', 'KAB. SIKKA', 19),
('1916', 'KAB. SUMBA BARAT', 19),
('1917', 'KAB. SUMBA BARAT DAYA', 19),
('1918', 'KAB. SUMBA TENGAH', 19),
('1919', 'KAB. SUMBA TIMUR', 19),
('1920', 'KAB. TIMOR TENGAH SELATAN', 19),
('1921', 'KAB. TIMOR TENGAH UTARA', 19),
('1922', 'KOTA KUPANG', 19),
('2001', 'KAB. BENGKAYANG', 20),
('2002', 'KAB. KAPUAS HULU', 20),
('2003', 'KAB. KAYONG UTARA', 20),
('2004', 'KAB. KETAPANG', 20),
('2005', 'KAB. KUBU RAYA', 20),
('2006', 'KAB. LANDAK', 20),
('2007', 'KAB. MELAWI', 20),
('2008', 'KAB. MEMPAWAH', 20),
('2009', 'KAB. SAMBAS', 20),
('2010', 'KAB. SANGGAU', 20),
('2011', 'KAB. SEKADAU', 20),
('2012', 'KAB. SINTANG', 20),
('2013', 'KOTA PONTIANAK', 20),
('2014', 'KOTA SINGKAWANG', 20),
('2101', 'KAB. BALANGAN', 21),
('2102', 'KAB. BANJAR', 21),
('2103', 'KAB. BARITO KUALA', 21),
('2104', 'KAB. HULU SUNGAI SELATAN', 21),
('2105', 'KAB. HULU SUNGAI TENGAH', 21),
('2106', 'KAB. HULU SUNGAI UTARA', 21),
('2107', 'KAB. KOTABARU', 21),
('2108', 'KAB. TABALONG', 21),
('2109', 'KAB. TANAH BUMBU', 21),
('2110', 'KAB. TANAH LAUT', 21),
('2111', 'KAB. TAPIN', 21),
('2112', 'KOTA BANJARBARU', 21),
('2113', 'KOTA BANJARMASIN', 21),
('2201', 'KAB. BARITO SELATAN', 22),
('2202', 'KAB. BARITO TIMUR', 22),
('2203', 'KAB. BARITO UTARA', 22),
('2204', 'KAB. GUNUNG MAS', 22),
('2205', 'KAB. KAPUAS', 22),
('2206', 'KAB. KATINGAN', 22),
('2207', 'KAB. KOTAWARINGIN BARAT', 22),
('2208', 'KAB. KOTAWARINGIN TIMUR', 22),
('2209', 'KAB. LAMANDAU', 22),
('2210', 'KAB. MURUNG RAYA', 22),
('2211', 'KAB. PULANG PISAU', 22),
('2212', 'KAB. SUKAMARA', 22),
('2213', 'KAB. SERUYAN', 22),
('2214', 'KOTA PALANGKARAYA', 22),
('2301', 'KAB. BERAU', 23),
('2302', 'KAB. KUTAI BARAT', 23),
('2303', 'KAB. KUTAI KARTANEGARA', 23),
('2304', 'KAB. KUTAI TIMUR', 23),
('2305', 'KAB. MAHAKAM ULU', 23),
('2306', 'KAB. PASER', 23),
('2307', 'KAB. PENAJAM PASER UTARA', 23),
('2308', 'KOTA BALIKPAPAN', 23),
('2309', 'KOTA BONTANG', 23),
('2310', 'KOTA SAMARINDA', 23),
('2401', 'KAB. BULUNGAN', 24),
('2402', 'KAB. MALINAU', 24),
('2403', 'KAB. NUNUKAN', 24),
('2404', 'KAB. TANA TIDUNG', 24),
('2405', 'KOTA TARAKAN', 24),
('2501', 'KAB. BOALEMO', 25),
('2502', 'KAB. BONE BOLANGO', 25),
('2503', 'KAB. GORONTALO', 25),
('2504', 'KAB. GORONTALO UTARA', 25),
('2505', 'KAB. POHUWATO', 25),
('2506', 'KOTA GORONTALO', 25),
('2601', 'KAB. BANTAENG', 26),
('2602', 'KAB. BARRU', 26),
('2603', 'KAB. BONE', 26),
('2604', 'KAB. BULUKUMBA', 26),
('2605', 'KAB. ENREKANG', 26),
('2606', 'KAB. GOWA', 26),
('2607', 'KAB. JENEPONTO', 26),
('2608', 'KAB. KEPULAUAN SELAYAR', 26),
('2609', 'KAB. LUWU', 26),
('2610', 'KAB. LUWU TIMUR', 26),
('2611', 'KAB. LUWU UTARA', 26),
('2612', 'KAB. MAROS', 26),
('2613', 'KAB. PANGKAJENE DAN KEPULAUAN', 26),
('2614', 'KAB. PINRANG', 26),
('2615', 'KAB. SIDENRENG RAPPANG', 26),
('2616', 'KAB. SINJAI', 26),
('2617', 'KAB. SOPPENG', 26),
('2618', 'KAB. TAKALAR', 26),
('2619', 'KAB. TANA TORAJA', 26),
('2620', 'KAB. TORAJA UTARA', 26),
('2621', 'KAB. WAJO', 26),
('2622', 'KOTA MAKASSAR', 26),
('2623', 'KOTA PALOPO', 26),
('2624', 'KOTA PAREPARE', 26),
('2701', 'KAB. BOMBANA', 27),
('2702', 'KAB. BUTON', 27),
('2703', 'KAB. BUTON SELATAN', 27),
('2704', 'KAB. BUTON TENGAH', 27),
('2705', 'KAB. BUTON UTARA', 27),
('2706', 'KAB. KOLAKA', 27),
('2707', 'KAB. KOLAKA TIMUR', 27),
('2708', 'KAB. KOLAKA UTARA', 27),
('2709', 'KAB. KONAWE', 27),
('2710', 'KAB. KONAWE KEPULAUAN', 27),
('2711', 'KAB. KONAWE SELATAN', 27),
('2712', 'KAB. KONAWE UTARA', 27),
('2713', 'KAB. MUNA', 27),
('2714', 'KAB. MUNA BARAT', 27),
('2715', 'KAB. WAKATOBI', 27),
('2716', 'KOTA BAU-BAU', 27),
('2717', 'KOTA KENDARI', 27),
('2801', 'KAB. BANGGAI', 28),
('2802', 'KAB. BANGGAI KEPULAUAN', 28),
('2803', 'KAB. BANGGAI LAUT', 28),
('2804', 'KAB. BUOL', 28),
('2805', 'KAB. DONGGALA', 28),
('2806', 'KAB. MOROWALI', 28),
('2807', 'KAB. MOROWALI UTARA', 28),
('2808', 'KAB. PARIGI MOUTONG', 28),
('2809', 'KAB. POSO', 28),
('2810', 'KAB. SIGI', 28),
('2811', 'KAB. TOJO UNA-UNA', 28),
('2812', 'KAB. TOLI-TOLI', 28),
('2813', 'KOTA PALU', 28),
('2901', 'KAB. BOLAANG MONGONDOW', 29),
('2902', 'KAB. BOLAANG MONGONDOW SELATAN', 29),
('2903', 'KAB. BOLAANG MONGONDOW TIMUR', 29),
('2904', 'KAB. BOLAANG MONGONDOW UTARA', 29),
('2905', 'KAB. KEPULAUAN SANGIHE', 29),
('2906', 'KAB. KEPULAUAN SIAU TAGULANDANG BIARO', 29),
('2907', 'KAB. KEPULAUAN TALAUD', 29),
('2908', 'KAB. MINAHASA', 29),
('2909', 'KAB. MINAHASA SELATAN', 29),
('2910', 'KAB. MINAHASA TENGGARA', 29),
('2911', 'KAB. MINAHASA UTARA', 29),
('2912', 'KOTA BITUNG', 29),
('2913', 'KOTA KOTAMOBAGU', 29),
('2914', 'KOTA MANADO', 29),
('2915', 'KOTA TOMOHON', 29),
('3001', 'KAB. MAJENE', 30),
('3002', 'KAB. MAMASA', 30),
('3003', 'KAB. MAMUJU', 30),
('3004', 'KAB. MAMUJU TENGAH', 30),
('3005', 'KAB. MAMUJU UTARA', 30),
('3006', 'KAB. POLEWALI MANDAR', 30),
('3101', 'KAB. BURU', 31),
('3102', 'KAB. BURU SELATAN', 31),
('3103', 'KAB. KEPULAUAN ARU', 31),
('3104', 'KAB. MALUKU BARAT DAYA', 31),
('3105', 'KAB. MALUKU TENGAH', 31),
('3106', 'KAB. MALUKU TENGGARA', 31),
('3107', 'KAB. MALUKU TENGGARA BARAT', 31),
('3108', 'KAB. SERAM BAGIAN BARAT', 31),
('3109', 'KAB. SERAM BAGIAN TIMUR', 31),
('3110', 'KOTA AMBON', 31),
('3111', 'KOTA TUAL', 31),
('3201', 'KAB. HALMAHERA BARAT', 32),
('3202', 'KAB. HALMAHERA TENGAH', 32),
('3203', 'KAB. HALMAHERA UTARA', 32),
('3204', 'KAB. HALMAHERA SELATAN', 32),
('3205', 'KAB. KEPULAUAN SULA', 32),
('3206', 'KAB. HALMAHERA TIMUR', 32),
('3207', 'KAB. PULAU MOROTAI', 32),
('3208', 'KAB. PULAU TALIABU', 32),
('3209', 'KOTA TERNATE', 32),
('3210', 'KOTA TIDORE KEPULAUAN', 32),
('3211', 'KOTA SOFIFI', 32),
('3212', 'KOTA SOFIFI', 32),
('3301', 'KAB. ASMAT', 33),
('3302', 'KAB. BIAK NUMFOR', 33),
('3303', 'KAB. BOVEN DIGOEL', 33),
('3304', 'KAB. DEIYAI', 33),
('3305', 'KAB. DOGIYAI', 33),
('3306', 'KAB. INTAN JAYA', 33),
('3307', 'KAB. JAYAPURA', 33),
('3308', 'KAB. JAYAWIJAYA', 33),
('3309', 'KAB. KEEROM', 33),
('3310', 'KAB. KEPULAUAN YAPEN', 33),
('3311', 'KAB. LANNY JAYA', 33),
('3312', 'KAB. MAMBERAMO RAYA', 33),
('3313', 'KAB. MAMBERAMO TENGAH', 33),
('3314', 'KAB. MAPPI', 33),
('3315', 'KAB. MERAUKE', 33),
('3316', 'KAB. MIMIKA', 33),
('3317', 'KAB. NABIRE', 33),
('3318', 'KAB. NDUGA', 33),
('3319', 'KAB. PANIAI', 33),
('3320', 'KAB. PEGUNUNGAN BINTANG', 33),
('3321', 'KAB. PUNCAK', 33),
('3322', 'KAB. PUNCAK JAYA', 33),
('3323', 'KAB. SARMI', 33),
('3324', 'KAB. SUPIORI', 33),
('3325', 'KAB. TOLIKARA', 33),
('3326', 'KAB. WAROPEN', 33),
('3327', 'KAB. YAHUKIMO', 33),
('3328', 'KAB. YALIMO', 33),
('3329', 'KOTA JAYAPURA', 33),
('3330', 'KAB. YAPEN WAROPEN', 33),
('3401', 'KAB. FAKFAK', 34),
('3402', 'KAB. KAIMANA', 34),
('3403', 'KAB. MANOKWARI', 34),
('3404', 'KAB. MANOKWARI SELATAN', 34),
('3405', 'KAB. MAYBRAT', 34),
('3406', 'KAB. PEGUNUNGAN ARFAK', 34),
('3407', 'KAB. RAJA AMPAT', 34),
('3408', 'KAB. SORONG', 34),
('3409', 'KAB. SORONG SELATAN', 34),
('3410', 'KAB. TAMBRAUW', 34),
('3411', 'KAB. TELUK BINTUNI', 34),
('3412', 'KAB. TELUK WONDAMA', 34),
('3413', 'KOTA SORONG', 34);

-- --------------------------------------------------------

--
-- Table structure for table `layouts`
--

CREATE TABLE `layouts` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  `nama_layout` varchar(255) DEFAULT NULL,
  `preview` varchar(255) DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `layouts`
--

INSERT INTO `layouts` (`id`, `value`, `nama_layout`, `preview`, `status`, `created_at`, `updated_at`) VALUES
(1, 'layout_1', 'Layout 1 (Kantor)', 'assets/images/layout_1.png', 0, NULL, NULL),
(2, 'layout_2', 'Layout 2 (Kantor)', 'assets/images/layout_2.png', 0, NULL, NULL),
(3, 'layout_3', 'Layout 3 (Kantor)', 'assets/images/layout_3.png', 0, NULL, NULL),
(4, 'layout_4', 'Layout 4 (Kantor)', 'assets/images/layout_4.png', 0, NULL, NULL),
(5, 'layout_5', 'Layout 5 (Kantor)', 'assets/images/layout_5.png', 0, NULL, NULL),
(6, 'layout_6', 'Layout 6 (Kantor)', 'assets/images/layout_6.png', 0, NULL, NULL),
(7, 'layout_7', 'Layout 7 (Kantor)', 'assets/images/layout_7.png', 0, NULL, NULL),
(8, 'layout_8', 'Layout 8 (Kantor)', 'assets/images/layout_8.png', 0, NULL, NULL),
(9, 'layout_9', 'Layout 9 (Kantor)', 'assets/images/layout_9.png', 0, NULL, NULL),
(10, 'layout_10', 'Layout 10 (Kantor)', 'assets/images/layout_10.png', 0, NULL, NULL),
(11, 'layout_11', 'Layout 11 (Masjid)', 'assets/images/layout_11.png', 0, NULL, NULL),
(12, 'layout_12', 'Layout 12 (Masjid)', 'assets/images/layout_12.png', 0, NULL, NULL),
(13, 'layout_13', 'Layout 13 (Masjid)', 'assets/images/layout_13.png', 0, NULL, NULL),
(14, 'layout_14', 'Layout 14 (Kampus)', 'assets/images/layout_14.png', 0, NULL, NULL),
(15, 'layout_15', 'Layout 15 (Kampus)', 'assets/images/layout_15.png', 0, NULL, NULL),
(16, 'layout_16', 'Layout 16 (Kampus)', 'assets/images/layout_16.png', 0, NULL, NULL),
(17, 'layout_17', 'Layout 17 (Kampus)', 'assets/images/layout_17.png', 0, NULL, NULL),
(18, 'layout_18', 'Layout 18 (Kampus)', 'assets/images/layout_18.png', 0, NULL, NULL),
(19, 'layout_19', 'Layout 19 (Kampus)', 'assets/images/layout_19.png', 0, NULL, NULL),
(20, 'layout_20', 'Layout 20 (Kampus)', 'assets/images/layout_20.png', 0, NULL, NULL),
(21, 'layout_21', 'Layout 21 (Sekolah)', 'assets/images/layout_21.png', 0, NULL, NULL),
(22, 'layout_22', 'Layout 22 (Sekolah)', 'assets/images/layout_22.png', 0, NULL, NULL),
(23, 'layout_23', 'Layout 23 (Sekolah)', 'assets/images/layout_23.png', 0, NULL, NULL),
(24, 'layout_24', 'Layout 24(Sekolah)', 'assets/images/layout_24.png', 0, NULL, NULL),
(25, 'layout_25', 'Layout 25 (Sekolah)', 'assets/images/layout_25.png', 0, NULL, NULL),
(26, 'layout_26', 'Layout 26 (Klinik)', 'assets/images/layout_26.png', 0, NULL, NULL),
(27, 'layout_27', 'Layout 27 (Klinik)', 'assets/images/layout_27.png', 0, NULL, NULL),
(28, 'layout_28', 'Layout 28 (Klinik)', 'assets/images/layout_28.png', 0, NULL, NULL),
(29, 'layout_29', 'Layout 29 (Custom)', 'assets/images/layout_29.png', 0, NULL, NULL),
(30, 'layout_30', 'Layout 30 Vertical 1', 'assets/images/layout_30.png', 0, NULL, NULL),
(31, 'layout_31', 'Layout 31 Vertical 2', 'assets/images/layout_31.png', 0, NULL, NULL),
(32, 'layout_32', 'Layout 32 Vertical Custom', 'assets/images/layout_32.png', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `tgl_news` date NOT NULL,
  `text_news` varchar(255) NOT NULL,
  `jenis_news` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `tgl_news`, `text_news`, `jenis_news`, `created_at`, `updated_at`) VALUES
(1, '2022-08-04', 'Selamat Datang Di Puskesmas Balaraja', 1, '2022-08-04 19:13:20', '2023-08-15 11:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `provinsis`
--

CREATE TABLE `provinsis` (
  `id` int(11) NOT NULL,
  `provinsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `provinsis`
--

INSERT INTO `provinsis` (`id`, `provinsi`) VALUES
(1, 'ACEH'),
(2, 'SUMATERA UTARA'),
(3, 'SUMATERA BARAT'),
(4, 'RIAU'),
(5, 'KEPULAUAN RIAU'),
(6, 'JAMBI'),
(7, 'BENGKULU'),
(8, 'SUMATERA SELATAN'),
(9, 'KEPULAUAN BANGKA BELITUNG'),
(10, 'LAMPUNG'),
(11, 'BANTEN'),
(12, 'JAWA BARAT'),
(13, 'JAKARTA'),
(14, 'JAWA TENGAH'),
(15, 'DAERAH ISTIMEWA YOGYAKARTA'),
(16, 'JAWA TIMUR'),
(17, 'BALI'),
(18, 'NUSA TENGGARA BARAT'),
(19, 'NUSA TENGGARA TIMUR'),
(20, 'KALIMANTAN BARAT'),
(21, 'KALIMANTAN SELATAN'),
(22, 'KALIMANTAN TENGAH'),
(23, 'KALIMANTAN TIMUR'),
(24, 'KALIMANTAN UTARA'),
(25, 'GORONTALO'),
(26, 'SULAWESI SELATAN'),
(27, 'SULAWESI TENGGARA'),
(28, 'SULAWESI TENGAH'),
(29, 'SULAWESI UTARA'),
(30, 'SULAWESI BARAT'),
(31, 'MALUKU'),
(32, 'MALUKU UTARA'),
(33, 'PAPUA'),
(34, 'PAPUA BARAT');

-- --------------------------------------------------------

--
-- Table structure for table `ruangs`
--

CREATE TABLE `ruangs` (
  `id` int(11) NOT NULL,
  `nama_ruang` varchar(150) NOT NULL,
  `jenis_ruang` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `group_setting` varchar(100) NOT NULL,
  `variable_setting` varchar(255) NOT NULL,
  `value_setting` text NOT NULL,
  `deskripsi_setting` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group_setting`, `variable_setting`, `value_setting`, `deskripsi_setting`, `updated_at`) VALUES
(1, 'app', 'ver', 'AIO', 'Versi Aplikasi', '2023-07-06 20:29:58'),
(2, 'app', 'developer', 'ALFIAN AJI WAHYUDI', 'Pengembang Aplikasi', '2023-07-06 20:30:24'),
(3, 'app', 'nama_aplikasi', 'Display Informasi', 'Nama Aplikasi', NULL),
(4, 'general', 'nama_instansi', 'PUSKESMAS BALARAJA', 'Nama Instansi', '2023-07-06 20:29:58'),
(5, 'general', 'alamat', 'Jl. Raya Serang KM. 24 Balaraja Tangerang Banten 15610', 'Alamat', '2023-08-15 16:53:02'),
(6, 'general', 'phone_instansi', '(021)-59576146\n0811-1251-386', 'No Telp', '2023-08-15 16:52:29'),
(7, 'general', 'mail', 'admin@puskesmasbalaraja.com', 'Email', '2024-01-11 17:56:50'),
(8, 'app', 'layout', 'layout_10', 'Display Layout', '2023-08-19 11:37:09'),
(9, 'app', 'news_refresh', '240', 'Waktu dalam detik merefresh News Ticker (default 240)', '2023-08-15 16:53:29'),
(10, 'app', 'background', 'images/1692077125_18f124eaecca762ab520.webp', 'Background Image untuk Display Informasi', '2023-08-15 12:25:25'),
(11, 'general', 'logo', 'images/1692071087_7fbb6b089940b018a445.png', 'Logo', '2023-08-15 10:44:47'),
(12, 'app', 'slide_refresh', '300', 'Waktu dalam detik merefresh Photos Gallery (default 300)', NULL),
(13, 'app', 'agenda_refresh', '300', 'Waktu dalam detik merefresh Agenda Slide (default 300)', NULL),
(14, 'app', 'name_agenda_instansi', 'Agenda', 'Nama agenda instansi yang ditampilkan', NULL),
(15, 'app', 'jadwal_sholat', 'api', 'Mode Jadwal Sholat (Realtime API atau Manual)', '2024-01-11 18:29:10'),
(16, 'app', 'kota', '1104', 'Nama Kota Anda (Digunakan untuk Jadwal Sholat dan Cuaca)', '2023-07-06 20:29:58'),
(17, 'app', 'provinsi', '11', 'Nama Provinsi Anda', '2023-08-15 10:25:24'),
(18, 'app', 'background_masjid', 'images/31655060b1e67a6ec73826a4cf604b79.jpg', 'Background Image untuk Display Informasi Masjid', NULL),
(19, 'app', 'video_youtube', 'no', 'Gunakan Video dari Youtube', '2023-08-19 11:23:02'),
(20, 'app', 'video_plugin', 'Plyr.io', 'Plugin Video Youtube yang digunakan', '2022-03-03 14:42:32'),
(21, 'app', 'limit_agenda', '4', 'Jumlah Agenda yang tampil Display', '2022-06-11 17:18:50'),
(22, 'app', 'limit_info', '4', 'Jumlah Informasi yang tampil Display', '2022-06-11 17:18:46'),
(23, 'app', 'limit_dosen', '100', 'Jumlah Dosen yang tampil Display', '2021-12-24 08:53:47'),
(24, 'app', 'fontsize_nama', 'h1', 'Ukuran Font Nama Instansi pada Layout', '2022-08-07 17:21:37'),
(25, 'app', 'fontweight_nama', 'fw-bold', 'Besar Font Nama Instansi pada Layout', '2023-06-28 08:48:55'),
(26, 'app', 'fontsize_alamat', 'h6', 'Ukuran Font Alamat pada Layout', '2022-08-06 10:34:56'),
(27, 'app', 'bgcolor_jam', '#0d6efd', 'Bg Color Jam pada Layout', '2022-08-06 17:49:58'),
(28, 'app', 'bgcolor_newsticker', '#dc3545', 'Bg Color New Ticker pada Layout', '2022-08-06 10:59:09'),
(29, 'app', 'custom_col_maxheight', '800', 'Tinggi Custom Column pada Layout', '2023-08-21 10:28:55'),
(30, 'app', 'carousel_autoplay_timeout', '4000', 'Vue Carousel Autoplay Timeout pada Galeri gambar (default 4000 dalam ms)', NULL),
(31, 'app', 'marquee_speed', '30', 'Kecepatan Marquee pada News Ticker (default 30 dalam second)', NULL),
(32, 'app', 'cuaca_refresh', '900', 'Cuaca auto refresh (default 900)', NULL),
(33, 'app', 'use_pusher', 'yes', 'Aktifkan Pusher / Pastikan data Pusher ID, Key, Secret di .env sudah diisi (jika tidak aktif akan menggunakan setInterval', '2024-11-16 23:42:33'),
(34, 'app', 'video_muted', 'no', 'Video MP4 dengan suara atau muted', '2023-08-15 10:58:26'),
(35, 'app', 'meta_refresh_enable', 'yes', 'Aktifkan meta refresh', NULL),
(36, 'app', 'meta_refresh_time', '3600', 'Waktu meta refresh (default 3600 dalam second)', NULL),
(37, 'app', 'fontsize_tanggal', '22', 'Ukuran Font Tanggal pada Layout (default 22)', NULL),
(38, 'app', 'fontsize_jam', '50', 'Ukuran Font Jam pada Layout (default 50)', NULL),
(39, 'app', 'fontsize_marquee', '40', 'Ukuran Font Marquee News Ticker pada Layout (default 40)', NULL),
(40, 'app', 'carousel_image_height', '100', 'Tinggi Gambar Galeri Carousel (default 220)', '2023-08-21 10:32:02'),
(41, 'app', 'framework_display', 'jquery', 'Gunakan JavaScript framework pada Layout Display: JQuery atau Vue.js (default pada Dashboard Vue.js)', '2023-08-21 10:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `tgl_daftar` datetime DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `foto`, `user_type`, `is_active`, `is_logged_in`, `tgl_daftar`, `last_logged_in`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$INo6IRmOXz4YqFhdxnzRjuqgKGaOuOlhBpxClF5V8xd1KPnmhq.9G', 'Administrator', 'alfianajiwahyudi@gmail.com', 'default.jpeg', 1, 1, 0, '2019-10-05 05:59:58', '2024-11-16 23:41:55', '103.18.34.198', NULL, '2024-11-16 23:41:55'),
(3, 'promkes', '$2y$10$sC9M2WGVb/4bzySnYtj7LeynsU2uNamXU2eDhYyVaz/hgGMO3ifRi', 'promkes', 'promkes@puskesmasbalaraja.com', 'default.jpeg', 2, 1, 0, NULL, '2023-08-21 09:19:17', '125.166.202.184', '2023-08-15 11:01:44', '2024-08-19 09:16:58'),
(4, 'Lina_Fitrianti', '$2y$10$AjhKPOTll8BjpG72LJx9xOh3C1XmVYSrCFG6E7prfhGD4NNiG3r6q', 'Lina Fitrianti', 'fitrianti.lina04@gmail.com', 'default.jpeg', 2, 1, 0, NULL, '2024-08-19 09:51:31', '180.254.67.98', '2023-08-18 12:06:46', '2024-08-19 09:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `source` int(11) NOT NULL DEFAULT 0,
  `video_url` varchar(255) DEFAULT NULL,
  `kode_youtube` varchar(255) DEFAULT NULL,
  `upload_time` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `judul`, `source`, `video_url`, `kode_youtube`, `upload_time`, `status`, `created_at`, `updated_at`) VALUES
(79, 'ILP Animasi', 1, 'videos/videoplayback.mp4', '', '2024-08-19 10:00:44', 1, '2024-08-19 10:00:44', '2024-08-19 10:00:44'),
(80, 'ILP ', 1, 'videos/WhatsApp_Video_2024-08-19_at_09.57.40.mp4', '', '2024-08-19 10:01:59', 1, '2024-08-19 10:01:59', '2024-08-19 10:01:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agamaquotes`
--
ALTER TABLE `agamaquotes`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `customs`
--
ALTER TABLE `customs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `dokters`
--
ALTER TABLE `dokters`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `galeris`
--
ALTER TABLE `galeris`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `haribelajars`
--
ALTER TABLE `haribelajars`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_jampelajaran` (`id_jampelajaran`) USING BTREE;

--
-- Indexes for table `harilayanans`
--
ALTER TABLE `harilayanans`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_jampelayanan` (`id_jampelayanan`) USING BTREE;

--
-- Indexes for table `jadwaldokters`
--
ALTER TABLE `jadwaldokters`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_dokter` (`id_dokter`) USING BTREE,
  ADD KEY `id_ruang` (`id_ruang`) USING BTREE;

--
-- Indexes for table `jadwalpelajarans`
--
ALTER TABLE `jadwalpelajarans`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_guru` (`id_guru`) USING BTREE,
  ADD KEY `id_kelas` (`id_kelas`) USING BTREE;

--
-- Indexes for table `jadwalsholats`
--
ALTER TABLE `jadwalsholats`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `jampelajarans`
--
ALTER TABLE `jampelajarans`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `jampelayanans`
--
ALTER TABLE `jampelayanans`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `jenislayanans`
--
ALTER TABLE `jenislayanans`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `jumatans`
--
ALTER TABLE `jumatans`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `kegiatanmasjids`
--
ALTER TABLE `kegiatanmasjids`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `keuanganmasjids`
--
ALTER TABLE `keuanganmasjids`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `kotas`
--
ALTER TABLE `kotas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_provinsi` (`id_provinsi`) USING BTREE;

--
-- Indexes for table `layouts`
--
ALTER TABLE `layouts`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `provinsis`
--
ALTER TABLE `provinsis`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `ruangs`
--
ALTER TABLE `ruangs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agamaquotes`
--
ALTER TABLE `agamaquotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customs`
--
ALTER TABLE `customs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dokters`
--
ALTER TABLE `dokters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dosens`
--
ALTER TABLE `dosens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galeris`
--
ALTER TABLE `galeris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `haribelajars`
--
ALTER TABLE `haribelajars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harilayanans`
--
ALTER TABLE `harilayanans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwaldokters`
--
ALTER TABLE `jadwaldokters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwalpelajarans`
--
ALTER TABLE `jadwalpelajarans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwalsholats`
--
ALTER TABLE `jadwalsholats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `jampelajarans`
--
ALTER TABLE `jampelajarans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jampelayanans`
--
ALTER TABLE `jampelayanans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenislayanans`
--
ALTER TABLE `jenislayanans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jumatans`
--
ALTER TABLE `jumatans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatanmasjids`
--
ALTER TABLE `kegiatanmasjids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keuanganmasjids`
--
ALTER TABLE `keuanganmasjids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layouts`
--
ALTER TABLE `layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `provinsis`
--
ALTER TABLE `provinsis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ruangs`
--
ALTER TABLE `ruangs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `haribelajars`
--
ALTER TABLE `haribelajars`
  ADD CONSTRAINT `haribelajars_ibfk_1` FOREIGN KEY (`id_jampelajaran`) REFERENCES `jampelajarans` (`id`);

--
-- Constraints for table `harilayanans`
--
ALTER TABLE `harilayanans`
  ADD CONSTRAINT `harilayanans_ibfk_1` FOREIGN KEY (`id_jampelayanan`) REFERENCES `jampelayanans` (`id`);

--
-- Constraints for table `jadwaldokters`
--
ALTER TABLE `jadwaldokters`
  ADD CONSTRAINT `jadwaldokters_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokters` (`id`),
  ADD CONSTRAINT `jadwaldokters_ibfk_2` FOREIGN KEY (`id_ruang`) REFERENCES `ruangs` (`id`);

--
-- Constraints for table `jadwalpelajarans`
--
ALTER TABLE `jadwalpelajarans`
  ADD CONSTRAINT `jadwalpelajarans_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `jadwalpelajarans_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `gurus` (`id`);

--
-- Constraints for table `kotas`
--
ALTER TABLE `kotas`
  ADD CONSTRAINT `kotas_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
