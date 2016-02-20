-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2016 at 04:34 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

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
  `student_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_totalPrice` decimal(10,2) NOT NULL,
  `order_finishDate` date NOT NULL,
  `order_status` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `student_id`, `order_date`, `order_totalPrice`, `order_finishDate`, `order_status`) VALUES
(16, 1, '2016-01-11 21:38:59', '12.00', '0000-00-00', 'PENDING'),
(17, 1, '2016-01-11 22:44:42', '6.00', '0000-00-00', 'PENDING'),
(18, 1, '2016-01-11 22:49:10', '74.40', '0000-00-00', 'PENDING');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_category`, `product_priceUnit`, `product_stock`, `product_status`, `staff_id`) VALUES
(2, 'Nasi Lemak1', 'Food', '6.00', 728, 'Hot Product', 1),
(3, 'Pensel', 'Stationary', '1.20', 186, 'Normal', 1),
(15, 'sadad', 'Drink', '5.00', 0, 'eeee', 1),
(16, 'sadad1', 'Drink', '5.00', 2, 'eeee', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`po_id`, `po_quantity`, `po_totalPricePerProduct`, `product_id`, `order_id`) VALUES
(32, 2, '12.00', 2, 16),
(33, 1, '6.00', 2, 17),
(34, 12, '72.00', 2, 18),
(35, 2, '2.40', 3, 18);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
`service_id` int(5) NOT NULL,
  `student_id` int(5) NOT NULL,
  `service_jabatan` varchar(255) NOT NULL,
  `service_copy` int(5) NOT NULL,
  `service_cat` varchar(50) NOT NULL,
  `service_status` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_files`
--

CREATE TABLE IF NOT EXISTS `service_files` (
`service_file_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `service_file_name` text NOT NULL,
  `service_file_size` varchar(50) NOT NULL,
  `service_file_type` varchar(255) NOT NULL,
  `service_file_content` mediumblob NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `staff_ic`, `staff_BOD`, `staff_phone`, `staff_position`, `staff_username`, `staff_password`) VALUES
(1, 'Jabon2', '060504145041', '2014-11-16', 172990873, 'Boss', 'q', '1'),
(2, 'admin', '123', '2015-12-10', 345, 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
`student_id` int(11) NOT NULL,
  `student_username` varchar(25) NOT NULL,
  `student_password` varchar(25) NOT NULL,
  `student_ic` varchar(25) NOT NULL,
  `student_noMatric` varchar(25) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_phone` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_username`, `student_password`, `student_ic`, `student_noMatric`, `student_name`, `student_phone`) VALUES
(1, 'a', 'a', '34', 'ty', 'er', '456'),
(3, 'qwe', 'asd', '666', 'trt', 'gggg', '6666');

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
-- Indexes for table `services`
--
ALTER TABLE `services`
 ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_files`
--
ALTER TABLE `service_files`
 ADD PRIMARY KEY (`service_file_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
 ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
 ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
MODIFY `po_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
MODIFY `service_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `service_files`
--
ALTER TABLE `service_files`
MODIFY `service_file_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
MODIFY `staff_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
