-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2026 at 08:13 AM
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
(3, 1, 1, 'Dumur', 'Tibbat', 1100.00, 1250.00, '145898', '2026-08-02 04:20:34', NULL, NULL, NULL, NULL),
(7, 10, 1, 'pencil', 'STAR', 6.50, 10.00, '1122', '2026-08-06 13:51:22', NULL, '2026-08-06 09:51:38', NULL, NULL),
(9, 1, 1, 'pencil', 'STAR', 7.00, 10.00, '9878', '2026-08-06 18:38:36', NULL, NULL, NULL, NULL),
(11, 1, 1, 'pencil', 'STAR', 7.00, 10.00, '2552', '2026-08-06 18:42:24', NULL, NULL, NULL, NULL),
(12, 0, 2, 'book', 'mkd', 250.00, 280.00, '1258', '2026-08-06 19:04:26', NULL, NULL, NULL, NULL),
(14, 666, 420, 'Cat Food', 'Miaw ', 450.00, 800.00, '', '2026-08-09 04:41:58', NULL, NULL, NULL, NULL),
(16, 1, 1, 'Dumur', 'roja', 1200.00, 1400.00, '0212', '2026-08-09 05:06:34', NULL, NULL, NULL, NULL),
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
(6, 1, '2026-08-10', 640.00, 0.00, 1, 0.00, 640.00, '', 1, '2026-08-12 12:53:01', '2026-08-12 16:53:01', NULL, 7, NULL);

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
(8, 6, 18, 5, 128.00, 640.00, '2026-08-12 12:53:01', '2026-08-12 16:53:01', NULL, 7, NULL);

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
(5, 3, 7, '2026-08-11', 135.00, 0.00, 0.00, 1, '2026-08-12 12:53:58', '2026-08-12 16:53:58', NULL, 7, NULL, 4);

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
(13, 5, 18, 1, 135.00, 135.00, '2026-08-12 12:53:58', '2026-08-12 16:53:58', NULL, 7, NULL);

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
  `sale_id` int(11) DEFAULT NULL,
  `stock_transfer_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

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
(14, NULL, 3, 4, 25, NULL, NULL, NULL, 0, '2026-08-14 06:03:08', NULL);

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
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
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
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
