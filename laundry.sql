-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 09:38 AM
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
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `costumer`
--

CREATE TABLE `costumer` (
  `id` int(12) NOT NULL,
  `costumer_name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `costumer`
--

INSERT INTO `costumer` (`id`, `costumer_name`, `phone`, `alamat`, `create_at`, `update_at`) VALUES
(3, 'Budi', '543757', 'Bandung', '2024-11-15 03:16:49', '2024-11-20 08:34:22'),
(4, 'oji yimeng', '434544', 'Tegal Alur', '2024-11-20 04:01:58', '2024-11-20 08:34:39');

-- --------------------------------------------------------

--
-- Table structure for table `detail_trans_order`
--

CREATE TABLE `detail_trans_order` (
  `id` int(12) NOT NULL,
  `id_order` int(12) DEFAULT NULL,
  `id_service` int(12) DEFAULT NULL,
  `qty` int(12) NOT NULL,
  `subtotal` varchar(50) NOT NULL,
  `note` varchar(50) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_trans_order`
--

INSERT INTO `detail_trans_order` (`id`, `id_order`, `id_service`, `qty`, `subtotal`, `note`, `create_at`, `update_at`) VALUES
(45, 64, 2, 3, '15000', '', '2024-11-20 06:01:28', '2024-11-20 06:01:28'),
(46, 64, 3, 1, '7000', '', '2024-11-20 06:01:28', '2024-11-20 06:01:28'),
(47, 65, 2, 3, '15000', '', '2024-11-20 06:19:15', '2024-11-20 06:19:15'),
(48, 65, 3, 3, '21000', '', '2024-11-20 06:19:15', '2024-11-20 06:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(12) NOT NULL,
  `nama_level` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `created_at`, `update_at`) VALUES
(1, 'administrator', '2024-11-13 06:20:18', '2024-11-13 06:20:18'),
(2, 'operator', '2024-11-13 06:20:18', '2024-11-13 06:20:18'),
(6, 'pimpinan', '2024-11-15 01:58:33', '2024-11-15 01:58:33');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(50) NOT NULL,
  `service_name` text NOT NULL,
  `harga` int(50) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_name`, `harga`, `deskripsi`, `create_at`, `update_at`) VALUES
(2, 'cuci baju', 5000, 'cuci baju yang bener', '2024-11-15 04:48:52', '2024-11-15 04:50:20'),
(3, 'cuci kain', 7000, 'cuci kain tidur', '2024-11-15 08:24:29', '2024-11-15 08:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `trans_order`
--

CREATE TABLE `trans_order` (
  `id` int(11) NOT NULL,
  `id_costomer` int(12) NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `order_date` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_order`
--

INSERT INTO `trans_order` (`id`, `id_costomer`, `order_code`, `status`, `order_date`, `keterangan`, `create_at`, `update_at`) VALUES
(64, 3, '#INV/20112024/00064', 0, '2024-11-17', '', '2024-11-20 06:01:28', '2024-11-20 06:01:28'),
(65, 4, '#INV/20112024/00065', 0, '2024-11-04', '', '2024-11-20 06:19:15', '2024-11-20 06:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `id_level` int(12) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `nama`, `email`, `username`, `password`, `create_at`, `update_at`) VALUES
(1, 1, 'admin', 'admin@gmail.com', 'admin', '123', '2024-11-13 06:43:42', '2024-11-13 06:43:42'),
(3, 2, 'operator', 'operator@gmail.com', 'operator', '1234', '2024-11-13 08:26:36', '2024-11-13 08:26:36'),
(9, 6, 'pimpinan', 'pimpinan@gmail.com', '', '123', '2024-11-15 03:33:14', '2024-11-15 03:33:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `costumer`
--
ALTER TABLE `costumer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_trans_order`
--
ALTER TABLE `detail_trans_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_service` (`id_service`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_order`
--
ALTER TABLE `trans_order`
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
-- AUTO_INCREMENT for table `costumer`
--
ALTER TABLE `costumer`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_trans_order`
--
ALTER TABLE `detail_trans_order`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trans_order`
--
ALTER TABLE `trans_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_trans_order`
--
ALTER TABLE `detail_trans_order`
  ADD CONSTRAINT `detail_trans_order_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `trans_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_trans_order_ibfk_2` FOREIGN KEY (`id_service`) REFERENCES `service` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `id_level_to_level` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
