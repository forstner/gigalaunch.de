-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 06, 2013 at 09:18 PM
-- Server version: 5.1.66
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gigalaunch`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` text NOT NULL,
  `system` tinyint(1) NOT NULL COMMENT 'if this is a default system group, that should never be deleted',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupname`, `system`) VALUES
(1, 'admins', 1);

-- --------------------------------------------------------

--
-- Table structure for table `passwd`
--

CREATE TABLE IF NOT EXISTS `passwd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `groups` text NOT NULL COMMENT 'list of groups the user belongs to',
  `password` text NOT NULL,
  `session` varchar(255) NOT NULL COMMENT 'random session id',
  `ip_login` varchar(255) NOT NULL COMMENT 'login-ip that user had during login',
  `logintime` varchar(255) NOT NULL COMMENT 'server-timestamp when user logged in',
  `loginexpires` varchar(255) NOT NULL COMMENT 'server-timestamp when session expires',
  `activation` varchar(255) NOT NULL COMMENT 'activation id',
  `data` text NOT NULL COMMENT 'additional data about the user',
  `status` varchar(255) NOT NULL COMMENT 'the state of the user active, disabled, deleted',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='stores users, passwords and sessions' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `passwd`
--

INSERT INTO `passwd` (`id`, `username`, `groups`, `password`, `session`, `ip_login`, `logintime`, `loginexpires`, `activation`, `data`, `status`) VALUES
(1, 'username', 'username,admins,', '5f4dcc3b5aa765d61d8327deb882cf99', 'd04e0dabcb1d7dd44309763421aa9a8b', '127.0.0.1', '1367867588', '1369667588', 'a88fd2f3e9a98f372522e60054f0068b', 'firstname:firstname,lastname:lastname,email:mail@mail.de,ip_during_registration:127.0.0.1,port_during_registration:44317,device_during_registration:Mozilla/5.0 (X11; Linux x86_64; rv-20.0) Gecko/20100101 Firefox/20.0,home:template.php,profilepicture:images/profilepictures/7.jpg,', '');

