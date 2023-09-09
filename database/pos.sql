-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2023 at 11:29 AM
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
  `password_view` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `password_view`, `status`, `firstname`, `lastname`) VALUES
(1, 'admin@gmail.com', '$2y$10$bilVP71iW.IFnzkR/ncYzOuYReIYNedKZ4KcMKgKtgLpsE.5mHwDe', '123456', 1, 'Nattawat', 'Thungyen'),
(2, 'admin2@gmail.com', '$2y$10$JD55ly5EDvk6DaKlIp1m8Ovc4Qza1TCl2/jntfTnNn9vLQ.GRuj8O', '123456', 0, 'Wanchana', 'Kaedmun');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `approve_date` date NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `user_id`, `approve_date`, `img_path`) VALUES
(21, 7, '2023-03-22', ''),
(25, 7, '2023-04-22', '10646dd00d0b0931.jpg'),
(29, 8, '2023-05-02', ''),
(34, 8, '2023-06-22', ''),
(42, 9, '2023-03-22', ''),
(43, 9, '2023-04-22', '10646dca528289b125189654_135325081672669_8915418648408975795_n.jpg'),
(44, 7, '2023-05-25', '1064e1c5aab39c4p4.jpg'),
(56, 10, '2023-05-25', ''),
(61, 12, '2023-03-23', ''),
(62, 12, '2023-04-25', '1064745c090eec11.jpg'),
(63, 12, '2023-05-29', ''),
(65, 7, '2023-07-29', '1064ec180ccfbd0cashbill.jpeg'),
(67, 7, '2023-08-29', ''),
(69, 11, '2023-08-29', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `no_receipt` varchar(255) NOT NULL,
  `method` tinyint(1) NOT NULL COMMENT '0=cash\r\n1=qrcode',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`no_receipt`, `method`, `timestamp`, `status`) VALUES
('20230429163518', 1, '2023-04-29 09:35:18', 0),
('20230429164321', 0, '2023-04-29 09:43:21', 0),
('20230512123617', 1, '2023-05-12 05:36:17', 0),
('20230516210239', 1, '2023-05-16 14:02:39', 0),
('20230516210303', 0, '2023-05-16 14:03:03', 0),
('20230516210320', 0, '2023-05-16 14:03:20', 0),
('20230516210330', 0, '2023-05-16 14:03:30', 0),
('20230516210456', 1, '2023-05-16 14:04:56', 0),
('20230516212725', 0, '2023-05-16 14:27:25', 0),
('20230521231932', 1, '2023-05-21 16:19:32', 0),
('20230525153305', 1, '2023-05-25 08:33:05', 1),
('20230525234025', 0, '2023-05-25 16:40:25', 0),
('20230529161343', 0, '2023-05-29 09:13:43', 0),
('20230529161413', 1, '2023-05-29 09:14:13', 0),
('20230529171926', 1, '2023-05-29 10:19:26', 0),
('20230529171955', 1, '2023-05-29 10:19:55', 0),
('20230529172252', 0, '2023-05-29 10:22:52', 0),
('20230529172309', 0, '2023-05-29 10:23:09', 0),
('20230529172359', 0, '2023-05-29 10:23:59', 1),
('20230529172754', 1, '2023-05-29 10:27:54', 0),
('20230531165547', 1, '2023-05-31 09:55:47', 0),
('20230531165954', 0, '2023-05-31 09:59:54', 0),
('20230612005559', 0, '2023-06-11 17:55:59', 1),
('20230629170827', 0, '2023-06-29 10:08:27', 1),
('20230705151323', 1, '2023-07-05 08:13:23', 1),
('20230705151335', 0, '2023-07-05 08:13:35', 0),
('20230820145200', 1, '2023-08-20 07:52:00', 1),
('20230820162708', 0, '2023-08-20 09:27:08', 0),
('20230820162747', 1, '2023-08-20 09:27:47', 0),
('20230828101628', 1, '2023-08-28 03:16:28', 0),
('20230828103008', 1, '2023-08-28 03:30:08', 0),
('20230829122753', 1, '2023-08-29 05:27:53', 0),
('20230831134143', 1, '2023-08-31 06:41:43', 0),
('20230909162502', 0, '2023-09-09 09:25:02', 1),
('20230909162525', 1, '2023-09-09 09:25:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `price` int(10) NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `type_id`, `user_id`, `name`, `description`, `price`, `img_path`) VALUES
(17, 23, 7, 'โค้ก', 'โค้ก', 15, '10644cc946558778851959149010_1-20221207171555-.jpg'),
(18, 26, 7, 'นมตราหมี', 'นมตราหมี', 12, '10644cc9b4f38c3BB-Product-shot-01.png'),
(19, 24, 7, 'ลาเต้', 'ลาเต้', 60, '10644cca5474a0e95a6b902c8074b248d3f98297d293237.png'),
(20, 24, 7, 'กาแฟดำ', 'กาแฟดำ', 55, '10644cca7ae86bbff43e8c44724493587d06bb75bb51915.png'),
(21, 27, 7, 'น้ำส้ม', 'น้ำส้มอร่อยที่สุดในโลก', 35, '1064638cb409fd8125189654_135325081672669_8915418648408975795_n.jpg'),
(22, 27, 7, 'น้ำแครอท', 'น้ำผลไม้เพื่อสุขภาพ', 30, '1064638ce8e2fd9download.jpeg');

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
(107, '20230516212725', 22, 9, 25),
(108, '20230521231932', 17, 1, 15),
(109, '20230521231932', 18, 1, 12),
(110, '20230525153305', 21, 1, 35),
(111, '20230525153305', 22, 1, 25),
(112, '20230525234025', 17, 1, 15),
(113, '20230525234025', 18, 1, 12),
(114, '20230525234025', 19, 1, 60),
(115, '20230525234025', 20, 1, 55),
(116, '20230525234025', 21, 1, 35),
(117, '20230525234025', 22, 1, 25),
(118, '20230529161343', 17, 1, 15),
(119, '20230529161413', 17, 1, 15),
(120, '20230529171926', 17, 4, 15),
(121, '20230529171955', 19, 5, 60),
(122, '20230529172252', 21, 2, 35),
(123, '20230529172309', 22, 1, 25),
(124, '20230529172359', 18, 2, 12),
(125, '20230529172754', 17, 1, 15),
(126, '20230531165547', 17, 1, 15),
(127, '20230531165954', 18, 1, 12),
(128, '20230612005559', 21, 1, 35),
(129, '20230629170827', 17, 1, 15),
(130, '20230705151323', 17, 1, 15),
(131, '20230705151323', 18, 1, 12),
(132, '20230705151323', 19, 1, 60),
(133, '20230705151323', 20, 1, 55),
(134, '20230705151323', 21, 1, 35),
(135, '20230705151323', 22, 1, 25),
(136, '20230705151335', 17, 5, 15),
(137, '20230820145200', 17, 100, 15),
(138, '20230820145200', 18, 100, 12),
(139, '20230820145200', 19, 100, 60),
(140, '20230820145200', 20, 100, 55),
(141, '20230820145200', 21, 100, 35),
(142, '20230820145200', 22, 100, 25),
(143, '20230820162708', 21, 1, 35),
(144, '20230820162747', 21, 1, 35),
(145, '20230828101628', 17, 6, 15),
(146, '20230828103008', 17, 5, 15),
(147, '20230828103008', 18, 2, 12),
(148, '20230829122753', 18, 2, 12),
(149, '20230831134143', 17, 1, 15),
(150, '20230909162502', 21, 3, 35),
(151, '20230909162525', 22, 1, 30);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(10) NOT NULL,
  `admin_id` int(10) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `admin_id`, `type`) VALUES
