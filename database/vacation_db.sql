-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: vacation_db
-- ------------------------------------------------------
-- Server version	5.7.44

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
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_code` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `submitted_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_code` (`employee_code`),
  CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`employee_code`) REFERENCES `users` (`employee_code`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
INSERT INTO `requests` VALUES (17,1010104,'2024-07-15','2024-07-20','Medical leave','pending','2024-06-25 00:00:00'),(18,1010105,'2024-08-10','2024-08-15','Personal time off','pending','2024-07-30 00:00:00'),(20,1010107,'2024-05-10','2024-05-15','Family event','pending','2024-04-30 00:00:00'),(21,1010108,'2024-06-20','2024-06-25','Conference attendance','pending','2024-06-05 00:00:00'),(22,1010109,'2024-07-01','2024-07-10','Vacation trip','pending','2024-06-10 00:00:00'),(23,1010110,'2024-08-15','2024-08-20','Wedding leave','pending','2024-07-28 00:00:00'),(24,1010103,'2025-02-28','2025-03-03','Family fishing trip','approved','2025-02-16 16:50:36');
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `employee_code` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('manager','employee') NOT NULL,
  `manager_code` int(7) NOT NULL,
  PRIMARY KEY (`employee_code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1010111 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1010101,'Alice Johnson','manager1@mail.com','$2y$10$yNFjiX3YL.KHUBXFhitaGORRMCDra.Qd8jSlhrOWO1WC6THTEyD5S','manager',1010101),(1010102,'Bob Smith','manager2@mail.com','$2y$10$6x6bLQnJO0my787Gtv80BeaeLXWqe248XuZgUfucUwQzW5XBuXoeW','manager',1010102),(1010103,'Charlie Davis','employee1@mail.com','$2y$10$DUHCtMKHzqX3.LakR/k4TOCMBtcuKHvk8OxrWAgKTnvw5W4.MVtgG','employee',1010101),(1010104,'Diana Wilson','employee2@mail.com','$2y$10$sKJyDYPMZUkujYm2WUaHSe93ebWrnMzuKCkHVs4bKbVl8GRsqiE.2','employee',1010101),(1010105,'Ethan Brown','employee3@mail.com','$2y$10$52lN31bV/Zoj/VGlJRHb1uitZz0cjP14sTRJsA44rwaMdXLA052Hi','employee',1010101),(1010106,'Fiona Martinez','employee4@mail.com','$2y$10$SZxwzKy6uUurltB8WRNCrehJcKgP64zLdgllqtEIAPRkOu7rXEHXW','employee',1010101),(1010107,'George White','employee5@mail.com','$2y$10$3wWONAqYJ.HWnKQxn7cKm.zBnIFyQwZaiee25XZYmIaH.jr14pNBK','employee',1010102),(1010108,'Hannah Taylor','employee6@mail.com','$2y$10$BQwQLzszC8qNMxTD4PjccuAwNC3Lr3LoLNKrDzCM2MhkfzMx.pSze','employee',1010102),(1010109,'Isaac Lee','employee7@mail.com','$2y$10$n5PglVMU/jOopO/K1T8cDu.WMndl18UH9pymvOLHjuBdGqOB/bki.','employee',1010102),(1010110,'Julia Moore','employee8@mail.com','$2y$10$i5z2YK4dLbsbeF.r0yCq8OR.0vQYp/kZgHqn5U/hOpxGT81nwNEAO','employee',1010102);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'vacation_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-16 20:27:49
