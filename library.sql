-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2020 at 06:39 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbook`
--

CREATE TABLE `tbook` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `categoryid` varchar(10) NOT NULL,
  `editorid` varchar(10) NOT NULL,
  `statusid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbook`
--

INSERT INTO `tbook` (`id`, `name`, `author`, `categoryid`, `editorid`, `statusid`) VALUES
(11, 'Secondbook', 'Aut', 'R_STAT_1', 'R_STAT_1', 'R_STAT_1');

-- --------------------------------------------------------

--
-- Table structure for table `tcatalog`
--

CREATE TABLE `tcatalog` (
  `catalog` varchar(10) NOT NULL,
  `value` varchar(10) NOT NULL,
  `display` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcatalog`
--

INSERT INTO `tcatalog` (`catalog`, `value`, `display`) VALUES
('B_STAT', 'R_STAT_1', 'Trilas');

-- --------------------------------------------------------

--
-- Table structure for table `treservation`
--

CREATE TABLE `treservation` (
  `id` int(11) NOT NULL,
  `bookid` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `statusid` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbook`
--
ALTER TABLE `tbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryid` (`categoryid`),
  ADD KEY `editorid` (`editorid`),
  ADD KEY `statusid` (`statusid`);

--
-- Indexes for table `tcatalog`
--
ALTER TABLE `tcatalog`
  ADD PRIMARY KEY (`value`);

--
-- Indexes for table `treservation`
--
ALTER TABLE `treservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookid` (`bookid`),
  ADD KEY `statusid` (`statusid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbook`
--
ALTER TABLE `tbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `treservation`
--
ALTER TABLE `treservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbook`
--
ALTER TABLE `tbook`
  ADD CONSTRAINT `tbook_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `tcatalog` (`value`),
  ADD CONSTRAINT `tbook_ibfk_2` FOREIGN KEY (`editorid`) REFERENCES `tcatalog` (`value`),
  ADD CONSTRAINT `tbook_ibfk_3` FOREIGN KEY (`statusid`) REFERENCES `tcatalog` (`value`);

--
-- Constraints for table `treservation`
--
ALTER TABLE `treservation`
  ADD CONSTRAINT `treservation_ibfk_1` FOREIGN KEY (`bookid`) REFERENCES `tbook` (`id`),
  ADD CONSTRAINT `treservation_ibfk_2` FOREIGN KEY (`statusid`) REFERENCES `tcatalog` (`value`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
