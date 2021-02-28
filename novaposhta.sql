-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 28 2021 г., 19:59
-- Версия сервера: 5.7.26
-- Версия PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `novaposhta`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ttn_history`
--

DROP TABLE IF EXISTS `ttn_history`;
CREATE TABLE IF NOT EXISTS `ttn_history` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `ttn_id` int(11) NOT NULL,
  `request_date` datetime NOT NULL,
  `request_status` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`status_id`),
  KEY `ttn_id` (`ttn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ttn_number`
--

DROP TABLE IF EXISTS `ttn_number`;
CREATE TABLE IF NOT EXISTS `ttn_number` (
  `ttn_id` int(11) NOT NULL AUTO_INCREMENT,
  `ttn` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ttn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
