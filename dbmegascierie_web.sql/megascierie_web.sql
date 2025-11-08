-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 08, 2025 at 02:36 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `megascierie_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `personne_contact` varchar(100) DEFAULT NULL,
  `type_client` enum('entreprise','particulier') DEFAULT NULL,
  `code_client` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `adresse`, `telephone`, `email`, `personne_contact`, `type_client`, `code_client`, `ville`, `pays`) VALUES
(1, 'Bois du Gabon SARL', 'Zone industrielle d’Owendo', '062111222', 'contact@boisgabon.ga', 'M. Nguema', 'entreprise', 'CL001', 'Libreville', 'Gabon'),
(2, 'Menuiserie Nzeng', 'PK7, Libreville', '066333444', 'nzeng@gmail.com', 'Mme Ella', 'particulier', 'CL002', 'Libreville', 'Gabon'),
(3, 'Timber Export Intl.', '12 Rue des Docks, 75001', '+33123456789', 'export@timber.fr', 'Mr Dubois', 'entreprise', 'CL003', 'Paris', 'France'),
(4, 'BatiConstruction SA', 'Z.I. Port-Gentil', '077555666', 'contact@bati.ga', 'Mme Bongo', 'entreprise', 'CL004', 'Port-Gentil', 'Gabon'),
(5, 'Artisan Ebène', 'Quartier Mindoubé', '069123456', 'artisan@ebene.ga', 'M. Emane', 'particulier', 'CL005', 'Libreville', 'Gabon');

-- --------------------------------------------------------

--
-- Table structure for table `contrat`
--

CREATE TABLE `contrat` (
  `id_contrat` int(11) NOT NULL,
  `numero_contrat` varchar(50) NOT NULL,
  `date_signature` date DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `type_produit` varchar(50) DEFAULT NULL,
  `quantite_prevue` decimal(10,2) DEFAULT NULL,
  `statut` enum('actif','terminé') DEFAULT 'actif',
  `conditions_particulieres` text,
  `id_client` int(11) DEFAULT NULL,
  `id_programme` int(11) DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contrat`
--

