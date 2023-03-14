-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2023 at 05:59 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_master-form`
--

-- --------------------------------------------------------

--
-- Table structure for table `cis_menu_apps`
--

CREATE TABLE `cis_menu_apps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extends`
--

CREATE TABLE `extends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_id` tinyint(4) NOT NULL,
  `index_id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extend_files`
--

CREATE TABLE `extend_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `extend_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_helpdesks`
--

CREATE TABLE `file_helpdesks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_helpdesk_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_upload_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `helpdesks`
--

CREATE TABLE `helpdesks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thread_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_date` date NOT NULL,
  `ticket_source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `topic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `sla_id` bigint(20) UNSIGNED DEFAULT NULL,
  `duedate` datetime NOT NULL,
  `assign_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('open','closed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `outlet_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `out_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `analyer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `analyzer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cable_length` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_com` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_reg` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_module_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cis_menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lis_menu_app` bigint(20) UNSIGNED DEFAULT NULL,
  `reg_report_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pkg` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_date` datetime DEFAULT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_display` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk_threads`
--

CREATE TABLE `helpdesk_threads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `helpdesk_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assign_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk_topics`
--

CREATE TABLE `helpdesk_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_category` int(11) NOT NULL,
  `topic_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `helpdesk_topics`
--

INSERT INTO `helpdesk_topics` (`id`, `id_category`, `topic_name`, `created_by`, `edited_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'New Request', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(2, 1, 'New Request / LIS-CIS Features', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(3, 1, 'New Request / PC and Peripherals', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(4, 1, 'New Request / Server and Networking', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(5, 1, 'New Request / Adjusment', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(6, 1, 'New Request / Bridging', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(7, 2, 'New Request / Interfacing', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(8, 3, 'New Request / LIS-CIS Modules', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(9, 4, 'New Request / Reg Key', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(10, 5, 'New Request / Report and Data', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(11, 6, 'New Request / CIS App', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(12, 1, 'TroubleShoot & Adjusment / Interfacing', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(13, 1, 'TroubleShoot & Adjusment / Onsite MCU', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(14, 1, 'TroubleShoot & Adjusment / PC and Peripherals', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(15, 1, 'TroubleShoot & Adjusment / Phlebotomy System', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(16, 1, 'TroubleShoot & Adjusment / Networking', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(17, 3, 'TroubleShoot & Adjusment / LIS Modules', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(18, 3, 'TroubleShoot & Adjusment / LIS', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(19, 5, 'TroubleShoot & Adjusment / LIS App', 1, NULL, '2023-03-13 07:37:57', '2023-03-13 07:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `lis_cis_modules`
--

CREATE TABLE `lis_cis_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lis_menu_apps`
--

CREATE TABLE `lis_menu_apps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masterhelptopic`
--

CREATE TABLE `masterhelptopic` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `helptopicname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `masterhelptopic`
--

INSERT INTO `masterhelptopic` (`id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`, `helptopicname`) VALUES
(4, '2023-03-14 02:06:10', '2023-03-14 02:06:10', 1, 1, '1', 'Cek Backup'),
(5, '2023-03-14 02:06:17', '2023-03-14 02:06:17', 1, 1, '1', 'Komunikasi'),
(6, '2023-03-14 02:06:31', '2023-03-14 02:06:31', 1, 1, '1', 'Meeting'),
(7, '2023-03-14 02:06:42', '2023-03-14 02:06:42', 1, 1, '1', 'New Request'),
(8, '2023-03-14 02:07:02', '2023-03-14 02:07:02', 1, 1, '1', 'New Request / Interfacing'),
(9, '2023-03-14 02:07:24', '2023-03-14 02:07:24', 1, 1, '1', 'New Request / LIS-CIS Features'),
(10, '2023-03-14 02:07:39', '2023-03-14 02:07:39', 1, 1, '1', 'New Request / LIS-CIS Modules'),
(11, '2023-03-14 02:08:19', '2023-03-14 02:08:19', 1, 1, '1', 'New Request / PC and Peripherals'),
(12, '2023-03-14 02:10:06', '2023-03-14 02:10:06', 1, 1, '1', 'New Request / Regkey'),
(13, '2023-03-14 02:10:28', '2023-03-14 02:10:28', 1, 1, '1', 'New Request / Server and Networking'),
(14, '2023-03-14 02:11:01', '2023-03-14 02:11:01', 1, 1, '1', 'Troubleshoot & Adjustment'),
(15, '2023-03-14 02:11:31', '2023-03-14 02:11:31', 1, 1, '1', 'Troubleshoot & Adjustment / CIS App'),
(16, '2023-03-14 02:11:40', '2023-03-14 02:11:40', 1, 1, '1', 'Troubleshoot & Adjustment / CIS Modules'),
(17, '2023-03-14 02:11:52', '2023-03-14 02:11:52', 1, 1, '1', 'Troubleshoot & Adjustment / Interfacing'),
(18, '2023-03-14 02:12:12', '2023-03-14 02:12:12', 1, 1, '1', 'Troubleshoot & Adjustment / LIS App'),
(19, '2023-03-14 02:12:21', '2023-03-14 02:12:21', 1, 1, '1', 'Troubleshoot & Adjustment / LIS Modules'),
(20, '2023-03-14 02:12:39', '2023-03-14 02:12:39', 1, 1, '1', 'Troubleshoot & Adjustment / Onsite MCU'),
(21, '2023-03-14 02:12:55', '2023-03-14 02:12:55', 1, 1, '1', 'Troubleshoot & Adjustment / PC and Peripherals'),
(22, '2023-03-14 02:13:14', '2023-03-14 02:13:14', 1, 1, '1', 'Troubleshoot & Adjustment / Phlebotomy System'),
(23, '2023-03-14 02:13:33', '2023-03-14 02:13:33', 1, 1, '1', 'Troubleshoot & Adjustment / Server and Networking');

-- --------------------------------------------------------

--
-- Table structure for table `masterhelptopictagmenu`
--

CREATE TABLE `masterhelptopictagmenu` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `helptopic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagmenumodule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `masterhelptopictagmenu`
--

INSERT INTO `masterhelptopictagmenu` (`id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`, `helptopic`, `tagmenumodule`) VALUES
(4, '2023-03-14 04:05:08', '2023-03-14 04:05:08', 1, 1, '1', '4', '63'),
(5, '2023-03-14 04:05:19', '2023-03-14 04:05:19', 1, 1, '1', '5', '63'),
(6, '2023-03-14 04:05:28', '2023-03-14 04:05:28', 1, 1, '1', '6', '63'),
(7, '2023-03-14 04:05:37', '2023-03-14 04:05:37', 1, 1, '1', '7', '63'),
(8, '2023-03-14 04:06:12', '2023-03-14 04:06:12', 1, 1, '1', '8', '63'),
(9, '2023-03-14 04:06:20', '2023-03-14 04:06:20', 1, 1, '1', '9', '63'),
(10, '2023-03-14 04:06:30', '2023-03-14 04:06:30', 1, 1, '1', '10', '4'),
(11, '2023-03-14 04:06:38', '2023-03-14 04:06:38', 1, 1, '1', '10', '5'),
(12, '2023-03-14 04:06:44', '2023-03-14 04:06:44', 1, 1, '1', '10', '6'),
(13, '2023-03-14 04:11:05', '2023-03-14 04:11:05', 1, 1, '1', '10', '7'),
(14, '2023-03-14 04:11:13', '2023-03-14 04:11:13', 1, 1, '1', '10', '8'),
(15, '2023-03-14 04:11:21', '2023-03-14 04:11:21', 1, 1, '1', '10', '9'),
(16, '2023-03-14 04:11:27', '2023-03-14 04:11:27', 1, 1, '1', '10', '10'),
(17, '2023-03-14 04:11:36', '2023-03-14 04:11:36', 1, 1, '1', '10', '11'),
(18, '2023-03-14 04:11:42', '2023-03-14 04:11:42', 1, 1, '1', '10', '12'),
(19, '2023-03-14 04:11:50', '2023-03-14 04:11:50', 1, 1, '1', '10', '13'),
(20, '2023-03-14 04:12:11', '2023-03-14 04:12:11', 1, 1, '1', '10', '14'),
(21, '2023-03-14 04:12:21', '2023-03-14 04:12:21', 1, 1, '1', '10', '15'),
(22, '2023-03-14 04:12:29', '2023-03-14 04:12:29', 1, 1, '1', '10', '16'),
(23, '2023-03-14 04:12:37', '2023-03-14 04:12:37', 1, 1, '1', '10', '17'),
(24, '2023-03-14 04:17:57', '2023-03-14 04:17:57', 1, 1, '1', '11', '63'),
(25, '2023-03-14 04:18:07', '2023-03-14 04:18:07', 1, 1, '1', '12', '63'),
(26, '2023-03-14 04:18:24', '2023-03-14 04:18:24', 1, 1, '1', '13', '63'),
(27, '2023-03-14 04:18:36', '2023-03-14 04:18:36', 1, 1, '1', '14', '63'),
(28, '2023-03-14 04:19:07', '2023-03-14 04:19:07', 1, 1, '1', '15', '18'),
(29, '2023-03-14 04:19:26', '2023-03-14 04:19:26', 1, 1, '1', '15', '19'),
(30, '2023-03-14 04:19:36', '2023-03-14 04:19:36', 1, 1, '1', '15', '20'),
(31, '2023-03-14 04:19:47', '2023-03-14 04:19:47', 1, 1, '1', '15', '21'),
(32, '2023-03-14 04:19:56', '2023-03-14 04:19:56', 1, 1, '1', '15', '22'),
(33, '2023-03-14 04:20:06', '2023-03-14 04:20:06', 1, 1, '1', '15', '23'),
(34, '2023-03-14 04:20:18', '2023-03-14 04:20:18', 1, 1, '1', '15', '24'),
(35, '2023-03-14 04:20:26', '2023-03-14 04:20:26', 1, 1, '1', '15', '25'),
(36, '2023-03-14 04:20:36', '2023-03-14 04:20:36', 1, 1, '1', '15', '26'),
(37, '2023-03-14 04:20:44', '2023-03-14 04:20:44', 1, 1, '1', '15', '27'),
(38, '2023-03-14 04:20:55', '2023-03-14 04:20:55', 1, 1, '1', '15', '28'),
(39, '2023-03-14 04:21:06', '2023-03-14 04:21:06', 1, 1, '1', '15', '29'),
(40, '2023-03-14 04:21:14', '2023-03-14 04:21:14', 1, 1, '1', '15', '30'),
(41, '2023-03-14 04:21:23', '2023-03-14 04:21:23', 1, 1, '1', '15', '31'),
(42, '2023-03-14 04:21:33', '2023-03-14 04:21:33', 1, 1, '1', '15', '32'),
(43, '2023-03-14 04:21:48', '2023-03-14 04:21:48', 1, 1, '1', '15', '33'),
(44, '2023-03-14 04:21:59', '2023-03-14 04:21:59', 1, 1, '1', '15', '34'),
(45, '2023-03-14 04:22:09', '2023-03-14 04:22:09', 1, 1, '1', '15', '35'),
(46, '2023-03-14 04:22:26', '2023-03-14 04:22:26', 1, 1, '1', '15', '36'),
(47, '2023-03-14 04:22:45', '2023-03-14 04:22:45', 1, 1, '1', '16', '4'),
(48, '2023-03-14 04:22:53', '2023-03-14 04:22:53', 1, 1, '1', '16', '5'),
(49, '2023-03-14 04:23:02', '2023-03-14 04:23:02', 1, 1, '1', '16', '6'),
(50, '2023-03-14 04:23:09', '2023-03-14 04:23:09', 1, 1, '1', '16', '7'),
(51, '2023-03-14 04:23:17', '2023-03-14 04:23:17', 1, 1, '1', '16', '8'),
(52, '2023-03-14 04:23:24', '2023-03-14 04:23:24', 1, 1, '1', '16', '9'),
(53, '2023-03-14 04:23:34', '2023-03-14 04:23:34', 1, 1, '1', '16', '10'),
(54, '2023-03-14 04:23:44', '2023-03-14 04:23:44', 1, 1, '1', '16', '11'),
(55, '2023-03-14 04:23:51', '2023-03-14 04:23:51', 1, 1, '1', '16', '12'),
(56, '2023-03-14 04:24:00', '2023-03-14 04:24:00', 1, 1, '1', '16', '13'),
(57, '2023-03-14 04:24:09', '2023-03-14 04:24:09', 1, 1, '1', '16', '14'),
(58, '2023-03-14 04:24:19', '2023-03-14 04:24:19', 1, 1, '1', '16', '15'),
(59, '2023-03-14 04:24:28', '2023-03-14 04:24:28', 1, 1, '1', '16', '16'),
(60, '2023-03-14 04:24:36', '2023-03-14 04:24:36', 1, 1, '1', '16', '17'),
(61, '2023-03-14 04:24:49', '2023-03-14 04:24:49', 1, 1, '1', '17', '63'),
(62, '2023-03-14 04:25:12', '2023-03-14 04:25:12', 1, 1, '1', '18', '37'),
(63, '2023-03-14 04:25:22', '2023-03-14 04:25:22', 1, 1, '1', '18', '38'),
(64, '2023-03-14 04:25:37', '2023-03-14 04:25:37', 1, 1, '1', '18', '39'),
(65, '2023-03-14 04:35:05', '2023-03-14 04:35:05', 1, 1, '1', '18', '40'),
(66, '2023-03-14 04:35:19', '2023-03-14 04:35:19', 1, 1, '1', '18', '41'),
(67, '2023-03-14 04:35:28', '2023-03-14 04:35:28', 1, 1, '1', '18', '42'),
(68, '2023-03-14 04:35:37', '2023-03-14 04:35:37', 1, 1, '1', '18', '43'),
(69, '2023-03-14 04:35:48', '2023-03-14 04:35:48', 1, 1, '1', '18', '44'),
(70, '2023-03-14 04:36:02', '2023-03-14 04:36:02', 1, 1, '1', '18', '46'),
(71, '2023-03-14 04:36:11', '2023-03-14 04:36:11', 1, 1, '1', '18', '47'),
(72, '2023-03-14 04:36:33', '2023-03-14 04:36:33', 1, 1, '1', '18', '48'),
(73, '2023-03-14 04:36:43', '2023-03-14 04:36:43', 1, 1, '1', '18', '49'),
(74, '2023-03-14 04:36:57', '2023-03-14 04:36:57', 1, 1, '1', '18', '50'),
(75, '2023-03-14 04:37:16', '2023-03-14 04:37:16', 1, 1, '1', '18', '51'),
(76, '2023-03-14 04:37:32', '2023-03-14 04:37:32', 1, 1, '1', '18', '52'),
(77, '2023-03-14 04:49:15', '2023-03-14 04:49:15', 1, 1, '1', '18', '53'),
(78, '2023-03-14 04:49:31', '2023-03-14 04:49:31', 1, 1, '1', '18', '54'),
(79, '2023-03-14 04:49:43', '2023-03-14 04:49:43', 1, 1, '1', '18', '55'),
(80, '2023-03-14 04:49:54', '2023-03-14 04:49:54', 1, 1, '1', '18', '56'),
(81, '2023-03-14 04:50:07', '2023-03-14 04:50:07', 1, 1, '1', '18', '57'),
(82, '2023-03-14 04:50:16', '2023-03-14 04:50:16', 1, 1, '1', '18', '58'),
(83, '2023-03-14 04:50:34', '2023-03-14 04:50:34', 1, 1, '1', '18', '59'),
(84, '2023-03-14 04:50:47', '2023-03-14 04:50:47', 1, 1, '1', '18', '60'),
(85, '2023-03-14 04:50:57', '2023-03-14 04:50:57', 1, 1, '1', '18', '61'),
(86, '2023-03-14 04:51:18', '2023-03-14 04:51:18', 1, 1, '1', '18', '20'),
(87, '2023-03-14 04:51:26', '2023-03-14 04:51:26', 1, 1, '1', '18', '62'),
(88, '2023-03-14 04:51:50', '2023-03-14 04:51:50', 1, 1, '1', '18', '27'),
(89, '2023-03-14 04:52:08', '2023-03-14 04:52:08', 1, 1, '1', '18', '28'),
(90, '2023-03-14 04:52:19', '2023-03-14 04:52:19', 1, 1, '1', '18', '29'),
(91, '2023-03-14 04:52:26', '2023-03-14 04:52:26', 1, 1, '1', '18', '30'),
(92, '2023-03-14 04:52:41', '2023-03-14 04:52:41', 1, 1, '1', '18', '33'),
(93, '2023-03-14 04:52:58', '2023-03-14 04:52:58', 1, 1, '1', '18', '34'),
(94, '2023-03-14 04:53:10', '2023-03-14 04:53:10', 1, 1, '1', '18', '35'),
(95, '2023-03-14 04:53:20', '2023-03-14 04:53:20', 1, 1, '1', '18', '31'),
(96, '2023-03-14 04:53:37', '2023-03-14 04:53:37', 1, 1, '1', '18', '32'),
(97, '2023-03-14 04:53:47', '2023-03-14 04:53:47', 1, 1, '1', '18', '36'),
(98, '2023-03-14 04:54:37', '2023-03-14 04:54:37', 1, 1, '1', '19', '4'),
(99, '2023-03-14 04:54:46', '2023-03-14 04:54:46', 1, 1, '1', '19', '5'),
(100, '2023-03-14 04:54:53', '2023-03-14 04:54:53', 1, 1, '1', '19', '6'),
(101, '2023-03-14 04:54:59', '2023-03-14 04:54:59', 1, 1, '1', '19', '7'),
(102, '2023-03-14 04:55:06', '2023-03-14 04:55:06', 1, 1, '1', '19', '8'),
(103, '2023-03-14 04:55:13', '2023-03-14 04:55:13', 1, 1, '1', '19', '9'),
(104, '2023-03-14 04:55:21', '2023-03-14 04:55:21', 1, 1, '1', '19', '10'),
(105, '2023-03-14 04:55:31', '2023-03-14 04:55:31', 1, 1, '1', '19', '11'),
(106, '2023-03-14 04:55:39', '2023-03-14 04:55:39', 1, 1, '1', '19', '12'),
(107, '2023-03-14 04:55:47', '2023-03-14 04:55:47', 1, 1, '1', '19', '13'),
(108, '2023-03-14 04:55:56', '2023-03-14 04:55:56', 1, 1, '1', '19', '14'),
(109, '2023-03-14 04:56:05', '2023-03-14 04:56:05', 1, 1, '1', '19', '15'),
(110, '2023-03-14 04:56:14', '2023-03-14 04:56:14', 1, 1, '1', '19', '16'),
(111, '2023-03-14 04:56:23', '2023-03-14 04:56:23', 1, 1, '1', '19', '17'),
(112, '2023-03-14 04:56:38', '2023-03-14 04:56:38', 1, 1, '1', '20', '63'),
(113, '2023-03-14 04:56:47', '2023-03-14 04:56:47', 1, 1, '1', '21', '63'),
(114, '2023-03-14 04:56:55', '2023-03-14 04:56:55', 1, 1, '1', '22', '63'),
(115, '2023-03-14 04:57:04', '2023-03-14 04:57:04', 1, 1, '1', '23', '63');

-- --------------------------------------------------------

--
-- Table structure for table `mastertag`
--

CREATE TABLE `mastertag` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tagname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mastertag`
--

INSERT INTO `mastertag` (`id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`, `tagname`) VALUES
(4, '2023-03-14 02:27:23', '2023-03-14 02:27:23', 1, 1, '1', 'QMS'),
(5, '2023-03-14 02:28:28', '2023-03-14 02:28:28', 1, 1, '1', 'Bridging'),
(6, '2023-03-14 02:28:33', '2023-03-14 02:28:33', 1, 1, '1', 'MCU'),
(7, '2023-03-14 02:28:51', '2023-03-14 02:28:51', 1, 1, '1', 'Ward Viewer'),
(8, '2023-03-14 02:28:57', '2023-03-14 02:28:57', 1, 1, '1', 'Admin Viewer'),
(9, '2023-03-14 02:29:03', '2023-03-14 02:29:03', 1, 1, '1', 'Cloud Result'),
(10, '2023-03-14 02:29:11', '2023-03-14 02:29:11', 1, 1, '1', 'Email Result'),
(11, '2023-03-14 02:29:15', '2023-03-14 02:29:15', 1, 1, '1', 'QA'),
(12, '2023-03-14 02:29:23', '2023-03-14 02:29:23', 1, 1, '1', 'Interfacing'),
(13, '2023-03-14 02:29:33', '2023-03-14 02:29:33', 1, 1, '1', 'Kios Hasil Mandiri'),
(14, '2023-03-14 02:29:45', '2023-03-14 02:29:45', 1, 1, '1', 'Schedule Monitoring'),
(15, '2023-03-14 02:32:14', '2023-03-14 02:32:14', 1, 1, '1', 'Status Hasil'),
(16, '2023-03-14 02:32:23', '2023-03-14 02:32:23', 1, 1, '1', 'Phlebotomy'),
(17, '2023-03-14 02:32:33', '2023-03-14 02:32:33', 1, 1, '1', 'WHOnet'),
(18, '2023-03-14 02:36:22', '2023-03-14 02:36:22', 1, 1, '1', 'Registration ~ Clinic Registration'),
(19, '2023-03-14 02:36:33', '2023-03-14 02:36:33', 1, 1, '1', 'Registration ~ Finance Receipt'),
(20, '2023-03-14 02:36:49', '2023-03-14 02:36:49', 1, 1, '1', 'Analysis ~ Print Result'),
(21, '2023-03-14 02:36:59', '2023-03-14 02:36:59', 1, 1, '1', 'Analysis ~ Log Maintenance'),
(22, '2023-03-14 02:37:18', '2023-03-14 02:37:18', 1, 1, '1', 'Analysis ~ Consultation'),
(23, '2023-03-14 02:37:28', '2023-03-14 02:37:28', 1, 1, '1', 'Analysis ~ Therapy'),
(24, '2023-03-14 02:37:42', '2023-03-14 02:37:42', 1, 1, '1', 'Analysis ~ Consultation Clinic'),
(25, '2023-03-14 02:37:54', '2023-03-14 02:37:54', 1, 1, '1', 'Analysis ~ Therapy Clinic'),
(26, '2023-03-14 02:38:07', '2023-03-14 02:38:07', 1, 1, '1', 'Analysis ~ Verification Clinic'),
(27, '2023-03-14 02:38:18', '2023-03-14 02:38:18', 1, 1, '1', 'Result Handling ~ Result Handling'),
(28, '2023-03-14 02:38:28', '2023-03-14 02:38:28', 1, 1, '1', 'Finance ~ Finance Receipt'),
(29, '2023-03-14 02:38:37', '2023-03-14 02:38:37', 1, 1, '1', 'Finance ~ Void'),
(30, '2023-03-14 02:38:45', '2023-03-14 02:38:45', 1, 1, '1', 'Finance ~ Payment'),
(31, '2023-03-14 02:39:01', '2023-03-14 02:39:01', 1, 1, '1', 'Marketing ~ Messenger'),
(32, '2023-03-14 02:39:09', '2023-03-14 02:39:09', 1, 1, '1', 'Marketing ~ QA'),
(33, '2023-03-14 02:39:20', '2023-03-14 02:39:20', 1, 1, '1', 'Inventory ~ Inv Order Outlet'),
(34, '2023-03-14 02:39:58', '2023-03-14 02:39:58', 1, 1, '1', 'Inventory ~ Inv Stock Opname'),
(35, '2023-03-14 02:40:05', '2023-03-14 02:40:05', 1, 1, '1', 'Inventory ~ Inv Order Loc'),
(36, '2023-03-14 04:10:39', '2023-03-14 04:10:39', 1, 1, '1', 'Master ~ Master'),
(37, '2023-03-14 02:41:34', '2023-03-14 02:41:34', 1, 1, '1', 'Registration ~ Lab Registration'),
(38, '2023-03-14 02:41:53', '2023-03-14 02:41:53', 1, 1, '1', 'Registration ~ Registration Blood Bank'),
(39, '2023-03-14 02:42:38', '2023-03-14 02:42:38', 1, 1, '1', 'Registration ~ Finance Recceipt'),
(40, '2023-03-14 02:42:48', '2023-03-14 02:42:48', 1, 1, '1', 'Sampling ~ Specimen Collection Lab'),
(41, '2023-03-14 02:43:04', '2023-03-14 02:43:04', 1, 1, '1', 'Sampling ~ Specimen Handling Lab'),
(42, '2023-03-14 02:43:24', '2023-03-14 02:43:24', 1, 1, '1', 'Sampling ~ Sample Handling Lab'),
(43, '2023-03-14 02:43:36', '2023-03-14 02:43:36', 1, 1, '1', 'Sampling ~ Specimen Collection Non Lab'),
(44, '2023-03-14 02:43:50', '2023-03-14 02:43:50', 1, 1, '1', 'Sampling ~ Specimen Handling Non Lab'),
(45, '2023-03-14 02:44:05', '2023-03-14 02:44:05', 1, 1, '1', 'Sampling ~ Sample Handling Non Lab'),
(46, '2023-03-14 02:44:24', '2023-03-14 02:44:24', 1, 1, '1', 'Sampling ~ Specimen Collection Blood Bank'),
(47, '2023-03-14 02:44:46', '2023-03-14 02:44:46', 1, 1, '1', 'Sampling ~ Specimen Handling Blood Bank'),
(48, '2023-03-14 02:44:57', '2023-03-14 02:44:57', 1, 1, '1', 'Analysis ~ QC Result'),
(49, '2023-03-14 02:45:09', '2023-03-14 02:45:09', 1, 1, '1', 'Analysis ~ Process Sample Lab'),
(50, '2023-03-14 02:45:19', '2023-03-14 02:45:19', 1, 1, '1', 'Analysis ~ Result Lab'),
(51, '2023-03-14 02:45:35', '2023-03-14 02:45:35', 1, 1, '1', 'Analysis ~ Verification Lab'),
(52, '2023-03-14 02:45:52', '2023-03-14 02:45:52', 1, 1, '1', 'Analysis ~ Authorization Lab'),
(53, '2023-03-14 02:46:08', '2023-03-14 02:46:08', 1, 1, '1', 'Analysis ~ Process Sample Non Lab'),
(54, '2023-03-14 02:47:05', '2023-03-14 02:47:05', 1, 1, '1', 'Analysis ~ Result Non Lab'),
(55, '2023-03-14 02:47:18', '2023-03-14 02:47:18', 1, 1, '1', 'Analysis ~ Verification Non Lab'),
(56, '2023-03-14 02:47:31', '2023-03-14 02:47:31', 1, 1, '1', 'Analysis ~ Authorization Non Lab'),
(57, '2023-03-14 02:47:52', '2023-03-14 02:47:52', 1, 1, '1', 'Analysis ~ Process Blood Bank'),
(58, '2023-03-14 02:48:14', '2023-03-14 02:48:14', 1, 1, '1', 'Analysis ~ Result Blood Bank'),
(59, '2023-03-14 02:48:39', '2023-03-14 02:48:39', 1, 1, '1', 'Analysis ~ Verification Blood Bank'),
(60, '2023-03-14 02:48:51', '2023-03-14 02:48:51', 1, 1, '1', 'Analysis ~ Authorization Blood Bank'),
(61, '2023-03-14 02:49:01', '2023-03-14 02:49:01', 1, 1, '1', 'Analysis ~ Check Up'),
(62, '2023-03-14 02:50:10', '2023-03-14 02:50:10', 1, 1, '1', 'Analysis ~ Print Result Other Sys'),
(63, '2023-03-14 04:04:53', '2023-03-14 04:04:53', 1, 1, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `mastertypejob`
--

CREATE TABLE `mastertypejob` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typejobname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mastertypejob`
--

INSERT INTO `mastertypejob` (`id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `status`, `typejobname`) VALUES
(5, '2023-03-13 09:02:15', '2023-03-13 09:02:15', 1, 1, '1', 'Onsite'),
(6, '2023-03-13 09:02:22', '2023-03-13 09:02:22', 1, 1, '1', 'Remote');

-- --------------------------------------------------------

--
-- Table structure for table `master_assignment`
--

CREATE TABLE `master_assignment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `index_id` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_customers`
--

CREATE TABLE `master_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_show` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_customers`
--

INSERT INTO `master_customers` (`id`, `customer_name`, `status`, `is_show`, `created_at`, `updated_at`) VALUES
(1, 'RS Zainoel Abidin', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(2, 'RS H Adam Malik', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(3, 'RS USU', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(4, 'Lab Gatsu', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(5, 'RSUD Ahmad Yani', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(6, 'RS Muhammad Hoesin', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(7, 'RSUD Rokan Hulu', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(8, 'RS Islam Arafah', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(9, 'RSUD Solok', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(10, 'Unyai', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(11, 'Lab MDC Medan Ayahanda', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(12, 'Natama Siantar', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(13, 'RS Advent', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(14, 'RS Immanuel', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(15, 'RS Limijati', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(16, 'RSUD Pagelaran Cianjur', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(17, 'RSUD Banten', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(18, 'RS JIH', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(19, 'RSUD Bangil', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(20, 'RS Saiful Anwar', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(21, 'RS Soedono', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(22, 'RS Oen Soba', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(23, 'RS Oen Kansa', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(24, 'RS Sayidiman Magetan', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(25, 'RSAL Ramelan Surabaya', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(26, 'RSUD Ibnu Sina', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(27, 'RS Semen Gresik', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(28, 'RSUD Dr Soetomo', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(29, 'Nikki Medika ', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(30, 'Quantum', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(31, 'RSUP Sanglah', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(32, 'Prima Medika', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(33, 'Kanaka', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(34, 'Biodika Makasar', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(35, 'Lab Helix', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(36, 'RS Mayapada', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(37, 'Budi Sehat', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(38, 'Westerindo', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(39, 'Lab Biomedika', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(40, 'Klinik Ella', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(41, 'Diagnos', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(42, 'E-LABS', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(43, 'Intibios', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(44, 'RS Bethsaida', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(45, 'RS Budhi Asih', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(46, 'RSUD Cengkareng', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(47, 'RS Cinta Kasih Tzu Chi', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(48, 'RSK Dharmais', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(49, 'RS Dharma Nugraha', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(50, 'RS IJ CP', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(51, 'RS Jakarta', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(52, 'RS JEC', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(53, 'RS Pusat Angkatan Darat', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(54, 'RS Satya Negara', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(55, 'RS Adhyaksa', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(56, 'RS Antam', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(57, 'Biomedilab', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(58, 'Lab Pademangan', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(59, 'RS Permata Pamulang', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(60, 'RSUD Depok', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(61, 'RS Ananda Babelan ', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(62, 'RS Sumber Waras', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(63, 'RS Ukrida', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(64, 'RSUD Tangerang Selatan', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(65, 'RS Haji', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(66, 'Lab Mikro FKUI', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(67, 'Lab Healthway', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(68, 'Klinik Satria Medika', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(69, 'Indolab', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(70, 'Lab Trastia', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(71, 'Synapsa', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(72, 'UTDRS RSUP Fatmawati', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(73, 'Farmalab', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(74, 'Klinik Utama Hidup Baru', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(75, 'C-Lab', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(76, 'ABC Lab', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(77, 'My Prima', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(78, 'RSIJ Sukapura', '', '1', '2023-03-13 07:37:56', '2023-03-13 07:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `master_customer_branches`
--

CREATE TABLE `master_customer_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `outlet_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_show` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_customer_branches`
--

INSERT INTO `master_customer_branches` (`id`, `outlet_id`, `customer_id`, `customer_branch`, `status`, `is_show`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '', 1, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(2, '', 2, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(3, '', 3, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(4, '', 4, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(5, '', 5, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(6, '', 6, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(7, '', 7, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(8, '', 8, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(9, '', 9, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(10, '', 10, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(11, '', 11, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(12, '', 12, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(13, '', 13, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(14, '', 14, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(15, '', 15, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(16, '', 16, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(17, '', 17, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(18, '', 18, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(19, '', 19, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(20, '', 20, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(21, '', 21, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(22, '0001', 22, 'Solo Baru', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(23, '0002', 23, 'Kartasura', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(24, '', 24, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(25, '', 25, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(26, '', 26, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(27, '', 27, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(28, '', 28, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(29, '', 29, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(30, '', 30, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(31, '', 31, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(32, '', 32, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(33, '', 33, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(34, '', 34, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(35, '0001', 35, 'Depok RTM', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(36, '0002', 35, 'Pondok Indah', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(37, '0003', 35, 'Bandung', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(38, '0004', 35, 'Depok Kartini', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(39, '0005', 35, 'BSD', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(40, '0006', 35, 'Tebet', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(41, '0007', 35, 'Ciputat', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(42, '0008', 35, 'Bekasi', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(43, '0009', 35, 'Tanah Merdeka', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(44, '0010', 35, 'Wastu Kencana', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(45, '0011', 35, 'Kuningan', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(46, '0012', 35, 'Ciledug', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(47, '0013', 35, 'Palembang Sukamto', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(48, '0014', 35, 'Bali Teuku Umar', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(49, '0015', 35, 'Batam', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(50, '0016', 35, 'Manado Piere Tendean', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(51, '0017', 35, 'Semarang Jati Raya', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(52, '0018', 35, 'Surabaya Mulyosari', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(53, '0019', 35, 'Yogyakarta Cik di tiro', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(54, '0001', 36, 'MHJS/Jakarta Selatan', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(55, '0002', 36, 'MHTG/Tangerang', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(56, '0003', 36, 'MHKN/Kuningan', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(57, '0004', 36, 'MHSB/Surabaya', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(58, '0005', 36, 'MHBD /Bandung', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(59, '0001', 37, 'Solo', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(60, '0002', 37, 'Sragen', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(61, '0003', 37, 'Sukoharjo', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(62, '0004', 37, 'Purwodadi/Jogja', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(63, '0001', 38, 'Cipaku/Pusat', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(64, '0002', 38, 'Sam Marie Wijaya', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(65, '0003', 38, 'Sam Marie Basra', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(66, '0005', 38, 'Klinik Mutiara Batam', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(67, '0008', 38, 'Cibubur', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(68, '0009', 38, 'Klinik CMC Cikarang ', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(69, '0010', 38, 'RSIA Evasari ', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(70, '0013', 38, 'Bekasi ', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(71, '0014', 38, 'Klinik Cikadu Tanjung Lesung', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(72, '0016', 38, 'BSD ', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(73, '0017', 38, 'Karawang', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(74, '0019', 38, 'RSAB Tangerang ', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(75, '0020', 38, 'Surabaya ', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(76, '0022', 38, 'RSAB Bekasi Barat', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(77, '0023', 38, 'WESTERINDO BEKASI TIMUR (LAB COVID)', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(78, '0021', 38, 'LIS CLOUD', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(79, '0001', 39, 'KEDOYA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(80, '0002', 39, 'CIUJUNG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(81, '0003', 39, 'KELAPA GADING', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(82, '0004', 39, 'CITRA GARDEN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(83, '0005', 39, 'BSD', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(84, '0006', 39, 'TANGERANG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(85, '0007', 39, 'ANGKE', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(86, '0008', 39, 'GADING SERPONG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(87, '0009', 39, 'SEMANAN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(88, '0010', 39, 'GANDARIA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(89, '0011', 39, 'MANGGA BESAR', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(90, '0012', 39, 'DENPASAR', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(91, '0013', 39, 'SUNTER', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(92, '0014', 39, 'PURI INDAH', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(93, '0015', 39, 'BEKASI', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(94, '0001', 40, 'ELLA SUPOMO/PUSAT', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(95, '0002', 40, 'ELLA KARTASURA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(96, '0003', 40, 'ELLA JATEN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(97, '0004', 40, 'ELLA PANJAITAN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(98, '0005', 40, 'ELLA KLATEN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(99, '0006', 40, 'ELLA LAWEYAN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(100, '0007', 40, 'ELLA SRAGEN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(101, '0008', 40, 'ELLA WONOGIRI', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(102, '0009', 40, 'ELLA MADIUN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(103, '0010', 40, 'ELLA JAKARTA BINTARO', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(104, '0011', 40, 'ELLA SEMARANG KELUD', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(105, '0012', 40, 'ELLA MAGELANG SUGIONO', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(106, '0013', 40, 'ELLA KUDUS SUNAN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(107, '0014', 40, 'ELLA YOGYA GODEAN', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(108, '0015', 40, 'ELLA PURWOKERTO OVERSTE', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(109, '0016', 40, 'ELLA TEBET', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(110, '0001', 40, 'ELLA BEAUTY STORE', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(111, '0017', 40, 'ELLA LAMPUNG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(112, '0000', 40, 'ELLA TRAINING', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(113, '0018', 40, 'ELLA MALANG MERBABU', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(114, '0019', 40, 'ELLA SIDOARJO', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(115, '0020', 40, 'ELLA SALATIGA IMAM BONJOL', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(116, '1001', 40, 'GLOWLABS SOLO SUPOMO', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(117, '0021', 40, 'ELLA SURABAYA DHARMA HUSADA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(118, '0022', 40, 'ELLA MAGELANG 2', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(119, '0024', 40, 'ELLA KEDIRI IMAM BONJOL', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(120, '0025', 40, 'ELLA TEGAL KAPTEN ISMAIL', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(121, '0001', 41, 'KLINIK BONA MITRA KELUARGA BANDUNG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(122, '0002', 41, 'BIC MENTENG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(123, '0003', 41, 'LAB DIAGNOS MAKASSAR', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(124, '0004', 41, 'LAB DIAGNOS CIPUTAT', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(125, '0005', 41, 'LAB DIAGNOS DENPASAR', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(126, '0006', 41, 'LAB DIAGNOS BATAM BANDARA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(127, '0007', 41, 'LAB DIAGNOS BATAM JASMINE', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(128, '0008', 41, 'LAB DIAGNOS JAKARTA KIZUNA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(129, '0009', 41, 'LAB DIAGNOS DUMAI GRAHA YASMINE', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(130, '0010', 41, 'LAB DIAGNOS DEPOK MARGONDA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(131, '0011', 41, 'LAB DIAGNOS PADANG PROKLAMASI', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(132, '0012', 41, 'LAB DIAGNOS BALI KLUNGKUNG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(133, '0013', 41, 'RSIA-RSU MENTENG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(134, '0014', 41, 'LAB DIAGNOS BANDUNG PARAMARTA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(135, '0015', 41, 'LAB DIAGNOS PALEMBANG AZZAHRA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(136, '0016', 41, 'LAB DIAGNOS BATAM ABULYATAMA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(137, '0017', 41, 'LAB DIAGNOS DENPASAR BIC', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(138, '0018', 41, 'LAB DIAGNOS JAKARTA GENOMIC', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(139, '0019', 41, 'LAB DIAGNOS BREBES AMANAH MAHMUDAH', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(140, '0020', 41, 'LAB DIAGNOS PEKANBARU BUDHI MULIA', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(141, '9001', 41, 'LAB DIAGNOS PUSAT', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(142, '9999', 41, 'TRAINING', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(143, '0021', 41, 'BIC BANDUNG', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(144, '0001', 42, 'Jakarta', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(145, '0002', 42, 'Bandung', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(146, '0003', 42, 'Makassar', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(147, '0004', 42, 'Surabaya', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(148, '0005', 42, 'Medan', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(149, '0001', 43, 'Jakarta Ciputat', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(150, '0002', 43, 'Bandung Merdeka', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(151, '0003', 43, 'Semarang Sultan Agung', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(152, '0004', 43, 'Denpasar Puputan', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(153, '0005', 43, 'Karawang', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(154, '0006', 43, 'Yogyakarta', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(155, '', 44, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(156, '', 45, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(157, '', 46, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(158, '', 47, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(159, '', 48, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(160, '', 49, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(161, '', 50, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(162, '', 51, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(163, '', 52, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(164, '', 53, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(165, '', 54, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(166, '', 55, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(167, '', 56, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(168, '', 57, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(169, '', 58, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(170, '', 59, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(171, '', 60, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(172, '', 61, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(173, '', 62, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(174, '', 63, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(175, '', 64, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(176, '', 65, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(177, '', 66, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(178, '', 67, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(179, '', 68, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(180, '', 69, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(181, '', 70, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(182, '', 71, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(183, '', 72, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(184, '', 73, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(185, '', 74, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(186, '', 75, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(187, '', 76, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(188, '', 77, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(189, '', 78, '', '', '1', '', '', '2023-03-13 07:37:57', '2023-03-13 07:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `master_datatype`
--

CREATE TABLE `master_datatype` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_datatype`
--

INSERT INTO `master_datatype` (`id`, `name`, `data_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Text', 'VARCHAR(255)', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(2, 'Longtext', 'TEXT', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(3, 'Number', 'BIGINT(20)', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(4, 'Time', 'TIME', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(5, 'Date', 'DATE', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(6, 'Yes/No', 'VARCHAR(1)', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(7, 'File', 'VARCHAR(255)', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(8, 'Checklist', 'TEXT', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(9, 'Today Date', 'DATE', 'seed', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `master_divisions`
--

CREATE TABLE `master_divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_divisions`
--

INSERT INTO `master_divisions` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'All', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(2, 'Application Support', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(3, 'Technical Support', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(4, 'Infrastructure', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(5, 'Project Development', 'seed', '2023-03-13 07:37:56', '2023-03-13 07:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `master_parent_child`
--

CREATE TABLE `master_parent_child` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `index_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relate_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_relation`
--

CREATE TABLE `master_relation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `relation_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_from_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_from_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refer_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_to_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refer_to_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_relation`
--

INSERT INTO `master_relation` (`id`, `relation_id`, `table_name_from`, `field_from`, `table_from_desc`, `field_from_desc`, `table_name_to`, `refer_to`, `table_to_desc`, `refer_to_desc`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'R.6.1', 'masterhelptopictagmenu', 'helptopic', 'Master Help Topic Tag Menu', 'Help Topic', 'masterhelptopic', 'helptopicname', 'Master Help Topic', 'Help Topic Name', '', '', '2023-03-14 04:04:08', '2023-03-14 04:04:08'),
(2, 'R.6.2', 'masterhelptopictagmenu', 'tagmenumodule', 'Master Help Topic Tag Menu', 'Tag Menu / Module', 'mastertag', 'tagname', 'Master Tag', 'Tag Name', '', '', '2023-03-14 04:04:18', '2023-03-14 04:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `master_status_report`
--

CREATE TABLE `master_status_report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_status_report`
--

INSERT INTO `master_status_report` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'In Progress', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(2, 'Done', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(3, 'Escalated', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(4, 'Pending', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(5, 'No Case', '2023-03-13 07:37:56', '2023-03-13 07:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `master_tables`
--

CREATE TABLE `master_tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_show` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extend` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_customer` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_clipboard` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_tables`
--

INSERT INTO `master_tables` (`id`, `group`, `name`, `description`, `is_show`, `extend`, `status`, `use_customer`, `use_clipboard`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '-', 'master_customers', 'Master Customer', '1', '0', '0', '', '', 'seed', 'seed', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(2, '-', 'master_customer_branches', 'Master Customer Branch', '1', '0', '0', '', '', 'seed', 'seed', '2023-03-13 07:37:57', '2023-03-13 07:37:57'),
(3, '-', 'mastertypejob', 'Master Type Job', '1', '0', '0', '0', '0', '1', '1', '2023-03-13 08:04:35', '2023-03-13 08:04:35'),
(4, '-', 'masterhelptopic', 'Master Help Topic', '1', '0', '0', '0', '0', '1', '1', '2023-03-14 01:57:52', '2023-03-14 01:57:52'),
(5, '-', 'mastertag', 'Master Tag', '1', '0', '0', '0', '0', '1', '1', '2023-03-14 02:15:37', '2023-03-14 02:15:37'),
(6, '-', 'masterhelptopictagmenu', 'Master Help Topic Tag Menu', '1', '0', '0', '0', '0', '1', '1', '2023-03-14 04:01:35', '2023-03-14 04:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `master_table_structures`
--

CREATE TABLE `master_table_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_show` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relate_to` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `can_copy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sequence_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_table_structures`
--

INSERT INTO `master_table_structures` (`id`, `table_id`, `field_name`, `field_description`, `is_show`, `data_type`, `relation`, `relate_to`, `input_type`, `can_copy`, `required`, `sequence_id`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 1, 'customer_name', 'CUstomer Name', '1', 'VARCHAR(255)', '0', '', 'Text', '', '', '1', '2023-03-13 07:37:57', '2023-03-13 07:37:57', 'seed'),
(2, 2, 'outlet_id', 'Outlet ID', '1', 'VARCHAR(255)', '0', '', 'Text', '', '', '1', '2023-03-13 07:37:57', '2023-03-13 07:37:57', 'seed'),
(3, 2, 'customer_id', 'Customer ID', '1', 'VARCHAR(255)', '0', '', 'Text', '', '', '2', '2023-03-13 07:37:57', '2023-03-13 07:37:57', 'seed'),
(4, 2, 'customer_branch', 'Customer Branch', '1', 'VARCHAR(255)', '0', '', 'Text', '', '', '3', '2023-03-13 07:37:57', '2023-03-13 07:37:57', 'seed'),
(5, 3, 'typejobname', 'Type Job Name', '1', 'VARCHAR(255)', '0', '', 'Text', '', 'required', '1', '2023-03-13 08:04:54', '2023-03-13 08:04:54', '1'),
(6, 4, 'helptopicname', 'Help Topic Name', '1', 'VARCHAR(255)', '0', '', 'Text', '', 'required', '1', '2023-03-14 02:05:16', '2023-03-14 02:05:16', '1'),
(7, 5, 'tagname', 'Tag Name', '1', 'VARCHAR(255)', '0', '', 'Text', '', '', '1', '2023-03-14 02:16:15', '2023-03-14 04:04:43', '1'),
(8, 6, 'helptopic', 'Help Topic', '1', 'VARCHAR(255)', '1', 'R.6.1', 'Text', '', 'required', '1', '2023-03-14 04:02:26', '2023-03-14 04:02:26', '1'),
(9, 6, 'tagmenumodule', 'Tag Menu / Module', '1', 'VARCHAR(255)', '1', 'R.6.2', 'Text', '', '', '2', '2023-03-14 04:03:00', '2023-03-14 04:03:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_01_05_011258_create_permission_tables', 1),
(7, '2023_01_05_011260_create_master_tables_table', 1),
(8, '2023_01_05_011261_create_master_datatype', 1),
(9, '2023_01_05_011262_create_master_relation', 1),
(10, '2023_01_05_011265_update_users_table', 1),
(11, '2023_01_05_022643_create_master_table_structures_table', 1),
(12, '2023_02_10_043925_create_extends_table', 1),
(13, '2023_02_10_044123_create_extend_files_table', 1),
(14, '2023_02_10_053710_create_master_divisions_table', 1),
(15, '2023_02_10_053854_update_user_add_relation_to_division', 1),
(16, '2023_02_10_110112_create_master_assignment', 1),
(17, '2023_02_14_101948_create_master_status_report', 1),
(18, '2023_02_16_112005_create_helpdesk_topics_table', 1),
(19, '2023_02_16_112456_create_sla_plans_table', 1),
(20, '2023_02_16_112814_create_lis_menu_apps_table', 1),
(21, '2023_02_16_113114_create_lis_cis_modules_table', 1),
(22, '2023_02_16_113321_create_cis_menu_apps_table', 1),
(23, '2023_02_16_113518_create_helpdesks_table', 1),
(24, '2023_02_16_121723_create_helpdesk_threads_table', 1),
(25, '2023_02_19_234307_create_master_parent_child', 1),
(26, '2023_02_21_153923_create_master_customers_table', 1),
(27, '2023_02_21_154332_create_master_customer_branches_table', 1),
(28, '2023_02_26_184215_create_file_uploads_table', 1),
(29, '2023_03_05_173230_create_file_helpdesks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.index', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55'),
(2, 'form.create', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55'),
(3, 'form.manage', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55'),
(4, 'form.relation', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55'),
(5, 'users.index', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55'),
(6, 'users.create', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55'),
(7, 'users.edit', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55'),
(8, 'users.delete', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(9, 'roles.index', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(10, 'roles.create', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(11, 'roles.edit', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(12, 'roles.delete', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(13, 'permissions.index', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(14, 'form-master_customers.index', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(15, 'form-master_customers.create', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(16, 'form-master_customer_branches.index', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(17, 'form-master_customer_branches.create', 'web', '2023-03-13 07:37:56', '2023-03-13 07:37:56'),
(18, 'form-mastertypejob.index', 'web', '2023-03-13 08:04:36', '2023-03-13 08:04:36'),
(19, 'form-mastertypejob.create', 'web', '2023-03-13 08:04:36', '2023-03-13 08:04:36'),
(20, 'form-mastertypejob.edit', 'web', '2023-03-13 08:04:36', '2023-03-13 08:04:36'),
(21, 'form-mastertypejob.delete', 'web', '2023-03-13 08:04:36', '2023-03-13 08:04:36'),
(22, 'form-masterhelptopic.index', 'web', '2023-03-14 01:57:52', '2023-03-14 01:57:52'),
(23, 'form-masterhelptopic.create', 'web', '2023-03-14 01:57:52', '2023-03-14 01:57:52'),
(24, 'form-masterhelptopic.edit', 'web', '2023-03-14 01:57:52', '2023-03-14 01:57:52'),
(25, 'form-masterhelptopic.delete', 'web', '2023-03-14 01:57:53', '2023-03-14 01:57:53'),
(26, 'form-mastertag.index', 'web', '2023-03-14 02:15:37', '2023-03-14 02:15:37'),
(27, 'form-mastertag.create', 'web', '2023-03-14 02:15:37', '2023-03-14 02:15:37'),
(28, 'form-mastertag.edit', 'web', '2023-03-14 02:15:37', '2023-03-14 02:15:37'),
(29, 'form-mastertag.delete', 'web', '2023-03-14 02:15:37', '2023-03-14 02:15:37'),
(30, 'form-masterhelptopictagmenu.index', 'web', '2023-03-14 04:01:35', '2023-03-14 04:01:35'),
(31, 'form-masterhelptopictagmenu.create', 'web', '2023-03-14 04:01:35', '2023-03-14 04:01:35'),
(32, 'form-masterhelptopictagmenu.edit', 'web', '2023-03-14 04:01:35', '2023-03-14 04:01:35'),
(33, 'form-masterhelptopictagmenu.delete', 'web', '2023-03-14 04:01:35', '2023-03-14 04:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2023-03-13 07:37:55', '2023-03-13 07:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sla_plans`
--

CREATE TABLE `sla_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sla_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sla_hour` int(11) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`, `division`, `is_active`) VALUES
(1, 'Administrator', 'admin@gmail.com', NULL, '$2y$10$9whjyy./MEFPRZdNXIBCquOKWIe77VDV4LN4L0PHyEQ5QaDCYEiei', NULL, NULL, NULL, '2023-03-13 07:37:56', '2023-03-13 07:37:56', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cis_menu_apps`
--
ALTER TABLE `cis_menu_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extends`
--
ALTER TABLE `extends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extends_created_by_foreign` (`created_by`);

--
-- Indexes for table `extend_files`
--
ALTER TABLE `extend_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extend_files_extend_id_foreign` (`extend_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `file_helpdesks`
--
ALTER TABLE `file_helpdesks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helpdesks`
--
ALTER TABLE `helpdesks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helpdesk_threads`
--
ALTER TABLE `helpdesk_threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helpdesk_topics`
--
ALTER TABLE `helpdesk_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lis_cis_modules`
--
ALTER TABLE `lis_cis_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lis_menu_apps`
--
ALTER TABLE `lis_menu_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masterhelptopic`
--
ALTER TABLE `masterhelptopic`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `masterhelptopictagmenu`
--
ALTER TABLE `masterhelptopictagmenu`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mastertag`
--
ALTER TABLE `mastertag`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mastertypejob`
--
ALTER TABLE `mastertypejob`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `master_assignment`
--
ALTER TABLE `master_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_customers`
--
ALTER TABLE `master_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_customer_branches`
--
ALTER TABLE `master_customer_branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_customer_branches_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `master_datatype`
--
ALTER TABLE `master_datatype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_divisions`
--
ALTER TABLE `master_divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_parent_child`
--
ALTER TABLE `master_parent_child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_relation`
--
ALTER TABLE `master_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_status_report`
--
ALTER TABLE `master_status_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_tables`
--
ALTER TABLE `master_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_table_structures`
--
ALTER TABLE `master_table_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_table_structures_table_id_foreign` (`table_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sla_plans`
--
ALTER TABLE `sla_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_division_foreign` (`division`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cis_menu_apps`
--
ALTER TABLE `cis_menu_apps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extends`
--
ALTER TABLE `extends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extend_files`
--
ALTER TABLE `extend_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_helpdesks`
--
ALTER TABLE `file_helpdesks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helpdesks`
--
ALTER TABLE `helpdesks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helpdesk_threads`
--
ALTER TABLE `helpdesk_threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helpdesk_topics`
--
ALTER TABLE `helpdesk_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `lis_cis_modules`
--
ALTER TABLE `lis_cis_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lis_menu_apps`
--
ALTER TABLE `lis_menu_apps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `masterhelptopic`
--
ALTER TABLE `masterhelptopic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `masterhelptopictagmenu`
--
ALTER TABLE `masterhelptopictagmenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `mastertag`
--
ALTER TABLE `mastertag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `mastertypejob`
--
ALTER TABLE `mastertypejob`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_assignment`
--
ALTER TABLE `master_assignment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_customers`
--
ALTER TABLE `master_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `master_customer_branches`
--
ALTER TABLE `master_customer_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `master_datatype`
--
ALTER TABLE `master_datatype`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_divisions`
--
ALTER TABLE `master_divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_parent_child`
--
ALTER TABLE `master_parent_child`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_relation`
--
ALTER TABLE `master_relation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_status_report`
--
ALTER TABLE `master_status_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_tables`
--
ALTER TABLE `master_tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_table_structures`
--
ALTER TABLE `master_table_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sla_plans`
--
ALTER TABLE `sla_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `extends`
--
ALTER TABLE `extends`
  ADD CONSTRAINT `extends_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `extend_files`
--
ALTER TABLE `extend_files`
  ADD CONSTRAINT `extend_files_extend_id_foreign` FOREIGN KEY (`extend_id`) REFERENCES `extends` (`id`);

--
-- Constraints for table `master_customer_branches`
--
ALTER TABLE `master_customer_branches`
  ADD CONSTRAINT `master_customer_branches_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `master_customers` (`id`);

--
-- Constraints for table `master_table_structures`
--
ALTER TABLE `master_table_structures`
  ADD CONSTRAINT `master_table_structures_table_id_foreign` FOREIGN KEY (`table_id`) REFERENCES `master_tables` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_division_foreign` FOREIGN KEY (`division`) REFERENCES `master_divisions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
