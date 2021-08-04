-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2021 at 08:02 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `body`, `created`, `author_id`) VALUES
(4, 'My Great Article', 'my-great-article', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laudantium nulla laboriosam praesentium magnam impedit accusantium architecto non voluptas voluptatibus quo dolor atque, provident dolorem iste reprehenderit beatae unde placeat veniam, sint libero delectus nisi mollitia sit? Tempore quo distinctio voluptatem earum, consequuntur dolor non. Ullam itaque ipsam odio? Error debitis deserunt sapiente eaque id, asperiores, odio similique cumque dolor quod dicta pariatur! Commodi animi, unde eaque fugiat totam nulla necessitatibus rerum. Expedita perspiciatis corrupti repellendus necessitatibus provident iure ullam. Tenetur neque veniam id consequatur inventore quia ab, accusantium voluptatibus voluptas assumenda, ipsa omnis exercitationem ea ipsum totam, sunt eius temporibus architecto amet vitae. Voluptas temporibus error voluptatem doloribus sunt totam illo non provident molestiae neque, repudiandae autem numquam laudantium vel, beatae dolorem at harum omnis. Dolore sed delectus consequatur, vel harum rem, nobis laudantium eius libero voluptate facilis. Praesentium pariatur necessitatibus, mollitia ipsam nostrum repellendus iste ipsa alias soluta saepe!', 1627900061, 8);

-- --------------------------------------------------------

--
-- Table structure for table `articles_images`
--

CREATE TABLE `articles_images` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `image` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles_images`
--

INSERT INTO `articles_images` (`id`, `article_id`, `image`) VALUES
(3, 4, '9589aad2d8c5d432cccc5443c5db3232.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'user'),
(2, 'admin'),
(3, 'author');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joined` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `joined`, `role_id`) VALUES
(8, 'p.braunen@sae.edu', 'Philip', 'Braunen', '$2y$10$UP3ApMvQJw/g9x64v4PJN.eNkTq4mcPeKThUyzyKRphLHNIcYNChG', 1627294672, 2),
(9, 'test@test.test', 'Tom', 'Niekerken', '$2y$10$Up3ptosvnid7sBmyijKR5.TlEP3G2ENWt1bd1RPfv7q1sL4rhUtkS', 1627378794, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `articles_images`
--
ALTER TABLE `articles_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `articles_images`
--
ALTER TABLE `articles_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `articles_images`
--
ALTER TABLE `articles_images`
  ADD CONSTRAINT `articles_images_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
