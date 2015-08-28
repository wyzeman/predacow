-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2015 at 10:54 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_activities`
--

INSERT INTO `tb_activities` (`id`, `field_who`, `field_how`, `field_what`, `field_reference`, `field_when`) VALUES
(1, 'wyzeman', 'login', '', '', '1440381915'),
(2, 'wyzeman', 'login', '', '', '1440383379'),
(3, 'wyzeman', 'login', '', '', '1440383510'),
(4, '2', 'logout_timeout', '', '', '1440467119'),
(5, 'wyzeman', 'login', '', '', '1440468788'),
(6, 'wyzeman', 'login', '', '', '1440472592'),
(7, 'wyzeman', 'login', '', '', '1440473353'),
(8, '2', 'logout_timeout', '', '', '1440549807'),
(9, 'wyzeman', 'login', '', '', '1440549811'),
(10, 'wyzeman', 'login', '', '', '1440556028'),
(11, 'qwz', 'login', '', '', '1440557969'),
(12, 'wyzeman', 'login', '', '', '1440558027'),
(13, '2', 'logout_timeout', '', '', '1440562705'),
(14, 'wyzeman', 'login', '', '', '1440563212'),
(15, '2', 'logout_timeout', '', '', '1440635559'),
(16, 'wyzeman', 'login', '', '', '1440635636'),
(17, 'wyzeman', 'login', '', '', '1440639230'),
(18, 'wyzeman', 'login', '', '', '1440639624'),
(19, 'CTD', 'login', '', '', '1440641433'),
(20, '', 'login_fail', 'CDT cdtcdt', '', '1440641479'),
(21, 'wyzeman', 'login', '', '', '1440641490'),
(22, 'CTD', 'login', '', '', '1440641506'),
(23, 'CTD', 'login', '', '', '1440641671'),
(24, 'wyzeman', 'login', '', '', '1440642063'),
(25, 'CTD', 'login', '', '', '1440642074'),
(26, 'CTD', 'login', '', '', '1440642564'),
(27, 'wyzeman', 'login', '', '', '1440642672'),
(28, 'CTD', 'login', '', '', '1440642781'),
(29, '4', 'logout_timeout', '', '', '1440650871'),
(30, 'CTD', 'login', '', '', '1440650881'),
(31, 'wyzeman', 'login', '', '', '1440725650'),
(32, 'wyzeman', 'login', '', '', '1440726360'),
(33, 'wyzeman', 'login', '', '', '1440726689'),
(34, 'wyzeman', 'login', '', '', '1440726896'),
(35, 'wyzeman', 'login', '', '', '1440726963'),
(36, 'wyzeman', 'login', '', '', '1440727049'),
(37, 'wyzeman', 'login', '', '', '1440727390'),
(38, 'wyzeman', 'login', '', '', '1440727447'),
(39, 'wyzeman', 'login', '', '', '1440727537'),
(40, 'wyzeman', 'login', '', '', '1440727551'),
(41, 'wyzeman', 'login', '', '', '1440727578'),
(42, 'wyzeman', 'logout', '', '', '1440728896'),
(43, 'wyzeman', 'login', '', '', '1440728900'),
(44, 'wyzeman', 'create_user', 'test', '', '1440729624'),
(45, 'wyzeman', 'delete_user', 'test', '', '1440730014');

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat`
--

