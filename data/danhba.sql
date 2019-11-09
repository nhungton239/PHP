-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 09, 2019 lúc 04:58 PM
-- Phiên bản máy phục vụ: 5.7.26
-- Phiên bản PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `danhba`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhba`
--

DROP TABLE IF EXISTS `danhba`;
CREATE TABLE IF NOT EXISTS `danhba` (
  `ID` int(11) NOT NULL,
  `Name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phone` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhba`
--

INSERT INTO `danhba` (`ID`, `Name`, `Email`, `Phone`) VALUES
(1, 'Vy', 'vy@gmail.com', '0664857639'),
(2, 'Mẹ', 'me@gmail.com', '0678904567'),
(3, 'bố', 'bo@gmail.com', '0345678901'),
(4, 'An', 'an@gmail.com', '0345678999'),
(5, 'Minh', 'minh@gmail.com', '0345678988'),
(6, 'Khánh', 'khanh@gmail.com', '0672890324');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhba_lable`
--

DROP TABLE IF EXISTS `danhba_lable`;
CREATE TABLE IF NOT EXISTS `danhba_lable` (
  `ID` int(11) NOT NULL,
  `IDLable` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhba_lable`
--

INSERT INTO `danhba_lable` (`ID`, `IDLable`) VALUES
(1, 2),
(2, 1),
(3, 1),
(4, 2),
(5, 5),
(6, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lable`
--

DROP TABLE IF EXISTS `lable`;
CREATE TABLE IF NOT EXISTS `lable` (
  `ID` int(11) NOT NULL,
  `Lable` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lable`
--

INSERT INTO `lable` (`ID`, `Lable`) VALUES
(1, 'Nhà'),
(2, 'Bạn'),
(5, 'team');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
