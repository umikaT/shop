CREATE TABLE `Addresses` (
  `address_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `country` varchar(56),
  `street` varchar(50),
  `home` char(4),
  `flat` char(3)
);

CREATE TABLE `UsersAddresses` (
  `address_id` int,
  `user_id` int
);

CREATE TABLE `Users` (
  `user_id` int PRIMARY KEY NOT NULL,
  `username` varchar(30),
  `first_name` varchar(26),
  `last_name` varchar(40),
  `email` varchar(254) UNIQUE,
  `dob` date CHECK(YEAR(dob)>=),
  `address` int,
  `phone` char(17),
  `password` varchar(20)
);

CREATE TABLE `Cart` (
  `cart_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int,
  `product` int
);

CREATE TABLE `Categories` (
  `category_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) UNIQUE NOT NULL,
  `category_desc` varchar(100)
);

CREATE TABLE `Suppliers` (
  `supplier_id` int PRIMARY KEY NOT NULL,
  `supplier_name` varchar(255),
  `supplier_address` varhcar,
  `supplier_phone` varchar(255),
  `supplier_NIP` varchar(255)
);

CREATE TABLE `Orders` (
  `order_id` int PRIMARY KEY NOT NULL,
  `purchaser_id` int,
  `shipping_method` int,
  `payment_id` int
);

CREATE TABLE `Payments` (
  `payment_id` int PRIMARY KEY NOT NULL,
  `order_id` int,
  `method` int
);

CREATE TABLE `OrdersProducts` (
  `order_id` int,
  `product_id` int
);

CREATE TABLE `Products` (
  `product_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `product_price` decimal(12.2) NOT NULL CHECK (product_price >=0),
  `product_category` int NOT NULL,
  `product_size` int,
  `supplier_name` varchar(60) NOT NULL,
  `description` varchar(255),
  `stock` int
);

CREATE TABLE `Delivery` (
  `delivery_id` int PRIMARY KEY NOT NULL,
  `delivery_method` varchar(25)
);

CREATE TABLE `PaymentMethods` (
  `MethodID` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `MethodName` varchar(20) NOT NULL
);

CREATE TABLE `CartProducts` (
  `product_id` int,
  `cart_id` int
);

CREATE TABLE `Sizes` (
  `size_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `SizeName` varchar(3) UNIQUE NOT NULL
);

CREATE TABLE `ProductSizes` (
  `size` int,
  `product` int
);

ALTER TABLE `Products` ADD FOREIGN KEY (`supplier_name`) REFERENCES `Suppliers` (`supplier_id`);

ALTER TABLE `Products` ADD FOREIGN KEY (`product_id`) REFERENCES `OrdersProducts` (`product_id`);

ALTER TABLE `Orders` ADD FOREIGN KEY (`order_id`) REFERENCES `OrdersProducts` (`order_id`);

ALTER TABLE `Users` ADD FOREIGN KEY (`user_id`) REFERENCES `Orders` (`purchaser_id`);

ALTER TABLE `Categories` ADD FOREIGN KEY (`category_id`) REFERENCES `Products` (`product_category`);

ALTER TABLE `Orders` ADD FOREIGN KEY (`shipping_method`) REFERENCES `Delivery` (`delivery_id`);

ALTER TABLE `Orders` ADD FOREIGN KEY (`payment_id`) REFERENCES `Payments` (`payment_id`);

ALTER TABLE `UsersAddresses` ADD FOREIGN KEY (`address_id`) REFERENCES `Addresses` (`address_id`);

ALTER TABLE `UsersAddresses` ADD FOREIGN KEY (`user_id`) REFERENCES `Users` (`address`);

ALTER TABLE `Payments` ADD FOREIGN KEY (`method`) REFERENCES `PaymentMethods` (`MethodID`);

ALTER TABLE `Cart` ADD FOREIGN KEY (`product`) REFERENCES `CartProducts` (`cart_id`);

ALTER TABLE `Cart` ADD FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

ALTER TABLE `Products` ADD FOREIGN KEY (`product_id`) REFERENCES `ProductSizes` (`product`);

ALTER TABLE `Products` ADD FOREIGN KEY (`product_id`) REFERENCES `CartProducts` (`product_id`);

ALTER TABLE `ProductSizes` ADD FOREIGN KEY (`size`) REFERENCES `Sizes` (`size_id`);
