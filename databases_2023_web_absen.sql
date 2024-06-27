-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2024 at 07:30 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `databases_2023_web_absen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_absensi` enum('masuk','pulang') NOT NULL,
  `foto_selfie` text NOT NULL,
  `latitude` decimal(10,6) NOT NULL,
  `longitude` decimal(10,6) NOT NULL,
  `waktu_absensi` date DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `alasan` text NOT NULL,
  `waktu` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `nama`, `jenis_absensi`, `foto_selfie`, `latitude`, `longitude`, `waktu_absensi`, `status`, `alasan`, `waktu`) VALUES
(1, 'ressa', 'masuk', '1696841856.jpg', '-1.616578', '103.623818', '2023-10-09', 'telat', 'nb', '15:57:36'),
(2, 'ressa', 'masuk', '1696902100.jpg', '0.000000', '0.000000', '2023-10-10', 'telat', ',kjhg', '08:41:40'),
(3, 'ressa', 'pulang', '1696902114.jpg', '0.000000', '0.000000', '2023-10-10', 'telat', 'kjhg', '08:41:54'),
(4, 'ressa', 'masuk', '1719464159.jpg', '0.000000', '0.000000', '2024-06-27', 'telat', 'aplikasi saya tidak berjalan', '11:55:59'),
(5, 'ressa', 'pulang', '1719464256.jpg', '0.000000', '0.000000', '2024-06-27', 'telat', 'hp saya habis batre', '11:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `tes`
--

CREATE TABLE `tes` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_absensi` enum('masuk','pulang') NOT NULL,
  `waktu_absensi` datetime NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `selfie_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(4, 'fajar', '$2y$10$6bbAVkviGB6HotGuC17qw.lcxhAbX1x3qUYjlj3vg0usTsVb32VKK'),
(5, 'ressa', '$2y$10$ca1V1drryH2rOeZ41tonR.y8wtevXqN8kCtqJLeDtwYsrU8Q3svp2'),
(6, 'vinna', '$2y$10$HF0Wc1S1uVrbiGo/WLW6Wuwearevo7QQ3bTlP3cYee/jn3Ds23HRO'),
(8, 'tes', '$2y$10$4hOTqyRcJ2aPy3/j797preg.YU45.pmeHUR.ZRx18pj/7IDAaAjHO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tes`
--
ALTER TABLE `tes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tes`
--
ALTER TABLE `tes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
