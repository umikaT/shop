-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 08:42 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `country` varchar(56) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `home` char(4) DEFAULT NULL,
  `flat` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `country`, `street`, `home`, `flat`) VALUES
(1, 'Polska', 'dasd', '12', '12');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cartproducts`
--

CREATE TABLE `cartproducts` (
  `product_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_desc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_desc`) VALUES
(1, 'LOngsleeve', NULL),
(2, 'krotkie', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `delivery_method` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `purchaser_id` int(11) DEFAULT NULL,
  `shipping_method` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ordersproducts`
--

CREATE TABLE `ordersproducts` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `paymentmethods`
--

CREATE TABLE `paymentmethods` (
  `MethodID` int(11) NOT NULL,
  `MethodName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `method` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` decimal(12,0) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_size` int(11) DEFAULT NULL,
  `supplier_name` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `product_category`, `product_size`, `supplier_name`, `description`, `stock`, `image`, `product_image`) VALUES
(2, 'das', 123, 1, NULL, NULL, 'wqda', 12, NULL, '../assets/uploads/b1_1.png'),
(3, 'adaw', 23, 2, NULL, NULL, '123wdaw', 12, NULL, '../assets/uploads/b4_2.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `productsizes`
--

CREATE TABLE `productsizes` (
  `size` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `SizeName` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(75) DEFAULT NULL,
  `supplier_address` varchar(100) DEFAULT NULL,
  `supplier_phone` varchar(17) DEFAULT NULL,
  `supplier_NIP` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `first_name` varchar(26) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` int(11) DEFAULT NULL,
  `phone` char(17) DEFAULT NULL,
  `passwd` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `role` varchar(10) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `email`, `dob`, `address`, `phone`, `passwd`, `reset_token`, `reset_expires`, `role`) VALUES
(1, 'adam', NULL, NULL, 'dominikkasprowicz90@gmail.com', NULL, NULL, NULL, '$2y$10$QzvEgVuUFqk/L', '7a74a9f39f6700f7dd27f2970065b09e84a5fd1da01f2eaaf87c950a8cab2324', '2025-11-19 21:27:32', 'admin'),
(2, 'produkty', NULL, NULL, 'adam@op.pl', NULL, NULL, NULL, '$2y$10$17sJyCQQ66kYK', NULL, NULL, 'user'),
(3, 'Adam', NULL, NULL, 'dominikkasprowicz91@gmail.com', NULL, NULL, NULL, '$2y$10$7FUA9UI8ipFBs', NULL, NULL, 'user'),
(4, 'ela123', NULL, NULL, 'email@op.pl', NULL, NULL, NULL, '$2y$10$bI/NiEdgjgwvo', NULL, NULL, 'user'),
(5, 'WOJTEK', NULL, NULL, 'wojtek@op.pl', NULL, NULL, NULL, '$2y$10$yMmL2VAlW.ZBh', NULL, NULL, 'user'),
(6, 'ala', NULL, NULL, 'ala@op.pl', NULL, NULL, NULL, '$2y$10$xlg0VMMN1QCE0', NULL, NULL, 'user'),
(7, 'nikodem', NULL, NULL, 'nik@op.pl', NULL, NULL, NULL, '$2y$10$3Z7SRhlT3jon3', NULL, NULL, 'user'),
(8, 'ela', NULL, NULL, 'e@op.pl', NULL, NULL, NULL, '$2y$10$qy4TxJ23JGgbfVQSLpjs0uqhvnTdqHWBxda4h5m84AMkTOBE07aV2', NULL, NULL, 'user'),
(9, 'ada,', 'adam', 'adada', 'a@op.pl', NULL, NULL, '212321123', '$2y$10$rV4qlLG1YlfSzEELwKDVP.bX3AyxPNYgIHldJXwJEoFsjBPnEj2GG', NULL, NULL, 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `usersaddresses`
--

CREATE TABLE `usersaddresses` (
  `address_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usersaddresses`
--

INSERT INTO `usersaddresses` (`address_id`, `user_id`) VALUES
(1, 9);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indeksy dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_cart_user` (`user`);

--
-- Indeksy dla tabeli `cartproducts`
--
ALTER TABLE `cartproducts`
  ADD KEY `fk_cp_cart` (`cart_id`),
  ADD KEY `fk_cp_product` (`product_id`);

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indeksy dla tabeli `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_order_user` (`purchaser_id`),
  ADD KEY `fk_order_delivery` (`shipping_method`),
  ADD KEY `fk_order_payment` (`payment_id`);

--
-- Indeksy dla tabeli `ordersproducts`
--
ALTER TABLE `ordersproducts`
  ADD KEY `fk_op_order` (`order_id`),
  ADD KEY `fk_op_product` (`product_id`);

--
-- Indeksy dla tabeli `paymentmethods`
--
ALTER TABLE `paymentmethods`
  ADD PRIMARY KEY (`MethodID`);

--
-- Indeksy dla tabeli `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment_method` (`method`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_category` (`product_category`),
  ADD KEY `fk_product_supplier` (`supplier_name`);

--
-- Indeksy dla tabeli `productsizes`
--
ALTER TABLE `productsizes`
  ADD KEY `fk_ps_product` (`product`),
  ADD KEY `fk_ps_size` (`size`);

--
-- Indeksy dla tabeli `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`),
  ADD UNIQUE KEY `SizeName` (`SizeName`);

--
-- Indeksy dla tabeli `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `usersaddresses`
--
ALTER TABLE `usersaddresses`
  ADD KEY `fk_ua_user` (`user_id`),
  ADD KEY `fk_ua_address` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  MODIFY `MethodID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cartproducts`
--
ALTER TABLE `cartproducts`
  ADD CONSTRAINT `fk_cp_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `fk_cp_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_delivery` FOREIGN KEY (`shipping_method`) REFERENCES `delivery` (`delivery_id`),
  ADD CONSTRAINT `fk_order_payment` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`),
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`purchaser_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `ordersproducts`
--
ALTER TABLE `ordersproducts`
  ADD CONSTRAINT `fk_op_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `fk_op_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_method` FOREIGN KEY (`method`) REFERENCES `paymentmethods` (`MethodID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`product_category`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_product_supplier` FOREIGN KEY (`supplier_name`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `productsizes`
--
ALTER TABLE `productsizes`
  ADD CONSTRAINT `fk_ps_product` FOREIGN KEY (`product`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_ps_size` FOREIGN KEY (`size`) REFERENCES `sizes` (`size_id`);

--
-- Constraints for table `usersaddresses`
--
ALTER TABLE `usersaddresses`
  ADD CONSTRAINT `fk_ua_address` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`),
  ADD CONSTRAINT `fk_ua_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
