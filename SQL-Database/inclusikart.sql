-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 06:55 AM
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
-- Database: `disability_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyers`
--

INSERT INTO `buyers` (`id`, `name`, `email`, `username`, `password`, `created_at`, `address`) VALUES
(1, 'Farah', 'farah@gmail.com', 'farah', '$2y$10$Hro8IPEw/wPfZ3woCUq/k.rIQ1GrXyqe7bREKKR3d4hFUehCa3Tgm', '2025-04-01 02:55:33', ''),
(2, 'Sitaram', 'sitaram@gmail.com', 'sitaram', '$2y$10$1MUkJvMHBkuY/6OVg9vjAu1i..07tnYp7RLpRks/3mr2tcLEa5yRG', '2025-04-01 03:13:29', ''),
(3, 'Navya', 'navya@gmail.com', 'navya', '$2y$10$0Yg.WXc5kj1kewfqyW6gjeQfGgGKE.5GhTO0J/f.D0MUzAhiVgxZC', '2025-04-02 13:05:24', ''),
(4, 'Geetu', 'geetu@gmail.com', 'Geetu', '$2y$10$6HE/y9OZauaCIUuWtAzAy.kIFtqZwEdFe4.v0x7.ZcED252j3UjRW', '2025-04-12 15:01:36', ''),
(5, 'Smitha', 'smitha@gmail.com', 'smitha', '$2y$10$rEO6p5IYtTCeu/ydTRXKMOl7YLW/XnbFb2.kult0TK5yq1RNgHNp2', '2025-04-13 03:35:05', ''),
(6, 'saara', 'saara@gmail.com', 'saara', '$2y$10$C.xGqc/zPHE5n4bjTHQnCe18rhr.ZBy1dUhjEw7F8aipIg2Mecuqi', '2025-04-13 03:52:36', ''),
(7, 'Madhu', 'madhu@gmail.com', 'madhu', '$2y$10$JBBJSxDBbhF2PJdwAO0k6.QnU/f6pcthkhZUBW6fPyBT2ytoAThEC', '2025-04-13 04:49:15', ''),
(8, 'Sairam', 'sairam@gmail.com', 'sairam', '$2y$10$Pa0/yIatyJzHyGotl6Gh6.3t2T6TfltviFr7kU4PeVf1W0gmtPdmy', '2025-04-14 05:40:50', ''),
(9, 'Sonuu', 'sonuu@gmail.com', 'sonuu', '$2y$10$gwFex9rJmFd/aYmn9.rGDO85saCgi/6YMRauoFXvpBpP8VmQTm/vq', '2025-04-14 05:44:13', ''),
(10, 'Ramesh', 'ramesh@gmail.com', 'Ramesh', '$2y$10$yCB7K5eli9E3qAdv3/tbfOzE01OUM0nT3gCYSs2wV3P75/kspMtPW', '2025-04-14 05:45:37', ''),
(11, 'Chandu', 'chandu@gmail.com', 'chandu', '$2y$10$x2b97HIcuplIt3HNdwZyXOv5A9o97jxmRnRHP41mtkYzi0UIqkgN2', '2025-04-14 06:22:16', ''),
(12, 'Bhavya', 'bhavya@gmail.com', 'Bhavya', '$2y$10$HWWdHZm0ZecjoE1nstSmgu6PFq.c2rVOhNotxm8V2OYBu6L9WGP0m', '2025-04-18 11:25:50', ''),
(13, 'Bindu', 'bindu@gmail.com', 'Bindu', '$2y$10$PlKY/6W0xIxzKGGOQDoriOk4EV6MT.bLESu34G0W2U8RYfE4zGjxa', '2025-04-18 11:32:25', ''),
(14, 'Akshay', 'akshay@gmail.com', 'Akshay', '$2y$10$Hsn/1/zIFoYTbjsjE86MpeKj8V0FKT7CibYLVG80qyX0gmDQTfFce', '2025-04-19 00:53:20', '');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_type` enum('buyer','seller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `user_type`) VALUES
(2, 9, 16, 1, '2025-04-14 06:20:53', 'buyer'),
(9, 1, 16, 1, '2025-04-18 05:36:53', 'buyer'),
(30, 1, 22, 1, '2025-04-26 15:03:47', 'buyer');

-- --------------------------------------------------------

--
-- Table structure for table `demand_requests`
--

CREATE TABLE `demand_requests` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demand_requests`
--

