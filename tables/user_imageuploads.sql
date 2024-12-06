-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 09:30 AM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_imageuploads`
--

CREATE TABLE `user_imageuploads` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_imageuploads`
--

INSERT INTO `user_imageuploads` (`id`, `username`, `image_path`, `uploaded_at`) VALUES
(1, 'Test User', 'uploads/Screenshot 2024-10-22 090128.png', '2024-12-06 06:29:33'),
(2, 'Test User', 'uploads/WhatsApp Image 2024-10-17 at 8.22.19 AM.jpeg', '2024-12-06 06:54:16'),
(3, 'Test User', 'uploads/Screenshot 2024-10-22 090128.png', '2024-12-06 06:56:50'),
(4, 'Test User', 'uploads/pexels-cottonbro-6473730.jpg', '2024-12-06 06:57:29'),
(5, 'Test User', 'uploads/IMG_8468-min (1).jpg', '2024-12-06 06:57:58'),
(6, 'dhokekiran88@gmail.com', 'uploads/Screenshot 2024-10-22 090128.png', '2024-12-06 07:14:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_imageuploads`
--
ALTER TABLE `user_imageuploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_imageuploads`
--
ALTER TABLE `user_imageuploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
