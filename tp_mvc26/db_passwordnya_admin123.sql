-- =====================================================================
-- Database : tp_mvc26
-- Password : admin123
-- Import   : mysql -u root -padmin123 < db_passwordnya_admin123.sql
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
-- Data contoh
-- ---------------------------------------------------------------------
INSERT INTO `lecturers` (`name`, `nidn`, `email`, `phone`, `join_date`) VALUES
  ('Budi Santoso', '0412038501', 'budi.santoso@example.ac.id', '081234567801', '2015-08-17'),
  ('Siti Aminah',  '0421059002', 'siti.aminah@example.ac.id',  '081234567802', '2018-01-08'),
  ('Andi Wijaya',  '0408118803', 'andi.wijaya@example.ac.id',  '081234567803', '2012-09-03'),
  ('Rina Kartika', '0430079204', 'rina.kartika@example.ac.id', '081234567804', '2020-02-10');

INSERT INTO `courses` (`lecturer_id`, `code`, `name`, `sks`, `semester`) VALUES
  (1, 'IF101', 'Pemrograman Web',   3, 4),
  (1, 'IF102', 'Basis Data',        3, 3),
  (2, 'IF103', 'Struktur Data',     3, 3),
  (2, 'SI201', 'Sistem Informasi Manajemen', 3, 5),
  (3, 'TK301', 'Jaringan Komputer', 2, 4);

INSERT INTO `research` (`lecturer_id`, `title`, `year`, `funding`) VALUES
  (1, 'Pengembangan Sistem Informasi Akademik Berbasis Web', 2023, 7500000.00),
  (2, 'Analisis Sentimen Media Sosial Menggunakan Machine Learning', 2024, 9000000.00),
  (3, 'Optimasi Jaringan Wireless pada Kampus', 2022, 5000000.00),
  (4, 'Sistem Pendukung Keputusan Penjadwalan Kuliah', 2024, 6500000.00);
