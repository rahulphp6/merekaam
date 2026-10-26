-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 04:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytask`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE `active_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `live_ip` varchar(100) DEFAULT NULL,
  `pc_ip` varchar(100) DEFAULT NULL,
  `user_ip` varchar(100) DEFAULT NULL,
  `time_in` varchar(50) DEFAULT NULL,
  `time_out` varchar(50) DEFAULT NULL,
  `last_active` datetime DEFAULT NULL,
  `pc_details` varchar(500) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `severity` enum('low','medium','high') DEFAULT 'medium',
  `bugs_status` enum('open','fixed','closed') DEFAULT 'open',
  `reported_by` int(11) DEFAULT NULL,
  `fixed_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `short` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `currency` varchar(30) DEFAULT NULL,
  `carrier` varchar(5000) DEFAULT NULL,
  `ret_des` varchar(500) DEFAULT NULL,
  `payment_mode` varchar(3000) DEFAULT NULL,
  `logo` varchar(500) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `linkedin` varchar(500) DEFAULT NULL,
  `instagram` varchar(500) DEFAULT NULL,
  `facebook` varchar(500) DEFAULT NULL,
  `twitter` varchar(300) DEFAULT NULL,
  `wapp` int(11) NOT NULL DEFAULT 0,
  `chat` int(11) NOT NULL DEFAULT 0,
  `store` bigint(20) DEFAULT NULL,
  `server_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id`, `brand`, `short`, `phone`, `email`, `currency`, `carrier`, `ret_des`, `payment_mode`, `logo`, `address`, `linkedin`, `instagram`, `facebook`, `twitter`, `wapp`, `chat`, `store`, `server_date`) VALUES
(5, 'Point of Sale', 'POS', '+971 4 334 0499', 'sales@optiecraft.com', 'AED', 'Hand Delivery,DHL Express,Century Courier,FedEx, Emirates Post, Other Local Courier', 'Advance Payment,Retainer Payment,Example', 'Bank Remittance, Bank Transfer, Cash, Cash-POS, Check, Credit Card, demo, Wallet', 'logo.png', 'iSpexe Trading - FZE, Dubai Digital Park, A6 Building, DSOA, Dubai,U.A.E', '', 'https://www.instagram.com/opti.craft/?r=nametag', 'https://www.facebook.com/optiecraft', '', 0, 0, NULL, '2020-12-12 04:49:15');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `date` varchar(100) NOT NULL,
  `store` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `server_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `date`, `store`, `status`, `server_date`) VALUES
