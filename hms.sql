-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 05:06 AM
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
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$ubgyImbsCwJYrL4Y6Pg9t.lHUXzBv0fhmRf1D9/X9eQ1.J2mjjn.i');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `reciever` int(11) NOT NULL,
  `msg` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender`, `reciever`, `msg`, `time`) VALUES
(21, 12, 7, 'hello doctor', '2024-05-01 05:34:29'),
(22, 7, 12, 'hello austin', '2024-05-01 05:35:10'),
(23, 12, 7, 'hello doctor', '2024-05-09 02:32:10'),
(24, 7, 12, 'hello austin', '2024-05-09 02:32:51');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'ENT'),
(2, 'Surgery'),
(3, 'Ortho'),
(4, 'Neuro');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `department` int(11) NOT NULL,
  `joined_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `email`, `phone`, `department`, `joined_on`, `password`) VALUES
(2, 'Ritesh Singh ', 'ritesh@gmail.com', '1234567890', 1, '2024-04-01 18:30:00', '$2y$10$b1GlEVRexXjuwqLk4iD7RuE4kaxZN/QLiRzEJZmPWI68AEUO2f9da'),
(5, 'Ankita Singh', 'ankita@gmail.com', '1234567891', 2, '2024-04-01 18:30:00', '$2y$10$a6BCN6YOVwDxXYkRcPE7AusK/KMB37qJr.fyOVlg7yaB8ESIr7sxS'),
(7, 'Alex', 'alex@gmail.com', '9898989898', 4, '2024-04-13 07:00:00', '$2y$10$nAo2s9JpiM.WHzcDg7bWpOzXJ5Y87abqz4zwyVpfWAqB9DJ4UqlAO'),
(8, 'test', 'test@gmail.com', '4343434343', 1, '2024-05-12 07:00:00', '$2y$10$DGAvwrZyADvd.4.C9BJ3aO9g9fW1Oa7Z47u3XBJdUV0meNs1dQCH6');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `username`, `email`, `password`) VALUES
(11, 'Ritesh', 'test@test1.com', '$2y$10$mLsOC4j6.xox.tOh1SjMau01uczgBKx.j1ewwp2lVNHTXS2Q5YNra'),
(12, 'austin', 'austin@gmail.com', '$2y$10$MXoeN8eeo9vAbD8k/HEfj.tRL0NsOZt/1batB8JH7WKdLDDfi2HIq');

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE `patient_details` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
  `doctorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_details`
--

INSERT INTO `patient_details` (`id`, `firstname`, `lastname`, `email`, `phone`, `gender`, `dob`, `doctorId`) VALUES
(6, 'Test', '1', 'test@test1.com', '1262659898', 'M', '2024-04-01', 5),
(7, 'test 3', 'test 3', 'test3@ckmkj.com', '1236548750', 'M', '2023-10-31', 2),
(9, 'Austin', 'patel', 'austin@gmail.com', '8787887887', 'M', '2024-04-14', 7);

-- --------------------------------------------------------

--
-- Table structure for table `patient_records`
--

CREATE TABLE `patient_records` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `report_url` text NOT NULL,
  `uploaded_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_records`
--

INSERT INTO `patient_records` (`id`, `patient_id`, `filename`, `report_url`, `uploaded_on`) VALUES
(2, 8, '8_test@test1.com_660d8906cdfa3_Stock Selection.docx', 'http://localhost/hms/patient/uploads/8_test@test1.com_660d8906cdfa3_Stock Selection.docx', '2024-04-03 16:51:18'),
(3, 8, '8_test@test1.com_660d894c4aadd_Support.docx', 'http://localhost/hms/patient/uploads/8_test@test1.com_660d894c4aadd_Support.docx', '2024-04-03 16:52:28'),
(4, 11, '11_test@test1.com_660d8dc41125d_Report.docx', 'http://localhost/hms/patient/uploads/11_test@test1.com_660d8dc41125d_Report.docx', '2024-04-03 17:11:32'),
(5, 11, '11_test@test1.com_660d8dca457f7_Assignment 1 and 2.docx', 'http://localhost/hms/patient/uploads/11_test@test1.com_660d8dca457f7_Assignment 1 and 2.docx', '2024-04-03 17:11:38'),
(6, 12, '12_austin@gmail.com_66330439ad4f7_Healthcare Data Management System.pptx', 'http://localhost/hms/patient/uploads/12_austin@gmail.com_66330439ad4f7_Healthcare Data Management System.pptx', '2024-05-02 03:10:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `doctorId` (`doctorId`);

--
-- Indexes for table `patient_records`
--
ALTER TABLE `patient_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `patient_details`
--
ALTER TABLE `patient_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient_records`
--
ALTER TABLE `patient_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `department` FOREIGN KEY (`department`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `email` FOREIGN KEY (`email`) REFERENCES `patient_details` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD CONSTRAINT `doctorId` FOREIGN KEY (`doctorId`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
