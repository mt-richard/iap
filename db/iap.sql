-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 15, 2023 at 06:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iap`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_department`
--

CREATE TABLE `a_department` (
  `dep_id` int(11) NOT NULL,
  `dep_name` varchar(200) NOT NULL,
  `dep_abbreviation` varchar(10) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `createdat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_internaship_periode`
--

CREATE TABLE `a_internaship_periode` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_student` int(11) NOT NULL DEFAULT 0,
  `taken_student` int(11) NOT NULL DEFAULT 0,
  `upload_grade` enum('no','yes') NOT NULL DEFAULT 'no',
  `status` enum('activated','deactivated') NOT NULL DEFAULT 'activated',
  `user_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_internaship_periode`
--

INSERT INTO `a_internaship_periode` (`id`, `start_date`, `end_date`, `total_student`, `taken_student`, `upload_grade`, `status`, `user_id`) VALUES
(5, '2023-10-09', '2023-11-23', 28, 0, 'no', 'activated', 1),
(6, '2023-10-10', '2023-11-24', 0, 0, 'no', 'deactivated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `a_partner_student_request`
--

CREATE TABLE `a_partner_student_request` (
  `id` int(11) NOT NULL,
  `request_student_number` int(3) NOT NULL DEFAULT 0,
  `major_in` varchar(100) NOT NULL,
  `partner_id` int(5) NOT NULL,
  `internaship_id` int(3) NOT NULL,
  `given_student_number` int(3) DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_partner_student_request_totals`
--

CREATE TABLE `a_partner_student_request_totals` (
  `id` int(11) NOT NULL,
  `partner_id` int(5) NOT NULL,
  `internaship_id` int(6) NOT NULL,
  `requested_student` int(3) NOT NULL DEFAULT 0,
  `given_student` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_partner_tb`
--

CREATE TABLE `a_partner_tb` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `tin` varchar(9) NOT NULL,
  `place` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `c_profile` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_student_grade`
--

CREATE TABLE `a_student_grade` (
  `id` int(11) NOT NULL,
  `evaluation_criteria` text NOT NULL,
  `marks` int(2) NOT NULL,
  `s_marks` int(2) DEFAULT NULL,
  `attachment` varchar(200) NOT NULL,
  `student_id` varchar(7) NOT NULL,
  `partner_id` int(6) NOT NULL,
  `supervisior_id` int(6) NOT NULL,
  `internaship_id` int(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_student_logbook`
--

CREATE TABLE `a_student_logbook` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `used_tools` varchar(200) DEFAULT NULL,
  `screenshoots` varchar(200) NOT NULL DEFAULT '-',
  `objective` varchar(200) NOT NULL,
  `challenges` varchar(250) DEFAULT NULL,
  `student_id` int(6) NOT NULL,
  `suppervisor_id` int(6) NOT NULL,
  `internaship_id` int(6) NOT NULL,
  `partner_id` int(6) NOT NULL,
  `partner_comment` varchar(200) NOT NULL DEFAULT '-',
  `suppervisior_comment` varchar(200) NOT NULL DEFAULT '-',
  `log_date` date NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_student_tb`
--

CREATE TABLE `a_student_tb` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `major_in` varchar(100) NOT NULL,
  `card_id` int(6) NOT NULL,
  `internaship_periode_id` int(6) NOT NULL,
  `partner_id` int(6) DEFAULT NULL,
  `suppervisior_id` int(6) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_suppervisior_tb`
--

CREATE TABLE `a_suppervisior_tb` (
  `id` int(11) NOT NULL,
  `names` varchar(200) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `department` enum('IT','BUSSINESS','THEOLOGY','HEALTH SCIENCE') NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_users`
--

CREATE TABLE `a_users` (
  `id` bigint(20) NOT NULL,
  `names` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `secret` varchar(150) NOT NULL,
  `level` enum('ADMIN','PARTNER','STUDENT','SUPERVISIOR','USER') NOT NULL DEFAULT 'USER',
  `institition_id` varchar(5) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `a_ip` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `a_users`
--

INSERT INTO `a_users` (`id`, `names`, `username`, `phone`, `secret`, `level`, `institition_id`, `status`, `updated_at`, `a_ip`) VALUES
(1, 'IPRC KIGALI', 'iprckigali', NULL, '$2y$10$yCJUqcquW6HUZAMgufO5xOmDSX8xTwVmaDcRoxLdnC6V8B/Z77TIq', 'ADMIN', '1', 'active', '2023-10-15 11:17:03', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `notifications_tb`
--

CREATE TABLE `notifications_tb` (
  `id` int(11) NOT NULL,
  `message` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `level` enum('ADMIN','PARTNER','STUDENT','SUPERVISIOR') NOT NULL,
  `level_id` int(3) NOT NULL,
  `done_by` int(3) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications_tb`
--

INSERT INTO `notifications_tb` (`id`, `message`, `link`, `level`, `level_id`, `done_by`, `created_at`) VALUES
(6, 'Please check Monte Morar daily activity', 's_log_book?st=20204', 'SUPERVISIOR', 30, 20204, '2023-10-13 11:33:42'),
(7, 'Please check Monte Morar daily activity', 'p_log_book?st=20204', 'PARTNER', 23, 20204, '2023-10-13 11:33:42'),
(8, 'Please check Monte Morar daily activity', 's_log_book?st=20204', 'SUPERVISIOR', 30, 20204, '2023-10-13 11:34:25'),
(9, 'Please check Monte Morar daily activity', 'p_log_book?st=20204', 'PARTNER', 23, 20204, '2023-10-13 11:34:25'),
(15, 'New Assigned Student(Corkery Corkery)', 'a_partner_student?st=20318', 'SUPERVISIOR', 31, 1, '2023-10-15 11:32:28'),
(17, 'Please check Pattie Corkery daily activity', 's_log_book?st=20318', 'SUPERVISIOR', 31, 20318, '2023-10-15 11:33:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_department`
--
ALTER TABLE `a_department`
  ADD PRIMARY KEY (`dep_id`),
  ADD UNIQUE KEY `dep_name` (`dep_name`),
  ADD UNIQUE KEY `dep_abbreviation` (`dep_abbreviation`);

--
-- Indexes for table `a_internaship_periode`
--
ALTER TABLE `a_internaship_periode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `a_partner_student_request`
--
ALTER TABLE `a_partner_student_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `a_partner_student_request_totals`
--
ALTER TABLE `a_partner_student_request_totals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `partiner_id` (`partner_id`);

--
-- Indexes for table `a_partner_tb`
--
ALTER TABLE `a_partner_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_student_grade`
--
ALTER TABLE `a_student_grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `supervisior_id` (`supervisior_id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `a_student_logbook`
--
ALTER TABLE `a_student_logbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `suppervisor_id` (`suppervisor_id`),
  ADD KEY `internaship_id` (`internaship_id`),
  ADD KEY `log_date` (`log_date`);

--
-- Indexes for table `a_student_tb`
--
ALTER TABLE `a_student_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internaship_periode_id` (`internaship_periode_id`),
  ADD KEY `suppervisior_id` (`suppervisior_id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `a_suppervisior_tb`
--
ALTER TABLE `a_suppervisior_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_users`
--
ALTER TABLE `a_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_indx` (`username`),
  ADD KEY `username` (`username`),
  ADD KEY `institition_id` (`institition_id`);

--
-- Indexes for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `a_department`
--
ALTER TABLE `a_department`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_internaship_periode`
--
ALTER TABLE `a_internaship_periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `a_partner_student_request`
--
ALTER TABLE `a_partner_student_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `a_partner_student_request_totals`
--
ALTER TABLE `a_partner_student_request_totals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `a_partner_tb`
--
ALTER TABLE `a_partner_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `a_student_grade`
--
ALTER TABLE `a_student_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_student_logbook`
--
ALTER TABLE `a_student_logbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `a_student_tb`
--
ALTER TABLE `a_student_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `a_suppervisior_tb`
--
ALTER TABLE `a_suppervisior_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `a_users`
--
ALTER TABLE `a_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `a_internaship_periode`
--
ALTER TABLE `a_internaship_periode`
  ADD CONSTRAINT `a_internaship_periode_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `a_users` (`id`);

--
-- Constraints for table `a_partner_student_request`
--
ALTER TABLE `a_partner_student_request`
  ADD CONSTRAINT `a_partner_student_request_ibfk_1` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`),
  ADD CONSTRAINT `a_partner_student_request_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`);

--
-- Constraints for table `a_partner_student_request_totals`
--
ALTER TABLE `a_partner_student_request_totals`
  ADD CONSTRAINT `a_partner_student_request_totals_ibfk_1` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`),
  ADD CONSTRAINT `a_partner_student_request_totals_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`);

--
-- Constraints for table `a_student_grade`
--
ALTER TABLE `a_student_grade`
  ADD CONSTRAINT `a_student_grade_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`),
  ADD CONSTRAINT `a_student_grade_ibfk_2` FOREIGN KEY (`supervisior_id`) REFERENCES `a_suppervisior_tb` (`id`),
  ADD CONSTRAINT `a_student_grade_ibfk_3` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`);

--
-- Constraints for table `a_student_logbook`
--
ALTER TABLE `a_student_logbook`
  ADD CONSTRAINT `a_student_logbook_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`),
  ADD CONSTRAINT `a_student_logbook_ibfk_2` FOREIGN KEY (`suppervisor_id`) REFERENCES `a_suppervisior_tb` (`id`),
  ADD CONSTRAINT `a_student_logbook_ibfk_3` FOREIGN KEY (`internaship_id`) REFERENCES `a_internaship_periode` (`id`);

--
-- Constraints for table `a_student_tb`
--
ALTER TABLE `a_student_tb`
  ADD CONSTRAINT `a_student_tb_ibfk_1` FOREIGN KEY (`internaship_periode_id`) REFERENCES `a_internaship_periode` (`id`),
  ADD CONSTRAINT `a_student_tb_ibfk_3` FOREIGN KEY (`suppervisior_id`) REFERENCES `a_suppervisior_tb` (`id`),
  ADD CONSTRAINT `a_student_tb_ibfk_4` FOREIGN KEY (`partner_id`) REFERENCES `a_partner_tb` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
