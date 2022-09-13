-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 29 juil. 2022 à 17:27
-- Version du serveur : 8.0.29
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `trick_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526CB281BE2E` (`trick_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220513130651', '2022-05-21 07:25:08', 276),
('DoctrineMigrations\\Version20220526130014', '2022-05-26 13:00:54', 493),
('DoctrineMigrations\\Version20220527150850', '2022-05-27 15:09:39', 70),
('DoctrineMigrations\\Version20220527151107', '2022-05-27 15:11:13', 33),
('DoctrineMigrations\\Version20220701182748', '2022-07-01 18:28:06', 180),
('DoctrineMigrations\\Version20220729134152', '2022-07-29 13:42:15', 82),
('DoctrineMigrations\\Version20220729143159', '2022-07-29 14:32:12', 240);

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tricks_id_id` int NOT NULL,
  `imagename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FA674A03E` (`tricks_id_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `user_id` int NOT NULL,
  `grouptrick_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8F0A91EA76ED395` (`user_id`),
  KEY `IDX_D8F0A91E40C90B5F` (`grouptrick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `name`, `content`, `created_at`, `updated_at`, `user_id`, `grouptrick_id`) VALUES
(5, 'testt', 'testtt', '2022-07-08 14:56:15', NULL, 33, 1),
(6, 'testtttttttttttttttttwwww', 'testttttttttttttwwwwwwwww', '2022-07-08 14:56:28', NULL, 33, 1),
(7, 'ww', 'wwwwww', '2022-07-08 15:11:31', NULL, 33, 1),
(8, 'w.w.w.w.w', 'w.w.w.w.w', '2022-07-10 06:53:10', NULL, 36, 1),
(9, 'pppppppp', 'pppppppppppppppppp', '2022-07-10 08:13:38', NULL, 36, 1),
(11, 'test', 'test', '2022-07-22 13:48:16', NULL, 36, 1),
(12, 'test', 'test', '2022-07-22 14:40:39', NULL, 36, 1),
(13, 'test', 'test', '2022-07-22 15:08:39', NULL, 36, 1),
(14, 'wwwwwwwww', 'wwwwwwwwwwwwwww', '2022-07-24 15:25:37', NULL, 36, 1),
(15, 'wwwwwwwww', 'wwwwwwwwwwwwwww', '2022-07-24 15:26:11', NULL, 36, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `roles` json NOT NULL,
  `is_accepted_terms` tinyint(1) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `firstname`, `login`, `password`, `mail`, `registrated_at`, `roles`, `is_accepted_terms`, `token`, `is_valid`, `avatar`) VALUES
(32, 'test', 'testt', 'test', 'Valentin4815', 'dtfzgbfd.fdgzfghf@mytrashmailer.com', '2022-06-09 09:31:01', '[\"ROLE_USER\"]', 0, '6992b98f49f29700fa634c0581ecb4a710b63d7461958d3d4acf8c85b23dd6ce', 1, NULL),
(33, 'Castex', 'Jean', 'testt', '$2y$13$stpWajyGITi7isFOvSV/MOu0x0bb52aZ1HJcv3KP2tK2id45VD0W6', 'szdfgh.zqsdfegrh@zqsfedgr.fr', '2022-06-09 09:33:38', '[\"ROLE_USER\"]', 0, '90ba3c24cadd98655ecd2600315c87ce5ca6105b1ed3a8819330cc5170bfa320', 1, 'avatar-2'),
(34, NULL, NULL, 'rzwedtgfxhgj', '$2y$13$.g.3WqIcOq3o/8tXzI/QgeDv0Kb.A75bHMemUZ/T.pzFBzeFnuPCW', 'valentin.sefhfhfh@mytrashmailer.com', '2022-06-12 16:21:33', '[\"ROLE_USER\"]', 0, 'f95a83c10bed6ba2914677950e67504738c5035fca7b33f31ba3d6af9127b96c', 0, NULL),
(35, NULL, NULL, 'rzwedtgfxhgjdfgg', '$2y$13$aVH5K.P304fVjmt8IDRIYO..sjmyyKWKqQMTU9IAO5BdYR1WmrZMC', 'valedfgntin.sefhdfgfhfh@mytrashmailer.com', '2022-06-12 16:34:41', '[\"ROLE_USER\"]', 0, NULL, 1, NULL),
(36, 'testttttt', 'test2', 'Admin', '$2y$13$stpWajyGITi7isFOvSV/MOu0x0bb52aZ1HJcv3KP2tK2id45VD0W6', 'admin.admin@mytrashmailer.com', '2022-06-17 14:16:18', '[\"ROLE_ADMIN\"]', 0, NULL, 1, 'avatar-3');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trick_id_id` int NOT NULL,
  `videoname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2CB46B9EE8` (`trick_id_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FA674A03E` FOREIGN KEY (`tricks_id_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E40C90B5F` FOREIGN KEY (`grouptrick_id`) REFERENCES `group` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB46B9EE8` FOREIGN KEY (`trick_id_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