INSERT INTO `contrat` (`id_contrat`, `numero_contrat`, `date_signature`, `duree`, `type_produit`, `quantite_prevue`, `statut`, `conditions_particulieres`, `id_client`, `id_programme`, `id_utilisateur`) VALUES
(1, 'CT-2025-01', '2025-09-01', 12, 'Planche', '150.00', 'actif', 'Livraison mensuelle de 12.5m³', 1, 1, 8),
(2, 'CT-2025-02', '2025-09-15', 6, 'Chevron', '80.00', 'actif', NULL, 2, 1, 8),
(3, 'CT-2025-03', '2025-10-01', 18, 'Poutre', '300.00', 'actif', 'Export maritime obligatoire', 3, 2, 8),
(4, 'CT-2025-04', '2025-10-10', 3, 'Mélange', '50.00', 'terminé', NULL, 4, 1, 8),
(5, 'CT-2025-05', '2025-11-01', 12, 'Planche', '100.00', 'actif', 'Prix fixe garanti', 5, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `declarationmensuelle`
--

CREATE TABLE `declarationmensuelle` (
  `id_declaration` int(11) NOT NULL,
  `mois` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `date_generation` date DEFAULT NULL,
  `type_declaration` varchar(50) DEFAULT NULL,
  `volume_total_declare` decimal(10,2) DEFAULT NULL,
  `responsable_declaration` int(11) DEFAULT NULL,
  `id_programme` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `declarationmensuelle`
--

INSERT INTO `declarationmensuelle` (`id_declaration`, `mois`, `annee`, `date_generation`, `type_declaration`, `volume_total_declare`, `responsable_declaration`, `id_programme`) VALUES
(1, 10, 2025, '2025-10-31', 'Technique', '185.50', 3, 1),
(2, 10, 2025, '2025-10-31', 'Commerciale', '150.00', 5, 1),
(3, 11, 2025, '2025-11-30', 'Technique', '190.00', 3, 2),
(4, 11, 2025, '2025-11-30', 'Commerciale', '175.00', 5, 2),
(5, 12, 2025, '2025-12-31', 'Technique', '160.00', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `id_facture` int(11) NOT NULL,
  `numero_facture` varchar(50) NOT NULL,
  `date_facture` date NOT NULL,
  `montant_total` decimal(12,2) NOT NULL,
  `TVA` decimal(5,2) DEFAULT NULL,
  `remise` decimal(5,2) DEFAULT NULL,
  `mode_paiement` varchar(50) DEFAULT NULL,
  `statut` enum('payée','non payée') DEFAULT 'non payée',
  `id_client` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id_facture`, `numero_facture`, `date_facture`, `montant_total`, `TVA`, `remise`, `mode_paiement`, `statut`, `id_client`, `id_utilisateur`) VALUES
(1, 'FAC-2025-001', '2025-10-25', '1250000.00', '18.00', '5.00', 'Virement', 'payée', 1, 5),
(2, 'FAC-2025-002', '2025-10-30', '740000.00', '18.00', '0.00', 'Chèque', 'non payée', 2, 5),
(3, 'FAC-2025-003', '2025-11-01', '3500000.00', '0.00', '10.00', 'Virement', 'payée', 3, 5),
(4, 'FAC-2025-004', '2025-11-05', '850000.00', '18.00', '0.00', 'Espèces', 'non payée', 4, 5),
(5, 'FAC-2025-005', '2025-11-10', '1500000.00', '18.00', '5.00', 'Chèque', 'non payée', 1, 5),
(6, 'FAC-2025-006', '2025-11-15', '420000.00', '18.00', '0.00', 'Espèces', 'payée', 5, 5),
(7, 'FAC-2025-007', '2025-11-20', '3200000.00', '0.00', '0.00', 'Virement', 'non payée', 3, 5),
(8, 'FAC-2025-008', '2025-11-25', '650000.00', '18.00', '0.00', 'Chèque', 'non payée', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `grume`
--

CREATE TABLE `grume` (
  `id_grume` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `essence` varchar(50) DEFAULT NULL,
  `volume` decimal(10,2) DEFAULT NULL,
  `origine` varchar(100) DEFAULT NULL,
  `date_entree` date DEFAULT NULL,
  `longueur` decimal(10,2) DEFAULT NULL,
  `diametre` decimal(10,2) DEFAULT NULL,
  `qualite` varchar(50) DEFAULT NULL,
  `statut` enum('en stock','production','transportée') DEFAULT 'en stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grume`
--

INSERT INTO `grume` (`id_grume`, `numero`, `essence`, `volume`, `origine`, `date_entree`, `longueur`, `diametre`, `qualite`, `statut`) VALUES
(1, 'GRM-001', 'Okoumé', '2.45', 'Makokou', '2025-10-15', '5.70', '38.50', '1ère', 'en stock'),
(2, 'GRM-002', 'Ozigo', '3.10', 'Ndjolé', '2025-10-16', '6.20', '40.00', '2e', 'en stock'),
(3, 'GRM-003', 'Padouk', '2.90', 'Booué', '2025-10-18', '5.50', '39.20', '1ère', 'production'),
(4, 'GRM-004', 'Azobé', '3.40', 'Lastoursville', '2025-10-20', '6.00', '41.50', '1ère', 'transportée'),
(5, 'GRM-005', 'Okoumé', '2.75', 'Makokou', '2025-10-25', '5.80', '37.00', '2e', 'en stock'),
(6, 'GRM-006', 'Okoumé', '2.80', 'Ndjolé', '2025-10-26', '6.00', '39.00', '1ère', 'en stock'),
(7, 'GRM-007', 'Ozigo', '3.20', 'Booué', '2025-10-26', '6.50', '40.50', '2e', 'en stock'),
(8, 'GRM-008', 'Padouk', '2.55', 'Makokou', '2025-10-28', '5.20', '35.00', '1ère', 'production'),
(9, 'GRM-009', 'Azobé', '3.80', 'Ndjolé', '2025-10-29', '6.10', '43.00', '1ère', 'en stock'),
(10, 'GRM-010', 'Okoumé', '2.65', 'Lastoursville', '2025-10-30', '5.60', '38.00', '2e', 'en stock'),
(11, 'GRM-011', 'Movingui', '2.10', 'Makokou', '2025-11-01', '5.00', '35.50', '1ère', 'en stock'),
(12, 'GRM-012', 'Movingui', '3.00', 'Ndjolé', '2025-11-02', '6.00', '39.50', '2e', 'production'),
(13, 'GRM-013', 'Tali', '3.50', 'Booué', '2025-11-03', '6.30', '42.00', '1ère', 'en stock'),
(14, 'GRM-014', 'Tali', '2.85', 'Lastoursville', '2025-11-04', '5.90', '37.50', '2e', 'en stock'),
(15, 'GRM-015', 'Okoumé', '2.95', 'Makokou', '2025-11-05', '5.50', '39.00', '1ère', 'en stock');

-- --------------------------------------------------------

--
-- Table structure for table `ordretransit`
--

CREATE TABLE `ordretransit` (
  `id_transit` int(11) NOT NULL,
  `date_transit` date NOT NULL,
  `type_transit` enum('grume','debite') NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `destination` varchar(80) NOT NULL,
  `statut` enum('préparé','en cours','livré','annulé') NOT NULL,
  `conducteur` varchar(50) DEFAULT NULL,
  `vehicule` varchar(30) DEFAULT NULL,
  `observations` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ordretransit`
--

INSERT INTO `ordretransit` (`id_transit`, `date_transit`, `type_transit`, `produit_id`, `quantite`, `destination`, `statut`, `conducteur`, `vehicule`, `observations`) VALUES
(1, '2025-10-24', 'debite', 2, '1.80', 'Menuiserie Nzeng', 'livré', 'Ekoua René', 'BB-789-GA', 'Livraison urgente'),
(2, '2025-11-01', 'debite', 8, '4.00', 'Port d\'Owendo', 'en cours', 'Ondo Pierre', 'CC-111-GA', 'Pour export CT-2025-03'),
(3, '2025-11-06', 'debite', 5, '1.50', 'BatiConstruction SA', 'préparé', 'Ekoua René', 'DD-222-GA', 'Reliquat de commande'),
(4, '2025-11-10', 'debite', 9, '1.30', 'Artisan Ebène', 'préparé', 'Ondo Pierre', 'CC-111-GA', NULL),
(5, '2025-11-15', 'debite', 7, '1.75', 'Bois du Gabon SARL', 'préparé', 'Mbadinga Jules', 'AA-456-GA', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productionscierie`
--

CREATE TABLE `productionscierie` (
  `id_production` int(11) NOT NULL,
  `date_production` date DEFAULT NULL,
  `volume_total` decimal(10,2) DEFAULT NULL,
  `rendement` decimal(5,2) DEFAULT NULL,
  `type_produit` varchar(50) DEFAULT NULL,
  `operateur_responsable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productionscierie`
--

INSERT INTO `productionscierie` (`id_production`, `date_production`, `volume_total`, `rendement`, `type_produit`, `operateur_responsable`) VALUES
(1, '2025-10-18', '15.50', '75.20', 'Planche/Poutre', 3),
(2, '2025-10-20', '18.40', '78.10', 'Chevron/Planche', 3),
(3, '2025-10-25', '12.00', '72.50', 'Planche/Poutre', 3),
(4, '2025-10-28', '16.80', '76.00', 'Chevron/Planche', 3),
(5, '2025-11-02', '20.10', '79.50', 'Planche/Poutre', 3);

-- --------------------------------------------------------

--
-- Table structure for table `produitdebite`
--

CREATE TABLE `produitdebite` (
  `id_debite` int(11) NOT NULL,
  `type_produit` varchar(50) NOT NULL,
  `volume` decimal(10,2) NOT NULL,
  `section` varchar(50) DEFAULT NULL,
  `date_debit` date NOT NULL,
  `longueur` decimal(10,2) DEFAULT NULL,
  `destination` enum('stock','client','production') DEFAULT NULL,
  `qualite` varchar(50) DEFAULT NULL,
  `id_grume_source` int(11) DEFAULT NULL,
  `id_production` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produitdebite`
--

INSERT INTO `produitdebite` (`id_debite`, `type_produit`, `volume`, `section`, `date_debit`, `longueur`, `destination`, `qualite`, `id_grume_source`, `id_production`) VALUES
(1, 'Planche', '1.25', '20x250', '2025-10-18', '5.70', 'stock', 'A', 3, 1),
(2, 'Chevron', '1.80', '100x100', '2025-10-20', '6.00', 'client', 'B', 3, 2),
(3, 'Planche', '2.10', '30x250', '2025-10-25', '5.50', 'stock', 'A', 8, 3),
(4, 'Poutre', '3.50', '150x150', '2025-10-25', '6.20', 'stock', 'A', 3, 3),
(5, 'Planche', '1.50', '20x200', '2025-10-28', '5.00', 'client', 'B', 8, 4),
(6, 'Chevron', '1.10', '80x80', '2025-10-28', '5.80', 'stock', 'A', 8, 4),
(7, 'Planche', '1.75', '25x300', '2025-11-02', '6.00', 'stock', 'A', 12, 5),
(8, 'Poutre', '4.00', '200x200', '2025-11-02', '6.50', 'client', 'B', 12, 5),
(9, 'Planche', '1.30', '20x250', '2025-11-04', '5.70', 'stock', 'A', 3, 2),
(10, 'Chevron', '1.95', '100x100', '2025-11-04', '6.10', 'stock', 'A', 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `programmeannuel`
--

CREATE TABLE `programmeannuel` (
  `id_programme` int(11) NOT NULL,
  `annee` int(11) DEFAULT NULL,
  `mois` int(11) DEFAULT NULL,
  `volume_prevu` decimal(10,2) DEFAULT NULL,
  `type_produit` varchar(50) DEFAULT NULL,
  `responsable_programme` int(11) DEFAULT NULL,
  `statut` enum('planifié','exécuté') DEFAULT 'planifié'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `programmeannuel`
--

INSERT INTO `programmeannuel` (`id_programme`, `annee`, `mois`, `volume_prevu`, `type_produit`, `responsable_programme`, `statut`) VALUES
(1, 2025, 10, '180.00', 'Planche/Chevron', 3, 'exécuté'),
(2, 2025, 11, '200.00', 'Poutre/Planche', 3, 'planifié'),
(3, 2026, 1, '150.00', 'Okoumé débité', 3, 'planifié');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `type_produit` enum('grume','debite') NOT NULL,
  `grume_id` int(11) DEFAULT NULL,
  `debite_id` int(11) DEFAULT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `emplacement` varchar(80) DEFAULT NULL,
  `date_entree` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `statut` enum('en stock','sorti','réservé','en transit') DEFAULT 'en stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id_stock`, `type_produit`, `grume_id`, `debite_id`, `quantite`, `emplacement`, `date_entree`, `date_sortie`, `statut`) VALUES
(1, 'grume', 1, NULL, '2.45', 'Parc Grumes A1', '2025-10-15', NULL, 'en stock'),
(2, 'grume', 2, NULL, '3.10', 'Parc Grumes A2', '2025-10-16', NULL, 'en stock'),
(3, 'grume', 5, NULL, '2.75', 'Parc Grumes A1', '2025-10-25', NULL, 'en stock'),
(4, 'debite', NULL, 1, '1.25', 'Hangar B1', '2025-10-18', NULL, 'en stock'),
(5, 'debite', NULL, 3, '2.10', 'Hangar B1', '2025-10-25', NULL, 'réservé'),
(6, 'debite', NULL, 4, '3.50', 'Hangar B2', '2025-10-25', NULL, 'en stock'),
(7, 'grume', 6, NULL, '2.80', 'Parc Grumes A3', '2025-10-26', NULL, 'en stock'),
(8, 'debite', NULL, 6, '1.10', 'Hangar B1', '2025-10-28', NULL, 'en stock'),
(9, 'grume', 9, NULL, '3.80', 'Parc Grumes A3', '2025-10-29', NULL, 'en stock'),
(10, 'debite', NULL, 7, '1.75', 'Hangar B2', '2025-11-02', NULL, 'en stock');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id_transport` int(11) NOT NULL,
  `date_transport` date DEFAULT NULL,
  `chauffeur` varchar(100) DEFAULT NULL,
  `immatriculation` varchar(20) DEFAULT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `type_produit` varchar(50) DEFAULT NULL,
  `volume_transporte` decimal(10,2) DEFAULT NULL,
  `statut` enum('en cours','livré','annulé','préparé') DEFAULT 'en cours',
  `numero_transport` varchar(50) DEFAULT NULL,
  `point_depart` varchar(100) DEFAULT NULL,
  `date_depart` date DEFAULT NULL,
  `date_arrivee` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id_transport`, `date_transport`, `chauffeur`, `immatriculation`, `destination`, `type_produit`, `volume_transporte`, `statut`, `numero_transport`, `point_depart`, `date_depart`, `date_arrivee`) VALUES
(1, '2025-10-21', 'Mbadinga Jules', 'AA-456-GA', 'Scierie Libreville', 'Grume', '3.40', 'livré', 'TR-GR-001', 'Lastoursville', '2025-10-20', '2025-10-21'),
(2, '2025-10-24', 'Ekoua René', 'BB-789-GA', 'Menuiserie Nzeng', 'Débités', '1.80', 'livré', 'TR-DB-002', 'Scierie Libreville', '2025-10-24', '2025-10-24'),
(3, '2025-11-01', 'Ondo Pierre', 'CC-111-GA', 'Port d\'Owendo', 'Débités', '4.00', 'en cours', 'TR-DB-003', 'Scierie Libreville', '2025-11-01', NULL),
(4, '2025-11-05', 'Mbadinga Jules', 'AA-456-GA', 'Scierie Libreville', 'Grume', '3.50', 'en cours', 'TR-GR-004', 'Booué', '2025-11-05', NULL),
(5, '2025-11-06', 'Ekoua René', 'DD-222-GA', 'BatiConstruction SA', 'Débités', '1.50', 'préparé', 'TR-DB-005', 'Scierie Libreville', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transport_grume`
--

CREATE TABLE `transport_grume` (
  `id_transport` int(11) NOT NULL,
  `id_grume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transport_grume`
--

INSERT INTO `transport_grume` (`id_transport`, `id_grume`) VALUES
(1, 4),
(4, 13);

-- --------------------------------------------------------

--
-- Table structure for table `transport_produit`
--

CREATE TABLE `transport_produit` (
  `id_transport` int(11) NOT NULL,
  `id_debite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transport_produit`
--

INSERT INTO `transport_produit` (`id_transport`, `id_debite`) VALUES
(2, 2),
(5, 5),
(3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `statut` enum('actif','inactif') DEFAULT 'actif',
  `date_creation` date DEFAULT NULL,
  `derniere_connexion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `telephone`, `statut`, `date_creation`, `derniere_connexion`) VALUES
(1, 'Mouity', 'André', 'andre.mouity@megascierie.com', 'admin123', 'Administrateur', '062345678', 'actif', '2025-10-01', NULL),
(2, 'Ngoma', 'Sylvie', 'sylvie.ngoma@megascierie.com', 'agent123', 'Agent de saisie', '062987654', 'actif', '2025-10-02', NULL),
(3, 'Ella', 'Patrick', 'patrick.ella@megascierie.com', 'prod123', 'Chef de production', '065321789', 'actif', '2025-10-03', NULL),
(4, 'Minko', 'Josué', 'josue.minko@megascierie.com', 'stock123', 'Gestionnaire de stock', '066999888', 'actif', '2025-10-04', NULL),
(5, 'Abessolo', 'Claire', 'claire.abessolo@megascierie.com', 'compte123', 'Comptable', '077777666', 'actif', '2025-10-05', NULL),
(6, 'Mbadinga', 'Jules', 'jules.mbadinga@megascierie.com', 'log123', 'Logisticien', '061234567', 'actif', '2025-10-06', NULL),
(7, 'Nzeng', 'Paul', 'paul.nzeng@megascierie.com', 'Client', 'client123', '068888999', 'actif', '2025-10-07', NULL),
(8, 'Ekoua', 'René', 'rene.ekoua@megascierie.com', 'commercial123', 'Agent commercial', '067777888', 'actif', '2025-10-08', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`id_contrat`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_programme` (`id_programme`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `declarationmensuelle`
--
ALTER TABLE `declarationmensuelle`
  ADD PRIMARY KEY (`id_declaration`),
  ADD KEY `responsable_declaration` (`responsable_declaration`),
  ADD KEY `id_programme` (`id_programme`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id_facture`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `grume`
--
ALTER TABLE `grume`
  ADD PRIMARY KEY (`id_grume`);

--
-- Indexes for table `ordretransit`
--
ALTER TABLE `ordretransit`
  ADD PRIMARY KEY (`id_transit`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Indexes for table `productionscierie`
--
ALTER TABLE `productionscierie`
  ADD PRIMARY KEY (`id_production`),
  ADD KEY `operateur_responsable` (`operateur_responsable`);

--
-- Indexes for table `produitdebite`
--
ALTER TABLE `produitdebite`
  ADD PRIMARY KEY (`id_debite`),
  ADD KEY `id_grume_source` (`id_grume_source`),
  ADD KEY `id_production` (`id_production`);

--
-- Indexes for table `programmeannuel`
--
ALTER TABLE `programmeannuel`
  ADD PRIMARY KEY (`id_programme`),
  ADD KEY `responsable_programme` (`responsable_programme`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `grume_id` (`grume_id`),
  ADD KEY `debite_id` (`debite_id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id_transport`);

--
-- Indexes for table `transport_grume`
--
ALTER TABLE `transport_grume`
  ADD PRIMARY KEY (`id_transport`,`id_grume`),
  ADD KEY `id_grume` (`id_grume`);

--
-- Indexes for table `transport_produit`
--
ALTER TABLE `transport_produit`
  ADD PRIMARY KEY (`id_transport`,`id_debite`),
  ADD KEY `id_debite` (`id_debite`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `declarationmensuelle`
--
ALTER TABLE `declarationmensuelle`
  MODIFY `id_declaration` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `facture`
--
ALTER TABLE `facture`
  MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `grume`
--
ALTER TABLE `grume`
  MODIFY `id_grume` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ordretransit`
--
ALTER TABLE `ordretransit`
  MODIFY `id_transit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `productionscierie`
--
ALTER TABLE `productionscierie`
  MODIFY `id_production` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produitdebite`
--
ALTER TABLE `produitdebite`
  MODIFY `id_debite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `programmeannuel`
--
ALTER TABLE `programmeannuel`
  MODIFY `id_programme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
