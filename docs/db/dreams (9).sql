-- Combined SQL dump: dreams.sql + dreams(2).sql
-- Duplicate SQL statements removed.
-- Statements from dreams.sql are retained first; unique statements from dreams(2).sql
-- are then appended.
--
-- NOTE: This removes duplicate statements, but does not resolve conflicting INSERTs
-- that use the same primary key with different values. Such conflicts are retained
-- as separate statements and may require manual reconciliation on import.

SET FOREIGN_KEY_CHECKS=0;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 06:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dreams`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_heads`
--

CREATE TABLE `account_heads` (
  `id` int(11) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_type` enum('Asset','Liability','Income','Expense','Equity','VAT') NOT NULL,
  `account_subtype` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `opening_balance` decimal(12,2) DEFAULT 0.00,
  `current_balance` decimal(12,2) DEFAULT 0.00,
  `total_debit` decimal(12,2) DEFAULT 0.00,
  `total_credit` decimal(12,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `last_transaction_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_heads`
--

INSERT INTO `account_heads` (`id`, `account_code`, `account_name`, `account_type`, `account_subtype`, `parent_id`, `opening_balance`, `current_balance`, `total_debit`, `total_credit`, `status`, `last_transaction_date`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CASH', 'Cash in Hand', 'Asset', 'Current Asset', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(2, 'BANK', 'Bank Account', 'Asset', 'Current Asset', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(3, 'AR', 'Accounts Receivable', 'Asset', 'Current Asset', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(4, 'AP', 'Accounts Payable', 'Liability', 'Current Liability', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(5, 'SALES', 'Sales Income', 'Income', 'Operating Income', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(6, 'PURCHASE', 'Purchase / COGS', 'Expense', 'Cost of Goods Sold', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(7, 'VAT_OUTPUT', 'VAT Payable (Output VAT)', 'VAT', 'Output VAT', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(8, 'VAT_INPUT', 'VAT Receivable (Input VAT)', 'VAT', 'Input VAT', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(9, '1234', 'account reciaveable', 'Asset', 'current asset', 3, 3000000.00, 300000.00, 0.00, 0.00, 'Active', NULL, '', '2026-08-17 00:09:02', '2026-08-18 00:55:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_heads`
--

CREATE TABLE `account_heads` (
  `id` int(11) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_type` enum('Asset','Liability','Income','Expense','Equity','VAT') NOT NULL,
  `account_subtype` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `opening_balance` decimal(12,2) DEFAULT 0.00,
  `current_balance` decimal(12,2) DEFAULT 0.00,
  `total_debit` decimal(12,2) DEFAULT 0.00,
  `total_credit` decimal(12,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `last_transaction_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_heads`
--

INSERT INTO `account_heads` (`id`, `account_code`, `account_name`, `account_type`, `account_subtype`, `parent_id`, `opening_balance`, `current_balance`, `total_debit`, `total_credit`, `status`, `last_transaction_date`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CASH', 'Cash in Hand', 'Asset', 'Current Asset', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(2, 'BANK', 'Bank Account', 'Asset', 'Current Asset', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(3, 'AR', 'Accounts Receivable', 'Asset', 'Current Asset', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(4, 'AP', 'Accounts Payable', 'Liability', 'Current Liability', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(5, 'SALES', 'Sales Income', 'Income', 'Operating Income', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(6, 'PURCHASE', 'Purchase / COGS', 'Expense', 'Cost of Goods Sold', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(7, 'VAT_OUTPUT', 'VAT Payable (Output VAT)', 'VAT', 'Output VAT', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(8, 'VAT_INPUT', 'VAT Receivable (Input VAT)', 'VAT', 'Input VAT', NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-16 13:25:20', '2026-08-16 13:25:20', NULL),
(9, '1232', 'account reciaveable', 'Asset', 'current asset', 3, 300000.00, 300000.00, 0.00, 0.00, 'Active', NULL, '', '2026-08-17 00:09:02', '2026-08-17 00:09:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Grocery item', 'Daily household items', '2026-08-02 23:34:06', '2026-08-06 10:38:53', '2026-08-06', NULL, NULL),
(4, 'stationary', 'pen,pencil,paper etc', '2026-08-06 02:27:21', '2026-08-06 10:39:37', '2026-08-06', NULL, NULL),
(5, 'stationary', 'pen,pencil,paper etc', '2026-08-06 02:28:05', '2026-08-06 10:38:59', '2026-08-06', NULL, NULL),
(6, 'Toys', 'child playing accessories', '2026-08-06 09:54:29', '2026-08-06 09:54:29', NULL, NULL, NULL),
(7, 'Toys', 'child playing accessories', '2026-08-06 10:04:12', '2026-08-06 10:39:07', '2026-08-06', NULL, NULL),
(8, 'stationary', 'pen,paper,pencil', '2026-08-06 10:05:18', '2026-08-06 10:39:20', '2026-08-06', NULL, NULL),
(9, 'stationary', 'pen,paper,pencil', '2026-08-06 10:07:54', '2026-08-06 10:39:23', '2026-08-06', NULL, NULL),
(10, 'stationary', 'pen,paper,pencil', '2026-08-06 10:08:17', '2026-08-06 10:08:17', NULL, NULL, NULL),
(11, 'stationary', 'pen,paper,pencil', '2026-08-06 10:18:15', '2026-08-06 10:39:13', '2026-08-06', NULL, NULL),
(12, 'food', 'daily nutrition food', '2026-08-06 10:19:09', '2026-08-06 10:19:09', NULL, NULL, NULL),
(13, 'Computer Accecories', 'dsjfkl', '2026-08-14 05:29:51', '2026-08-14 05:29:51', NULL, NULL, NULL),
(14, 'jkj', 'udio', '2026-08-14 06:02:39', '2026-08-14 06:02:39', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `account_id` int(11) NOT NULL,
  `account_code` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_type` enum('Asset','Liability','Income','Expense','Equity','VAT') NOT NULL,
  `account_subtype` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `opening_balance` decimal(12,2) DEFAULT 0.00,
  `current_balance` decimal(12,2) DEFAULT 0.00,
  `total_debit` decimal(12,2) DEFAULT 0.00,
  `total_credit` decimal(12,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `last_transaction_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`account_id`, `account_code`, `account_name`, `account_type`, `account_subtype`, `parent_id`, `opening_balance`, `current_balance`, `total_debit`, `total_credit`, `status`, `last_transaction_date`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1000', 'Assets', 'Asset', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(2, '1100', 'Cash in Hand', 'Asset', NULL, 1, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(3, '1200', 'Accounts Receivable', 'Asset', NULL, 1, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(4, '1300', 'Inventory / Stock', 'Asset', NULL, 1, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(5, '2000', 'Accounts Payable', 'Liability', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(6, '2100', 'VAT Payable (Output)', 'VAT', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(7, '2200', 'VAT Receivable (Input)', 'VAT', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(8, '4000', 'Sales Revenue', 'Income', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(9, '5000', 'Purchase / COGS', 'Expense', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 'Active', NULL, NULL, '2026-08-15 12:08:24', '2026-08-15 12:08:24', NULL),
(10, '1232', 'account reciaveable', 'Equity', '', 3, 100000.00, 100000.00, 0.00, 0.00, 'Active', NULL, '', '2026-08-15 16:07:17', '2026-08-15 16:07:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `membership_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `gender`, `phone`, `email`, `address`, `membership_type`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Araf Rahman', 'Male', '+8801589756', 'araf0505@yahoo.com', 'Hider Ali Musir Bari, Fatehabed', 'Regular', '2026-08-02 03:50:28', NULL, NULL, NULL, NULL),
(2, 'Muhammad Al Junayed', 'Male', '+6849213547', 'junayed684@gmail.com', 'Bagdad,iraq', 'Regular', '2026-08-02 04:11:25', NULL, NULL, NULL, NULL),
(3, 'Sultan ibn Adel', 'Male', '+6483215645', 'SultanAdel@gmail.com', 'al hudayed,yaman', 're', '2026-08-02 04:12:50', NULL, NULL, NULL, NULL),
(4, 'Belel ibn rabah al habasi', 'Male', '+6478215465', 'BelelRabah@gmail.com', 'Abhi-Siniya(eithopia)', 'R', '2026-08-02 04:14:07', NULL, NULL, NULL, NULL),
(6, 'shah sultan', 'Male', '0658545', '', 'hathazari', 'regular', '2026-08-14 05:34:46', NULL, NULL, NULL, NULL),
(7, 'amir hamza', 'Male', '6598', 'hamza@gmail.com', 'sdfjh', 'regular', '2026-08-14 06:03:56', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `category_id`, `expense_date`, `amount`, `payment_method`, `description`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 2, '2026-08-15', 652000.00, 'Cash', '', '2026-08-15 07:01:17', NULL, NULL, 7, NULL),
(2, 3, '2026-08-14', 5000.00, 'Cash', '', '2026-08-15 08:12:57', NULL, NULL, 7, NULL),
(1, 2, '2026-08-15', 652000.00, 'Cash', '', '2026-08-15 07:01:17', NULL, NULL, 7, NULL),
(2, 3, '2026-08-14', 5000.00, 'Cash', '', '2026-08-15 08:12:57', NULL, NULL, 7, NULL),
(1, 2, '2026-08-15', 652000.00, 'Cash', '', '2026-08-15 07:01:17', NULL, NULL, 7, NULL),
(2, 3, '2026-08-14', 5000.00, 'Cash', '', '2026-08-15 08:12:57', NULL, NULL, 7, NULL),
(1, 2, '2026-08-15', 652000.00, 'Cash', '', '2026-08-15 07:01:17', NULL, NULL, 7, NULL),
(2, 3, '2026-08-14', 5000.00, 'Cash', '', '2026-08-15 08:12:57', NULL, NULL, 7, NULL),
(3, 3, '2026-08-10', 65.00, 'Cash', 'kk', '2026-08-15 20:19:28', NULL, NULL, 7, NULL),
(1, 2, '2026-08-15', 652000.00, 'Cash', '', '2026-08-15 07:01:17', NULL, NULL, 7, NULL),
(2, 3, '2026-08-14', 5000.00, 'Cash', '', '2026-08-15 08:12:57', NULL, NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `category_name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Salary', 'Salaries of the staffs', 1, '2026-08-15 05:28:08', NULL, NULL, 7, NULL),
(2, 'Rent', 'rent', 1, '2026-08-15 07:01:01', NULL, NULL, 7, NULL),
(3, 'Bonus', 'Bonuses', 1, '2026-08-15 08:07:47', NULL, NULL, 7, NULL),
(1, 'Salary', 'Salaries of the staffs', 1, '2026-08-15 05:28:08', NULL, NULL, 7, NULL),
(2, 'Rent', 'rent', 1, '2026-08-15 07:01:01', NULL, NULL, 7, NULL),
(3, 'Bonus', 'Bonuses', 1, '2026-08-15 08:07:47', NULL, NULL, 7, NULL),
(1, 'Salary', 'Salaries of the staffs', 1, '2026-08-15 05:28:08', NULL, NULL, 7, NULL),
(2, 'Rent', 'rent', 1, '2026-08-15 07:01:01', NULL, NULL, 7, NULL),
(3, 'Bonus', 'Bonuses', 1, '2026-08-15 08:07:47', NULL, NULL, 7, NULL),
(1, 'Salary', 'Salaries of the staffs', 1, '2026-08-15 05:28:08', NULL, NULL, 7, NULL),
(2, 'Rent', 'rent', 1, '2026-08-15 07:01:01', NULL, NULL, 7, NULL),
(3, 'Bonus', 'Bonuses', 1, '2026-08-15 08:07:47', NULL, NULL, 7, NULL),
(1, 'Salary', 'Salaries of the staffs', 1, '2026-08-15 05:28:08', NULL, NULL, 7, NULL),
(2, 'Rent', 'rent', 1, '2026-08-15 07:01:01', NULL, NULL, 7, NULL),
(3, 'Bonus', 'Bonuses', 1, '2026-08-15 08:07:47', NULL, NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `entry_id` bigint(20) NOT NULL,
  `entry_date` date NOT NULL,
  `reference_type` enum('Sales','Purchase','Stock','Payment','Receipt','Manual') NOT NULL,
  `reference_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit` decimal(12,2) DEFAULT 0.00,
  `credit` decimal(12,2) DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`entry_id`, `entry_date`, `reference_type`, `reference_id`, `account_id`, `debit`, `credit`, `description`, `created_by`, `created_at`) VALUES
(1, '2026-08-04', 'Purchase', 8, 4, 119500.00, 0.00, 'Purchase #8 - Inventory', 7, '2026-08-16 06:08:44'),
(2, '2026-08-04', 'Purchase', 8, 5, 0.00, 119500.00, 'Purchase #8 - Payable', 7, '2026-08-16 06:08:44'),
(3, '2026-08-12', 'Purchase', 9, 4, 13500.00, 0.00, 'Purchase #9 - Inventory', 7, '2026-08-16 06:31:45'),
(4, '2026-08-12', 'Purchase', 9, 5, 0.00, 13500.00, 'Purchase #9 - Payable', 7, '2026-08-16 06:31:45'),
(5, '2026-08-11', 'Purchase', 10, 4, 249750.00, 0.00, 'Purchase #10 - Inventory', 7, '2026-08-16 06:50:56'),
(6, '2026-08-11', 'Purchase', 10, 5, 0.00, 249750.00, 'Purchase #10 - Payable', 7, '2026-08-16 06:50:56'),
(7, '2026-08-04', 'Purchase', 11, 4, 105.00, 0.00, 'Purchase #11 - Inventory', 7, '2026-08-16 06:54:39'),
(8, '2026-08-04', 'Purchase', 11, 5, 0.00, 105.00, 'Purchase #11 - Payable', 7, '2026-08-16 06:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `journal_vouchers`
--

CREATE TABLE `journal_vouchers` (
  `id` int(11) NOT NULL,
  `voucher_no` varchar(100) NOT NULL,
  `narration` text DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journal_vouchers`
--

INSERT INTO `journal_vouchers` (`id`, `voucher_no`, `narration`, `voucher_date`, `source_type`, `source_id`, `dr`, `cr`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'VCH-20260818-961', 'a/r', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 'Active', '2026-08-18 00:18:20', '2026-08-18 00:18:20', NULL),
(2, 'VCH-20260818-896', 'a/r', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 'Active', '2026-08-18 00:20:27', '2026-08-18 00:20:27', NULL),
(3, 'VCH-20260818-750', 'a/r', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 'Active', '2026-08-18 00:23:01', '2026-08-18 00:23:01', NULL),
(4, 'VCH-20260818-256', 'a/p', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 'Active', '2026-08-18 00:23:38', '2026-08-18 00:23:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_voucher_details`
--

CREATE TABLE `journal_voucher_details` (
  `id` int(11) NOT NULL,
  `journal_voucher_id` int(11) NOT NULL,
  `account_head_id` int(11) NOT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journal_voucher_details`
--

INSERT INTO `journal_voucher_details` (`id`, `journal_voucher_id`, `account_head_id`, `dr`, `cr`, `remarks`, `created_by`) VALUES
(1, 2, 3, 150000.00, 150000.00, 'a/r', 7),
(2, 3, 3, 150000.00, 150000.00, 'a/r', 7),
(3, 4, 4, 10000.00, 10000.00, 'a/p', 7);

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `id` int(11) NOT NULL,
  `payment_voucher_id` int(11) DEFAULT NULL,
  `receive_voucher_id` int(11) DEFAULT NULL,
  `journal_voucher_id` int(11) DEFAULT NULL,
  `account_head_id` int(11) NOT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`id`, `payment_voucher_id`, `receive_voucher_id`, `journal_voucher_id`, `account_head_id`, `dr`, `cr`, `remarks`, `created_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 3, 3, 150000.00, 150000.00, 'a/r', 7, '2026-08-18 00:23:01', '2026-08-18 00:23:01'),
(2, NULL, NULL, 4, 4, 10000.00, 10000.00, 'a/p', 7, '2026-08-18 00:23:38', '2026-08-18 00:23:38'),
(3, 3, NULL, NULL, 4, 10000.00, 10000.00, 'a/p', 7, '2026-08-18 00:30:57', '2026-08-18 00:30:57'),
(4, NULL, 1, NULL, 4, 100000.00, 100000.00, 'a/p', 7, '2026-08-18 00:39:12', '2026-08-18 00:39:12'),
(5, NULL, 2, NULL, 3, 50000.00, 50000.00, 'A/R', 7, '2026-08-18 00:39:44', '2026-08-18 00:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `journal_vouchers`
--

CREATE TABLE `journal_vouchers` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `note` text DEFAULT NULL,
  `date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_voucher_details`
--

CREATE TABLE `journal_voucher_details` (
  `id` int(11) NOT NULL,
  `journal_voucher_id` int(11) NOT NULL,
  `account_head_id` int(11) NOT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` int(11) NOT NULL,
  `payment_voucher_id` int(11) DEFAULT NULL,
  `receive_voucher_id` int(11) DEFAULT NULL,
  `journal_voucher_id` int(11) DEFAULT NULL,
  `account_head_id` int(11) NOT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_vouchers`
--

CREATE TABLE `payment_vouchers` (
  `id` int(11) NOT NULL,
  `voucher_no` varchar(100) NOT NULL,
  `pay_to` varchar(100) NOT NULL,
  `narration` text DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_vouchers`
--

INSERT INTO `payment_vouchers` (`id`, `voucher_no`, `pay_to`, `narration`, `voucher_date`, `source_type`, `source_id`, `dr`, `cr`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'VCH-20260818-827', 'a/p', 'a/p', '2026-08-17', NULL, NULL, 10000.00, 10000.00, 7, 'Active', '2026-08-18 00:30:57', '2026-08-18 00:31:18', '2026-08-17 20:31:18');

-- --------------------------------------------------------

--
-- Table structure for table `payment_voucher_details`
--

CREATE TABLE `payment_voucher_details` (
  `id` int(11) NOT NULL,
  `payment_voucher_id` int(11) NOT NULL,
  `account_head_id` int(11) NOT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_voucher_details`
--

INSERT INTO `payment_voucher_details` (`id`, `payment_voucher_id`, `account_head_id`, `dr`, `cr`, `remarks`, `created_by`) VALUES
(1, 3, 4, 10000.00, 10000.00, 'a/p', 7);

-- --------------------------------------------------------

--
-- Table structure for table `payment_vouchers`
--

CREATE TABLE `payment_vouchers` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `pay_to` varchar(100) NOT NULL,
  `note` text DEFAULT NULL,
  `date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_voucher_details`
--

CREATE TABLE `payment_voucher_details` (
  `id` int(11) NOT NULL,
  `payment_voucher_id` int(11) NOT NULL,
  `account_head_id` int(11) NOT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `product_name`, `brand`, `purchase_price`, `selling_price`, `barcode`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(3, 1, 1, 'Dumur', 'Tibbat', 1100.00, 1250.00, '145898', '2026-08-02 04:20:34', NULL, NULL, NULL, NULL),
(7, 10, 1, 'pencil', 'STAR', 6.50, 10.00, '1122', '2026-08-06 13:51:22', NULL, '2026-08-06 09:51:38', NULL, NULL),
(9, 1, 1, 'pencil', 'STAR', 7.00, 10.00, '9878', '2026-08-06 18:38:36', NULL, NULL, NULL, NULL),
(11, 1, 1, 'pencil', 'STAR', 7.00, 10.00, '2552', '2026-08-06 18:42:24', NULL, NULL, NULL, NULL),
(12, 0, 2, 'book', 'mkd', 250.00, 280.00, '1258', '2026-08-06 19:04:26', NULL, NULL, NULL, NULL),
(14, 666, 420, 'Cat Food', 'Miaw ', 450.00, 800.00, '', '2026-08-09 04:41:58', NULL, NULL, NULL, NULL),
(17, 4, 4, 'akrot', 'roja', 1200.00, 1350.00, 'khl', '2026-08-09 05:08:54', NULL, NULL, NULL, NULL),
(18, 4, 4, 'cumin', 'fdsf', 128.00, 135.00, '1365', '2026-08-12 04:38:45', NULL, NULL, NULL, NULL),
(19, 1, 1, 'black cumin', 'mkd', 135.00, 169.00, '2514', '2026-08-14 05:59:12', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT ' 1 Received, 0 Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `supplier_id`, `purchase_date`, `total_amount`, `discount_amount`, `discount_type`, `vat`, `grand_total`, `ref`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, '2026-08-12', 110700.00, 0.00, 1, 0.00, 110700.00, '', 1, '2026-08-12 02:28:21', '2026-08-12 06:28:21', NULL, 7, NULL),
(3, 1, '2026-08-12', 110700.00, 0.00, 1, 0.00, 110700.00, '', 1, '2026-08-12 02:34:54', '2026-08-12 06:34:54', NULL, 7, NULL),
(4, 1, '2026-08-12', 12500.00, 0.00, 1, 0.00, 12500.00, '', 1, '2026-08-12 03:23:30', '2026-08-12 07:23:30', NULL, 7, NULL),
(5, 2, '2026-08-09', 256.00, 5.00, 2, 15.00, 279.68, '', 1, '2026-08-12 12:12:44', '2026-08-12 16:12:44', NULL, 7, NULL),
(6, 1, '2026-08-10', 640.00, 0.00, 1, 0.00, 640.00, '', 1, '2026-08-12 12:53:01', '2026-08-12 16:53:01', NULL, 7, NULL),
(18, 0, '0000-00-00', 0.00, 0.00, 1, 0.00, 0.00, '', 1, '2026-08-16 11:03:05', '2026-08-16 15:03:05', NULL, 1, NULL),
(19, 2, '2026-08-14', 128000.00, 0.00, 1, 0.00, 128000.00, '', 1, '2026-08-16 11:19:17', '2026-08-16 15:19:17', NULL, 1, NULL),
(20, 3, '2026-08-15', 15360.00, 0.00, 1, 0.00, 15360.00, '', 1, '2026-08-16 19:50:17', '2026-08-16 23:50:17', NULL, 7, NULL),
(21, 1, '2026-08-16', 450000.00, 0.00, 1, 0.00, 450000.00, '', 1, '2026-08-17 02:28:39', '2026-08-17 06:28:39', NULL, 7, NULL);
(18, 0, '0000-00-00', 0.00, 0.00, 1, 0.00, 0.00, '', 1, '2026-08-16 11:03:05', '2026-08-16 15:03:05', NULL, 1, NULL),
(19, 2, '2026-08-14', 128000.00, 0.00, 1, 0.00, 128000.00, '', 1, '2026-08-16 11:19:17', '2026-08-16 15:19:17', NULL, 1, NULL),
(20, 3, '2026-08-15', 15360.00, 0.00, 1, 0.00, 15360.00, '', 1, '2026-08-16 19:50:17', '2026-08-16 23:50:17', NULL, 7, NULL),
(21, 1, '2026-08-16', 450000.00, 0.00, 1, 0.00, 450000.00, '', 1, '2026-08-17 02:28:39', '2026-08-17 06:28:39', NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `product_id`, `quantity`, `purchase_price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, 11, 100, 7.00, 700.00, '2026-08-12 02:28:21', '2026-08-12 06:28:21', NULL, 7, NULL),
(2, 1, 3, 100, 1100.00, 110000.00, '2026-08-12 02:28:21', '2026-08-12 06:28:21', NULL, 7, NULL),
(4, 3, 11, 100, 7.00, 700.00, '2026-08-12 02:34:54', '2026-08-12 06:34:54', NULL, 7, NULL),
(5, 3, 3, 100, 1100.00, 110000.00, '2026-08-12 02:34:54', '2026-08-12 06:34:54', NULL, 7, NULL),
(6, 4, 12, 50, 250.00, 12500.00, '2026-08-12 03:23:30', '2026-08-12 07:23:30', NULL, 7, NULL),
(7, 5, 18, 2, 128.00, 256.00, '2026-08-12 12:12:44', '2026-08-12 16:12:44', NULL, 7, NULL),
(8, 6, 18, 5, 128.00, 640.00, '2026-08-12 12:53:01', '2026-08-12 16:53:01', NULL, 7, NULL),
(16, 19, 18, 1000, 128.00, 128000.00, '2026-08-16 11:19:17', '2026-08-16 15:19:17', NULL, 1, NULL),
(17, 20, 18, 120, 128.00, 15360.00, '2026-08-16 19:50:17', '2026-08-16 23:50:17', NULL, 7, NULL),
(18, 21, 14, 1000, 450.00, 450000.00, '2026-08-17 02:28:39', '2026-08-17 06:28:39', NULL, 7, NULL);
(16, 19, 18, 1000, 128.00, 128000.00, '2026-08-16 11:19:17', '2026-08-16 15:19:17', NULL, 1, NULL),
(17, 20, 18, 120, 128.00, 15360.00, '2026-08-16 19:50:17', '2026-08-16 23:50:17', NULL, 7, NULL),
(18, 21, 14, 1000, 450.00, 450000.00, '2026-08-17 02:28:39', '2026-08-17 06:28:39', NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reason` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Active, 2 = Cancelled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `purchase_id`, `supplier_id`, `return_date`, `total_amount`, `reason`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 17, 1, '2026-08-16', 87500.00, 'fff', 1, '2026-08-16 03:49:32', '2026-08-16 07:49:32', NULL, 7, NULL),
(0, 21, 1, '2026-08-17', 45000.00, '', 1, '2026-08-17 02:39:11', '2026-08-17 06:39:11', NULL, 7, NULL),
(0, 21, 1, '2026-08-18', 13500.00, 'jjj', 1, '2026-08-18 02:42:29', '2026-08-18 06:42:29', NULL, 9, NULL),
(1, 17, 1, '2026-08-16', 87500.00, 'fff', 1, '2026-08-16 09:49:32', '2026-08-16 13:49:32', NULL, 7, NULL),
(2, 17, 1, '2026-08-16', 8250.00, 'g', 1, '2026-08-16 09:51:21', '2026-08-16 13:51:21', NULL, 7, NULL),
(3, 17, 1, '2026-08-16', 500.00, 'h', 1, '2026-08-16 09:51:51', '2026-08-16 13:51:51', NULL, 7, NULL),
(4, 17, 1, '2026-08-16', 8750.00, 'hh', 1, '2026-08-16 09:52:49', '2026-08-16 13:52:49', NULL, 7, NULL),
(5, 17, 1, '2026-08-17', 5000.00, '', 1, '2026-08-17 03:42:45', '2026-08-17 07:42:45', NULL, 2, NULL),
(0, 21, 1, '2026-08-18', 22500.00, 'ss', 1, '2026-08-18 02:45:36', '2026-08-18 06:45:36', NULL, 9, NULL),
(0, 20, 3, '2026-08-18', 2560.00, '', 1, '2026-08-18 02:48:11', '2026-08-18 06:48:11', NULL, 9, NULL),
(1, 17, 1, '2026-08-16', 87500.00, 'fff', 1, '2026-08-16 03:49:32', '2026-08-16 07:49:32', NULL, 7, NULL),
(0, 21, 1, '2026-08-17', 45000.00, '', 1, '2026-08-17 02:39:11', '2026-08-17 06:39:11', NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` int(11) NOT NULL,
  `purchase_return_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_return_details`
--

INSERT INTO `purchase_return_details` (`id`, `purchase_return_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `deleted_at`, `created_at`, `created_by`) VALUES
(1, 0, 14, 100, 450.00, 45000.00, NULL, '2026-08-17 02:39:11', 7),
(2, 0, 14, 30, 450.00, 13500.00, NULL, '2026-08-18 02:42:29', 9),
(3, 0, 14, 50, 450.00, 22500.00, NULL, '2026-08-18 02:45:36', 9),
(4, 0, 18, 20, 128.00, 2560.00, NULL, '2026-08-18 02:48:11', 9);

-- --------------------------------------------------------

--
-- Table structure for table `receive_vouchers`
--

CREATE TABLE `receive_vouchers` (
  `id` int(11) NOT NULL,
  `voucher_no` varchar(100) NOT NULL,
  `received_from` varchar(100) NOT NULL,
  `narration` text DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receive_vouchers`
--

INSERT INTO `receive_vouchers` (`id`, `voucher_no`, `received_from`, `narration`, `voucher_date`, `source_type`, `source_id`, `dr`, `cr`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'VCH-20260818-855', 'a/p', 'a/p', '2026-08-18', NULL, NULL, 100000.00, 100000.00, 7, 'Active', '2026-08-18 00:39:12', '2026-08-18 00:39:12', NULL),
(2, 'VCH-20260818-582', 'A/R', 'A/R', '2026-08-17', NULL, NULL, 50000.00, 50000.00, 7, 'Active', '2026-08-18 00:39:43', '2026-08-18 00:39:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `receive_voucher_details`
--

CREATE TABLE `receive_voucher_details` (
  `id` int(11) NOT NULL,
  `receive_voucher_id` int(11) NOT NULL,
  `account_head_id` int(11) NOT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receive_voucher_details`
--

INSERT INTO `receive_voucher_details` (`id`, `receive_voucher_id`, `account_head_id`, `dr`, `cr`, `remarks`, `created_by`) VALUES
(1, 1, 4, 100000.00, 100000.00, 'a/p', 7),
(2, 2, 3, 50000.00, 50000.00, 'A/R', 7);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `access` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `access`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Full access to all system features', 1, '2026-07-25 05:51:10', '2026-07-25 05:51:10'),
(2, 'Admin', 'Manage users, settings, and reports', 1, '2026-07-25 05:51:10', '2026-07-25 05:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` int(11) NOT NULL DEFAULT 2 COMMENT '1 = Paid, 2 = Pending, 3 = Cancelled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `user_id`, `sale_date`, `total_amount`, `discount`, `tax`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `warehouse_id`) VALUES
(3, 3, 7, '2026-08-13', 12500.00, 5.00, 0.00, 1, '2026-08-12 03:21:37', '2026-08-12 07:21:37', NULL, 7, NULL, 6),
(4, 1, 7, '2026-08-12', 2800.00, 0.00, 0.00, 1, '2026-08-12 03:24:00', '2026-08-12 07:24:00', NULL, 7, NULL, 6),
(5, 3, 7, '2026-08-11', 135.00, 0.00, 0.00, 1, '2026-08-12 12:53:58', '2026-08-12 16:53:58', NULL, 7, NULL, 4),
(6, 2, 7, '2026-08-15', 270.00, 0.00, 0.00, 1, '2026-08-15 09:32:11', '2026-08-15 13:32:11', NULL, 7, NULL, 3),
(7, 1, 7, '2026-08-15', 6250.00, 0.00, 0.00, 1, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL, 6),
(8, 3, 1, '2026-08-15', 125000.00, 0.00, 0.00, 1, '2026-08-16 11:10:50', '2026-08-16 15:10:50', NULL, 1, NULL, 6);
(6, 2, 7, '2026-08-15', 270.00, 0.00, 0.00, 1, '2026-08-15 09:32:11', '2026-08-15 13:32:11', NULL, 7, NULL, 3),
(7, 1, 7, '2026-08-15', 6250.00, 0.00, 0.00, 1, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL, 6),
(8, 3, 1, '2026-08-15', 125000.00, 0.00, 0.00, 1, '2026-08-16 11:10:50', '2026-08-16 15:10:50', NULL, 1, NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reason` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Active, 2 = Cancelled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_returns`
--

INSERT INTO `sales_returns` (`id`, `sale_id`, `customer_id`, `return_date`, `total_amount`, `reason`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(0, 8, 3, '2026-08-16', 62500.00, '', 1, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL),
(0, 5, 3, '2026-08-16', 0.00, 'c', 1, '2026-08-16 01:07:14', '2026-08-16 05:07:14', NULL, 7, NULL),
(0, 6, 2, '2026-08-16', 135.00, 'dddd', 1, '2026-08-16 02:05:32', '2026-08-16 06:05:32', NULL, 7, NULL),
(0, 4, 1, '2026-08-16', 1680.00, 'ddd', 1, '2026-08-16 02:06:24', '2026-08-16 06:06:24', NULL, 7, NULL),
(0, 8, 1, '2026-08-16', 5400.00, 'dd', 1, '2026-08-16 02:10:01', '2026-08-16 06:10:01', NULL, 7, NULL),
(0, 8, 1, '2026-08-16', 6750.00, 'jjj', 1, '2026-08-16 02:14:21', '2026-08-16 06:14:21', NULL, 7, NULL),
(0, 7, 1, '2026-08-16', 3750.00, 'oo', 1, '2026-08-16 02:15:56', '2026-08-16 06:15:56', NULL, 7, NULL),
(0, 8, 1, '2026-08-16', 5400.00, 'fff', 1, '2026-08-16 02:18:12', '2026-08-16 06:18:12', NULL, 7, NULL),
(0, 8, 1, '2026-08-16', 6750.00, 'hhh', 1, '2026-08-16 02:29:48', '2026-08-16 06:29:48', NULL, 7, NULL),
(0, 10, 1, '2026-08-16', 3380.00, 'fff', 1, '2026-08-16 02:33:29', '2026-08-16 06:33:29', NULL, 7, NULL),
(0, 11, 1, '2026-08-16', 14400.00, 'gg', 1, '2026-08-16 02:52:25', '2026-08-16 06:52:25', NULL, 7, NULL),
(0, 8, 3, '2026-08-16', 62500.00, '', 1, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL),
(0, 8, 3, '2026-08-16', 62500.00, '', 1, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_details`
--

CREATE TABLE `sales_return_details` (
  `id` int(11) NOT NULL,
  `sale_return_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_return_details`
--

INSERT INTO `sales_return_details` (`id`, `sale_return_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(0, 0, 3, 50, 1250.00, 62500.00, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL),
(0, 0, 14, 1, 0.00, 0.00, '2026-08-16 01:07:14', '2026-08-16 05:07:14', NULL, 7, NULL),
(0, 0, 18, 1, 135.00, 135.00, '2026-08-16 02:05:32', '2026-08-16 06:05:32', NULL, 7, NULL),
(0, 0, 12, 5, 280.00, 1400.00, '2026-08-16 02:06:24', '2026-08-16 06:06:24', NULL, 7, NULL),
(0, 0, 12, 1, 280.00, 280.00, '2026-08-16 02:06:24', '2026-08-16 06:06:24', NULL, 7, NULL),
(0, 0, 17, 4, 1350.00, 5400.00, '2026-08-16 02:10:01', '2026-08-16 06:10:01', NULL, 7, NULL),
(0, 0, 17, 5, 1350.00, 6750.00, '2026-08-16 02:14:21', '2026-08-16 06:14:21', NULL, 7, NULL),
(0, 0, 3, 3, 1250.00, 3750.00, '2026-08-16 02:15:56', '2026-08-16 06:15:56', NULL, 7, NULL),
(0, 0, 17, 4, 1350.00, 5400.00, '2026-08-16 02:18:12', '2026-08-16 06:18:12', NULL, 7, NULL),
(0, 0, 17, 5, 1350.00, 6750.00, '2026-08-16 02:29:48', '2026-08-16 06:29:48', NULL, 7, NULL),
(0, 0, 19, 20, 169.00, 3380.00, '2026-08-16 02:33:29', '2026-08-16 06:33:29', NULL, 7, NULL),
(0, 0, 14, 18, 800.00, 14400.00, '2026-08-16 02:52:25', '2026-08-16 06:52:25', NULL, 7, NULL),
(0, 0, 3, 50, 1250.00, 62500.00, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL),
(0, 0, 3, 50, 1250.00, 62500.00, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, 2, 6, 810.00, 4860.00, '2026-08-09 00:40:24', '2026-08-09 04:40:24', NULL, 7, NULL),
(2, 2, 12, 6, 280.00, 1680.00, '2026-08-09 00:40:50', '2026-08-09 04:40:50', NULL, 7, NULL),
(3, 3, 14, 3, 800.00, 2400.00, '2026-08-09 01:38:32', '2026-08-09 05:38:32', NULL, 7, NULL),
(4, 4, 12, 10, 280.00, 2800.00, '2026-08-09 02:23:30', '2026-08-09 06:23:30', NULL, 7, NULL),
(5, 5, 14, 2, 0.00, 1600.00, '2026-08-12 01:04:38', '2026-08-12 05:04:38', NULL, 7, NULL),
(11, 3, 3, 10, 1250.00, 12500.00, '2026-08-12 03:21:37', '2026-08-12 07:21:37', NULL, 7, NULL),
(12, 4, 12, 10, 280.00, 2800.00, '2026-08-12 03:24:00', '2026-08-12 07:24:00', NULL, 7, NULL),
(13, 5, 18, 1, 135.00, 135.00, '2026-08-12 12:53:58', '2026-08-12 16:53:58', NULL, 7, NULL),
(14, 6, 18, 2, 135.00, 270.00, '2026-08-15 09:32:11', '2026-08-15 13:32:11', NULL, 7, NULL),
(15, 7, 3, 5, 1250.00, 6250.00, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL),
(16, 8, 3, 100, 1250.00, 125000.00, '2026-08-16 11:10:50', '2026-08-16 15:10:50', NULL, 1, NULL);
(14, 6, 18, 2, 135.00, 270.00, '2026-08-15 09:32:11', '2026-08-15 13:32:11', NULL, 7, NULL),
(15, 7, 3, 5, 1250.00, 6250.00, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL),
(16, 8, 3, 100, 1250.00, 125000.00, '2026-08-16 11:10:50', '2026-08-16 15:10:50', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `stock_date` date DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `purchase_id` int(11) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `sale_return_id` int(11) DEFAULT NULL,
  `stock_transfer_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `stock_date`, `product_id`, `warehouse_id`, `quantity`, `purchase_id`, `purchase_return_id`, `sale_id`, `sale_return_id`, `stock_transfer_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`) VALUES
(1, '2026-08-12', 11, 6, 100, 1, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:28:21', NULL, NULL),
(2, '2026-08-12', 3, 6, 100, 1, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:28:21', NULL, NULL),
(4, '2026-08-12', 11, 6, 100, 3, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:34:54', NULL, NULL),
(5, '2026-08-12', 3, 6, 100, 3, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:34:54', NULL, NULL),
(6, '2026-08-13', 3, 6, -10, NULL, NULL, 3, NULL, NULL, 2026, NULL, '2026-08-12 07:21:37', NULL, NULL),
(7, '2026-08-12', 12, 6, 50, 4, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 07:23:30', NULL, NULL),
(8, '2026-08-12', 12, 6, -10, NULL, NULL, 4, NULL, NULL, 2026, NULL, '2026-08-12 07:24:00', NULL, NULL),
(9, '2026-08-09', 18, 4, 2, 5, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 16:12:44', NULL, NULL),
(10, '2026-08-10', 18, 3, 5, 6, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 16:53:01', NULL, NULL),
(11, '2026-08-11', 18, 4, -1, NULL, NULL, 5, NULL, NULL, 2026, NULL, '2026-08-12 16:53:58', NULL, NULL),
(12, NULL, 18, 3, 12, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-08-13 14:11:46', NULL, NULL),
(13, '2026-08-13', 18, 3, 2, 7, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-14 05:31:47', NULL, NULL),
(14, NULL, 3, 4, 25, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-08-14 06:03:08', NULL, NULL),
(15, '2026-08-15', 18, 3, -2, NULL, NULL, 6, NULL, NULL, 2026, NULL, '2026-08-15 13:32:11', NULL, NULL),
(16, '2026-08-15', 3, 6, -5, NULL, NULL, 7, NULL, NULL, 2026, NULL, '2026-08-15 13:42:06', NULL, NULL),
(23, '2026-08-15', 3, 6, -100, NULL, NULL, 8, NULL, NULL, 2026, NULL, '2026-08-16 15:10:50', NULL, NULL),
(24, '2026-08-16', 3, 6, 50, NULL, NULL, 8, 0, NULL, 2026, NULL, '2026-08-16 15:18:09', NULL, NULL),
(25, '2026-08-14', 18, 4, 1000, 19, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-16 15:19:18', NULL, NULL),
(26, '2026-08-15', 18, 3, 120, 20, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-16 23:50:17', NULL, NULL),
(27, '2026-08-16', 14, 7, 1000, 21, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-17 06:28:39', NULL, NULL),
(28, '2026-08-17', 14, 7, -100, 21, 0, NULL, NULL, NULL, 2026, NULL, '2026-08-17 06:39:11', NULL, NULL),
(29, '2026-08-18', 14, 7, -30, 21, 0, NULL, NULL, NULL, 2026, NULL, '2026-08-18 06:42:29', NULL, NULL),
(30, '2026-08-18', 14, 7, -50, 21, 0, NULL, NULL, NULL, 2026, NULL, '2026-08-18 06:45:36', NULL, NULL),
(31, '2026-08-18', 18, 3, -20, 20, 0, NULL, NULL, NULL, 2026, NULL, '2026-08-18 06:48:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_return_id` int(11) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 in 0 out',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_transfers`
--

INSERT INTO `stock_transfers` (`id`, `product_id`, `quantity`, `transfer_date`, `sale_id`, `purchase_id`, `sale_return_id`, `purchase_return_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(5, 9, 1, '2026-08-14', NULL, 5, NULL, NULL, 1, '2026-08-14 05:53:47', '2026-08-14 05:53:47', NULL, NULL, NULL),
(21, 12, 1, '2026-04-08', NULL, 8, NULL, NULL, 1, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL),
(22, 2, 6, '2026-08-12', 1, NULL, NULL, NULL, 0, '2026-08-09 00:40:24', '2026-08-09 04:40:24', NULL, 7, NULL),
(23, 12, 6, '2026-08-13', 2, NULL, NULL, NULL, 0, '2026-08-09 00:40:50', '2026-08-09 04:40:50', NULL, 7, NULL),
(24, 14, 3, '2026-08-04', 3, NULL, NULL, NULL, 0, '2026-08-09 01:38:32', '2026-08-09 05:38:32', NULL, 7, NULL),
(25, 12, 10, '2026-08-07', 4, NULL, NULL, NULL, 0, '2026-08-09 02:23:30', '2026-08-09 06:23:30', NULL, 7, NULL),
(26, 3, 12, '2026-08-09', NULL, NULL, NULL, NULL, 0, '2026-08-09 06:24:49', '2026-08-09 06:24:49', NULL, NULL, NULL),
(27, 10, 33, '2026-08-09', 3, 8, NULL, NULL, 0, '2026-08-09 06:25:40', '2026-08-09 06:25:40', NULL, NULL, NULL),
(28, 14, 2, '2026-08-10', NULL, 11, NULL, NULL, 1, '2026-08-12 00:48:01', '2026-08-12 04:48:01', NULL, 7, NULL),
(29, 17, 1, '2026-08-11', NULL, 12, NULL, NULL, 1, '2026-08-12 00:53:02', '2026-08-12 04:53:02', NULL, 7, NULL),
(30, 14, 2, '0000-00-00', 5, NULL, NULL, NULL, 0, '2026-08-12 01:04:38', '2026-08-12 05:04:38', NULL, 7, NULL),
(31, 9, 2, '2026-08-14', NULL, NULL, NULL, NULL, 0, '2026-08-14 05:54:43', '2026-08-14 05:54:43', NULL, NULL, NULL);
INSERT INTO `stock_transfers` (`id`, `product_id`, `quantity`, `transfer_date`, `sale_id`, `purchase_id`, `sale_return_id`, `purchase_return_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(5, 9, 1, '2026-08-14', NULL, 5, NULL, NULL, 1, '2026-08-14 05:53:47', '2026-08-14 05:53:47', NULL, NULL, NULL),
(21, 12, 1, '2026-04-08', NULL, 8, NULL, NULL, 1, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL),
(22, 2, 6, '2026-08-12', 1, NULL, NULL, NULL, 0, '2026-08-09 00:40:24', '2026-08-09 04:40:24', NULL, 7, NULL),
(23, 12, 6, '2026-08-13', 2, NULL, NULL, NULL, 0, '2026-08-09 00:40:50', '2026-08-09 04:40:50', NULL, 7, NULL),
(24, 14, 3, '2026-08-04', 3, NULL, NULL, NULL, 0, '2026-08-09 01:38:32', '2026-08-09 05:38:32', NULL, 7, NULL),
(25, 12, 10, '2026-08-07', 4, NULL, NULL, NULL, 0, '2026-08-09 02:23:30', '2026-08-09 06:23:30', NULL, 7, NULL),
(26, 3, 12, '2026-08-09', NULL, NULL, NULL, NULL, 0, '2026-08-09 06:24:49', '2026-08-09 06:24:49', NULL, NULL, NULL),
(27, 10, 33, '2026-08-09', 3, 8, NULL, NULL, 0, '2026-08-09 06:25:40', '2026-08-09 06:25:40', NULL, NULL, NULL),
(28, 14, 2, '2026-08-10', NULL, 11, NULL, NULL, 1, '2026-08-12 00:48:01', '2026-08-12 04:48:01', NULL, 7, NULL),
(29, 17, 1, '2026-08-11', NULL, 12, NULL, NULL, 1, '2026-08-12 00:53:02', '2026-08-12 04:53:02', NULL, 7, NULL),
(30, 14, 2, '0000-00-00', 5, NULL, NULL, NULL, 0, '2026-08-12 01:04:38', '2026-08-12 05:04:38', NULL, 7, NULL),
(31, 9, 2, '2026-08-14', NULL, NULL, NULL, NULL, 0, '2026-08-14 05:54:43', '2026-08-14 05:54:43', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Active, 2 = Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `contact_person`, `phone`, `email`, `address`, `city`, `country`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Kamal', 'Kamal', '015', 'kamal@yahoo.com', '2no Gate', 'Chattogram', 'BD', 1, '2026-08-03 06:48:44', '2026-08-03 06:48:44', NULL, NULL, NULL),
(2, 'Usama', 'al surafa', '+965875', 'usama02@gmail.com', 'clifornia,usa', 'california', 'USA', 1, '2026-08-06 22:53:27', '2026-08-07 02:53:27', NULL, NULL, NULL),
(3, 'Sultan', 'imran', '+6325458755', 'Sultan@yahoo.com', 'dhaka,bd', 'dhaka', 'bd', 1, '2026-08-06 23:01:07', '2026-08-07 03:01:07', NULL, NULL, NULL),
(4, 'pritom', '016585', '036574', '', '', '', '', 1, '2026-08-14 01:33:12', '2026-08-14 05:33:12', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `full_name`, `email`, `password`, `phone`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'Araf Rahman', 'araf@yahoo.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '01565985', 'Active', '2026-07-26 06:47:39', '2026-08-07 20:50:26', NULL, NULL, 1),
(2, 2, 'Pritom Hasan', 'pritam@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, 'Active', '2026-08-05 05:17:34', '2026-08-07 20:48:00', '2026-08-07 16:48:00', NULL, 1),
(7, 2, 'usama al surafa', 'surafa@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '+9654213', 'Active', '2026-08-05 05:43:45', '2026-08-07 20:51:44', NULL, NULL, 1),
(9, 1, 'Pritom Hasan', 'pritam@yahoo.com', '$2y$10$Ef8a8DqE2E4vsHIz4dACTO9ExZEtGj70968WYxuKdBVBdIv2ZUtgO', '+880189654', 'Active', '2026-08-07 20:47:44', '2026-08-07 20:50:36', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL,
  `warehouse_name` varchar(100) NOT NULL,
  `location` text DEFAULT NULL,
  `manager_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `warehouse_name`, `location`, `manager_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Main Warehouse', 'Agrabad, Chattogram', 'Md. Ibrahim', '2026-08-04 18:46:21', '2026-08-04 18:50:09', '2026-08-04 14:50:09', 1, 1),
(2, 'Branch Warehouse', 'GEC Circle, Chattogram', 'Kamal Hossain', '2026-08-04 18:46:21', '2026-08-04 18:50:06', '2026-08-04 14:50:06', 1, 1),
(3, 'Summit', 'Agrabad', 'Raihan', '2026-08-04 18:50:25', '2026-08-04 18:50:25', NULL, NULL, NULL),
(4, 'Rootya', 'GEC', 'Mohibulllah', '2026-08-04 18:50:49', '2026-08-04 18:51:02', NULL, NULL, NULL),
(5, 'Dew', 'Agrabad', 'Mohiner Ghora', '2026-08-05 17:19:08', '2026-08-05 17:19:08', NULL, NULL, NULL),
(6, 'Fatehabad', 'same', 'ifran', '2026-08-09 04:57:18', '2026-08-12 06:30:46', NULL, NULL, NULL),
(7, 'boddarhat', 'chadgoan', 'pritom', '2026-08-14 05:35:44', '2026-08-14 05:35:44', NULL, NULL, NULL),
(8, 'agrabed', 'same', '', '2026-08-14 06:04:36', '2026-08-14 06:04:36', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_code` (`account_code`),
  ADD KEY `idx_account_type` (`account_type`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_code` (`account_code`),
  ADD KEY `idx_account_type` (`account_type`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_vouchers`
-- Indexes for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`voucher_no`),
  ADD KEY `idx_jv_date` (`voucher_date`),
  ADD KEY `idx_jv_source` (`source_type`,`source_id`);

--
-- Indexes for table `journal_voucher_details`
--
ALTER TABLE `journal_voucher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jvd_voucher` (`journal_voucher_id`),
  ADD KEY `idx_jvd_account` (`account_head_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ledger_account` (`account_head_id`),
  ADD KEY `idx_ledger_payment` (`payment_voucher_id`),
  ADD KEY `idx_ledger_receive` (`receive_voucher_id`),
  ADD KEY `idx_ledger_journal` (`journal_voucher_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`voucher_no`),
  ADD KEY `idx_pv_date` (`voucher_date`),
  ADD KEY `idx_pv_source` (`source_type`,`source_id`);

--
-- Indexes for table `payment_voucher_details`
--
ALTER TABLE `payment_voucher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pvd_voucher` (`payment_voucher_id`),
  ADD KEY `idx_pvd_account` (`account_head_id`);

--
-- Indexes for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`),
  ADD KEY `idx_pv_date` (`date`),
  ADD KEY `idx_pv_source` (`source_type`,`source_id`);

--
-- Indexes for table `payment_voucher_details`
--
ALTER TABLE `payment_voucher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pvd_voucher` (`payment_voucher_id`),
  ADD KEY `idx_pvd_account` (`account_head_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_detail_details`
--
ALTER TABLE `purchase_return_detail_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_id` (`purchase_return_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `purchase_return_id` (`purchase_return_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `receive_vouchers`
--
ALTER TABLE `receive_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`voucher_no`),
  ADD KEY `idx_rv_date` (`voucher_date`),
  ADD KEY `idx_rv_source` (`source_type`,`source_id`);

--
-- Indexes for table `receive_voucher_details`
--
ALTER TABLE `receive_voucher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rvd_voucher` (`receive_voucher_id`),
  ADD KEY `idx_rvd_account` (`account_head_id`);
ALTER TABLE `receive_voucher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rvd_voucher` (`receive_voucher_id`),
  ADD KEY `idx_rvd_account` (`account_head_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_ibfk_1` (`product_id`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_heads`
--
ALTER TABLE `account_heads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `account_heads`
--
ALTER TABLE `account_heads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `journal_vouchers`
-- AUTO_INCREMENT for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `journal_voucher_details`
-- AUTO_INCREMENT for table `journal_voucher_details`
--
ALTER TABLE `journal_voucher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_voucher_details`
--
ALTER TABLE `payment_voucher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_voucher_details`
--
ALTER TABLE `payment_voucher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchase_return_detail_details`
--
ALTER TABLE `purchase_return_detail_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `receive_vouchers`
--
ALTER TABLE `receive_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `receive_voucher_details`
--
ALTER TABLE `receive_voucher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD CONSTRAINT `fk_account_parent` FOREIGN KEY (`parent_id`) REFERENCES `account_heads` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `journal_voucher_details`
--
ALTER TABLE `journal_voucher_details`
  ADD CONSTRAINT `fk_jvd_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_jvd_voucher` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ledger`
--
ALTER TABLE `ledger`
  ADD CONSTRAINT `fk_ledger_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_ledger_journal_voucher` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ledger_payment_voucher` FOREIGN KEY (`payment_voucher_id`) REFERENCES `payment_vouchers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ledger_receive_voucher` FOREIGN KEY (`receive_voucher_id`) REFERENCES `receive_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_voucher_details`
--
ALTER TABLE `payment_voucher_details`
  ADD CONSTRAINT `fk_pvd_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_pvd_voucher` FOREIGN KEY (`payment_voucher_id`) REFERENCES `payment_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `receive_voucher_details`
--
ALTER TABLE `receive_voucher_details`
  ADD CONSTRAINT `fk_rvd_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_rvd_voucher` FOREIGN KEY (`receive_voucher_id`) REFERENCES `receive_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD CONSTRAINT `fk_account_parent` FOREIGN KEY (`parent_id`) REFERENCES `account_heads` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `journal_voucher_details`
--
ALTER TABLE `journal_voucher_details`
  ADD CONSTRAINT `fk_jvd_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_jvd_voucher` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD CONSTRAINT `fk_ledger_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_ledger_journal_voucher` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ledger_payment_voucher` FOREIGN KEY (`payment_voucher_id`) REFERENCES `payment_vouchers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ledger_receive_voucher` FOREIGN KEY (`receive_voucher_id`) REFERENCES `receive_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_voucher_details`
--
ALTER TABLE `payment_voucher_details`
  ADD CONSTRAINT `fk_pvd_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_pvd_voucher` FOREIGN KEY (`payment_voucher_id`) REFERENCES `payment_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `receive_voucher_details`
--
ALTER TABLE `receive_voucher_details`
  ADD CONSTRAINT `fk_rvd_account` FOREIGN KEY (`account_head_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `fk_rvd_voucher` FOREIGN KEY (`receive_voucher_id`) REFERENCES `receive_vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 05:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `category_id`, `expense_date`, `amount`, `payment_method`, `description`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 2, '2026-08-15', 652000.00, 'Cash', '', '2026-08-15 07:01:17', NULL, NULL, 7, NULL),
(2, 3, '2026-08-14', 5000.00, 'Cash', '', '2026-08-15 08:12:57', NULL, NULL, 7, NULL);

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `category_name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Salary', 'Salaries of the staffs', 1, '2026-08-15 05:28:08', NULL, NULL, 7, NULL),
(2, 'Rent', 'rent', 1, '2026-08-15 07:01:01', NULL, NULL, 7, NULL),
(3, 'Bonus', 'Bonuses', 1, '2026-08-15 08:07:47', NULL, NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_vouchers`
--

CREATE TABLE `journal_vouchers` (
  `id` int(11) NOT NULL,
  `voucher_no` varchar(100) NOT NULL,
  `narration` text DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 inactive 1 active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journal_vouchers`
--

INSERT INTO `journal_vouchers` (`id`, `voucher_no`, `narration`, `voucher_date`, `source_type`, `source_id`, `dr`, `cr`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'VCH-20260818-961', 'a/r', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 1, '2026-08-18 00:18:20', '2026-08-18 00:18:20', NULL),
(2, 'VCH-20260818-896', 'a/r', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 1, '2026-08-18 00:20:27', '2026-08-18 00:20:27', NULL),
(3, 'VCH-20260818-750', 'a/r', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 1, '2026-08-18 00:23:01', '2026-08-18 00:23:01', NULL),
(4, 'VCH-20260818-256', 'a/p', '2026-08-17', NULL, NULL, 0.00, 0.00, 7, 1, '2026-08-18 00:23:38', '2026-08-18 00:23:38', NULL),
(5, 'J000005', 'goods purchase 50000 tk', '2026-08-18', NULL, NULL, 50000.00, 50000.00, 7, 1, '2026-08-19 03:09:48', '2026-08-19 03:09:48', NULL);

--
-- Dumping data for table `journal_voucher_details`
--

INSERT INTO `journal_voucher_details` (`id`, `journal_voucher_id`, `account_head_id`, `dr`, `cr`, `remarks`, `created_by`) VALUES
(1, 2, 3, 150000.00, 150000.00, 'a/r', 7),
(2, 3, 3, 150000.00, 150000.00, 'a/r', 7),
(3, 4, 4, 10000.00, 10000.00, 'a/p', 7),
(4, 5, 6, 50000.00, 0.00, '', 7),
(5, 5, 1, 0.00, 50000.00, '', 7);

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`id`, `payment_voucher_id`, `receive_voucher_id`, `journal_voucher_id`, `account_head_id`, `dr`, `cr`, `remarks`, `created_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 3, 3, 150000.00, 150000.00, 'a/r', 7, '2026-08-18 00:23:01', '2026-08-18 00:23:01'),
(2, NULL, NULL, 4, 4, 10000.00, 10000.00, 'a/p', 7, '2026-08-18 00:23:38', '2026-08-18 00:23:38'),
(3, 3, NULL, NULL, 4, 10000.00, 10000.00, 'a/p', 7, '2026-08-18 00:30:57', '2026-08-18 00:30:57'),
(4, NULL, 1, NULL, 4, 100000.00, 100000.00, 'a/p', 7, '2026-08-18 00:39:12', '2026-08-18 00:39:12'),
(5, NULL, 2, NULL, 3, 50000.00, 50000.00, 'A/R', 7, '2026-08-18 00:39:44', '2026-08-18 00:39:44'),
(6, NULL, NULL, 5, 6, 50000.00, 0.00, '', 7, '2026-08-19 03:09:48', '2026-08-19 03:09:48'),
(7, NULL, NULL, 5, 1, 0.00, 50000.00, '', 7, '2026-08-19 03:09:48', '2026-08-19 03:09:48'),
(8, 4, NULL, NULL, 4, 0.00, 0.00, '', 7, '2026-08-19 03:12:09', '2026-08-19 03:12:09'),
(9, 4, NULL, NULL, 2, 0.00, 0.00, '', 7, '2026-08-19 03:12:10', '2026-08-19 03:12:10'),
(10, 4, NULL, NULL, 2, 0.00, 0.00, 'payment to kamal 100000', 7, '2026-08-19 03:12:10', '2026-08-19 03:12:10'),
(14, 5, NULL, NULL, 6, 20000.00, 0.00, '', 7, '2026-08-19 03:14:21', '2026-08-19 03:14:21'),
(15, 5, NULL, NULL, 1, 0.00, 20000.00, '', 7, '2026-08-19 03:14:21', '2026-08-19 03:14:21'),
(16, 5, NULL, NULL, 1, 0.00, 0.00, 'payment to jamal 10000', 7, '2026-08-19 03:14:21', '2026-08-19 03:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_vouchers`
--

CREATE TABLE `payment_vouchers` (
  `id` int(11) NOT NULL,
  `voucher_no` varchar(100) NOT NULL,
  `pay_to` varchar(100) NOT NULL,
  `narration` text DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 inactive 1 active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_vouchers`
--

INSERT INTO `payment_vouchers` (`id`, `voucher_no`, `pay_to`, `narration`, `voucher_date`, `source_type`, `source_id`, `dr`, `cr`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'VCH-20260818-827', 'a/p', 'a/p', '2026-08-17', NULL, NULL, 10000.00, 10000.00, 7, 1, '2026-08-18 00:30:57', '2026-08-18 00:31:18', '2026-08-17 20:31:18'),
(4, 'PAY000004', 'kamal', 'payment to kamal 100000', '2026-08-18', NULL, NULL, 0.00, 0.00, 7, 1, '2026-08-19 03:12:09', '2026-08-19 03:12:09', NULL),
(5, 'PAY000005', 'jamal', 'payment to jamal 20000', '2026-08-18', NULL, NULL, 20000.00, 20000.00, 7, 1, '2026-08-19 03:13:02', '2026-08-19 03:14:20', NULL);

--
-- Dumping data for table `payment_voucher_details`
--

INSERT INTO `payment_voucher_details` (`id`, `payment_voucher_id`, `account_head_id`, `dr`, `cr`, `remarks`, `created_by`) VALUES
(1, 3, 4, 10000.00, 10000.00, 'a/p', 7),
(2, 4, 4, 0.00, 0.00, '', 7),
(3, 4, 2, 0.00, 0.00, '', 7),
(4, 4, 2, 0.00, 0.00, 'payment to kamal 100000', 7),
(8, 5, 6, 20000.00, 0.00, '', 7),
(9, 5, 1, 0.00, 20000.00, '', 7),
(10, 5, 1, 0.00, 0.00, 'payment to jamal 10000', 7);

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `purchase_id`, `supplier_id`, `return_date`, `total_amount`, `reason`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 17, 1, '2026-08-16', 87500.00, 'fff', 1, '2026-08-16 03:49:32', '2026-08-16 07:49:32', NULL, 7, NULL),
(0, 21, 1, '2026-08-17', 45000.00, '', 1, '2026-08-17 02:39:11', '2026-08-17 06:39:11', NULL, 7, NULL);

--
-- Dumping data for table `purchase_return_details`
--

INSERT INTO `purchase_return_details` (`id`, `purchase_return_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `deleted_at`, `created_at`, `created_by`) VALUES
(1, 0, 14, 100, 450.00, 45000.00, NULL, '2026-08-17 02:39:11', 7);

-- --------------------------------------------------------

--
-- Table structure for table `receive_vouchers`
--

CREATE TABLE `receive_vouchers` (
  `id` int(11) NOT NULL,
  `voucher_no` varchar(100) NOT NULL,
  `received_from` varchar(100) NOT NULL,
  `narration` text DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `dr` decimal(12,2) DEFAULT 0.00,
  `cr` decimal(12,2) DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0 inactive 1 active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receive_vouchers`
--

INSERT INTO `receive_vouchers` (`id`, `voucher_no`, `received_from`, `narration`, `voucher_date`, `source_type`, `source_id`, `dr`, `cr`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'VCH-20260818-855', 'a/p', 'a/p', '2026-08-18', NULL, NULL, 100000.00, 100000.00, 7, 1, '2026-08-18 00:39:12', '2026-08-18 00:39:12', NULL),
(2, 'VCH-20260818-582', 'A/R', 'A/R', '2026-08-17', NULL, NULL, 50000.00, 50000.00, 7, 1, '2026-08-18 00:39:43', '2026-08-18 00:39:43', NULL);

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `user_id`, `sale_date`, `total_amount`, `discount`, `tax`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `warehouse_id`) VALUES
(3, 3, 7, '2026-08-13', 12500.00, 5.00, 0.00, 1, '2026-08-12 03:21:37', '2026-08-12 07:21:37', NULL, 7, NULL, 6),
(4, 1, 7, '2026-08-12', 2800.00, 0.00, 0.00, 1, '2026-08-12 03:24:00', '2026-08-12 07:24:00', NULL, 7, NULL, 6),
(5, 3, 7, '2026-08-11', 135.00, 0.00, 0.00, 1, '2026-08-12 12:53:58', '2026-08-12 16:53:58', NULL, 7, NULL, 4),
(6, 2, 7, '2026-08-15', 270.00, 0.00, 0.00, 1, '2026-08-15 09:32:11', '2026-08-15 13:32:11', NULL, 7, NULL, 3),
(7, 1, 7, '2026-08-15', 6250.00, 0.00, 0.00, 1, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL, 6),
(8, 3, 1, '2026-08-15', 125000.00, 0.00, 0.00, 1, '2026-08-16 11:10:50', '2026-08-16 15:10:50', NULL, 1, NULL, 6),
(9, 2, 7, '2026-08-17', 125000.00, 0.00, 0.00, 1, '2026-08-18 01:45:54', '2026-08-18 05:45:54', NULL, 7, NULL, 6);

--
-- Dumping data for table `sales_returns`
--

INSERT INTO `sales_returns` (`id`, `sale_id`, `customer_id`, `return_date`, `total_amount`, `reason`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(0, 8, 3, '2026-08-16', 62500.00, '', 1, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL);

--
-- Dumping data for table `sales_return_details`
--

INSERT INTO `sales_return_details` (`id`, `sale_return_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(0, 0, 3, 50, 1250.00, 62500.00, '2026-08-16 11:18:09', '2026-08-16 15:18:09', NULL, 1, NULL);

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, 2, 6, 810.00, 4860.00, '2026-08-09 00:40:24', '2026-08-09 04:40:24', NULL, 7, NULL),
(2, 2, 12, 6, 280.00, 1680.00, '2026-08-09 00:40:50', '2026-08-09 04:40:50', NULL, 7, NULL),
(3, 3, 14, 3, 800.00, 2400.00, '2026-08-09 01:38:32', '2026-08-09 05:38:32', NULL, 7, NULL),
(4, 4, 12, 10, 280.00, 2800.00, '2026-08-09 02:23:30', '2026-08-09 06:23:30', NULL, 7, NULL),
(5, 5, 14, 2, 0.00, 1600.00, '2026-08-12 01:04:38', '2026-08-12 05:04:38', NULL, 7, NULL),
(11, 3, 3, 10, 1250.00, 12500.00, '2026-08-12 03:21:37', '2026-08-12 07:21:37', NULL, 7, NULL),
(12, 4, 12, 10, 280.00, 2800.00, '2026-08-12 03:24:00', '2026-08-12 07:24:00', NULL, 7, NULL),
(13, 5, 18, 1, 135.00, 135.00, '2026-08-12 12:53:58', '2026-08-12 16:53:58', NULL, 7, NULL),
(14, 6, 18, 2, 135.00, 270.00, '2026-08-15 09:32:11', '2026-08-15 13:32:11', NULL, 7, NULL),
(15, 7, 3, 5, 1250.00, 6250.00, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL),
(16, 8, 3, 100, 1250.00, 125000.00, '2026-08-16 11:10:50', '2026-08-16 15:10:50', NULL, 1, NULL),
(17, 9, 3, 100, 1250.00, 125000.00, '2026-08-18 01:45:54', '2026-08-18 05:45:54', NULL, 7, NULL);

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `stock_date`, `product_id`, `warehouse_id`, `quantity`, `purchase_id`, `purchase_return_id`, `sale_id`, `sale_return_id`, `stock_transfer_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`) VALUES
(1, '2026-08-12', 11, 6, 100, 1, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:28:21', NULL, NULL),
(2, '2026-08-12', 3, 6, 100, 1, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:28:21', NULL, NULL),
(4, '2026-08-12', 11, 6, 100, 3, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:34:54', NULL, NULL),
(5, '2026-08-12', 3, 6, 100, 3, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 06:34:54', NULL, NULL),
(6, '2026-08-13', 3, 6, -10, NULL, NULL, 3, NULL, NULL, 2026, NULL, '2026-08-12 07:21:37', NULL, NULL),
(7, '2026-08-12', 12, 6, 50, 4, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 07:23:30', NULL, NULL),
(8, '2026-08-12', 12, 6, -10, NULL, NULL, 4, NULL, NULL, 2026, NULL, '2026-08-12 07:24:00', NULL, NULL),
(9, '2026-08-09', 18, 4, 2, 5, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 16:12:44', NULL, NULL),
(10, '2026-08-10', 18, 3, 5, 6, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-12 16:53:01', NULL, NULL),
(11, '2026-08-11', 18, 4, -1, NULL, NULL, 5, NULL, NULL, 2026, NULL, '2026-08-12 16:53:58', NULL, NULL),
(12, NULL, 18, 3, 12, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-08-13 14:11:46', NULL, NULL),
(13, '2026-08-13', 18, 3, 2, 7, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-14 05:31:47', NULL, NULL),
(14, NULL, 3, 4, 25, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-08-14 06:03:08', NULL, NULL),
(15, '2026-08-15', 18, 3, -2, NULL, NULL, 6, NULL, NULL, 2026, NULL, '2026-08-15 13:32:11', NULL, NULL),
(16, '2026-08-15', 3, 6, -5, NULL, NULL, 7, NULL, NULL, 2026, NULL, '2026-08-15 13:42:06', NULL, NULL),
(23, '2026-08-15', 3, 6, -100, NULL, NULL, 8, NULL, NULL, 2026, NULL, '2026-08-16 15:10:50', NULL, NULL),
(24, '2026-08-16', 3, 6, 50, NULL, NULL, 8, 0, NULL, 2026, NULL, '2026-08-16 15:18:09', NULL, NULL),
(25, '2026-08-14', 18, 4, 1000, 19, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-16 15:19:18', NULL, NULL),
(26, '2026-08-15', 18, 3, 120, 20, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-16 23:50:17', NULL, NULL),
(27, '2026-08-16', 14, 7, 1000, 21, NULL, NULL, NULL, NULL, 2026, NULL, '2026-08-17 06:28:39', NULL, NULL),
(28, '2026-08-17', 14, 7, -100, 21, 0, NULL, NULL, NULL, 2026, NULL, '2026-08-17 06:39:11', NULL, NULL),
(29, '2026-08-17', 3, 6, -100, NULL, NULL, 9, NULL, NULL, 2026, NULL, '2026-08-18 05:45:54', NULL, NULL);

--
-- AUTO_INCREMENT for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `journal_voucher_details`
--
ALTER TABLE `journal_voucher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_voucher_details`
--
ALTER TABLE `payment_voucher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
SET FOREIGN_KEY_CHECKS=1;
