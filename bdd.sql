-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mar 05 Avril 2016 à 22:24
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `lokisalle`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(5) NOT NULL,
  `id_membre` int(5) DEFAULT NULL,
  `id_salle` int(5) DEFAULT NULL,
  `commentaire` text,
  `note` int(2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date`) VALUES
(1, 5, 2, 'SUPER', 4, '2016-04-19');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(6) NOT NULL,
  `montant` int(5) DEFAULT NULL,
  `id_membre` int(5) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `montant`, `id_membre`, `date`) VALUES
(16, 456, 6, '2016-01-22'),
(31, 28476, 6, '2016-04-03'),
(32, 21062, 6, '2016-04-03'),
(33, 9492, 6, '2016-04-03'),
(34, 9492, 6, '2016-04-03'),
(35, 0, 6, '2016-04-03'),
(36, 0, 4, '2016-04-04');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(6) NOT NULL,
  `id_commande` int(6) DEFAULT NULL,
  `id_produit` int(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `details_commande`
--

INSERT INTO `details_commande` (`id_details_commande`, `id_commande`, `id_produit`) VALUES
(2, 16, 5),
(3, 31, 14),
(4, 31, 14),
(5, 31, 14),
(6, 32, 14),
(7, 32, 9),
(8, 32, 8),
(9, 34, 14);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(5) NOT NULL,
  `pseudo` varchar(15) DEFAULT NULL,
  `mdp` varchar(245) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `sexe` enum('m','f') DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `cp` int(5) unsigned zerofill DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `statut` int(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `ville`, `cp`, `adresse`, `statut`) VALUES
(4, 'admin', '$2y$10$LJyXeZ0qdHFmwhTjdArjMehuOUGuFnO7GTLbIixCud634NzvfjlxW', 'Sabatier', 'celine', 'celine@toto.com', 'f', 'guyancourt', 78280, 'mon adresse', 1),
(5, 'CssJulien  ', '$2y$10$IX88d0LAJTk1Twn/aiBj1uLC7Iv1QqjBDwnvg7LPBoOEycqj1egzS', 'sabatier  ', 'julien  ', 'julien@toto.com', 'm', 'guyancourt  ', 78280, 'mon adresse', 0),
(6, 'CssYves', '$2y$10$3nouZvF3d9Jl/s83IjBMDOWgyF96ZQdoXZnTZAAALxZWY0zBvZDBq', 'Guigon', 'Yves', 'guigonyves@hello.com', 'm', 'Saint Peray', 07130, '5 allee de plein ciel', 0),
(7, 'CssElisabeth', '$2y$10$pX0dZFyOvP7US09bQw6E.On8HmOCr4V6XGdeuZLqvh/uMCyg8EbDW', 'Guigon', 'Elisabeth', 'guigonelisabeth@hello.com', 'f', 'Saint Peray', 07130, '5 allee de plein ciel', 0),
(8, 'CssBoris', '$2y$10$WQXkHEvApTSijk7oe1dr9eGrMjyhOw/YHrmdPteOleGDhiLSiIrpq', 'Sabatier', 'Boris', 'sabatierboris@hello.com', 'm', 'Lyon', 69003, '5 rue de la croix rousse', 0),
(9, 'CssHelene', '$2y$10$C6x0sad3B3A3PnOvtL7wbOuBx3HNete1KG3W4kB/dZhhiMPLaSeH2', 'Col', 'Helene', 'colhelene@hello.com', 'f', 'Villeurbanne', 69100, '5 rue des grattes ciel', 0),
(10, 'CssPatrick', '$2y$10$gJVnuA8gvPYcFhzhaqGyRuuj5PFn1BlGtNZJK/lXCqZRmf4/ApmdC', 'Chaneac', 'Patrick', 'chaneacpatrick@hello.com', 'm', 'Villeurbanne', 69100, '5 rue des grattes ciel', 0),
(11, 'CssPhilippe', '$2y$10$ACneoJYa3TrYfd14/qynA.rRq7qphIBSrAX.LyVMPuy/U52gMh1SG', 'Sabatier', 'Philippe', 'sabatierphilippe@hello.com', 'm', 'Villeurbanne', 69100, '6 A salvador Allende', 0),
(12, 'CssCatherine', '$2y$10$bud8m.Ovsia.f/BE29psse2bHKIKkkgna0qvy6IMHcZZ486vw3Uvq', 'Begon', 'Catherine', 'begoncatherine@hello.com', 'f', 'Villeurbanne', 69100, '6 A salvador Allende', 0),
(13, 'CssFrancois', '$2y$10$uw2x1gnBpMtkujpCi6KOmuoD2WO4z0IRshNzGB5ZCWEB4Xy34t2rG', 'Guigon', 'Francois', 'guigonfrancois@hello.com', 'm', 'Bois le roi', 77100, '5 rue des platanes', 0),
(14, 'CssAnn', '$2y$10$0uWB1TYj7152Z7/8BbSpbe/6BXQQCAbDcRL6oWySNW/ysNqaOq/LG', 'Guigon', 'Ann', 'guigonann@hello.com', 'f', 'Bois le roi', 77100, '5 rue des platanes', 0),
(15, 'CssLionel', '$2y$10$qbUtjGUpv8553cV9/E0pq.byoVdLszQ1woLxNgDOCiNZ2h.oxdnN.', 'Guigon', 'Lionel', 'guigonlionel@hello.com', 'm', 'Chamonix', 74100, '5 rue de la montagne', 0),
(16, 'CssPascale ', '$2y$10$RNMAUtnpLj8xBsphRLT/Pu5jijoXpyw7AmxOpdx9jkSDiOvkTuU7m', 'Moser ', 'Pascale ', 'moserpascale@hello.com', 'm', 'Chamonix ', 74100, '5 rue de la montagne', 1),
(17, 'CssEthan', '$2y$10$h6i9gIpKbnrBLTP1n8RmLuFw3NEUzFDOspjBQmRkIiOd4vX8JnSOm', 'Guigon', 'Ethan', 'guigonethan@hello.com', 'm', 'Chamonix', 74100, '5 rue de la montagne', 0),
(18, 'CssChristian', '$2y$10$JXZ/4AQWJ4S60N2iAI8KnOXSWWtjs8qGF.J9EA6xNCQssitHZ2GUC', 'Guigon', 'Christian', 'guigonchristian@hello.com', 'm', 'Antibes', 06100, '5 rue de la plage', 0),
(19, 'CssAndree', '$2y$10$Ehj25FrKRWElprDh0mnTjuo5I/Pm.YQV7Vz.JHoUlJ7ZUh9rhJyZC', 'Guigon', 'Andree', 'guigonandree@hello.com', 'f', 'Antibes', 06100, '5 rue de la plage', 0),
(20, 'CssArmand', '$2y$10$WHe5wPTT2Rd6jqipldRxbei9EKiEiYJhNxuEfbNIZjci6mVEKFJHG', 'Guigon', 'Armand', 'guigonarmand@hello.com', 'm', 'Aubenas', 07100, '5 rue des lavande', 0);

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id_newsletter` int(5) NOT NULL,
  `id_membre` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(5) NOT NULL,
  `date_arrivee` date DEFAULT NULL,
  `date_depart` date DEFAULT NULL,
  `id_salle` int(5) DEFAULT NULL,
  `id_promo` int(2) DEFAULT NULL,
  `prix` int(5) DEFAULT NULL,
  `etat` int(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `date_arrivee`, `date_depart`, `id_salle`, `id_promo`, `prix`, `etat`) VALUES
(5, '2016-09-03', '2016-09-10', 7, 1, 500, 0),
(7, '2016-09-24', '2016-10-01', 2, 1, 850, 0),
(8, '2016-10-01', '2016-10-08', 4, 5, 940, 0),
(9, '2016-10-08', '2016-10-15', 9, 1, 450, 0),
(10, '2016-03-10', '2016-03-24', 3, 1, 909, 0),
(11, '2016-03-04', '2016-03-10', 2, 1, 909, 0),
(12, '2016-03-03', '2016-03-10', 5, 1, 4, 0),
(13, '2016-04-01', '2016-04-06', 1, 1, 14, 1),
(14, '2016-04-29', '2016-05-06', 3, 1, 678, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Promotion`
--

CREATE TABLE `Promotion` (
  `id_promo` int(2) NOT NULL,
  `code_promo` varchar(6) DEFAULT NULL,
  `reduction` int(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Promotion`
--

INSERT INTO `Promotion` (`id_promo`, `code_promo`, `reduction`) VALUES
(1, 'NULL', 0),
(5, 'IROZP', 40),
(6, 'IDOPL', 30);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(5) NOT NULL,
  `pays` varchar(20) DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `adresse` text,
  `cp` int(5) unsigned zerofill DEFAULT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `description` text,
  `photo` varchar(200) DEFAULT NULL,
  `capacite` int(3) DEFAULT NULL,
  `categorie` enum('reunion','multimedia','conference') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `pays`, `ville`, `adresse`, `cp`, `titre`, `description`, `photo`, `capacite`, `categorie`) VALUES
(1, 'France1', 'Paris1', '5 rue de la republique1', 15003, '1La salle republique', '1La salle de conference', '/LOKISALLE/photo/La salle republique_2 _salle_multimedia.jpg', 21, 'reunion'),
(2, 'France', 'Marseille', '5 rue Victor Hugo', 13009, 'La salle Hugo', 'La salle multimedia', '/LOKISALLE/photo/2 _salle_multimedia.jpg', 15, 'multimedia'),
(3, 'France', 'Lyon', '6 place Bellecour', 69002, 'La salle Bellecour', 'Une salle pour travailler dans un cadre agreable ', '/LOKISALLE/photo/3 _salle_cooconing.jpg', 10, 'reunion'),
(4, 'France', 'Nantes', '5 rue de la mer', 44000, 'Le bureau', 'Un endroit pour travailler', '/LOKISALLE/photo/ _salle_travail.jpg', 10, 'reunion'),
(5, 'France ', 'Paris', '6 rue des gobelins', 75009, 'La salle restaurant', 'Une salle de restaurant pour anim&eacute; des soiree a themes', '/LOKISALLE/photo/ _salle_restaurant.jpg', 30, 'reunion'),
(6, 'France1', 'Paris', '8 rue montparnasse', 75015, 'La salle Montparnasse', 'Une salle de r&eacute;union ', '/LOKISALLE/photo/ _salle_reunion.jpg', 20, 'reunion'),
(7, 'France', 'Paris', '7 rue de gare de Lyon', 75012, 'La salle de lyon', 'Une salle ou l''on peut faire des demonstration de cuisine', '/LOKISALLE/photo/ _salle_demonstration.jpg', 15, 'reunion'),
(8, 'France', 'Lyon', '5 rue de la republique', 69002, 'La salle de la republique ', 'Salle de conference', '/LOKISALLE/photo/La salle de la republique __salle_3.jpg', 50, 'reunion'),
(9, 'France', 'Nantes', '5 rue de l''elephant', 78009, 'La salle de nantes', 'Salle de detente', '/LOKISALLE/photo/La salle de nantes__salle_1.jpg', 8, 'reunion');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD KEY `fk_avis_salle1_idx` (`id_salle`),
  ADD KEY `fk_avis_membre_idx` (`id_membre`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_commande_membre1_idx` (`id_membre`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`),
  ADD KEY `fk_details_commande_commande1_idx` (`id_commande`),
  ADD KEY `fk_details_commande_produit1_idx` (`id_produit`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id_newsletter`),
  ADD KEY `fk_newsletter_membre1_idx` (`id_membre`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `fk_produit_salle1_idx` (`id_salle`),
  ADD KEY `fk_produit_Promotion1_idx` (`id_promo`);

--
-- Index pour la table `Promotion`
--
ALTER TABLE `Promotion`
  ADD PRIMARY KEY (`id_promo`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id_newsletter` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `Promotion`
--
ALTER TABLE `Promotion`
  MODIFY `id_promo` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id_salle` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis_membre` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_avis_salle1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_commande_membre1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `fk_details_commande_commande1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_details_commande_produit1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_produit_Promotion1` FOREIGN KEY (`id_promo`) REFERENCES `Promotion` (`id_promo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_produit_salle1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE SET NULL;
