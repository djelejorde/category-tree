-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `app`;
CREATE DATABASE `app` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `app`;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `label`, `parent_id`) VALUES
(1,	'Dames',	0),
(2,	'Accessories',	1),
(3,	'Handschoenen',	2),
(4,	'Mutsen en Hoeden',	2),
(5,	'Portemonnees',	2),
(6,	'Riemen',	2),
(7,	'Sieraden & Horloges',	2),
(8,	'Armbanden',	7),
(9,	'Broches and pins',	7),
(10,	'Horloges',	7),
(11,	'Kettingen',	7),
(12,	'Oorbellen',	7),
(13,	'Ringen',	7),
(14,	'Sjaals',	2),
(15,	'Tassen',	2),
(16,	'Clutches',	15),
(17,	'Handtassen',	15),
(18,	'Rugzakken',	15);

-- 2021-05-03 13:52:25