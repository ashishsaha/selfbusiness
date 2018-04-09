-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2017 at 11:37 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookingnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `corporate_accounts`
--

CREATE TABLE IF NOT EXISTS `corporate_accounts` (
`id` int(4) NOT NULL,
  `name` varchar(200) NOT NULL,
  `corporate_email` varchar(50) NOT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `directory_url` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0: Disabled 1: Enabled'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `corporate_accounts`
--

INSERT INTO `corporate_accounts` (`id`, `name`, `corporate_email`, `contact_number`, `directory_url`, `status`) VALUES
(1, 'Booking System', 'ashish@goldsynctech.com', '83718487', 'localhost/ci', 1),
(2, 'Corporate Account 2', 'a@a.com', '123456', 'abb', 1),
(3, 'sfsdfdsf', 'a@a.com', '1234563', 'localhost/ci1', -1),
(4, 'Booking System abd', 'a@a.com', '123', 'abd', 1),
(5, 'Booking System abc', 'a@a.com', '123456', 'abc', 1),
(6, 'New booking System', 'aaa@aaa.com', '123456', 'xyz', 1),
(7, 'CA 10', 'ca10@ca10.com', '1244', 'ca10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `icon_images`
--

CREATE TABLE IF NOT EXISTS `icon_images` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon_image` varchar(255) DEFAULT NULL,
  `no_of_useage` int(5) DEFAULT '0' COMMENT 'if any image use one time then this value will be added',
  `status` tinyint(1) DEFAULT '1' COMMENT '1: available 0:unavailable  : status will be 0, only if no_of_useage is equal 0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `icon_images`
--

INSERT INTO `icon_images` (`id`, `name`, `icon_image`, `no_of_useage`, `status`) VALUES
(1, 'One 22', '14812872368f505ed4fb38c5b87dc4c6802d824e58.png', 0, -1),
(2, 'Image One', '1481287932default-icon.png', 2, 1),
(3, 'Image one 55', '1481522658b.png', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `icon_image_services`
--

CREATE TABLE IF NOT EXISTS `icon_image_services` (
`id` int(11) NOT NULL,
  `icon_image_id` int(11) NOT NULL,
  `service_id` int(4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`id` int(2) NOT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT 'Role Name',
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`) VALUES
(1, 'System Super Admin', 1),
(2, 'Corporate Super Admin', 1),
(3, 'Admin', 1),
(4, 'Staff ', 1),
(5, 'Customer ', 1),
(6, 'User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
`id` int(11) NOT NULL,
  `corporate_account_id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `service_image` varchar(255) DEFAULT NULL,
  `min_price` float(10,2) DEFAULT '0.00',
  `max_price` float(10,2) DEFAULT '0.00',
  `duration` int(4) NOT NULL COMMENT 'in minute value',
  `staff_selection_type` tinyint(1) DEFAULT '0' COMMENT '0: None 1: Single',
  `is_show_service_description` tinyint(1) DEFAULT '0',
  `is_show_price_range` tinyint(1) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Unavailable 1: Available',
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `corporate_account_id`, `name`, `description`, `service_image`, `min_price`, `max_price`, `duration`, `staff_selection_type`, `is_show_service_description`, `is_show_price_range`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 1, 'Servic One1', 'nndfdfd', '14824118357a59b5ecf18077fd23f8570a31631b15.png', 10.00, 0.00, 40, 1, 0, 1, 1, 1, '2016-12-14 13:16:38', 2, '2016-12-22 18:33:55'),
(2, 2, 'Service1', 'ccddfd', '1481782293b.png', 10.00, 12.00, 40, 1, 0, 1, 1, 1, '2016-12-15 11:41:33', 2, '2016-12-22 18:15:11'),
(3, 2, 'Service Ten', 'asfdsfdsf', '1481287932default-icon.png', 0.00, 0.00, 45, 1, 0, 1, 1, 1, '2016-12-15 12:04:42', 1, '2016-12-15 14:58:10'),
(4, 1, 'ss', 'terer3e', '1481522658b.png', 0.00, 0.00, 50, 1, 1, 1, -1, 1, '2016-12-15 12:07:04', NULL, NULL),
(5, 2, 'Service Elevent', NULL, '1483365783avatar-8.jpg', 0.00, 0.00, 60, 1, 0, 0, 1, 2, '2017-01-02 19:33:03', 2, '2017-01-02 19:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
`id` int(11) NOT NULL,
  `corporate_account_id` int(4) NOT NULL,
  `time_increment_val` int(3) NOT NULL,
  `appointment_duration` int(3) NOT NULL,
  `is_corp_super_create_cutomer` tinyint(1) NOT NULL DEFAULT '0',
  `is_customer_mobile_no_required` tinyint(1) NOT NULL DEFAULT '0',
  `staff_selection_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: None 1: Single',
  `is_show_staff_mobile_no` tinyint(1) NOT NULL DEFAULT '0',
  `is_show_staff_profile_img` tinyint(1) NOT NULL DEFAULT '0',
  `service_selection_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: None 1: Single 2: Multiple',
  `is_show_service_description` tinyint(1) NOT NULL DEFAULT '0',
  `is_show_price_range` tinyint(1) NOT NULL DEFAULT '0',
  `is_automatic_booking_status_change` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Pending to Completed',
  `is_show_bg_on_customer_panel` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Which color will show?',
  `is_show_text_color_on_customer_panel` tinyint(1) NOT NULL DEFAULT '0',
  `is_show_logo_on_cutomer_panel` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `corporate_account_id`, `time_increment_val`, `appointment_duration`, `is_corp_super_create_cutomer`, `is_customer_mobile_no_required`, `staff_selection_type`, `is_show_staff_mobile_no`, `is_show_staff_profile_img`, `service_selection_type`, `is_show_service_description`, `is_show_price_range`, `is_automatic_booking_status_change`, `is_show_bg_on_customer_panel`, `is_show_text_color_on_customer_panel`, `is_show_logo_on_cutomer_panel`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 1, 30, 50, 1, 1, 1, 1, 0, 1, 0, 1, 1, 0, 1, 1, NULL, NULL, NULL, NULL),
(2, 2, 30, 60, 0, 1, 1, 1, 0, 1, 1, 0, 1, 1, 0, 0, NULL, NULL, 2, '2017-01-02 19:36:52'),
(3, 4, 30, 60, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, NULL, NULL, 1, '2016-12-22 19:50:59'),
(4, 7, 30, 30, 1, 1, 0, 1, 1, 2, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings_customer_interface`
--

CREATE TABLE IF NOT EXISTS `settings_customer_interface` (
`id` int(3) NOT NULL,
  `corporate_account_id` int(3) NOT NULL,
  `default_bg_img` varchar(255) NOT NULL,
  `default_profile_img` varchar(255) NOT NULL,
  `default_logo_img` varchar(255) NOT NULL,
  `text_color` varchar(100) NOT NULL,
  `box_outline_color` varchar(100) NOT NULL,
  `box_bg_color` varchar(100) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings_customer_interface`
--

INSERT INTO `settings_customer_interface` (`id`, `corporate_account_id`, `default_bg_img`, `default_profile_img`, `default_logo_img`, `text_color`, `box_outline_color`, `box_bg_color`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 2, '14815391677a59b5ecf18077fd23f8570a31631b15.png', '148153916716ecefdb45cb98b7f9b8d1ecfa801340.png', '1481539167a.png', '#1e0525', '#2f962c', '#542543', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
(2, 3, '1481893948a.png', '1481893948user.png', '1481893948b.png', '#1d1d1d', '#842661', '#668549', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00'),
(3, 4, '14818949478f505ed4fb38c5b87dc4c6802d824e58.png', '1481894947a.png', '1481894947484af1be8efd44e4686ae6f918565969.png', '#000000', '#000000', '#48a543', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff_services`
--

CREATE TABLE IF NOT EXISTS `staff_services` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_services`
--

INSERT INTO `staff_services` (`id`, `user_id`, `service_id`) VALUES
(1, 0, 1),
(2, 1, 2),
(13, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff_settings`
--

CREATE TABLE IF NOT EXISTS `staff_settings` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `staff_selection_type` tinyint(1) DEFAULT '0' COMMENT 'None 1: Single',
  `is_show_staff_mobile_no` tinyint(1) DEFAULT NULL,
  `is_show_staff_profile_img` tinyint(1) DEFAULT NULL,
  `is_email_notification_active` tinyint(1) DEFAULT '0',
  `name_presentation_style` tinyint(1) DEFAULT '0' COMMENT '0: First Name/ Last Name 1: Last Name / First Name '
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_settings`
--

INSERT INTO `staff_settings` (`id`, `user_id`, `staff_selection_type`, `is_show_staff_mobile_no`, `is_show_staff_profile_img`, `is_email_notification_active`, `name_presentation_style`) VALUES
(1, 9, 1, 1, 0, 1, 0),
(2, 10, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `corporate_account_id` int(4) NOT NULL,
  `salutation` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(50) NOT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `activation_hash` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1: Active/ 0: Suspended',
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `corporate_account_id`, `salutation`, `first_name`, `last_name`, `username`, `password`, `contact_no`, `profile_image`, `activation_hash`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 1, 'Mr.', 'Ashsih', 'Saha', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', '83748483', '1482838580avatar-9.jpg', NULL, 1, 1, '2016-12-04 00:00:00', 1, '2016-12-27 17:06:20'),
(2, 2, 'Prof.', 'Anirban', 'Dutta', 'corporate@gmail.com', 'afdd0b4ad2ec172c586e2150770fbf9e', '123', '', NULL, 1, 1, '2016-12-14 18:58:18', 1, '2017-01-24 19:05:17'),
(3, 3, 'Mr.', 'Sanjib', 'Karmakar', 'corporate@abd.com', '202cb962ac59075b964b07152d234b70', '', '1481874288a.png', NULL, 1, 1, '2016-12-16 13:04:39', 1, '2016-12-16 13:14:48'),
(4, 4, 'Mr.', 'Anuran', 'Singha', 'corporate@abc.com', '202cb962ac59075b964b07152d234b70', '', '1481875268a.png', NULL, 1, 1, '2016-12-16 13:18:07', 4, '2016-12-23 20:49:57'),
(5, 7, 'Prof.', 'Anirban', 'Dutta', 'corporate@ca10.com', '202cb962ac59075b964b07152d234b70', '', '1482129575a.png', NULL, 1, 1, '2016-12-19 12:09:35', NULL, NULL),
(6, 7, 'Mr.', 'Darren', 'Ong', 'staff@ca10.com', '202cb962ac59075b964b07152d234b70', '', '1482131352a.png', NULL, 1, 5, '2016-12-19 12:39:12', NULL, NULL),
(7, 7, 'Mr.', 'Anirban', 'Dutta', 'customerca10@ca10.com', 'd9b1d7db4cd6e70935368a1efb10e377', '123', '1482159688a.png', NULL, 1, 6, '2016-12-19 19:17:54', 6, '2016-12-19 20:31:28'),
(8, 2, 'Mr.', 'Anuran', 'Vhatachaya', 'admin@ca2.com', '202cb962ac59075b964b07152d234b70', '111111', '1482311110a.png', 'a2a5c416bd1169e54f9e52b4b5907fdb', 1, 2, '2016-12-21 13:20:53', 2, '2016-12-28 20:22:48'),
(9, 2, 'Mr.', 'Sushovik', 'Ganguly', 'sus@ca02.com', '202cb962ac59075b964b07152d234b70', '112233', '1482328428a.png', NULL, 1, 2, '2016-12-21 19:23:48', NULL, NULL),
(10, 2, 'Mr.', 'Sanjoy', 'Dey', 'staffsanjoy@ca02.com', '202cb962ac59075b964b07152d234b70', '111111222', '1482402149484af1be8efd44e4686ae6f918565969.png', NULL, 1, 2, '2016-12-21 19:35:33', 2, '2016-12-22 20:22:32'),
(11, 2, 'Mrs.', 'Joy', 'Ong', 'customerjoy@ca02.com', '202cb962ac59075b964b07152d234b70', '11123', '1482475799a.png', NULL, 1, 10, '2016-12-23 12:19:59', 2, '2016-12-26 11:57:51'),
(12, 1, 'Mr.', 'Aritra', 'Ganguly', 'aritra@goldsynctech.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, NULL, '2016-12-27 19:35:25', NULL, NULL),
(13, 1, 'Mr.', 'A', 'S', 'customer@ca.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, NULL, '2016-12-27 19:42:25', NULL, NULL),
(14, 1, 'Mr.', 'Sourav', 'Gupta', 'sourav@goldsynctech.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, NULL, '2016-12-27 20:15:29', NULL, NULL),
(15, 4, 'Mr.', 'sush', 'abc', 'customer2@ca4.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, NULL, '2016-12-27 20:29:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(4, 3, 2),
(5, 4, 2),
(6, 5, 2),
(7, 6, 4),
(8, 7, 5),
(9, 8, 3),
(10, 10, 4),
(11, 11, 5),
(12, 12, 5),
(13, 13, 5),
(14, 14, 5),
(15, 15, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `corporate_accounts`
--
ALTER TABLE `corporate_accounts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icon_images`
--
ALTER TABLE `icon_images`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icon_image_services`
--
ALTER TABLE `icon_image_services`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_customer_interface`
--
ALTER TABLE `settings_customer_interface`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_services`
--
ALTER TABLE `staff_services`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_settings`
--
ALTER TABLE `staff_settings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `corporate_accounts`
--
ALTER TABLE `corporate_accounts`
MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `icon_images`
--
ALTER TABLE `icon_images`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `icon_image_services`
--
ALTER TABLE `icon_image_services`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `settings_customer_interface`
--
ALTER TABLE `settings_customer_interface`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `staff_services`
--
ALTER TABLE `staff_services`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `staff_settings`
--
ALTER TABLE `staff_settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
