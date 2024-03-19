-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 01:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weavemanila_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `uid`, `fullname`, `position`, `action`, `date`, `timestamp`, `image`) VALUES
(1, 1, 'John Doe', 'Manager', 'Backup Data', '2024-01-23', '2024-01-23 07:38:10', 'man1.png'),
(2, 2, 'Jane Smith', 'Developer', 'Backup Data', '2024-01-24', '2024-01-23 07:38:10', 'man.png'),
(3, 3, 'Bob Johnson', 'Analyst', 'Backup Data', '2024-01-25', '2024-01-23 07:38:10', 'man_2.png'),
(4, 4, 'Alice Brown', 'Coordinator', 'Backup Data', '2024-01-26', '2024-01-23 07:38:10', 'man_3.png'),
(5, 5, 'Charlie Wilson', 'Engineer', 'Delete File', '2024-01-27', '2024-01-23 07:38:10', 'man_3.png'),
(6, 6, 'Eva Davis', 'Supervisor', 'Approve Request', '2024-01-28', '2024-01-23 07:38:10', 'man_4.png'),
(7, 7, 'Frank Miller', 'Designer', 'Send Email', '2024-01-29', '2024-01-23 07:38:10', 'default_pfp.png'),
(8, 8, 'Grace Thompson', 'Administrator', 'Change Password', '2024-01-30', '2024-01-23 07:38:10', 'default_pfp.png'),
(9, 9, 'Henry Lee', 'Tester', 'Run Tests', '2024-01-31', '2024-01-23 07:38:10', 'default_pfp.png'),
(10, 10, 'Ivy Chen', 'Support', 'View Dashboard', '2024-02-01', '2024-01-23 07:38:10', 'default_pfp.png'),
(21, 11, 'Jane Smith', 'Developer', 'Update', '2023-01-25', '2024-01-24 12:24:53', 'man1.png'),
(22, 12, 'Bob Johnson', 'Designer', 'Delete', '2023-01-26', '2024-01-24 12:24:53', 'man1.png'),
(23, 13, 'Alice Brown', 'Analyst', 'Create', '2023-01-27', '2024-01-24 12:24:53', 'man1.png'),
(24, 14, 'Charlie Wilson', 'Coordinator', 'Update', '2023-01-28', '2024-01-24 12:24:53', 'man1.png'),
(25, 15, 'Eva Davis', 'Manager', 'Delete', '2023-01-29', '2024-01-24 12:24:53', 'man1.png'),
(26, 16, 'Frank Miller', 'Developer', 'Create', '2023-01-30', '2024-01-24 12:24:53', 'man1.png'),
(27, 17, 'Grace Turner', 'Designer', 'Update', '2023-01-31', '2024-01-24 12:24:53', 'man1.png'),
(28, 18, 'Henry Parker', 'Analyst', 'Delete', '2023-02-01', '2024-01-24 12:24:53', 'man1.png'),
(29, 19, 'Ivy White', 'Coordinator', 'Create', '2023-02-02', '2024-01-24 12:24:53', 'man1.png'),
(30, 1, 'test', 'Owner', 'nag logout', '2024-01-17', '2024-01-26 10:54:27', 'man_1.png'),
(31, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-01', '2024-02-29 20:08:04', '1707310005_65c37bb54ce044.84624441_images.png'),
(32, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-02', '2024-03-01 23:21:15', '1707310005_65c37bb54ce044.84624441_images.png'),
(33, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-02', '2024-03-01 23:48:18', '1707310005_65c37bb54ce044.84624441_images.png'),
(34, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-03', '2024-03-02 18:49:13', '1707310005_65c37bb54ce044.84624441_images.png'),
(35, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-03', '2024-03-02 18:50:22', '1707310005_65c37bb54ce044.84624441_images.png'),
(36, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-03', '2024-03-02 19:15:17', '1707310005_65c37bb54ce044.84624441_images.png'),
(37, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-03', '2024-03-03 02:16:06', '1707310005_65c37bb54ce044.84624441_images.png'),
(38, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-05', '2024-03-05 03:10:19', '1707310005_65c37bb54ce044.84624441_images.png'),
(39, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-14', '2024-03-13 23:35:14', '1707310005_65c37bb54ce044.84624441_images.png'),
(40, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-14', '2024-03-14 08:37:34', '1707310005_65c37bb54ce044.84624441_images.png'),
(41, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-14', '2024-03-14 08:38:32', '1707310005_65c37bb54ce044.84624441_images.png'),
(42, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-16', '2024-03-16 07:33:33', '1707310005_65c37bb54ce044.84624441_images.png'),
(43, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-03-16', '2024-03-16 07:34:21', '1707310005_65c37bb54ce044.84624441_images.png');

-- --------------------------------------------------------

--
-- Table structure for table `design_specs_tbl`
--

CREATE TABLE `design_specs_tbl` (
  `design_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `pattern_name` varchar(255) DEFAULT NULL,
  `dpi` varchar(255) DEFAULT NULL,
  `epi` varchar(255) DEFAULT NULL,
  `threading` varchar(255) DEFAULT NULL,
  `harness_lift` varchar(255) DEFAULT NULL,
  `pedal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `design_specs_tbl`
--

INSERT INTO `design_specs_tbl` (`design_specsID`, `pjoID`, `pattern_name`, `dpi`, `epi`, `threading`, `harness_lift`, `pedal`) VALUES
(1, 1, 'test', '1231', '12321', '3123', '321321', '12321'),
(2, 1, '', '', '', '', '', ''),
(3, 6, '', '', '', '', '', ''),
(4, 6, '', '', '', '', '', ''),
(5, 6, '', '', '', '', '', ''),
(6, 6, '', '', '', '', '', ''),
(7, 6, '', '', '', '', '', ''),
(8, 6, '', '', '', '', '', ''),
(9, 6, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `issuance_tbl`
--

CREATE TABLE `issuance_tbl` (
  `issuanceID` int(11) NOT NULL,
  `segregateID` int(11) DEFAULT NULL,
  `qty_raw` int(11) DEFAULT NULL,
  `balance_raw` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_actual_weight`
--

CREATE TABLE `item_actual_weight` (
  `actualweightID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `unit` varchar(244) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_actual_weight`
--

INSERT INTO `item_actual_weight` (`actualweightID`, `pjoID`, `quantity`, `weight`, `unit`) VALUES
(1, 1, 1, 300, 'Kilogram'),
(2, 2, 1, 0, 'Kilogram'),
(3, 2, 1, 0, 'Kilogram'),
(4, 2, 1, 0, 'Kilogram'),
(5, 2, 1, 0, 'Kilogram'),
(6, 6, 1, 0, 'Kilogram'),
(7, 6, 2, 0, 'Kilogram'),
(8, 6, 1, 0, 'Kilogram'),
(9, 6, 2, 0, 'Kilogram'),
(10, 6, 1, 0, 'Kilogram'),
(11, 6, 2, 0, 'Kilogram'),
(12, 6, 1, 0, 'Kilogram'),
(13, 6, 2, 0, 'Kilogram'),
(14, 6, 1, 0, 'Kilogram'),
(15, 6, 2, 0, 'Kilogram'),
(16, 6, 1, 0, 'Kilogram'),
(17, 6, 2, 0, 'Kilogram'),
(18, 6, 1, 0, 'Kilogram'),
(19, 6, 2, 0, 'Kilogram'),
(20, 6, 1, 0, 'Kilogram'),
(21, 6, 2, 0, 'Kilogram'),
(22, 6, 1, 0, 'Kilogram'),
(23, 6, 2, 0, 'Kilogram');

-- --------------------------------------------------------

--
-- Table structure for table `material_issuance_tbl`
--

CREATE TABLE `material_issuance_tbl` (
  `material_issuanceID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `material_desc` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `returned` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `issued_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `material_issuance_tbl`
--

INSERT INTO `material_issuance_tbl` (`material_issuanceID`, `pjoID`, `date`, `material_desc`, `quantity`, `returned`, `balance`, `issued_by`) VALUES
(1, 1, '0000-00-00', '', '0', '0', '', ''),
(2, 6, '0000-00-00', '', '0', '0', '', ''),
(3, 6, '0000-00-00', '', '0', '0', '', ''),
(4, 6, '0000-00-00', '', '0', '0', '', ''),
(5, 6, '0000-00-00', '', '0', '0', '', ''),
(6, 6, '0000-00-00', '', '0', '0', '', ''),
(7, 6, '0000-00-00', '', '0', '0', '', ''),
(8, 6, '0000-00-00', '', '0', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `material_specs_tbl`
--

CREATE TABLE `material_specs_tbl` (
  `material_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `consumption_in_wt_kg` float DEFAULT NULL,
  `material_used` varchar(255) DEFAULT NULL,
  `waste_allow` float DEFAULT NULL,
  `total_allow_issuance` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `material_specs_tbl`
--

INSERT INTO `material_specs_tbl` (`material_specsID`, `pjoID`, `type`, `consumption_in_wt_kg`, `material_used`, `waste_allow`, `total_allow_issuance`) VALUES
(1, 1, 'Warp', 30, 'New Material 1', 20, 11),
(2, 1, 'Weft', 30, 'New Material 2', 20, 11),
(3, 1, 'Insert', 30, 'New Material 3', 20, 11),
(4, 6, 'Warp', 0, 'New Material 1', 0, 0),
(5, 6, 'Weft', 0, 'New Material 2', 0, 0),
(6, 6, 'Insert', 0, 'New Material 3', 0, 0),
(7, 6, 'Warp', 0, 'New Material 1', 0, 0),
(8, 6, 'Weft', 0, 'New Material 2', 0, 0),
(9, 6, 'Insert', 0, 'New Material 3', 0, 0),
(10, 6, 'Warp', 0, 'New Material 1', 0, 0),
(11, 6, 'Weft', 0, 'New Material 2', 0, 0),
(12, 6, 'Insert', 0, 'New Material 3', 0, 0),
(13, 6, 'Warp', 0, 'New Material 1', 0, 0),
(14, 6, 'Weft', 0, 'New Material 2', 0, 0),
(15, 6, 'Insert', 0, 'New Material 3', 0, 0),
(16, 6, 'Warp', 0, 'New Material 1', 0, 0),
(17, 6, 'Weft', 0, 'New Material 2', 0, 0),
(18, 6, 'Insert', 0, 'New Material 3', 0, 0),
(19, 6, 'Warp', 0, 'New Material 1', 0, 0),
(20, 6, 'Weft', 0, 'New Material 2', 0, 0),
(21, 6, 'Insert', 0, 'New Material 3', 0, 0),
(22, 6, 'Warp', 0, 'New Material 1', 0, 0),
(23, 6, 'Weft', 0, 'New Material 2', 0, 0),
(24, 6, 'Insert', 0, 'New Material 3', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mpo_base`
--

CREATE TABLE `mpo_base` (
  `baseID` int(11) NOT NULL,
  `mpoID` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `quantity_received` int(11) DEFAULT 0,
  `unit_price` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `discounts` decimal(10,2) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_base`
--

INSERT INTO `mpo_base` (`baseID`, `mpoID`, `item_name`, `description`, `quantity`, `unit`, `quantity_received`, `unit_price`, `status`, `discounts`, `subtotal`) VALUES
(6, 79, 'JK Fiber', 'None', 500, 'Drum', 500, 12600, 2, 10.00, 45360),
(7, 79, 'M1 Fiber', 'None', 14, 'Drum', 14, 5000, 2, 12.00, 44000),
(8, 79, 'S1 Fiber', 'None', 25, 'Drum', 0, 20000, 0, 10.50, 89500),
(9, 80, 'JK Fiber', 'None', 4, 'Drum', 4, 12500, 2, 10.00, 45000),
(10, 80, 'M1 Fiber', 'None', 4, 'Drum', 0, 12500, 0, 5.00, 59375),
(15, 82, 'S1 Fiber', 'None', 4, 'Drum', 0, 12500, 0, 10.00, 45000);

-- --------------------------------------------------------

--
-- Table structure for table `mpo_datereceived_logs`
--

CREATE TABLE `mpo_datereceived_logs` (
  `datareceivedID` int(11) NOT NULL,
  `mpoID` int(11) NOT NULL DEFAULT 0,
  `baseID` int(11) NOT NULL,
  `date_received` date DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_datereceived_logs`
--

INSERT INTO `mpo_datereceived_logs` (`datareceivedID`, `mpoID`, `baseID`, `date_received`, `status`) VALUES
(35, 79, 8, '2024-03-06', 0),
(36, 80, 9, '2024-03-15', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mpo_segregate_tbl`
--

CREATE TABLE `mpo_segregate_tbl` (
  `segregateID` int(11) NOT NULL,
  `mpoID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `segregator` varchar(255) DEFAULT NULL,
  `order_stocks` float DEFAULT NULL,
  `received` float DEFAULT NULL,
  `balance_for_purchases` float DEFAULT NULL,
  `qty_raw_for_issuance` float DEFAULT NULL,
  `balance_raw_for_issuance` float DEFAULT NULL,
  `qty_for_received_taknis` float DEFAULT NULL,
  `waste_gumon_for_received_taknis` float DEFAULT NULL,
  `balance_for_received_taknis` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `mpo_tbl`
--

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
  `file_esignaturea` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_tbl`
--

INSERT INTO `mpo_tbl` (`mpoID`, `personelID`, `supplierID`, `categoryID`, `mpo_ref_no`, `date_purchased`, `client_ref_no`, `w_o_ref_no`, `delivery_date`, `delivery_address`, `supplier_address`, `company_address`, `total`, `delivery_charge`, `discount`, `other_costs`, `vat`, `total_amount`, `notes_instructions`, `prepared_by`, `approved_by`, `file_logo`, `file_esignaturep`, `file_esignaturea`) VALUES
(79, 1, 43, 2, '79', '2024-02-27', '', '', '2024-03-07', 'NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA', 'NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA', 'NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA', NULL, 0, 19213.5, 0, 21463.2, 202649.7, '', 'Janzen', 'Janzen', '', '', ''),
(80, 1, 43, 2, '80', '2024-01-31', 'test', '', '2024-02-21', 'BARMM, LANAO DEL SUR, BAYANG, BUBONG LILOD', 'NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA', 'BARMM, BASILAN, LAMITAN CITY, BALOBO', NULL, 0, 7468.75, 0, 12525, 117556.25, 'Nothing', 'Janzen', 'Dela Cruz', '', '', ''),
(82, 1, 43, 2, '82', '2024-02-22', '', '', '2024-02-26', 'Region 05, ALBAY, LEGAZPI CITY, BGY. 51 - BUYUAN (BGY. 49)', 'NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA', 'BARMM, MAGUINDANAO, DATU ANGGAL MIDTIMBANG, TUGAL', NULL, 0, 4500, 500, 5400, 50400, 'None', 'Dela Cruz', 'Agarin', 'default_logo.png', 'wallpapersden.com_satoru-gojo-acid-blue-eyes-jujutsu-kaisen_1336x768.jpg', 'wallpapersden.com_sukuna-4k-jujutsu-kaisen-art_1336x768.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `personel_tbl`
--

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
  `isAdmin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personel_tbl`
--

INSERT INTO `personel_tbl` (`personelID`, `email`, `username`, `firstname`, `middlename`, `lastname`, `password`, `profile_pic`, `gender`, `position`, `mobile_number`, `birthdate`, `age`, `address`, `status`, `account_created`, `civil_status`, `isAdmin`) VALUES
(1, 'meniski2345@gmail.com', 'janzen.d', 'Janzen Forrest', 'Agarin', 'Dela Cruz', '$2y$10$abeaq70rUAGWO9NdcAPjuOn9BOqr09vDTeR4siebelXfxrKCZQXHK', '1707310005_65c37bb54ce044.84624441_images.png', 'Male', 'Owner', '09123456789', '2001-07-27', 22, 'Buyuan Legazpi City', 1, '2024-01-26 09:28:56', 'Single', 1),
(2, 'user1@example.com', 'user1', 'John', 'Doe', 'Smith', 'password1', 'man_2.png', 'Male', 'production staff', '1234567890', '1990-01-01', 31, '123 Main St', 0, '2024-01-26 09:56:25', '', 0),
(3, 'user2@example.com', 'user2', 'Jane', 'Doe', 'Johnson', 'password2', 'woman_2.png', 'Female', 'warehouseman', '2147483647', '1995-05-15', 26, '456 Oak St', 0, '2024-01-26 09:56:25', '', 0),
(5, 'user1@example.com', 'user1', 'User', 'M', 'One', 'hashed_password1', 'man_4.png', 'Male', 'warehouseman', '1234567891', '1990-02-15', 32, '123 Street Ave, City', 0, '2024-01-26 11:55:51', '', 0),
(18, 'carlbrozebandola24@gmail.com', '', 'Carlo ', '', 'Bandola', '$2y$10$94gsllwLkABo7bShX7G8WOC9clSN66Gg0MGLksrl0jL4BI5/g3YN6', 'default_pfp.png', 'Male', 'production staff', '2147483647', '2024-01-02', 0, 'Pogi Street', 0, '2024-01-27 04:45:44', 'Single', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pjo_tbl`
--

CREATE TABLE `pjo_tbl` (
  `pjoID` int(11) NOT NULL,
  `personelID` int(11) DEFAULT NULL,
  `endorse` varchar(255) DEFAULT NULL,
  `job_order_no` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `f_esignature_preparedby` varchar(255) DEFAULT NULL,
  `f_esignature_approvedby` varchar(255) DEFAULT NULL,
  `f_preparedby` varchar(255) DEFAULT NULL,
  `f_approvedby` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `design_pattern` varchar(255) DEFAULT NULL,
  `construction` varchar(255) DEFAULT NULL,
  `width` int(65) NOT NULL,
  `length` int(65) NOT NULL,
  `size_selected` varchar(65) NOT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `weaving` tinyint(1) DEFAULT 0,
  `tassle` tinyint(1) DEFAULT 0,
  `trimming` tinyint(1) DEFAULT 0,
  `cleaning` tinyint(1) DEFAULT 0,
  `latexing` tinyint(1) DEFAULT 0,
  `re_latexing` tinyint(1) DEFAULT 0,
  `pipping` tinyint(1) DEFAULT 0,
  `cutting` tinyint(1) DEFAULT 0,
  `b_esignature_preparedby` varchar(255) DEFAULT NULL,
  `b_esignature_approvedby` varchar(255) DEFAULT NULL,
  `b_preparedby` varchar(255) DEFAULT NULL,
  `b_approvedby` varchar(255) DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `lead_time` int(11) DEFAULT 0,
  `qouta` float DEFAULT NULL,
  `loom` float DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `commitment_date` date DEFAULT NULL,
  `shipped_date` date DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pjo_tbl`
--

INSERT INTO `pjo_tbl` (`pjoID`, `personelID`, `endorse`, `job_order_no`, `date`, `reference`, `delivery_date`, `f_esignature_preparedby`, `f_esignature_approvedby`, `f_preparedby`, `f_approvedby`, `description`, `design_pattern`, `construction`, `width`, `length`, `size_selected`, `quantity`, `date_started`, `weaving`, `tassle`, `trimming`, `cleaning`, `latexing`, `re_latexing`, `pipping`, `cutting`, `b_esignature_preparedby`, `b_esignature_approvedby`, `b_preparedby`, `b_approvedby`, `date_finished`, `lead_time`, `qouta`, `loom`, `color`, `checked_by`, `order_date`, `commitment_date`, `shipped_date`, `client_name`) VALUES
(1, 1, 'Pedro Penduko', 1, '2024-03-16', 'weave', '2024-03-30', 'signature (3).png', 'signature (2).png', 'janzen', 'dela cruz', 'test', 'castle', 'castle na wala', 200, 300, 'Centimeters', '1', '2024-03-15', 1, 0, 0, 0, 0, 0, 0, 0, 'signature.png', NULL, 'rose', '', '2024-04-23', 39, 3, 23, 'red', 'John Smith', '2024-03-19', '2024-03-20', '2024-03-08', 'test'),
(2, 1, '', 2, '0000-00-00', '', '2024-03-19', '', '', '1', '1', 'test', 'test', 'test', 300, -9, 'Centimeters', '1', '2024-03-28', 1, 1, 0, 0, NULL, NULL, NULL, NULL, '', NULL, '1', '', '2024-05-06', 39, 3, 2, '2', 'John Smith', NULL, NULL, NULL, NULL),
(3, 1, '', 2, '0000-00-00', '', '2024-03-19', 'signature (1).png', 'signature (2).png', '1', '1', 'test', 'test', 'test', 300, -9, 'Centimeters', '1', '2024-03-28', 1, 1, 0, 0, NULL, NULL, NULL, NULL, 'signature (3).png', NULL, '1', '', '2024-05-06', 39, 3, 2, '2', 'John Smith', NULL, NULL, NULL, NULL),
(4, 1, '', 2, '0000-00-00', '', '2024-03-19', 'signature (1).png', 'signature (2).png', '1', '1', 'test', 'test', 'test', 300, -9, 'Centimeters', '1', '2024-03-28', 1, 1, 0, 0, 0, NULL, 0, 0, 'signature (3).png', NULL, '1', '', '2024-05-06', 39, 3, 2, '2', 'John Smith', NULL, NULL, NULL, NULL),
(5, 1, '', 2, '0000-00-00', '', '2024-03-19', 'signature (1).png', 'signature (2).png', '1', '1', 'test', 'test', 'test', 300, -9, 'Centimeters', '1', '2024-03-28', 1, 1, 0, 0, 0, 0, 0, 0, 'signature (3).png', NULL, '1', '', '2024-05-06', 39, 3, 2, '2', 'John Smith', NULL, NULL, NULL, NULL),
(6, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', '', '', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, '', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(7, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', '', '', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, '', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(8, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', '', '', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, '', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(9, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', 'default.png', 'default.png', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, 'default.png', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(10, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', 'default.png', 'default.png', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, 'default.png', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(11, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', 'default.png', 'default.png', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, 'default.png', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(12, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', 'default.png', 'default.png', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, 'default.png', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(13, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', 'default.png', 'default.png', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, 'default.png', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL),
(14, 1, 'Carlo Bandola', 3, '0000-00-00', '', '2024-03-18', 'default.png', 'default.png', 'te', 'tes', '23', '23', '23', 300, 3, 'Feet', '2', '2024-03-20', 1, 0, 0, 0, 0, 0, 0, 0, 'default.png', NULL, '43', '', '2027-07-03', 1200, 3, 32, 'red', 'John Smith', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_data_specs_tbl`
--

CREATE TABLE `post_data_specs_tbl` (
  `post_data_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `setting_w` varchar(255) DEFAULT NULL,
  `weaving_w` varchar(255) DEFAULT NULL,
  `output_width` float DEFAULT NULL,
  `warp_waste` float DEFAULT NULL,
  `weft_waste` float DEFAULT NULL,
  `insert_waste` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `post_data_specs_tbl`
--

INSERT INTO `post_data_specs_tbl` (`post_data_specsID`, `pjoID`, `setting_w`, `weaving_w`, `output_width`, `warp_waste`, `weft_waste`, `insert_waste`) VALUES
(1, 1, '312312', '321', 123, 32, 5454, 7676),
(2, 6, '', '', 0, 0, 0, 0),
(3, 6, '', '', 0, 0, 0, 0),
(4, 6, '', '', 0, 0, 0, 0),
(5, 6, '', '', 0, 0, 0, 0),
(6, 6, '', '', 0, 0, 0, 0),
(7, 6, '', '', 0, 0, 0, 0),
(8, 6, '', '', 0, 0, 0, 0),
(9, 6, '', '', 0, 0, 0, 0),
(10, 6, '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `process_tbl`
--

CREATE TABLE `process_tbl` (
  `processID` int(11) NOT NULL,
  `mpoID` int(11) DEFAULT NULL,
  `segregation` varchar(255) DEFAULT NULL,
  `cleaning` varchar(255) DEFAULT NULL,
  `drying` varchar(255) DEFAULT NULL,
  `weighting` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_monitoring_tbl`
--

CREATE TABLE `production_monitoring_tbl` (
  `outputID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `time_in_am` time DEFAULT NULL,
  `time_out_pm` time DEFAULT NULL,
  `output_am_pm` varchar(255) DEFAULT NULL,
  `ot_time_in` datetime DEFAULT NULL,
  `ot_time_out` datetime DEFAULT NULL,
  `ot_output` varchar(255) DEFAULT NULL,
  `total_output` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `production_monitoring_tbl`
--

INSERT INTO `production_monitoring_tbl` (`outputID`, `pjoID`, `date`, `time_in_am`, `time_out_pm`, `output_am_pm`, `ot_time_in`, `ot_time_out`, `ot_output`, `total_output`) VALUES
(2, 1, '2024-03-20 16:07:12', '18:07:12', '21:07:12', '23', '2024-03-28 16:07:12', '2024-03-28 16:07:12', '34', 23),
(3, 6, '0000-00-00 00:00:00', '00:00:00', '00:00:00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0),
(4, 6, '0000-00-00 00:00:00', '00:00:00', '00:00:00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0),
(5, 6, '0000-00-00 00:00:00', '00:00:00', '00:00:00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0),
(6, 6, '0000-00-00 00:00:00', '00:00:00', '00:00:00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0),
(7, 6, '0000-00-00 00:00:00', '00:00:00', '00:00:00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0),
(8, 6, '0000-00-00 00:00:00', '00:00:00', '00:00:00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0),
(9, 6, '0000-00-00 00:00:00', '00:00:00', '00:00:00', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_restorepoint`
--

CREATE TABLE `supplier_restorepoint` (
  `supplierID` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `total_material_used`
--

CREATE TABLE `total_material_used` (
  `materialusedID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `material_used` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `total_material_used`
--

INSERT INTO `total_material_used` (`materialusedID`, `pjoID`, `material_used`, `quantity`, `unit`) VALUES
(1, 1, 'New Material 1', 0, 'kilogram'),
(2, 1, 'New Material 2', 0, 'kilogram'),
(3, 1, 'New Material 3', 0, 'kilogram'),
(4, 2, 'New Material 1', 0, 'kilogram'),
(5, 2, 'New Material 2', 0, 'kilogram'),
(6, 2, 'New Material 3', 0, 'kilogram'),
(7, 2, 'New Material 1', 0, 'kilogram'),
(8, 2, 'New Material 2', 0, 'kilogram'),
(9, 2, 'New Material 3', 0, 'kilogram'),
(10, 2, 'New Material 1', 0, 'kilogram'),
(11, 2, 'New Material 2', 0, 'kilogram'),
(12, 2, 'New Material 3', 0, 'kilogram'),
(13, 2, 'New Material 1', 0, 'kilogram'),
(14, 2, 'New Material 2', 0, 'kilogram'),
(15, 2, 'New Material 3', 0, 'kilogram'),
(16, 6, 'New Material 1', 0, 'kilogram'),
(17, 6, 'New Material 2', 0, 'kilogram'),
(18, 6, 'New Material 3', 0, 'kilogram'),
(19, 6, 'New Material 1', 0, 'kilogram'),
(20, 6, 'New Material 2', 0, 'kilogram'),
(21, 6, 'New Material 3', 0, 'kilogram'),
(22, 6, 'New Material 1', 0, 'kilogram'),
(23, 6, 'New Material 2', 0, 'kilogram'),
(24, 6, 'New Material 3', 0, 'kilogram'),
(25, 6, 'New Material 1', 0, 'kilogram'),
(26, 6, 'New Material 2', 0, 'kilogram'),
(27, 6, 'New Material 3', 0, 'kilogram'),
(28, 6, 'New Material 1', 0, 'kilogram'),
(29, 6, 'New Material 2', 0, 'kilogram'),
(30, 6, 'New Material 3', 0, 'kilogram'),
(31, 6, 'New Material 1', 0, 'kilogram'),
(32, 6, 'New Material 2', 0, 'kilogram'),
(33, 6, 'New Material 3', 0, 'kilogram'),
(34, 6, 'New Material 1', 0, 'kilogram'),
(35, 6, 'New Material 2', 0, 'kilogram'),
(36, 6, 'New Material 3', 0, 'kilogram'),
(37, 6, 'New Material 1', 0, 'kilogram'),
(38, 6, 'New Material 2', 0, 'kilogram'),
(39, 6, 'New Material 3', 0, 'kilogram'),
(40, 6, 'New Material 1', 0, 'kilogram'),
(41, 6, 'New Material 2', 0, 'kilogram'),
(42, 6, 'New Material 3', 0, 'kilogram');

-- --------------------------------------------------------

--
-- Table structure for table `weaverlist_tbl`
--

CREATE TABLE `weaverlist_tbl` (
  `weaverID` int(11) NOT NULL,
  `weaverFname` varchar(255) DEFAULT NULL,
  `weaverLname` varchar(255) DEFAULT NULL,
  `weaverContact` varchar(12) DEFAULT NULL,
  `weaverEmail` varchar(255) DEFAULT NULL,
  `weaverAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weaverlist_tbl`
--

INSERT INTO `weaverlist_tbl` (`weaverID`, `weaverFname`, `weaverLname`, `weaverContact`, `weaverEmail`, `weaverAddress`) VALUES
(1, 'Carlo', 'Bandola', '09123456789', 'carlobandola@gmail.com', 'Region 05, ALBAY, LEGAZPI CITY, BGY. 30 - PIGCALE (POB.)'),
(2, 'Pedro', 'Penduko', '09123456789', 'test@gmail.com', 'NCR, NATIONAL CAPITAL REGION - MANILA, PANDACAN, BARANGAY 839');

-- --------------------------------------------------------

--
-- Table structure for table `w_category`
--

CREATE TABLE `w_category` (
  `categoryID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `procedure` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `w_category`
--

INSERT INTO `w_category` (`categoryID`, `title`, `description`, `procedure`) VALUES
(2, 'Raw Materials', 'test', ''),
(5, 'test input', 'test input', ''),
(6, 'a', 'a', ''),
(7, 'b', 'b', ''),
(8, 'c', 'c', '');

-- --------------------------------------------------------

--
-- Table structure for table `w_otp`
--

CREATE TABLE `w_otp` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `otpcode` varchar(6) NOT NULL,
  `expiration_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `w_otp`
--

INSERT INTO `w_otp` (`id`, `uid`, `otpcode`, `expiration_time`) VALUES
(2, 1, '595349', '2024-03-14 15:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `w_supplierlist`
--

CREATE TABLE `w_supplierlist` (
  `supplierID` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `w_supplierlist`
--

INSERT INTO `w_supplierlist` (`supplierID`, `supplier_name`, `contact_person`, `address`, `contact`, `email`) VALUES
(30, 'EagleExpress', 'Carlo', 'Konoha', '09123456789', 'meniski2345@gmail.com'),
(31, 'Supplier1', 'John Doe', '123 Main Street, City1', '1234567890', 'supplier1@example.com'),
(32, 'Supplier2', 'Jane Smith', '456 Oak Avenue, City2', '9876543210', 'supplier2@example.com'),
(33, 'Supplier3', 'Bob Johnson', '789 Elm Road, City3', '5551234567', 'supplier3@example.com'),
(34, 'Supplier4', 'Alice Brown', '321 Pine Lane, City4', '9879876543', 'supplier4@example.com'),
(35, 'Supplier5', 'Chris Green', '654 Birch Street, City5', '4445556666', 'supplier5@example.com'),
(36, 'Supplier6', 'Eva White', '987 Maple Drive, City6', '7897891234', 'supplier6@example.com'),
(37, 'Supplier7', 'Mike Black', '234 Cedar Road, City7', '1112223333', 'supplier7@example.com'),
(38, 'Supplier8', 'Sara Grey', '567 Walnut Lane, City8', '3334445555', 'supplier8@example.com'),
(42, 'Supplier12', 'Sophie Purple', '789 Maple Drive, City12', '5556667777', 'supplier12@example.com'),
(43, 'J&T', 'Janzen Dela Cruz', 'NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA', '09123456789', 'meniski2345@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `design_specs_tbl`
--
ALTER TABLE `design_specs_tbl`
  ADD PRIMARY KEY (`design_specsID`) USING BTREE,
  ADD KEY `fk_design_specs_tbl_pjo_tbl_1` (`pjoID`) USING BTREE;

--
-- Indexes for table `issuance_tbl`
--
ALTER TABLE `issuance_tbl`
  ADD PRIMARY KEY (`issuanceID`),
  ADD KEY `fk_issuance_tbl_mpo_segregate_tbl_1` (`segregateID`);

--
-- Indexes for table `item_actual_weight`
--
ALTER TABLE `item_actual_weight`
  ADD PRIMARY KEY (`actualweightID`),
  ADD KEY `fk_item_actual_weight_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `material_issuance_tbl`
--
ALTER TABLE `material_issuance_tbl`
  ADD PRIMARY KEY (`material_issuanceID`) USING BTREE,
  ADD KEY `fk_material_issuance_tbl_pjo_tbl_1` (`pjoID`) USING BTREE;

--
-- Indexes for table `material_specs_tbl`
--
ALTER TABLE `material_specs_tbl`
  ADD PRIMARY KEY (`material_specsID`) USING BTREE,
  ADD KEY `fk_material_specs_tbl_pjo_tbl_1` (`pjoID`) USING BTREE;

--
-- Indexes for table `mpo_base`
--
ALTER TABLE `mpo_base`
  ADD PRIMARY KEY (`baseID`),
  ADD KEY `fk_mpo_base_mpo_tbl_1` (`mpoID`);

--
-- Indexes for table `mpo_datereceived_logs`
--
ALTER TABLE `mpo_datereceived_logs`
  ADD PRIMARY KEY (`datareceivedID`),
  ADD KEY `fk_baseID` (`baseID`),
  ADD KEY `fk_table_mpoID` (`mpoID`);

--
-- Indexes for table `mpo_segregate_tbl`
--
ALTER TABLE `mpo_segregate_tbl`
  ADD PRIMARY KEY (`segregateID`) USING BTREE,
  ADD KEY `fk_mpo_segregate_tbl_mpo_tbl_1` (`mpoID`) USING BTREE;

--
-- Indexes for table `mpo_tbl`
--
ALTER TABLE `mpo_tbl`
  ADD PRIMARY KEY (`mpoID`),
  ADD KEY `fk_mpo_tbl_category_tbl_1` (`categoryID`),
  ADD KEY `fk_mpo_tbl_supplier_tbl_1` (`supplierID`),
  ADD KEY `fk_mpo_tbl_personel_tbl_1` (`personelID`);

--
-- Indexes for table `personel_tbl`
--
ALTER TABLE `personel_tbl`
  ADD PRIMARY KEY (`personelID`);

--
-- Indexes for table `pjo_tbl`
--
ALTER TABLE `pjo_tbl`
  ADD PRIMARY KEY (`pjoID`) USING BTREE,
  ADD KEY `fk_pjo_tbl_personel_tbl_1` (`personelID`) USING BTREE;

--
-- Indexes for table `post_data_specs_tbl`
--
ALTER TABLE `post_data_specs_tbl`
  ADD PRIMARY KEY (`post_data_specsID`) USING BTREE,
  ADD KEY `fk_post_data_specs_tbl_pjo_tbl_1` (`pjoID`) USING BTREE;

--
-- Indexes for table `process_tbl`
--
ALTER TABLE `process_tbl`
  ADD PRIMARY KEY (`processID`),
  ADD KEY `fk_process_tbl_mpo_tbl_1` (`mpoID`);

--
-- Indexes for table `production_monitoring_tbl`
--
ALTER TABLE `production_monitoring_tbl`
  ADD PRIMARY KEY (`outputID`) USING BTREE,
  ADD KEY `fk_output_monitoring_tbl_pjo_tbl_1` (`pjoID`) USING BTREE;

--
-- Indexes for table `total_material_used`
--
ALTER TABLE `total_material_used`
  ADD PRIMARY KEY (`materialusedID`),
  ADD KEY `fk_total_material_used_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `weaverlist_tbl`
--
ALTER TABLE `weaverlist_tbl`
  ADD PRIMARY KEY (`weaverID`);

--
-- Indexes for table `w_category`
--
ALTER TABLE `w_category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `w_otp`
--
ALTER TABLE `w_otp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personelID` (`uid`);

--
-- Indexes for table `w_supplierlist`
--
ALTER TABLE `w_supplierlist`
  ADD PRIMARY KEY (`supplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `design_specs_tbl`
--
ALTER TABLE `design_specs_tbl`
  MODIFY `design_specsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item_actual_weight`
--
ALTER TABLE `item_actual_weight`
  MODIFY `actualweightID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `material_issuance_tbl`
--
ALTER TABLE `material_issuance_tbl`
  MODIFY `material_issuanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `material_specs_tbl`
--
ALTER TABLE `material_specs_tbl`
  MODIFY `material_specsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `mpo_base`
--
ALTER TABLE `mpo_base`
  MODIFY `baseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mpo_datereceived_logs`
--
ALTER TABLE `mpo_datereceived_logs`
  MODIFY `datareceivedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `mpo_segregate_tbl`
--
ALTER TABLE `mpo_segregate_tbl`
  MODIFY `segregateID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pjo_tbl`
--
ALTER TABLE `pjo_tbl`
  MODIFY `pjoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `post_data_specs_tbl`
--
ALTER TABLE `post_data_specs_tbl`
  MODIFY `post_data_specsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `production_monitoring_tbl`
--
ALTER TABLE `production_monitoring_tbl`
  MODIFY `outputID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `total_material_used`
--
ALTER TABLE `total_material_used`
  MODIFY `materialusedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `weaverlist_tbl`
--
ALTER TABLE `weaverlist_tbl`
  MODIFY `weaverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `w_category`
--
ALTER TABLE `w_category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `w_otp`
--
ALTER TABLE `w_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `w_supplierlist`
--
ALTER TABLE `w_supplierlist`
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issuance_tbl`
--
ALTER TABLE `issuance_tbl`
  ADD CONSTRAINT `fk_issuance_tbl_mpo_segregate_tbl_1` FOREIGN KEY (`segregateID`) REFERENCES `mpo_segregate_tbl` (`segregateID`);

--
-- Constraints for table `item_actual_weight`
--
ALTER TABLE `item_actual_weight`
  ADD CONSTRAINT `fk_item_actual_weight_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `mpo_base`
--
ALTER TABLE `mpo_base`
  ADD CONSTRAINT `fk_mpo_base_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`);

--
-- Constraints for table `mpo_datereceived_logs`
--
ALTER TABLE `mpo_datereceived_logs`
  ADD CONSTRAINT `fk_baseID` FOREIGN KEY (`baseID`) REFERENCES `mpo_base` (`baseID`),
  ADD CONSTRAINT `fk_table_mpoID` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`);

--
-- Constraints for table `mpo_tbl`
--
ALTER TABLE `mpo_tbl`
  ADD CONSTRAINT `fk_mpo_tbl_category_tbl_1` FOREIGN KEY (`categoryID`) REFERENCES `w_category` (`categoryID`),
  ADD CONSTRAINT `fk_mpo_tbl_personel_tbl_1` FOREIGN KEY (`personelID`) REFERENCES `personel_tbl` (`personelID`),
  ADD CONSTRAINT `fk_mpo_tbl_supplier_tbl_1` FOREIGN KEY (`supplierID`) REFERENCES `w_supplierlist` (`supplierID`);

--
-- Constraints for table `process_tbl`
--
ALTER TABLE `process_tbl`
  ADD CONSTRAINT `fk_process_tbl_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`);

--
-- Constraints for table `total_material_used`
--
ALTER TABLE `total_material_used`
  ADD CONSTRAINT `fk_total_material_used_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `w_otp`
--
ALTER TABLE `w_otp`
  ADD CONSTRAINT `fk_personelID` FOREIGN KEY (`uid`) REFERENCES `personel_tbl` (`personelID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
