-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2022 at 11:24 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baza_bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bioskop`
--

CREATE TABLE `bioskop` (
  `id` bigint(20) NOT NULL,
  `naziv` varchar(50) DEFAULT NULL,
  `adresa` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bioskop`
--

INSERT INTO `bioskop` (`id`, `naziv`, `adresa`) VALUES
(1, 'Ušće', 'Bulevar Mihajla Pupina 4'),
(3, 'Delta', 'Jurija Gagarina 16'),
(11, 'Galerija', 'Bulevar Vudroa Vilsona 12');

-- --------------------------------------------------------

--
-- Table structure for table `bioskop_film`
--

CREATE TABLE `bioskop_film` (
  `bioskop` bigint(20) NOT NULL,
  `film` bigint(20) NOT NULL,
  `broj_projekcija` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bioskop_film`
--

INSERT INTO `bioskop_film` (`bioskop`, `film`, `broj_projekcija`) VALUES
(1, 3, 25),
(1, 4, 15),
(1, 5, 30),
(1, 13, 60),
(1, 15, 50),
(3, 3, 78),
(3, 4, 20),
(3, 5, 35),
(3, 13, 50),
(11, 3, 40),
(11, 13, 50),
(11, 15, 30);

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` bigint(20) NOT NULL,
  `kategorija` bigint(20) DEFAULT NULL,
  `naziv` varchar(40) DEFAULT NULL,
  `broj_minuta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `kategorija`, `naziv`, `broj_minuta`) VALUES
(3, 1, 'Interstellar', 180),
(4, 5, 'Toy Story', 90),
(5, 4, 'The Shining', 100),
(13, 3, 'Batman   ', 120),
(15, 2, 'Crazy Stupid Love  ', 118);

-- --------------------------------------------------------

--
-- Table structure for table `kategorija_filma`
--

CREATE TABLE `kategorija_filma` (
  `id` bigint(20) NOT NULL,
  `naziv` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategorija_filma`
--

INSERT INTO `kategorija_filma` (`id`, `naziv`) VALUES
(1, 'sci-fi'),
(2, 'romantični'),
(3, 'akcija'),
(4, 'horor'),
(5, 'za decu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bioskop`
--
ALTER TABLE `bioskop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bioskop_film`
--
ALTER TABLE `bioskop_film`
  ADD PRIMARY KEY (`bioskop`,`film`),
  ADD KEY `knjiga` (`film`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategorija` (`kategorija`);

--
-- Indexes for table `kategorija_filma`
--
ALTER TABLE `kategorija_filma`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bioskop`
--
ALTER TABLE `bioskop`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kategorija_filma`
--
ALTER TABLE `kategorija_filma`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bioskop_film`
--
ALTER TABLE `bioskop_film`
  ADD CONSTRAINT `bioskop_film_ibfk_1` FOREIGN KEY (`bioskop`) REFERENCES `bioskop` (`id`),
  ADD CONSTRAINT `bioskop_film_ibfk_2` FOREIGN KEY (`film`) REFERENCES `film` (`id`);

--
-- Constraints for table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_ibfk_1` FOREIGN KEY (`kategorija`) REFERENCES `kategorija_filma` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
