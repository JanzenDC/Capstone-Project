-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: weavemanila_main
-- ------------------------------------------------------
-- Server version 	10.4.28-MariaDB
-- Date: Sat, 02 Mar 2024 07:48:15 +0100

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40101 SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_logs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `audit_logs` VALUES (1,1,'John Doe','Manager','Backup Data','2024-01-23','2024-01-23 07:38:10','man1.png'),(2,2,'Jane Smith','Developer','Backup Data','2024-01-24','2024-01-23 07:38:10','man.png'),(3,3,'Bob Johnson','Analyst','Backup Data','2024-01-25','2024-01-23 07:38:10','man_2.png'),(4,4,'Alice Brown','Coordinator','Backup Data','2024-01-26','2024-01-23 07:38:10','man_3.png'),(5,5,'Charlie Wilson','Engineer','Delete File','2024-01-27','2024-01-23 07:38:10','man_3.png'),(6,6,'Eva Davis','Supervisor','Approve Request','2024-01-28','2024-01-23 07:38:10','man_4.png'),(7,7,'Frank Miller','Designer','Send Email','2024-01-29','2024-01-23 07:38:10','default_pfp.png'),(8,8,'Grace Thompson','Administrator','Change Password','2024-01-30','2024-01-23 07:38:10','default_pfp.png'),(9,9,'Henry Lee','Tester','Run Tests','2024-01-31','2024-01-23 07:38:10','default_pfp.png'),(10,10,'Ivy Chen','Support','View Dashboard','2024-02-01','2024-01-23 07:38:10','default_pfp.png'),(21,11,'Jane Smith','Developer','Update','2023-01-25','2024-01-24 12:24:53','man1.png'),(22,12,'Bob Johnson','Designer','Delete','2023-01-26','2024-01-24 12:24:53','man1.png'),(23,13,'Alice Brown','Analyst','Create','2023-01-27','2024-01-24 12:24:53','man1.png'),(24,14,'Charlie Wilson','Coordinator','Update','2023-01-28','2024-01-24 12:24:53','man1.png'),(25,15,'Eva Davis','Manager','Delete','2023-01-29','2024-01-24 12:24:53','man1.png'),(26,16,'Frank Miller','Developer','Create','2023-01-30','2024-01-24 12:24:53','man1.png'),(27,17,'Grace Turner','Designer','Update','2023-01-31','2024-01-24 12:24:53','man1.png'),(28,18,'Henry Parker','Analyst','Delete','2023-02-01','2024-01-24 12:24:53','man1.png'),(29,19,'Ivy White','Coordinator','Create','2023-02-02','2024-01-24 12:24:53','man1.png'),(30,1,'test','Owner','nag logout','2024-01-17','2024-01-26 10:54:27','man_1.png'),(31,1,'Janzen Forrest Dela Cruz','Owner','Backup Data','2024-03-01','2024-02-29 20:08:04','1707310005_65c37bb54ce044.84624441_images.png'),(32,1,'Janzen Forrest Dela Cruz','Owner','Backup Data','2024-03-02','2024-03-01 23:21:15','1707310005_65c37bb54ce044.84624441_images.png');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `audit_logs` with 22 row(s)
--

--
-- Table structure for table `design_specs_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `design_specs_tbl` (
  `design_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `pattern_name` varchar(255) DEFAULT NULL,
  `dpi` varchar(255) DEFAULT NULL,
  `no_of_harness` varchar(255) DEFAULT NULL,
  `threading` varchar(255) DEFAULT NULL,
  `harness_lift` varchar(255) DEFAULT NULL,
  `pedal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`design_specsID`),
  KEY `fk_design_specs_tbl_pjo_tbl_1` (`pjoID`),
  CONSTRAINT `fk_design_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `design_specs_tbl`
--

