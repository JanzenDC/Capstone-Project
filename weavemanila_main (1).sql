-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 05:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
(1, 1, 'Janzen Forrest Dela Cruz', 'Owner', 'Backup Data', '2024-04-26', '2024-04-26 08:45:53', '1713894644_6627f4f457dc65.71159290_astronaut_in_space_by_yuzzie1_df.png'),
(2, NULL, 'Janzen Forrest Dela Cruz', 'Owner', 'Create a PJO Form ID:1', '2024-04-27', '2024-04-27 06:53:57', '1713894644_6627f4f457dc65.71159290_astronaut_in_space_by_yuzzie1_df.png');

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
(1, 1, 'polygon', '23', '24', '25', '26', '27');

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
(1, 1, 1, 2, 'Kilogram'),
(2, 1, 2, 3, 'Kilogram'),
(3, 1, 3, 4, 'Kilogram');

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
(1, 1, 'Insert', 2, 'Material 1', 1, 1),
(2, 1, 'Weft', 3, 'Material 2', 2, 2),
(3, 1, 'Warp', 1, 'Material 3', 3, 1);

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
  `subtotal` int(11) DEFAULT NULL,
  `quantity_balance` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_base`
--

INSERT INTO `mpo_base` (`baseID`, `mpoID`, `item_name`, `description`, `quantity`, `unit`, `quantity_received`, `unit_price`, `status`, `discounts`, `subtotal`, `quantity_balance`) VALUES
(1, 1, 'm1 fiber', 'Fiber for model M1', 5, 'kilograms', 5, 155, 2, NULL, 775, 0),
(2, 1, 's2 fiber', 'Fiber for model S3', 25, 'kilograms', 25, 170, 2, NULL, 4250, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mpo_datereceived_logs`
--

