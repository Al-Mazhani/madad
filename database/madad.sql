-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 04:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `madad`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id_author` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `bio` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pages` int(11) DEFAULT NULL,
  `file_type` varchar(20) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `language` varchar(50) DEFAULT NULL,
  `book_url` varchar(255) DEFAULT NULL,
  `readBook` int(11) DEFAULT 0,
  `downloads` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `title_category` varchar(40) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes_book`
--

CREATE TABLE `likes_book` (
  `id_like` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `likes` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL CHECK (`role` in ('user','admin')),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `token`, `role`, `created_at`) VALUES
(1, 'username', 'admin@gmail.com', 'kdfldsfjdslfdslcf46ca0c71cef6a0ff90702364e8e66cc53cb020d0ef88c1637dc5e20591', 'cf46ca0c71cef6a0ff90702364e8e66cc53cb020d0ef88c1637dc5e205919036', 'user', '2025-12-30 17:43:02'),
(4, 'احمد', 'ali@gmail.com', 'dfkdslfdslfdslf', 'f1uuknf51ja7t1lnf8n68bbogr', 'user', '2025-12-30 17:53:22');

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewbookwithuthor`
-- (See below for the actual view)
--
CREATE TABLE `viewbookwithuthor` (
`id_book` int(11)
,`id_author` int(11)
,`title` varchar(255)
,`name` varchar(40)
,`image` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `viewbookwithuthor`
--
DROP TABLE IF EXISTS `viewbookwithuthor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewbookwithuthor`  AS SELECT `books`.`id_book` AS `id_book`, `authors`.`id_author` AS `id_author`, `books`.`title` AS `title`, `authors`.`name` AS `name`, `books`.`image` AS `image` FROM (`books` join `authors` on(`books`.`author_id` = `authors`.`id_author`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id_author`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `fk_author` (`author_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `likes_book`
--
ALTER TABLE `likes_book`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_book` (`id_book`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes_book`
--
ALTER TABLE `likes_book`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id_author`);

--
-- Constraints for table `likes_book`
--
ALTER TABLE `likes_book`
  ADD CONSTRAINT `likes_book_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
