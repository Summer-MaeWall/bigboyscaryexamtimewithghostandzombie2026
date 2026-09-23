-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2026 at 10:07 AM
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
(10, 1, 7, -1, '2026-03-30'),
(11, 2, 7, 1, '2026-03-30'),
(12, 1, 8, -1, '2026-03-30'),
(13, 2, 8, 1, '2026-03-30'),
(14, 3, 8, 3, '2026-03-30'),
(15, 4, 8, 4, '2026-03-30'),
(16, 1, 9, -1, '2026-03-30'),
(17, 2, 9, 1, '2026-03-30'),
(18, 3, 9, 3, '2026-03-30'),
(19, 4, 9, 4, '2026-03-30'),
(20, 1, 10, -1, '2026-03-30'),
(21, 2, 10, 3, '2026-03-30'),
(22, 3, 10, 1, '2026-03-30'),
(23, 1, 11, 1, '2026-03-30'),
(24, 2, 11, 3, '2026-03-30'),
(25, 3, 11, 3, '2026-03-30'),
(26, 1, 12, 10, '2026-03-30'),
(27, 2, 12, 1, '2026-03-30'),
(28, 1, 13, 1, '2026-03-30'),
(29, 2, 13, 1, '2026-03-30'),
(30, 3, 13, 1, '2026-03-30'),
(31, 1, 14, 1, '2026-03-30'),
(32, 2, 14, 1, '2026-03-30'),
(33, 3, 14, 2, '2026-03-30'),
(34, 1, 15, 1, '2026-03-30'),
(35, 2, 15, 1, '2026-03-30'),
(36, 3, 15, 2, '2026-03-30'),
(39, 1, 20, 1, '2026-03-31'),
(40, 2, 20, 1, '2026-03-31'),
(41, 3, 20, 1, '2026-03-31'),
(42, 10, 20, 1, '2026-03-31'),
(53, 1, 25, 10, '2026-03-31'),
(54, 2, 25, 7, '2026-03-31'),
(55, 4, 25, 7, '2026-03-31'),
(56, 6, 25, 9, '2026-03-31'),
(57, 7, 25, 6, '2026-03-31'),
(68, 9, 31, 1, '2026-03-31'),
(73, 1, 36, 1, '2026-04-01'),
(74, 2, 36, 1, '2026-04-01'),
(75, 3, 36, 1, '2026-04-01'),
(77, 7, 38, 4, '2026-04-01'),
(78, 1, 39, 1, '2026-04-01'),
(79, 1, 40, 1, '2026-04-01'),
(80, 10, 41, 10, '2026-04-01');

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
(5, 'noahpatel@mockdata.org', '$2y$10$1wTTLzZxYmnoEvPoW00EbeS3Qup85hrQr63Hn2zJeoKluhtW5vX82', '2026-03-25'),
(6, 'test@email.com', '$2y$10$UOOCa2yvV1lLhT4K0fbeauViMHdgsj.roRpZgj/44MXUaSRuSlgEK', '2026-03-31'),
(7, 'normal@test.com', '$2y$10$C9Dpv3YFQU/AOm2cCKTT5uvsBAdGsESXPeiAGmP7b0ft7HQIkKGnq', '2026-04-01'),
(8, 'normal@test.com', '$2y$10$KGbNDxax1PjeoxYP/J6.z./RUS2SeBerCiWmcn2ZcFJo4piirUqU6', '2026-04-01'),
(9, 'normal@test.com', '$2y$10$5KdZlbWX37fllvoHK13q4Od5JADZ7l7NWNFWc.VrvSnicztQwdnEO', '2026-04-01'),
(10, 'verylongemailaddress_thatis_definitely_over_64_characters_long@example.com', '$2y$10$lA8gSl1CWQ.LTZr1MeWIxeutF4ElvClbQlyHzP790/uGG5cFT4XU2', '2026-04-01'),
(11, 'test@test.com', '$2y$10$8WjvquAZ8f74jbUPxFmMJuD5vLqEn3Sgdg.ebzNkG98g1FRE329UO', '2026-04-01'),
(12, 'test@test.com', '$2y$10$3rzvy7EQ0P5fsy/PI0hWF.0QRkHiq4eSf2RS8J8O1iwnP5jUHGwaG', '2026-04-01'),
(13, 'test@normal.com', '$2y$10$s7wuNt1tE.8HcPxjcPsf2.NYVoG1KmUzhrB/cR6h71/DYH0Frqxl6', '2026-04-01'),
(14, 'test@erroneous.com', '$2y$10$bo8B2sIUCi/pEhmZbI/CeuXSz9fA.PfGCMkJIl.AJ8koMVJjX0J.C', '2026-04-01'),
(15, 'test@extreme.com', '$2y$10$lRRNLkZDetVRycexQ5xPjuXzUg9crtUv/tZYDdLgp5Le6lkVNPOY2', '2026-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE `farms` (
  `farm_id` int NOT NULL,
  `farm_name` text NOT NULL,
  `farm_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `farms`
--

INSERT INTO `farms` (`farm_id`, `farm_name`, `farm_code`) VALUES
(1, 'Greenhollow Farms', 'GHF\r\n'),
(3, 'Sunroot Organics', 'SRO'),
(4, 'Meadow & Thistle Provisions\r\n', 'MTP'),
(5, 'Willow Creek Dairy & Co. ', 'WCD\r\n'),
(6, 'Harvest Moon Foods', 'HMF\r\n'),
(7, 'Stonebridge Pastures\r\n', 'SBP'),
(8, 'Golden Vale Produce\r\n', 'GVP'),
(9, 'Briar Hill Farms', 'BHF'),
(11, 'Clearfield Naturals\r\n', 'CFN'),
(12, 'Thorn & Till Co. ', 'TTC');

-- --------------------------------------------------------

--
-- Table structure for table `loyalty`
--

CREATE TABLE `loyalty` (
  `loyalty_id` int NOT NULL,
  `user_id` int NOT NULL,
  `points` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `loyalty`
--

INSERT INTO `loyalty` (`loyalty_id`, `user_id`, `points`) VALUES
(1, 6, 101),
(2, 7, 10),
(3, 7, 10),
(4, 10, 10),
(5, 1, 10),
(6, 13, 118),
(7, 14, 10),
(8, 15, 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` text NOT NULL,
  `total` float NOT NULL,
  `delivery_date` date NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `type`, `total`, `delivery_date`, `order_date`) VALUES
