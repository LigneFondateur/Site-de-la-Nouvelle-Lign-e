-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 01 juin 2024 à 21:17
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionnaire_equipe`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrer`
--

DROP TABLE IF EXISTS `administrer`;
CREATE TABLE IF NOT EXISTS `administrer` (
  `idUtilisateur` int NOT NULL,
  `idEquipe` int NOT NULL,
  `estHabiliteAdmin` int NOT NULL,
  PRIMARY KEY (`idUtilisateur`,`idEquipe`),
  KEY `idEquipe` (`idEquipe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ancien_mdp`
--

DROP TABLE IF EXISTS `ancien_mdp`;
CREATE TABLE IF NOT EXISTS `ancien_mdp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ancienMdp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carte_utilisateur`
--

DROP TABLE IF EXISTS `carte_utilisateur`;
CREATE TABLE IF NOT EXISTS `carte_utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contenu` text COLLATE utf8mb4_general_ci,
  `youtube` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitch` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discord` varchar(27) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idUtilisateur` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `carte_utilisateur`
--

INSERT INTO `carte_utilisateur` (`id`, `contenu`, `youtube`, `twitch`, `discord`, `idUtilisateur`) VALUES
(1, NULL, 'https://www.youtube.com/channel/UCEh-TtBe3SXJRKN0FfvO7Eg', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `idUtilisateur` int NOT NULL,
  `idEquipe` int NOT NULL,
  `idRole` int NOT NULL,
  PRIMARY KEY (`idUtilisateur`,`idEquipe`),
  KEY `idEquipe` (`idEquipe`),
  KEY `idRole` (`idRole`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`idUtilisateur`, `idEquipe`, `idRole`) VALUES
(6, 1, 1),
(5, 1, 1),
(5, 3, 1),
(5, 5, 1),
(5, 4, 1),
(5, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `demander`
--

DROP TABLE IF EXISTS `demander`;
CREATE TABLE IF NOT EXISTS `demander` (
  `idEquipe` int NOT NULL,
  `idDemande_Adhesion` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `idRole` int NOT NULL,
  PRIMARY KEY (`idEquipe`,`idDemande_Adhesion`),
  KEY `idDemande_Adhesion` (`idDemande_Adhesion`),
  KEY `idRole` (`idRole`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demander`
--

INSERT INTO `demander` (`idEquipe`, `idDemande_Adhesion`, `idRole`) VALUES
(3, '13', 1),
(3, '12', 1),
(3, '11', 1),
(3, '10', 1),
(1, '10', 1),
(5, '9', 2),
(3, '9', 1),
(1, '9', 1);

-- --------------------------------------------------------

--
-- Structure de la table `demande_adhesion`
--

DROP TABLE IF EXISTS `demande_adhesion`;
CREATE TABLE IF NOT EXISTS `demande_adhesion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ambitions` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `interetsSelectionne` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dateDemande` datetime NOT NULL,
  `estTraite` int NOT NULL DEFAULT '0',
  `idUtilisateur` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demande_adhesion`
--

INSERT INTO `demande_adhesion` (`id`, `pseudo`, `ambitions`, `interetsSelectionne`, `email`, `dateDemande`, `estTraite`, `idUtilisateur`) VALUES
(9, 'Lignée Test', 'ceci est un message de test', NULL, 'test@test.fr', '2024-04-30 19:05:21', 0, NULL),
(10, 'Lignée Test 2', 'ceci est un message de test', NULL, 'test2@test.fr', '2024-04-30 19:06:56', 0, NULL),
(11, 'Lignée Test 3', 'ceci est un message de test', NULL, 'test3@test.fr', '2024-04-30 19:06:57', 0, NULL),
(12, 'Lignée Test 4', 'ceci est un message de test', NULL, 'test3@test.fr', '2024-04-30 19:06:58', 0, NULL),
(13, 'Lignée Test 5', 'ceci est un message de test', NULL, 'test3@test.fr', '2024-04-30 19:06:59', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `placesTotales` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `nom`, `placesTotales`) VALUES
(1, 'Clash Royale', 50),
(2, 'Clash of Clans', 50),
(3, 'Brawl Stars', 50),
(4, 'Rocket League', 10),
(5, 'Fortnite', 10);

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

DROP TABLE IF EXISTS `resultat`;
CREATE TABLE IF NOT EXISTS `resultat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estValide` int DEFAULT NULL,
  `motif` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dateObtention` datetime DEFAULT NULL,
  `idDemande_Adhesion` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idDemande_Adhesion` (`idDemande_Adhesion`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `nom`, `description`) VALUES
(1, 'membre', 'Membre de l\'équipe'),
(2, 'coach', 'Entraîneur de l\'équipe');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `motDePasse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estGestionnaire` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `email`, `motDePasse`, `image`, `estGestionnaire`) VALUES
(6, 'Utilisateur', 'utilisateur@test.fr', '$2y$10$v3sRj2DymFS7LI3DX6J4bOqck8JZ9z42OsoVZiW5hxNBYlrqdMUqC', NULL, 0),
(5, 'Lignée Fondateur', 'gestionnaire@test.fr', '$2y$10$v3sRj2DymFS7LI3DX6J4bOqck8JZ9z42OsoVZiW5hxNBYlrqdMUqC', NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
