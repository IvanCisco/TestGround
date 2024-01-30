-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 28, 2024 alle 19:12
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
-- Database: `ProvaDB`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquirente`
--

CREATE TABLE `acquirente` (
  `mail` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `datareg` date NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `istruzioni` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `acquirente`
--

INSERT INTO `acquirente` (`mail`, `password`, `nome`, `cognome`, `datareg`, `telefono`, `istruzioni`) VALUES
('asino@gmail.com', 'pass', 'Asino', 'CheVola', '2024-01-25', '9595959958', 'Veloci con le consegne'),
('laura.bianchi@esempio.com', 'segreto456', 'Laura', 'Bianchi', '2023-03-22', '3479876543', 'Consegna rapida.'),
('mail@gmail.com', 'pass', 'Nuovo', 'Utente', '2024-01-08', '3940320292', NULL),
('mailsupreme@gmail.com', '', 'Ivan', 'Munoz', '2024-01-08', '3848302020', NULL),
('mario.rossi@esempio.com', 'pass123', 'Mario', 'Rossi', '2023-05-10', '3331122334', 'Lasciare alla portineria.'),
('nuovio@gmail.com', 'pass', 'NoviPam', 'Pem', '2024-01-25', '4849498494', NULL),
('sati@gmail.com', 'pass', 'Noi3378', '28484', '2024-01-25', '3317995304', NULL);

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
('Carbonara', 'Carbonara'),
('Margherita', 'Margherita');

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
('giulia.rossi@esempio.com', '2023-11-11', '18:45:00'),
('giulia.rossi@esempio.com', '2024-01-20', '18:24:45'),
('luca.verdi@esempio.com', '2023-11-10', '12:30:00');

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
('Carbonara', 'ristorante2@esempio.com', '2023-11-11', '18:45:00'),
('Carbonara', 'ristorante2@esempio.com', '2024-01-20', '18:24:45'),
('Margherita', 'ristorante1@esempio.com', '2023-11-10', '12:30:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `domicilio`
--

CREATE TABLE `domicilio` (
  `mailacq` varchar(40) NOT NULL,
  `via` char(25) NOT NULL,
  `numero` int(11) NOT NULL,
  `cap` int(11) NOT NULL,
  `citta` enum('Milano','Roma','Palermo','Torino','Cagliari','Trento') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `domicilio`
--

INSERT INTO `domicilio` (`mailacq`, `via`, `numero`, `cap`, `citta`) VALUES
('asino@gmail.com', 'Via Delle Vie', 7, 72, 'Trento'),
('laura.bianchi@esempio.com', 'Via Tal dei Tali', 5, 184, 'Roma'),
('mail@gmail.com', 'Via LeMani Dal Culo', 39, 20292, 'Torino'),
('mailsupreme@gmail.com', 'Via Seli', 930, 34920, 'Palermo'),
('mario.rossi@esempio.com', 'Via Roma', 10, 20121, 'Milano'),
('nuovio@gmail.com', 'Via Tale', 28, 22, 'Palermo'),
('sati@gmail.com', 'Via Tal Dei Tali', 383, 0, 'Roma');

-- --------------------------------------------------------

--
-- Struttura della tabella `effettua`
--

CREATE TABLE `effettua` (
  `mailacq` varchar(40) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `stato` enum('in preparazione','in consegna','consegnato') NOT NULL,
  `metodopagamento` enum('contanti','carta') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `effettua`
--

INSERT INTO `effettua` (`mailacq`, `data`, `ora`, `stato`, `metodopagamento`) VALUES
('laura.bianchi@esempio.com', '2023-11-11', '18:45:00', 'in consegna', 'carta'),
('mario.rossi@esempio.com', '2023-11-10', '12:30:00', 'in preparazione', 'contanti');

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
  `citta` enum('Milano','Roma','Palermo','Torino','Cagliari','Trento') NOT NULL,
  `disponibilita` enum('s','n') NOT NULL,
  `credito` float(4,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `fattorino`
--

INSERT INTO `fattorino` (`mail`, `password`, `nome`, `cognome`, `sesso`, `datanascita`, `luogonascita`, `citta`, `disponibilita`, `credito`) VALUES
('giulia.rossi@esempio.com', 'segreto456', 'Giulia', 'Rossi', 'F', '1998-03-25', 'Roma', 'Roma', 'n', 9.75),
('luca.verdi@esempio.com', 'pass123', 'Luca', 'Verdi', 'M', '1995-08-18', 'Napoli', 'Milano', 's', 12.50),
('rider@gmail.com', 'pass', 'Gine', 'Der', 'NB', '2012-05-06', 'nb', 'Torino', 's', 0.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `flavorasu`
--

CREATE TABLE `flavorasu` (
  `mailfatt` varchar(40) NOT NULL,
  `giorno` enum('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica') NOT NULL,
  `orainizio` time NOT NULL,
  `orafine` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `flavorasu`
--

INSERT INTO `flavorasu` (`mailfatt`, `giorno`, `orainizio`, `orafine`) VALUES
('giulia.rossi@esempio.com', 'Martedì', '10:30:00', '18:30:00'),
('luca.verdi@esempio.com', 'Lunedì', '08:00:00', '14:00:00'),
('rider@gmail.com', 'Lunedì', '04:00:00', '13:00:00'),
('rider@gmail.com', 'Lunedì', '21:00:00', '22:00:00'),
('rider@gmail.com', 'Martedì', '01:00:00', '13:00:00'),
('rider@gmail.com', 'Venerdì', '10:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `fornisce`
--

CREATE TABLE `fornisce` (
  `mailrist` varchar(40) NOT NULL,
  `nomepiet` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `location`
--

CREATE TABLE `location` (
  `mailrist` varchar(40) NOT NULL,
  `via` char(25) NOT NULL,
  `numero` int(11) NOT NULL,
  `cap` int(11) NOT NULL,
  `citta` enum('Milano','Roma','Palermo','Torino','Cagliari','Trento') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `location`
--

INSERT INTO `location` (`mailrist`, `via`, `numero`, `cap`, `citta`) VALUES
('mailori@gmail.com', 'Via Sei', 24, 52363, 'Palermo'),
('ristorante1@esempio.com', 'Via Venezie', 16, 38888, 'Milano'),
('ristorante2@esempio.com', 'Via Napoli', 5, 184, 'Roma'),
('setino@gmail.com', 'Via Rasi', 2, 29033, 'Roma');

-- --------------------------------------------------------

--
-- Struttura della tabella `operainfatt`
--

CREATE TABLE `operainfatt` (
  `mailfatt` varchar(40) NOT NULL,
  `numero` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `operainfatt`
--

INSERT INTO `operainfatt` (`mailfatt`, `numero`) VALUES
('giulia.rossi@esempio.com', '2'),
('luca.verdi@esempio.com', '1'),
('rider@gmail.com', '3');

-- --------------------------------------------------------

--
-- Struttura della tabella `operainrist`
--

CREATE TABLE `operainrist` (
  `mailrist` varchar(40) NOT NULL,
  `zona` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `operainrist`
--

INSERT INTO `operainrist` (`mailrist`, `zona`) VALUES
('mailori@gmail.com', '4'),
('ristorante1@esempio.com', '4'),
('ristorante2@esempio.com', '4'),
('setino@gmail.com', '4');

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `stato` enum('in preparazione','in consegna','consegnato','preso in carico') NOT NULL,
  `metodopagamento` enum('contanti','carta') NOT NULL,
  `mailacq` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`data`, `ora`, `stato`, `metodopagamento`, `mailacq`) VALUES
('2023-11-10', '12:30:00', 'in preparazione', 'contanti', 'mario.rossi@esempio.com'),
('2023-11-11', '18:45:00', 'in consegna', 'carta', 'laura.bianchi@esempio.com'),
('2024-01-20', '18:24:45', '', 'contanti', 'laura.bianchi@esempio.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `pietanza`
--

CREATE TABLE `pietanza` (
  `nome` varchar(30) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `prezzo` decimal(5,2) NOT NULL,
  `descrizione` char(100) NOT NULL,
  `tipo` enum('menu','piatto') NOT NULL,
  `elenco` varchar(100) DEFAULT NULL,
  `immagine` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `pietanza`
--

INSERT INTO `pietanza` (`nome`, `mail`, `prezzo`, `descrizione`, `tipo`, `elenco`, `immagine`) VALUES
('Carbonara', 'ristorante2@esempio.com', 12.00, 'Pasta con uovo, guanciale e pecorino', 'piatto', NULL, NULL),
('Margherita', 'ristorante1@esempio.com', 8.50, 'Pizza con mozzarella e pomodoro', 'piatto', NULL, NULL),
('Menu Apocalittico', 'ristorante1@esempio.com', 21.00, 'Menu Catastrofico', 'menu', 'Margherita, Salsicce Fritte', NULL),
('piatto', 'ristorante1@esempio.com', 4.00, 'bellio', 'piatto', NULL, '../immagini/ristorante1esempiocom_piatto.png'),
('Salsicce Fritte', 'ristorante1@esempio.com', 14.00, 'Salsicce fritte', 'piatto', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `ristorante`
--

CREATE TABLE `ristorante` (
  `mail` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL,
  `partitaiva` varchar(11) NOT NULL,
  `nome` char(30) NOT NULL,
  `ragsoc` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ristorante`
