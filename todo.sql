-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2023 at 10:47 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('todo','doing','done') NOT NULL DEFAULT 'todo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `title`, `created_at`, `status`) VALUES
(22, 'FrontEnd', '2023-01-18 23:33:48', 'todo'),
(24, 'Dashbord', '2023-01-18 23:34:36', 'done'),
(25, 'BackEnd', '2023-01-18 23:35:30', 'doing');

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

-- Add a new table for developers
CREATE TABLE `developers` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some developers into the table
INSERT INTO `developers` (`name`) VALUES
('Naoufal'),
('Walid'),
('Mohsine'),
('Ilyass'),
('Hamza');

-- Add a new column to the `todo` table for developer assignment
ALTER TABLE `todo`
  ADD COLUMN `developer_id` int(11) UNSIGNED,
  ADD CONSTRAINT `fk_todo_developer`
  FOREIGN KEY (`developer_id`) REFERENCES `developers`(`id`)
  ON DELETE SET NULL;

-- Example of assigning tasks to specific developers
UPDATE `todo` SET `developer_id` = 1 WHERE `id` = 22;  -- Assign 'First 1' to Developer1
UPDATE `todo` SET `developer_id` = 2 WHERE `id` = 24;  -- Assign 'Third' to Developer2
UPDATE `todo` SET `developer_id` = 3 WHERE `id` = 25;  -- Assign 'Second' to Developer3;

-- End of the script
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
