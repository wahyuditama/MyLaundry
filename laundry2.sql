-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 05:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry2`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(12) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_telepon` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `nama_lengkap`, `no_telepon`, `alamat`, `create_at`, `update_at`) VALUES
(0, 'Arya Wiraguna', '566556', 'bandung', '2024-11-30 13:00:02', '2024-11-30 13:00:02'),
(0, 'ibnu ibrahim', '566556', 'jakarta', '2024-11-30 13:10:43', '2024-11-30 13:10:43');

-- --------------------------------------------------------

--
-- Table structure for table `detail_paket`
--

CREATE TABLE `detail_paket` (
  `id` int(12) NOT NULL,
  `id_user` int(12) NOT NULL,
  `id_paket` int(12) NOT NULL,
  `qty` int(100) NOT NULL,
  `subtotal` varchar(100) NOT NULL,
  `note` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_paket`
--

INSERT INTO `detail_paket` (`id`, `id_user`, `id_paket`, `qty`, `subtotal`, `note`, `create_at`, `update_at`) VALUES
(6, 4, 2, 3, '22500', '', '2024-12-01 15:48:39', '2024-12-01 15:48:39'),
(7, 5, 2, 3, '22500', '', '2024-12-01 16:02:29', '2024-12-01 16:02:29'),
(8, 6, 3, 3, '19500', '', '2024-12-01 16:08:51', '2024-12-01 16:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(12) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama_paket`, `harga`, `deskripsi`, `create_at`, `update_at`) VALUES
(1, 'Cuci Baju (Kaos)', '6000', 'Harga Untuk Baju Kaos', '2024-11-30 16:34:26', '2024-11-30 16:34:26'),
(2, 'Cuci Baju (Kemeja)', '7500', 'Harga Untuk Cuci Kemeja', '2024-11-30 16:37:56', '2024-11-30 16:41:38'),
(3, 'Cuci Celana bahan (non-levis)', '6500', 'Harga Untuk Cuci Celana Bahan', '2024-11-30 17:03:59', '2024-11-30 17:03:59'),
(5, 'Cuci Celana Levis', '8000', 'Harga Untuk Celana Levis', '2024-11-30 17:06:10', '2024-11-30 17:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(12) NOT NULL,
  `nama_level` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `create_at`, `update_at`) VALUES
(1, 'admistrator', '2024-11-30 09:59:26', '2024-11-30 10:14:35'),
(2, 'pimpinan', '2024-11-30 10:24:28', '2024-11-30 10:24:28'),
(3, 'admin web', '2024-11-30 10:24:36', '2024-11-30 10:24:36'),
(5, 'Pengunjung', '2024-11-30 16:06:28', '2024-11-30 16:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `trans_paket`
--

CREATE TABLE `trans_paket` (
  `id` int(12) NOT NULL,
  `id_user` int(12) NOT NULL,
  `no_invoice` varchar(25) NOT NULL,
  `order_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_paket`
--

INSERT INTO `trans_paket` (`id`, `id_user`, `no_invoice`, `order_date`, `status`, `keterangan`, `create_at`, `update_at`) VALUES
(6, 4, '#INV/01122024/0005', '2024-12-01', 0, '', '2024-12-01 16:08:51', '2024-12-01 16:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `id_level` int(12) NOT NULL,
  `level` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `level`, `nama_lengkap`, `email`, `no_telepon`, `alamat`, `password`, `create_at`, `update_at`) VALUES
(2, 1, 'admistrator', 'admin', 'admin@gmail.com', '566556', 'jakarta', '123', '2024-11-30 10:18:59', '2024-11-30 14:40:58'),
(4, 2, 'pimpinan', 'ibnu ibrahim', 'pimpinan@gmail.com', '566556', 'bandung', '123', '2024-11-30 14:28:41', '2024-11-30 14:28:41'),
(5, 3, 'admin web', 'yoimia', 'adminAPK@gmail.com', '566556', 'jakarta', '123', '2024-11-30 16:05:54', '2024-11-30 16:05:54'),
(6, 5, 'Pengunjung', 'yono', 'yono@gmail.com', '56655666', 'jakarta', '123', '2024-11-30 16:06:58', '2024-11-30 16:06:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_paket`
--
ALTER TABLE `detail_paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_paket_ibfk_2` (`id_paket`),
  ADD KEY `detail_paket_ibfk_3` (`id_user`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_paket`
--
ALTER TABLE `trans_paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_paket`
--
ALTER TABLE `detail_paket`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `trans_paket`
--
ALTER TABLE `trans_paket`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_paket`
--
ALTER TABLE `detail_paket`
  ADD CONSTRAINT `detail_paket_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_paket_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
