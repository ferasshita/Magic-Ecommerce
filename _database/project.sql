-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2024 at 08:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `blog_text` text NOT NULL,
  `blog_img` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `code` text DEFAULT NULL,
  `see` int(11) NOT NULL,
  `blog` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `quantity` int(100) NOT NULL,
  `variants` varchar(200) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `order_id`, `item_id`, `user_id`, `quantity`, `variants`, `date`) VALUES
(1712896220, 0, 1722082727, 746803408127636, 1, '0', '2024-06-27 01:14:10'),
(1712896221, 0, 1728419751, 746803408127636, 1, '0', '2024-06-27 01:14:12'),
(1712896222, 296800, 1722082727, 1, 2, '0', '2024-06-27 01:19:39'),
(1712896223, 296800, 1728419751, 1, 1, '0', '2024-06-27 01:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`id`, `title`, `description`, `image`) VALUES
(35, 'قميص', '', 'Asset/upload/collection/17194422722013934460.jpg'),
(36, 'سروال', '', 'Asset/upload/collection/17194424511649243755.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `costumers`
--

CREATE TABLE `costumers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `long` varchar(100) NOT NULL,
  `lat` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `ip` bigint(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `costumers`
--

INSERT INTO `costumers` (`id`, `name`, `phone`, `email`, `long`, `lat`, `address`, `ip`, `date`) VALUES
(8, 'فراس', '0917748838', 'example@gmail.com', '13.275887672075802', '32.81730469618965', 'عين زارة, طرابلس', 1, '2024-06-26 23:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `deliver`
--

CREATE TABLE `deliver` (
  `id` bigint(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `passport_number` varchar(100) DEFAULT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `passport_photo` varchar(100) DEFAULT NULL,
  `license_photo` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `vehical_number` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliver`
--

INSERT INTO `deliver` (`id`, `name`, `passport_number`, `license_number`, `passport_photo`, `license_photo`, `email`, `phone`, `photo`, `vehical_number`, `password`) VALUES
(1724719079, 'فراس', 'N5GSL74', '5398539839', 'Asset/upload/passport_photo/17194425881431985705.jpg', 'Asset/upload/license_photo/17194425881276441328.jpg', 'example@example.com', '091667723', 'Asset/upload/deliver/17194425881737149840.jpg', '5-727373', '7a1c9955');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `user_id`, `ip`, `status`) VALUES
(1325, 1724965133, '::1', 0),
(3371, 746803408127636, '::1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `type` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `from_date` varchar(100) NOT NULL,
  `to_date` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `minimum_purchase` int(11) DEFAULT NULL,
  `z` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forg_pass`
--

CREATE TABLE `forg_pass` (
  `id` int(8) NOT NULL,
  `email` varchar(100) NOT NULL,
  `numi` bigint(100) NOT NULL,
  `time` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gift_card`
--

CREATE TABLE `gift_card` (
  `id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `product_id` bigint(11) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `product_id`, `location`) VALUES
(43, 1728419751, 'Asset/upload/item/17194421332134611607.jpg'),
(44, 1728419751, 'Asset/upload/item/1719442134651940851.jpg'),
(45, 1728419751, 'Asset/upload/item/17194421341207874418.jpg'),
(46, 1724621945, 'Asset/upload/item/17194428621091988508.jpg'),
(47, 1729218081, 'Asset/upload/item/17194429661944047420.jpg'),
(48, 1722082727, 'Asset/upload/item/17194431771857016863.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item_like`
--

CREATE TABLE `item_like` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `item_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `long` varchar(100) DEFAULT NULL,
  `lat` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `location_name` varchar(100) DEFAULT NULL,
  `my_location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `type` int(11) NOT NULL,
  `message` text NOT NULL,
  `read` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `accept` bigint(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  `discount_code` varchar(100) DEFAULT NULL,
  `shop_finish` int(11) NOT NULL,
  `shop_bill` varchar(100) NOT NULL,
  `deliver_bill` varchar(100) NOT NULL,
  `pos` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `accept`, `location`, `note`, `discount_code`, `shop_finish`, `shop_bill`, `deliver_bill`, `pos`, `code`, `date`) VALUES
(296800, 1, 0, '0', '', '', 0, '', '', 0, NULL, '2024-06-27 01:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `next_pay` varchar(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(100) NOT NULL,
  `compare_price` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `track_quantity` int(11) NOT NULL,
  `out_stock` int(11) NOT NULL,
  `shipping_weight` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `product_catigory` varchar(100) DEFAULT NULL,
  `product_type` varchar(100) DEFAULT NULL,
  `vendor` varchar(100) DEFAULT NULL,
  `collection` bigint(11) DEFAULT 0,
  `tags` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `user_id`, `title`, `description`, `price`, `compare_price`, `number`, `track_quantity`, `out_stock`, `shipping_weight`, `barcode`, `status`, `product_catigory`, `product_type`, `vendor`, `collection`, `tags`, `date`) VALUES
(1722082727, '746803408127636', 'قميص اسود', '', '90', '120', -2, 1, 1, '', '', 0, '', '', '', 35, '', '2024-06-27 01:06:17'),
(1728419751, '746803408127636', 'قميص ابيض', '<p dir=\"rtl\"><strong>وصف المنتج:</strong></p>\r\n\r\n<ul dir=\"rtl\">\r\n	<li>قميص ت-شيرت أبيض مصنوع من قطن عالي الجودة (يمكن تحديد نوع القطن إن وجد، مثل قطن مصري أو عضوي).</li>\r\n	<li>تصميم أنيق وبسيط يناسب جميع الملابس (يمكن تعديل هذه الجملة لتلائم التصميم إن كان مميزا).</li>\r\n	<li>مثالي للارتداء في أي مناسبة، سواء كانت رسمية أو غير رسمية (يمكن تعديل هذه الجملة لتلائم الاستخدام المقصود للقميص).</li>\r\n	<li>متوفر بمجموعة متنوعة من المقاسات لتناسب الجميع (تأكد من ذكر المقاسات المتوفرة).</li>\r\n	<li>نسيج ناعم ومريح على البشرة.</li>\r\n	<li>قابل للغسل في الغسالة (يمكن تحديد تعليمات الغسيل الأخرى إن وجدت).</li>\r\n</ul>\r\n\r\n<p dir=\"rtl\"><strong>ميزات إضافية (اختيارية):</strong></p>\r\n\r\n<ul dir=\"rtl\">\r\n	<li>قصة محاكة بشكل مثالي لتوفير الراحة والمظهر الأنيق.</li>\r\n	<li>ياقة مضلعة تحافظ على شكلها.</li>\r\n	<li>خياطة متينة تضمن جودة المنتج.</li>\r\n</ul>\r\n\r\n<p dir=\"rtl\"><strong>في الختام، يمكنك إضافة عبارة ترغب فيها مثل:</strong></p>\r\n\r\n<ul>\r\n	<li dir=\"rtl\" style=\"text-align: right;\">ارتقِ بأسلوبك مع هذا القميص الأبيض الأنيق.</li>\r\n	<li dir=\"rtl\" style=\"text-align: right;\">قطعة أساسية لا غنى عنها لأي خزانة ملابس.</li>\r\n</ul>\r\n', '100', '150', -1, 1, 1, '', '2974274984732984', 0, '', '', '', 0, '', '2024-06-27 00:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `product_id` bigint(11) NOT NULL,
  `quantity` int(100) NOT NULL,
  `vendor` varchar(100) NOT NULL,
  `variant` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(8) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `access` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` bigint(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `Password` varchar(100) NOT NULL,
  `account_type` varchar(100) DEFAULT NULL,
  `mode` varchar(100) NOT NULL,
  `login_attempts` bigint(100) DEFAULT NULL,
  `online` int(100) NOT NULL,
  `aSetup` int(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `account_setup` varchar(100) DEFAULT NULL,
  `sus` int(100) NOT NULL,
  `user_activation_code` varchar(250) NOT NULL,
  `phone_activation_code` varchar(100) DEFAULT NULL,
  `user_email_status` enum('not verified','verified') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `username`, `email`, `phone`, `Password`, `account_type`, `mode`, `login_attempts`, `online`, `aSetup`, `language`, `account_setup`, `sus`, `user_activation_code`, `phone_activation_code`, `user_email_status`) VALUES
(1724719079, 'example@example.com', 'example@example.com', '091667723', '$2y$12$RP12PW7wAEDz20ptuIph1u5R6WvfcPEh1pTuV8TSILeeIQK8uwB7i', 'deliver', 'auto', NULL, 0, 0, 'العربية', '26/06/2024', 0, '', NULL, 'verified'),
(746803408127636, 'admin', 'admin@admin.com', '+21894029420942', '$2y$12$y74Kw4eScUOgbsBk0kHgWOXZ2ek6IeHZdMiyQi.ggNpqE6Cz9x4jG', 'admin', 'night', 0, 0, 0, 'العربية', '31/12/2023', 0, '40efd1615ac967c99f0a9ecbf08b7e9a', '351421', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `variant`
--

CREATE TABLE `variant` (
  `id` int(11) NOT NULL,
  `product_id` bigint(11) NOT NULL,
  `option_name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `available` varchar(100) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `costumers`
--
ALTER TABLE `costumers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliver`
--
ALTER TABLE `deliver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forg_pass`
--
ALTER TABLE `forg_pass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_like`
--
ALTER TABLE `item_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `variant`
--
ALTER TABLE `variant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1712896224;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `costumers`
--
ALTER TABLE `costumers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8127;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `forg_pass`
--
ALTER TABLE `forg_pass`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `item_like`
--
ALTER TABLE `item_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `variant`
--
ALTER TABLE `variant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete forgot password` ON SCHEDULE EVERY 10 MINUTE STARTS '2023-04-08 17:27:19' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM `forg_pass`
WHERE time < DATE_SUB(NOW(), INTERVAL 30 MINUTE)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
