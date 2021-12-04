-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2021 at 03:37 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jwellary_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `date_added` varchar(900) COLLATE latin1_general_ci NOT NULL,
  `Token` varchar(2000) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `date_added`, `Token`) VALUES
(1, 'admin', '123456', '08/05/20', 'qf7bQqTD7ctBtujV');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `Id` int(11) NOT NULL,
  `Name` varchar(900) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(900) COLLATE latin1_general_ci NOT NULL,
  `Number` varchar(90) COLLATE latin1_general_ci NOT NULL,
  `Message` varchar(9000) COLLATE latin1_general_ci NOT NULL,
  `admin_read` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Id`, `Name`, `Email`, `Number`, `Message`, `admin_read`, `date`) VALUES
(18, 'sajib', 'ssk58021@gmail.com', '+8801938531101', 'okay', 1, '2020-05-13 09:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `contact_information`
--

CREATE TABLE `contact_information` (
  `address` text NOT NULL,
  `address2` text NOT NULL,
  `mobile1` varchar(90) NOT NULL,
  `mobile2` varchar(90) NOT NULL,
  `mobile3` varchar(90) NOT NULL,
  `phone` varchar(90) NOT NULL,
  `email` varchar(90) NOT NULL,
  `facebook` varchar(900) DEFAULT NULL,
  `twitter` varchar(900) DEFAULT NULL,
  `instagram` varchar(900) DEFAULT NULL,
  `linkedin` varchar(900) NOT NULL,
  `googleplus` varchar(900) DEFAULT NULL,
  `gmail` varchar(900) DEFAULT NULL,
  `youtube` varchar(900) DEFAULT NULL,
  `yahoo` varchar(900) DEFAULT NULL,
  `skype` varchar(900) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_information`
--

INSERT INTO `contact_information` (`address`, `address2`, `mobile1`, `mobile2`, `mobile3`, `phone`, `email`, `facebook`, `twitter`, `instagram`, `linkedin`, `googleplus`, `gmail`, `youtube`, `yahoo`, `skype`) VALUES
('uttara', '', '+88 01686927099', '+88 01686927099', '', '+88 01686927099', 'info@jwellaryshop.com', 'https://www.facebook.com/jwellaryshop', 'http://twitter.com/', 'http://instagram.com', '', 'http://plus.google.com/', 'info@jwellaryshop.com', 'http://pinterest.com/', 'http://pinterest.com/', 'http://skype.com/'),
('uttara', '', '+88 01686927099', '+88 01686927099', '', '+88 01686927099', 'info@jwellaryshop.com', 'https://www.facebook.com/jwellaryshop', 'http://twitter.com/', 'http://instagram.com', '', 'http://plus.google.com/', 'info@jwellaryshop.com', 'http://pinterest.com/', 'http://pinterest.com/', 'http://skype.com/');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `username` varchar(90) NOT NULL,
  `coupon` varchar(900) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `username`, `coupon`, `discount`) VALUES
(1, 'ssk58021@gmail.com', 'grocery2020', 12);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(99) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(5, 'ssk58021@gmail.com'),
(30, 'admin11@gmail.com'),
(32, 'admin@testemail.com');

-- --------------------------------------------------------

--
-- Table structure for table `page_contents`
--

