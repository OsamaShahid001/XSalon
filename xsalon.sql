-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 07:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xsalon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `Role` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `join_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `Role`, `date`, `join_date`) VALUES
(1, 'Admin', '', 'admin123', 'Admin', '20-Jan-2024', '01-jan-2024'),
(3, 'jacksparrow', 'sparrow@gmail.com', '12345', 'Staff', '20-Jan-2024', '09-jan-2024'),
(4, 'william sparrow', 'william@gmail.com', '202cb962ac59075b964b07152d234b70', 'Staff', '14-Jan-2024', '09-Jan-2024'),
(8, 'jack williams', 'jack@gmail.com', '202cb962ac59075b964b07152d234b70', 'Receptionist', '14-Jan-2024', '09-Jan-2024'),
(9, 'Admin', '', 'admin123', 'Admin', '20-Jan-2024', '01-jan-2024');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `services` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `date`, `time`, `name`, `email`, `services`, `price`, `user_id`, `feedback`) VALUES
(57, '2024-01-03', '6:00', 'babar', 'babar@gmail.com', 'Hair Wash', '', 0, ''),
(82, '2024-01-07', '3:00', 'moid', 'babar@gmail.com', 'Massage', '', 1, 'feedback'),
(84, '2024-02-07', '1:00', 'babar', 'babar@gmail.com', 'Hair Shave', '12.99', 1, ''),
(85, '2024-02-08', '12:00', 'babar', 'babar@gmail.com', 'Beard Trim', '16.99', 1, ''),
(86, '2024-02-02', '3:00', 'afsa', 'babar@gmail.com', 'Massage', '20.99', 1, ''),
(88, '2024-01-10', '3:00', 'babar', 'user123@gmail.com', 'Shampoo', '15.99', 2, 'Feedback'),
(89, '2024-01-11', '2:00', 'babr', 'babar@gmail.com', 'Hair Color', '11.99', 1, 'Feedback'),
(90, '2024-01-11', '1:00', 'tariq', 'babar@gmail.com', 'Hair Cut', '9.99', 1, 'Feedback'),
(91, '2024-01-11', '3:00', 'farooq', 'babar@gmail.com', 'Clean Up', '19.99', 1, ''),
(92, '2024-01-14', '1:00', 'babar', 'babar@gmail.com', 'Hair Wash', '10.99', 1, 'Feedback'),
(93, '2024-01-14', '5:00', 'rafeeq', 'babar@gmail.com', 'Shampoo', '15.99', 1, 'Feedback'),
(94, '2024-01-17', '1:00', 'babar', 'babar@gmail.com', 'Facial', '14.99', 1, ''),
(95, '2024-01-17', '5:00', 'gafar', 'babar@gmail.com', 'Clean Up', '19.99', 1, ''),
(96, '2024-01-16', '2:00', 'babar', 'babar@gmail.com', 'Hair Shave', '12.99', 1, ''),
(97, '2024-01-17', '2:00', 'babar', 'babar@gmail.com', 'Hair Shave', '12.99', 1, ''),
(98, '2024-01-18', '4:00', 'babar', 'babar@gmail.com', 'Beard Trim', '16.99', 1, 'Feedback'),
(99, '2024-01-18', '2:00', 'happy girl', 'babar@gmail.com', 'Wedding Cut', '18.99', 1, ''),
(101, '2024-01-21', '12:00', 'osama', 'babar@gmail.com', 'Facial', '14.99', 1, ''),
(103, '2024-08-08', '12:00', 'CLEANING', 'starz1482@gmail.com', 'Hair Cut', '9.99', 9, '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(250) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `email`, `subject`, `message`, `user_id`) VALUES
(22, 'johnsmith@gmail.com', 'urgent', 'I want To work As a staff in Your Salon! Is there Any Postion For me ?', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_sku` varchar(50) NOT NULL,
  `wholesaler` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `inventory` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_name`, `product_sku`, `wholesaler`, `category`, `image`, `inventory`, `price`) VALUES
(63, 'Shampoo', '123123', 'Sunsilk', 'Sunsilk Shampoo', 'assets/imgs/shampoo.jpg', 199, 12.99),
(64, 'Whitening Cream', '2322137', 'Cream world Distributor', 'Cream', 'assets/imgs/download (4).jpg', 0, 14.99),
(65, 'comb', '3432', 'Comb world dis', 'Comb', 'assets/imgs/download (2).jpg', 10, 23.99),
(67, 'Hair Spray', '446322', 'Straight Spray', 'Spray', 'assets/imgs/download (1).jpg', 35, 35.94),
(70, 'Tissue', '453453', 'Party Tissues Distributor', 'Tissue', 'assets/imgs/download.jpg', 4, 9.99),
(75, 'Whitening Soap', '4354', 'Soap Factory', 'Whitening soap', 'assets/imgs/download (3).jpg', 12, 4.99);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `ratings` varchar(10) NOT NULL,
  `reviews` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `email`, `ratings`, `reviews`, `user_id`, `image`) VALUES
(15, 'babar', 'babar@gmail.com', '4', 'This salon services are so better than any local salon and their staff is so good. I love It !', 1, 'img/Akashi-Kaikyo Bridge pic6.jpg'),
(16, 'babar', 'babar@gmail.com', '5', 'I was so scared before doing hair color but after seeing result i love it recommended for everyone.', 1, 'img/Akashi-Kaikyo Bridge pic6.jpg'),
(29, 'user', 'user123@gmail.com', '5', 'Wow I\'m Impressed with There Service They Are Great In work I loved it! So Co-operative Staff :)', 2, 'img/Balinghe Bridge 2 pic2.jpg'),
(30, 'babar', 'babar@gmail.com', '5', '', 1, 'img/Akashi-Kaikyo Bridge pic6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `date`) VALUES
(1, 'babar', 'babar@gmail.com', '202cb962ac59075b964b07152d234b70', 'img/Akashi-Kaikyo Bridge pic6.jpg', '2024-01-07 16:23:45'),
(2, 'user', 'user123@gmail.com', '202cb962ac59075b964b07152d234b70', 'img/Balinghe Bridge 2 pic2.jpg', '2024-01-05 13:12:25'),
(4, 'hadi', 'hadi@gmail.com', '202cb962ac59075b964b07152d234b70', 'img/user-default.png', '2024-01-17 19:40:11'),
(5, 'osama', 'osama@gmail.com', '12345', 'img/user-default.png', '2024-08-07 16:20:06'),
(7, 'hafsa123', 'hafsa@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'img/user-default.png', '2024-07-11 22:30:08'),
(8, 'sir', 'sir@gmail.com', '123', 'img/user-default.png', '2024-01-08 19:16:47'),
(9, 'Admin', 'starz1482@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'img/user-default.png', '2024-08-07 16:22:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
