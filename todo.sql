-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 18 déc. 2023 à 16:28
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `br`
--

-- --------------------------------------------------------

--
-- Structure de la table `todo_developers`
--

CREATE TABLE `todo_developers` (
  `id` int(11) UNSIGNED NOT NULL,
  `todo_id` int(11) UNSIGNED NOT NULL,
  `developer_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `todo_developers`
--

INSERT INTO `todo_developers` (`id`, `todo_id`, `developer_id`) VALUES
(4, 1, 4),
(5, 1, 2),
(6, 1, 8),
(7, 25, 2),
(8, 25, 3),
(9, 26, 3),
(10, 27, 1),
(11, 28, 1),
(12, 28, 2),
(13, 28, 3),
(14, 29, 2),
(15, 29, 3),
(18, 31, 2),
(19, 31, 3),
(34, 38, 1),
(35, 38, 2),
(36, 38, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `todo_developers`
--
ALTER TABLE `todo_developers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_todo_id` (`todo_id`),
  ADD KEY `idx_developer_id` (`developer_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `todo_developers`
--
ALTER TABLE `todo_developers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `todo_developers`
--
ALTER TABLE `todo_developers`
  ADD CONSTRAINT `fk_todo_dev_developer_id` FOREIGN KEY (`developer_id`) REFERENCES `developers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_todo_dev_todo_id` FOREIGN KEY (`todo_id`) REFERENCES `todo` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
