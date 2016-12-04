-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db655171027.db.1and1.com
-- Generation Time: Nov 06, 2016 at 08:27 AM
-- Server version: 5.5.52-0+deb7u1-log
-- PHP Version: 5.4.45-0+deb7u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db655171027`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id`      INT(11) NOT NULL AUTO_INCREMENT,                    -- Primary Key : AUTO_INCREMENT
  `title`   VARCHAR(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table category' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id`          INT(11) NOT NULL AUTO_INCREMENT,                -- Primary Key : AUTO_INCREMENT
  `fname`       VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lname`       VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday`    DATETIME DEFAULT NULL,
  `username`    VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  `email`       VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `password`    VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar`      VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `biography`   TEXT DEFAULT NULL,
  `role`        INT(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table users' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `articles` (
    `id`                INT(11) NOT NULL AUTO_INCREMENT,            -- Primary Key : AUTO_INCREMENT
    `title`             TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
    `abstract`          TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
    `content`           TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
    `authors`           TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
    `categories`        INT(11) NOT NULL,                           -- Foreign Key : category.id
    `tags`              TEXT COLLATE utf8_unicode_ci DEFAULT NULL ,
    `status`            INT(3),
    `date_creation`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `date_modified`     DATETIME DEFAULT NULL,
    `writter`           INT(11) NOT NULL,                           -- Foreign Key : users.id
    `displayed_summary` INT(1),
    PRIMARY KEY(`id`),
    FOREIGN KEY(`writter`) REFERENCES users(`id`),
    FOREIGN KEY(`category`) REFERENCES category(`id`)
) ENGINE=InnoBD DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table articles' AUTO_INCREMENT=1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
