-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Värd: localhost
-- Tid vid skapande: 07 apr 2021 kl 10:11
-- Serverversion: 10.4.17-MariaDB
-- PHP-version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `Ecommerce`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `cartproduct_id` int(11) DEFAULT NULL,
  `cartuser_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_desc` varchar(500) NOT NULL,
  `price` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_desc`, `price`) VALUES
(11, 'car', 'blue', '20'),
(12, 'car2', 'blue2', '10'),
(13, 'car3', 'blue3', '15');

-- --------------------------------------------------------

--
-- Tabellstruktur `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `sessionuser_id` int(11) NOT NULL,
  `token` text NOT NULL,
  `last_used` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumpning av Data i tabell `sessions`
--

INSERT INTO `sessions` (`session_id`, `sessionuser_id`, `token`, `last_used`) VALUES
(32, 35, 'NjNiZTNhNDZkNjI0Yjg5MmFhNjEzMTdmNThlMzc1Mzg0MGQ3YzgyMDQyNGYxYWI0MTYxNzI3NTI0OQ==', '2021-04-01 14:07:29'),
(33, 35, 'OWJhNDRhMGZjMTIyZGE2ODU0Nzk4ZDhmOGY3OWIyNTA5YjdiMzEyYTgxMmYyZTQyMTYxNzI3Njg5MQ==', '2021-04-01 14:34:51'),
(34, 35, 'YTgzZDRhZGRkOWVkZGY3ZDQxYTc0MDdjM2Y5MWE3ODQzM2EzZjlhMmMwOTJiYjQzMTYxNzI3NzA1NQ==', '2021-04-01 14:37:35'),
(35, 35, 'YzI2MWZmMmIzODIxNTc1Y2FiODA4MDhiZWY4MWUxYWFmNzkyZGZiYzAwMjg4ZjBiMTYxNzI3NzA2NQ==', '2021-04-01 15:40:26'),
(36, 35, 'Nzc5NmJlNzhmZjg0ZWYwZDY3OGVkNTdhNjY5NDdkYzUyMjgyMWMzMzhlMjhhODkxMTYxNzcxNTE0NQ==', '2021-04-06 16:19:05');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_email`, `role`) VALUES
(35, 'tove', '$2y$10$FQKOY6RyRUMVTWIzJ71w4u6YxFgxwpMVT8JnWW15cKzqo7AwwJE5a', 'tove@tove.se', 'admin'),
(42, 'tove1', '$2y$10$mHo2bR2p.tjHHXjzw/.H8uE6y63ruPrrrbu6bX5LSvrmTxjf1kdeq', 'tove1@gmail.com', 'user'),
(48, 'tove2', '$2y$10$4iMxZqKXmLyEyzk3r0KdV.7DShQaLxcrSvtXqoxHuge.jwwVY4KOW', 'tove2@gmail.com', 'user');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cartproduct_id` (`cartproduct_id`),
  ADD KEY `cartuser_id` (`cartuser_id`);

--
-- Index för tabell `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Index för tabell `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `sessionuser_id` (`sessionuser_id`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT för tabell `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT för tabell `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`cartproduct_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`cartuser_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Restriktioner för tabell `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `session_id` FOREIGN KEY (`sessionuser_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
