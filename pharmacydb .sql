-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 08:25 AM
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
-- Database: `pharmacydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `USERNAME` varchar(10) NOT NULL,
  `PASSWORD` int(8) NOT NULL,
  `PHARMACY` varchar(50) NOT NULL,
  `ADDRESS` text NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `NUMBER` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_credentials`
--

INSERT INTO `admin_credentials` (`USERNAME`, `PASSWORD`, `PHARMACY`, `ADDRESS`, `EMAIL`, `NUMBER`) VALUES
('imasha', 12345678, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `CONTACT_NUMBER` int(10) NOT NULL,
  `ADDRESS` text NOT NULL,
  `DOCTOR_NAME` varchar(20) NOT NULL,
  `DOCTOR_ADDRESS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`ID`, `NAME`, `CONTACT_NUMBER`, `ADDRESS`, `DOCTOR_NAME`, `DOCTOR_ADDRESS`) VALUES
(1, 'Imasha Senanayaka', 766066998, 'Omalpe,embilipitiya', 'Dr. Kumara De silva', 'Embilipitiya hospital, Embilipitiya'),
(3, 'Yogeesha Lakshmini', 763356002, 'Anuradhapura', 'Dr.Nilmini', 'Kalubovila Hospital'),
(5, 'Samadhi Dissanayaka', 742360163, 'Anuradhapura', 'Dr.Lakshman', 'Anuradhapura Hospital'),
(7, 'Naduni Samindi', 740701106, 'Kegalla', 'Dr.Nuwan samarasekar', 'Kegalla Hospital'),
(9, 'Himasha Madhurangi', 712302069, 'Horana', 'Dr. Wijenayake', 'Horana Hospital'),
(10, 'Kaweesha Athapaththu', 775173220, 'Kandy', 'Dr. Siriwardhana', 'Peradeniya Hospital');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `INVOICE_ID` int(11) NOT NULL,
  `NET_TOTAL` int(11) NOT NULL,
  `INVOICE_DATE` date NOT NULL,
  `CUSTOMER_ID` int(11) NOT NULL,
  `TOTAL_AMOUNT` int(11) NOT NULL,
  `TOTAL_DISCOUNT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `PACKING` varchar(200) NOT NULL,
  `GENERIC_NAME` varchar(50) NOT NULL,
  `SUPPLIER_NAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`ID`, `NAME`, `PACKING`, `GENERIC_NAME`, `SUPPLIER_NAME`) VALUES
(1, ' Panadol  ', '10tab', 'Paracetamol (Acetaminophen)', 'Mr.Kumara'),
(2, 'Advil ', '10tab', 'Ibuprofen', 'Mr.Devinda'),
(3, 'Amodipine', '10tab', 'Amlodipine', 'Mr.Nuwan'),
(4, 'Zestril', '10tab', 'Lisinopril ', 'Mr.Nimal'),
(5, 'Amoxil  ', '20tab', 'Amoxicillin', 'Mr.Piyal'),
(6, 'Glucophage ', '10tab', 'Metformin', 'Mr.Kumara');

-- --------------------------------------------------------

--
-- Table structure for table `medicines_stock`
--

CREATE TABLE `medicines_stock` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `BATCH_ID` varchar(20) NOT NULL,
  `EXPIRY_DATE` date NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `MRP` float NOT NULL,
  `RATE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines_stock`
--

INSERT INTO `medicines_stock` (`ID`, `NAME`, `BATCH_ID`, `EXPIRY_DATE`, `QUANTITY`, `MRP`, `RATE`) VALUES
(1, 'Pandol', 'PA12', '2027-02-10', 50, 5, 20),
(2, 'Advil ', 'AD12', '2028-05-10', 40, 8, 25),
(3, 'Amodipine  ', 'AM12', '2028-05-03', 50, 15, 26),
(4, 'Zestril', 'ZE12', '2026-03-01', 30, 10, 20),
(5, 'Amoxil ', 'AM123', '2026-01-16', 30, 20, 30);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `SUPPLIER_NAME` varchar(20) NOT NULL,
  `INVOICE_NUMBER` int(11) NOT NULL,
  `VOUCHER_NUMBER` int(11) NOT NULL,
  `PURCHASE_DATE` date NOT NULL,
  `TOTAL_AMOUNT` float NOT NULL,
  `PAYMENT_STATUS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `CONTACT_NUMBER` int(10) NOT NULL,
  `ADDRESS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`ID`, `NAME`, `EMAIL`, `CONTACT_NUMBER`, `ADDRESS`) VALUES
(1, 'Mr.Kumara', 'kumara123@gmail.com', 712563423, 'Nugegoda'),
(2, 'Mr.Devinda', 'devinda345@gmail.com', 762541632, 'Kalubovila'),
(3, 'Mr.Nuwan', 'nuwan876@gmail.com', 742158965, 'Dehiwala'),
(4, 'Mr.Nimal', 'nimal235@gmail.com', 712548965, 'Wijerama'),
(5, 'Mr.Piyal', 'piyal234@gmail.com', 785412789, 'Malabe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`USERNAME`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`INVOICE_ID`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `medicines_stock`
--
ALTER TABLE `medicines_stock`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `INVOICE_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicines_stock`
--
ALTER TABLE `medicines_stock`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