CREATE TABLE `mpo_datereceived_logs` (
  `datareceivedID` int(11) NOT NULL,
  `mpoID` int(11) NOT NULL DEFAULT 0,
  `baseID` int(11) NOT NULL,
  `date_received` date DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `received` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_datereceived_logs`
--

INSERT INTO `mpo_datereceived_logs` (`datareceivedID`, `mpoID`, `baseID`, `date_received`, `status`, `timestamp`, `received`) VALUES
(1, 1, 1, '2024-04-26', 2, '2024-04-26 06:06:26', 5),
(2, 1, 2, '2024-04-26', 2, '2024-04-26 06:06:26', 25);

-- --------------------------------------------------------

--
-- Table structure for table `mpo_segregate_balance`
--

CREATE TABLE `mpo_segregate_balance` (
  `segID` int(11) NOT NULL,
  `baseID` int(11) DEFAULT NULL,
  `process` varchar(255) NOT NULL,
  `quantity_raw_bal` int(11) NOT NULL,
  `qty_received` int(11) DEFAULT NULL,
  `waste_bal` int(11) DEFAULT NULL,
  `qty_bal_received` int(11) DEFAULT NULL,
  `twine_data` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mpo_segregate_tbl`
--

CREATE TABLE `mpo_segregate_tbl` (
  `segregateID` int(11) NOT NULL,
  `mpoID` int(11) DEFAULT NULL,
  `baseID` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `segregator` varchar(255) DEFAULT NULL,
  `order_stocks` float DEFAULT NULL,
  `received` float DEFAULT NULL,
  `balance_for_purchases` float DEFAULT NULL,
  `qty_raw_for_issuance` float DEFAULT NULL,
  `balance_raw_for_issuance` float DEFAULT NULL,
  `qty_for_received_taknis` float DEFAULT NULL,
  `waste_gumon_for_received_taknis` float DEFAULT NULL,
  `balance_for_received_taknis` float DEFAULT NULL,
  `process` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `mpo_segregator_projects`
--

CREATE TABLE `mpo_segregator_projects` (
  `segreID` int(11) NOT NULL,
  `baseID` int(11) NOT NULL,
  `segregatorName` varchar(255) DEFAULT NULL,
  `date_issuance` date NOT NULL,
  `qty_issued` int(11) DEFAULT NULL,
  `qty_received` int(11) DEFAULT NULL,
  `waste_gumon` int(11) DEFAULT NULL,
  `process` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_segregator_projects`
--

INSERT INTO `mpo_segregator_projects` (`segreID`, `baseID`, `segregatorName`, `date_issuance`, `qty_issued`, `qty_received`, `waste_gumon`, `process`) VALUES
(2, 1, 'Juan Dela Cruz', '2024-04-27', 5, 4, 1, 'Braided'),
(10, 2, 'Juan Dela Cruz', '2024-04-27', 12, 11, 1, 'Braided'),
(11, 2, 'Juan Dela Cruz', '2024-05-02', 5, 2, 1, 'Braided'),
(12, 2, 'Juan Dela Cruz', '2024-04-28', 2, 1, 0, 'Braided'),
(13, 2, 'Gab Vincent', '2024-04-27', 2, 1, 0, 'Taknis'),
(14, 2, 'Miles Morales', '2024-04-25', 2, 1, 0, 'Braided');

-- --------------------------------------------------------

--
-- Table structure for table `mpo_starting_date`
--

CREATE TABLE `mpo_starting_date` (
  `mpoID` int(11) NOT NULL,
  `startingNo` int(11) DEFAULT NULL,
  `companyDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_starting_date`
--

INSERT INTO `mpo_starting_date` (`mpoID`, `startingNo`, `companyDate`) VALUES
(1, 24, '2024-04-10');

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
  `file_esignaturea` varchar(255) NOT NULL,
  `services` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_tbl`
--

INSERT INTO `mpo_tbl` (`mpoID`, `personelID`, `supplierID`, `categoryID`, `mpo_ref_no`, `date_purchased`, `client_ref_no`, `w_o_ref_no`, `delivery_date`, `delivery_address`, `supplier_address`, `company_address`, `total`, `delivery_charge`, `discount`, `other_costs`, `vat`, `total_amount`, `notes_instructions`, `prepared_by`, `approved_by`, `file_logo`, `file_esignaturep`, `file_esignaturea`, `services`) VALUES
(1, NULL, 58, 2, 'WEMA24-MPO-2024-04-26-1', '2024-04-26', '', '', NULL, 'Region 05, ALBAY, LEGAZPI CITY, BGY. 51 - BUYUAN (BGY. 49)', 'Region 05,CATANDUANES,PANDAN,LIBOD (POB.)', 'Region 05, ALBAY, LEGAZPI CITY, BGY. 51 - BUYUAN (BGY. 49)', 5025, 250, 10, 300, 12, 5681.2, 'Test', NULL, NULL, '', '', '', 'Cleaning,Weighting');

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
  `suffix` varchar(255) DEFAULT NULL,
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
  `company_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personel_tbl`
--

INSERT INTO `personel_tbl` (`personelID`, `email`, `username`, `firstname`, `middlename`, `lastname`, `suffix`, `password`, `profile_pic`, `gender`, `position`, `mobile_number`, `birthdate`, `age`, `address`, `status`, `account_created`, `civil_status`, `isAdmin`, `company_logo`) VALUES
(1, 'companyweavemanila@gmail.com', 'janzen.d', 'Janzen Forrest', 'Agarin', 'Dela Cruz', '', '$2y$10$EE9.d3ilY3sMX15z4S247OAu8cOp.5LxReGS06qPK9R7/7Sz3S3J2', '1713894644_6627f4f457dc65.71159290_astronaut_in_space_by_yuzzie1_df.png', 'Male', 'Owner', '09123456789', '2001-07-27', 22, 'Region 05, ALBAY, LEGAZPI CITY, BGY. 51 - BUYUAN (BGY. 49)', 1, '2024-01-26 09:28:56', 'Single', 1, '1714050278_662a54e61d7e00.17476168_depositphotos_449066958-stock-photo-financial-accounting-logo-financial-logo.jpg'),
(2, 'user1@example.com', 'user1', 'John', 'Doe', 'Smith', NULL, 'password1', 'man_2.png', 'Male', 'production staff', '1234567890', '1990-01-01', 31, '123 Main St', 0, '2024-01-26 09:56:25', '', 0, NULL),
(3, 'user2@example.com', 'user2', 'Jane', 'Doe', 'Johnson', NULL, 'password2', 'woman_2.png', 'Female', 'warehouseman', '2147483647', '1995-05-15', 26, '456 Oak St', 0, '2024-01-26 09:56:25', '', 0, NULL),
(5, 'user1@example.com', 'user1', 'User', 'M', 'One', NULL, 'hashed_password1', 'man_4.png', 'Male', 'warehouseman', '1234567891', '1990-02-15', 32, '123 Street Ave, City', 0, '2024-01-26 11:55:51', '', 0, NULL),
(18, 'carlbrozebandola24@gmail.com', '', 'Carlo ', '', 'Bandola', NULL, '$2y$10$94gsllwLkABo7bShX7G8WOC9clSN66Gg0MGLksrl0jL4BI5/g3YN6', 'default_pfp.png', 'Male', 'Production Staff', '9123456789', '2024-01-02', 0, 'Pogi Street', 0, '2024-01-27 04:45:44', 'Single', 0, NULL),
(19, 'meniski2345@gmail.com', NULL, 'Janzen', NULL, 'Dela Cruz', NULL, '$2y$10$L0ooYzUynv4jcoOjJ.5vrOt9ZXCe/4vm5DOyEyNf78QzPwEO3rINa', 'default_pfp.png', 'Male', 'Warehouseman', '09123456789', '2001-07-27', 22, 'P-5', 0, '2024-04-01 09:57:41', 'Single', 0, NULL),
(22, 'tflegazpi@gmail.com', NULL, 'James', NULL, 'Borras', NULL, '$2y$10$g09RFbQU5wH6nYu2bD6LneDGhLckDUwR4Czaikvdi7xMOcqiIEX9.', 'default_pfp.png', 'Male', 'Warehouseman', '09123456789', '2003-02-13', 21, 'Sto. Dominggo', 0, '2024-04-22 08:52:35', 'Single', 0, NULL);

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
  `services` varchar(255) DEFAULT NULL,
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
  `client_name` varchar(255) DEFAULT NULL,
  `status` tinyint(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pjo_tbl`
--

INSERT INTO `pjo_tbl` (`pjoID`, `personelID`, `endorse`, `job_order_no`, `date`, `reference`, `services`, `delivery_date`, `f_esignature_preparedby`, `f_esignature_approvedby`, `f_preparedby`, `f_approvedby`, `description`, `design_pattern`, `construction`, `width`, `length`, `size_selected`, `quantity`, `date_started`, `b_esignature_preparedby`, `b_esignature_approvedby`, `b_preparedby`, `b_approvedby`, `date_finished`, `lead_time`, `qouta`, `loom`, `color`, `checked_by`, `order_date`, `commitment_date`, `shipped_date`, `client_name`, `status`) VALUES
(1, NULL, 'Pedro Dela Cruz', 0, '2024-04-29', '3', 'Weaving,Cleaning,Trimming', '2024-04-30', NULL, NULL, 'Janzen Forrest Dela Cruz', 'null', 'Test Input', 'Flower', 'Test Input', 100, 200, 'Centimeters', '3', '2024-04-29', NULL, NULL, 'Pedro Dela Cruz', '', '2024-05-12', 13, 3, 3, 'Red', 'John Smith', '2024-04-27', '2024-04-30', '2024-05-03', 'John Wick', 0);

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
(1, 1, '24', '25', 24, 23, 2, 3);

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
  `date` date DEFAULT NULL,
  `time_in_am` time DEFAULT NULL,
  `time_out_pm` time DEFAULT NULL,
  `output_am_pm` varchar(255) DEFAULT NULL,
  `ot_time_in` time DEFAULT NULL,
  `ot_time_out` time DEFAULT NULL,
  `ot_output` varchar(255) DEFAULT NULL,
  `total_output` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `production_monitoring_tbl`
--

INSERT INTO `production_monitoring_tbl` (`outputID`, `pjoID`, `date`, `time_in_am`, `time_out_pm`, `output_am_pm`, `ot_time_in`, `ot_time_out`, `ot_output`, `total_output`) VALUES
(1, 1, '2024-05-03', '10:09:00', '10:10:00', '23', '00:00:00', '00:00:00', '0', 23),
(2, 1, '2024-05-02', '10:11:00', '10:11:00', '23', '00:00:00', '00:00:00', '0', 23);

-- --------------------------------------------------------

--
-- Table structure for table `segregatorlist_tbl`
--

CREATE TABLE `segregatorlist_tbl` (
  `segregatorID` int(11) NOT NULL,
  `segregatorFname` varchar(255) DEFAULT NULL,
  `segregatorLname` varchar(255) DEFAULT NULL,
  `segregatorContact` varchar(12) DEFAULT NULL,
  `segregatorEmail` varchar(255) DEFAULT NULL,
  `segregatorAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `segregatorlist_tbl`
--

INSERT INTO `segregatorlist_tbl` (`segregatorID`, `segregatorFname`, `segregatorLname`, `segregatorContact`, `segregatorEmail`, `segregatorAddress`) VALUES
(1, 'Juan', 'Dela Cruz', '09123456789', 'pedro@gmail.com', 'Region 02, ISABELA, CABATUAN, DEL PILAR'),
(2, 'Gab', 'Vincent', '09123456323', 'gab@gmail.com', 'Region 05, MASBATE, ESPERANZA, LIBERTAD'),
(3, 'Miles', 'Morales', '09876653214', 'miles@gmail.com', 'Region 03, TARLAC, LA PAZ, LA PURISIMA');

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
(1, 'Pedro', 'Dela Cruz', '09123454322', 'pedro@gmail.com', 'Region 01, ILOCOS SUR, GREGORIO DEL PILAR (CONCEPCION), POBLACION NORTE'),
(2, 'Johny', 'Yes Papa', '09234125673', 'johny@gmail.com', 'Region 01, ILOCOS NORTE, CURRIMAO, MAGLAOI CENTRO');

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
(5, 'Packing Materials', 'test input', ''),
(6, 'Dyeing Materials', 'a', ''),
(7, 'Backing Materials', 'b', ''),
(8, 'Finished Carpets', 'c', '');

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

-- --------------------------------------------------------

--
-- Table structure for table `w_supplierlist`
--

CREATE TABLE `w_supplierlist` (
  `supplierID` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `w_supplierlist`
--

INSERT INTO `w_supplierlist` (`supplierID`, `supplier_name`, `contact_person`, `address`, `email`, `category`) VALUES
(30, 'EagleExpress', 'Carlo', 'Konoha', 'meniski2345@gmail.com', NULL),
(31, 'Supplier1', 'John Doe', '123 Main Street, City1', 'supplier1@example.com', NULL),
(32, 'Supplier2', 'Jane Smith', '456 Oak Avenue, City2', 'supplier2@example.com', NULL),
(33, 'Supplier3', 'Bob Johnson', '789 Elm Road, City3', 'supplier3@example.com', NULL),
(34, 'Supplier4', 'Alice Brown', '321 Pine Lane, City4', 'supplier4@example.com', NULL),
(35, 'Supplier5', 'Chris Green', '654 Birch Street, City5', 'supplier5@example.com', NULL),
(36, 'Supplier6', 'Eva White', '987 Maple Drive, City6', 'supplier6@example.com', NULL),
(37, 'Supplier7', 'Mike Black', '234 Cedar Road, City7', 'supplier7@example.com', NULL),
(38, 'Supplier8', 'Sara Grey', '567 Walnut Lane, City8', 'supplier8@example.com', NULL),
(42, 'Supplier12', 'Sophie Purple', '789 Maple Drive, City12', 'supplier12@example.com', NULL),
(43, 'J&T', 'Janzen Dela Cruz', 'NCR, NATIONAL CAPITAL REGION - FOURTH DISTRICT, CITY OF LAS PIÑAS, ILAYA', 'tflegazpi@gmail.com', NULL),
(58, 'Shopee', 'John Doe', 'Region 05,CATANDUANES,PANDAN,LIBOD (POB.)', 'Shopee@gmail.com', 'Raw Materials');

-- --------------------------------------------------------

--
-- Table structure for table `w_supplierlist_item`
--

CREATE TABLE `w_supplierlist_item` (
  `itemID` int(11) NOT NULL,
  `supplierID` int(11) NOT NULL,
  `itemName` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `unit_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `w_supplierlist_item`
--

INSERT INTO `w_supplierlist_item` (`itemID`, `supplierID`, `itemName`, `description`, `unit`, `unit_price`) VALUES
(1, 58, 's1 fiber', 'Fiber for model S1', 'kilograms', 16),
(2, 58, 'm1 fiber', 'Fiber for model M1', 'kilograms', 155),
(3, 58, 'jk fiber', 'Fiber for model JK', 'kilograms', 12),
(4, 58, 's2 fiber', 'Fiber for model S3', 'kilograms', 170),
(5, 58, 'm3 fiber', 'Fiber for model M3', 'kilograms', 20);

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
-- Indexes for table `mpo_segregate_balance`
--
ALTER TABLE `mpo_segregate_balance`
  ADD PRIMARY KEY (`segID`);

--
-- Indexes for table `mpo_segregate_tbl`
--
ALTER TABLE `mpo_segregate_tbl`
  ADD PRIMARY KEY (`segregateID`) USING BTREE,
  ADD KEY `fk_mpo_segregate_tbl_mpo_tbl_1` (`mpoID`) USING BTREE;

--
-- Indexes for table `mpo_segregator_projects`
--
ALTER TABLE `mpo_segregator_projects`
  ADD PRIMARY KEY (`segreID`);

--
-- Indexes for table `mpo_starting_date`
--
ALTER TABLE `mpo_starting_date`
  ADD PRIMARY KEY (`mpoID`);

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
-- Indexes for table `segregatorlist_tbl`
--
ALTER TABLE `segregatorlist_tbl`
  ADD PRIMARY KEY (`segregatorID`);

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
-- Indexes for table `w_supplierlist_item`
--
ALTER TABLE `w_supplierlist_item`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `fk_supplierlist` (`supplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `design_specs_tbl`
--
ALTER TABLE `design_specs_tbl`
  MODIFY `design_specsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `issuance_tbl`
--
ALTER TABLE `issuance_tbl`
  MODIFY `issuanceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_actual_weight`
--
ALTER TABLE `item_actual_weight`
  MODIFY `actualweightID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `material_issuance_tbl`
--
ALTER TABLE `material_issuance_tbl`
  MODIFY `material_issuanceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_specs_tbl`
--
ALTER TABLE `material_specs_tbl`
  MODIFY `material_specsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mpo_base`
--
ALTER TABLE `mpo_base`
  MODIFY `baseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mpo_datereceived_logs`
--
ALTER TABLE `mpo_datereceived_logs`
  MODIFY `datareceivedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mpo_segregate_balance`
--
ALTER TABLE `mpo_segregate_balance`
  MODIFY `segID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mpo_segregate_tbl`
--
ALTER TABLE `mpo_segregate_tbl`
  MODIFY `segregateID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mpo_segregator_projects`
--
ALTER TABLE `mpo_segregator_projects`
  MODIFY `segreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mpo_starting_date`
--
ALTER TABLE `mpo_starting_date`
  MODIFY `mpoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personel_tbl`
--
ALTER TABLE `personel_tbl`
  MODIFY `personelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pjo_tbl`
--
ALTER TABLE `pjo_tbl`
  MODIFY `pjoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post_data_specs_tbl`
--
ALTER TABLE `post_data_specs_tbl`
  MODIFY `post_data_specsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `production_monitoring_tbl`
--
ALTER TABLE `production_monitoring_tbl`
  MODIFY `outputID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `segregatorlist_tbl`
--
ALTER TABLE `segregatorlist_tbl`
  MODIFY `segregatorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `total_material_used`
--
ALTER TABLE `total_material_used`
  MODIFY `materialusedID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weaverlist_tbl`
--
ALTER TABLE `weaverlist_tbl`
  MODIFY `weaverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `w_category`
--
ALTER TABLE `w_category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `w_otp`
--
ALTER TABLE `w_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `w_supplierlist`
--
ALTER TABLE `w_supplierlist`
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `w_supplierlist_item`
--
ALTER TABLE `w_supplierlist_item`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

--
-- Constraints for table `w_supplierlist_item`
--
ALTER TABLE `w_supplierlist_item`
  ADD CONSTRAINT `fk_supplierlist` FOREIGN KEY (`supplierID`) REFERENCES `w_supplierlist` (`supplierID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
