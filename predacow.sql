-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 24, 2015 at 08:57 AM
-- Server version: 5.5.44-0+deb8u1
-- PHP Version: 5.6.9-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `predacow`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_activities`
--

CREATE TABLE IF NOT EXISTS `tb_activities` (
`id` int(11) NOT NULL,
  `field_who` varchar(255) NOT NULL,
  `field_how` varchar(255) NOT NULL,
  `field_what` varchar(255) NOT NULL,
  `field_reference` varchar(255) NOT NULL,
  `field_when` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_activities`
--

INSERT INTO `tb_activities` (`id`, `field_who`, `field_how`, `field_what`, `field_reference`, `field_when`) VALUES
(1, 'wyzeman', 'login', '', '', '1440381915'),
(2, 'wyzeman', 'login', '', '', '1440383379'),
(3, 'wyzeman', 'login', '', '', '1440383510');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sessions`
--

CREATE TABLE IF NOT EXISTS `tb_sessions` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `timestamp_created` int(11) NOT NULL,
  `timestamp_last_activity` int(11) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `url_last_activity` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_sessions`
--

INSERT INTO `tb_sessions` (`id`, `id_user`, `timestamp_created`, `timestamp_last_activity`, `hostname`, `url_last_activity`) VALUES
(17, 2, 1440383510, 1440383624, '::1', '/predacow/users.php');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
`id` int(11) NOT NULL,
  `username` varchar(75) NOT NULL,
  `password` varchar(75) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `default_language` varchar(5) NOT NULL,
  `last_visit_hostname` varchar(255) NOT NULL,
  `last_visit_datetime` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_created` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `email_address`, `user_level`, `default_language`, `last_visit_hostname`, `last_visit_datetime`, `active`, `timestamp_created`) VALUES
(2, 'wyzeman', '$5$$QzsRjyEpRrd7eAfj8LYNYNPNkvoadO7HZyOXNKTRDe2', 'cyberwyze@hotmail.com', 255, 'fr_CA', '::1', 2015, 1, 1440380616);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_activities`
--
ALTER TABLE `tb_activities`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_activities`
--
ALTER TABLE `tb_activities`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
