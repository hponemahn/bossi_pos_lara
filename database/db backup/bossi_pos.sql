# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.30)
# Database: bossi_pos
# Generation Time: 2020-11-12 12:36:12 PM +0000
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2020_11_12_145317_create_migrations_table',1),
	(2,'2020_11_12_145318_create_order_details_table',1),
	(3,'2020_11_12_145318_create_orders_table',1),
	(4,'2020_11_12_145321_create_products_table',1),
	(5,'2020_11_12_145323_create_states_table',1),
	(6,'2020_11_12_145324_create_townships_table',1),
	(7,'2020_11_12_145326_create_users_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `total` double DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `buy_price` double DEFAULT NULL,
  `sell_price` double DEFAULT NULL,
  `discount_price` double DEFAULT '0',
  `sku` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT '',
  `is_damaged` tinyint(4) DEFAULT '0',
  `is_lost` tinyint(4) DEFAULT '0',
  `is_expired` tinyint(4) DEFAULT '0',
  `remark` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table states
# ------------------------------------------------------------

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table townships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `townships`;

CREATE TABLE `townships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `business_cat_id` int(11) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `api_token` varchar(80) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `state_id` tinyint(4) DEFAULT NULL,
  `township_id` tinyint(4) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `business_name`, `logo`, `business_cat_id`, `phone`, `email`, `email_verified_at`, `password`, `api_token`, `remember_token`, `state_id`, `township_id`, `address`, `created_at`, `updated_at`)
VALUES
	(1,'porro',NULL,NULL,NULL,'09777425147','carter81@yahoo.com',NULL,'$2y$10$y8yeJWC8tYhkN3/w0eLuh.007LBgRFm13Uylf5eLRF/8JrEBc38QS','ZX4Whea2aE8vH3i8cI6GT2xEZxiYqb1f4iGiMSnY2OmADCcucve8M1id66Hu',NULL,NULL,NULL,NULL,'2020-11-12 11:32:05','2020-11-12 11:37:14'),
	(2,'delectus',NULL,NULL,NULL,'2','linnie81@hackett.org',NULL,'$2y$10$f9zHh2zu8hUzfCcwBFIxVuD4QWpxGt2VdYTDMQBvBuYXIlLKuC2BW',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:05',NULL),
	(3,'velit',NULL,NULL,NULL,'3','porter34@hermann.info',NULL,'$2y$10$WAW0/H0UpJjKDxT1YIAuGO5TC7L19kEdkYdp0eJMqNu7aU..jhM7y',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:05',NULL),
	(4,'enim',NULL,NULL,NULL,'2','gulgowski.gabrielle@yahoo.com',NULL,'$2y$10$ntkLoSy92ywNNDAw1I.3GeT70/1AQxG4elGFqh5KeS2xEw.luIS7a',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:27',NULL),
	(5,'veniam',NULL,NULL,NULL,'5','vgutmann@nader.info',NULL,'$2y$10$A9areoaOvdiQoryCDYRgAevk9IYk4GRCo8xlHF06bZQK7sTyKsZ52',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:27',NULL),
	(6,'nihil',NULL,NULL,NULL,'3','ccremin@gmail.com',NULL,'$2y$10$w/rYXdw/gZ6Vzwvo/tKNVOV3OM03Aykm8wkYH8c5DuWZqaCmlRZjK',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:27',NULL),
	(7,'provident',NULL,NULL,NULL,'4','price.nick@yahoo.com',NULL,'$2y$10$4IDNZ9Se/ChaV9NY4UrbiO3GTScm36AJS4L96yPtriLo5BPy.mErG',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:27',NULL),
	(8,'cumque',NULL,NULL,NULL,'1','carol84@yahoo.com',NULL,'$2y$10$JQFYjL1dPKp40.8QpYQGGOwSAg30fBnHTIJRWPpuii8Ej6BCUb1ki',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:27',NULL),
	(9,'qui',NULL,NULL,NULL,NULL,'rlehner@hotmail.com',NULL,'$2y$10$k46nV9HroOzA2ExlSr/GQuqnEWnfOW.CJXt731zG1e0MsW9SsXkOG',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:40',NULL),
	(10,'illum',NULL,NULL,NULL,NULL,'agreenholt@gmail.com',NULL,'$2y$10$yltX99Ej55idfm4ZIzSMY.dFGkZcDoiGOgSWIB3AkwX0ADVTVBChy',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:40',NULL),
	(11,'similique',NULL,NULL,NULL,NULL,'gregg.stanton@yahoo.com',NULL,'$2y$10$yNEbk9lMBJnbGv8HWccn.euWqIFv1qLDX3baaUUElu0mDi92hGafm',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:40',NULL),
	(12,'id',NULL,NULL,NULL,NULL,'keaton.klein@treutel.com',NULL,'$2y$10$MGntymkV1iv7pHXuqw7Meu0JRMXLsLlIgXmY040AfpDtKur39rgK.',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:40',NULL),
	(13,'doloribus',NULL,NULL,NULL,NULL,'harold02@yahoo.com',NULL,'$2y$10$YaquwWak2z7BQ.ATm2CdpeEiKGk2nw0H03KOTAOuUW.588ZoKNe8O',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:40',NULL),
	(14,'sit',NULL,NULL,NULL,NULL,'slabadie@yahoo.com',NULL,'$2y$10$KeEuZ61dTjRYzuZwNzNvdu0j5u.JiWkH/Y8IA20pR1KBKKGcpX/Li',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:41',NULL),
	(15,'tenetur',NULL,NULL,NULL,NULL,'reginald.towne@gmail.com',NULL,'$2y$10$Tct.Ez10OIhB0QdeZxkZPO.GmhIa8yOrwOSAd.fA4ri37//9XG8SS',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:41',NULL),
	(16,'quo',NULL,NULL,NULL,NULL,'mills.gaetano@gmail.com',NULL,'$2y$10$tQWJJ95drvHDCh.a.b8Nyum3bD4tuAaj8LsOFYq7lxzsA0dvBUdr2',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:41',NULL),
	(17,'qui',NULL,NULL,NULL,NULL,'msatterfield@hotmail.com',NULL,'$2y$10$rK7h9wFYfhH.pGemtvTtz.8uNwbA0yckBv/SC9dqS96A48a36pKL6',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:41',NULL),
	(18,'nam',NULL,NULL,NULL,NULL,'ifisher@paucek.com',NULL,'$2y$10$C2jydWZbuBF8PydrtkXlZOx1Y.Ap7BCR2CgyALDjCwxDneHvWAyfC',NULL,NULL,NULL,NULL,NULL,'2020-11-12 11:32:41',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
