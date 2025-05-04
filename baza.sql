-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 03:31 PM
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
(2, 'Audi', 'A4', 2017, 65000, 110000.00, 'Diesel', 'Osobowy', 'Srebrny', 'Sedan', 2.0, 120, 'WAUZZZ8K9HA123456', 1, 'Manualna', 'FWD', 0, 4, 5, 1, 'Niemcy', '2017-05-10', 'WAW12345', 'Tempomat, Klimatyzacja automatyczna', 'Dobry', 'Dostępny'),
(3, 'Volkswagen', 'Golf', 2019, 40000, 85000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'Hatchback', 1.4, 100, 'WVWA1234567890123', 0, 'Automatyczna', 'FWD', 0, 5, 5, 2, 'Niemcy', '2019-03-20', 'KR54321', 'System audio premium, Kamera parkingowa', 'Bardzo Dobry', 'Dostępny'),
(4, 'Mercedes-Benz', 'C-Class', 2020, 30000, 150000.00, 'Diesel', 'Osobowy', 'Biały', 'Sedan', 2.1, 150, 'WDB20512345678901', 0, 'Automatyczna', 'RWD', 0, 4, 5, 1, 'Niemcy', '2020-09-15', 'WAW98765', 'Skórzana tapicerka, Asystent parkowania', 'Bardzo Dobry', 'Dostępny'),
(5, 'Skoda', 'Octavia', 2021, 25000, 90000.00, 'Benzyna', 'Osobowy', 'Szary', 'Kombi', 1.6, 110, 'TMBBJ5NU1M1234567', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Czechy', '2021-01-10', 'WAW11223', 'Klimatyzacja, System multimedialny', 'Bardzo Dobry', 'Dostępny'),
(6, 'Ford', 'Focus', 2018, 70000, 75000.00, 'Diesel', 'Osobowy', 'Zielony', 'Hatchback', 1.5, 120, 'WF0BXXGCBZ1112345', 1, 'Manualna', 'FWD', 0, 5, 5, 2, 'Wielka Brytania', '2018-06-01', 'KR65432', 'Tempomat, System audio Sony', 'Średni', 'Dostępny'),
(7, 'Toyota', 'Yaris', 2019, 40000, 65000.00, 'Benzyna', 'Osobowy', 'Biały', 'Hatchback', 1.3, 99, 'JTMBX3NX9KJ123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 1, 'Japonia', '2019-02-20', 'WAW76543', 'Klimatyzacja, Podgrzewane lusterka', 'Bardzo Dobry', 'Dostępny'),
(8, 'Peugeot', '308', 2020, 30000, 95000.00, 'Diesel', 'Osobowy', 'Czarny', 'Hatchback', 1.5, 120, 'VF3PCLFF8LM123456', 0, 'Manualna', 'FWD', 0, 5, 5, 2, 'Francja', '2020-05-15', 'KR87654', 'Asystent pasa ruchu, Tempomat', 'Bardzo Dobry', 'Dostępny'),
(9, 'Opel', 'Astra', 2021, 20000, 105000.00, 'Benzyna', 'Osobowy', 'Niebieski', 'Kombi', 1.6, 115, 'W0L0XCF68M1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 2, 'Niemcy', '2021-04-01', 'KR98765', 'Klimatyzacja, Nawigacja GPS', 'Bardzo Dobry', 'Dostępny'),
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
(34, 'Mazda', 'CX-5', 2018, 55000, 115000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.2, 135, 'JMZKF4WLAJ1234567', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Japonia', '2018-06-01', 'KR88888', 'Skórzana tapicerka, Kamera cofania', 'Dobry', 'Dostępny'),
(35, 'BMW', '5', 2021, 25000, 210000.00, 'Diesel', 'Osobowy', 'Czarny', 'Sedan', 2.0, 140, 'WBA5A5C52MC123456', 0, 'Automatyczna', 'RWD', 0, 4, 5, 7, 'Niemcy', '2021-02-01', 'WAW77777', 'Asystent jazdy nocnej, HUD', 'Bardzo Dobry', 'Dostępny'),
(36, 'Audi', 'Q2', 2020, 20000, 115000.00, 'Benzyna', 'Osobowy', 'Czerwony', 'SUV', 1.0, 85, 'WAUZZZF39L1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 4, 'Niemcy', '2020-03-15', 'KR99999', 'System audio Bang&Olufsen, Kamera cofania', 'Bardzo Dobry', 'Dostępny'),
(37, 'Volkswagen', 'Passat', 2019, 40000, 125000.00, 'Diesel', 'Osobowy', 'Srebrny', 'Kombi', 2.0, 110, 'WVWGZZ3CZJE123456', 0, 'Automatyczna', 'FWD', 0, 5, 5, 5, 'Niemcy', '2019-07-01', 'WAW88888', 'Tempomat adaptacyjny, Bluetooth', 'Bardzo Dobry', 'Dostępny'),
(38, 'Opel', 'Insignia', 2018, 62000, 99000.00, 'Diesel', 'Osobowy', 'Grafitowy', 'Kombi', 2.0, 125, 'W0LGT8EG3J1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 6, 'Niemcy', '2018-03-10', 'KR00000', 'Nawigacja, System audio Bose', 'Dobry', 'Dostępny'),
(39, 'Citroen', 'C3', 2019, 30000, 52000.00, 'Benzyna', 'Osobowy', 'Biały', 'Hatchback', 1.2, 60, 'VF7SXHMZ6KT123454', 0, 'Manualna', 'FWD', 0, 5, 5, 1, 'Francja', '2019-03-10', 'WAW33445', 'Bluetooth, Klimatyzacja', 'Dobry', 'Dostępny'),
(40, 'Seat', 'Leon', 2020, 20000, 97000.00, 'Diesel', 'Osobowy', 'Czarny', 'Kombi', 1.6, 85, 'VSSZZZ5FZLR123456', 0, 'Manualna', 'FWD', 0, 5, 5, 2, 'Hiszpania', '2020-07-20', 'KR87612', 'Tempomat, Nawigacja GPS', 'Bardzo Dobry', 'Dostępny'),
(41, 'Volvo', 'V60', 2021, 25000, 165000.00, 'Diesel', 'Osobowy', 'Szary', 'Kombi', 2.0, 140, 'YV1ZW71D9M1234567', 0, 'Automatyczna', 'FWD', 0, 5, 5, 3, 'Szwecja', '2021-05-01', 'WAW99887', 'Skórzana tapicerka, Asystent pasa ruchu', 'Bardzo Dobry', 'Dostępny'),
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
(53, 'Audi', 'Q3', 2020, 22000, 170000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.0, 140, 'WAUZZZF38L1234567', 0, 'Automatyczna', 'AWD', 0, 5, 5, 1, 'Niemcy', '2020-07-07', 'WAW78999', 'Skórzana tapicerka, Kamera 360', 'Bardzo Dobry', 'Dostępny'),
(54, 'BMW', 'X3', 2019, 40000, 185000.00, 'Diesel', 'Osobowy', 'Czarny', 'SUV', 2.0, 140, 'WBABC32090L123456', 0, 'Automatyczna', 'AWD', 0, 5, 5, 2, 'Niemcy', '2019-06-10', 'KR99888', 'Panoramiczny dach, Nawigacja', 'Bardzo Dobry', 'Dostępny'),
(55, 'Ford', 'Fiesta', 2017, 70000, 42000.00, 'Benzyna', 'Osobowy', 'Niebieski', 'Hatchback', 1.1, 63, 'WF0JXXGAHJH123456', 0, 'Manualna', 'FWD', 0, 5, 5, 3, 'Niemcy', '2017-04-11', 'WAW33211', 'Radio DAB, Bluetooth', 'Dobry', 'Dostępny'),
(56, 'Mazda', 'CX-5', 2020, 25000, 138000.00, 'Benzyna', 'Osobowy', 'Szary', 'SUV', 2.0, 121, 'JMZKF19F601234567', 0, 'Automatyczna', 'AWD', 0, 5, 5, 4, 'Japonia', '2020-09-30', 'KR66655', 'Kamera cofania, Skórzane fotele', 'Bardzo Dobry', 'Dostępny'),
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
(16, 36, 6, '2025-05-26', 'Oczekująca', 5750.00, '2025-06-02');

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
(7, 'Kamil', '', NULL, 'Kamil@Kamil.pl', '$2y$10$5piYMjEYnftZ8NvSwkbsXe.gY9Z/EOgKa4sJ9RsHckGN.hYoeL3X6', 'Klient');

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
  MODIFY `id_przegladu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `historiaserwisowa`
--
ALTER TABLE `historiaserwisowa`
  MODIFY `id_historia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lokacje`
--
ALTER TABLE `lokacje`
  MODIFY `id_lokacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pojazdy`
--
ALTER TABLE `pojazdy`
  MODIFY `id_pojazdu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id_rezerwacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transakcje`
--
ALTER TABLE `transakcje`
  MODIFY `id_transakcji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
