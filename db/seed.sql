-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 22, 2020 alle 10:11
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

--
-- Dump dei dati per la tabella `tipologia`
--

INSERT INTO `tipologia` (`id`, `nome`, `annoCreazione`, `costo`, `ingressiTotali`, `durata`) VALUES
(1, 'Annuale', 2019, 120, 30, 365),
(2, 'Quadrimestrale', 2018, 40, 15, 120);
COMMIT;


--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `cognome`, `dataNascita`, `sesso`) VALUES
(1, 'Anna', 'Magnani', '1955-10-12', 'F'),
(2, 'Fabrizio', 'de Andrè', '1988-03-02', 'M'),
(3, 'Chester', 'Bennington', '1976-03-20', 'M'),
(4, 'Claudia', 'Cortellesi', '1973-11-24', 'F'),
(5, 'Alessandro ', 'Baricco', '1958-01-25', 'M'),
(6, 'Margherita', 'Hack', '1922-06-12', 'F'),
(7, 'Piergiorgio', 'Odifreddi', '1950-07-13', 'M'),
(8, 'Marie', 'Curie', '1967-11-07', 'F');

--
-- Dump dei dati per la tabella `abbonamentoattivo`
--

INSERT INTO `abbonamentoattivo` (`id`, `dataInizio`, `dataFine`, `ingressiRimanenti`, `idCliente`, `idtipologia`) VALUES
(1, '2020-01-02', '2020-12-31', 2, 5, 1),
(2, '2020-01-13', '2020-12-31', 27, 2, 1),
(3, '2020-01-21', '2020-05-21', 14, 8, 2);

--
-- Dump dei dati per la tabella `attrazione`
--

INSERT INTO `attrazione` (`id`, `nome`, `tipologia`, `longitudine`, `latitudine`, `maxPosti`, `etaMin`, `altezzaMin`, `orari`) VALUES
(1, 'Katoon', 'Giostra', 42.5438, 37.8746, 45, 13, 150, NULL),
(2, 'Sotto il mare', 'Spettacolo', 42.5438, 37.8746, 250, NULL, NULL, '00:00:00'),
(3, 'Gold River', 'Giostra', 42.5438, 37.8746, 51, 12, 145, NULL),
(4, 'I pirati dei Caraibi', 'Spettacolo', 42.5438, 37.8746, 300, NULL, NULL, '10:30:00'),
(5, 'Divertical', 'Giostra', 42.5438, 37.8746, 57, 15, 135, NULL),
(6, 'The Truman Show', 'Spettacolo', 42.5438, 37.8746, 350, NULL, NULL, '17:00:00');


--
-- Dump dei dati per la tabella `dipendente`
--

INSERT INTO `dipendente` (`id`, `nome`, `cognome`, `stipendio`, `dataInizio`, `dataFine`, `sesso`, `dataNascita`) VALUES
(1, 'Stella ', 'De Giosa', 1200, '2017-10-16', '2019-10-16', 'F', '1955-10-12'),
(2, 'Claudia', 'Donati', 900, '2019-10-09', '2020-10-09', 'F', '1999-02-04'),
(3, 'Antonio', 'Caputo', 1000, '2019-07-01', '2020-07-01', 'M', '1978-10-08'),
(4, 'Lucia', 'Cippone', 1500, '2018-12-12', '2021-12-13', 'F', '1988-12-12'),
(5, 'Giuseppe', 'Ucci', 1200, '2019-05-14', '2021-05-14', 'M', '1993-07-29');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
