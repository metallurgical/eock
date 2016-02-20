-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2014 at 04:58 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eock`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
`order_id` int(100) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_totalPrice` decimal(10,2) NOT NULL,
  `order_finishDate` date NOT NULL,
  `student_noMatric` int(10) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_phone` int(11) NOT NULL,
  `order_status` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `order_date`, `order_totalPrice`, `order_finishDate`, `student_noMatric`, `student_name`, `student_phone`, `order_status`) VALUES
(2, '2014-12-03 14:59:04', '87.60', '0000-00-00', 2012441023, 'Megat4', 192244551, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`product_id` int(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_priceUnit` decimal(5,2) NOT NULL,
  `product_stock` int(50) NOT NULL,
  `product_status` varchar(50) NOT NULL,
  `staff_id` int(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_category`, `product_priceUnit`, `product_stock`, `product_status`, `staff_id`) VALUES
(2, 'Twisties', 'Food', '1.50', 100, 'Normal', 1),
(3, 'Pilot G Pen', 'Stationary', '5.30', 50, 'Normal', 1),
(4, 'Buku Tulis Kotak Kecil', 'Stationary', '0.60', 50, 'Normal', 1),
(5, '3+1 Pen', 'Stationary', '2.40', 60, 'Normal', 1),
(6, 'Correction Fluid', 'Stationary', '2.30', 50, 'Normal', 1),
(7, 'YOYO Auto Pencil', 'Stationary', '2.30', 50, 'Normal', 1),
(8, 'Stapler', 'Stationary', '5.30', 50, 'Normal', 1),
(9, 'Paper Punch', 'Stationary', '4.80', 50, 'Normal', 1),
(10, 'Plastic Ruler', 'Stationary', '0.50', 50, 'Normal', 1),
(11, 'STABILO Othello / Eraser', 'Stationary', '1.50', 50, 'Normal', 1),
(12, 'Scissor', 'Stationary', '2.50', 50, 'Normal', 1),
(13, 'Choki Choki', 'Food', '0.20', 60, 'Normal', 1),
(14, 'Bika', 'Food', '1.00', 50, 'Normal', 1),
(15, 'Koko Krunch(Big)', 'Food', '5.00', 50, 'Normal', 1),
(16, 'Corn flakes(Big)', 'Food', '5.00', 50, 'Normal', 1),
(17, 'Super Ring(Big)', 'Food', '2.50', 50, 'Normal', 1),
(18, 'Chips More(Big)', 'Food', '2.50', 50, 'Normal', 1),
(19, 'Chickadees(Big)', 'Food', '2.50', 50, 'Normal', 1),
(20, 'Corntoz(Big)', 'Food', '2.50', 50, 'Normal', 1),
(21, 'KitKat', 'Food', '1.50', 50, 'Normal', 1),
(22, 'Botol Air Mineral Cactus 500ml', 'Drinks', '1.00', 100, 'Normal', 1),
(23, 'Tin Pepsi 325ml', 'Drinks', '1.20', 100, 'Normal', 1),
(24, 'Tin Coca Cola 325ml', 'Drinks', '1.20', 100, 'Normal', 1),
(25, 'Tin Kickapoo Joy Juice 325ml', 'Drinks', '1.20', 100, 'Normal', 1),
(26, 'Botol Air Mineral Spritzer 500ml', 'Drinks', '1.00', 100, 'Normal', 1),
(27, 'Botol Mountain Dew 500ml', 'Drinks', '1.50', 100, 'Normal', 1),
(28, 'Tin Soya Bean 325ml', 'Drinks', '1.20', 100, 'Normal', 1),
(29, 'Tin 100PLUS 325ml', 'Drinks', '1.20', 100, 'Normal', 1),
(30, 'Botol Air Mineral Cactus 1500ml', 'Drinks', '2.00', 100, 'Normal', 1),
(31, 'Botol Air Mineral Spritzer 1500ml', 'Drinks', '2.00', 100, 'Normal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE IF NOT EXISTS `product_order` (
`po_id` int(100) NOT NULL,
  `po_quantity` int(100) NOT NULL,
  `po_totalPricePerProduct` decimal(10,2) NOT NULL,
  `product_id` int(100) NOT NULL,
  `order_id` int(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`po_id`, `po_quantity`, `po_totalPricePerProduct`, `product_id`, `order_id`) VALUES
(5, 0, '60.00', 2, 2),
(6, 0, '27.60', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
`staff_id` int(100) NOT NULL,
  `staff_name` varchar(100) DEFAULT NULL,
  `staff_ic` varchar(12) NOT NULL,
  `staff_BOD` date DEFAULT NULL,
  `staff_phone` int(11) DEFAULT NULL,
  `staff_position` varchar(100) DEFAULT NULL,
  `staff_username` varchar(100) NOT NULL,
  `staff_password` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `staff_ic`, `staff_BOD`, `staff_phone`, `staff_position`, `staff_username`, `staff_password`) VALUES
(1, 'Rafz', '060504145041', '2014-11-16', 172990873, 'Boss', 'test', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
 ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`product_id`), ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
 ADD PRIMARY KEY (`po_id`), ADD KEY `order_id` (`order_id`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
 ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
MODIFY `po_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
MODIFY `staff_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON UPDATE CASCADE;

--
-- Constraints for table `product_order`
--
ALTER TABLE `product_order`
ADD CONSTRAINT `product_order_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON UPDATE CASCADE,
ADD CONSTRAINT `product_order_ibfk_4` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
