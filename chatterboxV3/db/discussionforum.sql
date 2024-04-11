-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2024 at 10:36 PM
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
-- Database: `discussionforum`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'Passw0rd');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(9) NOT NULL,
  `text` int(200) NOT NULL,
  `date` datetime NOT NULL,
  `author` int(5) NOT NULL,
  `con_id` int(5) NOT NULL,
  `likes` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `communities`
--

CREATE TABLE `communities` (
  `com_id` int(9) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `content_id` int(9) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `author` int(5) NOT NULL,
  `title` varchar(40) NOT NULL,
  `likes` int(9) NOT NULL,
  `com_id` int(5) NOT NULL,
  `img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_id`
--

CREATE TABLE `temp_id` (
  `id` int(9) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(5) NOT NULL,
  `end` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `email` varchar(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `checkAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `profile` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `email`, `password`, `date`, `checkAdmin`, `profile`) VALUES
(13, 'laa', 'laa@email.c', '$2y$10$YuMn', '2024-03-26 22:50:05', 0, 0x4f49502e6a706567),
(14, 'foolaa', 'foolaa@emai', '$2y$10$cNVF', '2024-03-26 22:51:24', 0, 0x4f49502e6a706567),
(15, 'admin', 'admin@email', '$2y$10$iEqF', '2024-03-27 09:49:45', 1, 0x4f49502e6a706567);

-- --------------------------------------------------------

--
-- Table structure for table `user_communities`
--

CREATE TABLE `user_communities` (
  `uid` int(9) NOT NULL,
  `com_id` int(9) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `author` (`author`),
  ADD KEY `con_id` (`con_id`);

--
-- Indexes for table `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `author FK to uid` (`author`),
  ADD KEY `com_id` (`com_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user_communities`
--
ALTER TABLE `user_communities`
  ADD KEY `uid FK to uid in USERS` (`uid`),
  ADD KEY `com_id FK to com_id in COMMUNITIES` (`com_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogin`
--
ALTER TABLE `adminlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `communities`
--
ALTER TABLE `communities`
  MODIFY `com_id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`con_id`) REFERENCES `content` (`content_id`);

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `author FK to uid` FOREIGN KEY (`author`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `communities` (`com_id`);

--
-- Constraints for table `user_communities`
--
ALTER TABLE `user_communities`
  ADD CONSTRAINT `com_id FK to com_id in COMMUNITIES` FOREIGN KEY (`com_id`) REFERENCES `communities` (`com_id`),
  ADD CONSTRAINT `uid FK to uid in USERS` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
