-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2026 at 07:26 PM
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
-- Database: `iep_skkb`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_logs`
--

CREATE TABLE `backup_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `backup_date` datetime NOT NULL,
  `backup_name` varchar(255) NOT NULL,
  `performed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backup_logs`
--

INSERT INTO `backup_logs` (`id`, `backup_date`, `backup_name`, `performed_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, '2026-06-28 17:53:14', 'iep_skkb_20260628_175314.json', 5, 'Backup created successfully.', '2026-06-28 09:53:14', '2026-06-28 09:53:14'),
(2, '2026-06-28 17:53:20', 'iep_skkb_20260628_175320.json', 5, 'Backup created successfully.', '2026-06-28 09:53:20', '2026-06-28 09:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `behaviour_records`
--

CREATE TABLE `behaviour_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `record_date` date NOT NULL,
  `behaviour_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reward_rule` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consent_letters`
--

CREATE TABLE `consent_letters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_ic` varchar(255) NOT NULL,
  `student_ic` varchar(255) DEFAULT NULL,
  `consent_date` date NOT NULL,
  `agreement_text` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consent_letters`
--

INSERT INTO `consent_letters` (`id`, `student_id`, `parent_name`, `parent_ic`, `student_ic`, `consent_date`, `agreement_text`, `status`, `created_at`, `updated_at`) VALUES
(6, 9, 'Mawarwiduri Binti Abdul Halik', '802104115324', '150125115061', '2026-06-30', 'I hereby agree with the implementation of the IEP as planned by the school.', 'Approved', '2026-06-30 03:27:09', '2026-06-30 03:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `case_title` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL DEFAULT 'Medium',
  `consultation_notes` text DEFAULT NULL,
  `support_plan` text DEFAULT NULL,
  `support_type` varchar(255) DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iep_goals`
--

CREATE TABLE `iep_goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `curriculum_followed` varchar(255) DEFAULT NULL,
  `iep_focus` varchar(255) DEFAULT NULL,
  `main_challenges` text DEFAULT NULL,
  `long_term_goals` text NOT NULL,
  `short_term_goals` text NOT NULL,
  `intervention_strategy` text DEFAULT NULL,
  `achievement` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'In Progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iep_reviews`
--

CREATE TABLE `iep_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `review_date` date NOT NULL,
  `review_status` varchar(255) NOT NULL DEFAULT 'Scheduled',
  `review_notes` text NOT NULL,
  `next_review_date` date DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `iep_reviews`
--

INSERT INTO `iep_reviews` (`id`, `student_id`, `review_date`, `review_status`, `review_notes`, `next_review_date`, `reviewed_by`, `created_at`, `updated_at`) VALUES
(5, 9, '2026-06-30', 'Completed', 'lbhgbjbj', NULL, 1, '2026-06-30 03:24:37', '2026-06-30 03:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_01_01_000001_create_users_table', 1),
(4, '2026_01_01_000002_create_students_table', 1),
(5, '2026_01_01_000003_create_iep_goals_table', 1),
(6, '2026_01_01_000004_create_behaviour_records_table', 1),
(7, '2026_01_01_000005_create_progress_records_table', 1),
(8, '2026_01_01_000006_create_consultations_table', 1),
(9, '2026_01_01_000006_create_reviews_table', 1),
(10, '2026_01_01_000007_create_iep_reviews_table', 1),
(11, '2026_01_01_000008_create_consent_letters_table', 1),
(12, '2026_01_01_000008_create_system_notifications_table', 1),
(13, '2026_01_01_000009_create_notifications_table', 1),
(14, '2026_01_01_000010_create_backup_logs_table', 1),
(15, '2026_06_23_000011_add_parent_registration_fields_to_users_table', 2),
(16, '2026_06_23_000012_add_assignment_details_to_students_table', 2),
(17, '2026_07_03_000013_add_reward_rule_to_behaviour_records_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Welcome', 'IEP Management System SKKB is ready to use.', 0, '2026-06-15 19:02:59', '2026-06-15 19:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `progress_records`
--

CREATE TABLE `progress_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `progress_date` date NOT NULL,
  `progress_status` varchar(255) NOT NULL,
  `progress_notes` text NOT NULL,
  `positive_updates` int(11) NOT NULL DEFAULT 0,
  `need_monitoring` int(11) NOT NULL DEFAULT 0,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `review_date` date NOT NULL,
  `review_status` varchar(255) NOT NULL,
  `review_notes` text NOT NULL,
  `next_review_date` date DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_code` varchar(255) NOT NULL DEFAULT 'TBA 5001',
  `school_name` varchar(255) NOT NULL DEFAULT 'Sekolah Kebangsaan Kuala Berang',
  `student_name` varchar(255) NOT NULL,
  `student_ic` varchar(255) DEFAULT NULL,
  `class_name` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `programme_type` varchar(255) DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `existing_knowledge` text DEFAULT NULL,
  `student_ability` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `parent_phone` varchar(255) DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `parent_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `counsellor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `review_frequency` varchar(255) DEFAULT NULL,
  `assignment_notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `school_code`, `school_name`, `student_name`, `student_ic`, `class_name`, `gender`, `date_of_birth`, `category`, `programme_type`, `diagnosis`, `existing_knowledge`, `student_ability`, `address`, `parent_name`, `parent_phone`, `parent_email`, `parent_user_id`, `teacher_id`, `counsellor_id`, `review_frequency`, `assignment_notes`, `status`, `created_at`, `updated_at`) VALUES
(9, 'TBA 5001', 'Sekolah Kebangsaan Kuala Berang', 'Amir Bahari', '150125115061', '6 Bestari', 'Male', '2026-06-15', 'Speech Delay', NULL, NULL, NULL, NULL, NULL, 'Mawarwiduri Binti Abdul Halik', '+60136890521', 'nik7579@gmail.com', 10, NULL, NULL, NULL, NULL, 'Completed', '2026-06-30 03:24:18', '2026-06-30 03:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `system_notifications`
--

CREATE TABLE `system_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `identification_card` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `phone`, `identification_card`, `address`, `role`, `password`, `profile_picture`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN0001', 'GPK PPKI SK Kuala Berang', 'admin@skkb.edu.my', NULL, NULL, NULL, 'school_admin', '$2y$12$rUmSYzey1WO1nvTz.nI9kuS8tBUkqcdtl7yXWQprVN2kdVav/zgVy', 'uploads/profiles/5c0a5aa2-ab8c-46cf-ab5c-b4e13b9e6dc3.jpeg', 'Active', NULL, '2026-06-15 19:02:58', '2026-06-25 03:22:30'),
(2, 'TEACHER001', 'Pn Azizah Binti Said', 'teacher@skkb.edu.my', NULL, NULL, NULL, 'teacher', '$2y$12$qQ.rBuwyx8phlEV0/y.g7.LRV8qGmPZKCXSDgZYrS1ipwWF6SeDxG', 'uploads/profiles/b568f336-adf9-47bb-9c92-c33aaa602a94.jpg', 'Active', NULL, '2026-06-15 19:02:58', '2026-06-30 02:57:51'),
(3, 'COUNSELLOR001', 'Pn Rohaya Binti Wahab', 'counsellor@skkb.edu.my', NULL, NULL, NULL, 'counsellor', '$2y$12$xhio6VtjfA.VoKDxgybDXOzGlB86nkMEcMnQHGFRcM1KiwMCtROsW', NULL, 'Active', NULL, '2026-06-15 19:02:58', '2026-06-15 19:02:58'),
(5, 'SYSADMIN001', 'System Administrator', 'sysadmin@skkb.edu.my', NULL, NULL, NULL, 'system_admin', '$2y$12$ZIoKyEfL3c5UkTqVNBIHz.bL9nKTbmjFQquhnHj.A4JwshiAIUsZi', NULL, 'Active', NULL, '2026-06-15 19:02:58', '2026-06-15 19:02:58'),
(7, 'TEACHER002', 'Nurbatrisya', 'nurbatrisyaqhairanee@kpm.edu.my', '01140357140', '060912102398', 'SEMENYIH', 'teacher', '$2y$12$rdMUgFZolKpEqqt/vncxA.SN2CKN1l9P4k9Czg/SRDwwCPry5nPtG', NULL, 'Active', NULL, '2026-06-25 03:17:32', '2026-06-25 03:17:32'),
(10, 'PARENT0001', 'Mawarwiduri Binti Abdul Halik', 'nik7579@gmail.com', '+60136890521', '802104115324', 'Lot 2016,Kampung Tok Randok,Ajil,Hulu Terengganu,Terengganu', 'parent', '$2y$12$nv3hWFh7NFjxtpzEXb3oCe9803Bvp2Xw9hwFDg0wzgUvH7slZ55rm', NULL, 'Active', NULL, '2026-06-30 03:26:33', '2026-06-30 03:26:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup_logs`
--
ALTER TABLE `backup_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `backup_logs_performed_by_foreign` (`performed_by`);

--
-- Indexes for table `behaviour_records`
--
ALTER TABLE `behaviour_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `behaviour_records_student_id_foreign` (`student_id`),
  ADD KEY `behaviour_records_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `consent_letters`
--
ALTER TABLE `consent_letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consent_letters_student_id_foreign` (`student_id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_student_id_foreign` (`student_id`),
  ADD KEY `consultations_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `iep_goals`
--
ALTER TABLE `iep_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iep_goals_student_id_foreign` (`student_id`);

--
-- Indexes for table `iep_reviews`
--
ALTER TABLE `iep_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iep_reviews_student_id_foreign` (`student_id`),
  ADD KEY `iep_reviews_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `progress_records`
--
ALTER TABLE `progress_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `progress_records_student_id_foreign` (`student_id`),
  ADD KEY `progress_records_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_student_id_foreign` (`student_id`),
  ADD KEY `reviews_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_parent_user_id_foreign` (`parent_user_id`),
  ADD KEY `students_teacher_id_foreign` (`teacher_id`),
  ADD KEY `students_counsellor_id_foreign` (`counsellor_id`);

--
-- Indexes for table `system_notifications`
--
ALTER TABLE `system_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `users_identification_card_unique` (`identification_card`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup_logs`
--
ALTER TABLE `backup_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `behaviour_records`
--
ALTER TABLE `behaviour_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `consent_letters`
--
ALTER TABLE `consent_letters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iep_goals`
--
ALTER TABLE `iep_goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `iep_reviews`
--
ALTER TABLE `iep_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `progress_records`
--
ALTER TABLE `progress_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `system_notifications`
--
ALTER TABLE `system_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `backup_logs`
--
ALTER TABLE `backup_logs`
  ADD CONSTRAINT `backup_logs_performed_by_foreign` FOREIGN KEY (`performed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `behaviour_records`
--
ALTER TABLE `behaviour_records`
  ADD CONSTRAINT `behaviour_records_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `behaviour_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consent_letters`
--
ALTER TABLE `consent_letters`
  ADD CONSTRAINT `consent_letters_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `consultations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `iep_goals`
--
ALTER TABLE `iep_goals`
  ADD CONSTRAINT `iep_goals_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `iep_reviews`
--
ALTER TABLE `iep_reviews`
  ADD CONSTRAINT `iep_reviews_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `iep_reviews_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `progress_records`
--
ALTER TABLE `progress_records`
  ADD CONSTRAINT `progress_records_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `progress_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_counsellor_id_foreign` FOREIGN KEY (`counsellor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_parent_user_id_foreign` FOREIGN KEY (`parent_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `system_notifications`
--
ALTER TABLE `system_notifications`
  ADD CONSTRAINT `system_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