--

INSERT INTO `ristorante` (`mail`, `password`, `partitaiva`, `nome`, `ragsoc`) VALUES
('mailori@gmail.com', 'pass', '38262626266', 'No', 'Raggia'),
('ristorante1@esempio.com', 'pwd123', '12345678901', 'La Trattoria', 'Simba la'),
('ristorante2@esempio.com', 'pass456', '98765432109', 'Pizzeria Napoli', 'Pizzeria di Roma'),
('setino@gmail.com', 'pass', '93930022222', 'Lorico', 'Raggio');

-- --------------------------------------------------------

--
-- Struttura della tabella `rlavorasu`
--

CREATE TABLE `rlavorasu` (
  `mailrist` varchar(40) NOT NULL,
  `giorno` enum('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica') NOT NULL,
  `orainizio` time NOT NULL,
  `orafine` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `rlavorasu`
--

INSERT INTO `rlavorasu` (`mailrist`, `giorno`, `orainizio`, `orafine`) VALUES
('mailori@gmail.com', 'Lunedì', '01:00:00', '03:00:00'),
('mailori@gmail.com', 'Martedì', '02:00:00', '05:00:00'),
('mailori@gmail.com', 'Giovedì', '07:00:00', '19:00:00'),
('ristorante1@esempio.com', 'Lunedì', '02:00:00', '11:00:00'),
('ristorante1@esempio.com', 'Lunedì', '08:00:00', '23:00:00'),
('ristorante1@esempio.com', 'Martedì', '01:00:00', '14:00:00'),
('ristorante1@esempio.com', 'Martedì', '20:00:00', '22:00:00'),
('ristorante1@esempio.com', 'Giovedì', '01:15:00', '09:00:00'),
('ristorante2@esempio.com', 'Martedì', '08:30:00', '22:30:00'),
('setino@gmail.com', 'Lunedì', '03:00:00', '07:00:00'),
('setino@gmail.com', 'Martedì', '01:00:00', '08:00:00'),
('setino@gmail.com', 'Mercoledì', '08:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `sedelegale`
--

CREATE TABLE `sedelegale` (
  `mailrist` varchar(40) NOT NULL,
  `via` char(25) NOT NULL,
  `numero` int(11) NOT NULL,
  `cap` int(11) NOT NULL,
  `citta` enum('Milano','Roma','Palermo','Torino','Cagliari','Trento') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `sedelegale`
--

INSERT INTO `sedelegale` (`mailrist`, `via`, `numero`, `cap`, `citta`) VALUES
('mailori@gmail.com', 'Via B', 2, 25252, 'Palermo'),
('ristorante1@esempio.com', 'Via le mani', 395, 38484, 'Trento'),
('ristorante2@esempio.com', 'Via Garibaldi', 30, 100, 'Roma'),
('setino@gmail.com', 'Via Kioto', 2, 38811, 'Roma');

-- --------------------------------------------------------

--
-- Struttura della tabella `turno`
--

CREATE TABLE `turno` (
  `giorno` enum('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica') NOT NULL,
  `orainizio` time NOT NULL,
  `orafine` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `turno`
--

INSERT INTO `turno` (`giorno`, `orainizio`, `orafine`) VALUES
('Lunedì', '08:00:00', '14:00:00'),
('Lunedì', '08:00:00', '23:00:00'),
('Martedì', '08:30:00', '22:30:00'),
('Martedì', '10:30:00', '18:30:00');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquirente`
--
ALTER TABLE `acquirente`
  ADD PRIMARY KEY (`mail`);

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
-- Indici per le tabelle `domicilio`
--
ALTER TABLE `domicilio`
  ADD PRIMARY KEY (`mailacq`,`via`,`numero`,`cap`,`citta`),
  ADD KEY `via` (`via`,`numero`,`cap`,`citta`);

--
-- Indici per le tabelle `effettua`
--
ALTER TABLE `effettua`
  ADD PRIMARY KEY (`mailacq`,`data`,`ora`),
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
  ADD PRIMARY KEY (`mailfatt`,`giorno`,`orainizio`,`orafine`),
  ADD KEY `giorno` (`giorno`,`orainizio`,`orafine`);

--
-- Indici per le tabelle `fornisce`
--
ALTER TABLE `fornisce`
  ADD PRIMARY KEY (`mailrist`,`nomepiet`),
  ADD KEY `nomepiet` (`nomepiet`);

--
-- Indici per le tabelle `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`mailrist`,`via`,`numero`,`cap`,`citta`),
  ADD KEY `via` (`via`,`numero`,`cap`,`citta`);

--
-- Indici per le tabelle `operainfatt`
--
ALTER TABLE `operainfatt`
  ADD PRIMARY KEY (`mailfatt`,`numero`),
  ADD KEY `numero` (`numero`);

--
-- Indici per le tabelle `operainrist`
--
ALTER TABLE `operainrist`
  ADD PRIMARY KEY (`mailrist`,`zona`),
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
  ADD UNIQUE KEY `partitaiva` (`partitaiva`);

--
-- Indici per le tabelle `rlavorasu`
--
ALTER TABLE `rlavorasu`
  ADD PRIMARY KEY (`mailrist`,`giorno`,`orainizio`,`orafine`),
  ADD KEY `giorno` (`giorno`,`orainizio`,`orafine`);

--
-- Indici per le tabelle `sedelegale`
--
ALTER TABLE `sedelegale`
  ADD PRIMARY KEY (`mailrist`,`via`,`numero`,`cap`,`citta`),
  ADD KEY `via` (`via`,`numero`,`cap`,`citta`);

--
-- Indici per le tabelle `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`giorno`,`orainizio`,`orafine`);

--
-- Limiti per le tabelle scaricate
--

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
-- Limiti per la tabella `domicilio`
--
ALTER TABLE `domicilio`
  ADD CONSTRAINT `domicilio_ibfk_1` FOREIGN KEY (`mailacq`) REFERENCES `acquirente` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `effettua`
--
ALTER TABLE `effettua`
  ADD CONSTRAINT `effettua_ibfk_1` FOREIGN KEY (`mailacq`) REFERENCES `acquirente` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `effettua_ibfk_2` FOREIGN KEY (`data`,`ora`) REFERENCES `ordine` (`data`, `ora`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `flavorasu`
--
ALTER TABLE `flavorasu`
  ADD CONSTRAINT `flavorasu_ibfk_1` FOREIGN KEY (`mailfatt`) REFERENCES `fattorino` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `fornisce`
--
ALTER TABLE `fornisce`
  ADD CONSTRAINT `fornisce_ibfk_1` FOREIGN KEY (`mailrist`) REFERENCES `ristorante` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fornisce_ibfk_2` FOREIGN KEY (`nomepiet`) REFERENCES `pietanza` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`mailrist`) REFERENCES `ristorante` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `operainfatt`
--
ALTER TABLE `operainfatt`
  ADD CONSTRAINT `operainfatt_ibfk_1` FOREIGN KEY (`mailfatt`) REFERENCES `fattorino` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `operainrist`
--
ALTER TABLE `operainrist`
  ADD CONSTRAINT `operainrist_ibfk_1` FOREIGN KEY (`mailrist`) REFERENCES `ristorante` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Limiti per la tabella `rlavorasu`
--
ALTER TABLE `rlavorasu`
  ADD CONSTRAINT `rlavorasu_ibfk_1` FOREIGN KEY (`mailrist`) REFERENCES `ristorante` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `sedelegale`
--
ALTER TABLE `sedelegale`
  ADD CONSTRAINT `sedelegale_ibfk_1` FOREIGN KEY (`mailrist`) REFERENCES `ristorante` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
