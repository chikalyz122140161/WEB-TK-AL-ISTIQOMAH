-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: web_tk_alistiqomah
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `academic_term`
--

DROP TABLE IF EXISTS `academic_term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academic_term` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('ganjil','genap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('menunggu','aktif','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_term`
--

LOCK TABLES `academic_term` WRITE;
/*!40000 ALTER TABLE `academic_term` DISABLE KEYS */;
INSERT INTO `academic_term` VALUES ('019e5a10-0c19-7199-9408-c85b54afd568','2025/2026','ganjil','menunggu','2026-05-24 05:57:41','2026-05-24 05:57:41',NULL),('019e5a10-36de-70b3-8f16-7c4667d3f29e','2025/2026','genap','aktif','2026-05-24 05:57:52','2026-05-24 06:03:18',NULL),('019e5a5a-867e-70e9-a0a1-4042e526f9ec','2026/2027','ganjil','menunggu','2026-05-24 07:19:02','2026-05-24 07:23:05','2026-05-24 07:23:05'),('019e5a62-c312-7270-8269-37b80c22903f','2026/2027','ganjil','menunggu','2026-05-24 07:28:02','2026-05-24 07:28:07','2026-05-24 07:28:07');
/*!40000 ALTER TABLE `academic_term` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES ('019e5a10-0c28-70b7-a31e-ee6b7ae910df','Admin Baini, S.Pd — menambah tahun ajaran 2025/2026 Ganjil','2026-05-24 05:57:41','2026-05-24 05:57:41',NULL),('019e5a10-3724-7166-9eb9-92a7d6c7ef13','Admin Baini, S.Pd — menambah tahun ajaran 2025/2026 Genap','2026-05-24 05:57:52','2026-05-24 05:57:52',NULL),('019e5a10-6f55-7137-9a84-9e249eb0b51e','Admin Baini, S.Pd — menambah kelas A','2026-05-24 05:58:07','2026-05-24 05:58:07',NULL),('019e5a10-9574-7151-b81a-1d8e00d00338','Admin Baini, S.Pd — menambah kelas B1','2026-05-24 05:58:16','2026-05-24 05:58:16',NULL),('019e5a10-baf1-7216-84af-d31410324cb6','Admin Baini, S.Pd — menambah kelas B2','2026-05-24 05:58:26','2026-05-24 05:58:26',NULL),('019e5a11-60f3-70ee-9247-7db45d1aab02','Admin Baini, S.Pd — menambah ekstrakurikuler Karate','2026-05-24 05:59:08','2026-05-24 05:59:08',NULL),('019e5a11-b589-71c8-ade2-3f07275aba77','Admin Baini, S.Pd — menambah ekstrakurikuler Berenang','2026-05-24 05:59:30','2026-05-24 05:59:30',NULL),('019e5a11-c881-7350-9e11-9f8013dbc60f','Admin Baini, S.Pd — menghapus ekstrakurikuler Berenang','2026-05-24 05:59:35','2026-05-24 05:59:35',NULL),('019e5a11-fa95-7217-a514-0ae014340369','Admin Baini, S.Pd — menambah mata pelajaran matematika','2026-05-24 05:59:48','2026-05-24 05:59:48',NULL),('019e5a12-336f-71c1-9bf0-6daa525e16d6','Admin Baini, S.Pd — menambah konseling 7','2026-05-24 06:00:02','2026-05-24 06:00:02',NULL),('019e5a13-8b74-7202-8c56-d0b9512d9f1f','Admin Baini, S.Pd — mengedit konseling 7 Kebiasaan Indonesia Hebat','2026-05-24 06:01:30','2026-05-24 06:01:30',NULL),('019e5a14-048d-728a-8e26-0f37454b2176','Admin Baini, S.Pd — menerima pendaftaran siswa NABIL HAKIM MAULANA','2026-05-24 06:02:01','2026-05-24 06:02:01',NULL),('019e5a14-2e6f-72a9-84e8-5953a08a7937','Admin Baini, S.Pd — menerima pendaftaran siswa HANA NURAFIFAH','2026-05-24 06:02:12','2026-05-24 06:02:12',NULL),('019e5a14-6d9a-7242-81e4-37370c6159a9','Admin Baini, S.Pd — menerima pendaftaran siswa SYIFA AZZAHRA NURAINI','2026-05-24 06:02:28','2026-05-24 06:02:28',NULL),('019e5a15-3067-723d-a858-796c4a40f97c','Admin Baini, S.Pd — mengedit tahun ajaran 2025/2026 Genap','2026-05-24 06:03:18','2026-05-24 06:03:18',NULL),('019e5a15-ae31-7054-9d0c-152da69b935b','Guru Reita Wigianti, S.Si, S.Pd., Gr — mencatat presensi kelas A untuk tanggal 2026-05-24','2026-05-24 06:03:50','2026-05-24 06:03:50',NULL),('019e5a16-2489-7285-8415-ba4483180130','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal kegiatan: x','2026-05-24 06:04:21','2026-05-24 06:04:21',NULL),('019e5a16-7a9b-729a-a238-b7d450b08ee5','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal pembelajaran: zzz','2026-05-24 06:04:43','2026-05-24 06:04:43',NULL),('019e5a17-4748-7380-8eea-67d8fc1b370f','Admin Baini, S.Pd — mengedit aktivitas tahun ajaran untuk kelas A — 2025/2026 Genap','2026-05-24 06:05:35','2026-05-24 06:05:35',NULL),('019e5a18-0c88-73ad-b80a-4632288e1865','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat laporan perkembangan minggu ke-1 untuk siswa NABIL HAKIM MAULANA','2026-05-24 06:06:26','2026-05-24 06:06:26',NULL),('019e5a18-5a48-7306-9421-3cbdfbe8adfc','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat laporan perkembangan minggu ke-2 untuk siswa NABIL HAKIM MAULANA','2026-05-24 06:06:45','2026-05-24 06:06:45',NULL),('019e5a18-a7bd-723e-a36b-7da37ac28374','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat laporan perkembangan minggu ke-3 untuk siswa NABIL HAKIM MAULANA','2026-05-24 06:07:05','2026-05-24 06:07:05',NULL),('019e5a19-6afc-71d2-8ebc-04d136ea750d','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling untuk NABIL HAKIM MAULANA pada 2026-05-24','2026-05-24 06:07:55','2026-05-24 06:07:55',NULL),('019e5a43-ab3d-7321-bda8-b4f9ba63fa9b','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling per kelas pada 2026-05-24','2026-05-24 06:54:04','2026-05-24 06:54:04',NULL),('019e5a53-0b72-7230-bcd6-df74e8bc4f90','Orang Tua Hakim Maulana — mengajukan jadwal konseling untuk siswa NABIL HAKIM MAULANA pada 2026-05-24','2026-05-24 07:10:52','2026-05-24 07:10:52',NULL),('019e5a56-dd16-7219-b5cc-c0a3f62de4c7','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling per kelas pada 2026-05-30','2026-05-24 07:15:02','2026-05-24 07:15:02',NULL),('019e5a5a-86c7-7249-bcc3-8b2fd0a615aa','Admin Baini, S.Pd — menambah tahun ajaran 2026/2027 Ganjil','2026-05-24 07:19:02','2026-05-24 07:19:02',NULL),('019e5a5e-3c6d-7344-bae4-f919d3930847','Admin Baini, S.Pd — menghapus tahun ajaran 2026/2027 Ganjil','2026-05-24 07:23:05','2026-05-24 07:23:05',NULL),('019e5a62-c35a-7256-9064-3ba5045a8c04','Admin Baini, S.Pd — menambah tahun ajaran 2026/2027 Ganjil','2026-05-24 07:28:02','2026-05-24 07:28:02',NULL),('019e5a62-d651-7263-aec8-416782427cdf','Admin Baini, S.Pd — menghapus tahun ajaran 2026/2027 Ganjil','2026-05-24 07:28:07','2026-05-24 07:28:07',NULL),('019e5a63-0899-73ab-9b69-c7ad8e775427','Admin Baini, S.Pd — menambah kelas A2','2026-05-24 07:28:20','2026-05-24 07:28:20',NULL),('019e5a63-9284-7268-b6e0-0b8ec3994eb2','Admin Baini, S.Pd — menghapus kelas A2','2026-05-24 07:28:55','2026-05-24 07:28:55',NULL),('019e5a64-b00a-7051-a406-48f3cab8710c','Admin Baini, S.Pd — menambah kelas A3','2026-05-24 07:30:08','2026-05-24 07:30:08',NULL),('019e5a64-cdeb-7046-a9c8-c72f364bd51c','Admin Baini, S.Pd — menghapus kelas A3','2026-05-24 07:30:16','2026-05-24 07:30:16',NULL),('019e5a67-9d41-7129-b039-b4af6df0e354','Admin Baini, S.Pd — menambah kelas A3','2026-05-24 07:33:20','2026-05-24 07:33:20',NULL),('019e5a67-bbef-7259-a536-85a535807246','Admin Baini, S.Pd — menghapus kelas A3','2026-05-24 07:33:28','2026-05-24 07:33:28',NULL),('019e5a67-d914-70ac-95c4-a1273f192d8f','Admin Baini, S.Pd — menambah kelas A3','2026-05-24 07:33:35','2026-05-24 07:33:35',NULL),('019e5a68-070c-7267-946e-2babaa475edb','Admin Baini, S.Pd — menghapus kelas A3','2026-05-24 07:33:47','2026-05-24 07:33:47',NULL),('019e5a68-56ad-70c3-b40d-66d720e98b6d','Admin Baini, S.Pd — menambah ekstrakurikuler Berenang','2026-05-24 07:34:07','2026-05-24 07:34:07',NULL),('019e5a68-67ee-7113-b601-748ddb061124','Admin Baini, S.Pd — menghapus ekstrakurikuler Berenang','2026-05-24 07:34:12','2026-05-24 07:34:12',NULL),('019e5a68-8eea-7396-89f2-b4950d2d8a01','Admin Baini, S.Pd — menambah ekstrakurikuler Berenang','2026-05-24 07:34:22','2026-05-24 07:34:22',NULL),('019e5a68-a1df-71a3-8b61-de752df0d66d','Admin Baini, S.Pd — menghapus ekstrakurikuler Berenang','2026-05-24 07:34:27','2026-05-24 07:34:27',NULL),('019e5acf-fd74-733f-a2a0-2205a24ef8a5','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat laporan perkembangan minggu ke-4 untuk siswa NABIL HAKIM MAULANA','2026-05-24 09:27:20','2026-05-24 09:27:20',NULL),('019e5af4-6a04-7146-93b8-f2df22af9621','Orang Tua Hakim Maulana — mengajukan jadwal konseling untuk siswa NABIL HAKIM MAULANA pada 2026-06-04','2026-05-24 10:07:07','2026-05-24 10:07:07',NULL),('019e5b03-c597-715c-9fa3-bab2fbbac03e','Orang Tua Hakim Maulana — mengajukan jadwal konseling untuk siswa NABIL HAKIM MAULANA pada 2026-06-04','2026-05-24 10:23:54','2026-05-24 10:23:54',NULL),('019e5b1c-c532-73f8-a4b3-ec138c974716','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling untuk NABIL HAKIM MAULANA pada 2026-05-25','2026-05-24 10:51:12','2026-05-24 10:51:12',NULL),('019e5b1e-185e-72bc-841a-54909e7aba2f','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling per kelas pada 2026-06-02','2026-05-24 10:52:39','2026-05-24 10:52:39',NULL),('019e5b1e-ec37-7243-b6ca-2c8132e6be0b','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling per kelas pada 2026-06-02','2026-05-24 10:53:33','2026-05-24 10:53:33',NULL),('019e5b26-f5e6-7292-8516-b6233ed6ce7a','Orang Tua Hakim Maulana — mengajukan jadwal konseling untuk siswa NABIL HAKIM MAULANA pada 2026-06-16','2026-05-24 11:02:20','2026-05-24 11:02:20',NULL),('019e6041-4f7e-7061-9d63-6570a8b1f2ba','Orang Tua Hakim Maulana — mengajukan jadwal konseling untuk siswa NABIL HAKIM MAULANA pada 2026-05-26','2026-05-25 10:49:13','2026-05-25 10:49:13',NULL),('019e6042-7ad9-7188-af0a-875360c4c003','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling per kelas pada 2026-05-26','2026-05-25 10:50:30','2026-05-25 10:50:30',NULL),('019e6043-1d7a-70fe-81fe-ee6f23e13faf','Guru Reita Wigianti, S.Si, S.Pd., Gr — membuat jadwal konseling untuk NABIL HAKIM MAULANA pada 2026-05-27','2026-05-25 10:51:11','2026-05-25 10:51:11',NULL);
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_schedule`
--

DROP TABLE IF EXISTS `activity_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_schedule` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `start_hour` time DEFAULT NULL,
  `end_hour` time DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_schedule_class_term_id_foreign` (`class_term_id`),
  CONSTRAINT `activity_schedule_class_term_id_foreign` FOREIGN KEY (`class_term_id`) REFERENCES `class_term` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_schedule`
--

LOCK TABLES `activity_schedule` WRITE;
/*!40000 ALTER TABLE `activity_schedule` DISABLE KEYS */;
INSERT INTO `activity_schedule` VALUES ('019e5a16-247b-703c-9efb-d579b43f6848','019e5a14-0445-7225-8eb1-c2e0c30bd19e','x','2026-05-24','20:11:00','21:04:00','zzzz','zzz','2026-05-24 06:04:21','2026-05-24 06:04:21',NULL);
/*!40000 ALTER TABLE `activity_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_message`
--

DROP TABLE IF EXISTS `chat_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_message` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_room_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_message_chat_room_id_foreign` (`chat_room_id`),
  KEY `chat_message_sender_id_foreign` (`sender_id`),
  CONSTRAINT `chat_message_chat_room_id_foreign` FOREIGN KEY (`chat_room_id`) REFERENCES `chat_room` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_message_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_message`
--

LOCK TABLES `chat_message` WRITE;
/*!40000 ALTER TABLE `chat_message` DISABLE KEYS */;
INSERT INTO `chat_message` VALUES ('019e5a18-f01a-72f0-a5cd-e6f1774bc5f7','019e5a18-d9c9-70d3-a279-ed18cf05acf9','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','permisi',0,'2026-05-24 06:07:24','2026-05-24 06:07:24',NULL),('019e5ad6-ccec-7387-b641-ea3813b486ad','019e5a18-d9c9-70d3-a279-ed18cf05acf9','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','Selamat malam',0,'2026-05-24 09:34:47','2026-05-24 09:34:47',NULL),('019e5ad7-cdbe-7063-b03f-a8d9105becb7','019e5ad7-a706-7371-b860-72164c2227f1','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','Assalamualaikum Bapak',1,'2026-05-24 09:35:52','2026-05-24 09:36:10',NULL),('019e5ad8-765d-713a-8701-00cc67680bdb','019e5ad7-a706-7371-b860-72164c2227f1','019e5a0c-665b-7199-b129-c40e600bad20','Waalaikumsalam ibu, ada apa ya',1,'2026-05-24 09:36:36','2026-05-24 09:38:09',NULL);
/*!40000 ALTER TABLE `chat_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_room`
--

DROP TABLE IF EXISTS `chat_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_room` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_a_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_b_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_room_user_a_id_user_b_id_unique` (`user_a_id`,`user_b_id`),
  KEY `chat_room_user_b_id_foreign` (`user_b_id`),
  CONSTRAINT `chat_room_user_a_id_foreign` FOREIGN KEY (`user_a_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_room_user_b_id_foreign` FOREIGN KEY (`user_b_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_room`
--

LOCK TABLES `chat_room` WRITE;
/*!40000 ALTER TABLE `chat_room` DISABLE KEYS */;
INSERT INTO `chat_room` VALUES ('019e5a18-d9c9-70d3-a279-ed18cf05acf9','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a0c-4d24-708b-8369-a3597ec48f66','2026-05-24 06:07:18','2026-05-24 06:07:18',NULL),('019e5ad7-a706-7371-b860-72164c2227f1','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a0c-665b-7199-b129-c40e600bad20','2026-05-24 09:35:42','2026-05-24 09:35:42',NULL);
/*!40000 ALTER TABLE `chat_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maximum` int NOT NULL DEFAULT '20',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES ('019e5a10-6f0f-730b-a0ac-06c98ed97e58','A',20,'2026-05-24 05:58:06','2026-05-24 05:58:06',NULL),('019e5a10-952c-71a8-b5e3-1a1a102c56da','B1',20,'2026-05-24 05:58:16','2026-05-24 05:58:16',NULL),('019e5a10-bae6-700f-935f-34bb5fd154e7','B2',20,'2026-05-24 05:58:26','2026-05-24 05:58:26',NULL),('019e5a63-0852-72a0-bae9-393633309648','A2',20,'2026-05-24 07:28:20','2026-05-24 07:28:55','2026-05-24 07:28:55'),('019e5a64-afc1-71f7-9a06-a47cdaf2e5d8','A3',20,'2026-05-24 07:30:08','2026-05-24 07:30:16','2026-05-24 07:30:16'),('019e5a67-9d33-735f-b8f7-604e1fb5aead','A3',20,'2026-05-24 07:33:20','2026-05-24 07:33:28','2026-05-24 07:33:28'),('019e5a67-d906-72ab-835c-6c6355d079fc','A3',20,'2026-05-24 07:33:35','2026-05-24 07:33:47','2026-05-24 07:33:47');
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_schedule`
--

DROP TABLE IF EXISTS `class_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_schedule` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` int NOT NULL,
  `start_hour` time NOT NULL,
  `end_hour` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_schedule_class_term_id_foreign` (`class_term_id`),
  CONSTRAINT `class_schedule_class_term_id_foreign` FOREIGN KEY (`class_term_id`) REFERENCES `class_term` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_schedule`
--

LOCK TABLES `class_schedule` WRITE;
/*!40000 ALTER TABLE `class_schedule` DISABLE KEYS */;
INSERT INTO `class_schedule` VALUES ('019e5a16-7a8c-7303-8e81-f62bf3032d41','019e5a14-0445-7225-8eb1-c2e0c30bd19e','zzz',1,'01:04:00','20:10:00','2026-05-24 06:04:43','2026-05-24 06:04:43',NULL);
/*!40000 ALTER TABLE `class_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_term`
--

DROP TABLE IF EXISTS `class_term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_term` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isPass` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_term_class_id_foreign` (`class_id`),
  KEY `class_term_academic_term_id_foreign` (`academic_term_id`),
  CONSTRAINT `class_term_academic_term_id_foreign` FOREIGN KEY (`academic_term_id`) REFERENCES `academic_term` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_term_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_term`
--

LOCK TABLES `class_term` WRITE;
/*!40000 ALTER TABLE `class_term` DISABLE KEYS */;
INSERT INTO `class_term` VALUES ('019e5a14-0445-7225-8eb1-c2e0c30bd19e','019e5a10-6f0f-730b-a0ac-06c98ed97e58','019e5a10-36de-70b3-8f16-7c4667d3f29e',0,'2026-05-24 06:02:01','2026-05-24 06:02:01',NULL),('019e5a14-2e61-739d-a8ca-46cd9510fae3','019e5a10-952c-71a8-b5e3-1a1a102c56da','019e5a10-36de-70b3-8f16-7c4667d3f29e',0,'2026-05-24 06:02:12','2026-05-24 06:02:12',NULL),('019e5a14-6d54-709e-bac2-843b1d9c7403','019e5a10-bae6-700f-935f-34bb5fd154e7','019e5a10-36de-70b3-8f16-7c4667d3f29e',0,'2026-05-24 06:02:28','2026-05-24 06:02:28',NULL),('019e5a14-ba21-73d8-a2f4-1108adeae15d','019e5a10-6f0f-730b-a0ac-06c98ed97e58','019e5a10-0c19-7199-9408-c85b54afd568',0,'2026-05-24 06:02:48','2026-05-24 06:02:48',NULL),('019e5a14-ba27-71f0-a748-8de9c9d4fefb','019e5a10-952c-71a8-b5e3-1a1a102c56da','019e5a10-0c19-7199-9408-c85b54afd568',0,'2026-05-24 06:02:48','2026-05-24 06:02:48',NULL),('019e5a14-ba28-7213-8c3a-94121b79bf72','019e5a10-bae6-700f-935f-34bb5fd154e7','019e5a10-0c19-7199-9408-c85b54afd568',0,'2026-05-24 06:02:48','2026-05-24 06:02:48',NULL);
/*!40000 ALTER TABLE `class_term` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_term_counseling`
--

DROP TABLE IF EXISTS `class_term_counseling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_term_counseling` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `counseling_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_term_counseling_class_term_id_foreign` (`class_term_id`),
  KEY `class_term_counseling_counseling_id_foreign` (`counseling_id`),
  CONSTRAINT `class_term_counseling_class_term_id_foreign` FOREIGN KEY (`class_term_id`) REFERENCES `class_term` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_term_counseling_counseling_id_foreign` FOREIGN KEY (`counseling_id`) REFERENCES `counseling` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_term_counseling`
--

LOCK TABLES `class_term_counseling` WRITE;
/*!40000 ALTER TABLE `class_term_counseling` DISABLE KEYS */;
INSERT INTO `class_term_counseling` VALUES ('019e5a17-4704-72b4-8e8e-5abcfab49ac2','019e5a14-0445-7225-8eb1-c2e0c30bd19e','019e5a12-3328-7337-ad75-369796c23db8','2026-05-24 06:05:35','2026-05-24 06:05:35',NULL);
/*!40000 ALTER TABLE `class_term_counseling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_term_extracurricular`
--

DROP TABLE IF EXISTS `class_term_extracurricular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_term_extracurricular` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extracurricular_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_term_extracurricular_class_term_id_foreign` (`class_term_id`),
  KEY `class_term_extracurricular_extracurricular_id_foreign` (`extracurricular_id`),
  CONSTRAINT `class_term_extracurricular_class_term_id_foreign` FOREIGN KEY (`class_term_id`) REFERENCES `class_term` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_term_extracurricular_extracurricular_id_foreign` FOREIGN KEY (`extracurricular_id`) REFERENCES `extracurricular` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_term_extracurricular`
--

LOCK TABLES `class_term_extracurricular` WRITE;
/*!40000 ALTER TABLE `class_term_extracurricular` DISABLE KEYS */;
INSERT INTO `class_term_extracurricular` VALUES ('019e5a17-46ff-707e-8cbc-7dd0cae384bb','019e5a14-0445-7225-8eb1-c2e0c30bd19e','019e5a11-606a-73bb-a1a8-316d4017780f','2026-05-24 06:05:35','2026-05-24 06:05:35',NULL);
/*!40000 ALTER TABLE `class_term_extracurricular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_term_subject`
--

DROP TABLE IF EXISTS `class_term_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_term_subject` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_term_subject_class_term_id_foreign` (`class_term_id`),
  KEY `class_term_subject_subject_id_foreign` (`subject_id`),
  CONSTRAINT `class_term_subject_class_term_id_foreign` FOREIGN KEY (`class_term_id`) REFERENCES `class_term` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_term_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_term_subject`
--

LOCK TABLES `class_term_subject` WRITE;
/*!40000 ALTER TABLE `class_term_subject` DISABLE KEYS */;
INSERT INTO `class_term_subject` VALUES ('019e5a17-46f6-70ac-b557-868a335a3a0f','019e5a14-0445-7225-8eb1-c2e0c30bd19e','019e5a11-fa49-7351-890e-b7ff244035bf','2026-05-24 06:05:35','2026-05-24 06:05:35',NULL);
/*!40000 ALTER TABLE `class_term_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counseling`
--

DROP TABLE IF EXISTS `counseling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `counseling` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counseling`
--

LOCK TABLES `counseling` WRITE;
/*!40000 ALTER TABLE `counseling` DISABLE KEYS */;
INSERT INTO `counseling` VALUES ('019e5a12-3328-7337-ad75-369796c23db8','7 Kebiasaan Indonesia Hebat','2026-05-24 06:00:02','2026-05-24 06:01:30',NULL);
/*!40000 ALTER TABLE `counseling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counseling_assessment`
--

DROP TABLE IF EXISTS `counseling_assessment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `counseling_assessment` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `counseling_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `counseling_assessment_counseling_id_foreign` (`counseling_id`),
  CONSTRAINT `counseling_assessment_counseling_id_foreign` FOREIGN KEY (`counseling_id`) REFERENCES `counseling` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counseling_assessment`
--

LOCK TABLES `counseling_assessment` WRITE;
/*!40000 ALTER TABLE `counseling_assessment` DISABLE KEYS */;
INSERT INTO `counseling_assessment` VALUES ('019e5a13-8b50-7380-8337-c39f739c2ff5','019e5a12-3328-7337-ad75-369796c23db8','BANGUN PAGI','2026-05-24 06:01:30','2026-05-24 06:01:30',NULL),('019e5a13-8b53-7275-896c-88372cdc42cb','019e5a12-3328-7337-ad75-369796c23db8','BERIBADAH','2026-05-24 06:01:30','2026-05-24 06:01:30',NULL);
/*!40000 ALTER TABLE `counseling_assessment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumen_pendaftaran`
--

DROP TABLE IF EXISTS `dokumen_pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen_pendaftaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` bigint unsigned NOT NULL,
  `jenis_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokumen_pendaftaran_registration_id_foreign` (`registration_id`),
  CONSTRAINT `dokumen_pendaftaran_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumen_pendaftaran`
--

LOCK TABLES `dokumen_pendaftaran` WRITE;
/*!40000 ALTER TABLE `dokumen_pendaftaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `dokumen_pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extracurricular`
--

DROP TABLE IF EXISTS `extracurricular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extracurricular` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extracurricular`
--

LOCK TABLES `extracurricular` WRITE;
/*!40000 ALTER TABLE `extracurricular` DISABLE KEYS */;
INSERT INTO `extracurricular` VALUES ('019e5a11-606a-73bb-a1a8-316d4017780f','Karate','2026-05-24 05:59:08','2026-05-24 05:59:08',NULL),('019e5a11-b544-712e-8223-5e8ab09f398c','Berenang','2026-05-24 05:59:30','2026-05-24 05:59:35','2026-05-24 05:59:35'),('019e5a68-569f-709d-97ed-153b46ffe9ab','Berenang','2026-05-24 07:34:07','2026-05-24 07:34:12','2026-05-24 07:34:12'),('019e5a68-8edc-72cf-8747-6d40376b699f','Berenang','2026-05-24 07:34:22','2026-05-24 07:34:27','2026-05-24 07:34:27');
/*!40000 ALTER TABLE `extracurricular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extracurricular_assessment`
--

DROP TABLE IF EXISTS `extracurricular_assessment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extracurricular_assessment` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extracurricular_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `extracurricular_assessment_extracurricular_id_foreign` (`extracurricular_id`),
  CONSTRAINT `extracurricular_assessment_extracurricular_id_foreign` FOREIGN KEY (`extracurricular_id`) REFERENCES `extracurricular` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extracurricular_assessment`
--

LOCK TABLES `extracurricular_assessment` WRITE;
/*!40000 ALTER TABLE `extracurricular_assessment` DISABLE KEYS */;
INSERT INTO `extracurricular_assessment` VALUES ('019e5a11-6090-70fb-b760-e3f5bda61edb','019e5a11-606a-73bb-a1a8-316d4017780f','kekuatan','2026-05-24 05:59:08','2026-05-24 05:59:08',NULL),('019e5a11-b54c-71d4-b426-0417246a397c','019e5a11-b544-712e-8223-5e8ab09f398c','Kecepatan','2026-05-24 05:59:30','2026-05-24 05:59:35','2026-05-24 05:59:35');
/*!40000 ALTER TABLE `extracurricular_assessment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_03_02_000002_create_students_table',1),(5,'2026_03_02_000003_create_attendances_table',1),(6,'2026_03_02_000004_create_reports_table',1),(7,'2026_03_02_000005_create_schedules_table',1),(8,'2026_03_02_000006_create_chats_table',1),(9,'2026_03_02_000007_create_notifications_table',1),(10,'2026_03_02_000008_create_registrations_table',1),(11,'2026_03_02_000009_create_dokumen_pendaftaran_table',1),(12,'2026_03_07_132547_create_semester_reports_table',1),(13,'2026_04_09_221314_add_columns_to_students_table',1),(14,'2026_04_15_000001_add_pendidikan_to_registrations_table',1),(15,'2026_04_15_000002_add_nik_to_registrations_table',1),(16,'2026_05_15_000001_create_erd_schema_tables',1),(17,'2026_05_17_000001_add_fields_to_registrations_table',1),(18,'2026_05_17_000002_alter_user_status_enum',1),(19,'2026_05_17_000003_add_status_to_academic_term_table',1),(20,'2026_05_17_000004_add_aksi_to_student_enrollment_table',1),(21,'2026_05_18_152114_alter_class_schedule_hour_to_start_end_hour',1),(22,'2026_05_18_152716_alter_activity_schedule_hour_to_start_end_hour',1),(23,'2026_05_18_160311_alter_report_counseling_score_nullable_week_date',1),(24,'2026_05_18_185110_alter_private_counseling_schedule_nullable_student',1),(25,'2026_05_19_000001_create_chat_room_table',1),(26,'2026_05_19_000002_create_chat_message_table',1),(27,'2026_05_19_182734_update_counseling_status_enum',1),(28,'2026_05_20_000001_create_activity_table',1),(29,'2026_05_21_000001_add_isRead_to_chat_message',1),(30,'2026_05_24_000001_add_source_to_private_counseling_schedule',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parent` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('ayah','ibu','wali') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_student_id_foreign` (`student_id`),
  CONSTRAINT `parent_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent`
--

LOCK TABLES `parent` WRITE;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
INSERT INTO `parent` VALUES ('019e5a0c-1f50-7078-b061-45d9e09b89a4','019e5a0c-1f26-73af-a6a7-eea52dd6a448','ayah','Ari Kristianto','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-1f56-7135-b56b-806b9f99c245','019e5a0c-1f26-73af-a6a7-eea52dd6a448','ibu','Nurwahyuni','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-20cd-73db-bda0-53651b5bdbe6','019e5a0c-20c7-7224-b0c3-65f9bfda31d9','ayah','Ujang Afriyadi','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-20d3-70eb-adfd-c89ce2396317','019e5a0c-20c7-7224-b0c3-65f9bfda31d9','ibu','Diana Utami Putri Apandi','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-2241-7275-a20e-2bd28e4d6d2c','019e5a0c-223c-7145-bf8b-7cd19d645783','ayah','Andrian Suryana','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-2246-7175-9792-361a1751600f','019e5a0c-223c-7145-bf8b-7cd19d645783','ibu','Kencana Wulan Sari','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-23bf-70ab-ac31-3d8c8cc8c075','019e5a0c-23ba-72db-bcf2-3c7ab8e9081a','ayah','Alek Efendi','Lainnya',NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-23c4-711c-b97d-4d4681398792','019e5a0c-23ba-72db-bcf2-3c7ab8e9081a','ibu','Anggraeni Dwi Puspitasari','Lainnya',NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-2536-7055-a8b3-017fb3c0aba7','019e5a0c-2531-72df-8065-822afbd00101','ayah','Indra Wijaya','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-253b-737f-b8a5-024141998246','019e5a0c-2531-72df-8065-822afbd00101','ibu','Qonaatul Choiro','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-26ad-71d1-b9ce-2540b4322f1c','019e5a0c-26a7-71e5-a34d-fb4f78e7168f','ayah','Herri Adinata','PNS/TNI/Polri',NULL,NULL,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-26b2-73ab-b838-d8240955b607','019e5a0c-26a7-71e5-a34d-fb4f78e7168f','ibu','Indah Putri Agustina','PNS/TNI/Polri',NULL,NULL,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-2825-711f-8810-00cccb9161e0','019e5a0c-281f-7281-9d68-08e24d47beed','ayah','Ari Kurniawan Saputra','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-282a-731d-9c1a-6ffb3dc24901','019e5a0c-281f-7281-9d68-08e24d47beed','ibu','Cahyani Mutiara Wan P','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-299c-71cb-8561-f30acf9ad120','019e5a0c-2997-7397-8e8f-86c0b3e1cc6a','ayah','Hendriawan','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-29a1-732a-a093-0b87495fb04e','019e5a0c-2997-7397-8e8f-86c0b3e1cc6a','ibu','Diana Febriana','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2b12-713d-ad19-d8361ccb03e4','019e5a0c-2b0c-70e4-92e8-ef139633dcc9','ayah','Adi Setiawan','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2b17-73c4-a875-2707dcbd4fb8','019e5a0c-2b0c-70e4-92e8-ef139633dcc9','ibu','Indah Wahyu Setiawati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2c8d-706d-8fab-89ff9c71c8d6','019e5a0c-2c88-7060-8724-76457b436971','ayah','Sudirman','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2c92-72a5-a149-55ec6c5b3d36','019e5a0c-2c88-7060-8724-76457b436971','ibu','Julia Sari','IRT',NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2e0c-7059-9afc-3db680122094','019e5a0c-2e06-723f-859e-86537ce7668a','ayah','Radi Aditama Sanjaya','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-2e12-7227-ad5a-ef54cee23cfa','019e5a0c-2e06-723f-859e-86537ce7668a','ibu','Nuraini','Guru',NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-2f8e-726b-8cca-9814c9582d77','019e5a0c-2f88-7211-81c0-9862a8235804','ayah','Erpandi','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-2f94-719c-87e5-0b21c7a9cdcb','019e5a0c-2f88-7211-81c0-9862a8235804','ibu','Jumiati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-3114-7054-9c9f-6d0245e85b62','019e5a0c-310f-7332-aff4-12aed239094b','ayah','Hendri Nopriyanto','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-311a-73de-9293-a521d12019c1','019e5a0c-310f-7332-aff4-12aed239094b','ibu','Soraya','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-3295-7149-aa60-70b08d61fd91','019e5a0c-3290-735a-be7c-f44330f5b456','ayah','Akbar Syah Putra','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-3299-70b2-99b6-1ce2cfb9e7bd','019e5a0c-3290-735a-be7c-f44330f5b456','ibu','Fina Alfianita Sari','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-3410-7282-97e7-7052e5279a0e','019e5a0c-340a-71e0-ab18-04d32010cc5c','ayah','Hasan Nudin','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-3415-718f-b583-8a97a76150af','019e5a0c-340a-71e0-ab18-04d32010cc5c','ibu','Aulia Bunga Safitri','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-3588-72c1-8ed7-790c8ff4fd05','019e5a0c-3582-7258-9b8a-b9bb623a1375','ayah','Juliyanto','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-358d-7268-bb2d-b8a44a96e735','019e5a0c-3582-7258-9b8a-b9bb623a1375','ibu','Apriliyawati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-3700-7338-8134-0d21b0d3018a','019e5a0c-36fa-72e6-b9cd-d29481e0cd08','ayah','Janssen Cahyadi','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-3705-72c4-a778-163dabd0aa84','019e5a0c-36fa-72e6-b9cd-d29481e0cd08','ibu','Putri Syadza Sausan','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-387b-7015-bb97-3309d58f20af','019e5a0c-3876-7133-a88a-557af81fca8e','ayah','Beny Septianto','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-3880-730a-8ddc-9f91559c5af5','019e5a0c-3876-7133-a88a-557af81fca8e','ibu','Vivi Selvia Athaga','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-39f1-72c4-a838-e51681f91b87','019e5a0c-39ec-7166-9544-9af7e2c74286','ayah','Irawan Suki','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-39f7-7178-a5d2-e4271ffbce11','019e5a0c-39ec-7166-9544-9af7e2c74286','ibu','Irna Wati','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3b6c-72cb-889d-59c5cf601b20','019e5a0c-3b66-7395-830f-a9e60e500dd3','ayah','Andrian Suryana','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3b71-704f-8ca2-abe71c184b3a','019e5a0c-3b66-7395-830f-a9e60e500dd3','ibu','Kencana Wulan Sari','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3ce4-721b-8b36-bdb91303cb33','019e5a0c-3cde-718b-bfed-3a808f5d663f','ayah','Aria Kusuma','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-3cea-73c4-9505-9e17d2c245e3','019e5a0c-3cde-718b-bfed-3a808f5d663f','ibu','Puji Saka Anggraini','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-3e5b-705c-b69d-d82d1927fe02','019e5a0c-3e56-7175-b945-348b67932e39','ayah','Thoni Riswandi','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-3e60-730f-8641-858e20ad1478','019e5a0c-3e56-7175-b945-348b67932e39','ibu','Sutinah','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-3fd5-7228-b67b-c5e27b6ad31c','019e5a0c-3fcf-730b-ab9f-944f61803496','ayah','Jefriyanto','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-3fd9-7125-b387-595f5d279353','019e5a0c-3fcf-730b-ab9f-944f61803496','ibu','Febri Ratna Sari','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-414a-7140-8d9b-e09c9e8f9bf8','019e5a0c-4145-71b4-894d-661d7bec8089','ayah','Endi Hermawan','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-4150-72c6-b331-7612e4ef359a','019e5a0c-4145-71b4-894d-661d7bec8089','ibu','Umiga Utami','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-42d7-7338-ab4d-7f5ae7f35fe5','019e5a0c-42d1-70ba-9889-cbfc7e37f681','ayah','Yana Rodiana','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-42dd-72ab-9a4e-19507ced1f59','019e5a0c-42d1-70ba-9889-cbfc7e37f681','ibu','Usniawati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-4452-7253-9427-fbb1f0666569','019e5a0c-444c-73a6-80c8-3ad4ee00e848','ayah','Slamet Riyadi Dame','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-4457-7288-9d39-6a91519f2123','019e5a0c-444c-73a6-80c8-3ad4ee00e848','ibu','Evi Haryanti','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-45cb-710b-b2c7-cd1a0798ebb1','019e5a0c-45c5-7231-989a-a791ae5746a9','ayah','Slamet Riyadi Dame','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-45d1-7387-9ee4-88013730a189','019e5a0c-45c5-7231-989a-a791ae5746a9','ibu','Evi Haryanti','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-4746-70eb-aeb8-da4c782a5f81','019e5a0c-4741-7167-a763-43cdf293508e','ayah','Andri Hadi','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-474b-7247-b187-0449269e1bf2','019e5a0c-4741-7167-a763-43cdf293508e','ibu','Menik Anjarwati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-48c7-70a7-bf41-d0b3433a3e98','019e5a0c-48c2-70e3-963a-47738397e01d','ayah','Al Roy Triwidianto','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-48cc-7219-84ed-a6ae67914d76','019e5a0c-48c2-70e3-963a-47738397e01d','ibu','Putri Meika Andriani','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4a3c-7149-8e5e-4550e00b2543','019e5a0c-4a36-70a3-9833-0edc70285764','ayah','Joni Satriya','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4a43-73bc-8a1f-e3bef9f98651','019e5a0c-4a36-70a3-9833-0edc70285764','ibu','Fizri Via Agustina','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4bb6-70f4-9c8c-6a0a7b72dca4','019e5a0c-4bb2-7325-bae4-87be07e90da2','ayah','Nazarudin','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4bbb-70e1-90cc-0217200c50cf','019e5a0c-4bb2-7325-bae4-87be07e90da2','ibu','Tio Dorma Silalahi','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4d31-713d-b66d-40de90983add','019e5a0c-4d2a-724a-868f-f9462102823e','ayah','Ahmad Yani','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-4d36-71e8-93c0-d55f16f19870','019e5a0c-4d2a-724a-868f-f9462102823e','ibu','Ela Lastari','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-4eb6-7326-9a41-b2252145e040','019e5a0c-4eb0-7102-8224-8c61b9543c77','ayah','Somad Pinanda','Petani',NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-4ebb-7069-a1a6-06cfbd79a897','019e5a0c-4eb0-7102-8224-8c61b9543c77','ibu','Tuti Maryati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-5032-7116-a9d4-ea5ce7c28e99','019e5a0c-502d-73c4-9f97-1b6f1a86d37b','ayah','Ari Susilo','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-5037-72dd-a9ae-caee78a04bd5','019e5a0c-502d-73c4-9f97-1b6f1a86d37b','ibu','Faradillah Chairunnisa','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-51a7-707d-90f6-1a2010aa4704','019e5a0c-51a2-7355-83fd-4f5ec4f49d75','ayah','Agung Setiawan','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-51ad-730e-8c2a-d86d1b7e3662','019e5a0c-51a2-7355-83fd-4f5ec4f49d75','ibu','Ika Kusumawardani','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-5323-7174-a76b-301596190eb2','019e5a0c-531e-7306-8e55-81f039fe8dfd','ayah','Muhamad Rizki','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-5328-7265-b43d-6e3605ff6627','019e5a0c-531e-7306-8e55-81f039fe8dfd','ibu','Dini Oktavianti','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-549f-70c6-b099-8b6b6c30b2bc','019e5a0c-549a-726a-92f2-bb5173d59a7c','ayah','Rizki Ramadhan','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-54a5-70bb-9586-e5b85b3e2dda','019e5a0c-549a-726a-92f2-bb5173d59a7c','ibu','Siti Nurhaliza','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-5618-7085-9b3b-74f8f5db0957','019e5a0c-5612-7219-8a4c-5f04d05fdfc6','ayah','Dedi Setiawan','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-561d-7333-91e0-b8bb64c05b96','019e5a0c-5612-7219-8a4c-5f04d05fdfc6','ibu','Rina Wati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-5795-707a-ab77-4a450a37f461','019e5a0c-578f-72a4-8f39-75136db76003','ayah','Ibrahim Sholeh','PNS/TNI/Polri',NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-579b-70a6-af8c-b29e4e14e49d','019e5a0c-578f-72a4-8f39-75136db76003','ibu','Fatimah','Guru',NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-5914-7388-a9e9-1fb528d3c538','019e5a0c-590f-71dc-b589-0380885f1f8c','ayah','Hendra Gunawan','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-591a-7285-847f-f852be5ddf83','019e5a0c-590f-71dc-b589-0380885f1f8c','ibu','Yanti Ramadhani','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5a8f-7321-8a36-ad335d7c00cb','019e5a0c-5a89-71cd-ae6e-b35581e2ef68','ayah','Budi Pratama','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5a94-70d0-b851-9dc57c4705ba','019e5a0c-5a89-71cd-ae6e-b35581e2ef68','ibu','Lia Susanti','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5c08-7265-94e4-b73b88665d1f','019e5a0c-5c03-7119-8a2b-c74b58468318','ayah','Wahyu Hidayat','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5c0d-7094-9e2e-cd3774e72416','019e5a0c-5c03-7119-8a2b-c74b58468318','ibu','Dewi Lestari','IRT',NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5d82-7309-a45d-bc9c829438de','019e5a0c-5d7d-7306-b30c-b17270d2d510','ayah','Fauzan Hakim','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-5d87-7017-9216-86860d38e768','019e5a0c-5d7d-7306-b30c-b17270d2d510','ibu','Novia Sari','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-5eff-7217-93f1-f2ce982c4ad8','019e5a0c-5efa-7069-9060-f3b04eed7c1b','ayah','Eko Purwanto','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-5f04-7196-a149-ecc6cc8cd691','019e5a0c-5efa-7069-9060-f3b04eed7c1b','ibu','Sri Wahyuni','Guru',NULL,NULL,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-6088-7291-97ca-b5a3cfa4e6f0','019e5a0c-6083-7360-9b02-5109d76092b3','ayah','Arya Wibowo','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-608e-73b5-910b-21a1617805cd','019e5a0c-6083-7360-9b02-5109d76092b3','ibu','Mega Lestari','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-61fd-71eb-b516-37a2b60b0a3f','019e5a0c-61f8-7288-8381-75bc42cce785','ayah','Doni Rahayu','Petani',NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-6204-712d-8759-2bc5ffbd26b0','019e5a0c-61f8-7288-8381-75bc42cce785','ibu','Indri Yani','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-6379-7220-99c8-325417fcb0f7','019e5a0c-6374-7255-bbf6-94200f70c633','ayah','Santoso','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-637e-7369-a256-88a69e24ed47','019e5a0c-6374-7255-bbf6-94200f70c633','ibu','Linda Pratiwi','Karyawan Swasta',NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-64f0-70d8-a584-0923b3e5bed2','019e5a0c-64eb-72e1-9c93-a7aa53d49c3e','ayah','Syaifudin','Buruh',NULL,NULL,NULL,'2026-05-24 05:53:42','2026-05-24 05:53:42',NULL),('019e5a0c-64f6-71ca-a2cd-71f4d04218b1','019e5a0c-64eb-72e1-9c93-a7aa53d49c3e','ibu','Afifah Rahmawati','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:42','2026-05-24 05:53:42',NULL),('019e5a0c-666b-7218-8fc3-163ce191f94c','019e5a0c-6666-72b1-a381-352203f03472','ayah','Hakim Maulana','Wiraswasta',NULL,NULL,NULL,'2026-05-24 05:53:42','2026-05-24 05:53:42',NULL),('019e5a0c-6670-72a7-9109-d1c20a9d5d67','019e5a0c-6666-72b1-a381-352203f03472','ibu','Yeni Kurniasih','IRT',NULL,NULL,NULL,'2026-05-24 05:53:42','2026-05-24 05:53:42',NULL),('019e5a0c-67e0-7378-b623-c3690f3fbf24','019e5a0c-67db-709f-95e4-3296d363b045','ayah','Nuraini Ahmad','Petani',NULL,NULL,NULL,'2026-05-24 05:53:43','2026-05-24 05:53:43',NULL),('019e5a0c-67e5-70c1-ac5e-9b30db57ba05','019e5a0c-67db-709f-95e4-3296d363b045','ibu','Susi Rahayu','Tidak bekerja',NULL,NULL,NULL,'2026-05-24 05:53:43','2026-05-24 05:53:43',NULL);
/*!40000 ALTER TABLE `parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `presence`
--

DROP TABLE IF EXISTS `presence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presence` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_class_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `attendance` enum('hadir','izin','sakit','alpa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `presence_student_class_id_foreign` (`student_class_id`),
  CONSTRAINT `presence_student_class_id_foreign` FOREIGN KEY (`student_class_id`) REFERENCES `student_enrollment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presence`
--

LOCK TABLES `presence` WRITE;
/*!40000 ALTER TABLE `presence` DISABLE KEYS */;
INSERT INTO `presence` VALUES ('019e5a15-add6-7304-9f8a-cad92535fa43','019e5a14-044b-7150-8e10-f59ba6988257','2026-05-24','hadir',NULL,'2026-05-24 06:03:50','2026-05-24 06:03:50',NULL);
/*!40000 ALTER TABLE `presence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `private_counseling_schedule`
--

DROP TABLE IF EXISTS `private_counseling_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `private_counseling_schedule` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `date` date NOT NULL,
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `topic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `private_counseling_schedule_student_id_foreign` (`student_id`),
  KEY `private_counseling_schedule_teacher_id_foreign` (`teacher_id`),
  KEY `private_counseling_schedule_class_term_id_foreign` (`class_term_id`),
  CONSTRAINT `private_counseling_schedule_class_term_id_foreign` FOREIGN KEY (`class_term_id`) REFERENCES `class_term` (`id`) ON DELETE CASCADE,
  CONSTRAINT `private_counseling_schedule_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `private_counseling_schedule_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `private_counseling_schedule`
--

LOCK TABLES `private_counseling_schedule` WRITE;
/*!40000 ALTER TABLE `private_counseling_schedule` DISABLE KEYS */;
INSERT INTO `private_counseling_schedule` VALUES ('019e5b1e-184e-70b4-bb14-a92a2b214e35',NULL,'019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a14-0445-7225-8eb1-c2e0c30bd19e','approved','2026-06-02','08:53:00','09:53:00','Pertemuan Kelas','guru','2026-05-24 10:52:39','2026-05-24 11:04:09',NULL),('019e5b1e-ec28-727a-acb9-6ae8d95f6e39',NULL,'019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a14-0445-7225-8eb1-c2e0c30bd19e','approved','2026-06-02','09:15:00','10:56:00','Kelas Parenting','guru','2026-05-24 10:53:33','2026-05-24 11:04:33',NULL),('019e5b26-f5d6-7251-922d-33111bf8ea7b','019e5a0c-665b-7199-b129-c40e600bad20','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a14-0445-7225-8eb1-c2e0c30bd19e','pending','2026-06-16','09:01:00','09:30:00','Perilaku Sehari-hari','orangtua','2026-05-24 11:02:20','2026-05-24 11:02:20',NULL),('019e6041-4ec8-72ab-85b7-d430a7bbd28c','019e5a0c-665b-7199-b129-c40e600bad20','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a14-0445-7225-8eb1-c2e0c30bd19e','approved','2026-05-26','03:52:00','04:54:00','QQQ','orangtua','2026-05-25 10:49:13','2026-05-25 10:50:35',NULL),('019e6042-7ac8-717f-928c-3a13c059807a',NULL,'019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a14-0445-7225-8eb1-c2e0c30bd19e','approved','2026-05-26','05:50:00','06:50:00','WWWWWWWWW','guru','2026-05-25 10:50:30','2026-05-25 10:51:37',NULL),('019e6043-1d6c-73bf-bc1b-f54089cba5ac','019e5a0c-665b-7199-b129-c40e600bad20','019e5a0c-1ada-71b7-ba2a-1eea7425cf70','019e5a14-0445-7225-8eb1-c2e0c30bd19e','approved','2026-05-27','12:56:00','21:55:00','rrrr','guru','2026-05-25 10:51:11','2026-05-25 10:51:31',NULL);
/*!40000 ALTER TABLE `private_counseling_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_pendaftaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_panggilan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_siswa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `anak_ke` int DEFAULT NULL,
  `jumlah_saudara` int DEFAULT NULL,
  `suku_bangsa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `riwayat_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL,
  `nama_ayah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ibu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir_ayah` date DEFAULT NULL,
  `no_telp_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan_wali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir_wali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir_wali` date DEFAULT NULL,
  `no_telp_wali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir_ibu` date DEFAULT NULL,
  `no_telp_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_wali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_wali` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_ortu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_ortu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','review','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registrations_kode_pendaftaran_unique` (`kode_pendaftaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrations`
--

LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_enrollment_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_student_enrollment_id_foreign` (`student_enrollment_id`),
  CONSTRAINT `report_student_enrollment_id_foreign` FOREIGN KEY (`student_enrollment_id`) REFERENCES `student_enrollment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
INSERT INTO `report` VALUES ('019e5a18-0bef-7140-af95-a63a3a669a83','019e5a14-044b-7150-8e10-f59ba6988257','2026-05-24 06:06:25','2026-05-24 06:06:25',NULL);
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_counseling`
--

DROP TABLE IF EXISTS `report_counseling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_counseling` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `counseling_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_counseling_report_id_foreign` (`report_id`),
  KEY `report_counseling_counseling_id_foreign` (`counseling_id`),
  CONSTRAINT `report_counseling_counseling_id_foreign` FOREIGN KEY (`counseling_id`) REFERENCES `counseling` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_counseling_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `report` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_counseling`
--

LOCK TABLES `report_counseling` WRITE;
/*!40000 ALTER TABLE `report_counseling` DISABLE KEYS */;
INSERT INTO `report_counseling` VALUES ('019e5a18-0c69-7166-886b-efff42104e0f','019e5a18-0bef-7140-af95-a63a3a669a83','019e5a12-3328-7337-ad75-369796c23db8','2026-05-24 06:06:26','2026-05-24 06:06:26',NULL);
/*!40000 ALTER TABLE `report_counseling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_counseling_score`
--

DROP TABLE IF EXISTS `report_counseling_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_counseling_score` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_counseling_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `counseling_assessment_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('BB','MB','BSH','BSB') COLLATE utf8mb4_unicode_ci NOT NULL,
  `week` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rcon_score_rcon` (`report_counseling_id`),
  KEY `fk_rcon_score_assess` (`counseling_assessment_id`),
  CONSTRAINT `fk_rcon_score_assess` FOREIGN KEY (`counseling_assessment_id`) REFERENCES `counseling_assessment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rcon_score_rcon` FOREIGN KEY (`report_counseling_id`) REFERENCES `report_counseling` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_counseling_score`
--

LOCK TABLES `report_counseling_score` WRITE;
/*!40000 ALTER TABLE `report_counseling_score` DISABLE KEYS */;
INSERT INTO `report_counseling_score` VALUES ('019e5a18-0c71-7146-b883-5739c2b2153b','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b50-7380-8337-c39f739c2ff5','MB',1,'2026-04-28','2026-05-24 06:06:26','2026-05-24 06:06:26',NULL),('019e5a18-0c7a-7300-acb5-b79ce0ba7351','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b53-7275-896c-88372cdc42cb','BB',1,'2026-04-28','2026-05-24 06:06:26','2026-05-24 06:06:26',NULL),('019e5a18-59f2-7011-8617-b66c85d73f2c','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b50-7380-8337-c39f739c2ff5','BB',2,'2026-05-05','2026-05-24 06:06:45','2026-05-24 06:06:45',NULL),('019e5a18-5a3d-7350-bdc1-68e10fa7ddd5','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b53-7275-896c-88372cdc42cb','BSH',2,'2026-05-05','2026-05-24 06:06:45','2026-05-24 06:06:45',NULL),('019e5a18-a767-72e3-aacf-e98e9143c088','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b50-7380-8337-c39f739c2ff5','BSB',3,'2026-05-14','2026-05-24 06:07:05','2026-05-24 06:07:05',NULL),('019e5a18-a7b2-7283-91ae-e362f1d57b49','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b53-7275-896c-88372cdc42cb','BSH',3,'2026-05-14','2026-05-24 06:07:05','2026-05-24 06:07:05',NULL),('019e5acf-fd50-709c-a071-002c60470832','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b50-7380-8337-c39f739c2ff5','BSH',4,'2026-05-19','2026-05-24 09:27:20','2026-05-24 09:27:20',NULL),('019e5acf-fd68-7021-912e-47e92d473d72','019e5a18-0c69-7166-886b-efff42104e0f','019e5a13-8b53-7275-896c-88372cdc42cb','BSB',4,'2026-05-19','2026-05-24 09:27:20','2026-05-24 09:27:20',NULL);
/*!40000 ALTER TABLE `report_counseling_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_extracurricular`
--

DROP TABLE IF EXISTS `report_extracurricular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_extracurricular` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extracurricular_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_extracurricular_report_id_foreign` (`report_id`),
  KEY `report_extracurricular_extracurricular_id_foreign` (`extracurricular_id`),
  CONSTRAINT `report_extracurricular_extracurricular_id_foreign` FOREIGN KEY (`extracurricular_id`) REFERENCES `extracurricular` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_extracurricular_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `report` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_extracurricular`
--

LOCK TABLES `report_extracurricular` WRITE;
/*!40000 ALTER TABLE `report_extracurricular` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_extracurricular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_extracurricular_score`
--

DROP TABLE IF EXISTS `report_extracurricular_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_extracurricular_score` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_extracurricular_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extracurricular_assessment_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('BB','MB','BSH','BSB') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rext_score_rext` (`report_extracurricular_id`),
  KEY `fk_rext_score_assess` (`extracurricular_assessment_id`),
  CONSTRAINT `fk_rext_score_assess` FOREIGN KEY (`extracurricular_assessment_id`) REFERENCES `extracurricular_assessment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rext_score_rext` FOREIGN KEY (`report_extracurricular_id`) REFERENCES `report_extracurricular` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_extracurricular_score`
--

LOCK TABLES `report_extracurricular_score` WRITE;
/*!40000 ALTER TABLE `report_extracurricular_score` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_extracurricular_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_subject`
--

DROP TABLE IF EXISTS `report_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_subject` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_subject_report_id_foreign` (`report_id`),
  KEY `report_subject_subject_id_foreign` (`subject_id`),
  CONSTRAINT `report_subject_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `report` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_subject`
--

LOCK TABLES `report_subject` WRITE;
/*!40000 ALTER TABLE `report_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_subject_image`
--

DROP TABLE IF EXISTS `report_subject_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_subject_image` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_subject_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_subject_image_report_subject_id_foreign` (`report_subject_id`),
  CONSTRAINT `report_subject_image_report_subject_id_foreign` FOREIGN KEY (`report_subject_id`) REFERENCES `report_subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_subject_image`
--

LOCK TABLES `report_subject_image` WRITE;
/*!40000 ALTER TABLE `report_subject_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_subject_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` enum('islam','christian','catholic','hindu','buddhism','confucianism') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'islam',
  `birth_order` int DEFAULT NULL,
  `siblings_count` int DEFAULT NULL,
  `ethnicity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `illness_history` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_ayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_ibu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_induk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_user_id_foreign` (`user_id`),
  CONSTRAINT `student_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('019e5a0c-1f26-73af-a6a7-eea52dd6a448','019e5a0c-1f1a-70ba-bd2d-5994b00b88cf','ALVARO ATHAYA ARIYUN','L','121','3202858632','Bandar Lampung','2020-11-07','1871140711200001','Jl Untung Suropati LK II','081271459987','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-20c7-7224-b0c3-65f9bfda31d9','019e5a0c-20bc-7104-8246-f0fe063c0576','M. RAFFA ALFATIH AFRIYADI','L','144','3201575054','Solo','2020-11-22','1871102211200001','Jl. Untung Suropati Gg Harum No 65','085273678410','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-223c-7145-bf8b-7cd19d645783','019e5a0c-2232-711f-ad75-63f7144b50f4','MAHENDRA ANDRIAN','L',NULL,'3219058996','Bandar Lampung','2021-03-10','1871141003210001','Komp. Perum Pancabakti No 63',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-23ba-72db-bcf2-3c7ab8e9081a','019e5a0c-23af-71da-a67e-0ab4b0216426','MUHAMMAD AMMAR FADHILAH','L','148','3203532466','Bandar Lampung','2020-12-03','1871140312200001','JL. WIJAYA KUSUMA PANCA BAKTI NO. 8 LK. II','089529894444','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-2531-72df-8065-822afbd00101','019e5a0c-2526-73bd-a7fb-9c03498f6002','MUHAMMAD MIKAIL WIJAYA','L','145','3205821892','Bandar Lampung','2020-10-22','1871142210200001','Jl Untung Suropati Gg Tanjung No 179 LK II','081990518952','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-26a7-71e5-a34d-fb4f78e7168f','019e5a0c-269c-7338-8be3-5163958e10a4','MUHAMMAD ZABDAN ANDRIAN','L','133','3211693324','Bandar Lampung','2021-03-18','1871141803210003','KOMP. P PANCA BAKTI GG. TANJUNG LK III','082176151536','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-281f-7281-9d68-08e24d47beed','019e5a0c-2815-712f-923e-f206fab61fb0','REINA MECCA KURNIAWAN','P','146','3201201694','Bandar Lampung','2020-10-19','1871145910200002','JL. BUMI MANTI GG. SURYA KENCANA NO.21 LK I','082175824510','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-2997-7397-8e8f-86c0b3e1cc6a','019e5a0c-298c-7189-861a-c0388e72fa7c','YUKI MAHARANI','P',NULL,'3218872635','Lampung Barat','2021-03-21','1804116103210001','Jl Untung Suropati Gg Dahlia',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2b0c-70e4-92e8-ef139633dcc9','019e5a0c-2b03-708d-b735-de8484eb6370','ZEVANYA KIMBERLY','P','147','3208775515','Bandar Lampung','2020-09-25','1871146509200001','JL UNTUNG SUROPATI GG RUKUN II LK II',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2c88-7060-8724-76457b436971','019e5a0c-2c7d-706d-a0d8-6b62cbdb8ced','ERLANGGA PRADIPTA BIMANTARA','L','149',NULL,'Bandar Lampung','2021-09-25','1802052509210003','Jl Untung Suropati',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2e06-723f-859e-86537ce7668a','019e5a0c-2dfb-7276-82a1-8aeb200a04da','ISHKA AGNIA','P','150',NULL,'Bandar Lampung','2022-06-10','1871145006220002','Perum Pancabakti No.95',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-2f88-7211-81c0-9862a8235804','019e5a0c-2f7d-73f3-bd16-b9d3a2c37ace','ABIL ALTAIR ERDHAFEN','L','119','3193713608','Bandar Lampung','2019-12-03','1871140312190001','JL. UNTUNG SUROPATI PANCA BAKTI NO 61 LK I','082282746766','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-310f-7332-aff4-12aed239094b','019e5a0c-3104-7254-9310-065eac6237e3','AISYAH PUTRI INAYAH','P','120','3196671765','Bandar Lampung','2019-10-25','1871146510190001','JL UNTUNG SUROPATI GG RUKUN 4 LK. II','089561006419','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-3290-735a-be7c-f44330f5b456','019e5a0c-3285-70c1-ad51-9f202f2afbe9','AKSYAHRA VYANTA HUMAIRA MECCA','P','122','3207566962','Tulang Bawang','2020-03-21','1811046103200001','Jl Raja Ratu Gg Sejahtera 2','082280041105','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-340a-71e0-ab18-04d32010cc5c','019e5a0c-3400-71d2-8d15-3e4e1d492611','AQILA ZALFA HASANAH','P','125','3208035104','Bandar Lampung','2020-01-14','1871165401200001','JL. UNTUNG SUROPATI GG. FAMILY 6','083863766583','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-3582-7258-9b8a-b9bb623a1375','019e5a0c-3579-70a3-b392-3a602611c1a4','ARSYILA RAFIFAH ADELIA','P','127','3191726611','Bandar Lampung','2019-11-27','1871146711190001','JL UNTUNG SUROPATI GG RAJA RATU LK I','089570066040','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-36fa-72e6-b9cd-d29481e0cd08','019e5a0c-36f0-71f2-a2dd-3a18b9d9cda4','ATHALLA MAHER','L','123','3198334668','Bogor','2019-12-28','3271062812190005','JL WIJAYA KUSUMA GG MATAHARI 4','0895618980507','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-3876-7133-a88a-557af81fca8e','019e5a0c-386c-7314-b77e-089e90c2973c','CHEISYA SALSABILA','P','128','3199983429','Bandar Lampung','2019-12-25','1871146512190001','Jl. Untung Suropati P. Bakti Gg. asoka no 94 LK III',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-39ec-7166-9544-9af7e2c74286','019e5a0c-39e3-73e2-b286-06908269b32e','DEWI HAFIZAH IRWANA','P','130','3192155289','Bandar Lampung','2019-06-30','1871027006190002','JL WIJAYA KUSUMA PERUM PANCABAKTI LK II','081331323806','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3b66-7395-830f-a9e60e500dd3','019e5a0c-3b5c-7165-b974-a3b11ebf2bee','DIRGA ANDRIAN','L','129','3195197158','Bandar Lampung','2019-12-17','1871141712190003','Komp Perum Pancabakti No 63','088286242966','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3cde-718b-bfed-3a808f5d663f','019e5a0c-3cd5-7361-af1c-df4e91abf700','MARYAM GEBRINA KUSUMA','P','131','3193605334','Bandar Lampung','2019-09-14','1871175409190001','JL FLAMBOYAN GG.SADAR NO.8 LK.II','083866483095','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3e56-7175-b945-348b67932e39','019e5a0c-3e4c-739a-aa98-011be16c2d9b','REYHAN ALFA RISKI','L','137','3199561634','Bandar Lampung','2019-09-14','1871111409190002','JL.S.HATTA GG.PEPAYA I NO.20',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-3fcf-730b-ab9f-944f61803496','019e5a0c-3fc5-7370-89ef-9e87df5b8a05','SYAFIQ RADEVA VERDIANTO','L','141','3206973252','Bandar Lampung','2020-03-31','1871143103200004','Jl Untung Suropati Gg Rukun 2 LK II',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-4145-71b4-894d-661d7bec8089','019e5a0c-413a-7362-8888-4302d489da74','TEGUH SATRIA','L','142','3207434745','Bandar Lampung','2020-01-31','1871143101200001','JL UNTUNG SUROPATI GG RUKUN I LK I','089532316075','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-42d1-70ba-9889-cbfc7e37f681','019e5a0c-42c7-7027-8b05-06e7c89ae29b','WILDAN AMRILAH','L','143','3191730870','Bandar Lampung','2019-04-11','1871141104190003','JL UNTUNG SUROPATI GG MAKARTI LK II','081274811062','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-444c-73a6-80c8-3ad4ee00e848','019e5a0c-4442-7242-9a89-272e8c186db1','ANDHANU RHADITYA','L',NULL,'3200671971','Bandar Lampung','2020-03-01','1871140103200002','Jl Wijaya Kusuma Komp Pancabakti Gg Matahari LK II',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-45c5-7231-989a-a791ae5746a9','019e5a0c-45bb-70ca-b25b-3236f24df6ab','ANDHARU ADITYA','L',NULL,'3201524080','Bandar Lampung','2020-03-01','1871140103200001','Jl Wijaya Kusuma Komp Pancabakti Gg Matahari VII LK II',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-4741-7167-a763-43cdf293508e','019e5a0c-4736-7390-8cf7-f3e821795271','ANINDIRA CHAYRA PRATISTA','P','124','3200846419','Bandar Lampung','2020-04-09','1871144904200001','JL. UNTUNG SUROPATI GG. SEPAKAT NO 1A LK II','085758922300','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-48c2-70e3-963a-47738397e01d','019e5a0c-48b4-7169-978c-a0a0e38a917b','ARRASYA NATHANAEL WIDIANTO','L','126',NULL,'Bandar Lampung','2019-11-13','1871051311190005','JL. SRIKRESNA GG. WARU 20','08988142292','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4a36-70a3-9833-0edc70285764','019e5a0c-4a2d-7281-b185-17989a3d7d7d','KHAIRA NADHIFA SATRIYA JASA','P','132','3209801539','Bandar Lampung','2020-02-18','1871105802200001','JL. SRIKRISNA KP BAYUR','081274568944','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4bb2-7325-bae4-87be07e90da2','019e5a0c-4ba8-7027-8cdd-88fa08595d96','LUTHPI HASBI','L','134','3196466268','Simalungun','2019-08-09','1208030908190001','Jl Soekarno Hatta LK I',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4d2a-724a-868f-f9462102823e','019e5a0c-4d24-708b-8369-a3597ec48f66','NAUFAL RAMADHAN','L','138','3209376025','Gunung Sugih Besar','2020-05-01','3603020105200002','Kampung Baru','085269119394','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-4eb0-7102-8224-8c61b9543c77','019e5a0c-4ea6-70df-aa44-b1f6086b213a','NAYLA NANDA PUTRI','P','135','3202483333','Bandar Lampung','2020-03-23','1871146303200002','JL UNTUNG SUROPATI GG RAJA RATU LK I','081532722932','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-502d-73c4-9f97-1b6f1a86d37b','019e5a0c-5023-7150-b76b-9f573747af9e','RENATA ARSY SUSILO','P','139','3206861787','Bandar Lampung','2020-04-30','1871147004200001','Jl Untung Suropati Gg Tanjung No 20','081231087001','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-51a2-7355-83fd-4f5ec4f49d75','019e5a0c-5197-7167-a516-3aa42f8c9f19','SALAHUDDIN KAHFI PRAWIRANEGARA','L','140','3208144690','Bandar Lampung','2020-01-02','1871140201200001','Jl Wijaya Kusuma Gg Mawar Perum Golden Green Estate LK II','081379014810','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-531e-7306-8e55-81f039fe8dfd','019e5a0c-5314-735c-b6b4-f11d952713cd','SHEZAN NAILA SALSABILA','P','136','3192524958','Bandar Lampung','2019-11-29','1871146911190001','JL WIJAYA KUSUMA GG TANJUNG NO 174 LK II','089644228742','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-549a-726a-92f2-bb5173d59a7c','019e5a0c-5490-719c-881c-b8aa0fc67680','AZKA FATIH RAMADHAN','L',NULL,NULL,'Bandar Lampung','2020-07-12',NULL,'Jl. Teuku Umar No. 45 LK I','082145678901','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-5612-7219-8a4c-5f04d05fdfc6','019e5a0c-5608-732c-a8a3-7a19f3b50663','NABILA ZAHRA AULIA','P',NULL,NULL,'Bandar Lampung','2020-05-20',NULL,'Jl. Diponegoro Gg. Melati No. 12','085312345678','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-578f-72a4-8f39-75136db76003','019e5a0c-5789-7067-918f-ebd2cceb4427','HAFIDZ MAULANA IBRAHIM','L',NULL,NULL,'Metro','2020-02-14',NULL,'Jl. Ahmad Yani No. 78 LK III','081298765432','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-590f-71dc-b589-0380885f1f8c','019e5a0c-5905-71a5-a019-7c2ddd5ce95f','SITI AISYAH RAMADHANI','P',NULL,NULL,'Bandar Lampung','2020-08-30',NULL,'Jl. Raden Intan Gg. Kenanga No. 5','089612345678','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5a89-71cd-ae6e-b35581e2ef68','019e5a0c-5a7f-7060-90e1-20bf63b14131','FARHAN ADITYA PRATAMA','L',NULL,NULL,'Bandar Lampung','2020-04-05',NULL,'Jl. Pajajaran No. 22 LK II',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5c03-7119-8a2b-c74b58468318','019e5a0c-5bf9-7185-9e00-ecc1b7be37d6','ZAHRA NURUL IZZAH','P',NULL,NULL,'Pringsewu','2020-09-17',NULL,'Jl. Soekarno Hatta Gg. Mawar No. 3','082356781234','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5d7d-7306-b30c-b17270d2d510','019e5a0c-5d73-73d1-b8f6-bdda55075d0f','RAFI AHMAD FAUZAN','L',NULL,NULL,'Bandar Lampung','2020-06-22',NULL,'Jl. Sultan Agung No. 15 LK I','081356789012','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-5efa-7069-9060-f3b04eed7c1b','019e5a0c-5eed-7281-8b7b-701f391fdb18','KEYSHA AURELIA PUTRI','P',NULL,NULL,'Bandar Lampung','2020-01-09',NULL,'Jl. Kartini Gg. Anggrek No. 8','085678901234','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-6083-7360-9b02-5109d76092b3','019e5a0c-6078-7240-a906-3bc2c36a65b9','DZAKY ARYA WIBOWO','L',NULL,NULL,'Bandar Lampung','2020-11-03',NULL,'Jl. Hasanuddin No. 34 LK II',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-61f8-7288-8381-75bc42cce785','019e5a0c-61ee-719e-b7a1-65a6702fdce8','AULIA SAFIRA RAHAYU','P',NULL,NULL,'Lampung Selatan','2020-03-28',NULL,'Jl. Imam Bonjol Gg. Dahlia No. 6','082367890123','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-6374-7255-bbf6-94200f70c633','019e5a0c-6369-7259-ae29-7e4969539925','KEVIN PRATAMA SANTOSO','L',NULL,NULL,'Bandar Lampung','2020-10-14',NULL,'Jl. Gatot Subroto No. 56 LK III','089723456789','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-64eb-72e1-9c93-a7aa53d49c3e','019e5a0c-64e0-71f0-8b5b-0ed432fd2413','HANA NURAFIFAH','P',NULL,NULL,'Bandar Lampung','2021-01-18',NULL,'Jl. Mangga No. 12 LK I','081234509876','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:42','2026-05-24 05:53:42',NULL),('019e5a0c-6666-72b1-a381-352203f03472','019e5a0c-665b-7199-b129-c40e600bad20','NABIL HAKIM MAULANA','L',NULL,NULL,'Bandar Lampung','2020-12-25',NULL,'Jl. Flamboyan Gg. Nusa Indah No. 9',NULL,'islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:42','2026-05-24 05:53:42',NULL),('019e5a0c-67db-709f-95e4-3296d363b045','019e5a0c-67d0-7137-b420-6c44ed6497d3','SYIFA AZZAHRA NURAINI','P',NULL,NULL,'Tanggamus','2020-08-07',NULL,'Jl. Pisang No. 4 LK II','085612340987','islam',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-24 05:53:43','2026-05-24 05:53:43',NULL);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_enrollment`
--

DROP TABLE IF EXISTS `student_enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_enrollment` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_term_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','naik','tinggal','lulus','pindah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `aksi` enum('ganti_semester','ganti_kelas','tinggal_kelas') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_term_tujuan_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_enrollment_student_id_foreign` (`student_id`),
  KEY `student_enrollment_class_term_id_foreign` (`class_term_id`),
  KEY `student_enrollment_class_term_tujuan_id_foreign` (`class_term_tujuan_id`),
  CONSTRAINT `student_enrollment_class_term_id_foreign` FOREIGN KEY (`class_term_id`) REFERENCES `class_term` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_enrollment_class_term_tujuan_id_foreign` FOREIGN KEY (`class_term_tujuan_id`) REFERENCES `class_term` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_enrollment_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_enrollment`
--

LOCK TABLES `student_enrollment` WRITE;
/*!40000 ALTER TABLE `student_enrollment` DISABLE KEYS */;
INSERT INTO `student_enrollment` VALUES ('019e5a14-044b-7150-8e10-f59ba6988257','019e5a0c-6666-72b1-a381-352203f03472','019e5a14-0445-7225-8eb1-c2e0c30bd19e','aktif',NULL,NULL,'2026-05-24 06:02:01','2026-05-24 06:02:01',NULL),('019e5a14-2e68-721f-b7be-75ceee957ce7','019e5a0c-64eb-72e1-9c93-a7aa53d49c3e','019e5a14-2e61-739d-a8ca-46cd9510fae3','aktif',NULL,NULL,'2026-05-24 06:02:12','2026-05-24 06:02:12',NULL),('019e5a14-6d5c-7389-8d68-1d80de515a11','019e5a0c-67db-709f-95e4-3296d363b045','019e5a14-6d54-709e-bac2-843b1d9c7403','aktif',NULL,NULL,'2026-05-24 06:02:28','2026-05-24 06:02:28',NULL);
/*!40000 ALTER TABLE `student_enrollment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_file`
--

DROP TABLE IF EXISTS `student_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_file` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('kk','akta','foto','ktp_ortu','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_file_student_id_foreign` (`student_id`),
  CONSTRAINT `student_file_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_file`
--

LOCK TABLES `student_file` WRITE;
/*!40000 ALTER TABLE `student_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES ('019e5a11-fa49-7351-890e-b7ff244035bf','matematika','2026-05-24 05:59:48','2026-05-24 05:59:48',NULL);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','guru','orangtua') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `isGraduate` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('019e5a0c-1966-7127-81f8-e55ad8881563','Baini, S.Pd','admin@tkalistiqomah.sch.id',NULL,'$2y$12$QG.yxeiJuin.YYL9/9aG/.g7EGSgJ6/6SYbaf2UHqLNe4LQ4Vb9Mu','081200000000','admin','active',0,NULL,'2026-05-24 05:53:22','2026-05-24 05:53:22',NULL),('019e5a0c-1ada-71b7-ba2a-1eea7425cf70','Reita Wigianti, S.Si, S.Pd., Gr','reita.wigianti@tkalistiqomah.sch.id',NULL,'$2y$12$fAhTS4emFO5tpb5423b6Pe6Olxanrkh/4xmFcKzqAB/vaaGtAoVRC','081211111111','guru','active',0,NULL,'2026-05-24 05:53:23','2026-05-24 05:53:23',NULL),('019e5a0c-1c41-7196-a32c-fd3983a28ad2','Lucia Untari, S.Pd','lucia.untari@tkalistiqomah.sch.id',NULL,'$2y$12$gHb8vmf4sSybP4H5OG8/Z.kl6CbKFPd5BWy77mszKumNLVzs/zSRW','081222222222','guru','active',0,NULL,'2026-05-24 05:53:23','2026-05-24 05:53:23',NULL),('019e5a0c-1dae-72b3-b375-498d40ae74fe','Fitriyah Hariani, S.Pd','fitriyah.hariani@tkalistiqomah.sch.id',NULL,'$2y$12$uiKr63bRUJEYiE6in5nCUukUionT4JuVkARlq/JuD3SnDjrRpQWPS','081233333333','guru','active',0,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-1f1a-70ba-bd2d-5994b00b88cf','Ari Kristianto','ortu1@tkalistiqomah.sch.id',NULL,'$2y$12$EWq2k2KbfiY45XHvF.dZaeJH29tX1yrQG8z21J0r0WLU5CBaopUcy','081271459987','orangtua','pending',0,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-20bc-7104-8246-f0fe063c0576','Ujang Afriyadi','ortu2@tkalistiqomah.sch.id',NULL,'$2y$12$D1RpnOlT9syIrKQ7qAc7EOrtUtYT5EmmALkKmyzMGDezhEQJztCdC','085273678410','orangtua','pending',0,NULL,'2026-05-24 05:53:24','2026-05-24 05:53:24',NULL),('019e5a0c-2232-711f-ad75-63f7144b50f4','Andrian Suryana','ortu3@tkalistiqomah.sch.id',NULL,'$2y$12$3Q6X6RfscGEUq4Cv03/tbe1zpuwml1vIkJesm1EEczazC62QrmEGi',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-23af-71da-a67e-0ab4b0216426','Alek Efendi','ortu4@tkalistiqomah.sch.id',NULL,'$2y$12$vEn6RkiKegv39chas6x3.eHT7fpv16tgNSaROfgiWUg.2196ttSDC','089529894444','orangtua','pending',0,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-2526-73bd-a7fb-9c03498f6002','Indra Wijaya','ortu5@tkalistiqomah.sch.id',NULL,'$2y$12$FeALnvk7DpQgGSDLEH1JOuzi2jm2cKHSK7PHLGsx.Yum7OXeSLV6O','081990518952','orangtua','pending',0,NULL,'2026-05-24 05:53:25','2026-05-24 05:53:25',NULL),('019e5a0c-269c-7338-8be3-5163958e10a4','Herri Adinata','ortu6@tkalistiqomah.sch.id',NULL,'$2y$12$SuqKaZ4/xvJj0bwzIPQ2kuu5uKvQzf8kdjA6tk9JbIDEArJZ.r97y','082176151536','orangtua','pending',0,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-2815-712f-923e-f206fab61fb0','Ari Kurniawan Saputra','ortu7@tkalistiqomah.sch.id',NULL,'$2y$12$MmReeoE1E.kZPB4Ha67aRuHoyKVm.4S.8aoTYHHP.Q6F.FnaZPgXG','082175824510','orangtua','pending',0,NULL,'2026-05-24 05:53:26','2026-05-24 05:53:26',NULL),('019e5a0c-298c-7189-861a-c0388e72fa7c','Hendriawan','ortu8@tkalistiqomah.sch.id',NULL,'$2y$12$uPEAhg7kDl5YiM2eBz6LeOYvW6mI4BBFxwMneGIzptZw0bCZXYI9a',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2b03-708d-b735-de8484eb6370','Adi Setiawan','ortu9@tkalistiqomah.sch.id',NULL,'$2y$12$mm/I7obcnOaStwHJ2GoBs.GXbwIGxFx.kRbzQbYKhuCwz9roHeE5.',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2c7d-706d-a0d8-6b62cbdb8ced','Sudirman','ortu10@tkalistiqomah.sch.id',NULL,'$2y$12$uz60lLS6gKBPFNdZLVfjLuN.7lDtqpB7cc9Btzvsv92Kyc/.8N03W',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:27','2026-05-24 05:53:27',NULL),('019e5a0c-2dfb-7276-82a1-8aeb200a04da','Radi Aditama Sanjaya','ortu11@tkalistiqomah.sch.id',NULL,'$2y$12$BnCk/5RwzlKVZGzZF67reO/NJl.STx3Ny38YX9jYCztaLDbVrKWKy',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-2f7d-73f3-bd16-b9d3a2c37ace','Erpandi','ortu12@tkalistiqomah.sch.id',NULL,'$2y$12$Q1XnowsKT1kr01//Dg02j.9xxHDYW2b6NaB4pz8GdBoq9HcH0QG3q','082282746766','orangtua','pending',0,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-3104-7254-9310-065eac6237e3','Hendri Nopriyanto','ortu13@tkalistiqomah.sch.id',NULL,'$2y$12$1UmeYkn8307FP.5Q5pYs4eSeKoDjeppHgauRLgO6r2OEkzXZf6t7a','089561006419','orangtua','pending',0,NULL,'2026-05-24 05:53:28','2026-05-24 05:53:28',NULL),('019e5a0c-3285-70c1-ad51-9f202f2afbe9','Akbar Syah Putra','ortu14@tkalistiqomah.sch.id',NULL,'$2y$12$gSGdWlI/gG80NxERvDNKk.LWfGceoC2sWy3ErhMHH.2f/c5U.IaBq','082280041105','orangtua','pending',0,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-3400-71d2-8d15-3e4e1d492611','Hasan Nudin','ortu15@tkalistiqomah.sch.id',NULL,'$2y$12$Rn73oF1cB8jufX/q1uti0ePD/SpuQHRn99YWOBqyzRVJYi1V/Gc1S','083863766583','orangtua','pending',0,NULL,'2026-05-24 05:53:29','2026-05-24 05:53:29',NULL),('019e5a0c-3579-70a3-b392-3a602611c1a4','Juliyanto','ortu16@tkalistiqomah.sch.id',NULL,'$2y$12$ajlKzRCiDXgDC0FIBq8BheOeYJiD8PBcz7bxQRRXETLbDWEZ1Pr6O','089570066040','orangtua','pending',0,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-36f0-71f2-a2dd-3a18b9d9cda4','Janssen Cahyadi','ortu17@tkalistiqomah.sch.id',NULL,'$2y$12$8Gt/sVhRXpTLb2ELKPlZiu9Pmr7g8HnX0/Auxxnuk0MfpHl72hD/a','0895618980507','orangtua','pending',0,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-386c-7314-b77e-089e90c2973c','Beny Septianto','ortu18@tkalistiqomah.sch.id',NULL,'$2y$12$up5l56g2giPBbOCCbUz8vuvvJ23WY/QdqAnUWqwlnYa7NjGhYqwF2',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:30','2026-05-24 05:53:30',NULL),('019e5a0c-39e3-73e2-b286-06908269b32e','Irawan Suki','ortu19@tkalistiqomah.sch.id',NULL,'$2y$12$uXzW5XBM2w3MDwws51qmJOF4gZEh7pVHkIUwdI9t4VlNxp/awCmwO','081331323806','orangtua','pending',0,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3b5c-7165-b974-a3b11ebf2bee','Andrian Suryana','ortu20@tkalistiqomah.sch.id',NULL,'$2y$12$IbqiyORpk2JCTG.DFH0VAum2t.EQvwTEZdENPZwkKgBIlmEP4MyqO','088286242966','orangtua','pending',0,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3cd5-7361-af1c-df4e91abf700','Aria Kusuma','ortu21@tkalistiqomah.sch.id',NULL,'$2y$12$viv7uJq4B99xU8Z3whCV0eB9gBzwKH.FlrUXhvo2wSnjVHfOvEkGq','083866483095','orangtua','pending',0,NULL,'2026-05-24 05:53:31','2026-05-24 05:53:31',NULL),('019e5a0c-3e4c-739a-aa98-011be16c2d9b','Thoni Riswandi','ortu22@tkalistiqomah.sch.id',NULL,'$2y$12$nPObM1maKCcN0P2wJfRY8OstksC8ZzROSCgiCjJ7vkK2WKLYFi6l2',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-3fc5-7370-89ef-9e87df5b8a05','Jefriyanto','ortu23@tkalistiqomah.sch.id',NULL,'$2y$12$n9N0XDOHwHNl5P/BCz4sEef6TDV1LDcQ49eHgwX/3W0IWDyFBFIlu',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:32','2026-05-24 05:53:32',NULL),('019e5a0c-413a-7362-8888-4302d489da74','Endi Hermawan','ortu24@tkalistiqomah.sch.id',NULL,'$2y$12$bJaDjVKJb5kM2icVK1roGu.5baB82Owbi4iXA7m6nGd/etpOiu1Km','089532316075','orangtua','pending',0,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-42c7-7027-8b05-06e7c89ae29b','Yana Rodiana','ortu25@tkalistiqomah.sch.id',NULL,'$2y$12$0ptPqKoLl49sIok.HFi88eTLkWZ41UQaL2kN2A8G2ue3Blv98shY.','081274811062','orangtua','pending',0,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-4442-7242-9a89-272e8c186db1','Slamet Riyadi Dame','ortu26@tkalistiqomah.sch.id',NULL,'$2y$12$vZlRwQfr3BeUGuZFmzFbX.uP8zE3ZhWo1MUp5g4bWw9AkiVWPbP62',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:33','2026-05-24 05:53:33',NULL),('019e5a0c-45bb-70ca-b25b-3236f24df6ab','Slamet Riyadi Dame','ortu27@tkalistiqomah.sch.id',NULL,'$2y$12$y2Ep1zv3b7dtuurMRnWCDe15Po0c2Xlg8ZiFAc76IumjAptV1875q',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-4736-7390-8cf7-f3e821795271','Andri Hadi','ortu28@tkalistiqomah.sch.id',NULL,'$2y$12$YfTdfeQ6bK.0bqlCu2RuvO3/eZAfu6yS.9jeN6eIaiHHtxcyX.IJK','085758922300','orangtua','pending',0,NULL,'2026-05-24 05:53:34','2026-05-24 05:53:34',NULL),('019e5a0c-48b4-7169-978c-a0a0e38a917b','Al Roy Triwidianto','ortu29@tkalistiqomah.sch.id',NULL,'$2y$12$mEtrM2xK4q8B3ozZFxOnbeCDbTvhC5mvttXl14iAYq8l77z/mz592','08988142292','orangtua','pending',0,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4a2d-7281-b185-17989a3d7d7d','Joni Satriya','ortu30@tkalistiqomah.sch.id',NULL,'$2y$12$pDJmZxdVkZ2fybzIyVQEIuaUIra3z3LN80jydFUjlhcddlRIWlF2q','081274568944','orangtua','pending',0,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4ba8-7027-8cdd-88fa08595d96','Nazarudin','ortu31@tkalistiqomah.sch.id',NULL,'$2y$12$aY34FX/ODIzIFSIMkrCYX.0Bzn56JPsiELv6Vnng4a4I/YBSyDKzK',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:35','2026-05-24 05:53:35',NULL),('019e5a0c-4d24-708b-8369-a3597ec48f66','Ahmad Yani','ortu32@tkalistiqomah.sch.id',NULL,'$2y$12$T19R7XLQhF3dOmXwFK7et.Ji0XSEyd3BzTukXwNmnzbUSkbl6P29O','085269119394','orangtua','pending',0,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-4ea6-70df-aa44-b1f6086b213a','Somad Pinanda','ortu33@tkalistiqomah.sch.id',NULL,'$2y$12$kaEXh4J/OzbYT1mohTL/3.jJxVYiIBQ/3nkZtOu5.D/XN3Wlj1dtC','081532722932','orangtua','pending',0,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-5023-7150-b76b-9f573747af9e','Ari Susilo','ortu34@tkalistiqomah.sch.id',NULL,'$2y$12$94eX7vF386HY5wQlfwDvfuX6F0GrUEirA8Zqr9QutQTcGQQlFvxnu','081231087001','orangtua','pending',0,NULL,'2026-05-24 05:53:36','2026-05-24 05:53:36',NULL),('019e5a0c-5197-7167-a516-3aa42f8c9f19','Agung Setiawan','ortu35@tkalistiqomah.sch.id',NULL,'$2y$12$5bM79BhWlRSyFnnrgQ6/0eUfn0URSNrvhkZISlXX.bDiPJHnlpiuS','081379014810','orangtua','pending',0,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-5314-735c-b6b4-f11d952713cd','Muhamad Rizki','ortu36@tkalistiqomah.sch.id',NULL,'$2y$12$SAXfuiOTcW1iippTxapiy.4EUlPlNX6msX4e8iKPjq2HJeylHJaQK','089644228742','orangtua','pending',0,NULL,'2026-05-24 05:53:37','2026-05-24 05:53:37',NULL),('019e5a0c-5490-719c-881c-b8aa0fc67680','Rizki Ramadhan','ortu37@tkalistiqomah.sch.id',NULL,'$2y$12$GUucmed1ALq4LQbXbzWkiupvFjUKxVKqd0hBXBbE5aZAydKjJ6bYO','082145678901','orangtua','pending',0,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-5608-732c-a8a3-7a19f3b50663','Dedi Setiawan','ortu38@tkalistiqomah.sch.id',NULL,'$2y$12$FxXz1CCRi9V/gfViQpbtKug6ssb9B9NeKHDKGK1JyV5Jz.oHSYZRO','085312345678','orangtua','pending',0,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-5789-7067-918f-ebd2cceb4427','Ibrahim Sholeh','ortu39@tkalistiqomah.sch.id',NULL,'$2y$12$JtMBQb9t10sEgzEpn95H2esCvFJx1k58jh50X4wihii0r5ZDGVI06','081298765432','orangtua','pending',0,NULL,'2026-05-24 05:53:38','2026-05-24 05:53:38',NULL),('019e5a0c-5905-71a5-a019-7c2ddd5ce95f','Hendra Gunawan','ortu40@tkalistiqomah.sch.id',NULL,'$2y$12$gp/A9.3.xISzZyjMhB9P/ub3Qy4bGa7eGSSqtrcpnD2F4bKNl.mKa','089612345678','orangtua','pending',0,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5a7f-7060-90e1-20bf63b14131','Budi Pratama','ortu41@tkalistiqomah.sch.id',NULL,'$2y$12$VBfiiWXSe.AP7//k5WOxuu3LAfb6ykERAS50jwUnQ8R6ytZ7ISDQa',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5bf9-7185-9e00-ecc1b7be37d6','Wahyu Hidayat','ortu42@tkalistiqomah.sch.id',NULL,'$2y$12$5983ku.4YQvcvDbn7aKmZOBBoaj47H9Sx0ZMnOBBBcIsWcTZpeTNe','082356781234','orangtua','pending',0,NULL,'2026-05-24 05:53:39','2026-05-24 05:53:39',NULL),('019e5a0c-5d73-73d1-b8f6-bdda55075d0f','Fauzan Hakim','ortu43@tkalistiqomah.sch.id',NULL,'$2y$12$UacEU0jhTbp/6B2yH8DcvuxujsXQp3NlPVOkRihT04ElNSU3c2P6C','081356789012','orangtua','pending',0,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-5eed-7281-8b7b-701f391fdb18','Eko Purwanto','ortu44@tkalistiqomah.sch.id',NULL,'$2y$12$luAZ6t2IjeZsklPRY/Ru2.p/U8Zx6.G8HpbIwqL14MQdYLpBdn/gq','085678901234','orangtua','pending',0,NULL,'2026-05-24 05:53:40','2026-05-24 05:53:40',NULL),('019e5a0c-6078-7240-a906-3bc2c36a65b9','Arya Wibowo','ortu45@tkalistiqomah.sch.id',NULL,'$2y$12$dsd2BRaOzoqGN2Vpj07Vt.k/FxJD9UMiXGeX5mk46HT.uD962OebS',NULL,'orangtua','pending',0,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-61ee-719e-b7a1-65a6702fdce8','Doni Rahayu','ortu46@tkalistiqomah.sch.id',NULL,'$2y$12$nfSdDY3.Vuft5GrAr3bxcuZ1LIGuOvW4n.05m5ml.PaQZJT8U9Z9a','082367890123','orangtua','pending',0,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-6369-7259-ae29-7e4969539925','Santoso','ortu47@tkalistiqomah.sch.id',NULL,'$2y$12$jOrs1LZ9Hi2eICe55urh..Q821cOqBM5SuRzW3VI.MyjUQPERfqeK','089723456789','orangtua','pending',0,NULL,'2026-05-24 05:53:41','2026-05-24 05:53:41',NULL),('019e5a0c-64e0-71f0-8b5b-0ed432fd2413','Syaifudin','ortu48@tkalistiqomah.sch.id',NULL,'$2y$12$WEfADMpzsY8/1kA4jWOJTe/rPV6rhokP1C5rtdLHMeP6tCL0.4YhS','081234509876','orangtua','active',0,NULL,'2026-05-24 05:53:42','2026-05-24 06:02:12',NULL),('019e5a0c-665b-7199-b129-c40e600bad20','Hakim Maulana','ortu49@tkalistiqomah.sch.id',NULL,'$2y$12$ikovweYJAPMc8ls42qyA.eu3P5Y4aPcB23VEoN5brVJCvMDTZQohS',NULL,'orangtua','active',0,NULL,'2026-05-24 05:53:42','2026-05-24 06:02:01',NULL),('019e5a0c-67d0-7137-b420-6c44ed6497d3','Nuraini Ahmad','ortu50@tkalistiqomah.sch.id',NULL,'$2y$12$APIzlgwKpfg0RTDF8rUXFe.gyyNNHgKkp5ahpx48XSBbqe/E7CGHq','085612340987','orangtua','active',0,NULL,'2026-05-24 05:53:42','2026-05-24 06:02:28',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-26  1:21:07
