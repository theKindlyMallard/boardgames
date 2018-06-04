-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Cze 2018, 08:47
-- Wersja serwera: 10.1.30-MariaDB
-- Wersja PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `boardgames`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `publisher` varchar(64) NOT NULL,
  `fk_type` int(11) DEFAULT NULL,
  `players_number` varchar(64) NOT NULL,
  `complexity` int(11) NOT NULL,
  `play_time` varchar(64) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `game`
--

INSERT INTO `game` (`id`, `name`, `publisher`, `fk_type`, `players_number`, `complexity`, `play_time`, `description`, `image`, `site_url`, `fk_user`) VALUES
(1, 'super gra', 'super wydawnictwo', 2, '2-4', 5, '60min - 120min', 'Fajna fajna serio fajna', 'gggggggg', 'http://www.gg.pl', 1),
(2, 'nowa', 'nowe wydawnictwo', 1, '1-2', 8, '20 -50', 'dddddddddddddddddddddd', '', 'ssss', 1),
(3, 'nowa', 'nowe wydawnictwo', 1, '1-2', 8, '20 -50', 'dddddddddddddddddddddd', '', 'ssss', 1),
(4, 'nowa', 'nowe wydawnictwo', 2, '1-2', 4, '20 -50', 'weasd', '', 'ssssd', 1),
(5, 'nowa', 'nowe wydawnictwo', 2, '1-2', 3, '20 -50', 'dsada', '', 'ssss', 1),
(6, 'nowa666', 'nowe wydawnictwo666', 3, '2-5', 10, '15 - 100', 'jaa ja ja', '', 'https://www.w3schools.com', 1),
(7, 'nowa', 'nowe wydawnictwo', 2, '2-5', 1, '20 -50', 'ssas', 'C:xampphtdocsoardgamespublicimggameewok.jpg', 'ssssd', 1),
(8, 'fajna', 'rebelka', 1, '1-2', 7, '15 - 100', 'ddddd', '', 'https://www.w3schools.com', 1),
(9, 'nowa666', 'nowe wydawnictwo444', 2, '2-5', 3, '20 -50', 'de', 'public\\img\\game\\icon-mallard.png', 'ssssd', 1),
(10, 'fajna', 'rebelka', 4, '1-2', 2, '15 - 100', 'hihihi', 'public\\img\\game\\addingReminderGoogleCalendar.PNG', 'https://www.w3schools.com', 1),
(11, 'nowa2', 'nowe wydawnictwo2', 2, '2', 2, '20 -200', 'dwadwadwa', 'public\\img\\game\\legologo.jpg', 'ddddddddddw2', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `game_type`
--

CREATE TABLE `game_type` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `game_type`
--

INSERT INTO `game_type` (`id`, `name`) VALUES
(1, 'cooperation'),
(2, 'economical'),
(3, 'rpg'),
(4, 'cards');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `full_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `full_name`) VALUES
(1, 'q', 'pa', 'dupa');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_game_game_type` (`fk_type`),
  ADD KEY `fk_game_user` (`fk_user`);

--
-- Indexes for table `game_type`
--
ALTER TABLE `game_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `game_type`
--
ALTER TABLE `game_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `fk_game_game_type` FOREIGN KEY (`fk_type`) REFERENCES `game_type` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_game_user` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
