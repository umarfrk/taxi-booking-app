-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 28, 2024 at 01:01 PM
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
-- Database: `AMNZ_CityTaxi_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driverID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `licenseNo` varchar(20) NOT NULL,
  `licenseExpireDate` date NOT NULL,
  `vehicleType` varchar(10) NOT NULL,
  `vehicleModel` varchar(100) NOT NULL,
  `vehicleCapacity` int(11) NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `updatedTime` datetime NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driverID`, `userID`, `licenseNo`, `licenseExpireDate`, `vehicleType`, `vehicleModel`, `vehicleCapacity`, `vehicleNo`, `status`, `updatedTime`, `active`) VALUES
(1, 3, '1234', '2024-12-31', 'Car', 'test car', 4, '1234', 'Offline', '2024-09-26 15:10:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int(11) NOT NULL,
  `tripID` int(11) NOT NULL,
  `paidBy` int(11) NOT NULL,
  `driverID` int(11) NOT NULL,
  `paymentMethod` varchar(10) NOT NULL,
  `paymentStatus` varchar(10) NOT NULL,
  `paidDateTime` datetime NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ratingID` int(11) NOT NULL,
  `driverID` int(11) NOT NULL,
  `passengerID` int(11) NOT NULL,
  `tripID` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `review` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservationID` int(11) NOT NULL,
  `reservationType` varchar(10) NOT NULL,
  `reservedBy` int(11) NOT NULL,
  `passengerName` varchar(250) NOT NULL,
  `passengerPhone` varchar(15) NOT NULL,
  `passengerNIC` varchar(15) NOT NULL,
  `vehicleType` varchar(10) NOT NULL,
  `pickupLocation` text NOT NULL,
  `dropoffLocation` text NOT NULL,
  `reservedDateTime` datetime NOT NULL,
  `scheduledDateTime` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservationID`, `reservationType`, `reservedBy`, `passengerName`, `passengerPhone`, `passengerNIC`, `vehicleType`, `pickupLocation`, `dropoffLocation`, `reservedDateTime`, `scheduledDateTime`, `amount`, `note`, `status`, `active`) VALUES
(1, 'Manual', 1, 'Yugen', '1234567', '12345678', 'Car', 'one', 'two', '2024-09-27 21:17:30', '2024-09-27 21:16:00', 1500.00, 'Developer Test', 'Pending', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `tripID` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL,
  `driverID` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `arrivedTime` datetime NOT NULL,
  `pickedupTime` datetime NOT NULL,
  `dropedoffTime` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `userphone` varchar(15) NOT NULL,
  `password` varchar(250) NOT NULL,
  `nic` varchar(15) NOT NULL,
  `address` varchar(250) NOT NULL,
  `code` varchar(50) NOT NULL,
  `token` varchar(250) NOT NULL,
  `otp` int(11) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `type` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstname`, `lastname`, `useremail`, `userphone`, `password`, `nic`, `address`, `code`, `token`, `otp`, `lastLogin`, `type`, `active`) VALUES
(3, 'TKM', 'Theesan', 'tkmtheesan1996@gmail.com', '0767078650', '$2y$10$zFD7OH9/fouhi1emaA/1KOBk6AD1F4yyMO2PMawuveHjcTpMB4clq', '961472385v', 'No.46/11, Janapathaya, Norwood', '1727343617', '4809e7802ba3aa96e0613d675cc4ff7d', 314740, '2024-09-26 15:10:17', 4, 1),
(4, 'AMNZ', 'Operator', 'operator@gmail.com', '0767078650', '$2y$10$l3QRy6W67OFnXLRFN02ky.2lkGfU7wl3mDWG57pPBIWUI7jj526ym', '961472385v', 'No.46/11, Janapathaya, Norwood', '1727425662', 'ae2a02b27f3956db7342718551e5bf19', 0, '2024-09-27 13:57:42', 3, 1),
(5, 'Theesan', 'Passenger', 'theesan@gmail.com', '0767078650', '$2y$10$KnPXQxFLb7wJI9nGp7xJx.2IHHPG1WExD9ZH66I2eAQ01m3eaTfJq', '961472385v', 'No.46/11, Janapathaya, Norwood', '1727516258', 'b503ebd848442c832c768f1c9d5a4d3d', 775615, '2024-09-28 15:07:38', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driverID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservationID`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`tripID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `tripID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
