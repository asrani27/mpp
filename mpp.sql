-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mpp
CREATE DATABASE IF NOT EXISTS `mpp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mpp`;

-- Dumping structure for table mpp.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.cache: ~0 rows (approximately)

-- Dumping structure for table mpp.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.cache_locks: ~0 rows (approximately)

-- Dumping structure for table mpp.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table mpp.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `layanan_id` bigint unsigned NOT NULL,
  `rating` int unsigned NOT NULL COMMENT 'Rating 1-5',
  `komentar` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_user_id_foreign` (`user_id`),
  KEY `feedback_layanan_id_foreign` (`layanan_id`),
  CONSTRAINT `feedback_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.feedback: ~0 rows (approximately)
INSERT INTO `feedback` (`id`, `tanggal`, `user_id`, `layanan_id`, `rating`, `komentar`, `created_at`, `updated_at`) VALUES
	(1, '2026-05-17', 13, 2, 5, 'fghgfh', '2026-05-16 18:33:03', '2026-05-16 18:33:30');

-- Dumping structure for table mpp.instansi
CREATE TABLE IF NOT EXISTS `instansi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.instansi: ~2 rows (approximately)
INSERT INTO `instansi` (`id`, `nama`, `alamat`, `deskripsi`, `telp`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Dinas Kependudukan', 'Jl. Merdeka No. 1', 'Dinas Kependudukan dan Pencatatan Sipil', '021123456', 'aktif', '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(2, 'Dinas Sosial', 'Jl. Sudirman No. 2', 'Dinas Sosial Kabupaten', '021123457', 'aktif', '2026-05-16 16:11:20', '2026-05-16 16:11:20');

-- Dumping structure for table mpp.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.jobs: ~0 rows (approximately)

-- Dumping structure for table mpp.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.job_batches: ~0 rows (approximately)

-- Dumping structure for table mpp.layanan
CREATE TABLE IF NOT EXISTS `layanan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `instansi_id` bigint unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `syarat` text COLLATE utf8mb4_unicode_ci,
  `lama_proses` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','tidak_aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `layanan_instansi_id_foreign` (`instansi_id`),
  CONSTRAINT `layanan_instansi_id_foreign` FOREIGN KEY (`instansi_id`) REFERENCES `instansi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.layanan: ~2 rows (approximately)
INSERT INTO `layanan` (`id`, `instansi_id`, `nama`, `deskripsi`, `syarat`, `lama_proses`, `status`, `created_at`, `updated_at`) VALUES
	(2, 1, 'Pembuatan KTP', '-', '-', '1x24 jam', 'aktif', '2026-05-16 16:43:56', '2026-05-16 16:43:56');

-- Dumping structure for table mpp.masyarakat
CREATE TABLE IF NOT EXISTS `masyarakat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `masyarakat_nik_unique` (`nik`),
  UNIQUE KEY `masyarakat_email_unique` (`email`),
  KEY `masyarakat_user_id_foreign` (`user_id`),
  CONSTRAINT `masyarakat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.masyarakat: ~10 rows (approximately)
INSERT INTO `masyarakat` (`id`, `nik`, `nama`, `email`, `jabatan`, `telp`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, '3201010101010001', 'Ahmad Wijaya', 'ahmad@test.com', 'Karyawan Swasta', '081234567890', 12, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(2, '3201010101010002', 'Siti Nurhaliza', 'siti@test.com', 'Guru', '081234567891', 13, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(3, '3201010101010003', 'Budi Santoso', 'budi@test.com', 'Petani', '081234567892', 14, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(4, '3201010101010004', 'Dewi Lestari', 'dewi@test.com', 'Dokter', '081234567893', 15, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(5, '3201010101010005', 'Rizki Ramadhan', 'rizki@test.com', 'Pengusaha', '081234567894', 16, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(6, '3201010101010006', 'Putri Ayu', 'putri@test.com', 'Perawat', '081234567895', 17, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(7, '3201010101010007', 'Hendra Kusuma', 'hendra@test.com', 'PNS', '081234567896', 18, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(8, '3201010101010008', 'Maya Sari', 'maya@test.com', 'Ibu Rumah Tangga', '081234567897', 19, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(9, '3201010101010009', 'Fajar Nugroho', 'fajar@test.com', 'Wiraswasta', '081234567898', 20, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(10, '3201010101010010', 'Rina Amelia', 'rina@test.com', 'Akuntan', '081234567899', 21, '2026-05-16 16:11:24', '2026-05-16 16:11:24');

-- Dumping structure for table mpp.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.migrations: ~7 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(8, '0001_01_01_000000_create_users_table', 1),
	(9, '0001_01_01_000001_create_cache_table', 1),
	(10, '0001_01_01_000002_create_jobs_table', 1),
	(11, '2026_05_17_070000_create_instansi_table', 1),
	(12, '2026_05_17_070001_create_petugas_table', 1),
	(13, '2026_05_17_070002_create_masyarakat_table', 1),
	(14, '2026_05_17_070003_create_layanan_table', 1),
	(15, '2026_05_17_070004_create_permohonan_table', 2),
	(17, '2026_05_17_070005_create_status_permohonan_table', 3),
	(18, '2026_05_17_070006_create_feedback_table', 4);

-- Dumping structure for table mpp.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table mpp.permohonan
CREATE TABLE IF NOT EXISTS `permohonan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `layanan_id` bigint unsigned NOT NULL,
  `petugas_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu','diproses','ditolak','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permohonan_nomor_unique` (`nomor`),
  KEY `permohonan_layanan_id_foreign` (`layanan_id`),
  KEY `permohonan_petugas_id_foreign` (`petugas_id`),
  KEY `permohonan_user_id_foreign` (`user_id`),
  CONSTRAINT `permohonan_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permohonan_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `permohonan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.permohonan: ~1 rows (approximately)
