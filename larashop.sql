-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Авг 15 2023 г., 18:42
-- Версия сервера: 5.7.43
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `larashop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `baskets`
--

CREATE TABLE `baskets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `baskets`
--

INSERT INTO `baskets` (`id`, `created_at`, `updated_at`) VALUES
(1, '2023-08-15 10:16:04', '2023-08-15 12:05:22');

-- --------------------------------------------------------

--
-- Структура таблицы `basket_product`
--

CREATE TABLE `basket_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `basket_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `name`, `content`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Беговая дорожка GT 2270M', 'Беговая дорожка', 'Begovaya-dorozhka-GT-2270M', 'urzgwvVHO98Hgr0fKy5qaUKM0fZs0qGClT9uX0zu.jpg', '2023-08-15 10:51:35', '2023-08-15 10:51:35'),
(2, 'АйтиСервисМагазин', 'Сайт – лицо вашей компании в интернете.\r\nЭто мощнейший маркетинговый инструмент.\r\nАбсолютно любой пользователь может получить актуальную информацию', 'AjtiServisMagazin', 'yS8XfpTLu9IXqaqhrXirfUT4wNPdIYwkWcwzjAbe.jpg', '2023-08-15 11:51:52', '2023-08-15 11:51:52'),
(3, 'GARLYN L1000', 'Персональный бариста - всегда под рукой. По-настоящему компактная кофемашина с широким набором возможностей. Приготовление напитков одним касанием с настройкой рецептов по своему вкусу. Регулировка кр', 'GARLYN-L1000', 'A3Nntq8rilfUdV3c67jXqClby6yv75lMTDRs6Xht.png', '2023-08-15 12:00:32', '2023-08-15 12:00:32');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `content`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 0, 'Айти услуги', 'Профессиональный инструмент on-line продаж\r\nВам не нужно ничего придумывать. Дизайн и функционал вашего интернет-магазина уже готов. Выбирайте решение интернет-магазина, которое подойдет именно вам.', 'Ajti-uslugi', 'rlSly1KaeAmF4rZKI7lKcm9tvHBMDZgAilCuuEGk.jpg', '2023-08-15 10:21:49', '2023-08-15 11:57:16'),
(2, 0, 'Спортивные товары', 'У нас большое наименование товаров что может вас обрадовать, а вещи прослужат долго так как хорошего качества и брендовых фирм!', 'Sportivnye-tovary', 'PgM3oXv9VBq9SY2dt9a32Y0bQhRmLu4BCIynI4sb.jpg', '2023-08-15 10:28:46', '2023-08-15 10:28:46'),
(3, 0, 'Бытовая техника', 'Широкий выбор бытовой техники! Все для дома и все для вас дорогие покупатели и посетители!', 'Bytovaya-tehnika', 'JrA7RLrFDXitBKyRrzryklEgCKoqFW1phOOqqhTt.png', '2023-08-15 11:04:11', '2023-08-15 11:04:11');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2023_00_28_130327_create_categories_table', 1),
(5, '2023_00_28_130335_create_brands_table', 1),
(6, '2023_00_28_130346_create_products_table', 1),
(7, '2023_00_29_120033_create_baskets_table', 1),
(8, '2023_00_30_120730_create_basket_product_table', 1),
(9, '2023_01_00_081701_alter_users_table', 1),
(10, '2023_01_01_055603_create_orders_table', 1),
(11, '2023_01_01_061729_create_order_items_table', 1),
(12, '2023_01_01_062083_alter_orders_table', 1),
(13, '2023_01_01_063337_create_pages_table', 1),
(14, '2023_01_01_064359_create_profiles_table', 1),
(15, '2023_01_28_101100_alter_products_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `comment`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Rinat', 'user@mail.ru', '87051260410', 'Kaz', 'iiyu', 267652.00, 3, '2023-08-15 10:59:30', '2023-08-15 11:00:41');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `cost` decimal(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `price`, `quantity`, `cost`) VALUES
(1, 1, 1, 'Беговая дорожка GT 2270M', 267652.00, 1, 267652.00);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `parent_id`, `name`, `content`, `slug`, `created_at`, `updated_at`) VALUES
(1, 0, 'INETSHOP', '<h1 style=\"margin: 10px 0px; padding: 0px; font-size: 25px; font-weight: bold; line-height: 1.4em; color: rgb(207, 112, 0); font-family: Roboto, sans-serif; outline: none !important;\">ведущий казахстанский интернет-магазин c доставкой по всему Казахстану</h1><p style=\"margin-right: 0px; margin-bottom: 5px; margin-left: 0px; padding: 0px; line-height: 1.5em; color: rgb(0, 0, 0); font-family: Roboto, sans-serif; font-size: 14px; outline: none !important;\">В&nbsp; 2023 году мы решили, что совершать покупки онлайн должно быть легко и приятно. Все эти годы мы занимались любимым делом и совершенствовались — все как для себя. И на сегодняшний день наша компания стала одним из лидирующих интернет-магазинов в Казахстане.</p><p><br style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: Roboto, sans-serif; font-size: 14px; outline: none !important;\"><b style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: Roboto, sans-serif; font-size: 14px; outline: none !important;\">Мы не останавливаемся на достигнутом!</b><br style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: Roboto, sans-serif; font-size: 14px; outline: none !important;\"><br style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: Roboto, sans-serif; font-size: 14px; outline: none !important;\"><span style=\"color: rgb(0, 0, 0); font-family: Roboto, sans-serif; font-size: 14px;\">Наш ассортимент непрерывно растет. Это значит, что у нас еще больше качественных, интересных и полезных товаров!</span></p><p><span style=\"color: rgb(0, 0, 0); font-family: Roboto, sans-serif; font-size: 14px;\"><br></span></p>', 'INETSHOP', '2023-08-15 13:39:04', '2023-08-15 13:39:04');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  `hit` tinyint(1) NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `content`, `slug`, `image`, `price`, `sale`, `hit`, `new`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Беговая дорожка GT 2270M', NULL, 'Begovaya-dorozhka-GT-2270M', 'zjOSJnYAoPjNHiF7I2bcEmmKa7vROMMQTLoKWjor.jpg', 267652.00, 0, 0, 1, '2023-08-15 10:54:07', '2023-08-15 10:54:07'),
(2, 1, 2, 'Интернет магазин', 'Вам не нужно ничего придумывать. Дизайн и функционал вашего интернет-магазина уже готов. Выбирайте решение интернет-магазина, которое подойдет именно вам.', 'Internet-magazin', 'wuEqOCbR2FiLJMzU39jWJjV9CduNmDItfeuaOk3Q.jpg', 150000.00, 0, 1, 1, '2023-08-15 11:58:26', '2023-08-15 11:58:26'),
(3, 3, 3, 'GARLYN L1000', 'Персональный бариста - всегда под рукой. По-настоящему компактная кофемашина с широким набором возможностей. Приготовление напитков одним касанием с настройкой рецептов по своему вкусу. Регулировка крепости кофе и тонкости помола.', 'GARLYN-L1000', 'nqiucGnhCyXIN50MIWzHLzN4VF6DvUddRehPlxm4.png', 80000.00, 1, 0, 0, '2023-08-15 12:03:06', '2023-08-15 12:03:06');

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Rinat Sarmuldin', 'ura07srr@gmail.com', 1, NULL, '$2y$10$X0X33RiLCyRY7ksxi3nvducX8fwOqgEY2AeEi6wY4gYxgq6vQj1i6', NULL, '2023-08-15 13:31:05', '2023-08-15 13:31:05');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `basket_product`
--
ALTER TABLE `basket_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `basket_product_basket_id_foreign` (`basket_id`),
  ADD KEY `basket_product_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Индексы таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `baskets`
--
ALTER TABLE `baskets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `basket_product`
--
ALTER TABLE `basket_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `basket_product`
--
ALTER TABLE `basket_product`
  ADD CONSTRAINT `basket_product_basket_id_foreign` FOREIGN KEY (`basket_id`) REFERENCES `baskets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `basket_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
