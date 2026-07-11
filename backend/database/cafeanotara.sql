-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2026 at 11:07 AM
-- Server version: 8.0.43
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafeanotara`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `bookmark_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `cafe_id` int NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`bookmark_id`, `customer_id`, `cafe_id`, `created_on`) VALUES
(1, 3, 1, '2026-07-10 16:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `cafeimg`
--

CREATE TABLE `cafeimg` (
  `photo_id` int NOT NULL,
  `cafe_id` int NOT NULL,
  `photo_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cafeimg`
--

INSERT INTO `cafeimg` (`photo_id`, `cafe_id`, `photo_url`) VALUES
(1, 1, 'cafe.png'),
(2, 1, 'cafe.png');

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

CREATE TABLE `cafes` (
  `cafe_id` int NOT NULL,
  `owner_id` int DEFAULT NULL,
  `cafe_name` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `wifi_speed` varchar(45) DEFAULT NULL,
  `noise_level` enum('quiet','moderate','loud') DEFAULT NULL,
  `outlet_num` int DEFAULT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `price` int DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `google_maps_url` varchar(255) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cafes`
--

INSERT INTO `cafes` (`cafe_id`, `owner_id`, `cafe_name`, `location`, `description`, `wifi_speed`, `noise_level`, `outlet_num`, `opening_time`, `closing_time`, `price`, `is_verified`, `google_maps_url`, `created_on`) VALUES
(1, 2, 'Coffee Bun', 'Gen Ave., Cubao, Quezon City', 'A nice comfortable space for student alike', '150', 'quiet', 10, '07:00:00', '23:00:00', -200, 1, 'https://www.google.com/maps', '2026-06-06 11:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int NOT NULL,
  `reporter_id` int NOT NULL,
  `reported_user_id` int DEFAULT NULL,
  `reported_cafe_id` int DEFAULT NULL,
  `reported_review_id` int DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('ongoing','resolved') DEFAULT 'ongoing',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `reporter_id`, `reported_user_id`, `reported_cafe_id`, `reported_review_id`, `reason`, `status`, `created_on`) VALUES
(1, 2, 3, 1, 1, 'The review comment contains inappropriate language.', 'ongoing', '2026-07-11 11:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `cafe_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `owner_reply` varchar(255) DEFAULT NULL,
  `is_inappropriate` tinyint(1) DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `customer_id`, `cafe_id`, `rating`, `comment`, `owner_reply`, `is_inappropriate`, `created_on`) VALUES
(1, 3, 1, 5, 'Fast WiFi with many outlets, would recommend.', NULL, 0, '2026-07-10 18:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobilenumber` varchar(20) DEFAULT NULL,
  `role` enum('customer','owner','admin') NOT NULL,
  `account_status` enum('active','suspended','deleted') DEFAULT 'active',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `email`, `mobilenumber`, `role`, `account_status`, `created_on`) VALUES
(1, 'Albert', 'Wesker', 'admin', 'P@ss12345', 'admin@gmail.com', '09604700469', 'admin', 'active', '2026-06-01 09:00:00'),
(2, 'Claire', 'Redfield', 'cafe_owner', 'P@ss12345', 'owner@gmail.com', '09604700469', 'owner', 'active', '2026-06-05 10:15:00'),
(3, 'Jill', 'Valentine', 'pat_study_hard', 'P@ss12345', 'customer@gmail.com', '09604700469', 'customer', 'active', '2026-07-01 14:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD UNIQUE KEY `unique_user_cafe_bookmark` (`customer_id`,`cafe_id`),
  ADD KEY `cafe_id` (`cafe_id`);

--
-- Indexes for table `cafeimg`
--
ALTER TABLE `cafeimg`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `cafe_id` (`cafe_id`);

--
-- Indexes for table `cafes`
--
ALTER TABLE `cafes`
  ADD PRIMARY KEY (`cafe_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `reported_user_id` (`reported_user_id`),
  ADD KEY `reported_cafe_id` (`reported_cafe_id`),
  ADD KEY `reported_review_id` (`reported_review_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `unique_user_cafe_review` (`customer_id`,`cafe_id`),
  ADD KEY `cafe_id` (`cafe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `bookmark_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cafeimg`
--
ALTER TABLE `cafeimg`
  MODIFY `photo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cafes`
--
ALTER TABLE `cafes`
  MODIFY `cafe_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`cafe_id`) ON DELETE CASCADE;

--
-- Constraints for table `cafeimg`
--
ALTER TABLE `cafeimg`
  ADD CONSTRAINT `cafeimg_ibfk_1` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`cafe_id`) ON DELETE CASCADE;

--
-- Constraints for table `cafes`
--
ALTER TABLE `cafes`
  ADD CONSTRAINT `cafes_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`reported_cafe_id`) REFERENCES `cafes` (`cafe_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_ibfk_4` FOREIGN KEY (`reported_review_id`) REFERENCES `reviews` (`review_id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`cafe_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
