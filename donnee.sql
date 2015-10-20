-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Version du serveur: 5.1.36
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `category`
--
CREATE DATABASE IF NOT EXISTS `category` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `category`;

-- --------------------------------------------------------

--
-- Structure de la table `example`
--

CREATE TABLE IF NOT EXISTS `example` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `level` mediumint(8) NOT NULL DEFAULT '0',
  `left_border` mediumint(8) NOT NULL,
  `right_border` mediumint(8) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `left_border` (`left_border`),
  KEY `right_border` (`right_border`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Contenu de la table `example`
--

INSERT INTO `example` (`id`, `level`, `left_border`, `right_border`, `name`) VALUES
(36, 1, 23, 32, 'Nature'),
(35, 2, 50, 51, 'Hybride'),
(34, 2, 42, 43, 'Massue'),
(33, 2, 44, 45, 'Epée'),
(32, 2, 54, 55, 'Tête'),
(30, 1, 41, 46, 'Armes'),
(31, 2, 56, 61, 'Corps'),
(28, 1, 47, 48, 'Outils'),
(27, 1, 49, 52, 'Creature'),
(26, 1, 53, 62, 'Anatomie'),
(25, 0, 66, 67, 'Scripts'),
(24, 0, 64, 65, 'Scènes 3D'),
(23, 0, 40, 63, 'Objets 3D'),
(22, 0, 34, 39, 'Shaders'),
(21, 0, 2, 33, 'Textures'),
(37, 1, 15, 22, 'Fabriqué'),
(38, 1, 3, 14, 'Organique'),
(40, 2, 30, 31, 'Ciel'),
(41, 2, 24, 29, 'Bois'),
(42, 3, 27, 28, 'Nervure'),
(43, 3, 25, 26, 'Mousse'),
(44, 2, 20, 21, 'Metal'),
(45, 2, 16, 19, 'Céramique'),
(46, 3, 17, 18, 'Cassé'),
(48, 2, 6, 13, 'Humain'),
(49, 2, 4, 5, 'Créature'),
(50, 3, 11, 12, 'Peau'),
(51, 3, 9, 10, 'Cheveux'),
(52, 3, 7, 8, 'Sang'),
(53, 1, 37, 38, 'XSI'),
(54, 1, 35, 36, 'Maya'),
(55, 3, 59, 60, 'Buste'),
(58, 3, 57, 58, 'Jambe');