CREATE TABLE `page_contents` (
  `id` int(11) NOT NULL,
  `page` varchar(99) NOT NULL,
  `header` varchar(900) NOT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_contents`
--

INSERT INTO `page_contents` (`id`, `page`, `header`, `content`) VALUES
(1, 'about-us', 'About Us', '<p style=\"margin-bottom: 10px; color: rgb(68, 68, 68); line-height: 1.5em; font-family: Arial;\"><br></p>'),
(3, 'terms-of-use', 'Terms & Conditions', '<p style=\"margin: 0cm 0cm 0.0001pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><br></p>'),
(4, 'site-map', 'Site Maps', 'Site Map'),
(5, 'specials', 'Return Policy', 'Specials'),
(6, 'photo-confirmation', 'Photo Confirmation', 'Photo Confirmation'),
(7, 'payment-methods', 'Payment Method', 'Payment Method'),
(8, 'locations-we-ship-to', 'Location We Ship To', 'Location We Ship To'),
(9, 'shipping-returns', 'Returns/Replace Policy', '<p style=\"margin: 0cm 0cm 0.0001pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-size:10.5pt;font-family:\"Arial\",sans-serif;color:#343F49\">Our\r\npolicy lastsÂ <strong style=\"-webkit-font-smoothing: antialiased;\"><span style=\"border: 1pt none windowtext; padding: 0cm;\">7 days</span></strong>. IfÂ <strong style=\"-webkit-font-smoothing: antialiased;\"><span style=\"border: 1pt none windowtext; padding: 0cm;\">7 days</span></strong>Â have gone by since\r\nyour purchase, unfortunately we canâ€™t offer you a refund or exchange.<o:p></o:p></span></p>\r\n\r\n<p style=\"margin: 0cm 0cm 18pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; -webkit-font-smoothing: antialiased;\"><span style=\"font-size:10.5pt;\r\nfont-family:\"Arial\",sans-serif;color:#343F49\">To be eligible for a return, your\r\nitem must be unused and in the same condition that you received it. It must\r\nalso be in the original packaging.<o:p></o:p></span></p>\r\n\r\n<p style=\"margin: 0cm 0cm 0.0001pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><em><b><span style=\"font-size:10.5pt;font-family:\"Arial\",sans-serif;color:#343F49;\r\nborder:none windowtext 1.0pt;mso-border-alt:none windowtext 0cm;padding:0cm\">Shipping</span></b></em><span style=\"font-size:10.5pt;font-family:\"Arial\",sans-serif;color:#343F49\"><br style=\"-webkit-font-smoothing: antialiased;\">\r\nTo return your product, you should mail your product to:<o:p></o:p></span></p>\r\n\r\n<p style=\"margin: 0cm 0cm 18pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; -webkit-font-smoothing: antialiased;\"><span style=\"font-size:10.5pt;\r\nfont-family:\"Arial\",sans-serif;color:#343F49\">You will be responsible for\r\npaying for your own shipping costs for returning your item. Shipping costs are\r\nnon-refundable.<o:p></o:p></span></p>\r\n\r\n<p style=\"margin: 0cm 0cm 18pt; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><span style=\"font-size:10.5pt;font-family:\"Arial\",sans-serif;\r\ncolor:#343F49\">Depending on where you live, the time it may take for your\r\nexchanged product to reach you, may vary.<o:p></o:p></span></p>'),
(10, 'blog', 'à¦¶à¦¿à¦¶à§à¦° à¦¸à¦°à§à¦¦à¦¿ à¦•à¦¾à¦¶à¦¿ à¦¸à¦®à¦¸à§à¦¯à¦¾', '<p style=\"margin-top: 6px; margin-bottom: 6px; font-family: Helvetica, Arial, sans-serif; color: rgb(29, 33, 41); font-size: 14px;\"><br></p><div class=\"text_exposed_show\" style=\"display: inline; font-family: Helvetica, Arial, sans-serif; color: rgb(29, 33, 41); font-size: 14px;\"><p style=\"margin-bottom: 6px; font-family: inherit;\"></p></div>'),
(11, 'marchant', 'Become A Marchant', '<span style=\"background-color: rgb(255, 255, 0);\">Become A Marchant</span>'),
(12, 'testimonials', 'Testimonials', 'Testimonials'),
(13, 'privacy', 'Privacy Policy', 'Privacy Policy');

-- --------------------------------------------------------

--
-- Table structure for table `procat`
--

CREATE TABLE `procat` (
  `id` int(11) NOT NULL,
  `main` varchar(90) NOT NULL,
  `main_bn` varchar(900) DEFAULT NULL,
  `sub` varchar(90) NOT NULL,
  `header` varchar(900) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procat`
--

INSERT INTO `procat` (`id`, `main`, `main_bn`, `sub`, `header`, `position`) VALUES
(185, 'earrings', '', 'standard', 'earrings', 100);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(900) NOT NULL,
  `category` varchar(900) NOT NULL,
  `subcategory` varchar(900) NOT NULL,
  `brand` varchar(90) NOT NULL,
  `size` varchar(90) NOT NULL,
  `colors` varchar(9000) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `images` varchar(900) NOT NULL,
  `date_added` date DEFAULT NULL,
  `item_left` int(11) NOT NULL,
  `others` varchar(10) DEFAULT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `subcategory`, `brand`, `size`, `colors`, `description`, `price`, `views`, `discount`, `images`, `date_added`, `item_left`, `others`, `type`) VALUES
