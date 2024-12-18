-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2024 at 03:34 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baochaumobile`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `User_id` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `Role` tinyint NOT NULL,
  `Status` tinyint NOT NULL,
  PRIMARY KEY (`User_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`User_id`, `Username`, `Password`, `Role`, `Status`) VALUES
(1, 'admin1', 'e10adc3949ba59abbe56e057f20f883e', 3, 1),
(2, 'Admin3', 'e10adc3949ba59abbe56e057f20f883e', 1, 1),
(3, 'Admin2', 'e10adc3949ba59abbe56e057f20f883e', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

DROP TABLE IF EXISTS `catalog`;
CREATE TABLE IF NOT EXISTS `catalog` (
  `Catalog_id` int NOT NULL AUTO_INCREMENT,
  `Name_catalog` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Parent_id` int NOT NULL,
  `Sort_order` tinyint NOT NULL,
  `Status` tinyint NOT NULL,
  PRIMARY KEY (`Catalog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catalog`
--

INSERT INTO `catalog` (`Catalog_id`, `Name_catalog`, `Parent_id`, `Sort_order`, `Status`) VALUES
(1, 'Iphone', 0, 1, 1),
(2, 'HuaWei', 0, 2, 1),
(3, 'LG', 0, 3, 1),
(4, 'Pixel', 0, 4, 1),
(5, 'Sony', 0, 5, 1),
(6, 'Samsung', 0, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `Customer_id` int NOT NULL AUTO_INCREMENT,
  `Name_customer` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` tinyint NOT NULL,
  PRIMARY KEY (`Customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_id`, `Name_customer`, `Email`, `Phone`, `Status`) VALUES
(1, 'Hà Thị Mỹ Châu', 'mychau@gmail.com', '0984095418', 0),
(2, 'Nguyễn Hoàng Bảo', 'Hoangbao@gmail.com', '0901555423', 1),
(10, 'Nguyễn Hoàng Liên', 'HoangLien@gmail.com', '0394949891', 0);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `History_Id` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Action` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Timee` int NOT NULL,
  PRIMARY KEY (`History_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`History_Id`, `Username`, `Action`, `Timee`) VALUES
(224, 'admin1', 'Xóa Customer: 8', 1734100303),
(223, 'admin1', 'Thêm mới Khách hàng: Nguyễn Hoàng Liên', 1734100136),
(222, 'admin1', 'Sửa sản phẩm: SONNY RENO F9', 1734099703),
(221, 'admin1', 'Đăng nhập', 1734029296),
(220, 'admin1', 'Đăng xuất', 1734029280),
(219, 'admin1', 'Đăng nhập', 1734029274),
(217, 'admin1', 'Xóa User: 62', 1734027671),
(218, 'admin1', 'Đăng nhập', 1734028060),
(189, 'admin1', 'Đăng nhập', 1734015259),
(190, 'admin1', 'Sửa sản phẩm: SAMSUNG GALAXY FOLD ', 1734015676),
(191, 'admin1', 'Xóa sản phẩm: 8', 1734015699),
(192, 'admin1', 'Đăng nhập', 1734016205),
(193, 'admin1', 'Đăng nhập', 1734016993),
(194, 'admin1', 'Đăng nhập', 1734017257),
(195, 'admin1', 'Sửa sản phẩm: SAMSUNG GALAXY FOLD ', 1734017267),
(196, 'admin1', 'Sửa sản phẩm: SAMSUNG GALAXY FOLD ', 1734017293),
(197, 'admin1', 'Sửa sản phẩm: LG G8 THIN', 1734017831),
(198, 'admin1', 'Xóa sản phẩm: 22', 1734017893),
(199, 'admin1', 'Thêm mới sản phẩm: JonnyPROMAX', 1734018882),
(200, 'admin1', 'Xóa sản phẩm: 25', 1734018930),
(201, 'admin1', 'Thêm mới sản phẩm: JonnyPROMAX', 1734018991),
(202, 'admin1', 'Sửa sản phẩm: JonnyPROMAX', 1734019019),
(203, 'admin1', 'Xóa sản phẩm: 26', 1734019330),
(204, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP 333', 1734019568),
(205, 'admin1', 'Đăng nhập', 1734019597),
(206, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP 333555', 1734020093),
(207, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP 333555', 1734020129),
(208, 'admin1', 'Thêm mới sản phẩm: Jonny promax', 1734020260),
(209, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP ', 1734020597),
(210, 'admin1', 'Xóa sản phẩm: 27', 1734020619),
(211, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP ', 1734020636),
(212, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP ', 1734020654),
(213, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP ', 1734020664),
(214, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP 333', 1734027054),
(215, 'admin1', 'Sửa sản phẩm: SAMSUNG Z-FLIP', 1734027061),
(216, 'admin1', 'Thêm mới sản phẩm: OPPO RENO F9', 1734027401),
(225, 'admin1', 'Thêm mới Khách hàng: Nguyễn Hoàng Liên', 1734100310),
(226, 'admin1', 'Xóa Customer: 9', 1734100317),
(227, 'admin1', 'Thêm mới Khách hàng: Nguyễn Hoàng Liên', 1734100322),
(228, 'admin1', 'Xóa User: 65', 1734101176),
(229, 'admin1', 'Xóa User: 61', 1734101179),
(230, 'admin1', 'Xóa User: 66', 1734101541),
(231, 'admin1', 'Xóa User: 12', 1734101544),
(232, 'admin1', 'Đăng nhập', 1734108741),
(233, 'hoangbao1', 'Đăng xuất', 1734108945),
(234, 'admin1', 'Đăng nhập', 1734108955),
(235, 'admin1', 'Đăng nhập', 1734108992),
(236, 'admin1', 'Đăng nhập', 1734109922),
(237, 'admin1', 'Đăng nhập', 1734110255),
(238, 'admin1', 'Đăng nhập', 1734150839),
(239, 'admin1', 'Đăng nhập', 1734150967),
(240, 'admin1', 'Đăng nhập', 1734151463),
(241, 'admin1', 'Đăng nhập', 1734151590),
(242, 'admin1', 'Xóa sản phẩm: 28', 1734151595),
(243, 'admin1', 'Đăng nhập', 1734151831),
(244, 'admin1', 'Đăng xuất', 1734151901),
(245, 'admin1', 'Đăng nhập', 1734155128);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `Manufacturer_id` int NOT NULL AUTO_INCREMENT,
  `Name_manufacturer` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` tinyint NOT NULL,
  PRIMARY KEY (`Manufacturer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`Manufacturer_id`, `Name_manufacturer`, `Status`) VALUES
(1, 'APPLE', 1),
(2, 'SAMSUNG', 1),
(3, 'LG', 1),
(4, 'SONY', 1),
(5, 'PIXEL', 1),
(6, 'HUAWEI', 0),
(7, 'VIVO', 1),
(8, 'OPPO', 0);

-- --------------------------------------------------------

--
-- Table structure for table `oderdetail`
--

DROP TABLE IF EXISTS `oderdetail`;
CREATE TABLE IF NOT EXISTS `oderdetail` (
  `OrderDetail_id` int NOT NULL AUTO_INCREMENT,
  `Order_id` int NOT NULL,
  `Product_id` int NOT NULL,
  `Price` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Quantity` int NOT NULL,
  `Status` tinyint NOT NULL,
  PRIMARY KEY (`OrderDetail_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oderdetail`
--

INSERT INTO `oderdetail` (`OrderDetail_id`, `Order_id`, `Product_id`, `Price`, `Quantity`, `Status`) VALUES
(1, 0, 15, '22980', 2, 0),
(2, 0, 15, '22980', 2, 0),
(3, 2, 15, '13990', 1, 0),
(4, 0, 15, '22980', 2, 0),
(5, 4, 15, '13990', 1, 0),
(6, 0, 15, '22980', 2, 0),
(7, 6, 15, '13990', 1, 0),
(8, 0, 15, '22980', 2, 0),
(9, 8, 15, '13990', 1, 0),
(10, 0, 6, '13470', 3, 0),
(11, 0, 14, '13999', 1, 0),
(12, 11, 14, '50998', 2, 0),
(13, 12, 14, '29970', 3, 0),
(14, 13, 14, '4490', 1, 0),
(15, 0, 14, '139990', 10, 0),
(16, 15, 14, '254990', 10, 0),
(17, 0, 14, '139990', 10, 0),
(18, 17, 14, '254990', 10, 0),
(19, 0, 14, '139990', 10, 0),
(20, 19, 14, '254990', 10, 0),
(21, 0, 14, '139990', 10, 0),
(22, 21, 14, '254990', 10, 0),
(23, 0, 14, '139990', 10, 0),
(24, 23, 14, '254990', 10, 0),
(25, 0, 14, '139990', 10, 0),
(26, 25, 14, '254990', 10, 0),
(27, 0, 19, '11490', 1, 0),
(28, 0, 19, '80430', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderproduct`
--

DROP TABLE IF EXISTS `orderproduct`;
CREATE TABLE IF NOT EXISTS `orderproduct` (
  `Order_id` int NOT NULL AUTO_INCREMENT,
  `Customer_id` int NOT NULL,
  `OrderDetail_id` int NOT NULL,
  `Timee` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `PriceAll` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` tinyint NOT NULL,
  PRIMARY KEY (`Order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderproduct`
--

INSERT INTO `orderproduct` (`Order_id`, `Customer_id`, `OrderDetail_id`, `Timee`, `PriceAll`, `Status`) VALUES
(6, 1, 26, '1499831646', '394980', 0),
(8, 2, 28, '1502779094', '80430', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Product_id` int NOT NULL AUTO_INCREMENT,
  `Manufacturer_id` int NOT NULL,
  `Ten_sp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Anh_sp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Gia_sp` int NOT NULL,
  `Bao_hanh` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Phu_kien` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Trang_thai` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Tinh_trang` tinyint NOT NULL,
  `Status` tinyint NOT NULL,
  PRIMARY KEY (`Product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_id`, `Manufacturer_id`, `Ten_sp`, `Anh_sp`, `Gia_sp`, `Bao_hanh`, `Phu_kien`, `Trang_thai`, `Tinh_trang`, `Status`) VALUES
(9, 6, ' HUAWEI NOVA 12', 'HUAWEI2.jpg', 2999, '12 tháng', 'Full box', 'New', 1, 1),
(16, 6, 'HUAWEI P9', 'HUAWEI3.jpg', 20490, '12 tháng', 'Full box', 'New', 1, 1),
(18, 1, 'IPHONE 16 PROMAX', 'iphone1.jpg', 12990, '12 tháng', 'Full box', 'Like new 99%', 1, 1),
(19, 1, 'IPHONE 14 PRO ', 'iphone2.jpg', 11490, '12 tháng', 'Full box', 'New', 1, 1),
(20, 1, 'IPHONE XS MAX', 'iphone3.jpg', 13999, '12 tháng', 'Full box', 'New', 1, 1),
(21, 3, 'LG STYLO 6', 'LG1.jpg', 31499, '12 tháng', 'Full box', 'New', 1, 1),
(23, 1, 'SAMSUNG GALAXY FOLD ', 'samsung4.jpg', 35999, '12 tháng', 'Full box', 'New', 1, 1),
(24, 2, 'SAMSUNG Z-FLIP', 'samsung2.jpg', 18799, '12 tháng', 'Full box', 'New', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `Role_id` int NOT NULL AUTO_INCREMENT,
  `Name_role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Role_id`, `Name_role`) VALUES
(1, 'Editer'),
(2, 'Admin'),
(3, 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `FullName` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Role` enum('user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `Status` enum('active','inactive') COLLATE utf8mb4_general_ci DEFAULT 'active',
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_logged_in` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Email`, `FullName`, `Role`, `Status`, `CreatedAt`, `is_logged_in`) VALUES
(1, 'mychau', '$2y$10$y1XWLfoJKtoUmgxbG3H7T.3s8zedfCDzO8Lgw5q4QmEBgjUpFIziO', 'chau28400@gmail.com', 'Ha Chau', 'user', 'active', '2024-12-13 07:53:01', 1),
(2, 'hoangbao1', '$2y$10$YyOCKDGfP3HzoqvuJ9xPFORKGSvr7iPlfZmqeqpRlIY2DsSKlDpfy', 'hoangbao@gmail.com', 'Hoang Bao Nguyen', 'user', 'active', '2024-12-13 09:54:15', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
