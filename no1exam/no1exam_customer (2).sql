-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2018 at 01:29 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `no1exam_customer`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `status` varchar(8) NOT NULL COMMENT 'active, inactive',
  `created_date` datetime NOT NULL,
  `last_modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullname`, `email`, `phone`, `password`, `image`, `status`, `created_date`, `last_modified_date`) VALUES
(1, 'Meda Vinod Kumar', 'vinod@wipro.com', '9705999270', '111111', NULL, 'active', '2018-05-20 15:58:28', '2018-05-20 13:58:28'),
(2, 'kananna', 'kkk@kk.in', '9999999999', '$2y$13$fVrGUaF/LS4Ub2F9/qLHwu6SjLMdNFOcRvAWFFW0bfYbK6EuOwOCu', NULL, 'active', '2018-05-20 16:09:20', '2018-05-20 14:09:23'),
(3, 'ravi', 'ravi@tamil.com', '0000000000', '$2y$13$i1u8vFzZEeBDMCs9Jd3snezlaheF7DMo6syuSlWZWa5ERhkKGDZn.', NULL, 'active', '2018-05-20 16:16:38', '2018-05-21 20:02:07'),
(4, 'surya', 'surya@surya.com', '1000000000', '$2y$13$HVtNq47RfEMGCsgzdOzE9ej8ZQPyremttLXSDel/bOpMnF8WfOu5y', NULL, 'active', '2018-05-20 16:21:54', '2018-05-20 14:21:56'),
(5, 'jyothika', 'jyo@surya.com', '9999999990', '$2y$13$xeFLZYjyT0nsX.E7zXC9eO1GJRo9H/8/aEXZERH3fq/w1tW2Qlmae', NULL, 'active', '2018-05-20 16:24:20', '2018-05-20 14:24:23'),
(6, 'kamal', 'kamal@kaml.com', '9090909090', '$2y$13$ckeTR3ziIQY6nMl1HTd/ruqzNfzrlB1PTRKEEheZDzM8qEdCevy.S', NULL, 'active', '2018-05-20 17:05:03', '2018-05-20 15:05:05'),
(7, 'kkkkkkkkkkkk', 'kkks@kk.in', '8888888888', '$2y$13$URx672zhUtHA4K5Rgq1iquwHHmalF3GtZ8F5gUON.g8Mcn4QwwrRq', NULL, 'active', '2018-05-20 17:38:32', '2018-05-21 20:13:48'),
(8, 'vishnu', 'vishnu@gmail.com', '8978271314', '$2y$13$8eLID/wFzcLDU.upkfn4vegGaKfUivxYS7uvt5lUMwQxWx2evTzNi', NULL, 'active', '2018-05-22 21:24:38', '2018-05-22 19:26:15'),
(9, 'pppppppp', 'pppp@ppp.com', '4444444444', '$2y$13$zHPymnifH2SkFEuSmuSvJ.9UPz8bJUOP0..wz5w0yAhdUZL4/l6w2', NULL, 'active', '2018-05-27 17:43:18', '2018-05-27 15:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `category_type` varchar(15) NOT NULL COMMENT 'forgotpassword',
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(6) DEFAULT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `category_type`, `customer_id`, `token`, `created_date`) VALUES
(1, 'forgotpassword', 3, '308414', '2018-05-21 21:14:35'),
(2, 'forgotpassword', 3, '464452', '2018-05-21 21:15:45'),
(3, 'forgotpassword', 3, '584568', '2018-05-21 21:18:49'),
(4, 'forgotpassword', 3, '482138', '2018-05-21 21:20:02'),
(5, 'forgotpassword', 3, '718650', '2018-05-21 21:20:48'),
(6, 'forgotpassword', 3, '247070', '2018-05-21 21:34:57'),
(7, 'forgotpassword', 3, '878720', '2018-05-21 21:37:52'),
(8, 'forgotpassword', 3, '562116', '2018-05-21 21:39:09'),
(9, 'forgotpassword', 3, '573363', '2018-05-21 21:40:31'),
(10, 'forgotpassword', 3, '740216', '2018-05-21 21:50:27'),
(11, 'forgotpassword', 3, '224755', '2018-05-21 21:52:20'),
(12, 'forgotpassword', 3, '467371', '2018-05-21 21:58:04'),
(13, 'forgotpassword', 3, '566383', '2018-05-21 21:59:36'),
(14, 'forgotpassword', 3, '102616', '2018-05-21 22:01:44'),
(15, 'forgotpassword', 7, '453016', '2018-05-21 22:07:45'),
(16, 'forgotpassword', 7, '527747', '2018-05-21 22:13:09'),
(17, 'forgotpassword', 8, '217881', '2018-05-22 21:25:34'),
(18, 'forgotpassword', 9, '002762', '2018-05-27 17:43:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
