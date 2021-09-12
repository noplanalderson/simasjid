-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2021 at 06:38 PM
-- Server version: 10.3.30-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_app_simasjid`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumentasi`
--

CREATE TABLE `tb_dokumentasi` (
  `dok_id` int(11) NOT NULL,
  `id_kegiatan` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `file_dokumentasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_inventaris`
--

CREATE TABLE `tb_inventaris` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` char(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tgl_pendataan` date DEFAULT current_timestamp(),
  `nama_barang` varchar(255) NOT NULL,
  `kuantitas_masuk` float DEFAULT NULL,
  `kuantitas_keluar` float DEFAULT NULL,
  `satuan` char(80) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `dokumentasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tb_inventaris`
--
CREATE TRIGGER `hapus_barang` AFTER DELETE ON `tb_inventaris` FOR EACH ROW INSERT INTO tb_log_inventaris(aksi, timestamp, kode_barang, user_id, nama_barang, kuantitas_masuk, kuantitas_keluar, satuan, keterangan)
VALUES('Hapus', NOW(), OLD .kode_barang, OLD .user_id,  OLD .nama_barang, OLD .kuantitas_masuk, OLD .kuantitas_keluar, OLD .satuan, OLD .keterangan);

CREATE TRIGGER `tambah_barang` AFTER INSERT ON `tb_inventaris` FOR EACH ROW INSERT INTO tb_log_inventaris(aksi, timestamp, kode_barang, user_id, nama_barang, kuantitas_masuk, kuantitas_keluar, satuan, keterangan)
VALUES('Tambah', NOW(), NEW .kode_barang, NEW .user_id,  NEW .nama_barang, NEW .kuantitas_masuk, NEW .kuantitas_keluar, NEW .satuan, NEW .keterangan);

CREATE TRIGGER `update_barang` AFTER UPDATE ON `tb_inventaris` FOR EACH ROW INSERT INTO tb_log_inventaris(aksi, timestamp, kode_barang, user_id, nama_barang, kuantitas_masuk, kuantitas_keluar, satuan, keterangan)
VALUES('Update', NOW(), NEW .kode_barang, NEW .user_id,  NEW .nama_barang, NEW .kuantitas_masuk, NEW .kuantitas_keluar, NEW .satuan, NEW .keterangan);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `nama_jabatan` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`id_jabatan`, `type_id`, `nama_jabatan`) VALUES
(1, 1, 'Administrator'),
(6, 6, 'Ketua DKM'),
(7, 6, 'Bendahara'),
(9, 9, 'Auditor');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_kegiatan`
--

CREATE TABLE `tb_jenis_kegiatan` (
  `id_jenis` int(11) NOT NULL,
  `jenis_kegiatan` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jenis_kegiatan`
--

INSERT INTO `tb_jenis_kegiatan` (`id_jenis`, `jenis_kegiatan`) VALUES
(1, 'Ta\'lim Mingguan'),
(2, 'Khutbah Jum\'at'),
(3, 'Kajian Subuh'),
(5, 'Kegiatan Rohis');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kas_masjid`
--

CREATE TABLE `tb_kas_masjid` (
  `id_transaksi` int(11) NOT NULL,
  `kode_transaksi` char(15) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `pemasukan` float(12,2) UNSIGNED DEFAULT NULL,
  `pengeluaran` float(12,2) UNSIGNED DEFAULT NULL,
  `dokumentasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tb_kas_masjid`
--
CREATE TRIGGER `hapus_kas` AFTER DELETE ON `tb_kas_masjid` FOR EACH ROW INSERT INTO tb_log_kas(aksi, timestamp, kode_transaksi, id_kategori, user_id, date, keterangan, pemasukan, pengeluaran)
VALUES('Hapus', NOW(), OLD .kode_transaksi, OLD .id_kategori, OLD .user_id, OLD .date, OLD .keterangan, OLD .pemasukan, OLD .pengeluaran);

CREATE TRIGGER `tambah_kas` AFTER INSERT ON `tb_kas_masjid` FOR EACH ROW INSERT INTO tb_log_kas(aksi, timestamp, kode_transaksi, id_kategori, user_id, date, keterangan, pemasukan, pengeluaran)
VALUES('Tambah', NOW(), NEW .kode_transaksi, NEW .id_kategori, NEW .user_id, NEW .date, NEW .keterangan, NEW .pemasukan, NEW .pengeluaran);

CREATE TRIGGER `update_kas` AFTER UPDATE ON `tb_kas_masjid` FOR EACH ROW INSERT INTO tb_log_kas(aksi, timestamp, kode_transaksi, id_kategori, user_id, date, keterangan, pemasukan, pengeluaran)
VALUES('Update', NOW(), NEW .kode_transaksi, NEW .id_kategori, NEW .user_id, NEW .date, NEW .keterangan, NEW .pemasukan, NEW .pengeluaran);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori_kas`
--

