-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2021 at 07:40 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dejabrew`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `itemId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`itemId`, `productId`, `orderId`, `quantity`, `totalPrice`) VALUES
(45, 62, 48, 2, 540),
(46, 63, 48, 2, 540),
(47, 63, 49, 2, 540),
(48, 64, 49, 2, 300);

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `foodId` int(11) NOT NULL,
  `foodName` varchar(25) NOT NULL,
  `price` int(255) NOT NULL,
  `foodType` varchar(255) NOT NULL,
  `badge` text NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`foodId`, `foodName`, `price`, `foodType`, `badge`, `image`) VALUES
(62, 'Mint muffins', 270, 'pastry', '6 pack', 'izabela-rutkowski-NGRK_2sv8H8-unsplash.jpg'),
(63, 'Vanilla latte', 270, 'coffee', ' ', 'vanilla latte.jpg'),
(64, 'Lemon cake', 150, 'pastry', 'per slice', 'alexandra-golovac--Qe0rpF2ThY-unsplash.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(50) NOT NULL,
  `grandTotal` int(100) NOT NULL,
  `date/time` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(220) NOT NULL DEFAULT 'pending',
  `userId` int(11) NOT NULL,
  `cartId` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `grandTotal`, `date/time`, `status`, `userId`, `cartId`) VALUES
(48, 1080, '2020-11-29', 'completed', 92, '921606677557'),
(49, 840, '2020-11-29', 'pending', 91, '911606677637');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNumber` int(10) NOT NULL,
  `userType` varchar(10) NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstName`, `lastName`, `email`, `password`, `phoneNumber`, `userType`) VALUES
(37, 'ratty', 'Gyel', 'rattygyel@hotmail.com', 'blue23', 7898989, 'admin'),
(38, 'Dorine', 'Otanga', 'DorineOtanga@gmail.com', 'blvck', 723489774, 'client'),
(40, 'Ezra', 'Ndanyi', 'ezndanyi@gmail.com', 'sumsit56', 7457812, 'client'),
(82, 'Priscilla', 'Naliaka', 'pnalis@gmail.com', 'nalis', 7898989, 'admin'),
(86, 'Ian', 'Ibrahim', 'ianokova@gmail.com', 'ibra78', 758170781, 'admin'),
(87, 'Priscah ', 'Njeri', 'Prinyo2@gmail.com', 'rastarasta', 712345678, 'client'),
(88, 'Tiffany', 'Karori', 'Tiffo@gmail.com', 'breezy', 707216734, 'client'),
(89, 'ian', 'Okova', 'ian@gmail.com', '13362', 758170781, 'client'),
(91, 'Kimberly', 'Kamau', 'kim@gmail.com', 'light78', 7898989, 'client'),
(92, 'Gloria', 'Sumi', 'sum@hotmail.com', 'Nairobi@2013', 758170781, 'client'),
(93, 'Dennis', 'Ndinda', 'Dndinda@gmail.com', 'love23', 758170781, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`itemId`),
  ADD KEY `productId` (`productId`),
  ADD KEY `orderId` (`orderId`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`foodId`),
  ADD UNIQUE KEY `foodName` (`foodName`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `foodId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `food` (`foodId`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
