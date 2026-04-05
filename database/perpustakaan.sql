-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Mar 2024 pada 15.09
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL,
  `kode_admin` varchar(12) NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `sebagai` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama_admin`, `password`, `kode_admin`, `no_tlp`, `sebagai`) VALUES
(24, 'naufal', '123', 'admin1', '081231234', 'admin'),
(25, 'rama', '123', 'petugas1', '086557231', 'petugas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `cover` varchar(255) NOT NULL,
  `id_buku` varchar(20) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` date NOT NULL,
  `jumlah_halaman` int(11) NOT NULL,
  `buku_deskripsi` text NOT NULL,
  `isi_buku` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`cover`, `id_buku`, `kategori`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `jumlah_halaman`, `buku_deskripsi`, `isi_buku`) VALUES
('65cd871847f87.jpeg', 'BK0001', 'bisnis', 'Crypto', 'dimz', 'bagaimana cara belajar Crypto', '2024-02-20', 68, 'Trading', 'crypto.pdf'),
('65cd87b9ad169.jpeg', 'BK0002', 'bisnis', 'Bitcoin ', 'Kevin', 'PT.Kevinda', '2024-02-04', 50, 'tentang bitcoin yang mendunia ', 'Bitcoin - Wikipedia bahasa Indonesia, ensiklopedia bebas.pdf'),
('65cd87d04320a.jpg', 'BK0003', 'novel', 'Boboiboy', 'm.ihyadin', 'adinn', '2024-02-15', 30, 'anak kecial punya kekuatan', 'BoBoiBoy - Wikipedia bahasa Indonesia, ensiklopedia bebas.pdf'),
('65cd8853279a9.jpeg', 'BK0004', 'novel', 'Bawang Merah Bawang Putih ', 'Andri', 'PT.Novel', '2014-02-02', 20, 'anak tiri yang dijahati oleh ibu tirinya', 'Bawang Merah Bawang Putih - Wikipedia bahasa Indonesia, ensiklopedia bebas.pdf'),
('65f6f2dbb4755.jpg', 'BK0005', 'bahasa', 'indonesia tanah air', 'merdeka', 'paleto', '2024-03-17', 200, 'indonesia tanah air beta, pusaka abadi nan jaya.  indonesia sejak dulu kala, tetap di puja puja bangsa, disana tempat lahir beta', '(Bahasa Inggris) (Bahasa Inggris) (1).pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_buku`
--

CREATE TABLE `kategori_buku` (
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori_buku`
--

INSERT INTO `kategori_buku` (`kategori`) VALUES
('bahasa'),
('bisnis'),
('filsafat'),
('informatika'),
('novel'),
('olahraga'),
('sains');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `nisn` int(11) NOT NULL,
  `kode_member` varchar(12) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `kelas` varchar(5) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `tgl_pendaftaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`nisn`, `kode_member`, `nama`, `password`, `jenis_kelamin`, `kelas`, `jurusan`, `no_tlp`, `tgl_pendaftaran`) VALUES
(1, 'mem01', 'rpl', '$2y$10$ePvYz233f/pM0pxe6/7Ez.XJU.qh3Xc1OqFjttLMoWAc6TQG/mqpK', 'Laki laki', 'X', 'Sistem Informatika Jaringan dan Aplikasi', '0123', '2024-02-07'),
(2, 'mem02', 'dimas', '$2y$10$iBawahYf6oYv2F5q3O1aUezRlKMvFFpw.3NnCRX5WS2rLE4yea7Im', 'Laki laki', 'XI', 'Sistem Informatika Jaringan dan Aplikasi', '08123', '2024-02-19'),
(3, 'mem03', 'adin', '$2y$10$R/nSgUE3S91pdxlWC7sQ2e4Cjjls5RaxenpEkDf8DpjDuMzqrvKEy', 'Laki laki', 'XI', 'Rekayasa Perangkat Lunak', '089265', '2024-02-22'),
(4, 'mem04', 'sulthan', '$2y$10$NVCIbokJyz6Vnl8G4P6heOdYCxDGyFmcjO7ze6f6tqvhc0GfVchIO', 'Laki laki', 'XII', 'Teknik Instalasi Tenaga Listrik', '13213', '2024-03-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_buku` varchar(20) NOT NULL,
  `nisn` int(11) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `harga` int(20) NOT NULL,
  `bukti_transaksi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `nisn`, `nama_admin`, `tgl_peminjaman`, `tgl_pengembalian`, `status`, `harga`, `bukti_transaksi`) VALUES
(129, 'BK0001', 4, 'rama', '2024-03-15', '2024-03-16', 'Waktu habis', 1250, '053.jpg'),
(130, 'BK0001', 4, 'rama', '2024-03-15', '2024-03-20', 'Belum konfirmasi', 5000, ''),
(131, 'BK0002', 4, 'rama', '2024-03-15', '2024-03-22', 'Belum konfirmasi', 6300, ''),
(132, 'BK0003', 4, 'rama', '2024-03-15', '2024-03-16', 'Waktu habis', 1250, ''),
(133, 'BK0004', 4, 'rama', '2024-03-17', '2024-03-27', 'Belum konfirmasi', 8000, '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_admin` (`kode_admin`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `kategori` (`kategori`);

--
-- Indeks untuk tabel `kategori_buku`
--
ALTER TABLE `kategori_buku`
  ADD PRIMARY KEY (`kategori`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`nisn`),
  ADD UNIQUE KEY `kode_member` (`kode_member`);

--
-- Indeks untuk tabel `peminjaman`
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
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori_buku` (`kategori`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`nisn`) REFERENCES `member` (`nisn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
