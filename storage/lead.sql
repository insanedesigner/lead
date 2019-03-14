-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2019 at 01:25 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lead`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `id_agency` int(11) NOT NULL,
  `agency_name` varchar(500) DEFAULT NULL,
  `points` varchar(150) DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `website` varchar(300) DEFAULT NULL,
  `remarks` varchar(10000) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `edited_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`id_agency`, `agency_name`, `points`, `contact_person`, `email`, `phone`, `website`, `remarks`, `status`, `created_by`, `created_date`, `edited_by`, `edited_date`) VALUES
(1, 'Luka', '1500', 'lukis', 'luka@luka.com', '7907487010', 'luka.com', NULL, 1, NULL, NULL, NULL, NULL),
(2, 'Dubicell', '2000', 'barak', 'dubicell@gmail.com', '7907487010', 'dubizel.com', NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `business_key_details`
--

CREATE TABLE `business_key_details` (
  `id` int(11) NOT NULL,
  `business_key` varchar(150) DEFAULT NULL,
  `key_value` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business_key_details`
--

INSERT INTO `business_key_details` (`id`, `business_key`, `key_value`, `description`) VALUES
(1, 'ED', 'Enable', ''),
(2, 'ED', 'Disable', '');

-- --------------------------------------------------------

--
-- Table structure for table `mapping_user_role_screen`
--

CREATE TABLE `mapping_user_role_screen` (
  `id_user_role_screen_map` int(11) NOT NULL,
  `id_user_role` int(11) NOT NULL,
  `id_user_screen` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapping_user_role_screen`
--

INSERT INTO `mapping_user_role_screen` (`id_user_role_screen_map`, `id_user_role`, `id_user_screen`, `created_date`, `edited_date`) VALUES
(1, 1, 1, '2018-02-28 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 2, '2018-02-28 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 3, '2018-02-28 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 4, '2018-02-28 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `screens`
--

CREATE TABLE `screens` (
  `id_screen` int(11) NOT NULL,
  `screen_name` varchar(500) DEFAULT NULL,
  `screen_key` varchar(100) DEFAULT NULL,
  `sub_screen` varchar(500) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `edited_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `screens`
--

INSERT INTO `screens` (`id_screen`, `screen_name`, `screen_key`, `sub_screen`, `created_date`, `edited_date`) VALUES
(1, 'Administrator Dashboard', 'AdminDash', '', NULL, NULL),
(2, 'Agency', 'Agency', '[1,2,3,4]', NULL, NULL),
(3, 'Manage Agency', 'ManageAgency', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_screens`
--

CREATE TABLE `sub_screens` (
  `id_sub_screens` int(11) NOT NULL,
  `sub_screen_name` varchar(150) NOT NULL,
  `created_date` int(11) NOT NULL,
  `edited_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_screens`
--

INSERT INTO `sub_screens` (`id_sub_screens`, `sub_screen_name`, `created_date`, `edited_date`) VALUES
(1, 'Add', 0, 0),
(2, 'Edit\r\n', 0, 0),
(3, 'Delete', 0, 0),
(4, 'View', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table 9`
--

CREATE TABLE `table 9` (
  `COL 1` int(1) DEFAULT NULL,
  `COL 2` varchar(15) DEFAULT NULL,
  `COL 3` varchar(9) DEFAULT NULL,
  `COL 4` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table 9`
--

INSERT INTO `table 9` (`COL 1`, `COL 2`, `COL 3`, `COL 4`) VALUES
(1, 'ED', 'Enable', ''),
(2, 'ED', 'Disable', ''),
(3, 'COURSE DURATION', 'Full Time', ''),
(4, 'COURSE DURATION', 'Part Time', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `id_user_info` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `id_user_info`) VALUES
(1, 'admin', '$2y$10$1GNAPvmmWqQjgV9fiT3mzubPx2vaMENixhYW2VIQt9ShH4LZ/HBaW', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id_user_info` int(11) NOT NULL,
  `id_user_type` int(11) DEFAULT NULL,
  `id_user_role` int(11) DEFAULT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `addres` varchar(10000) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `edited_by` int(11) NOT NULL,
  `edited_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id_user_info`, `id_user_type`, `id_user_role`, `first_name`, `last_name`, `gender`, `addres`, `email`, `phone`, `created_by`, `created_date`, `edited_by`, `edited_date`) VALUES
(1, 1, 1, 'Vyshakh', 'Ps', 'Male', '', 'vyshakh@spiderworks.in', '7907487010', 1, '2018-02-28 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(11) NOT NULL,
  `role_name` varchar(250) DEFAULT NULL,
  `role_key` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `edited_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_role`, `role_name`, `role_key`, `created_date`, `edited_date`) VALUES
(1, 'Administrator', 'admin', '2018-02-28 00:00:00', NULL),
(2, 'User', 'User', '2018-02-28 00:00:00', NULL),
(3, 'Assigned Leads', 'AssignedLeads', NULL, NULL),
(4, 'UnAssigned Leads', 'Unassigned', NULL, NULL),
(5, 'Finance', 'Finance', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id_user_type` int(11) NOT NULL,
  `type_name` varchar(250) DEFAULT NULL,
  `type_key` varchar(10) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `edited_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id_user_type`, `type_name`, `type_key`, `created_date`, `edited_date`) VALUES
(1, 'Super Admin', 'su', '2018-02-28 00:00:00', '0000-00-00 00:00:00'),
(2, 'Administrator', 'admin', NULL, NULL),
(3, 'User', 'user', NULL, NULL),
(4, 'Agency', 'agency', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`id_agency`);

--
-- Indexes for table `business_key_details`
--
ALTER TABLE `business_key_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapping_user_role_screen`
--
ALTER TABLE `mapping_user_role_screen`
  ADD PRIMARY KEY (`id_user_role_screen_map`);

--
-- Indexes for table `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`id_screen`);

--
-- Indexes for table `sub_screens`
--
ALTER TABLE `sub_screens`
  ADD PRIMARY KEY (`id_sub_screens`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id_user_info`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id_user_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `id_agency` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `business_key_details`
--
ALTER TABLE `business_key_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mapping_user_role_screen`
--
ALTER TABLE `mapping_user_role_screen`
  MODIFY `id_user_role_screen_map` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `screens`
--
ALTER TABLE `screens`
  MODIFY `id_screen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_screens`
--
ALTER TABLE `sub_screens`
  MODIFY `id_sub_screens` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id_user_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id_user_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
