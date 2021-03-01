-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 01, 2021 at 06:22 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` varchar(5) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `category_number` varchar(15) DEFAULT NULL,
  `writer` varchar(50) DEFAULT NULL,
  `statu` varchar(15) DEFAULT NULL,
  `printed_date` varchar(10) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `reference` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `name`, `category_number`, `writer`, `statu`, `printed_date`, `price`, `reference`) VALUES
('58461', 'Engineering Technology', '620', 'Amila Senadeera', 'book', '2019-04-05', 250, 'no'),
('58462', 'Administration systems', '650', 'Sujith Amarasena', 'book', '2020-01-15', 250, 'no'),
('58463', 'Boda Meedum', '645', 'sujeewa prasannaarachchi', 'book', '03-05-2019', 550, 'no'),
('58464', 'Automobile', '620', 'Pawan Sandeepa', 'book', '2020-01-15', 450, 'no'),
('58465', 'Ira Girawi', '645', 'Champi Kodikara', 'book', '2019-08-07', 250, 'no'),
('58490', 'Pini Pabalu', '645', 'Nipu Madushi', 'book', '2017-08-07', 450, 'no'),
('58492', 'Dedunu', '645', 'Sujeewa Prasanna Arachchi', 'book', '2017-03-04', 560, 'no'),
('58495', 'Electrical engineering', '620', 'Chathura weerasinghe', 'book', '2019-03-10', 460, 'yes'),
('58496', 'new2 book', '650', 'pawan', 'book', '2020-01-15', 250, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `book_id` varchar(5) NOT NULL,
  `member_id` varchar(7) NOT NULL,
  `due_date` date NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`book_id`, `member_id`, `due_date`) VALUES
('58461', 'st095', '2020-04-11'),
('58464', 'st095', '2020-04-11'),
('58462', 'mb08540', '2020-09-19'),
('58495', 'mb08540', '2020-09-20');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_number` varchar(15) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_number`,`category_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_number`, `category_name`) VALUES
('620', 'engineering knowledge'),
('645', 'Novels'),
('650', 'administration');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_book`
--

