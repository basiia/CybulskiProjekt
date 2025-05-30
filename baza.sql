-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 02:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `komis_samochodowy`
--

-- --------------------------------------------------------

--
-- Table structure for table `historiaprzegladow`
--

CREATE TABLE `historiaprzegladow` (
  `id_przegladu` int(11) NOT NULL,
  `id_pojazdu` int(11) NOT NULL,
  `data_przegladu` date NOT NULL,
  `przebieg` int(11) NOT NULL,
  `wynik` enum('Pozytywny','Negatywny') NOT NULL,
  `uwagi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historiaprzegladow`
--

INSERT INTO `historiaprzegladow` (`id_przegladu`, `id_pojazdu`, `data_przegladu`, `przebieg`, `wynik`, `uwagi`) VALUES
(1, 1, '2023-01-15', 120000, 'Pozytywny', 'Brak uwag.'),
(2, 2, '2023-02-10', 85000, 'Pozytywny', 'Zalecana wymiana klocków hamulcowych.'),
(3, 3, '2023-03-05', 97000, 'Pozytywny', NULL),
(4, 4, '2023-03-20', 103000, 'Negatywny', 'Problemy z układem wydechowym.'),
(5, 5, '2023-04-12', 110000, 'Pozytywny', 'Wymiana filtra powietrza zalecana w następnym przeglądzie.'),
(6, 6, '2023-05-03', 90000, 'Pozytywny', NULL),
(7, 7, '2023-05-22', 125000, 'Pozytywny', 'Układ hamulcowy w dobrym stanie.'),
(8, 8, '2023-06-14', 102000, 'Pozytywny', 'Brak uwag.'),
(9, 9, '2023-07-01', 115000, 'Negatywny', 'Wycieki oleju.'),
(10, 10, '2023-07-18', 108000, 'Pozytywny', 'Zalecana wymiana opon.'),
(11, 11, '2023-08-05', 98000, 'Pozytywny', NULL),
(12, 12, '2023-08-25', 112000, 'Pozytywny', 'Brak uwag.'),
(13, 13, '2023-09-10', 120000, 'Pozytywny', 'Wymiana świec zapłonowych zalecana.'),
(14, 14, '2023-09-28', 100000, 'Pozytywny', NULL),
(15, 15, '2023-10-15', 123000, 'Pozytywny', 'Układ klimatyzacji działa poprawnie.'),
(16, 16, '2023-11-02', 93000, 'Pozytywny', 'Brak uwag.'),
(17, 17, '2023-11-20', 127000, 'Pozytywny', 'Zalecana wymiana oleju w skrzyni biegów.'),
(18, 18, '2023-12-08', 109000, 'Pozytywny', NULL),
(19, 19, '2023-12-25', 118000, 'Negatywny', 'Problemy z zawieszeniem.'),
(20, 20, '2024-01-10', 105000, 'Pozytywny', 'Brak uwag.'),
(21, 21, '2024-01-28', 130000, 'Pozytywny', NULL),
(22, 22, '2024-02-15', 95000, 'Pozytywny', 'Zalecana kontrola układu hamulcowego.'),
(23, 23, '2024-03-04', 117000, 'Pozytywny', NULL),
(24, 24, '2024-03-21', 125000, 'Pozytywny', 'Brak uwag.'),
(25, 25, '2024-04-08', 113000, 'Negatywny', 'Nieszczelność układu chłodzenia.'),
(26, 26, '2024-04-26', 98000, 'Pozytywny', NULL),
(27, 27, '2024-05-14', 135000, 'Pozytywny', 'Wymiana oleju w silniku wykonana.'),
(28, 28, '2024-06-01', 102000, 'Pozytywny', 'Brak uwag.'),
(29, 29, '2024-06-18', 120000, 'Pozytywny', 'Zalecana wymiana filtrów.'),
(30, 30, '2024-07-06', 128000, 'Pozytywny', NULL),
(31, 31, '2024-07-24', 110000, 'Pozytywny', 'Brak uwag.'),
(32, 32, '2024-08-11', 94000, 'Pozytywny', 'Kontrola układu kierowniczego zalecana.'),
(33, 33, '2024-08-29', 122000, 'Pozytywny', NULL),
(34, 34, '2024-09-15', 130000, 'Pozytywny', 'Brak uwag.'),
(35, 35, '2024-10-03', 117000, 'Negatywny', 'Problemy z układem hamulcowym.'),
(36, 36, '2024-10-21', 101000, 'Pozytywny', NULL),
(37, 37, '2024-11-08', 125000, 'Pozytywny', 'Wymiana klocków hamulcowych wykonana.'),
(38, 38, '2024-11-26', 107000, 'Pozytywny', NULL),
(39, 39, '2024-12-14', 115000, 'Pozytywny', 'Brak uwag.'),
(40, 40, '2024-12-31', 90000, 'Pozytywny', 'Zalecana wymiana oleju.'),
(41, 41, '2025-01-18', 132000, 'Pozytywny', NULL),
(42, 42, '2025-02-05', 98000, 'Pozytywny', 'Brak uwag.'),
(43, 43, '2025-02-23', 118000, 'Pozytywny', 'Wymiana świec zapłonowych zalecana.'),
(44, 44, '2025-03-13', 127000, 'Negatywny', 'Problemy z zawieszeniem.'),
(45, 45, '2025-03-31', 108000, 'Pozytywny', NULL),
(46, 46, '2025-04-18', 120000, 'Pozytywny', 'Brak uwag.'),
(47, 47, '2025-05-06', 99000, 'Pozytywny', 'Kontrola układu chłodzenia.'),
(48, 48, '2025-05-24', 130000, 'Pozytywny', NULL),
(49, 49, '2025-06-11', 105000, 'Pozytywny', 'Zalecana wymiana filtra powietrza.'),
(50, 50, '2025-06-29', 115000, 'Pozytywny', NULL),
(51, 51, '2025-07-17', 125000, 'Pozytywny', 'Brak uwag.'),
(52, 52, '2025-08-04', 95000, 'Pozytywny', 'Kontrola układu hamulcowego.'),
(53, 53, '2025-08-22', 110000, 'Pozytywny', NULL),
(54, 54, '2025-09-09', 118000, 'Pozytywny', 'Zalecana wymiana oleju.'),
(55, 55, '2025-09-27', 100000, 'Negatywny', 'Problemy z układem wydechowym.'),
(56, 56, '2025-10-15', 130000, 'Pozytywny', NULL),
(57, 57, '2025-11-02', 108000, 'Pozytywny', 'Brak uwag.'),
(58, 58, '2025-11-20', 120000, 'Pozytywny', 'Wymiana świec zapłonowych wykonana.'),
(59, 59, '2025-12-08', 115000, 'Pozytywny', NULL),
(60, 60, '2025-12-26', 105000, 'Pozytywny', 'Zalecana wymiana filtrów.'),
(61, 61, '2026-01-13', 132000, 'Pozytywny', NULL),
(62, 62, '2026-01-31', 98000, 'Pozytywny', 'Brak uwag.'),
(63, 63, '2026-02-18', 120000, 'Pozytywny', 'Kontrola układu klimatyzacji.'),
(64, 64, '2026-03-07', 125000, 'Negatywny', 'Problemy z układem kierowniczym.'),
(65, 65, '2026-03-25', 110000, 'Pozytywny', NULL),
(66, 66, '2026-04-12', 115000, 'Pozytywny', 'Zalecana wymiana klocków hamulcowych.'),
(67, 67, '2026-04-30', 105000, 'Pozytywny', NULL),
(68, 68, '2026-05-18', 95000, 'Pozytywny', 'Brak uwag.'),
(69, 1, '2026-06-05', 135000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(70, 2, '2026-06-23', 100000, 'Pozytywny', NULL),
(71, 3, '2026-07-11', 125000, 'Pozytywny', 'Brak uwag.'),
(72, 4, '2026-07-29', 130000, 'Pozytywny', 'Zalecana wymiana filtrów.'),
(73, 5, '2026-08-16', 115000, 'Negatywny', 'Problemy z układem hamulcowym.'),
(74, 6, '2026-09-03', 105000, 'Pozytywny', NULL),
(75, 7, '2026-09-21', 140000, 'Pozytywny', 'Brak uwag.'),
(76, 8, '2026-10-09', 110000, 'Pozytywny', 'Kontrola układu wydechowego.'),
(77, 9, '2026-10-27', 120000, 'Pozytywny', NULL),
(78, 10, '2026-11-14', 125000, 'Pozytywny', 'Zalecana wymiana świec zapłonowych.'),
(79, 11, '2026-12-02', 115000, 'Pozytywny', NULL),
(80, 12, '2026-12-20', 100000, 'Pozytywny', 'Brak uwag.'),
(81, 13, '2027-01-07', 130000, 'Pozytywny', NULL),
(82, 14, '2027-01-25', 105000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(83, 15, '2027-02-12', 120000, 'Pozytywny', NULL),
(84, 16, '2027-03-02', 125000, 'Negatywny', 'Problemy z układem kierowniczym.'),
(85, 17, '2027-03-20', 115000, 'Pozytywny', NULL),
(86, 18, '2027-04-07', 110000, 'Pozytywny', 'Zalecana wymiana klocków hamulcowych.'),
(87, 19, '2027-04-25', 105000, 'Pozytywny', NULL),
(88, 20, '2027-05-13', 95000, 'Pozytywny', 'Brak uwag.'),
(89, 21, '2027-05-31', 135000, 'Pozytywny', NULL),
(90, 22, '2027-06-18', 100000, 'Pozytywny', 'Kontrola układu chłodzenia.'),
(91, 23, '2027-07-06', 125000, 'Pozytywny', NULL),
(92, 24, '2027-07-24', 130000, 'Pozytywny', 'Zalecana wymiana filtrów.'),
(93, 25, '2027-08-11', 115000, 'Pozytywny', NULL),
(94, 26, '2027-08-29', 105000, 'Pozytywny', 'Brak uwag.'),
(95, 27, '2027-09-16', 140000, 'Pozytywny', NULL),
(96, 28, '2027-10-04', 110000, 'Pozytywny', 'Kontrola układu hamulcowego.'),
(97, 29, '2027-10-22', 120000, 'Pozytywny', NULL),
(98, 30, '2027-11-09', 125000, 'Pozytywny', 'Brak uwag.'),
(99, 31, '2027-11-27', 115000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(100, 32, '2027-12-15', 100000, 'Pozytywny', NULL),
(101, 33, '2028-01-02', 130000, 'Pozytywny', 'Brak uwag.'),
(102, 34, '2028-01-20', 105000, 'Pozytywny', 'Kontrola układu kierowniczego.'),
(103, 35, '2028-02-07', 120000, 'Negatywny', 'Problemy z hamulcami.'),
(104, 36, '2028-02-25', 125000, 'Pozytywny', 'Zalecana wymiana oleju.'),
(105, 37, '2028-03-14', 115000, 'Pozytywny', 'Brak uwag.'),
(106, 38, '2028-04-01', 110000, 'Pozytywny', 'Wymiana filtrów powietrza.'),
(107, 39, '2028-04-19', 130000, 'Pozytywny', 'Kontrola układu wydechowego.'),
(108, 40, '2028-05-07', 100000, 'Pozytywny', 'Brak uwag.'),
(109, 41, '2028-05-25', 125000, 'Pozytywny', 'Zalecana wymiana klocków hamulcowych.'),
(110, 42, '2028-06-12', 115000, 'Pozytywny', 'Brak uwag.'),
(111, 43, '2028-06-30', 105000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(112, 44, '2028-07-18', 95000, 'Negatywny', 'Problemy z zawieszeniem.'),
(113, 45, '2028-08-05', 135000, 'Pozytywny', 'Brak uwag.'),
(114, 46, '2028-08-23', 120000, 'Pozytywny', 'Zalecana kontrola klimatyzacji.'),
(115, 47, '2028-09-10', 110000, 'Pozytywny', 'Brak uwag.'),
(116, 48, '2028-09-28', 125000, 'Pozytywny', 'Kontrola układu chłodzenia.'),
(117, 49, '2028-10-16', 115000, 'Pozytywny', 'Wymiana świec zapłonowych.'),
(118, 50, '2028-11-03', 100000, 'Pozytywny', 'Brak uwag.'),
(119, 51, '2028-11-21', 130000, 'Pozytywny', 'Zalecana wymiana filtrów.'),
(120, 52, '2028-12-09', 105000, 'Pozytywny', 'Brak uwag.'),
(121, 53, '2028-12-27', 115000, 'Pozytywny', 'Kontrola układu kierowniczego.'),
(122, 54, '2029-01-14', 125000, 'Pozytywny', 'Brak uwag.'),
(123, 55, '2029-02-01', 110000, 'Negatywny', 'Problemy z układem hamulcowym.'),
(124, 56, '2029-02-19', 130000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(125, 57, '2029-03-09', 115000, 'Pozytywny', 'Brak uwag.'),
(126, 58, '2029-03-27', 105000, 'Pozytywny', 'Kontrola układu wydechowego.'),
(127, 59, '2029-04-14', 125000, 'Pozytywny', 'Brak uwag.'),
(128, 60, '2029-05-02', 100000, 'Pozytywny', 'Zalecana wymiana świec zapłonowych.'),
(129, 61, '2029-05-20', 130000, 'Pozytywny', 'Brak uwag.'),
(130, 62, '2029-06-07', 115000, 'Pozytywny', 'Wymiana filtrów powietrza.'),
(131, 63, '2029-06-25', 105000, 'Pozytywny', 'Brak uwag.'),
(132, 64, '2029-07-13', 125000, 'Negatywny', 'Problemy z zawieszeniem.'),
(133, 65, '2029-07-31', 110000, 'Pozytywny', 'Zalecana kontrola układu hamulcowego.'),
(134, 66, '2029-08-18', 130000, 'Pozytywny', 'Brak uwag.'),
(135, 67, '2029-09-05', 115000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(136, 68, '2029-09-23', 100000, 'Pozytywny', 'Brak uwag.'),
(137, 1, '2029-10-11', 135000, 'Pozytywny', 'Kontrola układu klimatyzacji.'),
(138, 2, '2029-10-29', 120000, 'Pozytywny', 'Zalecana wymiana klocków hamulcowych.'),
(139, 3, '2029-11-16', 125000, 'Pozytywny', 'Brak uwag.'),
(140, 4, '2029-12-04', 110000, 'Pozytywny', 'Wymiana filtrów powietrza.'),
(141, 5, '2029-12-22', 130000, 'Pozytywny', 'Brak uwag.'),
(142, 6, '2030-01-09', 115000, 'Pozytywny', 'Kontrola układu kierowniczego.'),
(143, 7, '2030-01-27', 125000, 'Pozytywny', 'Brak uwag.'),
(144, 8, '2030-02-14', 110000, 'Pozytywny', 'Zalecana wymiana oleju.'),
(145, 9, '2030-03-04', 135000, 'Pozytywny', 'Brak uwag.'),
(146, 10, '2030-03-22', 120000, 'Pozytywny', 'Wymiana świec zapłonowych.'),
(147, 11, '2030-04-09', 125000, 'Pozytywny', 'Brak uwag.'),
(148, 12, '2030-04-27', 110000, 'Pozytywny', 'Kontrola układu hamulcowego.'),
(149, 13, '2030-05-15', 130000, 'Pozytywny', 'Brak uwag.'),
(150, 14, '2030-06-02', 115000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(151, 15, '2030-06-20', 105000, 'Pozytywny', 'Brak uwag.'),
(152, 16, '2030-07-08', 125000, 'Negatywny', 'Problemy z zawieszeniem.'),
(153, 17, '2030-07-26', 110000, 'Pozytywny', 'Kontrola układu kierowniczego.'),
(154, 18, '2030-08-13', 130000, 'Pozytywny', 'Brak uwag.'),
(155, 19, '2030-08-31', 115000, 'Pozytywny', 'Zalecana wymiana filtrów powietrza.'),
(156, 20, '2030-09-18', 100000, 'Pozytywny', 'Brak uwag.'),
(157, 21, '2030-10-06', 135000, 'Pozytywny', 'Kontrola układu klimatyzacji.'),
(158, 22, '2030-10-24', 120000, 'Pozytywny', 'Wymiana klocków hamulcowych.'),
(159, 23, '2030-11-11', 125000, 'Pozytywny', 'Brak uwag.'),
(160, 24, '2030-11-29', 110000, 'Pozytywny', 'Zalecana wymiana oleju.'),
(161, 25, '2030-12-17', 130000, 'Pozytywny', 'Brak uwag.'),
(162, 26, '2031-01-04', 115000, 'Pozytywny', 'Kontrola układu wydechowego.'),
(163, 27, '2031-01-22', 125000, 'Pozytywny', 'Brak uwag.'),
(164, 28, '2031-02-09', 110000, 'Pozytywny', 'Wymiana filtrów powietrza.'),
(165, 29, '2031-02-27', 135000, 'Pozytywny', 'Brak uwag.'),
(166, 30, '2031-03-17', 120000, 'Pozytywny', 'Kontrola układu hamulcowego.'),
(167, 31, '2031-04-04', 125000, 'Pozytywny', 'Brak uwag.'),
(168, 32, '2031-04-22', 110000, 'Pozytywny', 'Zalecana wymiana oleju.'),
(169, 33, '2031-05-10', 130000, 'Pozytywny', 'Brak uwag.'),
(170, 34, '2031-05-28', 115000, 'Pozytywny', 'Wymiana świec zapłonowych.'),
(171, 35, '2031-06-15', 105000, 'Pozytywny', 'Brak uwag.'),
(172, 36, '2031-07-03', 125000, 'Negatywny', 'Problemy z zawieszeniem.'),
(173, 37, '2031-07-21', 110000, 'Pozytywny', 'Kontrola układu kierowniczego.'),
(174, 38, '2031-08-08', 130000, 'Pozytywny', 'Brak uwag.'),
(175, 39, '2031-08-26', 115000, 'Pozytywny', 'Zalecana wymiana klocków hamulcowych.'),
(176, 40, '2031-09-13', 100000, 'Pozytywny', 'Brak uwag.'),
(177, 41, '2031-10-01', 135000, 'Pozytywny', 'Kontrola układu klimatyzacji.'),
(178, 42, '2031-10-19', 120000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(179, 43, '2031-11-06', 125000, 'Pozytywny', 'Brak uwag.'),
(180, 44, '2031-11-24', 110000, 'Pozytywny', 'Zalecana wymiana filtrów.'),
(181, 45, '2031-12-12', 130000, 'Pozytywny', 'Brak uwag.'),
(182, 46, '2032-01-01', 115000, 'Pozytywny', 'Kontrola układu wydechowego.'),
(183, 47, '2032-01-19', 125000, 'Pozytywny', 'Brak uwag.'),
(184, 48, '2032-02-06', 110000, 'Pozytywny', 'Zalecana wymiana świec zapłonowych.'),
(185, 49, '2032-02-24', 135000, 'Pozytywny', 'Brak uwag.'),
(186, 50, '2032-03-13', 120000, 'Pozytywny', 'Kontrola układu hamulcowego.'),
(187, 51, '2032-03-31', 125000, 'Pozytywny', 'Brak uwag.'),
(188, 52, '2032-04-18', 110000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(189, 53, '2032-05-06', 130000, 'Pozytywny', 'Brak uwag.'),
(190, 54, '2032-05-24', 115000, 'Pozytywny', 'Zalecana kontrola układu kierowniczego.'),
(191, 55, '2032-06-11', 105000, 'Pozytywny', 'Brak uwag.'),
(192, 56, '2032-06-29', 125000, 'Negatywny', 'Problemy z zawieszeniem.'),
(193, 57, '2032-07-17', 110000, 'Pozytywny', 'Kontrola układu klimatyzacji.'),
(194, 58, '2032-08-04', 130000, 'Pozytywny', 'Brak uwag.'),
(195, 59, '2032-08-22', 115000, 'Pozytywny', 'Wymiana filtrów powietrza.'),
(196, 60, '2032-09-09', 100000, 'Pozytywny', 'Brak uwag.'),
(197, 61, '2032-09-27', 135000, 'Pozytywny', 'Kontrola układu hamulcowego.'),
(198, 62, '2032-10-15', 120000, 'Pozytywny', 'Brak uwag.'),
(199, 63, '2032-11-02', 125000, 'Pozytywny', 'Wymiana oleju wykonana.'),
(200, 64, '2032-11-20', 110000, 'Pozytywny', 'Brak uwag.');

-- --------------------------------------------------------

--
-- Table structure for table `historiaserwisowa`
--

CREATE TABLE `historiaserwisowa` (
  `id_historia` int(11) NOT NULL,
  `id_pojazdu` int(11) NOT NULL,
  `data_serwisu` date NOT NULL,
  `opis` text NOT NULL,
  `koszt` decimal(10,2) DEFAULT NULL,
  `odpowiedzialny_serwis` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historiaserwisowa`
--

INSERT INTO `historiaserwisowa` (`id_historia`, `id_pojazdu`, `data_serwisu`, `opis`, `koszt`, `odpowiedzialny_serwis`) VALUES
(1, 1, '2022-03-15', 'Wymiana oleju silnikowego i filtra', 320.00, 'AutoSerwis Warszawa'),
(2, 2, '2022-04-10', 'Przegląd techniczny, wymiana klocków hamulcowych', 550.00, 'MotoFix Kraków'),
(3, 3, '2022-05-05', 'Naprawa układu wydechowego', 1150.00, 'AutoNaprawa Poznań'),
(4, 4, '2022-06-11', 'Regulacja zaworów, wymiana świec zapłonowych', 390.00, 'SerwisPlus Wrocław'),
(5, 5, '2022-07-22', 'Wymiana amortyzatorów', 930.00, 'SpeedCar Gdańsk'),
(6, 6, '2022-08-18', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 310.00, 'Chłodnica Service Łódź'),
(7, 7, '2022-09-30', 'Wymiana paska rozrządu', 810.00, 'Mechanik24 Katowice'),
(8, 8, '2022-10-15', 'Naprawa układu hamulcowego – wymiana tarcz', 1090.00, 'MotoFix Kraków'),
(9, 9, '2022-11-10', 'Diagnostyka komputerowa i wymiana filtra powietrza', 240.00, 'AutoSerwis Warszawa'),
(10, 10, '2022-12-20', 'Wymiana akumulatora', 460.00, 'SpeedCar Gdańsk'),
(11, 11, '2023-01-05', 'Przegląd okresowy, wymiana oleju', 410.00, 'AutoNaprawa Poznań'),
(12, 12, '2023-02-15', 'Naprawa układu chłodzenia', 890.00, 'Chłodnica Service Łódź'),
(13, 13, '2023-03-12', 'Wymiana klocków hamulcowych', 610.00, 'Mechanik24 Katowice'),
(14, 14, '2023-04-08', 'Regeneracja alternatora', 1220.00, 'SerwisPlus Wrocław'),
(15, 15, '2023-05-14', 'Wymiana amortyzatorów i sprężyn', 980.00, 'MotoFix Kraków'),
(16, 16, '2023-06-10', 'Serwis klimatyzacji – wymiana czynnika', 340.00, 'Chłodnica Service Łódź'),
(17, 17, '2023-07-21', 'Diagnostyka silnika i wymiana świec zapłonowych', 430.00, 'AutoSerwis Warszawa'),
(18, 18, '2023-08-15', 'Wymiana oleju w skrzyni biegów', 670.00, 'SpeedCar Gdańsk'),
(19, 19, '2023-09-20', 'Naprawa zawieszenia – wymiana tulei', 770.00, 'Mechanik24 Katowice'),
(20, 20, '2023-10-18', 'Przegląd techniczny i wymiana filtra paliwa', 310.00, 'SerwisPlus Wrocław'),
(21, 21, '2023-11-22', 'Wymiana oleju silnikowego i filtra', 330.00, 'AutoSerwis Warszawa'),
(22, 22, '2023-12-11', 'Przegląd techniczny, wymiana klocków hamulcowych', 560.00, 'MotoFix Kraków'),
(23, 23, '2024-01-05', 'Naprawa układu wydechowego', 1180.00, 'AutoNaprawa Poznań'),
(24, 24, '2024-02-13', 'Regulacja zaworów, wymiana świec zapłonowych', 400.00, 'SerwisPlus Wrocław'),
(25, 25, '2024-03-20', 'Wymiana amortyzatorów', 960.00, 'SpeedCar Gdańsk'),
(26, 26, '2024-04-17', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 320.00, 'Chłodnica Service Łódź'),
(27, 27, '2024-05-29', 'Wymiana paska rozrządu', 800.00, 'Mechanik24 Katowice'),
(28, 28, '2024-06-15', 'Naprawa układu hamulcowego – wymiana tarcz', 1070.00, 'MotoFix Kraków'),
(29, 29, '2024-07-10', 'Diagnostyka komputerowa i wymiana filtra powietrza', 230.00, 'AutoSerwis Warszawa'),
(30, 30, '2024-08-22', 'Wymiana akumulatora', 470.00, 'SpeedCar Gdańsk'),
(31, 31, '2024-09-05', 'Przegląd okresowy, wymiana oleju', 420.00, 'AutoNaprawa Poznań'),
(32, 32, '2024-10-15', 'Naprawa układu chłodzenia', 880.00, 'Chłodnica Service Łódź'),
(33, 33, '2024-11-12', 'Wymiana klocków hamulcowych', 620.00, 'Mechanik24 Katowice'),
(34, 34, '2024-12-08', 'Regeneracja alternatora', 1210.00, 'SerwisPlus Wrocław'),
(35, 35, '2025-01-14', 'Wymiana amortyzatorów i sprężyn', 990.00, 'MotoFix Kraków'),
(36, 36, '2025-02-10', 'Serwis klimatyzacji – wymiana czynnika', 350.00, 'Chłodnica Service Łódź'),
(37, 37, '2025-03-21', 'Diagnostyka silnika i wymiana świec zapłonowych', 440.00, 'AutoSerwis Warszawa'),
(38, 38, '2025-04-15', 'Wymiana oleju w skrzyni biegów', 680.00, 'SpeedCar Gdańsk'),
(39, 39, '2025-05-20', 'Naprawa zawieszenia – wymiana tulei', 760.00, 'Mechanik24 Katowice'),
(40, 40, '2025-06-18', 'Przegląd techniczny i wymiana filtra paliwa', 320.00, 'SerwisPlus Wrocław'),
(41, 41, '2023-01-19', 'Wymiana oleju silnikowego i filtra', 335.00, 'AutoSerwis Warszawa'),
(42, 42, '2023-02-15', 'Przegląd techniczny, wymiana klocków hamulcowych', 570.00, 'MotoFix Kraków'),
(43, 43, '2023-03-10', 'Naprawa układu wydechowego', 1130.00, 'AutoNaprawa Poznań'),
(44, 44, '2023-04-16', 'Regulacja zaworów, wymiana świec zapłonowych', 395.00, 'SerwisPlus Wrocław'),
(45, 45, '2023-05-27', 'Wymiana amortyzatorów', 940.00, 'SpeedCar Gdańsk'),
(46, 46, '2023-06-23', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 315.00, 'Chłodnica Service Łódź'),
(47, 47, '2023-07-05', 'Wymiana paska rozrządu', 820.00, 'Mechanik24 Katowice'),
(48, 48, '2023-08-20', 'Naprawa układu hamulcowego – wymiana tarcz', 1080.00, 'MotoFix Kraków'),
(49, 49, '2023-09-15', 'Diagnostyka komputerowa i wymiana filtra powietrza', 250.00, 'AutoSerwis Warszawa'),
(50, 50, '2023-10-25', 'Wymiana akumulatora', 455.00, 'SpeedCar Gdańsk'),
(51, 51, '2023-11-10', 'Przegląd okresowy, wymiana oleju', 415.00, 'AutoNaprawa Poznań'),
(52, 52, '2023-12-20', 'Naprawa układu chłodzenia', 895.00, 'Chłodnica Service Łódź'),
(53, 53, '2024-01-17', 'Wymiana klocków hamulcowych', 605.00, 'Mechanik24 Katowice'),
(54, 54, '2024-02-13', 'Regeneracja alternatora', 1195.00, 'SerwisPlus Wrocław'),
(55, 55, '2024-03-19', 'Wymiana amortyzatorów i sprężyn', 985.00, 'MotoFix Kraków'),
(56, 56, '2024-04-15', 'Serwis klimatyzacji – wymiana czynnika', 345.00, 'Chłodnica Service Łódź'),
(57, 57, '2024-05-26', 'Diagnostyka silnika i wymiana świec zapłonowych', 425.00, 'AutoSerwis Warszawa'),
(58, 58, '2024-06-20', 'Wymiana oleju w skrzyni biegów', 665.00, 'SpeedCar Gdańsk'),
(59, 59, '2024-07-25', 'Naprawa zawieszenia – wymiana tulei', 755.00, 'Mechanik24 Katowice'),
(60, 60, '2024-08-23', 'Przegląd techniczny i wymiana filtra paliwa', 305.00, 'SerwisPlus Wrocław'),
(61, 61, '2024-09-27', 'Wymiana oleju silnikowego i filtra', 340.00, 'AutoSerwis Warszawa'),
(62, 62, '2024-10-16', 'Przegląd techniczny, wymiana klocków hamulcowych', 575.00, 'MotoFix Kraków'),
(63, 63, '2024-11-11', 'Naprawa układu wydechowego', 1120.00, 'AutoNaprawa Poznań'),
(64, 64, '2024-12-17', 'Regulacja zaworów, wymiana świec zapłonowych', 405.00, 'SerwisPlus Wrocław'),
(65, 65, '2025-01-28', 'Wymiana amortyzatorów', 950.00, 'SpeedCar Gdańsk'),
(66, 66, '2025-02-24', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 330.00, 'Chłodnica Service Łódź'),
(67, 67, '2025-03-06', 'Wymiana paska rozrządu', 815.00, 'Mechanik24 Katowice'),
(68, 68, '2025-04-21', 'Naprawa układu hamulcowego – wymiana tarcz', 1085.00, 'MotoFix Kraków'),
(69, 1, '2025-05-16', 'Diagnostyka komputerowa i wymiana filtra powietrza', 245.00, 'AutoSerwis Warszawa'),
(70, 2, '2025-06-28', 'Wymiana akumulatora', 460.00, 'SpeedCar Gdańsk'),
(71, 3, '2025-07-05', 'Przegląd techniczny, wymiana oleju', 410.00, 'AutoNaprawa Poznań'),
(72, 4, '2025-07-22', 'Naprawa układu chłodzenia', 880.00, 'Chłodnica Service Łódź'),
(73, 5, '2025-08-14', 'Wymiana klocków hamulcowych', 615.00, 'Mechanik24 Katowice'),
(74, 6, '2025-08-29', 'Regeneracja alternatora', 1230.00, 'SerwisPlus Wrocław'),
(75, 7, '2025-09-13', 'Wymiana amortyzatorów i sprężyn', 970.00, 'MotoFix Kraków'),
(76, 8, '2025-09-28', 'Serwis klimatyzacji – wymiana czynnika', 335.00, 'Chłodnica Service Łódź'),
(77, 9, '2025-10-12', 'Diagnostyka silnika i wymiana świec zapłonowych', 435.00, 'AutoSerwis Warszawa'),
(78, 10, '2025-10-30', 'Wymiana oleju w skrzyni biegów', 675.00, 'SpeedCar Gdańsk'),
(79, 11, '2025-11-15', 'Naprawa zawieszenia – wymiana tulei', 765.00, 'Mechanik24 Katowice'),
(80, 12, '2025-11-28', 'Przegląd techniczny i wymiana filtra paliwa', 315.00, 'SerwisPlus Wrocław'),
(81, 13, '2022-01-09', 'Wymiana oleju silnikowego i filtra', 325.00, 'AutoSerwis Warszawa'),
(82, 14, '2022-01-23', 'Przegląd techniczny, wymiana klocków hamulcowych', 560.00, 'MotoFix Kraków'),
(83, 15, '2022-02-10', 'Naprawa układu wydechowego', 1190.00, 'AutoNaprawa Poznań'),
(84, 16, '2022-02-27', 'Regulacja zaworów, wymiana świec zapłonowych', 405.00, 'SerwisPlus Wrocław'),
(85, 17, '2022-03-14', 'Wymiana amortyzatorów', 940.00, 'SpeedCar Gdańsk'),
(86, 18, '2022-03-30', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 320.00, 'Chłodnica Service Łódź'),
(87, 19, '2022-04-18', 'Wymiana paska rozrządu', 810.00, 'Mechanik24 Katowice'),
(88, 20, '2022-05-05', 'Naprawa układu hamulcowego – wymiana tarcz', 1100.00, 'MotoFix Kraków'),
(89, 21, '2022-05-20', 'Diagnostyka komputerowa i wymiana filtra powietrza', 235.00, 'AutoSerwis Warszawa'),
(90, 22, '2022-06-07', 'Wymiana akumulatora', 465.00, 'SpeedCar Gdańsk'),
(91, 23, '2022-06-25', 'Przegląd okresowy, wymiana oleju', 405.00, 'AutoNaprawa Poznań'),
(92, 24, '2022-07-12', 'Naprawa układu chłodzenia', 885.00, 'Chłodnica Service Łódź'),
(93, 25, '2022-07-30', 'Wymiana klocków hamulcowych', 600.00, 'Mechanik24 Katowice'),
(94, 26, '2022-08-15', 'Regeneracja alternatora', 1200.00, 'SerwisPlus Wrocław'),
(95, 27, '2022-09-02', 'Wymiana amortyzatorów i sprężyn', 975.00, 'MotoFix Kraków'),
(96, 28, '2022-09-20', 'Serwis klimatyzacji – wymiana czynnika', 350.00, 'Chłodnica Service Łódź'),
(97, 29, '2022-10-06', 'Diagnostyka silnika i wymiana świec zapłonowych', 420.00, 'AutoSerwis Warszawa'),
(98, 30, '2022-10-22', 'Wymiana oleju w skrzyni biegów', 660.00, 'SpeedCar Gdańsk'),
(99, 31, '2022-11-10', 'Naprawa zawieszenia – wymiana tulei', 740.00, 'Mechanik24 Katowice'),
(100, 32, '2022-11-28', 'Przegląd techniczny i wymiana filtra paliwa', 300.00, 'SerwisPlus Wrocław'),
(101, 33, '2022-12-14', 'Wymiana oleju silnikowego i filtra', 335.00, 'AutoSerwis Warszawa'),
(102, 34, '2023-01-03', 'Przegląd techniczny, wymiana klocków hamulcowych', 580.00, 'MotoFix Kraków'),
(103, 35, '2023-01-21', 'Naprawa układu wydechowego', 1140.00, 'AutoNaprawa Poznań'),
(104, 36, '2023-02-07', 'Regulacja zaworów, wymiana świec zapłonowych', 390.00, 'SerwisPlus Wrocław'),
(105, 37, '2023-02-25', 'Wymiana amortyzatorów', 950.00, 'SpeedCar Gdańsk'),
(106, 38, '2023-03-14', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 325.00, 'Chłodnica Service Łódź'),
(107, 39, '2023-03-30', 'Wymiana paska rozrządu', 800.00, 'Mechanik24 Katowice'),
(108, 40, '2023-04-18', 'Naprawa układu hamulcowego – wymiana tarcz', 1075.00, 'MotoFix Kraków'),
(109, 41, '2023-05-05', 'Diagnostyka komputerowa i wymiana filtra powietrza', 245.00, 'AutoSerwis Warszawa'),
(110, 42, '2023-05-23', 'Wymiana akumulatora', 455.00, 'SpeedCar Gdańsk'),
(111, 43, '2023-06-10', 'Przegląd okresowy, wymiana oleju', 425.00, 'AutoNaprawa Poznań'),
(112, 44, '2023-06-28', 'Naprawa układu chłodzenia', 890.00, 'Chłodnica Service Łódź'),
(113, 45, '2023-07-15', 'Wymiana klocków hamulcowych', 610.00, 'Mechanik24 Katowice'),
(114, 46, '2023-08-02', 'Regeneracja alternatora', 1215.00, 'SerwisPlus Wrocław'),
(115, 47, '2023-08-20', 'Wymiana amortyzatorów i sprężyn', 980.00, 'MotoFix Kraków'),
(116, 48, '2023-09-07', 'Serwis klimatyzacji – wymiana czynnika', 340.00, 'Chłodnica Service Łódź'),
(117, 49, '2023-09-25', 'Diagnostyka silnika i wymiana świec zapłonowych', 430.00, 'AutoSerwis Warszawa'),
(118, 50, '2023-10-12', 'Wymiana oleju w skrzyni biegów', 680.00, 'SpeedCar Gdańsk'),
(119, 51, '2023-10-30', 'Naprawa zawieszenia – wymiana tulei', 770.00, 'Mechanik24 Katowice'),
(120, 52, '2023-11-17', 'Przegląd techniczny i wymiana filtra paliwa', 320.00, 'SerwisPlus Wrocław'),
(121, 53, '2023-12-04', 'Wymiana oleju silnikowego i filtra', 340.00, 'AutoSerwis Warszawa'),
(122, 54, '2023-12-22', 'Przegląd techniczny, wymiana klocków hamulcowych', 575.00, 'MotoFix Kraków'),
(123, 55, '2024-01-09', 'Naprawa układu wydechowego', 1165.00, 'AutoNaprawa Poznań'),
(124, 56, '2024-01-27', 'Regulacja zaworów, wymiana świec zapłonowych', 405.00, 'SerwisPlus Wrocław'),
(125, 57, '2024-02-14', 'Wymiana amortyzatorów', 955.00, 'SpeedCar Gdańsk'),
(126, 58, '2024-03-03', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 330.00, 'Chłodnica Service Łódź'),
(127, 59, '2024-03-20', 'Wymiana paska rozrządu', 820.00, 'Mechanik24 Katowice'),
(128, 60, '2024-04-07', 'Naprawa układu hamulcowego – wymiana tarcz', 1090.00, 'MotoFix Kraków'),
(129, 61, '2024-04-25', 'Diagnostyka komputerowa i wymiana filtra powietrza', 250.00, 'AutoSerwis Warszawa'),
(130, 62, '2024-05-12', 'Wymiana akumulatora', 465.00, 'SpeedCar Gdańsk'),
(131, 63, '2024-05-30', 'Przegląd okresowy, wymiana oleju', 415.00, 'AutoNaprawa Poznań'),
(132, 64, '2024-06-17', 'Naprawa układu chłodzenia', 880.00, 'Chłodnica Service Łódź'),
(133, 65, '2024-07-04', 'Wymiana klocków hamulcowych', 605.00, 'Mechanik24 Katowice'),
(134, 66, '2024-07-22', 'Regeneracja alternatora', 1220.00, 'SerwisPlus Wrocław'),
(135, 67, '2024-08-09', 'Wymiana amortyzatorów i sprężyn', 975.00, 'MotoFix Kraków'),
(136, 68, '2024-08-27', 'Serwis klimatyzacji – wymiana czynnika', 345.00, 'Chłodnica Service Łódź'),
(137, 1, '2024-09-13', 'Diagnostyka silnika i wymiana świec zapłonowych', 420.00, 'AutoSerwis Warszawa'),
(138, 2, '2024-09-30', 'Wymiana oleju w skrzyni biegów', 665.00, 'SpeedCar Gdańsk'),
(139, 3, '2024-10-18', 'Naprawa zawieszenia – wymiana tulei', 755.00, 'Mechanik24 Katowice'),
(140, 4, '2024-11-05', 'Przegląd techniczny i wymiana filtra paliwa', 310.00, 'SerwisPlus Wrocław'),
(141, 5, '2024-11-23', 'Wymiana oleju silnikowego i filtra', 330.00, 'AutoSerwis Warszawa'),
(142, 6, '2024-12-10', 'Przegląd techniczny, wymiana klocków hamulcowych', 570.00, 'MotoFix Kraków'),
(143, 7, '2024-12-28', 'Naprawa układu wydechowego', 1175.00, 'AutoNaprawa Poznań'),
(144, 8, '2025-01-14', 'Regulacja zaworów, wymiana świec zapłonowych', 400.00, 'SerwisPlus Wrocław'),
(145, 9, '2025-02-01', 'Wymiana amortyzatorów', 960.00, 'SpeedCar Gdańsk'),
(146, 10, '2025-02-19', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 335.00, 'Chłodnica Service Łódź'),
(147, 11, '2025-03-07', 'Wymiana paska rozrządu', 825.00, 'Mechanik24 Katowice'),
(148, 12, '2025-03-25', 'Naprawa układu hamulcowego – wymiana tarcz', 1085.00, 'MotoFix Kraków'),
(149, 13, '2025-04-11', 'Diagnostyka komputerowa i wymiana filtra powietrza', 255.00, 'AutoSerwis Warszawa'),
(150, 14, '2025-04-29', 'Wymiana akumulatora', 460.00, 'SpeedCar Gdańsk'),
(151, 15, '2025-05-17', 'Przegląd okresowy, wymiana oleju', 420.00, 'AutoNaprawa Poznań'),
(152, 16, '2025-06-04', 'Naprawa układu chłodzenia', 885.00, 'Chłodnica Service Łódź'),
(153, 17, '2025-06-22', 'Wymiana klocków hamulcowych', 610.00, 'Mechanik24 Katowice'),
(154, 18, '2025-07-10', 'Regeneracja alternatora', 1225.00, 'SerwisPlus Wrocław'),
(155, 19, '2025-07-28', 'Wymiana amortyzatorów i sprężyn', 980.00, 'MotoFix Kraków'),
(156, 20, '2025-08-15', 'Serwis klimatyzacji – wymiana czynnika', 340.00, 'Chłodnica Service Łódź'),
(157, 21, '2025-09-02', 'Diagnostyka silnika i wymiana świec zapłonowych', 435.00, 'AutoSerwis Warszawa'),
(158, 22, '2025-09-20', 'Wymiana oleju w skrzyni biegów', 670.00, 'SpeedCar Gdańsk'),
(159, 23, '2025-10-08', 'Naprawa zawieszenia – wymiana tulei', 780.00, 'Mechanik24 Katowice'),
(160, 24, '2025-10-26', 'Przegląd techniczny i wymiana filtra paliwa', 325.00, 'SerwisPlus Wrocław'),
(161, 25, '2025-11-13', 'Wymiana oleju silnikowego i filtra', 335.00, 'AutoSerwis Warszawa'),
(162, 26, '2025-12-01', 'Przegląd techniczny, wymiana klocków hamulcowych', 575.00, 'MotoFix Kraków'),
(163, 27, '2025-12-19', 'Naprawa układu wydechowego', 1155.00, 'AutoNaprawa Poznań'),
(164, 28, '2026-01-06', 'Regulacja zaworów, wymiana świec zapłonowych', 410.00, 'SerwisPlus Wrocław'),
(165, 29, '2026-01-24', 'Wymiana amortyzatorów', 965.00, 'SpeedCar Gdańsk'),
(166, 30, '2026-02-11', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 335.00, 'Chłodnica Service Łódź'),
(167, 31, '2026-02-28', 'Wymiana paska rozrządu', 815.00, 'Mechanik24 Katowice'),
(168, 32, '2026-03-18', 'Naprawa układu hamulcowego – wymiana tarcz', 1105.00, 'MotoFix Kraków'),
(169, 33, '2026-04-05', 'Diagnostyka komputerowa i wymiana filtra powietrza', 260.00, 'AutoSerwis Warszawa'),
(170, 34, '2026-04-23', 'Wymiana akumulatora', 470.00, 'SpeedCar Gdańsk'),
(171, 35, '2026-05-11', 'Przegląd okresowy, wymiana oleju', 420.00, 'AutoNaprawa Poznań'),
(172, 36, '2026-05-29', 'Naprawa układu chłodzenia', 895.00, 'Chłodnica Service Łódź'),
(173, 37, '2026-06-16', 'Wymiana klocków hamulcowych', 610.00, 'Mechanik24 Katowice'),
(174, 38, '2026-07-04', 'Regeneracja alternatora', 1235.00, 'SerwisPlus Wrocław'),
(175, 39, '2026-07-22', 'Wymiana amortyzatorów i sprężyn', 985.00, 'MotoFix Kraków'),
(176, 40, '2026-08-09', 'Serwis klimatyzacji – wymiana czynnika', 345.00, 'Chłodnica Service Łódź'),
(177, 41, '2026-08-27', 'Diagnostyka silnika i wymiana świec zapłonowych', 440.00, 'AutoSerwis Warszawa'),
(178, 42, '2026-09-14', 'Wymiana oleju w skrzyni biegów', 675.00, 'SpeedCar Gdańsk'),
(179, 43, '2026-10-02', 'Naprawa zawieszenia – wymiana tulei', 785.00, 'Mechanik24 Katowice'),
(180, 44, '2026-10-20', 'Przegląd techniczny i wymiana filtra paliwa', 330.00, 'SerwisPlus Wrocław'),
(181, 45, '2026-11-07', 'Wymiana oleju silnikowego i filtra', 345.00, 'AutoSerwis Warszawa'),
(182, 46, '2026-11-25', 'Przegląd techniczny, wymiana klocków hamulcowych', 585.00, 'MotoFix Kraków'),
(183, 47, '2026-12-13', 'Naprawa układu wydechowego', 1185.00, 'AutoNaprawa Poznań'),
(184, 48, '2027-01-01', 'Regulacja zaworów, wymiana świec zapłonowych', 415.00, 'SerwisPlus Wrocław'),
(185, 49, '2027-01-19', 'Wymiana amortyzatorów', 970.00, 'SpeedCar Gdańsk'),
(186, 50, '2027-02-06', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 340.00, 'Chłodnica Service Łódź'),
(187, 51, '2027-02-24', 'Wymiana paska rozrządu', 830.00, 'Mechanik24 Katowice'),
(188, 52, '2027-03-14', 'Naprawa układu hamulcowego – wymiana tarcz', 1110.00, 'MotoFix Kraków'),
(189, 53, '2027-04-01', 'Diagnostyka komputerowa i wymiana filtra powietrza', 265.00, 'AutoSerwis Warszawa'),
(190, 54, '2027-04-19', 'Wymiana akumulatora', 475.00, 'SpeedCar Gdańsk'),
(191, 55, '2027-05-07', 'Przegląd okresowy, wymiana oleju', 430.00, 'AutoNaprawa Poznań'),
(192, 56, '2027-05-25', 'Naprawa układu chłodzenia', 900.00, 'Chłodnica Service Łódź'),
(193, 57, '2027-06-12', 'Wymiana klocków hamulcowych', 615.00, 'Mechanik24 Katowice'),
(194, 58, '2027-06-30', 'Regeneracja alternatora', 1240.00, 'SerwisPlus Wrocław'),
(195, 59, '2027-07-18', 'Wymiana amortyzatorów i sprężyn', 990.00, 'MotoFix Kraków'),
(196, 60, '2027-08-05', 'Serwis klimatyzacji – wymiana czynnika', 350.00, 'Chłodnica Service Łódź'),
(197, 61, '2027-08-23', 'Diagnostyka silnika i wymiana świec zapłonowych', 445.00, 'AutoSerwis Warszawa'),
(198, 62, '2027-09-10', 'Wymiana oleju w skrzyni biegów', 680.00, 'SpeedCar Gdańsk'),
(199, 63, '2027-09-28', 'Naprawa zawieszenia – wymiana tulei', 790.00, 'Mechanik24 Katowice'),
(200, 64, '2027-10-16', 'Przegląd techniczny i wymiana filtra paliwa', 335.00, 'SerwisPlus Wrocław'),
(201, 65, '2027-11-03', 'Wymiana oleju silnikowego i filtra', 350.00, 'AutoSerwis Warszawa'),
(202, 66, '2027-11-21', 'Przegląd techniczny, wymiana klocków hamulcowych', 590.00, 'MotoFix Kraków'),
(203, 67, '2027-12-09', 'Naprawa układu wydechowego', 1200.00, 'AutoNaprawa Poznań'),
(204, 68, '2027-12-27', 'Regulacja zaworów, wymiana świec zapłonowych', 420.00, 'SerwisPlus Wrocław'),
(205, 1, '2028-01-14', 'Wymiana amortyzatorów', 975.00, 'SpeedCar Gdańsk'),
(206, 2, '2028-02-01', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 345.00, 'Chłodnica Service Łódź'),
(207, 3, '2028-02-19', 'Wymiana paska rozrządu', 835.00, 'Mechanik24 Katowice'),
(208, 4, '2028-03-08', 'Naprawa układu hamulcowego – wymiana tarcz', 1120.00, 'MotoFix Kraków'),
(209, 5, '2028-03-26', 'Diagnostyka komputerowa i wymiana filtra powietrza', 270.00, 'AutoSerwis Warszawa'),
(210, 6, '2028-04-13', 'Wymiana akumulatora', 480.00, 'SpeedCar Gdańsk'),
(211, 7, '2028-05-01', 'Przegląd okresowy, wymiana oleju', 435.00, 'AutoNaprawa Poznań'),
(212, 8, '2028-05-19', 'Naprawa układu chłodzenia', 910.00, 'Chłodnica Service Łódź'),
(213, 9, '2028-06-06', 'Wymiana klocków hamulcowych', 620.00, 'Mechanik24 Katowice'),
(214, 10, '2028-06-24', 'Regeneracja alternatora', 1250.00, 'SerwisPlus Wrocław'),
(215, 11, '2028-07-12', 'Wymiana amortyzatorów i sprężyn', 995.00, 'MotoFix Kraków'),
(216, 12, '2028-07-30', 'Serwis klimatyzacji – wymiana czynnika', 355.00, 'Chłodnica Service Łódź'),
(217, 13, '2028-08-17', 'Diagnostyka silnika i wymiana świec zapłonowych', 450.00, 'AutoSerwis Warszawa'),
(218, 14, '2028-09-04', 'Wymiana oleju w skrzyni biegów', 685.00, 'SpeedCar Gdańsk'),
(219, 15, '2028-09-22', 'Naprawa zawieszenia – wymiana tulei', 795.00, 'Mechanik24 Katowice'),
(220, 16, '2028-10-10', 'Przegląd techniczny i wymiana filtra paliwa', 340.00, 'SerwisPlus Wrocław'),
(221, 17, '2028-10-28', 'Wymiana oleju silnikowego i filtra', 355.00, 'AutoSerwis Warszawa'),
(222, 18, '2028-11-15', 'Przegląd techniczny, wymiana klocków hamulcowych', 595.00, 'MotoFix Kraków'),
(223, 19, '2028-12-03', 'Naprawa układu wydechowego', 1210.00, 'AutoNaprawa Poznań'),
(224, 20, '2028-12-21', 'Regulacja zaworów, wymiana świec zapłonowych', 425.00, 'SerwisPlus Wrocław'),
(225, 21, '2029-01-08', 'Wymiana amortyzatorów', 980.00, 'SpeedCar Gdańsk'),
(226, 22, '2029-01-26', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 350.00, 'Chłodnica Service Łódź'),
(227, 23, '2029-02-13', 'Wymiana paska rozrządu', 840.00, 'Mechanik24 Katowice'),
(228, 24, '2029-03-03', 'Naprawa układu hamulcowego – wymiana tarcz', 1130.00, 'MotoFix Kraków'),
(229, 25, '2029-03-21', 'Diagnostyka komputerowa i wymiana filtra powietrza', 275.00, 'AutoSerwis Warszawa'),
(230, 26, '2029-04-08', 'Wymiana akumulatora', 485.00, 'SpeedCar Gdańsk'),
(231, 27, '2029-04-26', 'Przegląd okresowy, wymiana oleju', 440.00, 'AutoNaprawa Poznań'),
(232, 28, '2029-05-14', 'Naprawa układu chłodzenia', 920.00, 'Chłodnica Service Łódź'),
(233, 29, '2029-06-01', 'Wymiana klocków hamulcowych', 625.00, 'Mechanik24 Katowice'),
(234, 30, '2029-06-19', 'Regeneracja alternatora', 1255.00, 'SerwisPlus Wrocław'),
(235, 31, '2029-07-07', 'Wymiana amortyzatorów i sprężyn', 1000.00, 'MotoFix Kraków'),
(236, 32, '2029-07-25', 'Serwis klimatyzacji – wymiana czynnika', 360.00, 'Chłodnica Service Łódź'),
(237, 33, '2029-08-12', 'Diagnostyka silnika i wymiana świec zapłonowych', 455.00, 'AutoSerwis Warszawa'),
(238, 34, '2029-08-30', 'Wymiana oleju w skrzyni biegów', 690.00, 'SpeedCar Gdańsk'),
(239, 35, '2029-09-17', 'Naprawa zawieszenia – wymiana tulei', 800.00, 'Mechanik24 Katowice'),
(240, 36, '2029-10-05', 'Przegląd techniczny i wymiana filtra paliwa', 345.00, 'SerwisPlus Wrocław'),
(241, 37, '2029-10-23', 'Wymiana oleju silnikowego i filtra', 360.00, 'AutoSerwis Warszawa'),
(242, 38, '2029-11-10', 'Przegląd techniczny, wymiana klocków hamulcowych', 600.00, 'MotoFix Kraków'),
(243, 39, '2029-11-28', 'Naprawa układu wydechowego', 1220.00, 'AutoNaprawa Poznań'),
(244, 40, '2029-12-16', 'Regulacja zaworów, wymiana świec zapłonowych', 430.00, 'SerwisPlus Wrocław'),
(245, 41, '2030-01-03', 'Wymiana amortyzatorów', 985.00, 'SpeedCar Gdańsk'),
(246, 42, '2030-01-21', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 355.00, 'Chłodnica Service Łódź'),
(247, 43, '2030-02-08', 'Wymiana paska rozrządu', 845.00, 'Mechanik24 Katowice'),
(248, 44, '2030-02-26', 'Naprawa układu hamulcowego – wymiana tarcz', 1140.00, 'MotoFix Kraków'),
(249, 45, '2030-03-16', 'Diagnostyka komputerowa i wymiana filtra powietrza', 280.00, 'AutoSerwis Warszawa'),
(250, 46, '2030-04-03', 'Wymiana akumulatora', 490.00, 'SpeedCar Gdańsk'),
(251, 47, '2030-04-21', 'Przegląd okresowy, wymiana oleju', 445.00, 'AutoNaprawa Poznań'),
(252, 48, '2030-05-09', 'Naprawa układu chłodzenia', 930.00, 'Chłodnica Service Łódź'),
(253, 49, '2030-05-27', 'Wymiana klocków hamulcowych', 630.00, 'Mechanik24 Katowice'),
(254, 50, '2030-06-14', 'Regeneracja alternatora', 1260.00, 'SerwisPlus Wrocław'),
(255, 51, '2030-07-02', 'Wymiana amortyzatorów i sprężyn', 1005.00, 'MotoFix Kraków'),
(256, 52, '2030-07-20', 'Serwis klimatyzacji – wymiana czynnika', 365.00, 'Chłodnica Service Łódź'),
(257, 53, '2030-08-07', 'Diagnostyka silnika i wymiana świec zapłonowych', 460.00, 'AutoSerwis Warszawa'),
(258, 54, '2030-08-25', 'Wymiana oleju w skrzyni biegów', 695.00, 'SpeedCar Gdańsk'),
(259, 55, '2030-09-12', 'Naprawa zawieszenia – wymiana tulei', 805.00, 'Mechanik24 Katowice'),
(260, 56, '2030-09-30', 'Przegląd techniczny i wymiana filtra paliwa', 350.00, 'SerwisPlus Wrocław'),
(261, 57, '2030-10-18', 'Wymiana oleju silnikowego i filtra', 365.00, 'AutoSerwis Warszawa'),
(262, 58, '2030-11-05', 'Przegląd techniczny, wymiana klocków hamulcowych', 605.00, 'MotoFix Kraków'),
(263, 59, '2030-11-23', 'Naprawa układu wydechowego', 1230.00, 'AutoNaprawa Poznań'),
(264, 60, '2030-12-11', 'Regulacja zaworów, wymiana świec zapłonowych', 435.00, 'SerwisPlus Wrocław'),
(265, 61, '2031-12-29', 'Wymiana amortyzatorów', 990.00, 'SpeedCar Gdańsk'),
(266, 62, '2031-01-16', 'Serwis klimatyzacji – czyszczenie i doładowanie czynnika', 360.00, 'Chłodnica Service Łódź'),
(267, 63, '2031-02-03', 'Wymiana paska rozrządu', 850.00, 'Mechanik24 Katowice'),
(268, 64, '2031-02-21', 'Naprawa układu hamulcowego – wymiana tarcz', 1150.00, 'MotoFix Kraków'),
(269, 65, '2031-03-11', 'Diagnostyka komputerowa i wymiana filtra powietrza', 285.00, 'AutoSerwis Warszawa'),
(270, 66, '2031-03-29', 'Wymiana akumulatora', 495.00, 'SpeedCar Gdańsk');

-- --------------------------------------------------------

--
-- Table structure for table `lokacje`
--

CREATE TABLE `lokacje` (
  `id_lokacji` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `miasto` varchar(100) NOT NULL,
  `kod_pocztowy` varchar(10) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokacje`
--

INSERT INTO `lokacje` (`id_lokacji`, `nazwa`, `adres`, `miasto`, `kod_pocztowy`, `telefon`, `email`) VALUES
(1, 'Karpol Łódź', 'ul. Piotrkowska 100', 'Łódź', '90-001', '422100100', 'lodz@karpol.pl'),
(2, 'Karpol Katowice', 'ul. 3 Maja 20', 'Katowice', '40-001', '322200200', 'katowice@karpol.pl'),
(3, 'Karpol Warszawa', 'ul. Marszałkowska 1', 'Warszawa', '00-001', '222333444', 'warszawa@karpol.pl'),
(4, 'Karpol Kraków', 'ul. Floriańska 10', 'Kraków', '30-001', '123456789', 'krakow@karpol.pl'),
(5, 'Karpol Gdańsk', 'ul. Długa 15', 'Gdańsk', '80-001', '555888999', 'gdansk@karpol.pl'),
(6, 'Karpol Wrocław', 'ul. Świdnicka 25', 'Wrocław', '50-001', '667788990', 'wroclaw@karpol.pl'),
(7, 'Karpol Poznań', 'ul. Półwiejska 10', 'Poznań', '61-001', '888777666', 'poznan@karpol.pl');

-- --------------------------------------------------------

--
-- Table structure for table `opinie`
--

CREATE TABLE `opinie` (
  `id` int(11) NOT NULL,
  `imie_nazwisko` varchar(100) DEFAULT NULL,
  `miasto` varchar(100) DEFAULT NULL,
  `tresc` text DEFAULT NULL,
  `data_opinii` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opinie`
--

INSERT INTO `opinie` (`id`, `imie_nazwisko`, `miasto`, `tresc`, `data_opinii`) VALUES
(1, 'Jan Kowalski', 'Warszawa', 'Bardzo miła obsługa i szybka realizacja rezerwacji. Samochód zgodny z opisem. Polecam!', '2024-11-12'),
(2, 'Anna Nowak', 'Kraków', 'Auto w świetnym stanie, wszystko przebiegło sprawnie. Na pewno wrócę.', '2025-02-28'),
(3, 'Marek Zieliński', 'Gdańsk', 'Duży wybór aut i bardzo pomocni pracownicy. Polecam każdemu!', '2025-01-10'),
(4, 'Ewa Wiśniewska', 'Wrocław', 'Profesjonalna obsługa, auto czyste i gotowe do jazdy. Rezerwacja bezproblemowa.', '2025-03-15'),
(5, 'Tomasz Kaczmarek', 'Poznań', 'Zarezerwowałem auto przez stronę, wszystko poszło szybko i bez komplikacji.', '2025-04-01'),
(6, 'Magdalena Dąbrowska', 'Łódź', 'Polecam każdemu kto szuka sprawdzonego samochodu. Obsługa na najwyższym poziomie.', '2025-03-30'),
(7, 'Kacper Jasiński', 'Katowice', 'Rewelacyjna jakość usług, auto odebrane w idealnym stanie. Dziękuję!', '2025-05-10'),
(8, 'Oliwia Mazur', 'Warszawa', 'Świetna lokalizacja i przemiła obsługa. Na pewno skorzystam ponownie.', '2025-05-14'),
(9, 'Paweł Grabowski', 'Kraków', 'Nie spodziewałem się tak dobrej obsługi w tak krótkim czasie. Brawo!', '2025-03-09'),
(10, 'Natalia Pawlak', 'Gdańsk', 'Bardzo sprawna i szybka rezerwacja. Polecam serdecznie każdemu!', '2025-04-22'),
(11, 'Michał Walczak', 'Wrocław', 'Miła obsługa, dobra cena, wszystko zgodne z umową.', '2025-02-18'),
(12, 'Karolina Król', 'Poznań', 'Zdecydowanie polecam! Samochód czysty, zatankowany i gotowy do jazdy.', '2025-01-05'),
(13, 'Dominik Rutkowski', 'Łódź', 'Obsługa klienta na bardzo wysokim poziomie. Szybko i bez problemów.', '2025-04-05'),
(14, 'Aleksandra Wójcik', 'Katowice', 'Bardzo dobra komunikacja ze strony firmy, auto zadbane i komfortowe.', '2025-05-01'),
(15, 'Patryk Nowicki', 'Warszawa', 'Szybko, sprawnie i bez stresu. Wszystko zorganizowane jak należy.', '2025-05-28'),
(16, 'Klaudia Michalska', 'Kraków', 'Auto idealne na weekendowy wypad. Bezproblemowa obsługa i rezerwacja.', '2025-04-15'),
(17, 'Adrian Bąk', 'Gdańsk', 'Wszystko przebiegło bardzo profesjonalnie, polecam każdemu.', '2025-02-12'),
(18, 'Weronika Lis', 'Wrocław', 'Fachowa obsługa, terminowo i zgodnie z umową.', '2025-01-20'),
(19, 'Bartosz Wrona', 'Poznań', 'Świetne ceny i szeroki wybór samochodów.', '2025-03-07'),
(20, 'Joanna Głowacka', 'Łódź', 'Jestem bardzo zadowolony z całego procesu wypożyczenia.', '2025-02-26'),
(21, 'Mateusz Zając', 'Katowice', 'Bardzo przyjazny personel, który pomógł mi znaleźć idealne auto.', '2025-01-18'),
(22, 'Monika Kubiak', 'Warszawa', 'Samochód czysty, zadbany, rezerwacja przebiegła sprawnie.', '2025-03-21'),
(23, 'Rafał Krawczyk', 'Kraków', 'Polecam! Bez ukrytych kosztów i z jasnymi warunkami.', '2025-04-09'),
(24, 'Paulina Baran', 'Gdańsk', 'Rezerwacja online bardzo intuicyjna, auto zgodne z opisem.', '2025-05-02'),
(25, 'Sebastian Szymański', 'Wrocław', 'Szybka i rzetelna obsługa. Wszystko dopięte na ostatni guzik.', '2025-03-18'),
(26, 'Agnieszka Kucharska', 'Poznań', 'Samochód dostępny od ręki. Rewelacyjna obsługa klienta.', '2025-01-27'),
(27, 'Grzegorz Kalinowski', 'Łódź', 'Firma godna zaufania. Zdecydowanie polecam.', '2025-03-03'),
(28, 'Daria Malinowska', 'Katowice', 'Bardzo pozytywne doświadczenie. Wszystko zgodnie z ustaleniami.', '2025-02-08'),
(29, 'Mariusz Mazurek', 'Warszawa', 'Szybka odpowiedź na zapytanie i pomoc przy wyborze auta.', '2025-05-04'),
(30, 'Emilia Nowakowska', 'Kraków', 'Miła i kompetentna obsługa. Samochód w świetnym stanie.', '2025-03-01'),
(31, 'Krzysztof Piątek', 'Gdańsk', 'Profesjonalizm i uczciwość. Zdecydowanie polecam.', '2025-04-12'),
(32, 'Julia Woźniak', 'Wrocław', 'Auto bardzo dobrze przygotowane, czyste i bez zastrzeżeń.', '2025-02-05'),
(33, 'Daniel Górski', 'Poznań', 'Dobry kontakt, jasne zasady, żadnych ukrytych kosztów.', '2025-01-17'),
(34, 'Barbara Sawicka', 'Łódź', 'Obsługa bardzo pomocna i życzliwa. Polecam każdemu.', '2025-04-24'),
(35, 'Artur Domański', 'Katowice', 'Wszystko w jak najlepszym porządku. Auto działało bez zarzutu.', '2025-03-19'),
(36, 'Natalia Jaworska', 'Warszawa', 'Firma zasługuje na 5 gwiazdek. Wzorowy kontakt i jakość.', '2025-04-17'),
(37, 'Łukasz Sikora', 'Kraków', 'Jestem pod wrażeniem. Auto wyglądało jak nowe.', '2025-01-29'),
(38, 'Kinga Borkowska', 'Gdańsk', 'Bardzo szybka obsługa i minimum formalności.', '2025-03-06'),
(39, 'Maciej Kozłowski', 'Wrocław', 'Pełna przejrzystość oferty i fachowe doradztwo.', '2025-02-11'),
(40, 'Aleksandra Maj', 'Poznań', 'Wszystko odbyło się sprawnie, bez żadnych opóźnień.', '2025-01-30'),
(41, 'Damian Tomaszewski', 'Łódź', 'Obsługa zna się na rzeczy. Samochód spełnił moje oczekiwania.', '2025-04-13'),
(42, 'Zuzanna Tomaszewska', 'Katowice', 'Auto przygotowane wzorowo, czyste i zadbane.', '2025-05-05'),
(43, 'Jakub Krupa', 'Warszawa', 'Świetne doświadczenie z całą ekipą. Dziękuję!', '2025-03-16'),
(44, 'Martyna Leśniak', 'Kraków', 'Wrócę na pewno! Wszystko dopracowane.', '2025-05-08'),
(45, 'Wojciech Sadowski', 'Gdańsk', 'Bardzo dobre wrażenie od początku do końca.', '2025-02-14'),
(46, 'Sylwia Chmielewska', 'Wrocław', 'Wysoki poziom obsługi i świetne warunki wynajmu.', '2025-04-27'),
(47, 'Szymon Wojciechowski', 'Poznań', 'Samochód był dokładnie taki, jak opisywano. Polecam!', '2025-03-13'),
(48, 'Iga Nowicka', 'Łódź', 'Zero problemów, wszystko zrealizowane zgodnie z oczekiwaniami.', '2025-02-22'),
(49, 'Oskar Zawadzki', 'Katowice', 'Szybka realizacja zamówienia i przystępne ceny.', '2025-03-28'),
(50, 'Liliana Sokołowska', 'Warszawa', 'Jestem bardzo zadowolona z jakości obsługi i auta.', '2025-04-19'),
(51, 'Wiktor Ostrowski', 'Kraków', 'Świetna komunikacja i fachowe podejście do klienta.', '2025-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `pojazdy`
--

CREATE TABLE `pojazdy` (
  `id_pojazdu` int(11) NOT NULL,
  `marka` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `rok_produkcji` int(11) NOT NULL,
  `przebieg` int(11) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `rodzaj_paliwa` enum('Benzyna','Diesel','Elektryczny','Hybryda','LPG') NOT NULL,
  `typ_pojazdu` enum('Osobowy','Dostawczy','Motocykl','Inny') NOT NULL,
  `kolor` varchar(50) DEFAULT NULL,
  `rodzaj_nadwozia` enum('Sedan','Kombi','Hatchback','SUV','Coupe','Inny') NOT NULL,
  `pojemnosc_silnika` decimal(4,1) NOT NULL,
  `moc_kw` int(11) NOT NULL,
  `vin` varchar(17) NOT NULL,
  `uszkodzony` tinyint(1) DEFAULT NULL,
  `skrzynia_biegow` enum('Manualna','Automatyczna') NOT NULL,
  `naped` enum('FWD','RWD','AWD','4x4') NOT NULL,
  `kierownica_prawa` tinyint(1) DEFAULT NULL,
  `liczba_drzwi` int(11) NOT NULL,
  `liczba_miejsc` int(11) NOT NULL,
  `id_lokacji` int(11) NOT NULL,
  `kraj_pochodzenia` varchar(100) NOT NULL,
  `data_pierwszej_rejestracji` date NOT NULL,
  `numer_rejestracyjny` varchar(20) NOT NULL,
  `wyposazenie_dodatkowe` text DEFAULT NULL,
  `stan_techniczny` enum('Bardzo Dobry','Dobry','Średni','Zły') NOT NULL,
  `status` enum('Dostępny','Sprzedany','Zarezerwowany') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pojazdy`
--

INSERT INTO `pojazdy` (`id_pojazdu`, `marka`, `model`, `rok_produkcji`, `przebieg`, `cena`, `rodzaj_paliwa`, `typ_pojazdu`, `kolor`, `rodzaj_nadwozia`, `pojemnosc_silnika`, `moc_kw`, `vin`, `uszkodzony`, `skrzynia_biegow`, `naped`, `kierownica_prawa`, `liczba_drzwi`, `liczba_miejsc`, `id_lokacji`, `kraj_pochodzenia`, `data_pierwszej_rejestracji`, `numer_rejestracyjny`, `wyposazenie_dodatkowe`, `stan_techniczny`, `status`) VALUES
(1, 'BMW', '3', 2018, 50000, 120000.00, 'Benzyna', 'Osobowy', 'Czarny', 'Sedan', 2.0, 135, 'WBA8A9C51JAC00001', 0, 'Automatyczna', 'FWD', 0, 4, 5, 1, 'Niemcy', '2018-07-15', 'KR12345', 'System nawigacji, Podgrzewane siedzenia', 'Bardzo Dobry', 'Dostępny'),
(2, 'Audi', 'A4', 2017, 65000, 110000.00, 'Diesel', 'Osobowy', 'Srebrny', 'Sedan', 2.0, 120, 'WAUZZZ8K9HA123456', 1, 'Manualna', 'FWD', 0, 4, 5, 1, 'Niemcy', '2017-05-10', 'WAW12345', 'Tempomat, Klimatyzacja automatyczna', 'Dobry', 'Zarezerwowany'),
(3, 'Volkswagen', 'Golf', 2019, 40000, 85000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Hatchback', 1.4, 100, 'WVWA1234567890123', 0, 'Automatyczna', 'FWD', 0, 5, 5, 2, 'Niemcy', '2019-03-20', 'KR54321', 'System audio premium, Kamera parkingowa', 'Bardzo Dobry', 'Dostępny'),
(4, 'Mercedes-Benz', 'C-Class', 2020, 30000, 150000.00, 'Diesel', 'Osobowy', 'Biały', 'Sedan', 2.1, 150, 'WDB20512345678901', 0, 'Automatyczna', 'RWD', 0, 4, 5, 1, 'Niemcy', '2020-09-15', 'WAW98765', 'Skórzana tapicerka, Asystent parkowania', 'Bardzo Dobry', 'Dostępny'),
(5, 'Skoda', 'Octavia', 2021, 25000, 90000.00, 'Benzyna', 'Osobowy', 'Szary', 'Kombi', 1.6, 110, 'TMBBJ5NU1M1234567', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Czechy', '2021-01-10', 'WAW11223', 'Klimatyzacja, System multimedialny', 'Bardzo Dobry', 'Zarezerwowany'),
(6, 'Ford', 'Focus', 2018, 70000, 75000.00, 'Diesel', 'Osobowy', 'Zielony', 'Hatchback', 1.5, 120, 'WF0BXXGCBZ1112345', 1, 'Manualna', 'FWD', 0, 5, 5, 2, 'Wielka Brytania', '2018-06-01', 'KR65432', 'Tempomat, System audio Sony', 'Średni', 'Dostępny'),
(7, 'Toyota', 'Yaris', 2019, 40000, 65000.00, 'Benzyna', 'Osobowy', 'Biały', 'Hatchback', 1.3, 99, 'JTMBX3NX9KJ123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 1, 'Japonia', '2019-02-20', 'WAW76543', 'Klimatyzacja, Podgrzewane lusterka', 'Bardzo Dobry', 'Dostępny'),
(8, 'Peugeot', '308', 2020, 30000, 95000.00, 'Diesel', 'Osobowy', 'Czarny', 'Hatchback', 1.5, 120, 'VF3PCLFF8LM123456', 0, 'Manualna', 'FWD', 0, 5, 5, 2, 'Francja', '2020-05-15', 'KR87654', 'Asystent pasa ruchu, Tempomat', 'Bardzo Dobry', 'Dostępny'),
(9, 'Opel', 'Astra', 2021, 20000, 105000.00, 'Benzyna', 'Osobowy', 'Niebieski', 'Kombi', 1.6, 115, 'W0L0XCF68M1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 2, 'Niemcy', '2021-04-01', 'KR98765', 'Klimatyzacja, Nawigacja GPS', 'Bardzo Dobry', 'Zarezerwowany'),
(10, 'Renault', 'Clio', 2018, 80000, 68000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Hatchback', 1.2, 90, 'VF1B5XEXK12345678', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Francja', '2018-11-15', 'WAW12345', 'Klimatyzacja, Bluetooth', 'Dobry', 'Dostępny'),
(11, 'Honda', 'Civic', 2020, 25000, 130000.00, 'Benzyna', 'Osobowy', 'Zielony', 'Sedan', 1.8, 140, 'SHHFK2740LU123456', 0, 'Automatyczna', 'FWD', 0, 4, 5, 1, 'Japonia', '2020-06-10', 'WAW54321', 'Kamera parkingowa, Asystent parkowania', 'Bardzo Dobry', 'Dostępny'),
(12, 'Mazda', '3', 2021, 15000, 115000.00, 'Benzyna', 'Osobowy', 'Srebrny', 'Hatchback', 2.0, 160, 'JM1BM1K76M1234567', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Japonia', '2021-01-30', 'KR12345', 'System audio Bose, Tempomat', 'Bardzo Dobry', 'Dostępny'),
(13, 'Nissan', 'Qashqai', 2020, 35000, 125000.00, 'Diesel', 'Osobowy', 'Biały', 'SUV', 1.5, 115, 'SJNFD4FX1XW123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Japonia', '2020-03-01', 'WAW87654', 'Podgrzewane siedzenia, Kamera parkingowa', 'Bardzo Dobry', 'Dostępny'),
(14, 'Hyundai', 'i30', 2019, 55000, 70000.00, 'Benzyna', 'Osobowy', 'Zielony', 'Hatchback', 1.4, 100, 'KMHGT41D5KU123456', 1, 'Manualna', 'FWD', 0, 5, 5, 1, 'Korea Południowa', '2019-07-10', 'KR54321', 'Klimatyzacja, Nawigacja GPS', 'Dobry', 'Dostępny'),
(15, 'Fiat', '500', 2018, 75000, 35000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Hatchback', 1.2, 69, 'ZFA31200003456789', 0, 'Automatyczna', 'FWD', 0, 3, 4, 2, 'Włochy', '2018-02-15', 'KR65432', 'Bluetooth, Klimatyzacja', 'Bardzo Dobry', 'Dostępny'),
(16, 'Kia', 'Sportage', 2021, 20000, 145000.00, 'Diesel', 'Osobowy', 'Niebieski', 'SUV', 2.0, 136, 'KNAPG81F3N1234567', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Korea Południowa', '2021-04-01', 'KR76543', 'Kamera parkingowa, Podgrzewane siedzenia', 'Bardzo Dobry', 'Dostępny'),
(17, 'Subaru', 'Forester', 2020, 30000, 120000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.0, 150, 'JF2SJFFC4AH123456', 0, 'Manualna', 'AWD', 0, 5, 5, 1, 'Japonia', '2020-06-10', 'WAW43210', 'Napęd 4x4, Klimatyzacja automatyczna', 'Bardzo Dobry', 'Dostępny'),
(18, 'BMW', 'X5', 2020, 40000, 190000.00, 'Diesel', 'Osobowy', 'Biały', 'SUV', 3.0, 250, 'WBAKF61030B123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Niemcy', '2020-09-15', 'WAW54321', 'Skórzana tapicerka, Asystent parkowania', 'Bardzo Dobry', 'Dostępny'),
(19, 'Ford', 'Kuga', 2020, 30000, 115000.00, 'Diesel', 'Osobowy', 'Szary', 'SUV', 2.0, 150, 'WF0AXXGBBAM123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 1, 'Wielka Brytania', '2020-04-10', 'KR98765', 'Klimatyzacja, Podgrzewane siedzenia', 'Bardzo Dobry', 'Dostępny'),
(20, 'Volvo', 'V60', 2019, 45000, 125000.00, 'Diesel', 'Osobowy', 'Szary', 'Kombi', 2.0, 140, 'YV1FZBAC6K1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 3, 'Szwecja', '2019-05-10', 'KR11111', 'Asystent pasa ruchu, Kamera cofania', 'Bardzo Dobry', 'Dostępny'),
(21, 'Jeep', 'Renegade', 2020, 28000, 110000.00, 'Benzyna', 'Osobowy', 'Czarny', 'SUV', 1.3, 110, '1C4BU0000LP123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 4, 'USA', '2020-06-15', 'WAW11111', 'Nawigacja GPS, Klimatyzacja', 'Bardzo Dobry', 'Dostępny'),
(22, 'Tesla', 'Model 3', 2021, 15000, 200000.00, 'Elektryczny', 'Osobowy', 'Biały', 'Sedan', 0.0, 180, '5YJ3E1EA7MF123456', 0, 'Automatyczna', 'RWD', 0, 4, 5, 5, 'USA', '2021-03-01', 'EL12345', 'Autopilot, Podgrzewane fotele', 'Bardzo Dobry', 'Dostępny'),
(23, 'Seat', 'Leon', 2018, 60000, 78000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Hatchback', 1.4, 92, 'VSSZZZ5FZJR123456', 0, 'Manualna', 'FWD', 0, 5, 5, 6, 'Hiszpania', '2018-07-20', 'KR22222', 'Bluetooth, Klimatyzacja', 'Dobry', 'Dostępny'),
(24, 'Citroen', 'C3', 2020, 32000, 69000.00, 'Benzyna', 'Osobowy', 'Niebieski', 'Hatchback', 1.2, 82, 'VF7SXHMZ6KT123456', 0, 'Manualna', 'FWD', 0, 5, 5, 7, 'Francja', '2020-08-25', 'WAW22222', 'System audio, Klimatyzacja', 'Dobry', 'Dostępny'),
(25, 'Alfa Romeo', 'Giulia', 2019, 35000, 140000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Sedan', 2.0, 147, 'ZARFAMBN2K1234567', 0, 'Automatyczna', 'RWD', 0, 4, 5, 3, 'Włochy', '2019-06-15', 'KR33333', 'Skórzana tapicerka, Tempomat', 'Bardzo Dobry', 'Dostępny'),
(26, 'Lexus', 'NX300h', 2020, 27000, 165000.00, 'Hybryda', 'Osobowy', 'Biały', 'SUV', 2.5, 145, 'JTJBJRBZ6L2123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 4, 'Japonia', '2020-03-01', 'WAW33333', 'Kamera 360, Asystent parkowania', 'Bardzo Dobry', 'Dostępny'),
(27, 'Mini', 'Cooper', 2017, 50000, 74000.00, 'Benzyna', 'Osobowy', 'Zielony', 'Hatchback', 1.5, 100, 'WMWXM7C5XH1234567', 0, 'Manualna', 'FWD', 0, 3, 4, 5, 'Wielka Brytania', '2017-08-10', 'KR44444', 'Bluetooth, Klimatyzacja', 'Dobry', 'Dostępny'),
(28, 'Suzuki', 'Vitara', 2021, 18000, 97000.00, 'Benzyna', 'Osobowy', 'Srebrny', 'SUV', 1.4, 95, 'TSMJYB44S02123456', 0, 'Manualna', 'FWD', 0, 5, 5, 6, 'Japonia', '2021-06-10', 'WAW44444', 'Podgrzewane siedzenia, Tempomat', 'Bardzo Dobry', 'Dostępny'),
(29, 'Dacia', 'Duster', 2020, 40000, 65000.00, 'Benzyna', 'Osobowy', 'Pomarańczowy', 'SUV', 1.6, 84, 'UU1HSDABXLL123456', 0, 'Manualna', 'FWD', 0, 5, 5, 7, 'Rumunia', '2020-05-01', 'KR55555', 'Klimatyzacja, System multimedialny', 'Dobry', 'Dostępny'),
(30, 'Chevrolet', 'Cruze', 2016, 80000, 43000.00, 'Benzyna', 'Osobowy', 'Granatowy', 'Sedan', 1.8, 104, '1G1PE5SB6G1234567', 0, 'Manualna', 'FWD', 0, 4, 5, 1, 'USA', '2016-09-01', 'KR66666', 'Bluetooth, Klimatyzacja', 'Średni', 'Dostępny'),
(31, 'Toyota', 'Corolla', 2021, 12000, 97000.00, 'Hybryda', 'Osobowy', 'Biały', 'Sedan', 1.8, 90, 'JTDEPRAEXMJ123456', 0, 'Automatyczna', 'FWD', 0, 4, 5, 2, 'Japonia', '2021-03-10', 'WAW55555', 'Kamera cofania, System multimedialny', 'Bardzo Dobry', 'Dostępny'),
(32, 'Renault', 'Talisman', 2019, 48000, 88000.00, 'Diesel', 'Osobowy', 'Grafitowy', 'Kombi', 1.7, 110, 'VF1RFB008L1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 3, 'Francja', '2019-04-10', 'KR77777', 'Asystent pasa, Tempomat', 'Dobry', 'Dostępny'),
(33, 'Hyundai', 'Tucson', 2020, 30000, 118000.00, 'Benzyna', 'Osobowy', 'Niebieski', 'SUV', 1.6, 132, 'KMHJ381BBLU123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 1, 'Korea Południowa', '2020-09-01', 'WAW66666', 'Nawigacja, Bluetooth', 'Bardzo Dobry', 'Dostępny'),
(34, 'Mazda', 'CX-5', 2018, 55000, 115000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.2, 135, 'JMZKF4WLAJ1234567', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Japonia', '2018-06-01', 'KR88888', 'Skórzana tapicerka, Kamera cofania', 'Dobry', 'Zarezerwowany'),
(35, 'BMW', '5', 2021, 25000, 210000.00, 'Diesel', 'Osobowy', 'Czarny', 'Sedan', 2.0, 140, 'WBA5A5C52MC123456', 0, 'Automatyczna', 'RWD', 0, 4, 5, 7, 'Niemcy', '2021-02-01', 'WAW77777', 'Asystent jazdy nocnej, HUD', 'Bardzo Dobry', 'Dostępny'),
(36, 'Audi', 'Q2', 2020, 20000, 115000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'SUV', 1.0, 85, 'WAUZZZF39L1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 4, 'Niemcy', '2020-03-15', 'KR99999', 'System audio Bang&Olufsen, Kamera cofania', 'Bardzo Dobry', 'Dostępny'),
(37, 'Volkswagen', 'Passat', 2019, 40000, 125000.00, 'Diesel', 'Osobowy', 'Srebrny', 'Kombi', 2.0, 110, 'WVWGZZ3CZJE123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 5, 'Niemcy', '2019-07-01', 'WAW88888', 'Tempomat adaptacyjny, Bluetooth', 'Bardzo Dobry', 'Dostępny'),
(38, 'Opel', 'Insignia', 2018, 62000, 99000.00, 'Diesel', 'Osobowy', 'Grafitowy', 'Kombi', 2.0, 125, 'W0LGT8EG3J1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 6, 'Niemcy', '2018-03-10', 'KR00000', 'Nawigacja, System audio Bose', 'Dobry', 'Dostępny'),
(39, 'Citroen', 'C3', 2019, 30000, 52000.00, 'Benzyna', 'Osobowy', 'Biały', 'Hatchback', 1.2, 60, 'VF7SXHMZ6KT123454', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Francja', '2019-03-10', 'WAW33445', 'Bluetooth, Klimatyzacja', 'Dobry', 'Dostępny'),
(40, 'Seat', 'Leon', 2020, 20000, 97000.00, 'Diesel', 'Osobowy', 'Czarny', 'Kombi', 1.6, 85, 'VSSZZZ5FZLR123456', 0, 'Manualna', 'FWD', 0, 5, 5, 2, 'Hiszpania', '2020-07-20', 'KR87612', 'Tempomat, Nawigacja GPS', 'Bardzo Dobry', 'Dostępny'),
(41, 'Volvo', 'V60', 2021, 25000, 165000.00, 'Diesel', 'Osobowy', 'Szary', 'Kombi', 2.0, 140, 'YV1ZW71D9M1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 3, 'Szwecja', '2021-05-01', 'WAW99887', 'Skórzana tapicerka, Asystent pasa ruchu', 'Bardzo Dobry', 'Zarezerwowany'),
(42, 'Chevrolet', 'Cruze', 2018, 80000, 45000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Sedan', 1.6, 85, 'KL1JF5DE9BK123456', 0, 'Manualna', 'FWD', 0, 4, 5, 4, 'USA', '2018-08-12', 'KR11223', 'Klimatyzacja, Bluetooth', 'Dobry', 'Dostępny'),
(43, 'Dacia', 'Duster', 2020, 35000, 76000.00, 'Diesel', 'Osobowy', 'Pomarańczowy', 'SUV', 1.5, 81, 'UU1HSDCJ6LY123456', 0, 'Manualna', 'AWD', 0, 5, 5, 5, 'Rumunia', '2020-04-22', 'WAW55678', 'Napęd 4x4, Tempomat', 'Bardzo Dobry', 'Dostępny'),
(44, 'Alfa Romeo', 'Giulia', 2019, 45000, 140000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Sedan', 2.0, 147, 'ZARFAEBN5K7623456', 0, 'Automatyczna', 'RWD', 0, 4, 5, 6, 'Włochy', '2019-06-05', 'KR44556', 'Skórzana tapicerka, Nawigacja', 'Bardzo Dobry', 'Dostępny'),
(45, 'Tesla', 'Model 3', 2021, 15000, 210000.00, 'Elektryczny', 'Osobowy', 'Biały', 'Sedan', 0.0, 200, '5YJ3E1EA7MF123451', 0, 'Automatyczna', 'RWD', 0, 4, 5, 7, 'USA', '2021-02-15', 'EL12345', 'Autopilot, Podgrzewane fotele', 'Bardzo Dobry', 'Dostępny'),
(46, 'Suzuki', 'Vitara', 2018, 60000, 72000.00, 'Benzyna', 'Osobowy', 'Zielony', 'SUV', 1.6, 88, 'TSMLYDA2S00412345', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Japonia', '2018-09-20', 'KR76234', 'Klimatyzacja, Kamera cofania', 'Dobry', 'Dostępny'),
(47, 'Lexus', 'IS 300h', 2020, 30000, 180000.00, 'Hybryda', 'Osobowy', 'Czarny', 'Sedan', 2.5, 164, 'JTHBH5D2101234567', 0, 'Automatyczna', 'RWD', 0, 4, 5, 2, 'Japonia', '2020-12-01', 'WAW99876', 'System multimedialny, Asystent martwego pola', 'Bardzo Dobry', 'Dostępny'),
(48, 'Mini', 'Cooper', 2019, 40000, 98000.00, 'Benzyna', 'Osobowy', 'Niebieski', 'Hatchback', 1.5, 100, 'WMWXM5C54J3D12345', 0, 'Manualna', 'FWD', 0, 3, 4, 3, 'Wielka Brytania', '2019-10-10', 'KR33221', 'Tempomat, Klimatyzacja', 'Bardzo Dobry', 'Dostępny'),
(49, 'Jaguar', 'XE', 2020, 28000, 175000.00, 'Diesel', 'Osobowy', 'Szary', 'Sedan', 2.0, 132, 'SAJAB4BN6LCP12345', 0, 'Automatyczna', 'RWD', 0, 4, 5, 4, 'Wielka Brytania', '2020-05-22', 'WAW66778', 'Asystent parkowania, Skórzana tapicerka', 'Bardzo Dobry', 'Dostępny'),
(50, 'Mitsubishi', 'ASX', 2019, 50000, 78000.00, 'Benzyna', 'Osobowy', 'Srebrny', 'SUV', 1.6, 86, 'JMBXJGA2WLU123456', 0, 'Manualna', 'FWD', 0, 5, 5, 5, 'Japonia', '2019-08-01', 'KR55677', 'Podgrzewane siedzenia, Kamera cofania', 'Bardzo Dobry', 'Dostępny'),
(51, 'Jeep', 'Renegade', 2020, 32000, 95000.00, 'Diesel', 'Osobowy', 'Pomarańczowy', 'SUV', 1.6, 96, '1C4BU0000L1234567', 0, 'Manualna', 'FWD', 0, 5, 5, 6, 'USA', '2020-03-18', 'WAW44556', 'Asystent zjazdu, Bluetooth', 'Dobry', 'Dostępny'),
(52, 'Toyota', 'Corolla', 2021, 18000, 115000.00, 'Hybryda', 'Osobowy', 'Biały', 'Sedan', 1.8, 90, 'JTDBAMFJ0M1234567', 0, 'Automatyczna', 'FWD', 0, 4, 5, 7, 'Japonia', '2021-04-15', 'KR22334', 'System multimedialny, Tempomat', 'Bardzo Dobry', 'Dostępny'),
(53, 'Audi', 'Q3', 2020, 22000, 170000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.0, 140, 'WAUZZZF38L1234567', 0, 'Automatyczna', 'AWD', 0, 5, 5, 1, 'Niemcy', '2020-07-07', 'WAW78999', 'Skórzana tapicerka, Kamera 360', 'Bardzo Dobry', 'Zarezerwowany'),
(54, 'BMW', 'X3', 2019, 40000, 185000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.0, 140, 'WBABC32090L123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Niemcy', '2019-06-10', 'KR99888', 'Panoramiczny dach, Nawigacja', 'Bardzo Dobry', 'Dostępny'),
(55, 'Ford', 'Fiesta', 2017, 70000, 42000.00, 'Benzyna', 'Osobowy', 'Niebieski', 'Hatchback', 1.1, 63, 'WF0JXXGAHJH123456', 0, 'Manualna', 'FWD', 0, 5, 5, 3, 'Niemcy', '2017-04-11', 'WAW33211', 'Radio DAB, Bluetooth', 'Dobry', 'Dostępny'),
(56, 'Mazda', 'CX-5', 2020, 25000, 138000.00, 'Benzyna', 'Osobowy', 'Szary', 'SUV', 2.0, 121, 'JMZKF19F601234567', 0, 'Automatyczna', 'AWD', 0, 5, 5, 4, 'Japonia', '2020-09-30', 'KR66655', 'Kamera cofania, Skórzane fotele', 'Bardzo Dobry', 'Zarezerwowany'),
(57, 'Renault', 'Megane', 2018, 65000, 54000.00, 'Diesel', 'Osobowy', 'Czarny', 'Kombi', 1.5, 81, 'VF1RFB00C56712345', 0, 'Manualna', 'FWD', 0, 5, 5, 5, 'Francja', '2018-05-15', 'WAW11324', 'Czujniki parkowania, Klimatyzacja', 'Dobry', 'Dostępny'),
(58, 'Hyundai', 'Tucson', 2021, 20000, 142000.00, 'Benzyna', 'Osobowy', 'Biały', 'SUV', 1.6, 110, 'KMHJB81BAMU123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 6, 'Korea Południowa', '2021-03-20', 'KR55441', 'Tempomat, Podgrzewane fotele', 'Bardzo Dobry', 'Dostępny'),
(59, 'Peugeot', '308', 2019, 50000, 69000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Hatchback', 1.2, 96, 'VF3LCBHZMKT123456', 0, 'Manualna', 'FWD', 0, 5, 5, 7, 'Francja', '2019-11-11', 'WAW77112', 'Bluetooth, Nawigacja', 'Dobry', 'Dostępny'),
(60, 'Skoda', 'Scala', 2020, 22000, 77000.00, 'Benzyna', 'Osobowy', 'Srebrny', 'Hatchback', 1.0, 85, 'TMBJZ7NW4L1234567', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Czechy', '2020-07-25', 'KR88123', 'Klimatyzacja, Kamera cofania', 'Bardzo Dobry', 'Dostępny'),
(61, 'Subaru', 'Outback', 2019, 60000, 148000.00, 'Benzyna', 'Osobowy', 'Zielony', 'Kombi', 2.5, 129, 'JF1BS9KC5KG123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Japonia', '2019-10-15', 'WAW44321', 'Napęd 4x4, Skórzana tapicerka', 'Bardzo Dobry', 'Dostępny'),
(62, 'Fiat', 'Tipo', 2018, 75000, 43000.00, 'Benzyna', 'Osobowy', 'Szary', 'Sedan', 1.4, 70, 'ZFA12300006712345', 0, 'Manualna', 'FWD', 0, 4, 5, 3, 'Włochy', '2018-07-08', 'KR11322', 'Bluetooth, Klimatyzacja', 'Dobry', 'Dostępny'),
(63, 'Honda', 'HR-V', 2020, 30000, 99000.00, 'Benzyna', 'Osobowy', 'Czarny', 'SUV', 1.5, 96, 'SHHRC7750LU123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 4, 'Japonia', '2020-06-11', 'WAW88213', 'Asystent pasa, Nawigacja', 'Bardzo Dobry', 'Dostępny'),
(64, 'Volkswagen', 'Passat', 2019, 55000, 98000.00, 'Diesel', 'Osobowy', 'Biały', 'Sedan', 2.0, 110, 'WVWZZZ3CZLE123456', 0, 'Automatyczna', 'FWD', 0, 4, 5, 5, 'Niemcy', '2019-11-01', 'KR77882', 'Tempomat, Klimatyzacja dwustrefowa', 'Bardzo Dobry', 'Dostępny'),
(65, 'Nissan', 'Micra', 2017, 80000, 39000.00, 'Benzyna', 'Osobowy', 'Pomarańczowy', 'Hatchback', 0.9, 66, 'SJNFBAK13U1234567', 0, 'Manualna', 'FWD', 0, 5, 5, 6, 'Japonia', '2017-05-14', 'WAW11235', 'Bluetooth, Podgrzewane lusterka', 'Dobry', 'Dostępny'),
(66, 'Opel', 'Grandland X', 2021, 18000, 109000.00, 'Diesel', 'Osobowy', 'Granatowy', 'SUV', 1.5, 96, 'W0VDDHNS5M1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 7, 'Niemcy', '2021-05-28', 'KR99821', 'Nawigacja, Asystent parkowania', 'Bardzo Dobry', 'Dostępny'),
(67, 'Toyota', 'Yaris', 2020, 20000, 78000.00, 'Hybryda', 'Osobowy', 'Czerwony', 'Hatchback', 1.5, 85, 'VNKKL3D3XMA123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 1, 'Japonia', '2020-09-09', 'WAW44345', 'Bluetooth, Kamera cofania', 'Bardzo Dobry', 'Dostępny'),
(68, 'Mercedes-Benz', 'GLA', 2020, 15000, 165000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.0, 110, 'WDC1569031N123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Niemcy', '2020-03-03', 'KR33445', 'Nawigacja, Skórzane fotele', 'Bardzo Dobry', 'Dostępny');

-- --------------------------------------------------------

--
-- Table structure for table `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `id_rezerwacji` int(11) NOT NULL,
  `id_pojazdu` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `data_rezerwacji` date NOT NULL,
  `status` enum('Oczekująca','Zatwierdzona','Anulowana') NOT NULL,
  `wielkosc_zaliczki` decimal(10,2) DEFAULT NULL,
  `data_waznosci` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rezerwacje`
--

INSERT INTO `rezerwacje` (`id_rezerwacji`, `id_pojazdu`, `id_user`, `data_rezerwacji`, `status`, `wielkosc_zaliczki`, `data_waznosci`) VALUES
(6, 4, 5, '2025-05-14', 'Oczekująca', 15000.00, '2025-05-21'),
(7, 1, 6, '2025-05-08', 'Anulowana', 18000.00, '2025-05-15'),
(8, 29, 6, '2025-05-23', 'Oczekująca', 3250.00, '2025-05-30'),
(9, 6, 5, '2025-04-30', 'Oczekująca', 3750.00, '2025-05-07'),
(10, 6, 5, '2025-04-30', 'Oczekująca', 3750.00, '2025-05-07'),
(11, 25, 5, '2025-05-03', 'Oczekująca', 14000.00, '2025-05-10'),
(12, 25, 6, '2025-05-29', 'Anulowana', 28000.00, '2025-06-05'),
(13, 25, 6, '2025-05-29', 'Anulowana', 28000.00, '2025-06-05'),
(14, 25, 6, '2025-05-29', 'Anulowana', 28000.00, '2025-06-05'),
(15, 25, 6, '2025-05-29', 'Anulowana', 28000.00, '2025-06-05'),
(16, 36, 6, '2025-05-26', 'Oczekująca', 5750.00, '2025-06-02'),
(17, 56, 8, '2025-05-19', 'Anulowana', 13800.00, '2025-05-26'),
(18, 56, 8, '2025-05-19', 'Anulowana', 27600.00, '2025-05-26'),
(19, 56, 8, '2025-05-20', 'Anulowana', 27600.00, '2025-05-27'),
(20, 9, 8, '2025-05-12', 'Anulowana', 5250.00, '2025-05-19'),
(21, 9, 8, '1111-11-11', 'Oczekująca', 5250.00, '1111-11-18'),
(23, 53, 8, '2025-05-18', 'Oczekująca', 8500.00, '2025-05-25'),
(24, 5, 8, '2025-05-18', 'Oczekująca', 4500.00, '2025-05-25'),
(25, 5, 8, '2025-05-18', 'Oczekująca', 18000.00, '2025-05-25'),
(26, 34, 8, '2025-05-18', 'Oczekująca', 5750.00, '2025-05-25'),
(27, 2, 8, '2025-05-18', 'Oczekująca', 5500.00, '2025-05-25'),
(28, 41, 5, '2025-05-18', 'Zatwierdzona', 8250.00, '2025-05-25'),
(29, 27, 8, '2025-05-30', 'Anulowana', 3700.00, '2025-06-06'),
(30, 39, 8, '2025-05-30', 'Anulowana', 2600.00, '2025-06-06'),
(31, 67, 8, '2025-05-30', 'Anulowana', 3900.00, '2025-06-06'),
(32, 17, 8, '2025-05-30', 'Anulowana', 6000.00, '2025-06-06');

-- --------------------------------------------------------

--
-- Table structure for table `transakcje`
--

CREATE TABLE `transakcje` (
  `id_transakcji` int(11) NOT NULL,
  `id_pojazdu` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `data_sprzedazy` date NOT NULL,
  `cena_sprzedazy` decimal(10,2) NOT NULL,
  `forma_platnosci` enum('Gotówka','Przelew','Kredyt','Inna') NOT NULL,
  `status` enum('Zrealizowana','Anulowana','W trakcie') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_user` int(11) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `rola` enum('Admin','Pracownik','Klient') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_user`, `imie`, `nazwisko`, `telefon`, `email`, `haslo`, `rola`) VALUES
(1, 'Jan', 'Kowalski', '501234567', 'jan.kowalski@example.com', 'haslo123', 'Klient'),
(4, 'Rafal', '', NULL, 'rafal@ok.pl', '$2y$10$jpDbUBpsGHt38Ke.8luX/urDEXHPjSG2igJpH2S4mT2M8KbXXYVmq', 'Admin'),
(5, 'Adam', '', NULL, 'a@a.pl', '$2y$10$quCpg5370Em66F0uJD672eYom0ICjab/iEB/LOmNIhon.Owpb1SgC', 'Admin'),
(6, 'Ryszard', '', NULL, 'poka@toka.pl', '$2y$10$fo5C2XQYCqr6FqFWzJlzG.v5p/41.AoK7N9tVdsBXWFH304MY/a8m', 'Klient'),
(7, 'Kamil', '', NULL, 'Kamil@Kamil.pl', '$2y$10$5piYMjEYnftZ8NvSwkbsXe.gY9Z/EOgKa4sJ9RsHckGN.hYoeL3X6', 'Klient'),
(8, 'Polek', 'Adam', '123123123', 'b@b.pl', '$2y$10$GK8Od6uPVpmuXxwqTuCVsuneffU2giJy1z4ckDXQm2yrDYf.UMoTK', 'Klient');

-- --------------------------------------------------------

--
-- Table structure for table `wiadomosci`
--

CREATE TABLE `wiadomosci` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefon` varchar(50) DEFAULT NULL,
  `wiadomosc` text NOT NULL,
  `data_wyslania` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wiadomosci`
--

INSERT INTO `wiadomosci` (`id`, `name`, `email`, `telefon`, `wiadomosc`, `data_wyslania`) VALUES
(1, 'Adam', 'a@a.pl', '123123123', 'ADam', '2025-05-30 12:24:55'),
(2, 'Adam', 'a@a.pla', '123321123', 'ddd', '2025-05-30 12:26:38'),
(3, 'Adam', 'a@a.pl', '123123123', 'DDDD', '2025-05-30 12:30:34'),
(4, 'Adam', 'a@a.pl', '123123123', 'faaf', '2025-05-30 12:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `zdjeciapojazdow`
--

CREATE TABLE `zdjeciapojazdow` (
  `id_zdjecia` int(11) NOT NULL,
  `id_pojazdu` int(11) NOT NULL,
  `sciezka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `historiaprzegladow`
--
ALTER TABLE `historiaprzegladow`
  ADD PRIMARY KEY (`id_przegladu`),
  ADD KEY `id_pojazdu` (`id_pojazdu`);

--
-- Indexes for table `historiaserwisowa`
--
ALTER TABLE `historiaserwisowa`
  ADD PRIMARY KEY (`id_historia`),
  ADD KEY `id_pojazdu` (`id_pojazdu`);

--
-- Indexes for table `lokacje`
--
ALTER TABLE `lokacje`
  ADD PRIMARY KEY (`id_lokacji`);

--
-- Indexes for table `opinie`
--
ALTER TABLE `opinie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pojazdy`
--
ALTER TABLE `pojazdy`
  ADD PRIMARY KEY (`id_pojazdu`),
  ADD UNIQUE KEY `vin` (`vin`),
  ADD KEY `id_lokacji` (`id_lokacji`);

--
-- Indexes for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id_rezerwacji`),
  ADD KEY `id_pojazdu` (`id_pojazdu`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `transakcje`
--
ALTER TABLE `transakcje`
  ADD PRIMARY KEY (`id_transakcji`),
  ADD KEY `id_pojazdu` (`id_pojazdu`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zdjeciapojazdow`
--
ALTER TABLE `zdjeciapojazdow`
  ADD PRIMARY KEY (`id_zdjecia`),
  ADD KEY `id_pojazdu` (`id_pojazdu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historiaprzegladow`
--
ALTER TABLE `historiaprzegladow`
  MODIFY `id_przegladu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `historiaserwisowa`
--
ALTER TABLE `historiaserwisowa`
  MODIFY `id_historia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT for table `lokacje`
--
ALTER TABLE `lokacje`
  MODIFY `id_lokacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `opinie`
--
ALTER TABLE `opinie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `pojazdy`
--
ALTER TABLE `pojazdy`
  MODIFY `id_pojazdu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id_rezerwacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `transakcje`
--
ALTER TABLE `transakcje`
  MODIFY `id_transakcji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wiadomosci`
--
ALTER TABLE `wiadomosci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zdjeciapojazdow`
--
ALTER TABLE `zdjeciapojazdow`
  MODIFY `id_zdjecia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historiaprzegladow`
--
ALTER TABLE `historiaprzegladow`
  ADD CONSTRAINT `historiaprzegladow_ibfk_1` FOREIGN KEY (`id_pojazdu`) REFERENCES `pojazdy` (`id_pojazdu`);

--
-- Constraints for table `historiaserwisowa`
--
ALTER TABLE `historiaserwisowa`
  ADD CONSTRAINT `historiaserwisowa_ibfk_1` FOREIGN KEY (`id_pojazdu`) REFERENCES `pojazdy` (`id_pojazdu`);

--
-- Constraints for table `pojazdy`
--
ALTER TABLE `pojazdy`
  ADD CONSTRAINT `pojazdy_ibfk_1` FOREIGN KEY (`id_lokacji`) REFERENCES `lokacje` (`id_lokacji`);

--
-- Constraints for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `rezerwacje_ibfk_1` FOREIGN KEY (`id_pojazdu`) REFERENCES `pojazdy` (`id_pojazdu`),
  ADD CONSTRAINT `rezerwacje_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `uzytkownicy` (`id_user`);

--
-- Constraints for table `transakcje`
--
ALTER TABLE `transakcje`
  ADD CONSTRAINT `transakcje_ibfk_1` FOREIGN KEY (`id_pojazdu`) REFERENCES `pojazdy` (`id_pojazdu`),
  ADD CONSTRAINT `transakcje_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `uzytkownicy` (`id_user`);

--
-- Constraints for table `zdjeciapojazdow`
--
ALTER TABLE `zdjeciapojazdow`
  ADD CONSTRAINT `zdjeciapojazdow_ibfk_1` FOREIGN KEY (`id_pojazdu`) REFERENCES `pojazdy` (`id_pojazdu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
