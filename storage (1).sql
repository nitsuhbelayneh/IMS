-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2019 at 09:51 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `storage`
--

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE IF NOT EXISTS `credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(100) NOT NULL,
  `addedby` varchar(100) NOT NULL,
  `addeddate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `role`, `addedby`, `addeddate`) VALUES
(23, 'admin1', 'admin1', 'admin1', 'admin1@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'storemanager', 'admin1', '2019-01-14'),
(24, 'keeper2', 'keeper2', 'keeper2', 'keeper2@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'storekeeper', 'admin1', '2019-01-14'),
(25, 'user1', 'user1', 'user1', 'user1@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'user', 'admin1', '2019-01-14'),
(28, 'admin2', 'admin2', 'admin2', 'admin2@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'storemanager', 'admin1', '2019-01-17'),
(29, 'keeper1', 'keeper1', 'keeper1', 'keeper1@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'storekeeper', 'admin1', '2019-01-17'),
(30, 'user2', 'user2', 'user2', 'user2@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'user', 'admin1', '2019-01-17');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` varchar(200) NOT NULL,
  `itemid` varchar(200) NOT NULL,
  `model` varchar(200) NOT NULL,
  `quantity` int(150) NOT NULL,
  `price` double NOT NULL,
  `addedby` varchar(200) NOT NULL,
  `addeddate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `itemname`, `itemid`, `model`, `quantity`, `price`, `addedby`, `addeddate`) VALUES
(2, 'Lenovo', 'Leno', 'Ideapad 310', 5, 3000, 'Tselote', '2019-01-18'),
(4, 'Laptop Acer', 'Acer', 'Aspire VX 15', 4, 22000, 'Tselote', '2019-01-22'),
(7, 'Iphone', 'Ipho', '6+', 3, 11000, 'Tselote', '2019-01-26');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `sender` varchar(150) NOT NULL,
  `recipient` varchar(150) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `currenttime` time NOT NULL,
  `currentdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `sender`, `recipient`, `status`, `currenttime`, `currentdate`) VALUES
(4, 'hryy', 'Tselote', 'Tselotee', 'clear', '12:10:06', '2019-01-26'),
(5, 'hello tinsae', 'Tselotee', 'Tinsaeee', 'Read', '12:18:56', '2019-01-26'),
(6, 'Hi tinsu', 'Tselotee', 'Tinsaeee', 'Read', '12:20:20', '2019-01-26'),
(7, 'Hi tinsae manager', 'Tselotee', 'Tinsae', 'Read', '12:21:32', '2019-01-26'),
(8, 'Hey Tselotee', 'Tselote', 'Tselotee', 'clear', '12:51:35', '2019-01-26'),
(9, 'Hey Tselotee', 'Tselot', 'Tselotee', 'clear', '12:52:22', '2019-01-26'),
(10, 'hey manager tselot', 'Tselotee', 'Tselot', 'Read', '01:09:37', '2019-01-26'),
(11, 'hey keeper tselote', 'Tselotee', 'Tselote', 'Read', '01:09:51', '2019-01-26'),
(12, 'where u at', 'Tselotee', 'Tselot', 'Read', '01:10:02', '2019-01-26'),
(13, 'where you at', 'Tselotee', 'Tselote', 'Read', '01:10:11', '2019-01-26'),
(14, 'Tselotee manager', 'Tselot', 'Tselotee', 'Read', '01:35:40', '2019-01-26'),
(15, 'asdfghj', 'Tselot', 'Tselotee', 'Read', '01:38:18', '2019-01-26'),
(16, 'hey message from user tselotee', 'Tselotee', 'Tselot', 'Read', '03:06:05', '2019-01-26'),
(17, 'hey whats up', 'Tselotee', 'Tselote', 'clear', '03:07:45', '2019-01-26'),
(18, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!', 'Tselot', 'Tinsaee', 'Read', '03:09:49', '2019-01-26'),
(19, 'ok ill allow it', 'Tinsaee', 'Tselot', 'Read', '03:13:14', '2019-01-26'),
(20, 'Hey keeper', 'Tselot', 'Tselote', 'Read', '03:17:02', '2019-01-26'),
(21, 'WHat do you want', 'Tselot', 'Tselotee', 'clear', '03:20:46', '2019-01-26'),
(22, 'Hey TSelot this is ur store manager !!', 'Tselot', 'Tselotee', 'clear', '07:02:05', '2019-01-26'),
(23, 'hello', 'Tselot', 'Tselotee', 'Read', '07:07:27', '2019-01-26'),
(24, 'hello hello hello', 'Tselot', 'Tselotee', 'clear', '07:07:34', '2019-01-26'),
(25, 'Hey Store Keeper', 'Tselotee', 'Tselote', 'clear', '07:36:22', '2019-01-26'),
(26, 'Hello User', 'Tselote', 'Tselotee', 'clear', '07:52:27', '2019-01-26'),
(27, 'Hello store manager This is Store Keeper!!!', 'Tselote', 'Tselot', 'clear', '07:53:12', '2019-01-26'),
(28, 'Hello User Does this message appear', 'Tselote', 'Tselotee', 'clear', '07:56:17', '2019-01-26'),
(29, 'hello storekeeper', 'Tselotee', 'Tselote', 'Read', '08:00:57', '2019-01-26'),
(30, 'Hello TSelotee USer', 'Tselote', 'Tselotee', 'clear', '08:08:02', '2019-01-26'),
(31, 'ANte Selam nek', 'Tselot', 'Tselote', 'Read', '08:31:34', '2019-01-26'),
(32, 'Hello keeper thsis sld', 'Tselot', 'Tselotee', 'clear', '08:32:29', '2019-01-26'),
(33, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi deleniti eum excepturi, harum laborum libero nam nemo repellat soluta ullam. Accusamus doloremque eos laborum minus quasi. Nesciunt officiis soluta vitae!', 'Tselot', 'Tselote', 'Read', '08:34:04', '2019-01-26'),
(34, 'Heloo store manager', 'Tselote', 'Tselot', 'clear', '08:40:32', '2019-01-26'),
(35, 'hello userr', 'Tselote', 'Tselotee', 'clear', '08:40:43', '2019-01-26'),
(36, 'Hello store keeper this is store manager', 'Tselot', 'Tselote', 'clear', '01:47:13', '2019-01-28'),
(37, 'Hey user', 'Tselote', 'Tselotee', 'clear', '01:50:39', '2019-01-28');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` varchar(150) NOT NULL,
  `itemid` varchar(150) NOT NULL,
  `price` double NOT NULL,
  `model` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `requestedby` varchar(150) NOT NULL,
  `requeststatus` varchar(150) NOT NULL,
  `requestdate` date NOT NULL,
  `approvedby` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `itemname`, `itemid`, `price`, `model`, `quantity`, `requestedby`, `requeststatus`, `requestdate`, `approvedby`) VALUES
(7, 'Lenovo', 'Leno', 9000, 'Ideapad 310', '3', 'Tselotee', 'Returned', '2019-01-22', 'Tselot'),
(15, 'Laptop Acer', 'Acer', 44000, 'Aspire VX 15', '2', 'Tselotee', 'Returned', '2019-01-24', 'Tselot'),
(18, 'Lenovo', 'Leno', 9000, 'Ideapad 310', '3', 'Tinsaeee', 'Returned', '2019-01-24', 'Tselot'),
(19, 'Lenovo', 'Leno', 9000, 'Ideapad 310', '3', 'Tinsaeee', 'Returned', '2019-01-24', 'Tselot'),
(22, 'Laptop Acer', 'Acer', 66000, 'Aspire VX 15', '3', 'Tselotee', 'Returned', '2019-01-24', 'Tselot'),
(23, 'Laptop Acer', 'Acer', 44000, 'Aspire VX 15', '2', 'Tselotee', 'Returned', '2019-01-24', 'Tselot'),
(26, 'Lenovo', 'Leno', 9000, 'Ideapad 310', '3', 'Tselotee', 'Returned', '2019-01-24', 'Tselot'),
(27, 'Lenovo', 'Leno', 6000, 'Ideapad 310', '2', 'Tselotee', 'Returned', '2019-01-24', 'Tselot'),
(30, 'Lenovo', 'Leno', 6000, 'Ideapad 310', '2', 'Tinsaeee', 'Returned', '2019-01-24', 'Tselot'),
(31, 'Laptop Acer', 'Acer', 66000, 'Aspire VX 15', '3', 'Tinsaeee', 'Returned', '2019-01-24', 'Tselot'),
(33, 'Lenovo', 'Leno', 12000, 'Ideapad 310', '4', 'Tselotee', 'Returned', '2019-01-24', 'Tselot'),
(34, 'Lenovo', 'Leno', 9000, 'Ideapad 310', '3', 'Tselotee', 'Returned', '2019-01-25', 'Tselot'),
(36, 'Laptop Acer', 'Acer', 22000, 'Aspire VX 15', '1', 'Tselotee', 'Approved', '2019-01-25', 'Tselot'),
(37, 'Lenovo', 'Leno', 6000, 'Ideapad 310', '2', 'Tselotee', 'Returned', '2019-01-25', 'Tselot'),
(38, 'Lenovo', 'Leno', 6000, 'Ideapad 310', '2', 'Tselotee', 'Returned', '2019-01-26', 'Tselot');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
