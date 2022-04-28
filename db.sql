/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.1.50-community : Database - timberexecute
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`timberexecute` /*!40100 DEFAULT CHARACTER SET cp1256 */;

USE `timberexecute`;

/*Table structure for table `attributes` */

DROP TABLE IF EXISTS `attributes`;

CREATE TABLE `attributes` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(255) NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=cp1256;

/*Data for the table `attributes` */

insert  into `attributes`(`attribute_id`,`attribute_name`) values (1,'Website Name'),(2,'Logo'),(3,'Comapny Full Name'),(4,'Phone'),(5,'Fax'),(6,'Mobile'),(7,'E-mail'),(8,'Address'),(9,'Lat'),(10,'Long'),(11,'Start Hour'),(12,'End Hour'),(13,'facebook'),(14,'twitter'),(15,'instagram'),(16,'linkedin'),(17,'google'),(18,'youtube'),(19,'slogon'),(20,'NavColor'),(21,'SocialColor'),(22,'FooterColor'),(23,'ButtonColor'),(24,'dir');

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=cp1256;

/*Data for the table `cart` */

insert  into `cart`(`cart_id`,`user_id`,`product_id`,`price`,`quantity`,`total_price`) values (1,6,1,18500,2,37000);

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `main_category` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text,
  `publish` int(11) NOT NULL DEFAULT '0',
  `home` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=cp1256;

/*Data for the table `categories` */

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `message_date` datetime DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `new` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=cp1256;

/*Data for the table `messages` */

/*Table structure for table `order_details` */

DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=cp1256;

/*Data for the table `order_details` */

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `total_price` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `cc_name` varchar(255) DEFAULT NULL,
  `cc_number` varchar(255) DEFAULT NULL,
  `cc_month` varchar(10) DEFAULT NULL,
  `cc_year` varchar(10) DEFAULT NULL,
  `paid_amount` varchar(100) DEFAULT NULL,
  `paid_amount_currency` varchar(100) DEFAULT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  `payment_status` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `site_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=cp1256;

/*Data for the table `orders` */

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `page_of` int(11) NOT NULL DEFAULT '0',
  `page_body` text,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `site_id` int(11) NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '0',
  `home` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=cp1256;

/*Data for the table `pages` */

insert  into `pages`(`id`,`page_name`,`page_of`,`page_body`,`plugin_id`,`site_id`,`publish`,`home`,`slug`,`url`) values (17,'Home',0,'',4,2,1,0,'home','home'),(18,'About Us',0,'<div class=\"btgrid\">\r\n<div class=\"row row-1\">\r\n<div class=\"col col-md-6\">\r\n<div class=\"content\">\r\n<p>This is About us page line 1</br>\r\nThis is About us page line 2</br>\r\nThis is About us page line 3</br>\r\nThis is About us page line 4</br>\r\nThis is About us page line 5</br>\r\nThis is About us page line 6</br>\r\nThis is About us page line 7</br>\r\nThis is About us page line 8</br>\r\nThis is About us page line 9</br>\r\nThis is About us page line 10</br>\r\n</div>\r\n</div>\r\n\r\n<div class=\"col col-md-6\">\r\n<div class=\"content\">\r\n<div data-oembed-url=\"https://www.youtube.com/watch?v=p5CTABX4-dc\">\r\n<div style=\"height:0; left:0; padding-bottom:56.25%; position:relative; width:100%\"><iframe allow=\"accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture;\" allowfullscreen=\"\" scrolling=\"no\" src=\"https://www.youtube.com/embed/p5CTABX4-dc?rel=0\" style=\"top: 0; left: 0; width: 100%; height: 100%; position: absolute; border: 0;\" tabindex=\"-1\"></iframe></div>\r\n</div>\r\n\r\n<p><img alt=\"\" src=\"http://omr.loc/img/about0img.jpg\" style=\"width:100%\" /></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n',0,2,1,1,'about-us','about-us'),(19,'Contacts',0,'',3,2,1,0,'contacts','contacts'),(20,'Services',0,'',1,2,1,0,'services','services'),(21,'Projects',0,'',2,2,1,0,'projects','projects'),(22,'New Projects',0,'<p>new page text</p>\r\n',0,2,0,0,'new-projects','new-projects'),(23,'new page',22,'<h1>new page head</h1>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n',0,2,0,0,'new-page','new-projects/new-page'),(24,'Catalog',0,'',5,2,1,0,'catalog','catalog');

/*Table structure for table `plugins` */

DROP TABLE IF EXISTS `plugins`;

CREATE TABLE `plugins` (
  `plugin_id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(255) NOT NULL,
  `plugin_url` varchar(11) NOT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=cp1256;

