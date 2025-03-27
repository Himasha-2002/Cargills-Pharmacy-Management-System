-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 07:24 AM
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
-- Database: `cargils-pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `doctor_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `contact`, `address`, `doctor_name`, `doctor_address`) VALUES
(1, 'Ashen Gimhana Dissanayaka', '0764426675', 'No:222,Nedungolla,Mandawala', 'A.H.Dissanayaka', 'Dehiwala Road, Nugegoda');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `inv_number` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `inv_date` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `total_discount` varchar(100) NOT NULL,
  `net_total` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `inv_number`, `customer_name`, `inv_date`, `total_amount`, `total_discount`, `net_total`) VALUES
(1, 'I-00001', 'Ashen Gimhana Dissanayaka', '2025-03-21', '90.00', '0.00', '90.00'),
(2, 'I-00002', 'Ashen Gimhana Dissanayaka', '2025-03-23', '180.00', '4.50', '175.50'),
(3, 'I-00003', 'Ashen Gimhana Dissanayaka', '2025-03-24', '180.00', '0.00', '180.00');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `packing` varchar(100) NOT NULL,
  `generic_name` varchar(100) NOT NULL,
  `supplier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `medicine_name`, `packing`, `generic_name`, `supplier`) VALUES
(1, 'Paracetamol', '15  TAB', 'Acetaminophen', 'Supplier_one'),
(3, 'Vitamin D3', '30 TAB', 'Cholecalciferol', 'HealthCare Ltd');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_stock`
--

CREATE TABLE `medicine_stock` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `packing` varchar(100) NOT NULL,
  `batch_id` varchar(100) NOT NULL,
  `expire_date` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `mrp` varchar(100) NOT NULL,
  `rate` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_stock`
--

INSERT INTO `medicine_stock` (`id`, `medicine_name`, `packing`, `batch_id`, `expire_date`, `quantity`, `mrp`, `rate`, `amount`) VALUES
(1, 'Paracetamol', '10', 'P125', '2027-11', '45', '45', '55', '2475.00'),
(2, 'Vitamin D3', '20', 'V123', '2027-10', '50', '30', '20', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `inv_number` varchar(20) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `grand_total` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `inv_number`, `supplier`, `payment_type`, `date`, `grand_total`) VALUES
(1, 'P-00001', 'HealthCare Ltd', 'Card Payment', '2025-03-19', '1100.00'),
(3, 'P-00002', 'Supplier_one', 'Cash Payment', '2025-03-21', '2200.00'),
(4, 'P-00003', 'Supplier 3', 'Cash Payment', '2025-03-24', '3475.00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `email`, `contact`, `address`) VALUES
(1, 'Supplier_one', 'supplier1@gmail.com', '0761234557', 'Dehiwala Road, Nugegoda'),
(3, 'Supplier 3', 'supplier3@gmail.com', '0761234555', 'Athurugiriya Road, Malabe'),
(4, 'HealthCare Ltd', 'healthcare@gamil.com', '0761234555', 'Athurugiriya Road, Malabe');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pharmacy_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pharmacy_name`, `address`, `email`, `contact`, `username`, `password`, `confirm_password`) VALUES
(1, 'cargils pharmacy', 'NO: 138, dehiwala road, Nugegoda', 'user1@gmail.com', '0718183768', 'testUser1', 'user1#2001', 'user1@2001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