INSERT INTO `demand_requests` (`id`, `buyer_id`, `product_id`, `quantity`, `status`, `created_at`) VALUES
(1, 1, 14, 10, 'approved', '2025-04-13 08:49:25'),
(2, 4, 15, 7, 'approved', '2025-04-13 11:01:15'),
(3, 7, 17, 12, 'pending', '2025-04-14 09:56:36'),
(4, 14, 24, 20, 'pending', '2025-04-19 01:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `disability_type` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `name`, `age`, `disability_type`, `contact`, `reason`, `qr_code`, `created_at`) VALUES
(1, 6, 'Nivya', 23, 'Visually Impaired', '9090909090', 'I am currently in need of financial support to purchase a wheelchair, which is essential for my mobility and daily activities. Due to my physical disability, I am unable to walk without assistance, and the lack of a proper mobility aid limits my independence. A suitable wheelchair or mobility equipment would significantly improve my quality of life by allowing me to move around safely, attend appointments, and even explore income-generating opportunities from home. Unfortunately, due to my current financial situation, I am unable to afford one. I sincerely request support from kind donors to help me live with dignity and freedom.\r\n\r\n', 'nivya@okhdfcbank', '2025-04-06 11:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` text NOT NULL,
  `status` enum('pending','shipped','delivered') DEFAULT 'pending',
  `estimated_delivery` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `total`, `created_at`, `address`, `status`, `estimated_delivery`) VALUES
(1, 3, 900.00, '2025-04-08 13:37:06', '', 'pending', NULL),
(2, 3, 350.00, '2025-04-08 13:45:02', '', 'pending', NULL),
(3, 1, 950.00, '2025-04-10 08:50:17', '', 'pending', NULL),
(4, 1, 150.00, '2025-04-10 16:35:11', '', 'pending', NULL),
(5, 1, 100.00, '2025-04-11 08:38:52', '', 'pending', NULL),
(6, 1, 300.00, '2025-04-11 09:09:59', '', 'pending', NULL),
(7, 1, 100.00, '2025-04-11 09:27:52', '', 'pending', NULL),
(8, 4, 800.00, '2025-04-12 15:02:22', '', 'pending', NULL),
(9, 4, 200.00, '2025-04-12 15:10:45', '', 'pending', NULL),
(10, 3, 200.00, '2025-04-13 03:30:58', '', 'pending', NULL),
(11, 2, 470.00, '2025-04-13 03:45:21', '', 'pending', NULL),
(12, 6, 850.00, '2025-04-13 03:54:24', '', 'pending', NULL),
(13, 7, 80.00, '2025-04-13 04:49:38', '', 'pending', NULL),
(14, 10, 400.00, '2025-04-14 06:13:49', '', 'pending', NULL),
(15, 10, 130.00, '2025-04-14 06:20:00', '', 'pending', NULL),
(16, 11, 370.00, '2025-04-14 06:23:52', '', 'pending', NULL),
(17, 8, 400.00, '2025-04-14 06:24:31', '', 'pending', NULL),
(18, 10, 130.00, '2025-04-14 08:40:41', 'Sanathnagar, Hyderabad 8-3-228/447', 'pending', NULL),
(19, 11, 400.00, '2025-04-14 09:54:32', 'SanathNagar,Hyderabad,8-3-228/447', 'pending', NULL),
(20, 10, 390.00, '2025-04-17 04:46:13', 'SanathNagar', 'pending', NULL),
(21, 12, 360.00, '2025-04-18 11:26:47', 'Nagarkurnool', 'pending', NULL),
(22, 13, 580.00, '2025-04-18 11:33:02', 'Rahmathnagar', 'pending', NULL),
(23, 13, 800.00, '2025-04-18 11:37:54', 'SanathNagar', 'pending', NULL),
(24, 10, 380.00, '2025-04-18 11:48:21', 'Telangana Hyd', 'pending', NULL),
(25, 10, 100.00, '2025-04-18 11:48:59', 'Warangal', 'pending', NULL),
(26, 14, 1100.00, '2025-04-19 00:54:21', 'Dilsukhnagar', 'pending', NULL),
(27, 10, 930.00, '2025-04-19 00:58:52', 'Telangana Hyd', 'pending', NULL),
(28, 14, 70.00, '2025-04-19 08:07:34', 'SanathNagar', 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(2, 2, 9, 1, 350.00),
(3, 3, 8, 2, 200.00),
(4, 3, 3, 1, 400.00),
(5, 3, 2, 1, 150.00),
(6, 4, 2, 1, 150.00),
(7, 5, 1, 1, 100.00),
(9, 7, 1, 1, 100.00),
(10, 8, 12, 4, 200.00),
(11, 9, 12, 1, 200.00),
(12, 10, 12, 1, 200.00),
(13, 11, 13, 1, 470.00),
(14, 12, 2, 1, 150.00),
(15, 12, 14, 1, 230.00),
(16, 12, 13, 1, 470.00),
(17, 13, 16, 1, 80.00),
(18, 14, 17, 1, 400.00),
(19, 15, 15, 1, 130.00),
(20, 16, 11, 1, 240.00),
(21, 16, 15, 1, 130.00),
(22, 17, 17, 1, 400.00),
(23, 18, 15, 1, 130.00),
(24, 19, 17, 1, 400.00),
(25, 20, 15, 3, 130.00),
(26, 21, 21, 1, 60.00),
(27, 21, 22, 3, 100.00),
(28, 22, 21, 3, 60.00),
(29, 22, 22, 4, 100.00),
(30, 23, 21, 5, 60.00),
(31, 23, 22, 5, 100.00),
(32, 24, 21, 3, 60.00),
(33, 24, 22, 2, 100.00),
(34, 25, 22, 1, 100.00),
(35, 26, 25, 2, 70.00),
(36, 26, 24, 4, 240.00),
(37, 27, 25, 3, 70.00),
(38, 27, 24, 3, 240.00),
(39, 28, 25, 1, 70.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `materials_used` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `image`, `description`, `price`, `status`, `created_at`, `materials_used`) VALUES
(1, 6, 'Threaded Bangles', 'bangles.jpg', 'Handmade beautiful traditional stylish latest premium silk thread combo collection bangles for women and girls for festivals/occasions.', 100.00, 'approved', '2025-04-01 07:13:37', NULL),
(2, 6, 'Silk Threaded Bangles', 'silk threaded bangles2.jpg', 'Handmade beautiful traditional stylish latest premium silk thread combo collection bangles for women and girls for festivals/occasions.', 150.00, 'approved', '2025-04-01 08:05:37', NULL),
(3, 6, 'Woolen Shawls', 'woolenshawls.jpg', 'Handmade wooden shawls are stylish and unique, crafted with care using wood elements. They add a natural and elegant touch to any outfit.', 400.00, 'approved', '2025-04-01 08:11:11', NULL),
(8, 15, 'Handmade Bags', 'handbags.jpg', 'This is the story of an adventurer who travels to unexplored lands, facing various challenges and making new discoveries along the way. ', 200.00, 'approved', '2025-04-06 08:04:18', NULL),
(9, 6, 'Wooden Craft', 'wooden.jpg', 'Discover excellence at handmade wooden crafts. Transform your living spaces with our handcrafted wooden handicrafts, perfect for enhancing your home decor.', 350.00, 'approved', '2025-04-08 13:02:43', NULL),
(11, 6, 'Chikankari', 'chikankari.jpeg', 'Chikankari is a traditional embroidery style from Lucknow, India, known for its intricate hand-stitched designs.', 240.00, 'approved', '2025-04-12 13:44:09', NULL),
(12, 42, 'Handmade Cloth Bags', 'handmadeclothbag1.jpeg', 'Handmand Patch Work tote bags, for that ethnic chic look. Pair it with ethnic and traditional outfits.', 200.00, NULL, '2025-04-12 14:57:36', NULL),
(13, 42, 'Handmade Clcok', 'handmadeclock.jpeg', 'From traditional to modern designs, find the perfect clock to enhance your decor and keep time in style.', 470.00, NULL, '2025-04-13 03:33:58', NULL),
(14, 25, 'Wall Hanger', 'wallhanger.jpeg', 'Wall hangers for clothes are available in various sizes and colours to match your room\'s aesthetic.', 230.00, '', '2025-04-13 03:50:04', NULL),
(15, 44, 'Home Decor', 'homedecor.jpeg', 'Trove Craft India is a modest design studio based in Hyderabad that creates unique, handcrafted home decor concepts. ', 130.00, 'approved', '2025-04-13 04:44:42', NULL),
(16, 44, 'Beautiful Home Decor', 'homedecor3.jpeg', 'Trove Craft India is a modest design studio based in Hyderabad that creates unique, handcrafted home decor concepts. ', 80.00, 'approved', '2025-04-13 04:47:56', NULL),
(17, 45, 'Ecofriendly Showcase', 'ecofriendly Showcase.jpeg', 'handmade crafts often require fewer resources during their production process compared to mass-produced goods, making them a more eco-friendly option.', 500.00, 'approved', '2025-04-14 04:42:58', NULL),
(18, 45, 'Ecofriendly Baskets', 'wooden.jpg', 'Indiahandmade is an initiative of the Ministry of Textile, Govt. of India that has an authentic range of Indian handloom & handicraft items.', 200.00, 'pending', '2025-04-16 09:34:50', 'Indiahandmade is an initiative of the Ministry of Textile, Govt. of India that has an authentic range of Indian handloom & handicraft items.'),
(19, 45, 'Ecofriendly Baskets', 'homedecor3.jpeg', 'jdhfdjf', 200.00, 'approved', '2025-04-17 05:03:51', 'dfkdjfd'),
(20, 47, 'Wooden handmade crafts', 'wooden.jpg', 'this is a beautiful wooden craft', 150.00, 'approved', '2025-04-18 06:58:10', 'made of pure wooden'),
(21, 47, 'Handmade Keychain', 'keychain.jpeg', 'Handmade Crochet Keychain, Crochet Keychain for Car, Motorbike, Bag, Purse, Crochet Keyrings & Keychains, Knitting', 60.00, 'approved', '2025-04-18 07:03:49', 'Handmade Crochet Keychain, Crochet Keychain for Car, Motorbike, Bag, Purse, Crochet Keyrings & Keychains, Knitting'),
(22, 47, 'Cute Cushions', 'cushions.jpeg', ' cushions are more for support (under your back on a sofa) or for decoration, such as on your armchair, chair or bed, pillows are designed for sleeping', 100.00, 'approved', '2025-04-18 07:07:16', ' cushions are more for support (under your back on a sofa) or for decoration, such as on your armchair, chair or bed, pillows are designed for sleeping'),
(23, 47, 'Orange Cushion', 'cushion2orange.jpeg', ' cushions are more for support (under your back on a sofa) or for decoration, such as on your armchair, chair or bed, pillows are designed for sleeping', 130.00, 'approved', '2025-04-18 07:11:26', ' cushions are more for support (under your back on a sofa) or for decoration, such as on your armchair, chair or bed, pillows are designed for sleeping'),
(24, 49, 'Handmade Clay Cup', 'claycup.jpg', 'Handmade ceramic mugs are typically crafted using high-quality materials and traditional pottery techniques, resulting in durable and long-lasting products', 240.00, 'approved', '2025-04-19 00:42:48', 'Handmade ceramic mugs are typically crafted using high-quality materials and traditional pottery techniques, resulting in durable and long-lasting products'),
(25, 49, 'Wooden Keychains', 'woodenkeychains.jpg', 'Handmade ceramic mugs are typically crafted using high-quality materials and traditional pottery techniques, resulting in durable and long-lasting products', 70.00, 'approved', '2025-04-19 00:51:14', 'Handmade ceramic mugs are typically crafted using high-quality materials and traditional pottery techniques, resulting in durable and long-lasting products'),
(26, 49, 'Ecofriendly Baskets', 'wooden.jpg', 'fjdsljfsfjjdsl', 300.00, 'approved', '2025-04-19 08:02:34', 'dfjkfjdkfj');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `quantity`, `price`, `created_at`, `views`) VALUES
(1, 11, 40, 240.00, '2025-04-12 13:44:09', 3),
(2, 12, 30, 200.00, '2025-04-12 14:57:36', 0),
(3, 13, 12, 470.00, '2025-04-13 03:33:58', 0),
(4, 14, 17, 230.00, '2025-04-13 03:50:04', 0),
(5, 15, 4, 130.00, '2025-04-13 04:44:42', 6),
(6, 16, 4, 80.00, '2025-04-13 04:47:56', 5),
(7, 17, 8, 260.00, '2025-04-14 04:42:58', 11),
(8, 18, 4, 200.00, '2025-04-16 09:34:50', 0),
(9, 19, 3, 200.00, '2025-04-17 05:03:51', 0),
(10, 20, 2, 150.00, '2025-04-18 06:58:10', 0),
(11, 21, 2, 60.00, '2025-04-18 07:03:49', 10),
(12, 22, 12, 100.00, '2025-04-18 07:07:16', 9),
(13, 23, 5, 130.00, '2025-04-18 07:11:26', 0),
(14, 24, 10, 240.00, '2025-04-19 00:42:48', 4),
(15, 25, 6, 70.00, '2025-04-19 00:51:14', 3),
(16, 26, 12, 300.00, '2025-04-19 08:02:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_verifiers`
--

CREATE TABLE `product_verifiers` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `verifier_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `reviewed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile_verifier`
--

CREATE TABLE `profile_verifier` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_verifier`
--

INSERT INTO `profile_verifier` (`id`, `username`, `password`) VALUES
(1, 'profile1', 'pass123'),
(2, 'profile2', 'pass456');

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_requests`
--

CREATE TABLE `raw_material_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `products` text DEFAULT NULL,
  `raw_materials_needed` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `raw_material_requests`
--

INSERT INTO `raw_material_requests` (`id`, `user_id`, `name`, `age`, `contact`, `address`, `products`, `raw_materials_needed`, `created_at`) VALUES
(2, 6, 'Nivya', 23, '9090909090', 'telangana Rahmathnagar', 'Crochet Bags', '', '2025-04-06 12:16:58'),
(3, 6, 'Nivya Alikanti', 20, '6767676767', 'telangan hyderabad sanaathnagar', 'Crochet handbags, Paintings', 'Yarn (cotton, wool, acrylic)\r\n\r\nNeedles (crochet, sewing, embroidery)\r\n\r\nThreads (colored and basic)', '2025-04-06 12:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `user_id`, `title`, `description`, `video_url`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'The Journey to the Unknown', 'This is the story of an adventurer who travels to unexplored lands, facing various challenges and making new discoveries along the way. The journey is full of mystery, and every day is a new adventure!', 'uploads/1743917859_share_story1.mp4', 'uploads/1743917859_share_story1img.jpg', 'approved', '2025-04-06 05:37:39', '2025-04-06 05:45:11'),
(2, 6, 'The Journey to the Unknown', 'This is the story of an adventurer who travels to unexplored lands, facing various challenges and making new discoveries along the way. The journey is full of mystery, and every day is a new adventure!', 'uploads/1743918091_share_story1.mp4', 'uploads/1743918091_share_story1img.jpg', 'rejected', '2025-04-06 05:41:31', '2025-04-06 08:01:24'),
(3, 15, 'The Journey to the Unknown', 'This is the story of an adventurer who travels to unexplored lands, facing various challenges and making new discoveries along the way. The journey is full of mystery, and every day is a new adventure!', 'uploads/1743926438_share_story1.mp4', 'uploads/1743926438_share_story2.jpg', 'approved', '2025-04-06 08:00:38', '2025-04-06 08:01:26'),
(4, 39, 'The Journey to the Unknown', 'A forgotten haveli in Shekhawati reveals tales through its fading frescoes. When a young artist visits to restore the murals, he finds echoes of love, rebellion, and freedom hidden in every color. But restoring the past comes with its own price — and its own blessings.', 'uploads/1744039700_share_story1.mp4', 'uploads/1744039700_share_story2.jpg', 'approved', '2025-04-07 15:28:20', '2025-04-07 15:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','submitted','verified','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`) VALUES
(1, 'Sita', 'sita@gmail.com', '$2y$10$Zs.ILwR4ztx.vUSH41EhV..ma0OZevfV7kSNpo9YGu06gFk9p6vsi', 'verified'),
(2, 'Rama', 'rama@gmail.com', '$2y$10$9W.Xu3KU09b6uuEaykwg6.4LgrfLJwKs/tRJ3Wj2Vk0HJTgFiggbS', 'verified'),
(3, 'Likitha', 'likitha23@gmail.com', '$2y$10$2wWUGNbawq5sBv/UE4vAhexwyez8WehKHKjOVf8cRYjOOuxNtbzvi', 'verified'),
(4, 'deekshitha', 'deeshaka@gmail.com', '$2y$10$.6lMSmbhXoq5uNm6OGFtbug2b0Acjq3IgVb5Bsfu3CrJbAg0pQiT.', 'verified'),
(6, 'nivya', 'nivyaalikanti@gmail.com', '$2y$10$Uigemoggrjb6ijUkBkfs9.L6Bs5UZjY9wHdRvb013GDE4nl6H/kiu', 'verified'),
(7, 'nivedi', 'nivedi@gmail.com', '$2y$10$m2J/WPHEAqYZQyVSfqU2JuFP0joKltUAxNbwN5BmscuXR5HT3D1oy', 'verified'),
(10, 'sitamahalakshmi', 'sitamahalakshmi@gmail.com', '$2y$10$i01fILl6wAyIyGCLHOxcXOCwCEybTRnS2839AN4pWnRmTAzeqNSh.', 'pending'),
(11, 'anand', 'anand@gmail.com', '$2y$10$52Id93Tti3DB6qhYqI0HLuHWcTva1tvbigSUgYwaNE3nijoZOxh96', 'verified'),
(12, 'Nikitha', 'niki@gmail.com', '$2y$10$k26sKVb8ZQ2aoIpd57cRZeqbBrz6KUpTQ/D5rsMmr1Ml1CfBWYnRe', 'rejected'),
(13, 'Rakshika', 'rakshi@gmail.com', '$2y$10$bfXd6o8s0cF7K2aTuqVULemHlmxqv1RWKf0aXVbim4dXiwPSqSfk2', 'verified'),
(14, 'nivyaalikanti', 'nivya@gmail.com', '$2y$10$OPcIGDc0zPxMlJZ3mRV/se57xhR4nfA.KCPVHr6Di8e8Qx6STQdVq', 'rejected'),
(15, 'Anitha', 'anitha@gmail.com', '$2y$10$BdpVq5vghELeIdu1w.z0LOQgYO2aX1CAbarpucLjdxw09gMvbV3IW', 'verified'),
(16, 'Naksha', 'naksha@gmail.com', '$2y$10$/KykMg0hwdcbdP.9zWY92e/58/A5Rq877QL.scnu2VhzW4cp6Dp..', 'pending'),
(17, 'Deepika', 'deepu@gmail.com', '$2y$10$l9AxdT3iQG/NHCibF75beOfP7HrZVa29Kjv.co2qnMq9Q0hKGjo5O', 'rejected'),
(18, 'Anjana', 'anjana@gmail.com', '$2y$10$0xSh0qjb8VC4M7x2R.HeR.tkdngtPF9BnuH8A6stTaOiC4iKfPcae', 'verified'),
(19, 'Sitaram', 'sitaram@gmail.com', '$2y$10$2Q/QaJ77vJ2WHqlnVCRmSeOoYI48AU94ceXRRH8mjCLSPKCLgSopO', 'rejected'),
(20, 'Ananya', 'ananya@gmail.com', '$2y$10$t0DlJlnoNnxuw47JVfp9kOBBsdr6YXSA0M0BPTe6CdBh0QbH270lu', 'verified'),
(21, 'Ramulu', 'ramulu@gmail.com', '$2y$10$LaGsF5aidL8JkkYdQBzoj.q0rVWQABE9asv/4j3Iui3oF1YCZIJTm', 'rejected'),
(22, 'Heena', 'heena@gmail.ccom', '$2y$10$cfpDidSNJBPyJW67FTpzluqOcNOLAC.StjTVuxF/iBujZ7u/bPc.m', 'rejected'),
(23, 'Diya', 'diya@gmail.com', '$2y$10$gYJjv98./D/Fk7W6qQzKjeWJVs2dOeGLOQroB/fVBN3iWjen4fH9u', 'verified'),
(24, 'Nayana', 'nayana@gmail.com', '$2y$10$EJLzz8cS7N6V3DMLJ0SKauGGRaV.cze0FEo2NPpCosqUMvgCTrHgG', 'verified'),
(25, 'Hyna', 'hyna@gmail.com', '$2y$10$djqwM3ZN5S9ga30yd.oK5eiaypIbU1/eYmkObzPxKzXZ58AwJ2Pzm', 'verified'),
(26, 'Sairam', 'sairam@gmail.com', '$2y$10$wSMwS4MNRWzvkXz0WZZ0euYyMTpv5DB2utI12m07G9AY0TA4H.A3W', 'verified'),
(27, 'Srilekha', 'srilekha@gmail.com', '$2y$10$ke3g7dBP5p/9FwcM5RLjh.RKN5.5CrObA0ZkgycKVHEN8ROnRtaca', 'verified'),
(28, 'Navya', 'navyaalikanti@gmail.com', '$2y$10$jKTZayXaGavgG.nJiGJkneuumhApqG9rrbLdhfPq4mEyouuEqs3Jq', 'verified'),
(29, 'Teju', 'teju@gmail.com', '$2y$10$qgyDLKRpFzajHOYDZduNBe.zem7B.MOuAbeKhp84At3PGB0zbZKG2', 'verified'),
(30, 'Esha', 'esha@gmail.com', '$2y$10$dW8x1IueiDn07lVtGJxcAuWmIqfP06dMK/Bg1nKtuCBj7NCxMjVyy', 'rejected'),
(31, 'Ghitha', 'ghitha@gmail.com', '$2y$10$8oGA7k2PJnvDekmHYdDnJe8va4LO/da/tuISfMi3dS1ier2Ex/ZCm', 'verified'),
(32, 'Preethi', 'preethi@gmail.com', '$2y$10$eK3Y/dj2TTbipA81yVWcLu.kYKwmOJ.QRkEcruPcXfAXWNYCQuZLy', 'verified'),
(33, 'Jheena', 'jheena@gmail.com', '$2y$10$gWkMPBUYYTv4l7PKRvYCbOZoqKjPz9Veya2DtW3P3zZ4r2O5mlqN6', 'verified'),
(34, 'Banu', 'banu@gmail.com', '$2y$10$Pnu8e9vKzletQnPdgKNp7egZ4mtT0Sz/Ku8vP8l2HMlbMD2ZjaYj.', 'verified'),
(35, 'Vanu', 'Vanu@gmal.com', '$2y$10$RvU/OqBF0Rc1ZY3T6xeaJOjaTrlrPBhNMyC2tpHF5vr5N7E0km1iK', 'verified'),
(36, 'Nandu', 'nandu@gmail.com', '$2y$10$jUmPe.QkYloDm/5W/G0Bp.12PT.WR0doQW3wf1HFkZ0Ed0CChMJzG', 'verified'),
(37, 'Chandu', 'chandu@gmail.com', '$2y$10$63PY6H8kaT015qrseD9yV.dkv4aptI9O2HuUk0YR8D1guetHgGGCK', 'submitted'),
(38, 'Xara', 'xara@gmail.com', '$2y$10$.5Ta2kuauPr3dsN7SnAMnujozKVsXVE67mziXi.yhCtkJR/BUM7h2', 'verified'),
(39, 'Vani', 'vani@gmail.com', '$2y$10$CMgmvw0fhWWJi.MtXK9tzOA29JVDHfwVUlzMSx0y1j6tSJXbL8lYO', 'verified'),
(40, 'Rishitha', 'rishi@gmail.com', '$2y$10$TV.rOT/KDX1umXUV8FKixuQQkFkAnnfVnlRYmLZXea2G9AdLRMHT6', 'pending'),
(41, 'Sandhya', 'sandhya@gmail.com', '$2y$10$wh7CbsB/grr3kJReDfhy6.IUu4QHzpaMo7dKc1/yN8AFMnTJZWuYC', 'verified'),
(42, 'Divya', 'divya@gmail.com', '$2y$10$6H/aPethAKDrKwZQSwxg3eK6F083zLchtRG8063Cm1mdMpYt/6ALS', 'verified'),
(43, 'Geetu', 'geetu@gmail.com', '$2y$10$azopOMlzFDEX77BVHlOnx.pJuWhtqV4tsmT/hrFD0fdkFwM/Q24uC', 'pending'),
(44, 'Sony', 'sony@gmail.com', '$2y$10$VAwqBf9ZAOYfsnww0dOI9OeQn2JQy0JrMnj4UyhAPbWiDmcZ17it6', 'verified'),
(45, 'Janu', 'janu@gmail.com', '$2y$10$.gwDR5aICvfAiAl7LyO/iudYDes2KlUYk9AqY8hiq0OzrsRXpSzc6', 'verified'),
(46, 'Saniya', 'saniya@gmail.com', '$2y$10$ItOk9LcrWN2HPN5tOdJByucXFEDEqq9O7fAPmIvYa9QWqsoa6kEgu', 'submitted'),
(47, 'Madhu', 'madhu@gmail.com', '$2y$10$hZkd6udWWxu540w1eCLJ6.7aW30dCv5gof99KAY5IiAovlYgwY2xC', 'verified'),
(48, 'Bindu', 'bindu@gmail.com', '$2y$10$4.yfrm.NJlEadA2ZuFpULO/u02g3Lay7IVLiH0xg5vNT6E8twX1xm', 'pending'),
(49, 'Medha', 'medha@gmail.com', '$2y$10$iGf3AvncNpXCqHZKv5rbOOi26kztb3jSXs0NQFzgOZhg62Q0/zcFy', 'verified'),
(50, 'Manya', 'manya@gmail.com', '$2y$10$O4gKs7e62XkkMgGmnPV18OfD5Zkp7rkDxwZDYwO5zjBxP3aqbMENW', 'verified'),
(51, 'Kalyani', 'kalyani@gmail.com', '$2y$10$eMiJH1GLafaDrobUuoPRbO94D3kpY5TPaFAL6bbYcHQnVqYtvhJMa', 'pending'),
(52, 'Lakshmi', 'lakshmi@gmail.com', '$2y$10$HwiyTIoiTFi.Wh/Ehnr09.cQGp3pmk71pSeU.9o/OBETnThdlBiG6', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `disability_type` varchar(100) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_account_number` varchar(50) NOT NULL,
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `name`, `dob`, `address`, `disability_type`, `document`, `bank_name`, `bank_account_number`, `gender`) VALUES
(1, 1, 'Sita Mahalakshmi', '2020-02-12', 'Telangana Hyd', 'Visually Impaired', 'disability_certificate.pdf', '', '', NULL),
(2, 2, 'Rama', '2024-07-03', 'Hyderabad', 'Physically', 'uploads/disability_certificate.pdf', '', '', NULL),
(3, 3, 'Likitha Reddy', '2023-09-05', 'SanathNagar', 'Visually Impaired', 'uploads/disability_certificate.pdf', '', '', NULL),
(4, 4, 'Deekshitha', '2025-03-03', 'Warangal', 'Visually Impaired', 'uploads/disability_certificate.pdf', '', '', NULL),
(5, 6, 'Nivya', '2006-02-21', 'Rahmathnagar', 'Visually Impaired', 'uploads/disability_certificate.pdf', '', '', NULL),
(6, 7, 'Niveditha', '2025-01-07', 'Nagarkurnool', 'Physically', 'uploads/Abstract.pdf', '', '', NULL),
(7, 11, 'Anand', '2023-09-05', 'Kothagudem', 'Physically', 'uploads/Inclusi Kart ppt.pptx', '', '', NULL),
(8, 12, 'Nikitha', '2023-03-06', 'Nagarkurnool', 'Physically', 'uploads/samaj-9007.pdf', '', '', NULL),
(9, 13, 'Rakshika Reddy', '2025-03-03', 'Telangana Hyd', 'Visually Impaired', 'uploads/Orange White Modular Abstract Strategy Deck Business Presentation.pdf', '', '', NULL),
(10, 14, 'NivyaAlikanti', '2025-03-02', 'SanathNagar', 'Visually Impaired', 'uploads/PART B.pdf', '', '', NULL),
(11, 17, 'Deepika', '2025-03-04', 'Telangana Hyd', 'Visually Impaired', 'uploads/PARTTA.pdf', '', '', NULL),
(12, 19, 'Sitaram', '2024-04-02', 'SanathNagar', 'Physically', 'uploads/download.pdf', '', '', NULL),
(13, 19, 'Sitaram', '2024-04-02', 'SanathNagar', 'Physically', 'uploads/download.pdf', '', '', NULL),
(14, 20, 'Ananya', '2021-01-03', 'Warangal', 'Hearing', 'uploads/Project Abstract_  (1) (1).pdf', '', '', NULL),
(15, 18, 'Anjana', '2025-03-05', 'Nagarkurnool', 'Hearing', 'uploads/itws2.pdf', '', '', NULL),
(16, 21, 'Ramulu', '2025-03-14', 'Rahmathnagar', 'Physically', 'uploads/PAART B.pdf', '', '', NULL),
(17, 22, 'Heena', '2025-03-04', 'Warangal', 'Physically', 'uploads/PART B.pdf', '', '', NULL),
(18, 23, 'Diya', '2025-03-06', 'Warangal', 'Visually Impaired', 'uploads/PART A.pdf', '', '', NULL),
(19, 24, 'Nayana', '2025-03-06', 'Warangal', 'Physically', 'uploads/PART A.pdf', '', '', NULL),
(20, 25, 'Hyna', '2025-03-06', 'Warangal', 'Visually Impaired', 'uploads/PART A.pdf', '', '', NULL),
(21, 26, 'SaiRam', '2025-04-07', 'Telangana Hyd', 'Hearing', 'uploads/download (1).pdf', '', '', NULL),
(22, 27, 'Srilekha', '2025-04-08', 'SanathNagar', 'Physically', 'uploads/disability_certificate (8).pdf', '', '', NULL),
(23, 28, 'Navya', '2025-04-16', 'SanathNagar', 'Visually Impaired', 'uploads/disability_certificate (7).pdf', '', '', NULL),
(24, 29, 'Teju', '2025-04-01', 'Telangana Hyd', 'Physically', 'uploads/Status_Report_format_2025[1].pdf', '', '', NULL),
(25, 30, 'Esha', '2025-04-09', 'SanathNagar', 'Visually Impaired', 'uploads/Status_Report_format_2025[1].pdf', '', '', NULL),
(26, 31, 'Ghitha', '2025-04-15', 'Warangal', 'Physically', 'uploads/disability_certificate.pdf', '', '', NULL),
(27, 32, 'Preethi', '2025-04-10', 'SanathNagar', 'Visually Impaired', 'uploads/disability_certificate (1).pdf', '', '', NULL),
(28, 33, 'Jheena', '2025-04-14', 'Nagarkurnool', 'Physically', 'uploads/disability_certificate (1).pdf', '', '', NULL),
(29, 34, 'Banu', '2025-04-13', 'Telangana Hyd', 'Visually Impaired', 'uploads/disability_certificate (7).pdf', '', '', NULL),
(30, 35, 'Vanu', '2025-04-09', 'Warangal', 'Physically', 'uploads/disability_certificate (8).pdf', '', '', NULL),
(31, 36, 'Nandu', '2025-04-20', 'Telangana Hyd', 'Visually Impaired', 'uploads/disability_certificate.pdf', '', '', NULL),
(32, 37, 'Chandu', '2025-04-09', 'SanathNagar', 'Physically', 'uploads/disability_certificate.pdf', '', '', NULL),
(33, 38, 'Xara', '2025-04-10', 'Nagarkurnool', 'Visually Impaired', 'uploads/disability_certificate.pdf', '', '', NULL),
(34, 15, 'Anitha', '2025-04-21', 'Warangal', 'Physically', 'uploads/disability_certificate (1).pdf', '', '', NULL),
(35, 39, 'Vani', '2025-04-10', 'SanathNagar', 'Physically', 'uploads/disability_certificate.pdf', '', '', NULL),
(36, 41, 'Sandhya', '2025-04-09', 'Warangal', 'Physically', 'uploads/TS EPASS APPLICATION.pdf', 'ICICI', 'IC1238F90', NULL),
(37, 42, 'Divya', '2025-04-09', 'Warangal', 'Visually Impaired', 'uploads/Mern Payment.pdf', 'ICICI', 'IC1238FD8', NULL),
(38, 44, 'Sony', '2025-04-09', 'SanathNagar', 'Physically', 'uploads/TS EPASS APPLICATION.pdf', 'Canara', 'CN04A5', NULL),
(39, 45, 'Janu', '2025-04-10', 'Warangal', 'Visually Impaired', 'uploads/Payment Status.pdf', 'Canara', 'CN04R7', NULL),
(40, 46, 'Saniya', '2025-04-15', 'Telangana Hyd', 'Visually Impaired', 'uploads/disability_certificate (8).pdf', 'SBI', 'SBI3402', 'Female'),
(41, 47, 'Madhu', '2025-04-14', 'Warangal', 'Hearing', 'uploads/disability_certificate (8).pdf', 'SBI', 'SBIRI890', 'male'),
(42, 49, 'Medha', '2025-04-16', 'Santhoshnagar', 'Visually Impaired', 'uploads/disability_certificate (6).pdf', 'Union', 'UN09987', 'Female'),
(43, 50, 'Manya', '2025-04-15', 'Telangana Hyd', 'Hearing', 'uploads/disability_certificate (5).pdf', 'Canara', 'CUYO8734', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `verifiers`
--

CREATE TABLE `verifiers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verifiers`
--

INSERT INTO `verifiers` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$Ry1Xp3If6v0zqKBbbyUyvuYAsEveB62BDbudXx14qgbjGJHQqTpoe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `demand_requests`
--
ALTER TABLE `demand_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_verifiers`
--
ALTER TABLE `product_verifiers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `profile_verifier`
--
ALTER TABLE `profile_verifier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `raw_material_requests`
--
ALTER TABLE `raw_material_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `verifiers`
--
ALTER TABLE `verifiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `demand_requests`
--
ALTER TABLE `demand_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_verifiers`
--
ALTER TABLE `product_verifiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_verifier`
--
ALTER TABLE `profile_verifier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `raw_material_requests`
--
ALTER TABLE `raw_material_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `verifiers`
--
ALTER TABLE `verifiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `demand_requests`
--
ALTER TABLE `demand_requests`
  ADD CONSTRAINT `demand_requests_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demand_requests_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_verifiers`
--
ALTER TABLE `product_verifiers`
  ADD CONSTRAINT `product_verifiers_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raw_material_requests`
--
ALTER TABLE `raw_material_requests`
  ADD CONSTRAINT `raw_material_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
