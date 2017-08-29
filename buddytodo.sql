-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2017 at 01:19 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buddytodo`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `list_id` int(11) NOT NULL,
  `list_public_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `list_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `list_assigned_by` int(11) NOT NULL,
  `list_assigned_to` int(11) NOT NULL,
  `list_created_at` datetime NOT NULL,
  `list_created_by` int(11) NOT NULL,
  `list_updated_at` datetime NOT NULL,
  `list_updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`list_id`, `list_public_id`, `list_name`, `list_assigned_by`, `list_assigned_to`, `list_created_at`, `list_created_by`, `list_updated_at`, `list_updated_by`) VALUES
(1, 'ab51e133-a81e-4ebb-b15b-25ca61d3215a', 'Helo', 3, 4, '2017-08-30 01:27:41', 3, '0000-00-00 00:00:00', 0),
(2, '99693551-96d3-4c9d-83ed-b45830264d0e', 'First Task List', 3, 4, '2017-08-30 01:28:19', 3, '0000-00-00 00:00:00', 0),
(3, '6cbb43cc-f707-447d-b135-98705d9c05df', 'Your very first task', 4, 3, '2017-08-30 01:46:40', 4, '0000-00-00 00:00:00', 0),
(4, 'b43d4264-f1ee-41ac-8637-ad1c4ad83428', 'Second Task', 4, 3, '2017-08-30 01:47:44', 4, '0000-00-00 00:00:00', 0),
(5, 'c3168090-f77a-4b82-83c8-84e81d630d75', 'Hello World', 4, 3, '2017-08-30 01:47:59', 4, '0000-00-00 00:00:00', 0),
(6, 'f261a087-dd27-4e8d-a290-dde8030f6582', 'Travelling Todos', 3, 3, '2017-08-30 03:50:55', 3, '0000-00-00 00:00:00', 0),
(7, 'be01f48f-ed1c-4a72-bd2c-461e9496d7bb', 'Another Task List', 3, 4, '2017-08-30 04:01:26', 3, '0000-00-00 00:00:00', 0),
(8, 'c5a6fff6-b850-4318-a22e-44988acd4145', 'Sample Task List', 8, 3, '2017-08-30 04:47:01', 8, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_public_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role_permission_strings` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_public_id`, `role_name`, `role_permission_strings`, `role_slug`) VALUES
(1, 'f4bffd52-9469-4f62-a342-6279c53c175e', 'Admin', 'user-create/user-update/user-delete/user-view/is-admin', 'admin'),
(2, '62278504-b497-4297-8745-62b270ed3ed4', 'User', 'is-user', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_public_id` varchar(255) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  `task_iscompleted` tinyint(4) NOT NULL DEFAULT '0',
  `task_description` text NOT NULL,
  `task_created_at` datetime NOT NULL,
  `task_created_by` int(11) NOT NULL,
  `task_updated_at` datetime NOT NULL,
  `task_updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_public_id`, `task_list_id`, `task_iscompleted`, `task_description`, `task_created_at`, `task_created_by`, `task_updated_at`, `task_updated_by`) VALUES
(1, '9cdb3af9-c056-4515-87aa-7ba310097ed9', 4, 1, 'We provide solutions to track customers uniquely for their entire visit duration in a particular location. We harness the power of data analytics to provide a scalable and affordable solution to retailers to understand opportunity, engagement and loyalty across the chain of stores.', '2017-08-30 02:40:16', 3, '0000-00-00 00:00:00', 0),
(2, '7a5375e7-974e-4506-8d41-d0a48854462f', 4, 1, 'We are building a technology platform which will help retailers understand their customers and provide actionable insights which can be used to justify overall marketing, merchandising and operational decisions.', '2017-08-30 02:58:27', 3, '0000-00-00 00:00:00', 0),
(3, 'de1ee1a9-9b7a-4d72-ba40-ac7d6335e4f4', 4, 1, 'We are solving some of the toughest problems faced due to complexity in wireless sensor networks, representation of indoor locations, processing of large data efficiently, generating insights, and high availability of large scale systems.', '2017-08-30 02:59:58', 3, '0000-00-00 00:00:00', 0),
(4, 'd7eb06e2-51e5-4421-9dcf-229b31ab4822', 4, 1, 'Hello World', '2017-08-30 03:00:06', 3, '0000-00-00 00:00:00', 0),
(5, '705f0c64-1403-41b7-bc48-c772718053e5', 2, 0, 'Clean your own shit.', '2017-08-30 04:29:07', 3, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_public_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_mobile` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_password` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_created_by` int(11) NOT NULL,
  `user_updated_at` datetime NOT NULL,
  `user_updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_public_id`, `user_role`, `user_name`, `user_email`, `user_mobile`, `user_password`, `user_created_at`, `user_created_by`, `user_updated_at`, `user_updated_by`) VALUES
(1, 'be5cbf06-610f-4413-81a4-d2515c75e956', 1, 'Admin', 'admin@admin.com', NULL, '21c95d2f6e6609e5df7292618165fddc', '2017-08-29 20:17:25', 1, '0000-00-00 00:00:00', 0),
(3, 'e981723f-ded4-4994-b771-fe83b5fdffed', 2, 'Vikas Gupta', 'vkg091@gmail.com', NULL, 'bdc742735d244d0dc457271e37cb2d04', '2017-08-29 20:19:52', 1, '2017-08-30 04:35:02', 1),
(4, 'e6c463a2-21b8-436a-a5ec-d4bfcf086147', 2, 'Adwait Gupta', 'adwait@gmail.com', NULL, 'a7c178c3730dce63b01982e95528696e', '2017-08-29 21:34:43', 1, '0000-00-00 00:00:00', 0),
(8, 'e3ba4c2c-c04e-4600-85c4-779003eb4dea', 2, 'Test', 'test@user.com', NULL, 'cdfa6c6e1dc1e2ed427c930cbeffb7f3', '2017-08-30 04:46:05', 1, '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`list_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
