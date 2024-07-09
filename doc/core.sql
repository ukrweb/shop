-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 18 2019 г., 21:46
-- Версия сервера: 5.7.26-log
-- Версия PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `core`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `oc_category_id` int(11) DEFAULT NULL,
  `category_name` varchar(155) DEFAULT NULL,
  `margin_percent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `margin_fix` decimal(10,2) NOT NULL DEFAULT '0.00',
  `category_parent_id` int(10) UNSIGNED DEFAULT NULL,
  `category_enable` int(2) DEFAULT NULL,
  `status` int(2) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=2340 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `contragent`
--

CREATE TABLE `contragent` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  `unrestricted_value` varchar(255) NOT NULL DEFAULT '',
  `data_address_value` varchar(255) NOT NULL DEFAULT '',
  `data_address_unrestricted_value` varchar(255) NOT NULL DEFAULT '',
  `data_address_data_source` varchar(255) NOT NULL DEFAULT '',
  `data_address_data_qc` tinyint(4) DEFAULT NULL,
  `data_branch_count` smallint(6) NOT NULL DEFAULT '0',
  `data_branch_type` varchar(16) NOT NULL DEFAULT '',
  `data_inn` bigint(20) DEFAULT NULL,
  `data_kpp` bigint(20) DEFAULT NULL,
  `data_ogrn` bigint(20) DEFAULT NULL,
  `data_ogrn_date` varchar(10) NOT NULL DEFAULT '',
  `data_hid` varchar(255) NOT NULL DEFAULT '',
  `data_management_name` varchar(255) NOT NULL DEFAULT '',
  `data_management_post` varchar(255) NOT NULL DEFAULT '',
  `data_name_full_with_opf` varchar(255) NOT NULL DEFAULT '',
  `data_name_short_with_opf` varchar(255) NOT NULL DEFAULT '',
  `data_name_latin` varchar(255) NOT NULL DEFAULT '',
  `data_name_full` varchar(255) NOT NULL DEFAULT '',
  `data_name_short` varchar(255) NOT NULL DEFAULT '',
  `data_okpo` bigint(20) DEFAULT NULL,
  `data_okved` varchar(12) NOT NULL DEFAULT '',
  `data_okved_type` bigint(20) DEFAULT NULL,
  `data_opf_code` int(6) DEFAULT NULL,
  `data_opf_full` varchar(255) NOT NULL DEFAULT '',
  `data_opf_short` varchar(255) NOT NULL DEFAULT '',
  `data_opf_type` smallint(6) DEFAULT NULL,
  `data_state_actuality_date` varchar(10) NOT NULL DEFAULT '',
  `data_state_registration_date` varchar(10) NOT NULL DEFAULT '',
  `data_state_liquidation_date` varchar(10) NOT NULL DEFAULT '',
  `data_state_status` varchar(16) NOT NULL DEFAULT '',
  `data_type` varchar(16) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `supplier_delivery_time` tinyint(4) NOT NULL DEFAULT '0',
  `margin_percent` decimal(6,2) NOT NULL DEFAULT '0.00',
  `margin_fix` decimal(8,2) NOT NULL DEFAULT '0.00',
  `supplier_update_id` int(10) UNSIGNED DEFAULT NULL,
  `supplier_update_interval` int(11) NOT NULL DEFAULT '0',
  `sipplier_enable` int(2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `default_contragent_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=4096 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `supplier_category`
--

CREATE TABLE `supplier_category` (
  `supplier_category_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `supplier_category_name` varchar(255) DEFAULT NULL,
  `datetime_update` datetime DEFAULT NULL,
  `supplier_category_enable` int(2) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=110 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `supplier_stock`
--

CREATE TABLE `supplier_stock` (
  `supplier_stock_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `stock_name` varchar(50) NOT NULL,
  `delivery_time` int(10) UNSIGNED DEFAULT NULL,
  `margin_fix` decimal(6,2) NOT NULL DEFAULT '0.00',
  `margin_percent` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=780 DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `fk_category_category1_idx` (`category_parent_id`);

--
-- Индексы таблицы `contragent`
--
ALTER TABLE `contragent`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `fk_suppliers_suppliers_updates1_idx` (`supplier_update_id`);

--
-- Индексы таблицы `supplier_category`
--
ALTER TABLE `supplier_category`
  ADD PRIMARY KEY (`supplier_category_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Индексы таблицы `supplier_stock`
--
ALTER TABLE `supplier_stock`
  ADD PRIMARY KEY (`supplier_stock_id`),
  ADD KEY `supplier_id_idx` (`supplier_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `contragent`
--
ALTER TABLE `contragent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `supplier_category`
--
ALTER TABLE `supplier_category`
  MODIFY `supplier_category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `supplier_stock`
--
ALTER TABLE `supplier_stock`
  MODIFY `supplier_stock_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
