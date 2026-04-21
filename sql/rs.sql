-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 06:45 AM
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
-- Database: `riverside_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method` varchar(20) NOT NULL DEFAULT 'Cash',
  `gcash_reference` varchar(50) DEFAULT NULL,
  `payment_screenshot` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) DEFAULT NULL,
  `change_amount` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_method`, `gcash_reference`, `payment_screenshot`, `total_amount`, `payment`, `change_amount`, `order_date`) VALUES
(1, 5, 'Cash', NULL, NULL, 130.00, NULL, NULL, '2026-04-20 01:52:18'),
(2, 5, 'Cash', NULL, NULL, 265.00, NULL, NULL, '2026-04-20 01:52:33'),
(3, 5, 'Cash', NULL, NULL, 110.00, NULL, NULL, '2026-04-20 02:34:02'),
(4, 5, 'Cash', NULL, NULL, 125.00, NULL, NULL, '2026-04-21 03:39:08');

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
(1, 1, 5, 1, 85.00),
(2, 1, 4, 1, 45.00),
(3, 2, 4, 1, 45.00),
(4, 2, 5, 1, 85.00),
(5, 2, 3, 1, 135.00),
(6, 3, 2, 1, 110.00),
(7, 4, 29, 1, 125.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `category`, `stock`, `image`) VALUES
(2, 'Cappuccino', 110.00, 'Coffee', 28, 'Cappuccino.jpg'),
(3, 'Spanish Latte', 135.00, 'Coffee', 24, 'Spanish Latte.jpg'),
(4, 'Chocolate Cookie', 45.00, 'Snacks', 12, 'Chocolate Cookie .jpg'),
(5, 'Clubhouse Sandwich', 85.00, 'Hot Coffee', 8, 'Clubhouse_Sandwich.jpg'),
(7, 'Hot Brewed Coffee', 49.00, 'Hot Coffee', 10, 'Hot_Brewed_Coffee.jpg'),
(8, 'Paa Combo (w/ Drinks)', 155.00, 'Hot Coffee', 23, 'paa combo.jpg'),
(9, 'Pecho Combo (w/ Drinks)', 185.00, 'Combo Meals', 20, 'Pecho Combo.png'),
(10, 'Fried Chicken Combo (w/ Drinks)', 125.00, 'Combo Meals', 20, 'Fried_Chicken.jpg'),
(11, 'Fried Porkchop Combo (w/ Drinks)', 130.00, 'Combo Meals', 20, 'Fried_Porkchop.jpg'),
(12, 'Pecho (No Drinks)', 105.00, 'Combo Meals', 20, 'Pecho.jpg'),
(13, 'Fried Chicken (No Drinks)', 110.00, 'Combo Meals', 20, 'Fried_Chicken_Solo.jpg'),
(14, 'Fried Porkchop (No Drinks)', 120.00, 'Combo Meals', 20, 'Fried_Porkchop_Solo.jpg'),
(15, 'Burger', 59.00, 'Burgers', 50, 'Burger(2).jpg'),
(16, 'Cheese Burger', 69.00, 'Burgers', 50, 'Cheese Burger.jpg'),
(17, 'Cheese Burger w/ Egg', 85.00, 'Burgers', 50, 'Cheese Burger wEgg.jpg'),
(18, 'Grilled Cheese', 50.00, 'Sandwiches', 30, 'Grilled Cheese.jpg'),
(19, 'Grilled Ham & Cheese', 65.00, 'Sandwiches', 30, 'Grilled Ham & Cheese.jpg'),
(20, 'Grilled Ham & Cheese w/ Egg', 80.00, 'Sandwiches', 30, 'Grilled Ham & Cheese wEgg.jpg'),
(21, 'Hotdog Sandwich', 50.00, 'Sandwiches', 30, 'Hotdog Sandwich (Even Long) .jpg'),
(22, 'Tapsilog', 85.00, 'Silog Meals', 25, 'Tapsilog.jpg'),
(23, 'Hamsilog', 40.00, 'Silog Meals', 25, 'Hamsilog.jpg'),
(24, 'Hotsilog', 15.00, 'Silog Meals', 25, 'Hotsilog.jpg'),
(25, 'Cornsilog', 69.00, 'Silog Meals', 25, 'Cornsilog.jpg'),
(26, 'Hotdog Silog', 70.00, 'Hot Coffee', 34, 'Hotdog silog.jpg'),
(27, 'Lumsilog', 85.00, 'Silog Meals', 25, 'lumsilog.jpg'),
(28, 'Porksilog', 125.00, 'Silog Meals', 25, 'Porksilog.jpg'),
(29, 'Chicksilog', 125.00, 'Silog Meals', 24, 'Chicksilog.jpg'),
(30, 'Burger w/ Fries Combo', 125.00, 'Combo Snacks', 15, 'WITH FREE Blue Lemonade Burger w Fries.jpg'),
(31, 'Hotdog w/ Fries Combo', 125.00, 'Combo Snacks', 15, 'WITH FREE Lemonade Hotdog w Fries.jpg'),
(32, 'Lumpia w/ Fries Combo', 115.00, 'Combo Snacks', 15, 'lumsilog.jpg'),
(33, 'Fries', 45.00, 'Favorites', 40, 'Fries.jpg'),
(34, 'Lumpia Shanghai', 60.00, 'Favorites', 40, 'Lumpia Shanghai.jpg'),
(35, 'Tacos', 69.00, 'Favorites', 30, 'Tacos.jpg'),
(36, 'Taco Fries', 95.00, 'Favorites', 30, 'Taco Fries.jpg'),
(37, 'Hawaiian 11\" Pizza', 199.00, 'Favorites', 10, 'Hawaiian 11 Pizza.jpeg'),
(38, 'Overload 11\" Pizza', 249.00, 'Favorites', 10, 'Overload 11 Pizza .jpg'),
(39, 'Bihon Guisado (4pax)', 120.00, 'Special Menu', 10, 'Biho Guisado.jpg'),
(40, 'Pancit Guisado (4pax)', 160.00, 'Special Menu', 10, 'Pancit Guisado.jpg'),
(41, 'Chicken Lomi', 160.00, 'Special Menu', 10, 'Chicken Lomi.jpg'),
(42, 'Brewed Coffee', 40.00, 'Hot Drinks', 50, 'Brewed Coffee.jpg'),
(43, 'Coffee w/ Milk', 45.00, 'Hot Drinks', 50, 'Coffee w Milk.jpg'),
(44, 'Hot Milo', 35.00, 'Hot Drinks', 50, 'Hot Milo .jpg'),
(45, 'Hot Milk', 30.00, 'Hot Drinks', 50, 'Hot Milk .webp'),
(46, '3 in 1 Coffee', 20.00, 'Hot Drinks', 100, '3 in 1 Coffee.jpg'),
(47, 'Iced Choco', 40.00, 'Refreshments', 40, 'Iced Choco.jpg'),
(48, 'Iced Coffee', 40.00, 'Hot Coffee', 4, 'Iced Coffee.jpg'),
(49, 'Bottled Water', 40.00, 'Refreshments', 50, 'Bottled_Water.jpg'),
(50, 'Soft Drinks', 25.00, 'Refreshments', 100, 'Soft Drinks (Mt. Dew, Pepsi, Tropicana, Sting)(1).jpg'),
(51, 'Lemonade Glass', 40.00, 'Refreshments', 34, 'Lemonade Glass .jpg'),


-- --------------------------------------------------------

--
-- Table structure for table `staff_logs`
--

CREATE TABLE `staff_logs` (
  `id` int(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `status` enum('On Duty','Out') DEFAULT 'On Duty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_logs`
