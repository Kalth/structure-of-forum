-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 13 Octobre 2015 à 18:50
-- Version du serveur: 5.5.44-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `descri` varchar(256) NOT NULL,
  `private` int(1) NOT NULL DEFAULT '0',
  `last_msg_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `descri`, `private`, `last_msg_id`) VALUES
(1, 'CatÃ©gorie', 'PremiÃ¨re catÃ©gorie de teste', 0, 10),
(2, 'CatÃ©gorie 2', 'deuxieme catÃ©gorie de teste', 0, 2),
(3, 'CatÃ©gorie privÃ©', 'On ne la vois que si on est avec des droits supérieur!', 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `msg`
--

CREATE TABLE IF NOT EXISTS `msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_crea` datetime NOT NULL,
  `content` blob NOT NULL,
  `date_last_change` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `msg`
--

INSERT INTO `msg` (`id`, `topic_id`, `user_id`, `date_crea`, `content`, `date_last_change`) VALUES
(1, 1, 2, '2015-09-03 00:00:00', 0x566f696c61206c65203165722073756a6574, NULL),
(2, 2, 3, '2015-09-03 00:00:00', 0x766f696c61206c65206465757869656d652074657374, NULL),
(3, 3, 3, '2015-09-03 00:00:00', 0x6176656320736f6e206d657373616765, NULL),
(4, 1, 3, '2015-09-03 00:00:00', 0x6574207361207265706f6e736520, NULL),
(5, 1, 3, '2015-09-03 00:00:00', 0x73612072656c6f6164207061733f, NULL),
(6, 1, 3, '2015-09-03 00:00:00', 0x6c612073612076612072656c6f6164, NULL),
(7, 4, 1, '2015-09-03 00:00:00', 0x61207175656c6c6520706f696e743f, NULL),
(8, 1, 2, '2015-09-06 00:00:00', 0x7465737465, NULL),
(9, 3, 2, '2015-09-06 00:00:00', 0x7465737465, NULL),
(10, 3, 1, '2015-09-06 20:21:03', 0x610a, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `categori_id` int(11) NOT NULL,
  `open` int(1) NOT NULL DEFAULT '1',
  `on_top` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `topic`
--

INSERT INTO `topic` (`id`, `name`, `user_id`, `categori_id`, `open`, `on_top`) VALUES
(1, 'Mon 1er topic', 2, 1, 1, 0),
(2, 'Le 1er sujet de b', 3, 2, 1, 0),
(3, 'deuxieme topic de b', 3, 1, 1, 0),
(4, '1er sujet privÃ©', 1, 3, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `topic_users`
--

CREATE TABLE IF NOT EXISTS `topic_users` (
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `topic_users`
--

INSERT INTO `topic_users` (`topic_id`, `user_id`, `msg_id`) VALUES
(1, 2, 8),
(2, 3, 2),
(1, 3, 8),
(3, 3, 10),
(1, 1, 8),
(3, 1, 10),
(2, 1, 2),
(4, 1, 7),
(3, 2, 9);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `mail` varchar(254) DEFAULT NULL,
  `pseudo` varchar(50) NOT NULL,
  `last_co` date NOT NULL,
  `right` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `identifiant`, `password`, `mail`, `pseudo`, `last_co`, `right`) VALUES
(1, 'alex07', '81e9022d365cd525e7eef02d9e2983b7702d9fcaa29f29208c71368e456ded219dbb0c477506cd80', 'dede07fr@gmail.com', 'Kalth', '2015-09-03', 3),
(2, 'a', 'ce78850638f92658a5a585097579926dda667a5716562cfcf6fbe77f63542f99b04705d6970dff5d', 'a', 'a', '2015-09-03', 1),
(3, 'b', 'a45bda6d6dd0cfde8c87a1b3231f6947e6725a147b703b9ab9a95c724bcbfcca6bd2c030e5639ff6', 'b', 'b', '2015-09-03', 1),
(4, 'Ã©', '171ab6c2955ab9f18cdf9c4ac219fa20798da3a02e4451508939258738453df0200b54927fa33330', 'Ã©', 'Ã©', '2015-09-06', 1),
(5, 'Ã¨', '5d1979b1f703a6e6035ec6b4c0605462363906a48e25ba8cfafa5cb17d500b57545f7c9da1d1690d', 'Ã¨', 'Ã¨', '2015-09-06', 1),
(6, 'teste4', 'bfb347b6bfbb2a7cb5a7bab4724d5ee63387b7ff8aeeb38cb6abd3246167f40a5016d63743ceb352', NULL, '4', '2015-09-12', 1),
(7, '5', '2f5068fdb762ac8722adffd9c81846b4676b25ad445a46ca642ea4d1f5ec9914cb094496b1bf896d', NULL, '5', '2015-09-12', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
