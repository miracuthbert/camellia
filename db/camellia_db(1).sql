-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2017 at 09:25 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camellia_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `details` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`, `details`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Meals', 'meals', NULL, 'Assign to meals.', 1, '2017-12-01 14:43:33', '2017-12-03 18:13:09'),
(2, 'Hot Beverages', 'hot-beverages', 4, 'Assign to beverages that are hot/warm.', 1, '2017-12-01 14:47:14', '2017-12-11 09:55:55'),
(4, 'Drinks', 'drinks', NULL, 'Assign to beverages that are alcoholic.', 1, '2017-12-01 16:41:31', '2017-12-07 13:59:59'),
(5, 'Snacks', 'snacks', 1, 'Assign to meals that are listed as snacks.', 1, '2017-12-03 18:20:26', '2017-12-03 18:50:53'),
(6, 'Lunch', 'lunch', 1, 'Assign to meals that are mainly available at lunch.', 1, '2017-12-03 19:03:21', '2017-12-07 12:50:37'),
(7, 'Cold Beverages', 'cold-beverages', 4, 'Cold beverages category.', 1, '2017-12-07 13:03:20', '2017-12-11 10:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `image` text,
  `price` double NOT NULL DEFAULT '0',
  `usable` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `category_id`, `name`, `details`, `image`, `price`, `usable`, `created_at`, `updated_at`) VALUES
(1, 6, 'Fries with Quarter Chicken', 'Fries with chicken wing.', NULL, 250, 1, '2017-12-03 21:15:45', '2017-12-03 21:15:45'),
(2, 5, 'Samosa (Beef)', 'Samosa filled with beef.', NULL, 30, 1, '2017-12-05 14:29:37', '2017-12-05 16:36:58'),
(3, 5, 'Bagia', 'Made with lentil flour.', NULL, 20, 1, '2017-12-05 14:30:29', '2017-12-05 18:44:05'),
(4, 2, 'Hot Choclate', 'Hot choclate drink.', NULL, 180, 1, '2017-12-11 09:57:48', '2017-12-11 09:57:48');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `booked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `booked_at`, `expired_at`, `paid_at`, `created_at`, `updated_at`) VALUES
(2, 1, '2017-12-11 06:25:17', NULL, NULL, '2017-12-11 06:25:17', '2017-12-11 06:25:17'),
(3, 1, '2017-12-11 06:32:38', NULL, NULL, '2017-12-11 06:32:38', '2017-12-11 06:32:38'),
(4, 1, '2017-12-11 06:34:31', NULL, NULL, '2017-12-11 06:34:31', '2017-12-11 06:34:31'),
(5, 1, '2017-12-11 06:34:57', NULL, NULL, '2017-12-11 06:34:57', '2017-12-11 06:34:57'),
(6, 2, '2017-12-11 09:11:43', NULL, '2017-12-11 20:21:44', '2017-12-11 09:11:43', '2017-12-11 20:21:44'),
(7, 1, '2017-12-11 13:18:32', NULL, NULL, '2017-12-11 13:18:32', '2017-12-11 13:18:32'),
(8, 1, '2017-12-11 13:20:24', NULL, NULL, '2017-12-11 13:20:24', '2017-12-11 13:20:24'),
(9, 1, '2017-12-11 13:27:03', NULL, '2017-12-11 20:17:35', '2017-12-11 13:27:03', '2017-12-11 20:17:35'),
(10, 1, '2017-12-11 13:40:11', NULL, '2017-12-12 08:19:59', '2017-12-11 13:40:11', '2017-12-12 08:19:59'),
(11, 1, '2017-12-11 13:40:33', NULL, NULL, '2017-12-11 13:40:33', '2017-12-11 13:40:33'),
(12, 1, '2017-12-11 13:45:15', NULL, NULL, '2017-12-11 13:45:15', '2017-12-11 13:45:15'),
(13, 1, '2017-12-11 13:45:31', NULL, NULL, '2017-12-11 13:45:31', '2017-12-11 13:45:31'),
(14, 1, '2017-12-11 13:48:40', NULL, NULL, '2017-12-11 13:48:40', '2017-12-11 13:48:40'),
(15, 1, '2017-12-11 13:49:11', NULL, NULL, '2017-12-11 13:49:11', '2017-12-11 13:49:11'),
(16, 1, '2017-12-11 13:49:36', NULL, NULL, '2017-12-11 13:49:36', '2017-12-11 13:49:36'),
(17, 1, '2017-12-11 13:53:15', NULL, NULL, '2017-12-11 13:53:15', '2017-12-11 13:53:15'),
(18, 1, '2017-12-11 13:56:01', NULL, NULL, '2017-12-11 13:56:01', '2017-12-11 13:56:01'),
(19, 1, '2017-12-11 14:01:40', NULL, NULL, '2017-12-11 14:01:40', '2017-12-11 14:01:40'),
(20, 1, '2017-12-11 14:02:04', NULL, NULL, '2017-12-11 14:02:04', '2017-12-11 14:02:04'),
(21, 1, '2017-12-11 14:03:04', NULL, NULL, '2017-12-11 14:03:04', '2017-12-11 14:03:04'),
(22, 1, '2017-12-11 14:03:36', NULL, NULL, '2017-12-11 14:03:36', '2017-12-11 14:03:36'),
(23, 1, '2017-12-11 14:07:25', NULL, NULL, '2017-12-11 14:07:25', '2017-12-11 14:07:25'),
(24, 1, '2017-12-11 14:07:51', NULL, NULL, '2017-12-11 14:07:51', '2017-12-11 14:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `food_id` int(10) UNSIGNED NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 250, 1, '2017-12-11 06:25:17', '2017-12-11 06:25:17'),
(2, 3, 2, 30, 10, '2017-12-11 06:32:38', '2017-12-11 06:32:38'),
(3, 3, 1, 250, 3, '2017-12-11 06:32:38', '2017-12-11 06:32:38'),
(4, 4, 2, 30, 6, '2017-12-11 06:34:31', '2017-12-11 06:34:31'),
(5, 5, 1, 250, 1, '2017-12-11 06:34:57', '2017-12-11 06:34:57'),
(6, 6, 1, 250, 1, '2017-12-11 09:11:43', '2017-12-11 09:11:43'),
(7, 7, 2, 30, 5, '2017-12-11 13:18:32', '2017-12-11 13:18:32'),
(8, 7, 1, 250, 1, '2017-12-11 13:18:32', '2017-12-11 13:18:32'),
(9, 8, 2, 30, 6, '2017-12-11 13:20:24', '2017-12-11 13:20:24'),
(10, 8, 1, 250, 3, '2017-12-11 13:20:24', '2017-12-11 13:20:24'),
(11, 9, 2, 30, 9, '2017-12-11 13:27:03', '2017-12-11 13:27:03'),
(12, 9, 3, 20, 6, '2017-12-11 13:27:03', '2017-12-11 13:27:03'),
(13, 9, 4, 180, 3, '2017-12-11 13:27:03', '2017-12-11 13:27:03'),
(14, 10, 1, 250, 4, '2017-12-11 13:40:11', '2017-12-11 13:40:11'),
(15, 11, 1, 250, 1, '2017-12-11 13:40:33', '2017-12-11 13:40:33'),
(16, 12, 4, 180, 2, '2017-12-11 13:45:15', '2017-12-11 13:45:15'),
(17, 13, 1, 250, 2, '2017-12-11 13:45:31', '2017-12-11 13:45:31'),
(18, 14, 2, 30, 20, '2017-12-11 13:48:40', '2017-12-11 13:48:40'),
(19, 15, 1, 250, 20, '2017-12-11 13:49:11', '2017-12-11 13:49:11'),
(20, 16, 4, 180, 20, '2017-12-11 13:49:36', '2017-12-11 13:49:36'),
(21, 17, 1, 250, 1, '2017-12-11 13:53:15', '2017-12-11 13:53:15'),
(22, 18, 1, 250, 1, '2017-12-11 13:56:01', '2017-12-11 13:56:01'),
(23, 19, 1, 250, 1, '2017-12-11 14:01:40', '2017-12-11 14:01:40'),
(24, 20, 3, 20, 4, '2017-12-11 14:02:04', '2017-12-11 14:02:04'),
(25, 21, 3, 20, 7, '2017-12-11 14:03:04', '2017-12-11 14:03:04'),
(26, 22, 2, 30, 10, '2017-12-11 14:03:36', '2017-12-11 14:03:36'),
(27, 23, 2, 30, 20, '2017-12-11 14:07:25', '2017-12-11 14:07:25'),
(28, 24, 1, 250, 10, '2017-12-11 14:07:51', '2017-12-11 14:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_payments`
--

INSERT INTO `order_payments` (`id`, `order_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 9, 1, '2017-12-11 20:17:35', '2017-12-11 20:17:35'),
(2, 6, 1, '2017-12-11 20:21:43', '2017-12-11 20:21:43'),
(3, 10, 1, '2017-12-12 08:19:59', '2017-12-12 08:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '2017-12-11 07:05:22', '2017-12-11 07:05:22'),
(2, 'Cashier', 'cashier', '2017-12-11 07:05:22', '2017-12-11 07:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` int(191) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Cuthbert', 'Cuthbert', 'miracuthbert@gmail.com', 763232713, '$2y$10$3CXjStfOgXXoU43rNV.mK.ab0jpUfrGGxQn5JFr7BOKaYg6oPHmZG', NULL, '2017-12-01 12:20:15', '2017-12-01 12:20:15'),
(2, 'John', 'John', 'johndoe@test.com', 724308266, '$2y$10$aH0JFKG5ArPnLtccED2Us.ILAdLYMP8UnAmSmGecbGFQTy9Hyeh5W', NULL, '2017-12-07 13:46:03', '2017-12-07 13:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, '2017-12-11 07:10:41', '2017-12-11 07:10:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_roles_ibfk_1` (`user_id`),
  ADD KEY `user_roles_ibfk_2` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`);

--
-- Constraints for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD CONSTRAINT `order_payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_payments_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
