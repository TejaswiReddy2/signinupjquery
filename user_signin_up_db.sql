-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2020 at 02:55 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_signin_up_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `vb_users`
--

CREATE TABLE `vb_users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `full_name` varchar(64) DEFAULT '',
  `user_email` varchar(64) DEFAULT '',
  `mobile_number` varchar(16) DEFAULT '',
  `user_phone_otp` varchar(8) DEFAULT '',
  `user_phone_verify` enum('N','Y') DEFAULT 'Y',
  `password` varchar(512) DEFAULT '',
  `user_password_otp` varchar(8) DEFAULT '',
  `creation_ip` varchar(16) DEFAULT '',
  `creation_date` datetime DEFAULT '1970-01-01 00:00:00',
  `creation_lat` varchar(32) DEFAULT '',
  `creation_long` varchar(32) DEFAULT '',
  `created_by` bigint(20) DEFAULT NULL,
  `update_ip` varchar(16) DEFAULT '',
  `update_date` datetime DEFAULT '1970-01-01 00:00:00',
  `update_lat` varchar(32) DEFAULT '',
  `update_long` varchar(32) DEFAULT '',
  `updated_by` bigint(20) DEFAULT NULL,
  `status` enum('A','I','B','D') DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vb_users`
--

INSERT INTO `vb_users` (`id`, `user_id`, `full_name`, `user_email`, `mobile_number`, `user_phone_otp`, `user_phone_verify`, `password`, `user_password_otp`, `creation_ip`, `creation_date`, `creation_lat`, `creation_long`, `created_by`, `update_ip`, `update_date`, `update_lat`, `update_long`, `updated_by`, `status`) VALUES
(1, 1000000001, 'Tejaswi Reddy', 'tejaswi.teju@algosoft.co', '9664224772', '', 'Y', 'ZQmGvsUJetV+DT1R5z4Bm7a2+zhQhYYRiTKnESx62XBjQ3NwaXJ4cnFUaU9XUkdmc1ZDSWxtOGVObmdJNVFVPQ==', '4321', '192.168.1.100', '2020-10-04 12:20:35', '', '', NULL, '', '1970-01-01 00:00:00', '', '', NULL, 'A'),
(2, 1000000002, 'Pruthvi', 'koga@wemsrsa.com', '7691813993', '', 'Y', 'Iu9CcpudNB6PN5bNLLvdTTHe8iXtcoTf45vbqmOWZmtBNmpXY282MXkwbit3VmU5b3JUY1dzR3V1aGFqOVV3PQ==', '', '192.168.1.100', '2020-10-04 13:18:12', '', '', NULL, '', '1970-01-01 00:00:00', '', '', NULL, 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vb_users`
--
ALTER TABLE `vb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vb_users`
--
ALTER TABLE `vb_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
