-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 09:08 AM
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
-- Database: `coba`
--

-- --------------------------------------------------------

--
-- Table structure for table `debitur`
--

CREATE TABLE `debitur` (
  `id` int(11) NOT NULL,
  `cif` varchar(6) NOT NULL,
  `rekening` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `nominal` varchar(100) NOT NULL,
  `segmen` enum('KUR','KUPEDES','BRIGUNA') NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_sekarang` date NOT NULL DEFAULT curdate(),
  `usia_arsip` int(11) GENERATED ALWAYS AS (to_days(`tanggal_sekarang`) - to_days(`tanggal_masuk`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `debitur`
--

INSERT INTO `debitur` (`id`, `cif`, `rekening`, `nama`, `alamat`, `telepon`, `nominal`, `segmen`, `tanggal_masuk`, `tanggal_sekarang`) VALUES
(8, 'JKH688', '365501056085282', 'Adam', 'Ujung Berung, Kota Bandung', '089654936758', '5000000', 'BRIGUNA', '2025-05-20', '2025-06-20'),
(9, 'RHD747', '472847983640197', 'Rainhard', 'Cibiru, Kota Bandung', '089327324729', '15000000', 'KUPEDES', '2025-04-20', '2025-06-20'),
(10, 'DTR472', '137198371986432', 'Dea ', 'Arcamanik, Kota Bandung', '085327382974', '12000000', 'KUR', '2025-01-20', '2025-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `ruangan` enum('ruangan arsip','gudang','musnahkan') NOT NULL,
  `lemari` varchar(5) DEFAULT NULL,
  `rak` varchar(5) DEFAULT NULL,
  `baris` varchar(5) DEFAULT NULL,
  `digitalisasi` enum('sudah','belum') NOT NULL DEFAULT 'belum',
  `id_debitur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `ruangan`, `lemari`, `rak`, `baris`, `digitalisasi`, `id_debitur`) VALUES
(30, 'ruangan arsip', 'A', '1', '1', 'sudah', 9),
(35, 'ruangan arsip', 'A', '1', '2', 'sudah', 8),
(36, 'musnahkan', NULL, NULL, NULL, 'sudah', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Bagas', 'bagas', '$2y$10$WgEIi3WgkBhTZodDE4s33u7.4nB//9.1qkmicXlK0FaNX3tzrL7m2'),
(2, 'Pamungkas Raharja ', 'pamungkas', '$2y$10$YhuCs9zwGgxTPdqtRdWnE.k1/2tDGUmBg3w6RaAbrgxXkNq.CsczK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `debitur`
--
ALTER TABLE `debitur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lemari` (`lemari`,`rak`,`baris`,`ruangan`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `debitur`
--
ALTER TABLE `debitur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
