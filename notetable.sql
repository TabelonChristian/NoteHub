-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 01:38 AM
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
-- Database: `notes`
--

-- --------------------------------------------------------

--
-- Table structure for table `notetable`
--

CREATE TABLE `notetable` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_title` varchar(100) NOT NULL,
  `note_desc` longtext NOT NULL,
  `note_date` date NOT NULL,
  `note_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notetable`
--

INSERT INTO `notetable` (`note_id`, `user_id`, `note_title`, `note_desc`, `note_date`, `note_status`) VALUES
(12, 6, 'qweqweweqwekk', 'qweqweqweqweqweqweqwekk', '2024-04-13', 'Added'),
(13, 6, 'Believer by Imagine Dragons', 'Yay', '2024-04-13', 'Added'),
(14, 6, 'Chaka chaka chaka chaka', 'adsadasdasdasda', '2024-04-13', 'Added');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notetable`
--
ALTER TABLE `notetable`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `UserxNote` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notetable`
--
ALTER TABLE `notetable`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notetable`
--
ALTER TABLE `notetable`
  ADD CONSTRAINT `UserxNote` FOREIGN KEY (`user_id`) REFERENCES `usertable` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
