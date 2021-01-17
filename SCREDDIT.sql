-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 192.168.2.200    Database: SCS
-- ------------------------------------------------------
-- Server version	5.5.62-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Answer`
--

DROP TABLE IF EXISTS `Answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `User_id` int(11) NOT NULL,
  `Task_id` int(11) NOT NULL,
  `input` text,
  `accepted` bit(1) NOT NULL DEFAULT b'0',
  `completed` bit(1) NOT NULL,
  `waiting` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `fk_Answer_User1_idx` (`User_id`),
  KEY `fk_Answer_Task1_idx` (`Task_id`),
  CONSTRAINT `fk_Answer_Task1` FOREIGN KEY (`Task_id`) REFERENCES `Task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Answer_User1` FOREIGN KEY (`User_id`) REFERENCES `backend_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4257 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Answer_x_SIMS`
--

DROP TABLE IF EXISTS `Answer_x_SIMS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Answer_x_SIMS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_SIMS` int(11) NOT NULL,
  `id_answer` int(11) NOT NULL,
  `scale` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_SIMS_idx` (`id_SIMS`),
  KEY `fk_answer_xx_idx` (`id_answer`),
  CONSTRAINT `fk_answer_x` FOREIGN KEY (`id_answer`) REFERENCES `Answer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_SIMS_x` FOREIGN KEY (`id_SIMS`) REFERENCES `SIMS` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68097 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Questionnaire`
--

DROP TABLE IF EXISTS `Questionnaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Questionnaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` longtext NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SIMS`
--

DROP TABLE IF EXISTS `SIMS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SIMS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sims_cat_idx` (`category`),
  CONSTRAINT `fk_sims_cat` FOREIGN KEY (`category`) REFERENCES `SIMS_Category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SIMS_Category`
--

DROP TABLE IF EXISTS `SIMS_Category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SIMS_Category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sims_parent_cat_idx` (`parent_id`),
  CONSTRAINT `fk_sims_parent_cat` FOREIGN KEY (`parent_id`) REFERENCES `SIMS_Category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Task`
--

DROP TABLE IF EXISTS `Task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `description` text,
  `task_type_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `input_type` int(11) NOT NULL,
  `correct_answer` text NOT NULL,
  `task_day` int(11) NOT NULL,
  `from_time` varchar(45) DEFAULT NULL,
  `to_time` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Task_TaskType1_idx` (`task_type_id`),
  CONSTRAINT `fk_Task_TaskType1` FOREIGN KEY (`task_type_id`) REFERENCES `task_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Untitled`
--

DROP TABLE IF EXISTS `Untitled`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Untitled` (
  `MyUnknownColumn` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `id_SIMS` int(11) DEFAULT NULL,
  `id_answer` int(11) DEFAULT NULL,
  `scale` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `User_x_Questionnaire`
--

DROP TABLE IF EXISTS `User_x_Questionnaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User_x_Questionnaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_questionnaire` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `answer` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_x_idx` (`id_user`),
  KEY `fk_questionaire_idx` (`id_questionnaire`),
  CONSTRAINT `fk_questionaire` FOREIGN KEY (`id_questionnaire`) REFERENCES `Questionnaire` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_x` FOREIGN KEY (`id_user`) REFERENCES `backend_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3008 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backend_user`
--

DROP TABLE IF EXISTS `backend_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backend_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `age` int(11) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `auth_key` int(11) NOT NULL,
  `consent` bit(1) NOT NULL DEFAULT b'0',
  `activated_date` datetime DEFAULT NULL,
  `control_group` bit(1) NOT NULL DEFAULT b'0',
  `email` varchar(255) NOT NULL,
  `questionnaire_done` bit(1) NOT NULL,
  `db_score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `task_type`
--

DROP TABLE IF EXISTS `task_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_TaskType_TaskType_idx` (`parent_id`),
  CONSTRAINT `fk_TaskType_TaskType` FOREIGN KEY (`parent_id`) REFERENCES `task_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-17 16:17:26
