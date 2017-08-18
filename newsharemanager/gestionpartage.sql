-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 18 Août 2017 à 13:21
-- Version du serveur :  5.6.17-log
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gestionpartage`
--

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE IF NOT EXISTS `demandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomServ` varchar(30) NOT NULL,
  `nomDisque` varchar(30) NOT NULL,
  `nomPartage` varchar(30) NOT NULL,
  `etat` varchar(30) NOT NULL DEFAULT 'N',
  `quota` float NOT NULL,
  `demandeur` varchar(30) NOT NULL,
  `dateDemande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(30) NOT NULL DEFAULT 'C',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `demandes`
--

INSERT INTO `demandes` (`id`, `nomServ`, `nomDisque`, `nomPartage`, `etat`, `quota`, `demandeur`, `dateDemande`, `type`) VALUES
(2, '', '', 'BiatTunis', 'R', 5, 'matricule1', '2017-07-31 09:11:37', 'C'),
(3, 'Wserver', 'C:', 'BiatGabs', 'E', 2, 'matricule19', '2017-07-31 09:13:21', 'C');

-- --------------------------------------------------------

--
-- Structure de la table `demandespermission`
--

CREATE TABLE IF NOT EXISTS `demandespermission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_demande` int(11) NOT NULL,
  `utilisateur` varchar(30) NOT NULL,
  `permission` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_demandeper` (`id_demande`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `demandespermission`
--

INSERT INTO `demandespermission` (`id`, `id_demande`, `utilisateur`, `permission`) VALUES
(3, 2, 'matricule1', 'FULL'),
(7, 3, 'matricule2', 'FULL'),
(8, 3, 'matricule19', 'READ'),
(9, 3, 'matricule1', 'FULL');

-- --------------------------------------------------------

--
-- Structure de la table `disques`
--

CREATE TABLE IF NOT EXISTS `disques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_serveur` int(11) NOT NULL,
  `nomdisque` varchar(10) NOT NULL,
  `espacelibre` float NOT NULL,
  `espacetotal` float NOT NULL,
  `espaceReserve` float NOT NULL,
  `espaceAllouable` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `csd` (`id_serveur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `disques`
--

