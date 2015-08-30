-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2015 at 08:35 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;

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
(45, 'wyzeman', 'delete_user', 'test', '', '1440730014'),
(46, 'wyzeman', 'logout_timeout', '', '', '1440769902'),
(47, 'wyzeman', 'login', '', '', '1440769907'),
(48, 'wyzeman', 'logout', '', '', '1440769914'),
(49, 'wyzeman', 'login', '', '', '1440769919'),
(50, 'wyzeman', 'logout', '', '', '1440770864'),
(51, '', 'login_fail', 'dlkasjfd dsa', '', '1440770869'),
(52, '', 'login_fail', 'dasfasd dasfsdaf', '', '1440770969'),
(53, '', 'login_fail', 'fsadfdsafsad sdafasd', '', '1440771218'),
(54, '', 'login_fail', 'lmdc0525 lmdc0525 ', '', '1440771275'),
(55, 'wyzeman', 'login', '', '', '1440771461'),
(56, 'wyzeman', 'logout', '', '', '1440771601'),
(57, '', 'login_fail', 'lmdc0525 lmdc0525', '', '1440771605'),
(58, 'wyzeman', 'login', '', '', '1440771609'),
(59, 'wyzeman', 'logout', '', '', '1440771623'),
(60, 'wyzeman', 'login', '', '', '1440771630'),
(61, 'wyzeman', 'logout', '', '', '1440771650'),
(62, 'wyzeman', 'login', '', '', '1440771655'),
(63, 'wyzeman', 'logout_timeout', '', '', '1440798748'),
(64, 'wyzeman', 'logout_timeout', '', '', '1440798749'),
(65, 'wyzeman', 'logout_timeout', '', '', '1440798840'),
(66, 'wyzeman', 'login', '', '', '1440798846'),
(67, 'wyzeman', 'modify_user', 'CTD', '', '1440816235'),
(68, 'wyzeman', 'modify_user', 'CTD', '', '1440816235'),
(69, 'wyzeman', 'modify_user', 'CTD', '', '1440816247'),
(70, 'wyzeman', 'modify_user', 'CTD', '', '1440816247'),
(71, 'wyzeman', 'modify_user', 'CTD', 'test', '1440816330'),
(72, 'wyzeman', 'modify_user', 'CTD', 'test', '1440816330'),
(73, 'wyzeman', 'modify_user', 'CTD', 'CTD,ctd@3btech.ca,1,100,4,en_US', '1440816438'),
(74, 'wyzeman', 'modify_user', 'CTD', 'CTD,ctd@3btech.ca,1,100,4,en_US', '1440816438'),
(75, 'wyzeman', 'modify_user', 'CTD', 'CTD,ctd@3btech.ca,1,100,6,en_US', '1440816476'),
(76, 'wyzeman', 'modify_user', 'CTD', 'CTD,ctd@3btech.ca,1,100,6,en_US', '1440816476'),
(77, 'wyzeman', 'modify_user', 'CTD', 'CTD,ctd@3btech.ca,1,1,6,en_US', '1440816703'),
(78, 'wyzeman', 'modify_user', 'CTD', 'CTD,ctd@3btech.ca,1,100,7,en_US', '1440816727'),
(79, 'wyzeman', 'create_group', 'test', 'test,1,1', '1440817012'),
(80, 'wyzeman', 'delete_group', 'test', '', '1440817127'),
(81, 'wyzeman', 'modify_group', 'X', 'X,-1,1', '1440817378'),
(82, 'wyzeman', 'modify_group', 'X', 'X,6,1', '1440817384'),
(83, 'wyzeman', 'logout', '', '', '1440819600'),
(84, 'wyzeman', 'logout', '', '', '1440819769'),
(85, 'wyzeman', 'logout', '', '', '1440819819'),
(86, 'wyzeman', 'logout', '', '', '1440819880'),
(87, 'wyzeman', 'logout', '', '', '1440819919'),
(88, 'wyzeman', 'login', '', '', '1440819924'),
(89, 'wyzeman', 'logout', '', '', '1440819956'),
(90, 'wyzeman', 'logout', '', '', '1440820024'),
(91, 'wyzeman', 'login', '', '', '1440820028'),
(92, 'wyzeman', 'logout', '', '', '1440820055'),
(93, 'wyzeman', 'login', '', '', '1440820059'),
(94, 'wyzeman', 'logout', '', '', '1440820495'),
(95, 'wyzeman', 'logout', '', '', '1440820567'),
(96, 'wyzeman', 'logout', '', '', '1440820594'),
(97, 'wyzeman', 'logout', '', '', '1440820617'),
(98, 'wyzeman', 'logout', '', '', '1440820640'),
(99, 'wyzeman', 'logout', '', '', '1440820688'),
(100, 'wyzeman', 'logout', '', '', '1440820727'),
(101, 'wyzeman', 'logout', '', '', '1440820826'),
(102, 'wyzeman', 'logout', '', '', '1440820897'),
(103, 'wyzeman', 'logout', '', '', '1440820936'),
(104, 'wyzeman', 'login', '', '', '1440820941'),
(105, 'wyzeman', 'logout', '', '', '1440820953'),
(106, 'wyzeman', 'login', '', '', '1440820967'),
(107, 'wyzeman', 'logout', '', '', '1440820969'),
(108, 'wyzeman', 'login', '', '', '1440820987'),
(109, 'wyzeman', 'logout', '', '', '1440820997'),
(110, 'wyzeman', 'login', '', '', '1440821017'),
(111, 'wyzeman', 'logout', '', '', '1440821029'),
(112, 'wyzeman', 'login', '', '', '1440821034'),
(113, 'wyzeman', 'logout', '', '', '1440821042'),
(114, 'wyzeman', 'login', '', '', '1440821057'),
(115, 'wyzeman', 'logout', '', '', '1440821058'),
(116, 'wyzeman', 'login', '', '', '1440821098'),
(117, 'wyzeman', 'logout', '', '', '1440821100'),
(118, 'wyzeman', 'login', '', '', '1440821117'),
(119, 'wyzeman', 'logout', '', '', '1440821118'),
(120, 'wyzeman', 'login', '', '', '1440821139'),
(121, 'wyzeman', 'logout', '', '', '1440821142'),
(122, 'wyzeman', 'login', '', '', '1440821154'),
(123, 'wyzeman', 'logout', '', '', '1440821155'),
(124, 'wyzeman', 'logout', '', '', '1440821204'),
(125, 'wyzeman', 'logout', '', '', '1440821260'),
(126, 'wyzeman', 'login', '', '', '1440821264'),
(127, 'wyzeman', 'logout', '', '', '1440821266'),
(128, 'wyzeman', 'login', '', '', '1440821337'),
(129, 'wyzeman', 'logout', '', '', '1440821392'),
(130, 'wyzeman', 'login', '', '', '1440821398'),
(131, 'wyzeman', 'logout', '', '', '1440821449'),
(132, 'wyzeman', 'logout', '', '', '1440821538'),
(133, 'wyzeman', 'logout', '', '', '1440821621'),
(134, 'wyzeman', 'logout', '', '', '1440821643'),
(135, 'wyzeman', 'login', '', '', '1440821647'),
(136, 'wyzeman', 'logout', '', '', '1440821669'),
(137, 'wyzeman', 'login', '', '', '1440828601');

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
(1, 2, 0, 1440830605),
(2, 4, 0, 0),
(3, 2, 0, 1440830605),
(4, 2, 0, 1440830605);

