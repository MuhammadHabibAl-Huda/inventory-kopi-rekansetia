-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_inventory_rekansetia
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `db_inventory_rekansetia`
--

/*!40000 DROP DATABASE IF EXISTS `db_inventory_rekansetia`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `db_inventory_rekansetia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_inventory_rekansetia`;

--
-- Table structure for table `bahan_bakus`
--

DROP TABLE IF EXISTS `bahan_bakus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bahan_bakus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_bahan` varchar(255) NOT NULL,
  `stok_sisa` decimal(10,2) NOT NULL DEFAULT 0.00,
  `satuan` varchar(255) NOT NULL,
  `stok_minimum` decimal(10,2) NOT NULL DEFAULT 100.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bahan_bakus`
--

LOCK TABLES `bahan_bakus` WRITE;
/*!40000 ALTER TABLE `bahan_bakus` DISABLE KEYS */;
INSERT INTO `bahan_bakus` VALUES (1,'Susu UHT',3600.00,'ml',3000.00,1,'2026-08-11 00:10:39','2026-08-17 10:11:14'),(2,'Gula Aren',2960.00,'ml',1000.00,1,'2026-08-11 00:11:42','2026-08-11 04:22:14'),(3,'Krimer Bubuk',2950.00,'gram',500.00,1,'2026-08-11 00:12:37','2026-08-11 04:27:15'),(4,'Expresso House Blend',4910.00,'gram',1000.00,1,'2026-08-11 00:14:07','2026-08-11 04:22:14'),(5,'Expresso Arabica',2874.00,'gram',500.00,1,'2026-08-11 00:14:58','2026-08-11 15:45:56'),(6,'Susu Kental Manis',2880.00,'ml',500.00,1,'2026-08-11 00:15:43','2026-08-11 04:22:14'),(7,'Sirup Lemon',1000.00,'ml',100.00,1,'2026-08-11 00:18:16','2026-08-11 00:18:16'),(8,'Sari Lemon',1000.00,'ml',100.00,1,'2026-08-11 00:18:53','2026-08-11 00:18:53'),(9,'Gula Putih Cair',2997.50,'ml',1000.00,1,'2026-08-11 00:19:36','2026-08-12 01:19:26'),(10,'Soda',1000.00,'ml',200.00,1,'2026-08-11 00:19:57','2026-08-11 00:19:57'),(11,'Rich Milk',640.00,'ml',250.00,1,'2026-08-11 00:20:34','2026-08-11 04:27:15'),(12,'Sirup Caramel',974.00,'ml',100.00,1,'2026-08-11 00:21:01','2026-08-11 04:27:15'),(13,'Coklat Bubuk',1000.00,'gram',100.00,1,'2026-08-11 00:21:29','2026-08-11 00:21:29'),(14,'Sirup Tiramisu',1000.00,'ml',100.00,1,'2026-08-11 00:22:07','2026-08-11 00:22:07'),(15,'Sirup Butterscoth',1000.00,'ml',100.00,1,'2026-08-11 00:22:39','2026-08-11 00:22:39'),(16,'Arabica Single Origin',3000.00,'gram',50.00,1,'2026-08-11 00:23:33','2026-08-11 00:23:33'),(17,'Robusta',5000.00,'gram',1000.00,1,'2026-08-11 00:24:19','2026-08-11 00:24:19'),(18,'Air',7900.00,'ml',5000.00,1,'2026-08-11 00:25:26','2026-08-11 04:22:14'),(19,'Batu Es',2900.00,'gram',1000.00,1,'2026-08-11 00:26:00','2026-08-11 04:22:14');
/*!40000 ALTER TABLE `bahan_bakus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'2026_06_24_111815_create_bahan_bakus_table',1),(3,'2026_06_24_111919_create_produks_table',1),(4,'2026_06_24_112010_create_reseps_table',1),(5,'2026_06_29_050059_create_riwayat_stoks_table',1),(6,'2026_07_22_115408_add_role_to_users_table',1),(7,'2026_08_09_142121_add_status_to_bahan_bakus_table',1),(8,'2026_08_11_065340_change_numeric_columns_to_decimal',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produks`
--

DROP TABLE IF EXISTS `produks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produks`
--

LOCK TABLES `produks` WRITE;
/*!40000 ALTER TABLE `produks` DISABLE KEYS */;
INSERT INTO `produks` VALUES (1,'Es Kopi Susu Setia',17000,'2026-08-11 00:27:28','2026-08-11 00:27:28'),(2,'Es Kopi Susu Loyal',17000,'2026-08-11 00:29:47','2026-08-11 00:29:47'),(3,'Es Kopi Lemon',17000,'2026-08-11 00:31:39','2026-08-11 00:31:39'),(4,'Espresso Shake',15000,'2026-08-11 00:34:04','2026-08-11 00:34:04'),(5,'Dirty Latte',20000,'2026-08-11 00:36:04','2026-08-11 00:36:04'),(6,'Jus Kuphi',16000,'2026-08-11 00:37:48','2026-08-11 00:37:48'),(7,'Cappuccino',17000,'2026-08-11 00:39:56','2026-08-11 00:39:56'),(8,'Mochaccino',17000,'2026-08-11 00:41:23','2026-08-11 00:41:23'),(9,'Caffe Latte',17000,'2026-08-11 00:43:55','2026-08-11 00:43:55'),(10,'Latte Tiramisu',17000,'2026-08-11 00:45:13','2026-08-11 00:45:13'),(11,'Latte Caramel',17000,'2026-08-11 00:46:35','2026-08-11 00:46:35'),(12,'Latte Butterscotch',17000,'2026-08-11 00:48:28','2026-08-11 00:48:28'),(13,'Americano',14000,'2026-08-11 00:49:56','2026-08-11 00:49:56'),(14,'Espresso',12000,'2026-08-11 00:51:40','2026-08-11 00:51:40'),(15,'V60',20000,'2026-08-11 00:53:03','2026-08-11 00:53:03'),(16,'Japanese Ice',20000,'2026-08-11 00:54:20','2026-08-11 00:54:20'),(17,'Aeropress',20000,'2026-08-11 00:55:44','2026-08-11 00:55:44'),(18,'Tubruk',18000,'2026-08-11 00:58:42','2026-08-11 00:58:42'),(19,'Vietnam Drip',12000,'2026-08-11 01:00:15','2026-08-11 01:00:15');
/*!40000 ALTER TABLE `produks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reseps`
--

DROP TABLE IF EXISTS `reseps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reseps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `produk_id` bigint(20) unsigned NOT NULL,
  `bahan_baku_id` bigint(20) unsigned NOT NULL,
  `jumlah_dibutuhkan` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reseps_produk_id_foreign` (`produk_id`),
  KEY `reseps_bahan_baku_id_foreign` (`bahan_baku_id`),
  CONSTRAINT `reseps_bahan_baku_id_foreign` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_bakus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reseps_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reseps`
--

LOCK TABLES `reseps` WRITE;
/*!40000 ALTER TABLE `reseps` DISABLE KEYS */;
INSERT INTO `reseps` VALUES (1,1,1,150.00,'2026-08-11 00:28:26','2026-08-11 00:28:26'),(2,1,2,20.00,'2026-08-11 00:28:41','2026-08-11 00:28:41'),(3,1,3,10.00,'2026-08-11 00:29:02','2026-08-11 00:29:02'),(4,1,4,18.00,'2026-08-11 00:29:16','2026-08-11 00:29:16'),(5,2,1,140.00,'2026-08-11 00:30:00','2026-08-11 00:30:00'),(6,2,2,13.00,'2026-08-11 00:30:19','2026-08-11 00:30:19'),(7,2,3,15.00,'2026-08-11 00:30:34','2026-08-11 00:30:34'),(8,2,16,18.00,'2026-08-11 00:30:51','2026-08-11 00:30:51'),(9,2,6,7.00,'2026-08-11 00:31:10','2026-08-11 00:31:10'),(10,3,4,18.00,'2026-08-11 00:31:59','2026-08-11 00:31:59'),(11,3,18,100.00,'2026-08-11 00:32:21','2026-08-11 00:32:21'),(12,3,7,10.00,'2026-08-11 00:32:34','2026-08-11 00:32:34'),(13,3,8,10.00,'2026-08-11 00:32:50','2026-08-11 00:32:50'),(14,3,9,10.00,'2026-08-11 00:33:06','2026-08-11 00:33:06'),(15,3,10,50.00,'2026-08-11 00:33:18','2026-08-11 00:33:18'),(16,4,2,8.00,'2026-08-11 00:35:06','2026-08-11 00:35:06'),(17,4,4,18.00,'2026-08-11 00:35:22','2026-08-11 00:35:22'),(18,4,19,150.00,'2026-08-11 00:35:35','2026-08-11 00:35:35'),(19,5,3,10.00,'2026-08-11 00:36:31','2026-08-11 00:36:31'),(20,5,5,18.00,'2026-08-11 00:36:48','2026-08-11 00:36:48'),(21,5,11,120.00,'2026-08-11 00:37:03','2026-08-11 00:37:03'),(22,5,12,7.00,'2026-08-11 00:37:18','2026-08-11 00:37:18'),(23,6,1,100.00,'2026-08-11 00:38:21','2026-08-11 00:38:21'),(24,6,4,18.00,'2026-08-11 00:38:33','2026-08-11 00:38:33'),(25,6,6,40.00,'2026-08-11 00:38:46','2026-08-11 00:38:46'),(27,7,5,18.00,'2026-08-11 00:40:33','2026-08-11 00:40:33'),(28,8,1,150.00,'2026-08-11 00:41:41','2026-08-11 00:41:41'),(29,8,2,15.00,'2026-08-11 00:41:57','2026-08-11 00:41:57'),(30,8,4,18.00,'2026-08-11 00:42:16','2026-08-11 00:42:16'),(31,8,6,10.00,'2026-08-11 00:42:34','2026-08-11 00:42:34'),(32,8,13,2.50,'2026-08-11 00:42:57','2026-08-11 00:42:57'),(33,9,1,150.00,'2026-08-11 00:44:17','2026-08-11 00:44:17'),(34,9,5,18.00,'2026-08-11 00:44:30','2026-08-11 00:44:30'),(35,10,1,150.00,'2026-08-11 00:45:27','2026-08-11 00:45:27'),(36,10,4,18.00,'2026-08-11 00:45:41','2026-08-11 00:45:41'),(37,10,14,20.00,'2026-08-11 00:46:05','2026-08-11 00:46:05'),(38,11,1,150.00,'2026-08-11 00:46:56','2026-08-11 00:46:56'),(39,11,4,18.00,'2026-08-11 00:47:11','2026-08-11 00:47:11'),(40,11,12,20.00,'2026-08-11 00:47:30','2026-08-11 00:47:30'),(41,12,1,150.00,'2026-08-11 00:48:53','2026-08-11 00:48:53'),(42,12,4,18.00,'2026-08-11 00:49:08','2026-08-11 00:49:08'),(43,12,15,20.00,'2026-08-11 00:49:30','2026-08-11 00:49:30'),(44,13,5,18.00,'2026-08-11 00:50:13','2026-08-11 00:50:13'),(45,13,18,100.00,'2026-08-11 00:50:30','2026-08-11 00:50:30'),(46,13,19,100.00,'2026-08-11 00:50:56','2026-08-11 00:50:56'),(47,14,5,18.00,'2026-08-11 00:52:22','2026-08-11 00:52:22'),(48,15,18,200.00,'2026-08-11 00:53:29','2026-08-11 00:53:29'),(49,15,16,13.00,'2026-08-11 00:53:57','2026-08-11 00:53:57'),(50,16,18,130.00,'2026-08-11 00:54:46','2026-08-11 00:54:46'),(51,16,16,13.00,'2026-08-11 00:55:01','2026-08-11 00:55:01'),(52,17,18,200.00,'2026-08-11 00:56:05','2026-08-11 00:56:05'),(53,17,16,13.00,'2026-08-11 00:56:20','2026-08-11 00:56:20'),(54,18,5,15.00,'2026-08-11 00:59:06','2026-08-11 00:59:06'),(55,18,18,150.00,'2026-08-11 00:59:21','2026-08-11 00:59:21'),(56,19,6,25.00,'2026-08-11 01:00:31','2026-08-11 01:00:31'),(57,19,18,150.00,'2026-08-11 01:00:48','2026-08-11 01:00:48'),(58,19,17,15.00,'2026-08-11 01:01:10','2026-08-11 01:01:10'),(59,7,1,150.00,'2026-08-11 15:33:08','2026-08-11 15:33:08');
/*!40000 ALTER TABLE `reseps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riwayat_stoks`
--

DROP TABLE IF EXISTS `riwayat_stoks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `riwayat_stoks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bahan_baku_id` bigint(20) unsigned NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `riwayat_stoks_bahan_baku_id_foreign` (`bahan_baku_id`),
  CONSTRAINT `riwayat_stoks_bahan_baku_id_foreign` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_bakus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_stoks`
--

LOCK TABLES `riwayat_stoks` WRITE;
/*!40000 ALTER TABLE `riwayat_stoks` DISABLE KEYS */;
INSERT INTO `riwayat_stoks` VALUES (1,1,'Keluar',600.00,'POS ΓÇö 2 Es Kopi Susu Setia, 3 Jus Kuphi','2026-08-11 04:22:14','2026-08-11 04:22:14'),(2,2,'Keluar',40.00,'POS ΓÇö 2 Es Kopi Susu Setia','2026-08-11 04:22:14','2026-08-11 04:22:14'),(3,3,'Keluar',40.00,'POS ΓÇö 2 Es Kopi Susu Setia, 2 Dirty Latte','2026-08-11 04:22:14','2026-08-11 04:22:14'),(4,4,'Keluar',90.00,'POS ΓÇö 2 Es Kopi Susu Setia, 3 Jus Kuphi','2026-08-11 04:22:14','2026-08-11 04:22:14'),(5,5,'Keluar',54.00,'POS ΓÇö 1 Americano, 2 Dirty Latte','2026-08-11 04:22:14','2026-08-11 04:22:14'),(6,18,'Keluar',100.00,'POS ΓÇö 1 Americano','2026-08-11 04:22:14','2026-08-11 04:22:14'),(7,19,'Keluar',100.00,'POS ΓÇö 1 Americano','2026-08-11 04:22:14','2026-08-11 04:22:14'),(8,6,'Keluar',120.00,'POS ΓÇö 3 Jus Kuphi','2026-08-11 04:22:14','2026-08-11 04:22:14'),(9,11,'Keluar',240.00,'POS ΓÇö 2 Dirty Latte','2026-08-11 04:22:14','2026-08-11 04:22:14'),(10,12,'Keluar',14.00,'POS ΓÇö 2 Dirty Latte','2026-08-11 04:22:14','2026-08-11 04:22:14'),(11,3,'Keluar',10.00,'POS ΓÇö 1 Dirty Latte','2026-08-11 04:27:15','2026-08-11 04:27:15'),(12,5,'Keluar',18.00,'POS ΓÇö 1 Dirty Latte','2026-08-11 04:27:15','2026-08-11 04:27:15'),(13,11,'Keluar',120.00,'POS ΓÇö 1 Dirty Latte','2026-08-11 04:27:15','2026-08-11 04:27:15'),(14,12,'Keluar',12.00,'POS ΓÇö 1 Dirty Latte, Add-on untuk Dirty Latte','2026-08-11 04:27:15','2026-08-11 04:27:15'),(15,1,'Keluar',450.00,'POS ΓÇö 3 Caffe latte','2026-08-11 15:45:56','2026-08-11 15:45:56'),(16,5,'Keluar',54.00,'POS ΓÇö 3 Caffe latte','2026-08-11 15:45:56','2026-08-11 15:45:56'),(17,9,'Keluar',2.50,'Penyusutan ΓÇö Add-on Manual Kasir ΓÇö ekstra gula','2026-08-12 01:19:26','2026-08-12 01:19:26'),(18,1,'Masuk',100.00,'Restock Supplier ΓÇö Shopee','2026-08-17 10:11:14','2026-08-17 10:11:14');
/*!40000 ALTER TABLE `riwayat_stoks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('cDilBaR6j5PbjgrDfx2p0aLG2QyCdu0lE9tMeZmK',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUFdmemNkQzV0MlE1c3ZsUGhiYVBQOW5HVnV4elNlRWtpbUQyV1U2diI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=',1786964661),('gKuhYzkPMp7BSOWWL0gaYfKBPyJXkc0q1UeC6bsE',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWlJFUzZaYVo2RXpKckVhTThZVVpZSHQ5aGFpb2pyVm1YNEt6Z2hXMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iYWhhbi1iYWt1IjtzOjU6InJvdXRlIjtzOjE2OiJiYWhhbi1iYWt1LmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1787061905),('LboeSx306ukbJobeX9hd56QMHiNHG2xexbdkz5Hi',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidTVMR25pRHpEM2dSWU1LbHFWdmZGak9wM1NDbnQzRWczNlZPV0ZQcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC91c2VycyI7czo1OiJyb3V0ZSI7czoxMToidXNlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1786963188);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','barista') NOT NULL DEFAULT 'barista',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@rekansetia.com',NULL,'$2y$12$TJhUYgyqyQ8YvJPY0bh16e.I/KcTAAvj9TgrpsGFGfHNXstB0Q.5.','admin',NULL,'2026-08-11 00:07:31','2026-08-11 00:07:31'),(2,'Ferry','barista@rekansetia.com',NULL,'$2y$12$efmE8BJVTHDmC7AYEgrfo.tpQSdzRr3LchducZ0vCaKeBosEgdk2W','barista','NpOW9ECCu33nX75SPWrsXte7GmP4oCSEy3FQnGfQXYcrxTkDxFmoHAdrpIO4','2026-08-11 01:03:56','2026-08-11 01:03:56'),(3,'Asep','barista2@rekansetia.com',NULL,'$2y$12$GUR6k7bRIa0Dph95ylz2kuMOmf.mUNainB/0DA8oZ.2/RbkKPtW5q','barista',NULL,'2026-08-11 01:05:25','2026-08-11 01:05:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_inventory_rekansetia'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-18 21:12:43
