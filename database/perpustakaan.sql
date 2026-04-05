-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 05, 2026 at 02:11 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL,
  `kode_admin` varchar(12) NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `sebagai` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama_admin`, `password`, `kode_admin`, `no_tlp`, `sebagai`) VALUES
(24, 'admin', '123', 'admin1', '081231234', 'admin'),
(25, 'petugas1', '123', 'petugas1', '086557231', 'petugas'),
(26, 'petugas2', '123', 'petugas2', '08181080', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `cover` varchar(255) NOT NULL,
  `id_buku` varchar(20) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` date NOT NULL,
  `jumlah_halaman` int NOT NULL,
  `buku_deskripsi` text NOT NULL,
  `isi_buku` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`cover`, `id_buku`, `kategori`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `jumlah_halaman`, `buku_deskripsi`, `isi_buku`) VALUES
('69d26ce95acdc.jpeg', 'BK0001', 'informatika', 'Buku IOT', 'Rehan', 'Buku Pembelajaran Tentang IOT', '2024-02-20', 68, 'IOT', 'crypto.pdf'),
('65cd87d04320a.jpg', 'BK0003', 'novel', 'Boboiboy', 'm.ihyadin', 'adinn', '2024-02-15', 30, 'anak kecial punya kekuatan', 'BoBoiBoy - Wikipedia bahasa Indonesia, ensiklopedia bebas.pdf'),
('65cd8853279a9.jpeg', 'BK0004', 'novel', 'Bawang Merah Bawang Putih ', 'Andri', 'PT.Novel', '2014-02-02', 20, 'anak tiri yang dijahati oleh ibu tirinya', 'Bawang Merah Bawang Putih - Wikipedia bahasa Indonesia, ensiklopedia bebas.pdf'),
('69d26cd15aa64.jpg', 'BK0005', 'bisnis', 'Originals Bisnis', 'Adam Grant', 'PT Nusantara Sejahtera', '2026-01-31', 12, 'Adam Grant\r\n', 'sertifikat-rehan-maulana-5 (2).pdf');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_buku`
--

CREATE TABLE `kategori_buku` (
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_buku`
--

