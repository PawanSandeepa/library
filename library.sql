-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 05, 2020 at 01:37 AM
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
('58461', 'bookpawan', '620', 'sandeepa', 'book', '2019-04-05', 250, 'no'),
('58462', 'bookpawan2', '650', 'dayananda', 'book', '2019-08-07', 550, 'no'),
('58463', 'newbook', '620', 'sujeewaprasannaarachchi', 'book', '03-05-2019', 550, 'no');

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
('650', 'administration');

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
  `mpassword` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `f_name`, `l_name`, `initials`, `address`, `dob`, `gender`, `phone_mobile`, `phone_home`, `nic`, `address_of_working`, `working_place`, `grade`, `email`, `registered_date`, `caretaker_name`, `caretaker_address`, `caretaker_nic`, `guarantor_name`, `guarantor_address`, `guarantor_post`, `guarantor_working_place`, `mpassword`) VALUES
('mb08540', 'member', 'memberpawan', '', 'matara', '', 'male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '8cb2237d0679ca88db6464eac60da96345513964'),
('mb08541', 'pawanmember', 'sandeepa', '', 'matara', '', 'male', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '8cb2237d0679ca88db6464eac60da96345513964');

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
('st095', 'staff', 'staffpawan', 'navimana', '0717985631', 'pawan@gmail.com', '953591170v', 'admin', '87e8db4f2338ba69baa1c7d4e60969caf4f06d9e');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `member_id` char(7) NOT NULL,
  `book_id` varchar(5) NOT NULL,
  `issued_date` varchar(12) NOT NULL,
  `issued_by` char(5) NOT NULL,
  `due_date` varchar(12) NOT NULL,
  `return_date` varchar(12) DEFAULT NULL,
  `return_to` char(5) DEFAULT NULL,
  PRIMARY KEY (`member_id`,`book_id`,`issued_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`member_id`, `book_id`, `issued_date`, `issued_by`, `due_date`, `return_date`, `return_to`) VALUES
('mb08540', '58461', '2020-02-06', 'st095', '2020-02-20', NULL, NULL),
('mb08540', '58462', '2020-02-06', 'st095', '2020-02-20', '2020-02-07', 'st095'),
('mb08541', '58462', '2020-02-23', 'st095', '2020-03-08', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
