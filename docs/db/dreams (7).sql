-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< Updated upstream:docs/db/dreams.sql
-- Generation Time: Aug 09, 2026 at 12:44 AM
=======
-- Generation Time: Aug 15, 2026 at 06:30 PM
>>>>>>> Stashed changes:docs/db/dreams (7).sql
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
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

INSERT INTO `categories` (`categories_id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Grocery item', 'Daily household items', '2026-08-02 23:34:06', '2026-08-06 10:38:53', '2026-08-06', NULL, NULL),
(4, 'stationary', 'pen,pencil,paper etc', '2026-08-06 02:27:21', '2026-08-06 10:39:37', '2026-08-06', NULL, NULL),
(5, 'stationary', 'pen,pencil,paper etc', '2026-08-06 02:28:05', '2026-08-06 10:38:59', '2026-08-06', NULL, NULL),
(6, 'Toys', 'child playing accessories', '2026-08-06 09:54:29', '2026-08-06 09:54:29', NULL, NULL, NULL),
(7, 'Toys', 'child playing accessories', '2026-08-06 10:04:12', '2026-08-06 10:39:07', '2026-08-06', NULL, NULL),
(8, 'stationary', 'pen,paper,pencil', '2026-08-06 10:05:18', '2026-08-06 10:39:20', '2026-08-06', NULL, NULL),
(9, 'stationary', 'pen,paper,pencil', '2026-08-06 10:07:54', '2026-08-06 10:39:23', '2026-08-06', NULL, NULL),
(10, 'stationary', 'pen,paper,pencil', '2026-08-06 10:08:17', '2026-08-06 10:08:17', NULL, NULL, NULL),
(11, 'stationary', 'pen,paper,pencil', '2026-08-06 10:18:15', '2026-08-06 10:39:13', '2026-08-06', NULL, NULL),
(12, 'food', 'daily nutrition food', '2026-08-06 10:19:09', '2026-08-06 10:19:09', NULL, NULL, NULL);

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
  `customer_id` int(11) NOT NULL,
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

INSERT INTO `customers` (`customer_id`, `name`, `gender`, `phone`, `email`, `address`, `membership_type`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 'Araf Rahman', 'Male', '+8801589756', 'araf0505@yahoo.com', 'Hider Ali Musir Bari, Fatehabed', 'Regular', '2026-08-02 03:50:28', NULL, NULL, NULL, NULL),
(2, 'Muhammad Al Junayed', 'Male', '+6849213547', 'junayed684@gmail.com', 'Bagdad,iraq', 'Regular', '2026-08-02 04:11:25', NULL, NULL, NULL, NULL),
(3, 'Sultan ibn Adel', 'Male', '+6483215645', 'SultanAdel@gmail.com', 'al hudayed,yaman', 're', '2026-08-02 04:12:50', NULL, NULL, NULL, NULL),
(4, 'Belel ibn rabah al habasi', 'Male', '+6478215465', 'BelelRabah@gmail.com', 'Abhi-Siniya(eithopia)', 'R', '2026-08-02 04:14:07', NULL, NULL, NULL, NULL);

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
(2, 1, 1, 'akrot', 'Tibbat', 750.00, 810.00, '254587', '2026-08-02 04:20:09', NULL, NULL, NULL, NULL),
(3, 1, 1, 'Dumur', 'Tibbat', 1100.00, 1250.00, '145898', '2026-08-02 04:20:34', NULL, NULL, NULL, NULL),
(7, 10, 1, 'pencil', 'STAR', 6.50, 10.00, '1122', '2026-08-06 13:51:22', NULL, '2026-08-06 09:51:38', NULL, NULL),
(9, 1, 1, 'pencil', 'STAR', 7.00, 10.00, '9878', '2026-08-06 18:38:36', NULL, NULL, NULL, NULL),
(10, 1, 1, 'pencil', 'STAR', 7.00, 10.00, '3252', '2026-08-06 18:40:18', NULL, NULL, NULL, NULL),
(11, 1, 1, 'pencil', 'STAR', 7.00, 10.00, '2552', '2026-08-06 18:42:24', NULL, NULL, NULL, NULL),
(12, 0, 2, 'book', 'mkd', 250.00, 280.00, '1258', '2026-08-06 19:04:26', NULL, NULL, NULL, NULL);

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
<<<<<<< Updated upstream:docs/db/dreams.sql
(5, 0, '0000-00-00', 0.00, 0.00, 0, 0.00, 0.00, '', 1, '2026-08-06 23:45:04', '2026-08-07 03:45:04', NULL, 1, NULL),
(6, 0, '0000-00-00', 0.00, 0.00, 0, 0.00, 0.00, '', 1, '2026-08-06 23:45:11', '2026-08-07 03:45:11', NULL, 1, NULL),
(7, 0, '0000-00-00', 0.00, 0.00, 0, 0.00, 0.00, '', 1, '2026-08-06 23:45:14', '2026-08-07 03:45:14', NULL, 1, NULL),
(8, 2, '2026-04-08', 250.00, 2.00, 2, 15.00, 281.75, 'jaber ibrahim', 1, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL);
=======
(1, 1, '2026-08-12', 110700.00, 0.00, 1, 0.00, 110700.00, '', 1, '2026-08-12 02:28:21', '2026-08-12 06:28:21', NULL, 7, NULL),
(3, 1, '2026-08-12', 110700.00, 0.00, 1, 0.00, 110700.00, '', 1, '2026-08-12 02:34:54', '2026-08-12 06:34:54', NULL, 7, NULL),
(4, 1, '2026-08-12', 12500.00, 0.00, 1, 0.00, 12500.00, '', 1, '2026-08-12 03:23:30', '2026-08-12 07:23:30', NULL, 7, NULL),
(5, 2, '2026-08-09', 256.00, 5.00, 2, 15.00, 279.68, '', 1, '2026-08-12 12:12:44', '2026-08-12 16:12:44', NULL, 7, NULL),
(6, 1, '2026-08-10', 640.00, 0.00, 1, 0.00, 640.00, '', 1, '2026-08-12 12:53:01', '2026-08-12 16:53:01', NULL, 7, NULL);
>>>>>>> Stashed changes:docs/db/dreams (7).sql

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
<<<<<<< Updated upstream:docs/db/dreams.sql
(20, 8, 12, 1, 250.00, 250.00, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL);
=======
(1, 1, 11, 100, 7.00, 700.00, '2026-08-12 02:28:21', '2026-08-12 06:28:21', NULL, 7, NULL),
(2, 1, 3, 100, 1100.00, 110000.00, '2026-08-12 02:28:21', '2026-08-12 06:28:21', NULL, 7, NULL),
(4, 3, 11, 100, 7.00, 700.00, '2026-08-12 02:34:54', '2026-08-12 06:34:54', NULL, 7, NULL),
(5, 3, 3, 100, 1100.00, 110000.00, '2026-08-12 02:34:54', '2026-08-12 06:34:54', NULL, 7, NULL),
(6, 4, 12, 50, 250.00, 12500.00, '2026-08-12 03:23:30', '2026-08-12 07:23:30', NULL, 7, NULL),
(7, 5, 18, 2, 128.00, 256.00, '2026-08-12 12:12:44', '2026-08-12 16:12:44', NULL, 7, NULL),
(8, 6, 18, 5, 128.00, 640.00, '2026-08-12 12:53:01', '2026-08-12 16:53:01', NULL, 7, NULL);
>>>>>>> Stashed changes:docs/db/dreams (7).sql

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
  `sale_id` int(11) NOT NULL,
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
<<<<<<< Updated upstream:docs/db/dreams.sql
=======
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
(7, 1, 7, '2026-08-15', 6250.00, 0.00, 0.00, 1, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL, 6);

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
>>>>>>> Stashed changes:docs/db/dreams (7).sql
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

<<<<<<< Updated upstream:docs/db/dreams.sql
=======
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
(15, 7, 3, 5, 1250.00, 6250.00, '2026-08-15 09:42:06', '2026-08-15 13:42:06', NULL, 7, NULL);

>>>>>>> Stashed changes:docs/db/dreams (7).sql
-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

<<<<<<< Updated upstream:docs/db/dreams.sql
INSERT INTO `stocks` (`id`, `product_id`, `warehouse_id`, `quantity`, `updated_at`, `deleted_at`) VALUES
(1, 12, 4, 24, '2026-08-08 16:00:21', NULL),
(2, 9, 3, 33, '2026-08-08 22:38:12', NULL);
=======
INSERT INTO `stocks` (`id`, `stock_date`, `product_id`, `warehouse_id`, `quantity`, `purchase_id`, `sale_id`, `stock_transfer_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2026-08-12', 11, 6, 100, 1, NULL, NULL, 2026, '2026-08-12 06:28:21', NULL),
(2, '2026-08-12', 3, 6, 100, 1, NULL, NULL, 2026, '2026-08-12 06:28:21', NULL),
(4, '2026-08-12', 11, 6, 100, 3, NULL, NULL, 2026, '2026-08-12 06:34:54', NULL),
(5, '2026-08-12', 3, 6, 100, 3, NULL, NULL, 2026, '2026-08-12 06:34:54', NULL),
(6, '2026-08-13', 3, 6, -10, NULL, 3, NULL, 2026, '2026-08-12 07:21:37', NULL),
(7, '2026-08-12', 12, 6, 50, 4, NULL, NULL, 2026, '2026-08-12 07:23:30', NULL),
(8, '2026-08-12', 12, 6, -10, NULL, 4, NULL, 2026, '2026-08-12 07:24:00', NULL),
(9, '2026-08-09', 18, 4, 2, 5, NULL, NULL, 2026, '2026-08-12 16:12:44', NULL),
(10, '2026-08-10', 18, 3, 5, 6, NULL, NULL, 2026, '2026-08-12 16:53:01', NULL),
(11, '2026-08-11', 18, 4, -1, NULL, 5, NULL, 2026, '2026-08-12 16:53:58', NULL),
(12, NULL, 18, 3, 12, NULL, NULL, NULL, 0, '2026-08-13 14:11:46', NULL),
(13, '2026-08-13', 18, 3, 2, 7, NULL, NULL, 2026, '2026-08-14 05:31:47', NULL),
(14, NULL, 3, 4, 25, NULL, NULL, NULL, 0, '2026-08-14 06:03:08', NULL),
(15, '2026-08-15', 18, 3, -2, NULL, 6, NULL, 2026, '2026-08-15 13:32:11', NULL),
(16, '2026-08-15', 3, 6, -5, NULL, 7, NULL, 2026, '2026-08-15 13:42:06', NULL);
>>>>>>> Stashed changes:docs/db/dreams (7).sql

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
(21, 12, 1, '2026-04-08', NULL, 8, NULL, NULL, 1, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL);

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
(3, 'Sultan', 'imran', '+6325458755', 'Sultan@yahoo.com', 'dhaka,bd', 'dhaka', 'bd', 1, '2026-08-06 23:01:07', '2026-08-07 03:01:07', NULL, NULL, NULL);

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
(5, 'Dew', 'Agrabad', 'Mohiner Ghora', '2026-08-05 17:19:08', '2026-08-05 17:19:08', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `account_code` (`account_code`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
<<<<<<< Updated upstream:docs/db/dreams.sql
  ADD PRIMARY KEY (`customer_id`);
=======
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `account_id` (`account_id`);
>>>>>>> Stashed changes:docs/db/dreams (7).sql

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
<<<<<<< Updated upstream:docs/db/dreams.sql
  ADD PRIMARY KEY (`sale_id`);
=======
  ADD PRIMARY KEY (`id`);
>>>>>>> Stashed changes:docs/db/dreams (7).sql

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
  ADD UNIQUE KEY `unique_stock` (`product_id`,`warehouse_id`),
  ADD KEY `warehouse_id` (`warehouse_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
<<<<<<< Updated upstream:docs/db/dreams.sql
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `entry_id` bigint(20) NOT NULL AUTO_INCREMENT;
>>>>>>> Stashed changes:docs/db/dreams (7).sql

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
<<<<<<< Updated upstream:docs/db/dreams.sql
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
>>>>>>> Stashed changes:docs/db/dreams (7).sql

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
<<<<<<< Updated upstream:docs/db/dreams.sql
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
>>>>>>> Stashed changes:docs/db/dreams (7).sql

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
<<<<<<< Updated upstream:docs/db/dreams.sql
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
>>>>>>> Stashed changes:docs/db/dreams (7).sql

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
<<<<<<< Updated upstream:docs/db/dreams.sql
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
>>>>>>> Stashed changes:docs/db/dreams (7).sql

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD CONSTRAINT `chart_of_accounts_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `chart_of_accounts` (`account_id`);

--
-- Constraints for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD CONSTRAINT `journal_entries_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `chart_of_accounts` (`account_id`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stocks_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
