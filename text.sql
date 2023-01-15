-- --------------------------------------------------------
-- Host:                         tigerbn.com
-- Server version:               8.0.26-0ubuntu0.20.04.2 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for theoldmountain
CREATE DATABASE IF NOT EXISTS `theoldmountain` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `theoldmountain`;

-- Dumping structure for table theoldmountain.acft_standards
CREATE TABLE IF NOT EXISTS `acft_standards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `points` int DEFAULT NULL,
  `gender` enum('M','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `min_age` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `max_age` varchar(3) DEFAULT NULL,
  `MDL_min_score` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `SPT_min_score` varchar(50) DEFAULT NULL,
  `HRP_min_score` varchar(50) DEFAULT NULL,
  `SDC_min_score` time DEFAULT NULL,
  `PLK_min_score` varchar(50) DEFAULT NULL,
  `2MR_min_score` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table theoldmountain.acft_standards: ~4 rows (approximately)
DELETE FROM `acft_standards`;
/*!40000 ALTER TABLE `acft_standards` DISABLE KEYS */;
INSERT INTO `acft_standards` (`id`, `points`, `gender`, `min_age`, `max_age`, `MDL_min_score`, `SPT_min_score`, `HRP_min_score`, `SDC_min_score`, `PLK_min_score`, `2MR_min_score`) VALUES
	(1, 0, 'M', '', NULL, '80', '4.0', '4', '00:02:28', NULL, NULL),
	(2, 10, 'M', '', NULL, '90', NULL, NULL, NULL, NULL, NULL),
	(3, 20, 'M', '', NULL, '100', NULL, NULL, NULL, NULL, NULL),
	(4, 30, 'M', '', NULL, '110', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `acft_standards` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