(1, 1, 'del', 0, '2026-03-29', '2026-03-27'),
(2, 1, 'del', 0, '2026-03-29', '2026-03-27'),
(3, 1, 'del', 0, '2026-04-26', '2026-03-30'),
(4, 1, 'col', 0, '2026-03-31', '2026-03-30'),
(5, 1, 'col', 0, '2026-04-01', '2026-03-30'),
(6, 1, 'col', 0, '2026-04-01', '2026-03-30'),
(7, 1, 'col', 0, '2026-04-25', '2026-03-30'),
(8, 1, 'del', 0, '2026-04-16', '2026-03-30'),
(9, 1, 'col', 0, '2026-04-16', '2026-03-30'),
(10, 1, 'del', 0, '2026-04-15', '2026-03-30'),
(11, 1, 'del', 0, '2026-04-15', '2026-03-30'),
(12, 1, 'del', 0, '2026-04-16', '2026-03-30'),
(13, 1, 'del', 0, '2026-04-02', '2026-03-30'),
(14, 1, 'del', 0, '2026-03-31', '2026-03-30'),
(15, 1, 'del', 0, '2026-03-31', '2026-03-30'),
(20, 6, 'del', 19.78, '2026-03-27', '2026-03-31'),
(25, 6, 'del', 122.6, '2026-03-26', '2026-03-31'),
(31, 6, 'del', 3.2, '2026-03-11', '2026-03-31'),
(36, 13, 'del', 10.79, '2026-04-03', '2026-04-01'),
(38, 13, 'col', 7.6, '2026-01-16', '2026-04-01'),
(39, 13, 'col', 2.99, '2026-04-09', '2026-04-01'),
(40, 13, 'col', 2.99, '2026-04-09', '2026-04-01'),
(41, 6, 'col', 89.9, '2026-04-08', '2026-04-01');

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
(1, 'Free-Range eggs (Large 6-pack)', '[INSERT DESCRIPTION HERE] ', 'GHF', 'assets/images/eggs.jpg', 'A picture of eggs sitting in a wire basket with straw, feathers and more eggs in the background ', 2.99, 21),
(2, 'Grass-Fed Beef Mince', '[INSERT DESCRIPTION HERE] ', 'SBP', 'assets/images/mince_beef.jpg', 'A picture of mince beef with a piece of thyme on top', 4.3, 22),
(3, 'Artisan Cheddar Cheese (200g)', '[INSERT DESCRIPTION HERE] ', 'WCD', 'assets/images/cheese.jpg', 'Blocks of cheddar cheese in a brown ceramic bowl', 3.5, 33),
(4, 'Homemade Beef Pie (400g)\r\n', '[INSERT DESCRIPTION HERE] ', 'HMF', 'assets/images/beef_pie.jpg', 'A slice of beef pie on a black plate', 5, 18),
(5, 'Fresh Sourdough Bread (500g)', '[INSERT DESCRIPTION HERE]', 'TTC', 'assets/images/sourdough.jpg', 'A picture of 2 loafs of sourdough bread on a wooden platter surrounded by pieces of thyme', 2.8, 28),
(6, 'Seasonal Apples (1kg)', '[INSERT DESCRIPTION HERE]', 'SRO', 'assets/images/apples.jpg', 'A picture of a bowl of apples in a backgarden surrounded by pinecones', 1.8, 51),
(7, 'Double Cream (300ml)', '[INSERT DESCRIPTION HERE] ', 'MTP', 'assets/images/cream.png', 'A bowl of whipped double cream ', 1.9, 26),
(8, 'Pork Sausages (1kg pack)\r\n', '[INSERT DESCRIPTION HERE] ', 'SBP', 'assets/images/sausages.jpg', 'A picture of four sausages lined up with  parsley accents ', 6.5, 27),
(9, 'Strawberry Jam (340g jar)\r\n', '[INSERT DESCRIPTION HERE]', 'BHF', 'assets/images/jam.jpg', 'A jar of strawberry jam with a strawberry in front of it on a blue tea towel', 3.2, 36),
(10, 'Roast Chicken (Whole)', '[INSERT DESCRIPTION HERE]', 'CFN', 'assets/images/chicken.jpg', 'A roasted Chickrn on a black platter with roasted tomatoes, aubergine and lemon', 8.99, 0),
(11, 'fresh Baguette', '[INSERT DESCRIPTION HERE]', 'GVP', 'assets/images/baguette.png', 'a fresh baguette', 2.3, 25);

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

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `email`, `type`, `password`, `sign_up_date`) VALUES
(1, 'test@greenfield.com', 'adm', '$2y$10$Ht/6p6SFMMrkWK7qJXrsk.NXvNDo5tY0Y40uW3DI.d8ZDQf5J6g2W', '2026-04-01'),
(2, 'store@greenfield.com', 'sto', '$2y$10$vQY5Xz8lQkOa83tX5QgVD.PfgsPjTywomy/fp3qrzNAwB6..eg3A2', '2026-04-01');

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

