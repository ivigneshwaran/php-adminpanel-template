-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2019 at 07:30 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wwwmanim_knee`
--

-- --------------------------------------------------------

--
-- Table structure for table `rd_meta`
--

CREATE TABLE `rd_meta` (
  `m_id` bigint(20) NOT NULL,
  `meta_type` varchar(30) NOT NULL,
  `meta_name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `meta_slug` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `st` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rd_meta`
--

INSERT INTO `rd_meta` (`m_id`, `meta_type`, `meta_name`, `meta_slug`, `meta_value`, `st`) VALUES
(4, 'category', 'About Us', 'about-us', '', 0),
(5, 'category', 'Why Us', 'why-us', '', 0),
(6, 'category', 'Services', 'services', '', 0),
(7, 'category', 'Conditions Treated', 'conditions-treated', '', 0),
(8, 'category', 'Testimonial', 'testimonial', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rd_meta`
--
ALTER TABLE `rd_meta`
  ADD PRIMARY KEY (`m_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rd_meta`
--
ALTER TABLE `rd_meta`
  MODIFY `m_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
