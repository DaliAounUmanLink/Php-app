-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 03 oct. 2024 à 12:08
-- Version du serveur : 8.4.2
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db1`
--

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `release_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `poster` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `films`
--

INSERT INTO `films` (`id`, `title`, `description`, `release_date`, `created_at`, `poster`) VALUES
(1, 'Inception', 'Synopsis. Dominick \"Dom\" Cobb (Leonardo DiCaprio) and business partner Arthur (Joseph Gordon-Levitt) are \"extractors\", people who perform corporate espionage using an experimental military technology to infiltrate the subconscious of their targets and extract information while experiencing shared dreaming.', '2010-08-13', '2024-09-30 12:04:59', 'inception (Copie).jpg'),
(2, 'The Shawshank Redemption', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', '1994-09-23', '2024-09-30 12:04:59', 'theshawshankredemption.jpg'),
(5, 'The Hangover ', 'The Hangover is a comedy film directed by Todd Phillips, released on June 5, 2009. The story follows a group of friends who travel to Las Vegas for a bachelor party. After a night of wild partying, they wake up with no memory of the previous night and discover that the groom is missing. The film revolves around their chaotic and comedic attempts to piece together the events of the night before and find their friend before the wedding.', '2009-06-06', '2024-10-02 12:00:40', 'thehangover.jpg'),
(6, 'Pirates of the Caribbean: The Curse of the Black Pearl', 'A young blacksmith named Will Turner teams up with eccentric pirate Captain Jack Sparrow to save his kidnapped love, Elizabeth Swann, from cursed pirates who are doomed to roam the seas eternally as undead beings.', '2003-07-09', '2024-10-02 16:01:29', 'piratesofthecaribbean.png'),
(7, 'Titanic', 'Titanic is an epic romance and disaster film directed by James Cameron. The story follows a fictionalized account of the sinking of the RMS Titanic, a luxury British passenger liner that sank after hitting an iceberg on its maiden voyage in April 1912.', '1997-12-19', '2024-10-02 16:49:47', 'titanic.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `film_id` int NOT NULL,
  `reservation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `seat_number` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `film_id`, `reservation_date`, `seat_number`) VALUES
(1, 1, 1, '2024-09-30 13:38:09', NULL),
(2, 1, 2, '2024-09-30 14:05:57', '42'),
(3, 1, 2, '2024-09-30 14:05:57', '43'),
(4, 1, 2, '2024-09-30 14:05:57', '44'),
(5, 1, 2, '2024-09-30 14:05:57', '45');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'dali', 'daliaoun@gmail.com', '$2y$10$5VcXYMcWmWMBCXaYFAN62utqmg/0ZFwSw.QoTkGt3t9rdPdftbL.m', '2024-09-30 11:58:54', 'admin'),
(2, 'nouri', 'nouri@gmail.com', '$2y$10$ZTR0PfRZLUzfd.dYu9/yi.ahXSgFJmxWBUo69PI2g3MatYGYsrqXa', '2024-10-01 14:51:02', NULL),
(13, 'yosra', 'yosra@gmail.com', '$2y$10$MzRIgNmwLCilthEK2TAGh./RgYHZB5Eyofg5KVKlDte1CShbX8zPu', '2024-10-02 15:27:50', 'admin'),
(15, 'fathi', 'fathi@gmail.com', '$2y$10$s4lHaLxez8J3ucN/v91vpeg9Yb.jUXPCM514fdatZiZO454Yh5rDi', '2024-10-03 11:15:11', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `film_id` (`film_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