--
-- Dumping data for table `staff_audit`
--

INSERT INTO `staff_audit` (`audit_id`, `staff_id`, `code`, `long_desc`, `date`) VALUES
(1, 1, 'log', 'User has successfully logged in', '2026-04-01'),
(2, 1, 'reg', 'New staff account created', '2026-04-01'),
(3, 1, 'log', 'User has successfully logged out', '2026-04-01'),
(4, 1, 'log', 'User has successfully logged in', '2026-04-01'),
(5, 1, 'log', 'User has successfully logged out', '2026-04-01'),
(6, 1, 'log', 'User has successfully logged in', '2026-04-01'),
(7, 1, 'log', 'User has successfully logged in', '2026-04-01'),
(8, 1, 'log', 'User has successfully logged out', '2026-04-01'),
(9, 2, 'log', 'User has successfully logged in', '2026-04-01'),
(10, 2, 'log', 'User has successfully logged in', '2026-04-01'),
(11, 2, 'log', 'User has successfully logged out', '2026-04-01'),
(12, 1, 'log', 'User has successfully logged in', '2026-04-01'),
(13, 1, 'log', 'User has successfully logged in', '2026-04-01'),
(14, 1, 'log', 'User has successfully logged in', '2026-04-02'),
(15, 1, 'pro', 'User has added a new product', '2026-04-02'),
(16, 1, 'bas', 'User has successfully added an item to basket', '2026-04-02'),
(17, 1, 'pro', 'User has successfully updated product quantity', '2026-04-02'),
(18, 1, 'log', 'User has successfully logged out', '2026-04-02'),
(19, 2, 'log', 'User has successfully logged in', '2026-04-02'),
(20, 2, 'log', 'User has successfully logged in', '2026-04-02'),
(21, 2, 'log', 'User has successfully logged out', '2026-04-02'),
(22, 1, 'log', 'User has successfully logged in', '2026-04-02'),
(23, 1, 'log', 'User has successfully logged in', '2026-04-02'),
(24, 1, 'log', 'User has successfully logged out', '2026-04-02'),
(25, 1, 'log', 'User has successfully logged in', '2026-04-02'),
(26, 1, 'log', 'User has successfully logged out', '2026-04-02');

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
(22, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(23, 1, 'log', 'User has successfully logged out', '2026-03-30'),
(24, 1, 'log', 'User has successfully logged in', '2026-03-30'),
(25, 1, 'log', 'User has successfully logged out', '2026-03-30'),
(26, 1, 'log', 'User has successfully logged in', '2026-03-30'),
(27, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(28, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(29, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(30, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(31, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(32, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(33, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(34, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(35, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(36, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(37, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(38, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(39, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(40, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(41, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(42, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(43, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(44, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(45, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(46, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(47, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(48, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(49, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(50, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(51, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(52, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(53, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(54, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(55, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(56, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(57, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(58, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(59, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(60, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(61, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(62, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(63, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(64, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(65, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(66, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(67, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(68, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(69, 1, 'log', 'User has successfully logged out', '2026-03-30'),
(70, 1, 'log', 'User has successfully logged in', '2026-03-30'),
(71, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(72, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(73, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(74, 1, 'log', 'User has successfully logged in', '2026-03-30'),
(75, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(76, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(77, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(78, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(79, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(80, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(81, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(82, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(83, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(84, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(85, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(86, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(87, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(88, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(89, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(90, 1, 'ord', 'User has successfully Placed an order', '2026-03-30'),
(91, 1, 'bas', 'User has successfully added an item to basket', '2026-03-30'),
(92, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-30'),
(93, 1, 'log', 'User has successfully logged in', '2026-03-31'),
(94, 1, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(95, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-31'),
(96, 1, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(97, 1, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(98, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-31'),
(99, 1, 'bas', 'User has successfully updated an items quantity in the basket', '2026-03-31'),
(100, 1, 'bas', 'User has successfully updated an items quantity in the basket', '2026-03-31'),
(101, 1, 'bas', 'User has successfully removed an item from basket', '2026-03-31'),
(102, 1, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(103, 1, 'log', 'User has successfully logged out', '2026-03-31'),
(104, 6, 'reg', 'New user registered', '2026-03-31'),
(105, 6, 'log', 'User has successfully logged in', '2026-03-31'),
(106, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(107, 6, 'bas', 'User has successfully updated an items quantity in the basket', '2026-03-31'),
(108, 6, 'bas', 'User has successfully updated an items quantity in the basket', '2026-03-31'),
(109, 6, 'bas', 'User has successfully updated an items quantity in the basket', '2026-03-31'),
(110, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(111, 6, 'log', 'User has successfully logged out', '2026-03-31'),
(112, 1, 'log', 'User has successfully logged in', '2026-03-31'),
(113, 1, 'log', 'User has successfully logged out', '2026-03-31'),
(114, 1, 'log', 'User has successfully logged in', '2026-03-31'),
(115, 1, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(116, 1, 'log', 'User has successfully logged out', '2026-03-31'),
(117, 6, 'log', 'User has successfully logged in', '2026-03-31'),
(118, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(119, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(120, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(121, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(122, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(123, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(124, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(125, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(126, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(127, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(128, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(129, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(130, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(131, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(132, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(133, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(134, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(135, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(136, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(137, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(138, 6, 'bas', 'User has successfully updated an items quantity in the basket', '2026-03-31'),
(139, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(140, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(141, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(142, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(143, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(144, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(145, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(146, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(147, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(148, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(149, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(150, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(151, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(152, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(153, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(154, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(155, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(156, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(157, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(158, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(159, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(160, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(161, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(162, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(163, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(164, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(165, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(166, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(167, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(168, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(169, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(170, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(171, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(172, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(173, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(174, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(175, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(176, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(177, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(178, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(179, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(180, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(181, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(182, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(183, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(184, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(185, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(186, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(187, 6, 'bas', 'User has successfully added an item to basket', '2026-03-31'),
(188, 6, 'ord', 'User has successfully Placed an order', '2026-03-31'),
(189, 6, 'ord', 'User has successfully cancelled order.', '2026-03-31'),
(190, 7, 'reg', 'New user registered', '2026-04-01'),
(191, 7, 'reg', 'New user registered', '2026-04-01'),
(192, 10, 'reg', 'New user registered', '2026-04-01'),
(193, 1, 'reg', 'New user registered', '2026-04-01'),
(194, 7, 'log', 'User has successfully logged in', '2026-04-01'),
(195, 7, 'log', 'User has successfully logged out', '2026-04-01'),
(196, 10, 'log', 'User has successfully logged in', '2026-04-01'),
(197, 10, 'log', 'User has successfully logged out', '2026-04-01'),
(198, 13, 'reg', 'New user registered', '2026-04-01'),
(199, 13, 'log', 'User has successfully logged in', '2026-04-01'),
(200, 14, 'reg', 'New user registered', '2026-04-01'),
(201, 15, 'reg', 'New user registered', '2026-04-01'),
(202, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(203, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(204, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(205, 13, 'ord', 'User has successfully Placed an order', '2026-04-01'),
(206, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(207, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(208, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(209, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(210, 13, 'bas', 'User has successfully removed an item from basket', '2026-04-01'),
(211, 13, 'bas', 'User has successfully removed an item from basket', '2026-04-01'),
(212, 13, 'bas', 'User has successfully removed an item from basket', '2026-04-01'),
(213, 13, 'bas', 'User has successfully removed an item from basket', '2026-04-01'),
(214, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(215, 13, 'ord', 'User has successfully Placed an order', '2026-04-01'),
(216, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(217, 13, 'ord', 'User has successfully Placed an order', '2026-04-01'),
(218, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(219, 13, 'ord', 'User has successfully Placed an order', '2026-04-01'),
(220, 13, 'ord', 'User has successfully cancelled order.', '2026-04-01'),
(221, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(222, 13, 'ord', 'User has successfully Placed an order', '2026-04-01'),
(223, 13, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(224, 6, 'log', 'User has successfully logged in', '2026-04-01'),
(225, 6, 'bas', 'User has successfully added an item to basket', '2026-04-01'),
(226, 6, 'ord', 'User has successfully Placed an order', '2026-04-01'),
(227, 13, 'log', 'User has successfully logged out', '2026-04-01'),
(228, 1, 'log', 'User has successfully logged in', '2026-04-02');

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
-- Indexes for table `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`farm_id`);

--
-- Indexes for table `loyalty`
--
ALTER TABLE `loyalty`
  ADD PRIMARY KEY (`loyalty_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `basket_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `farms`
--
ALTER TABLE `farms`
  MODIFY `farm_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `loyalty`
--
ALTER TABLE `loyalty`
  MODIFY `loyalty_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_audit`
--
ALTER TABLE `staff_audit`
  MODIFY `audit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_audit`
--
ALTER TABLE `user_audit`
  MODIFY `audit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

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
