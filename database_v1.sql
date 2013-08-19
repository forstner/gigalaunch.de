-- MySQL dump 10.13  Distrib 5.1.66, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gigalaunch
-- ------------------------------------------------------
-- Server version	5.1.66-0+squeeze1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` text NOT NULL,
  `system` tinyint(1) NOT NULL COMMENT 'if this is a default system group, that should never be deleted',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admins',1),(37,'username2',0),(36,'username1',0),(35,'username',0);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passwd`
--

DROP TABLE IF EXISTS `passwd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwd` (
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='stores users, passwords and sessions';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passwd`
--

LOCK TABLES `passwd` WRITE;
/*!40000 ALTER TABLE `passwd` DISABLE KEYS */;
INSERT INTO `passwd` VALUES (1,'username','username,admins,','5f4dcc3b5aa765d61d8327deb882cf99','cb83bed80cd958ceb24f50604a0ed965','127.0.0.1','1376924188','1378724188','7d2ac9703d62e4d7f48b09be7bc3688d','firstname:firstname,lastname:lastname,email:mail@mail.de,ip_during_registration:192.168.1.45,port_during_registration:49434,device_during_registration:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.59.8 (KHTML- like Gecko) Version/5.1.9 Safari/534.59.8,home:UserManagement.php,profilepicture:images/profilepictures/Dandelion.gif,',''),(3,'username2','username2,','5f4dcc3b5aa765d61d8327deb882cf99','','','','','f8586a0ce14689a5b6d582f6dc814aca','firstname:firstname,lastname:lastname,email:mail@mail.de,ip_during_registration:192.168.1.45,port_during_registration:49449,device_during_registration:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.59.8 (KHTML- like Gecko) Version/5.1.9 Safari/534.59.8,home:UserManagement.php,profilepicture:images/profilepictures/Sunflower.gif,','');
/*!40000 ALTER TABLE `passwd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translations` (
  `id` bigint(20) NOT NULL,
  `deutsch` text NOT NULL,
  `russisch` text NOT NULL,
  `spanisch` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES (0,'hallo','nastrovie','!ola');
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-08-19 17:04:29
