-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 07 2022 г., 16:29
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `my_project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `plus` int NOT NULL DEFAULT '0',
  `minus` int NOT NULL DEFAULT '0',
  `plus_by` text COLLATE utf8mb4_general_ci,
  `minus_by` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `followers_table`
--

CREATE TABLE `followers_table` (
  `id` int NOT NULL,
  `follower_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `author_email` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `followers_table`
--

INSERT INTO `followers_table` (`id`, `follower_email`, `author_email`) VALUES
(70, 'farabara066@gmail.com', 'levon.ovnanian@gmail.com,admin@admin.com'),
(71, 'levon.ovnanian@gmail.com', 'admin@admin.com,levon.ovnanian@gmail.com,farabara066@gmail.com');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `icon_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nickname` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `icon_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'person-1824144.svg',
  `email_send_if_article` tinyint NOT NULL DEFAULT '0',
  `email_send_if_comment` tinyint NOT NULL DEFAULT '0',
  `email_send_if_add_follower` tinyint NOT NULL DEFAULT '0',
  `email_send_if_dell_follower` tinyint NOT NULL DEFAULT '0',
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('active','limited','blocked') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auth_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `is_confirmed`, `icon_path`, `email_send_if_article`, `email_send_if_comment`, `email_send_if_add_follower`, `email_send_if_dell_follower`, `role`, `status`, `password_hash`, `auth_token`, `created_at`, `rating`) VALUES
(1, 'admin', 'admin@admin.com', 1, 'person-1824144.svg', 0, 0, 0, 0, 'admin', 'active', '$2y$10$9/pSD4o1NEHu7g40fPkkKOi67t.23fBY19ubL8MMv3eS5ufM5QerS', 'f9d0ea9de45b99f1144ef5f510f0d3eeadb01cd9509c291a1ebb55335c937ac0210b2af52dcbf6d5', '2021-11-16 17:10:44', 1),
(3, 'Ana', 'levon.ovnanian@gmail.com', 1, 'person-1824144.svg', 0, 0, 0, 0, 'user', 'active', '$2y$10$pa5JYkh6FKefuWYZpMNBAub741wPSod3jDufuVj7RaerOVzpyuXKq', '448a8bb5be8614d9835f5ae231b7e5844fa4b4c2ec53d97ffc16cf79e326f7b6aa3c30993a3fe9e1', '2021-09-30 15:33:27', 0),
(16, 'Uliana', 'farabara066@gmail.com', 1, 'person-1824144.svg', 0, 0, 0, 0, 'user', 'active', '$2y$10$.IyyNQ5x04fdOF1bSp4mXO7U4sPLfkCpkbR3LrG.65mLkvWgxN3oe', '9061d471a8c778f20db7bc443b38ec678f701cdee74661c234a04198b31d36887fa3f738e016665b', '2021-12-21 16:00:40', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_activation_codes`
--

CREATE TABLE `users_activation_codes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `users_comments`
--

CREATE TABLE `users_comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `article_id` int NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `redacted_at` datetime DEFAULT NULL,
  `source_comment_id` int DEFAULT NULL,
  `comment_key` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `plus` mediumint NOT NULL DEFAULT '0',
  `minus` mediumint NOT NULL DEFAULT '0',
  `plus_by` text,
  `minus_by` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `followers_table`
--
ALTER TABLE `followers_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nickname` (`nickname`) USING BTREE;

--
-- Индексы таблицы `users_activation_codes`
--
ALTER TABLE `users_activation_codes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_comments`
--
ALTER TABLE `users_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=584;

--
-- AUTO_INCREMENT для таблицы `followers_table`
--
ALTER TABLE `followers_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `users_activation_codes`
--
ALTER TABLE `users_activation_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `users_comments`
--
ALTER TABLE `users_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