LOCK TABLES `design_specs_tbl` WRITE;
/*!40000 ALTER TABLE `design_specs_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `design_specs_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `design_specs_tbl` with 0 row(s)
--

--
-- Table structure for table `issuance_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `issuance_tbl` (
  `issuanceID` int(11) NOT NULL,
  `segregateID` int(11) DEFAULT NULL,
  `qty_raw` int(11) DEFAULT NULL,
  `balance_raw` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`issuanceID`),
  KEY `fk_issuance_tbl_mpo_segregate_tbl_1` (`segregateID`),
  CONSTRAINT `fk_issuance_tbl_mpo_segregate_tbl_1` FOREIGN KEY (`segregateID`) REFERENCES `mpo_segregate_tbl` (`segregateID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issuance_tbl`
--

LOCK TABLES `issuance_tbl` WRITE;
/*!40000 ALTER TABLE `issuance_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `issuance_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `issuance_tbl` with 0 row(s)
--

--
-- Table structure for table `material_issuance_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_issuance_tbl` (
  `material_issuanceID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `material_desc` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `returned` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `issued_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`material_issuanceID`),
  KEY `fk_material_issuance_tbl_pjo_tbl_1` (`pjoID`),
  CONSTRAINT `fk_material_issuance_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_issuance_tbl`
--

LOCK TABLES `material_issuance_tbl` WRITE;
/*!40000 ALTER TABLE `material_issuance_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `material_issuance_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `material_issuance_tbl` with 0 row(s)
--

--
-- Table structure for table `material_specs_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_specs_tbl` (
  `material_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `material_used_and_type` varchar(255) DEFAULT NULL,
  `consumption_wt_and_type` varchar(255) DEFAULT NULL,
  `waste_allow_and_type` varchar(255) DEFAULT NULL,
  `total_allow_issuance_and_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`material_specsID`),
  KEY `fk_material_specs_tbl_pjo_tbl_1` (`pjoID`),
  CONSTRAINT `fk_material_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_specs_tbl`
--

LOCK TABLES `material_specs_tbl` WRITE;
/*!40000 ALTER TABLE `material_specs_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `material_specs_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `material_specs_tbl` with 0 row(s)
--

--
-- Table structure for table `mpo_base`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpo_base` (
  `baseID` int(11) NOT NULL AUTO_INCREMENT,
  `mpoID` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `quantity_received` int(11) DEFAULT 0,
  `unit_price` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `discounts` decimal(10,2) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  PRIMARY KEY (`baseID`),
  KEY `fk_mpo_base_mpo_tbl_1` (`mpoID`),
  CONSTRAINT `fk_mpo_base_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mpo_base`
--

LOCK TABLES `mpo_base` WRITE;
/*!40000 ALTER TABLE `mpo_base` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `mpo_base` VALUES (6,79,'JK Fiber','None',4,'Drum',4,12600,2,10.00,45360),(7,79,'M1 Fiber','None',14,'Drum',10,5000,1,12.00,44000),(8,79,'S1 Fiber','None',25,'Drum',25,20000,2,10.50,89500),(9,80,'JK Fiber','None',4,'Drum',4,12500,2,10.00,45000),(10,80,'M1 Fiber','None',4,'Drum',4,12500,2,5.00,59375),(15,82,'S1 Fiber','None',4,'Drum',3,12500,1,10.00,45000);
/*!40000 ALTER TABLE `mpo_base` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `mpo_base` with 6 row(s)
--

--
-- Table structure for table `mpo_segregate_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpo_segregate_tbl` (
  `segregateID` int(11) NOT NULL AUTO_INCREMENT,
  `mpoID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `segregator` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`segregateID`),
  KEY `fk_mpo_segregate_tbl_mpo_tbl_1` (`mpoID`),
  CONSTRAINT `fk_mpo_segregate_tbl_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mpo_segregate_tbl`
--

LOCK TABLES `mpo_segregate_tbl` WRITE;
/*!40000 ALTER TABLE `mpo_segregate_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `mpo_segregate_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `mpo_segregate_tbl` with 0 row(s)
--

--
-- Table structure for table `mpo_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpo_tbl` (
  `mpoID` int(11) NOT NULL,
  `personelID` int(11) DEFAULT NULL,
  `supplierID` int(11) DEFAULT NULL,
  `categoryID` int(11) DEFAULT NULL,
  `mpo_ref_no` varchar(255) DEFAULT NULL,
  `date_purchased` date DEFAULT NULL,
  `client_ref_no` varchar(255) DEFAULT NULL,
  `w_o_ref_no` varchar(255) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `supplier_address` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `delivery_charge` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `other_costs` double DEFAULT NULL,
  `vat` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `notes_instructions` varchar(255) DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `file_logo` varchar(255) NOT NULL,
  `file_esignaturep` varchar(255) NOT NULL,
  `file_esignaturea` varchar(255) NOT NULL,
  PRIMARY KEY (`mpoID`),
  KEY `fk_mpo_tbl_category_tbl_1` (`categoryID`),
  KEY `fk_mpo_tbl_supplier_tbl_1` (`supplierID`),
  KEY `fk_mpo_tbl_personel_tbl_1` (`personelID`),
  CONSTRAINT `fk_mpo_tbl_category_tbl_1` FOREIGN KEY (`categoryID`) REFERENCES `w_category` (`categoryID`),
  CONSTRAINT `fk_mpo_tbl_personel_tbl_1` FOREIGN KEY (`personelID`) REFERENCES `personel_tbl` (`personelID`),
  CONSTRAINT `fk_mpo_tbl_supplier_tbl_1` FOREIGN KEY (`supplierID`) REFERENCES `w_supplierlist` (`supplierID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mpo_tbl`
--

LOCK TABLES `mpo_tbl` WRITE;
/*!40000 ALTER TABLE `mpo_tbl` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `mpo_tbl` VALUES (79,1,43,2,'79','2024-02-27','','','2024-03-07','NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA','NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA','NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA',NULL,0,19213.5,0,21463.2,202649.7,'','Janzen','Janzen','','',''),(80,1,43,2,'80','2024-01-31','test','','2024-02-21','BARMM, LANAO DEL SUR, BAYANG, BUBONG LILOD','NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA','BARMM, BASILAN, LAMITAN CITY, BALOBO',NULL,0,7468.75,0,12525,117556.25,'Nothing','Janzen','Dela Cruz','','',''),(82,1,43,2,'82','2024-02-22','','','2024-02-26','Region 05, ALBAY, LEGAZPI CITY, BGY. 51 - BUYUAN (BGY. 49)','NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA','BARMM, MAGUINDANAO, DATU ANGGAL MIDTIMBANG, TUGAL',NULL,0,4500,500,5400,50400,'None','Dela Cruz','Agarin','default_logo.png','wallpapersden.com_satoru-gojo-acid-blue-eyes-jujutsu-kaisen_1336x768.jpg','wallpapersden.com_sukuna-4k-jujutsu-kaisen-art_1336x768.jpg');
/*!40000 ALTER TABLE `mpo_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `mpo_tbl` with 3 row(s)
--

--
-- Table structure for table `output_monitoring_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `output_monitoring_tbl` (
  `outputID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `time_in_am` time DEFAULT NULL,
  `time_out_pm` time DEFAULT NULL,
  `output_am` varchar(255) DEFAULT NULL,
  `output_pm` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`outputID`),
  KEY `fk_output_monitoring_tbl_pjo_tbl_1` (`pjoID`),
  CONSTRAINT `fk_output_monitoring_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `output_monitoring_tbl`
--

LOCK TABLES `output_monitoring_tbl` WRITE;
/*!40000 ALTER TABLE `output_monitoring_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `output_monitoring_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `output_monitoring_tbl` with 0 row(s)
--

--
-- Table structure for table `personel_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personel_tbl` (
  `personelID` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default_pfp.png',
  `gender` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(12) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `account_created` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `isAdmin` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`personelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personel_tbl`
--

LOCK TABLES `personel_tbl` WRITE;
/*!40000 ALTER TABLE `personel_tbl` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `personel_tbl` VALUES (1,'meniski2345@gmail.com','janzen.d','Janzen Forrest','Agarin','Dela Cruz','$2y$10$jnFtbJcqmjJ4NaCJBGpIc.Vp/dht5JLUMk2T1yRzVQ4WOu43j.Hky','1707310005_65c37bb54ce044.84624441_images.png','Male','Owner','09123456789','2001-07-27',22,'Buyuan Legazpi City',1,'2024-01-26 09:28:56','Single',1),(2,'user1@example.com','user1','John','Doe','Smith','password1','man_2.png','Male','Developer','1234567890','1990-01-01',31,'123 Main St',0,'2024-01-26 09:56:25','',0),(3,'user2@example.com','user2','Jane','Doe','Johnson','password2','woman_2.png','Female','Designer','2147483647','1995-05-15',26,'456 Oak St',0,'2024-01-26 09:56:25','',0),(5,'user1@example.com','user1','User','M','One','hashed_password1','man_4.png','Male','Manager','1234567891','1990-02-15',32,'123 Street Ave, City',0,'2024-01-26 11:55:51','',0),(18,'carlbrozebandola24@gmail.com','','Carlo ','','Bandola','$2y$10$94gsllwLkABo7bShX7G8WOC9clSN66Gg0MGLksrl0jL4BI5/g3YN6','default_pfp.png','Male','','2147483647','2024-01-02',0,'Pogi Street',0,'2024-01-27 04:45:44','Single',0);
/*!40000 ALTER TABLE `personel_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `personel_tbl` with 5 row(s)
--

--
-- Table structure for table `pjo_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pjo_tbl` (
  `pjoID` int(11) NOT NULL AUTO_INCREMENT,
  `personelID` int(11) DEFAULT NULL,
  `endorse` varchar(255) DEFAULT NULL,
  `job_order_no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `prepared_issued_by` varchar(255) DEFAULT NULL,
  `noted_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pjoID`),
  KEY `fk_pjo_tbl_personel_tbl_1` (`personelID`),
  CONSTRAINT `fk_pjo_tbl_personel_tbl_1` FOREIGN KEY (`personelID`) REFERENCES `personel_tbl` (`personelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pjo_tbl`
--

LOCK TABLES `pjo_tbl` WRITE;
/*!40000 ALTER TABLE `pjo_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `pjo_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `pjo_tbl` with 0 row(s)
--

--
-- Table structure for table `post_data_specs_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_data_specs_tbl` (
  `post_data_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `setting_w` varchar(255) DEFAULT NULL,
  `weaving_w` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`post_data_specsID`),
  KEY `fk_post_data_specs_tbl_pjo_tbl_1` (`pjoID`),
  CONSTRAINT `fk_post_data_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_data_specs_tbl`
--

LOCK TABLES `post_data_specs_tbl` WRITE;
/*!40000 ALTER TABLE `post_data_specs_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `post_data_specs_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `post_data_specs_tbl` with 0 row(s)
--

--
-- Table structure for table `process_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `process_tbl` (
  `processID` int(11) NOT NULL,
  `mpoID` int(11) DEFAULT NULL,
  `segregation` varchar(255) DEFAULT NULL,
  `cleaning` varchar(255) DEFAULT NULL,
  `drying` varchar(255) DEFAULT NULL,
  `weighting` double DEFAULT NULL,
  PRIMARY KEY (`processID`),
  KEY `fk_process_tbl_mpo_tbl_1` (`mpoID`),
  CONSTRAINT `fk_process_tbl_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_tbl`
--

LOCK TABLES `process_tbl` WRITE;
/*!40000 ALTER TABLE `process_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `process_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `process_tbl` with 0 row(s)
--

--
-- Table structure for table `product_specs_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_specs_tbl` (
  `product_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `design_pattern` varchar(255) DEFAULT NULL,
  `construction` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `date_started` datetime DEFAULT NULL,
  `date_finished` datetime DEFAULT NULL,
  `looms` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `lead_time` datetime DEFAULT NULL,
  `quota` varchar(255) DEFAULT NULL,
  `weaving` varchar(255) DEFAULT NULL,
  `trimming` varchar(255) DEFAULT NULL,
  `cleaning` varchar(255) DEFAULT NULL,
  `latexing` varchar(255) DEFAULT NULL,
  `re_latexing` varchar(255) DEFAULT NULL,
  `piping` varchar(255) DEFAULT NULL,
  `cutting` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_specsID`),
  KEY `fk_product_specs_tbl_pjo_tbl_1` (`pjoID`),
  CONSTRAINT `fk_product_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specs_tbl`
--

LOCK TABLES `product_specs_tbl` WRITE;
/*!40000 ALTER TABLE `product_specs_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `product_specs_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_specs_tbl` with 0 row(s)
--

--
-- Table structure for table `purchase_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_tbl` (
  `purchaseID` int(11) NOT NULL,
  `segregateID` int(11) DEFAULT NULL,
  `order_stocks` varchar(255) DEFAULT NULL,
  `received` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `item_cost` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`purchaseID`),
  KEY `fk_purchase_tbl_mpo_segregate_tbl_1` (`segregateID`),
  CONSTRAINT `fk_purchase_tbl_mpo_segregate_tbl_1` FOREIGN KEY (`segregateID`) REFERENCES `mpo_segregate_tbl` (`segregateID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_tbl`
--

LOCK TABLES `purchase_tbl` WRITE;
/*!40000 ALTER TABLE `purchase_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `purchase_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `purchase_tbl` with 0 row(s)
--

--
-- Table structure for table `received_taknis_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `received_taknis_tbl` (
  `received_taknisID` int(11) NOT NULL,
  `segregateID` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `waste_gumon` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`received_taknisID`),
  KEY `fk_received_taknis_tbl_mpo_segregate_tbl_1` (`segregateID`),
  CONSTRAINT `fk_received_taknis_tbl_mpo_segregate_tbl_1` FOREIGN KEY (`segregateID`) REFERENCES `mpo_segregate_tbl` (`segregateID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `received_taknis_tbl`
--

LOCK TABLES `received_taknis_tbl` WRITE;
/*!40000 ALTER TABLE `received_taknis_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `received_taknis_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `received_taknis_tbl` with 0 row(s)
--

--
-- Table structure for table `remarks_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `remarks_tbl` (
  `remarksID` int(11) NOT NULL,
  `material_specsID` int(11) DEFAULT NULL,
  `item_actual_weight` double DEFAULT NULL,
  `total_material_issued` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`remarksID`),
  KEY `fk_remarks_tbl_material_specs_tbl_1` (`material_specsID`),
  CONSTRAINT `fk_remarks_tbl_material_specs_tbl_1` FOREIGN KEY (`material_specsID`) REFERENCES `material_specs_tbl` (`material_specsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remarks_tbl`
--

LOCK TABLES `remarks_tbl` WRITE;
/*!40000 ALTER TABLE `remarks_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `remarks_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `remarks_tbl` with 0 row(s)
--

--
-- Table structure for table `supplier_restorepoint`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_restorepoint` (
  `supplierID` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_restorepoint`
--

LOCK TABLES `supplier_restorepoint` WRITE;
/*!40000 ALTER TABLE `supplier_restorepoint` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `supplier_restorepoint` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `supplier_restorepoint` with 0 row(s)
--

--
-- Table structure for table `waste_tbl`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `waste_tbl` (
  `wasteID` int(11) NOT NULL,
  `post_data_specsID` int(11) DEFAULT NULL,
  `warp` varchar(255) DEFAULT NULL,
  `weft` varchar(255) DEFAULT NULL,
  `insert` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`wasteID`),
  KEY `fk_waste_tbl_post_data_specs_tbl_1` (`post_data_specsID`),
  CONSTRAINT `fk_waste_tbl_post_data_specs_tbl_1` FOREIGN KEY (`post_data_specsID`) REFERENCES `post_data_specs_tbl` (`post_data_specsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waste_tbl`
--

LOCK TABLES `waste_tbl` WRITE;
/*!40000 ALTER TABLE `waste_tbl` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `waste_tbl` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `waste_tbl` with 0 row(s)
--

--
-- Table structure for table `w_category`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `w_category` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `procedure` varchar(64) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `w_category`
--

LOCK TABLES `w_category` WRITE;
/*!40000 ALTER TABLE `w_category` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `w_category` VALUES (2,'Raw Materials','test',''),(5,'test input','test input',''),(6,'a','a',''),(7,'b','b',''),(8,'c','c','');
/*!40000 ALTER TABLE `w_category` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `w_category` with 5 row(s)
--

--
-- Table structure for table `w_otp`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `w_otp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `otpcode` varchar(6) NOT NULL,
  `expiration_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_personelID` (`uid`),
  CONSTRAINT `fk_personelID` FOREIGN KEY (`uid`) REFERENCES `personel_tbl` (`personelID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `w_otp`
--

LOCK TABLES `w_otp` WRITE;
/*!40000 ALTER TABLE `w_otp` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `w_otp` VALUES (2,1,'679567','2024-03-01 03:34:00');
/*!40000 ALTER TABLE `w_otp` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `w_otp` with 1 row(s)
--

--
-- Table structure for table `w_supplierlist`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `w_supplierlist` (
  `supplierID` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`supplierID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `w_supplierlist`
--

LOCK TABLES `w_supplierlist` WRITE;
/*!40000 ALTER TABLE `w_supplierlist` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `w_supplierlist` VALUES (30,'EagleExpress','Carlo','Konoha','09123456789','meniski2345@gmail.com'),(31,'Supplier1','John Doe','123 Main Street, City1','1234567890','supplier1@example.com'),(32,'Supplier2','Jane Smith','456 Oak Avenue, City2','9876543210','supplier2@example.com'),(33,'Supplier3','Bob Johnson','789 Elm Road, City3','5551234567','supplier3@example.com'),(34,'Supplier4','Alice Brown','321 Pine Lane, City4','9879876543','supplier4@example.com'),(35,'Supplier5','Chris Green','654 Birch Street, City5','4445556666','supplier5@example.com'),(36,'Supplier6','Eva White','987 Maple Drive, City6','7897891234','supplier6@example.com'),(37,'Supplier7','Mike Black','234 Cedar Road, City7','1112223333','supplier7@example.com'),(38,'Supplier8','Sara Grey','567 Walnut Lane, City8','3334445555','supplier8@example.com'),(42,'Supplier12','Sophie Purple','789 Maple Drive, City12','5556667777','supplier12@example.com'),(43,'J&T','Janzen Dela Cruz','NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA','09123456789','j&texpress@gmail.com');
/*!40000 ALTER TABLE `w_supplierlist` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `w_supplierlist` with 11 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET AUTOCOMMIT=@OLD_AUTOCOMMIT */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Sat, 02 Mar 2024 07:48:15 +0100
