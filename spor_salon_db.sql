-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 08:22 AM
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
-- Database: `spor_salon_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dersler`
--

CREATE TABLE `dersler` (
  `ders_id` int(11) NOT NULL,
  `ad` varchar(80) NOT NULL,
  `seviye` enum('Baslangic','Orta','Ileri') NOT NULL DEFAULT 'Baslangic',
  `egitmen_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dersler`
--

INSERT INTO `dersler` (`ders_id`, `ad`, `seviye`, `egitmen_id`) VALUES
(1, 'Yoga', 'Baslangic', 3),
(2, 'Pilates', 'Orta', 1),
(3, 'Fitness', 'Ileri', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ders_oturumlari`
--

CREATE TABLE `ders_oturumlari` (
  `oturum_id` int(11) NOT NULL,
  `ders_id` int(11) NOT NULL,
  `baslangic` datetime NOT NULL,
  `salon` varchar(30) NOT NULL,
  `kapasite` int(11) NOT NULL
) ;

--
-- Dumping data for table `ders_oturumlari`
--

INSERT INTO `ders_oturumlari` (`oturum_id`, `ders_id`, `baslangic`, `salon`, `kapasite`) VALUES
(1, 1, '2025-12-30 18:00:00', 'Salon 1', 15),
(2, 2, '2025-12-31 19:00:00', 'Salon 2', 12),
(3, 3, '2026-01-01 20:00:00', 'Salon 1', 20);

-- --------------------------------------------------------

--
-- Table structure for table `egitmenler`
--

CREATE TABLE `egitmenler` (
  `egitmen_id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `uzmanlik` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `egitmenler`
--

INSERT INTO `egitmenler` (`egitmen_id`, `ad_soyad`, `telefon`, `uzmanlik`) VALUES
(1, 'Ayse Demir', '0555 111 2233', 'Pilates'),
(2, 'Mehmet Kaya', '0555 222 3344', 'Fitness'),
(3, 'Elif Yilmaz', '0555 333 4455', 'Yoga');

-- --------------------------------------------------------

--
-- Table structure for table `rezervasyonlar`
--

CREATE TABLE `rezervasyonlar` (
  `rezervasyon_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `oturum_id` int(11) NOT NULL,
  `kayit_zamani` datetime NOT NULL DEFAULT current_timestamp(),
  `durum` enum('kaydoldu','iptal','katildi') NOT NULL DEFAULT 'kaydoldu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rezervasyonlar`
--

INSERT INTO `rezervasyonlar` (`rezervasyon_id`, `uye_id`, `oturum_id`, `kayit_zamani`, `durum`) VALUES
(1, 1, 2, '2025-12-30 09:14:27', 'kaydoldu'),
(3, 1, 3, '2025-12-30 09:15:52', 'kaydoldu');

-- --------------------------------------------------------

--
-- Table structure for table `uyeler`
--

CREATE TABLE `uyeler` (
  `uye_id` int(11) NOT NULL,
  `ad` varchar(50) NOT NULL,
  `soyad` varchar(50) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `paket_id` int(11) DEFAULT NULL,
  `uyelik_baslangic` date DEFAULT NULL,
  `uyelik_bitis` date DEFAULT NULL,
  `durum` enum('aktif','pasif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uyeler`
--

INSERT INTO `uyeler` (`uye_id`, `ad`, `soyad`, `telefon`, `email`, `paket_id`, `uyelik_baslangic`, `uyelik_bitis`, `durum`) VALUES
(1, 'Deniz', 'Aydin', '05550000000', 'deniz.aydin@example.com', 1, NULL, NULL, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `uyelik_paketleri`
--

CREATE TABLE `uyelik_paketleri` (
  `paket_id` int(11) NOT NULL,
  `ad` varchar(50) NOT NULL,
  `sure_gun` int(11) NOT NULL,
  `ucret` decimal(10,2) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uyelik_paketleri`
--

INSERT INTO `uyelik_paketleri` (`paket_id`, `ad`, `sure_gun`, `ucret`, `aktif`) VALUES
(1, 'Aylik', 30, 800.00, 1),
(2, 'Uclu Aylik', 90, 2100.00, 1),
(3, 'Yillik', 365, 7000.00, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dersler`
--
ALTER TABLE `dersler`
  ADD PRIMARY KEY (`ders_id`),
  ADD KEY `fk_dersler_egitmen` (`egitmen_id`);

--
-- Indexes for table `ders_oturumlari`
--
ALTER TABLE `ders_oturumlari`
  ADD PRIMARY KEY (`oturum_id`),
  ADD KEY `fk_oturum_ders` (`ders_id`);

--
-- Indexes for table `egitmenler`
--
ALTER TABLE `egitmenler`
  ADD PRIMARY KEY (`egitmen_id`);

--
-- Indexes for table `rezervasyonlar`
--
ALTER TABLE `rezervasyonlar`
  ADD PRIMARY KEY (`rezervasyon_id`),
  ADD UNIQUE KEY `uq_uye_oturum` (`uye_id`,`oturum_id`),
  ADD KEY `fk_rez_oturum` (`oturum_id`);

--
-- Indexes for table `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`uye_id`),
  ADD UNIQUE KEY `uq_uyeler_email` (`email`),
  ADD KEY `fk_uyeler_paket` (`paket_id`);

--
-- Indexes for table `uyelik_paketleri`
--
ALTER TABLE `uyelik_paketleri`
  ADD PRIMARY KEY (`paket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dersler`
--
ALTER TABLE `dersler`
  MODIFY `ders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ders_oturumlari`
--
ALTER TABLE `ders_oturumlari`
  MODIFY `oturum_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `egitmenler`
--
ALTER TABLE `egitmenler`
  MODIFY `egitmen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rezervasyonlar`
--
ALTER TABLE `rezervasyonlar`
  MODIFY `rezervasyon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `uye_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uyelik_paketleri`
--
ALTER TABLE `uyelik_paketleri`
  MODIFY `paket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dersler`
--
ALTER TABLE `dersler`
  ADD CONSTRAINT `fk_dersler_egitmen` FOREIGN KEY (`egitmen_id`) REFERENCES `egitmenler` (`egitmen_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ders_oturumlari`
--
ALTER TABLE `ders_oturumlari`
  ADD CONSTRAINT `fk_oturum_ders` FOREIGN KEY (`ders_id`) REFERENCES `dersler` (`ders_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rezervasyonlar`
--
ALTER TABLE `rezervasyonlar`
  ADD CONSTRAINT `fk_rez_oturum` FOREIGN KEY (`oturum_id`) REFERENCES `ders_oturumlari` (`oturum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rez_uye` FOREIGN KEY (`uye_id`) REFERENCES `uyeler` (`uye_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uyeler`
--
ALTER TABLE `uyeler`
  ADD CONSTRAINT `fk_uyeler_paket` FOREIGN KEY (`paket_id`) REFERENCES `uyelik_paketleri` (`paket_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