(23, 1, 'น้ำอัดลม'),
(24, 1, 'กาแฟ'),
(25, 1, 'เครื่องดื่มโซดา'),
(26, 1, 'นม'),
(27, 1, 'น้ำผลไม้'),
(28, 0, 'เบียร์');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_view` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0=disable\r\n1=enable',
  `agree` tinyint(1) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `id_number` varchar(13) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `line` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `store` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `password_view`, `status`, `agree`, `firstname`, `lastname`, `id_number`, `phone`, `line`, `address`, `store`, `description`, `img_path`) VALUES
(7, 'user@gmail.com', '$2y$10$RrDdRV9KCJMm/0rroiNuruEayTgDKo3X.oQuKC2ghYUnWrB0FzWO2', '123456', 1, 1, 'Nattawat', 'Thungyen', '7897623641259', '0871122211', 'id line', '10 ม.1 ต.สุเทพ อ.เมือง จ.เชียงใหม่ 50200', 'BOMPaPerX', 'ขายทุกอย่าง', '106425d46bdff69QR.png'),
(8, 'user2@gmail.com', '$2y$10$eXa/NC96wjdf3JV.xGrR4ubT1wO25f1NocnTaHdap68maRaEW9vzy', '123456', 0, 1, 'Wanchana', 'Kaedmun', '1234567891234', '0999999999', 'id line', 'เชียงราย', 'นายอาม', 'ขายกล้อง', ''),
(9, '1@gmail.com', '$2y$10$PcQkgLevKKo1U4FTeALWa.4PkWHZ4c3mh.wUboF5CmcMvLye0Dxnu', '123456', 0, 1, 'Nattawat', 'Thungyen', '1234567891234', '0888888812', 'id line', 'กรุงเทพมหานคร', '123', '123', '10646cfb9d5bc60download.jpeg'),
(10, '62223604@g.cmru.ac.th', '$2y$10$.7cN/Zo.zSnIt.MZ81T9zuShPJM9pXfN4RUQL9Rs8zJWOQFNieXBi', '123456', 0, 0, 'Wanchana', 'koedmun', '1234567891234', '0999999999', 'id line', 'ลำปาง', 'Coffee in Love', '555', '10644e07c5054bb1501_1602_Z62_0571.jpg'),
(11, 'user3@gmail.com', '$2y$10$robgoijtoNPhDxacOvHiHOrrJLPUC2ttHHYWI9XcCvrorVbf/ybAO', '123456', 1, 1, 'Nattawat', 'Thungyen', '1234567890123', '0812634568', 'id line 555', 'พะเยา', 'รสชาติดี', 'ขายน้ำผลไม้', '10646448d6e6b3bQR.png'),
(12, 'user4@gmail.com', '$2y$10$PR6c2c49Co.YmUhM73JvD.mx.HYkce8Imax2fAMigxCo0VowKn2Ae', '123456', 0, 1, 'nutthicha', 'taname', '1111111111111', '0999999999', 'prang', '10 ม.3 ต.สุเทพ อ.เมือง จ.เชียงใหม่ 50200', 'Shopee', 'ขายของ 1 บาท', '10646f8b2e88875QR.png'),
(13, 'user5@gmail.com', '$2y$10$Fn5kJY0McLlslhPAgbB5Cu3v3/lDjemjnRRGPvPq2GCW3SzMdaV0W', '123456', 0, 0, '', '', '', '', '', '', '', '', ''),
(14, '2@gmil.com', '$2y$10$oTS0SyOW1UrYdMv0vlfbku5Sr1zU9JtT/KirbY1YFu4O8D.Z3x9uO', '123456', 0, 0, '', '', '', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`no_receipt`);

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
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `record_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
