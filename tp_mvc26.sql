-- =====================================================================
-- Database : tp_mvc26
-- Import   : mysql -u root < tp_mvc26.sql
--            atau phpMyAdmin > Import
-- =====================================================================

DROP DATABASE IF EXISTS `tp_mvc26`;
CREATE DATABASE `tp_mvc26`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE `tp_mvc26`;

-- ---------------------------------------------------------------------
-- Tabel 1: lecturers (data dosen)
-- ---------------------------------------------------------------------
CREATE TABLE `lecturers` (
  `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(100) NOT NULL,
  `nidn`      VARCHAR(20)  NOT NULL,
  `email`     VARCHAR(100) NULL,
  `phone`     VARCHAR(20)  NULL,
  `join_date` DATE         NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_lecturers_nidn` (`nidn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Tabel 2: courses (mata kuliah) -> relasi ke lecturers
-- ---------------------------------------------------------------------
CREATE TABLE `courses` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `lecturer_id` INT UNSIGNED NULL,
  `code`        VARCHAR(10)  NOT NULL,
  `name`        VARCHAR(100) NOT NULL,
  `sks`         TINYINT UNSIGNED NOT NULL DEFAULT 3,
  `semester`    TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_courses_code` (`code`),
  KEY `idx_courses_lecturer` (`lecturer_id`),
  CONSTRAINT `fk_courses_lecturer`
    FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Tabel 3: research (penelitian) -> relasi ke lecturers
-- ---------------------------------------------------------------------
CREATE TABLE `research` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `lecturer_id` INT UNSIGNED NULL,
  `title`       VARCHAR(150) NOT NULL,
  `year`        SMALLINT UNSIGNED NOT NULL,
  `funding`     DECIMAL(12,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_research_lecturer` (`lecturer_id`),
  CONSTRAINT `fk_research_lecturer`
    FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Data contoh (Realistis)
-- ---------------------------------------------------------------------
INSERT INTO `lecturers` (`name`, `nidn`, `email`, `phone`, `join_date`) VALUES
  ('Prof. Dr. Budi Santoso, M.Kom.',     '0412038501', 'budi.santoso@upi.edu',   '0812-2145-8901', '2014-08-15'),
  ('Dr. Siti Aminah, S.Kom., M.Cs.',    '0421059002', 'siti.aminah@upi.edu',    '0821-3498-7622', '2018-01-10'),
  ('Andi Wijaya, S.T., M.T.',           '0408118803', 'andi.wijaya@upi.edu',    '0857-9812-4433', '2012-09-03'),
  ('Rina Kartika, S.Kom., M.Kom.',      '0430079204', 'rina.kartika@upi.edu',   '0813-8821-9054', '2020-02-17'),
  ('Dr. Hendra Gunawan, S.Si., M.T.',   '0415067805', 'hendra.gunawan@upi.edu', '0819-0456-1123', '2016-04-20');

INSERT INTO `courses` (`lecturer_id`, `code`, `name`, `sks`, `semester`) VALUES
  (1, 'IK210', 'Desain dan Pemrograman Berorientasi Objek', 3, 3),
  (1, 'IK410', 'Kecerdasan Buatan dan Sains Data',          3, 5),
  (2, 'IK220', 'Struktur Data dan Algoritma',               3, 3),
  (2, 'IK510', 'Pemrograman Web Berbasis Komponen',         3, 6),
  (3, 'IK330', 'Jaringan Komputer dan Komunikasi Data',      3, 4),
  (4, 'IK310', 'Sistem Manajemen Basis Data',               3, 4),
  (5, 'IK420', 'Rekayasa Perangkat Lunak',                  3, 5);

INSERT INTO `research` (`lecturer_id`, `title`, `year`, `funding`) VALUES
  (1, 'Penerapan Deep Learning untuk Deteksi Dini Retinopati Diabetik',                           2024, 35000000.00),
  (2, 'Pengembangan Intelligent Tutoring System Berbasis Gamifikasi Adaptif',                     2024, 25000000.00),
  (3, 'Analisis Kinerja Protokol Routing LoRaWAN pada Smart Campus',                              2023, 20000000.00),
  (4, 'Sistem Rekomendasi Jalur Karir Lulusan Menggunakan Graph Neural Network',                  2024, 30000000.00),
  (5, 'Pengembangan Arsitektur Microservices pada Sistem Monitoring Presensi Berbasis GPS',      2023, 22500000.00);
