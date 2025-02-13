-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 13 Φεβ 2025 στις 16:25:34
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
  `full_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int(11) GENERATED ALWAYS AS (to_days(`end_date`) - to_days(`start_date`) + 1) STORED,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `submitted_date` datetime DEFAULT current_timestamp(),
  `manager_code` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `requests`
--

INSERT INTO `requests` (`id`, `employee_code`, `full_name`, `start_date`, `end_date`, `reason`, `status`, `submitted_date`, `manager_code`) VALUES
(1, 1111115, 'Alexandra Politou', '2025-06-10', '2025-06-20', 'Summer vacation', 'approved', '2025-02-13 15:50:38', 1111111),
(2, 1111112, 'Katerina Haskou', '2025-04-15', '2025-04-22', 'Family visit', 'pending', '2025-02-13 15:50:38', 1111111),
(3, 1111114, 'George Nasiopoulos', '2025-07-05', '2025-07-15', 'Trip abroad', 'rejected', '2025-02-13 15:50:38', 1111111),
(4, 1111113, 'Katerina Lamprou', '2025-12-23', '2026-01-02', 'Christmas holidays', 'pending', '2025-02-13 15:50:38', 1111111),
(6, 1111113, 'Katerina Lamprou', '2025-02-14', '2025-02-17', 'Romantic Trip', 'approved', '2025-02-13 15:50:38', 1111111),
(12, 1111115, 'Alexandra Politou', '2025-02-24', '2025-02-28', 'Fishing Trip', 'rejected', '2025-02-13 14:57:29', 1111111),
(13, 1111115, 'Alexandra Politou', '2025-03-10', '2025-03-14', 'Fishing Trip', 'pending', '2025-02-13 15:59:59', 1111111);

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
(1111111, 'Panagiwtis Kapsochas', 'panagiwtiskapsochas@gmail.com', '$2y$10$1vv8wO5JN5e6S9U0rf/qwO1X5dYorBiV0WkY1.U7moT0oHZ4MCpfK', 'manager', 1111111),
(1111112, 'Katerina Haskou', 'katehaskou@gmail.com', '$2y$10$tM7JzNw/mJIvOLegNYs0u./wsl9I717573gUdAX338F.OHAVbSVO.', 'employee', 1111111),
(1111113, 'Katerina Lamprou', 'katerinalamprou21@gmail.com', '$2y$10$QaRE7WMNQTnV7Uj3pXv/cOtlcUul5YaftzedQKNLH5Q8vfIJeI94e', 'employee', 1111111),
(1111114, 'George Nasiopoulos', 'gnash92@gmail.com', '$2y$10$BGVRKq6ZzErDj9vNcyHn7O0bannBAn7q05vFv4KmEY15VWxOnuT9S', 'employee', 1111111),
(1111115, 'Alexandra Politou', 'politoualexandra@gmail.com', '$2y$10$.Duxp/J1S3nuUKuxbr/fCeX2hY7lZ3H42zIu3Gt6Uyu7QYKVTVI.S', 'employee', 1111111),
(1111116, 'Sotiris Kapsochas', 'sotkapsochas@gmail.com', '$2y$10$OZmKkK4.knOilJTt8WCJlOq1NsqSNyAKJfP/eB/6kJPx8ZZZrznOu', 'employee', 1111111),
(1111117, 'Vagelis Mageiras', 'vagtax@gmail.com', '$2y$10$SBimQKHB6eZbR8z4XOODgOUQB.gRfio3eRAqVHscRouw6fvF/oQT.', 'manager', 1111117),
(1111118, 'Nikos Melidoniotis', 'nikmelido@gmail.com', '$2y$10$yYaAIGyn1jRBpRCzta90K.GrqVnY61k7UZCuH8.DqhdjcULZrUH.S', 'employee', 1111117);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
