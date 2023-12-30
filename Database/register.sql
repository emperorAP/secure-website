-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2023 at 07:55 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cyberlogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `is_verified` int(10) NOT NULL DEFAULT 0,
  `resettoken` varchar(255) DEFAULT NULL,
  `resettokenexpire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `username`, `email`, `password`, `token`, `verification_code`, `is_verified`, `resettoken`, `resettokenexpire`) VALUES
(14, 'ashish', 'panthi1@gmail.com', '$2y$10$RHmVsKKDcpwKkNOLDqUb5ekUNvj0OIGEJAvhosZeyAI3VmqiXHfTS', '5520178011beeac03c85153e704f16', '31a33ea3065e8d95a0e92adb990741e0', 0, NULL, NULL),
(17, 'AP', 'panthiaaashish@gmail.com', '$2y$10$QEM5GKqjsQriHsaW6JHdfeHcYapvfMCd9Di.R4QWnfZyX3RcCethi', '2e8b75c6b03b3409a0f81e3025524c', '9a07ef90398cfd4f4afe9958e294c4a8', 1, 'd3e32ab877f562e806ab7f7012d9e6f6', '2023-03-28'),
(18, 'AP', 'ap12@gmail.com', '$2y$10$mQiAEugPlX5fZK6ca1NroeFTbE44Rj7JgllRgG7W6FZVWiYitSk2e', '7cfc5b9105c1b594fc91584241c113', 'f0707e7e543ab0520c18d964cd3794e1', 0, NULL, NULL),
(19, 'AP', 'apap@gmail.com', '$2y$10$ZitK60L.56HOFdWqnMhv2uTe3CRlt4N5UEAQfPx24SoOK0s.e1RQm', '386db898d530a61a9a058c84f4af43', '0039b98770c9e458ee972a975a4d46c0', 0, NULL, NULL),
(20, 'AP', 'paaa@gmail.com', '$2y$10$s2IBmVCFsCHX1WsdXZkdyuOyhNi816UHXUjK33Y7Fb1uuyrAsfknu', '2c2f4fe5e83c3f9c40a82017e39bce', 'a1e76ce21d52087f622fd465213b520f', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