(100100, 'Gold Earrings', 'earrings', 'standard', 'Fahim jwellary', 'S,M,L,XL', '', '<div class=\"product attribute description\" style=\"margin: 0px 0px 2rem; padding: 0px; font-family: futura-pt, sans-serif;\"><div class=\"value\" style=\"margin: 0px; padding: 0px;\">Gold engraved earrings with hanging ball. Earrings push back not made of gold.</div></div><div class=\"additional-attributes-wrapper table-wrapper\" style=\"margin: 0px; padding: 0px; font-family: futura-pt, sans-serif;\"><table class=\"data table additional-attributes\" id=\"product-attribute-specs-table\" style=\"margin: 0px 0px 2rem; padding: 0px; width: 413px; border: none;\"><caption class=\"table-caption\" style=\"margin: -1px -1px 15px; padding: 0px; border: 0px; clip: unset; height: auto; overflow: hidden; position: relative; width: auto; font-size: 1.8rem; font-weight: 600;\">Specifications</caption><tbody style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51);\"><tr style=\"margin: 0px; padding: 0px; background: rgb(251, 251, 251);\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Colour</th><td class=\"col data\" data-th=\"Colour\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Colour\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">Golden</td></tr><tr style=\"margin: 0px; padding: 0px;\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Material</th><td class=\"col data\" data-th=\"Material\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Material\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">Gold</td></tr><tr style=\"margin: 0px; padding: 0px; background: rgb(251, 251, 251);\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Carat</th><td class=\"col data\" data-th=\"Carat\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Carat\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">21 Karat (Certified)</td></tr><tr style=\"margin: 0px; padding: 0px;\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Value Addition</th><td class=\"col data\" data-th=\"Value Addition\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Value Addition\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">Engrave</td></tr><tr style=\"margin: 0px; padding: 0px; background: rgb(251, 251, 251);\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Style</th><td class=\"col data\" data-th=\"Style\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Style\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">Drop</td></tr><tr style=\"margin: 0px; padding: 0px;\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Back Type</th><td class=\"col data\" data-th=\"Back Type\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Back Type\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">Butterfly Push Back</td></tr><tr style=\"margin: 0px; padding: 0px; background: rgb(251, 251, 251);\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Length</th><td class=\"col data\" data-th=\"Length\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Length\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">2</td></tr><tr style=\"margin: 0px; padding: 0px;\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Diameter</th><td class=\"col data\" data-th=\"Diameter\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Diameter\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">0.5</td></tr><tr style=\"margin: 0px; padding: 0px; background: rgb(251, 251, 251);\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Measurement Unit</th><td class=\"col data\" data-th=\"Measurement Unit\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Measurement Unit\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">CM</td></tr><tr style=\"margin: 0px; padding: 0px;\"><th class=\"col label\" scope=\"row\" style=\"margin: 0px; padding: 5.5px 30px 10px 0px; text-align: left; border: none; font-weight: 500;\">Care</th><td class=\"col data\" data-th=\"Care\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\"><br></td><td class=\"col data\" data-th=\"Care\" style=\"margin: 0px; padding: 5.5px 5px 10px; border: none;\">To clean gold jewellery, use a solution of warm water and detergent-free soap and wash gold gently with a soft-bristled brush. Store gold pieces separately in soft cloth bags or original boxes to protect them from the exposure to harsh daily elements</td></tr></tbody></table></div>', 20466, 0, 0, '1', '2021-08-29', 20, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `product_comments`
--

CREATE TABLE `product_comments` (
  `id` int(11) NOT NULL,
  `name` varchar(900) NOT NULL,
  `email` varchar(90) NOT NULL,
  `message` text NOT NULL,
  `prid` int(11) NOT NULL,
  `admin_read` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_order`
--

CREATE TABLE `p_order` (
  `id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `date` varchar(90) NOT NULL,
  `name` varchar(900) DEFAULT NULL,
  `phone` varchar(90) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `address` text NOT NULL,
  `location` varchar(90) NOT NULL,
  `shipment` varchar(99) DEFAULT NULL,
  `payment` varchar(99) NOT NULL,
  `payment_number` varchar(90) NOT NULL,
  `payment_trxn_id` varchar(90) NOT NULL,
  `pr_id` varchar(9000) NOT NULL,
  `pr_size` varchar(9000) NOT NULL,
  `pr_qty` varchar(9000) NOT NULL,
  `pr_color` varchar(9000) NOT NULL,
  `admin_read` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_order`
--

INSERT INTO `p_order` (`id`, `order_no`, `date`, `name`, `phone`, `email`, `address`, `location`, `shipment`, `payment`, `payment_number`, `payment_trxn_id`, `pr_id`, `pr_size`, `pr_qty`, `pr_color`, `admin_read`) VALUES
(178, 72246, '29-08-2021', 'Guest', '01718825371', '', 'Dhaka', '', 'Normal', 'cod', '', '', '100100', 'L', '2', 'N/A', 2),
(179, 31319, '27-09-2021', 'Guest', '+8801521201359', '', 'Dhaka', '', 'Normal', 'cod', '', '', '100100', 'M', '1', 'N/A', 0),
(180, 38278, '27-09-2021', 'Guest', '+8801521201359', '', 'Dhaka', '', 'Normal', 'cod', '', '', '100100', 'M', '1', 'N/A', 0);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(900) NOT NULL,
  `page_view` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `title`, `page_view`) VALUES
(1, 'Jewellary Shop || Exclusive Shop', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `image` varchar(900) DEFAULT NULL,
  `image_heading` varchar(900) DEFAULT NULL,
  `image_text1` varchar(900) DEFAULT NULL,
  `image_text2` varchar(900) DEFAULT NULL,
  `image_text3` varchar(900) DEFAULT NULL,
  `image_link` varchar(900) DEFAULT NULL,
  `heading_link` varchar(900) DEFAULT NULL,
  `text1_link` varchar(900) DEFAULT NULL,
  `text2_link` varchar(900) DEFAULT NULL,
  `text3_link` varchar(900) DEFAULT NULL,
  `page` varchar(900) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image`, `image_heading`, `image_text1`, `image_text2`, `image_text3`, `image_link`, `heading_link`, `text1_link`, `text2_link`, `text3_link`, `page`, `position`) VALUES
(32, 'images/slider/images (1).jpg?1222259157.415', '', '2yHuGEge94Y', '', '', '', '', '', '', '', 'index', 5),
(3, 'images/slider/download (2).jpg?1222259157.415', '', '', '', '', '', '', '', '', '', 'index', 1),
(4, 'images/slider/slider-banners-12-grocery_1.jpg?1222259157.415', '', '', '', '', 'index', '', '', '', '', 'index', 4),
(1, 'images/slider/diamond-city-demo-image-2.png?1222259157.415', 'shop now', '', '', '', '', '', '', '', '', 'index', 1),
(33, 'images/slider/images (1).jpg?1222259157.415', '', '', '', '', '', '', '', '', '', 'index', 1),
(17, 'images/slider/Homepage_Gold_Banner_01Sep.jpg?1222259157.415', '', '', '', '', '', '', '', '', '', 'index', 3),
(26, 'images/slider/images.jpg?1222259157.415', '', '', '', '', '', '', '', '', '', 'index', 2),
(31, 'images/slider/download.jpg?1222259157.415', '', '', '', '', '', '', '', '', '', 'index', 1),
(38, 'images/slider/jewellery-banner-redo-2-1.jpg?1222259157.415', '', '', '', '', '', '', '', '', '', 'index', 6),
(41, 'images/slider/1.jpg?1222259157.415', '', '', '', '', '', '', '', '', '', 'index', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sample`
--

CREATE TABLE `tbl_sample` (
  `id` int(15) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sample`
--

INSERT INTO `tbl_sample` (`id`, `first_name`, `last_name`) VALUES
(1, '0', '0'),
(2, '0', '0'),
(3, 'sajib', 'hossain');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(900) NOT NULL,
  `password` varchar(90) NOT NULL,
  `token` varchar(90) NOT NULL,
  `first_name` varchar(900) NOT NULL,
  `last_name` varchar(900) NOT NULL,
  `email` varchar(900) NOT NULL,
  `address` varchar(900) NOT NULL,
  `city` varchar(900) NOT NULL,
  `district` varchar(900) NOT NULL,
  `postalcode` varchar(900) NOT NULL,
  `mobile_number` varchar(900) NOT NULL,
  `wishlists` varchar(900) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `token`, `first_name`, `last_name`, `email`, `address`, `city`, `district`, `postalcode`, `mobile_number`, `wishlists`) VALUES
(10, 'test@mail.com', 'test1234', 'ShJmS1G1nxNzz68y', 'sajib', 'hossain', 'test@mail.com', 'Secor 9, Uttara, Dhaka, Bangladesh', 'Chittagong', 'Noakhali', '1230', '+8801956758055', ''),
(79, 'ssk580211@gmail.com', '12345678', 'ellhSij8VSK5YoSI', 'sk', 'sojib', 'ssk580211@gmail.com', 'dhaka', 'Dhaka', 'Dhaka', '', '01718825371', ''),
(80, 'devtest@gmail.com', '12345678', 'SMH1FHuM2WhE60eE', 'dev', 'test', 'devtest@gmail.com', 'Dhaka', 'Dhaka', 'Dhaka', '', '01718825372', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_contents`
--
ALTER TABLE `page_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procat`
--
ALTER TABLE `procat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_comments`
--
ALTER TABLE `product_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_order`
--
ALTER TABLE `p_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sample`
--
ALTER TABLE `tbl_sample`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `page_contents`
--
ALTER TABLE `page_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `procat`
--
ALTER TABLE `procat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `product_comments`
--
ALTER TABLE `product_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `p_order`
--
ALTER TABLE `p_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_sample`
--
ALTER TABLE `tbl_sample`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
