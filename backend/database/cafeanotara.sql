-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2026 at 03:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `bookmark_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`bookmark_id`, `customer_id`, `cafe_id`, `created_on`) VALUES
(1, 4, 1, '2025-12-28 22:10:32'),
(2, 4, 3, '2026-01-02 10:36:53'),
(3, 5, 1, '2026-01-06 23:03:14'),
(4, 5, 2, '2026-01-11 11:29:35'),
(5, 6, 4, '2026-01-15 23:55:56'),
(6, 6, 5, '2026-01-20 12:22:17'),
(7, 10, 6, '2026-01-25 00:48:38'),
(8, 10, 7, '2026-01-29 13:14:59'),
(9, 11, 8, '2026-02-03 01:41:21'),
(10, 11, 9, '2026-02-07 14:07:42'),
(11, 12, 10, '2026-02-12 02:34:03'),
(12, 12, 11, '2026-02-16 15:00:24'),
(13, 13, 12, '2026-02-21 03:26:45'),
(14, 14, 13, '2026-02-25 15:53:06'),
(15, 15, 14, '2026-03-02 04:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `cafeimg`
--

CREATE TABLE `cafeimg` (
  `photo_id` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `photo_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafeimg`
--

INSERT INTO `cafeimg` (`photo_id`, `cafe_id`, `photo_url`) VALUES
(1, 1, 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1080&q=80'),
(2, 1, 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=1080&q=80'),
(3, 2, 'https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=1080&q=80'),
(4, 3, 'https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=1080&q=80'),
(5, 4, 'https://images.unsplash.com/photo-1507133750040-4a8f57021571?w=1080&q=80'),
(6, 5, 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1080&q=80'),
(7, 6, 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1080&q=80'),
(8, 7, 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=1080&q=80'),
(9, 8, 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=1080&q=80'),
(10, 9, 'https://images.unsplash.com/photo-1509785307050-d4066910ec1e?w=1080&q=80'),
(11, 10, 'https://images.unsplash.com/photo-1461988091159-192b6df7054f?w=1080&q=80'),
(12, 11, 'https://images.unsplash.com/photo-1493857671505-72967e2e2760?w=1080&q=80'),
(13, 12, 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=1080&q=80'),
(14, 13, 'https://images.unsplash.com/photo-1600093463592-8e36ae95ef56?w=1080&q=80'),
(15, 14, 'https://images.unsplash.com/photo-1442550528053-c431ecb55509?w=1080&q=80'),
(16, 15, 'https://static.vecteezy.com/system/resources/previews/060/506/482/large_2x/cozy-cafe-interior-with-vibrant-decor-and-plants-inviting-for-relaxation-and-socializing-photo.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

CREATE TABLE `cafes` (
  `cafe_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `cafe_name` varchar(45) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `wifi_speed` varchar(45) DEFAULT NULL,
  `noise_level` enum('quiet','moderate','loud') DEFAULT NULL,
  `outlet_num` int(11) DEFAULT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `google_maps_url` varchar(500) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafes`
--

INSERT INTO `cafes` (`cafe_id`, `owner_id`, `cafe_name`, `location`, `description`, `wifi_speed`, `noise_level`, `outlet_num`, `opening_time`, `closing_time`, `price`, `is_verified`, `google_maps_url`, `created_on`) VALUES
(1, 2, 'Coffee Bun', 'Cubao, Quezon City', 'Great study cafe with strong WiFi.', '150 Mbps', 'quiet', 12, '07:00:00', '23:00:00', '100-300', 1, 'https://maps.google.com', '2025-10-22 03:35:16'),
(2, 3, 'Daily Brew', 'Taft, Manila', 'Perfect for students near universities.', '200 Mbps', 'moderate', 20, '08:00:00', '22:00:00', '150-350', 1, 'https://maps.google.com', '2025-10-26 16:01:37'),
(3, 3, 'Cafe Horizon', 'Makati City', 'Modern café with relaxing ambiance.', '300 Mbps', 'quiet', 18, '08:00:00', '00:00:00', '200-400', 1, 'https://maps.google.com', '2025-10-31 04:27:58'),
(4, 3, 'Bean Avenue', 'BGC, Taguig', 'Minimalist coffee shop with plenty of sockets.', '250 Mbps', 'moderate', 25, '07:30:00', '23:30:00', '180-350', 1, 'https://maps.google.com', '2025-11-04 16:54:19'),
(5, 3, 'Midnight Coffee', 'España, Manila', 'Open late for students finishing requirements.', '180 Mbps', 'loud', 10, '16:00:00', '03:00:00', '120-280', 0, 'https://maps.google.com', '2025-11-09 05:20:40'),
(6, 2, 'Sunrise Grind', 'Marikina City', 'Neighborhood favorite with early opening hours.', '120 Mbps', 'moderate', 10, '06:00:00', '21:00:00', '100-250', 1, 'https://maps.google.com', '2025-11-13 17:47:01'),
(7, 7, 'Kape Republika', 'Pasay City', 'Industrial-chic cafe near the airport area.', '200 Mbps', 'quiet', 16, '07:00:00', '22:00:00', '150-320', 1, 'https://maps.google.com', '2025-11-18 06:13:22'),
(8, 7, 'The Reading Nook Cafe', 'Ermita, Manila', 'Book-themed cafe great for long study sessions.', '160 Mbps', 'quiet', 14, '08:00:00', '21:00:00', '130-300', 1, 'https://maps.google.com', '2025-11-22 18:39:43'),
(9, 7, 'Brewtiful Mornings', 'Antipolo City', 'Hillside cafe with a view, popular on weekends.', '90 Mbps', 'moderate', 8, '06:30:00', '20:00:00', '120-280', 0, 'https://maps.google.com', '2025-11-27 07:06:04'),
(10, 8, 'Kapehan sa Kanto', 'Caloocan City', 'No-frills corner cafe with cheap, strong coffee.', '60 Mbps', 'loud', 6, '06:00:00', '20:00:00', '80-180', 0, 'https://maps.google.com', '2025-12-01 19:32:25'),
(11, 8, 'Grind House PH', 'Mandaluyong City', 'Industrial-style cafe popular with freelancers.', '220 Mbps', 'quiet', 22, '07:00:00', '23:00:00', '180-360', 1, 'https://maps.google.com', '2025-12-06 07:58:47'),
(12, 8, 'Cloud 9 Coffee', 'Parañaque City', 'Bright, airy cafe close to the airport.', '140 Mbps', 'moderate', 15, '07:00:00', '22:00:00', '150-300', 1, 'https://maps.google.com', '2025-12-10 20:25:08'),
(13, 9, 'Roast & Toast', 'Las Piñas City', 'Family-run cafe known for its all-day breakfast.', '100 Mbps', 'moderate', 12, '06:00:00', '21:00:00', '110-260', 0, 'https://maps.google.com', '2025-12-15 08:51:29'),
(14, 9, 'The Daily Grind Manila', 'Muntinlupa City', 'Reliable wifi and generous outlets for remote work.', '180 Mbps', 'quiet', 20, '07:00:00', '22:30:00', '160-320', 1, 'https://maps.google.com', '2025-12-19 21:17:50'),
(15, 9, 'Kape at Kwento', 'Valenzuela City', 'Cozy storytelling-themed cafe with board games.', '80 Mbps', 'moderate', 9, '08:00:00', '21:00:00', '100-240', 0, 'https://maps.google.com', '2025-12-24 09:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `reportcode`
--

CREATE TABLE `reportcode` (
  `report_code` int(11) NOT NULL,
  `report` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reportcode`
