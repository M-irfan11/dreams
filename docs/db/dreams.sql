-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2026 at 09:12 AM
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
(12, 0, 2, 'book', 'mkd', 250.00, 280.00, '1258', '2026-08-06 19:04:26', NULL, NULL, NULL, NULL),
(13, 2, 44, 'Mi', 'Miaw ', 65000.00, 850.00, '55', '2026-08-09 04:34:26', NULL, NULL, NULL, NULL),
(14, 666, 420, 'Cat Food', 'Miaw ', 450.00, 800.00, '', '2026-08-09 04:41:58', NULL, NULL, NULL, NULL),
(15, 55, 555, 'dd', 'ddfd', 500.00, 600.00, 'sdd', '2026-08-09 04:56:52', NULL, NULL, NULL, NULL);

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
(5, 0, '0000-00-00', 0.00, 0.00, 0, 0.00, 0.00, '', 1, '2026-08-06 23:45:04', '2026-08-07 03:45:04', NULL, 1, NULL),
(6, 0, '0000-00-00', 0.00, 0.00, 0, 0.00, 0.00, '', 1, '2026-08-06 23:45:11', '2026-08-07 03:45:11', NULL, 1, NULL),
(7, 0, '0000-00-00', 0.00, 0.00, 0, 0.00, 0.00, '', 1, '2026-08-06 23:45:14', '2026-08-07 03:45:14', NULL, 1, NULL),
(8, 2, '2026-04-08', 250.00, 2.00, 2, 15.00, 281.75, 'jaber ibrahim', 1, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL),
(9, 1, '2026-08-09', 19565000.00, 0.00, 0, 0.00, 19565000.00, 'dd', 1, '2026-08-09 02:25:26', '2026-08-09 06:25:26', NULL, 7, NULL),
(10, 1, '2026-08-09', 500.00, 0.00, 1, 0.00, 500.00, '88', 1, '2026-08-09 02:32:28', '2026-08-09 02:32:56', NULL, 7, 7),
(11, 1, '2026-08-09', 108900.00, 0.00, 0, 0.00, 108900.00, '88', 1, '2026-08-09 02:36:37', '2026-08-09 06:36:37', NULL, 7, NULL),
(12, 1, '2026-08-09', 32500000.00, 0.00, 0, 0.00, 32500000.00, '88', 1, '2026-08-09 02:39:25', '2026-08-09 06:39:25', NULL, 7, NULL);

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
(20, 8, 12, 1, 250.00, 250.00, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL),
(21, 9, 13, 301, 65000.00, 19565000.00, '2026-08-09 02:25:26', '2026-08-09 06:25:26', NULL, 7, NULL),
(23, 10, 15, 1, 500.00, 500.00, '2026-08-09 02:32:56', '2026-08-09 06:32:56', NULL, 7, NULL),
(24, 11, 3, 99, 1100.00, 108900.00, '2026-08-09 02:36:37', '2026-08-09 06:36:37', NULL, 7, NULL),
(25, 12, 13, 500, 65000.00, 32500000.00, '2026-08-09 02:39:25', '2026-08-09 06:39:25', NULL, 7, NULL);

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
  `updated_by` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `customer_id`, `user_id`, `sale_date`, `total_amount`, `discount`, `tax`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `warehouse_id`) VALUES
(1, 1, 7, '2026-08-12', 4860.00, 500.00, 1.00, 2, '2026-08-09 00:40:24', '2026-08-09 04:40:24', NULL, 7, NULL, 3),
(2, 1, 7, '2026-08-13', 1680.00, 500.00, 5.00, 2, '2026-08-09 00:40:50', '2026-08-09 04:40:50', NULL, 7, NULL, 3);

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
(2, 2, 12, 6, 280.00, 1680.00, '2026-08-09 00:40:50', '2026-08-09 04:40:50', NULL, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `warehouse_id`, `quantity`, `updated_at`, `deleted_at`) VALUES
(1, 12, 4, 24, '2026-08-08 16:00:21', NULL),
(2, 9, 3, 33, '2026-08-08 22:38:12', NULL),
(3, 14, 3, 500, '2026-08-09 05:41:26', NULL);

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
(21, 12, 1, '2026-04-08', NULL, 8, NULL, NULL, 1, '2026-08-07 06:11:49', '2026-08-07 10:11:49', NULL, 1, NULL),
(22, 2, 6, '2026-08-12', 1, NULL, NULL, NULL, 0, '2026-08-09 00:40:24', '2026-08-09 04:40:24', NULL, 7, NULL),
(23, 12, 6, '2026-08-13', 2, NULL, NULL, NULL, 0, '2026-08-09 00:40:50', '2026-08-09 04:40:50', NULL, 7, NULL),
(24, 2, 52, '2026-08-09', 2, 8, 4556554, 5524, 0, '2026-08-09 05:43:10', '2026-08-09 05:43:10', NULL, NULL, NULL),
(25, 13, 301, '2026-08-09', NULL, 9, NULL, NULL, 1, '2026-08-09 02:25:26', '2026-08-09 06:25:26', NULL, 7, NULL),
(27, 15, 1, '2026-08-09', NULL, 10, NULL, NULL, 1, '2026-08-09 02:32:56', '2026-08-09 06:32:56', NULL, 7, NULL),
(28, 3, 99, '2026-08-09', NULL, 11, NULL, NULL, 1, '2026-08-09 02:36:37', '2026-08-09 06:36:37', NULL, 7, NULL),
(29, 13, 500, '2026-08-09', NULL, 12, NULL, NULL, 1, '2026-08-09 02:39:25', '2026-08-09 06:39:25', NULL, 7, NULL);

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
(0, 'Fatehabad', 'same', 'ifran', '2026-08-09 04:57:18', '2026-08-09 04:57:18', NULL, NULL, NULL),
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
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

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
  ADD PRIMARY KEY (`sale_id`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stocks_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
