-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 20, 2024 alle 16:32
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `provadb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquirente`
--

CREATE TABLE `acquirente` (
  `mail` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nome` char(20) NOT NULL,
  `cognome` char(20) NOT NULL,
  `datareg` date NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `domicilio` int(11) NOT NULL,
  `istruzioni` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `acquirente`
--

INSERT INTO `acquirente` (`mail`, `password`, `nome`, `cognome`, `datareg`, `telefono`, `domicilio`, `istruzioni`) VALUES
('laura.bianchi@gmail.com', 'pass', 'Laura', 'Bianchi', '2024-02-04', '2147483647', 2, 'Lasciare alla portineria'),
('mario.rossi@gmail.com', 'pass', 'Mario', 'Rossi', '2024-02-04', '3325678391', 1, 'Veloci con le consegne');

-- --------------------------------------------------------

--
-- Struttura della tabella `compone`
--

CREATE TABLE `compone` (
  `piatto` varchar(30) NOT NULL,
  `menu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `compone`
--

INSERT INTO `compone` (`piatto`, `menu`) VALUES
('Carbonara', 'Carbonara');

-- --------------------------------------------------------

--
-- Struttura della tabella `consegna`
--

CREATE TABLE `consegna` (
  `mailfatt` varchar(40) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `consegna`
--

INSERT INTO `consegna` (`mailfatt`, `data`, `ora`) VALUES
('giulia.rossi@gmail.com', '2023-11-11', '18:45:00'),
('luca.verdi@gmail.com', '2023-11-10', '12:30:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `contiene`
--

CREATE TABLE `contiene` (
  `nome` varchar(30) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `contiene`
--

INSERT INTO `contiene` (`nome`, `mail`, `data`, `ora`) VALUES
('Carbonara', 'ristorante2@gmail.com', '2023-11-11', '18:45:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `fattorino`
--

CREATE TABLE `fattorino` (
  `mail` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nome` char(20) NOT NULL,
  `cognome` char(20) NOT NULL,
  `sesso` enum('M','F','NB') NOT NULL,
  `datanascita` date NOT NULL,
  `luogonascita` char(25) NOT NULL,
  `citta` enum('Milano','Roma','Palermo','Torino','Cagliari','Trento') DEFAULT NULL,
  `disponibilita` enum('S','N') NOT NULL DEFAULT 'N',
  `credito` float(4,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `fattorino`
--

INSERT INTO `fattorino` (`mail`, `password`, `nome`, `cognome`, `sesso`, `datanascita`, `luogonascita`, `citta`, `disponibilita`, `credito`) VALUES
('giulia.rossi@gmail.com', 'pass', 'Giulia', 'Rossi', 'F', '1998-03-25', 'Roma', 'Roma', 'N', 9.75),
('luca.verdi@gmail.com', 'pass', 'Lucianello', 'Verdi', 'M', '1995-08-18', 'Napoli', 'Milano', 'S', 12.50),
('riderino@gmail.com', 'pass', 'Ryder', 'Willowfield', 'F', '2000-05-12', 'Willowfield', 'Torino', 'N', 0.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `flavorasu`
--

CREATE TABLE `flavorasu` (
  `mail` varchar(40) NOT NULL,
  `turno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `flavorasu`
--

INSERT INTO `flavorasu` (`mail`, `turno`) VALUES
('luca.verdi@gmail.com', 39);

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzo`
--

CREATE TABLE `indirizzo` (
  `id` int(11) NOT NULL,
  `via` char(25) NOT NULL,
  `numero` varchar(3) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `citta` enum('Milano','Roma','Palermo','Torino','Cagliari','Trento') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `indirizzo`
--

INSERT INTO `indirizzo` (`id`, `via`, `numero`, `cap`, `citta`) VALUES
(5, 'Corso Indipendenza', '395', '38484', 'Trento'),
(9, 'Largo Murani', '30', '00218', 'Roma'),
(6, 'Largo Murani', '30', '218', 'Roma'),
(4, 'Via Napoli', '5', '40144', 'Milano'),
(1, 'Via Roma', '10', '20121', 'Milano'),
(2, 'Via Tal Dei Tali', '5', '301', 'Roma'),
(3, 'Via Venezia', '16', '38888', 'Milano');

-- --------------------------------------------------------

--
-- Struttura della tabella `operainfatt`
--

CREATE TABLE `operainfatt` (
  `mail` varchar(40) NOT NULL,
  `zona` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `operainfatt`
--

INSERT INTO `operainfatt` (`mail`, `zona`) VALUES
('giulia.rossi@gmail.com', '2'),
('luca.verdi@gmail.com', '1'),
('luca.verdi@gmail.com', '2'),
('riderino@gmail.com', '1'),
('riderino@gmail.com', '4'),
('riderino@gmail.com', '5');

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `stato` enum('in preparazione','preso in carico','in consegna','consegnato') NOT NULL,
  `metodopagamento` enum('contanti','carta') NOT NULL,
  `mailacq` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`data`, `ora`, `stato`, `metodopagamento`, `mailacq`) VALUES
('2023-11-10', '12:30:00', 'in preparazione', 'contanti', 'mario.rossi@gmail.com'),
('2023-11-11', '18:45:00', 'consegnato', 'carta', 'laura.bianchi@gmail.com'),
('2024-02-15', '18:02:12', 'in preparazione', 'carta', 'mario.rossi@gmail.com'),
('2024-02-15', '22:14:14', 'in preparazione', 'contanti', 'mario.rossi@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `pietanza`
--

CREATE TABLE `pietanza` (
  `nome` varchar(30) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `prezzo` float(4,2) NOT NULL,
  `descrizione` tinytext NOT NULL,
  `tipo` enum('menu','piatto') NOT NULL,
  `elenco` tinytext DEFAULT NULL,
  `immagine` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `pietanza`
--

INSERT INTO `pietanza` (`nome`, `mail`, `prezzo`, `descrizione`, `tipo`, `elenco`, `immagine`) VALUES
('Bellio', 'ristorante1@gmail.com', 14.50, 'Stratosf', 'piatto', NULL, '../immagini/ristorante1gmailcom_Bellio.png'),
('Carbonara', 'ristorante2@gmail.com', 12.00, 'Spaghetti con uova, guanciale e pecorino', 'piatto', NULL, NULL),
('One', 'ristorante1@gmail.com', 12.90, 'settimo', 'piatto', NULL, '../immagini/ristorante1gmailcom_One.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `ristorante`
--

CREATE TABLE `ristorante` (
  `mail` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL,
  `partitaiva` varchar(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `ragsoc` char(20) NOT NULL,
  `location` int(11) NOT NULL,
  `sedelegale` int(11) NOT NULL,
  `zona` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ristorante`
--

INSERT INTO `ristorante` (`mail`, `password`, `partitaiva`, `nome`, `ragsoc`, `location`, `sedelegale`, `zona`) VALUES
('ristorante1@gmail.com', 'pass', '2147483647', 'La Trattoria', 'Raggiano', 3, 5, '1'),
('ristorante2@gmail.com', 'pass', '57382958372', 'Pizzeria Napoli', 'Ragione in tutto', 4, 6, '1');

-- --------------------------------------------------------

--
-- Struttura della tabella `rlavorasu`
--

CREATE TABLE `rlavorasu` (
  `mail` varchar(40) NOT NULL,
  `turno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `rlavorasu`
--

INSERT INTO `rlavorasu` (`mail`, `turno`) VALUES
('ristorante1@gmail.com', 37),
('ristorante2@gmail.com', 35);

-- --------------------------------------------------------

--
-- Struttura della tabella `turno`
--

CREATE TABLE `turno` (
  `id` int(11) NOT NULL,
  `giorno` enum('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica') NOT NULL,
  `orainizio` time NOT NULL,
  `orafine` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `turno`
--

INSERT INTO `turno` (`id`, `giorno`, `orainizio`, `orafine`) VALUES
(1, 'Lunedì', '00:00:00', '00:00:00'),
(2, 'Lunedì', '00:00:00', '00:05:00'),
(3, 'Lunedì', '00:00:00', '00:10:00'),
(4, 'Lunedì', '00:00:00', '00:15:00'),
(5, 'Lunedì', '00:00:00', '00:20:00'),
(6, 'Lunedì', '00:00:00', '00:25:00'),
(7, 'Lunedì', '00:00:00', '00:30:00'),
(8, 'Lunedì', '00:00:00', '00:35:00'),
(9, 'Lunedì', '00:00:00', '00:40:00'),
(10, 'Lunedì', '00:00:00', '00:45:00'),
(11, 'Lunedì', '00:00:00', '00:50:00'),
(12, 'Lunedì', '00:00:00', '00:55:00'),
(13, 'Lunedì', '00:00:00', '01:00:00'),
(33, 'Lunedì', '07:00:00', '14:00:00'),
(38, 'Lunedì', '12:00:00', '14:00:00'),
(30, 'Martedì', '04:00:00', '07:10:00'),
(36, 'Martedì', '04:00:00', '15:00:00'),
(39, 'Martedì', '09:00:00', '16:30:00'),
(20, 'Martedì', '09:00:00', '18:00:00'),
(34, 'Martedì', '12:00:00', '15:00:00'),
(31, 'Mercoledì', '06:20:00', '12:45:00'),
(21, 'Mercoledì', '09:00:00', '18:00:00'),
(37, 'Giovedì', '01:05:00', '20:10:00'),
(29, 'Giovedì', '06:20:00', '18:55:00'),
(35, 'Giovedì', '10:00:00', '23:00:00'),
(22, 'Giovedì', '11:00:00', '23:00:00'),
(32, 'Sabato', '10:00:00', '23:30:00'),
(18, 'Sabato', '11:00:00', '15:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `zona`
--

CREATE TABLE `zona` (
  `numero` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `zona`
--

INSERT INTO `zona` (`numero`) VALUES
('1'),
('2'),
('3'),
('4'),
('5');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquirente`
--
ALTER TABLE `acquirente`
  ADD PRIMARY KEY (`mail`),
  ADD KEY `domicilio` (`domicilio`);

--
-- Indici per le tabelle `compone`
--
ALTER TABLE `compone`
  ADD PRIMARY KEY (`piatto`,`menu`),
  ADD KEY `menu` (`menu`);

--
-- Indici per le tabelle `consegna`
--
ALTER TABLE `consegna`
  ADD PRIMARY KEY (`mailfatt`,`data`,`ora`),
  ADD KEY `data` (`data`,`ora`);

--
-- Indici per le tabelle `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`nome`,`mail`,`data`,`ora`),
  ADD KEY `data` (`data`,`ora`);

--
-- Indici per le tabelle `fattorino`
--
ALTER TABLE `fattorino`
  ADD PRIMARY KEY (`mail`);

--
-- Indici per le tabelle `flavorasu`
--
ALTER TABLE `flavorasu`
  ADD PRIMARY KEY (`mail`,`turno`),
  ADD KEY `turno` (`turno`);

--
-- Indici per le tabelle `indirizzo`
--
ALTER TABLE `indirizzo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `via` (`via`,`numero`,`cap`,`citta`);

--
-- Indici per le tabelle `operainfatt`
--
ALTER TABLE `operainfatt`
  ADD PRIMARY KEY (`mail`,`zona`),
  ADD KEY `zona` (`zona`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`data`,`ora`),
  ADD KEY `mailacq` (`mailacq`);

--
-- Indici per le tabelle `pietanza`
--
ALTER TABLE `pietanza`
  ADD PRIMARY KEY (`nome`,`mail`),
  ADD KEY `mail` (`mail`);

--
-- Indici per le tabelle `ristorante`
--
ALTER TABLE `ristorante`
  ADD PRIMARY KEY (`mail`),
  ADD UNIQUE KEY `partitaiva` (`partitaiva`),
  ADD KEY `ristorante_ibfk_1` (`location`),
  ADD KEY `ristorante_ibfk_2` (`sedelegale`),
  ADD KEY `zona` (`zona`);

--
-- Indici per le tabelle `rlavorasu`
--
ALTER TABLE `rlavorasu`
  ADD PRIMARY KEY (`mail`,`turno`),
  ADD KEY `turno` (`turno`);

--
-- Indici per le tabelle `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `giorno` (`giorno`,`orainizio`,`orafine`);

--
-- Indici per le tabelle `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`numero`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `indirizzo`
--
ALTER TABLE `indirizzo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT per la tabella `turno`
--
ALTER TABLE `turno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquirente`
--
ALTER TABLE `acquirente`
  ADD CONSTRAINT `acquirente_ibfk_1` FOREIGN KEY (`domicilio`) REFERENCES `indirizzo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `compone`
--
ALTER TABLE `compone`
  ADD CONSTRAINT `compone_ibfk_1` FOREIGN KEY (`piatto`) REFERENCES `pietanza` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compone_ibfk_2` FOREIGN KEY (`menu`) REFERENCES `pietanza` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `consegna`
--
ALTER TABLE `consegna`
  ADD CONSTRAINT `consegna_ibfk_1` FOREIGN KEY (`mailfatt`) REFERENCES `fattorino` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consegna_ibfk_2` FOREIGN KEY (`data`,`ora`) REFERENCES `ordine` (`data`, `ora`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`nome`,`mail`) REFERENCES `pietanza` (`nome`, `mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`data`,`ora`) REFERENCES `ordine` (`data`, `ora`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `flavorasu`
--
ALTER TABLE `flavorasu`
  ADD CONSTRAINT `flavorasu_ibfk_1` FOREIGN KEY (`mail`) REFERENCES `fattorino` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flavorasu_ibfk_2` FOREIGN KEY (`turno`) REFERENCES `turno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `operainfatt`
--
ALTER TABLE `operainfatt`
  ADD CONSTRAINT `operainfatt_ibfk_1` FOREIGN KEY (`mail`) REFERENCES `fattorino` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `operainfatt_ibfk_2` FOREIGN KEY (`zona`) REFERENCES `zona` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`mailacq`) REFERENCES `acquirente` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `pietanza`
--
ALTER TABLE `pietanza`
  ADD CONSTRAINT `pietanza_ibfk_1` FOREIGN KEY (`mail`) REFERENCES `ristorante` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `ristorante`
--
ALTER TABLE `ristorante`
  ADD CONSTRAINT `ristorante_ibfk_1` FOREIGN KEY (`location`) REFERENCES `indirizzo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ristorante_ibfk_2` FOREIGN KEY (`sedelegale`) REFERENCES `indirizzo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ristorante_ibfk_3` FOREIGN KEY (`zona`) REFERENCES `zona` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `rlavorasu`
--
ALTER TABLE `rlavorasu`
  ADD CONSTRAINT `rlavorasu_ibfk_1` FOREIGN KEY (`mail`) REFERENCES `ristorante` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rlavorasu_ibfk_2` FOREIGN KEY (`turno`) REFERENCES `turno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
