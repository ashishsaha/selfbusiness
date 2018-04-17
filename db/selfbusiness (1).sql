-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2018 at 08:14 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `selfbusiness`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `status`, `created`) VALUES
(1, 'Ifaz', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `child_accounts`
--

CREATE TABLE `child_accounts` (
  `id` int(4) NOT NULL,
  `parent_account_id` int(3) NOT NULL,
  `name` varchar(550) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child_accounts`
--

INSERT INTO `child_accounts` (`id`, `parent_account_id`, `name`, `description`, `status`, `created`, `updated`) VALUES
(1, 1, 'CHILD ABCd', 'CHILD description teste', -1, NULL, NULL),
(2, 3, 'Mill Cost', 'Mill related expense', 1, NULL, NULL),
(3, 3, 'Pay to supplier', 'This is for supplier payment', 1, NULL, NULL),
(4, 3, 'Labor Bill', 'Bill for labor', 1, NULL, NULL),
(5, 3, 'Employee Bill', 'Test ABC bb', 1, NULL, NULL),
(6, 1, 'Receive from customer', 'Get payment from customer', 1, NULL, NULL),
(7, 3, 'Home cost', 'This is the cost for home', 1, NULL, NULL),
(8, 3, 'Daily cost', 'This is the expense for extra expense for mill (like - tea bill and so on)', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_setup`
--

CREATE TABLE `company_setup` (
  `id` int(3) NOT NULL,
  `company_name` varchar(512) DEFAULT NULL,
  `contact_no` varchar(80) DEFAULT NULL,
  `address` text,
  `proprietor` varchar(512) DEFAULT NULL,
  `bank_account_name` text,
  `bank_account_number` text,
  `bank_name` text,
  `bank_branch` text,
  `bank_location` text,
  `purchase_invoice_prefix` varchar(20) DEFAULT NULL,
  `sell_invoice_prefix` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_setup`
--

INSERT INTO `company_setup` (`id`, `company_name`, `contact_no`, `address`, `proprietor`, `bank_account_name`, `bank_account_number`, `bank_name`, `bank_branch`, `bank_location`, `purchase_invoice_prefix`, `sell_invoice_prefix`, `created`, `updated`) VALUES
(1, 'Geeta Daal Meals and Industries Ltd', '01712954527', 'Dignagar, Kanaipur', 'Tapon Saha', '["Shibu Saha"]', '["2132321"]', '["NBL"]', '["Kanaipur Bazar"]', '["Kanaipur"]', 'PINV', 'SINV', NULL, '2018-04-07 12:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_number` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_customer` tinyint(1) DEFAULT '0',
  `is_supplier` tinyint(1) DEFAULT '0',
  `employee_type` binary(1) DEFAULT '0' COMMENT '0: Supplier/Customer 1: Casual Labor 2: Labor 3: Employee',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bank_account_name` text,
  `bank_account_number` text,
  `bank_name` text,
  `bank_branch` text,
  `bank_location` text,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `contact_number`, `is_customer`, `is_supplier`, `employee_type`, `address`, `bank_account_name`, `bank_account_number`, `bank_name`, `bank_branch`, `bank_location`, `status`, `created`, `updated`) VALUES
(1, '​ভুবন দাস', '017438282821', 1, 0, 0x30, 'কানাইপুর ', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(2, 'আশীষ সাহা', '2343434434', 1, 1, 0x30, 'ফরিদপুর ', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(3, 'Sohel Shekh', '1232', 0, 1, 0x30, 'Faridpur', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(4, 'Madhob Saha', '2343434434', 1, 0, 0x30, '123', '["Ashish ","Madhob"]', '["23242","213213213"]', '["NBL","BL"]', '["Kanaipur","Kanipur"]', '["Faridpur","Kanaipur Bazar"]', 1, NULL, '2018-01-27 04:45:58'),
(5, 'Jeebon Debnath', '02343434434', 1, 1, 0x30, 'Address#1, Address#2', '["N\\/A"]', '["N\\/A"]', '["N\\/A"]', '["N\\/A"]', '["N\\/A"]', 1, NULL, NULL),
(6, 'Solaiman Baparry', '2343434434', 0, 0, 0x31, 'Mirgi', NULL, NULL, NULL, NULL, NULL, 1, '2018-01-22 11:23:44', NULL),
(7, 'Rahim Molla', '12323', 0, 0, 0x33, 'Sator', NULL, NULL, NULL, NULL, NULL, 1, '2018-01-30 09:29:21', NULL),
(8, 'Ranjon Saha', '1232323', 0, 0, 0x33, 'Address#1, Address#2', NULL, NULL, NULL, NULL, NULL, 1, '2018-01-30 09:30:04', NULL),
(9, 'Nannu Molla', '12345678', 0, 0, 0x31, 'Test', NULL, NULL, NULL, NULL, NULL, 1, '2018-01-31 08:13:11', NULL),
(10, 'Kamal Sheikh', '13123', 0, 0, 0x32, 'Labor', NULL, NULL, NULL, NULL, NULL, 1, '2018-01-31 08:16:08', NULL),
(11, 'Bappy Saha', '123123', 1, 0, 0x30, 'Pabna', '["N\\/A"]', '["N\\/A"]', '["N\\/A"]', '["N\\/A"]', '["N\\/A"]', 1, '2018-04-10 11:18:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) NOT NULL,
  `invoice_no` varchar(20) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `description` text,
  `transportation_cost` float(10,2) DEFAULT '0.00',
  `labor_cost` float(10,2) DEFAULT '0.00',
  `total_cost` float(14,2) DEFAULT '0.00' COMMENT 'Total cost of dynamic product sum(sub_total_price)',
  `accumulated_cost` float(14,2) DEFAULT '0.00',
  `invoice_type` tinyint(1) DEFAULT '0' COMMENT '0: purchase 1: sell',
  `status` tinyint(1) DEFAULT '1',
  `created_by` int(11) DEFAULT NULL COMMENT 'user_id',
  `updated_by` int(11) DEFAULT NULL COMMENT 'user_id',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `customer_id`, `description`, `transportation_cost`, `labor_cost`, `total_cost`, `accumulated_cost`, `invoice_type`, `status`, `created_by`, `updated_by`, `created`, `updated`) VALUES
(1, 'SINV000001', 5, '', 0.00, 0.00, 54205.00, 0.00, 1, 1, 1, NULL, '2018-04-16 10:54:21', NULL),
(2, 'SINV000002', 4, '', 0.00, 0.00, 39750.00, 0.00, 1, 1, 1, NULL, '2018-04-16 10:55:37', NULL),
(3, 'PINV000001', 3, '', 0.00, 0.00, 24150.00, 0.00, 0, 1, 1, NULL, '2018-04-16 10:57:08', NULL),
(4, 'PINV000002', 3, '', 0.00, 0.00, 51065.00, 0.00, 0, 1, 1, NULL, '2018-04-16 10:57:34', NULL),
(5, '3', 2, 'This group for the store management related 2', 0.00, 0.00, 26250.00, 0.00, 0, 1, 1, NULL, '2018-04-16 11:15:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint(20) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(3) DEFAULT NULL,
  `brand_id` int(2) DEFAULT NULL,
  `total_bosta` float(10,2) DEFAULT NULL,
  `bosta_per_kg` float(10,2) DEFAULT NULL,
  `total_maan` float(10,2) DEFAULT NULL,
  `total_kg` float(10,2) DEFAULT NULL,
  `price_per_bosta` float(10,2) DEFAULT NULL,
  `sub_total_price` float(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `product_id`, `brand_id`, `total_bosta`, `bosta_per_kg`, `total_maan`, `total_kg`, `price_per_bosta`, `sub_total_price`) VALUES
(1, 1, 4, 1, 20.00, 50.00, 25.00, 1000.00, 1750.00, 35000.00),
(2, 1, 2, 1, 23.00, 25.00, 14.38, 575.00, 835.00, 19205.00),
(3, 2, 2, 1, 50.00, 25.00, 31.25, 1250.00, 795.00, 39750.00),
(4, 3, 2, 1, 30.00, 25.00, 18.75, 750.00, 805.00, 24150.00),
(5, 4, 4, 1, 35.00, 50.00, 43.75, 1750.00, 1459.00, 51065.00),
(6, 5, 2, 1, 30.00, 25.00, 18.75, 750.00, 875.00, 26250.00);

-- --------------------------------------------------------

--
-- Table structure for table `parent_accounts`
--

CREATE TABLE `parent_accounts` (
  `id` int(3) NOT NULL,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parent_accounts`
--

INSERT INTO `parent_accounts` (`id`, `name`, `description`, `status`, `created`, `updated`) VALUES
(1, 'Income', 'Test ABC bb', 1, NULL, NULL),
(2, 'xxx', 'ttt', -1, NULL, NULL),
(3, 'Expense', 'All type of expense', 1, NULL, NULL),
(4, 'Asset', 'For asset calculation', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `status`, `created`, `updated`) VALUES
(1, 'চন্দনে', 'Test ss', -1, NULL, NULL),
(2, 'Musuri', 'Tet', 1, NULL, NULL),
(3, 'Khesari', 'Khesari Daal', -1, NULL, NULL),
(4, 'Mug', 'Mug Daal', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(2) NOT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT 'Role Name',
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`) VALUES
(1, 'System Super Admin', 1),
(2, 'Manager', 1),
(3, 'Staff', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` bigint(20) NOT NULL,
  `trans_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Hand Cash 1: Bank Transaction 3: Cheque',
  `ref_invoice_no` varchar(50) DEFAULT NULL,
  `child_account_id` varchar(255) NOT NULL,
  `payment_from_or_to` int(11) DEFAULT NULL COMMENT 'Actually here will be id of supplier/customer and if transaction is not against person then it should be save as 0',
  `amount` double(12,2) NOT NULL DEFAULT '0.00',
  `note` text,
  `status` tinyint(1) DEFAULT '1' COMMENT '-1 will be set when it will be deleted',
  `trans_date` datetime NOT NULL,
  `bank_account_from` varchar(255) DEFAULT NULL,
  `bank_account_to` varchar(255) DEFAULT NULL,
  `checque_no` varchar(255) DEFAULT NULL,
  `salary_month` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `trans_type`, `ref_invoice_no`, `child_account_id`, `payment_from_or_to`, `amount`, `note`, `status`, `trans_date`, `bank_account_from`, `bank_account_to`, `checque_no`, `salary_month`, `created_by`, `created`, `updated_by`, `updated`) VALUES
(1, 0, NULL, '7', 0, 475.00, 'Testb', 1, '2018-01-24 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(2, 1, NULL, '7', 0, 475.00, 'It was for flour purchase', 1, '2018-01-25 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(3, 2, NULL, '7', 0, 500.00, '', 1, '2018-01-24 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(4, 0, NULL, '7', 0, 350.00, 'Test', -1, '2018-01-26 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(5, 0, NULL, '7', 0, 7000.00, 'Purchase machine equipment', 1, '2018-01-25 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(6, 0, NULL, '2', 9, 6750.00, 'For parts purchasing', 1, '2018-01-26 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(7, 0, NULL, '8', 0, 78.00, 'Tea bill and biscuit bill ', 1, '2018-01-25 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(8, 1, NULL, '3', 5, 275000.00, 'It has been sent by Madhob', 1, '2018-01-26 00:00:00', 'Shibu Saha,2132321,NBL,Kanaipur Bazar,Kanaipur', 'Ashish ,23242,NBL,Kanaipur,Faridpur', NULL, NULL, 1, NULL, 1, '2018-01-31 00:00:00'),
(9, 0, NULL, '3', 2, 200000.00, '', 1, '2018-01-29 00:00:00', NULL, NULL, NULL, NULL, 1, '2018-01-29 00:00:00', 1, NULL),
(10, 0, NULL, '5', 7, 5000.00, 'It is last month Salary', 1, '2018-01-30 00:00:00', NULL, NULL, NULL, 'January', 1, '2018-01-30 00:00:00', 1, '2018-01-30 00:00:00'),
(11, 0, NULL, '2', 10, 800.00, '', 1, '2018-01-31 00:00:00', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(12, 0, NULL, '6', 5, 20000.00, 'note test', 1, '2018-01-31 00:00:00', NULL, NULL, NULL, NULL, 1, '2018-01-31 00:00:00', 1, '2018-01-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `corporate_account_id`, `salutation`, `first_name`, `last_name`, `username`, `password`, `contact_no`, `profile_image`, `activation_hash`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 0, 'Mr.', 'Ashsih', 'Saha', 'admin@test.com', 'afdd0b4ad2ec172c586e2150770fbf9e', '83748483', '1523013535user-png-image-15189.png', NULL, 1, 1, '2016-12-04 00:00:00', 1, '2018-04-07 12:44:46'),
(2, 2, 'Prof.', 'Anirban', 'Dutta', 'corporate@gmail.com', 'afdd0b4ad2ec172c586e2150770fbf9e', '123', '', NULL, 1, 1, '2016-12-14 18:58:18', 1, '2018-04-07 12:50:21'),
(3, 3, 'Mr.', 'Sanjib', 'Karmakar', 'corporate@abd.com', '202cb962ac59075b964b07152d234b70', '', '1481874288a.png', NULL, 1, 1, '2016-12-16 13:04:39', 1, '2016-12-16 13:14:48'),
(4, 0, 'Mr.', 'Bappy', 'Saha', 'bappy.ni@gmail.com', '202cb962ac59075b964b07152d234b70', '012355666', '1523034014user-png-image-15189.png', NULL, 1, 1, '2018-04-06 22:30:14', 1, '2018-04-07 12:45:17'),
(5, 0, 'Mr.', 'test', '123', 'test@gmail.com', '202cb962ac59075b964b07152d234b70', '123333', '1523037978user-png-image-15189.png', NULL, 1, 1, '2018-04-06 23:36:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(4, 3, 2),
(5, 4, 2),
(6, 5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `child_accounts`
--
ALTER TABLE `child_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_setup`
--
ALTER TABLE `company_setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_accounts`
--
ALTER TABLE `parent_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `child_accounts`
--
ALTER TABLE `child_accounts`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `company_setup`
--
ALTER TABLE `company_setup`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `parent_accounts`
--
ALTER TABLE `parent_accounts`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
