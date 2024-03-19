-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 01:55 PM
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
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `design_specs_tbl`
--
ALTER TABLE `design_specs_tbl`
  MODIFY `design_specsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_actual_weight`
--
ALTER TABLE `item_actual_weight`
  MODIFY `actualweightID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issuance_tbl`
--
ALTER TABLE `material_issuance_tbl`
  MODIFY `material_issuanceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_specs_tbl`
--
ALTER TABLE `material_specs_tbl`
  MODIFY `material_specsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mpo_base`
--
ALTER TABLE `mpo_base`
  MODIFY `baseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mpo_datereceived_logs`
--
ALTER TABLE `mpo_datereceived_logs`
  MODIFY `datareceivedID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mpo_segregate_tbl`
--
ALTER TABLE `mpo_segregate_tbl`
  MODIFY `segregateID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pjo_tbl`
--
ALTER TABLE `pjo_tbl`
  MODIFY `pjoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_data_specs_tbl`
--
ALTER TABLE `post_data_specs_tbl`
  MODIFY `post_data_specsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_monitoring_tbl`
--
ALTER TABLE `production_monitoring_tbl`
  MODIFY `outputID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `total_material_used`
--
ALTER TABLE `total_material_used`
  MODIFY `materialusedID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weaverlist_tbl`
--
ALTER TABLE `weaverlist_tbl`
  MODIFY `weaverID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `w_category`
--
ALTER TABLE `w_category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `w_otp`
--
ALTER TABLE `w_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `w_supplierlist`
--
ALTER TABLE `w_supplierlist`
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT;

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
