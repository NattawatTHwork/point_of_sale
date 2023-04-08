-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2023 at 08:48 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `status`, `firstname`, `lastname`) VALUES
(1, 'admin@gmail.com', '$2y$10$bilVP71iW.IFnzkR/ncYzOuYReIYNedKZ4KcMKgKtgLpsE.5mHwDe', 1, 'Nattawat', 'Thungyen'),
(2, 'admin2@gmail.com', '$2y$10$JD55ly5EDvk6DaKlIp1m8Ovc4Qza1TCl2/jntfTnNn9vLQ.GRuj8O', 0, 'Wanchana', 'Kaedmun');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(10) NOT NULL,
  `no_receipt` varchar(255) NOT NULL,
  `method` tinyint(1) NOT NULL COMMENT '0=cash\r\n1=qrcode',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `no_receipt`, `method`, `timestamp`, `status`) VALUES
(33, '20230408030457', 0, '2023-04-07 20:04:57', 0),
(34, '20230408033023', 1, '2023-04-07 20:30:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(10) NOT NULL,
  `discount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `type_id`, `user_id`, `name`, `description`, `price`, `discount`) VALUES
(2, 11, 7, 'ลาเต้', 'ขายทุกอย่าง', 50, 0),
(3, 11, 7, 'เอสเพสโช่', 'ขายทุกอย่าง', 50, 5),
(4, 11, 7, 'กาแฟดำ', 'ขายทุกอย่าง', 100, 10),
(5, 13, 7, 'มอคค่า', 'ขายทุกอย่าง', 55, 5),
(6, 18, 7, 'น้ำส้ม', 'ขายทุกอย่าง', 55, 10),
(7, 11, 7, 'นม', 'user_id', 50, 5),
(8, 11, 8, 'cannon', '20', 100, 20),
(9, 12, 8, 'fuji', '5', 100, 5);

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `record_id` int(10) NOT NULL,
  `no_receipt` varchar(255) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(255) NOT NULL,
  `net_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`record_id`, `no_receipt`, `product_id`, `quantity`, `net_price`) VALUES
(62, '20230408030457', 4, 1, 90),
(63, '20230408033023', 2, 1, 50),
(64, '20230408033023', 3, 1, 45);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(10) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type`) VALUES
(11, 'Espresso'),
(12, 'Espresso con panna coffee'),
(13, 'Long Black'),
(14, 'Latte'),
(15, 'Flat White'),
(16, 'Cappuccino'),
(17, 'Piccolo'),
(18, 'Mocha'),
(19, 'Caramel Macchiato'),
(20, 'Dirty Coffee'),
(21, 'Dalgona Coffee'),
(22, 'Americano');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=disable\r\n1=enable',
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `store` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `status`, `firstname`, `lastname`, `store`, `description`, `img_path`) VALUES
(7, 'user@gmail.com', '$2y$10$BChw6lO9TBNlE0szK7TMoeIXl6GAf3sGDBbq67yv5A0.X9VeNeaL.', 1, 'Nattawat', 'Thungyen', 'BOMPaPerX', 'ขายทุกอย่าง', '106425d46bdff69QR.png'),
(8, 'user2@gmail.com', '$2y$10$eXa/NC96wjdf3JV.xGrR4ubT1wO25f1NocnTaHdap68maRaEW9vzy', 0, 'Wanchana', 'Kaedmun', 'นายอาม', 'ขายกล้อง', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `record_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
