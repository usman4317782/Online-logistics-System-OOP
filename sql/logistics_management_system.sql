-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2024 at 09:17 PM
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
-- Database: `logistics_management_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_create_tables` ()   BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE tableName VARCHAR(255);
    DECLARE cur CURSOR FOR
        SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = 'logistics_management_system';

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO tableName;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET @sql_query = CONCAT('SHOW CREATE TABLE ', tableName, ';');
        PREPARE final_query FROM @sql_query;
        EXECUTE final_query;
        DEALLOCATE PREPARE final_query;
    END LOOP;

    CLOSE cur;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `address`, `phone_number`, `email`, `password`, `role`) VALUES
(1, 'usman', 'House no 1/1 street no 04 harbanspura lahore', '03224474879', 'usman@gmail.com', 'Usman@123', 'main');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `cnic` varchar(100) NOT NULL,
  `license_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `name`, `contact`, `cnic`, `license_number`) VALUES
(3, 'qasim', '+923554412587', '3620154896367', '456789458'),
(4, 'muhammad yousaf', '+923086588995', '3620156987412', 'KL 56447');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `type`, `amount`, `description`, `date_added`, `updated_at`) VALUES
(2, '3', 5200.00, 'Kamran Driver February Salary is paid and updated', '2024-02-10 13:56:11', '2024-02-10 15:05:06'),
(3, '2', 1500.00, 'Fuel of Vehicle No LEG-5688', '2024-02-10 14:27:37', '2024-02-10 14:53:21'),
(4, '10', 12000.00, 'new computer has been purchased', '2024-02-15 10:21:46', '2024-02-15 10:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `expense_type`
--

CREATE TABLE `expense_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_type`
--

INSERT INTO `expense_type` (`id`, `type_name`) VALUES
(1, 'fuel expenses'),
(2, 'maintenance'),
(3, 'driver’s salary'),
(4, 'demo'),
(5, 'demo'),
(6, 'demoi'),
(7, 'xyz'),
(8, 'abc'),
(9, 'image'),
(10, 'computer'),
(11, '4546'),
(12, 'Personal Expense');

-- --------------------------------------------------------

--
-- Table structure for table `freight_logistics`
--

CREATE TABLE `freight_logistics` (
  `id` int(11) NOT NULL,
  `freight_details` text NOT NULL,
  `logistics_details` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `booking_date` date DEFAULT NULL,
  `shipment_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freight_logistics`
--

INSERT INTO `freight_logistics` (`id`, `freight_details`, `logistics_details`, `price`, `booking_date`, `shipment_date`, `created_at`, `updated_at`) VALUES
(4, 'Transportation of pharmaceuticals from Rawalpindi to Faisalabad', 'Specialized courier service selected for sensitive items. Estimated delivery time: 2 days.', 1800.00, '2024-03-23', '2024-03-25', '2024-03-21 05:36:17', '2024-03-21 18:01:17'),
(5, 'Shipping of perishable goods from Lahore to Multan', 'Temperature-controlled trucks will be used for transportation. Estimated transit time: 4 days.', 2000.00, '2024-03-21', '2024-03-27', '2024-03-21 09:25:16', '2024-03-21 17:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `type`, `amount`, `description`, `date_added`, `updated_at`) VALUES
(4, '2', 26587.00, 'Maintenance income has been added', '2024-02-14 10:07:02', '2024-02-14 10:07:02'),
(5, '3', 28652.00, 'salary has been updated by the user new update and final update.', '2024-02-14 10:36:22', '2024-02-15 05:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `freight_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `stripe_charge_id` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Completed') NOT NULL,
  `current_route` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `freight_id`, `amount`, `stripe_charge_id`, `status`, `current_route`, `created_at`, `updated_at`) VALUES
(1, 5, 4, 1800, 'ch_3OwqU7GCDpOhv9Km02K3WCE8', 'Completed', '', '2024-03-21 18:37:04', '2024-03-22 12:02:46'),
(2, 5, 4, 1800, 'ch_3Ox6EMGCDpOhv9Km0YVRBUrC', 'Completed', 'Delivered', '2024-03-22 11:25:51', '2024-03-22 20:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_income` decimal(10,2) NOT NULL,
  `total_expenses` decimal(10,2) NOT NULL,
  `net_income` decimal(10,2) NOT NULL,
  `date_generated` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_type` enum('On Demand','Schedule') NOT NULL DEFAULT 'On Demand'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `start_date`, `end_date`, `total_income`, `total_expenses`, `net_income`, `date_generated`, `generated_type`) VALUES
(1, '2024-02-15', '2024-02-15', 0.00, 0.00, 0.00, '2024-02-15 08:54:11', 'On Demand'),
(2, '2024-02-01', '2024-02-15', 55239.00, 6700.00, 48539.00, '2024-02-15 09:01:10', ''),
(3, '2024-02-01', '2024-02-15', 55239.00, 6700.00, 48539.00, '2024-02-15 09:03:20', ''),
(4, '2023-02-14', '2024-02-16', 55239.00, 6700.00, 48539.00, '2024-02-15 09:04:38', 'On Demand'),
(5, '2024-02-06', '2024-02-20', 55239.00, 6700.00, 48539.00, '2024-02-15 09:05:05', ''),
(6, '2024-01-01', '2024-10-01', 55239.00, 6700.00, 48539.00, '2024-02-15 09:09:05', ''),
(7, '2024-01-01', '2024-02-15', 55239.00, 6700.00, 48539.00, '2024-02-15 09:35:18', ''),
(8, '2024-02-01', '2024-02-28', 55239.00, 18700.00, 36539.00, '2024-02-15 10:22:44', 'On Demand');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `trip_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `start_point` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `distance_covered` varchar(255) NOT NULL,
  `charges` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`trip_id`, `vehicle_id`, `driver_id`, `start_point`, `destination`, `distance_covered`, `charges`, `date`, `time`) VALUES
(7, 12, 3, 'Gujranwala', 'Sargodha', '265 KM', 2500.00, '2024-01-17', '22:00:00'),
(10, 19, 4, 'Sheikhupura', 'Rawlapindi', '50 KM', 887.00, '2024-01-17', '23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `address`, `phone_number`, `email`, `password`) VALUES
(5, 'hafiz muhammad usman     ', 'lahore', '03354888559', 'haider23@yahoo.com', 'Usman@1997'),
(6, 'hafiz muhammad usman', 'lahore', '03354888557', 'yaseen23@yahoo.com', 'Usman@1 997');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `registration_number` varchar(20) NOT NULL,
  `model` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `registration_number`, `model`, `capacity`) VALUES
(12, 'LEQ-9994', 'Hiace Dala', 5),
(19, 'LEO-8756', 'Hiace', 3),
(21, 'LOM-4579-20', 'Honda Civic', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freight_logistics`
--
ALTER TABLE `freight_logistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `trips_ibfk_1` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `freight_logistics`
--
ALTER TABLE `freight_logistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`),
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