--

INSERT INTO `staff_logs` (`id`, `staff_name`, `login_time`, `logout_time`, `duration`, `status`) VALUES
(1, 'Riverside Cafe Admin', '2026-04-20 09:45:28', '2026-04-20 09:45:49', '0 hrs 0 mins', 'Out'),
(2, 'Riverside Cafe Admin', '2026-04-20 09:45:43', '2026-04-20 10:13:43', '0 hrs 28 mins', 'Out'),
(3, 'Sabrina Carpenter', '2026-04-20 09:48:02', NULL, NULL, 'On Duty'),
(4, 'Riverside Cafe Admin', '2026-04-20 10:27:36', NULL, NULL, 'On Duty'),
(5, 'Riverside Cafe Admin', '2026-04-20 11:03:58', '2026-04-20 11:07:34', '0 hrs 3 mins', 'Out'),
(6, 'Riverside Cafe Admin', '2026-04-20 11:09:20', '2026-04-20 11:13:32', '0 hrs 4 mins', 'Out'),
(7, 'Riverside Cafe Admin', '2026-04-20 11:13:35', '2026-04-20 11:13:38', '0 hrs 0 mins', 'Out'),
(8, 'Riverside Cafe Admin', '2026-04-20 11:14:05', NULL, NULL, 'On Duty'),
(9, 'Riverside Cafe Admin', '2026-04-21 11:09:35', NULL, NULL, 'On Duty');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'staff',
  `duty_day` varchar(20) DEFAULT 'Not Set',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `duty_day`, `created_at`, `updated_at`) VALUES
(5, 'Riverside Cafe Admin', 'rs@gmail.com', '$2y$12$g3CM3sNi9ys9KdRC3t/T3O5sOFIBtKIkyoi6Vf2l6BIb/IX7WMdbi', 'admin', 'Everyday', '2026-04-20 01:45:21', '2026-04-20 01:45:21'),
(6, 'Ronelo Mabayag Dacillo', 'dacilloronelo@gmail.com', '$2y$12$86nVaeKSNfx5pMRDlBlcWeBtK7eMNob2oXHwe4AW1cxOwQe8Zo2/C', 'staff', 'Monday', '2026-04-20 01:45:21', '2026-04-20 01:45:21'),
(7, 'Mailen Salla Bulahan', 'mailen@gmail.com', '$2y$12$2hbZ791Ja30XiOPExCGrReBtsEFxoAReIDPzLbY6byV6jD0/6k9DK', 'staff', 'Tuesday', '2026-04-20 01:45:21', '2026-04-20 01:45:21'),
(8, 'Ralph romeo Agus ', 'agus@gmail.com', '$2y$12$lb.TmmjAQlgS/XYxD7celui2RjsIIKmmsmqXzMz7oAKpF6j9o1Hsa', 'staff', 'Wednesday', '2026-04-20 01:46:46', '2026-04-20 02:04:24'),
(9, 'Irish ann B. Adrias', 'irish@gmail.com', '$2y$12$Gme/cQnDynLUzJB8oC16o.uCaNVFnj9FyEs3MNDxL3St34TGAgskK', 'staff', 'Sunday', '2026-04-20 01:47:15', '2026-04-20 02:04:36'),
(10, 'Sabrina Carpenter', 'sabrina@gmail.com', '$2y$12$7oqbWFk4itZKG7wh80jai.EFOfOetJcoidagK934DoYHUZG1ogexe', 'staff', NULL, '2026-04-20 01:47:39', '2026-04-20 01:47:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gcash_reference` (`gcash_reference`),
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_logs`
--
ALTER TABLE `staff_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `staff_logs`
--
ALTER TABLE `staff_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_item` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_item` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