-- --------------------------------------------------------

--
-- Table structure for table `tb_events_logs`
--

CREATE TABLE IF NOT EXISTS `tb_events_logs` (
`id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `event_type` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_events_logs`
--

INSERT INTO `tb_events_logs` (`id`, `timestamp`, `event_type`, `description`) VALUES
(1, 1440727049, 0, 'wyzeman as join'),
(2, 1440727390, 0, 'wyzeman has join the room'),
(3, 1440727447, 0, 'wyzeman has join the room'),
(4, 1440727537, 0, 'wyzeman has join the room'),
(5, 1440727547, 0, 'wyzeman has left the building.'),
(6, 1440727551, 0, 'wyzeman has join the room'),
(7, 1440727575, 0, 'wyzeman has left the building.'),
(8, 1440727578, 0, 'wyzeman has join the room.'),
(9, 1440728850, 0, 'wyzeman has left the building.'),
(10, 1440728896, 0, 'wyzeman has left the building.'),
(11, 1440728900, 0, 'wyzeman has join the room.'),
(12, 1440729624, 0, 'wyzeman has created a new user: test'),
(13, 1440730014, 0, 'wyzeman has deleted the user: test'),
(14, 1440769902, 0, 'wyzeman ping timeout!'),
(15, 1440769907, 0, 'wyzeman has join the room.'),
(16, 1440769914, 0, 'wyzeman has left the building.'),
(17, 1440769919, 0, 'wyzeman has join the room.'),
(18, 1440770864, 0, 'wyzeman has left the building.'),
(19, 1440771601, 0, 'wyzeman has left the building.'),
(20, 1440771605, 0, 'lmdc0525 failed to login decently.'),
(21, 1440771623, 0, 'wyzeman has left the building.'),
(22, 1440771650, 0, 'wyzeman has left the building.'),
(23, 1440771655, 0, 'wyzeman has join the room.'),
(24, 1440798840, 0, 'wyzeman ping timeout!'),
(25, 1440798846, 0, 'wyzeman has join the room.'),
(26, 1440816235, 0, 'wyzeman has modifyed user: CTD info.'),
(27, 1440816235, 0, 'wyzeman has modifyed user: CTD info.'),
(28, 1440816247, 0, 'wyzeman has modifyed user: CTD info.'),
(29, 1440816247, 0, 'wyzeman has modifyed user: CTD info.'),
(30, 1440816330, 0, 'wyzeman has modifyed user: CTD info.'),
(31, 1440816330, 0, 'wyzeman has modifyed user: CTD info.'),
(32, 1440816438, 0, 'wyzeman has modifyed user: CTD info.'),
(33, 1440816438, 0, 'wyzeman has modifyed user: CTD info.'),
(34, 1440816476, 0, 'wyzeman has modifyed user: CTD info.'),
(35, 1440816476, 0, 'wyzeman has modifyed user: CTD info.'),
(36, 1440816703, 0, 'wyzeman has modifyed user: CTD info.'),
(37, 1440816727, 0, 'wyzeman has modifyed user: CTD info.'),
(38, 1440817012, 0, 'wyzeman has created a new group: test'),
(39, 1440817127, 0, 'wyzeman has deleted the group: test'),
(40, 1440817378, 0, 'wyzeman has modifyed user: X info.'),
(41, 1440817384, 0, 'wyzeman has modifyed user: X info.'),
(42, 1440819600, 0, 'wyzeman has left the building.'),
(43, 1440819769, 0, 'wyzeman has left the building.'),
(44, 1440819819, 0, 'wyzeman has left the building.'),
(45, 1440819880, 0, 'wyzeman has left the building.'),
(46, 1440819919, 0, 'wyzeman has left the building.'),
(47, 1440819924, 0, 'wyzeman has join the room.'),
(48, 1440819956, 0, 'wyzeman has left the building.'),
(49, 1440820024, 0, 'wyzeman has left the building.'),
(50, 1440820028, 0, 'wyzeman has join the room.'),
(51, 1440820055, 0, 'wyzeman has left the building.'),
(52, 1440820059, 0, 'wyzeman has join the room.'),
(53, 1440820495, 0, 'wyzeman has left the building.'),
(54, 1440820567, 0, 'wyzeman has left the building.'),
(55, 1440820594, 0, 'wyzeman has left the building.'),
(56, 1440820617, 0, 'wyzeman has left the building.'),
(57, 1440820640, 0, 'wyzeman has left the building.'),
(58, 1440820688, 0, 'wyzeman has left the building.'),
(59, 1440820727, 0, 'wyzeman has left the building.'),
(60, 1440820826, 0, 'wyzeman has left the building.'),
(61, 1440820897, 0, 'wyzeman has left the building.'),
(62, 1440820936, 0, 'wyzeman has left the building.'),
(63, 1440820941, 0, 'wyzeman has join the room.'),
(64, 1440820953, 0, 'wyzeman has left the building.'),
(65, 1440820967, 0, 'wyzeman has join the room.'),
(66, 1440820969, 0, 'wyzeman has left the building.'),
(67, 1440820987, 0, 'wyzeman has join the room.'),
(68, 1440820997, 0, 'wyzeman has left the building.'),
(69, 1440821017, 0, 'wyzeman has join the room.'),
(70, 1440821029, 0, 'wyzeman has left the building.'),
(71, 1440821034, 0, 'wyzeman has join the room.'),
(72, 1440821042, 0, 'wyzeman has left the building.'),
(73, 1440821057, 0, 'wyzeman has join the room.'),
(74, 1440821058, 0, 'wyzeman has left the building.'),
(75, 1440821098, 0, 'wyzeman has join the room.'),
(76, 1440821100, 0, 'wyzeman has left the building.'),
(77, 1440821117, 0, 'wyzeman has join the room.'),
(78, 1440821118, 0, 'wyzeman has left the building.'),
(79, 1440821139, 0, 'wyzeman has join the room.'),
(80, 1440821142, 0, 'wyzeman has left the building.'),
(81, 1440821154, 0, 'wyzeman has join the room.'),
(82, 1440821155, 0, 'wyzeman has left the building.'),
(83, 1440821204, 0, 'wyzeman has left the building.'),
(84, 1440821260, 0, 'wyzeman has left the building.'),
(85, 1440821264, 0, 'wyzeman has join the room.'),
(86, 1440821266, 0, 'wyzeman has left the building.'),
(87, 1440821337, 0, 'wyzeman has join the room.'),
(88, 1440821392, 0, 'wyzeman has left the building.'),
(89, 1440821398, 0, 'wyzeman has join the room.'),
(90, 1440821449, 0, 'wyzeman has left the building.'),
(91, 1440821538, 0, 'wyzeman has left the building.'),
(92, 1440821621, 0, 'wyzeman has left the building.'),
(93, 1440821643, 0, 'wyzeman has left the building.'),
(94, 1440821647, 0, 'wyzeman has join the room.'),
(95, 1440821669, 0, 'wyzeman has left the building.'),
(96, 1440828601, 0, 'wyzeman has join the room.');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_groups`
--

INSERT INTO `tb_groups` (`id`, `name`, `parent_group`, `deleted`, `timestamp_created`, `active`) VALUES
(1, 'Mindkind', -1, 0, 0, 1),
(4, '3B tech', -1, 0, 1440640584, 1),
(6, 'Mind Over Machine', 1, 0, 1440813864, 1),
(7, 'X', 6, 0, 1440815500, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_sessions`
--

INSERT INTO `tb_sessions` (`id`, `id_user`, `timestamp_created`, `timestamp_last_activity`, `hostname`, `url_last_activity`) VALUES
(1, 2, 1440828600, 1440894930, '127.0.0.1', '/predacow/events.php');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `email_address`, `user_level`, `id_group`, `default_language`, `last_visit_hostname`, `last_visit_datetime`, `active`, `timestamp_created`, `deleted`) VALUES
(2, 'wyzeman', '$5$$QzsRjyEpRrd7eAfj8LYNYNPNkvoadO7HZyOXNKTRDe2', 'cyberwyze@hotmail.com', 255, 1, 'fr_CA', '127.0.0.1', 2015, 1, 1440380616, 0),
(3, 'qwz', '$5$$sAQhvOPvB6fmGGoaZ1nlayOIIZ6P9pRhMEBnPEs2IR8', 'qwz@hotmail.com', 255, 1, 'en_US', '127.0.0.1', 2015, 1, 1440556652, 0),
(4, 'CTD', '$5$$2i.aX8wIsNKClIK4a.XfxK68UqhEF1GR/Y/1aRrAlb.', 'ctd@3btech.ca', 100, 7, 'en_US', '127.0.0.1', 2015, 1, 1440640928, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users_geolocalisation`
--

CREATE TABLE IF NOT EXISTS `tb_users_geolocalisation` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `country` varchar(75) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `region` varchar(5) NOT NULL,
  `region_name` varchar(75) NOT NULL,
  `city` varchar(75) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `lat` varchar(25) NOT NULL,
  `lon` varchar(25) NOT NULL,
  `timezone` varchar(75) NOT NULL,
  `isp` varchar(75) NOT NULL,
  `org` varchar(75) NOT NULL,
  `aka` varchar(75) NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users_geolocalisation`
--

INSERT INTO `tb_users_geolocalisation` (`id`, `id_user`, `country`, `country_code`, `region`, `region_name`, `city`, `zip`, `lat`, `lon`, `timezone`, `isp`, `org`, `aka`, `ip`) VALUES
(0, 2, 'Canada', '', '', '', '', '', '', '', '', '', '', '', ''),
(0, 2, 'Canada', 'CA', '', '', '', '', '', '', '', '', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', '', '', '', '', '', '', '', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', '', '', '', '', '', '', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', '', '', '', '', '', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '', '', '', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '-71.2706', '', '', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '-71.2706', 'America/Toronto', '', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '-71.2706', 'America/Toronto', 'Bell Canada', '', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '-71.2706', 'America/Toronto', 'Bell Canada', 'Bell Canada', '', ''),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '-71.2706', 'America/Toronto', 'Bell Canada', 'Bell Canada', 'AS577 Bell Canada', '70.24.199.229'),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '-71.2706', 'America/Toronto', 'Bell Canada', 'Bell Canada', 'AS577 Bell Canada', '70.24.199.229'),
(0, 2, 'Canada', 'CA', 'QC', 'Quebec', 'Québec', 'G1M', '46.8183', '-71.2706', 'America/Toronto', 'Bell Canada', 'Bell Canada', 'AS577 Bell Canada', '70.24.199.229');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=138;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `tb_groups`
--
ALTER TABLE `tb_groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_webchat`
--
ALTER TABLE `tb_webchat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_webchat_chatrooms`
--
ALTER TABLE `tb_webchat_chatrooms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