--

INSERT INTO `reportcode` (`report_code`, `report`) VALUES
(10, 'Copyright Violation'),
(12, 'Discrimination'),
(9, 'Duplicate Listing'),
(7, 'Fake Review'),
(4, 'False Information'),
(1, 'Harassment'),
(2, 'Hate Speech'),
(13, 'Impersonation'),
(3, 'Inappropriate Language'),
(15, 'Other'),
(8, 'Scam or Fraud'),
(5, 'Sharing Personal Information'),
(14, 'Solicitation'),
(6, 'Spam'),
(11, 'Threatening Behavior');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `reported_user_id` int(11) DEFAULT NULL,
  `reported_cafe_id` int(11) DEFAULT NULL,
  `reported_review_id` int(11) DEFAULT NULL,
  `report_code` int(11) NOT NULL,
  `status` enum('ongoing','resolved') DEFAULT 'ongoing',
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `reporter_id`, `reported_user_id`, `reported_cafe_id`, `reported_review_id`, `report_code`, `status`, `created_on`) VALUES
(1, 2, 4, 1, 1, 3, 'ongoing', '2026-05-13 11:21:04'),
(2, 3, 5, 1, 2, 1, 'resolved', '2026-05-17 23:47:25'),
(3, 2, 6, 2, 3, 4, 'ongoing', '2026-05-22 12:13:47'),
(4, 3, 4, 3, 4, 5, 'resolved', '2026-05-27 00:40:08'),
(5, 2, 5, 4, 5, 2, 'ongoing', '2026-05-31 13:06:29'),
(6, 3, 6, 5, 6, 3, 'resolved', '2026-06-05 01:32:50'),
(7, 7, NULL, NULL, 7, 6, 'ongoing', '2026-06-09 13:59:11'),
(8, 8, 10, NULL, NULL, 7, 'resolved', '2026-06-14 02:25:32'),
(9, 9, NULL, 6, NULL, 8, 'ongoing', '2026-06-18 14:51:53'),
(10, 10, NULL, NULL, 9, 9, 'resolved', '2026-06-23 03:18:14'),
(11, 11, 12, NULL, NULL, 10, 'ongoing', '2026-06-27 15:44:35'),
(12, 12, NULL, 10, NULL, 11, 'resolved', '2026-07-02 04:10:56'),
(13, 13, NULL, NULL, 13, 12, 'ongoing', '2026-07-06 16:37:17'),
(14, 14, 9, NULL, NULL, 13, 'resolved', '2026-07-11 05:03:38'),
(15, 15, NULL, 14, NULL, 14, 'ongoing', '2026-07-15 17:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `owner_reply` varchar(255) DEFAULT NULL,
  `is_inappropriate` tinyint(1) DEFAULT 0,
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `customer_id`, `cafe_id`, `rating`, `comment`, `owner_reply`, `is_inappropriate`, `created_on`) VALUES
(1, 4, 1, 5, 'Fast WiFi with many outlets. Highly recommended!', 'Thank you for visiting!', 0, '2026-03-06 16:45:48'),
(2, 5, 1, 3, 'It is louder than I expected during peak hours.', 'We appreciate the feedback.', 0, '2026-03-11 05:12:09'),
(3, 6, 2, 4, 'Coffee tastes great and the staff are friendly.', 'Glad you enjoyed!', 0, '2026-03-15 17:38:30'),
(4, 4, 3, 5, 'Very quiet place to study for exams.', 'Hope to see you again!', 0, '2026-03-20 06:04:51'),
(5, 5, 4, 4, 'Lots of charging outlets and comfortable seats.', 'Thank you!', 0, '2026-03-24 18:31:12'),
(6, 6, 5, 2, 'Music was too loud and WiFi was unstable.', 'We will work on improving.', 0, '2026-03-29 06:57:34'),
(7, 10, 6, 5, 'Cheap, strong coffee and opens super early.', 'Thanks for the support!', 0, '2026-04-02 19:23:55'),
(8, 10, 7, 4, 'Nice industrial vibe, good for group study.', NULL, 0, '2026-04-07 07:50:16'),
(9, 11, 8, 3, 'Cute theme but seating fills up fast.', 'We are planning an expansion.', 0, '2026-04-11 20:16:37'),
(10, 11, 9, 5, 'Great view, worth the trip up the hill.', NULL, 0, '2026-04-16 08:42:58'),
(11, 12, 10, 4, 'Simple but the coffee is surprisingly good.', 'Thank you po!', 0, '2026-04-20 21:09:19'),
(12, 12, 11, 2, 'Too crowded and hard to find a seat.', NULL, 0, '2026-04-25 09:35:40'),
(13, 13, 12, 5, 'Bright and clean, loved the pastries too.', 'See you again soon!', 0, '2026-04-29 22:02:01'),
(14, 14, 13, 4, 'Breakfast options were a nice surprise.', NULL, 0, '2026-05-04 10:28:22'),
(15, 15, 14, 3, 'Decent wifi but outlets were all taken.', 'Noted, adding more outlets.', 0, '2026-05-08 22:54:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobilenumber` varchar(20) DEFAULT NULL,
  `role` enum('customer','owner','admin') NOT NULL,
  `account_status` enum('active','suspended','deleted') DEFAULT 'active',
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `email`, `mobilenumber`, `role`, `account_status`, `created_on`) VALUES
(1, 'Albert', 'Wesker', 'admin1', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'admin@gmail.com', '09604700469', 'admin', 'active', '2025-08-15 09:00:00'),
(2, 'Claire', 'Redfield', 'owner1', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'owner1@gmail.com', '09171234567', 'owner', 'active', '2025-08-19 21:26:21'),
(3, 'Leon', 'Kennedy', 'owner2', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'owner2@gmail.com', '09181234567', 'owner', 'active', '2025-08-24 09:52:42'),
(4, 'Jill', 'Valentine', 'customer1', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer1@gmail.com', '09221234567', 'customer', 'active', '2025-08-28 22:19:03'),
(5, 'Ada', 'Wong', 'customer2', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer2@gmail.com', '09231234567', 'customer', 'active', '2025-09-02 10:45:24'),
(6, 'Chris', 'Redfield', 'customer3', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer3@gmail.com', '09241234567', 'customer', 'active', '2025-09-06 23:11:45'),
(7, 'Barry', 'Burton', 'owner3', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'owner3@gmail.com', '09251234567', 'owner', 'active', '2025-09-11 11:38:06'),
(8, 'Rebecca', 'Chambers', 'owner4', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'owner4@gmail.com', '09261234567', 'owner', 'active', '2025-09-16 00:04:27'),
(9, 'Carlos', 'Oliveira', 'owner5', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'owner5@gmail.com', '09271234567', 'owner', 'active', '2025-09-20 12:30:48'),
(10, 'Sherry', 'Birkin', 'customer4', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer4@gmail.com', '09281234567', 'customer', 'active', '2025-09-25 00:57:09'),
(11, 'Piers', 'Nivans', 'customer5', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer5@gmail.com', '09291234567', 'customer', 'active', '2025-09-29 13:23:30'),
(12, 'Helena', 'Harper', 'customer6', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer6@gmail.com', '09301234567', 'customer', 'active', '2025-10-04 01:49:51'),
(13, 'Moira', 'Burton', 'customer7', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer7@gmail.com', '09311234567', 'customer', 'active', '2025-10-08 14:16:12'),
(14, 'Ethan', 'Winters', 'customer8', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer8@gmail.com', '09321234567', 'customer', 'active', '2025-10-13 02:42:34'),
(15, 'Mia', 'Winters', 'customer9', '$2b$10$1gRNhS4GGwdf9O7XQeXl..2O9RCzSJyYRUrrj33cOXJWR5X.lQeUa', 'customer9@gmail.com', '09331234567', 'customer', 'active', '2025-10-17 15:08:55'),
(16, 'Miku', 'Hatsune', 'MikuDayo123', '$2y$10$q1TqjVh4btjQc1vUboKV8emsQF8Pg5sHohaAllyqLpHrrmVBTU6OC', 'MikuVocaloid@gmail.com', '09121378901', 'customer', 'active', '2026-08-01 20:58:14'),
(17, 'Rin', 'Kagamine', 'RinKGMN', '$2y$10$AAJvbCo1mxa7IUNl3Kh9NOZuaqFzz7JKGwHr55mGzwvkJ4hN4qY7K', 'RinKGMN@gmail.com', '09123930412', 'customer', 'active', '2026-04-01 21:07:47'),
(18, 'Len', 'Kagamine', 'LenKGMN', '$2y$10$BU.gkAHaCFWSH2vAXN89Wuz9ELdeyO8AS.W/vu1tVzaPl7Ify1EAS', 'LenKGMN@gmail.com', '09127391022', 'owner', 'suspended', '2026-02-01 21:10:08');

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
-- Indexes for table `reportcode`
--
ALTER TABLE `reportcode`
  ADD PRIMARY KEY (`report_code`),
  ADD UNIQUE KEY `report` (`report`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `reported_user_id` (`reported_user_id`),
  ADD KEY `reported_cafe_id` (`reported_cafe_id`),
  ADD KEY `reported_review_id` (`reported_review_id`),
  ADD KEY `report_code` (`report_code`);

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
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cafeimg`
--
ALTER TABLE `cafeimg`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cafes`
--
ALTER TABLE `cafes`
  MODIFY `cafe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reportcode`
--
ALTER TABLE `reportcode`
  MODIFY `report_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  ADD CONSTRAINT `reports_ibfk_4` FOREIGN KEY (`reported_review_id`) REFERENCES `reviews` (`review_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_ibfk_5` FOREIGN KEY (`report_code`) REFERENCES `reportcode` (`report_code`);

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
