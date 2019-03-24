-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2018 at 01:00 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hck`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Gaurav Kumar Jha', 'gauravjha8298@gmail.com', 'daef4f1d93c6eac1b1eff21e190dc50b50824a96');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(500) NOT NULL,
  `roll` varchar(8) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `cleared` varchar(11) NOT NULL DEFAULT '-1',
  `last_submission` varchar(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `name`, `email`, `password`, `roll`, `score`, `cleared`, `last_submission`) VALUES
(21, 'kshitij Saini', 'kshitizsaini1941996@gmail.com', '02773feb1f63e68f214ef92c159786837ab97af6', '14ICS024', 791.805, '12345', '1539359658'),
(1538071912, 'Harsh', 'onlineqwerty1@gmail.com', 'daef4f1d93c6eac1b1eff21e190dc50b50824a96', '16BIT029', 0, '1234567', '1539357720'),
(1538071917, 'Anveshika Srivastava', 'anvisrivastava1008@gmail.com', '9e7a2320422288de584c279b1741d6ab7f7e0227', '16BIT023', 444.36, '123456', '1539361403');

-- --------------------------------------------------------

--
-- Table structure for table `testinfo`
--

CREATE TABLE `testinfo` (
  `id` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `start` varchar(30) NOT NULL,
  `end` varchar(30) NOT NULL,
  `active` varchar(20) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testinfo`
--

INSERT INTO `testinfo` (`id`, `status`, `start`, `end`, `active`) VALUES
(1, '0', '1539357720', '1539374400', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `usr`
--

CREATE TABLE `usr` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usr`
--

INSERT INTO `usr` (`id`, `email`, `password`) VALUES
(1, 'xyz@xyz.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `weapons`
--

CREATE TABLE `weapons` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `power` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `issecret` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weapons`
--

INSERT INTO `weapons` (`id`, `name`, `power`, `code`, `issecret`) VALUES
(1, 'Dhanush', 80, 123, 1),
(2, 'Talwar', 65, 246, 1),
(3, 'Gada', 85, 369, 1),
(4, 'SudarshanChakra', 100, 700, 0),
(5, 'Trishul', 93, 468, 1),
(6, 'Bhala', 72, 345, 1),
(7, 'Bhramastra', 98, 681, 1),
(8, 'Vajra', 90, 234, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `roll` (`roll`);

--
-- Indexes for table `testinfo`
--
ALTER TABLE `testinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usr`
--
ALTER TABLE `usr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weapons`
--
ALTER TABLE `weapons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1538071918;
--
-- AUTO_INCREMENT for table `testinfo`
--
ALTER TABLE `testinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usr`
--
ALTER TABLE `usr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `weapons`
--
ALTER TABLE `weapons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