INSERT INTO `kategori_buku` (`kategori`) VALUES
('bisnis'),
('filsafat'),
('informatika'),
('novel'),
('olahraga'),
('sains');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `nisn` int NOT NULL,
  `kode_member` varchar(12) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `kelas` varchar(5) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `tgl_pendaftaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`nisn`, `kode_member`, `nama`, `password`, `jenis_kelamin`, `kelas`, `jurusan`, `no_tlp`, `tgl_pendaftaran`) VALUES
(1, 'mem01', 'rpl', '$2y$10$ePvYz233f/pM0pxe6/7Ez.XJU.qh3Xc1OqFjttLMoWAc6TQG/mqpK', 'Laki laki', 'X', 'Sistem Informatika Jaringan dan Aplikasi', '0123', '2024-02-07'),
(2, 'mem02', 'dimas', '$2y$10$iBawahYf6oYv2F5q3O1aUezRlKMvFFpw.3NnCRX5WS2rLE4yea7Im', 'Laki laki', 'XI', 'Sistem Informatika Jaringan dan Aplikasi', '08123', '2024-02-19'),
(4, 'mem04', 'sulthan', '$2y$10$NVCIbokJyz6Vnl8G4P6heOdYCxDGyFmcjO7ze6f6tqvhc0GfVchIO', 'Laki laki', 'XII', 'Teknik Instalasi Tenaga Listrik', '13213', '2024-03-15'),
(900, 'mem07', 'reh', '$2y$10$2bxcc1tLOT2NZgcxvGfYqOXozCMYCvpZp4n30NmAOpsNXM6aK85Ry', 'Laki laki', 'X', 'Desain Gambar Mesin', '08080', '2026-02-01'),
(1090, 'mem08', 'tim', '$2y$10$F0zPrysaI3WaZyxVrF.gjO1Gzv4lCy22p.0dZKeXq7KbtwsbFRIKW', 'Laki laki', 'X', 'Teknik Konstruksi Perumahan', '0800', '2026-02-01'),
(1234, 'mem05', 'ari', '$2y$10$xAmXB3OMm/JnUr/A3.QviOAxeeL7sZQ2hksgilHWuJZAxEW.gFtQW', 'Choose', 'Choos', 'Choose', '0', '2025-08-05'),
(22222, 'mem06', 'tim', '$2y$10$9CXbeZL.NPkFln9aF.YYh.BbB3nNR1pR1TiqiN2u4AJR8flnFi5Am', 'Laki laki', 'X', 'Desain Pemodelan Informasi Bangunan', '0800', '2026-02-01'),
(232410205, 'mem09', 'rehan maulana', '$2y$10$Ef0PZUXf6hLYI1aETrXfg.5qrseYuuU5JYyb4WD8DM9235SeHHVyW', 'Laki laki', '', 'Rekayasa Perangkat Lunak', '0801810801', '2026-04-05');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `id_buku` varchar(20) NOT NULL,
  `nisn` int NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `harga` int NOT NULL,
  `bukti_transaksi` varchar(50) NOT NULL,
  `address_norek` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `nisn`, `nama_admin`, `tgl_peminjaman`, `tgl_pengembalian`, `status`, `harga`, `bukti_transaksi`, `address_norek`) VALUES
(129, 'BK0001', 4, 'rama', '2024-03-15', '2024-03-16', 'Waktu habis', 1250, '053.jpg', ''),
(130, 'BK0001', 4, 'rama', '2024-03-15', '2024-03-20', 'Waktu habis', 5000, '', ''),
(132, 'BK0003', 4, 'rama', '2024-03-15', '2024-03-16', 'Waktu habis', 1250, '', ''),
(133, 'BK0004', 4, 'rama', '2024-03-17', '2024-03-27', 'Waktu habis', 8000, '', ''),
(134, 'BK0003', 1234, 'rama', '2026-01-22', '2026-01-23', 'Waktu habis', 1250, 'PKR20260122145818.png', ''),
(139, 'BK0003', 1234, 'rama', '2026-01-29', '2026-02-03', 'Waktu habis', 5000, 'download (1).png', ''),
(142, 'BK0001', 1234, 'rama', '2026-01-30', '2026-02-09', 'Waktu habis', 8000, 'logo-removebg-preview.png', '0861658'),
(143, 'BK0005', 1234, 'rama', '2026-02-01', '2026-02-06', 'Waktu habis', 5000, 'pplg.jpg', '11221'),
(144, 'BK0001', 1234, 'rama', '2026-02-01', '2026-02-02', 'Waktu habis', 1250, 'madep.jpg', '0861658'),
(145, 'BK0005', 1234, 'rama', '2026-02-02', '2026-02-03', 'Waktu habis', 1250, 'register-fungsi.png', '0861658'),
(146, 'BK0005', 1234, 'rama', '2026-02-04', '2026-02-05', 'Waktu habis', 1250, '', NULL),
(147, 'BK0003', 1234, 'rama', '2026-02-04', '2026-02-05', 'Waktu habis', 1250, 'UPLOAD.png', '0861658'),
(148, 'BK0003', 232410205, 'rama', '2026-04-05', '2026-04-06', 'Konfirmasi', 1250, 'WhatsApp Image 2026-03-05 at 15.09.13.jpeg', '0861658'),
(149, 'BK0005', 232410205, 'tim', '2026-04-05', '2026-04-06', 'Belum konfirmasi', 1250, 'Logo InvestaStar.png', '0861658');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_admin` (`kode_admin`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `kategori_buku`
--
ALTER TABLE `kategori_buku`
  ADD PRIMARY KEY (`kategori`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`nisn`),
  ADD UNIQUE KEY `kode_member` (`kode_member`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `nisn` (`nisn`),
  ADD KEY `id_admin` (`nama_admin`),
  ADD KEY `id_admin_2` (`nama_admin`),
  ADD KEY `nama_admin` (`nama_admin`),
  ADD KEY `nama_admin_2` (`nama_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori_buku` (`kategori`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`nisn`) REFERENCES `member` (`nisn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
