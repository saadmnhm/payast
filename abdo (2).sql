-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 24 nov. 2025 à 12:15
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `abdo`
--

-- --------------------------------------------------------

--
-- Structure de la table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `brands`
--

INSERT INTO `brands` (`id`, `label`, `image`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'brembo', 'brands/YpszX65s49yEmTg07z9ts4SH3waK61oRWy8H3AFH.png', 1, '2025-11-04 09:30:46', '2025-11-21 08:05:55', '2025-11-21 08:05:55'),
(2, 'bochaaaaaaaaaa', 'brands/m3H0mmksOI4pK4oE2eKc0che9vImXzw5XpxWArK5.png', 1, '2025-11-04 13:05:42', '2025-11-21 08:16:14', NULL),
(3, 'sssssss', 'brands/eLSFYFsGKQDN2AQN7y1N5B6Nmd6Z5OoYswQeGLYA.png', 1, '2025-11-04 13:43:10', '2025-11-21 08:16:24', NULL),
(4, 'total', 'brands/5eMAYaBWEMr9EU1Q7yx7NofsIq1UOlOx9R1YoUXd.jpg', 1, '2025-11-21 15:18:34', '2025-11-21 15:18:34', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `catalog_categories`
--

CREATE TABLE `catalog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `catalog_categories`
--

INSERT INTO `catalog_categories` (`id`, `title`, `slug`, `parent_id`, `order`, `icon`, `image`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mécanique', 'mecanique', NULL, 0, NULL, NULL, NULL, 1, '2025-11-24 09:24:55', '2025-11-24 09:24:55', NULL),
(2, 'Filtration', 'filtration', NULL, 0, NULL, NULL, NULL, 1, '2025-11-24 09:25:28', '2025-11-24 09:25:28', NULL),
(3, 'Filtre à air', 'filtre-a-air', 2, 0, NULL, NULL, NULL, 1, '2025-11-24 09:25:40', '2025-11-24 09:25:40', NULL),
(4, 'Filtre à huile', 'filtre-a-huile', 2, 0, NULL, NULL, NULL, 1, '2025-11-24 09:25:56', '2025-11-24 09:25:56', NULL),
(5, 'Batteries', 'batteries', NULL, 0, NULL, NULL, NULL, 1, '2025-11-24 09:27:03', '2025-11-24 09:27:03', NULL),
(6, 'Chargeur de batterie', 'chargeur-de-batterie', 5, 0, NULL, NULL, NULL, 1, '2025-11-24 09:27:09', '2025-11-24 09:27:09', NULL),
(7, 'Batterie', 'batterie', 5, 0, NULL, NULL, NULL, 1, '2025-11-24 09:27:23', '2025-11-24 09:27:23', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `constructeurs`
--

CREATE TABLE `constructeurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `constructeurs`
--

INSERT INTO `constructeurs` (`id`, `label`, `image`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'hyunday', 'constructeurs/b4pMZ9k03L97oChkrulKweh3c4IEzIUjn9VGQ9z6.png', 1, '2025-11-04 13:22:19', '2025-11-04 13:22:19', NULL),
(2, 'pg', 'constructeurs/hEWD2sQirjVWdN1hwGXiKAHUOMpEZOt8mtugr7Ub.png', 1, '2025-11-04 13:22:41', '2025-11-04 13:22:41', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
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
-- Structure de la table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gallery_media`
--

CREATE TABLE `gallery_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallery_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `original_size` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_compressed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_28_090500_add_login_fields_to_users_table', 1),
(6, '2023_06_12_013333_add_profile_photo_path_column_to_users_table', 1),
(7, '2024_07_01_100049_create_permission_tables', 1),
(8, '2025_04_11_100645_add_soft_delete_to_users_table', 1),
(9, '2025_04_11_102156_add_is_active_to_users_table', 1),
(10, '2025_04_11_105659_add_first_name_last_name_to_users_table', 1),
(11, '2025_04_11_112007_add_phone_to_users_table', 1),
(12, '2025_04_14_144140_create_blog_tables', 1),
(13, '2025_04_17_172154_add_role_to_users_table', 1),
(14, '2025_04_18_114610_create_contact_tables', 1),
(15, '2025_09_16_093138_create_galleries_table', 1),
(16, '2025_09_16_101930_remove_thumbnail_path_from_galleries_table', 1),
(17, '2025_09_16_103117_create_gallery_media_table', 1),
(18, '2025_09_16_103944_remove_old_file_columns_from_galleries_table', 1),
(19, '2025_09_16_103948_remove_old_file_columns_from_galleries_table', 1),
(20, '2025_11_04_090527_create_navigation_menus_table', 1),
(21, '2025_11_04_111020_create_brands_table', 1),
(22, '2025_11_04_144704_create_contsucteur_table', 1),
(23, '2025_11_21_094540_create_catalog_categories_table', 1),
(24, '2025_11_21_094545_create_pieces_table', 1),
(25, '2025_11_21_165015_add_brand_id_to_pieces_table', 1),
(26, '2025_11_21_170732_remove_old_brand_columns_from_pieces_table', 1),
(27, '2025_11_24_092531_add_promotions_tables', 1);

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Structure de la table `navigation_menus`
--

CREATE TABLE `navigation_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_dropdown` tinyint(1) NOT NULL DEFAULT 0,
  `target` varchar(255) NOT NULL DEFAULT '_self',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `navigation_menus`
--

INSERT INTO `navigation_menus` (`id`, `title`, `url`, `icon`, `parent_id`, `order`, `is_active`, `is_dropdown`, `target`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mécanique', '/pieces/mecanique', NULL, NULL, 0, 1, 1, '_self', '2025-11-24 09:24:55', '2025-11-24 09:26:27', NULL),
(2, 'Filtration', '/pieces/filtration', NULL, NULL, 0, 1, 1, '_self', '2025-11-24 09:25:28', '2025-11-24 09:26:27', NULL),
(3, 'Filtre à air', '/pieces/filtre-a-air', NULL, 2, 0, 1, 1, '_self', '2025-11-24 09:25:40', '2025-11-24 09:26:28', NULL),
(4, 'Filtre à huile', '/pieces/filtre-a-huile', NULL, 2, 0, 1, 1, '_self', '2025-11-24 09:25:56', '2025-11-24 09:26:28', NULL),
(5, 'Batteries', '/pieces/batteries', NULL, NULL, 0, 1, 1, '_self', '2025-11-24 09:27:03', '2025-11-24 09:27:28', NULL),
(6, 'Chargeur de batterie', '/pieces/chargeur-de-batterie', NULL, 5, 0, 1, 1, '_self', '2025-11-24 09:27:09', '2025-11-24 09:27:28', NULL),
(7, 'Batterie', '/pieces/batterie', NULL, 5, 0, 1, 1, '_self', '2025-11-24 09:27:23', '2025-11-24 09:27:29', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'read user management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(2, 'write user management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(3, 'create user management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(4, 'read content management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(5, 'write content management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(6, 'create content management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(7, 'read financial management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(8, 'write financial management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(9, 'create financial management', 'web', '2025-11-24 09:04:59', '2025-11-24 09:04:59'),
(10, 'read reporting', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(11, 'write reporting', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(12, 'create reporting', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(13, 'read payroll', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(14, 'write payroll', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(15, 'create payroll', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(16, 'read disputes management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(17, 'write disputes management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(18, 'create disputes management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(19, 'read api controls', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(20, 'write api controls', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(21, 'create api controls', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(22, 'read database management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(23, 'write database management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(24, 'create database management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(25, 'read repository management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(26, 'write repository management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(27, 'create repository management', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pieces`
--

INSERT INTO `pieces` (`id`, `name`, `reference`, `price`, `category_id`, `brand_id`, `image`, `description`, `stock`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Filtre à air CAF100461C', 'CAF100461C', 500000.00, 3, 2, 'catalog/pieces/yZptwD1oOa6of48kCU3aBxVFVAFYhQQoS5LkBQSt.png', NULL, 80, 1, '2025-11-24 09:28:49', '2025-11-24 09:50:20', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `piece_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price_promo` decimal(10,2) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`id`, `title`, `slug`, `piece_id`, `price_promo`, `order`, `icon`, `image`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Promotion Filtre à air CAF100461C', 'promo-filtre-a-air-caf100461c', 1, 10.00, 0, NULL, NULL, NULL, 1, '2025-11-24 09:29:15', '2025-11-24 09:29:15', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(2, 'developer', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(3, 'analyst', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(4, 'support', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00'),
(5, 'trial', 'web', '2025-11-24 09:05:00', '2025-11-24 09:05:00');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(4, 3),
(5, 1),
(5, 3),
(6, 1),
(6, 3),
(7, 1),
(7, 3),
(8, 1),
(8, 3),
(9, 1),
(9, 3),
(10, 1),
(10, 3),
(10, 4),
(11, 1),
(11, 3),
(11, 4),
(12, 1),
(12, 3),
(12, 4),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(27, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `last_name`, `name`, `email`, `phone`, `is_active`, `profile_photo_path`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`, `last_login_at`, `last_login_ip`, `deleted_at`) VALUES
(24, 1, 'lm', 'Preciousp', '', 'saad@blinkagency.ma', '+15417162752', 1, 'assets/images/avatars/1744972845_image_12.jpg', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, '2025-04-11 15:05:22', '2025-09-16 13:55:53', '2025-09-16 15:55:53', '127.0.0.1', NULL),
(53, 1, 'second', 'saad', '', 'test@example.com', '0666666600', 1, 'assets/images/avatars/1757949898_image.jpg', NULL, '$2y$10$CCqFm8IK5lQorSdvqJdaqe/aX1/ky1dLkLt8C91vydkxh4TNNblLS', NULL, NULL, '2025-09-15 13:24:58', '2025-11-21 14:31:33', '2025-11-21 16:31:33', '127.0.0.1', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_user_id_foreign` (`user_id`);

--
-- Index pour la table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `catalog_categories`
--
ALTER TABLE `catalog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `catalog_categories_slug_deleted_at_unique` (`slug`,`deleted_at`),
  ADD KEY `catalog_categories_parent_id_foreign` (`parent_id`);

--
-- Index pour la table `constructeurs`
--
ALTER TABLE `constructeurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_read_by_user_id_foreign` (`read_by_user_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gallery_media`
--
ALTER TABLE `gallery_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_media_gallery_id_foreign` (`gallery_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `navigation_menus_parent_id_foreign` (`parent_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pieces_reference_unique` (`reference`),
  ADD KEY `pieces_category_id_foreign` (`category_id`),
  ADD KEY `pieces_brand_id_foreign` (`brand_id`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promotions_slug_deleted_at_unique` (`slug`,`deleted_at`),
  ADD KEY `promotions_piece_id_foreign` (`piece_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `catalog_categories`
--
ALTER TABLE `catalog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `constructeurs`
--
ALTER TABLE `constructeurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gallery_media`
--
ALTER TABLE `gallery_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `catalog_categories`
--
ALTER TABLE `catalog_categories`
  ADD CONSTRAINT `catalog_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `catalog_categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_read_by_user_id_foreign` FOREIGN KEY (`read_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `gallery_media`
--
ALTER TABLE `gallery_media`
  ADD CONSTRAINT `gallery_media_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  ADD CONSTRAINT `navigation_menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `navigation_menus` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD CONSTRAINT `pieces_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pieces_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `catalog_categories` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_piece_id_foreign` FOREIGN KEY (`piece_id`) REFERENCES `pieces` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
