-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- サーバのバージョン： 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yabukib`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bentotable`
--

CREATE TABLE `bentotable` (
  `date` date NOT NULL,
  `name` text NOT NULL,
  `price` int(8) NOT NULL,
  `stocks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `bentotable`
--

INSERT INTO `bentotable` (`date`, `name`, `price`, `stocks`) VALUES
('2019-05-31', 'スペシャル弁当', 10000, 200),
('2019-05-31', 'A弁当', 300, 50),
('2019-05-31', 'B弁当', 350, 30),

-- --------------------------------------------------------

--
-- テーブルの構造 `identifixtable`
--

CREATE TABLE `identifixtable` (
  `QRid` char(36) NOT NULL,
  `student` char(7) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `identifixtable`
--

INSERT INTO `identifixtable` (`QRid`, `student`, `date`) VALUES
('254fc572-a766-4522-a013-ff6562026145', '1742120', '2019-05-31'),
('fd91c4ee-7817-45df-b0dc-658ff39a9f45', '1742119', '2019-05-31');

-- --------------------------------------------------------

--
-- テーブルの構造 `ordertable`
--

CREATE TABLE `ordertable` (
  `QRid` char(36) NOT NULL,
  `name` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `ordertable`
--

INSERT INTO `ordertable` (`QRid`, `name`, `date`) VALUES
('254fc572-a766-4522-a013-ff6562026145', 'A弁当', '2019-05-31'),
('254fc572-a766-4522-a013-ff6562026145', 'B弁当', '2019-05-31'),
('fd91c4ee-7817-45df-b0dc-658ff39a9f45', 'スペシャル弁当', '2019-05-31');

-- --------------------------------------------------------

--
-- テーブルの構造 `studentlogintable`
--

CREATE TABLE `studentlogintable` (
  `student` char(7) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `resumeDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `studentlogintable`
--

INSERT INTO `studentlogintable` (`student`, `password`, `resumeDate`) VALUES
('1742111', 'murata', NULL),
('1742119', 'yamashita', NULL),
('1742120', 'yamada', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `vendorlogintable`
--

CREATE TABLE `vendorlogintable` (
  `vendor` char(7) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `vendorlogintable`
--

INSERT INTO `vendorlogintable` (`vendor`, `password`) VALUES
('1234567', 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `identifixtable`
--
ALTER TABLE `identifixtable`
  ADD PRIMARY KEY (`QRid`);

--
-- Indexes for table `studentlogintable`
--
ALTER TABLE `studentlogintable`
  ADD PRIMARY KEY (`student`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
