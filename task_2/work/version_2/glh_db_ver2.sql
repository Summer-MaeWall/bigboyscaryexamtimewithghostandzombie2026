-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2026 at 09:52 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE `basket` (
  `basket_id` int NOT NULL,
  `product_id` int NOT NULL,
  `order_id` int NOT NULL,
  `quantity` int NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`basket_id`, `product_id`, `order_id`, `quantity`, `date`) VALUES
(1, 2, 1, 1, '2026-03-27'),
(2, 2, 2, 3, '2026-03-27'),
(4, 3, 1, 1, '2026-03-30'),
(5, 4, 2, 1, '2026-03-30'),
(6, 5, 2, 1, '2026-03-30'),
(7, 5, 3, 1, '2026-03-30'),
(8, 2, 6, 1, '2026-03-30'),
(9, 3, 6, 1, '2026-03-30'),
(10, 1, 7, 1, '2026-03-30'),
(11, 2, 7, 1, '2026-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `user_id` int NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `sign_up_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`user_id`, `email`, `password`, `sign_up_date`) VALUES
(1, 'test@test.com', '$2y$10$K3/LQsgWKwSPpnsv74UtzOotWZiPU4E7OyzJS3j1PfZC5KAYHkmqu', '2026-03-23'),
(2, 'emma.wilson@testmail.local', '$2y$10$6odMerJOf91WzApXWBKcRuQn5.hNo1V/JRhv4.PIsmXyLocOLPyGm', '2026-03-23'),
(3, 'james.carter@fakemail.site', '$2y$10$0Ew1uj4jtjNSGU41Z5P1PuXNFVTlIpUjs9sjked4SW9NcR7pHLP7m', '2026-03-25'),
(4, 'sophia.renolds@demo-example.com', '$2y$10$GO1eIIV1apEgWpiDVjlEKuLEY6rB/tLcVFVbI58xRale1SiT63WpK', '2026-03-25'),
(5, 'noahpatel@mockdata.org', '$2y$10$1wTTLzZxYmnoEvPoW00EbeS3Qup85hrQr63Hn2zJeoKluhtW5vX82', '2026-03-25');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` text NOT NULL,
  `delivery_date` date NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `type`, `delivery_date`, `order_date`) VALUES
(1, 1, 'del', '2026-03-29', '2026-03-27'),
(2, 1, 'del', '2026-03-29', '2026-03-27'),
(3, 1, 'del', '2026-04-26', '2026-03-30'),
(4, 1, 'col', '2026-03-31', '2026-03-30'),
(5, 1, 'col', '2026-04-01', '2026-03-30'),
(6, 1, 'col', '2026-04-01', '2026-03-30'),
(7, 1, 'col', '2026-04-25', '2026-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `farm` text NOT NULL,
  `image` text NOT NULL,
  `image_alt` text NOT NULL,
  `price` float NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `farm`, `image`, `image_alt`, `price`, `quantity`) VALUES
(1, 'Free-Range eggs (Large 6-pack)', '[INSERT DESCRIPTION HERE] ', 'GHF', 'assets/images/eggs.jpg', 'A picture of eggs sitting in a wire basket with straw, feathers and more eggs in the background ', 2.99, 48),
(2, 'Grass-Fed Beef Mince', '[INSERT DESCRIPTION HERE] ', 'SBP', 'assets/images/mince_beef.jpg', 'A picture of mince beef with a piece of thyme on top', 4.3, 35),
(3, 'Artisan Cheddar Cheese (200g)', '[INSERT DESCRIPTION HERE] ', 'WCD', 'assets/images/cheese.jpg', 'Blocks of cheddar cheese in a brown ceramic bowl', 3.5, 40),
(4, 'Homemade Beef Pie (400g)\r\n', '[INSERT DESCRIPTION HERE] ', 'HMF', 'assets/images/beef_pie.jpg', 'A slice of beef pie on a black plate', 5, 25),
(5, 'Fresh Sourdough Bread (500g)', '[INSERT DESCRIPTION HERE]', 'TTC', 'assets/images/sourdough.jpg', 'A picture of 2 loafs of sourdough bread on a wooden platter surrounded by pieces of thyme', 2.8, 30),
(6, 'Seasonal Apples (1kg)', '[INSERT DESCRIPTION HERE]', 'SRO', 'assets/images/apples.jpg', 'A picture of a bowl of apples in a backgarden surrounded by pinecones', 1.8, 60),
(7, 'Double Cream (300ml)', '[INSERT DESCRIPTION HERE] ', 'MTP', 'assets/images/cream.png', 'A bowl of whipped double cream ', 1.9, 45),
(8, 'Pork Sausages (1kg pack)\r\n', '[INSERT DESCRIPTION HERE] ', 'SBP', 'assets/images/sausages.jpg', 'A picture of four sausages lined up with  parsley accents ', 6.5, 33),
(9, 'Strawberry Jam (340g jar)\r\n', '[INSERT DESCRIPTION HERE]', 'BHF', 'assets/images/jam.jpg', 'A jar of strawberry jam with a strawberry in front of it on a blue tea towel', 3.2, 40),
(10, 'Roast Chicken (Whole)', '[INSERT DESCRIPTION HERE]', 'CFN', 'assets/images/chicken.jpg', 'A roasted Chickrn on a black platter with roasted tomatoes, aubergine and lemon', 8.99, 20);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int NOT NULL,
  `email` text NOT NULL,
  `type` text NOT NULL,
  `password` text NOT NULL,
  `sign_up_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_audit`
--

CREATE TABLE `staff_audit` (
  `audit_id` int NOT NULL,
  `staff_id` int NOT NULL,
  `code` text NOT NULL,
  `long_desc` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_audit`
--

CREATE TABLE `user_audit` (
  `audit_id` int NOT NULL,
  `user_id` int NOT NULL,
  `code` text NOT NULL,
  `long_desc` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_audit`
--

INSERT INTO `user_audit` (`audit_id`, `user_id`, `code`, `long_desc`, `date`) VALUES
(1, 5, 'reg', 'New user registered', '2026-03-25'),
(2, 2, 'log', 'User has successfully logged in', '2026-03-25'),
(3, 2, 'log', 'User has successfully logged in', '2026-03-25'),
(4, 2, 'log', 'User has successfully logged out', '2026-03-25'),
(5, 1, 'log', 'User has successfully logged in', '2026-03-25'),
(6, 1, 'log', 'User has successfully logged out', '2026-03-25'),
(7, 1, 'log', 'User has successfully logged in', '2026-03-27'),
(8, 1, 'log', 'User has successfully logged in', '2026-03-27'),
(9, 1, 'log', 'User has successfully logged in', '2026-03-27'),
(10, 1, 'log', 'User has successfully logged out', '2026-03-27'),
(11, 1, 'log', 'User has successfully logged in', '2026-03-27'),
(12, 1, 'log', 'User has successfully logged out', '2026-03-27'),
(13, 1, 'log', 'User has successfully logged in', '2026-03-27'),
(14, 2, 'log', 'User has successfully logged in', '2026-03-27'),
(15, 1, 'log', 'User has successfully logged in', '2026-03-27'),
(16, 1, 'log', 'User has successfully logged in', '2026-03-30'),
(17, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(18, 1, 'bas', 'User has successfully updated an items quantity in the basket', '2026-03-30'),
(19, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(20, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(21, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(22, 1, 'ord', 'User has successfully Placed an order', '2026-03-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`basket_id`),
  ADD KEY `product_id` (`product_id`,`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `staff_audit`
--
ALTER TABLE `staff_audit`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `user_audit`
--
ALTER TABLE `user_audit`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `basket_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_audit`
--
ALTER TABLE `staff_audit`
  MODIFY `audit_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_audit`
--
ALTER TABLE `user_audit`
  MODIFY `audit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_audit`
--
ALTER TABLE `staff_audit`
  ADD CONSTRAINT `staff_audit_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_audit`
--
ALTER TABLE `user_audit`
  ADD CONSTRAINT `user_audit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
