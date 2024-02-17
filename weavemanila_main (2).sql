-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2024 at 04:06 AM
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
(1, 1, 'John Doe', 'Manager', 'Login', '2024-01-23', '2024-01-23 07:38:10', 'man1.png'),
(2, 2, 'Jane Smith', 'Developer', 'Create Document', '2024-01-24', '2024-01-23 07:38:10', 'man.png'),
(3, 3, 'Bob Johnson', 'Analyst', 'Logout', '2024-01-25', '2024-01-23 07:38:10', 'man_2.png'),
(4, 4, 'Alice Brown', 'Coordinator', 'Update Profile', '2024-01-26', '2024-01-23 07:38:10', 'man_3.png'),
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
(30, 1, 'test', 'Owner', 'nag logout', '2024-01-17', '2024-01-26 10:54:27', 'man_1.png');

-- --------------------------------------------------------

--
-- Table structure for table `design_specs_tbl`
--

CREATE TABLE `design_specs_tbl` (
  `design_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `pattern_name` varchar(255) DEFAULT NULL,
  `dpi` varchar(255) DEFAULT NULL,
  `no_of_harness` varchar(255) DEFAULT NULL,
  `threading` varchar(255) DEFAULT NULL,
  `harness_lift` varchar(255) DEFAULT NULL,
  `pedal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `material_issuance_tbl`
--

CREATE TABLE `material_issuance_tbl` (
  `material_issuanceID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `material_desc` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `returned` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `issued_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_specs_tbl`
--

CREATE TABLE `material_specs_tbl` (
  `material_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `material_used_and_type` varchar(255) DEFAULT NULL,
  `consumption_wt_and_type` varchar(255) DEFAULT NULL,
  `waste_allow_and_type` varchar(255) DEFAULT NULL,
  `total_allow_issuance_and_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `quantity_balance` varchar(255) DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `discounts` decimal(10,2) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_base`
--

INSERT INTO `mpo_base` (`baseID`, `mpoID`, `item_name`, `description`, `quantity`, `unit`, `quantity_balance`, `unit_price`, `status`, `discounts`, `subtotal`) VALUES
(1, 78, 'qeqw', '', 0, '', NULL, 0, NULL, 10.00, 0),
(2, 78, 'eqwe', '', 0, '', NULL, 0, NULL, 0.00, 0),
(3, 78, 'qweqwe', '', 0, '', NULL, 0, NULL, 0.00, 0),
(4, 78, 'qweqwe', '', 0, '', NULL, 0, NULL, 0.00, 0),
(5, 78, 'qeqeqw', '', 0, '', NULL, 0, NULL, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mpo_segregate_tbl`
--

CREATE TABLE `mpo_segregate_tbl` (
  `segregateID` int(11) NOT NULL,
  `mpoID` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `segregator` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `approved_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpo_tbl`
--

INSERT INTO `mpo_tbl` (`mpoID`, `personelID`, `supplierID`, `categoryID`, `mpo_ref_no`, `date_purchased`, `client_ref_no`, `w_o_ref_no`, `delivery_date`, `delivery_address`, `supplier_address`, `company_address`, `total`, `delivery_charge`, `discount`, `other_costs`, `vat`, `total_amount`, `notes_instructions`, `prepared_by`, `approved_by`) VALUES
(78, 1, 30, 5, '65', '2024-02-27', 'asdasd', 'asdas', '2024-02-21', 'asdas', 'adasdas', 'asdasda', NULL, 0, 0, 0, 0, 0, 'adadadad', 'asdada', 'adada');

-- --------------------------------------------------------

--
-- Table structure for table `output_monitoring_tbl`
--

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
  `balance` varchar(255) DEFAULT NULL
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
  `age` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `account_created` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personel_tbl`
--

INSERT INTO `personel_tbl` (`personelID`, `email`, `username`, `firstname`, `middlename`, `lastname`, `password`, `profile_pic`, `gender`, `position`, `mobile_number`, `birthdate`, `age`, `address`, `status`, `account_created`, `civil_status`) VALUES
(1, 'meniski2345@gmail.com', 'janzen.d', 'Janzen Forrest', 'Agarin', 'Dela Cruz', '$2y$10$vqqbNUeoid9gFWivQV4NxOxJ.Wg./097QlB1uGasf82oU4AZWYmvW', '1707310005_65c37bb54ce044.84624441_images.png', 'Male', 'Owner', '09123456789', '2001-07-27', 0000000022, 'Buyuan Legazpi City', 1, '2024-01-26 09:28:56', 'Single'),
(2, 'user1@example.com', 'user1', 'John', 'Doe', 'Smith', 'password1', 'man_2.png', 'Male', 'Developer', '1234567890', '1990-01-01', 0000000031, '123 Main St', 0, '2024-01-26 09:56:25', ''),
(3, 'user2@example.com', 'user2', 'Jane', 'Doe', 'Johnson', 'password2', 'woman_2.png', 'Female', 'Designer', '2147483647', '1995-05-15', 0000000026, '456 Oak St', 0, '2024-01-26 09:56:25', ''),
(5, 'user1@example.com', 'user1', 'User', 'M', 'One', 'hashed_password1', 'man_4.png', 'Male', 'Manager', '1234567891', '1990-02-15', 0000000032, '123 Street Ave, City', 0, '2024-01-26 11:55:51', ''),
(18, 'carlbrozebandola24@gmail.com', '', 'Carlo ', '', 'Bandola', '$2y$10$94gsllwLkABo7bShX7G8WOC9clSN66Gg0MGLksrl0jL4BI5/g3YN6', 'default_pfp.png', 'Male', '', '2147483647', '2024-01-02', 0000000000, 'Pogi Street', 0, '2024-01-27 04:45:44', 'Single');

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
  `total` varchar(255) DEFAULT NULL,
  `prepared_issued_by` varchar(255) DEFAULT NULL,
  `noted_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_data_specs_tbl`
--

CREATE TABLE `post_data_specs_tbl` (
  `post_data_specsID` int(11) NOT NULL,
  `pjoID` int(11) DEFAULT NULL,
  `setting_w` varchar(255) DEFAULT NULL,
  `weaving_w` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `product_specs_tbl`
--

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
  `cutting` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_tbl`
--

CREATE TABLE `purchase_tbl` (
  `purchaseID` int(11) NOT NULL,
  `segregateID` int(11) DEFAULT NULL,
  `order_stocks` varchar(255) DEFAULT NULL,
  `received` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `item_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `received_taknis_tbl`
--

CREATE TABLE `received_taknis_tbl` (
  `received_taknisID` int(11) NOT NULL,
  `segregateID` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `waste_gumon` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remarks_tbl`
--

CREATE TABLE `remarks_tbl` (
  `remarksID` int(11) NOT NULL,
  `material_specsID` int(11) DEFAULT NULL,
  `item_actual_weight` double DEFAULT NULL,
  `total_material_issued` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waste_tbl`
--

CREATE TABLE `waste_tbl` (
  `wasteID` int(11) NOT NULL,
  `post_data_specsID` int(11) DEFAULT NULL,
  `warp` varchar(255) DEFAULT NULL,
  `weft` varchar(255) DEFAULT NULL,
  `insert` varchar(255) DEFAULT NULL
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
(2, 1, '408753', '2024-02-13 05:30:42');

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
(30, 'EagleExpress', 'Carlo', 'Konoha', '09123456789', 'Naruto@gmail.com'),
(31, 'Supplier1', 'John Doe', '123 Main Street, City1', '1234567890', 'supplier1@example.com'),
(32, 'Supplier2', 'Jane Smith', '456 Oak Avenue, City2', '9876543210', 'supplier2@example.com'),
(33, 'Supplier3', 'Bob Johnson', '789 Elm Road, City3', '5551234567', 'supplier3@example.com'),
(34, 'Supplier4', 'Alice Brown', '321 Pine Lane, City4', '9879876543', 'supplier4@example.com'),
(35, 'Supplier5', 'Chris Green', '654 Birch Street, City5', '4445556666', 'supplier5@example.com'),
(36, 'Supplier6', 'Eva White', '987 Maple Drive, City6', '7897891234', 'supplier6@example.com'),
(37, 'Supplier7', 'Mike Black', '234 Cedar Road, City7', '1112223333', 'supplier7@example.com'),
(38, 'Supplier8', 'Sara Grey', '567 Walnut Lane, City8', '3334445555', 'supplier8@example.com'),
(41, 'Supplier11', 'Mark Yellow', '456 Birch Street, City11', '2223334444', 'supplier11@example.com'),
(42, 'Supplier12', 'Sophie Purple', '789 Maple Drive, City12', '5556667777', 'supplier12@example.com');

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
  ADD PRIMARY KEY (`design_specsID`),
  ADD KEY `fk_design_specs_tbl_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `issuance_tbl`
--
ALTER TABLE `issuance_tbl`
  ADD PRIMARY KEY (`issuanceID`),
  ADD KEY `fk_issuance_tbl_mpo_segregate_tbl_1` (`segregateID`);

--
-- Indexes for table `material_issuance_tbl`
--
ALTER TABLE `material_issuance_tbl`
  ADD PRIMARY KEY (`material_issuanceID`),
  ADD KEY `fk_material_issuance_tbl_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `material_specs_tbl`
--
ALTER TABLE `material_specs_tbl`
  ADD PRIMARY KEY (`material_specsID`),
  ADD KEY `fk_material_specs_tbl_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `mpo_base`
--
ALTER TABLE `mpo_base`
  ADD PRIMARY KEY (`baseID`),
  ADD KEY `fk_mpo_base_mpo_tbl_1` (`mpoID`);

--
-- Indexes for table `mpo_segregate_tbl`
--
ALTER TABLE `mpo_segregate_tbl`
  ADD PRIMARY KEY (`segregateID`),
  ADD KEY `fk_mpo_segregate_tbl_mpo_tbl_1` (`mpoID`);

--
-- Indexes for table `mpo_tbl`
--
ALTER TABLE `mpo_tbl`
  ADD PRIMARY KEY (`mpoID`),
  ADD KEY `fk_mpo_tbl_category_tbl_1` (`categoryID`),
  ADD KEY `fk_mpo_tbl_supplier_tbl_1` (`supplierID`),
  ADD KEY `fk_mpo_tbl_personel_tbl_1` (`personelID`);

--
-- Indexes for table `output_monitoring_tbl`
--
ALTER TABLE `output_monitoring_tbl`
  ADD PRIMARY KEY (`outputID`),
  ADD KEY `fk_output_monitoring_tbl_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `personel_tbl`
--
ALTER TABLE `personel_tbl`
  ADD PRIMARY KEY (`personelID`);

--
-- Indexes for table `pjo_tbl`
--
ALTER TABLE `pjo_tbl`
  ADD PRIMARY KEY (`pjoID`),
  ADD KEY `fk_pjo_tbl_personel_tbl_1` (`personelID`);

--
-- Indexes for table `post_data_specs_tbl`
--
ALTER TABLE `post_data_specs_tbl`
  ADD PRIMARY KEY (`post_data_specsID`),
  ADD KEY `fk_post_data_specs_tbl_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `process_tbl`
--
ALTER TABLE `process_tbl`
  ADD PRIMARY KEY (`processID`),
  ADD KEY `fk_process_tbl_mpo_tbl_1` (`mpoID`);

--
-- Indexes for table `product_specs_tbl`
--
ALTER TABLE `product_specs_tbl`
  ADD PRIMARY KEY (`product_specsID`),
  ADD KEY `fk_product_specs_tbl_pjo_tbl_1` (`pjoID`);

--
-- Indexes for table `purchase_tbl`
--
ALTER TABLE `purchase_tbl`
  ADD PRIMARY KEY (`purchaseID`),
  ADD KEY `fk_purchase_tbl_mpo_segregate_tbl_1` (`segregateID`);

--
-- Indexes for table `received_taknis_tbl`
--
ALTER TABLE `received_taknis_tbl`
  ADD PRIMARY KEY (`received_taknisID`),
  ADD KEY `fk_received_taknis_tbl_mpo_segregate_tbl_1` (`segregateID`);

--
-- Indexes for table `remarks_tbl`
--
ALTER TABLE `remarks_tbl`
  ADD PRIMARY KEY (`remarksID`),
  ADD KEY `fk_remarks_tbl_material_specs_tbl_1` (`material_specsID`);

--
-- Indexes for table `waste_tbl`
--
ALTER TABLE `waste_tbl`
  ADD PRIMARY KEY (`wasteID`),
  ADD KEY `fk_waste_tbl_post_data_specs_tbl_1` (`post_data_specsID`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `mpo_base`
--
ALTER TABLE `mpo_base`
  MODIFY `baseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `design_specs_tbl`
--
ALTER TABLE `design_specs_tbl`
  ADD CONSTRAINT `fk_design_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `issuance_tbl`
--
ALTER TABLE `issuance_tbl`
  ADD CONSTRAINT `fk_issuance_tbl_mpo_segregate_tbl_1` FOREIGN KEY (`segregateID`) REFERENCES `mpo_segregate_tbl` (`segregateID`);

--
-- Constraints for table `material_issuance_tbl`
--
ALTER TABLE `material_issuance_tbl`
  ADD CONSTRAINT `fk_material_issuance_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `material_specs_tbl`
--
ALTER TABLE `material_specs_tbl`
  ADD CONSTRAINT `fk_material_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `mpo_base`
--
ALTER TABLE `mpo_base`
  ADD CONSTRAINT `fk_mpo_base_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`);

--
-- Constraints for table `mpo_segregate_tbl`
--
ALTER TABLE `mpo_segregate_tbl`
  ADD CONSTRAINT `fk_mpo_segregate_tbl_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`);

--
-- Constraints for table `mpo_tbl`
--
ALTER TABLE `mpo_tbl`
  ADD CONSTRAINT `fk_mpo_tbl_category_tbl_1` FOREIGN KEY (`categoryID`) REFERENCES `w_category` (`categoryID`),
  ADD CONSTRAINT `fk_mpo_tbl_personel_tbl_1` FOREIGN KEY (`personelID`) REFERENCES `personel_tbl` (`personelID`),
  ADD CONSTRAINT `fk_mpo_tbl_supplier_tbl_1` FOREIGN KEY (`supplierID`) REFERENCES `w_supplierlist` (`supplierID`);

--
-- Constraints for table `output_monitoring_tbl`
--
ALTER TABLE `output_monitoring_tbl`
  ADD CONSTRAINT `fk_output_monitoring_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `pjo_tbl`
--
ALTER TABLE `pjo_tbl`
  ADD CONSTRAINT `fk_pjo_tbl_personel_tbl_1` FOREIGN KEY (`personelID`) REFERENCES `personel_tbl` (`personelID`);

--
-- Constraints for table `post_data_specs_tbl`
--
ALTER TABLE `post_data_specs_tbl`
  ADD CONSTRAINT `fk_post_data_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `process_tbl`
--
ALTER TABLE `process_tbl`
  ADD CONSTRAINT `fk_process_tbl_mpo_tbl_1` FOREIGN KEY (`mpoID`) REFERENCES `mpo_tbl` (`mpoID`);

--
-- Constraints for table `product_specs_tbl`
--
ALTER TABLE `product_specs_tbl`
  ADD CONSTRAINT `fk_product_specs_tbl_pjo_tbl_1` FOREIGN KEY (`pjoID`) REFERENCES `pjo_tbl` (`pjoID`);

--
-- Constraints for table `purchase_tbl`
--
ALTER TABLE `purchase_tbl`
  ADD CONSTRAINT `fk_purchase_tbl_mpo_segregate_tbl_1` FOREIGN KEY (`segregateID`) REFERENCES `mpo_segregate_tbl` (`segregateID`);

--
-- Constraints for table `received_taknis_tbl`
--
ALTER TABLE `received_taknis_tbl`
  ADD CONSTRAINT `fk_received_taknis_tbl_mpo_segregate_tbl_1` FOREIGN KEY (`segregateID`) REFERENCES `mpo_segregate_tbl` (`segregateID`);

--
-- Constraints for table `remarks_tbl`
--
ALTER TABLE `remarks_tbl`
  ADD CONSTRAINT `fk_remarks_tbl_material_specs_tbl_1` FOREIGN KEY (`material_specsID`) REFERENCES `material_specs_tbl` (`material_specsID`);

--
-- Constraints for table `waste_tbl`
--
ALTER TABLE `waste_tbl`
  ADD CONSTRAINT `fk_waste_tbl_post_data_specs_tbl_1` FOREIGN KEY (`post_data_specsID`) REFERENCES `post_data_specs_tbl` (`post_data_specsID`);

--
-- Constraints for table `w_otp`
--
ALTER TABLE `w_otp`
  ADD CONSTRAINT `fk_personelID` FOREIGN KEY (`uid`) REFERENCES `personel_tbl` (`personelID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
