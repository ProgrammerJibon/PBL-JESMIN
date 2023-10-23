-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 07:36 AM
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
-- Database: `pbl_jessy`
--
CREATE DATABASE IF NOT EXISTS `pbl_jessy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pbl_jessy`;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `dept_id` varchar(255) NOT NULL,
  `sub_id` varchar(255) NOT NULL,
  `csession` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats_messages`
--

CREATE TABLE IF NOT EXISTS `chats_messages` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `chat_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `img_url` varchar(2048) NOT NULL,
  `time` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `department_name_short` varchar(1024) NOT NULL,
  `department_name_full` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `current_department` varchar(255) NOT NULL DEFAULT '0',
  `admission_session` varchar(255) NOT NULL DEFAULT '0',
  `current_subject` varchar(255) NOT NULL DEFAULT '0',
  `notice_title` varchar(2048) NOT NULL,
  `notice_desc` longtext NOT NULL,
  `notice_image` varchar(2048) NOT NULL,
  `added_time` varchar(16) NOT NULL DEFAULT '0',
  `event_time` varchar(16) NOT NULL DEFAULT '0',
  `by_user_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results_name`
--

CREATE TABLE IF NOT EXISTS `results_name` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `result_name` varchar(1024) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `admission_session` varchar(255) NOT NULL,
  `current_session` varchar(255) NOT NULL,
  `schedule_time` varchar(16) NOT NULL DEFAULT '0',
  `release_time` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results_student`
--

CREATE TABLE IF NOT EXISTS `results_student` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `result_id` varchar(255) NOT NULL,
  `assignemnt_mark` varchar(4) NOT NULL DEFAULT '0',
  `class_test_mark` varchar(4) NOT NULL DEFAULT '0',
  `class_present_mark` varchar(4) NOT NULL DEFAULT '0',
  `presentaion_mark` varchar(4) NOT NULL DEFAULT '0',
  `exam_paper_mark` varchar(4) NOT NULL DEFAULT '0',
  `cgpa_point` varchar(8) NOT NULL DEFAULT '0.00',
  `subject_id` varchar(255) NOT NULL,
  `time` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `section_code` varchar(1024) NOT NULL,
  `section_mode` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions_name`
--

CREATE TABLE IF NOT EXISTS `sessions_name` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) NOT NULL,
  `year` varchar(4) NOT NULL,
  `season` varchar(8) NOT NULL DEFAULT '',
  `time` varchar(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

CREATE TABLE IF NOT EXISTS `site_info` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(1024) NOT NULL,
  `site_logo` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_info`
--

INSERT IGNORE INTO `site_info` (`id`, `site_title`, `site_logo`) VALUES
(1, 'Student Management', 'assets/ugvlogo.png');

-- --------------------------------------------------------

--
-- Table structure for table `subject_list`
--

CREATE TABLE IF NOT EXISTS `subject_list` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(2048) NOT NULL,
  `subject_code` varchar(1024) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `nid_number` varchar(32) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `email` varchar(2048) NOT NULL,
  `admission_session_id` varchar(255) NOT NULL,
  `current_session_id` varchar(255) NOT NULL,
  `current_section_id` varchar(255) NOT NULL,
  `current_department_id` varchar(255) NOT NULL,
  `current_subject_id` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `pic` varchar(2048) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'ACTIVE',
  `time` varchar(16) NOT NULL DEFAULT '0',
  `username` varchar(1024) NOT NULL,
  `password` varchar(2048) NOT NULL DEFAULT 'd93a5def7511da3d0f2d171d9c344e91',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT IGNORE INTO `users` (`id`, `type`, `fname`, `lname`, `nid_number`, `phone`, `email`, `admission_session_id`, `current_session_id`, `current_section_id`, `current_department_id`, `current_subject_id`, `student_id`, `pic`, `status`, `time`, `username`, `password`) VALUES
(1, 'ADMIN', 'Jesmin', '', '', '', '', '', '', '', '', '', '', '', 'ACTIVE', '0', 'admin', 'd93a5def7511da3d0f2d171d9c344e91');

-- --------------------------------------------------------

--
-- Table structure for table `users_cookies`
--

CREATE TABLE IF NOT EXISTS `users_cookies` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `cookies` varchar(2048) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `creation_time` varchar(16) NOT NULL DEFAULT '0',
  `expiring_time` varchar(16) NOT NULL DEFAULT '0',
  `ip` varchar(32) NOT NULL DEFAULT '0.0.0.0',
  `agent` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
