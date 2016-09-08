<?php
/**
 * Created by PhpStorm.
 * User: sapphirehead
 * Date: 01.09.2016
 * Time: 19:20


 * Если делать через консоль
 * Вначале надо создать БД: CREATE DATABASE photo_gallery;
 * Потом команда пользования ею: USE photo_gallery;
 * И только потом можно вводить весь этот нижний запрос в кавычках в коммандную строку.
 *
 *  Folders in tables - for example
 *
 *
 *   Table structure for table `comments`
 */
$config = parse_ini_file(__DIR__ . '\..\..\dbconf.ini');
$mysqli = new mysqli($config['db.conn'], $config['db.user'], $config['db.pass']);
$mysqli->query("CREATE DATABASE IF NOT EXISTS `photo_gallery`");
$mysqli->query("USE `photo_gallery`");
$mysqli->query("CREATE TABLE IF NOT EXISTS `comments` (
`id` int(11) NOT NULL auto_increment,
  `photograph_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `author` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `photograph_id` (`photograph_id`)
) AUTO_INCREMENT=1
#
# Dumping data for table `comments`
#
INSERT INTO `comments` VALUES (1,1,'2016-01-01 11:30:39','Djey','I love this picture!'),(2,1,'2016-01-01 20:46:39','Vasya','Pretty flowers.'),(3,1,'2016-01-01 21:08:58','Pupkin','I like them too.')
#
# Table structure for table `photographs`
#
CREATE TABLE IF NOT EXISTS `photographs` (
`id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) NOT NULL,
  `prew_name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `views` int(255) NOT NULL,
  `dt` timestamp NOT NULL,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1
#
# Dumping data for table `photographs`
#
INSERT INTO `photographs` VALUES (1,'first.jpg','1','image/jpeg',265437,'1','first',0,'2016-01-01 11:30:39')
#
# Table structure for table `users`
#
CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL auto_increment,
  `username` varchar(50) unique NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1
#
# Dumping data for table `users`
#
INSERT INTO `users` VALUES (1,'admin','$2y$12$24akjJ0340LJafkri3409emvhDZiHiuYYoPP.Ny7le62NtlcoRkIe','','')
#
# My table for adding param: `parameters`
#
CREATE TABLE IF NOT EXISTS `parameters` (
    `id` int(1) NOT NULL,
#  `src` varchar(255) NOT NULL DEFAULT 'public/images',--
#  `dest` varchar(255) NOT NULL DEFAULT 'public/prewiev',--
    `width` int(3) NOT NULL,
  `height` int(3) NOT NULL,
  `rgb` int(8) NOT NULL,
  `quality` int(3) NOT NULL,
  `title` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `name_pages` varchar(100) NOT NULL,
  `count_images` int(3) NOT NULL,
  `sort` varchar(9) NOT NULL,
  PRIMARY KEY  (`id`)
  )
#
# Dumping data for table `parameters`
#
INSERT INTO `parameters` VALUES (0,200,160,0xFFFFFF,100,'Gallery','Group','Photogallery',15,'views')
#
# Table structure for table `mail`
#
CREATE TABLE IF NOT EXISTS `mail` (
    `id` int(11) NOT NULL,
  `host` varchar(100) NOT NULL,
  `mail_from` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `overall_name` varchar(255) NOT NULL,
  `mail_for` varchar(100) NOT NULL,
  `recipient` varchar(100) NOT NULL,
  `header` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
)
#
# Dumping data for table `mail`
#
INSERT INTO `mail` VALUES (0,'yandex.ru', 'Djey35@yandex.ru', 't/4wBSTCRwZbAxv6SketFg==', 587, 'Photo Gallery',
        'bykovevg@yandex.ru', 'Photo Gallery Admin', 'Message from site');
#
# Table structure for table `translit`
#
CREATE TABLE IF NOT EXISTS `translit` (
    `id` int(2) NOT NULL AUTO_INCREMENT,
  `rus` varchar(3) NOT NULL DEFAULT '',
  `eng` varchar(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 PACK_KEYS=0;
#
# Dumping data for table `translit`
#
INSERT INTO `translit` VALUES (1,'а','a'),(2,'б','b'),(3,'в','v'),(4,'г','g'),(5,'д','d'),(6,'е','e'),(7,'ё','yo'),(8,'ж','zh'),(9,'з','z'),(10,'и','i'),(11,'й','j'),(12,'к','k'),(13,'л','l'),(14,'м','m'),(15,'н','n'),(16,'о','o'),(17,'п','p'),(18,'р','r'),(19,'с','s'),(20,'т','t'),(21,'у','u'),(22,'ф','f'),(23,'х','x'),(24,'ц','c'),(25,'ч','ch'),(26,'ш','sh'),(27,'щ','shh'),(28,'ь','`'),(29,'ы','y'),(30,'ъ','``'),(31,'э','eh'),(32,'ю','yu'),(33,'я','ya'),(34,'кю','q'),(35,'yо','w'),(36,' ','_');
");
$mysqli->close();
