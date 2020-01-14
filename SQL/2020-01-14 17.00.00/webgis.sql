-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Gen 14, 2020 alle 17:22
-- Versione del server: 5.7.11
-- Versione PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webgis`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `wg_progetti`
--

CREATE TABLE `wg_progetti` (
  `id` int(11) NOT NULL,
  `nome_progetto` varchar(255) COLLATE utf8_bin NOT NULL,
  `data_progetto` date NOT NULL DEFAULT '0000-00-00',
  `descrizione` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `wg_progetti_foto`
--

CREATE TABLE `wg_progetti_foto` (
  `id` int(11) NOT NULL,
  `id_progetto` int(11) NOT NULL,
  `nome_foto` varchar(255) COLLATE utf8_bin NOT NULL,
  `foto` varchar(255) COLLATE utf8_bin NOT NULL,
  `ordine` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `wg_progetti_layers`
--

CREATE TABLE `wg_progetti_layers` (
  `id` int(11) NOT NULL,
  `id_progetto` int(11) NOT NULL,
  `id_madre` int(11) NOT NULL DEFAULT '0',
  `nome_layer` varchar(255) COLLATE utf8_bin NOT NULL,
  `ordine` int(11) NOT NULL,
  `attributi` text COLLATE utf8_bin NOT NULL COMMENT 'attributi in array serializzati',
  `boundaries` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `wg_utenti`
--

CREATE TABLE `wg_utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `user` varchar(100) COLLATE utf8_bin NOT NULL,
  `pass` varchar(255) COLLATE utf8_bin NOT NULL,
  `attivo` tinyint(1) NOT NULL DEFAULT '1',
  `livello` varchar(50) COLLATE utf8_bin NOT NULL,
  `last_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `wg_progetti`
--
ALTER TABLE `wg_progetti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_progetto` (`data_progetto`);

--
-- Indici per le tabelle `wg_progetti_foto`
--
ALTER TABLE `wg_progetti_foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordine` (`ordine`),
  ADD KEY `id_progetto` (`id_progetto`);

--
-- Indici per le tabelle `wg_progetti_layers`
--
ALTER TABLE `wg_progetti_layers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_progetto` (`id_progetto`),
  ADD KEY `id_madre` (`id_madre`),
  ADD KEY `ordine` (`ordine`);

--
-- Indici per le tabelle `wg_utenti`
--
ALTER TABLE `wg_utenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `pass` (`pass`),
  ADD KEY `attivo` (`attivo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `wg_progetti`
--
ALTER TABLE `wg_progetti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `wg_progetti_foto`
--
ALTER TABLE `wg_progetti_foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `wg_progetti_layers`
--
ALTER TABLE `wg_progetti_layers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `wg_utenti`
--
ALTER TABLE `wg_utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `wg_progetti_foto`
--
ALTER TABLE `wg_progetti_foto`
  ADD CONSTRAINT `foto_progetti` FOREIGN KEY (`id_progetto`) REFERENCES `wg_progetti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `wg_progetti_layers`
--
ALTER TABLE `wg_progetti_layers`
  ADD CONSTRAINT `mappa_progetto` FOREIGN KEY (`id_progetto`) REFERENCES `wg_progetti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