DROP TABLE IF EXISTS `deleted_book`;
CREATE TABLE IF NOT EXISTS `deleted_book` (
  `id` varchar(5) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `category_number` varchar(15) DEFAULT NULL,
  `writer` varchar(50) DEFAULT NULL,
  `statu` varchar(15) DEFAULT NULL,
  `printed_date` varchar(10) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `reference` varchar(3) NOT NULL,
  `deleted_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deleted_book`
--

INSERT INTO `deleted_book` (`id`, `name`, `category_number`, `writer`, `statu`, `printed_date`, `price`, `reference`, `deleted_date`) VALUES
('58467', 'new book', '650', 'sandeepa', 'book', '2020-01-15', 450, 'no', '2020-06-10');

-- --------------------------------------------------------

--
-- Table structure for table `extend_request`
--

DROP TABLE IF EXISTS `extend_request`;
CREATE TABLE IF NOT EXISTS `extend_request` (
  `extend_type` varchar(20) NOT NULL,
  `member_id` varchar(7) NOT NULL,
  `book_id` varchar(5) NOT NULL,
  PRIMARY KEY (`extend_type`,`member_id`,`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` char(7) NOT NULL,
  `f_name` varchar(20) DEFAULT NULL,
  `l_name` varchar(30) NOT NULL,
  `initials` varchar(15) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `dob` varchar(12) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `phone_mobile` varchar(11) DEFAULT NULL,
  `phone_home` varchar(11) DEFAULT NULL,
  `nic` char(10) DEFAULT NULL,
  `address_of_working` varchar(100) DEFAULT NULL,
  `working_place` varchar(100) DEFAULT NULL,
  `grade` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `registered_date` varchar(12) DEFAULT NULL,
  `caretaker_name` varchar(50) DEFAULT NULL,
  `caretaker_address` varchar(100) DEFAULT NULL,
  `caretaker_nic` char(10) DEFAULT NULL,
  `guarantor_name` varchar(50) DEFAULT NULL,
  `guarantor_address` varchar(100) DEFAULT NULL,
  `guarantor_post` varchar(20) DEFAULT NULL,
  `guarantor_working_place` varchar(100) DEFAULT NULL,
  `count_of_transactions` int(11) NOT NULL DEFAULT 0,
  `mpassword` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `f_name`, `l_name`, `initials`, `address`, `dob`, `gender`, `phone_mobile`, `phone_home`, `nic`, `address_of_working`, `working_place`, `grade`, `email`, `registered_date`, `caretaker_name`, `caretaker_address`, `caretaker_nic`, `guarantor_name`, `guarantor_address`, `guarantor_post`, `guarantor_working_place`, `count_of_transactions`, `mpassword`) VALUES
('mb08540', 'member', 'memberpawan', '', 'matara', '', 'male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 7, '8cb2237d0679ca88db6464eac60da96345513964'),
('mb08541', 'pawanmember', 'sandeepa', '', 'matara', '', 'male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 4, '8cb2237d0679ca88db6464eac60da96345513964'),
('mb08542', 'new', 'member', 'dd', 'matara', '2020-02-04', 'male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '8cb2237d0679ca88db6464eac60da96345513964'),
('mb08545', 'new2', 'member', 'dd', 'matara', '', 'male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '8cb2237d0679ca88db6464eac60da96345513964');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `id` char(5) NOT NULL,
  `f_name` varchar(20) DEFAULT NULL,
  `l_name` varchar(30) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(11) DEFAULT NULL,
  `e_mail` varchar(50) DEFAULT NULL,
  `nic` char(10) DEFAULT NULL,
  `job_position` varchar(20) NOT NULL,
  `spassword` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `f_name`, `l_name`, `address`, `mobile_number`, `e_mail`, `nic`, `job_position`, `spassword`) VALUES
('st096', 'staff', 'staffpawan2', 'efef', '565', 'efeqf', '263', 'assistant', '4fd505f8aeed956f068c4ce57bfc30a6131b7c79'),
('st095', 'staff', 'staffpawan', 'navimana', '0717985631', 'pawan@gmail.com', '953591170v', 'admin', '87e8db4f2338ba69baa1c7d4e60969caf4f06d9e'),
('st097', 'staff', 'member', 'matara', '0717985631', 'ddpawansandeepa@gmail.com', '953591170v', 'assistant', '4fd505f8aeed956f068c4ce57bfc30a6131b7c79');

-- --------------------------------------------------------

--
-- Table structure for table `survey_book`
--

DROP TABLE IF EXISTS `survey_book`;
CREATE TABLE IF NOT EXISTS `survey_book` (
  `id` varchar(5) NOT NULL,
  `model` varchar(10) DEFAULT NULL,
  `state` varchar(15) DEFAULT 'missing',
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_book`
--

INSERT INTO `survey_book` (`id`, `model`, `state`, `description`) VALUES
('58463', 'book', 'transaction', 'member id: mb08541, issued date: 2020-06-09, due date: 2020-06-23'),
('58464', NULL, 'missing', 'transaction returned on: 2020-06-09'),
('58465', NULL, 'here', 'transaction returned on: 2020-06-09'),
('58461', 'book', 'missing', 'member id: mb08540, issued date: 2020-06-09, due date: 2020-06-23'),
('58462', 'book', 'transaction', 'member id: mb08541, issued date: 2020-06-10, due date: 2020-06-24'),
('58492', 'book', 'transaction', 'member id: mb08540, issued date: 2020-08-20, due date: 2020-09-03'),
('58495', 'book', 'here', NULL),
('58496', 'book', 'here', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `book_id` varchar(5) NOT NULL,
  `member_id` char(7) DEFAULT NULL,
  `issued_date` varchar(12) DEFAULT NULL,
  `issued_by` char(5) DEFAULT NULL,
  `due_date` varchar(12) DEFAULT NULL,
  `return_date` varchar(12) DEFAULT 'UNKNOWN',
  `return_to` char(5) DEFAULT 'NO',
  `count_of_transactions` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`book_id`, `member_id`, `issued_date`, `issued_by`, `due_date`, `return_date`, `return_to`, `count_of_transactions`) VALUES
('58464', 'mb08541', '2020-06-09', 'st095', '2020-06-23', '2020-06-09', 'st095', 1),
('58465', 'mb08541', '2020-06-09', 'st095', '2020-06-23', '2020-06-09', 'st095', 3),
('58462', 'mb08541', '2020-06-10', 'st095', '2020-07-08', NULL, NULL, 4),
('58461', 'mb08540', '2020-06-09', 'st095', '2020-07-21', NULL, NULL, 2),
('58492', 'mb08540', '2020-08-20', 'st095', '2020-09-03', NULL, NULL, 0),
('58495', NULL, NULL, NULL, NULL, 'UNKNOWN', 'NO', 0),
('58496', NULL, NULL, NULL, NULL, 'UNKNOWN', 'NO', 0);

DELIMITER $$
--
-- Events
--
DROP EVENT `expire_cart`$$
CREATE DEFINER=`root`@`localhost` EVENT `expire_cart` ON SCHEDULE EVERY 12 HOUR STARTS '2020-03-12 12:08:08' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM test where due_date<=CURDATE()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
