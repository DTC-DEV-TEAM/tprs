-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2023 at 12:43 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dtc_digits_dprs`
--

-- --------------------------------------------------------

--
-- Table structure for table `pre_payment_process`
--

CREATE TABLE `pre_payment_process` (
  `id` int(10) UNSIGNED NOT NULL,
  `pre_payment_header_name` varchar(191) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pre_payment_process`
--

INSERT INTO `pre_payment_process` (`id`, `pre_payment_header_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'For Approval', 'ACTIVE', NULL, NULL, NULL, NULL, NULL),
(2, 'For Budget Release', 'ACTIVE', NULL, NULL, NULL, NULL, NULL),
(3, 'For Receipts Validation', 'ACTIVE', NULL, NULL, NULL, NULL, NULL),
(4, 'For Closing', 'ACTIVE', NULL, NULL, NULL, NULL, NULL),
(5, 'Closed', 'ACTIVE', NULL, NULL, NULL, NULL, NULL),
(6, 'Rejected', 'ACTIVE', NULL, NULL, NULL, NULL, NULL),
(7, 'For Recording', 'ACTIVE', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pre_payment_process`
--
ALTER TABLE `pre_payment_process`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pre_payment_process`
--
ALTER TABLE `pre_payment_process`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
