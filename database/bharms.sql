-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2025 at 06:58 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bharms`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `appointment_type` enum('General Check-up','Maternal Check-up','Vaccination','Doctor Consultation','Midwife Consultation') COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_status` enum('Pending','Approved','Rejected','Completed','Cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `staff_id`, `appointment_type`, `appointment_date`, `appointment_time`, `appointment_status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'General Check-up', '2025-11-25', '08:30:00', 'Rejected', 'My head is aching.', '2025-11-13 23:28:10', '2025-11-14 12:38:56'),
(2, 1, NULL, 'Vaccination', '2026-01-08', '16:50:00', 'Cancelled', 'I am sick', '2025-11-14 16:04:04', '2025-11-14 16:24:34'),
(3, 1, NULL, 'General Check-up', '2025-11-27', '10:00:00', 'Rejected', 'i am sick', '2025-11-14 16:43:22', '2025-11-14 16:46:59'),
(4, 4, NULL, 'Maternal Check-up', '2025-11-21', '11:20:00', 'Pending', 'Maternal', '2025-11-14 17:20:34', '2025-11-14 17:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PRC_expiry` date DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `specialization`, `license_number`, `PRC_expiry`, `contact_number`, `address`, `created_at`, `updated_at`) VALUES
(1, 6, 'Test', NULL, 'Doctor', 'General Medicine', 'DOC123', NULL, '1234567890', NULL, '2025-11-14 13:27:27', '2025-11-14 13:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

CREATE TABLE `medical_history` (
  `history_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `known_conditions` text COLLATE utf8mb4_unicode_ci,
  `allergies` text COLLATE utf8mb4_unicode_ci,
  `current_medications` text COLLATE utf8mb4_unicode_ci,
  `previous_hospitalization` text COLLATE utf8mb4_unicode_ci,
  `family_history` text COLLATE utf8mb4_unicode_ci,
  `immunization_status` enum('Complete','Incomplete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Incomplete',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_history`
--

INSERT INTO `medical_history` (`history_id`, `patient_id`, `known_conditions`, `allergies`, `current_medications`, `previous_hospitalization`, `family_history`, `immunization_status`, `remarks`, `last_updated`, `created_at`, `updated_at`) VALUES
(1, 1, 'Asthma', 'Shrimp', NULL, NULL, NULL, 'Incomplete', NULL, '2025-11-15 00:11:26', '2025-11-13 22:08:32', '2025-11-14 16:11:26'),
(3, 3, NULL, NULL, NULL, NULL, NULL, 'Incomplete', NULL, '2025-11-14 17:44:13', '2025-11-14 09:44:13', '2025-11-14 09:44:13'),
(4, 4, 'Asthma', 'Shrimp', NULL, NULL, NULL, 'Incomplete', NULL, '2025-11-15 01:16:46', '2025-11-14 17:15:15', '2025-11-14 17:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `midwives`
--

CREATE TABLE `midwives` (
  `midwife_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PRC_expiry` date DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `midwives`
--

INSERT INTO `midwives` (`midwife_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `license_number`, `PRC_expiry`, `contact_number`, `address`, `created_at`, `updated_at`) VALUES
(1, 6, 'Test', NULL, 'Midwife', 'MID123', NULL, '1234567890', NULL, '2025-11-14 13:27:41', '2025-11-14 13:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '2014_10_12_000000_create_users_table', 1),
(22, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(25, '2025_11_05_114252_create_patients_table', 1),
(26, '2025_11_05_114853_create_medical_history_table', 1),
(27, '2025_11_06_071404_add_verify_token_to_users_table', 1),
(28, '2025_11_11_210355_add_verification_pin_to_users_table', 2),
(31, '2025_11_12_133318_add_verification_pin_to_users_table', 3),
(32, '2025_11_14_000030_make_address_nullable_in_patients_table', 3),
(33, '2025_11_14_130000_create_appointments_table', 4),
(40, '2025_11_14_211848_create_staff_table', 5),
(41, '2025_11_14_211903_create_doctors_table', 5),
(42, '2025_11_14_211916_create_midwives_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `civil_status` enum('Single','Married','Widowed','Separated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Single',
  `address` text COLLATE utf8mb4_unicode_ci,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relationship_to_patient` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_source` enum('Clinic','Online') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Online',
  `created_by_staff` bigint UNSIGNED DEFAULT NULL,
  `record_status` enum('Active','Archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `sex`, `birth_date`, `civil_status`, `address`, `contact_number`, `emergency_contact_name`, `emergency_contact_number`, `relationship_to_patient`, `registration_source`, `created_by_staff`, `record_status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Rodeliza', NULL, 'La Rosa', 'Female', '2002-09-20', 'Single', 'Osmeña St., Purok Burbos', '09917940262', 'Sheba La Rosa', '09876543219', 'Parent', 'Online', NULL, 'Active', '2025-11-13 17:20:07', '2025-11-14 09:18:21'),
(3, 4, 'Ahlde', NULL, 'Geonzon', 'Female', '2001-08-30', 'Single', 'Osmeña St., Purok Burbos', '09917940262', 'Myrna', '09876543215', 'Parent', 'Online', NULL, 'Active', '2025-11-14 09:23:38', '2025-11-14 09:44:13'),
(4, 8, 'Diovely', NULL, 'Campo', 'Female', '2004-04-08', 'Single', 'Osmeña St., Purok Burbos', '09917940262', 'John Lloyd Noya', '09876543211', 'Parent', 'Online', NULL, 'Active', '2025-11-14 17:10:55', '2025-11-14 17:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `position` enum('Health Worker','Barangay Nurse') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `sex`, `birth_date`, `position`, `contact_number`, `address`, `created_at`, `updated_at`) VALUES
(1, 7, 'Rasheed', NULL, 'Tapales', 'Male', '2004-06-11', 'Health Worker', '09917940262', 'Osmeña St., Purok Burbos', '2025-11-14 14:49:35', '2025-11-14 14:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('patient','staff','doctor','midwife') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'patient',
  `email_verified` tinyint NOT NULL DEFAULT '0',
  `status` enum('Active','Pending','Disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `verify_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_pin` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin_created_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `email_verified`, `status`, `verify_token`, `verification_pin`, `pin_created_at`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'rodeliza.1020@gmail.com', '$2y$10$nltLsOOyru8srITqh8DQbuC8SQzohVQFMXc.URlP9S/OvxDOd8IGG', 'patient', 0, 'Pending', '93NQJP1HD2bfN8nb0XWuOc0VWM45iEhE6k2hPLz5hkGqEJbOfk', '539215', '2025-11-13 16:09:16', NULL, NULL, '2025-11-13 16:05:38', '2025-11-13 16:05:38'),
(2, 'rodeliza.2222@gmail.com', '$2y$10$U9oG7UFvQUcDaTOMxXBEUeaAIczjqUXlfxcHKXeoqUpqNBSHv.SCq', 'patient', 1, 'Active', NULL, NULL, NULL, NULL, NULL, '2025-11-13 17:20:07', '2025-11-13 17:21:54'),
(4, 'ahldegeonzon30@gmail.com', '$2y$10$g2yldQhImTeJeS5HBrb/TOSC.3hXw8vTix/bFBgaMllle0Z7jFLCC', 'patient', 1, 'Active', NULL, NULL, NULL, NULL, NULL, '2025-11-14 09:23:38', '2025-11-14 09:24:29'),
(5, 'rodeliza@gmail.com', '$2y$10$ic8KD9pDzX322q59PnJLfuoOt6YElMI.X.c1lgqnwiM21.mykTMau', 'staff', 1, 'Active', NULL, NULL, NULL, NULL, NULL, '2025-11-14 18:34:30', '2025-11-14 18:34:30'),
(6, 'teststaff@example.com', '$2y$10$zBlBGK3csYZKzSEv3fQRIe1nXzin47960kQtc5WKpYS6UM6dg4cd2', 'staff', 1, 'Active', NULL, NULL, NULL, NULL, NULL, '2025-11-14 13:25:26', '2025-11-14 13:25:26'),
(7, 'tapalesrasheed123@gmail.com', '$2y$10$./WBffgOx0qDsHTP.z0Po.IRcX83OOpwBVM0G54.iTS8H0asccKla', 'staff', 1, 'Active', NULL, NULL, NULL, NULL, NULL, '2025-11-14 14:49:34', '2025-11-14 14:49:34'),
(8, 'rodeliza.2002@gmail.com', '$2y$10$vm/OjqdOidAdNWixb8sZH.3G8VlkRlvuchcXWgsVMu0QJZ6a7vkUC', 'patient', 1, 'Active', NULL, NULL, NULL, NULL, NULL, '2025-11-14 17:10:55', '2025-11-14 17:12:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `medical_history_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `midwives`
--
ALTER TABLE `midwives`
  ADD PRIMARY KEY (`midwife_id`),
  ADD KEY `midwives_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`),
  ADD KEY `patients_first_name_last_name_birth_date_index` (`first_name`,`last_name`,`birth_date`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `staff_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_history`
--
ALTER TABLE `medical_history`
  MODIFY `history_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `midwives`
--
ALTER TABLE `midwives`
  MODIFY `midwife_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD CONSTRAINT `medical_history_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `midwives`
--
ALTER TABLE `midwives`
  ADD CONSTRAINT `midwives_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
