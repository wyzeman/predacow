-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2015 at 10:48 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

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
(10, 'wyzeman', 'login', '', '', '1440556028');

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
-- Table structure for table `tb_groups`
--

CREATE TABLE IF NOT EXISTS `tb_groups` (
`id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `parent_group` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_groups`
--

INSERT INTO `tb_groups` (`id`, `name`, `parent_group`, `deleted`) VALUES
(1, 'Mindkind', -1, 0),
(2, 'test', -1, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_sessions`
--

INSERT INTO `tb_sessions` (`id`, `id_user`, `timestamp_created`, `timestamp_last_activity`, `hostname`, `url_last_activity`) VALUES
(5, 2, 1440556028, 1440557318, '127.0.0.1', '/predacow/webchat.php');

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
  `id_group` int(11) NOT NULL DEFAULT '-1',
  `default_language` varchar(5) NOT NULL,
  `last_visit_hostname` varchar(255) NOT NULL,
  `last_visit_datetime` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `timestamp_created` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `email_address`, `user_level`, `id_group`, `default_language`, `last_visit_hostname`, `last_visit_datetime`, `active`, `timestamp_created`, `deleted`) VALUES
(2, 'wyzeman', '$5$$QzsRjyEpRrd7eAfj8LYNYNPNkvoadO7HZyOXNKTRDe2', 'cyberwyze@hotmail.com', 255, 1, 'fr_CA', '127.0.0.1', 2015, 1, 1440380616, 0),
(3, 'qwz', '$5$$ru5dV71zNhnQuQbs7FxtiBkPOlgAtsxjoClI.kV8oh0', 'qwz@hotmail.com', 255, 1, 'en_US', '', 0, 1, 1440556652, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_webchat`
--

CREATE TABLE IF NOT EXISTS `tb_webchat` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `opened` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_webchat`
--

INSERT INTO `tb_webchat` (`id`, `id_user`, `opened`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_webchat_chatrooms`
--

CREATE TABLE IF NOT EXISTS `tb_webchat_chatrooms` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `chatroom_id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_webchat_chatrooms`
--

INSERT INTO `tb_webchat_chatrooms` (`id`, `id_user`, `chatroom_id`, `name`) VALUES
(4, 2, -101, 'Mindkind');

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
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
-- AUTO_INCREMENT for table `tb_groups`
--
ALTER TABLE `tb_groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_webchat`
--
ALTER TABLE `tb_webchat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_webchat_chatrooms`
--
ALTER TABLE `tb_webchat_chatrooms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;