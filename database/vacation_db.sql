-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 16 Φεβ 2025 στις 17:28:23
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `vacation_db`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `employee_code` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `submitted_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `requests`
--

INSERT INTO `requests` (`id`, `employee_code`, `start_date`, `end_date`, `reason`, `status`, `submitted_date`) VALUES
(16, 1010103, '2024-06-01', '2024-06-07', 'Family vacation', 'pending', '2024-05-20 00:00:00'),
(17, 1010104, '2024-07-15', '2024-07-20', 'Medical leave', 'pending', '2024-06-25 00:00:00'),
(18, 1010105, '2024-08-10', '2024-08-15', 'Personal time off', 'pending', '2024-07-30 00:00:00'),
(19, 1010106, '2024-09-05', '2024-09-12', 'Travel abroad', 'pending', '2024-08-22 00:00:00'),
(20, 1010107, '2024-05-10', '2024-05-15', 'Family event', 'pending', '2024-04-30 00:00:00'),
(21, 1010108, '2024-06-20', '2024-06-25', 'Conference attendance', 'pending', '2024-06-05 00:00:00'),
(22, 1010109, '2024-07-01', '2024-07-10', 'Vacation trip', 'pending', '2024-06-10 00:00:00'),
(23, 1010110, '2024-08-15', '2024-08-20', 'Wedding leave', 'pending', '2024-07-28 00:00:00');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `employee_code` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('manager','employee') NOT NULL,
  `manager_code` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`employee_code`, `full_name`, `email`, `password`, `role`, `manager_code`) VALUES
(1010101, 'Alice Johnson', 'manager1@mail.com', '$2y$10$yNFjiX3YL.KHUBXFhitaGORRMCDra.Qd8jSlhrOWO1WC6THTEyD5S', 'manager', 1010101),
(1010102, 'Bob Smith', 'manager2@mail.com', '$2y$10$6x6bLQnJO0my787Gtv80BeaeLXWqe248XuZgUfucUwQzW5XBuXoeW', 'manager', 1010102),
(1010103, 'Charlie Davis', 'employee1@mail.com', '$2y$10$DUHCtMKHzqX3.LakR/k4TOCMBtcuKHvk8OxrWAgKTnvw5W4.MVtgG', 'employee', 1010101),
(1010104, 'Diana Wilson', 'employee2@mail.com', '$2y$10$sKJyDYPMZUkujYm2WUaHSe93ebWrnMzuKCkHVs4bKbVl8GRsqiE.2', 'employee', 1010101),
(1010105, 'Ethan Brown', 'employee3@mail.com', '$2y$10$52lN31bV/Zoj/VGlJRHb1uitZz0cjP14sTRJsA44rwaMdXLA052Hi', 'employee', 1010101),
(1010106, 'Fiona Martinez', 'employee4@mail.com', '$2y$10$NenFaUyxSH7RWjCABwtjn.hx.UdtwSq1T8CF4mupSiTNHIiDRDcCa', 'employee', 1010101),
(1010107, 'George White', 'employee5@mail.com', '$2y$10$3wWONAqYJ.HWnKQxn7cKm.zBnIFyQwZaiee25XZYmIaH.jr14pNBK', 'employee', 1010102),
(1010108, 'Hannah Taylor', 'employee6@mail.com', '$2y$10$BQwQLzszC8qNMxTD4PjccuAwNC3Lr3LoLNKrDzCM2MhkfzMx.pSze', 'employee', 1010102),
(1010109, 'Isaac Lee', 'employee7@mail.com', '$2y$10$n5PglVMU/jOopO/K1T8cDu.WMndl18UH9pymvOLHjuBdGqOB/bki.', 'employee', 1010102),
(1010110, 'Julia Moore', 'employee8@mail.com', '$2y$10$i5z2YK4dLbsbeF.r0yCq8OR.0vQYp/kZgHqn5U/hOpxGT81nwNEAO', 'employee', 1010102);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_code` (`employee_code`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`employee_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `employee_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111119;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`employee_code`) REFERENCES `users` (`employee_code`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