INSERT INTO `disques` (`id`, `id_serveur`, `nomdisque`, `espacelibre`, `espacetotal`, `espaceReserve`, `espaceAllouable`) VALUES
(4, 1, 'G:', 5, 5, 0, 5),
(3, 1, 'C:', 18, 20, 0, 18);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `destinataire` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(30) NOT NULL,
  `etat` varchar(30) NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`id`),
  KEY `csn` (`destinataire`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Contenu de la table `notification`
--

INSERT INTO `notification` (`id`, `destinataire`, `message`, `date_creation`, `type`, `etat`) VALUES
(1, 'matricule3', 'demande creation :: matricule1', '2017-07-31 08:10:57', 'INFO', 'read'),
(2, 'Administrateur', 'demande creation :: matricule1', '2017-07-31 08:10:57', 'INFO', 'unread'),
(3, 'matricule3', 'demande creation :: matricule1', '2017-07-31 08:11:37', 'INFO', 'read'),
(4, 'Administrateur', 'demande creation :: matricule1', '2017-07-31 08:11:37', 'INFO', 'unread'),
(5, 'matricule3', 'demande creation :: matricule19', '2017-07-31 08:13:21', 'INFO', 'read'),
(6, 'Administrateur', 'demande creation :: matricule19', '2017-07-31 08:13:21', 'INFO', 'unread'),
(7, 'matricule1', 'Création approuvée ::Samir', '2017-07-31 08:32:12', 'SUCCESS', 'unread'),
(8, 'matricule1', 'demande refusé ::BiatTunis', '2017-07-31 08:32:55', 'error', 'unread'),
(9, 'matricule19', 'Création approuvée ::BiatGabs', '2017-07-31 08:39:44', 'SUCCESS', 'unread'),
(10, 'matricule3', 'TASK N°1 : Dossier partagé @ l''adresse \\\\Wserver\\Samir10', '2017-07-31 08:44:11', 'Success', 'read'),
(11, 'Administrateur', 'TASK N°1 : Dossier partagé @ l''adresse \\\\Wserver\\Samir10', '2017-07-31 08:44:11', 'Success', 'unread'),
(12, 'matricule3', 'TASK N°2 : Erreur de connection WMI', '2017-07-31 08:44:11', 'ERROR', 'read'),
(13, 'Administrateur', 'TASK N°2 : Erreur de connection WMI', '2017-07-31 08:44:11', 'ERROR', 'unread'),
(14, 'matricule3', 'TASK N°3 : Erreur de connection WMI', '2017-07-31 08:44:11', 'ERROR', 'read'),
(15, 'Administrateur', 'TASK N°3 : Erreur de connection WMI', '2017-07-31 08:44:11', 'ERROR', 'unread'),
(16, 'matricule3', 'TASK N°3 : Dossier partagé @ l''adresse \\\\Wserver\\partageAdmin', '2017-07-31 08:46:11', 'Success', 'read'),
(17, 'Administrateur', 'TASK N°3 : Dossier partagé @ l''adresse \\\\Wserver\\partageAdmin', '2017-07-31 08:46:11', 'Success', 'unread'),
(18, 'matricule3', 'TASK N°2 : Dossier deja existant', '2017-07-31 08:48:45', 'ERROR', 'read'),
(19, 'Administrateur', 'TASK N°2 : Dossier deja existant', '2017-07-31 08:48:45', 'ERROR', 'unread'),
(20, 'matricule3', 'TASK N°4 : partage Modifié @ l''adresse \\\\Wserver\\biatgabstest', '2017-07-31 09:33:05', 'Success', 'read'),
(21, 'Administrateur', 'TASK N°4 : partage Modifié @ l''adresse \\\\Wserver\\biatgabstest', '2017-07-31 09:33:05', 'Success', 'unread'),
(22, 'matricule3', 'TASK N°4 : partage Modifié @ l''adresse \\\\Wserver\\biatgabstest', '2017-07-31 09:35:19', 'Success', 'read'),
(23, 'Administrateur', 'TASK N°4 : partage Modifié @ l''adresse \\\\Wserver\\biatgabstest', '2017-07-31 09:35:19', 'Success', 'unread'),
(24, 'matricule3', 'TASK N°5 : partage Modifié @ l''adresse \\\\Wserver\\behy', '2017-07-31 11:39:30', 'Success', 'read'),
(25, 'Administrateur', 'TASK N°5 : partage Modifié @ l''adresse \\\\Wserver\\behy', '2017-07-31 11:39:30', 'Success', 'unread'),
(26, 'matricule3', 'TASK N°5 : partage Modifié @ l''adresse \\\\Wserver\\behy', '2017-07-31 11:43:48', 'Success', 'read'),
(27, 'Administrateur', 'TASK N°5 : partage Modifié @ l''adresse \\\\Wserver\\behy', '2017-07-31 11:43:48', 'Success', 'unread'),
(28, 'matricule3', 'TASK N°5 : Erreur de Modification du partage', '2017-07-31 11:45:45', 'ERROR', 'read'),
(29, 'Administrateur', 'TASK N°5 : Erreur de Modification du partage', '2017-07-31 11:45:45', 'ERROR', 'unread'),
(30, 'matricule3', 'TASK N°6 : Erreur de Modification du partage', '2017-07-31 11:51:08', 'ERROR', 'read'),
(31, 'Administrateur', 'TASK N°6 : Erreur de Modification du partage', '2017-07-31 11:51:08', 'ERROR', 'unread'),
(32, 'matricule3', 'TASK N°7 : partage Modifié @ l''adresse \\\\Wserver\\behy', '2017-07-31 11:54:23', 'Success', 'read'),
(33, 'Administrateur', 'TASK N°7 : partage Modifié @ l''adresse \\\\Wserver\\behy', '2017-07-31 11:54:23', 'Success', 'unread'),
(34, 'matricule3', 'TASK N°8 : Dossier partagé @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 12:06:09', 'Success', 'read'),
(35, 'Administrateur', 'TASK N°8 : Dossier partagé @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 12:06:09', 'Success', 'unread'),
(36, 'matricule3', 'TASK N°9 : Erreur de Modification du partage', '2017-07-31 12:16:18', 'ERROR', 'read'),
(37, 'Administrateur', 'TASK N°9 : Erreur de Modification du partage', '2017-07-31 12:16:18', 'ERROR', 'unread'),
(38, 'matricule3', 'TASK N°10 : Erreur de Modification du partage', '2017-07-31 12:18:59', 'ERROR', 'read'),
(39, 'Administrateur', 'TASK N°10 : Erreur de Modification du partage', '2017-07-31 12:18:59', 'ERROR', 'unread'),
(40, 'matricule3', 'TASK N°11 : Erreur de connection WMI', '2017-07-31 12:19:00', 'ERROR', 'read'),
(41, 'Administrateur', 'TASK N°11 : Erreur de connection WMI', '2017-07-31 12:19:00', 'ERROR', 'unread'),
(42, 'matricule3', 'TASK N°12 : partage Modifié @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 12:19:47', 'Success', 'read'),
(43, 'Administrateur', 'TASK N°12 : partage Modifié @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 12:19:47', 'Success', 'unread'),
(44, 'matricule3', 'TASK N°13 : partage Modifié @ l''adresse \\\\Wserver\\myshare', '2017-07-31 12:22:11', 'Success', 'read'),
(45, 'Administrateur', 'TASK N°13 : partage Modifié @ l''adresse \\\\Wserver\\myshare', '2017-07-31 12:22:11', 'Success', 'unread'),
(46, 'matricule3', 'TASK N°14 : Erreur de Modification du partage', '2017-07-31 12:24:41', 'ERROR', 'read'),
(47, 'Administrateur', 'TASK N°14 : Erreur de Modification du partage', '2017-07-31 12:24:41', 'ERROR', 'unread'),
(48, 'matricule3', 'TASK N°15 : partage Modifié @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 12:28:20', 'Success', 'read'),
(49, 'Administrateur', 'TASK N°15 : partage Modifié @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 12:28:20', 'Success', 'unread'),
(50, 'matricule3', 'TASK N°16 : partage Modifié @ l''adresse \\\\Wserver\\Samir', '2017-07-31 12:29:06', 'Success', 'read'),
(51, 'Administrateur', 'TASK N°16 : partage Modifié @ l''adresse \\\\Wserver\\Samir', '2017-07-31 12:29:06', 'Success', 'unread'),
(52, 'matricule3', 'TASK N°17 : partage Modifié @ l''adresse \\\\Wserver\\BiatSfax', '2017-07-31 12:29:40', 'Success', 'read'),
(53, 'Administrateur', 'TASK N°17 : partage Modifié @ l''adresse \\\\Wserver\\BiatSfax', '2017-07-31 12:29:40', 'Success', 'unread'),
(54, 'matricule3', 'TASK N°18 : Erreur de Modification du partage', '2017-07-31 12:32:02', 'ERROR', 'read'),
(55, 'Administrateur', 'TASK N°18 : Erreur de Modification du partage', '2017-07-31 12:32:02', 'ERROR', 'unread'),
(56, 'matricule3', 'TASK N°19 : partage Modifié @ l''adresse \\\\Wserver\\partage1', '2017-07-31 12:33:41', 'Success', 'read'),
(57, 'Administrateur', 'TASK N°19 : partage Modifié @ l''adresse \\\\Wserver\\partage1', '2017-07-31 12:33:41', 'Success', 'unread'),
(58, 'matricule3', 'TASK N°20 : partage Supprimé du réseau', '2017-07-31 12:34:25', 'Success', 'read'),
(59, 'Administrateur', 'TASK N°20 : partage Supprimé du réseau', '2017-07-31 12:34:25', 'Success', 'unread'),
(60, 'matricule3', 'TASK N°21 : partage Supprimé du réseau', '2017-07-31 12:35:34', 'Success', 'read'),
(61, 'Administrateur', 'TASK N°21 : partage Supprimé du réseau', '2017-07-31 12:35:34', 'Success', 'unread'),
(62, 'matricule3', 'TASK N°22 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'read'),
(63, 'Administrateur', 'TASK N°22 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'unread'),
(64, 'matricule3', 'TASK N°23 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'read'),
(65, 'Administrateur', 'TASK N°23 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'unread'),
(66, 'matricule3', 'TASK N°24 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'read'),
(67, 'Administrateur', 'TASK N°24 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'unread'),
(68, 'matricule3', 'TASK N°25 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'read'),
(69, 'Administrateur', 'TASK N°25 : Erreur de connection WMI', '2017-07-31 12:35:35', 'ERROR', 'unread'),
(70, 'matricule3', 'TASK N°26 : Erreur de connection WMI', '2017-07-31 12:35:36', 'ERROR', 'read'),
(71, 'Administrateur', 'TASK N°26 : Erreur de connection WMI', '2017-07-31 12:35:36', 'ERROR', 'unread'),
(72, 'matricule3', 'TASK N°2 : Dossier deja existant', '2017-07-31 12:36:53', 'ERROR', 'unread'),
(73, 'Administrateur', 'TASK N°2 : Dossier deja existant', '2017-07-31 12:36:53', 'ERROR', 'unread'),
(74, 'matricule3', 'TASK N°30 : partage Supprimé du réseau', '2017-07-31 12:41:24', 'Success', 'unread'),
(75, 'Administrateur', 'TASK N°30 : partage Supprimé du réseau', '2017-07-31 12:41:24', 'Success', 'unread'),
(76, 'matricule3', 'TASK N°31 : partage Supprimé du réseau', '2017-07-31 12:41:45', 'Success', 'unread'),
(77, 'Administrateur', 'TASK N°31 : partage Supprimé du réseau', '2017-07-31 12:41:45', 'Success', 'unread'),
(78, 'matricule3', 'TASK N°32 : Erreur de connection WMI', '2017-07-31 12:41:45', 'ERROR', 'read'),
(79, 'Administrateur', 'TASK N°32 : Erreur de connection WMI', '2017-07-31 12:41:45', 'ERROR', 'unread'),
(80, 'matricule3', 'TASK N°33 : partage Supprimé du réseau', '2017-07-31 12:42:01', 'Success', 'unread'),
(81, 'Administrateur', 'TASK N°33 : partage Supprimé du réseau', '2017-07-31 12:42:01', 'Success', 'unread');

-- --------------------------------------------------------

--
-- Structure de la table `partagepermission`
--

CREATE TABLE IF NOT EXISTS `partagepermission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_partage` int(11) NOT NULL,
  `utilisateur` varchar(30) NOT NULL,
  `permission` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cspp` (`id_partage`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `partagepermission`
--

INSERT INTO `partagepermission` (`id`, `id_partage`, `utilisateur`, `permission`) VALUES
(19, 12, 'matricule1', 'READ'),
(20, 12, 'Tout le monde', 'READ');

-- --------------------------------------------------------

--
-- Structure de la table `partages`
--

CREATE TABLE IF NOT EXISTS `partages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_demande` int(11) NOT NULL DEFAULT '0',
  `nomPartage` varchar(30) NOT NULL,
  `quota` float NOT NULL DEFAULT '0',
  `adressReseau` varchar(45) NOT NULL,
  `cheminLocal` varchar(100) NOT NULL,
  `tailleActuel` float NOT NULL DEFAULT '0',
  `nomServ` varchar(30) NOT NULL,
  `demandeur` varchar(30) NOT NULL DEFAULT '',
  `disque` varchar(10) NOT NULL,
  `etat` varchar(30) NOT NULL DEFAULT 'Actif',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `partages`
--

INSERT INTO `partages` (`id`, `id_demande`, `nomPartage`, `quota`, `adressReseau`, `cheminLocal`, `tailleActuel`, `nomServ`, `demandeur`, `disque`, `etat`) VALUES
(12, 0, 'Samir', 0, '\\\\Wserver\\Samir', 'C:\\Samir', 0, 'Wserver', '', 'C:', 'Actif');

-- --------------------------------------------------------

--
-- Structure de la table `personnels`
--

CREATE TABLE IF NOT EXISTS `personnels` (
  `matricule` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `droit` varchar(30) NOT NULL,
  PRIMARY KEY (`matricule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personnels`
--

INSERT INTO `personnels` (`matricule`, `nom`, `prenom`, `droit`) VALUES
('matricule1', 'kallel', 'oussema', 'Utilisateur'),
('matricule2', 'Moalla', 'khaled', 'Technicien'),
('matricule3', 'Bahi', 'Mohamed', 'Admin'),
('matricule4', 'ben garbi', 'Samir', 'Utilisateur'),
('Administrateur', 'Moalla', 'khaled', 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `serveurs`
--

CREATE TABLE IF NOT EXISTS `serveurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomServ` varchar(30) NOT NULL,
  `nomAdmin` varchar(30) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `serveurs`
--

INSERT INTO `serveurs` (`id`, `nomServ`, `nomAdmin`, `pwd`) VALUES
(1, 'Wserver', 'Wserver\\Administrateur', 'root');

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

CREATE TABLE IF NOT EXISTS `taches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_demande` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `etat` varchar(30) NOT NULL DEFAULT 'A',
  `res_exec` varchar(50) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cst` (`id_demande`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `taches`
--

INSERT INTO `taches` (`id`, `id_demande`, `type`, `etat`, `res_exec`, `date_creation`) VALUES
(1, 1, 'C', 'T', 'Dossier partagé @ l''adresse \\\\Wserver\\Samir10', '2017-07-31 09:44:11'),
(2, 3, 'C', 'E', 'Dossier deja existant', '2017-07-31 13:36:53'),
(3, 4, 'C', 'T', 'Dossier partagé @ l''adresse \\\\Wserver\\partageAdmin', '2017-07-31 09:46:11'),
(4, 5, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\biatgabstest', '2017-07-31 10:35:19'),
(5, 6, 'M', 'P', '', '2017-07-31 12:46:19'),
(6, 7, 'M', 'P', '', '2017-07-31 13:36:46'),
(7, 8, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\behy', '2017-07-31 12:54:23'),
(8, 9, 'C', 'T', 'Dossier partagé @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 13:06:09'),
(9, 4, 'M', 'P', '', '2017-07-31 13:36:46'),
(10, 5, 'M', 'P', '', '2017-07-31 13:36:46'),
(11, 1, 'M', 'P', '', '2017-07-31 13:36:46'),
(30, 8, 'S', 'T', 'partage Supprimé du réseau', '2017-07-31 13:41:24'),
(12, 9, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 13:19:47'),
(13, 10, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\myshare', '2017-07-31 13:22:11'),
(14, 10, 'M', 'E', 'Erreur de Modification du partage', '2017-07-31 13:24:41'),
(15, 9, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\nouvpartage', '2017-07-31 13:28:20'),
(16, 11, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\Samir', '2017-07-31 13:29:06'),
(17, 12, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\BiatSfax', '2017-07-31 13:29:40'),
(18, 12, 'M', 'E', 'Erreur de Modification du partage', '2017-07-31 13:32:02'),
(19, 13, 'M', 'T', 'partage Modifié @ l''adresse \\\\Wserver\\partage1', '2017-07-31 13:33:41'),
(20, 13, 'S', 'T', 'partage Supprimé du réseau', '2017-07-31 13:34:25'),
(21, 1, 'S', 'T', 'partage Supprimé du réseau', '2017-07-31 13:35:34'),
(22, 11, 'S', 'E', 'Erreur de connection WMI', '2017-07-31 13:35:35'),
(23, 1, 'S', 'E', 'Erreur de connection WMI', '2017-07-31 13:35:35'),
(24, 8, 'S', 'E', 'Erreur de connection WMI', '2017-07-31 13:35:35'),
(25, 9, 'S', 'E', 'Erreur de connection WMI', '2017-07-31 13:35:35'),
(26, 1, 'S', 'E', 'Erreur de connection WMI', '2017-07-31 13:35:36'),
(27, 11, 'S', 'P', '', '2017-07-31 13:36:46'),
(28, 8, 'S', 'P', '', '2017-07-31 13:36:46'),
(29, 9, 'S', 'P', '', '2017-07-31 13:36:46'),
(31, 11, 'S', 'T', 'partage Supprimé du réseau', '2017-07-31 13:41:45'),
(32, 9, 'S', 'E', 'Erreur de connection WMI', '2017-07-31 13:41:45'),
(33, 9, 'S', 'T', 'partage Supprimé du réseau', '2017-07-31 13:42:01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
