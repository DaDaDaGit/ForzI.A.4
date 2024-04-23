-- Progettazione Web 
DROP DATABASE if exists paroli_616954; 
CREATE DATABASE paroli_616954; 
USE paroli_616954; 
-- MySQL dump 10.13  Distrib 5.7.28, for Win64 (x86_64)
--
-- Host: localhost    Database: paroli_616954
-- ------------------------------------------------------
-- Server version	5.7.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES ('AI','AI@email.com',''),('dario','dario@email.com','$2y$10$G3Xos1.22U26fpEnD0uQdeuop5c/dsOmKIZmsfqLSj0/Wcwe8t8mK'),('paroli','paroli@email.com','$2y$10$pSkuHg3epsllF7uXORijOeeFtfnSacP5WKc7I/kD2heDQLrjWdUqK');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partita`
--

DROP TABLE IF EXISTS `partita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partita` (
  `ID_partita` int(11) NOT NULL AUTO_INCREMENT,
  `firstPlayer` varchar(25) NOT NULL,
  `secondPlayer` varchar(25) NOT NULL,
  `arrayMosse` varchar(83) NOT NULL COMMENT 'stringa costituita da un array di mosse',
  `timestampPartita` datetime NOT NULL,
  `risultato` varchar(25) NOT NULL COMMENT 'contiene il nome del vincitore o "Pareggio"',
  `redPlayer` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_partita`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partita`
--

LOCK TABLES `partita` WRITE;
/*!40000 ALTER TABLE `partita` DISABLE KEYS */;
INSERT INTO `partita` VALUES (100,'paroli','dario','2,3,4,6,2,4,3,4,3,4,5,3,5,4','2023-01-15 11:26:39','dario','paroli'),(101,'AI','dario','3,3,2,3,4,3,1','2023-01-15 12:15:57','AI','dario');
/*!40000 ALTER TABLE `partita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partite_giocate`
--

DROP TABLE IF EXISTS `partite_giocate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partite_giocate` (
  `ID_partita` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  KEY `usernameFK` (`username`),
  KEY `partitaFK` (`ID_partita`),
  CONSTRAINT `partitaFK` FOREIGN KEY (`ID_partita`) REFERENCES `partita` (`ID_partita`),
  CONSTRAINT `usernameFK` FOREIGN KEY (`username`) REFERENCES `account` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partite_giocate`
--

LOCK TABLES `partite_giocate` WRITE;
/*!40000 ALTER TABLE `partite_giocate` DISABLE KEYS */;
INSERT INTO `partite_giocate` VALUES (100,'paroli'),(100,'dario'),(101,'AI'),(101,'dario');
/*!40000 ALTER TABLE `partite_giocate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-15 12:18:33
