-- Database Dump for FutsalKit
-- Created for UAS Pengembangan Aplikasi Web Dinamis Secukupnya

CREATE DATABASE IF NOT EXISTS `futsalkit`;
USE `futsalkit`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `matches`;
DROP TABLE IF EXISTS `players`;
DROP TABLE IF EXISTS `teams`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Table Users
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'manager') DEFAULT 'manager',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Table Teams
CREATE TABLE `teams` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `manager_id` INT NOT NULL,
  `team_name` VARCHAR(100) UNIQUE NOT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `contact_number` VARCHAR(20) NOT NULL,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Table Players
CREATE TABLE `players` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `team_id` INT NOT NULL,
  `player_name` VARCHAR(100) NOT NULL,
  `jersey_number` INT NOT NULL,
  `position` VARCHAR(50) NOT NULL,
  `identity_card` VARCHAR(255) DEFAULT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Table Matches
CREATE TABLE `matches` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tournament_name` VARCHAR(100) NOT NULL,
  `home_team_id` INT NOT NULL,
  `away_team_id` INT NOT NULL,
  `match_date` DATE NOT NULL,
  `match_time` TIME NOT NULL,
  `venue` VARCHAR(100) NOT NULL,
  `score_home` INT DEFAULT NULL,
  `score_away` INT DEFAULT NULL,
  `status` ENUM('scheduled', 'ongoing', 'finished') DEFAULT 'scheduled',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Seed Data
-- Passwords: admin123 and manager123 (hashed)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Super Admin FutsalKit', 'admin@futsalkit.com', '$2y$12$7qBiYIit23jSkQOzwDoY3ePsAEq0pCVvIfqGvN1bNL4FnbfQSSMSC', 'admin'),
(2, 'Manajer Barcelona', 'manager@futsalkit.com', '$2y$12$8io1r8lIEILMXea/4OVrvOjpMyHjwCtHgpgPcQLAJgVEukkdQTOtG', 'manager'),
(3, 'Manajer Madrid', 'madrid@futsalkit.com', '$2y$12$8io1r8lIEILMXea/4OVrvOjpMyHjwCtHgpgPcQLAJgVEukkdQTOtG', 'manager'),
(4, 'Manajer Manchester', 'manchester@futsalkit.com', '$2y$12$8io1r8lIEILMXea/4OVrvOjpMyHjwCtHgpgPcQLAJgVEukkdQTOtG', 'manager'),
(5, 'Manajer Garuda', 'garuda@futsalkit.com', '$2y$12$8io1r8lIEILMXea/4OVrvOjpMyHjwCtHgpgPcQLAJgVEukkdQTOtG', 'manager'),
(6, 'Manajer Nusantara', 'nusantara@futsalkit.com', '$2y$12$8io1r8lIEILMXea/4OVrvOjpMyHjwCtHgpgPcQLAJgVEukkdQTOtG', 'manager');

INSERT INTO `teams` (`id`, `manager_id`, `team_name`, `logo`, `contact_number`, `status`) VALUES
(1, 2, 'FC Barcelona Futsal', 'logo_barca.png', '08123456789', 'approved'),
(2, 3, 'Real Madrid Futsal', 'logo_madrid.png', '08987654321', 'pending'),
(3, 4, 'Manchester City Futsal', 'logo_manchester.png', '082112223333', 'approved'),
(4, 5, 'Garuda United Futsal', 'logo_garuda.png', '083144455566', 'approved'),
(5, 6, 'Nusantara Warriors Futsal', 'logo_nusantara.png', '085177788899', 'pending');

INSERT INTO `players` (`id`, `team_id`, `player_name`, `jersey_number`, `position`, `identity_card`, `photo`) VALUES
(1, 1, 'Lionel Messi', 10, 'Pivot - Inti', 'identity_01.png', 'player_01.jpg'),
(2, 1, 'Andres Iniesta', 8, 'Flank Kiri - Inti', 'identity_02.png', 'player_02.jpg'),
(3, 1, 'Xavi Hernandez', 6, 'Anchor - Inti', 'identity_03.png', 'player_03.jpg'),
(4, 1, 'Carles Puyol', 5, 'Flank Kanan - Inti', 'identity_04.png', 'player_04.jpg'),
(5, 1, 'Victor Valdes', 1, 'Kiper - Inti', 'identity_05.png', 'player_05.jpg'),
(6, 1, 'Sergio Busquets', 16, 'Anchor - Cadangan', 'identity_06.png', 'player_06.jpg'),
(7, 1, 'Pedro Rodriguez', 7, 'Flank Kanan - Cadangan', 'identity_07.png', 'player_07.jpg'),
(8, 1, 'David Villa', 9, 'Pivot - Cadangan', 'identity_08.png', 'player_08.jpg'),
(9, 1, 'Jordi Alba', 18, 'Flank Kiri - Cadangan', 'identity_09.png', 'player_09.jpg'),
(10, 1, 'Marc ter Stegen', 13, 'Kiper - Cadangan', 'identity_10.png', 'player_10.jpg'),
(11, 2, 'Karim Benzema', 9, 'Pivot - Inti', 'identity_11.png', 'player_11.jpg'),
(12, 2, 'Luka Modric', 10, 'Flank Kiri - Inti', 'identity_12.png', 'player_12.jpg'),
(13, 2, 'Toni Kroos', 8, 'Anchor - Inti', 'identity_13.png', 'player_13.jpg'),
(14, 2, 'Sergio Ramos', 4, 'Flank Kanan - Inti', 'identity_14.png', 'player_14.jpg'),
(15, 2, 'Iker Casillas', 1, 'Kiper - Inti', 'identity_15.png', 'player_15.jpg'),
(16, 2, 'Vinicius Junior', 7, 'Flank Kanan - Cadangan', 'identity_16.png', 'player_16.jpg'),
(17, 2, 'Rodrygo Goes', 11, 'Pivot - Cadangan', 'identity_17.png', 'player_17.jpg'),
(18, 2, 'Federico Valverde', 15, 'Anchor - Cadangan', 'identity_18.png', 'player_18.jpg'),
(19, 2, 'Marcelo Vieira', 12, 'Flank Kiri - Cadangan', 'identity_19.png', 'player_19.jpg'),
(20, 2, 'Thibaut Courtois', 13, 'Kiper - Cadangan', 'identity_20.png', 'player_20.jpg'),
(21, 3, 'Erling Haaland', 9, 'Pivot - Inti', 'identity_21.png', 'player_21.jpg'),
(22, 3, 'Kevin De Bruyne', 17, 'Flank Kiri - Inti', 'identity_22.png', 'player_22.jpg'),
(23, 3, 'Rodri Hernandez', 16, 'Anchor - Inti', 'identity_23.png', 'player_23.jpg'),
(24, 3, 'Phil Foden', 47, 'Flank Kanan - Inti', 'identity_24.png', 'player_24.jpg'),
(25, 3, 'Ederson Moraes', 31, 'Kiper - Inti', 'identity_25.png', 'player_25.jpg'),
(26, 3, 'Bernardo Silva', 20, 'Flank Kanan - Cadangan', 'identity_26.png', 'player_26.jpg'),
(27, 3, 'Jack Grealish', 10, 'Flank Kiri - Cadangan', 'identity_27.png', 'player_27.jpg'),
(28, 3, 'Julian Alvarez', 19, 'Pivot - Cadangan', 'identity_28.png', 'player_28.jpg'),
(29, 3, 'Ruben Dias', 3, 'Anchor - Cadangan', 'identity_29.png', 'player_29.jpg'),
(30, 3, 'Stefan Ortega', 18, 'Kiper - Cadangan', 'identity_30.png', 'player_30.jpg'),
(31, 4, 'Raka Pratama', 11, 'Pivot - Inti', 'identity_31.png', 'player_31.jpg'),
(32, 4, 'Dimas Saputra', 8, 'Flank Kiri - Inti', 'identity_32.png', 'player_32.jpg'),
(33, 4, 'Bayu Nugroho', 6, 'Anchor - Inti', 'identity_33.png', 'player_33.jpg'),
(34, 4, 'Fajar Mahendra', 7, 'Flank Kanan - Inti', 'identity_34.png', 'player_34.jpg'),
(35, 4, 'Arga Wiratama', 1, 'Kiper - Inti', 'identity_35.png', 'player_35.jpg'),
(36, 4, 'Rizky Ramadhan', 14, 'Pivot - Cadangan', 'identity_36.png', 'player_36.jpg'),
(37, 4, 'Yoga Firmansyah', 15, 'Anchor - Cadangan', 'identity_37.png', 'player_37.jpg'),
(38, 4, 'Bagas Pamungkas', 17, 'Flank Kanan - Cadangan', 'identity_38.png', 'player_38.jpg'),
(39, 4, 'Ilham Maulana', 18, 'Flank Kiri - Cadangan', 'identity_39.png', 'player_39.jpg'),
(40, 4, 'Naufal Hidayat', 22, 'Kiper - Cadangan', 'identity_40.png', 'player_40.jpg'),
(41, 5, 'Aldi Setiawan', 10, 'Pivot - Inti', 'identity_41.png', 'player_41.jpg'),
(42, 5, 'Reno Kurnia', 9, 'Flank Kiri - Inti', 'identity_42.png', 'player_42.jpg'),
(43, 5, 'Galih Prakoso', 4, 'Anchor - Inti', 'identity_43.png', 'player_43.jpg'),
(44, 5, 'Farhan Akbar', 12, 'Flank Kanan - Inti', 'identity_44.png', 'player_44.jpg'),
(45, 5, 'Iqbal Maulana', 1, 'Kiper - Inti', 'identity_45.png', 'player_45.jpg'),
(46, 5, 'Tegar Wicaksono', 19, 'Pivot - Cadangan', 'identity_46.png', 'player_46.jpg'),
(47, 5, 'Hafiz Ramadhan', 20, 'Anchor - Cadangan', 'identity_47.png', 'player_47.jpg'),
(48, 5, 'Rafi Darmawan', 21, 'Flank Kanan - Cadangan', 'identity_48.png', 'player_48.jpg'),
(49, 5, 'Satria Wijaya', 23, 'Flank Kiri - Cadangan', 'identity_49.png', 'player_49.jpg'),
(50, 5, 'Reza Alfarizi', 25, 'Kiper - Cadangan', 'identity_50.png', 'player_50.jpg');

INSERT INTO `matches` (`id`, `tournament_name`, `home_team_id`, `away_team_id`, `match_date`, `match_time`, `venue`, `score_home`, `score_away`, `status`) VALUES
(1, 'Piala Rektor Futsal 2026', 1, 2, '2026-08-20', '19:00:00', 'GOR Futsal Madya', NULL, NULL, 'scheduled'),
(2, 'Piala Rektor Futsal 2026', 3, 4, '2026-08-21', '20:00:00', 'GOR Futsal Madya', NULL, NULL, 'scheduled'),
(3, 'Piala Rektor Futsal 2026', 1, 3, '2026-08-22', '18:30:00', 'Arena Kampus Utama', NULL, NULL, 'scheduled');
