-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 21, 2020 alle 18:27
-- Versione del server: 10.1.36-MariaDB
-- Versione PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fantasy`
--
CREATE DATABASE IF NOT EXISTS `fantasy` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fantasy`;

-- --------------------------------------------------------

--
-- Struttura della tabella `abbonamentoattivo`
--

DROP TABLE IF EXISTS `abbonamentoattivo`;
CREATE TABLE `abbonamentoattivo` (
  `id` int(11) NOT NULL,
  `dataInizio` date NOT NULL,
  `dataFine` date NOT NULL,
  `ingressiRimanenti` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idtipologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Trigger `abbonamentoattivo`
--
DROP TRIGGER IF EXISTS `storicizzazioneAbbonamento`;
DELIMITER $$
CREATE TRIGGER `storicizzazioneAbbonamento` BEFORE UPDATE ON `abbonamentoattivo` FOR EACH ROW BEGIN
  DECLARE costo float;
  IF NEW.ingressiRimanenti  = 0 THEN
    SELECT t.costo into costo FROM tipologia t WHERE t.id= new.idtipologia;
    INSERT INTO storicoAbbonamento(dataInizio, dataFine, costo, ingressiRimanenti, idCliente, idtipologia)        VALUES (new.dataInizio, new.dataFine, costo, new.ingressiRimanenti,new.idCliente,new.idtipologia);
    -- DELETE FROM abbonamentoattivo where id=new.id;
  END IF;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `accesso`
--

DROP TABLE IF EXISTS `accesso`;
CREATE TABLE `accesso` (
  `idAttrazione` int(11) NOT NULL,
  `idVip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `attrazione`
--

DROP TABLE IF EXISTS `attrazione`;
CREATE TABLE `attrazione` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `tipologia` enum('Spettacolo','Giostra') NOT NULL,
  `longitudine` float NOT NULL DEFAULT '42.5438',
  `latitudine` float NOT NULL DEFAULT '37.8746',
  `maxPosti` int(11) NOT NULL,
  `etaMin` int(11) DEFAULT NULL,
  `altezzaMin` int(11) DEFAULT NULL,
  `orari` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `biglietto`
--

DROP TABLE IF EXISTS `biglietto`;
CREATE TABLE `biglietto` (
  `id` int(11) NOT NULL,
  `costo` float NOT NULL,
  `dataValidita` date NOT NULL,
  `dataAcquisto` date NOT NULL,
  `oraAcquisto` time NOT NULL,
  `luogoAcquisto` enum('Web','Cassa') NOT NULL DEFAULT 'Web',
  `TipoPagamento` enum('Contanti','Carta') DEFAULT NULL,
  `Validato` tinyint(1) DEFAULT '0',
  `idCliente` int(11) NOT NULL,
  `idAbbonamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `dataNascita` date NOT NULL,
  `sesso` enum('M','F','Und') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendente`
--

DROP TABLE IF EXISTS `dipendente`;
CREATE TABLE `dipendente` (
  `id` int(11) NOT NULL,
  `nome` varchar(25) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `stipendio` float NOT NULL,
  `dataInizio` date NOT NULL,
  `dataFine` date NOT NULL,
  `sesso` enum('M','F','Und') DEFAULT NULL,
  `dataNascita` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `gestione`
--

DROP TABLE IF EXISTS `gestione`;
CREATE TABLE `gestione` (
  `idDipendente` int(11) NOT NULL,
  `idAttrazione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `storicoabbonamento`
--

DROP TABLE IF EXISTS `storicoabbonamento`;
CREATE TABLE `storicoabbonamento` (
  `id` int(11) NOT NULL,
  `dataInizio` date NOT NULL,
  `dataFine` date NOT NULL,
  `costo` float NOT NULL,
  `ingressiRimanenti` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idtipologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia`
--

DROP TABLE IF EXISTS `tipologia`;
CREATE TABLE `tipologia` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `annoCreazione` int(4) NOT NULL,
  `costo` float NOT NULL,
  `ingressiTotali` int(11) NOT NULL,
  `durata` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `vip`
--

DROP TABLE IF EXISTS `vip`;
CREATE TABLE `vip` (
  `id` int(11) NOT NULL,
  `dataValidita` date NOT NULL,
  `dataAcquisto` date NOT NULL,
  `oraAcquisto` time NOT NULL,
  `costo` float NOT NULL,
  `accessiRimanenti` int(11) NOT NULL DEFAULT '20',
  `idBiglietto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `abbonamentoattivo`
--
ALTER TABLE `abbonamentoattivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idtipologia` (`idtipologia`);

--
-- Indici per le tabelle `accesso`
--
ALTER TABLE `accesso`
  ADD PRIMARY KEY (`idAttrazione`,`idVip`),
  ADD KEY `idVip` (`idVip`);

--
-- Indici per le tabelle `attrazione`
--
ALTER TABLE `attrazione`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `biglietto`
--
ALTER TABLE `biglietto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idAbbonamento` (`idAbbonamento`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `dipendente`
--
ALTER TABLE `dipendente`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `gestione`
--
ALTER TABLE `gestione`
  ADD PRIMARY KEY (`idDipendente`,`idAttrazione`),
  ADD KEY `idAttrazione` (`idAttrazione`);

--
-- Indici per le tabelle `storicoabbonamento`
--
ALTER TABLE `storicoabbonamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idtipologia` (`idtipologia`);

--
-- Indici per le tabelle `tipologia`
--
ALTER TABLE `tipologia`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `vip`
--
ALTER TABLE `vip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idBiglietto` (`idBiglietto`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `abbonamentoattivo`
--
ALTER TABLE `abbonamentoattivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `attrazione`
--
ALTER TABLE `attrazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `biglietto`
--
ALTER TABLE `biglietto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `dipendente`
--
ALTER TABLE `dipendente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `storicoabbonamento`
--
ALTER TABLE `storicoabbonamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tipologia`
--
ALTER TABLE `tipologia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `vip`
--
ALTER TABLE `vip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `abbonamentoattivo`
--
ALTER TABLE `abbonamentoattivo`
  ADD CONSTRAINT `abbonamentoattivo_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `abbonamentoattivo_ibfk_2` FOREIGN KEY (`idtipologia`) REFERENCES `tipologia` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `accesso`
--
ALTER TABLE `accesso`
  ADD CONSTRAINT `accesso_ibfk_1` FOREIGN KEY (`idAttrazione`) REFERENCES `attrazione` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accesso_ibfk_2` FOREIGN KEY (`idVip`) REFERENCES `vip` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `biglietto`
--
ALTER TABLE `biglietto`
  ADD CONSTRAINT `biglietto_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biglietto_ibfk_3` FOREIGN KEY (`idAbbonamento`) REFERENCES `abbonamentoattivo` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `gestione`
--
ALTER TABLE `gestione`
  ADD CONSTRAINT `gestione_ibfk_1` FOREIGN KEY (`idDipendente`) REFERENCES `dipendente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gestione_ibfk_2` FOREIGN KEY (`idAttrazione`) REFERENCES `attrazione` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `storicoabbonamento`
--
ALTER TABLE `storicoabbonamento`
  ADD CONSTRAINT `storicoabbonamento_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `storicoabbonamento_ibfk_2` FOREIGN KEY (`idtipologia`) REFERENCES `tipologia` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `vip`
--
ALTER TABLE `vip`
  ADD CONSTRAINT `vip_ibfk_1` FOREIGN KEY (`idBiglietto`) REFERENCES `biglietto` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- NT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `attrazione`
--
ALTER TABLE `attrazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `biglietto`
--
ALTER TABLE `biglietto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT per la tabella `dipendente`
--
ALTER TABLE `dipendente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `storicoabbonamento`
--
ALTER TABLE `storicoabbonamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `tipologia`
--
ALTER TABLE `tipologia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `vip`
--
ALTER TABLE `vip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Limiti per le tabelle scaricate
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
