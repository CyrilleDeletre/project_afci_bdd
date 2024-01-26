-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 25 jan. 2024 à 11:49
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
-- Base de données : `afci`
--

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

CREATE TABLE `affecter` (
  `id_pedagogie` int(11) NOT NULL,
  `id_centre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `apprenants`
--

CREATE TABLE `apprenants` (
  `id_apprenant` int(11) NOT NULL,
  `nom_apprenant` varchar(255) DEFAULT NULL,
  `prenom_apprenant` varchar(255) DEFAULT NULL,
  `mail_apprenant` varchar(255) DEFAULT NULL,
  `adresse_apprenant` varchar(255) DEFAULT NULL,
  `ville_apprenant` varchar(255) DEFAULT NULL,
  `code_postal_apprenant` varchar(255) DEFAULT NULL,
  `tel_apprenant` varchar(255) DEFAULT NULL,
  `date_naissance_apprenant` date DEFAULT NULL,
  `niveau_apprenant` varchar(255) DEFAULT NULL,
  `num_PE_apprenant` varchar(255) DEFAULT NULL,
  `num_secu_apprenant` varchar(255) DEFAULT NULL,
  `rib_apprenant` varchar(255) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_session` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `centres`
--

CREATE TABLE `centres` (
  `id_centre` int(11) NOT NULL,
  `ville_centre` varchar(255) DEFAULT NULL,
  `adresse_centre` varchar(255) DEFAULT NULL,
  `code_postal_centre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id_formation` int(11) NOT NULL,
  `nom_formation` varchar(255) DEFAULT NULL,
  `duree_formation` varchar(255) DEFAULT NULL,
  `niveau_sortie_formation` varchar(255) DEFAULT NULL,
  `description` varchar(1500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `localiser`
--

CREATE TABLE `localiser` (
  `id_formation` int(11) NOT NULL,
  `id_centre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pedagogie`
--

CREATE TABLE `pedagogie` (
  `id_pedagogie` int(11) NOT NULL,
  `nom_pedagogie` varchar(255) DEFAULT NULL,
  `prenom_pedagogie` varchar(255) DEFAULT NULL,
  `mail_pedagogie` varchar(255) DEFAULT NULL,
  `num_pedagogie` varchar(255) DEFAULT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nom_role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE `session` (
  `id_session` int(11) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `id_pedagogie` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD PRIMARY KEY (`id_pedagogie`,`id_centre`),
  ADD KEY `FK_affecter_id_centre` (`id_centre`);

--
-- Index pour la table `apprenants`
--
ALTER TABLE `apprenants`
  ADD PRIMARY KEY (`id_apprenant`),
  ADD KEY `FK_apprenants_id_role` (`id_role`),
  ADD KEY `FK_apprenants_id_session` (`id_session`);

--
-- Index pour la table `centres`
--
ALTER TABLE `centres`
  ADD PRIMARY KEY (`id_centre`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id_formation`);

--
-- Index pour la table `localiser`
--
ALTER TABLE `localiser`
  ADD PRIMARY KEY (`id_formation`,`id_centre`),
  ADD KEY `FK_localiser_id_centre` (`id_centre`);

--
-- Index pour la table `pedagogie`
--
ALTER TABLE `pedagogie`
  ADD PRIMARY KEY (`id_pedagogie`),
  ADD KEY `FK_pedagogie_id_role` (`id_role`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `FK_session_id_pedagogie` (`id_pedagogie`),
  ADD KEY `FK_session_id_formation` (`id_formation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affecter`
--
ALTER TABLE `affecter`
  MODIFY `id_pedagogie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `apprenants`
--
ALTER TABLE `apprenants`
  MODIFY `id_apprenant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `centres`
--
ALTER TABLE `centres`
  MODIFY `id_centre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `localiser`
--
ALTER TABLE `localiser`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pedagogie`
--
ALTER TABLE `pedagogie`
  MODIFY `id_pedagogie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD CONSTRAINT `FK_affecter_id_centre` FOREIGN KEY (`id_centre`) REFERENCES `centres` (`id_centre`),
  ADD CONSTRAINT `FK_affecter_id_pedagogie` FOREIGN KEY (`id_pedagogie`) REFERENCES `pedagogie` (`id_pedagogie`);

--
-- Contraintes pour la table `apprenants`
--
ALTER TABLE `apprenants`
  ADD CONSTRAINT `FK_apprenants_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`),
  ADD CONSTRAINT `FK_apprenants_id_session` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `localiser`
--
ALTER TABLE `localiser`
  ADD CONSTRAINT `FK_localiser_id_centre` FOREIGN KEY (`id_centre`) REFERENCES `centres` (`id_centre`),
  ADD CONSTRAINT `FK_localiser_id_formation` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`);

--
-- Contraintes pour la table `pedagogie`
--
ALTER TABLE `pedagogie`
  ADD CONSTRAINT `FK_pedagogie_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_session_id_formation` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id_formation`),
  ADD CONSTRAINT `FK_session_id_pedagogie` FOREIGN KEY (`id_pedagogie`) REFERENCES `pedagogie` (`id_pedagogie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
