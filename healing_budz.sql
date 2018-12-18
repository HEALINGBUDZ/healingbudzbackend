-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2018 at 01:51 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healing_budz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@healingbudz.com', '$2y$10$ULZjlClo6AtjDPUzkiXWN.CYuDjuthWy1nbaTHQ1/70wejMMuuxRG', '08B87cSQEI1k4RUApfe0rgj15HGAo18SneLBMrbXemkd2YEv26x4H6ccoWSR', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_products`
--

CREATE TABLE `admin_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `user_id`, `question_id`, `answer`, `created_at`, `updated_at`) VALUES
(1, 2, 12, ' asdas dasd <br /> as <br /> dsa <br /> dsa <br /> dsad <br /> a <br /> <br /> asd <br /> as <br /> sada <br /> s <br /> <a target=\'_blank\' href=\'http://youtube.com\'>youtube.com</a> ', '2018-01-18 17:32:50', '2018-01-18 17:32:50');

-- --------------------------------------------------------

--
-- Table structure for table `answer_attachments`
--

CREATE TABLE `answer_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `upload_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `answer_likes`
--

CREATE TABLE `answer_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer_likes`
--

INSERT INTO `answer_likes` (`id`, `answer_id`, `user_id`, `created_at`, `updated_at`) VALUES
(10, 1, 1, '2018-02-02 07:11:54', '2018-02-02 07:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `budz_feeds`
--

CREATE TABLE `budz_feeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `search_by` bigint(20) UNSIGNED DEFAULT NULL,
  `review_id` bigint(20) UNSIGNED DEFAULT NULL,
  `my_save_id` bigint(20) UNSIGNED DEFAULT NULL,
  `share_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tag_id` bigint(20) UNSIGNED DEFAULT NULL,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `cta` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_events`
--

CREATE TABLE `business_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `from_time` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_time` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_languages`
--

CREATE TABLE `business_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_reviews`
--

CREATE TABLE `business_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_review_attachments`
--

CREATE TABLE `business_review_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_review_replies`
--

CREATE TABLE `business_review_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reply` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_review_reports`
--

CREATE TABLE `business_review_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_review_id` bigint(20) UNSIGNED NOT NULL,
  `reported_by` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_shares`
--

CREATE TABLE `business_shares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_timings`
--

CREATE TABLE `business_timings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `monday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tuesday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wednesday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thursday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `friday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saturday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sunday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mon_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tue_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wed_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thu_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fri_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sat_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sun_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_types`
--

CREATE TABLE `business_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_types`
--

INSERT INTO `business_types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Dispensary', NULL, NULL),
(2, 'Medical Practitioner', NULL, NULL),
(3, 'Cannabites', NULL, NULL),
(4, 'Lounge', NULL, NULL),
(5, 'Events', NULL, NULL),
(6, 'Holistic', NULL, NULL),
(7, 'Clinic', NULL, NULL),
(8, 'Cannabis Club/Bar', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `business_user_ratings`
--

CREATE TABLE `business_user_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `rated_by` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `rating` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `sender_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `receiver_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `chat_id`, `sender_id`, `receiver_id`, `message`, `file_type`, `file_path`, `is_read`, `sender_deleted`, `receiver_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, ' hello ', NULL, NULL, 1, 0, 0, '2018-01-18 15:55:35', '2018-03-02 02:06:47'),
(2, 1, 2, 1, ' asdasdas asd ', NULL, NULL, 1, 0, 0, '2018-01-18 15:55:48', '2018-03-02 02:06:47'),
(3, 1, 2, 1, ' asdasdsad ', NULL, NULL, 1, 0, 0, '2018-01-18 15:57:02', '2018-03-02 02:06:47'),
(4, 1, 2, 1, ' <a target=\'<br />blank\' href=http://google.com>google.com</a> ', NULL, NULL, 1, 0, 0, '2018-01-18 15:57:18', '2018-03-02 02:06:47'),
(5, 1, 2, 1, ' <a target=\'<br />blank\' href=http://www.google.com>www.google.com</a> ', NULL, NULL, 1, 0, 0, '2018-01-18 15:57:29', '2018-03-02 02:06:47'),
(6, 1, 2, 1, ' <a target=\'<br />blank\' href=http://google.ae>google.ae</a> ', NULL, NULL, 1, 0, 0, '2018-01-18 15:57:38', '2018-03-02 02:06:47'),
(7, 1, 1, 2, ' hello ', NULL, NULL, 0, 0, 0, '2018-01-31 00:07:33', '2018-01-31 00:07:33'),
(8, 1, 1, 2, ' hello ', NULL, NULL, 0, 0, 0, '2018-01-31 00:08:31', '2018-01-31 00:08:31'),
(9, 1, 1, 2, ' hello ', NULL, NULL, 0, 0, 0, '2018-01-31 00:10:13', '2018-01-31 00:10:13'),
(10, 1, 1, 2, ' how are you ', NULL, NULL, 0, 0, 0, '2018-01-31 00:10:21', '2018-01-31 00:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `chat_users`
--

CREATE TABLE `chat_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `last_message_id` bigint(20) NOT NULL DEFAULT '0',
  `sender_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `receiver_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_users`
--

INSERT INTO `chat_users` (`id`, `sender_id`, `receiver_id`, `last_message_id`, `sender_deleted`, `receiver_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 10, 0, 0, '2018-01-18 15:55:35', '2018-01-31 00:10:22');

-- --------------------------------------------------------

--
-- Table structure for table `data_settings`
--

CREATE TABLE `data_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_wifi` tinyint(1) NOT NULL DEFAULT '0',
  `show_notification` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `default_questions`
--

CREATE TABLE `default_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `default_questions`
--

INSERT INTO `default_questions` (`id`, `question`, `answer`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'Should I warm cannabis oil before applying?', 'I’m using cannabis oil. For muscle pain therapy and I’m unsure if I should warm it before rubbing it on the effected areas.', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `disease_preventions`
--

CREATE TABLE `disease_preventions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prevention` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disease_preventions`
--