INSERT INTO `permohonan` (`id`, `nomor`, `tanggal`, `layanan_id`, `petugas_id`, `user_id`, `nik`, `nama`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
	(10, 'PMH-20260517-0002', '2026-05-17', 2, 9, 13, '3201010101010002', 'Siti Nurhaliza', 'dfgdfg', 'menunggu', '2026-05-16 18:00:49', '2026-05-16 18:19:14'),
	(11, 'PMH-20260517-0003', '2026-05-17', 2, 3, 13, '3201010101010002', 'Siti Nurhaliza', 'sdf', 'menunggu', '2026-05-16 18:20:59', '2026-05-16 18:20:59');

-- Dumping structure for table mpp.petugas
CREATE TABLE IF NOT EXISTS `petugas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `petugas_nip_unique` (`nip`),
  UNIQUE KEY `petugas_email_unique` (`email`),
  KEY `petugas_instansi_id_foreign` (`instansi_id`),
  KEY `petugas_user_id_foreign` (`user_id`),
  CONSTRAINT `petugas_instansi_id_foreign` FOREIGN KEY (`instansi_id`) REFERENCES `instansi` (`id`) ON DELETE CASCADE,
  CONSTRAINT `petugas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.petugas: ~12 rows (approximately)
INSERT INTO `petugas` (`id`, `nip`, `nama`, `email`, `jabatan`, `telp`, `instansi_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, '198501012010011001', 'Dr. Hendra Wijaya', 'hendra.kepala@test.com', 'Kepala Dinas', '081234500001', 1, 2, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(2, '199002152011012002', 'Nurul Hidayati', 'nurul.sekretaris@test.com', 'Sekretaris', '081234500002', 1, 3, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(3, '199103202012011003', 'Asep Supriatna', 'asep.kasi1@test.com', 'Kasi Pelayanan', '081234500003', 1, 4, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(4, '198807302009012004', 'Lisa Permatasari', 'lisa.staff1@test.com', 'Staff Pelayanan', '081234500004', 1, 5, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(5, '199205182013011005', 'Dedi Kurniawan', 'dedi.staff2@test.com', 'Staff Teknis', '081234500005', 1, 6, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(6, '199011252010012006', 'Yuniarti', 'yuni.kabid@test.com', 'Kabid Sosial', '081234500006', 2, 7, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(7, '198912102008012007', 'Taufik Hidayat', 'taufik.kasi@test.com', 'Kasi Rehab', '081234500007', 2, 8, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(8, '199306202014011008', 'Rini Wulandari', 'rini.staff@test.com', 'Staff Rehabilitasi', '081234500008', 2, 9, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(9, '199108152011012009', 'Agus Setiawan', 'agus.petugas@test.com', 'Petugas Lapangan', '081234500009', 2, 10, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(10, '199405252015011010', 'Dian Pratama', 'dian.staff3@test.com', 'Staf Administrasi', '081234500010', 1, 11, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(13, '3253', 'pet1', 'pet1@gmail.vom', 'gjh', 'sdg', 1, 26, '2026-05-16 16:35:10', '2026-05-16 16:35:10'),
	(14, 'dgsdf', 'pet2', 'pet2@gmail.com', 'ghk', 'dfgdfg', 2, 27, '2026-05-16 16:37:28', '2026-05-16 16:37:28');

-- Dumping structure for table mpp.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.sessions: ~0 rows (approximately)

-- Dumping structure for table mpp.status_permohonan
CREATE TABLE IF NOT EXISTS `status_permohonan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permohonan_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_permohonan_permohonan_id_foreign` (`permohonan_id`),
  CONSTRAINT `status_permohonan_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.status_permohonan: ~1 rows (approximately)
INSERT INTO `status_permohonan` (`id`, `permohonan_id`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
	(3, 10, 'menunggu', 'Permohonan berhasil diajukan', '2026-05-16 18:00:49', '2026-05-16 18:00:49'),
	(4, 10, 'diproses', 'Status diubah dari Menunggu menjadi Diproses', '2026-05-16 18:13:22', '2026-05-16 18:13:22'),
	(5, 10, 'diproses', 'Status diubah dari Diproses menjadi Diproses', '2026-05-16 18:13:23', '2026-05-16 18:13:23'),
	(6, 10, 'menunggu', 'Status diubah dari Diproses menjadi Menunggu', '2026-05-16 18:17:24', '2026-05-16 18:17:24'),
	(7, 10, 'selesai', 'Status diubah dari Menunggu menjadi Selesai', '2026-05-16 18:19:01', '2026-05-16 18:19:01'),
	(8, 10, 'menunggu', 'Status diubah dari Selesai menjadi Menunggu', '2026-05-16 18:19:14', '2026-05-16 18:19:14'),
	(9, 10, 'menunggu', 'fghfgh', '2026-05-16 18:19:17', '2026-05-16 18:19:17'),
	(10, 11, 'menunggu', 'Permohonan berhasil diajukan', '2026-05-16 18:20:59', '2026-05-16 18:20:59');

-- Dumping structure for table mpp.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mpp.users: ~30 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin MPP', 'mpp@mpp.com', NULL, '$2y$12$9OxL1LVH3wfsOHV.NgGSwO3XxWUgpKZFmeAQ2SxH8DvleX/8MzWEm', 'admin', NULL, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(2, 'Dr. Hendra Wijaya', 'hendra.kepala@test.com', NULL, '$2y$12$15yKFGc7/iLInB.KFIupuOfIE4zV.X5XOq2LkxV3ouQCZsp1cdHma', 'petugas', NULL, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(3, 'Nurul Hidayati', 'nurul.sekretaris@test.com', NULL, '$2y$12$weKYx8HioMMNZecvaogXj.RGnZ5VIyL.wSfENH5qlpNhtXb5xdEUW', 'petugas', NULL, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(4, 'Asep Supriatna', 'asep.kasi1@test.com', NULL, '$2y$12$2eODHl8zEg9YvFaIg6PgnuqWGXXmShhSGGmjERdaB2Ol33qgHrmqi', 'petugas', NULL, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(5, 'Lisa Permatasari', 'lisa.staff1@test.com', NULL, '$2y$12$wKCOjzk6rSYgkVQuMbuvJu0y/gSMbjsb6DaM3W1LnFTsD.HGlOAvO', 'petugas', NULL, '2026-05-16 16:11:20', '2026-05-16 16:11:20'),
	(6, 'Dedi Kurniawan', 'dedi.staff2@test.com', NULL, '$2y$12$Ee10DR9HJEb9nlk/5sWsJ.4JVy0jGs.rP5dq78aNgqUHll/rnI/V2', 'petugas', NULL, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(7, 'Yuniarti', 'yuni.kabid@test.com', NULL, '$2y$12$qXotFEQggMnscVpKCaTkFe4OGz9KbmaD4K9VAfgH0H4STf4ReTzoq', 'petugas', NULL, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(8, 'Taufik Hidayat', 'taufik.kasi@test.com', NULL, '$2y$12$TFtiwyE7o8BjqTKtFOLVvOkwfr1AbRYNehIMstXL8xpgMV8ZYATJG', 'petugas', NULL, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(9, 'Rini Wulandari', 'rini.staff@test.com', NULL, '$2y$12$nRCUU5RpXeRPu7nSYYYhtu/1FwQe.unzWeLK97iJEfMX1OAdWtmf2', 'petugas', NULL, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(10, 'Agus Setiawan', 'agus.petugas@test.com', NULL, '$2y$12$JQa6xWiHs4NUtadcgseiKOtQVmhTxITUuiyieUt33PBhNnb59vOfu', 'petugas', NULL, '2026-05-16 16:11:21', '2026-05-16 16:11:21'),
	(11, 'Dian Pratama', 'dian.staff3@test.com', NULL, '$2y$12$1wIUGVqVIHFDSVjnoS/AR.jaX0P/AWgz.Y7rrE/pJLgKS0T5sphUe', 'petugas', NULL, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(12, 'Ahmad Wijaya', 'ahmad@test.com', NULL, '$2y$12$80dvpeSli7ut75fCpGejB.2MDBHI2kxaYAVzMKNKSQHWx5K/lv47i', 'user', NULL, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(13, 'Siti Nurhaliza', 'siti@test.com', NULL, '$2y$12$Lx7KgUySQW.43k1pZx4PAuoTvX4eApGQ4qJG8xitOYn55wxeook1O', 'user', NULL, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(14, 'Budi Santoso', 'budi@test.com', NULL, '$2y$12$MU108IbBPdGFHyN06AYYnOiMUWemhQa9h3kfyV4wDE8WMthF4XzJC', 'user', NULL, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(15, 'Dewi Lestari', 'dewi@test.com', NULL, '$2y$12$.0oOqXlMmTQ8Iiboqjwh3eyFPvyuN.epekSCpsOhthTCCdu900eXu', 'user', NULL, '2026-05-16 16:11:22', '2026-05-16 16:11:22'),
	(16, 'Rizki Ramadhan', 'rizki@test.com', NULL, '$2y$12$bluMa8BncVQQGQOKAsYcOOX4N05kGdZ3pvAowR73/iJOF8V3QAmni', 'user', NULL, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(17, 'Putri Ayu', 'putri@test.com', NULL, '$2y$12$V8vf.4EbSjM8a7fitgyhBu5HMrLkN5tYHhAdFzyhmmXZtEDl9IWuG', 'user', NULL, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(18, 'Hendra Kusuma', 'hendra@test.com', NULL, '$2y$12$Gx18aylHNss8XjYO10qmF.TPhG46zxZzqbmTQcVL.L2wNRK9Btjt.', 'user', NULL, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(19, 'Maya Sari', 'maya@test.com', NULL, '$2y$12$tcT3FEIdFLVA/cQFRJ.EK.vLh1LkXqg30NuTNsbfaKD.59q3Abzha', 'user', NULL, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(20, 'Fajar Nugroho', 'fajar@test.com', NULL, '$2y$12$2LlcyAKGPwoT4GCGwsKoi.chBk9RKgiwFRWfSqrVFO6Er/iS./MlG', 'user', NULL, '2026-05-16 16:11:23', '2026-05-16 16:11:23'),
	(21, 'Rina Amelia', 'rina@test.com', NULL, '$2y$12$bisFJps8N3XK6D.sxtFUAuSss7.mJBf3gAusMAQTYSfBrbbETBnZK', 'user', NULL, '2026-05-16 16:11:24', '2026-05-16 16:11:24'),
	(22, 'asdasdasd', 'asd@gmail.com', NULL, '$2y$12$rmtBANp1akEB14bKGbNpBOQbQ6ATGcOO962ar1ediQb8WUeasvY5i', 'user', NULL, '2026-05-16 16:28:24', '2026-05-16 16:28:24'),
	(26, 'pet1', 'pet1@gmail.vom', NULL, '$2y$12$TkOsF2CjpAKb.mXyN.GPyuSxT5Fs7/bGAS94mA03xtAWW9CsRPxbS', 'user', NULL, '2026-05-16 16:35:10', '2026-05-16 16:35:10'),
	(27, 'pet2', 'pet2@gmail.com', NULL, '$2y$12$0JbBhUEGZ/p0w9NyLoi2XeJtLy5m6tElpWUmUH0sbN8.VLFI98ROS', 'petugas', NULL, '2026-05-16 16:37:28', '2026-05-16 16:37:28'),
	(28, 'sdfsdf', 'sdfsdf1778979024@example.com', NULL, '$2y$12$va9Cxjc6GIM2egDM.qyMRu/JQE76RbS8pC/RHn5DOm.8B1Trl4Ezu', 'user', NULL, '2026-05-16 16:50:24', '2026-05-16 16:50:24'),
	(29, 'andi', 'andi1778979249@example.com', NULL, '$2y$12$y.4FMBbIjZ6uMqZ2JvzsP.uoz1PDwJCZyp79ltiywensqn54dk7rO', 'user', NULL, '2026-05-16 16:54:09', '2026-05-16 16:54:09'),
	(30, 'dfgfdg', 'dfgfdg1778979322@example.com', NULL, '$2y$12$A4BCRtKr/5DvRerY2WUGjOEnqEicwbIyTdoFfyd2zgzy3AW9YhWl2', 'user', NULL, '2026-05-16 16:55:22', '2026-05-16 16:55:22'),
	(31, 'gdf', 'gdf1778979369@example.com', NULL, '$2y$12$LDz.E9sK3x1mTGJ12odaDuv9DdNFJ53cLPBpYLlqJ3iDmz2VHfZNe', 'user', NULL, '2026-05-16 16:56:09', '2026-05-16 16:56:09'),
	(32, 'gdf', 'gdf1778979385@example.com', NULL, '$2y$12$Mv8TmIq61zL.41faBswQXOXSiTBXWYI35n8dAjAOPpMgmn0KhEKXq', 'user', NULL, '2026-05-16 16:56:25', '2026-05-16 16:56:25'),
	(33, 'dfg', 'dfg1778979396@example.com', NULL, '$2y$12$eqNKltEoeAZ/s1mpL8Z0hegJ6HwtibkD.lWU9P5gDoHTIiu8y1qua', 'user', NULL, '2026-05-16 16:56:36', '2026-05-16 16:56:36');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
