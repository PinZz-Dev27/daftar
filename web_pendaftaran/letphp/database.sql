-- Script Database MySQL untuk Aplikasi Pendaftaran Lomba Game Siswa SIJA
-- Database: datadepin
-- Tabel: sija2

CREATE DATABASE IF NOT EXISTS `datadepin` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `datadepin`;

CREATE TABLE IF NOT EXISTS `sija2` (
  `NO` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `WEBSITE` varchar(255) NOT NULL,
  `COMMENT` text NOT NULL,
  `GENDER` varchar(20) NOT NULL,
  PRIMARY KEY (`NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
