-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2017 at 06:59 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `newtask`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Ident` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(250) NOT NULL,
  PRIMARY KEY (`Ident`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Ident`, `Name`, `Username`, `Password`, `Email`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `ID` int(30) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Age` int(30) NOT NULL,
  `Designation` varchar(55) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `UserImage` varchar(255) NOT NULL,
  `Prof_status` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`ID`, `Name`, `Password`, `Age`, `Designation`, `Email`, `Address`, `UserImage`, `Prof_status`, `Status`) VALUES
(11, 'test', 'test123', 23, 'Test', 'developer@gmail.com', '22nd street nanaganallur', '1490878191Penguins.jpg', 'test', 1),
(12, 'qwerty', 'qwerty123', 24, 'qwerty', 'qwerty@gmail.com', 'test', '1490866868Koala.jpg', 'good', 1),
(13, 'gokul', '123456', 25, 'Manager', 'gokult@gmail.com', '6d,Kamaraj street,\r\nChennai-22.', '1490936636Tulips.jpg', 'Goodmorning', 1),
(14, 'John', 'john123', 32, 'Project manager', 'john@gmail.com', '2nd street,\r\nBanglore', '1490933871Hydrangeas.jpg', 'Have a nice day', 1),
(15, 'Peter fernandas', 'peter123', 30, 'manager', 'peter@gmail.com', 'chennai-45', '1490934131Koala.jpg', 'Goodmorning', 1),
(16, 'testing', 'qwerty', 25, 'tester', 'tester@gmail.com', 'test', '1490934235Desert.jpg', 'Test', 1);
