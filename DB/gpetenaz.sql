-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2017 at 10:53 AM
-- Server version: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.13-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gpetenaz`
--

-- --------------------------------------------------------

--
-- Table structure for table `AssPrezzi`
--

CREATE TABLE `AssPrezzi` (
  `id` int(11) NOT NULL,
  `biglietto` int(11) NOT NULL,
  `prezzo` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Biglietti`
--

CREATE TABLE `Biglietti` (
  `id` int(11) NOT NULL,
  `nominativo` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `id_tour` int(11) DEFAULT NULL,
  `prezzo_totale` double(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Prezzi`
--

CREATE TABLE `Prezzi` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `prezzo` decimal(5,2) NOT NULL DEFAULT '0.00',
  `prezzo_audioguida` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Prezzi`
--

INSERT INTO `Prezzi` (`id`, `descrizione`, `prezzo`, `prezzo_audioguida`) VALUES
(1, 'Intero', '10.00', '2.00'),
(2, 'Bambini fino ai 5 anni', '2.00', '1.50'),
(3, 'Bambini dai 6 ai 12 anni', '4.00', '1.50'),
(4, 'Anziani', '6.00', '1.00'),
(5, 'Studenti', '7.50', '2.00'),
(6, 'Disabili', '3.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `Tours`
--

CREATE TABLE `Tours` (
  `id` int(11) NOT NULL,
  `nome` varchar(64) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `prezzo` decimal(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `id_guida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Tours`
--

INSERT INTO `Tours` (`id`, `nome`, `descrizione`, `prezzo`, `id_guida`) VALUES
(1, 'Nessun tour guidato', '', '0.00', 3),
(2, 'Tour guidato della notte', 'Un tour guidato tra le opere raffiguranti la notte, con una guida che spiega il significato dei quadri.', '2.50', 4),
(3, 'Tour guidato degli astratti', 'Un tour guidato tra gli astratti presenti nel museo.', '2.00', 4),
(4, 'Tour guidato scultoreo', 'Un tour guidato in cui si speigano le sculture presenti nel museo.', '3.00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Utenti`
--

CREATE TABLE `Utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `ruolo` enum('segreteria','guide') NOT NULL,
  `username` varchar(26) NOT NULL,
  `password` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Utenti`
--

INSERT INTO `Utenti` (`id`, `nome`, `ruolo`, `username`, `password`) VALUES
(1, 'Ombretta Gaggi', 'segreteria', 'admin', 'admin'),
(2, 'Guida Guidi', 'guide', 'user', 'user'),
(3, 'Silvio Meneguzzo', 'guide', 'silvio', 'silvio'),
(4, 'Giulia Petenazzi', 'guide', 'giulia', 'giulia'),
(5, 'Giovanni Prete', 'guide', 'giovanni', 'giovanni'),
(6, 'Fabio Vianello', 'guide', 'fabio', 'fabio');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AssPrezzi`
--
ALTER TABLE `AssPrezzi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Biglietti`
--
ALTER TABLE `Biglietti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tour` (`id_tour`);

--
-- Indexes for table `Prezzi`
--
ALTER TABLE `Prezzi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Tours`
--
ALTER TABLE `Tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `id_guida` (`id_guida`);

--
-- Indexes for table `Utenti`
--
ALTER TABLE `Utenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AssPrezzi`
--
ALTER TABLE `AssPrezzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Biglietti`
--
ALTER TABLE `Biglietti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Prezzi`
--
ALTER TABLE `Prezzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `Tours`
--
ALTER TABLE `Tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Utenti`
--
ALTER TABLE `Utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Biglietti`
--
ALTER TABLE `Biglietti`
  ADD CONSTRAINT `bigliettiTours` FOREIGN KEY (`id_tour`) REFERENCES `Tours` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Tours`
--
ALTER TABLE `Tours`
  ADD CONSTRAINT `toursGuida` FOREIGN KEY (`id_guida`) REFERENCES `Utenti` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