(8, 'Administrator', '2021-07-16 09:14:59', 0, 1, '2021-07-16 03:44:43'),
(33, 'sales', '', 0, 1, '2025-10-29 12:46:49'),
(58, 'Digital Marketing', '2026-08-14', 0, 1, '2026-08-14 06:34:13'),
(59, 'Development', '2026-08-14', 0, 1, '2026-08-14 06:34:20'),
(60, 'Designing', '2026-08-14', 0, 1, '2026-08-14 06:34:30'),
(61, 'Testers', '2026-08-14', 0, 1, '2026-08-14 06:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `deployments`
--

CREATE TABLE `deployments` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `deployed_by` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `lead_status` enum('new','contacted','converted','lost') DEFAULT 'new',
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `phone`, `website`, `project_name`, `lead_status`, `status`, `date`) VALUES
(4, 'suhial', '', '', 'Whatsapp', 'new', 1, '2026-08-12 18:30:00'),
(5, 'Akshay', '', '', 'Medtenance', 'new', 1, '2025-02-28 18:30:00'),
(6, 'Shree Shyam Hospital', '', '', '', 'new', 1, '2026-07-31 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `addnew` varchar(200) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `store` bigint(20) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `icon`, `link`, `addnew`, `parent`, `sort`, `status`, `is_active`, `store`, `date`) VALUES
(1, 'Leads', 'search', 'leads', 'leads-add', 0, 2, 1, 1, 0, '0000-00-00 00:00:00'),
(2, 'projects', 'check-square-o', 'projects', 'projects-add', 0, 3, 1, 1, 0, '0000-00-00 00:00:00'),
(3, 'Tasks', 'clipboard', 'tasks', 'tasks-add', 0, 4, 1, 1, 0, '0000-00-00 00:00:00'),
(4, 'dashboard', 'dashboard', 'dashboard', '', 0, 1, 1, 0, NULL, '2026-07-29 18:30:00'),
(6, 'payments', 'money', 'payments', '', 0, 4, 1, 1, NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `MKey` varchar(200) NOT NULL,
  `about` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `MKey`, `about`, `status`, `date`) VALUES
(2, 'login', 'c4ca4238a0b923820dcc509a6f75849b', 'manage logins', 1, '2020/08/26 11:17:53 am'),
(3, 'roles', 'c4ca4238a0b923820dcc509a6f75849b', 'manage roles activity', 1, '2020/08/26 11:19:28 am'),
(4, 'pro', 'cfcd208495d565ef66e7dff9f98764da', 'enable extra features', 1, '2020/08/26 11:26:17 am');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `heading` varchar(300) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `server_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `heading`, `description`, `date`, `status`, `server_date`) VALUES
(1, 'Welcome to POS', 'POS! Ready to launch', '2021-08-02 08:36:53', 0, '2020-08-02 23:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `url` varchar(300) DEFAULT NULL,
  `ntime` varchar(100) DEFAULT NULL,
  `repeat` int(11) DEFAULT 1,
  `nloop` int(11) NOT NULL DEFAULT 1,
  `publish_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_read` int(11) NOT NULL DEFAULT 0,
  `read_by` bigint(20) DEFAULT NULL,
  `store` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `url`, `ntime`, `repeat`, `nloop`, `publish_date`, `is_read`, `read_by`, `store`, `status`, `date`) VALUES
(2, 2128727000000069001, 'Demo', 'Hi Demo', NULL, '2023-01-10 10:49:26', 1, 1, '2023-01-10 01:14:34', 1, 0, 704774487, 1, '2023-01-10 10:44:34'),
(3, 2128727000000072086, 'Complete Your Confirmed Sales Order Until December 2022', 'Dear Sally, Past dues all confirmed sales order have to be closed asap.', NULL, '2023-01-10 10:45:14', 3, 1, '2023-01-10 01:14:17', 0, NULL, 704774487, 1, '2023-01-10 10:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `installment_no` int(11) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `paid_status` enum('pending','paid','overdue') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `level` int(11) NOT NULL DEFAULT 2,
  `status` int(11) NOT NULL DEFAULT 1,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `level`, `status`, `date`) VALUES
(1, '404', '', 2, 1, '2022-03-05'),
(26, 'mail', '', 2, 1, '2022-03-05'),
(27, 'module', '', 2, 1, '2022-03-05'),
(28, 'notes', '', 2, 1, '2022-03-05'),
(42, 'profile', '', 2, 1, '2022-03-05'),
(47, 'roles', '', 2, 1, '2022-03-05'),
(54, 'store', '', 2, 1, '2022-03-05'),
(63, 'user', '', 2, 1, '2022-03-05'),
(64, 'users', '', 2, 1, '2022-03-05'),
(327, 'login', '', 2, 1, '2022-03-09'),
(396, 'setting', '', 2, 1, '2022-03-15'),
(700, 'items', '', 2, 1, '2022-05-13'),
(1110, 'theme', '', 2, 1, '2024-03-09'),
(1111, 'menu', '', 2, 1, '2024-03-09'),
(1114, 'testing', '', 2, 1, '2025-10-28'),
(1121, 'locations', '', 2, 1, '2025-12-16'),
(1122, 'database', '', 2, 1, '2025-12-04'),
(1126, 'location', '', 2, 1, '2025-12-16'),
(1133, 'job', '', 2, 1, '2026-07-28'),
(1134, 'cargo_types', '', 2, 1, '2026-07-28'),
(1136, 'bugs', '', 2, 1, '2026-07-28'),
(1137, 'task', '', 2, 1, '2026-07-28'),
(1138, 'clients', '', 2, 1, '2026-07-28'),
(1139, 'tasks', '', 2, 1, '2026-07-28'),
(1140, 'projects', '', 2, 1, '2026-07-29'),
(1141, 'leads', '', 2, 1, '2026-07-30'),
(1142, 'dashboard', '', 2, 1, '2026-07-30'),
(1143, 'payments', '', 2, 1, '2026-08-14'),
(1144, 'departments', '', 2, 1, '2026-08-14');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `isRead` int(11) DEFAULT 0,
  `isWrite` int(11) DEFAULT 0,
  `isEdit` int(11) DEFAULT 0,
  `isDelete` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `isRead`, `isWrite`, `isEdit`, `isDelete`, `status`) VALUES
(1, 5, 1, 1, 1, 1, 1, 0),
(16, 5, 26, 1, 1, 1, 1, 0),
(17, 5, 27, 1, 1, 1, 1, 0),
(18, 5, 28, 1, 1, 1, 1, 0),
(29, 5, 42, 1, 1, 1, 1, 0),
(34, 5, 47, 1, 1, 1, 1, 0),
(39, 5, 54, 1, 1, 1, 1, 0),
(46, 5, 63, 1, 1, 1, 1, 0),
(47, 5, 64, 1, 1, 1, 1, 0),
(48, 1, 1, 1, 1, 1, 1, 0),
(63, 1, 26, 1, 1, 1, 1, 0),
(64, 1, 27, 1, 1, 1, 1, 0),
(65, 1, 28, 1, 1, 1, 1, 0),
(76, 1, 42, 1, 1, 1, 1, 0),
(81, 1, 47, 1, 1, 1, 1, 0),
(86, 1, 54, 1, 1, 1, 1, 0),
(93, 1, 63, 1, 1, 1, 1, 0),
(94, 1, 64, 1, 1, 1, 1, 0),
(97, 1, 327, 1, 1, 1, 1, 0),
(99, 1, 396, 1, 1, 1, 1, 0),
(104, 5, 327, 1, 1, 1, 1, 0),
(106, 5, 396, 1, 1, 1, 1, 0),
(164, 5, 700, 1, 1, 1, 0, 0),
(170, 1, 700, 1, 1, 1, 1, 0),
(174, 2, 1, 1, 1, 1, 1, 0),
(189, 2, 26, 1, 1, 1, 1, 0),
(190, 2, 27, 1, 1, 1, 1, 0),
(191, 2, 28, 1, 1, 1, 1, 0),
(202, 2, 42, 1, 1, 1, 1, 0),
(207, 2, 47, 1, 1, 1, 1, 0),
(212, 2, 54, 1, 1, 1, 1, 0),
(219, 2, 63, 1, 1, 1, 1, 0),
(220, 2, 64, 1, 1, 1, 1, 0),
(223, 2, 327, 1, 1, 1, 1, 0),
(225, 2, 396, 1, 1, 1, 1, 0),
(229, 2, 700, 1, 1, 1, 1, 0),
(233, 3, 1, 1, 1, 1, 1, 0),
(248, 3, 26, 1, 1, 1, 1, 0),
(249, 3, 27, 1, 1, 1, 1, 0),
(250, 3, 28, 1, 1, 1, 1, 0),
(261, 3, 42, 1, 1, 1, 1, 0),
(266, 3, 47, 1, 1, 1, 1, 0),
(271, 3, 54, 1, 1, 1, 1, 0),
(278, 3, 63, 1, 1, 1, 1, 0),
(279, 3, 64, 1, 1, 1, 1, 0),
(282, 3, 327, 1, 1, 1, 1, 0),
(284, 3, 396, 1, 1, 1, 1, 0),
(288, 3, 700, 1, 1, 1, 1, 0),
(308, 5, 1110, 1, 1, 0, 0, 0),
(309, 5, 1111, 1, 1, 0, 0, 0),
(312, 5, 1114, 0, 0, 0, 0, 0),
(318, 5, 1121, 0, 0, 0, 0, 0),
(319, 5, 1122, 0, 0, 0, 0, 0),
(326, 1, 1110, 1, 1, 1, 1, 0),
(327, 1, 1111, 1, 1, 1, 1, 0),
(330, 1, 1114, 1, 1, 1, 1, 0),
(336, 1, 1121, 1, 1, 1, 1, 0),
(337, 1, 1122, 1, 1, 1, 1, 0),
(340, 1, 1126, 1, 1, 1, 1, 0),
(347, 3, 1110, 1, 1, 1, 1, 0),
(348, 3, 1111, 1, 1, 1, 1, 0),
(351, 3, 1114, 1, 1, 1, 1, 0),
(357, 3, 1121, 1, 1, 1, 1, 0),
(358, 3, 1122, 1, 1, 1, 1, 0),
(361, 3, 1126, 1, 1, 1, 1, 0),
(369, 5, 1126, 0, 0, 0, 0, 0),
(376, 3, 1133, 1, 1, 1, 1, 0),
(377, 1, 1133, 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `payment_terms` text DEFAULT NULL,
  `policy` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `reference_link` varchar(255) DEFAULT NULL,
  `project_status` enum('active','on_hold','completed','archived') DEFAULT 'active',
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `client_id`, `name`, `amount`, `payment_terms`, `policy`, `file`, `reference`, `reference_link`, `project_status`, `status`, `date`) VALUES
(4, 4, 'WhatsApp CRM email payment reciept', 13100.00, '2', '', NULL, '', 'whatsapp', 'active', 1, '2026-08-12 18:30:00'),
(5, 4, 'wpsender designing', 67000.00, '2', '', NULL, '', '', 'active', 1, '2026-07-12 18:30:00'),
(6, 4, 'logistic CRM', 248000.00, '4', '', NULL, '', '', 'active', 1, '2026-07-18 18:30:00'),
(7, 4, 'POS V.4 upgrade', 3560.00, '4', '', NULL, '', '', 'active', 1, '2026-08-13 18:30:00'),
(8, 5, 'Medtenace Website work', 17000.00, '1', '', NULL, '', '', 'completed', 1, '2025-03-17 18:30:00'),
(9, 5, 'Medtenance CRM', 62000.00, '2', '', NULL, '', '', 'completed', 1, '2025-03-17 18:30:00'),
(10, 6, 'WP Website Work dynamic', 12000.00, '1', '', NULL, '', '', 'completed', 1, '2026-07-31 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `status`, `date`) VALUES
(1, 'administrator', 'you can manage', 1, '2024-03-12 00:30:47'),
(2, 'super admin', 'advance admin', 1, '2024-03-12 00:30:47'),
(3, 'admin', 'simple admin', 1, '2024-03-12 00:30:47'),
(5, 'user', 'front end user also read user', 1, '2024-03-12 00:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `mode` int(11) NOT NULL DEFAULT 1,
  `push` int(11) NOT NULL DEFAULT 1,
  `sms` int(11) NOT NULL DEFAULT 1,
  `email` int(11) NOT NULL DEFAULT 1,
  `support` int(11) NOT NULL DEFAULT 1,
  `store` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `mode`, `push`, `sms`, `email`, `support`, `store`) VALUES
(1, 1, 1, 1, 1, 1, 704774487),
(6, 0, 1, 1, 1, 1, 705054324);

-- --------------------------------------------------------

--
-- Table structure for table `smtp`
--

CREATE TABLE `smtp` (
  `id` int(11) NOT NULL,
  `host` varchar(100) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `pwd` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `multi_ph` varchar(500) DEFAULT NULL,
  `server_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smtp`
--

INSERT INTO `smtp` (`id`, `host`, `port`, `user`, `pwd`, `status`, `phone`, `email`, `multi_ph`, `server_date`) VALUES
(3, 'imaxxe.com', 465, 'sales@imaxxe.com', 'JHNsc0AxODE5ODI=', 1, '909090990909', 'suhial@hotmail.com', '', '2020-10-17 23:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `task_status` enum('todo','in_progress','completed','testing','deployed') DEFAULT 'todo',
  `progress` int(11) DEFAULT 0,
  `task_history` int(11) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `name`, `description`, `assigned_to`, `priority`, `task_status`, `progress`, `task_history`, `deadline`, `status`, `date`) VALUES
(4, 4, 'Email zinna payment reciept', '', 2, 'medium', 'in_progress', 40, 0, '2026-08-19', 1, '2026-08-13 18:30:00'),
(5, 5, 'wpsender design same twilio UI', 'design must be copy with twilio', 320, 'low', 'completed', 100, 0, '2026-08-15', 1, '2026-07-12 18:30:00'),
(6, 6, 'First Phase task', 'prepare CRUD and front for this crm', 320, 'high', 'completed', 100, 0, '2026-08-10', 1, '0000-00-00 00:00:00'),
(7, 6, 'Second Phase logistic', 'prepare second phase logistic connectvity with zoho and prepare modules cutomers, estimates, projects', 2, 'high', 'in_progress', 60, 0, '2026-08-16', 1, '2026-08-10 18:30:00'),
(8, 6, 'third phase work', 'prepare third phase after review second phase', 2, 'high', 'in_progress', 0, 0, '2026-08-31', 1, '2026-08-13 18:30:00'),
(9, 6, 'Final Deployment', 'deliver this work after testing', 320, 'low', 'todo', 0, 0, '2026-09-19', 1, '2026-08-13 18:30:00'),
(10, 8, 'website plus forum development', '', 2, 'medium', 'completed', 100, 0, '0000-00-00', 1, '2026-07-13 18:30:00'),
(11, 9, 'CRM development medical field', '', 2, 'medium', 'completed', 100, 0, '0000-00-00', 1, '2025-04-28 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `task_logs`
--

CREATE TABLE `task_logs` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `log_text` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testing`
--

CREATE TABLE `testing` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `test_case` text DEFAULT NULL,
  `result` enum('pass','fail') DEFAULT NULL,
  `tested_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `store` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `name`, `store`, `status`, `date`) VALUES
(1, 'eyeconic', 705054324, 0, '2024-01-06 01:35:53'),
(2, 'tubler', 772285939, 1, '2024-01-06 01:32:30'),
(3, 'opticraft', 704774487, 0, '2024-01-07 01:50:04'),
(4, 'alamin', 0, 1, '2026-02-11 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `location_id` bigint(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `query` varchar(500) DEFAULT NULL,
  `related` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date` varchar(100) DEFAULT NULL,
  `server_details` varchar(200) DEFAULT NULL,
  `server_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `user_id`, `customer_id`, `location_id`, `title`, `query`, `related`, `status`, `date`, `server_details`, `server_date`) VALUES
(40, 3106697000035312003, 3106697000006222239, 3106697000006122442, 'error', 'get solve', NULL, 1, '2025-12-05', NULL, '2025-12-05 06:23:39'),
(46, 3106697000021120049, 3106697000016804221, 3106697000000079013, 'bbhai', '', NULL, 1, '2025-12-10', NULL, '2025-12-10 13:09:25'),
(47, 3106697000000074001, 3106697000014198001, 3106697000022102616, 'title', 'quesfff', NULL, 1, '2025-12-10', NULL, '2025-12-10 13:10:14'),
(48, 3106697000021120049, 3106697000015650081, 3106697000020914119, 'error', 'reso', NULL, 1, '2025-12-10', NULL, '2025-12-10 13:19:31'),
(49, 0, 0, 3106697000000079013, '', '', NULL, 1, '2025-12-10', NULL, '2025-12-10 13:25:04'),
(50, 3106697000035312003, 3106697000000247023, 3106697000006188780, 'some issue', 'issue query', NULL, 1, '2025-12-30', NULL, '2025-12-30 12:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `store` bigint(20) DEFAULT NULL,
  `server_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `UserName` varchar(500) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `role` int(11) DEFAULT 5,
  `dep_id` int(11) DEFAULT NULL,
  `profilePic` varchar(300) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `Gender` int(11) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `CountryName` varchar(100) DEFAULT NULL,
  `EndUserIp` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `date` datetime DEFAULT NULL,
  `is_current_user` int(5) DEFAULT NULL,
  `role_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `UserName`, `last_name`, `role`, `dep_id`, `profilePic`, `password`, `email`, `phone`, `Gender`, `dob`, `address`, `City`, `CountryName`, `EndUserIp`, `status`, `date`, `is_current_user`, `role_id`) VALUES
(1, 'suhial', 'suhial_iSpexe', NULL, 1, 0, 'upload/teams-dp/screenshot-2025-10-10-130827/screenshot-2025-10-10-130827.png', '$2y$10$FLmYQNwiwD6zniLO2M0Q7.TXUiOH9XgnSmSCkE0.lhx8w8fwk7fcu', 'suhial@hotmail.com', '909090990909', NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00 00:00:00', NULL, '1'),
(2, 'Rahul', 'SuperAdmin', NULL, 1, NULL, 'upload/teams-dp/rpilot/rpilot.png', '$2y$10$C7T8hHBQKQKrdrds5r8/QeeYAACE8.FVEfyAI2dvV.j/mT1R77t46', 'rahulphp7@gmail.com', '919990099238', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-08-14 00:00:00', NULL, '3'),
(320, 'Vikas', NULL, NULL, 5, 59, NULL, NULL, 'vikasphp@gmail.com', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00 00:00:00', NULL, '5'),
(321, 'sumit', NULL, NULL, 5, 60, NULL, NULL, 'sumit@gmail.com', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-08-14 00:00:00', NULL, '5'),
(322, 'Deepak', NULL, NULL, 5, 58, NULL, NULL, 'deepak@bhargavji.in', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-08-14 00:00:00', NULL, '5'),
(323, 'Prince', NULL, NULL, 5, 58, NULL, NULL, 'prince@bhargavji.in', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-08-14 00:00:00', NULL, '5'),
(324, 'Neeraj', NULL, NULL, 5, 59, NULL, NULL, 'neeraj@bhargavji.in', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-08-14 00:00:00', NULL, '5'),
(325, 'Renu', NULL, NULL, 5, 61, NULL, NULL, 'renu@bhargavji.in', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-08-14 00:00:00', NULL, '5'),
(326, 'Reena Sharma', NULL, NULL, 5, 33, NULL, NULL, 'reena@bhargavji.in', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '0000-00-00 00:00:00', NULL, '5'),
(327, 'shakir Ali', NULL, NULL, 5, 59, NULL, NULL, 'ali@bhargavji.in', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-08-14 00:00:00', NULL, '5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_users`
--
ALTER TABLE `active_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_phone` (`phone`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unqName` (`name`);

--
-- Indexes for table `deployments`
--
ALTER TABLE `deployments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_module` (`name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payments_project` (`project_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perm` (`permission_id`),
  ADD KEY `fk_role_id` (`role_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projects_lead` (`client_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store` (`store`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tasks_project` (`project_id`);

--
-- Indexes for table `task_logs`
--
ALTER TABLE `task_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testing`
--
ALTER TABLE `testing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_users`
--
ALTER TABLE `active_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `deployments`
--
ALTER TABLE `deployments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1145;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task_logs`
--
ALTER TABLE `task_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testing`
--
ALTER TABLE `testing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `fk_perm` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_lead` FOREIGN KEY (`client_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
