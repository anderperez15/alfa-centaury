-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 06 Janvier 2016 à 02:52
-- Version du serveur: 5.5.46-0ubuntu0.14.04.2
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `helpdesk`
--

-- --------------------------------------------------------

--
-- Structure de la table `Demand`
--

CREATE TABLE IF NOT EXISTS `Demand` (
  `demandID` int(11) NOT NULL AUTO_INCREMENT,
  `demandType` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nbDaysTreatement` int(11) DEFAULT NULL,
  PRIMARY KEY (`demandID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `Demand`
--

INSERT INTO `Demand` (`demandID`, `demandType`, `nbDaysTreatement`) VALUES
(1, 'Question', 7),
(3, 'Information', 5),
(4, 'File', 6),
(5, 'Request--Petition', 7),
(6, 'Request--Claim', 9),
(7, 'Request--Complaint', 9);

-- --------------------------------------------------------

--
-- Structure de la table `Message`
--

CREATE TABLE IF NOT EXISTS `Message` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `createdOn` datetime DEFAULT NULL,
  `currentService` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isViewed` tinyint(1) DEFAULT NULL,
  `isTreated` tinyint(1) DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci,
  `contactType` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `demandType` int(11) DEFAULT NULL,
  `viewedBy` int(11) DEFAULT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `closedOn` datetime DEFAULT NULL,
  `responseText` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `closedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`messageID`),
  KEY `IDX_790009E3D3564642` (`createdBy`),
  KEY `IDX_790009E318B96200` (`demandType`),
  KEY `IDX_790009E3AA486CAC` (`viewedBy`),
  KEY `IDX_790009E39830F9E2` (`closedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Message`
--

INSERT INTO `Message` (`messageID`, `createdOn`, `currentService`, `isViewed`, `isTreated`, `subject`, `message`, `contactType`, `createdBy`, `demandType`, `viewedBy`, `status`, `code`, `closedOn`, `responseText`, `closedBy`) VALUES
(3, '2016-01-06 01:12:37', 'It', 1, 1, 'Net connection is so bad', 'Net connection is so bad , please do whatever you see oportune', 'mail', 12, 5, 8, 'closed', 'w0caVV5Kj3b9rza', '2016-01-06 02:20:30', 'Treated', 9),
(4, '2016-01-06 01:13:10', 'Reception', 0, 0, 'Is the issue closed?', 'please reply me briefly', 'mail', 12, 1, NULL, 'opened', 'qQglzm951eiMosu', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdOn` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DA1797792FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_2DA17977A0D96FBF` (`email_canonical`),
  KEY `IDX_2DA17977D3564642` (`createdBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `firstName`, `lastName`, `createdOn`, `createdBy`) VALUES
(2, 'admin', 'admin', 'admin@admin.com', 'admin@admin.com', 1, 'ewkl3e9zrzswc04go8g0coccgkgwcwc', '$2y$13$ewkl3e9zrzswc04go8g0ce0xivFIRVGTxwnIh5gDLztQ28FwNhW9y', '2016-01-06 01:00:47', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, 'Admin', 'Admin', '2015-12-31 01:15:58', NULL),
(6, 'gonzalez.murcia@hotmail.es', 'gonzalez.murcia@hotmail.es', 'gonzalez.murcia@hotmail.es', 'gonzalez.murcia@hotmail.es', 0, '2m0hy0yp5tesgk4k00ws8ok8skw8c8', '$2y$13$2m0hy0yp5tesgk4k00ws8eV1dSa.ZwU4EdfJkg2GDIXg0mB/M3a5q', '2016-01-04 02:20:30', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:24:"ROLE_INTERNAL_ACCOUNTING";}', 0, NULL, 'Gonzalez', 'Alvaro', '2016-01-04 02:20:06', 2),
(7, 'adriano.garcia@gmail.com', 'adriano.garcia@gmail.com', 'adriano.garcia@gmail.com', 'adriano.garcia@gmail.com', 1, 'a25pqrk9gwwgos8gs8c0okk84kow8w0', '$2y$13$a25pqrk9gwwgos8gs8c0oevnnMpTR1rsfxhkJT8VM8BNhR.YqQPZW', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:28:"ROLE_INTERNAL_ADMINISTRATION";}', 0, NULL, 'Adriano', 'Garcia', '2016-01-04 15:31:22', 2),
(8, 'leo.messi@gmail.ar', 'leo.messi@gmail.ar', 'leo.messi@gmail.ar', 'leo.messi@gmail.ar', 1, 'xk2svenqatc4osk448c4kw80g4soco', '$2y$13$xk2svenqatc4osk448c4kuRDRKFTggpUpjroFApdimgwKLQ/nkkLu', '2016-01-06 02:21:26', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:23:"ROLE_INTERNAL_RECEPTION";}', 0, NULL, 'Leo', 'Messi', '2016-01-04 15:32:15', 2),
(9, 'radamel.falcao@gmail.col', 'radamel.falcao@gmail.col', 'radamel.falcao@gmail.col', 'radamel.falcao@gmail.col', 1, 'a7dtxhu5kd4cskg44s8g88w840swc4o', '$2y$13$a7dtxhu5kd4cskg44s8g8uZL7k1rc06fPtOfaLtnqUmnArinU5e76', '2016-01-06 02:21:40', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_INTERNAL_IT";}', 0, NULL, 'Radamel', 'Falcao', '2016-01-04 15:33:04', 2),
(10, 'hugo.venezuela@hotmail.com', 'hugo.venezuela@hotmail.com', 'hugo.venezuela@hotmail.com', 'hugo.venezuela@hotmail.com', 1, 'eokxx3o7gxcs8ws40wkkoooscoo0ws4', '$2y$13$eokxx3o7gxcs8ws40wkkoernktZSSGxNwpKZ2droLi7xkk01DbPiy', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:28:"ROLE_INTERNAL_ADMINISTRATION";}', 0, NULL, 'Hugo', 'Chavez', '2016-01-04 15:33:49', 2),
(12, 'safwen', 'safwen', 'safoine.ben.salem@gmail.com', 'safoine.ben.salem@gmail.com', 1, '9xcg2z32b9s8ssw08k0ww0c4w8g4woo', '$2y$13$9xcg2z32b9s8ssw08k0wwu66YgFPsm23edjEmds4lXuQM8aG8NjWi', '2016-01-06 02:44:40', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:13:"ROLE_EXTERNAL";}', 0, NULL, 'Safwen', 'Ben Salem', '2016-01-05 01:17:00', NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `FK_790009E318B96200` FOREIGN KEY (`demandType`) REFERENCES `Demand` (`demandID`),
  ADD CONSTRAINT `FK_790009E39830F9E2` FOREIGN KEY (`closedBy`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `FK_790009E3AA486CAC` FOREIGN KEY (`viewedBy`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `FK_790009E3D3564642` FOREIGN KEY (`createdBy`) REFERENCES `User` (`id`);

--
-- Contraintes pour la table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `FK_2DA17977D3564642` FOREIGN KEY (`createdBy`) REFERENCES `User` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
