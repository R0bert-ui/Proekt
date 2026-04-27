-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 27 2026 г., 06:32
-- Версия сервера: 5.7.39
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `car_dealership`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`id`, `car_id`, `user_id`, `full_name`, `phone`, `email`, `comment`, `status`, `created_at`) VALUES
(1, 5, 22, 'полное имя', '7 777 777 77 77', 'Primer2@mail.ru', 'коммент', 'approved', '2026-03-30 10:56:00');

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `mileage` int(11) NOT NULL,
  `gearbox` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `popularity` int(11) DEFAULT '0',
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `price`, `mileage`, `gearbox`, `fuel`, `popularity`, `photo_url`, `created_at`, `status`) VALUES
(2, 'BMW', 'X5 G05', 2020, '42000000.00', 55000, 'Автомат', 'Дизель', 88, 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800', '2026-03-16 04:00:00', 'available'),
(3, 'Mercedes-Benz', 'E-Class W213', 2019, '24500000.00', 70000, 'Автомат', 'Бензин', 82, NULL, '2026-03-16 04:00:00', 'available'),
(4, 'Lexus', 'RX 300', 2018, '21000000.00', 85000, 'Автомат', 'Бензин', 90, 'https://iat.ru/uploads/origin/models/272233/1.webp', '2026-03-16 04:00:00', 'available'),
(5, 'Hyundai', 'Elantra', 2022, '11500000.00', 25000, 'Автомат', 'Бензин', 75, 'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?auto=format&fit=crop&w=800', '2026-03-16 04:00:00', 'available'),
(6, 'Kia', 'Sportage', 2021, '13800000.00', 38000, 'Автомат', 'Бензин', 85, 'https://media.ixbt.site/fit-in/1066x600/https://www.ixbt.com/img/n1/news/2021/5/2/hb0v8h0b0dwv2ndvlcwl_large.png', '2026-03-16 04:00:00', 'available'),
(7, 'Audi', 'A6', 2017, '14200000.00', 95000, 'Автомат', 'Бензин', 65, 'https://images.unsplash.com/photo-1606152421802-db97b9c7a11b?auto=format&fit=crop&w=800', '2026-03-16 04:00:00', 'sold'),
(8, 'Toyota', 'Land Cruiser 300', 2022, '58000000.00', 15000, 'Автомат', 'Дизель', 100, 'https://iat.ru/uploads/origin/models/2047797/2.jpg', '2026-03-16 04:00:00', 'available'),
(9, 'Volkswagen', 'Polo', 2020, '8200000.00', 60000, 'Автомат', 'Бензин', 70, 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=800', '2026-03-16 04:00:00', 'available'),
(10, 'Tesla', 'Model 3', 2021, '18500000.00', 32000, 'Автомат', 'Электро', 80, 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800', '2026-03-16 04:00:00', 'available'),
(14, 'Toyota', 'Camry', 2023, '15000000.00', 25000, 'Автомат', 'Бензин', 951, NULL, '2026-04-06 03:54:37', 'available'),
(15, 'BMW', 'X5', 2022, '45000000.00', 45000, 'Автомат', 'Дизель', 88, 'https://picsum.photos/seed/2/600/400', '2026-04-06 03:54:37', 'available'),
(16, 'Mercedes-Benz', 'E-Class', 2021, '35000000.00', 55000, 'Автомат', 'Бензин', 92, NULL, '2026-04-06 03:54:37', 'available'),
(17, 'Audi', 'A6', 2020, '28000000.00', 65000, 'Автомат', 'Дизель', 85, 'https://picsum.photos/seed/4/600/400', '2026-04-06 03:54:37', 'available'),
(18, 'Kia', 'Sportage', 2023, '12000000.00', 15000, 'Автомат', 'Бензин', 80, 'https://picsum.photos/seed/5/600/400', '2026-04-06 03:54:37', 'available'),
(19, 'Hyundai', 'Elantra', 2022, '9500000.00', 30000, 'Автомат', 'Бензин', 75, 'https://picsum.photos/seed/6/600/400', '2026-04-06 03:54:37', 'available'),
(20, 'Lexus', 'RX', 2021, '32000000.00', 40000, 'Автомат', 'Гибрид', 90, 'https://picsum.photos/seed/7/600/400', '2026-04-06 03:54:37', 'available'),
(21, 'Volkswagen', 'Passat', 2020, '18000000.00', 70000, 'Механика', 'Бензин', 999, NULL, '2026-04-06 03:54:37', 'available'),
(22, 'Ford', 'Focus', 2022, '10000000.00', 35000, 'Автомат', 'Бензин', 72, 'https://picsum.photos/seed/9/600/400', '2026-04-06 03:54:37', 'available'),
(23, 'Honda', 'Civic', 2021, '11000000.00', 40000, 'Автомат', 'Бензин', 82, 'https://picsum.photos/seed/10/600/400', '2026-04-06 03:54:37', 'available'),
(24, 'Mazda', 'CX-5', 2023, '16000000.00', 20000, 'Автомат', 'Бензин', 87, 'https://picsum.photos/seed/11/600/400', '2026-04-06 03:54:37', 'available'),
(25, 'Nissan', 'Qashqai', 2022, '13500000.00', 38000, 'Автомат', 'Бензин', 81, 'https://picsum.photos/seed/12/600/400', '2026-04-06 03:54:37', 'available'),
(26, 'Volvo', 'XC60', 2021, '26000000.00', 50000, 'Автомат', 'Дизель', 89, 'https://picsum.photos/seed/13/600/400', '2026-04-06 03:54:37', 'available'),
(27, 'Subaru', 'Outback', 2020, '20000000.00', 60000, 'Автомат', 'Бензин', 83, 'https://picsum.photos/seed/14/600/400', '2026-04-06 03:54:37', 'available'),
(28, 'Porsche', '911', 2019, '65000000.00', 75000, 'Автомат', 'Бензин', 98, 'https://picsum.photos/seed/15/600/400', '2026-04-06 03:54:37', 'available'),
(29, 'Tesla', 'Model 3', 2023, '22000000.00', 5000, 'Автомат', 'Электричество', 99, 'https://picsum.photos/seed/16/600/400', '2026-04-06 03:54:37', 'available'),
(30, 'Chevrolet', 'Cruze', 2021, '8500000.00', 55000, 'Механика', 'Бензин', 68, 'https://picsum.photos/seed/17/600/400', '2026-04-06 03:54:37', 'available'),
(31, 'Jeep', 'Wrangler', 2022, '24000000.00', 45000, 'Механика', 'Бензин', 86, 'https://picsum.photos/seed/18/600/400', '2026-04-06 03:54:37', 'available'),
(32, 'Range Rover', 'Discovery', 2020, '38000000.00', 70000, 'Автомат', 'Дизель', 91, 'https://picsum.photos/seed/19/600/400', '2026-04-06 03:54:37', 'available'),
(33, 'Jaguar', 'XF', 2019, '30000000.00', 80000, 'Автомат', 'Дизель', 87, 'https://picsum.photos/seed/20/600/400', '2026-04-06 03:54:37', 'available'),
(34, 'Toyota', 'Corolla', 2023, '8000000.00', 12000, 'Автомат', 'Бензин', 85, 'https://picsum.photos/seed/21/600/400', '2026-04-06 03:54:37', 'available'),
(35, 'BMW', '3 Series', 2022, '25000000.00', 35000, 'Автомат', 'Бензин', 84, 'https://picsum.photos/seed/22/600/400', '2026-04-06 03:54:37', 'available'),
(36, 'Mercedes-Benz', 'C-Class', 2021, '22000000.00', 45000, 'Автомат', 'Бензин', 82, 'https://picsum.photos/seed/23/600/400', '2026-04-06 03:54:37', 'available'),
(37, 'Audi', 'A4', 2020, '18000000.00', 55000, 'Механика', 'Бензин', 80, 'https://picsum.photos/seed/24/600/400', '2026-04-06 03:54:37', 'available'),
(38, 'Kia', 'Rio', 2022, '6500000.00', 25000, 'Механика', 'Бензин', 70, 'https://picsum.photos/seed/25/600/400', '2026-04-06 03:54:37', 'available'),
(39, 'Hyundai', 'Santa Fe', 2023, '16000000.00', 18000, 'Автомат', 'Бензин', 88, 'https://picsum.photos/seed/26/600/400', '2026-04-06 03:54:37', 'available'),
(40, 'Lexus', 'IS', 2021, '24000000.00', 40000, 'Автомат', 'Гибрид', 86, 'https://picsum.photos/seed/27/600/400', '2026-04-06 03:54:37', 'available'),
(41, 'Volkswagen', 'Golf', 2020, '12000000.00', 60000, 'Механика', 'Бензин', 76, 'https://picsum.photos/seed/28/600/400', '2026-04-06 03:54:37', 'available'),
(42, 'Ford', 'Mustang', 2021, '28000000.00', 40000, 'Автомат', 'Бензин', 93, 'https://picsum.photos/seed/29/600/400', '2026-04-06 03:54:37', 'available'),
(43, 'Honda', 'Accord', 2022, '17000000.00', 30000, 'Автомат', 'Бензин', 81, 'https://picsum.photos/seed/30/600/400', '2026-04-06 03:54:37', 'available'),
(44, 'Mazda', '6', 2021, '14000000.00', 45000, 'Автомат', 'Бензин', 79, 'https://picsum.photos/seed/31/600/400', '2026-04-06 03:54:37', 'available'),
(45, 'Nissan', 'Altima', 2020, '13000000.00', 55000, 'Механика', 'Бензин', 75, 'https://picsum.photos/seed/32/600/400', '2026-04-06 03:54:37', 'available'),
(46, 'Volvo', 'S90', 2020, '32000000.00', 50000, 'Автомат', 'Дизель', 88, 'https://picsum.photos/seed/33/600/400', '2026-04-06 03:54:37', 'available'),
(47, 'Subaru', 'Legacy', 2019, '16000000.00', 65000, 'Автомат', 'Бензин', 77, 'https://picsum.photos/seed/34/600/400', '2026-04-06 03:54:37', 'available'),
(48, 'Porsche', 'Cayenne', 2019, '55000000.00', 70000, 'Автомат', 'Бензин', 96, 'https://picsum.photos/seed/35/600/400', '2026-04-06 03:54:37', 'available'),
(49, 'Tesla', 'Model S', 2022, '35000000.00', 10000, 'Автомат', 'Электричество', 97, 'https://picsum.photos/seed/36/600/400', '2026-04-06 03:54:37', 'available'),
(50, 'Chevrolet', 'Malibu', 2021, '9000000.00', 50000, 'Автомат', 'Бензин', 72, 'https://picsum.photos/seed/37/600/400', '2026-04-06 03:54:37', 'available'),
(51, 'Jeep', 'Cherokee', 2022, '18000000.00', 35000, 'Автомат', 'Бензин', 82, 'https://picsum.photos/seed/38/600/400', '2026-04-06 03:54:37', 'available'),
(52, 'Range Rover', 'Evoque', 2021, '22000000.00', 45000, 'Автомат', 'Бензин', 85, 'https://picsum.photos/seed/39/600/400', '2026-04-06 03:54:37', 'available'),
(53, 'Jaguar', 'F-Type', 2020, '45000000.00', 60000, 'Автомат', 'Бензин', 94, 'https://picsum.photos/seed/40/600/400', '2026-04-06 03:54:37', 'available'),
(54, 'Toyota', 'Land Cruiser', 2022, '38000000.00', 35000, 'Автомат', 'Дизель', 94, 'https://picsum.photos/seed/41/600/400', '2026-04-06 03:54:37', 'available'),
(55, 'BMW', 'X3', 2023, '32000000.00', 20000, 'Автомат', 'Бензин', 87, 'https://picsum.photos/seed/42/600/400', '2026-04-06 03:54:37', 'available'),
(56, 'Mercedes-Benz', 'GLE', 2022, '42000000.00', 30000, 'Автомат', 'Дизель', 90, 'https://picsum.photos/seed/43/600/400', '2026-04-06 03:54:37', 'available'),
(57, 'Audi', 'Q5', 2021, '26000000.00', 50000, 'Автомат', 'Бензин', 84, 'https://picsum.photos/seed/44/600/400', '2026-04-06 03:54:37', 'available'),
(58, 'Kia', 'Sorento', 2023, '14000000.00', 22000, 'Автомат', 'Бензин', 81, 'https://picsum.photos/seed/45/600/400', '2026-04-06 03:54:37', 'available'),
(59, 'Hyundai', 'Tucson', 2022, '11000000.00', 32000, 'Механика', 'Бензин', 78, 'https://picsum.photos/seed/46/600/400', '2026-04-06 03:54:37', 'available'),
(60, 'Lexus', 'NX', 2021, '20000000.00', 40000, 'Автомат', 'Гибрид', 84, 'https://picsum.photos/seed/47/600/400', '2026-04-06 03:54:37', 'available'),
(61, 'Volkswagen', 'Tiguan', 2020, '16000000.00', 65000, 'Механика', 'Дизель', 80, 'https://picsum.photos/seed/48/600/400', '2026-04-06 03:54:37', 'available'),
(62, 'Ford', 'Explorer', 2022, '20000000.00', 40000, 'Автомат', 'Бензин', 83, 'https://picsum.photos/seed/49/600/400', '2026-04-06 03:54:37', 'available'),
(63, 'Honda', 'CR-V', 2021, '15000000.00', 45000, 'Автомат', 'Бензин', 86, 'https://picsum.photos/seed/50/600/400', '2026-04-06 03:54:37', 'available'),
(64, 'Mazda', 'CX-9', 2022, '19000000.00', 35000, 'Автомат', 'Бензин', 82, 'https://picsum.photos/seed/51/600/400', '2026-04-06 03:54:37', 'available'),
(65, 'Nissan', 'Murano', 2021, '17000000.00', 50000, 'Автомат', 'Бензин', 79, 'https://picsum.photos/seed/52/600/400', '2026-04-06 03:54:37', 'available'),
(66, 'Volvo', 'XC90', 2020, '42000000.00', 60000, 'Автомат', 'Дизель', 91, 'https://picsum.photos/seed/53/600/400', '2026-04-06 03:54:37', 'available'),
(67, 'Subaru', 'Forester', 2019, '14000000.00', 70000, 'Автомат', 'Бензин', 80, 'https://picsum.photos/seed/54/600/400', '2026-04-06 03:54:37', 'available'),
(68, 'Porsche', 'Panamera', 2018, '58000000.00', 85000, 'Автомат', 'Бензин', 97, 'https://picsum.photos/seed/55/600/400', '2026-04-06 03:54:37', 'available'),
(69, 'Tesla', 'Model X', 2023, '42000000.00', 8000, 'Автомат', 'Электричество', 98, 'https://picsum.photos/seed/56/600/400', '2026-04-06 03:54:37', 'available'),
(70, 'Chevrolet', 'Tahoe', 2020, '28000000.00', 55000, 'Автомат', 'Бензин', 85, 'https://picsum.photos/seed/57/600/400', '2026-04-06 03:54:37', 'available'),
(71, 'Jeep', 'Compass', 2022, '12000000.00', 30000, 'Механика', 'Бензин', 76, 'https://picsum.photos/seed/58/600/400', '2026-04-06 03:54:37', 'available'),
(72, 'Range Rover', 'Velar', 2021, '35000000.00', 50000, 'Автомат', 'Бензин', 89, 'https://picsum.photos/seed/59/600/400', '2026-04-06 03:54:37', 'available'),
(73, 'Jaguar', 'E-PACE', 2020, '22000000.00', 65000, 'Автомат', 'Бензин', 84, 'https://picsum.photos/seed/60/600/400', '2026-04-06 03:54:37', 'available'),
(74, 'Toyota', 'RAV4', 2023, '13000000.00', 15000, 'Автомат', 'Бензин', 88, 'https://picsum.photos/seed/61/600/400', '2026-04-06 03:54:37', 'available'),
(75, 'BMW', 'M5', 2021, '48000000.00', 40000, 'Автомат', 'Бензин', 95, 'https://picsum.photos/seed/62/600/400', '2026-04-06 03:54:37', 'available'),
(76, 'Mercedes-Benz', 'AMG GT', 2020, '52000000.00', 55000, 'Автомат', 'Бензин', 96, 'https://picsum.photos/seed/63/600/400', '2026-04-06 03:54:37', 'available'),
(77, 'Audi', 'RS6', 2019, '42000000.00', 70000, 'Автомат', 'Бензин', 94, 'https://picsum.photos/seed/64/600/400', '2026-04-06 03:54:37', 'available'),
(78, 'Kia', 'Stinger', 2022, '18000000.00', 25000, 'Автомат', 'Бензин', 80, 'https://picsum.photos/seed/65/600/400', '2026-04-06 03:54:37', 'available'),
(79, 'Hyundai', 'Sonata', 2021, '10500000.00', 40000, 'Механика', 'Бензин', 74, 'https://picsum.photos/seed/66/600/400', '2026-04-06 03:54:37', 'available'),
(80, 'Lexus', 'RX Hybrid', 2022, '36000000.00', 25000, 'Автомат', 'Гибрид', 92, 'https://picsum.photos/seed/67/600/400', '2026-04-06 03:54:37', 'available'),
(81, 'Volkswagen', 'Jetta', 2020, '8000000.00', 75000, 'Механика', 'Бензин', 68, 'https://picsum.photos/seed/68/600/400', '2026-04-06 03:54:37', 'available'),
(82, 'Ford', 'Fusion', 2021, '11000000.00', 50000, 'Автомат', 'Бензин', 70, 'https://picsum.photos/seed/69/600/400', '2026-04-06 03:54:37', 'available'),
(83, 'Honda', 'Odyssey', 2020, '19000000.00', 60000, 'Автомат', 'Бензин', 78, 'https://picsum.photos/seed/70/600/400', '2026-04-06 03:54:37', 'available'),
(84, 'Mazda', 'CX-3', 2023, '10000000.00', 20000, 'Механика', 'Бензин', 75, 'https://picsum.photos/seed/71/600/400', '2026-04-06 03:54:37', 'available'),
(85, 'Nissan', 'Rogue', 2021, '12000000.00', 55000, 'Механика', 'Бензин', 72, 'https://picsum.photos/seed/72/600/400', '2026-04-06 03:54:37', 'available'),
(86, 'Volvo', 'V90', 2020, '35000000.00', 55000, 'Автомат', 'Дизель', 87, 'https://picsum.photos/seed/73/600/400', '2026-04-06 03:54:37', 'available'),
(87, 'Subaru', 'Impreza', 2019, '9000000.00', 70000, 'Механика', 'Бензин', 71, 'https://picsum.photos/seed/74/600/400', '2026-04-06 03:54:37', 'available'),
(88, 'Porsche', 'Macan', 2019, '35000000.00', 75000, 'Автомат', 'Бензин', 92, 'https://picsum.photos/seed/75/600/400', '2026-04-06 03:54:37', 'available'),
(89, 'Tesla', 'Model Y', 2023, '28000000.00', 7000, 'Автомат', 'Электричество', 96, 'https://picsum.photos/seed/76/600/400', '2026-04-06 03:54:37', 'available'),
(90, 'Chevrolet', 'Silverado', 2020, '22000000.00', 60000, 'Автомат', 'Бензин', 81, 'https://picsum.photos/seed/77/600/400', '2026-04-06 03:54:37', 'available'),
(91, 'Jeep', 'Grand Cherokee', 2021, '26000000.00', 40000, 'Автомат', 'Бензин', 87, 'https://picsum.photos/seed/78/600/400', '2026-04-06 03:54:37', 'available'),
(92, 'Range Rover', 'Sport', 2020, '32000000.00', 55000, 'Автомат', 'Дизель', 88, 'https://picsum.photos/seed/79/600/400', '2026-04-06 03:54:37', 'available'),
(93, 'Jaguar', 'I-PACE', 2022, '38000000.00', 15000, 'Автомат', 'Электричество', 93, 'https://picsum.photos/seed/80/600/400', '2026-04-06 03:54:37', 'available'),
(94, 'Toyota', 'Prius', 2023, '11000000.00', 8000, 'Автомат', 'Гибрид', 89, 'https://picsum.photos/seed/81/600/400', '2026-04-06 03:54:37', 'available'),
(95, 'BMW', 'M3', 2021, '42000000.00', 35000, 'Автомат', 'Бензин', 94, 'https://picsum.photos/seed/82/600/400', '2026-04-06 03:54:37', 'available'),
(96, 'Mercedes-Benz', 'C63', 2020, '45000000.00', 50000, 'Автомат', 'Бензин', 95, 'https://picsum.photos/seed/83/600/400', '2026-04-06 03:54:37', 'available'),
(97, 'Audi', 'S4', 2019, '28000000.00', 65000, 'Механика', 'Бензин', 85, 'https://picsum.photos/seed/84/600/400', '2026-04-06 03:54:37', 'available'),
(98, 'Kia', 'Niro', 2022, '10000000.00', 30000, 'Автомат', 'Гибрид', 76, 'https://picsum.photos/seed/85/600/400', '2026-04-06 03:54:37', 'available'),
(99, 'Hyundai', 'Kona', 2023, '8500000.00', 18000, 'Механика', 'Бензин', 73, 'https://picsum.photos/seed/86/600/400', '2026-04-06 03:54:37', 'available'),
(100, 'Lexus', 'GS', 2021, '26000000.00', 45000, 'Автомат', 'Гибрид', 85, 'https://picsum.photos/seed/87/600/400', '2026-04-06 03:54:37', 'available'),
(101, 'Volkswagen', 'Beetle', 2020, '7500000.00', 80000, 'Механика', 'Бензин', 66, 'https://picsum.photos/seed/88/600/400', '2026-04-06 03:54:37', 'available'),
(102, 'Ford', 'Edge', 2021, '16000000.00', 55000, 'Автомат', 'Бензин', 77, 'https://picsum.photos/seed/89/600/400', '2026-04-06 03:54:37', 'available'),
(103, 'Honda', 'Pilot', 2020, '18000000.00', 60000, 'Автомат', 'Бензин', 80, 'https://picsum.photos/seed/90/600/400', '2026-04-06 03:54:37', 'available'),
(104, 'Mazda', '3', 2023, '9000000.00', 25000, 'Механика', 'Бензин', 74, 'https://picsum.photos/seed/91/600/400', '2026-04-06 03:54:37', 'available'),
(105, 'Nissan', 'Sentra', 2021, '8000000.00', 60000, 'Механика', 'Бензин', 68, 'https://picsum.photos/seed/92/600/400', '2026-04-06 03:54:37', 'available'),
(106, 'Volvo', 'S60', 2020, '24000000.00', 65000, 'Автомат', 'Дизель', 83, 'https://picsum.photos/seed/93/600/400', '2026-04-06 03:54:37', 'available'),
(107, 'Subaru', 'BRZ', 2019, '15000000.00', 70000, 'Механика', 'Бензин', 79, 'https://picsum.photos/seed/94/600/400', '2026-04-06 03:54:37', 'available'),
(108, 'Porsche', 'Boxster', 2018, '32000000.00', 80000, 'Механика', 'Бензин', 91, 'https://picsum.photos/seed/95/600/400', '2026-04-06 03:54:37', 'available'),
(109, 'Tesla', 'Roadster', 2023, '75000000.00', 3000, 'Автомат', 'Электричество', 99, 'https://picsum.photos/seed/96/600/400', '2026-04-06 03:54:37', 'available'),
(110, 'Chevrolet', 'Equinox', 2020, '11000000.00', 65000, 'Автомат', 'Бензин', 69, 'https://picsum.photos/seed/97/600/400', '2026-04-06 03:54:37', 'available'),
(111, 'Jeep', 'Renegade', 2022, '9500000.00', 35000, 'Механика', 'Бензин', 71, 'https://picsum.photos/seed/98/600/400', '2026-04-06 03:54:37', 'available'),
(112, 'Range Rover', 'Defender', 2021, '28000000.00', 40000, 'Автомат', 'Дизель', 86, 'https://picsum.photos/seed/99/600/400', '2026-04-06 03:54:37', 'available'),
(113, 'Jaguar', 'XE', 2020, '16000000.00', 70000, 'Механика', 'Бензин', 79, 'https://picsum.photos/seed/100/600/400', '2026-04-06 03:54:37', 'available'),
(114, 'Toyota', 'Yaris', 2023, '5000000.00', 10000, 'Механика', 'Бензин', 68, 'https://picsum.photos/seed/101/600/400', '2026-04-06 03:54:37', 'available'),
(115, 'BMW', '7 Series', 2021, '55000000.00', 35000, 'Автомат', 'Дизель', 92, 'https://picsum.photos/seed/102/600/400', '2026-04-06 03:54:37', 'available'),
(116, 'Mercedes-Benz', 'S-Class', 2020, '65000000.00', 45000, 'Автомат', 'Бензин', 98, 'https://picsum.photos/seed/103/600/400', '2026-04-06 03:54:37', 'available'),
(117, 'Audi', 'A8', 2019, '48000000.00', 60000, 'Автомат', 'Дизель', 90, 'https://picsum.photos/seed/104/600/400', '2026-04-06 03:54:37', 'available'),
(118, 'Kia', 'Telluride', 2022, '22000000.00', 28000, 'Автомат', 'Бензин', 82, 'https://picsum.photos/seed/105/600/400', '2026-04-06 03:54:37', 'available'),
(119, 'Hyundai', 'Venue', 2023, '5500000.00', 12000, 'Механика', 'Бензин', 70, 'https://picsum.photos/seed/106/600/400', '2026-04-06 03:54:37', 'available'),
(120, 'Lexus', 'LS', 2021, '48000000.00', 40000, 'Автомат', 'Гибрид', 91, 'https://picsum.photos/seed/107/600/400', '2026-04-06 03:54:37', 'available'),
(121, 'Volkswagen', 'CC', 2020, '14000000.00', 70000, 'Механика', 'Дизель', 77, 'https://picsum.photos/seed/108/600/400', '2026-04-06 03:54:37', 'available'),
(122, 'Ford', 'Bronco', 2021, '26000000.00', 45000, 'Автомат', 'Бензин', 84, 'https://picsum.photos/seed/109/600/400', '2026-04-06 03:54:37', 'available'),
(123, 'Honda', 'Insight', 2020, '14000000.00', 65000, 'Автомат', 'Гибрид', 75, 'https://picsum.photos/seed/110/600/400', '2026-04-06 03:54:37', 'available'),
(124, 'Mazda', 'MX-5', 2023, '13000000.00', 22000, 'Механика', 'Бензин', 86, 'https://picsum.photos/seed/111/600/400', '2026-04-06 03:54:37', 'available'),
(125, 'Nissan', 'Maxima', 2021, '16000000.00', 55000, 'Механика', 'Бензин', 74, 'https://picsum.photos/seed/112/600/400', '2026-04-06 03:54:37', 'available'),
(126, 'Volvo', 'XC40', 2020, '18000000.00', 60000, 'Автомат', 'Дизель', 81, 'https://picsum.photos/seed/113/600/400', '2026-04-06 03:54:37', 'available'),
(127, 'Subaru', 'Crosstrek', 2019, '11000000.00', 72000, 'Механика', 'Бензин', 76, 'https://picsum.photos/seed/114/600/400', '2026-04-06 03:54:37', 'available'),
(128, 'Porsche', '718 Cayman', 2018, '38000000.00', 80000, 'Механика', 'Бензин', 93, 'https://picsum.photos/seed/115/600/400', '2026-04-06 03:54:37', 'available'),
(129, 'Tesla', 'Semi', 2023, '80000000.00', 5000, 'Электричество', 'Электричество', 100, 'https://picsum.photos/seed/116/600/400', '2026-04-06 03:54:37', 'available'),
(130, 'Chevrolet', 'Bolt', 2022, '12000000.00', 8000, 'Автомат', 'Электричество', 87, 'https://picsum.photos/seed/117/600/400', '2026-04-06 03:54:37', 'available'),
(131, 'Jeep', 'Gladiator', 2021, '25000000.00', 42000, 'Механика', 'Бензин', 85, 'https://picsum.photos/seed/118/600/400', '2026-04-06 03:54:37', 'available'),
(132, 'Range Rover', 'Freelander', 2020, '19000000.00', 65000, 'Автомат', 'Дизель', 80, 'https://picsum.photos/seed/119/600/400', '2026-04-06 03:54:37', 'available'),
(133, 'Jaguar', 'C-X75', 2019, '68000000.00', 90000, 'Автомат', 'Электричество', 97, 'https://picsum.photos/seed/120/600/400', '2026-04-06 03:54:37', 'available'),
(134, 'BMW', 'X5 G05', 2023, '45000000.00', 25000, 'Автомат', 'Дизель', 90, 'https://example.com/photo.jpg', '2026-04-20 09:45:52', 'available'),
(135, 'BMW', 'X5 G05', 2023, '45000000.00', 25000, 'Автомат', 'Дизель', 90, 'https://example.com/photo.jpg', '2026-04-20 10:43:01', 'available');

-- --------------------------------------------------------

--
-- Структура таблицы `car_history`
--

CREATE TABLE `car_history` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_history`
--

INSERT INTO `car_history` (`id`, `car_id`, `event`, `date`) VALUES
(4, 2, 'Регистрация в ПДК', '2020-03-15'),
(5, 2, 'Ремонт кузова', '2021-11-22'),
(6, 2, 'Техническое обслуживание', '2023-12-10'),
(7, 3, 'Регистрация в ПДК', '2019-07-05'),
(8, 3, 'Смена владельца', '2021-02-14'),
(9, 3, 'Техническое обслуживание', '2023-06-18'),
(10, 4, 'Регистрация в ПДК', '2018-01-12'),
(11, 4, 'Техническое обслуживание', '2020-08-30'),
(12, 4, 'Техническое обслуживание', '2023-05-22'),
(13, 5, 'Регистрация в ПДК', '2022-04-20'),
(14, 5, 'Техническое обслуживание', '2024-03-15'),
(15, 6, 'Регистрация в ПДК', '2021-06-10'),
(16, 6, 'Смена владельца', '2023-01-08'),
(17, 6, 'Техническое обслуживание', '2024-02-20'),
(18, 7, 'Регистрация в ПДК', '2017-09-18'),
(19, 7, 'Техническое обслуживание', '2020-12-05'),
(20, 7, 'Техническое обслуживание', '2023-10-12'),
(21, 8, 'Регистрация в ПДК', '2022-02-08'),
(22, 8, 'Техническое обслуживание', '2023-11-20'),
(23, 9, 'Регистрация в ПДК', '2020-08-25'),
(24, 9, 'Техническое обслуживание', '2022-09-10'),
(25, 9, 'Техническое обслуживание', '2024-01-15'),
(26, 10, 'Регистрация в ПДК', '2021-10-12'),
(27, 10, 'Техническое обслуживание', '2023-08-20');

-- --------------------------------------------------------

--
-- Структура таблицы `car_reviews`
--

CREATE TABLE `car_reviews` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `author` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_reviews`
--

INSERT INTO `car_reviews` (`id`, `car_id`, `author`, `rating`, `comment`, `created_at`) VALUES
(4, 2, 'Дмитрий Волков', 5, 'BMW X5 - это мечта! Мощный, красивый, все работает идеально.', '2026-02-18 08:20:00'),
(5, 2, 'Ольга Николаева', 4, 'Симпатичный джип, но расход топлива высоват.', '2026-02-28 13:40:00'),
(6, 3, 'Виктор Соколов', 4, 'Mercedes - класс! Езду себя чувствует как в воздухе.', '2026-03-05 05:50:00'),
(7, 3, 'Елена Борисова', 5, 'Прекрасный автомобиль, очень надежный и долговечный.', '2026-03-08 10:25:00'),
(8, 4, 'Сергей Львов', 5, 'Lexus RX - топ! Все детали на месте, качество на высоте.', '2026-02-22 07:10:00'),
(9, 4, 'Наталья Орлова', 4, 'Очень хороший выбор для семьи. Просторный и безопасный.', '2026-03-02 12:35:00'),
(10, 5, 'Павел Морозов', 4, 'Hyundai Elantra - надежная и доступная машина.', '2026-02-26 09:50:00'),
(11, 5, 'Людмила Федорова', 5, 'Новый автомобиль, работает как часы!', '2026-03-06 06:30:00'),
(12, 6, 'Игорь Козлов', 5, 'Kia Sportage - отличный паркетник с хорошей управляемостью.', '2026-02-24 11:20:00'),
(13, 6, 'Анна Белова', 4, 'Удобный для города, но на трассе хотелось бы больше стабильности.', '2026-03-03 08:40:00'),
(14, 7, 'Валентин Доступов', 4, 'Audi A6 - машина для взрослых людей. Премиум качество.', '2026-02-21 10:15:00'),
(15, 7, 'Юлия Соколова', 4, 'Красивый и мощный. Годы проголосуют шансы на разные вещи.', '2026-03-04 07:25:00'),
(16, 8, 'Максим Степанов', 5, 'Land Cruiser 300 - легенда! Может ездить везде и долго.', '2026-02-19 06:05:00'),
(17, 8, 'Галина Комарова', 5, 'Королевский внедорожник. Очень мощный и уверенный на дороге.', '2026-03-07 11:50:00'),
(18, 9, 'Константин Цветков', 4, 'Volkswagen Polo - компактный и экономичный. Удобнее не надо!', '2026-02-23 09:30:00'),
(19, 9, 'Татьяна Васильева', 4, 'Отличный городской автомобиль. Маневренный и спорт дух видно.', '2026-03-09 08:05:00'),
(20, 10, 'Роман Смирнов', 5, 'Tesla Model 3 - будущее уже здесь! Тихий, мощный и экономичный.', '2026-02-17 07:40:00'),
(21, 10, 'Вероника Лебедева', 5, 'Электромобиль будущего. Нет никакого загрязнения окружающей среды.', '2026-03-10 12:20:00');

-- --------------------------------------------------------

--
-- Структура таблицы `car_service`
--

CREATE TABLE `car_service` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_service`
--

INSERT INTO `car_service` (`id`, `car_id`, `service`, `date`) VALUES
(4, 2, 'ТО-1: замена масла и фильтров', '2020-09-10'),
(5, 2, 'Замена тормозных колодок', '2021-11-22'),
(6, 2, 'ТО-2: полное техническое обслуживание', '2023-12-10'),
(7, 3, 'ТО-1: замена масла и фильтров', '2019-10-15'),
(8, 3, 'Замена свечей зажигания', '2021-05-20'),
(9, 3, 'ТО-2: полное техническое обслуживание', '2023-06-18'),
(10, 4, 'ТО-1: замена масла и фильтров', '2018-05-10'),
(11, 4, 'Диагностика ходовой части', '2020-08-30'),
(12, 4, 'ТО-2: полное техническое обслуживание', '2023-05-22'),
(13, 5, 'ТО-1: замена масла и фильтров', '2022-08-20'),
(14, 5, 'Инспекция безопасности', '2024-03-15'),
(15, 6, 'ТО-1: замена масла и фильтров', '2021-10-15'),
(16, 6, 'Замена тормозной жидкости', '2023-01-08'),
(17, 6, 'ТО-2: полное техническое обслуживание', '2024-02-20'),
(18, 7, 'ТО-1: замена масла и фильтров', '2017-12-18'),
(19, 7, 'Ремонт подвески', '2020-12-05'),
(20, 7, 'ТО-2: полное техническое обслуживание', '2023-10-12'),
(21, 8, 'ТО-1: замена масла и фильтров', '2022-06-08'),
(22, 8, 'Проверка дизельного фильтра', '2023-11-20'),
(23, 9, 'ТО-1: замена масла и фильтров', '2020-11-25'),
(24, 9, 'Замена воздушного фильтра', '2022-09-10'),
(25, 9, 'Инспекция электрооборудования', '2024-01-15'),
(26, 10, 'ТО-1: проверка батареи', '2021-12-12'),
(27, 10, 'Диагностика электросистемы', '2023-08-20');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1, 22, 'mark_sold', 'Marked car ID: 7 as sold', '2026-03-16 13:20:31'),
(2, 35, 'add_car', 'Added car: 123 123', '2026-03-30 10:01:43'),
(3, 22, 'mark_sold', 'Marked car ID: 11 as sold', '2026-03-30 10:02:47'),
(4, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:18:13'),
(5, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:25:38'),
(6, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:26:31'),
(7, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:26:39'),
(8, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:26:50'),
(9, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:26:55'),
(10, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:26:59'),
(11, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:28:22'),
(12, 35, 'mark_sold', 'Marked car ID: 1 as sold', '2026-03-30 11:28:29'),
(13, 35, 'add_car', 'Added car: 123 123', '2026-04-06 03:08:07'),
(14, 35, 'add_car', 'Added car: 123 123', '2026-04-06 03:08:17'),
(15, 35, 'add_car', 'Added car: 123 123', '2026-04-06 03:08:54'),
(16, 35, 'edit_car', 'Edited car ID: 13', '2026-04-06 03:09:00'),
(17, 35, 'update_application', 'Updated application ID: 1 to new', '2026-04-06 03:09:05'),
(18, 35, 'update_application', 'Updated application ID: 1 to approved', '2026-04-06 03:09:09'),
(19, 35, 'update_application', 'Updated application ID: 1 to approved', '2026-04-06 03:09:57'),
(20, 22, 'delete_car', 'Deleted car ID: 11', '2026-04-06 03:18:40'),
(21, 22, 'delete_car', 'Deleted car ID: 13', '2026-04-06 03:18:43'),
(22, 22, 'delete_car', 'Deleted car ID: 12', '2026-04-06 03:18:45'),
(23, 22, 'delete_car', 'Deleted car ID: 12', '2026-04-06 03:18:54'),
(24, 22, 'edit_car', 'Edited car ID: 3', '2026-04-06 03:30:19'),
(25, 22, 'edit_car', 'Edited car ID: 3', '2026-04-06 03:30:25'),
(26, 22, 'edit_car', 'Edited car ID: 1', '2026-04-06 03:30:28'),
(27, 22, 'edit_car', 'Edited car ID: 1', '2026-04-06 03:30:32'),
(28, 22, 'edit_car', 'Edited car ID: 21', '2026-04-06 04:42:29'),
(29, 22, 'edit_car', 'Edited car ID: 21', '2026-04-06 05:05:36'),
(30, 22, 'edit_car', 'Edited car ID: 14', '2026-04-06 05:05:40'),
(31, 22, 'edit_car', 'Edited car ID: 16', '2026-04-06 05:05:53');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Ivan Petrov', 'ivan@mail.com', '123456', 'user', '2026-02-16 11:09:56'),
(2, 'Anna Smirnova', 'anna@mail.com', '123456', 'user', '2026-02-16 11:09:56'),
(3, 'Терентьеваа Инга Владимировна', 'dyckova.varvara@example.org', '$2y$10$uf9P/0A.GinZElWIefk.GOFXzZLdriwnfBGbyIjeWcBzn9ScOb49O', 'user', '2026-02-23 09:32:39'),
(4, 'Филипп Романович Юдин', 'ykov68@example.net', '$2y$10$unDRzk6sGGDaZHEEzxaK5Oww3d9u5JDCTF4xhiGFKEQPvOkuEKKdi', 'user', '2026-02-23 09:32:39'),
(5, 'Зоя Романовна Воронцова', 'marta71@example.net', '$2y$10$UVPkS37F0nVP64gnct6s4OkH.Pf5Qm.f8wmxFzX8Qe7TEgZvZ8ws6', 'user', '2026-02-23 09:32:39'),
(6, 'Борис Фёдорович Волкова', 'xtrofimova@example.net', '$2y$10$RfG0RUgmI3LmT7INpqpyzuJyS/z7w00gRqazP/Y4GNteTVbdqK1Ui', 'user', '2026-02-23 09:32:39'),
(7, 'Киселёва Афанасий Александрович', 'mark41@example.com', '$2y$10$PKqGh.xZcIvgmtANku2.LeIEgzwuxuC3eamES7I4H8aVUMx9GXp7G', 'user', '2026-02-23 09:32:39'),
(8, 'Максимова Раиса Алексеевна', 'klara.sidorov@example.org', '$2y$10$IrWiZKvlUmKH5tcFT0xv8OsGZvIAKsNb4ncJsKqz3AK8Kn1yko/6e', 'user', '2026-02-23 09:32:39'),
(9, 'Олег Львович Фролов', 'yroslav80@example.org', '$2y$10$MN6y5sZSCLPdj2k.5sbEMO/3z8J9448II0Yk.lPdTK5O5NLMh7rJe', 'user', '2026-02-23 09:32:39'),
(10, 'Рада Александровна Агафоноваа', 'emelynova.elizaveta@example.net', '$2y$10$AhOgvqpxjtSFey6Lj2YK/OUV.e.bw/TjEkPwNQIk8db5HokeiBfQS', 'user', '2026-02-23 09:32:40'),
(11, 'Пономарёва Владлен Андреевич', 'nazar71@example.org', '$2y$10$5kRFrnjb64GPOj3.7cK/fuyiphbrwma11ns4wJPSi344s1QbCtlR6', 'user', '2026-02-23 09:32:40'),
(12, 'Лидия Фёдоровна Крылова', 'ovasileva@example.net', '$2y$10$BkY..YS/IkF.casm/gh3SuxH81Kbdk4FYxjUa64zIhQKuVLZ8Agcq', 'user', '2026-02-23 09:32:40'),
(22, 'primer2@mail.ru', 'primer2@mail.ru', '$2y$10$HfGsOBSZfPERiIav2d83ruYRbPysSkPvOsFqK8A9rvfZnezujT.FG', 'admin', '2026-03-16 11:39:09'),
(23, 'Баранова Капитолина Львовна', 'nsamoilova@example.com', '$2y$10$37dZh9XHNxHAV5KH1Y1J3ez9oxyCGyU6PWlOece0cKkvIIHMvjcEC', 'user', '2026-03-16 13:14:11'),
(24, 'Рогова Ян Фёдорович', 'nonna03@example.net', '$2y$10$FNuArrK9k81PUsEiAR9npOBvSo8TmLG3hea/yxsC2lf35ErrwlvoK', 'user', '2026-03-16 13:14:11'),
(25, 'Кулакова Виктория Сергеевна', 'panova.fedosy@example.org', '$2y$10$djbp1poHw445IfHtirLaluKLb/fsiWw5Z/o92rHR7Xnu7QuoecEoe', 'user', '2026-03-16 13:14:11'),
(26, 'Ефремов Гавриил Александрович', 'vitalii34@example.com', '$2y$10$JZINd40Sb0WkXIna9tuaQ.MMuozXChwXpWx6H1dVjL0Xy33KBm27q', 'user', '2026-03-16 13:14:12'),
(27, 'Суханова Болеслав Львович', 'evdokimov.izabella@example.com', '$2y$10$RZfYhCRdTIHruGY.N1PumO1VgPbXpjEqb8yraLr7zhPJ/RHcXoAWS', 'user', '2026-03-16 13:14:12'),
(28, 'Ермакова Глеб Евгеньевич', 'anna63@example.com', '$2y$10$gdWiNi2qdZ3oNy29HWJN4Oiy2wO9V5HdcbrmI.WidOhzI0evfTrvi', 'user', '2026-03-16 13:14:12'),
(29, 'Эдуард Алексеевич Лихачёва', 'vil.sukin@example.com', '$2y$10$1dlLzT9oQzrnHMNU5NJ8ZenQ/w/sFOymnFMbxeUe8xUjJBl3ktkzq', 'user', '2026-03-16 13:14:12'),
(30, 'Болеслав Андреевич Михайлова', 'vlad.knyzeva@example.com', '$2y$10$/zfASZPH2CLrpju0KkuKzuaK26PiSNvZY8IC0UgNKrDI/Nrtw3tZ.', 'user', '2026-03-16 13:14:12'),
(31, 'Быкова Ульяна Фёдоровна', 'gleb99@example.org', '$2y$10$ZY5MIpDv.Ou1RB9t04AMKOSkyh1ec8l1VEvFK0MCxb9VuH6t7ptg6', 'user', '2026-03-16 13:14:12'),
(32, 'Мартыноваа Алла Владимировна', 'maiy86@example.com', '$2y$10$ACbx9b3dXOOIjbxynbY/t.6mzfzeFnfFSGJHCXt0HSQUe17ZN9Ffq', 'user', '2026-03-16 13:14:12'),
(33, 'Admin', 'admin@example.com', '$2y$10$5KZxtgGZZqy5uG.9dAfVeuA7BYYtiaxUg7OWImi5Ez6sIwRk5mRnu', 'admin', '2026-03-16 13:14:12'),
(34, 'primer1@mail.ru', 'primer1@mail.ru', '$2y$10$8xNw4BB4wvyHBp7.Ap2./.foJvNsPnFE4NspaVG368guHFEfyEoDC', 'user', '2026-03-16 13:17:01'),
(35, 'AdminPanel', 'AdminPanel@mail.ru', '$2y$10$ZPVR461tBKSM9bd3JBYbJeryAvZyB4GozHg62iar8zb0EUj99bgiW', 'admin', '2026-03-30 09:49:39');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_car` (`car_id`),
  ADD KEY `fk_app_user` (`user_id`);

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `car_history`
--
ALTER TABLE `car_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_history_car` (`car_id`);

--
-- Индексы таблицы `car_reviews`
--
ALTER TABLE `car_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_car` (`car_id`);

--
-- Индексы таблицы `car_service`
--
ALTER TABLE `car_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_car` (`car_id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT для таблицы `car_history`
--
ALTER TABLE `car_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `car_reviews`
--
ALTER TABLE `car_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `car_service`
--
ALTER TABLE `car_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_app_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `car_history`
--
ALTER TABLE `car_history`
  ADD CONSTRAINT `fk_history_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `car_reviews`
--
ALTER TABLE `car_reviews`
  ADD CONSTRAINT `fk_reviews_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `car_service`
--
ALTER TABLE `car_service`
  ADD CONSTRAINT `fk_service_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
