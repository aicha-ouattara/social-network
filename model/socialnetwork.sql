-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 25 mai 2021 à 10:14
-- Version du serveur :  8.0.21
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `socialnetwork`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  `id_comment` int DEFAULT NULL,
  `content` varchar(750) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `comments_ibfk_1` (`id_post`),
  KEY `comments_ibfk_2` (`id_user`),
  KEY `id_comment` (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comment_reactions`
--

DROP TABLE IF EXISTS `comment_reactions`;
CREATE TABLE IF NOT EXISTS `comment_reactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_comment` int NOT NULL,
  `id_user` int NOT NULL,
  `choice` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_comment` (`id_comment`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE IF NOT EXISTS `follows` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_followed` int NOT NULL,
  `id_following` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_followed` (`id_following`),
  KEY `id_follower` (`id_followed`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `follows`
--

INSERT INTO `follows` (`id`, `id_followed`, `id_following`, `date`) VALUES
(63, 31, 36, '2021-05-20'),
(68, 36, 37, '2021-05-20'),
(70, 31, 37, '2021-05-20');

-- --------------------------------------------------------

--
-- Structure de la table `hashtags`
--

DROP TABLE IF EXISTS `hashtags`;
CREATE TABLE IF NOT EXISTS `hashtags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `item1` int NOT NULL,
  `item2` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_ibfk_1` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inventory`
--

INSERT INTO `inventory` (`id`, `id_user`, `item1`, `item2`) VALUES
(6, 30, 0, 0),
(7, 31, 0, 0),
(8, 32, 0, 0),
(11, 35, 0, 0),
(12, 36, 0, 0),
(13, 37, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ips`
--

DROP TABLE IF EXISTS `ips`;
CREATE TABLE IF NOT EXISTS `ips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_client` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ips`
--

INSERT INTO `ips` (`id`, `id_user`, `address`, `active`) VALUES
(11, 30, '127.0.0.1', 1),
(12, 31, '127.0.0.1', 1),
(13, 32, '127.0.0.1', 1),
(16, 35, '127.0.0.1', 1),
(17, 36, '127.0.0.1', 1),
(18, 37, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ivs`
--

DROP TABLE IF EXISTS `ivs`;
CREATE TABLE IF NOT EXISTS `ivs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_mail` int NOT NULL,
  `bytes` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mail` (`id_mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `keychain`
--

DROP TABLE IF EXISTS `keychain`;
CREATE TABLE IF NOT EXISTS `keychain` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_mail` int NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mail` (`id_mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mails`
--

DROP TABLE IF EXISTS `mails`;
CREATE TABLE IF NOT EXISTS `mails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mails`
--

INSERT INTO `mails` (`id`, `address`, `active`) VALUES
(13, 'five@laplateforme.io', 1),
(14, 'sub@laplateforme.io', 1),
(15, 'seven@laplateforme.io', 1),
(21, 'height@laplateforme.io', 1),
(34, 'nine@laplateforme.io', 1),
(35, 'newuser@laplateforme.io', 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conversation` int NOT NULL,
  `id_sender` int NOT NULL,
  `id_receiver` int NOT NULL,
  `content` varchar(2250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `emoji` int NOT NULL,
  `status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_ibfk_1` (`id_sender`),
  KEY `id_userB` (`id_receiver`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `conversation`, `id_sender`, `id_receiver`, `content`, `date`, `emoji`, `status`) VALUES
(1, 1, 36, 1, 'Salut mon pote', '2021-05-03 00:00:00', 0, 'Vu'),
(2, 2, 36, 35, 'Salut huit', '2021-05-04 00:00:00', 0, 'Vu'),
(4, 3, 31, 36, 'Salut c\'est sub1', '2021-05-07 10:21:13', 0, 'Envoyé'),
(5, 4, 4, 36, 'Ceci est le message le plus ancien', '2021-05-01 05:21:58', 0, 'Vu'),
(6, 3, 31, 36, 'Message à grouper', '2021-05-14 10:22:53', 0, 'Envoyé'),
(7, 4, 4, 36, 'Salut c\'est encore 4, group me', '2021-05-14 18:23:27', 0, 'Envoyé'),
(8, 2, 35, 36, 'salut nine ', '2021-05-03 23:19:25', 4, 'Vu'),
(11, 2, 36, 35, 'tu m\'en diras tant', '2021-05-13 20:20:36', 0, 'Vu'),
(12, 1, 36, 1, 'test message mort', '2021-05-20 08:46:56', 0, 'Vu'),
(13, 1, 36, 1, 'Test message mort x 2', '2021-05-20 08:47:22', 0, 'Vu'),
(14, 1, 1, 36, 'wtf ?', '2021-05-20 08:48:37', 0, 'Vu');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_replies` int NOT NULL,
  `id_category` int NOT NULL,
  `path` varchar(750) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `choice1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `count1` int NOT NULL DEFAULT '0',
  `choice2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `count2` int NOT NULL DEFAULT '0',
  `views` int NOT NULL,
  `expdate` date DEFAULT NULL,
  `highlighted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post_hashtags`
--

DROP TABLE IF EXISTS `post_hashtags`;
CREATE TABLE IF NOT EXISTS `post_hashtags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_post` int NOT NULL,
  `id_hashtag` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_hashtag` (`id_hashtag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post_likes`
--

DROP TABLE IF EXISTS `post_likes`;
CREATE TABLE IF NOT EXISTS `post_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post_reactions`
--

DROP TABLE IF EXISTS `post_reactions`;
CREATE TABLE IF NOT EXISTS `post_reactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  `choice` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recovery`
--

DROP TABLE IF EXISTS `recovery`;
CREATE TABLE IF NOT EXISTS `recovery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `question1` varchar(1250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `answer1` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `question2` varchar(1250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `answer2` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_mail` int DEFAULT NULL,
  `id_informations` int DEFAULT NULL,
  `id_settings` int DEFAULT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `authtoken` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `blacklist` varchar(1250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_ibfk_1` (`id_mail`),
  KEY `users_ibfk_3` (`id_informations`),
  KEY `id_settings` (`id_settings`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `id_mail`, `id_informations`, `id_settings`, `login`, `password`, `authtoken`, `blacklist`, `active`) VALUES
(30, 13, NULL, 44, 'five', '$2y$10$B4N89DKLXSUgnlYt7nwNjuLxwFpL6j3LvhGc/dvnb6AOYma1GwWZG', '29892d1a0b7577b5cbd3085a30520838', '', 1),
(31, 14, 1, NULL, 'sub1', '', '', '', 1),
(32, 15, 2, NULL, 'seven', '$2y$10$g0RmKJ112Py1MHfL7betgO.giYnfdzGG.QnR.ilhBKQJOzn9pMFlC', '', '', 1),
(35, 21, 6, NULL, 'height', '', '', '', 0),
(36, 34, 19, 45, 'nine', '$2y$10$dR.rU91q03fi3DMCAUA3BefZEmUIvSCGPKMuC0qQ75hnmaYnoGZeW', '70ff241da052be7f6d53a91c60f11ae5', '', 1),
(37, 35, 20, 46, 'newuser', '$2y$10$rXtwYQTn3Pv4VM9t.1PmSOVy0Gj3c0KmoER5O1qvZgzmMFlF/7byq', '247ca9e0ae65fc4a16768053e87e8456', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_hashtags`
--

DROP TABLE IF EXISTS `user_hashtags`;
CREATE TABLE IF NOT EXISTS `user_hashtags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_hashtag` int NOT NULL,
  `counter` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_hashtag` (`id_hashtag`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_informations`
--

DROP TABLE IF EXISTS `user_informations`;
CREATE TABLE IF NOT EXISTS `user_informations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bio` varchar(1250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `registerdate` date NOT NULL,
  `phone` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_informations`
--

INSERT INTO `user_informations` (`id`, `bio`, `country`, `city`, `lastname`, `firstname`, `birthdate`, `registerdate`, `phone`) VALUES
(1, NULL, NULL, '', NULL, NULL, NULL, '2021-05-13', NULL),
(2, NULL, NULL, '', NULL, NULL, NULL, '2021-05-13', NULL),
(6, NULL, NULL, '', NULL, NULL, NULL, '2021-05-13', NULL),
(19, 'Ceci est ma bio test', 'Irlande', 'Toulon', 'Louis', 'Denis', '2021-02-23', '2021-05-13', '01-23-45-67-89'),
(20, 'Bonjour', 'France', NULL, NULL, NULL, NULL, '2021-05-20', NULL),
(21, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-20', NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-20', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `picture` varchar(1250) COLLATE utf8mb4_general_ci NOT NULL,
  `background` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_settings`
--

INSERT INTO `user_settings` (`id`, `picture`, `background`) VALUES
(40, '0', '0'),
(41, '0', '0'),
(42, '0', '0'),
(43, '0', '0'),
(44, 'storage/users/pictures/e52f315c0e8d212bb092412740265517.jpg', '0'),
(45, 'storage/user36/pictures/ef207a5bbe87f3b088f54fbcfc18d26d.jpg', 'storage/user36/backgrounds/7b4e1b97997b5411f959408718a3b123.jpg'),
(46, '0', 'storage/user37/backgrounds/7b69097d10f8adbc4605f57e81000a7b.jpg'),
(47, '0', '0'),
(48, '0', '0');

-- --------------------------------------------------------

--
-- Structure de la table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE IF NOT EXISTS `wallets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `tokens` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wallets_ibfk_1` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wallets`
--

INSERT INTO `wallets` (`id`, `id_user`, `tokens`) VALUES
(6, 30, 500),
(7, 31, 500),
(8, 32, 500),
(11, 35, 500),
(12, 36, 500),
(13, 37, 500);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`id_comment`) REFERENCES `comments` (`id`);

--
-- Contraintes pour la table `comment_reactions`
--
ALTER TABLE `comment_reactions`
  ADD CONSTRAINT `comment_reactions_ibfk_1` FOREIGN KEY (`id_comment`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_reactions_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`id_following`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`id_followed`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `ips`
--
ALTER TABLE `ips`
  ADD CONSTRAINT `ips_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `ivs`
--
ALTER TABLE `ivs`
  ADD CONSTRAINT `ivs_ibfk_1` FOREIGN KEY (`id_mail`) REFERENCES `mails` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `keychain`
--
ALTER TABLE `keychain`
  ADD CONSTRAINT `keychain_ibfk_1` FOREIGN KEY (`id_mail`) REFERENCES `mails` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `post_hashtags`
--
ALTER TABLE `post_hashtags`
  ADD CONSTRAINT `post_hashtags_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_hashtags_ibfk_2` FOREIGN KEY (`id_hashtag`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post_reactions`
--
ALTER TABLE `post_reactions`
  ADD CONSTRAINT `post_reactions_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_reactions_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `recovery`
--
ALTER TABLE `recovery`
  ADD CONSTRAINT `recovery_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`id_informations`) REFERENCES `user_informations` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_4` FOREIGN KEY (`id_settings`) REFERENCES `user_settings` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_hashtags`
--
ALTER TABLE `user_hashtags`
  ADD CONSTRAINT `user_hashtags_ibfk_1` FOREIGN KEY (`id_hashtag`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_hashtags_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
