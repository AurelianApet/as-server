-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2021-01-21 07:46:21
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- 表的结构 `active_pages`
--

CREATE TABLE IF NOT EXISTS `active_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `active_pages`
--

INSERT INTO `active_pages` (`id`, `name`, `enabled`) VALUES
(1, 'blog', 1);

-- --------------------------------------------------------

--
-- 表的结构 `attachs`
--

CREATE TABLE IF NOT EXISTS `attachs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `time_update` int(11) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `categorie` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `procurement` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `attachs_translations`
--

CREATE TABLE IF NOT EXISTS `attachs_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `price` varchar(20) NOT NULL,
  `serial_number` varchar(20) NOT NULL,
  `abbr` varchar(5) NOT NULL,
  `for_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `attach_categories`
--

CREATE TABLE IF NOT EXISTS `attach_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sub_for` int(11) NOT NULL,
  `position` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `attach_categories`
--

INSERT INTO `attach_categories` (`id`, `sub_for`, `position`) VALUES
(1, 0, 0),
(2, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `attach_categories_translations`
--

CREATE TABLE IF NOT EXISTS `attach_categories_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `abbr` varchar(5) NOT NULL,
  `for_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `attach_categories_translations`
--

INSERT INTO `attach_categories_translations` (`id`, `name`, `abbr`, `for_id`) VALUES
(1, 'attach1', 'en', 1),
(2, 'attach2', 'en', 2);

-- --------------------------------------------------------

--
-- 表的结构 `bank_accounts`
--

CREATE TABLE IF NOT EXISTS `bank_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_for` int(11) NOT NULL,
  `position` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `categories`
--

INSERT INTO `categories` (`id`, `sub_for`, `position`) VALUES
(1, 0, 0),
(2, 0, 0),
(3, 0, 0),
(4, 0, 0),
(5, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `categories_translations`
--

CREATE TABLE IF NOT EXISTS `categories_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `abbr` varchar(5) NOT NULL,
  `for_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `categories_translations`
--

INSERT INTO `categories_translations` (`id`, `name`, `abbr`, `for_id`) VALUES
(2, 'category1', 'en', 1),
(3, 'category2', 'en', 2),
(4, 'category3', 'en', 3),
(5, 'category4', 'en', 4),
(6, 'category5', 'en', 5);

-- --------------------------------------------------------

--
-- 表的结构 `chat_history`
--

CREATE TABLE IF NOT EXISTS `chat_history` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `from_id` int(11) unsigned NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `to_name` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `is_file` tinyint(1) NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `confirm_links`
--

CREATE TABLE IF NOT EXISTS `confirm_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` char(32) NOT NULL,
  `for_order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `guide_list`
--

CREATE TABLE IF NOT EXISTS `guide_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `setup_guide` longtext CHARACTER SET utf8 NOT NULL,
  `categorie` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `guide_list`
--

INSERT INTO `guide_list` (`id`, `image`, `title`, `setup_guide`, `categorie`, `date`) VALUES
(1, 'Hydrangeas.jpg', 'guide1', '<p>this is guide1</p>\r\n', 1, '2021-01-13 10:28:07');

-- --------------------------------------------------------

--
-- 表的结构 `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `currencyKey` varchar(5) NOT NULL,
  `flag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `languages`
--

INSERT INTO `languages` (`id`, `abbr`, `name`, `currency`, `currencyKey`, `flag`) VALUES
(1, 'en', 'english', '$', 'USD', 'en.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'point to public_users ID',
  `products` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `referrer` varchar(255) NOT NULL,
  `clean_referrer` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `paypal_status` varchar(10) DEFAULT NULL,
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'viewed status is change when change processed status',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `discount_code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `orders_clients`
--

CREATE TABLE IF NOT EXISTS `orders_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `notes` text NOT NULL,
  `for_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder` int(10) unsigned DEFAULT NULL COMMENT 'folder with images',
  `image` varchar(255) NOT NULL,
  `time` int(10) unsigned NOT NULL COMMENT 'time created',
  `time_update` int(10) unsigned NOT NULL COMMENT 'time updated',
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `categorie` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `procurement` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `folder`, `image`, `time`, `time_update`, `visibility`, `categorie`, `quantity`, `procurement`, `url`, `position`, `vendor_id`) VALUES
(1, NULL, 'userfile2.png', 1611197636, 0, 1, 1, 1, 5, 'Algorithm', 0, 0),
(2, NULL, 'Penguins1.jpg', 1611201136, 1611201148, 1, 3, 123, 0, 'product3', 0, 0),
(3, NULL, 'Winter1.jpg', 1611201275, 0, 1, 5, 1221, 0, 'product5', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `products_translations`
--

CREATE TABLE IF NOT EXISTS `products_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `price` varchar(20) NOT NULL,
  `serial_number` varchar(20) NOT NULL,
  `abbr` varchar(5) NOT NULL,
  `for_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `products_translations`
--

INSERT INTO `products_translations` (`id`, `title`, `description`, `price`, `serial_number`, `abbr`, `for_id`) VALUES
(1, 'Algorithm', 'Description', '123', '10-10', 'en', 1),
(2, 'product3', '<p>aaaaaaaaaa</p>\r\n', '12', '1223dsf', 'en', 2),
(3, 'product5', '<p>dddddddddddd</p>\r\n', '12', 'sdsadf', 'en', 3);

-- --------------------------------------------------------

--
-- 表的结构 `product_order`
--

CREATE TABLE IF NOT EXISTS `product_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `username` varchar(55) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_email` varchar(55) NOT NULL,
  `product_name` varchar(55) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  `pay_status` tinyint(1) NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `product_order`
--

INSERT INTO `product_order` (`id`, `user_id`, `username`, `address`, `user_email`, `product_name`, `product_id`, `pay_type`, `pay_status`, `viewed`, `status`, `date`) VALUES
(1, 3, 'user', 'user_address', 'aaa@aaa.com', 'Algorithm', 1, 'Cacao', 1, 0, 0, '2021-01-21 03:42:34'),
(6, 3, 'user', 'user_address', 'aaa@aaa.com', 'Algorithm', 1, 'Neighbour', 1, 0, 0, '2021-01-21 03:46:39'),
(7, 3, 'user', 'user_address', 'aaa@aaa.com', 'Algorithm', 1, 'Card', 1, 0, 0, '2021-01-21 03:46:55'),
(8, 3, 'user', 'user_address', 'aaa@aaa.com', 'Algorithm', 1, 'Card', 1, 0, 0, '2021-01-21 03:47:09'),
(9, 3, 'user', 'user_address', 'aaa@aaa.com', 'Algorithm', 1, 'Neighbour', 1, 0, 0, '2021-01-21 03:47:41');

-- --------------------------------------------------------

--
-- 表的结构 `question_chat_list`
--

CREATE TABLE IF NOT EXISTS `question_chat_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `question_chat_list`
--

INSERT INTO `question_chat_list` (`id`, `username`, `user_id`, `status`, `date`) VALUES
(3, 'user', '1', 0, '2021-01-21 02:27:52'),
(4, 'user', '3', 0, '2021-01-21 02:34:19'),
(5, 'user', '3', 0, '2021-01-21 02:34:42'),
(6, 'user', '3', 0, '2021-01-21 02:35:43'),
(7, 'user', '3', 0, '2021-01-21 02:36:25'),
(8, 'user', '3', 0, '2021-01-21 02:36:28'),
(9, 'algorithm', '4', 0, '2021-01-21 05:22:56');

-- --------------------------------------------------------

--
-- 表的结构 `repair_list`
--

CREATE TABLE IF NOT EXISTS `repair_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `request_id` int(12) unsigned NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sellername` varchar(255) CHARACTER SET utf8 NOT NULL,
  `seller_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` longtext CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` int(1) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sell_date` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `repair_list`
--

INSERT INTO `repair_list` (`id`, `request_id`, `username`, `user_address`, `sellername`, `seller_address`, `description`, `image`, `status`, `date`, `sell_date`) VALUES
(1, 1, 'username1', 'user_address1', 'sellername1', 'seller_address1', 'This is repair1', 'Jellyfish.jpg', 1, '2021-01-18 05:26:08', '1610532889'),
(2, 1, 'user', 'aaaaaa', 'asdf', 'qwqwe', 'aaaaaaaaaaaaaaaaaa', 'Tulips2.jpg', 0, '2021-01-21 02:46:55', 'qwert'),
(3, 3, 'user', 'anywhere', 'anyone', 'somewhere', 'anything', '', 0, '2021-01-21 02:48:00', '2021-01-20'),
(4, 3, 'user', 'anywhere', 'anyone', 'somewhere', 'anything', 'userfile1.png', 0, '2021-01-21 02:50:54', '2021-01-20');

-- --------------------------------------------------------

--
-- 表的结构 `repeat_questions_list`
--

CREATE TABLE IF NOT EXISTS `repeat_questions_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) CHARACTER SET utf8 NOT NULL,
  `answer` longtext CHARACTER SET utf8 NOT NULL,
  `categorie` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `repeat_questions_list`
--

INSERT INTO `repeat_questions_list` (`id`, `question`, `answer`, `categorie`, `date`) VALUES
(1, 'question3', '<p>This is question3</p>\r\n', 3, '2021-01-13 06:24:24'),
(2, 'question1', '<p>this is question1</p>\r\n', 1, '2021-01-13 06:23:58'),
(3, 'question2', '<p>this is question2</p>\r\n', 2, '2021-01-13 06:10:00');

-- --------------------------------------------------------

--
-- 表的结构 `seo_pages`
--

CREATE TABLE IF NOT EXISTS `seo_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `seo_pages`
--

INSERT INTO `seo_pages` (`id`, `name`) VALUES
(1, 'home'),
(2, 'checkout'),
(3, 'contacts'),
(4, 'blog');

-- --------------------------------------------------------

--
-- 表的结构 `seo_pages_translations`
--

CREATE TABLE IF NOT EXISTS `seo_pages_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `abbr` varchar(5) NOT NULL,
  `page_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `subscribed`
--

CREATE TABLE IF NOT EXISTS `subscribed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'notifications by email',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `notify`, `last_login`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@email.com', 0, 1611210537),
(2, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@email.com', 0, 1611209204);

-- --------------------------------------------------------

--
-- 表的结构 `users_public`
--

CREATE TABLE IF NOT EXISTS `users_public` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `users_public`
--

INSERT INTO `users_public` (`id`, `name`, `email`, `address`, `password`, `created`) VALUES
(3, 'user', 'aaa@aaa.com', 'address', 'ee11cbb19052e40b07aac0ca060c23ee', '2021-01-21 02:13:23'),
(4, 'algorithm', 'algorithm@abc.com', 'anywhere', 'ed469618898d75b149e5c7c4b6a1c415', '2021-01-21 05:21:36');

-- --------------------------------------------------------

--
-- 表的结构 `value_store`
--

CREATE TABLE IF NOT EXISTS `value_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thekey` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`thekey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `value_store`
--

INSERT INTO `value_store` (`id`, `thekey`, `value`) VALUES
(1, 'sitelogo', 'logo.jpg'),
(2, 'paymentDone', '0'),
(3, 'answerDone', '1'),
(4, 'paymentRequest', '1'),
(5, 'productUpdate', '1'),
(6, 'productAdd', '1'),
(7, 'googleMaps', '42.671840, 83.279163'),
(8, 'contactsEmailTo', 'contacts@shop.dev'),
(9, 'publicQuantity', '0'),
(10, 'paypal_email', ''),
(11, 'paypal_sandbox', '0'),
(12, 'googleApi', '');

-- --------------------------------------------------------

--
-- 表的结构 `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `url` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`email`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
