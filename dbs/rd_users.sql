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
-- Table structure for table `rd_users`
--

CREATE TABLE `rd_users` (
  `Uid` int(10) NOT NULL,
  `ad_username` varchar(100) NOT NULL,
  `ad_pwd` varchar(250) NOT NULL,
  `ST` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rd_users`
--

INSERT INTO `rd_users` (`Uid`, `ad_username`, `ad_pwd`, `ST`) VALUES
(1, 'kwadmin', '$2y$10$WKwliNIitfcY8UFlwnmOA.eOZ6OWawu9No34i1v4ZZv4CGxzSP0tG', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rd_users`
--
ALTER TABLE `rd_users`
  ADD PRIMARY KEY (`Uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rd_users`
--
ALTER TABLE `rd_users`
  MODIFY `Uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
