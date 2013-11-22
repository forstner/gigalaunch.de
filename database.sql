-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2013 at 10:39 AM
-- Server version: 5.5.31
-- PHP Version: 5.4.4-14+deb7u4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hausautomation`
--
CREATE DATABASE `hausautomation` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hausautomation`;

-- --------------------------------------------------------

--
-- Table structure for table `buttons`
--

CREATE TABLE IF NOT EXISTS `buttons` (
  `ButtonID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deviceid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `label` text NOT NULL,
  `outputs` text NOT NULL,
  PRIMARY KEY (`ButtonID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `CarambolaID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserID_of_Elektriker` int(10) unsigned NOT NULL,
  `UserID_of_customer` int(10) unsigned NOT NULL,
  `EinsatzOrt` text NOT NULL,
  `ModuleIDs` text NOT NULL COMMENT 'all ModuleIDs which are connected to this carambola',
  `mac` varchar(16) NOT NULL,
  `networks` text NOT NULL,
  `settings` text NOT NULL,
  `users` text NOT NULL,
  `ping` varchar(255) NOT NULL,
  `uptime` varchar(255) NOT NULL,
  `disk` text NOT NULL,
  `picture` text NOT NULL,
  PRIMARY KEY (`CarambolaID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`CarambolaID`, `UserID_of_Elektriker`, `UserID_of_customer`, `EinsatzOrt`, `ModuleIDs`, `mac`, `networks`, `settings`, `users`, `ping`, `uptime`, `disk`, `picture`) VALUES
(1, 0, 1, '2STOCK Büro Dataworx Donaustrasse 2 89073 Ulm', '1,', 'C4:93:00:11:17:8', 'br-lan Link encap:Ethernet HWaddr C4:93:00:11:17:85 inet addr:192.168.0.2 Bcast:192.168.0.255 Mask:255.255.255.0 UP BROADCAST RUNNING MULTICAST MTU:1500 Metric:1 RX packets:15417 errors:0 dropped:9 overruns:0 frame:0 TX packets:14896 errors:0 dropped:0 overruns:0 carrier:0 collisions:0 txqueuelen:0 RX bytes:1330753 (1.2 MiB) TX bytes:2466044 (2.3 MiB)', '', '', '1.209 ', ' 01:03:49 up 1:40, load average: 0.04, 0.09, 0.12', 'Filesystem Size Used Available Use% Mounted on rootfs 1.1M 592.0K 560.0K 51% / /dev/root 5.5M 5.5M 0 100% /rom tmpfs 14.6M 348.0K 14.3M 2% /tmp tmpfs 512.0K 0 512.0K 0% /dev /dev/mtdblock5 1.1M 592.0K 560.0K 51% /overlay overlayfs:/overlay 1.1M 592.0K 560.0K 51% / /dev/sda1 7.1G 137.8M 6.6G 2% /mnt/sda1', 'images/carambola.jpg'),
(2, 0, 1, '2STOCK Büro Dataworx Donaustrasse 2 89073 Ulm', '1,', 'C4:93:00:11:17:9', 'br-lan Link encap:Ethernet HWaddr C4:93:00:11:17:85 inet addr:192.168.0.2 Bcast:192.168.0.255 Mask:255.255.255.0 UP BROADCAST RUNNING MULTICAST MTU:1500 Metric:1 RX packets:15417 errors:0 dropped:9 overruns:0 frame:0 TX packets:14896 errors:0 dropped:0 overruns:0 carrier:0 collisions:0 txqueuelen:0 RX bytes:1330753 (1.2 MiB) TX bytes:2466044 (2.3 MiB)', '', '', '1.209 ', ' 01:03:49 up 1:40, load average: 0.04, 0.09, 0.12', 'Filesystem Size Used Available Use% Mounted on rootfs 1.1M 592.0K 560.0K 51% / /dev/root 5.5M 5.5M 0 100% /rom tmpfs 14.6M 348.0K 14.3M 2% /tmp tmpfs 512.0K 0 512.0K 0% /dev /dev/mtdblock5 1.1M 592.0K 560.0K 51% /overlay overlayfs:/overlay 1.1M 592.0K 560.0K 51% / /dev/sda1 7.1G 137.8M 6.6G 2% /mnt/sda1', 'images/carambola.jpg'),
(3, 0, 1, '1STOCK Büro Dataworx Donaustrasse 2 89073 Ulm', '1,', 'C4:93:00:11:17:8', 'br-lan Link encap:Ethernet HWaddr C4:93:00:11:17:85 inet addr:192.168.0.2 Bcast:192.168.0.255 Mask:255.255.255.0 UP BROADCAST RUNNING MULTICAST MTU:1500 Metric:1 RX packets:15417 errors:0 dropped:9 overruns:0 frame:0 TX packets:14896 errors:0 dropped:0 overruns:0 carrier:0 collisions:0 txqueuelen:0 RX bytes:1330753 (1.2 MiB) TX bytes:2466044 (2.3 MiB)', '', '', '1.209 ', ' 01:03:49 up 1:40, load average: 0.04, 0.09, 0.12', 'Filesystem Size Used Available Use% Mounted on rootfs 1.1M 592.0K 560.0K 51% / /dev/root 5.5M 5.5M 0 100% /rom tmpfs 14.6M 348.0K 14.3M 2% /tmp tmpfs 512.0K 0 512.0K 0% /dev /dev/mtdblock5 1.1M 592.0K 560.0K 51% /overlay overlayfs:/overlay 1.1M 592.0K 560.0K 51% / /dev/sda1 7.1G 137.8M 6.6G 2% /mnt/sda1', 'images/carambola.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` text NOT NULL,
  `system` tinyint(1) NOT NULL COMMENT 'if this is a default system group, that should never be deleted',
  `mail` text NOT NULL,
  `profilepicture` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=352 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupname`, `system`, `mail`, `profilepicture`) VALUES
(1, 'root', 1, '', ''),
(37, 'username2', 0, '', ''),
(36, 'username1', 0, '', ''),
(348, 'user', 0, '', ''),
(339, 'username', 0, '', ''),
(349, 'gehtMaGarnich', 0, '', ''),
(350, 'bla', 0, '', ''),
(351, 'anonymouse', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `ModuleID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CarambolaID` bigint(20) unsigned NOT NULL,
  `ModuleIP` varchar(255) NOT NULL,
  `mac` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `switches` text NOT NULL,
  `schedule` text NOT NULL,
  `OutgoingCommandQueue` text NOT NULL,
  `description` text NOT NULL,
  `vendor` text NOT NULL,
  PRIMARY KEY (`ModuleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`ModuleID`, `CarambolaID`, `ModuleIP`, `mac`, `type`, `switches`, `schedule`, `OutgoingCommandQueue`, `description`, `vendor`) VALUES
(1, 1, '192.168.0.250', '00:00:00:00:00', 'ethdio32', 'SwitchID|name|type|displayAs|value|groupname|picture||\r\n1|küche|output|button|on|group1|lamp.jpg||\r\n2|bad|output|slider|off|group2|livingRoom.jpg||\r\n3|wohnzimmer|output|button|on|group1|lamp.jpg||\r\n', 'timestamp|type|SwitchID|value||\r\n001231232|switch|1|on||\r\n001231232|switch|2|off||\r\n001231232|switch|3|off||', 'timestamp|type|SwitchID|value||\r\n001231232|rename|1|Haustüre||\r\n001231232|switch|1|on||\r\n001231232|switch|2|off||\r\n001231232|switch|3|off||', 'hat 32 inputs/outputs welche individuell als input oder output konfigurierbar sind\r\n\r\n', 'ANSPRECHPARTNER\r\n\r\nTech: Sascha Bruder\r\n\r\nSascha Bruder Fon: 06203 930 21 05 Fax: 06203 930 21 28 Mail: sascha.bruder@iocontrol.de\r\n\r\nchef: tw@ebru.de'),
(2, 1, '192.168.0.250', '00:00:00:00:00', 'ethdio32', 'SwitchID|name|type|displayAs|value|groupname|picture||\r\n1|küche|output|button|on|group1|lamp.jpg||\r\n2|bad|output|slider|off|group2|livingRoom.jpg||\r\n3|wohnzimmer|output|button|on|group1|lamp.jpg||\r\n', 'timestamp|type|SwitchID|value||\r\n001231232|switch|1|on||\r\n001231232|switch|2|off||\r\n001231232|switch|3|off||', 'timestamp|type|SwitchID|value||\r\n001231232|rename|1|Haustüre||\r\n001231232|switch|1|on||\r\n001231232|switch|2|off||\r\n001231232|switch|3|off||', 'hat 32 inputs/outputs welche individuell als input oder output konfigurierbar sind\r\n\r\n', 'ANSPRECHPARTNER\r\n\r\nTech: Sascha Bruder\r\n\r\nSascha Bruder Fon: 06203 930 21 05 Fax: 06203 930 21 28 Mail: sascha.bruder@iocontrol.de\r\n\r\nchef: tw@ebru.de'),
(3, 2, '192.168.0.250', '00:00:00:00:00', 'ethdio32', 'SwitchID|name|type|displayAs|value|groupname|picture||\r\n1|küche|output|button|on|group1|lamp.jpg||\r\n2|bad|output|slider|off|group2|livingRoom.jpg||\r\n3|wohnzimmer|output|button|on|group1|lamp.jpg||\r\n', 'timestamp|type|SwitchID|value||\r\n001231232|switch|1|on||\r\n001231232|switch|2|off||\r\n001231232|switch|3|off||', 'timestamp|type|SwitchID|value||\r\n001231232|rename|1|Haustüre||\r\n001231232|switch|1|on||\r\n001231232|switch|2|off||\r\n001231232|switch|3|off||', 'hat 32 inputs/outputs welche individuell als input oder output konfigurierbar sind\r\n\r\n', 'ANSPRECHPARTNER\r\n\r\nTech: Sascha Bruder\r\n\r\nSascha Bruder Fon: 06203 930 21 05 Fax: 06203 930 21 28 Mail: sascha.bruder@iocontrol.de\r\n\r\nchef: tw@ebru.de'),
(4, 3, '192.168.0.250', '00:00:00:00:00', 'ethdio32', 'SwitchID|name|type|displayAs|value|groupname|picture||\r\n1|küche|output|button|on|group1|lamp.jpg||\r\n2|bad|output|slider|off|group2|livingRoom.jpg||\r\n3|wohnzimmer|output|button|on|group1|lamp.jpg||\r\n', 'timestamp|type|SwitchID|value||\r\n001231232|switch|1|on||\r\n001231232|switch|2|off||\r\n001231232|switch|3|off||', 'command|modify|ModuleID4|SwitchID|Value||1371542854|command|modify|ModuleID4|SwitchID|Value||', 'hat 32 inputs/outputs welche individuell als input oder output konfigurierbar sind\r\n\r\n', 'ANSPRECHPARTNER\r\n\r\nTech: Sascha Bruder\r\n\r\nSascha Bruder Fon: 06203 930 21 05 Fax: 06203 930 21 28 Mail: sascha.bruder@iocontrol.de\r\n\r\nchef: tw@ebru.de');

-- --------------------------------------------------------

--
-- Table structure for table `passwd`
--

CREATE TABLE IF NOT EXISTS `passwd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `mail` text NOT NULL,
  `groups` text NOT NULL COMMENT 'list of groups the user belongs to',
  `password` text NOT NULL,
  `session` varchar(255) NOT NULL COMMENT 'random session id',
  `ip_login` varchar(255) NOT NULL COMMENT 'login-ip that user had during login',
  `ip_during_registration` text NOT NULL,
  `port_during_registration` text NOT NULL,
  `logintime` varchar(255) NOT NULL COMMENT 'server-timestamp when user logged in',
  `loginexpires` varchar(255) NOT NULL COMMENT 'server-timestamp when session expires',
  `activation` varchar(255) NOT NULL COMMENT 'activation id',
  `data` text NOT NULL COMMENT 'additional data about the user',
  `status` varchar(255) NOT NULL COMMENT 'the state of the user active, disabled, deleted',
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `device_during_registration` text NOT NULL,
  `home` text NOT NULL,
  `profilepicture` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='stores users, passwords and sessions' AUTO_INCREMENT=246 ;

--
-- Dumping data for table `passwd`
--

INSERT INTO `passwd` (`id`, `username`, `mail`, `groups`, `password`, `session`, `ip_login`, `ip_during_registration`, `port_during_registration`, `logintime`, `loginexpires`, `activation`, `data`, `status`, `firstname`, `lastname`, `device_during_registration`, `home`, `profilepicture`) VALUES
(240, 'user123', 'mail@mail.de', 'username2,user,username', '5f4dcc3b5aa765d61d8327deb882cf99', '228f59fb5089731eb849d635d1ad4a5a', '::1', '', '', '1385131335', '1386931335', 'c79ffb726a1d767d9366f11b19e8413b', '', '', 'firstname123', 'lastname123', '', 'ManagementUser.php', 'images/profilepictures/asian_model_profilepicture.jpg'),
(231, 'landschaft', 'mail@mail.de', 'root,username2,username1,gehtMaGarnich,bla', '5f4dcc3b5aa765d61d8327deb882cf99', '2bea49ced19c30665a2a77add913cde3', '::1', '', '', '1384261519', '1386061519', '', '', '', 'firstname', 'lastname', '', 'ManagementUser.php', 'images/profilepictures/7.jpg'),
(244, 'username', '', 'root,username,gehtMaGarnich', '5f4dcc3b5aa765d61d8327deb882cf99', '0fad48f795cdfca854fed987b22244b3', '::1', '', '', '1385133803', '1386933803', 'cbd97087abe665a5d085077e423aa36b', '', '', 'firstname', 'lastname', '', 'ManagementUser.php', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
