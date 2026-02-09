-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 31 يناير 2026 الساعة 18:18
-- إصدار الخادم: 10.4.32-MariaDB
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
-- بنية الجدول `authors`
--

CREATE TABLE `authors` (
  `id_author` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `bio` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `public_id` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `authors`
--

INSERT INTO `authors` (`id_author`, `name`, `bio`, `image`, `created_at`, `public_id`) VALUES
(1, 'أحمد آل حمدان', 'ولد الكاتب الشاب أحمد آل حمدان في جدة بالمملكة العربية السعودية عام 1992 م، ونشأ فيها وحصل على شهادة البكالوريوس في الرياضيات من جامعة الملك عبد العزيز.\r\n\r\nأصدر عام 2017 روايته الأولى «مدينة الحب لا يسكنها العقلاء»،[2] التي تدور قصتها حول شخص يؤلف كتاباً يدعو فيه عشيقته التي لا تحب القراءة إلى الرجوع اليه عن طريق وضع صورته على الغلاف.[3][4][5][6] أصدر بعدها جزءا ثانيا من القصة بعنوان «أنت كل أشيائي الجميلة»،[7] وثالثا بعنوان «ردني إليك»', 'uploads/Author_profile/696284b19d3ea.jpg', '0000-00-00 00:00:00', '241fed-99670e-6e7221-ca3e9b'),
(5, 'فيودور  دوستويفسكي ', 'فيودور ميخايلوفيتش دوستويفسكي (بالروسية: Фёдор Миха́йлович Достое́вский )‏; أص‌د: [ˈfʲɵdər mʲɪˈxajləvʲɪtɕ dəstɐˈjɛfskʲɪj]   ( سماع) ؛ (11 نوفمبر 1821 - 9 فبراير 1881). هو روائي وكاتب قصص قصيرة وصحفي وفيلسوف روسي. وهو واحدٌ من أشهر الكُتاب والمؤلفين حول العالم. رواياته تحوي فهماً عميقاً للنفس البشرية كما تقدم تحليلاً ثاقباً للحالة السياسية والاجتماعية والروحية لروسيا في القرن التاسع عشر، وتتعامل مع مجموعة متنوعة من المواضيع الفلسفية والدينية.', 'uploads/Author_profile/69566bb14e5ca.jpg', '0000-00-00 00:00:00', '769978-72c0ec-29858d-e4cc4a');

-- --------------------------------------------------------

--
-- Stand-in structure for view `base_view_book`
-- (See below for the actual view)
--
CREATE TABLE `base_view_book` (
`book_public_id` char(40)
,`title` varchar(255)
,`image` varchar(255)
,`author_public_id` char(40)
,`name` varchar(40)
,`category_public_id` char(40)
);

-- --------------------------------------------------------

--
-- بنية الجدول `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `public_id` char(40) DEFAULT 'NOT NULL',
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

--
-- إرجاع أو استيراد بيانات الجدول `books`
--

INSERT INTO `books` (`id_book`, `public_id`, `title`, `pages`, `file_type`, `file_size`, `image`, `year`, `description`, `author_id`, `id_category`, `language`, `book_url`, `readBook`, `downloads`, `created_at`) VALUES
(1, '2ceb12-8c7d2c-56293f-ca0488', 'ابابيل ', 2000, 'PDF', 3897, 'uploads/image_book/6961e1c2c9bdd.webp', '2026', '                                                                                                                     سي                                                                                                              ', 1, 1, 'العربية', 'uploads/book_url/697c569761b3b.pdf', 4, 6, '0000-00-00 00:00:00'),
(2, '73f79f-f81155-f92b40-b6168a', 'الليالي البيضاء', 2000, 'PDF', 4019, 'uploads/image_book/69594efeee181.jpg', '2026', 'asd', 5, 1, 'العربية', 'uploads/book_url/69594efeee2fc.pdf', 2, 1, '0000-00-00 00:00:00'),
(5, '6f8570-0db744-eaf4a6-f364ef', 'الجريمة والعقاب', 2005, 'PDF', 4116037, 'uploads/image_book/6961e3dca106c.jpg', '1990', '                                                                              تعتبر هذه الرواية من أفضل ما كتب فيودور دوستويفسكي، حيث نالت هذه الرواية شهره واسعة في العالم، في أول الأمر لم تنشر على أنها رواية، و لكن تم نشرها في المجلة الأدبية الروسية في عام ١٨٦٦، و تشمل الرواية قضية مهمة، و هي الخير و الشر، و الثواب و العقاب، و تعتبر من أكثر الروايات التي عبر فيها الكاتب عن نفسه، لذلك نجحت في الوصول إلى الناس .\r\n\r\n                                                   ', 5, 2, 'العربية', 'uploads/book_url/6961e3dca15a2.pdf', 1, 0, '0000-00-00 00:00:00'),
(17, '1fafec-d21810-bbedbf-220368', 'حضارة العرب', 200, 'PDF', 3897, 'uploads/image_book/69760edf4892f.jpg', '0000', '                                                          حضارة العرب                                                ', 1, 1, 'العربية', 'uploads/book_url/69760edf48aeb.pdf', 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `book_info_view`
-- (See below for the actual view)
--
CREATE TABLE `book_info_view` (
`book_public_id` char(40)
,`title` varchar(255)
,`pages` int(11)
,`language` varchar(50)
,`file_size` int(11)
,`file_type` varchar(20)
,`year` year(4)
,`image` varchar(255)
,`book_url` varchar(255)
,`readBook` int(11)
,`downloads` int(11)
,`description` text
,`name` varchar(40)
,`title_category` varchar(40)
,`category_public_id` char(40)
);

-- --------------------------------------------------------

--
-- بنية الجدول `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `title_category` varchar(40) NOT NULL,
  `created_at` datetime NOT NULL,
  `category_public_id` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `category`
--

INSERT INTO `category` (`id_category`, `title_category`, `created_at`, `category_public_id`) VALUES
(1, 'روايات', '0000-00-00 00:00:00', '663b67-9573b4-b4a801-1c0785'),
(2, 'فلسفة', '0000-00-00 00:00:00', '663b67-9573b4-b4a801-1c0783');

-- --------------------------------------------------------

--
-- بنية الجدول `likes_book`
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
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `active_user` int(11) NOT NULL DEFAULT 0 CHECK (`active_user` in (0,1))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `token`, `role`, `created_at`, `active_user`) VALUES
(1, 'username', 'admin@gmail.com', 'kdfldsfjdslfdslcf46ca0c71cef6a0ff90702364e8e66cc53cb020d0ef88c1637dc5e20591', 'cf46ca0c71cef6a0ff90702364e8e66cc53cb020d0ef88c1637dc5e205919036', 'user', '2025-12-30 17:43:02', 1),
(2, 'احمد', 'ali@gmail.com', 'dfkdslfdslfdslf', 'f1uuknf51ja7t1lnf8n68bbogr', 'user', '2025-12-30 17:53:22', 1),
(5, 'username', 'jkdfjdsfjdsf@gmail.com', '$2y$10$CvDOluLlkD7a1orTO.FW5enRB0ZVRWhFXRBfD1ryr2iL9S2SMtFTO', '4e5f0d-eb6474-cdaeb140-1ebc5b2e63', 'user', '2026-01-05 12:16:19', 1),
(6, 'username', 'adfgsfgsf@gmail.com', '$2y$10$60t4ja4G/hpjyXkEwukwWutd5PtlINrfnTc8GEihLhl0OqlRJzUJa', 'be9566-fa25a9-94c3923b-2ac5940239', 'user', '2026-01-05 12:17:25', 1),
(7, 'Hussein', 'hussein@gmail.com', '12345', 'be9566-fa25a9-94c3923b-2ac5940232', 'admin', '2026-01-10 21:47:32', 1),
(8, 'sda23', 'alig@gmail.com', '$2y$10$i6KqlRvUlKubD54mE4slBuY1fURGP8ajPCokA.OL5qA1zXjowkMLS', 'a981f4-d7412b-62f6cc-f0a674', 'admin', '2026-01-10 22:01:17', 1),
(9, 'hussein ahmed', 'hussein.ahmed@gmail.com', '$2y$10$.hZmjV4ZWzw3UPAD/o7I/ebZB0nbnjqyG8cK1EaMCRwEqXKFSDmki', '175dd4-09a64d-ed5fcb-f1a672', 'user', '2026-01-18 11:39:11', 1),
(10, 'ahmed', 'ahmed@gmail.com', '$2y$10$RUuOjD2MEk1PisKUlh00PexQ0G.CSVs.2TpV/6xvZ.I51A/4jKj.q', 'd375c0-d82215-4e4cf5-2842e7', 'admin', '2026-01-20 18:11:08', 1),
(11, 'سيس', 'aa@gmail.com', '$2y$10$n0KL3wnIs4qhhh8kHIADlO6o/a1jrJ4Y2j633t3LS9peQTqDYzexW', '861795-a54d15-2a5ee3-480213', 'user', '2026-01-20 18:51:51', 1),
(12, 'ali', 'alia@gamil.com', '$2y$10$E00LCRF9m0Z3jgx1UfAqXu3vypDXgEmoOjZZJkP53xHZ5gT9wF3M2', '7d4fa9-0ae092-98dda4-4d70d9', 'admin', '2026-01-20 19:02:41', 1),
(13, 'hussein', 'husseinahmed@gmail.com', '$2y$10$MZZqjNZG7GUihhK52ji2nur5Feaimn0RrY81TZ.LAfZxMXM6.gBOC', '2e3dce-ce2d00-e6ea37-871c5d', 'admin', '2026-01-20 19:47:56', 1),
(14, 'hussein ', 'husseinahmedabod@gmail.com', '$2y$10$EApyEZc/QnghXDITYRAvKepJzeEu7B09fTaEu//19cAgNxq0uBT2O', 'd30147-d381c6-3411d3-e4b6b2', 'user', '2026-01-21 19:06:12', 1),
(15, 'username', 'hh@gmail.com', '$2y$10$E6P8NfN3rqJHKZ9WqWmjtuQ9lLMpf4FI7Yj.iZ0Rv.OvzKCCjJr8u', 'ae03d4-0a31a0-c1ff8a-60dc0e', 'user', '2026-01-22 16:21:23', 0),
(16, 'Hussein Al-Mzhani', 'hhhh@gmail.com', '$2y$10$jQ1406MjzczcRoTfJJ9HQOqk6fhpEgkP.s/Ni7MbtngUrKmSIBosC', 'dca761-7f129f-3c5e95-1d0e4d', 'admin', '2026-01-22 19:41:21', 0),
(17, 'حسين المزحاني', 'husseinal@gmail.com', '$2y$10$Cz.8XQNoXjFvS6gRRTgiKe4jNDnbjcqXbKQ/pWI6xrtkSuBf3UuBq', 'df6281-828154-5adfb7-57db65', 'admin', '2026-01-25 18:03:21', 0),
(18, 'dfgdfg', 'adsfgad@gmail.com', '$2y$10$iHhfR2uoqlOqOteevvkvAuxn4R2.Dp/BfPFZRaSic5JEM73X9Nfmi', '432756-2561fa-70c4ec-feda88', 'admin', '2026-01-25 19:27:23', 0),
(19, 'sdfsdf', 'sdfsdfd@gmail.com', '$2y$10$mGiqtmHeGPfqn6bR0ErDhO79.R/AiBUKYkfokZ79qMQiVXtlqE/zC', '8fcdc0-6354ac-60b60e-cfbd61', 'admin', '2026-01-25 19:39:06', 0),
(20, 'sdfdsf', 'asdfasdfadsf@gmail.com', '$2y$10$QU6A00/ilQdjZIyOezx2tOucO8HG.ywCgZOf5UNxThLP.GOha6ak6', '5c2fbc-ac6325-6339c4-0a7088', 'admin', '2026-01-25 19:39:30', 0),
(21, 'username', 'alis@gmail.com', '$2y$10$2KAUuIXGzzAhwtZQgaIAWOXilwyVVRIhkixL6Vn9p6lVEseAfaFF6', '724a5f-47aa10-bb8084-550c65', 'user', '2026-01-29 09:57:59', 0),
(22, 'username', 'asdjfhasdfh@gmail.com', '$2y$10$RBflmj/BjLq7GCbxYskVA.pGMLmWxCucWwXb7Jsuk5hmIPb.uDL1m', '372d7f-5c6694-50ed26-10e7a0', 'user', '2026-01-31 18:40:17', 0);

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
-- Stand-in structure for view `view_info_author`
-- (See below for the actual view)
--
CREATE TABLE `view_info_author` (
`public_id` char(40)
,`name` varchar(40)
,`bio` text
,`image` varchar(255)
,`readers` decimal(32,0)
,`allBooks` bigint(21)
,`downloads` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure for view `base_view_book`
--
DROP TABLE IF EXISTS `base_view_book`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `base_view_book`  AS SELECT `book`.`public_id` AS `book_public_id`, `book`.`title` AS `title`, `book`.`image` AS `image`, `author`.`public_id` AS `author_public_id`, `author`.`name` AS `name`, `category`.`category_public_id` AS `category_public_id` FROM ((`books` `book` join `authors` `author` on(`book`.`author_id` = `author`.`id_author`)) join `category` on(`book`.`id_category` = `category`.`id_category`)) ;

-- --------------------------------------------------------

--
-- Structure for view `book_info_view`
--
DROP TABLE IF EXISTS `book_info_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `book_info_view`  AS SELECT `book`.`public_id` AS `book_public_id`, `book`.`title` AS `title`, `book`.`pages` AS `pages`, `book`.`language` AS `language`, `book`.`file_size` AS `file_size`, `book`.`file_type` AS `file_type`, `book`.`year` AS `year`, `book`.`image` AS `image`, `book`.`book_url` AS `book_url`, `book`.`readBook` AS `readBook`, `book`.`downloads` AS `downloads`, `book`.`description` AS `description`, `author`.`name` AS `name`, `category`.`title_category` AS `title_category`, `category`.`category_public_id` AS `category_public_id` FROM ((`books` `book` join `authors` `author` on(`book`.`author_id` = `author`.`id_author`)) join `category` on(`book`.`id_category` = `category`.`id_category`)) ;

-- --------------------------------------------------------

--
-- Structure for view `viewbookwithuthor`
--
DROP TABLE IF EXISTS `viewbookwithuthor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewbookwithuthor`  AS SELECT `books`.`id_book` AS `id_book`, `authors`.`id_author` AS `id_author`, `books`.`title` AS `title`, `authors`.`name` AS `name`, `books`.`image` AS `image` FROM (`books` join `authors` on(`books`.`author_id` = `authors`.`id_author`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_info_author`
--
DROP TABLE IF EXISTS `view_info_author`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_info_author`  AS SELECT `authors`.`public_id` AS `public_id`, `authors`.`name` AS `name`, `authors`.`bio` AS `bio`, `authors`.`image` AS `image`, coalesce(sum(`books`.`readBook`),0) AS `readers`, count(`books`.`id_book`) AS `allBooks`, coalesce(sum(`books`.`downloads`),0) AS `downloads` FROM (`authors` left join `books` on(`authors`.`id_author` = `books`.`author_id`)) GROUP BY `authors`.`public_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id_author`),
  ADD UNIQUE KEY `public_id` (`public_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `fk_author` (`author_id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `category_public_id` (`category_public_id`);

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
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes_book`
--
ALTER TABLE `likes_book`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id_author`);

--
-- قيود الجداول `likes_book`
--
ALTER TABLE `likes_book`
  ADD CONSTRAINT `likes_book_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