/*Data for the table `plugins` */

insert  into `plugins`(`plugin_id`,`plugin_name`,`plugin_url`) values (1,'Services','services_p'),(2,'Projects','projects_p'),(3,'Contacts','contacts_p'),(4,'Home Page','home_p'),(5,'Product Catalog','products_p');

/*Table structure for table `product_files` */

DROP TABLE IF EXISTS `product_files`;

CREATE TABLE `product_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `publish` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=cp1256;

/*Data for the table `product_files` */

/*Table structure for table `product_rating` */

DROP TABLE IF EXISTS `product_rating`;

CREATE TABLE `product_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=cp1256;

/*Data for the table `product_rating` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(255) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '0',
  `home` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `url` text,
  `site_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=cp1256;

/*Data for the table `products` */

/*Table structure for table `project_files` */

DROP TABLE IF EXISTS `project_files`;

CREATE TABLE `project_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `publish` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1256;

/*Data for the table `project_files` */

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contract_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '0',
  `home` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1256;

/*Data for the table `projects` */

/*Table structure for table `services` */

DROP TABLE IF EXISTS `services`;

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '0',
  `home` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1256;

/*Data for the table `services` */

/*Table structure for table `site_attributes` */

DROP TABLE IF EXISTS `site_attributes`;

CREATE TABLE `site_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `attribute_id` int(11) NOT NULL DEFAULT '0',
  `attribute_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=cp1256;

/*Data for the table `site_attributes` */

insert  into `site_attributes`(`id`,`site_id`,`attribute_id`,`attribute_value`) values (19,2,1,'Timber Execute'),(20,2,3,'Timber Execute'),(21,2,4,'+201224906830'),(22,2,5,'+200000000'),(23,2,6,'+201281234567'),(24,2,7,'omr.hanafy@gmail.com'),(25,2,8,'xxx street Al-seyouf Alexandria, Egypt'),(26,2,9,'31.23626595300202'),(27,2,10,'30.0010285448335'),(28,2,11,'08:00'),(29,2,12,'20:00'),(30,2,13,'http://facebook.com'),(31,2,14,'http://twitter.com'),(32,2,15,'http://instgran.com'),(33,2,16,'http://linkedin.com'),(34,2,17,'http://google.com'),(35,2,18,'http://youtube'),(36,2,19,'If you can imagine it we can do it'),(37,1,20,'#24355c'),(38,1,21,'#007bff'),(39,1,22,'#1c2331'),(40,1,23,'#000000'),(41,2,20,'#663300'),(42,2,21,'#d27e46'),(43,2,22,'#4c2b15'),(44,2,23,'#663300'),(45,1,24,'ltr'),(46,2,24,'ltr');

/*Table structure for table `site_header_slides` */

DROP TABLE IF EXISTS `site_header_slides`;

CREATE TABLE `site_header_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_img_url` varchar(255) DEFAULT NULL,
  `slide_head` varchar(255) DEFAULT NULL,
  `slide_text` varchar(255) DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=cp1256;

/*Data for the table `site_header_slides` */

/*Table structure for table `site_intro_slides` */

DROP TABLE IF EXISTS `site_intro_slides`;

CREATE TABLE `site_intro_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `intro_img_url` varchar(255) DEFAULT NULL,
  `intro_head` varchar(255) DEFAULT NULL,
  `intro_text` varchar(255) DEFAULT NULL,
  `intro_link` int(11) NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=cp1256;

/*Data for the table `site_intro_slides` */

/*Table structure for table `sites` */

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=cp1256;

/*Data for the table `sites` */

insert  into `sites`(`site_id`,`site_name`) values (2,'timberexecute.com');

/*Table structure for table `user_products` */

DROP TABLE IF EXISTS `user_products`;

CREATE TABLE `user_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=cp1256;

/*Data for the table `user_products` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `site_id` int(11) NOT NULL,
  `google_id` varchar(150) DEFAULT NULL,
  `profile_image` text,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `name_on_card` varchar(255) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `card_ex_month` char(2) DEFAULT NULL,
  `card_ex_year` int(11) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `email_verified` int(11) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=cp1256;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`site_id`,`google_id`,`profile_image`,`address_1`,`address_2`,`name_on_card`,`card_number`,`card_ex_month`,`card_ex_year`,`verification_code`,`email_verified`,`last_login`) values (1,'admin','admin@timberexecute.com','2021',1,'','',NULL,NULL,NULL,NULL,NULL,NULL,'',0,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
