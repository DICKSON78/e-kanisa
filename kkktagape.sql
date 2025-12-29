-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 08, 2025 at 01:31 PM
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
-- Database: `kkktagape`
--

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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `expected_attendance` int(11) DEFAULT NULL,
  `actual_attendance` int(11) DEFAULT NULL,
  `budget` decimal(15,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_category_id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `payee` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Nauli -Bible Study', 'Nauli za Bible Study', 1, 1, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(2, 'Posho -Mwinjilisti', 'Posho ya Mwinjilisti', 1, 2, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(3, 'Posho Mhudumu', 'Posho ya Mhudumu', 1, 3, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(4, 'Posho -Wahubiri', 'Posho ya Wahubiri', 1, 4, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(5, 'Posho Mlinzi', 'Posho ya Mlinzi', 1, 5, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(6, 'Posho Mbalimbali', 'Posho mbalimbali', 1, 6, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(7, 'Posho -Mwl K/kuu', 'Posho ya Mwalimu Kanisa Kuu', 1, 7, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(8, 'Posho-Mwl K/Vijana', 'Posho ya Mwalimu Kanisa Vijana', 1, 8, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(9, 'Nauli-Bank', 'Nauli za kwenda benki', 1, 9, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(10, 'Nauli Ubebaji Vyombo', 'Nauli za ubebaji wa vyombo', 1, 10, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(11, 'Nauli mbalimbali', 'Nauli mbalimbali', 1, 11, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(12, 'Maji kunywa/usafi/Chakula', 'Maji ya kunywa, usafi na chakula', 1, 12, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(13, 'Matumizi -Mtaa', 'Matumizi ya mtaa', 1, 13, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(14, '8% ya Jimbo', '8% ya mapato yanayotolewa kwa Jimbo', 1, 14, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(15, 'Umeme', 'Gharama za umeme', 1, 15, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(16, 'Pango la ofisi', 'Pango la ofisi', 1, 16, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(17, 'Stationery', 'Vifaa vya ofisi', 1, 17, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(18, 'Matumizi mengineyo', 'Matumizi mengine mbalimbali', 1, 18, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(19, 'Huduma za Kichungaji', 'Huduma za kichungaji', 1, 19, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(20, 'Vikao/Semina/kongamano', 'Vikao, semina na kongamano', 1, 20, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(21, 'Marejesho-mkopo', 'Marejesho ya mikopo', 1, 21, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(22, 'Mkesha', 'Gharama za mkesha', 1, 22, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(23, 'Ujenzi', 'Gharama za ujenzi', 1, 23, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(24, 'Ujenzi -Ofisi ya Jimbo', 'Ujenzi wa ofisi ya Jimbo', 1, 24, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(25, 'Ununuzi wa viti', 'Ununuzi wa viti', 1, 25, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(26, 'mikaeli na watoto', 'Mikaeli na watoto', 1, 26, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(27, 'Tamasha vijana', 'Tamasha la vijana', 1, 27, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(28, 'Gharama ya majoho', 'Gharama za majoho', 1, 28, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(29, 'Ujenzi madhabahu', 'Ujenzi wa madhabahu', 1, 29, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(30, 'Bango', 'Gharama za bango', 1, 30, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(31, 'Ununuzi vyombo vya muziki', 'Ununuzi wa vyombo vya muziki', 1, 31, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(32, 'Watoto-safari', 'Safari za watoto', 1, 32, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(33, 'Kwaya kuu', 'Gharama za kwaya kuu', 1, 33, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(34, 'Wahitaji', 'Msaada kwa wahitaji', 1, 34, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(35, 'Posho store keeper', 'Posho ya store keeper', 1, 35, '2025-11-29 08:29:43', '2025-11-29 08:29:43');

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
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `income_category_id` bigint(20) UNSIGNED NOT NULL,
  `collection_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income_categories`
--

CREATE TABLE `income_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_categories`
--

INSERT INTO `income_categories` (`id`, `code`, `name`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'M0001', 'SADAKA YA MWAKA MPYA', 'Sadaka ya mwaka mpya', 1, 1, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(2, 'M0002', 'SHUKRANI YA WIKI (kawaida) na colect', 'Shukrani ya wiki ya kawaida na collection', 1, 2, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(3, 'M0003', 'SADAKA YA AHADI', 'Sadaka ya ahadi', 1, 3, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(4, 'M0004', 'SHULE YA JUMAPILI', 'Sadaka ya shule ya jumapili', 1, 4, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(5, 'M0005', 'SADAKA YA MAVUNO', 'Sadaka ya mavuno', 1, 5, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(6, 'M0006', 'SADAKA YA PASAKA/kupaa', 'Sadaka ya Pasaka na kupaa', 1, 6, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(7, 'M0007', 'SADAKA YA SHUKRANI AINA ZOTE', 'Sadaka ya shukrani aina zote', 1, 7, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(8, 'M0008', 'SADAKA YA UBATIZO', 'Sadaka ya ubatizo', 1, 8, '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(9, 'M0009', 'SHUKRANI YA KIPAIMARA', 'Shukrani ya kipaimara', 1, 9, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(10, 'M0010', 'SHUKRANI YA NDOA', 'Shukrani ya ndoa', 1, 10, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(11, 'M0011', 'SADAKA FUNGU LA KUMI', 'Sadaka fungu la kumi (Zaka)', 1, 11, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(12, 'M0012', 'SHUKRANI YA CCB', 'Shukrani ya CCB (Chama cha Biblia)', 1, 12, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(13, 'M0013', 'SADAKA YA JENGO', 'Sadaka ya ujenzi wa jengo', 1, 13, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(14, 'M0014', 'MICHANGO MBALIMBALI', 'Michango mbalimbali', 1, 14, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(15, 'M0015', 'SADAKA YA NYUMBA KWA NYUMBA', 'Sadaka ya nyumba kwa nyumba', 1, 15, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(16, 'M0016', 'SADAKA YA MORNING & EVENING GLORY', 'Sadaka ya Morning & Evening Glory', 1, 16, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(17, 'M0017', 'HARAMBEE na mnada', 'Harambee na mnada', 1, 17, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(18, 'M0018', 'SADAKA YA MFUKO WA ELIMU', 'Sadaka ya mfuko wa elimu', 1, 18, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(19, 'M0019', 'SADAKA MAALUM- MAKAO MAKUU, VIJANA, KAZI ZA MISIONI,AKINA MAMA, VYAMA VYA INJILI, MSAMARIA MWEMA', 'Sadaka maalum kwa Makao Makuu, Vijana, Kazi za Misioni, Akina Mama, Vyama vya Injili, Msamaria Mwema', 1, 19, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(20, 'M0020', 'SADAKA ZA KAZI ZA UMOJA _JIMBO NA DAYOSISI', 'Sadaka za kazi za umoja wa Jimbo na Dayosisi', 1, 20, '2025-11-29 08:29:43', '2025-11-29 08:29:43'),
(21, 'M0021', 'SADAKA YA KRISMAS', 'Sadaka ya Krismas', 1, 21, '2025-11-29 08:29:43', '2025-11-29 08:29:43');

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
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_number` varchar(255) NOT NULL,
  `envelope_number` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Mme','Mke') DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `house_number` varchar(255) DEFAULT NULL,
  `block_number` varchar(255) DEFAULT NULL,
  `neighbor_name` varchar(255) DEFAULT NULL,
  `neighbor_phone` varchar(255) DEFAULT NULL,
  `church_elder` varchar(255) DEFAULT NULL,
  `pledge_number` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `baptism_date` date DEFAULT NULL,
  `confirmation_date` date DEFAULT NULL,
  `membership_date` date DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `spouse_phone` varchar(255) DEFAULT NULL,
  `children_info` text DEFAULT NULL COMMENT 'JSON field for children names and ages',
  `special_group` varchar(255) DEFAULT NULL,
  `ministry_groups` text DEFAULT NULL COMMENT 'JSON array of ministries: Kwaya, Fellowship, etc',
  `id_number` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_29_111313_create_roles_table', 1),
(5, '2025_11_29_111319_create_members_table', 1),
(6, '2025_11_29_111323_create_income_categories_table', 1),
(7, '2025_11_29_111327_create_expense_categories_table', 1),
(8, '2025_11_29_111330_create_incomes_table', 1),
(9, '2025_11_29_111337_create_expenses_table', 1),
(10, '2025_11_29_111346_create_requests_table', 1),
(11, '2025_11_29_111352_create_events_table', 1),
(12, '2025_11_29_111355_create_settings_table', 1),
(13, '2025_11_29_111358_add_role_id_to_users_table', 1),
(14, '2025_11_29_202933_add_special_group_to_members_table', 2),
(15, '2025_11_30_092650_add_envelope_and_additional_fields_to_members_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_number` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `department` varchar(255) NOT NULL,
  `amount_requested` decimal(15,2) NOT NULL,
  `amount_approved` decimal(15,2) DEFAULT NULL,
  `status` enum('Inasubiri','Imeidhinishwa','Imekataliwa') NOT NULL DEFAULT 'Inasubiri',
  `approval_notes` text DEFAULT NULL,
  `requested_date` date NOT NULL,
  `approved_date` date DEFAULT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Mwanachama', 'mwanachama', 'Church Member - Limited view-only permissions', '[\"view_dashboard\",\"view_events\",\"view_own_profile\",\"update_own_profile\"]', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(2, 'Mhasibu', 'mhasibu', 'Accountant - Full financial management permissions', '[\"view_dashboard\",\"view_analytics\",\"view_incomes\",\"create_incomes\",\"update_incomes\",\"delete_incomes\",\"export_incomes\",\"view_expenses\",\"create_expenses\",\"update_expenses\",\"delete_expenses\",\"export_expenses\",\"view_income_categories\",\"create_income_categories\",\"update_income_categories\",\"delete_income_categories\",\"view_expense_categories\",\"create_expense_categories\",\"update_expense_categories\",\"delete_expense_categories\",\"view_financial_reports\",\"generate_financial_reports\",\"export_financial_reports\",\"view_requests\",\"create_requests\",\"update_requests\",\"view_events\",\"view_members\",\"view_own_profile\",\"update_own_profile\"]', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(3, 'Mchungaji', 'mchungaji', 'Pastor - Full administrative permissions for everything', '[\"view_dashboard\",\"view_analytics\",\"view_incomes\",\"create_incomes\",\"update_incomes\",\"delete_incomes\",\"export_incomes\",\"view_expenses\",\"create_expenses\",\"update_expenses\",\"delete_expenses\",\"export_expenses\",\"view_income_categories\",\"create_income_categories\",\"update_income_categories\",\"delete_income_categories\",\"view_expense_categories\",\"create_expense_categories\",\"update_expense_categories\",\"delete_expense_categories\",\"view_financial_reports\",\"generate_financial_reports\",\"export_financial_reports\",\"view_members\",\"create_members\",\"update_members\",\"delete_members\",\"export_members\",\"view_users\",\"create_users\",\"update_users\",\"delete_users\",\"view_roles\",\"create_roles\",\"update_roles\",\"delete_roles\",\"view_events\",\"create_events\",\"update_events\",\"delete_events\",\"view_requests\",\"create_requests\",\"update_requests\",\"delete_requests\",\"approve_requests\",\"reject_requests\",\"view_settings\",\"update_settings\",\"access_system_settings\",\"view_audit_logs\",\"manage_backup\",\"view_own_profile\",\"update_own_profile\"]', '2025-11-29 08:29:42', '2025-11-29 08:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('g2b1KlbIxBwXQkm0lqOHaJlkY34p3ltvsSp7tX8x', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibnlabUhHbERyYmphektnY2ZGU2hGck5YWXJiRm8ycEpoWDR0U1FYUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wYW5lbC9leHBvcnQtZXhjZWwva2l3YW5qYT9zdGF0dXM9cGFpZCI7czo1OiJyb3V0ZSI7czoyMDoiZXhwb3J0LmV4Y2VsLmtpd2FuamEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1765196976),
('zaHKW0d6HD53sNizrPjbsPEhkBe86q5TUT3lHIVb', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidHBmQXRwZWdmUHNVbXdZSzQ4M0JuZDcydVFoTGxYSWpmdUlOdG55biI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wYW5lbC9tZW1iZXJzIjtzOjU6InJvdXRlIjtzOjEzOiJtZW1iZXJzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1764498604);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `created_at`, `updated_at`) VALUES
(1, 'church_name', 'KANISA LA KIINJILI LA KILUTHERI TANZANIA', 'text', 'church_info', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(2, 'diocese', 'DAYOSISI YA MASHARIKI NA PWANI', 'text', 'church_info', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(3, 'district', 'JIMBO LA MAGHARIBI', 'text', 'church_info', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(4, 'parish', 'USHARIKA WA MAKABE', 'text', 'church_info', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(5, 'mtaa', 'MTAA WA AGAPE', 'text', 'church_info', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(6, 'church_full_name', 'KANISA LA KIINJILI LA KILUTHERI TANZANIA - MTAA WA AGAPE', 'text', 'church_info', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(7, 'address', 'Dar es Salaam, Tanzania', 'text', 'contact', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(8, 'phone', '+255 000 000 000', 'text', 'contact', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(9, 'email', 'info@agapekanisa.or.tz', 'email', 'contact', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(10, 'website', 'www.agapekanisa.or.tz', 'url', 'contact', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(11, 'diocese_percentage', '8', 'number', 'financial', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(12, 'currency', 'TZS', 'text', 'financial', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(13, 'currency_symbol', 'Tsh', 'text', 'financial', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(14, 'timezone', 'Africa/Dar_es_Salaam', 'text', 'system', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(15, 'date_format', 'd/m/Y', 'text', 'system', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(16, 'time_format', 'H:i', 'text', 'system', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(17, 'language', 'sw', 'text', 'system', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(18, 'email_notifications', '1', 'boolean', 'notifications', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(19, 'sms_notifications', '0', 'boolean', 'notifications', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(20, 'financial_year_start', '01-01', 'text', 'reports', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(21, 'report_logo', '', 'image', 'reports', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(22, 'sunday_service_time', '09:00', 'time', 'services', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(23, 'midweek_service_time', '18:00', 'time', 'services', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(24, 'bible_study_day', 'Jumatano', 'text', 'services', '2025-11-29 08:29:42', '2025-11-29 08:29:42'),
(25, 'bible_study_time', '18:00', 'time', 'services', '2025-11-29 08:29:42', '2025-11-29 08:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `remember_token`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'Admin Kanisa', 'admin@kanisa.org', '2025-11-29 08:29:43', '$2y$12$TUBoNHrUEXR4H3bFrM11fu9roZxA4Cm3I.iKIJ1KWr2neWRk51y/G', 1, NULL, '2025-12-08 08:35:47', '2025-11-29 08:29:43', '2025-12-08 08:35:47'),
(2, 2, 'Mhasibu Kanisa', 'mhasibu@kanisa.org', '2025-11-29 08:29:44', '$2y$12$VcUK5.KsLs3wLhGFTBr3D.SgcqQrEx3khcLuFo9p3o9W/NLxo/Gbi', 1, NULL, NULL, '2025-11-29 08:29:44', '2025-11-29 08:29:44'),
(3, 1, 'Mwanachama Kanisa', 'member@kanisa.org', '2025-11-29 08:29:44', '$2y$12$l2p18nMcM7DWACCTdIaADeNRp3RIeTXB2QWkOBmWcN5K5W86DeIcq', 1, NULL, NULL, '2025-11-29 08:29:44', '2025-11-29 08:29:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_created_by_foreign` (`created_by`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expenses_expense_category_id_year_month_unique` (`expense_category_id`,`year`,`month`),
  ADD KEY `expenses_created_by_foreign` (`created_by`),
  ADD KEY `expenses_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_income_category_id_foreign` (`income_category_id`),
  ADD KEY `incomes_member_id_foreign` (`member_id`),
  ADD KEY `incomes_created_by_foreign` (`created_by`),
  ADD KEY `incomes_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `income_categories`
--
ALTER TABLE `income_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `income_categories_code_unique` (`code`);

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
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_member_number_unique` (`member_number`),
  ADD UNIQUE KEY `members_envelope_number_unique` (`envelope_number`),
  ADD KEY `members_user_id_foreign` (`user_id`);

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
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `requests_request_number_unique` (`request_number`),
  ADD KEY `requests_requested_by_foreign` (`requested_by`),
  ADD KEY `requests_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_categories`
--
ALTER TABLE `income_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incomes_income_category_id_foreign` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incomes_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `incomes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
