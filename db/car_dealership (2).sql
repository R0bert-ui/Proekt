-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 16 2026 г., 13:00
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
(1, 1, 1, 'Ivan Petrov', '+79991234567', 'ivan@mail.com', 'Interested in test drive', 'new', '2026-02-16 11:09:56'),
(2, 7, 3, 'Анна Дмитриевна Мартынова', '(35222) 93-6612', 'illarion.doronina@example.com', 'Placeat earum cum possimus dolor ea labore omnis saepe.', 'new', '2026-02-23 09:32:40'),
(3, 4, 4, 'Ефим Сергеевич Федотов', '+7 (922) 200-5674', 'inessa24@example.org', 'Eligendi eum et quia magnam reprehenderit sed magnam voluptate sunt.', 'new', '2026-02-23 09:32:40'),
(4, 16, 10, 'Крылов Пётр Александрович', '(35222) 76-8273', 'rbelozerov@example.net', 'Consequatur repudiandae in tempora excepturi dolorum est non consequatur laboriosam est.', 'new', '2026-02-23 09:32:40'),
(5, 15, 10, 'Мария Владимировна Веселоваа', '8-800-308-1280', 'fcernov@example.net', 'Qui dolor quisquam voluptatem magnam aut at a saepe tenetur explicabo.', 'new', '2026-02-23 09:32:40'),
(6, 7, 9, 'Мамонтова Артём Романович', '8-800-133-3761', 'uzuravleva@example.com', 'Iste distinctio illum ea dolores explicabo facere.', 'new', '2026-02-23 09:32:40'),
(7, 15, 4, 'Ефремова Анфиса Фёдоровна', '+7 (922) 291-5333', 'valeriy.denisov@example.org', 'Distinctio assumenda sed sit et enim doloribus error.', 'new', '2026-02-23 09:32:40'),
(8, 15, 11, 'Эмма Фёдоровна Лыткина', '(35222) 73-1193', 'izolda04@example.net', 'Temporibus porro nobis facilis voluptatem dicta dolorem ut odit et.', 'new', '2026-02-23 09:32:40'),
(9, 16, 6, 'Инесса Фёдоровна Дроздоваа', '+7 (922) 245-4913', 'kovalev.ily@example.net', 'Aperiam ut atque esse quasi ut provident ipsam tempore iste aliquid.', 'new', '2026-02-23 09:32:40'),
(10, 14, 3, 'Афанасий Алексеевич Субботина', '(35222) 53-0149', 'apollon.filatova@example.org', 'Quia sed minus facilis reiciendis porro ut nobis et.', 'new', '2026-02-23 09:32:40'),
(11, 11, 7, 'Диана Ивановна Зиновьеваа', '(35222) 01-9853', 'regina.maslova@example.com', 'Hic vero et magnam reiciendis facilis quia cum possimus voluptatem.', 'new', '2026-02-23 09:32:40'),
(12, 13, 12, 'Ирина Романовна Волкова', '(812) 775-39-48', 'kornilova.lydmila@example.org', 'Officia quod temporibus nemo eius ipsam et placeat maiores.', 'new', '2026-02-23 09:32:40'),
(13, 8, 6, 'Дмитрий Романович Афанасьева', '+7 (922) 544-3439', 'fadeev.klavdiy@example.com', 'Inventore illum molestiae sequi architecto est.', 'new', '2026-02-23 09:32:40'),
(14, 3, 3, 'Вера Сергеевна Вишняковаа', '(812) 593-87-88', 'udavydova@example.org', 'Amet error cum magnam ut voluptate consequatur necessitatibus ratione ut.', 'new', '2026-02-23 09:32:40'),
(15, 10, 7, 'Клара Фёдоровна Романова', '(35222) 81-2938', 'krasilnikova.ykov@example.org', 'Adipisci pariatur illo amet corporis.', 'new', '2026-02-23 09:32:40'),
(16, 16, 10, 'Станислав Максимович Андреев', '8-800-737-1800', 'abram.frolova@example.org', 'Aut facere soluta et doloremque rerum vel adipisci totam nihil eveniet.', 'new', '2026-02-23 09:32:40'),
(17, 11, 6, 'Силина Алёна Евгеньевна', '+7 (922) 137-9086', 'viktoriy.bragina@example.com', 'Veritatis et minus doloribus mollitia accusantium possimus officiis.', 'new', '2026-02-23 09:32:40'),
(18, 16, 3, 'Ефремова Иннокентий Андреевич', '+7 (922) 186-9083', 'anzelika.guseva@example.net', 'Dolore recusandae officia excepturi blanditiis vitae.', 'new', '2026-02-23 09:32:40'),
(19, 11, 9, 'Карпова Болеслав Евгеньевич', '(812) 851-44-87', 'evgeniy.mikailov@example.org', 'Velit velit ut veritatis aliquid quo voluptas maiores quas.', 'new', '2026-02-23 09:32:40'),
(20, 4, 10, 'Анфиса Сергеевна Крюкова', '(495) 958-5354', 'pakomov.stepan@example.net', 'Magni nulla expedita dolore asperiores quaerat rerum.', 'new', '2026-02-23 09:32:40'),
(21, 5, 7, 'Клара Львовна Даниловаа', '+7 (922) 967-3114', 'grigoreva.zoy@example.com', 'Nulla rerum ipsam illo ut voluptatem nisi voluptatem deleniti.', 'new', '2026-02-23 09:32:40'),
(22, 8, 9, 'Артемий Максимович Крылов', '(812) 423-44-50', 'rmikailova@example.net', 'Id blanditiis consequatur consequatur et explicabo a sit officiis sed.', 'new', '2026-02-23 09:32:40'),
(23, 10, 5, 'Софья Алексеевна Мясникова', '+7 (922) 330-1232', 'evseev.viktor@example.org', 'Eveniet maxime eum quos commodi aut aperiam animi.', 'new', '2026-02-23 09:32:40'),
(24, 10, 6, 'Захар Александрович Беспалова', '8-800-694-8129', 'kabanov.evgenii@example.org', 'Ea ipsa possimus et ex voluptates rerum.', 'new', '2026-02-23 09:32:40'),
(25, 7, 4, 'Тит Романович Петров', '(495) 406-3659', 'lobanova.svytoslav@example.net', 'Aut aliquam expedita qui impedit qui ratione eos voluptatem.', 'new', '2026-02-23 09:32:40'),
(26, 9, 5, 'Шашкова Анастасия Ивановна', '(35222) 00-4458', 'sobolev.matvei@example.org', 'Nihil eaque qui vel necessitatibus consectetur veritatis accusantium qui mollitia tenetur consequatur.', 'new', '2026-02-23 09:32:40'),
(27, 5, 6, 'Лариса Алексеевна Анисимоваа', '(495) 668-3971', 'sofiy.mikeeva@example.net', 'Impedit autem repellendus minima consequatur voluptatibus ea.', 'new', '2026-02-23 09:32:40'),
(28, 3, 3, 'Медведев Ян Дмитриевич', '+7 (922) 183-6387', 'omikailova@example.com', 'Cum aliquid aliquam repellat repudiandae cumque aut sit nihil et.', 'new', '2026-02-23 09:32:40'),
(29, 13, 7, 'Карпова Ефим Фёдорович', '(495) 844-9890', 'sprokorov@example.net', 'Repellat tenetur blanditiis doloremque omnis quisquam in sed.', 'new', '2026-02-23 09:32:40'),
(30, 13, 6, 'Дорофеев Ираклий Львович', '8-800-602-9545', 'lysy.stepanova@example.org', 'Officia laborum pariatur ullam molestias sit ut.', 'new', '2026-02-23 09:32:40'),
(31, 6, 7, 'Гордей Львович Ермакова', '8-800-527-9357', 'martynova.gleb@example.com', 'Quam similique nisi corrupti atque sit voluptas mollitia.', 'new', '2026-02-23 09:32:40'),
(32, 10, 12, 'Киселёваа Варвара Львовна', '(35222) 58-4910', 'lydmila.kononova@example.net', 'Et qui accusantium facilis eius excepturi aliquam.', 'new', '2026-02-23 09:32:40'),
(33, 3, 12, 'Егорова Артём Максимович', '(495) 227-3716', 'zukova.vasilisa@example.org', 'Sit ea alias deserunt corporis quo voluptatum rerum incidunt beatae eius.', 'new', '2026-02-23 09:32:40'),
(34, 11, 7, 'Артур Львович Муравьёв', '(495) 337-3170', 'diana.gromov@example.org', 'Ut pariatur alias a et vero eos.', 'new', '2026-02-23 09:32:40'),
(35, 4, 5, 'Большакова Валерия Ивановна', '(812) 677-49-99', 'zukova.milan@example.com', 'Temporibus sapiente rerum dolores qui voluptates inventore labore expedita dolore molestias.', 'new', '2026-02-23 09:32:40'),
(36, 16, 7, 'Эмилия Ивановна Макароваа', '(35222) 69-1788', 'lev.zueva@example.com', 'Et doloremque eum voluptas cumque nobis ab architecto ex dolor beatae.', 'new', '2026-02-23 09:32:40'),
(37, 10, 3, 'Шубина Милан Андреевич', '8-800-520-5986', 'zinaida40@example.com', 'Et velit qui nisi culpa doloremque laudantium.', 'new', '2026-02-23 09:32:40'),
(38, 12, 4, 'Гурьева Людмила Львовна', '(35222) 15-3464', 'sergei.merkusev@example.com', 'Pariatur enim odio placeat sit saepe voluptas veritatis molestias dolores.', 'new', '2026-02-23 09:32:40'),
(39, 3, 4, 'Самойловаа Яна Владимировна', '(812) 654-14-63', 'gavrilov.galina@example.org', 'Eum non suscipit nihil veritatis sed nulla nemo.', 'new', '2026-02-23 09:32:40'),
(40, 8, 11, 'Инесса Борисовна Сергеева', '(812) 650-97-56', 'ersov.ulyna@example.org', 'Quam dolor dolor hic cupiditate magnam minima et beatae id.', 'new', '2026-02-23 09:32:40'),
(41, 17, 5, 'Всеволод Львович Русакова', '8-800-495-0927', 'yna42@example.net', 'Quis voluptatem qui culpa qui rem numquam qui voluptates ut.', 'new', '2026-02-23 09:32:40'),
(42, 9, 7, 'Ева Борисовна Васильеваа', '8-800-801-7407', 'rybova.dina@example.net', 'Commodi sit cumque aut aut cum.', 'new', '2026-02-23 09:32:40'),
(43, 5, 10, 'Воробьёва Розалина Евгеньевна', '(812) 628-36-61', 'rartemev@example.net', 'Illo placeat et et aliquam consequatur et et quia.', 'new', '2026-02-23 09:32:40'),
(44, 8, 8, 'Поляков Владислав Алексеевич', '(35222) 55-4364', 'rybova.vsevolod@example.net', 'Sunt minus vero magnam aliquid quaerat mollitia omnis quis.', 'new', '2026-02-23 09:32:40'),
(45, 9, 12, 'Добрыня Львович Евдокимов', '(35222) 71-5554', 'konstantin92@example.com', 'Possimus aut dolores aut quidem quia rerum natus excepturi delectus officiis.', 'new', '2026-02-23 09:32:40'),
(46, 12, 5, 'Поляков Бронислав Алексеевич', '(812) 029-54-98', 'gorbunova.radislav@example.net', 'Ut repellat eveniet qui velit voluptatem quis tempore iste deleniti voluptas.', 'new', '2026-02-23 09:32:40'),
(47, 12, 5, 'Ковалёв Владимир Романович', '(35222) 51-3579', 'ykov.fomiceva@example.com', 'Cupiditate et ratione quaerat perspiciatis iste nobis ut facilis aut quae.', 'new', '2026-02-23 09:32:40'),
(48, 14, 5, 'Коновалова Артемий Иванович', '(35222) 17-0962', 'nestor21@example.com', 'Totam est voluptates excepturi consequatur laudantium dolorem ut.', 'new', '2026-02-23 09:32:40'),
(49, 12, 7, 'Дмитриев Егор Борисович', '(35222) 08-8566', 'ivan34@example.org', 'Neque consequatur neque nihil maxime facere tempora voluptatem nam aut.', 'new', '2026-02-23 09:32:40'),
(50, 14, 4, 'Всеволод Андреевич Трофимова', '(495) 002-3013', 'rafail.vladimirova@example.org', 'Quidem laudantium quia sint sit vitae maxime ex ut.', 'new', '2026-02-23 09:32:40'),
(51, 13, 9, 'Родионов Станислав Сергеевич', '(495) 017-0603', 'olga55@example.net', 'Occaecati natus consequatur deserunt natus alias ab voluptatem.', 'new', '2026-02-23 09:32:40');

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
(1, 'Toyota', 'Camry', 2020, '2500000.00', 45000, 'Automatic', 'Petrol', 10, 'https://example.com/camry.jpg', '2026-02-16 11:09:56'),
(2, 'BMW', 'X5', 2019, '4200000.00', 60000, 'Automatic', 'Diesel', 8, 'https://example.com/x5.jpg', '2026-02-16 11:09:56'),
(3, 'Toyota', 'Camry', 2019, '4894304.00', 86979, 'Manual', 'Diesel', 52, 'https://picsum.photos/seed/145/600/400', '2026-02-23 09:32:40'),
(4, 'Toyota', 'E-Class', 2016, '1126952.00', 18835, 'Automatic', 'Petrol', 38, 'https://picsum.photos/seed/300/600/400', '2026-02-23 09:32:40'),
(5, 'Kia', 'RX', 2018, '4046009.00', 87968, 'Automatic', 'Hybrid', 19, 'https://picsum.photos/seed/445/600/400', '2026-02-23 09:32:40'),
(6, 'Lexus', 'E-Class', 2020, '1120521.00', 55166, 'Automatic', 'Hybrid', 9, 'https://picsum.photos/seed/422/600/400', '2026-02-23 09:32:40'),
(7, 'Kia', 'RX', 2015, '3571411.00', 20101, 'Manual', 'Diesel', 62, 'https://picsum.photos/seed/512/600/400', '2026-02-23 09:32:40'),
(8, 'Audi', 'A6', 2017, '5789757.00', 64321, 'Manual', 'Hybrid', 50, 'https://picsum.photos/seed/219/600/400', '2026-02-23 09:32:40'),
(9, 'Mercedes', 'Camry', 2017, '5606919.00', 83059, 'Manual', 'Diesel', 61, 'https://picsum.photos/seed/623/600/400', '2026-02-23 09:32:40'),
(10, 'Audi', 'E-Class', 2018, '1445388.00', 143372, 'Manual', 'Hybrid', 67, 'https://picsum.photos/seed/606/600/400', '2026-02-23 09:32:40'),
(11, 'Audi', 'Sportage', 2017, '821379.00', 30267, 'Manual', 'Petrol', 13, 'https://picsum.photos/seed/237/600/400', '2026-02-23 09:32:40'),
(12, 'Mercedes', 'Elantra', 2015, '2970650.00', 26170, 'Automatic', 'Petrol', 21, 'https://picsum.photos/seed/759/600/400', '2026-02-23 09:32:40'),
(13, 'Kia', 'X5', 2018, '1533091.00', 57066, 'Manual', 'Petrol', 58, 'https://picsum.photos/seed/758/600/400', '2026-02-23 09:32:40'),
(14, 'Toyota', 'A6', 2021, '2883276.00', 95100, 'Manual', 'Diesel', 100, 'https://picsum.photos/seed/359/600/400', '2026-02-23 09:32:40'),
(15, 'Audi', 'RX', 2019, '5225997.00', 122080, 'Automatic', 'Diesel', 46, 'https://picsum.photos/seed/550/600/400', '2026-02-23 09:32:40'),
(16, 'Mercedes', 'E-Class', 2023, '1758569.00', 114500, 'Manual', 'Petrol', 67, 'https://picsum.photos/seed/541/600/400', '2026-02-23 09:32:40'),
(17, 'Mercedes', 'Elantra', 2016, '1656707.00', 15034, 'Automatic', 'Diesel', 79, 'https://picsum.photos/seed/998/600/400', '2026-02-23 09:32:40');

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
(1, 1, 'Registered', '2020-05-10'),
(2, 1, 'Changed owner', '2022-03-15'),
(3, 3, 'Accident repair', '1986-12-18'),
(4, 3, 'Changed owner', '1977-03-11'),
(5, 3, 'Accident repair', '2005-06-10'),
(6, 4, 'Registered', '1988-07-04'),
(7, 4, 'Registered', '2010-02-08'),
(8, 4, 'Registered', '2017-12-29'),
(9, 5, 'Changed owner', '1998-12-25'),
(10, 5, 'Accident repair', '1990-01-10'),
(11, 5, 'Changed owner', '1987-05-10'),
(12, 6, 'Accident repair', '1985-04-22'),
(13, 6, 'Inspection passed', '1985-06-08'),
(14, 6, 'Inspection passed', '2018-11-26'),
(15, 7, 'Registered', '1999-07-17'),
(16, 7, 'Registered', '1985-05-15'),
(17, 7, 'Inspection passed', '2021-04-24'),
(18, 8, 'Registered', '1970-07-22'),
(19, 8, 'Accident repair', '2000-03-24'),
(20, 8, 'Accident repair', '1998-03-25'),
(21, 9, 'Registered', '1997-07-22'),
(22, 9, 'Registered', '1976-12-04'),
(23, 9, 'Changed owner', '2018-03-01'),
(24, 10, 'Changed owner', '2005-05-10'),
(25, 10, 'Inspection passed', '2014-01-11'),
(26, 10, 'Inspection passed', '1982-12-16'),
(27, 11, 'Registered', '1983-09-09'),
(28, 11, 'Inspection passed', '1981-10-19'),
(29, 11, 'Changed owner', '2011-10-09'),
(30, 12, 'Accident repair', '1995-07-12'),
(31, 12, 'Accident repair', '2016-09-01'),
(32, 12, 'Inspection passed', '2001-11-29'),
(33, 13, 'Registered', '1991-03-17'),
(34, 13, 'Accident repair', '2009-03-28'),
(35, 13, 'Accident repair', '2018-12-07'),
(36, 14, 'Inspection passed', '2011-10-28'),
(37, 14, 'Registered', '1979-06-14'),
(38, 14, 'Changed owner', '2003-04-16'),
(39, 15, 'Changed owner', '2010-02-24'),
(40, 15, 'Inspection passed', '2023-12-17'),
(41, 15, 'Inspection passed', '1999-12-19'),
(42, 16, 'Accident repair', '1999-07-05'),
(43, 16, 'Registered', '1972-09-25'),
(44, 16, 'Changed owner', '1991-12-02'),
(45, 17, 'Changed owner', '2016-01-21'),
(46, 17, 'Registered', '2003-12-16'),
(47, 17, 'Changed owner', '1981-08-23');

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
(1, 1, 'Anna Smirnova', 5, 'Excellent condition!', '2026-02-16 11:09:56'),
(2, 2, 'Ivan Petrov', 4, 'Good car but high mileage.', '2026-02-16 11:09:56'),
(3, 6, 'Прохоров Феликс Борисович', 4, 'Voluptas nostrum consequatur architecto pariatur recusandae impedit soluta. Molestiae consequatur suscipit non sit sapiente qui excepturi. Aut incidunt a perferendis sed non qui beatae voluptatum.', '2026-02-23 09:32:40'),
(4, 12, 'Панова Аким Дмитриевич', 3, 'Nobis error tempora unde animi porro optio reiciendis. Iusto voluptatem quod molestias doloremque corrupti. Sed sint aliquam pariatur quam.', '2026-02-23 09:32:40'),
(5, 8, 'Назарова Антонин Романович', 5, 'Quia maxime qui numquam nihil totam fuga voluptas. Impedit autem et laboriosam eaque. Quasi quos sit dolor sunt et voluptatem nisi.', '2026-02-23 09:32:40'),
(6, 6, 'Агафоноваа Кристина Львовна', 3, 'Explicabo qui excepturi voluptate at corporis non esse. Ut molestias et consectetur eveniet saepe error necessitatibus eum. Quia enim perferendis quas. Quisquam eos esse dolore magnam ipsam dignissimos libero.', '2026-02-23 09:32:40'),
(7, 5, 'Люся Сергеевна Вишняковаа', 3, 'Et sunt vel qui amet perspiciatis officia enim. Et voluptas quidem quasi. Et ex quae dolor nisi error.', '2026-02-23 09:32:40'),
(8, 13, 'Абрам Фёдорович Медведева', 4, 'Neque dolorum doloremque laboriosam nemo totam et architecto. Minima dignissimos autem cupiditate quibusdam id omnis voluptatem. Corporis rem distinctio dolores totam. Natus qui minus dolorem et iste.', '2026-02-23 09:32:40'),
(9, 15, 'Викентий Евгеньевич Гришина', 3, 'Dolores voluptas dignissimos rerum quis harum officiis voluptatem sit. Voluptas dolores illo similique voluptates. Doloribus molestias quasi adipisci qui natus beatae. Dolor quis temporibus quasi est incidunt eaque nesciunt.', '2026-02-23 09:32:40'),
(10, 13, 'Киселёва Елена Максимовна', 4, 'Ea dicta autem et. Possimus quia harum nisi aut eveniet dolor. Temporibus recusandae et fugit non. Veniam minus non est aut et.', '2026-02-23 09:32:40'),
(11, 16, 'Богданова Лев Владимирович', 5, 'Et eaque qui laboriosam iure iusto at. Et quia commodi dignissimos sunt eveniet. Sit laborum doloremque amet laborum. Consequuntur exercitationem perferendis voluptatem quisquam debitis temporibus vero.', '2026-02-23 09:32:40'),
(12, 15, 'Эмма Владимировна Константинова', 3, 'Eaque recusandae animi ducimus voluptatem. Aperiam aperiam facere ut. Praesentium voluptatem voluptatem nihil aut neque adipisci. Temporibus ab dolores dolorem perferendis vel aliquam fuga quod. Nisi molestiae doloribus quaerat aut molestias velit.', '2026-02-23 09:32:40'),
(13, 17, 'Меркушева Артём Андреевич', 3, 'Molestias qui voluptatem ipsam harum debitis necessitatibus. Aut ex ut alias assumenda aut perferendis.', '2026-02-23 09:32:40'),
(14, 8, 'Васильеваа Анжелика Романовна', 5, 'Quisquam aliquid nesciunt ad quia autem quisquam. Sint voluptatibus excepturi quibusdam est qui adipisci eius. Corrupti et aliquid vel ratione laboriosam.', '2026-02-23 09:32:40'),
(15, 11, 'Николай Иванович Гуляева', 5, 'Tempore quo similique hic explicabo. Amet voluptatem sequi eligendi enim officiis voluptas. Et qui rem doloribus porro doloremque in. Omnis tempora molestias dolores veniam vitae est.', '2026-02-23 09:32:40'),
(16, 5, 'Жданов Ираклий Владимирович', 3, 'Quas sunt velit deleniti molestias quasi. Voluptatem omnis quae doloribus saepe. Repellat aut qui esse qui.', '2026-02-23 09:32:40'),
(17, 5, 'Эльвира Евгеньевна Журавлёваа', 3, 'Reprehenderit omnis animi earum. Voluptatibus placeat sed nulla sit amet sit quo. Expedita itaque consequatur quia tempora autem est.', '2026-02-23 09:32:40'),
(18, 13, 'Яковлева Добрыня Фёдорович', 5, 'Perferendis vitae accusantium sint laudantium. Sapiente natus autem non earum. Et atque tenetur voluptas et corporis ipsum.', '2026-02-23 09:32:40'),
(19, 12, 'Анжелика Алексеевна Колобоваа', 3, 'Minus non fugiat repudiandae praesentium. Autem et qui dignissimos consequatur eligendi magni. Laborum quo sit voluptatem. Aspernatur reiciendis quisquam quia ullam voluptas.', '2026-02-23 09:32:40'),
(20, 5, 'Кудряшова Лидия Романовна', 4, 'Ut et facilis et voluptatem saepe sed. Dolores placeat delectus quam nulla architecto id. Ut voluptate rerum aut. Necessitatibus hic sint autem facere nihil quia.', '2026-02-23 09:32:40'),
(21, 3, 'Альберт Александрович Туров', 4, 'Ipsa labore quis dolorem. Veniam porro minus quia hic tenetur sit. Voluptas at impedit vitae atque. Fuga veritatis pariatur autem sed neque.', '2026-02-23 09:32:40'),
(22, 7, 'Денисов Ираклий Дмитриевич', 3, 'Qui ut cum corporis est aut quidem. Numquam nihil veniam corporis doloremque.', '2026-02-23 09:32:40'),
(23, 10, 'Изольда Андреевна Петухова', 3, 'Itaque asperiores magni officia. Necessitatibus hic distinctio a qui inventore est eum. Officia sit voluptates sequi officia quibusdam id ullam. Enim vitae magni perferendis voluptatum sint.', '2026-02-23 09:32:40'),
(24, 10, 'Тетерина Марта Ивановна', 4, 'Dolorum voluptas quia maiores autem omnis. Commodi similique quam magnam et ad in hic.', '2026-02-23 09:32:40'),
(25, 10, 'Аполлон Львович Большакова', 3, 'Voluptatum dolorem reiciendis id impedit eligendi ab. Aliquid rerum aut ut quod soluta.', '2026-02-23 09:32:40'),
(26, 8, 'Дмитриева Тарас Львович', 5, 'Blanditiis libero eligendi voluptates architecto quia quod. Suscipit totam officia et quasi doloremque quos et est.', '2026-02-23 09:32:40'),
(27, 3, 'Яна Максимовна Юдина', 5, 'Ut quam sint est nam. Consequatur optio accusamus veritatis.', '2026-02-23 09:32:40'),
(28, 6, 'Лидия Ивановна Носковаа', 4, 'Rerum omnis iure ea modi numquam quasi. Quis aut soluta atque maxime tenetur iste accusamus. Beatae ab voluptas dolores rerum tenetur qui dicta. Et est non repellat molestiae dolores.', '2026-02-23 09:32:40'),
(29, 13, 'София Ивановна Кузнецоваа', 3, 'Maxime hic corporis distinctio qui quo ipsa. Doloribus necessitatibus id earum et aut. In vitae consequatur voluptatem cum velit vero in fugiat.', '2026-02-23 09:32:40'),
(30, 17, 'Иванов Вячеслав Дмитриевич', 4, 'Laborum aut quos est ab error. Aut saepe rerum autem nostrum dolor quibusdam asperiores. Temporibus debitis doloribus qui accusantium.', '2026-02-23 09:32:40'),
(31, 9, 'Харитонова Донат Андреевич', 5, 'Occaecati magnam dicta occaecati praesentium est velit optio tempore. Non modi ut at ipsa. Quibusdam non laborum quo sapiente voluptatem hic voluptas.', '2026-02-23 09:32:40'),
(32, 6, 'Пестова Альбина Максимовна', 3, 'Architecto praesentium minus excepturi vel quaerat voluptas. Accusamus impedit aliquid voluptatem aut ut sed. Expedita qui facilis aut voluptatem voluptatem. Architecto autem nemo occaecati atque.', '2026-02-23 09:32:40'),
(33, 4, 'Власова Геннадий Иванович', 4, 'Aliquid veniam quam sit corporis id occaecati libero quos. Nemo a tenetur recusandae dolore dolorem voluptate. Repellat magni dolor ipsa. Veritatis reiciendis dolor sit quia sit. Maiores excepturi omnis sed officiis et.', '2026-02-23 09:32:40'),
(34, 5, 'Изабелла Фёдоровна Виноградоваа', 4, 'Deleniti veniam aut ex consequatur reprehenderit explicabo. Ipsum nobis autem consequatur non quia et. Magnam ut tempora corporis sit saepe sapiente vel.', '2026-02-23 09:32:40'),
(35, 8, 'Клавдия Андреевна Молчанова', 5, 'Sed eaque delectus id aut dolor impedit ducimus adipisci. Placeat dolores aut iste earum sit. Recusandae omnis culpa aut pariatur aliquid. Aut quidem odio sit iusto id.', '2026-02-23 09:32:40'),
(36, 6, 'Русакова Артемий Романович', 5, 'Ullam laboriosam et placeat harum. Rerum blanditiis velit minus rerum porro repudiandae molestiae.', '2026-02-23 09:32:40'),
(37, 3, 'Анжелика Фёдоровна Афанасьеваа', 3, 'Necessitatibus exercitationem expedita quo. Officia corporis enim ea laborum aut dolorem dolorum facere. Repellat reprehenderit odit occaecati nihil nihil sunt accusantium fugit. Animi aut ut cum ad illum placeat non.', '2026-02-23 09:32:40'),
(38, 3, 'Афанасий Алексеевич Рябов', 5, 'Recusandae sit mollitia nesciunt dolor magni. Est iste sed id. Sint tempora non voluptatem sunt est.', '2026-02-23 09:32:40'),
(39, 16, 'Коновалов Аполлон Андреевич', 4, 'Nihil aliquid quidem culpa vitae architecto tempore. Eum deserunt tenetur et debitis sunt sint saepe. Voluptatem illo rem non id.', '2026-02-23 09:32:40'),
(40, 4, 'Кошелева Герман Дмитриевич', 3, 'Qui voluptas impedit ut voluptatibus et ut eos. Molestias saepe at magni expedita aut. Nihil hic dolor alias et quia vel. A ipsam recusandae provident voluptatibus sed quod.', '2026-02-23 09:32:40'),
(41, 9, 'Леонид Львович Андреева', 5, 'Et et explicabo qui reiciendis molestiae a cum nisi. Dolore provident dolorem minus explicabo. Quam non ullam maxime qui culpa quas veritatis aspernatur. Fugiat maxime et pariatur provident voluptatibus.', '2026-02-23 09:32:40'),
(42, 15, 'Юдин Арсений Евгеньевич', 4, 'Asperiores non delectus excepturi. Voluptatum autem veritatis nesciunt et. Officiis culpa sint in impedit. Est voluptatem quis quod pariatur id.', '2026-02-23 09:32:40'),
(43, 14, 'Марат Львович Осипов', 3, 'Officiis aut quasi hic unde aut non voluptas quia. Quo aut nostrum dolor. Odit vero beatae maiores nesciunt et laudantium.', '2026-02-23 09:32:40'),
(44, 9, 'Молчанова Галина Ивановна', 5, 'Quisquam non dolores architecto voluptates. Aliquam iste recusandae voluptate nisi in eaque nostrum omnis. Vel itaque aliquam molestiae quia.', '2026-02-23 09:32:40'),
(45, 13, 'Гущин Артемий Алексеевич', 5, 'Similique soluta ad occaecati. Aut laborum voluptatem voluptas vero et. Quo aut impedit consequatur iusto maiores et. Qui aut autem expedita blanditiis harum.', '2026-02-23 09:32:40'),
(46, 8, 'Нонна Фёдоровна Громоваа', 5, 'Sit iusto vel adipisci alias voluptatum. Laborum dolor officiis voluptatem accusamus. Sit eaque ipsam facere perferendis quia laboriosam neque. Sit molestiae ut ratione sit maiores fuga.', '2026-02-23 09:32:40'),
(47, 3, 'Прохорова Антонин Борисович', 5, 'Et tempore est est. Sit rerum possimus iure dolorum. Ut perspiciatis sit officia et iste. Iure sit possimus natus eligendi quia dolor esse.', '2026-02-23 09:32:40'),
(48, 13, 'Белозёров Прохор Романович', 5, 'Asperiores sit aliquid quia molestias qui. Ut accusantium explicabo ab eligendi repellendus rerum. Suscipit vel rem veritatis labore consectetur. Sint est debitis molestiae consequatur laborum soluta.', '2026-02-23 09:32:40'),
(49, 5, 'Галина Алексеевна Исаеваа', 3, 'Eius et rerum nisi dolores exercitationem quo. Nisi odit tenetur fugiat amet error aliquid temporibus. Consequatur veniam adipisci non modi alias amet.', '2026-02-23 09:32:40'),
(50, 6, 'Морозоваа Клементина Борисовна', 3, 'At minima facere est est. Quia dolore vel et dolorem recusandae mollitia adipisci ex. Amet ut corporis rerum ducimus itaque.', '2026-02-23 09:32:40'),
(51, 4, 'Валентин Фёдорович Фёдорова', 5, 'Perspiciatis dolor in molestiae autem vel nesciunt voluptatum quos. Quibusdam eos magni soluta. Beatae sed ipsum vel ab est.', '2026-02-23 09:32:40'),
(52, 3, 'Вадим Владимирович Ситников', 4, 'Sit id nam minus dolores qui quia hic. Repellendus deleniti quaerat exercitationem quaerat vel.', '2026-02-23 09:32:40');

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
(1, 1, 'Oil change', '2023-01-10'),
(2, 2, 'Brake replacement', '2023-06-20'),
(3, 3, 'Brake replacement', '1972-08-08'),
(4, 3, 'Brake replacement', '1985-10-15'),
(5, 4, 'Oil change', '2022-07-13'),
(6, 4, 'Tire change', '2015-04-20'),
(7, 5, 'Brake replacement', '1981-05-23'),
(8, 5, 'Oil change', '2016-12-22'),
(9, 6, 'Tire change', '2017-05-20'),
(10, 6, 'Tire change', '2018-07-18'),
(11, 7, 'Tire change', '1977-10-27'),
(12, 7, 'Engine diagnostics', '2021-03-28'),
(13, 8, 'Brake replacement', '2000-08-19'),
(14, 8, 'Brake replacement', '2018-06-10'),
(15, 9, 'Brake replacement', '1991-02-20'),
(16, 9, 'Brake replacement', '2008-03-10'),
(17, 10, 'Engine diagnostics', '1986-09-16'),
(18, 10, 'Tire change', '2012-04-13'),
(19, 11, 'Tire change', '2017-05-22'),
(20, 11, 'Oil change', '1990-07-14'),
(21, 12, 'Oil change', '1992-03-23'),
(22, 12, 'Oil change', '1971-07-15'),
(23, 13, 'Oil change', '2016-11-29'),
(24, 13, 'Oil change', '1993-10-31'),
(25, 14, 'Tire change', '1999-10-01'),
(26, 14, 'Tire change', '1987-05-13'),
(27, 15, 'Engine diagnostics', '2000-11-03'),
(28, 15, 'Oil change', '2018-12-31'),
(29, 16, 'Brake replacement', '1987-11-14'),
(30, 16, 'Brake replacement', '1991-06-25'),
(31, 17, 'Brake replacement', '1993-02-15'),
(32, 17, 'Engine diagnostics', '1972-02-09');

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
(13, '123', '123@mail.ru', '$2y$10$HpdVIb48JHzbR4XDOOzKqOJ0gFdgqoUF3D18BvGqxouTrsoXP59Rq', 'user', '2026-02-23 11:04:42'),
(14, '123', '123123@mail.ry', '$2y$10$ay/bqcSq2AZxgBvWI1WxGOGBwgJCvkYSSpEkxgxxANJDsigQ7QmhW', 'user', '2026-02-23 11:07:45'),
(15, '123123', '123123123@mail.ru', '$2y$10$vmJ.6p4Xaq0/ptiqi3Kph.6pHY104MYlNqejOZivekdDuvOJeZgse', 'user', '2026-02-23 11:08:24'),
(16, '123123123', '123123123123@mail.ru', '$2y$10$Rn5nP0M2Y1VJZmKPLa/naO823piSut3kefQ.H42p9iUFpOPwZGfEu', 'user', '2026-02-23 11:09:17'),
(17, 'ivan1@mail.com', 'ivan1@mail.com', '$2y$10$P0kBwFXF5sAa6yim4VSkyefACZeE0mVqQ8ioCw17X2wxyVEEI4CeO', 'user', '2026-02-23 11:10:03'),
(18, '12233', '12233@mail.ru', '$2y$10$6QBjpQ0fcJ6DkBd0s2vpwu8HrLo0eAaDL.eb3h.uek.A7R1YGFZ62', 'user', '2026-02-23 11:16:40'),
(19, 'пример1', 'primer1@mail.ru', '$2y$10$N.Fh31ZmUF1VGVkzy.kEaO.Y/WHYcN.FKNHU5moEuriQgyn0O33MC', 'user', '2026-02-23 11:18:52'),
(20, 'primer2@mail.ru', 'primer2@mail.ru', '$2y$10$k0jybrrVQQlxNRVQlul2KevFxTyIjqMk9fccnm//gV1bnkFwvDoHu', 'user', '2026-02-23 11:30:17'),
(21, 'Тестовый', 'Test1@mail.ru', '$2y$10$ZY/E8UrDeczCiUjNW6mfn.Lvxq6UFD9roLPARbL5TCMWR8x5VcMHq', 'user', '2026-03-02 13:04:26');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `car_reviews`
--
ALTER TABLE `car_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `car_service`
--
ALTER TABLE `car_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