CREATE TABLE `tb_kategori_kas` (
  `id_kategori` int(11) NOT NULL,
  `kategori` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kategori_kas`
--

INSERT INTO `tb_kategori_kas` (`id_kategori`, `kategori`) VALUES
(1, 'Dana Umum'),
(4, 'Santunan Yatim'),
(8, 'Kebersihan'),
(9, 'Infaq Jum\'at');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kegiatan`
--

CREATE TABLE `tb_kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time DEFAULT NULL,
  `judul_kegiatan` varchar(255) NOT NULL,
  `narasumber` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_inventaris`
--

CREATE TABLE `tb_log_inventaris` (
  `log_id` int(11) NOT NULL,
  `aksi` enum('Tambah','Update','Hapus') NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kode_barang` char(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kuantitas_masuk` float DEFAULT NULL,
  `kuantitas_keluar` int(11) NOT NULL,
  `satuan` char(80) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_kas`
--

CREATE TABLE `tb_log_kas` (
  `log_id` int(11) NOT NULL,
  `aksi` enum('Tambah','Update','Hapus') NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kode_transaksi` char(15) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `pemasukan` float(12,2) DEFAULT NULL,
  `pengeluaran` float(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_zakat_fitrah`
--

CREATE TABLE `tb_log_zakat_fitrah` (
  `log_id` int(11) NOT NULL,
  `aksi` enum('Tambah','Update','Hapus') NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `kode_transaksi` char(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('masuk','keluar') NOT NULL,
  `date` date NOT NULL,
  `atas_nama` char(100) NOT NULL,
  `bentuk_zakat` enum('beras','uang tunai','gandum','emas','perak') NOT NULL,
  `satuan_zakat` enum('RUPIAH','KILOGRAM','GRAM','LITER') NOT NULL,
  `jumlah_jiwa` int(11) DEFAULT NULL,
  `jumlah_zakat` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_zakat_mal`
--

CREATE TABLE `tb_log_zakat_mal` (
  `log_id` int(11) NOT NULL,
  `aksi` enum('Tambah','Update','Hapus') NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kode_transaksi` char(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('masuk','keluar') NOT NULL,
  `date` date NOT NULL,
  `atas_nama` char(100) NOT NULL,
  `bentuk_zakat` char(100) NOT NULL,
  `satuan_zakat` enum('RUPIAH','KILOGRAM','EKOR','LITER','GRAM') NOT NULL,
  `jumlah_jiwa` int(11) DEFAULT NULL,
  `jumlah_zakat` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_memo`
--

CREATE TABLE `tb_memo` (
  `id` int(11) NOT NULL,
  `dari` int(11) DEFAULT NULL,
  `kepada` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT current_timestamp(),
  `prioritas` enum('biasa','darurat','mendesak','khusus') NOT NULL,
  `judul_memo` varchar(100) NOT NULL,
  `isi_memo` varchar(500) NOT NULL,
  `dibaca` tinyint(1) DEFAULT 0,
  `receiver_deletion` tinyint(1) DEFAULT 0,
  `sender_deletion` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `menu_id` int(11) NOT NULL,
  `menu_parent` int(11) DEFAULT NULL,
  `menu_label` char(100) NOT NULL,
  `menu_link` char(150) NOT NULL,
  `menu_icon` char(255) DEFAULT NULL,
  `menu_location` enum('mainmenu','submenu','content') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`menu_id`, `menu_parent`, `menu_label`, `menu_link`, `menu_icon`, `menu_location`) VALUES
(2, NULL, 'Dashboard', 'dashboard', 'mdi mdi-view-dashboard', 'mainmenu'),
(3, NULL, 'Manajemen Akses', 'manajemen-akses', 'fas fa-key', 'mainmenu'),
(4, 3, 'Get Role', 'get-role', NULL, 'content'),
(5, 3, 'Tambah Role', 'tambah-role', 'fas fa-plus-square', 'content'),
(6, 3, 'Edit Role', 'edit-role', 'fas fa-edit', 'content'),
(7, 3, 'Hapus Role', 'hapus-role', 'fas fa-trash-alt', 'content'),
(8, NULL, 'Manajemen User', 'manajemen-user', 'fas fa-users', 'mainmenu'),
(9, 8, 'Tambah User', 'tambah-user', 'fas fa-user-plus', 'content'),
(10, 8, 'Edit User', 'edit-user', 'fas fa-user-edit', 'content'),
(11, 8, 'Hapus User', 'hapus-user', 'fas fa-trash-alt', 'content'),
(18, NULL, 'Pengaturan Masjid', 'pengaturan-masjid', 'fas fa-cogs', 'mainmenu'),
(19, 8, 'Get User', 'get-user', NULL, 'content'),
(20, NULL, 'Utilitas', 'utilitas', 'fas fa-tools', 'mainmenu'),
(21, 20, 'Tambah Utilitas', 'tambah-utilitas', 'fas fa-plus-square', 'content'),
(22, 20, 'Edit Utilitas', 'edit-utilitas', 'fas fa-edit', 'content'),
(23, 20, 'Hapus Utilitas', 'hapus-utilitas', 'fas fa-trash-alt', 'content'),
(24, 20, 'Get Utilitas', 'get-utilitas', NULL, 'content'),
(25, NULL, 'Pengaturan SMTP', 'pengaturan-smtp', 'fas fa-paper-plane', 'mainmenu'),
(30, NULL, 'Keuangan', '#keuangan', 'fas fa-coins', 'mainmenu'),
(31, 30, 'Input Pemasukan', 'input-pemasukan', 'fas fa-plus-square', 'content'),
(32, 30, 'Input Pengeluaran', 'input-pengeluaran', 'fas fa-plus-square', 'content'),
(33, 30, 'Hapus Kas', 'hapus-kas', 'fas fa-trash-alt', 'content'),
(34, 30, 'Get Kas', 'get-kas', NULL, 'content'),
(35, 30, 'Log Kas', 'log-kas', 'fas fa-history', 'content'),
(36, NULL, 'Zakat Fitrah', '#zakat-fitrah', 'fas fa-hand-holding-usd', 'mainmenu'),
(37, 36, 'Data Muzakki', 'data-muzakki', NULL, 'submenu'),
(38, 36, 'Data Mustahik', 'data-mustahik', NULL, 'submenu'),
(39, 36, 'Tambah Zakat Fitrah', 'tambah-zakat-fitrah', 'fas fa-plus-square', 'content'),
(40, 36, 'Edit Zakat Fitrah', 'edit-zakat-fitrah', 'fas fa-edit', 'content'),
(41, 36, 'Hapus Zakat  Fitrah', 'hapus-zakat-fitrah', 'fas fa-trash-alt', 'content'),
(42, 36, 'Log Zakat Fitrah', 'log-zakat-fitrah', 'fas fa-history', 'content'),
(43, 36, 'Kwitansi Zakat Fitrah', 'kwitansi-zakat-fitrah', 'fas fa-receipt', 'content'),
(46, 36, 'Get Zakat Fitrah', 'get-zakat-fitrah', NULL, 'content'),
(47, NULL, 'Zakat Mal', '#zakat-mal', 'fas fa-wallet', 'mainmenu'),
(48, 47, 'Zakat Mal Masuk', 'zakat-mal-masuk', NULL, 'submenu'),
(49, 47, 'Zakat Mal Keluar', 'zakat-mal-keluar', NULL, 'submenu'),
(50, 47, 'Tambah Zakat Mal', 'tambah-zakat-mal', 'fas fa-plus-square', 'content'),
(51, 47, 'Edit Zakat Mal', 'edit-zakat-mal', 'fas fa-edit', 'content'),
(52, 47, 'Hapus Zakat Mal', 'hapus-zakat-mal', 'fas fa-trash-alt', 'content'),
(53, 47, 'Log Zakat Mal', 'log-zakat-mal', 'fas fa-history', 'content'),
(56, 47, 'Get Zakat Mal', 'get-zakat-mal', NULL, 'content'),
(57, 47, 'Kwitansi Zakat Mal', 'kwitansi-zakat-mal', 'fas fa-receipt', 'content'),
(58, NULL, 'Inventarisasi', '#inventarisasi', 'fas fa-toolbox', 'mainmenu'),
(59, 30, 'Kas Masuk', 'kas-masuk', NULL, 'submenu'),
(60, 30, 'Kas Keluar', 'kas-keluar', NULL, 'submenu'),
(61, 30, 'Saldo Kas', 'saldo-kas', NULL, 'submenu'),
(62, 30, 'Edit Data Kas', 'edit-kas', 'fas fa-edit', 'content'),
(63, NULL, 'Agenda Kegiatan', '#agenda-kegiatan', 'fas fa-calendar-alt', 'mainmenu'),
(64, 63, 'Tambah Agenda', 'tambah-agenda', 'fas fa-plus-square', 'content'),
(65, 63, 'Edit Agenda', 'edit-agenda', 'fas fa-edit', 'content'),
(66, 63, 'Hapus Agenda', 'hapus-agenda', 'fas fa-trash-alt', 'content'),
(67, 63, 'Get Agenda', 'get-agenda', NULL, 'content'),
(68, 58, 'Hapus Barang', 'hapus-barang', 'fas fa-trash-alt', 'content'),
(69, 58, 'Get Barang', 'get-barang', NULL, 'content'),
(70, 58, 'Log Barang', 'log-barang', 'fas fa-history', 'content'),
(71, 58, 'Barang Masuk', 'barang-masuk', NULL, 'submenu'),
(72, 58, 'Barang Keluar', 'barang-keluar', NULL, 'submenu'),
(73, 58, 'Stok Barang', 'stok-barang', NULL, 'submenu'),
(74, 58, 'Edit Barang', 'edit-barang', 'fas fa-edit', 'content'),
(75, 58, 'Input Barang Masuk', 'input-barang-masuk', 'fas fa-plus-square', 'content'),
(76, 58, 'Input Barang Keluar', 'input-barang-keluar', 'fas fa-plus-square', 'content'),
(77, NULL, 'Kalkulator Zakat', '#kalkulator-zakat', 'fas fa-calculator', 'mainmenu'),
(78, 77, 'Kal. Zakat Penghasilan', 'kal-zakat-penghasilan', NULL, 'submenu'),
(79, 77, 'Kal. Zakat Mal', 'kal-zakat-mal', NULL, 'submenu'),
(80, 63, 'Tabel Kegiatan', 'agenda-kegiatan', NULL, 'submenu'),
(81, 63, 'Kalender', 'kalender', NULL, 'submenu'),
(82, 36, 'Rekap Zakat Fitrah', 'rekapitulasi-zakat-fitrah', NULL, 'submenu'),
(83, 47, 'Rekap Zakat Mal', 'rekap-zakat-mal', NULL, 'submenu'),
(84, NULL, 'Database Mustahik', 'database-mustahik', 'fas fa-database', 'mainmenu'),
(85, 84, 'Tambah Mustahik', 'tambah-data-mustahik', 'fas fa-plus-square', 'content'),
(86, 84, 'Get Data Mustahik', 'get-data-mustahik', NULL, 'content'),
(87, 84, 'Edit Mustahik', 'edit-data-mustahik', 'fas fa-edit', 'content'),
(88, 84, 'Hapus Data Mustahik', 'hapus-data-mustahik', 'fas fa-trash-alt', 'content'),
(89, NULL, 'Audit Log', '#audit', 'fas fa-history', 'mainmenu'),
(90, 89, 'Audit Log Kas', 'audit-kas', NULL, 'submenu'),
(91, 89, 'Audit Log Zakat Fitrah', 'audit-zakat-fitrah', NULL, 'submenu'),
(92, 89, 'Audit Log Zakat Mal', 'audit-zakat-mal', NULL, 'submenu'),
(93, 89, 'Audit Log Inventaris', 'audit-inventaris', NULL, 'submenu'),
(94, NULL, 'Dokumentasi', 'dokumentasi', 'fas fa-images', 'mainmenu'),
(95, 92, 'Unggah Foto', 'unggah-foto', 'fas fa-camera', 'content'),
(96, 92, 'Edit Foto', 'edit-foto', '', 'content'),
(97, 92, 'Get Foto', 'get-foto', NULL, 'content'),
(98, 92, 'Hapus Foto', 'hapus-foto', 'fas fa-trash-alt', 'content');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mustahik`
--

CREATE TABLE `tb_mustahik` (
  `id_mustahik` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` char(150) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` char(16) DEFAULT NULL,
  `kategori` enum('fakir','miskin','riqab','gharim','ibnu sabil','mualaf','amil zakat','yatim','piatu','janda','fi sabilillah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengaturan_masjid`
--

CREATE TABLE `tb_pengaturan_masjid` (
  `id_masjid` tinyint(1) NOT NULL,
  `logo_masjid` varchar(255) NOT NULL,
  `icon_masjid` varchar(255) NOT NULL,
  `nama_masjid` char(100) NOT NULL,
  `alamat_masjid` varchar(255) NOT NULL,
  `telepon_masjid` char(16) DEFAULT NULL,
  `email_masjid` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `role_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`role_id`, `type_id`, `menu_id`) VALUES
(74, 1, 6),
(75, 1, 10),
(76, 1, 22),
(77, 1, 4),
(78, 1, 19),
(79, 1, 24),
(80, 1, 7),
(81, 1, 11),
(82, 1, 23),
(83, 1, 3),
(84, 1, 8),
(85, 1, 25),
(86, 1, 18),
(87, 1, 5),
(88, 1, 9),
(89, 1, 21),
(90, 1, 20),
(188, 6, 2),
(189, 6, 38),
(190, 6, 37),
(191, 6, 62),
(192, 6, 22),
(193, 6, 40),
(194, 6, 51),
(195, 6, 34),
(196, 6, 24),
(197, 6, 46),
(198, 6, 56),
(199, 6, 33),
(200, 6, 23),
(201, 6, 41),
(202, 6, 52),
(203, 6, 31),
(204, 6, 32),
(205, 6, 58),
(206, 6, 60),
(207, 6, 59),
(208, 6, 43),
(209, 6, 57),
(210, 6, 35),
(211, 6, 42),
(212, 6, 53),
(213, 6, 30),
(214, 6, 61),
(215, 6, 21),
(216, 6, 39),
(217, 6, 50),
(218, 6, 20),
(219, 6, 36),
(220, 6, 47),
(221, 6, 49),
(222, 6, 48),
(223, 6, 63),
(224, 6, 65),
(225, 6, 64),
(226, 6, 66),
(227, 6, 67),
(228, 6, 74),
(229, 6, 69),
(230, 6, 68),
(231, 6, 70),
(232, 6, 71),
(233, 6, 72),
(234, 6, 75),
(235, 6, 76),
(236, 6, 73),
(237, 6, 77),
(238, 6, 79),
(239, 6, 78),
(240, 6, 80),
(241, 6, 81),
(242, 6, 82),
(243, 6, 83),
(244, 6, 84),
(245, 6, 85),
(246, 6, 86),
(247, 6, 87),
(248, 6, 88),
(249, 9, 89),
(250, 9, 93),
(251, 9, 90),
(252, 9, 91),
(253, 9, 92),
(254, 9, 2),
(256, 9, 58),
(257, 9, 30),
(258, 9, 82),
(259, 9, 83),
(260, 9, 61),
(261, 9, 73),
(262, 9, 36),
(263, 9, 47),
(264, 9, 35),
(265, 9, 42),
(266, 9, 53),
(267, 9, 70),
(268, 9, 59),
(269, 9, 60),
(270, 9, 35),
(271, 9, 48),
(272, 9, 49),
(273, 9, 38),
(274, 9, 37),
(275, 9, 71),
(276, 9, 72),
(277, 9, 84),
(278, 6, 94),
(279, 6, 95),
(280, 6, 96),
(281, 6, 97),
(282, 6, 98);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(2) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_token` varchar(255) DEFAULT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `last_ip` varbinary(16) DEFAULT NULL,
  `user_picture` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_type`
--

CREATE TABLE `tb_user_type` (
  `type_id` int(11) NOT NULL,
  `type_name` char(100) NOT NULL,
  `index_page` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_type`
--

INSERT INTO `tb_user_type` (`type_id`, `type_name`, `index_page`) VALUES
(1, 'administrator', 'manajemen-akses'),
(6, 'petugas', 'dashboard'),
(9, 'auditor', 'dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `tb_zakat_fitrah`
--

CREATE TABLE `tb_zakat_fitrah` (
  `id_transaksi` int(11) NOT NULL,
  `kode_transaksi` char(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('masuk','keluar') NOT NULL,
  `atas_nama` char(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(16) DEFAULT NULL,
  `bentuk_zakat` enum('beras','uang tunai','gandum','emas','perak') NOT NULL,
  `satuan_zakat` enum('RUPIAH','KILOGRAM','GRAM','LITER') NOT NULL,
  `jumlah_jiwa` int(11) DEFAULT NULL,
  `jumlah_zakat` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tb_zakat_fitrah`
--
CREATE TRIGGER `delete_zakat_fitrah` BEFORE DELETE ON `tb_zakat_fitrah` FOR EACH ROW INSERT INTO tb_log_zakat_fitrah(aksi, timestamp, kode_transaksi, user_id, `status`, date, atas_nama, bentuk_zakat, satuan_zakat, jumlah_jiwa, jumlah_zakat)
VALUES('Hapus', NOW(), OLD .kode_transaksi, OLD .user_id, OLD .status, OLD .date, OLD .atas_nama, OLD .bentuk_zakat, OLD .satuan_zakat, OLD .jumlah_jiwa, OLD .jumlah_zakat);

CREATE TRIGGER `tambah_zakat_fitrah` AFTER INSERT ON `tb_zakat_fitrah` FOR EACH ROW INSERT INTO tb_log_zakat_fitrah(aksi, timestamp, kode_transaksi, user_id, status, date, atas_nama, bentuk_zakat, satuan_zakat, jumlah_jiwa, jumlah_zakat)
VALUES('Tambah', NOW(), NEW .kode_transaksi, NEW .user_id, NEW .status, NEW .date, NEW .atas_nama, NEW .bentuk_zakat, NEW .satuan_zakat, NEW .jumlah_jiwa, NEW .jumlah_zakat);

CREATE TRIGGER `update_zakat_fitrah` AFTER UPDATE ON `tb_zakat_fitrah` FOR EACH ROW INSERT INTO tb_log_zakat_fitrah(aksi, timestamp, kode_transaksi, user_id, status, date, atas_nama, bentuk_zakat, satuan_zakat, jumlah_jiwa, jumlah_zakat)
VALUES('Update', NOW(), NEW .kode_transaksi, NEW .user_id, NEW .status, NEW .date, NEW .atas_nama, NEW .bentuk_zakat, NEW .satuan_zakat, NEW .jumlah_jiwa, NEW .jumlah_zakat);

-- --------------------------------------------------------

--
-- Table structure for table `tb_zakat_mal`
--

CREATE TABLE `tb_zakat_mal` (
  `id_transaksi` int(11) NOT NULL,
  `kode_transaksi` char(15) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('masuk','keluar') NOT NULL,
  `atas_nama` char(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(16) DEFAULT NULL,
  `bentuk_zakat` char(100) NOT NULL,
  `satuan_zakat` enum('RUPIAH','KILOGRAM','EKOR','LITER','GRAM') NOT NULL,
  `jumlah_jiwa` int(11) DEFAULT NULL,
  `jumlah_zakat` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tb_zakat_mal`
--
CREATE TRIGGER `hapus_zakat_mal` AFTER DELETE ON `tb_zakat_mal` FOR EACH ROW INSERT INTO tb_log_zakat_mal(aksi, timestamp, kode_transaksi, user_id, status, date, atas_nama, bentuk_zakat, satuan_zakat, jumlah_jiwa, jumlah_zakat)
VALUES('Hapus', NOW(), OLD .kode_transaksi, OLD .user_id, OLD .status,  OLD .date, OLD .atas_nama, OLD .bentuk_zakat, OLD .satuan_zakat, OLD .jumlah_jiwa, OLD .jumlah_zakat);

CREATE TRIGGER `tambah_zakat_mal` AFTER INSERT ON `tb_zakat_mal` FOR EACH ROW INSERT INTO tb_log_zakat_mal(aksi, timestamp, kode_transaksi, user_id, status, date, atas_nama, bentuk_zakat, satuan_zakat, jumlah_jiwa, jumlah_zakat)
VALUES('Tambah', NOW(), NEW .kode_transaksi, NEW .user_id, NEW .status, NEW .date, NEW .atas_nama, NEW .bentuk_zakat, NEW .satuan_zakat, NEW .jumlah_jiwa, NEW .jumlah_zakat);

CREATE TRIGGER `update_zakat_mal` AFTER UPDATE ON `tb_zakat_mal` FOR EACH ROW INSERT INTO tb_log_zakat_mal(aksi, timestamp, kode_transaksi, user_id, status, date, atas_nama, bentuk_zakat, satuan_zakat, jumlah_jiwa, jumlah_zakat)
VALUES('Tambah', NOW(), NEW .kode_transaksi, NEW .user_id, NEW .status, NEW .date, NEW .atas_nama, NEW .bentuk_zakat, NEW .satuan_zakat, NEW .jumlah_jiwa, NEW .jumlah_zakat);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_dokumentasi`
--
ALTER TABLE `tb_dokumentasi`
  ADD PRIMARY KEY (`dok_id`),
  ADD KEY `id_kegiatan` (`id_kegiatan`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_inventaris`
--
ALTER TABLE `tb_inventaris`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `tb_jenis_kegiatan`
--
ALTER TABLE `tb_jenis_kegiatan`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tb_kas_masjid`
--
ALTER TABLE `tb_kas_masjid`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `tb_kategori_kas`
--
ALTER TABLE `tb_kategori_kas`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `id_jenis` (`id_jenis`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_log_inventaris`
--
ALTER TABLE `tb_log_inventaris`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_log_kas`
--
ALTER TABLE `tb_log_kas`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_log_zakat_fitrah`
--
ALTER TABLE `tb_log_zakat_fitrah`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_log_zakat_mal`
--
ALTER TABLE `tb_log_zakat_mal`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_memo`
--
ALTER TABLE `tb_memo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dari` (`dari`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tb_mustahik`
--
ALTER TABLE `tb_mustahik`
  ADD PRIMARY KEY (`id_mustahik`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_pengaturan_masjid`
--
ALTER TABLE `tb_pengaturan_masjid`
  ADD PRIMARY KEY (`id_masjid`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `tb_roles_ibfk_2` (`type_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `tb_user_ibfk_1` (`id_jabatan`);

--
-- Indexes for table `tb_user_type`
--
ALTER TABLE `tb_user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `tb_zakat_fitrah`
--
ALTER TABLE `tb_zakat_fitrah`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_zakat_mal`
--
ALTER TABLE `tb_zakat_mal`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_dokumentasi`
--
ALTER TABLE `tb_dokumentasi`
  MODIFY `dok_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_inventaris`
--
ALTER TABLE `tb_inventaris`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_jenis_kegiatan`
--
ALTER TABLE `tb_jenis_kegiatan`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_kas_masjid`
--
ALTER TABLE `tb_kas_masjid`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_kategori_kas`
--
ALTER TABLE `tb_kategori_kas`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_log_inventaris`
--
ALTER TABLE `tb_log_inventaris`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_log_kas`
--
ALTER TABLE `tb_log_kas`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_log_zakat_fitrah`
--
ALTER TABLE `tb_log_zakat_fitrah`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_log_zakat_mal`
--
ALTER TABLE `tb_log_zakat_mal`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_memo`
--
ALTER TABLE `tb_memo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tb_mustahik`
--
ALTER TABLE `tb_mustahik`
  MODIFY `id_mustahik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_pengaturan_masjid`
--
ALTER TABLE `tb_pengaturan_masjid`
  MODIFY `id_masjid` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_user_type`
--
ALTER TABLE `tb_user_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_zakat_fitrah`
--
ALTER TABLE `tb_zakat_fitrah`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tb_zakat_mal`
--
ALTER TABLE `tb_zakat_mal`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_dokumentasi`
--
ALTER TABLE `tb_dokumentasi`
  ADD CONSTRAINT `tb_dokumentasi_ibfk_1` FOREIGN KEY (`id_kegiatan`) REFERENCES `tb_kegiatan` (`id_kegiatan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_dokumentasi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_inventaris`
--
ALTER TABLE `tb_inventaris`
  ADD CONSTRAINT `tb_inventaris_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD CONSTRAINT `tb_jabatan_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `tb_user_type` (`type_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_kas_masjid`
--
ALTER TABLE `tb_kas_masjid`
  ADD CONSTRAINT `tb_kas_masjid_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kas_masjid_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori_kas` (`id_kategori`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  ADD CONSTRAINT `tb_kegiatan_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `tb_jenis_kegiatan` (`id_jenis`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kegiatan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_memo`
--
ALTER TABLE `tb_memo`
  ADD CONSTRAINT `tb_memo_ibfk_1` FOREIGN KEY (`dari`) REFERENCES `tb_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD CONSTRAINT `tb_roles_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `tb_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_roles_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `tb_user_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tb_jabatan` (`id_jabatan`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_zakat_fitrah`
--
ALTER TABLE `tb_zakat_fitrah`
  ADD CONSTRAINT `tb_zakat_fitrah_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_zakat_mal`
--
ALTER TABLE `tb_zakat_mal`
  ADD CONSTRAINT `tb_zakat_mal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
