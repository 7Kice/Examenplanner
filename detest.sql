-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 sep 2022 om 17:07
-- Serverversie: 10.4.22-MariaDB
-- PHP-versie: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `detest`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `detest`
--

CREATE TABLE `detest` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `klas` varchar(100) DEFAULT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `crebo` varchar(255) DEFAULT NULL,
  `kwalificatie` varchar(255) DEFAULT NULL,
  `cohort` varchar(255) DEFAULT NULL,
  `benamingeenheid` varchar(255) DEFAULT NULL,
  `codeeenheid` varchar(255) DEFAULT NULL,
  `afnamevorm` varchar(255) DEFAULT NULL,
  `tijd` varchar(255) DEFAULT NULL,
  `duur` varchar(255) DEFAULT NULL,
  `beoordelaar` varchar(255) DEFAULT NULL,
  `leverancier` varchar(255) DEFAULT NULL,
  `toezicht` varchar(255) DEFAULT NULL,
  `aantal` varchar(255) DEFAULT NULL,
  `studentnummer` varchar(255) DEFAULT NULL,
  `cluster` varchar(255) DEFAULT NULL,
  `versie` varchar(255) DEFAULT NULL,
  `locatie` varchar(255) DEFAULT NULL,
  `opmerking` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `detest`
--

INSERT INTO `detest` (`id`, `title`, `description`, `url`, `klas`, `start`, `end`, `crebo`, `kwalificatie`, `cohort`, `benamingeenheid`, `codeeenheid`, `afnamevorm`, `tijd`, `duur`, `beoordelaar`, `leverancier`, `toezicht`, `aantal`, `studentnummer`, `cluster`, `versie`, `locatie`, `opmerking`) VALUES
(87, 'toets2', 'asd', 'https://www.google.com/', '', '2022-09-30', '2022-10-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'veigar', '$2y$10$qTX6frCG526ahIhzmtyKPelZhuAnpyyC1PVioXpbM3fzMkFur4d7u', '2022-09-29 09:31:20'),
(2, 'account3', '$2y$10$F6OQkuNsXt6z2T3PtwIDCOqImHjo1ALy9y0dFEInu/u2ko8pnlZCK', '2022-09-30 16:11:37');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `detest`
--
ALTER TABLE `detest`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `detest`
--
ALTER TABLE `detest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