CREATE TABLE IF NOT EXISTS `tb_chat` (
`id` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `username` varchar(75) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_chat`
--

INSERT INTO `tb_chat` (`id`, `channel`, `timestamp`, `username`, `message`) VALUES
(1, -101, 1440556866, 'wyzeman', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat_unseens`
--

CREATE TABLE IF NOT EXISTS `tb_chat_unseens` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_chat_unseens`
--

INSERT INTO `tb_chat_unseens` (`id`, `id_user`, `channel`, `timestamp`) VALUES
(1, 3, -101, 1440556866);

-- --------------------------------------------------------

--
-- Table structure for table `tb_events`
--

CREATE TABLE IF NOT EXISTS `tb_events` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `opened` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_events`
--

INSERT INTO `tb_events` (`id`, `id_user`, `opened`, `timestamp`) VALUES
(1, 2, 0, 1440730203),
(2, 4, 0, 0),
(3, 2, 0, 1440730203),
(4, 2, 0, 1440730203);

-- --------------------------------------------------------

--
-- Table structure for table `tb_events_logs`
--

CREATE TABLE IF NOT EXISTS `tb_events_logs` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `event_type` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_events_logs`
--

INSERT INTO `tb_events_logs` (`id`, `id_user`, `timestamp`, `event_type`, `description`) VALUES
(1, 2, 1440727049, 0, 'wyzeman as join'),
(2, 2, 1440727390, 0, 'wyzeman has join the room'),
(3, 2, 1440727447, 0, 'wyzeman has join the room'),
(4, 2, 1440727537, 0, 'wyzeman has join the room'),
(5, 2, 1440727547, 0, 'wyzeman has left the building.'),
(6, 2, 1440727551, 0, 'wyzeman has join the room'),
(7, 2, 1440727575, 0, 'wyzeman has left the building.'),
(8, 2, 1440727578, 0, 'wyzeman has join the room.'),
(9, 2, 1440728850, 0, 'wyzeman has left the building.'),
(10, 2, 1440728896, 0, 'wyzeman has left the building.'),
(11, 2, 1440728900, 0, 'wyzeman has join the room.'),
(12, 2, 1440729624, 0, 'wyzeman has created a new user: test'),
(13, 2, 1440730014, 0, 'wyzeman has deleted the user: test');

-- --------------------------------------------------------

--
-- Table structure for table `tb_groups`
--

CREATE TABLE IF NOT EXISTS `tb_groups` (
`id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `parent_group` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `timestamp_created` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_groups`
--

INSERT INTO `tb_groups` (`id`, `name`, `parent_group`, `deleted`, `timestamp_created`, `active`) VALUES
(1, 'Mindkind', -1, 0, 0, 1),
(4, '3B tech', -1, 0, 1440640584, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_sessions`
--

INSERT INTO `tb_sessions` (`id`, `id_user`, `timestamp_created`, `timestamp_last_activity`, `hostname`, `url_last_activity`) VALUES
(12, 2, 1440728900, 1440730483, '127.0.0.1', '/predacow/alerts.php');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
`id` int(11) NOT NULL,
  `username` varchar(75) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `id_group` int(11) NOT NULL DEFAULT '-1',
  `default_language` varchar(5) NOT NULL,
  `last_visit_hostname` varchar(255) NOT NULL,
  `last_visit_datetime` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_created` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `email_address`, `user_level`, `id_group`, `default_language`, `last_visit_hostname`, `last_visit_datetime`, `active`, `timestamp_created`, `deleted`) VALUES
(2, 'wyzeman', '$5$$QzsRjyEpRrd7eAfj8LYNYNPNkvoadO7HZyOXNKTRDe2', 'cyberwyze@hotmail.com', 255, 1, 'fr_CA', '127.0.0.1', 2015, 1, 1440380616, 0),
(3, 'qwz', '$5$$sAQhvOPvB6fmGGoaZ1nlayOIIZ6P9pRhMEBnPEs2IR8', 'qwz@hotmail.com', 255, 1, 'en_US', '127.0.0.1', 2015, 1, 1440556652, 0),
(4, 'CTD', '$5$$2i.aX8wIsNKClIK4a.XfxK68UqhEF1GR/Y/1aRrAlb.', 'ctd@3btech.ca', 100, 4, 'en_US', '127.0.0.1', 2015, 1, 1440640928, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_webchat`
--

CREATE TABLE IF NOT EXISTS `tb_webchat` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `opened` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_webchat`
--

INSERT INTO `tb_webchat` (`id`, `id_user`, `opened`) VALUES
(1, 2, 0),
(2, 3, 0),
(3, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_webchat_chatrooms`
--

CREATE TABLE IF NOT EXISTS `tb_webchat_chatrooms` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `chatroom_id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_activities`
--
ALTER TABLE `tb_activities`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_chat`
--
ALTER TABLE `tb_chat`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_chat_unseens`
--
ALTER TABLE `tb_chat_unseens`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_events`
--
ALTER TABLE `tb_events`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_events_logs`
--
ALTER TABLE `tb_events_logs`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_groups`
--
ALTER TABLE `tb_groups`
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
-- Indexes for table `tb_webchat`
--
ALTER TABLE `tb_webchat`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_webchat_chatrooms`
--
ALTER TABLE `tb_webchat_chatrooms`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_activities`
--
ALTER TABLE `tb_activities`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `tb_chat`
--
ALTER TABLE `tb_chat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_chat_unseens`
--
ALTER TABLE `tb_chat_unseens`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_events`
--
ALTER TABLE `tb_events`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_events_logs`
--
ALTER TABLE `tb_events_logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tb_groups`
--
ALTER TABLE `tb_groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_webchat`
--
ALTER TABLE `tb_webchat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_webchat_chatrooms`
--
ALTER TABLE `tb_webchat_chatrooms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
