-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2020 at 07:03 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acc_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `donner_fund_detail`
--

CREATE TABLE `donner_fund_detail` (
  `id` int(11) NOT NULL,
  `office_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gl_acc_code` bigint(15) NOT NULL,
  `fund_type` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fund_type_desc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fund_pay_frequency` varchar(15) NOT NULL,
  `pay_method` varchar(10) NOT NULL,
  `pay_curr` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_amt` decimal(17,2) NOT NULL,
  `allow_flag` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_of_pay` int(3) NOT NULL,
  `donner_pay_amt` decimal(17,2) NOT NULL,
  `num_of_paid` int(3) NOT NULL,
  `donner_paid_amt` decimal(17,2) NOT NULL,
  `fund_paid_flag` varchar(5) NOT NULL,
  `last_paid_date` date NOT NULL,
  `effect_date` date NOT NULL,
  `terminate_date` date NOT NULL,
  `ss_creator` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ss_creator_on` date NOT NULL,
  `ss_modifier` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ss_modified_on` date NOT NULL,
  `ss_org_no` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donner_fund_detail`
--

INSERT INTO `donner_fund_detail` (`id`, `office_code`, `member_id`, `gl_acc_code`, `fund_type`, `fund_type_desc`, `fund_pay_frequency`, `pay_method`, `pay_curr`, `pay_amt`, `allow_flag`, `num_of_pay`, `donner_pay_amt`, `num_of_paid`, `donner_paid_amt`, `fund_paid_flag`, `last_paid_date`, `effect_date`, `terminate_date`, `ss_creator`, `ss_creator_on`, `ss_modifier`, `ss_modified_on`, `ss_org_no`) VALUES
(1, '9900', '1', 0, '1', 'Fitra', 'Yearly', 'Fixed', '02', '450.00', '1', 2, '500.00', 2, '1000.00', '', '2020-07-13', '2020-07-01', '2020-07-31', 'abdullah', '2017-07-01', '', '0000-00-00', '9900'),
(2, '9900', '1', 0, '2', 'Jakat', 'Yearly', 'Fixed', '02', '65.00', '1', 1, '250.00', 1, '250.00', '', '2020-07-13', '2020-07-01', '2020-07-31', 'abdullah', '2017-07-01', '', '0000-00-00', '9900'),
(3, '9900', '1', 0, '3', 'Sadka', 'Monthly', 'Percentage', '02', '500.00', '1', 2, '200.00', 2, '400.00', '', '2020-07-13', '2020-07-01', '2020-07-31', 'abdullah', '2017-07-01', '', '0000-00-00', '9900');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donner_fund_detail`
--
ALTER TABLE `donner_fund_detail`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donner_fund_detail`
--
ALTER TABLE `donner_fund_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
