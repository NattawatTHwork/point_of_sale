-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 07:54 PM
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
(47, '20230429163518', 1, '2023-04-29 09:35:18', 0),
(48, '20230429164321', 0, '2023-04-29 09:43:21', 0),
(51, '20230512123617', 1, '2023-05-12 05:36:17', 0),
(52, '20230516210239', 1, '2023-05-16 14:02:39', 0),
(53, '20230516210303', 0, '2023-05-16 14:03:03', 0),
(54, '20230516210320', 0, '2023-05-16 14:03:20', 0),
(55, '20230516210330', 0, '2023-05-16 14:03:30', 0),
(56, '20230516210456', 1, '2023-05-16 14:04:56', 0),
(57, '20230516212725', 0, '2023-05-16 14:27:25', 0);

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
  `discount` int(10) NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `type_id`, `user_id`, `name`, `description`, `price`, `discount`, `img_path`) VALUES
(17, 23, 7, 'โค้ก', 'โค้ก', 15, 0, '10644cc946558778851959149010_1-20221207171555-.jpg'),
(18, 26, 7, 'นมตราหมี', 'นมตราหมี', 12, 0, '10644cc9b4f38c3BB-Product-shot-01.png'),
(19, 24, 7, 'ลาเต้', 'ลาเต้', 60, 0, '10644cca5474a0e95a6b902c8074b248d3f98297d293237.png'),
(20, 24, 7, 'กาแฟดำ', 'กาแฟดำ', 55, 0, '10644cca7ae86bbff43e8c44724493587d06bb75bb51915.png'),
(21, 27, 7, 'น้ำส้ม', 'น้ำส้มอร่อยที่สุดในโลก', 35, 0, '1064638cb409fd8125189654_135325081672669_8915418648408975795_n.jpg'),
(22, 27, 7, 'น้ำแครอท', 'น้ำผลไม้เพื่อสุขภาพ', 30, 5, '1064638ce8e2fd9download.jpeg');

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
(84, '20230429163518', 17, 2, 15),
(85, '20230429163518', 18, 2, 12),
(86, '20230429164321', 17, 3, 15),
(93, '20230512123617', 17, 1, 15),
(94, '20230512123617', 18, 1, 12),
(95, '20230516210239', 17, 1, 15),
(96, '20230516210239', 18, 1, 12),
(97, '20230516210239', 19, 1, 60),
(98, '20230516210239', 20, 1, 55),
(99, '20230516210239', 21, 1, 35),
(100, '20230516210239', 22, 1, 25),
(101, '20230516210303', 21, 5, 35),
(102, '20230516210320', 19, 4, 60),
(103, '20230516210320', 20, 6, 55),
(104, '20230516210330', 18, 12, 12),
(105, '20230516210456', 17, 10, 15),
(106, '20230516212725', 21, 9, 35),
(107, '20230516212725', 22, 9, 25);

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
(23, 'น้ำอัดลม'),
(24, 'กาแฟ'),
(25, 'เครื่องดื่มโซดา'),
(26, 'นม'),
(27, 'น้ำผลไม้');

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
  `id_number` varchar(13) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `store` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `status`, `firstname`, `lastname`, `id_number`, `phone`, `address`, `store`, `description`, `img_path`) VALUES
(7, 'user@gmail.com', '$2y$10$BChw6lO9TBNlE0szK7TMoeIXl6GAf3sGDBbq67yv5A0.X9VeNeaL.', 1, 'Nattawat', 'Thungyen', '7897623641259', '0871122211', 'เชียงใหม่', 'BOMPaPerX', 'ขายทุกอย่าง', '106425d46bdff69QR.png'),
(8, 'user2@gmail.com', '$2y$10$eXa/NC96wjdf3JV.xGrR4ubT1wO25f1NocnTaHdap68maRaEW9vzy', 1, 'Wanchana', 'Kaedmun', '1234567891234', '0999999999', 'เชียงราย', 'นายอาม', 'ขายกล้อง', ''),
(9, '1@gmail.com', '$2y$10$PcQkgLevKKo1U4FTeALWa.4PkWHZ4c3mh.wUboF5CmcMvLye0Dxnu', 0, 'Nattawat', 'Thungyen', '1234567891234', '0888888812', 'กรุงเทพมหานคร', '123', '123', '106444fedde2dbcQR.png'),
(10, '62223604@g.cmru.ac.th', '$2y$10$.7cN/Zo.zSnIt.MZ81T9zuShPJM9pXfN4RUQL9Rs8zJWOQFNieXBi', 1, 'Wanchana', 'koedmun', '1234567891234', '0999999999', 'ลำปาง', 'Coffee in Love', '555', '10644e07c5054bb1501_1602_Z62_0571.jpg'),
(11, 'user3@gmail.com', '$2y$10$robgoijtoNPhDxacOvHiHOrrJLPUC2ttHHYWI9XcCvrorVbf/ybAO', 0, 'Nattawat', 'Thungyen', '1234567890123', '0812634568', 'พะเยา', 'รสชาติดี', 'ขายน้ำผลไม้', '10646448d6e6b3bQR.png');

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
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `record_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
