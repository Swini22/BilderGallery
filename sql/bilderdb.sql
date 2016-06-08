-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Jun 2016 um 16:33
-- Server-Version: 10.0.17-MariaDB
-- PHP-Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bilderdb`
--
CREATE DATABASE IF NOT EXISTS `bilderdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_german2_ci;
USE `bilderdb`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id_gallery` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_gallery`),
  UNIQUE KEY `gallery_id_uindex` (`id_gallery`),
  KEY `gallery_user_id_user_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id_image` int(11) NOT NULL AUTO_INCREMENT,
  `image_link` varchar(200) COLLATE utf8_german2_ci NOT NULL,
  `thumbnail` varchar(200) COLLATE utf8_german2_ci NOT NULL,
  `gallery_id` int(11) NOT NULL,
  PRIMARY KEY (`id_image`),
  UNIQUE KEY `image_id_image_uindex` (`id_image`),
  KEY `image_gallery_id_gallery_fk` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image_tag`
--

CREATE TABLE IF NOT EXISTS `image_tag` (
  `id_image_tag` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id_image_tag`),
  UNIQUE KEY `image_tag_id_image_tag_uindex` (`id_image_tag`),
  KEY `image_tag_image_id_image_fk` (`image_id`),
  KEY `image_tag_tag_id_tag_fk` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  PRIMARY KEY (`id_tag`),
  UNIQUE KEY `tag_id_tag_uindex` (`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `tag`
--

INSERT INTO `tag` (`id_tag`, `name`) VALUES
  (1, 'natur'),
  (2, 'animal'),
  (3, 'item'),
  (4, 'love'),
  (5, 'friendship'),
  (6, 'heaven'),
  (7, 'space'),
  (8, 'cartoon'),
  (9, 'human'),
  (10, 'environment'),
  (12, 'food');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `password` char(60) COLLATE utf8_german2_ci NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_bid_uindex` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_user_id_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`);

--
-- Constraints der Tabelle `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_gallery_id_gallery_fk` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id_gallery`);

--
-- Constraints der Tabelle `image_tag`
--
ALTER TABLE `image_tag`
  ADD CONSTRAINT `image_tag_image_id_image_fk` FOREIGN KEY (`image_id`) REFERENCES `image` (`id_image`),
  ADD CONSTRAINT `image_tag_tag_id_tag_fk` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id_tag`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
