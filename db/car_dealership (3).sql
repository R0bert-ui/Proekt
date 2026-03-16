-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 16 2026 г., 14:29
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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `price`, `mileage`, `gearbox`, `fuel`, `popularity`, `photo_url`, `created_at`) VALUES
(1, 'Toyota', 'Camry 75', 2021, '16500000.00', 45000, 'Автомат', 'Бензин', 95, 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=800', '2026-03-16 07:00:00'),
(2, 'BMW', 'X5 G05', 2020, '42000000.00', 55000, 'Автомат', 'Дизель', 88, 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800', '2026-03-16 07:00:00'),
(3, 'Mercedes-Benz', 'E-Class W213', 2019, '24500000.00', 70000, 'Автомат', 'Бензин', 82, 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=800', '2026-03-16 07:00:00'),
(4, 'Lexus', 'RX 300', 2018, '21000000.00', 85000, 'Автомат', 'Бензин', 90, 'https://iat.ru/uploads/origin/models/272233/1.webp', '2026-03-16 07:00:00'),
(5, 'Hyundai', 'Elantra', 2022, '11500000.00', 25000, 'Автомат', 'Бензин', 75, 'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?auto=format&fit=crop&w=800', '2026-03-16 07:00:00'),
(6, 'Kia', 'Sportage', 2021, '13800000.00', 38000, 'Автомат', 'Бензин', 85, 'https://media.ixbt.site/fit-in/1066x600/https://www.ixbt.com/img/n1/news/2021/5/2/hb0v8h0b0dwv2ndvlcwl_large.png', '2026-03-16 07:00:00'),
(7, 'Audi', 'A6', 2017, '14200000.00', 95000, 'Автомат', 'Бензин', 65, 'https://images.unsplash.com/photo-1606152421802-db97b9c7a11b?auto=format&fit=crop&w=800', '2026-03-16 07:00:00'),
(8, 'Toyota', 'Land Cruiser 300', 2022, '58000000.00', 15000, 'Автомат', 'Дизель', 100, 'https://iat.ru/uploads/origin/models/2047797/2.jpg', '2026-03-16 07:00:00'),
(9, 'Volkswagen', 'Polo', 2020, '8200000.00', 60000, 'Автомат', 'Бензин', 70, 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=800', '2026-03-16 07:00:00'),
(10, 'Tesla', 'Model 3', 2021, '18500000.00', 32000, 'Автомат', 'Электро', 80, 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800', '2026-03-16 07:00:00');

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
(1, 1, 'Регистрация в ПДК', '2021-05-10'),
(2, 1, 'Техническое обслуживание', '2023-09-15'),
(3, 1, 'Смена владельца', '2022-08-20'),
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
(1, 1, 'Иван Петров', 5, 'Отличный автомобиль! Очень комфортный и экономичный. Рекомендую всем.', '2026-02-20 10:30:00'),
(2, 1, 'Мария Сергеева', 4, 'Хорошая машина, надежная, но салон немного устарел для своего года выпуска.', '2026-02-25 14:15:00'),
(3, 1, 'Алексей Иванов', 5, 'Владею уже 3 года. Сплошные плюсы!', '2026-03-01 09:45:00'),
(4, 2, 'Дмитрий Волков', 5, 'BMW X5 - это мечта! Мощный, красивый, все работает идеально.', '2026-02-18 11:20:00'),
(5, 2, 'Ольга Николаева', 4, 'Симпатичный джип, но расход топлива высоват.', '2026-02-28 16:40:00'),
(6, 3, 'Виктор Соколов', 4, 'Mercedes - класс! Езду себя чувствует как в воздухе.', '2026-03-05 08:50:00'),
(7, 3, 'Елена Борисова', 5, 'Прекрасный автомобиль, очень надежный и долговечный.', '2026-03-08 13:25:00'),
(8, 4, 'Сергей Львов', 5, 'Lexus RX - топ! Все детали на месте, качество на высоте.', '2026-02-22 10:10:00'),
(9, 4, 'Наталья Орлова', 4, 'Очень хороший выбор для семьи. Просторный и безопасный.', '2026-03-02 15:35:00'),
(10, 5, 'Павел Морозов', 4, 'Hyundai Elantra - надежная и доступная машина.', '2026-02-26 12:50:00'),
(11, 5, 'Людмила Федорова', 5, 'Новый автомобиль, работает как часы!', '2026-03-06 09:30:00'),
(12, 6, 'Игорь Козлов', 5, 'Kia Sportage - отличный паркетник с хорошей управляемостью.', '2026-02-24 14:20:00'),
(13, 6, 'Анна Белова', 4, 'Удобный для города, но на трассе хотелось бы больше стабильности.', '2026-03-03 11:40:00'),
(14, 7, 'Валентин Доступов', 4, 'Audi A6 - машина для взрослых людей. Премиум качество.', '2026-02-21 13:15:00'),
(15, 7, 'Юлия Соколова', 4, 'Красивый и мощный. Годы проголосуют шансы на разные вещи.', '2026-03-04 10:25:00'),
(16, 8, 'Максим Степанов', 5, 'Land Cruiser 300 - легенда! Может ездить везде и долго.', '2026-02-19 09:05:00'),
(17, 8, 'Галина Комарова', 5, 'Королевский внедорожник. Очень мощный и уверенный на дороге.', '2026-03-07 14:50:00'),
(18, 9, 'Константин Цветков', 4, 'Volkswagen Polo - компактный и экономичный. Удобнее не надо!', '2026-02-23 12:30:00'),
(19, 9, 'Татьяна Васильева', 4, 'Отличный городской автомобиль. Маневренный и спорт дух видно.', '2026-03-09 11:05:00'),
(20, 10, 'Роман Смирнов', 5, 'Tesla Model 3 - будущее уже здесь! Тихий, мощный и экономичный.', '2026-02-17 10:40:00'),
(21, 10, 'Вероника Лебедева', 5, 'Электромобиль будущего. Нет никакого загрязнения окружающей среды.', '2026-03-10 15:20:00');

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
(1, 1, 'ТО-1: замена масла и фильтров', '2021-08-20'),
(2, 1, 'Замена воздушного фильтра салона', '2022-11-15'),
(3, 1, 'ТО-2: полное техническое обслуживание', '2023-09-15'),
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
(12, 'Лидия Фёдоровна Крылова', 'ovasileva@example.net', '$2y$10$BkY..YS/IkF.casm/gh3SuxH81Kbdk4FYxjUa64zIhQKuVLZ8Agcq', 'user', '2026-02-23 09:32:40');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
