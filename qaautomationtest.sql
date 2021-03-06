-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2020 at 09:26 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qaautomationtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `caseone`
--

CREATE TABLE `caseone` (
  `id` int(11) NOT NULL,
  `candidateName` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `text1` varchar(100) COLLATE utf32_unicode_ci DEFAULT NULL,
  `text2` varchar(100) COLLATE utf32_unicode_ci DEFAULT NULL,
  `text3` varchar(100) COLLATE utf32_unicode_ci DEFAULT NULL,
  `text4` varchar(100) COLLATE utf32_unicode_ci DEFAULT NULL,
  `options` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `multipleoptions` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  `alltext` text COLLATE utf32_unicode_ci NOT NULL,
  `acceptedFlag` enum('queue','accept','reject') COLLATE utf32_unicode_ci NOT NULL DEFAULT 'queue',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `casetwo`
--

CREATE TABLE `casetwo` (
  `id` int(11) NOT NULL,
  `type` enum('plus','minus') COLLATE utf32_unicode_ci NOT NULL,
  `amount` bigint(20) NOT NULL,
  `description` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `status` enum('Approved','Rejected','Pending') COLLATE utf32_unicode_ci NOT NULL DEFAULT 'Pending',
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `candidateName` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `makerUsername` varchar(10) COLLATE utf32_unicode_ci NOT NULL,
  `checkerUsername` varchar(10) COLLATE utf32_unicode_ci NOT NULL,
  `isLogin` enum('1','0') COLLATE utf32_unicode_ci NOT NULL DEFAULT '0',
  `lastLogin` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caseone`
--
ALTER TABLE `caseone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `casetwo`
--
ALTER TABLE `casetwo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caseone`
--
ALTER TABLE `caseone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `casetwo`
--
ALTER TABLE `casetwo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