INSERT INTO `disease_preventions` (`id`, `prevention`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 'Neuroprotectant', 1, NULL, NULL),
(2, 'Algheiner`s', 1, NULL, NULL),
(3, 'Heart Disease', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` double(8,2) DEFAULT NULL,
  `lng` double(8,2) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_likes`
--

CREATE TABLE `event_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_ratings`
--

CREATE TABLE `event_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_reviews`
--

CREATE TABLE `event_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `review` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_review_attachments`
--

CREATE TABLE `event_review_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_type` enum('image','video') COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_ticket_pricings`
--

CREATE TABLE `event_ticket_pricings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_timings`
--

CREATE TABLE `event_timings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `monday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tuesday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wednesday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thursday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `friday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saturday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sunday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_type_edits`
--

CREATE TABLE `event_type_edits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `event_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experties`
--

CREATE TABLE `experties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experties`
--

INSERT INTO `experties` (`id`, `title`, `exp_question_id`, `created_at`, `updated_at`) VALUES
(1, 'Canker Sores', 1, NULL, NULL),
(2, 'Muscle Spasms', 1, NULL, NULL),
(3, 'Insomnia', 1, NULL, NULL),
(4, 'Skin Rash', 1, NULL, NULL),
(5, 'OG Kush', 2, NULL, NULL),
(6, 'Capri Sunset', 2, NULL, NULL),
(7, 'Girl Scout Cookies', 2, NULL, NULL),
(8, 'Blueberry Dream', 2, NULL, NULL),
(9, 'Hazyhash', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expertise_questions`
--

CREATE TABLE `expertise_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expertise_questions`
--

INSERT INTO `expertise_questions` (`id`, `question`, `created_at`, `updated_at`) VALUES
(1, 'Which conditions or ailments have you treated with cannabis?', NULL, NULL),
(2, 'What marijuana strains do you have experience with?', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flaged_answers`
--

CREATE TABLE `flaged_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `flaged_user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flaged_answers`
--

INSERT INTO `flaged_answers` (`id`, `answer_id`, `user_id`, `flaged_user_id`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'Spam', '2018-01-30 07:02:25', '2018-01-30 07:02:25');

-- --------------------------------------------------------

--
-- Table structure for table `flavors`
--

CREATE TABLE `flavors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flavor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follow_uses`
--

CREATE TABLE `follow_uses` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_private` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `user_id`, `image`, `title`, `description`, `is_private`, `created_at`, `updated_at`) VALUES
(1, 2, '/groups/image_r5bzOCIr4pG7afi.jpg', 'asdsada', ' asdsad ', 0, '2018-01-18 17:39:53', '2018-01-18 17:39:53'),
(2, 2, '/groups/image_IB8EU8bYOD6x5PC.jpg', 'asdsada', ' asdsad ', 0, '2018-01-18 17:41:33', '2018-01-18 17:41:33'),
(3, 2, '/groups/image_iEHucaeiHxzLnUQ.jpg', 'asdsada', ' asdsad ', 0, '2018-01-18 17:46:30', '2018-01-18 17:46:30'),
(4, 1, '', 'wrerewrwerw', ' <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> ', 0, '2018-01-22 00:37:04', '2018-01-30 06:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `group_followers`
--

CREATE TABLE `group_followers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `unread_count` bigint(20) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_followers`
--

INSERT INTO `group_followers` (`id`, `user_id`, `group_id`, `unread_count`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, 1, '2018-01-18 17:39:53', '2018-01-18 17:39:53'),
(2, 2, 2, 0, 1, '2018-01-18 17:41:33', '2018-01-18 17:41:33'),
(3, 2, 3, 0, 1, '2018-01-18 17:46:30', '2018-01-18 18:40:27'),
(4, 1, 4, 0, 1, '2018-01-22 00:37:04', '2018-02-02 04:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `group_invitations`
--

CREATE TABLE `group_invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_messages`
--

CREATE TABLE `group_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_messages`
--

INSERT INTO `group_messages` (`id`, `user_id`, `group_id`, `text`, `type`, `file_path`, `poster`, `created_at`, `updated_at`) VALUES
(1, 2, 3, ' <a target=\'_blank\' href=\'http://google.com\'>google.com</a> ', 'text', NULL, NULL, '2018-01-18 17:46:41', '2018-01-18 17:46:41'),
(2, 2, 3, ' <a target=\'_blank\' href=\'http://google.com\'>google.com</a> ', 'text', NULL, NULL, '2018-01-18 17:50:33', '2018-01-18 17:50:33'),
(3, 2, 3, ' adsasdasd ', 'text', NULL, NULL, '2018-01-18 17:52:33', '2018-01-18 17:52:33'),
(4, 2, 3, ' <a target=\'_blank\' href=\'http://google.com\'>google.com</a> ', 'text', NULL, NULL, '2018-01-18 17:52:40', '2018-01-18 17:52:40'),
(5, 2, 3, ' <a target=\'_blank\' href=\'https://home.zoho.com/home\'>https://home.zoho.com/home</a> ', 'text', NULL, NULL, '2018-01-18 17:53:26', '2018-01-18 17:53:26'),
(6, 1, 4, ' Hello ', 'text', NULL, NULL, '2018-01-31 00:11:11', '2018-01-31 00:11:11'),
(7, 1, 4, ' how are you ', 'text', NULL, NULL, '2018-01-31 00:11:19', '2018-01-31 00:11:19'),
(8, 1, 4, ' asdad ', 'text', NULL, NULL, '2018-01-31 00:11:21', '2018-01-31 00:11:21'),
(9, 1, 4, ' asdas ', 'text', NULL, NULL, '2018-01-31 00:11:24', '2018-01-31 00:11:24'),
(10, 1, 4, ' adadsad ', 'text', NULL, NULL, '2018-01-31 00:11:25', '2018-01-31 00:11:25'),
(11, 1, 4, ' adsasd ', 'text', NULL, NULL, '2018-01-31 00:11:26', '2018-01-31 00:11:26'),
(12, 1, 4, ' asdasdsa ', 'text', NULL, NULL, '2018-01-31 00:11:27', '2018-01-31 00:11:27'),
(13, 1, 4, ' asda ', 'text', NULL, NULL, '2018-01-31 00:11:28', '2018-01-31 00:11:28'),
(14, 1, 4, ' asdads ', 'text', NULL, NULL, '2018-01-31 00:11:28', '2018-01-31 00:11:28'),
(15, 1, 4, ' asdasd ', 'text', NULL, NULL, '2018-01-31 00:11:29', '2018-01-31 00:11:29'),
(16, 1, 4, ' asdada ', 'text', NULL, NULL, '2018-01-31 00:11:30', '2018-01-31 00:11:30'),
(17, 1, 4, ' adada ', 'text', NULL, NULL, '2018-01-31 00:11:31', '2018-01-31 00:11:31'),
(18, 1, 4, ' dwa ', 'text', NULL, NULL, '2018-01-31 00:11:32', '2018-01-31 00:11:32'),
(19, 1, 4, ' a ', 'text', NULL, NULL, '2018-01-31 00:11:32', '2018-01-31 00:11:32'),
(20, 1, 4, ' d ', 'text', NULL, NULL, '2018-01-31 00:11:32', '2018-01-31 00:11:32'),
(21, 1, 4, ' dw ', 'text', NULL, NULL, '2018-01-31 00:11:32', '2018-01-31 00:11:32'),
(22, 1, 4, ' ad ', 'text', NULL, NULL, '2018-01-31 00:11:32', '2018-01-31 00:11:32'),
(23, 1, 4, ' wa ', 'text', NULL, NULL, '2018-01-31 00:11:32', '2018-01-31 00:11:32'),
(24, 1, 4, ' d ', 'text', NULL, NULL, '2018-01-31 00:11:32', '2018-01-31 00:11:32'),
(25, 1, 4, ' wa ', 'text', NULL, NULL, '2018-01-31 00:11:33', '2018-01-31 00:11:33'),
(26, 1, 4, ' da ', 'text', NULL, NULL, '2018-01-31 00:11:33', '2018-01-31 00:11:33'),
(27, 1, 4, ' wd ', 'text', NULL, NULL, '2018-01-31 00:11:33', '2018-01-31 00:11:33'),
(28, 1, 4, ' ad ', 'text', NULL, NULL, '2018-01-31 00:11:33', '2018-01-31 00:11:33'),
(29, 1, 4, ' w ', 'text', NULL, NULL, '2018-01-31 00:11:33', '2018-01-31 00:11:33'),
(30, 1, 4, ' a ', 'text', NULL, NULL, '2018-01-31 00:11:33', '2018-01-31 00:11:33'),
(31, 1, 4, ' test ', 'text', NULL, NULL, '2018-01-31 00:18:53', '2018-01-31 00:18:53'),
(32, 1, 4, ' Hello ', 'text', NULL, NULL, '2018-01-31 00:21:08', '2018-01-31 00:21:08'),
(33, 1, 4, ' how are you buddy ', 'text', NULL, NULL, '2018-01-31 00:21:15', '2018-01-31 00:21:15'),
(34, 1, 4, ' asdsa ', 'text', NULL, NULL, '2018-02-02 04:21:51', '2018-02-02 04:21:51'),
(35, 1, 4, ' asdasd ', 'text', NULL, NULL, '2018-02-02 04:21:57', '2018-02-02 04:21:57'),
(36, 1, 4, ' aadas as d ', 'text', NULL, NULL, '2018-02-02 04:22:01', '2018-02-02 04:22:01'),
(37, 1, 4, ' asd a ', 'text', NULL, NULL, '2018-02-02 04:22:02', '2018-02-02 04:22:02'),
(38, 1, 4, ' sd ', 'text', NULL, NULL, '2018-02-02 04:22:02', '2018-02-02 04:22:02'),
(39, 1, 4, ' sada ', 'text', NULL, NULL, '2018-02-02 04:22:02', '2018-02-02 04:22:02'),
(40, 1, 4, ' dsas ', 'text', NULL, NULL, '2018-02-02 04:22:03', '2018-02-02 04:22:03'),
(41, 1, 4, ' das ', 'text', NULL, NULL, '2018-02-02 04:22:03', '2018-02-02 04:22:03'),
(42, 1, 4, ' dsa ', 'text', NULL, NULL, '2018-02-02 04:22:03', '2018-02-02 04:22:03'),
(43, 1, 4, ' dsdfdsf ', 'text', NULL, NULL, '2018-02-02 04:22:10', '2018-02-02 04:22:10'),
(44, 1, 4, ' sdf ', 'text', NULL, NULL, '2018-02-02 04:22:11', '2018-02-02 04:22:11'),
(45, 1, 4, ' dsf ', 'text', NULL, NULL, '2018-02-02 04:22:11', '2018-02-02 04:22:11'),
(46, 1, 4, ' sdf ', 'text', NULL, NULL, '2018-02-02 04:22:11', '2018-02-02 04:22:11'),
(47, 1, 4, ' ds ', 'text', NULL, NULL, '2018-02-02 04:22:11', '2018-02-02 04:22:11'),
(48, 1, 4, ' fsd ', 'text', NULL, NULL, '2018-02-02 04:22:11', '2018-02-02 04:22:11'),
(49, 1, 4, ' fsd ', 'text', NULL, NULL, '2018-02-02 04:22:11', '2018-02-02 04:22:11'),
(50, 1, 4, ' fs ', 'text', NULL, NULL, '2018-02-02 04:22:12', '2018-02-02 04:22:12'),
(51, 1, 4, ' fds ', 'text', NULL, NULL, '2018-02-02 04:22:12', '2018-02-02 04:22:12'),
(52, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:12', '2018-02-02 04:22:12'),
(53, 1, 4, ' sf ', 'text', NULL, NULL, '2018-02-02 04:22:12', '2018-02-02 04:22:12'),
(54, 1, 4, ' s ', 'text', NULL, NULL, '2018-02-02 04:22:12', '2018-02-02 04:22:12'),
(55, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:13', '2018-02-02 04:22:13'),
(56, 1, 4, ' sfs ', 'text', NULL, NULL, '2018-02-02 04:22:13', '2018-02-02 04:22:13'),
(57, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:13', '2018-02-02 04:22:13'),
(58, 1, 4, ' dsfds ', 'text', NULL, NULL, '2018-02-02 04:22:13', '2018-02-02 04:22:13'),
(59, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:13', '2018-02-02 04:22:13'),
(60, 1, 4, ' sd ', 'text', NULL, NULL, '2018-02-02 04:22:13', '2018-02-02 04:22:13'),
(61, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:14', '2018-02-02 04:22:14'),
(62, 1, 4, ' dsf ', 'text', NULL, NULL, '2018-02-02 04:22:14', '2018-02-02 04:22:14'),
(63, 1, 4, ' dsf ', 'text', NULL, NULL, '2018-02-02 04:22:14', '2018-02-02 04:22:14'),
(64, 1, 4, ' ds ', 'text', NULL, NULL, '2018-02-02 04:22:14', '2018-02-02 04:22:14'),
(65, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:14', '2018-02-02 04:22:14'),
(66, 1, 4, ' dsf ', 'text', NULL, NULL, '2018-02-02 04:22:14', '2018-02-02 04:22:14'),
(67, 1, 4, ' dsf ', 'text', NULL, NULL, '2018-02-02 04:22:15', '2018-02-02 04:22:15'),
(68, 1, 4, ' dsf ', 'text', NULL, NULL, '2018-02-02 04:22:15', '2018-02-02 04:22:15'),
(69, 1, 4, ' dsf ', 'text', NULL, NULL, '2018-02-02 04:22:15', '2018-02-02 04:22:15'),
(70, 1, 4, ' ds ', 'text', NULL, NULL, '2018-02-02 04:22:15', '2018-02-02 04:22:15'),
(71, 1, 4, ' fsd ', 'text', NULL, NULL, '2018-02-02 04:22:15', '2018-02-02 04:22:15'),
(72, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:15', '2018-02-02 04:22:15'),
(73, 1, 4, ' ds ', 'text', NULL, NULL, '2018-02-02 04:22:16', '2018-02-02 04:22:16'),
(74, 1, 4, ' fds ', 'text', NULL, NULL, '2018-02-02 04:22:16', '2018-02-02 04:22:16'),
(75, 1, 4, ' fdss ', 'text', NULL, NULL, '2018-02-02 04:22:16', '2018-02-02 04:22:16'),
(76, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:16', '2018-02-02 04:22:16'),
(77, 1, 4, ' dsfsdfdsfsdfds ', 'text', NULL, NULL, '2018-02-02 04:22:17', '2018-02-02 04:22:17'),
(78, 1, 4, ' f ', 'text', NULL, NULL, '2018-02-02 04:22:18', '2018-02-02 04:22:18'),
(79, 1, 4, ' sdfdsf ', 'text', NULL, NULL, '2018-02-02 04:22:18', '2018-02-02 04:22:18'),
(80, 1, 4, ' sdfdsf ', 'text', NULL, NULL, '2018-02-02 04:22:19', '2018-02-02 04:22:19'),
(81, 1, 4, ' sdfds ', 'text', NULL, NULL, '2018-02-02 04:22:20', '2018-02-02 04:22:20'),
(82, 1, 4, ' asdasd ', 'text', NULL, NULL, '2018-02-02 04:23:28', '2018-02-02 04:23:28'),
(83, 1, 4, ' as ', 'text', NULL, NULL, '2018-02-02 04:23:28', '2018-02-02 04:23:28'),
(84, 1, 4, ' dsadsa ', 'text', NULL, NULL, '2018-02-02 04:23:28', '2018-02-02 04:23:28'),
(85, 1, 4, ' d ', 'text', NULL, NULL, '2018-02-02 04:23:28', '2018-02-02 04:23:28'),
(86, 1, 4, ' asdasd ', 'text', NULL, NULL, '2018-02-02 04:23:29', '2018-02-02 04:23:29'),
(87, 1, 4, ' as ', 'text', NULL, NULL, '2018-02-02 04:23:29', '2018-02-02 04:23:29'),
(88, 1, 4, ' d ', 'text', NULL, NULL, '2018-02-02 04:23:29', '2018-02-02 04:23:29'),
(89, 1, 4, ' ad ', 'text', NULL, NULL, '2018-02-02 04:23:29', '2018-02-02 04:23:29'),
(90, 1, 4, ' sa ', 'text', NULL, NULL, '2018-02-02 04:23:29', '2018-02-02 04:23:29'),
(91, 1, 4, ' d ', 'text', NULL, NULL, '2018-02-02 04:23:30', '2018-02-02 04:23:30'),
(92, 1, 4, ' sa ', 'text', NULL, NULL, '2018-02-02 04:23:30', '2018-02-02 04:23:30'),
(93, 1, 4, ' dsa ', 'text', NULL, NULL, '2018-02-02 04:23:30', '2018-02-02 04:23:30'),
(94, 1, 4, ' d ', 'text', NULL, NULL, '2018-02-02 04:23:30', '2018-02-02 04:23:30'),
(95, 1, 4, ' sad ', 'text', NULL, NULL, '2018-02-02 04:23:30', '2018-02-02 04:23:30'),
(96, 1, 4, ' a ', 'text', NULL, NULL, '2018-02-02 04:23:30', '2018-02-02 04:23:30'),
(97, 1, 4, ' dsa ', 'text', NULL, NULL, '2018-02-02 04:23:30', '2018-02-02 04:23:30'),
(98, 1, 4, ' sd ', 'text', NULL, NULL, '2018-02-02 04:23:31', '2018-02-02 04:23:31'),
(99, 1, 4, ' sa ', 'text', NULL, NULL, '2018-02-02 04:23:31', '2018-02-02 04:23:31'),
(100, 1, 4, ' d ', 'text', NULL, NULL, '2018-02-02 04:23:31', '2018-02-02 04:23:31'),
(101, 1, 4, ' a ', 'text', NULL, NULL, '2018-02-02 04:23:31', '2018-02-02 04:23:31'),
(102, 1, 4, ' d ', 'text', NULL, NULL, '2018-02-02 04:23:31', '2018-02-02 04:23:31'),
(103, 1, 4, ' a ', 'text', NULL, NULL, '2018-02-02 04:23:31', '2018-02-02 04:23:31'),
(104, 1, 4, ' d ', 'text', NULL, NULL, '2018-02-02 04:23:31', '2018-02-02 04:23:31'),
(105, 1, 4, ' sadaasdasd ', 'text', NULL, NULL, '2018-02-02 04:23:40', '2018-02-02 04:23:40'),
(106, 1, 4, ' adssadsada ', 'text', NULL, NULL, '2018-02-02 04:23:45', '2018-02-02 04:23:45');

-- --------------------------------------------------------

--
-- Table structure for table `group_message_likes`
--

CREATE TABLE `group_message_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_message_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icons`
--

CREATE TABLE `icons` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `icons`
--

INSERT INTO `icons` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '/icons/1.png', NULL, NULL),
(2, '/icons/2.png', NULL, NULL),
(3, '/icons/3.png', NULL, NULL),
(4, '/icons/4.png', NULL, NULL),
(5, '/icons/4.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_public` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_events`
--

CREATE TABLE `journal_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `feeling` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_event_attachments`
--

CREATE TABLE `journal_event_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_event_tags`
--

CREATE TABLE `journal_event_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `journal_event_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_followings`
--

CREATE TABLE `journal_followings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_like_dislikes`
--

CREATE TABLE `journal_like_dislikes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_like` tinyint(1) NOT NULL DEFAULT '0',
  `is_dislike` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_settings`
--

CREATE TABLE `journal_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `entry_mode` tinyint(1) NOT NULL DEFAULT '0',
  `wifi` tinyint(1) NOT NULL DEFAULT '0',
  `data_sync` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_639-1` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legals`
--

CREATE TABLE `legals` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_users`
--

CREATE TABLE `login_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `device_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `g_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_users`
--

INSERT INTO `login_users` (`id`, `user_id`, `device_type`, `device_id`, `lat`, `lng`, `session_key`, `time_zone`, `fb_id`, `g_id`, `created_at`, `updated_at`) VALUES
(2, 2, 'web', '::1', '0', '0', '', NULL, NULL, NULL, '2018-01-18 15:54:29', '2018-01-18 15:54:29'),
(12, 3, 'ios', '231231312', '74.2222', '35.222', '$2y$10$FURfLgnzQOYO1CQqWK8scuJR/Cm7x/ZOt53l5yktQ7hcR.fAVRo8O', '-5', '13123123123', '22222222222222222222222222', '2018-02-09 00:46:43', '2018-02-09 00:46:43'),
(13, 1, 'web', '::1', '0', '0', '', NULL, NULL, NULL, '2018-02-21 01:48:47', '2018-02-21 01:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `medical_conditions`
--

CREATE TABLE `medical_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `m_condition` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_conditions`
--

INSERT INTO `medical_conditions` (`id`, `m_condition`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 'Heart Disease', 1, NULL, NULL),
(2, 'Heart Condition', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `item`, `created_at`, `updated_at`) VALUES
(1, 'Activity Log', NULL, NULL),
(2, 'Message', NULL, NULL),
(3, 'My Journal', NULL, NULL),
(4, 'My Questions', NULL, NULL),
(5, 'My Answers', NULL, NULL),
(6, 'My Groups', NULL, NULL),
(7, 'My Strains', NULL, NULL),
(8, 'My Budz Map', NULL, NULL),
(9, 'My Rewards', NULL, NULL),
(10, 'My Saves', NULL, NULL),
(11, 'Shout Out', NULL, NULL),
(12, 'Wall', '2018-02-21 19:00:00', '2018-02-21 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_07_06_134623_create_login_users_table', 1),
(4, '2017_07_06_135540_create_specializations_table', 1),
(5, '2017_07_06_135707_create_user_specializations_table', 1),
(6, '2017_07_06_135914_create_searched_keywords_table', 1),
(7, '2017_07_06_140113_create_default_questions_table', 1),
(8, '2017_07_06_140246_create_tags_table', 1),
(9, '2017_07_06_140411_create_strain_types_table', 1),
(10, '2017_07_06_140855_create_strains_table', 1),
(11, '2017_07_06_141139_create_strain_images_table', 1),
(12, '2017_07_06_141451_create_strain_likes_table', 1),
(13, '2017_07_06_142500_create_strain_reviews_table', 1),
(14, '2017_07_06_142536_create_strain_ratings_table', 1),
(15, '2017_07_06_142803_create_strain_review_images_table', 1),
(16, '2017_07_07_121149_create_user_strains_table', 1),
(17, '2017_07_07_124612_create_menu_items_table', 1),
(18, '2017_07_07_134239_create_used_tags_table', 1),
(19, '2017_07_07_134552_create_journals_table', 1),
(20, '2017_07_07_134912_create_journal_followings_table', 1),
(21, '2017_07_07_135152_create_journal_events_table', 1),
(22, '2017_07_07_135525_create_journal_event_attachments_table', 1),
(23, '2017_07_07_135727_create_journal_like_dislikes_table', 1),
(24, '2017_07_10_054904_create_search_counts_table', 1),
(25, '2017_07_10_055351_create_questions_table', 1),
(26, '2017_07_10_055531_create_answers_table', 1),
(27, '2017_07_10_060214_create_answer_attachments_table', 1),
(28, '2017_07_10_061306_create_answer_likes_table', 1),
(29, '2017_07_10_061446_create_flaged_answers_table', 1),
(30, '2017_07_31_115531_create_offers_table', 1),
(31, '2017_07_31_120811_create_user_activities_table', 1),
(32, '2017_07_31_121225_create_support_messages_table', 1),
(33, '2017_07_31_121545_create_groups_table', 1),
(34, '2017_07_31_122015_create_group_followers_table', 1),
(35, '2017_07_31_122351_create_group_invitations_table', 1),
(36, '2017_07_31_122620_create_group_messages_table', 1),
(37, '2017_07_31_124335_create_group_message_likes_table', 1),
(38, '2017_07_31_125507_create_question_likes_table', 1),
(39, '2017_07_31_125715_create_question_shares_table', 1),
(40, '2017_07_31_125854_create_my_saves_table', 1),
(41, '2017_07_31_130307_create_notifications_table', 1),
(42, '2017_07_31_130655_create_user_follows_table', 1),
(43, '2017_07_31_131231_create_user_tags_table', 1),
(44, '2017_07_31_132238_create_notification_settings_table', 1),
(45, '2017_07_31_132816_create_reminder_settings_table', 1),
(46, '2017_07_31_133524_create_journal_settings_table', 1),
(47, '2017_08_03_044144_create_expertise_questions_table', 1),
(48, '2017_08_03_054910_create_data_settings_table', 1),
(49, '2017_08_03_055144_create_experties_table', 1),
(50, '2017_08_03_055413_create_user_experties_table', 1),
(51, '2017_08_03_055605_create_user_reviews_table', 1),
(52, '2017_08_03_064940_create_event_types_table', 1),
(53, '2017_08_03_065201_create_events_table', 1),
(54, '2017_08_03_065855_create_event_type_edits_table', 1),
(55, '2017_08_03_070114_create_event_timings_table', 1),
(56, '2017_08_03_070556_create_tickets_table', 1),
(57, '2017_08_03_071143_create_event_ticket_pricings_table', 1),
(58, '2017_08_03_071423_create_event_reviews_table', 1),
(59, '2017_08_03_071631_create_event_likes_table', 1),
(60, '2017_08_03_071730_create_event_ratings_table', 1),
(61, '2017_08_03_072905_create_event_review_attachments_table', 1),
(62, '2017_08_10_104735_create_medical_conditions_table', 1),
(63, '2017_08_10_105947_create_user_medical_conditions_table', 1),
(64, '2017_08_15_070902_create_user_group_settings_table', 1),
(65, '2017_08_15_131957_create_journal_event_tags_table', 1),
(66, '2017_08_16_063810_create_business_types_table', 1),
(67, '2017_08_16_064533_create_sub_users_table', 1),
(68, '2017_08_16_064536_create_products_table', 1),
(69, '2017_08_16_064538_create_product_images_table', 1),
(70, '2017_08_16_064549_create_product_pricings_table', 1),
(71, '2017_08_16_064611_create_shout_outs_table', 1),
(72, '2017_08_16_064740_create_shout_out_notifications_table', 1),
(73, '2017_08_16_065047_create_sub_user_images_table', 1),
(74, '2017_08_16_070248_create_business_timings_table', 1),
(75, '2017_08_16_070436_create_business_reviews_table', 1),
(76, '2017_08_16_071420_create_business_user_ratings_table', 1),
(77, '2017_08_16_071535_create_business_review_attachments_table', 1),
(78, '2017_08_16_071810_create_business_review_reports_table', 1),
(79, '2017_08_16_095535_VSearchTable', 1),
(80, '2017_08_17_093041_sub_users_update', 1),
(81, '2017_08_17_093055_subscription', 1),
(82, '2017_08_21_100605_create_privacy_policies_table', 1),
(83, '2017_08_21_100840_create_legals_table', 1),
(84, '2017_08_21_100853_create_follow_uses_table', 1),
(85, '2017_08_21_102857_create_term_condations_table', 1),
(86, '2017_08_21_105034_VUserGroup', 1),
(87, '2017_08_21_113017_create_user_strain_likes_table', 1),
(88, '2017_08_21_114523_create_get_sub_user_settings_table', 1),
(89, '2017_08_23_070230_create_negative_effects_table', 1),
(90, '2017_08_23_070418_create_sensations_table', 1),
(91, '2017_08_23_070605_create_disease_preventions_table', 1),
(92, '2017_08_23_070841_create_strain_survey_questions_table', 1),
(93, '2017_08_23_070939_create_strain_survey_answers_table', 1),
(94, '2017_08_24_062203_create_v_get_my_saves_table', 1),
(95, '2017_08_25_130400_create_flavors_table', 1),
(96, '2017_08_25_130405_create_v_top_survey_answers_table', 1),
(97, '2017_08_30_091844_create_chat_users_table', 1),
(98, '2017_08_30_093049_create_chat_messages_table', 1),
(99, '2017_08_31_054028_create_samples_table', 1),
(100, '2017_09_13_070350_create_admins_table', 1),
(101, '2017_10_03_065232_create_strain_review_flags_table', 1),
(102, '2017_10_12_120302_create_shout_out_likes_table', 1),
(103, '2017_10_16_060207_create_icons_table', 1),
(104, '2017_10_27_123504_create_h_b_galleries_table', 1),
(105, '2017_11_23_095548_create_services_table', 1),
(106, '2017_11_29_093505_create_languages_table', 1),
(107, '2017_11_29_093720_create_business_languages_table', 1),
(108, '2017_11_30_045126_create_business_events_table', 1),
(109, '2017_12_11_133113_create_tag_state_prices_table', 1),
(110, '2017_12_26_050321_create_user_points_table', 1),
(111, '2017_12_27_054851_create_strain_image_like_dislikes_table', 1),
(112, '2017_12_27_062400_create_strain_image_flags_table', 1),
(113, '2018_01_04_114842_create_v_products_table', 1),
(114, '2018_01_08_092746_create_my_save_settings_table', 1),
(115, '2018_01_19_055711_create_admin_products_table', 2),
(116, '2018_01_19_060038_create_orders_table', 2),
(117, '2018_02_13_052300_create_business_shares_table', 2),
(118, '2018_02_13_062203_create_shout_out_shares_table', 2),
(119, '2018_02_13_064009_create_shout_out_views_table', 2),
(120, '2018_02_13_092437_create_business_review_replies_table', 2),
(121, '2018_02_14_051104_create_budz_feeds_table', 2),
(122, '2018_02_13_132603_create_tag_searches_table', 3),
(123, '2018_02_15_073613_create_user_posts_table', 3),
(124, '2018_02_15_073723_create_user_post_tageds_table', 3),
(125, '2018_02_15_073740_create_user_post_attachments_table', 3),
(126, '2018_02_15_073752_create_user_post_likes_table', 3),
(127, '2018_02_15_073806_create_user_post_comments_table', 3),
(128, '2018_02_15_073827_create_user_post_comment_attachments_table', 3),
(129, '2018_02_15_073840_create_user_post_comment_shares_table', 3),
(130, '2018_02_15_073850_create_user_post_comment_flags_table', 3),
(131, '2018_02_15_103413_create_user_post_muteds_table', 4),
(132, '2018_02_15_073850_create_user_post_flags_table', 1),
(133, '2018_03_02_110549_create_user_post_scrapes_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `my_saves`
--

CREATE TABLE `my_saves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `type_sub_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `my_saves`
--

INSERT INTO `my_saves` (`id`, `user_id`, `model`, `description`, `type_id`, `type_sub_id`, `created_at`, `updated_at`) VALUES
(7, 1, 'Question', '', 4, 12, '2018-03-01 08:24:41', '2018-03-01 08:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `my_save_settings`
--

CREATE TABLE `my_save_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `save_question` tinyint(1) NOT NULL DEFAULT '0',
  `save_group` tinyint(1) NOT NULL DEFAULT '0',
  `save_strain` tinyint(1) NOT NULL DEFAULT '0',
  `save_budz` tinyint(1) NOT NULL DEFAULT '0',
  `save_journal` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `negative_effects`
--

CREATE TABLE `negative_effects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `effect` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `negative_effects`
--

INSERT INTO `negative_effects` (`id`, `effect`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 'Mucus', 1, NULL, NULL),
(2, 'Allergy', 1, NULL, NULL),
(3, 'Headache', 1, NULL, NULL),
(4, 'Less REM sleep', 1, NULL, NULL),
(5, 'Tar buildup  ', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_user` bigint(20) UNSIGNED NOT NULL,
  `to_user` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `new_question` tinyint(1) NOT NULL DEFAULT '0',
  `follow_question_answer` tinyint(1) NOT NULL DEFAULT '0',
  `public_joined` tinyint(1) NOT NULL DEFAULT '0',
  `private_joined` tinyint(1) NOT NULL DEFAULT '0',
  `follow_strains` tinyint(1) NOT NULL DEFAULT '0',
  `specials` tinyint(1) NOT NULL DEFAULT '0',
  `shout_out` tinyint(1) NOT NULL DEFAULT '0',
  `message` tinyint(1) NOT NULL DEFAULT '0',
  `follow_profile` tinyint(1) NOT NULL DEFAULT '0',
  `follow_journal` tinyint(1) NOT NULL DEFAULT '0',
  `your_strain` tinyint(1) NOT NULL DEFAULT '0',
  `like_question` tinyint(1) NOT NULL DEFAULT '0',
  `like_answer` tinyint(1) NOT NULL DEFAULT '0',
  `like_journal` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `expire_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policies`
--

CREATE TABLE `privacy_policies` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thc` double(8,2) NOT NULL,
  `cbd` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_pricings`
--

CREATE TABLE `product_pricings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `question`, `description`, `created_at`, `updated_at`) VALUES
(9, 1, ' again ask new activity happy question ', ' again ask new activity happy question ', '2018-01-24 02:30:24', '2018-01-24 02:30:24'),
(10, 1, ' hello new tag<b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> new activoity ', ' hello new tag<b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> new activoity ', '2018-01-24 02:31:47', '2018-01-24 02:31:47'),
(11, 1, ' ads asd ad new <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>sleep</font></b> activity ', ' ads asd ad new <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>sleep</font></b> activity ', '2018-01-24 02:32:58', '2018-01-24 02:32:58'),
(12, 1, ' adsdas <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <br /> test ', ' <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> adssa <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <br /> yes <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> ', '2018-01-30 06:46:26', '2018-01-30 06:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `question_likes`
--

CREATE TABLE `question_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `is_like` tinyint(1) NOT NULL DEFAULT '0',
  `is_flag` tinyint(1) NOT NULL DEFAULT '0',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_shares`
--

CREATE TABLE `question_shares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reminder_settings`
--

CREATE TABLE `reminder_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_on` tinyint(1) NOT NULL DEFAULT '0',
  `send` tinyint(1) NOT NULL DEFAULT '0',
  `notify_if_created` tinyint(1) NOT NULL DEFAULT '0',
  `time` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `samples`
--

CREATE TABLE `samples` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `searched_keywords`
--

CREATE TABLE `searched_keywords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key_word` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `on_sale` tinyint(1) NOT NULL DEFAULT '0',
  `is_tag` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `searched_keywords`
--

INSERT INTO `searched_keywords` (`id`, `key_word`, `price`, `on_sale`, `is_tag`, `created_at`, `updated_at`) VALUES
(1, 'cac', NULL, 0, 0, '2018-01-30 06:53:08', '2018-01-30 06:53:08'),
(2, 'test', NULL, 0, 0, '2018-01-30 06:55:53', '2018-01-30 06:55:53'),
(3, 'h', NULL, 0, 0, '2018-02-12 00:04:48', '2018-02-12 00:04:48'),
(4, 'f', NULL, 0, 0, '2018-02-12 00:24:06', '2018-02-12 00:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `search_counts`
--

CREATE TABLE `search_counts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keyword_id` bigint(20) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `search_counts`
--

INSERT INTO `search_counts` (`id`, `keyword_id`, `count`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-01-30', '2018-01-30 06:53:08', '2018-01-30 06:53:08'),
(2, 2, 3, '2018-01-30', '2018-01-30 06:55:53', '2018-01-30 07:00:00'),
(3, 3, 1, '2018-02-12', '2018-02-12 00:04:48', '2018-02-12 00:04:48'),
(4, 4, 12, '2018-02-12', '2018-02-12 00:24:06', '2018-02-12 00:42:34'),
(5, 2, 4, '2018-02-12', '2018-02-12 00:37:11', '2018-02-12 00:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `sensations`
--

CREATE TABLE `sensations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sensation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensations`
--

INSERT INTO `sensations` (`id`, `sensation`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 'Hunger', 1, NULL, NULL),
(2, 'Happiness', 1, NULL, NULL),
(3, 'Horny', 1, NULL, NULL),
(4, 'Paranoid', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charges` double(11,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shout_outs`
--

CREATE TABLE `shout_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validity_date` date NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` double(8,2) DEFAULT NULL,
  `lng` double(8,2) DEFAULT NULL,
  `zip_code` int(11) DEFAULT NULL,
  `public_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shout_out_likes`
--

CREATE TABLE `shout_out_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shout_out_id` bigint(20) UNSIGNED DEFAULT NULL,
  `liked_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shout_out_notifications`
--

CREATE TABLE `shout_out_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shout_out_id` bigint(20) UNSIGNED DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shout_out_shares`
--

CREATE TABLE `shout_out_shares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shout_out_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shout_out_views`
--

CREATE TABLE `shout_out_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shout_out_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `state_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country`, `state`, `state_code`) VALUES
(1, 'United States', 'Alaska', 'AK'),
(2, 'United States', 'Alabama', 'AL'),
(5, 'United States', 'Arizona', 'AZ'),
(6, 'United States', 'Arkansas', 'AR'),
(7, 'United States', 'California', 'CA'),
(8, 'United States', 'Colorado', 'CO'),
(9, 'United States', 'Connecticut', 'CT'),
(10, 'United States', 'Delaware', 'DE'),
(11, 'United States', 'Florida', 'FL'),
(12, 'United States', 'Georgia', 'GA'),
(13, 'United States', 'Hawaii', 'HI'),
(14, 'United States', 'Idaho', 'ID'),
(15, 'United States', 'Illinois', 'IL'),
(16, 'United States', 'Indiana', 'IN'),
(17, 'United States', 'Iowa', 'IA'),
(18, 'United States', 'Kansas', 'KS'),
(19, 'United States', 'Kentucky', 'KY'),
(20, 'United States', 'Louisiana', 'LA'),
(21, 'United States', 'Maine', 'ME'),
(22, 'United States', 'Maryland', 'MD'),
(23, 'United States', 'Massachusetts', 'MA'),
(24, 'United States', 'Michigan', 'MI'),
(25, 'United States', 'Minnesota', 'MN'),
(26, 'United States', 'Mississippi', 'MS'),
(27, 'United States', 'Missouri', 'MO'),
(28, 'United States', 'Montana', 'MT'),
(29, 'United States', 'Nebraska', 'NE'),
(30, 'United States', 'Nevada', 'NV'),
(31, 'United States', 'New Hampshire', 'NH'),
(32, 'United States', 'New Jersey', 'NJ'),
(33, 'United States', 'New Mexico', 'NM'),
(34, 'United States', 'New York', 'NY'),
(35, 'United States', 'North Carolina', 'NC'),
(36, 'United States', 'North Dakota', 'ND'),
(37, 'United States', 'Ohio', 'OH'),
(38, 'United States', 'Oklahoma', 'OK'),
(39, 'United States', 'Oregon', 'OR'),
(40, 'United States', 'Pennsylvania', 'PA'),
(41, 'United States', 'Puerto Rico', 'PR'),
(42, 'United States', 'Rhode Island', 'RI'),
(43, 'United States', 'South Carolina', 'SC'),
(44, 'United States', 'South Dakota', 'SD'),
(45, 'United States', 'Tennessee', 'TN'),
(46, 'United States', 'Texas', 'TX'),
(47, 'United States', 'Utah', 'UT'),
(48, 'United States', 'Vermont', 'VT'),
(49, 'United States', 'Virginia', 'VA'),
(50, 'United States', 'Washington', 'WA'),
(51, 'United States', 'Washington D.C.', 'DC'),
(52, 'United States', 'West Virginia', 'WV'),
(53, 'United States', 'Wisconsin', 'WI'),
(54, 'United States', 'Wyoming', 'WY');

-- --------------------------------------------------------

--
-- Table structure for table `strains`
--

CREATE TABLE `strains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strains`
--

INSERT INTO `strains` (`id`, `type_id`, `title`, `overview`, `approved`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cactus', 'test review', 1, NULL, NULL),
(2, 2, 'Girls Scout Ot', 'test overview 2', 1, NULL, NULL),
(3, 3, 'Girls Scout Ot2', 'test overview 3', 1, NULL, NULL),
(4, 1, 'Girls Scout Ot3', 'test overview 3', 1, NULL, NULL),
(5, 2, 'Girls Scout Ot4', 'test overview 4', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `strain_images`
--

CREATE TABLE `strain_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_image_flags`
--

CREATE TABLE `strain_image_flags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `is_flagged` tinyint(1) NOT NULL DEFAULT '0',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_image_like_dislikes`
--

CREATE TABLE `strain_image_like_dislikes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `is_liked` tinyint(1) NOT NULL DEFAULT '0',
  `is_disliked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_likes`
--

CREATE TABLE `strain_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_like` tinyint(1) DEFAULT NULL,
  `is_dislike` tinyint(1) DEFAULT NULL,
  `is_flaged` tinyint(1) DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_ratings`
--

CREATE TABLE `strain_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `strain_review_id` bigint(20) UNSIGNED NOT NULL,
  `rated_by` bigint(20) UNSIGNED NOT NULL,
  `rating` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strain_ratings`
--

INSERT INTO `strain_ratings` (`id`, `strain_id`, `strain_review_id`, `rated_by`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 3.00, NULL, NULL),
(2, 3, 1, 5, 4.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `strain_reviews`
--

CREATE TABLE `strain_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED NOT NULL,
  `review` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strain_reviews`
--

INSERT INTO `strain_reviews` (`id`, `strain_id`, `reviewed_by`, `review`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'adsdas', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `strain_review_flags`
--

CREATE TABLE `strain_review_flags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `strain_review_id` bigint(20) UNSIGNED NOT NULL,
  `flaged_by` bigint(20) UNSIGNED NOT NULL,
  `is_flaged` tinyint(1) NOT NULL DEFAULT '0',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_review_images`
--

CREATE TABLE `strain_review_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `strain_review_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_survey_answers`
--

CREATE TABLE `strain_survey_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_survey_questions`
--

CREATE TABLE `strain_survey_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strain_types`
--

CREATE TABLE `strain_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strain_types`
--

INSERT INTO `strain_types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Hybrid', NULL, NULL),
(2, 'Indica', NULL, NULL),
(3, 'Sativa', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_users`
--

CREATE TABLE `sub_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_type_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_organic` tinyint(1) NOT NULL DEFAULT '0',
  `is_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_accepted` enum('Yes','No') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_policies` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_requirements` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_user_images`
--

CREATE TABLE `sub_user_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `on_sale` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `title`, `is_approved`, `price`, `on_sale`, `created_at`, `updated_at`) VALUES
(1, 'asd', 1, 1, 1, NULL, NULL),
(2, 'cannibis oil', 1, 0, 0, NULL, NULL),
(3, 'sleep', 1, 0, 0, NULL, NULL),
(4, 'test1', 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag_searches`
--

CREATE TABLE `tag_searches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `zip_code` int(11) NOT NULL DEFAULT '0',
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag_state_prices`
--

CREATE TABLE `tag_state_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `term_condations`
--

CREATE TABLE `term_condations` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `used_tags`
--

CREATE TABLE `used_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `menu_item_id` bigint(20) UNSIGNED NOT NULL,
  `type_used_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `used_tags`
--

INSERT INTO `used_tags` (`id`, `tag_id`, `user_id`, `menu_item_id`, `type_used_id`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 6, '3', '2018-01-18 17:46:30', '2018-01-18 17:46:30'),
(9, 1, 1, 6, '4', '2018-01-30 06:55:25', '2018-01-30 06:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` int(11) DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` int(11) NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci,
  `location` text COLLATE utf8mb4_unicode_ci,
  `fb_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_web` tinyint(1) NOT NULL DEFAULT '0',
  `show_my_save` tinyint(1) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `zip_code`, `image_path`, `user_type`, `avatar`, `cover`, `bio`, `location`, `fb_id`, `google_id`, `is_web`, `show_my_save`, `points`, `remember_token`, `created_at`, `updated_at`, `city`, `state_id`) VALUES
(1, 'test', NULL, 'test@test.com', '$2y$10$.kThCWUzcIr5ZUnCsuxOouYyTD1Ha7jnAk8JG2JhOq/Yy7Fua9apC', 12345, NULL, 1, '/icons/5.png', NULL, NULL, NULL, NULL, NULL, 1, 0, 500, 'orSl5ynWQDEOvBuUeNLhHIucL9sqqjM9JkS40d6xW7j6I8CDCJ5F9xb2k9PE', '2018-01-18 15:19:09', '2018-03-02 02:11:42', 'lahore', '13'),
(2, 'hello', NULL, 'hello@hello.com', '$2y$10$zXiXInebNv8X3SzqyvdUdutpvr/93qjp291SGl756TLnTWkK7WM6i', 12345, NULL, 1, '/icons/2.png', NULL, NULL, NULL, NULL, NULL, 1, 0, 100, NULL, '2018-01-18 15:54:27', '2018-01-18 17:22:40', 'lahore', '1'),
(3, 'fb full name', NULL, 't@codingpixel.coms', '', 0, NULL, 2, NULL, NULL, NULL, '13123123123', '13123123123', NULL, 0, 0, 4321, NULL, '2018-02-09 00:46:42', '2018-02-09 00:46:42', NULL, NULL),
(4, 'Testing', NULL, 'et@codingpixel.coms', '', 0, NULL, 2, NULL, NULL, NULL, '13123123123', '13123123123', NULL, 0, 0, 21, NULL, '2018-02-09 00:46:42', '2018-02-09 00:46:42', NULL, NULL),
(5, 'baa', NULL, 'asdet@codingpixel.coms', '', 0, NULL, 2, NULL, NULL, NULL, '13123123123', '13123123123', NULL, 0, 0, 12, NULL, '2018-02-09 00:46:42', '2018-02-09 00:46:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `on_user` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('Questions','Answers','Favorites','Likes','Groups','Journal','Tags','Budz Map','Strains','Users','Chat','ShoutOut','Post') COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint(20) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `notification_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_sub_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`id`, `user_id`, `on_user`, `type`, `type_id`, `description`, `text`, `model`, `is_read`, `notification_text`, `created_at`, `updated_at`, `type_sub_id`) VALUES
(1, 2, 1, 'Chat', 3, ' asdasdsad ', 'You send a message.', 'ChatMessage', 1, 'hello send you a private message.', '2018-01-18 15:57:02', '2018-03-05 00:32:14', ''),
(2, 2, 1, 'Chat', 4, ' <a target=\'<br />blank\' href=http://google.com>google.com</a> ', 'You send a message.', 'ChatMessage', 1, 'hello send you a private message.', '2018-01-18 15:57:18', '2018-03-05 00:32:14', ''),
(3, 2, 1, 'Chat', 5, ' <a target=\'<br />blank\' href=http://www.google.com>www.google.com</a> ', 'You send a message.', 'ChatMessage', 1, 'hello send you a private message.', '2018-01-18 15:57:29', '2018-03-05 00:32:14', ''),
(4, 2, 1, 'Chat', 6, ' <a target=\'<br />blank\' href=http://google.ae>google.ae</a> ', 'You send a message.', 'ChatMessage', 1, 'hello send you a private message.', '2018-01-18 15:57:39', '2018-03-05 00:32:14', ''),
(10, 2, 2, 'Questions', 6, ' sdfsdf <br /> \r\nsdfdsf <br /> \r\nds <br /> \r\nfds <br /> \r\nfds <br /> \r\nf <br /> \r\nds <br /> \r\nfds <br /> \r\n <br /> \r\nfs <br /> \r\ngoogle.com', 'You Asked A Question', 'Question', 0, '', '2018-01-18 17:22:40', '2018-01-18 17:22:40', ''),
(11, 2, 2, 'Answers', 6, ' sdfsdf sdfd <br /> sf ds fds fd <br /> adsa <br /> asd <br /> asd <br /> sa <br /> dsa <br /> dsa <br /> da <br /> sd <br /> <br /> s f ds fd <br /> s fs <a target=\'_blank\' href=\'http://google.com\'>google.com</a> ', 'You answered a question', 'Question', 0, 'Your question was answered by hello', '2018-01-18 17:32:50', '2018-01-18 17:32:50', '1'),
(12, 2, 2, 'Groups', 3, 'asdsada', 'You created a group', 'Group', 0, 'hello Created a group', '2018-01-18 17:46:30', '2018-01-18 17:46:30', ''),
(13, 2, 2, 'Questions', 7, ' sdfd4 <br /><b ><font class=\'keyword<br />class\' color=#6d96ad>\r\nsleep</font></b> <br /> \r\nasdsadasdadas <br /> \r\nasd <br /> \r\nad <br /> \r\nsa <br /> \r\n <br /><b ><font class=\'keyword<br />class\' color=#6d96ad>\r\nsleep</font></b> <br /> \r\ngoogle.com', 'You Asked A Question', 'Question', 0, '', '2018-01-18 18:00:08', '2018-01-18 18:00:08', ''),
(14, 2, 2, 'Questions', 8, '<b ><font class=\'keyword_class\' color=#6d96ad>sleep</font></b> <br /> \r\nsad <br /> \r\nsa <br /> \r\nsa <br /> \r\ndsa', 'You Asked A Question', 'Question', 0, '', '2018-01-18 18:04:38', '2018-01-18 18:04:38', ''),
(15, 1, 1, 'Groups', 4, 'sdfs sdf sd fd sd', 'You created a group', 'Group', 1, 'test Created a group', '2018-01-22 00:37:04', '2018-03-05 00:32:14', ''),
(16, 1, 1, 'Questions', 9, ' again ask new activity happy question', 'You Asked A Question', 'Question', 1, '', '2018-01-24 02:30:25', '2018-03-05 00:32:14', ''),
(17, 1, 1, 'Questions', 10, ' hello new tag<b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> new activoity', 'You Asked A Question', 'Question', 1, '', '2018-01-24 02:31:47', '2018-03-05 00:32:14', ''),
(18, 1, 1, 'Questions', 11, ' ads asd ad new <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>sleep</font></b> activity', 'You Asked A Question', 'Question', 1, '', '2018-01-24 02:32:59', '2018-03-05 00:32:14', ''),
(19, 1, 1, 'Questions', 12, ' awda <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b>  <br /> <b ><font class=\'keyword_class\' color=#6d96ad>\r\ntest1</font></b> da da dads <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> adsada <b ><font class=\'keyword_class\' ', 'You Asked A Question', 'Question', 1, '', '2018-01-30 06:46:26', '2018-03-05 00:32:14', ''),
(20, 1, 2, 'Chat', 9, ' hello ', 'You send a message.', 'ChatMessage', 0, 'test send you a private message.', '2018-01-31 00:10:13', '2018-01-31 00:10:13', ''),
(21, 1, 2, 'Chat', 10, ' how are you ', 'You send a message.', 'ChatMessage', 0, 'test send you a private message.', '2018-01-31 00:10:22', '2018-01-31 00:10:22', ''),
(28, 1, 1, 'Favorites', 12, ' adsdas <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <b ><font class=\'keyword_class\' color=#6d96ad>test1</font></b> <br /> test ', 'You added a question to your favorites', 'Question', 1, 'test added your question to his favorites.', '2018-03-01 08:24:41', '2018-03-05 00:32:14', ''),
(29, 1, 1, 'Likes', 98, NULL, 'You Liked post', 'Post', 1, 'test like the post.', '2018-03-02 00:46:10', '2018-03-05 00:32:14', '1'),
(30, 1, 1, 'Likes', 113, 'asdada', 'You Liked post', 'Post', 0, 'test like the post.', '2018-03-05 04:47:26', '2018-03-05 04:47:26', '2'),
(31, 1, 1, 'Likes', 113, 'asdada', 'You Liked post', 'Post', 0, 'test like the post.', '2018-03-05 04:47:26', '2018-03-05 04:47:26', '2'),
(32, 1, 1, 'Likes', 113, 'asdada', 'You Liked post', 'Post', 0, 'test like the post.', '2018-03-05 04:47:44', '2018-03-05 04:47:44', '2'),
(33, 1, 1, '', 113, 'asdada', 'You Commented On Post', 'Post', 0, 'test comment on post.', '2018-03-05 05:22:02', '2018-03-05 05:22:02', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_experties`
--

CREATE TABLE `user_experties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `exp_id` bigint(20) UNSIGNED NOT NULL,
  `exp_question_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_follows`
--

CREATE TABLE `user_follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `followed_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_group_settings`
--

CREATE TABLE `user_group_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `is_mute` tinyint(1) NOT NULL DEFAULT '0',
  `mute_time` tinyint(1) DEFAULT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `mute_forever` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_medical_conditions`
--

CREATE TABLE `user_medical_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medical_c_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_points`
--

CREATE TABLE `user_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `points` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_points`
--

INSERT INTO `user_points` (`id`, `type`, `user_id`, `points`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 'First Question', 2, '50', NULL, '2018-01-18 17:11:15', '2018-01-18 17:11:15'),
(2, 'First Question', 2, '50', NULL, '2018-01-18 17:22:40', '2018-01-18 17:22:40'),
(3, 'First Question', 1, '50', NULL, '2018-01-24 02:30:24', '2018-01-24 02:30:24'),
(4, 'Share Question', 1, '50', '11', '2018-01-29 00:30:25', '2018-01-29 00:30:25'),
(5, 'Share Question', 1, '50', '10', '2018-01-29 00:35:28', '2018-01-29 00:35:28'),
(6, 'Follow Bud', 1, '50', '1', '2018-01-30 07:11:50', '2018-01-30 07:11:50'),
(7, 'Follow Bud', 1, '50', '1', '2018-01-30 07:12:21', '2018-01-30 07:12:21'),
(8, 'Share Question', 1, '50', '12', '2018-01-30 08:20:06', '2018-01-30 08:20:06'),
(9, 'Follow Bud', 1, '50', '3', '2018-03-02 01:13:21', '2018-03-02 01:13:21'),
(10, 'Follow Bud', 1, '50', '1', '2018-03-02 01:13:22', '2018-03-02 01:13:22'),
(11, 'Follow Bud', 1, '50', '4', '2018-03-02 01:13:23', '2018-03-02 01:13:23'),
(12, 'Follow Bud', 1, '50', '5', '2018-03-02 01:13:34', '2018-03-02 01:13:34'),
(13, 'Follow Bud', 1, '50', '3', '2018-03-02 02:11:26', '2018-03-02 02:11:26'),
(14, 'Follow Bud', 1, '50', '1', '2018-03-02 02:11:27', '2018-03-02 02:11:27'),
(15, 'Follow Bud', 1, '50', '2', '2018-03-02 02:11:28', '2018-03-02 02:11:28'),
(16, 'Follow Bud', 1, '50', '4', '2018-03-02 02:11:41', '2018-03-02 02:11:41'),
(17, 'Follow Bud', 1, '50', '5', '2018-03-02 02:11:42', '2018-03-02 02:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_posts`
--

CREATE TABLE `user_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sub_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `json_data` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_repost` tinyint(1) DEFAULT '1',
  `shared_id` bigint(20) DEFAULT NULL,
  `shared_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_posts`
--

INSERT INTO `user_posts` (`id`, `user_id`, `sub_user_id`, `description`, `json_data`, `allow_repost`, `shared_id`, `shared_user_id`, `created_at`, `updated_at`) VALUES
(58, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:20:10', '2018-03-01 05:20:10'),
(59, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:20:22', '2018-03-01 05:20:22'),
(60, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:20:36', '2018-03-01 05:20:36'),
(61, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:22:28', '2018-03-01 05:22:28'),
(62, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:23:43', '2018-03-01 05:23:43'),
(63, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:25:46', '2018-03-01 05:25:46'),
(64, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:25:57', '2018-03-01 05:25:57'),
(65, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:26:26', '2018-03-01 05:26:26'),
(66, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:26:38', '2018-03-01 05:26:38'),
(67, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:27:31', '2018-03-01 05:27:31'),
(68, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:27:42', '2018-03-01 05:27:42'),
(69, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:29:02', '2018-03-01 05:29:02'),
(70, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:29:11', '2018-03-01 05:29:11'),
(71, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:29:41', '2018-03-01 05:29:41'),
(72, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:31:26', '2018-03-01 05:31:26'),
(73, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:43:51', '2018-03-01 05:43:51'),
(74, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:44:13', '2018-03-01 05:44:13'),
(75, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:45:28', '2018-03-01 05:45:28'),
(76, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:46:28', '2018-03-01 05:46:28'),
(77, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:47:09', '2018-03-01 05:47:09'),
(78, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:48:54', '2018-03-01 05:48:54'),
(79, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:49:17', '2018-03-01 05:49:17'),
(80, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:50:25', '2018-03-01 05:50:25'),
(81, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:50:56', '2018-03-01 05:50:56'),
(82, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:53:36', '2018-03-01 05:53:36'),
(83, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:55:09', '2018-03-01 05:55:09'),
(84, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:56:11', '2018-03-01 05:56:11'),
(85, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:56:28', '2018-03-01 05:56:28'),
(86, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:57:45', '2018-03-01 05:57:45'),
(87, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:57:59', '2018-03-01 05:57:59'),
(88, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:58:50', '2018-03-01 05:58:50'),
(89, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:59:08', '2018-03-01 05:59:08'),
(90, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:59:11', '2018-03-01 05:59:11'),
(91, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 05:59:18', '2018-03-01 05:59:18'),
(92, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 06:01:39', '2018-03-01 06:01:39'),
(93, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 06:01:51', '2018-03-01 06:01:51'),
(94, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 06:11:18', '2018-03-01 06:11:18'),
(95, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-01 06:11:35', '2018-03-01 06:11:35'),
(96, 1, NULL, 'hello how are you buddy', '[{\"id\":\"2\",\"type\":\"user\",\"value\":\"hello\",\"trigger\":\"@\"}]', 1, NULL, NULL, '2018-03-01 08:25:27', '2018-03-01 08:25:27'),
(98, 1, NULL, NULL, NULL, 1, NULL, NULL, '2018-03-02 00:42:59', '2018-03-02 00:42:59'),
(99, 1, NULL, 'asd asd hello fb full name', '[{\"id\":\"1\",\"type\":\"tag\",\"value\":\"asd\",\"trigger\":\"#\"},{\"id\":\"2\",\"type\":\"user\",\"value\":\"hello\",\"trigger\":\"@\"},{\"id\":\"3\",\"type\":\"user\",\"value\":\"fb full name\",\"trigger\":\"@\"}]', 1, NULL, NULL, '2018-03-02 02:41:17', '2018-03-02 02:41:17'),
(100, 1, NULL, 'asd asd hello fb full name Testing', '[{\"id\":\"1\",\"type\":\"tag\",\"value\":\"asd\",\"trigger\":\"#\"},{\"id\":\"2\",\"type\":\"user\",\"value\":\"hello\",\"trigger\":\"@\"},{\"id\":\"3\",\"type\":\"user\",\"value\":\"fb full name\",\"trigger\":\"@\"},{\"id\":\"4\",\"type\":\"user\",\"value\":\"Testing\",\"trigger\":\"@\"}]', 1, NULL, NULL, '2018-03-02 02:42:03', '2018-03-02 02:42:03'),
(101, 1, NULL, 'asd', '[{\"id\":\"1\",\"type\":\"tag\",\"value\":\"asd\",\"trigger\":\"#\"}]', 1, NULL, NULL, '2018-03-02 02:42:36', '2018-03-02 02:42:36'),
(102, 1, NULL, 'Testing', NULL, 1, NULL, NULL, '2018-03-02 04:24:24', '2018-03-02 04:24:24'),
(103, 1, NULL, 'Testing', NULL, 1, NULL, NULL, '2018-03-02 04:25:15', '2018-03-02 04:25:15'),
(104, 1, NULL, 'dad', NULL, 1, NULL, NULL, '2018-03-02 04:26:22', '2018-03-02 04:26:22'),
(105, 1, NULL, 'This Was Shaared', NULL, 1, NULL, NULL, '2018-03-02 04:29:44', '2018-03-02 04:29:44'),
(106, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:06:31', '2018-03-05 03:06:31'),
(107, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:06:51', '2018-03-05 03:06:51'),
(108, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:07:58', '2018-03-05 03:07:58'),
(109, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:08:09', '2018-03-05 03:08:09'),
(110, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:08:22', '2018-03-05 03:08:22'),
(111, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:08:52', '2018-03-05 03:08:52'),
(112, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:09:11', '2018-03-05 03:09:11'),
(113, 1, NULL, 'asdada', NULL, 1, 105, 1, '2018-03-05 03:09:36', '2018-03-05 03:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_post_attachments`
--

CREATE TABLE `user_post_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_post_attachments`
--

INSERT INTO `user_post_attachments` (`id`, `post_id`, `file`, `poster`, `type`, `created_at`, `updated_at`) VALUES
(105, 58, '/posts/image_ITFfvnZBLU.jpg', NULL, 'image', '2018-03-01 05:20:10', '2018-03-01 05:20:10'),
(106, 58, '/posts/image_S0sCZXfv3q.png', NULL, 'image', '2018-03-01 05:20:10', '2018-03-01 05:20:10'),
(107, 59, '/posts/image_ITFfvnZBLU.jpg', NULL, 'image', '2018-03-01 05:20:22', '2018-03-01 05:20:22'),
(108, 59, '/posts/image_S0sCZXfv3q.png', NULL, 'image', '2018-03-01 05:20:22', '2018-03-01 05:20:22'),
(109, 60, '/posts/image_ITFfvnZBLU.jpg', NULL, 'image', '2018-03-01 05:20:36', '2018-03-01 05:20:36'),
(110, 60, '/posts/image_S0sCZXfv3q.png', NULL, 'image', '2018-03-01 05:20:36', '2018-03-01 05:20:36'),
(111, 60, '/posts/image_QFXYtPqZ5f.jpg', NULL, 'image', '2018-03-01 05:20:36', '2018-03-01 05:20:36'),
(112, 61, '/posts/image_lHl7vRHAqJ.jpg', NULL, 'image', '2018-03-01 05:22:28', '2018-03-01 05:22:28'),
(113, 62, '/posts/image_5jo3l0gQvh.jpg', NULL, 'image', '2018-03-01 05:23:43', '2018-03-01 05:23:43'),
(114, 63, '/posts/image_4BtJKy7HUz.jpg', NULL, 'image', '2018-03-01 05:25:46', '2018-03-01 05:25:46'),
(115, 64, '/posts/image_4BtJKy7HUz.jpg', NULL, 'image', '2018-03-01 05:25:57', '2018-03-01 05:25:57'),
(116, 64, '/posts/image_qA7lZN3t1v.jpg', NULL, 'image', '2018-03-01 05:25:57', '2018-03-01 05:25:57'),
(117, 64, '/posts/image_UIrJRIxBLU.png', NULL, 'image', '2018-03-01 05:25:57', '2018-03-01 05:25:57'),
(118, 64, '/posts/image_HR1eRpt1D4.jpg', NULL, 'image', '2018-03-01 05:25:57', '2018-03-01 05:25:57'),
(119, 64, '/posts/image_bDzxMnaXwG.jpg', NULL, 'image', '2018-03-01 05:25:58', '2018-03-01 05:25:58'),
(120, 65, '/posts/image_qo9Da1muc6.png', NULL, 'image', '2018-03-01 05:26:26', '2018-03-01 05:26:26'),
(121, 66, '/posts/image_qo9Da1muc6.png', NULL, 'image', '2018-03-01 05:26:38', '2018-03-01 05:26:38'),
(122, 66, '/posts/image_cdKci32Ixx.jpg', NULL, 'image', '2018-03-01 05:26:38', '2018-03-01 05:26:38'),
(123, 66, '/posts/image_KvJ92vxef3.png', NULL, 'image', '2018-03-01 05:26:38', '2018-03-01 05:26:38'),
(124, 66, '/posts/image_844zglRQov.jpg', NULL, 'image', '2018-03-01 05:26:38', '2018-03-01 05:26:38'),
(125, 66, '/posts/image_YLye4sfq1W.jpg', NULL, 'image', '2018-03-01 05:26:38', '2018-03-01 05:26:38'),
(126, 67, '/posts/image_zvhSYC7CiZ.jpg', NULL, 'image', '2018-03-01 05:27:31', '2018-03-01 05:27:31'),
(127, 68, '/posts/image_pEmx4I8yaQ.jpg', NULL, 'image', '2018-03-01 05:27:42', '2018-03-01 05:27:42'),
(128, 68, '/posts/image_XmdGPb6plb.png', NULL, 'image', '2018-03-01 05:27:42', '2018-03-01 05:27:42'),
(129, 68, '/posts/image_6cjXrpQioJ.jpg', NULL, 'image', '2018-03-01 05:27:42', '2018-03-01 05:27:42'),
(130, 68, '/posts/image_kMBiUrLbWL.jpg', NULL, 'image', '2018-03-01 05:27:42', '2018-03-01 05:27:42'),
(131, 69, '/posts/image_y6tj8KvNzr.jpg', NULL, 'image', '2018-03-01 05:29:02', '2018-03-01 05:29:02'),
(132, 70, '/posts/image_aBvhT9qnDG.jpg', NULL, 'image', '2018-03-01 05:29:11', '2018-03-01 05:29:11'),
(133, 70, '/posts/image_gu1qQjTFhX.png', NULL, 'image', '2018-03-01 05:29:11', '2018-03-01 05:29:11'),
(134, 70, '/posts/image_JkmLnNMQ8E.jpg', NULL, 'image', '2018-03-01 05:29:11', '2018-03-01 05:29:11'),
(135, 70, '/posts/image_LxdPH859Hm.jpg', NULL, 'image', '2018-03-01 05:29:11', '2018-03-01 05:29:11'),
(136, 71, '/posts/image_YeB9IS3Hgv.jpg', NULL, 'image', '2018-03-01 05:29:41', '2018-03-01 05:29:41'),
(137, 71, '/posts/image_yontDlIav6.png', NULL, 'image', '2018-03-01 05:29:41', '2018-03-01 05:29:41'),
(138, 71, '/posts/image_vMETPM1sO3.jpg', NULL, 'image', '2018-03-01 05:29:41', '2018-03-01 05:29:41'),
(139, 71, '/posts/image_OjOFA2JxdA.jpg', NULL, 'image', '2018-03-01 05:29:41', '2018-03-01 05:29:41'),
(140, 71, '/posts/image_3eMGbvgBR7.jpg', NULL, 'image', '2018-03-01 05:29:41', '2018-03-01 05:29:41'),
(141, 72, '/posts/image_W5bWsddRJq.jpg', NULL, 'image', '2018-03-01 05:31:26', '2018-03-01 05:31:26'),
(142, 72, '/posts/image_A1yCjX8875.png', NULL, 'image', '2018-03-01 05:31:26', '2018-03-01 05:31:26'),
(143, 72, '/posts/image_Mlcv6UjCar.jpg', NULL, 'image', '2018-03-01 05:31:26', '2018-03-01 05:31:26'),
(144, 72, '/posts/image_zNrVpgpRAL.jpg', NULL, 'image', '2018-03-01 05:31:26', '2018-03-01 05:31:26'),
(145, 72, '/posts/image_aN0H03Jm9k.jpg', NULL, 'image', '2018-03-01 05:31:26', '2018-03-01 05:31:26'),
(146, 73, '/posts/image_GGIQVoq42c.jpg', NULL, 'image', '2018-03-01 05:43:51', '2018-03-01 05:43:51'),
(147, 74, '/posts/image_QIaWljxbCr.png', NULL, 'image', '2018-03-01 05:44:13', '2018-03-01 05:44:13'),
(148, 75, '/posts/image_LdWWKwTTEP.jpg', NULL, 'image', '2018-03-01 05:45:28', '2018-03-01 05:45:28'),
(149, 76, '/posts/image_GLktC9JTKV.jpg', NULL, 'image', '2018-03-01 05:46:28', '2018-03-01 05:46:28'),
(150, 77, '/posts/image_TUCVZbf9xz.jpg', NULL, 'image', '2018-03-01 05:47:09', '2018-03-01 05:47:09'),
(151, 78, '/posts/image_oahDhwgvt5.jpg', NULL, 'image', '2018-03-01 05:48:54', '2018-03-01 05:48:54'),
(152, 79, '/posts/image_YVNa0oE6ZB.jpg', NULL, 'image', '2018-03-01 05:49:18', '2018-03-01 05:49:18'),
(153, 80, '/posts/image_bediL2YOdl.jpg', NULL, 'image', '2018-03-01 05:50:25', '2018-03-01 05:50:25'),
(154, 80, '/posts/image_DF7RzTleMr.png', NULL, 'image', '2018-03-01 05:50:26', '2018-03-01 05:50:26'),
(155, 80, '/posts/image_nEA7H8VFXw.jpg', NULL, 'image', '2018-03-01 05:50:26', '2018-03-01 05:50:26'),
(156, 80, '/posts/image_GrnGCCdSGE.jpg', NULL, 'image', '2018-03-01 05:50:26', '2018-03-01 05:50:26'),
(157, 80, '/posts/image_vpcfkyNcSR.jpg', NULL, 'image', '2018-03-01 05:50:26', '2018-03-01 05:50:26'),
(158, 81, '/posts/image_BrC2wTILZJ.jpg', NULL, 'image', '2018-03-01 05:50:56', '2018-03-01 05:50:56'),
(159, 81, '/posts/image_f7s6vxg28C.png', NULL, 'image', '2018-03-01 05:50:56', '2018-03-01 05:50:56'),
(160, 81, '/posts/image_qiRJxh2b9r.jpg', NULL, 'image', '2018-03-01 05:50:56', '2018-03-01 05:50:56'),
(161, 81, '/posts/image_6PVylrNHg4.jpg', NULL, 'image', '2018-03-01 05:50:56', '2018-03-01 05:50:56'),
(162, 81, '/posts/image_xMYWP4d95A.jpg', NULL, 'image', '2018-03-01 05:50:57', '2018-03-01 05:50:57'),
(163, 82, '/posts/image_JHAVojgJgO.png', NULL, 'image', '2018-03-01 05:53:36', '2018-03-01 05:53:36'),
(164, 83, '/posts/image_HFgVBK9zsB.jpg', NULL, 'image', '2018-03-01 05:55:09', '2018-03-01 05:55:09'),
(165, 84, '/posts/image_XsEEkM72IB.jpg', NULL, 'image', '2018-03-01 05:56:11', '2018-03-01 05:56:11'),
(166, 85, '/posts/image_NHIF05G2k1.jpg', NULL, 'image', '2018-03-01 05:56:28', '2018-03-01 05:56:28'),
(167, 85, '/posts/image_gISLrRFgsn.png', NULL, 'image', '2018-03-01 05:56:28', '2018-03-01 05:56:28'),
(168, 85, '/posts/image_lfZ91HLsMh.jpg', NULL, 'image', '2018-03-01 05:56:28', '2018-03-01 05:56:28'),
(169, 85, '/posts/image_RROKInSdE7.jpg', NULL, 'image', '2018-03-01 05:56:28', '2018-03-01 05:56:28'),
(170, 85, '/posts/image_Zy1DQ518Pe.jpg', NULL, 'image', '2018-03-01 05:56:28', '2018-03-01 05:56:28'),
(171, 85, '/posts/video_er6dFONyg1.mp4', '/posts/posters/video_er6dFONyg1.jpg', 'video', '2018-03-01 05:56:28', '2018-03-01 05:56:28'),
(172, 86, '/posts/video_aVocMMZb0Z.mp4', '/posts/posters/video_aVocMMZb0Z.jpg', 'video', '2018-03-01 05:57:45', '2018-03-01 05:57:45'),
(173, 87, '/posts/video_aVocMMZb0Z.mp4', '/posts/posters/video_aVocMMZb0Z.jpg', 'video', '2018-03-01 05:57:59', '2018-03-01 05:57:59'),
(174, 88, '/posts/image_Cp04g79lVA.jpg', NULL, 'image', '2018-03-01 05:58:50', '2018-03-01 05:58:50'),
(175, 89, '/posts/image_19pl3eG4bI.jpg', NULL, 'image', '2018-03-01 05:59:08', '2018-03-01 05:59:08'),
(176, 90, '/posts/image_mOHatbXIso.jpg', NULL, 'image', '2018-03-01 05:59:11', '2018-03-01 05:59:11'),
(177, 91, '/posts/video_JhZM6iFf8J.mp4', '/posts/posters/video_JhZM6iFf8J.jpg', 'video', '2018-03-01 05:59:18', '2018-03-01 05:59:18'),
(178, 92, '/posts/video_H40uXgypdz.mp4', '/posts/posters/video_H40uXgypdz.jpg', 'video', '2018-03-01 06:01:39', '2018-03-01 06:01:39'),
(179, 93, '/posts/image_rKgZD7QThI.jpg', NULL, 'image', '2018-03-01 06:01:51', '2018-03-01 06:01:51'),
(180, 93, '/posts/image_FdA83l3uTM.png', NULL, 'image', '2018-03-01 06:01:51', '2018-03-01 06:01:51'),
(181, 93, '/posts/image_Ejv6N6ChM3.jpg', NULL, 'image', '2018-03-01 06:01:51', '2018-03-01 06:01:51'),
(182, 93, '/posts/video_H40uXgypdz.mp4', '/posts/posters/video_H40uXgypdz.jpg', 'video', '2018-03-01 06:01:51', '2018-03-01 06:01:51'),
(183, 93, '/posts/video_LWTBJaF8AQ.mp4', '/posts/posters/video_LWTBJaF8AQ.jpg', 'video', '2018-03-01 06:01:51', '2018-03-01 06:01:51'),
(184, 94, '/posts/image_2aXkggou5T.jpg', NULL, 'image', '2018-03-01 06:11:18', '2018-03-01 06:11:18'),
(185, 94, '/posts/video_lNXklpir9A.mp4', '/posts/posters/video_lNXklpir9A.jpg', 'video', '2018-03-01 06:11:18', '2018-03-01 06:11:18'),
(186, 95, '/posts/image_t6UAWVqgix.png', NULL, 'image', '2018-03-01 06:11:35', '2018-03-01 06:11:35'),
(187, 95, '/posts/image_2uiloSPsmT.jpg', NULL, 'image', '2018-03-01 06:11:35', '2018-03-01 06:11:35'),
(188, 95, '/posts/video_lNXklpir9A.mp4', '/posts/posters/video_lNXklpir9A.jpg', 'video', '2018-03-01 06:11:35', '2018-03-01 06:11:35'),
(189, 95, '/posts/video_aDT29OZgas.mp4', '/posts/posters/video_aDT29OZgas.jpg', 'video', '2018-03-01 06:11:35', '2018-03-01 06:11:35'),
(190, 98, '/posts/image_bXDC3ZOjFG.png', NULL, 'image', '2018-03-02 00:42:59', '2018-03-02 00:42:59'),
(191, 98, '/posts/image_EgAKH973fl.jpg', NULL, 'image', '2018-03-02 00:42:59', '2018-03-02 00:42:59'),
(192, 98, '/posts/image_nz6ZRQN78G.jpg', NULL, 'image', '2018-03-02 00:42:59', '2018-03-02 00:42:59'),
(193, 98, '/posts/video_cYrOpvinYe.mp4', '/posts/posters/video_cYrOpvinYe.jpg', 'video', '2018-03-02 00:42:59', '2018-03-02 00:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_post_comments`
--

CREATE TABLE `user_post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `json_data` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_post_comments`
--

INSERT INTO `user_post_comments` (`id`, `user_id`, `post_id`, `comment`, `json_data`, `created_at`, `updated_at`) VALUES
(1, 1, 113, 'asdsada', NULL, '2018-03-05 05:22:02', '2018-03-05 05:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_post_comment_attachments`
--

CREATE TABLE `user_post_comment_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_post_flags`
--

CREATE TABLE `user_post_flags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_post_likes`
--

CREATE TABLE `user_post_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `is_like` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_post_likes`
--

INSERT INTO `user_post_likes` (`id`, `user_id`, `post_id`, `is_like`, `created_at`, `updated_at`) VALUES
(1, 1, 98, 1, '2018-03-02 00:46:10', '2018-03-02 00:46:10'),
(2, 1, 113, 1, '2018-03-05 04:47:26', '2018-03-05 04:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_post_muteds`
--

CREATE TABLE `user_post_muteds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_post_mutes`
--

CREATE TABLE `user_post_mutes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `is_mute` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_post_mutes`
--

INSERT INTO `user_post_mutes` (`id`, `user_id`, `post_id`, `is_mute`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 1, '2018-03-01 00:12:57', '2018-03-01 00:12:57'),
(2, 1, 97, 0, '2018-03-02 00:45:24', '2018-03-02 00:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_post_scrapes`
--

CREATE TABLE `user_post_scrapes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extracted_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_post_shares`
--

CREATE TABLE `user_post_shares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `post_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_post_tageds`
--

CREATE TABLE `user_post_tageds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_post_tageds`
--

INSERT INTO `user_post_tageds` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 2, 104, '2018-03-02 04:26:23', '2018-03-02 04:26:23'),
(2, 3, 104, '2018-03-02 04:26:23', '2018-03-02 04:26:23'),
(3, 4, 104, '2018-03-02 04:26:23', '2018-03-02 04:26:23'),
(4, 5, 104, '2018-03-02 04:26:23', '2018-03-02 04:26:23'),
(5, 2, 105, '2018-03-02 04:29:44', '2018-03-02 04:29:44'),
(6, 3, 106, '2018-03-05 03:06:31', '2018-03-05 03:06:31'),
(7, 2, 113, '2018-03-05 03:09:36', '2018-03-05 03:09:36'),
(8, 3, 113, '2018-03-05 03:09:36', '2018-03-05 03:09:36'),
(9, 4, 113, '2018-03-05 03:09:36', '2018-03-05 03:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED NOT NULL,
  `review` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_specializations`
--

CREATE TABLE `user_specializations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `specialization_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_strains`
--

CREATE TABLE `user_strains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `strain_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `indica` int(11) DEFAULT NULL,
  `sativa` int(11) DEFAULT NULL,
  `genetics` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cross_breed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `growing` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plant_height` double(8,2) DEFAULT NULL,
  `flowering_time` int(11) DEFAULT NULL,
  `min_fahren_temp` double(8,2) DEFAULT NULL,
  `max_fahren_temp` double(8,2) DEFAULT NULL,
  `min_celsius_temp` double(8,2) DEFAULT NULL,
  `max_celsius_temp` double(8,2) DEFAULT NULL,
  `yeild` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `climate` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_strain_likes`
--

CREATE TABLE `user_strain_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_strain_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_like` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tags`
--

CREATE TABLE `user_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_get_my_saves`
-- (See below for the actual view)
--
CREATE TABLE `v_get_my_saves` (
`id` bigint(20) unsigned
,`user_id` bigint(20) unsigned
,`model` varchar(255)
,`description` longtext
,`type_id` bigint(20) unsigned
,`type_sub_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
,`title` longtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_get_sub_user_settings`
-- (See below for the actual view)
--
CREATE TABLE `v_get_sub_user_settings` (
`id` bigint(20) unsigned
,`user_id` bigint(20) unsigned
,`business_type_id` bigint(20) unsigned
,`title` varchar(100)
,`logo` varchar(255)
,`banner` varchar(255)
,`is_organic` tinyint(1)
,`is_delivery` tinyint(1)
,`description` varchar(255)
,`location` varchar(255)
,`lat` varchar(255)
,`lng` varchar(255)
,`phone` varchar(255)
,`web` varchar(255)
,`facebook` varchar(255)
,`twitter` varchar(255)
,`instagram` varchar(255)
,`insurance_accepted` enum('Yes','No')
,`office_policies` varchar(500)
,`visit_requirements` varchar(500)
,`created_at` timestamp
,`updated_at` timestamp
,`stripe_id` varchar(255)
,`card_brand` varchar(255)
,`card_last_four` varchar(255)
,`trial_ends_at` timestamp
,`ends_at` timestamp
,`s_id` varchar(255)
,`review_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_h_b_galleries`
-- (See below for the actual view)
--
CREATE TABLE `v_h_b_galleries` (
`v_pk` varchar(23)
,`id` bigint(20) unsigned
,`a_type` varchar(2)
,`path` varchar(255)
,`type` varchar(100)
,`user_id` bigint(20) unsigned
,`poster` varchar(255)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_products`
-- (See below for the actual view)
--
CREATE TABLE `v_products` (
`id` bigint(20) unsigned
,`sub_user_id` bigint(20) unsigned
,`strain_id` bigint(20) unsigned
,`type_id` bigint(20) unsigned
,`name` varchar(100)
,`thc` double(8,2)
,`cbd` double(8,2)
,`created_at` timestamp
,`updated_at` timestamp
,`user_id` bigint(20) unsigned
,`title` varchar(100)
,`logo` varchar(255)
,`lat` varchar(255)
,`lng` varchar(255)
,`tag_id` bigint(20) unsigned
,`state` varchar(255)
,`price` varchar(255)
,`tag_title` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_search_table`
-- (See below for the actual view)
--
CREATE TABLE `v_search_table` (
`v_pk` varchar(23)
,`id` bigint(20) unsigned
,`s_type` varchar(2)
,`title` longtext
,`description` longtext
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_top_survey_answers`
-- (See below for the actual view)
--
CREATE TABLE `v_top_survey_answers` (
`m_id` bigint(20) unsigned
,`m_condition` varchar(100)
,`s_id` bigint(20) unsigned
,`sensation` varchar(100)
,`n_id` bigint(20) unsigned
,`n_effect` varchar(100)
,`p_id` bigint(20) unsigned
,`prevention` varchar(100)
,`f_id` bigint(20) unsigned
,`flavor` varchar(100)
,`question_id` bigint(20) unsigned
,`strain_id` bigint(20) unsigned
,`result` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_groups`
-- (See below for the actual view)
--
CREATE TABLE `v_user_groups` (
`id` bigint(20) unsigned
,`user_id` bigint(20) unsigned
,`image` varchar(255)
,`title` varchar(100)
,`description` text
,`is_private` tinyint(1)
,`created_at` timestamp
,`updated_at` timestamp
,`get_members_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `v_get_my_saves`
--
DROP TABLE IF EXISTS `v_get_my_saves`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_get_my_saves`  AS  select `my_saves`.`id` AS `id`,`my_saves`.`user_id` AS `user_id`,`my_saves`.`model` AS `model`,`my_saves`.`description` AS `description`,`my_saves`.`type_id` AS `type_id`,`my_saves`.`type_sub_id` AS `type_sub_id`,`my_saves`.`created_at` AS `created_at`,`my_saves`.`updated_at` AS `updated_at`,ifnull(`questions`.`question`,ifnull(`strains`.`title`,ifnull(`journals`.`title`,ifnull(`answers`.`answer`,ifnull(`groups`.`title`,ifnull(`sub_users`.`title`,ifnull(`shout_outs`.`title`,NULL))))))) AS `title` from (((((((`my_saves` left join `questions` on(((`my_saves`.`type_sub_id` = `questions`.`id`) and (`my_saves`.`type_id` = 4)))) left join `strains` on(((`my_saves`.`type_sub_id` = `strains`.`id`) and (`my_saves`.`type_id` = 7)))) left join `journals` on(((`my_saves`.`type_sub_id` = `journals`.`id`) and (`my_saves`.`type_id` = 3)))) left join `answers` on(((`my_saves`.`type_sub_id` = `answers`.`id`) and (`my_saves`.`type_id` = 5)))) left join `groups` on(((`my_saves`.`type_sub_id` = `groups`.`id`) and (`my_saves`.`type_id` = 6)))) left join `sub_users` on(((`my_saves`.`type_sub_id` = `sub_users`.`id`) and (`my_saves`.`type_id` = 8)))) left join `shout_outs` on(((`my_saves`.`type_sub_id` = `shout_outs`.`id`) and (`my_saves`.`type_id` = 11)))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_get_sub_user_settings`
--
DROP TABLE IF EXISTS `v_get_sub_user_settings`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_get_sub_user_settings`  AS  select `sub_users`.`id` AS `id`,`sub_users`.`user_id` AS `user_id`,`sub_users`.`business_type_id` AS `business_type_id`,`sub_users`.`title` AS `title`,`sub_users`.`logo` AS `logo`,`sub_users`.`banner` AS `banner`,`sub_users`.`is_organic` AS `is_organic`,`sub_users`.`is_delivery` AS `is_delivery`,`sub_users`.`description` AS `description`,`sub_users`.`location` AS `location`,`sub_users`.`lat` AS `lat`,`sub_users`.`lng` AS `lng`,`sub_users`.`phone` AS `phone`,`sub_users`.`web` AS `web`,`sub_users`.`facebook` AS `facebook`,`sub_users`.`twitter` AS `twitter`,`sub_users`.`instagram` AS `instagram`,`sub_users`.`insurance_accepted` AS `insurance_accepted`,`sub_users`.`office_policies` AS `office_policies`,`sub_users`.`visit_requirements` AS `visit_requirements`,`sub_users`.`created_at` AS `created_at`,`sub_users`.`updated_at` AS `updated_at`,`sub_users`.`stripe_id` AS `stripe_id`,`sub_users`.`card_brand` AS `card_brand`,`sub_users`.`card_last_four` AS `card_last_four`,`sub_users`.`trial_ends_at` AS `trial_ends_at`,`subscriptions`.`ends_at` AS `ends_at`,`subscriptions`.`stripe_id` AS `s_id`,(select count(0) from `business_reviews` where (`sub_users`.`id` = `business_reviews`.`sub_user_id`)) AS `review_count` from (`sub_users` left join `subscriptions` on((`sub_users`.`id` = `subscriptions`.`sub_user_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_h_b_galleries`
--
DROP TABLE IF EXISTS `v_h_b_galleries`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_h_b_galleries`  AS  select (concat(`business_review_attachments`.`id`,'_','br') collate utf8mb4_unicode_ci) AS `v_pk`,`business_review_attachments`.`id` AS `id`,('br' collate utf8mb4_unicode_ci) AS `a_type`,`business_review_attachments`.`attachment` AS `path`,`business_review_attachments`.`type` AS `type`,`business_review_attachments`.`user_id` AS `user_id`,`business_review_attachments`.`poster` AS `poster`,`business_review_attachments`.`created_at` AS `created_at` from `business_review_attachments` union all select (concat(`event_review_attachments`.`id`,'_','er') collate utf8mb4_unicode_ci) AS `v_pk`,`event_review_attachments`.`id` AS `id`,('er' collate utf8mb4_unicode_ci) AS `a_type`,`event_review_attachments`.`attachment` AS `path`,`event_review_attachments`.`upload_type` AS `type`,`event_review_attachments`.`user_id` AS `user_id`,`event_review_attachments`.`poster` AS `poster`,`event_review_attachments`.`created_at` AS `created_at` from `event_review_attachments` union all select (concat(`journal_event_attachments`.`id`,'_','je') collate utf8mb4_unicode_ci) AS `v_pk`,`journal_event_attachments`.`id` AS `id`,('je' collate utf8mb4_unicode_ci) AS `a_type`,`journal_event_attachments`.`attachment_path` AS `path`,`journal_event_attachments`.`attachment_type` AS `type`,`journal_event_attachments`.`user_id` AS `user_id`,`journal_event_attachments`.`poster` AS `poster`,`journal_event_attachments`.`created_at` AS `created_at` from `journal_event_attachments` union all select (concat(`product_images`.`id`,'_','pi') collate utf8mb4_unicode_ci) AS `v_pk`,`product_images`.`id` AS `id`,('pi' collate utf8mb4_unicode_ci) AS `a_type`,`product_images`.`image` AS `path`,('image' collate utf8mb4_unicode_ci) AS `type`,`product_images`.`user_id` AS `user_id`,('NULL' collate utf8mb4_unicode_ci) AS `poster`,`product_images`.`created_at` AS `created_at` from `product_images` union all select (concat(`strain_images`.`id`,'_','si') collate utf8mb4_unicode_ci) AS `v_pk`,`strain_images`.`id` AS `id`,('si' collate utf8mb4_unicode_ci) AS `a_type`,`strain_images`.`image_path` AS `path`,('image' collate utf8mb4_unicode_ci) AS `type`,`strain_images`.`user_id` AS `user_id`,('NULL' collate utf8mb4_unicode_ci) AS `poster`,`strain_images`.`created_at` AS `created_at` from `strain_images` union all select (concat(`strain_review_images`.`id`,'_','sr') collate utf8mb4_unicode_ci) AS `v_pk`,`strain_review_images`.`id` AS `id`,('sr' collate utf8mb4_unicode_ci) AS `a_type`,`strain_review_images`.`attachment` AS `path`,`strain_review_images`.`type` AS `type`,`strain_review_images`.`user_id` AS `user_id`,`strain_review_images`.`poster` AS `poster`,`strain_review_images`.`created_at` AS `created_at` from `strain_review_images` union all select (concat(`sub_user_images`.`id`,'_','su') collate utf8mb4_unicode_ci) AS `v_pk`,`sub_user_images`.`id` AS `id`,('su' collate utf8mb4_unicode_ci) AS `a_type`,`sub_user_images`.`image` AS `path`,('image' collate utf8mb4_unicode_ci) AS `type`,`sub_user_images`.`user_id` AS `user_id`,('NULL' collate utf8mb4_unicode_ci) AS `poster`,`sub_user_images`.`created_at` AS `created_at` from `sub_user_images` ;

-- --------------------------------------------------------

--
-- Structure for view `v_products`
--
DROP TABLE IF EXISTS `v_products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_products`  AS  select `products`.`id` AS `id`,`products`.`sub_user_id` AS `sub_user_id`,`products`.`strain_id` AS `strain_id`,`products`.`type_id` AS `type_id`,`products`.`name` AS `name`,`products`.`thc` AS `thc`,`products`.`cbd` AS `cbd`,`products`.`created_at` AS `created_at`,`products`.`updated_at` AS `updated_at`,`sub_users`.`user_id` AS `user_id`,`sub_users`.`title` AS `title`,`sub_users`.`logo` AS `logo`,`sub_users`.`lat` AS `lat`,`sub_users`.`lng` AS `lng`,`tag_state_prices`.`tag_id` AS `tag_id`,`tag_state_prices`.`state` AS `state`,`tag_state_prices`.`price` AS `price`,`tags`.`title` AS `tag_title` from (((`products` left join `sub_users` on((`products`.`sub_user_id` = `sub_users`.`id`))) left join `tag_state_prices` on((`sub_users`.`user_id` = `tag_state_prices`.`user_id`))) left join `tags` on((`tag_state_prices`.`tag_id` = `tags`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_search_table`
--
DROP TABLE IF EXISTS `v_search_table`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_search_table`  AS  select (concat(`sub_users`.`id`,'_','bm') collate utf8mb4_unicode_ci) AS `v_pk`,`sub_users`.`id` AS `id`,('bm' collate utf8mb4_unicode_ci) AS `s_type`,`sub_users`.`title` AS `title`,`sub_users`.`description` AS `description`,`sub_users`.`created_at` AS `created_at` from `sub_users` union all select (concat(`answers`.`id`,'_','a') collate utf8mb4_unicode_ci) AS `v_pk`,`answers`.`question_id` AS `id`,'a' AS `s_type`,(`answers`.`answer` collate utf8mb4_unicode_ci) AS `title`,'' AS `description`,`answers`.`created_at` AS `created_at` from `answers` union all select (concat(`questions`.`id`,'_','q') collate utf8mb4_unicode_ci) AS `v_pk`,`questions`.`id` AS `id`,'q' AS `q`,(`questions`.`question` collate utf8mb4_unicode_ci) AS `title`,`questions`.`description` AS `description`,`questions`.`created_at` AS `created_at` from `questions` union all select (concat(`journals`.`id`,'_','j') collate utf8mb4_unicode_ci) AS `v_pk`,`journals`.`id` AS `id`,'j' AS `j`,(`journals`.`title` collate utf8mb4_unicode_ci) AS `title`,'' AS `description`,`journals`.`created_at` AS `created_at` from `journals` union all select (concat(`groups`.`id`,'_','g') collate utf8mb4_unicode_ci) AS `v_pk`,`groups`.`id` AS `id`,'g' AS `g`,(`groups`.`title` collate utf8mb4_unicode_ci) AS `title`,`groups`.`description` AS `description`,`groups`.`created_at` AS `created_at` from `groups` union all select (concat(`users`.`id`,'_','u') collate utf8mb4_unicode_ci) AS `v_pk`,`users`.`id` AS `id`,'u' AS `u`,(`users`.`first_name` collate utf8mb4_unicode_ci) AS `title`,'' AS `description`,`users`.`created_at` AS `created_at` from `users` union all select (concat(`strains`.`id`,'_','s') collate utf8mb4_unicode_ci) AS `v_pk`,`strains`.`id` AS `id`,'s' AS `s`,(`strains`.`title` collate utf8mb4_unicode_ci) AS `title`,`strains`.`overview` AS `overview`,`strains`.`created_at` AS `created_at` from `strains` ;

-- --------------------------------------------------------

--
-- Structure for view `v_top_survey_answers`
--
DROP TABLE IF EXISTS `v_top_survey_answers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_top_survey_answers`  AS  select `medical_conditions`.`id` AS `m_id`,`medical_conditions`.`m_condition` AS `m_condition`,`sensations`.`id` AS `s_id`,`sensations`.`sensation` AS `sensation`,`negative_effects`.`id` AS `n_id`,`negative_effects`.`effect` AS `n_effect`,`disease_preventions`.`id` AS `p_id`,`disease_preventions`.`prevention` AS `prevention`,`flavors`.`id` AS `f_id`,`flavors`.`flavor` AS `flavor`,`strain_survey_answers`.`question_id` AS `question_id`,`strain_survey_answers`.`strain_id` AS `strain_id`,count(0) AS `result` from (((((`strain_survey_answers` left join `medical_conditions` on((`strain_survey_answers`.`answer` like concat('%',`medical_conditions`.`m_condition`,'%')))) left join `sensations` on((`strain_survey_answers`.`answer` like concat('%',`sensations`.`sensation`,'%')))) left join `negative_effects` on((`strain_survey_answers`.`answer` like concat('%',`negative_effects`.`effect`,'%')))) left join `disease_preventions` on((`strain_survey_answers`.`answer` like concat('%',`disease_preventions`.`prevention`,'%')))) left join `flavors` on((`strain_survey_answers`.`answer` like concat('%',`flavors`.`flavor`,'%')))) group by `medical_conditions`.`m_condition`,`sensations`.`sensation`,`negative_effects`.`effect`,`disease_preventions`.`prevention`,`flavors`.`flavor`,`strain_survey_answers`.`question_id`,`strain_survey_answers`.`strain_id` order by `strain_survey_answers`.`question_id`,`strain_survey_answers`.`strain_id`,13 desc ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_groups`
--
DROP TABLE IF EXISTS `v_user_groups`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_groups`  AS  select `groups`.`id` AS `id`,`groups`.`user_id` AS `user_id`,`groups`.`image` AS `image`,`groups`.`title` AS `title`,`groups`.`description` AS `description`,`groups`.`is_private` AS `is_private`,`groups`.`created_at` AS `created_at`,`groups`.`updated_at` AS `updated_at`,(select count(0) from `group_followers` where (`groups`.`id` = `group_followers`.`group_id`)) AS `get_members_count` from `groups` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_products`
--
ALTER TABLE `admin_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_user_id_foreign` (`user_id`),
  ADD KEY `answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `answer_attachments`
--
ALTER TABLE `answer_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_attachments_answer_id_foreign` (`answer_id`);

--
-- Indexes for table `answer_likes`
--
ALTER TABLE `answer_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_likes_answer_id_foreign` (`answer_id`),
  ADD KEY `answer_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `budz_feeds`
--
ALTER TABLE `budz_feeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budz_feeds_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `budz_feeds_user_id_foreign` (`user_id`),
  ADD KEY `budz_feeds_search_by_foreign` (`search_by`),
  ADD KEY `budz_feeds_review_id_foreign` (`review_id`),
  ADD KEY `budz_feeds_my_save_id_foreign` (`my_save_id`),
  ADD KEY `budz_feeds_share_id_foreign` (`share_id`),
  ADD KEY `budz_feeds_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `business_events`
--
ALTER TABLE `business_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_events_sub_user_id_foreign` (`sub_user_id`);

--
-- Indexes for table `business_languages`
--
ALTER TABLE `business_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_languages_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `business_languages_language_id_foreign` (`language_id`);

--
-- Indexes for table `business_reviews`
--
ALTER TABLE `business_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_reviews_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `business_reviews_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `business_review_attachments`
--
ALTER TABLE `business_review_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_review_attachments_business_review_id_foreign` (`business_review_id`),
  ADD KEY `business_review_attachments_user_id_foreign` (`user_id`);

--
-- Indexes for table `business_review_replies`
--
ALTER TABLE `business_review_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_review_replies_business_review_id_foreign` (`business_review_id`),
  ADD KEY `business_review_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `business_review_reports`
--
ALTER TABLE `business_review_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_review_reports_business_review_id_foreign` (`business_review_id`),
  ADD KEY `business_review_reports_reported_by_foreign` (`reported_by`);

--
-- Indexes for table `business_shares`
--
ALTER TABLE `business_shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_shares_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `business_shares_user_id_foreign` (`user_id`);

--
-- Indexes for table `business_timings`
--
ALTER TABLE `business_timings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_timings_sub_user_id_foreign` (`sub_user_id`);

--
-- Indexes for table `business_types`
--
ALTER TABLE `business_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_user_ratings`
--
ALTER TABLE `business_user_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_user_ratings_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `business_user_ratings_rated_by_foreign` (`rated_by`),
  ADD KEY `business_user_ratings_review_id_foreign` (`review_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_chat_id_foreign` (`chat_id`),
  ADD KEY `chat_messages_sender_id_foreign` (`sender_id`),
  ADD KEY `chat_messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_users_sender_id_foreign` (`sender_id`),
  ADD KEY `chat_users_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `data_settings`
--
ALTER TABLE `data_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `default_questions`
--
ALTER TABLE `default_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disease_preventions`
--
ALTER TABLE `disease_preventions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Indexes for table `event_likes`
--
ALTER TABLE `event_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_likes_event_id_foreign` (`event_id`),
  ADD KEY `event_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `event_ratings`
--
ALTER TABLE `event_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_ratings_event_id_foreign` (`event_id`),
  ADD KEY `event_ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `event_reviews`
--
ALTER TABLE `event_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_reviews_event_id_foreign` (`event_id`),
  ADD KEY `event_reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `event_review_attachments`
--
ALTER TABLE `event_review_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_review_attachments_event_review_id_foreign` (`event_review_id`),
  ADD KEY `event_review_attachments_user_id_foreign` (`user_id`);

--
-- Indexes for table `event_ticket_pricings`
--
ALTER TABLE `event_ticket_pricings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_ticket_pricings_event_id_foreign` (`event_id`),
  ADD KEY `event_ticket_pricings_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `event_timings`
--
ALTER TABLE `event_timings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_timings_user_id_foreign` (`user_id`),
  ADD KEY `event_timings_event_id_foreign` (`event_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_type_edits`
--
ALTER TABLE `event_type_edits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_type_edits_user_id_foreign` (`user_id`),
  ADD KEY `event_type_edits_event_id_foreign` (`event_id`),
  ADD KEY `event_type_edits_event_type_id_foreign` (`event_type_id`);

--
-- Indexes for table `experties`
--
ALTER TABLE `experties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experties_exp_question_id_foreign` (`exp_question_id`);

--
-- Indexes for table `expertise_questions`
--
ALTER TABLE `expertise_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flaged_answers`
--
ALTER TABLE `flaged_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flaged_answers_answer_id_foreign` (`answer_id`),
  ADD KEY `flaged_answers_user_id_foreign` (`user_id`),
  ADD KEY `flaged_answers_flaged_user_id_foreign` (`flaged_user_id`);

--
-- Indexes for table `flavors`
--
ALTER TABLE `flavors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow_uses`
--
ALTER TABLE `follow_uses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_user_id_foreign` (`user_id`);

--
-- Indexes for table `group_followers`
--
ALTER TABLE `group_followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_followers_user_id_foreign` (`user_id`),
  ADD KEY `group_followers_group_id_foreign` (`group_id`);

--
-- Indexes for table `group_invitations`
--
ALTER TABLE `group_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_invitations_user_id_foreign` (`user_id`),
  ADD KEY `group_invitations_group_id_foreign` (`group_id`);

--
-- Indexes for table `group_messages`
--
ALTER TABLE `group_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_messages_user_id_foreign` (`user_id`),
  ADD KEY `group_messages_group_id_foreign` (`group_id`);

--
-- Indexes for table `group_message_likes`
--
ALTER TABLE `group_message_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_message_likes_user_id_foreign` (`user_id`),
  ADD KEY `group_message_likes_group_message_id_foreign` (`group_message_id`);

--
-- Indexes for table `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journals_user_id_foreign` (`user_id`);

--
-- Indexes for table `journal_events`
--
ALTER TABLE `journal_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_events_user_id_foreign` (`user_id`),
  ADD KEY `journal_events_journal_id_foreign` (`journal_id`),
  ADD KEY `journal_events_strain_id_foreign` (`strain_id`);

--
-- Indexes for table `journal_event_attachments`
--
ALTER TABLE `journal_event_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_event_attachments_journal_event_id_foreign` (`journal_event_id`),
  ADD KEY `journal_event_attachments_user_id_foreign` (`user_id`);

--
-- Indexes for table `journal_event_tags`
--
ALTER TABLE `journal_event_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_event_tags_journal_id_foreign` (`journal_id`),
  ADD KEY `journal_event_tags_journal_event_id_foreign` (`journal_event_id`),
  ADD KEY `journal_event_tags_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `journal_followings`
--
ALTER TABLE `journal_followings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_followings_user_id_foreign` (`user_id`),
  ADD KEY `journal_followings_journal_id_foreign` (`journal_id`);

--
-- Indexes for table `journal_like_dislikes`
--
ALTER TABLE `journal_like_dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_like_dislikes_journal_event_id_foreign` (`journal_event_id`),
  ADD KEY `journal_like_dislikes_user_id_foreign` (`user_id`);

--
-- Indexes for table `journal_settings`
--
ALTER TABLE `journal_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legals`
--
ALTER TABLE `legals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_users`
--
ALTER TABLE `login_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `medical_conditions`
--
ALTER TABLE `medical_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_saves`
--
ALTER TABLE `my_saves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `my_saves_user_id_foreign` (`user_id`),
  ADD KEY `my_saves_type_id_foreign` (`type_id`);

--
-- Indexes for table `my_save_settings`
--
ALTER TABLE `my_save_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `my_save_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `negative_effects`
--
ALTER TABLE `negative_effects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_from_user_foreign` (`from_user`),
  ADD KEY `notifications_to_user_foreign` (`to_user`),
  ADD KEY `notifications_type_id_foreign` (`type_id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `offers_strain_id_foreign` (`strain_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `products_strain_id_foreign` (`strain_id`),
  ADD KEY `products_type_id_foreign` (`type_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`),
  ADD KEY `product_images_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_pricings`
--
ALTER TABLE `product_pricings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_pricings_product_id_foreign` (`product_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `question_likes`
--
ALTER TABLE `question_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_likes_user_id_foreign` (`user_id`),
  ADD KEY `question_likes_question_id_foreign` (`question_id`);

--
-- Indexes for table `question_shares`
--
ALTER TABLE `question_shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_shares_user_id_foreign` (`user_id`),
  ADD KEY `question_shares_question_id_foreign` (`question_id`);

--
-- Indexes for table `reminder_settings`
--
ALTER TABLE `reminder_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reminder_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `samples`
--
ALTER TABLE `samples`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `searched_keywords`
--
ALTER TABLE `searched_keywords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_counts`
--
ALTER TABLE `search_counts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `search_counts_keyword_id_foreign` (`keyword_id`);

--
-- Indexes for table `sensations`
--
ALTER TABLE `sensations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_sub_user_id_foreign` (`sub_user_id`);

--
-- Indexes for table `shout_outs`
--
ALTER TABLE `shout_outs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shout_outs_user_id_foreign` (`user_id`),
  ADD KEY `shout_outs_sub_user_id_foreign` (`sub_user_id`);

--
-- Indexes for table `shout_out_likes`
--
ALTER TABLE `shout_out_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shout_out_likes_shout_out_id_foreign` (`shout_out_id`),
  ADD KEY `shout_out_likes_liked_by_foreign` (`liked_by`);

--
-- Indexes for table `shout_out_notifications`
--
ALTER TABLE `shout_out_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shout_out_notifications_user_id_foreign` (`user_id`),
  ADD KEY `shout_out_notifications_shout_out_id_foreign` (`shout_out_id`);

--
-- Indexes for table `shout_out_shares`
--
ALTER TABLE `shout_out_shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shout_out_shares_shout_out_id_foreign` (`shout_out_id`),
  ADD KEY `shout_out_shares_user_id_foreign` (`user_id`);

--
-- Indexes for table `shout_out_views`
--
ALTER TABLE `shout_out_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shout_out_views_shout_out_id_foreign` (`shout_out_id`),
  ADD KEY `shout_out_views_user_id_foreign` (`user_id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strains`
--
ALTER TABLE `strains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strains_type_id_foreign` (`type_id`);

--
-- Indexes for table `strain_images`
--
ALTER TABLE `strain_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_images_strain_id_foreign` (`strain_id`),
  ADD KEY `strain_images_user_id_foreign` (`user_id`);

--
-- Indexes for table `strain_image_flags`
--
ALTER TABLE `strain_image_flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_image_flags_user_id_foreign` (`user_id`),
  ADD KEY `strain_image_flags_image_id_foreign` (`image_id`);

--
-- Indexes for table `strain_image_like_dislikes`
--
ALTER TABLE `strain_image_like_dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_image_like_dislikes_user_id_foreign` (`user_id`),
  ADD KEY `strain_image_like_dislikes_image_id_foreign` (`image_id`);

--
-- Indexes for table `strain_likes`
--
ALTER TABLE `strain_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_likes_strain_id_foreign` (`strain_id`),
  ADD KEY `strain_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `strain_ratings`
--
ALTER TABLE `strain_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_ratings_strain_id_foreign` (`strain_id`),
  ADD KEY `strain_ratings_strain_review_id_foreign` (`strain_review_id`),
  ADD KEY `strain_ratings_rated_by_foreign` (`rated_by`);

--
-- Indexes for table `strain_reviews`
--
ALTER TABLE `strain_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_reviews_strain_id_foreign` (`strain_id`),
  ADD KEY `strain_reviews_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `strain_review_flags`
--
ALTER TABLE `strain_review_flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_review_flags_strain_id_foreign` (`strain_id`),
  ADD KEY `strain_review_flags_strain_review_id_foreign` (`strain_review_id`),
  ADD KEY `strain_review_flags_flaged_by_foreign` (`flaged_by`);

--
-- Indexes for table `strain_review_images`
--
ALTER TABLE `strain_review_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_review_images_strain_id_foreign` (`strain_id`),
  ADD KEY `strain_review_images_user_id_foreign` (`user_id`),
  ADD KEY `strain_review_images_strain_review_id_foreign` (`strain_review_id`);

--
-- Indexes for table `strain_survey_answers`
--
ALTER TABLE `strain_survey_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strain_survey_answers_question_id_foreign` (`question_id`),
  ADD KEY `strain_survey_answers_strain_id_foreign` (`strain_id`),
  ADD KEY `strain_survey_answers_user_id_foreign` (`user_id`);

--
-- Indexes for table `strain_survey_questions`
--
ALTER TABLE `strain_survey_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strain_types`
--
ALTER TABLE `strain_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_sub_user_id_foreign` (`sub_user_id`);

--
-- Indexes for table `sub_users`
--
ALTER TABLE `sub_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_users_user_id_foreign` (`user_id`),
  ADD KEY `sub_users_business_type_id_foreign` (`business_type_id`);

--
-- Indexes for table `sub_user_images`
--
ALTER TABLE `sub_user_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_user_images_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `sub_user_images_user_id_foreign` (`user_id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_searches`
--
ALTER TABLE `tag_searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_searches_tag_id_foreign` (`tag_id`),
  ADD KEY `tag_searches_user_id_foreign` (`user_id`);

--
-- Indexes for table `tag_state_prices`
--
ALTER TABLE `tag_state_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_state_prices_user_id_foreign` (`user_id`),
  ADD KEY `tag_state_prices_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `term_condations`
--
ALTER TABLE `term_condations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `used_tags`
--
ALTER TABLE `used_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `used_tags_tag_id_foreign` (`tag_id`),
  ADD KEY `used_tags_user_id_foreign` (`user_id`),
  ADD KEY `used_tags_menu_item_id_foreign` (`menu_item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_foreign` (`user_id`),
  ADD KEY `user_activities_on_user_foreign` (`on_user`);

--
-- Indexes for table `user_experties`
--
ALTER TABLE `user_experties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_experties_user_id_foreign` (`user_id`),
  ADD KEY `user_experties_exp_id_foreign` (`exp_id`);

--
-- Indexes for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_follows_user_id_foreign` (`user_id`),
  ADD KEY `user_follows_followed_id_foreign` (`followed_id`);

--
-- Indexes for table `user_group_settings`
--
ALTER TABLE `user_group_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_group_settings_user_id_foreign` (`user_id`),
  ADD KEY `user_group_settings_group_id_foreign` (`group_id`);

--
-- Indexes for table `user_medical_conditions`
--
ALTER TABLE `user_medical_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_medical_conditions_medical_c_id_foreign` (`medical_c_id`),
  ADD KEY `user_medical_conditions_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_points`
--
ALTER TABLE `user_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_points_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_posts_user_id_foreign` (`user_id`),
  ADD KEY `user_posts_sub_user_id_foreign` (`sub_user_id`),
  ADD KEY `shared_id` (`shared_id`),
  ADD KEY `shared_user_id` (`shared_user_id`);

--
-- Indexes for table `user_post_attachments`
--
ALTER TABLE `user_post_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_attachments_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_post_comments`
--
ALTER TABLE `user_post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_comments_user_id_foreign` (`user_id`),
  ADD KEY `user_post_comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_post_comment_attachments`
--
ALTER TABLE `user_post_comment_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_comment_attachments_comment_id_foreign` (`comment_id`);

--
-- Indexes for table `user_post_flags`
--
ALTER TABLE `user_post_flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_comment_flags_user_id_foreign` (`user_id`),
  ADD KEY `user_post_comment_flags_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_post_likes`
--
ALTER TABLE `user_post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_likes_user_id_foreign` (`user_id`),
  ADD KEY `user_post_likes_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_post_muteds`
--
ALTER TABLE `user_post_muteds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_muteds_user_id_foreign` (`user_id`),
  ADD KEY `user_post_muteds_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_post_mutes`
--
ALTER TABLE `user_post_mutes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_muteds_user_id_foreign` (`user_id`),
  ADD KEY `user_post_muteds_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_post_scrapes`
--
ALTER TABLE `user_post_scrapes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_scrapes_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_post_shares`
--
ALTER TABLE `user_post_shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_shares_user_id_foreign` (`user_id`),
  ADD KEY `user_post_shares_post_id_foreign` (`post_id`),
  ADD KEY `user_post_shares_post_user_id_foreign` (`post_user_id`);

--
-- Indexes for table `user_post_tageds`
--
ALTER TABLE `user_post_tageds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_tageds_user_id_foreign` (`user_id`),
  ADD KEY `user_post_tageds_post_id_foreign` (`post_id`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_reviews_user_id_foreign` (`user_id`),
  ADD KEY `user_reviews_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `user_specializations`
--
ALTER TABLE `user_specializations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_specializations_user_id_foreign` (`user_id`),
  ADD KEY `user_specializations_specialization_id_foreign` (`specialization_id`);

--
-- Indexes for table `user_strains`
--
ALTER TABLE `user_strains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_strains_strain_id_foreign` (`strain_id`),
  ADD KEY `user_strains_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_strain_likes`
--
ALTER TABLE `user_strain_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_strain_likes_user_strain_id_foreign` (`user_strain_id`),
  ADD KEY `user_strain_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_tags_user_id_foreign` (`user_id`),
  ADD KEY `user_tags_tag_id_foreign` (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_products`
--
ALTER TABLE `admin_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answer_attachments`
--
ALTER TABLE `answer_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `answer_likes`
--
ALTER TABLE `answer_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `budz_feeds`
--
ALTER TABLE `budz_feeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_events`
--
ALTER TABLE `business_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_languages`
--
ALTER TABLE `business_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_reviews`
--
ALTER TABLE `business_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_review_attachments`
--
ALTER TABLE `business_review_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_review_replies`
--
ALTER TABLE `business_review_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_review_reports`
--
ALTER TABLE `business_review_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_shares`
--
ALTER TABLE `business_shares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_timings`
--
ALTER TABLE `business_timings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_types`
--
ALTER TABLE `business_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `business_user_ratings`
--
ALTER TABLE `business_user_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chat_users`
--
ALTER TABLE `chat_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_settings`
--
ALTER TABLE `data_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `default_questions`
--
ALTER TABLE `default_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `disease_preventions`
--
ALTER TABLE `disease_preventions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_likes`
--
ALTER TABLE `event_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_ratings`
--
ALTER TABLE `event_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_reviews`
--
ALTER TABLE `event_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_review_attachments`
--
ALTER TABLE `event_review_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_ticket_pricings`
--
ALTER TABLE `event_ticket_pricings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_timings`
--
ALTER TABLE `event_timings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_type_edits`
--
ALTER TABLE `event_type_edits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experties`
--
ALTER TABLE `experties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expertise_questions`
--
ALTER TABLE `expertise_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `flaged_answers`
--
ALTER TABLE `flaged_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flavors`
--
ALTER TABLE `flavors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follow_uses`
--
ALTER TABLE `follow_uses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `group_followers`
--
ALTER TABLE `group_followers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `group_invitations`
--
ALTER TABLE `group_invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_messages`
--
ALTER TABLE `group_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `group_message_likes`
--
ALTER TABLE `group_message_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_events`
--
ALTER TABLE `journal_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_event_attachments`
--
ALTER TABLE `journal_event_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_event_tags`
--
ALTER TABLE `journal_event_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_followings`
--
ALTER TABLE `journal_followings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_like_dislikes`
--
ALTER TABLE `journal_like_dislikes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_settings`
--
ALTER TABLE `journal_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legals`
--
ALTER TABLE `legals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_users`
--
ALTER TABLE `login_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `medical_conditions`
--
ALTER TABLE `medical_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `my_saves`
--
ALTER TABLE `my_saves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `my_save_settings`
--
ALTER TABLE `my_save_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `negative_effects`
--
ALTER TABLE `negative_effects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_pricings`
--
ALTER TABLE `product_pricings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `question_likes`
--
ALTER TABLE `question_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_shares`
--
ALTER TABLE `question_shares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reminder_settings`
--
ALTER TABLE `reminder_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `samples`
--
ALTER TABLE `samples`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `searched_keywords`
--
ALTER TABLE `searched_keywords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `search_counts`
--
ALTER TABLE `search_counts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sensations`
--
ALTER TABLE `sensations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shout_outs`
--
ALTER TABLE `shout_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shout_out_likes`
--
ALTER TABLE `shout_out_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shout_out_notifications`
--
ALTER TABLE `shout_out_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shout_out_shares`
--
ALTER TABLE `shout_out_shares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shout_out_views`
--
ALTER TABLE `shout_out_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `strains`
--
ALTER TABLE `strains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `strain_images`
--
ALTER TABLE `strain_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_image_flags`
--
ALTER TABLE `strain_image_flags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_image_like_dislikes`
--
ALTER TABLE `strain_image_like_dislikes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_likes`
--
ALTER TABLE `strain_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_ratings`
--
ALTER TABLE `strain_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `strain_reviews`
--
ALTER TABLE `strain_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `strain_review_flags`
--
ALTER TABLE `strain_review_flags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_review_images`
--
ALTER TABLE `strain_review_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_survey_answers`
--
ALTER TABLE `strain_survey_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_survey_questions`
--
ALTER TABLE `strain_survey_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strain_types`
--
ALTER TABLE `strain_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_users`
--
ALTER TABLE `sub_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_user_images`
--
ALTER TABLE `sub_user_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tag_searches`
--
ALTER TABLE `tag_searches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag_state_prices`
--
ALTER TABLE `tag_state_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `term_condations`
--
ALTER TABLE `term_condations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `used_tags`
--
ALTER TABLE `used_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_experties`
--
ALTER TABLE `user_experties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_follows`
--
ALTER TABLE `user_follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_group_settings`
--
ALTER TABLE `user_group_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_medical_conditions`
--
ALTER TABLE `user_medical_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_points`
--
ALTER TABLE `user_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_posts`
--
ALTER TABLE `user_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `user_post_attachments`
--
ALTER TABLE `user_post_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `user_post_comments`
--
ALTER TABLE `user_post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_post_comment_attachments`
--
ALTER TABLE `user_post_comment_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post_flags`
--
ALTER TABLE `user_post_flags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post_likes`
--
ALTER TABLE `user_post_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_post_muteds`
--
ALTER TABLE `user_post_muteds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post_mutes`
--
ALTER TABLE `user_post_mutes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_post_scrapes`
--
ALTER TABLE `user_post_scrapes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post_shares`
--
ALTER TABLE `user_post_shares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_post_tageds`
--
ALTER TABLE `user_post_tageds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_specializations`
--
ALTER TABLE `user_specializations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_strains`
--
ALTER TABLE `user_strains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_strain_likes`
--
ALTER TABLE `user_strain_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tags`
--
ALTER TABLE `user_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `answer_attachments`
--
ALTER TABLE `answer_attachments`
  ADD CONSTRAINT `answer_attachments_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `answer_likes`
--
ALTER TABLE `answer_likes`
  ADD CONSTRAINT `answer_likes_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answer_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `budz_feeds`
--
ALTER TABLE `budz_feeds`
  ADD CONSTRAINT `budz_feeds_my_save_id_foreign` FOREIGN KEY (`my_save_id`) REFERENCES `my_saves` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budz_feeds_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `business_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budz_feeds_search_by_foreign` FOREIGN KEY (`search_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budz_feeds_share_id_foreign` FOREIGN KEY (`share_id`) REFERENCES `business_shares` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budz_feeds_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budz_feeds_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budz_feeds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_events`
--
ALTER TABLE `business_events`
  ADD CONSTRAINT `business_events_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_languages`
--
ALTER TABLE `business_languages`
  ADD CONSTRAINT `business_languages_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_languages_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_reviews`
--
ALTER TABLE `business_reviews`
  ADD CONSTRAINT `business_reviews_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_reviews_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_review_attachments`
--
ALTER TABLE `business_review_attachments`
  ADD CONSTRAINT `business_review_attachments_business_review_id_foreign` FOREIGN KEY (`business_review_id`) REFERENCES `business_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_review_attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_review_replies`
--
ALTER TABLE `business_review_replies`
  ADD CONSTRAINT `business_review_replies_business_review_id_foreign` FOREIGN KEY (`business_review_id`) REFERENCES `business_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_review_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_review_reports`
--
ALTER TABLE `business_review_reports`
  ADD CONSTRAINT `business_review_reports_business_review_id_foreign` FOREIGN KEY (`business_review_id`) REFERENCES `business_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_review_reports_reported_by_foreign` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_shares`
--
ALTER TABLE `business_shares`
  ADD CONSTRAINT `business_shares_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_timings`
--
ALTER TABLE `business_timings`
  ADD CONSTRAINT `business_timings_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_user_ratings`
--
ALTER TABLE `business_user_ratings`
  ADD CONSTRAINT `business_user_ratings_rated_by_foreign` FOREIGN KEY (`rated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_user_ratings_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `business_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_user_ratings_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chat_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD CONSTRAINT `chat_users_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_users_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_settings`
--
ALTER TABLE `data_settings`
  ADD CONSTRAINT `data_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_likes`
--
ALTER TABLE `event_likes`
  ADD CONSTRAINT `event_likes_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_ratings`
--
ALTER TABLE `event_ratings`
  ADD CONSTRAINT `event_ratings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_reviews`
--
ALTER TABLE `event_reviews`
  ADD CONSTRAINT `event_reviews_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_review_attachments`
--
ALTER TABLE `event_review_attachments`
  ADD CONSTRAINT `event_review_attachments_event_review_id_foreign` FOREIGN KEY (`event_review_id`) REFERENCES `event_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_review_attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_ticket_pricings`
--
ALTER TABLE `event_ticket_pricings`
  ADD CONSTRAINT `event_ticket_pricings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_ticket_pricings_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_timings`
--
ALTER TABLE `event_timings`
  ADD CONSTRAINT `event_timings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_timings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_type_edits`
--
ALTER TABLE `event_type_edits`
  ADD CONSTRAINT `event_type_edits_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_type_edits_event_type_id_foreign` FOREIGN KEY (`event_type_id`) REFERENCES `event_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_type_edits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experties`
--
ALTER TABLE `experties`
  ADD CONSTRAINT `experties_exp_question_id_foreign` FOREIGN KEY (`exp_question_id`) REFERENCES `expertise_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `flaged_answers`
--
ALTER TABLE `flaged_answers`
  ADD CONSTRAINT `flaged_answers_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flaged_answers_flaged_user_id_foreign` FOREIGN KEY (`flaged_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flaged_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_followers`
--
ALTER TABLE `group_followers`
  ADD CONSTRAINT `group_followers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_followers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_invitations`
--
ALTER TABLE `group_invitations`
  ADD CONSTRAINT `group_invitations_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_invitations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_messages`
--
ALTER TABLE `group_messages`
  ADD CONSTRAINT `group_messages_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_message_likes`
--
ALTER TABLE `group_message_likes`
  ADD CONSTRAINT `group_message_likes_group_message_id_foreign` FOREIGN KEY (`group_message_id`) REFERENCES `group_messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_message_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journals`
--
ALTER TABLE `journals`
  ADD CONSTRAINT `journals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_events`
--
ALTER TABLE `journal_events`
  ADD CONSTRAINT `journal_events_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_events_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_event_attachments`
--
ALTER TABLE `journal_event_attachments`
  ADD CONSTRAINT `journal_event_attachments_journal_event_id_foreign` FOREIGN KEY (`journal_event_id`) REFERENCES `journal_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_event_attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_event_tags`
--
ALTER TABLE `journal_event_tags`
  ADD CONSTRAINT `journal_event_tags_journal_event_id_foreign` FOREIGN KEY (`journal_event_id`) REFERENCES `journal_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_event_tags_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_event_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_followings`
--
ALTER TABLE `journal_followings`
  ADD CONSTRAINT `journal_followings_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_followings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_like_dislikes`
--
ALTER TABLE `journal_like_dislikes`
  ADD CONSTRAINT `journal_like_dislikes_journal_event_id_foreign` FOREIGN KEY (`journal_event_id`) REFERENCES `journal_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_like_dislikes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_settings`
--
ALTER TABLE `journal_settings`
  ADD CONSTRAINT `journal_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_users`
--
ALTER TABLE `login_users`
  ADD CONSTRAINT `login_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `my_saves`
--
ALTER TABLE `my_saves`
  ADD CONSTRAINT `my_saves_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `my_saves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `my_save_settings`
--
ALTER TABLE `my_save_settings`
  ADD CONSTRAINT `my_save_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_from_user_foreign` FOREIGN KEY (`from_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_to_user_foreign` FOREIGN KEY (`to_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD CONSTRAINT `notification_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `admin_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `strain_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_pricings`
--
ALTER TABLE `product_pricings`
  ADD CONSTRAINT `product_pricings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_likes`
--
ALTER TABLE `question_likes`
  ADD CONSTRAINT `question_likes_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_shares`
--
ALTER TABLE `question_shares`
  ADD CONSTRAINT `question_shares_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reminder_settings`
--
ALTER TABLE `reminder_settings`
  ADD CONSTRAINT `reminder_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `search_counts`
--
ALTER TABLE `search_counts`
  ADD CONSTRAINT `search_counts_keyword_id_foreign` FOREIGN KEY (`keyword_id`) REFERENCES `searched_keywords` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shout_outs`
--
ALTER TABLE `shout_outs`
  ADD CONSTRAINT `shout_outs_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shout_outs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shout_out_likes`
--
ALTER TABLE `shout_out_likes`
  ADD CONSTRAINT `shout_out_likes_liked_by_foreign` FOREIGN KEY (`liked_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shout_out_likes_shout_out_id_foreign` FOREIGN KEY (`shout_out_id`) REFERENCES `shout_outs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shout_out_notifications`
--
ALTER TABLE `shout_out_notifications`
  ADD CONSTRAINT `shout_out_notifications_shout_out_id_foreign` FOREIGN KEY (`shout_out_id`) REFERENCES `shout_outs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shout_out_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shout_out_shares`
--
ALTER TABLE `shout_out_shares`
  ADD CONSTRAINT `shout_out_shares_shout_out_id_foreign` FOREIGN KEY (`shout_out_id`) REFERENCES `shout_outs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shout_out_shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shout_out_views`
--
ALTER TABLE `shout_out_views`
  ADD CONSTRAINT `shout_out_views_shout_out_id_foreign` FOREIGN KEY (`shout_out_id`) REFERENCES `shout_outs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shout_out_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strains`
--
ALTER TABLE `strains`
  ADD CONSTRAINT `strains_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `strain_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_images`
--
ALTER TABLE `strain_images`
  ADD CONSTRAINT `strain_images_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_image_flags`
--
ALTER TABLE `strain_image_flags`
  ADD CONSTRAINT `strain_image_flags_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `strain_images` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_image_flags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_image_like_dislikes`
--
ALTER TABLE `strain_image_like_dislikes`
  ADD CONSTRAINT `strain_image_like_dislikes_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `strain_images` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_image_like_dislikes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_likes`
--
ALTER TABLE `strain_likes`
  ADD CONSTRAINT `strain_likes_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_ratings`
--
ALTER TABLE `strain_ratings`
  ADD CONSTRAINT `strain_ratings_rated_by_foreign` FOREIGN KEY (`rated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_ratings_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_ratings_strain_review_id_foreign` FOREIGN KEY (`strain_review_id`) REFERENCES `strain_reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_reviews`
--
ALTER TABLE `strain_reviews`
  ADD CONSTRAINT `strain_reviews_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_reviews_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_review_flags`
--
ALTER TABLE `strain_review_flags`
  ADD CONSTRAINT `strain_review_flags_flaged_by_foreign` FOREIGN KEY (`flaged_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_review_flags_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_review_flags_strain_review_id_foreign` FOREIGN KEY (`strain_review_id`) REFERENCES `strain_reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_review_images`
--
ALTER TABLE `strain_review_images`
  ADD CONSTRAINT `strain_review_images_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_review_images_strain_review_id_foreign` FOREIGN KEY (`strain_review_id`) REFERENCES `strain_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_review_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strain_survey_answers`
--
ALTER TABLE `strain_survey_answers`
  ADD CONSTRAINT `strain_survey_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `strain_survey_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_survey_answers_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `strain_survey_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_users`
--
ALTER TABLE `sub_users`
  ADD CONSTRAINT `sub_users_business_type_id_foreign` FOREIGN KEY (`business_type_id`) REFERENCES `business_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_user_images`
--
ALTER TABLE `sub_user_images`
  ADD CONSTRAINT `sub_user_images_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_user_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `support_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_searches`
--
ALTER TABLE `tag_searches`
  ADD CONSTRAINT `tag_searches_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_searches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_state_prices`
--
ALTER TABLE `tag_state_prices`
  ADD CONSTRAINT `tag_state_prices_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_state_prices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `used_tags`
--
ALTER TABLE `used_tags`
  ADD CONSTRAINT `used_tags_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `used_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `used_tags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activities_on_user_foreign` FOREIGN KEY (`on_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_experties`
--
ALTER TABLE `user_experties`
  ADD CONSTRAINT `user_experties_exp_id_foreign` FOREIGN KEY (`exp_id`) REFERENCES `experties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_experties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD CONSTRAINT `user_follows_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_group_settings`
--
ALTER TABLE `user_group_settings`
  ADD CONSTRAINT `user_group_settings_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_group_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_medical_conditions`
--
ALTER TABLE `user_medical_conditions`
  ADD CONSTRAINT `user_medical_conditions_medical_c_id_foreign` FOREIGN KEY (`medical_c_id`) REFERENCES `medical_conditions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_medical_conditions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_points`
--
ALTER TABLE `user_points`
  ADD CONSTRAINT `user_points_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD CONSTRAINT `user_posts_sub_user_id_foreign` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_attachments`
--
ALTER TABLE `user_post_attachments`
  ADD CONSTRAINT `user_post_attachments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_comments`
--
ALTER TABLE `user_post_comments`
  ADD CONSTRAINT `user_post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_comment_attachments`
--
ALTER TABLE `user_post_comment_attachments`
  ADD CONSTRAINT `user_post_comment_attachments_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `user_post_comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_flags`
--
ALTER TABLE `user_post_flags`
  ADD CONSTRAINT `user_post_comment_flags_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_comment_flags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_likes`
--
ALTER TABLE `user_post_likes`
  ADD CONSTRAINT `user_post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_muteds`
--
ALTER TABLE `user_post_muteds`
  ADD CONSTRAINT `user_post_muteds_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_muteds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_scrapes`
--
ALTER TABLE `user_post_scrapes`
  ADD CONSTRAINT `user_post_scrapes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_shares`
--
ALTER TABLE `user_post_shares`
  ADD CONSTRAINT `user_post_shares_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_shares_post_user_id_foreign` FOREIGN KEY (`post_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_post_tageds`
--
ALTER TABLE `user_post_tageds`
  ADD CONSTRAINT `user_post_tageds_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `user_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_post_tageds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD CONSTRAINT `user_reviews_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_specializations`
--
ALTER TABLE `user_specializations`
  ADD CONSTRAINT `user_specializations_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_specializations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_strains`
--
ALTER TABLE `user_strains`
  ADD CONSTRAINT `user_strains_strain_id_foreign` FOREIGN KEY (`strain_id`) REFERENCES `strains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_strains_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_strain_likes`
--
ALTER TABLE `user_strain_likes`
  ADD CONSTRAINT `user_strain_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_strain_likes_user_strain_id_foreign` FOREIGN KEY (`user_strain_id`) REFERENCES `user_strains` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD CONSTRAINT `user_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_tags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
