-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2024 at 09:42 PM
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
  `text` text NOT NULL,
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
  `img` blob NOT NULL,
  `dislikes` int(9) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `text`, `date`, `author`, `title`, `likes`, `com_id`, `img`, `dislikes`) VALUES
(1, 'Cows love to give milk!', '0000-00-00 00:00:00', 16, 'Cows are cute', 0, 0, 0x494d475f36363138316163343438316239372e33343938353534392e6a706567, 0);

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
(15, 'admin', 'admin@email', '$2y$10$iEqF', '2024-03-27 09:49:45', 1, 0x4f49502e6a706567),
(16, 'test', 'test@email.', '$2y$10$hcb5Pa1WCm3xQViF8cmo6eI.oTsknjNswp.bAigLJg4vDker6Kpi6', '0000-00-00 00:00:00', 0, 0x53637265656e73686f7420323032332d30392d3236203136343131352e706e67),
(17, 'Joe', 'Joe@email.c', '$2y$10$rBdxeJM.v5V/svXF.lK0oOomLPx5Xpas86.L5Gwht1O40ql/U4i9e', '0000-00-00 00:00:00', 0, 0x53637265656e73686f7420323032332d30362d3037203134323934302e706e67),
(18, 'Test3', 'Test3@email', '$2y$10$KTEkB8/OId1LJKgfzBYSWuCKsh9f679/Crqms4adytak1/qmefi32', '0000-00-00 00:00:00', 0, 0x646f776e6c6f61642e6a706567);

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
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `content_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;