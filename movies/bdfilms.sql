# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Database: bdfilms2
# Generation Time: 2020-11-09 00:24:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `titre`, `slug`, `created_at`, `updated_at`)
VALUES
	(1,'Action','action','2020-11-07 20:31:38','2020-11-07 20:31:49'),
	(2,'Romance','romance','2020-11-07 22:12:37','2020-11-07 22:12:37'),
	(7,'test','test','2020-11-08 18:02:13','2020-11-08 18:02:13');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table films
# ------------------------------------------------------------

DROP TABLE IF EXISTS `films`;

CREATE TABLE `films` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `titre` varchar(255) NOT NULL DEFAULT '',
  `image` text NOT NULL,
  `preview_url` text NOT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `duree` varchar(10) DEFAULT NULL,
  `prix` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `films` WRITE;
/*!40000 ALTER TABLE `films` DISABLE KEYS */;

INSERT INTO `films` (`id`, `category_id`, `titre`, `image`, `preview_url`, `auteur`, `duree`, `prix`, `created_at`, `updated_at`)
VALUES
	(1,1,'Superman','92ea353a22d8540c4b333b7fa890a9e71bf192fb.jpg','https://www.youtube.com/watch?v=T6DJcgm3wNY','Jerry Sieg','3h 8m',20,'2020-11-07 20:30:53','2020-11-07 20:30:53'),
	(2,1,'Dark Tower','022cc761e7338535863dd34464cb085bd2c029ec.jpeg','https://www.youtube.com/watch?v=GjwfqXTebIY','Nikolaj Arcel','1h 35m',20,'2020-11-07 20:35:36','2020-11-07 20:35:36'),
	(3,1,'Amazing Spiderma 3','6b40a95e6886bc538962ff5abad36e4c6e225409.jpeg','https://www.youtube.com/watch?v=Y51d7UsxfKY','Jon Watts','2h 13m',15,'2020-11-07 20:36:08','2020-11-07 20:36:08'),
	(4,2,'Aladdin (2019)','ac128a1c3a3f4032bb835366a6c6a9077ccba20c.jpg','https://www.youtube.com/watch?v=foyufD52aog','Guy Ritchie','2h 8m',30,'2020-11-07 20:39:08','2020-11-07 20:39:08'),
	(5,2,'Le Diable S\'habille en Prada','9827fbe7af3835f1363a2394f6c643ce27d8868b.jpg','https://www.youtube.com/watch?v=SkXERnN-vzw','David Frankel','1h 50m',25,'2020-11-07 20:40:40','2020-11-07 20:40:40'),
	(6,2,'Focus','b39a4f6316265e04303e07138cc8d6544d5831f8.jpg','https://www.youtube.com/watch?v=MxCRgtdAuBo','Denise Di Novi','1h 45m',8,'2020-11-07 20:40:40','2020-11-07 20:40:40'),
	(25,1,'test','785f58b98ac6b89f9ef9853680645bb97177a151.jpg','sdddsdsdsd','suds','ds',21,'2020-11-08 22:30:50','2020-11-08 22:30:50'),
	(26,1,'got 2','ba0d0f8db4257e6b5fc64565664c4b453bf4f90f.jpeg','dsdsdsdsds','ssddsd','3h 8m',12,'2020-11-08 22:31:32','2020-11-08 22:31:32');

/*!40000 ALTER TABLE `films` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `film_id` int(11) NOT NULL,
  `membre_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;

INSERT INTO `locations` (`id`, `film_id`, `membre_id`, `quantity`, `created_at`, `updated_at`)
VALUES
	(10,1,1,2,'2020-11-08 06:13:42','2020-11-08 06:13:42'),
	(11,2,2,1,'2020-11-08 22:10:32','2020-11-08 22:10:32');

/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table membres
# ------------------------------------------------------------

DROP TABLE IF EXISTS `membres`;

CREATE TABLE `membres` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `is_admin` int(11) DEFAULT '0',
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `membres` WRITE;
/*!40000 ALTER TABLE `membres` DISABLE KEYS */;

INSERT INTO `membres` (`id`, `nom`, `email`, `is_admin`, `password`, `created_at`, `updated_at`)
VALUES
	(1,'fg','fg@yahoo.fr',0,'$2y$10$MxuvrN8Dc0ZQ6A5hIbfiPeKYtc4C3k3Xx1ER22NSNTZ43ZfzP2/Cq','2020-11-08 07:43:13','2020-11-08 02:39:03'),
	(2,'test','test@yahoo.fr',0,'$2y$10$MxuvrN8Dc0ZQ6A5hIbfiPeKYtc4C3k3Xx1ER22NSNTZ43ZfzP2/Cq','2020-11-08 07:43:13','2020-11-08 02:39:03'),
	(3,'admin','admin@gmail.com',1,'$2y$10$h1Pg/PTwAdytvUEqIomcKOqxRlaIEBuokcTG2..vYOxrEPu0Ws31S','2020-11-08 23:40:05','2020-11-08 07:34:22');

/*!40000 ALTER TABLE `membres` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
