-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 03:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multiuserdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_totals`
--

CREATE TABLE `daily_totals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_calories` int(11) DEFAULT 2000,
  `total_protein` int(11) DEFAULT 0,
  `total_carbs` int(11) DEFAULT 0,
  `total_fats` int(11) DEFAULT 0,
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_totals`
--

INSERT INTO `daily_totals` (`id`, `user_id`, `total_calories`, `total_protein`, `total_carbs`, `total_fats`, `last_updated`) VALUES
(3, 3, 2336, 0, 0, 0, '2025-10-03 18:43:14'),
(4, 4, 2422, 0, 0, 0, '2025-10-03 18:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `calories` int(11) NOT NULL,
  `protein` int(11) NOT NULL,
  `carbs` int(11) NOT NULL,
  `fats` int(11) NOT NULL,
  `entry_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `user_id`, `food_name`, `calories`, `protein`, `carbs`, `fats`, `entry_date`) VALUES
(2, 3, 'Chicken Breast (100g) (x4)', 660, 124, 0, 16, '2025-10-03 18:43:11'),
(3, 4, 'Chicken Breast (100g) (x5)', 825, 155, 0, 20, '2025-10-03 18:44:40'),
(4, 4, 'Egg (x10)', 780, 60, 10, 50, '2025-10-03 18:44:46'),
(5, 4, 'Tofu (100g) (x4)', 304, 32, 8, 20, '2025-10-03 18:50:04'),
(6, 4, 'Fish Curry with Rice (1 plate) (x1)', 500, 25, 60, 18, '2025-10-03 18:51:14'),
(7, 4, 'Pomfret (Silver) (100g) (x1)', 140, 20, 0, 6, '2025-10-03 18:55:45'),
(8, 4, 'Prawns (Jhinga) (100g) (x2)', 200, 48, 0, 2, '2025-10-03 18:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `food_library`
--

CREATE TABLE `food_library` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `calories` int(11) NOT NULL,
  `protein` int(11) NOT NULL,
  `carbs` int(11) NOT NULL,
  `fats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_library`
--

INSERT INTO `food_library` (`id`, `food_name`, `calories`, `protein`, `carbs`, `fats`) VALUES
(1, 'Banana', 105, 1, 27, 0),
(2, 'Apple', 95, 1, 25, 0),
(3, 'Chicken Breast (100g)', 165, 31, 0, 4),
(4, 'Brown Rice (1 cup)', 215, 5, 45, 2),
(5, 'Egg', 78, 6, 1, 5),
(6, 'Dal Tadka with Rice (1 plate)', 450, 15, 80, 8),
(7, 'Omelette (2 eggs with veggies)', 180, 15, 3, 12),
(8, 'Chicken Biryani (1 plate)', 500, 25, 60, 18),
(9, 'Paneer Tikka (5 pieces)', 250, 15, 8, 18),
(10, 'Oats Muesli (1 bowl with milk)', 350, 10, 60, 8),
(11, 'Steamed Rice (1 cup)', 205, 4, 45, 0),
(12, 'Aloo Paratha (1 with curd)', 300, 7, 45, 10),
(13, 'Poha (1 plate)', 250, 5, 50, 3),
(14, 'Masala Dosa (1 large)', 380, 8, 65, 10),
(15, 'Idli with Sambar (2 idli, 1 bowl)', 250, 8, 45, 4),
(16, 'Chole Bhature (2 bhature, 1 bowl)', 600, 15, 80, 25),
(17, 'Rajma Chawal (1 plate)', 550, 20, 90, 12),
(18, 'Butter Chicken (1 serving)', 450, 30, 15, 30),
(19, 'Palak Paneer (1 serving)', 300, 18, 10, 22),
(20, 'Vegetable Sandwich (2 slices bread)', 250, 8, 40, 6),
(21, 'Vegetable Pulao (1 plate)', 350, 8, 65, 6),
(22, 'Upma (1 bowl)', 280, 6, 50, 6),
(23, 'Egg Curry (2 eggs, 1 serving)', 300, 15, 10, 22),
(24, 'Fish Curry with Rice (1 plate)', 500, 25, 60, 18),
(25, 'Roti / Chapati (1 piece)', 85, 3, 18, 1),
(26, 'Naan (1 piece)', 260, 8, 50, 3),
(27, 'Vegetable Pasta (Arrabbiata)', 400, 12, 75, 5),
(28, 'Pav Bhaji (2 pav, 1 bowl bhaji)', 450, 12, 60, 18),
(29, 'Samosa (1 piece)', 250, 4, 30, 13),
(30, 'Scrambled Eggs (2 eggs)', 150, 13, 2, 10),
(31, 'Paneer Butter Masala (1 serving)', 400, 18, 15, 30),
(32, 'Aloo Gobi (1 serving)', 150, 4, 18, 7),
(33, 'Mixed Vegetable Curry (1 serving)', 200, 5, 20, 12),
(34, 'Plain Curd / Yogurt (1 bowl)', 100, 6, 8, 5),
(35, 'Vegetable Fried Rice (1 plate)', 340, 9, 50, 10),
(36, 'Banana', 105, 1, 27, 0),
(37, 'Apple', 95, 1, 25, 0),
(38, 'Chicken Breast (100g)', 165, 31, 0, 4),
(39, 'Brown Rice (1 cup cooked)', 215, 5, 45, 2),
(40, 'Egg (1 large)', 78, 6, 1, 5),
(41, 'Milk (1 cup, whole)', 150, 8, 12, 8),
(42, 'Oats (1 cup cooked)', 160, 6, 28, 3),
(43, 'White Rice (1 cup cooked)', 205, 4, 45, 0),
(44, 'Whole Wheat Bread (1 slice)', 80, 4, 14, 1),
(45, 'Potato (1 medium)', 160, 4, 37, 0),
(46, 'Sweet Potato (1 medium)', 103, 2, 24, 0),
(47, 'Spinach (1 cup raw)', 7, 1, 1, 0),
(48, 'Broccoli (1 cup)', 55, 4, 11, 1),
(49, 'Carrot (1 medium)', 25, 1, 6, 0),
(50, 'Tomato (1 medium)', 22, 1, 5, 0),
(51, 'Orange (1 medium)', 62, 1, 15, 0),
(52, 'Strawberries (1 cup)', 50, 1, 12, 0),
(53, 'Salmon (100g cooked)', 208, 20, 0, 13),
(54, 'Tuna (canned in water, 100g)', 130, 28, 0, 1),
(55, 'Ground Beef (90/10, 100g cooked)', 200, 28, 0, 10),
(56, 'Almonds (28g / ~23 almonds)', 165, 6, 6, 14),
(57, 'Peanut Butter (2 tbsp)', 190, 7, 8, 16),
(58, 'Plain Yogurt (1 cup)', 150, 9, 12, 8),
(59, 'Cheddar Cheese (28g)', 115, 7, 1, 9),
(60, 'Lentils (1 cup cooked)', 230, 18, 40, 1),
(61, 'Chickpeas (1 cup cooked)', 270, 15, 45, 4),
(62, 'Tofu (100g)', 76, 8, 2, 5),
(63, 'Olive Oil (1 tbsp)', 120, 0, 0, 14),
(64, 'Onion (1 medium)', 44, 1, 10, 0),
(65, 'Bell Pepper (1 medium)', 30, 1, 7, 0),
(66, 'Indian Salmon (Rawas) (100g)', 210, 22, 0, 13),
(67, 'Rohu Fish (100g)', 110, 20, 0, 3),
(68, 'Catla Fish (100g)', 105, 19, 0, 3),
(69, 'Hilsa (Ilish) Fish (100g)', 310, 22, 0, 24),
(70, 'Pomfret (Silver) (100g)', 140, 20, 0, 6),
(71, 'Surmai (King Fish) (100g)', 140, 21, 0, 6),
(72, 'Mackerel (Bangda) (100g)', 205, 18, 0, 14),
(73, 'Sardines (Mathi) (100g)', 208, 25, 0, 11),
(74, 'Tilapia Fish (100g)', 130, 26, 0, 3),
(75, 'Anchovies (Nethili) (100g)', 130, 20, 0, 5),
(76, 'Prawns (Jhinga) (100g)', 100, 24, 0, 1),
(77, 'Basa Fillet (100g)', 90, 18, 0, 2),
(78, 'Greek Salad (1 serving)', 300, 6, 12, 25),
(79, 'Caesar Salad (with chicken)', 470, 30, 18, 30),
(80, 'Coleslaw (1 cup)', 300, 2, 25, 22),
(81, 'Garden Salad (with vinaigrette)', 150, 3, 10, 12),
(82, 'Fruit Salad (1 cup)', 110, 1, 28, 0),
(83, 'Whey Protein (1 scoop)', 120, 24, 3, 2),
(84, 'Casein Protein (1 scoop)', 120, 24, 4, 1),
(85, 'Mass Gainer (1 large scoop)', 600, 50, 85, 6),
(86, 'Creatine Monohydrate (5g)', 0, 0, 0, 0),
(87, 'BCAAs (1 scoop)', 40, 9, 0, 0),
(88, 'Fish Oil Omega-3 (1 softgel)', 10, 0, 0, 1),
(89, 'Multivitamin (1 tablet)', 0, 0, 0, 0),
(90, 'Paneer (100g)', 290, 18, 4, 22),
(91, 'Tofu (100g)', 76, 8, 2, 5),
(92, 'Lentils (Dal, 1 cup cooked)', 230, 18, 40, 1),
(93, 'Chickpeas (Chole, 1 cup cooked)', 270, 15, 45, 4),
(94, 'Kidney Beans (Rajma, 1 cup cooked)', 225, 15, 40, 1),
(95, 'Soya Chunks (50g dry)', 170, 25, 15, 1),
(96, 'Greek Yogurt (1 cup)', 140, 20, 8, 4),
(97, 'Quinoa (1 cup cooked)', 222, 8, 39, 4),
(98, 'Peanuts (28g)', 160, 7, 5, 14),
(99, 'Pumpkin Seeds (28g)', 150, 9, 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `bmi` float DEFAULT NULL,
  `goal_weight` float DEFAULT NULL,
  `goal_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `user_id`, `fullname`, `phone`, `age`, `height`, `weight`, `gender`, `bmi`, `goal_weight`, `goal_type`) VALUES
(3, 3, 'alankar janawalekar', '9152730741', 20, 167, 75, 'male', 26.89, 65, 'fat_loss'),
(4, 4, 'shrajan ganiga', '9004949706', 20, 177, 75, 'male', 23.94, 65, 'maintain');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(3, 'luciferjan', '$2y$10$UVpocSBP02HY0PmulABSuOAZKkiHA2IIOo5BJwxbw3ryeiGJHHxI6', '2025-10-03 13:10:48'),
(4, 'shrajan', '$2y$10$Kt4Rj4aBWTttpDe2KSwDUOlsj6siGhq6lRUvJczdH3F4Nzi/GA.XK', '2025-10-03 13:13:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_totals`
--
ALTER TABLE `daily_totals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_library`
--
ALTER TABLE `food_library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_totals`
--
ALTER TABLE `daily_totals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `food_library`
--
ALTER TABLE `food_library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `userinfo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
