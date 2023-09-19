-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2023 at 08:37 PM
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
(2, 'admin2@gmail.com', '$2y$10$JD55ly5EDvk6DaKlIp1m8Ovc4Qza1TCl2/jntfTnNn9vLQ.GRuj8O', '123456', 0, 'Wanchana', 'Koedmun');

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
(72, 15, '2023-07-19', ''),
(73, 15, '2023-08-19', '1.jpg'),
(74, 15, '2023-09-19', ''),
(75, 16, '2023-08-09', ''),
(76, 16, '2023-09-20', ''),
(77, 17, '2023-09-20', '');

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
('20230920002931', 1, '2023-07-06 17:29:31', 1),
('20230920002943', 1, '2023-07-06 17:30:00', 1),
('20230920004531', 0, '2023-07-07 17:48:18', 1),
('20230920004540', 0, '2023-07-07 17:48:28', 1),
('20230920004557', 0, '2023-07-07 18:00:00', 1),
('20230920004949', 1, '2023-07-08 17:49:49', 1),
('20230920005036', 1, '2023-07-08 17:50:36', 1),
('20230920005217', 0, '2023-08-15 17:52:17', 1),
('20230920005225', 1, '2023-08-16 17:53:43', 1),
('20230920005237', 1, '2023-08-17 17:53:50', 1),
('20230920005609', 0, '2023-09-18 17:56:09', 1),
('20230920005616', 0, '2023-09-18 17:56:16', 1),
('20230920005625', 1, '2023-09-18 17:56:25', 1),
('20230920005740', 1, '2023-09-19 17:57:40', 1),
('20230920005818', 1, '2023-09-19 17:58:18', 1),
('20230920005827', 0, '2023-09-19 17:58:27', 1),
('20230920011102', 1, '2023-08-19 18:11:02', 1),
('20230920011201', 1, '2023-08-20 18:12:01', 1),
('20230920011217', 0, '2023-08-21 18:12:17', 1),
('20230920011254', 1, '2023-09-18 18:12:54', 1),
('20230920011303', 1, '2023-09-18 18:14:08', 1),
('20230920011314', 1, '2023-09-18 19:00:00', 1),
('20230920011456', 1, '2023-09-19 18:14:56', 1),
('20230920011504', 1, '2023-09-19 18:15:04', 1),
('20230920011509', 0, '2023-09-19 18:15:09', 1),
('20230920011517', 0, '2023-09-19 18:15:17', 1),
('20230920012255', 1, '2023-08-31 18:22:55', 1),
('20230920012344', 0, '2023-09-01 18:23:44', 1),
('20230920012842', 1, '2023-09-19 18:28:42', 1);

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
  `price` float NOT NULL,
  `img_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `type_id`, `user_id`, `name`, `description`, `price`, `img_path`) VALUES
(28, 29, 15, 'เอสเพรสโซ', 'เอสเพรสโซ', 90, '106509d454aa6e4Espresso-2.jpg'),
(29, 29, 15, 'อเมริกาโน', 'อเมริกาโน', 80, '106509d46fa668eAmericano-2.jpg'),
(30, 29, 15, 'มอคค่า', 'มอคค่า', 80, '106509d4984e43aMocca-1.jpg'),
(31, 29, 15, 'ลาเต้', 'ลาเต้', 85, '106509d4b01fe5fLatte.jpg'),
(32, 29, 15, 'คาปูชิโน', 'คาปูชิโน', 85, '106509d51fc92cbCappuccino.jpg'),
(33, 29, 15, 'มัคคิอาโต', 'มัคคิอาโต', 90, '106509d53f9ade0Macchiato.jpg'),
(34, 29, 15, 'กาแฟโบราณ', 'กาแฟโบราณ', 40, '106509d5d78135cThai-Coffee.jpg'),
(35, 29, 15, 'เฟร้บเป้', 'เฟร้บเป้', 110, '106509d5f033a5fFrappe.jpg'),
(36, 29, 15, 'อัฟโฟกาโต', 'อัฟโฟกาโต', 120, '106509d63aabe71Affogato.jpg'),
(37, 29, 15, 'อเมริกาโนน้ำส้ม', 'อเมริกาโนน้ำส้ม', 95, '106509d656b5301Orange-Juice-Americano.jpg'),
(38, 29, 15, 'อเมริกาโนน้ำผึ้ง', 'อเมริกาโนน้ำผึ้ง', 115, '106509d6703d858Honey-Americano.jpg'),
(39, 29, 15, 'อเมริกาโนน้ำมะพร้าว', 'อเมริกาโนน้ำมะพร้าว', 120, '106509d6a8d05f8Coconut-Americano.jpg'),
(40, 31, 16, 'โค้กกระป๋อง', 'โค้กกระป๋อง', 15, '106509e34e162dfasdf.jpeg'),
(41, 31, 16, 'โค้ก 1.25 ml', 'โค้ก 1.25 ml', 30, '106509e389655188851959149010_1-20221207171555-.jpg'),
(42, 36, 16, 'แลคตาซอย 300 ml', 'แลคตาซอย 300 ml', 12, '106509e3b6af268300_main_2021_update.jpg'),
(43, 36, 16, 'โอวันติน 180 ml', 'โอวันติน 180 ml', 10, '106509e3eb1256ebase-uht.png'),
(44, 36, 16, 'ไมโล', 'ไมโล', 10, '106509e40b1c3bfThumb-Product-01-UHT-Regular_0.jpg'),
(45, 32, 17, 'น้ำส้ม', 'น้ำส้มคั้นสด', 25, '106509e82d96e8e125189654_135325081672669_8915418648408975795_n.jpg'),
(46, 32, 17, 'น้ำแครอท', 'น้ำแครอทคั้นสด', 25, '106509e84b90de5download.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `record_id` int(10) NOT NULL,
  `no_receipt` varchar(255) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `net_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`record_id`, `no_receipt`, `product_id`, `quantity`, `net_price`) VALUES
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
(145, '20230828101628', 17, 6, 15),
(146, '20230828103008', 17, 5, 15),
(147, '20230828103008', 18, 2, 12),
(148, '20230829122753', 18, 2, 12),
(149, '20230831134143', 17, 1, 15),
(150, '20230909162502', 21, 3, 35),
(151, '20230909162525', 22, 1, 30),
(152, '20230919163643', 17, 10, 15),
(153, '20230920002931', 28, 1, 90),
(154, '20230920002943', 29, 2, 80),
(155, '20230920004531', 29, 2, 80),
(156, '20230920004531', 31, 1, 85),
(157, '20230920004540', 39, 1, 120),
(158, '20230920004557', 35, 2, 110),
(159, '20230920004557', 37, 1, 95),
(160, '20230920004949', 32, 1, 85),
(161, '20230920004949', 33, 1, 90),
(162, '20230920004949', 34, 1, 40),
(163, '20230920004949', 36, 1, 120),
(164, '20230920005036', 28, 1, 90),
(165, '20230920005036', 29, 1, 80),
(166, '20230920005036', 30, 1, 80),
(167, '20230920005036', 31, 1, 85),
(168, '20230920005036', 32, 1, 85),
(169, '20230920005217', 35, 2, 110),
(170, '20230920005225', 37, 4, 95),
(171, '20230920005237', 29, 1, 80),
(172, '20230920005237', 31, 1, 85),
(173, '20230920005609', 28, 2, 90),
(174, '20230920005609', 29, 2, 80),
(175, '20230920005609', 30, 1, 80),
(176, '20230920005616', 29, 1, 80),
(177, '20230920005625', 31, 2, 85),
(178, '20230920005740', 32, 2, 85),
(179, '20230920005818', 31, 1, 85),
(180, '20230920005818', 32, 1, 85),
(181, '20230920005827', 31, 1, 85),
(182, '20230920005827', 33, 1, 90),
(183, '20230920011102', 40, 12, 15),
(184, '20230920011201', 40, 3, 15),
(185, '20230920011201', 41, 3, 30),
(186, '20230920011217', 42, 5, 12),
(187, '20230920011217', 43, 5, 10),
(188, '20230920011217', 44, 5, 10),
(189, '20230920011254', 40, 2, 15),
(190, '20230920011303', 41, 1, 30),
(191, '20230920011314', 42, 6, 12),
(192, '20230920011456', 40, 20, 15),
(193, '20230920011504', 41, 2, 30),
(194, '20230920011509', 43, 1, 10),
(195, '20230920011517', 42, 1, 12),
(196, '20230920012255', 31, 1, 85),
(197, '20230920012255', 32, 2, 85),
(198, '20230920012344', 29, 5, 80),
(199, '20230920012842', 45, 4, 25),
(200, '20230920012842', 46, 1, 25);

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
(29, 'กาแฟ'),
(31, 'น้ำอัดลม'),
(32, 'น้ำผลไม้'),
(33, 'น้ำ'),
(34, 'ชา'),
(35, 'โซดา'),
(36, 'นม'),
(37, 'แอลกอฮอล์');

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
(15, 'user@gmail.com', '$2y$10$qBHeM7QXCPSiDBlhcDIB1OZbv0mLrXAUPvZ/B4epMACNbvHyF0Dmm', '123456', 1, 1, 'ดาวิกา', 'โฮร์เน่', '1111111111111', '0953221388', 'mai_davika', '10 ม.5 ต.สุเทพ อ.เมือง จ.เชียงใหม่ 50200', 'davikah coffee', 'ร้านกาแฟสดของใหม่ดาวิกา เมล็ดกาแฟนำเข้าจากต่างประเทศ', '106509cc683ceb4QR.png'),
(16, 'user2@gmail.com', '$2y$10$0NvbmvnFBGwWxk8pf8FohumIe8xdukRmHN/0H8ubc6HlR4APj.8HS', '123456', 1, 1, 'มาริโอ้', 'เมาเร่อ', '2222222222222', '0945645342', 'mario', '12 ม.10 ต.สุเทพ อ.เมือง จ.เชียงใหม่ 50200', 'มาริโอ้ ขายเครื่องดื่ม', 'ขายเครื่องดื่มทั่วไป', '106509e2829aa5dQR.png'),
(17, 'user3@gmail.com', '$2y$10$xduZ2J4Vd9TfxD8vdn1td.52vFjRt5DaV.gZWzJcYbXNV.fTlhyjK', '123456', 1, 1, 'ณวัฒน์', 'กุลรัตนรักษ์', '3333333333333', '0854453453', 'pong_nawat', '75 ม.1 ต.สุเทพ อ.เมือง จ.เชียงใหม่ 50200', 'ป้อง น้ำผลไม้สด', 'น้ำผลไม้สดๆจากสวน', '106509e5f77936bQR.png'),
(18, 'user4@gmail.com', '$2y$10$FM.w9MxA7Pm84m4nVZ061OgN3IlunKfgWMZuyk4mMBz/tcJik7xEq', '123456', 0, 0, '', '', '', '', '', '', '', '', ''),
(19, 'user5@gmail.com', '$2y$10$cD3vjymL6kZrHSajKOy5euPLs9HyVRbpiLeYJcatszKvAcU7X8vpm', '123456', 0, 0, '', '', '', '', '', '', '', '', '');

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
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `record_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
