-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2019. Nov 11. 10:30
-- Kiszolgáló verziója: 10.4.6-MariaDB
-- PHP verzió: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `live`
--
CREATE DATABASE IF NOT EXISTS `live` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `live`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `acls`
--

CREATE TABLE `acls` (
  `id` int(11) NOT NULL,
  `user_level` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `acls`
--

INSERT INTO `acls` (`id`, `user_level`) VALUES
(1, '[\"Admin\"]'),
(2, '\"Registered\"'),
(3, '\"seller\"');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(155) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`, `deleted`) VALUES
(2, 'Catan Studios', '2019-11-07 22:10:56', 2019, 0),
(14, 'Catan Studios1', '2019-11-08 09:13:52', 2019, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `description` text COLLATE utf8_hungarian_ci DEFAULT NULL,
  `body` text COLLATE utf8_hungarian_ci NOT NULL,
  `vendor` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid_increment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `created_at`, `update_at`, `name`, `description`, `body`, `vendor`, `brand_id`, `list_price`, `price`, `shipping`, `featured`, `deleted`, `user_id`, `bid_increment`) VALUES
(12, '2019-11-05 13:59:37', '2019-11-08 13:44:47', 'Catan', NULL, '&lt;p&gt;Catasdn egy kurva jo jatek ezt nekem elhihetitek.&lt;/p&gt;', NULL, 2, '5.99', '11.99', '3.00', 0, 0, 1, NULL),
(25, '2019-11-06 18:36:49', NULL, 'Nike cipÅ‘', NULL, '&lt;p&gt;Ez egy nagyon szep cipo, esoben ,hoban mindenben hasznalhato.&lt;/p&gt;', NULL, NULL, '10.00', '10.55', '1.00', 0, 1, 1, NULL),
(26, '2019-11-06 18:49:22', NULL, 'Nike cipÅ‘', NULL, '&lt;p&gt;Ez egy nagyon szep cipo, esoben ,hoban mindenben hasznalhato.&lt;/p&gt;', NULL, NULL, '10.00', '10.55', '1.00', 0, 1, 1, NULL),
(27, '2019-11-07 08:04:09', NULL, 'delete me', NULL, '&lt;p&gt;sdfghjkl&amp;eacute;-&lt;/p&gt;', NULL, NULL, '12.00', '12.00', '12.00', 0, 1, 1, NULL),
(28, '2019-11-07 08:05:01', NULL, 'delete me', NULL, '&lt;p&gt;sdfghjkl&amp;eacute;-&lt;/p&gt;', NULL, NULL, '12.00', '12.00', '12.00', 0, 1, 1, NULL),
(29, '2019-11-07 08:08:36', NULL, 'delete me', NULL, '&lt;p&gt;sdfghjkl&amp;eacute;-&lt;/p&gt;', NULL, NULL, '12.00', '12.00', '12.00', 0, 1, 1, NULL),
(30, '2019-11-07 08:09:14', NULL, 'delete me', NULL, '&lt;p&gt;sdfghjkl&amp;eacute;-&lt;/p&gt;', NULL, NULL, '12.00', '12.00', '12.00', 0, 1, 1, NULL),
(31, '2019-11-07 08:09:49', NULL, 'delete me', NULL, '&lt;p&gt;asdsdsadsadsad&lt;/p&gt;', NULL, NULL, '1234.00', '123.00', '234.00', 0, 1, 1, NULL),
(33, '2019-11-07 09:27:38', NULL, 'delete images', NULL, '&lt;p&gt;dsfdfdfdfdfdfdfdf&lt;/p&gt;', NULL, NULL, '10.00', '1.00', '1.00', 0, 1, 1, NULL),
(34, '2019-11-07 09:37:20', NULL, 'Dr&aacute;cz Istv&aacute;n', NULL, '&lt;p&gt;sdsdsdsdsd&lt;/p&gt;', NULL, NULL, '111.00', '111.00', '11.00', 0, 1, 1, NULL),
(35, '2019-11-07 09:58:32', NULL, 'delete', NULL, '&lt;p&gt;sdsdsdsd&lt;/p&gt;', NULL, NULL, '21.00', '1.00', '1.00', 0, 1, 1, NULL),
(36, '2019-11-07 15:09:46', NULL, 'Utazas', NULL, '&lt;p&gt;Ez egy utazas amire mindenki kivancsi&lt;/p&gt;', NULL, NULL, '100.00', '100.00', '10.00', 0, 1, 1, NULL),
(37, '2019-11-08 13:36:13', NULL, 'Utazas', NULL, '&lt;p&gt;Ez egy utazas amit megvasarolhatsz&lt;/p&gt;', NULL, 14, '100.00', '100.00', '10.00', 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  `fname` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  `lname` varchar(150) COLLATE utf8_hungarian_ci NOT NULL,
  `acl` text COLLATE utf8_hungarian_ci DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT 0,
  `belepes_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fname`, `lname`, `acl`, `deleted`, `belepes_at`) VALUES
(1, 'draczi', 'istvan.dracz@gmail.com', '$2y$10$cLwJqj/naZ2oFb5px.EwLuh0JHhWPbTRo.eFERgZg/GLGS/5Z6o4O', 'Istvan', 'Dracz', '[\"Admin\"]', 0, '2019-11-10 23:08:20'),
(9, 'kovacs', 'balats@gmail.com', '$2y$10$BbwdhtCO.lQrTZJqSQ5Rl.Gqw//n9aIdHy0ZHh9/a2kf3RcnP5h.i', 'Istvan', 'Kovacs', '1', 0, '2019-11-10 23:34:06');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users_sessions`
--

CREATE TABLE `users_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `acls`
--
ALTER TABLE `acls`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- A tábla indexei `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deleted` (`deleted`),
  ADD KEY `vendor` (`vendor`),
  ADD KEY `brand` (`brand_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `featured` (`featured`);

--
-- A tábla indexei `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sort` (`sort`),
  ADD KEY `product_id` (`product_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `acls`
--
ALTER TABLE `acls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT a táblához `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `users_sessions`
--
ALTER TABLE `users_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Megkötések a táblához `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Megkötések a táblához `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
