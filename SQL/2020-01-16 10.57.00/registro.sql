-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Gen 16, 2020 alle 10:57
-- Versione del server: 5.7.11
-- Versione PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `webgis`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `wg_registro`
--

CREATE TABLE `wg_registro` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL DEFAULT '0',
  `categoria` varchar(50) COLLATE utf8_bin NOT NULL,
  `operazione` text COLLATE utf8_bin NOT NULL,
  `data` datetime NOT NULL,
  `errore` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `wg_registro`
--
ALTER TABLE `wg_registro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `errore` (`errore`),
  ADD KEY `data` (`data`),
  ADD KEY `categoria` (`categoria`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `wg_registro`
--
ALTER TABLE `wg_registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;