-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ajar`;
CREATE TABLE `ajar` (
  `id_ajar` varchar(40) NOT NULL,
  `id_dosen` varchar(40) NOT NULL,
  `id_matakuliah` varchar(40) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `created_at` date DEFAULT NULL,
  `edited_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id_ajar`),
  KEY `id_dosen` (`id_dosen`),
  KEY `id_matakuliah` (`id_matakuliah`),
  CONSTRAINT `ajar_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`),
  CONSTRAINT `ajar_ibfk_2` FOREIGN KEY (`id_matakuliah`) REFERENCES `matakuliah` (`id_matakuliah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `det_bayar_semester`;
CREATE TABLE `det_bayar_semester` (
  `id_bayar` varchar(40) NOT NULL,
  `semester` enum('1','2','3','4','5','6','7','8') NOT NULL,
  `cicilan` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  KEY `id_bayar` (`id_bayar`),
  CONSTRAINT `det_bayar_semester_ibfk_1` FOREIGN KEY (`id_bayar`) REFERENCES `pembayaran` (`id_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `det_bayar_spi`;
CREATE TABLE `det_bayar_spi` (
  `id_bayar` varchar(40) NOT NULL,
  `cicilan` int(11) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  KEY `id_bayar` (`id_bayar`),
  CONSTRAINT `det_bayar_spi_ibfk_1` FOREIGN KEY (`id_bayar`) REFERENCES `pembayaran` (`id_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `dosen`;
CREATE TABLE `dosen` (
  `id_dosen` varchar(40) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('1','0') NOT NULL,
  `agama` varchar(35) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `created_at` date NOT NULL,
  `edited_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id_dosen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `jurusan`;
CREATE TABLE `jurusan` (
  `id_jurusan` varchar(40) NOT NULL,
  `kode_jurusan` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` date NOT NULL,
  `edited_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `nim` varchar(40) NOT NULL,
  `id_jurusan` varchar(40) NOT NULL,
  `id_uangkuliah` varchar(40) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('1','0') NOT NULL,
  `agama` varchar(35) NOT NULL,
  `kelas` varchar(5) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `semester` enum('0','1','2','3','4','5','6','7','8') NOT NULL DEFAULT '1',
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `spi` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `edited_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`nim`),
  KEY `id_jurusan` (`id_jurusan`),
  KEY `id_uangkuliah` (`id_uangkuliah`),
  CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`),
  CONSTRAINT `mahasiswa_ibfk_2` FOREIGN KEY (`id_uangkuliah`) REFERENCES `uangkuliah` (`id_uangkuliah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `matakuliah`;
CREATE TABLE `matakuliah` (
  `id_matakuliah` varchar(40) NOT NULL,
  `id_jurusan` varchar(40) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `sks` int(11) NOT NULL,
  `semester` enum('1','2','3','4','5','6','7','8') NOT NULL,
  `created_at` date NOT NULL,
  `edited_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id_matakuliah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nilai_lain`;
CREATE TABLE `nilai_lain` (
  `id_ajar` varchar(40) NOT NULL,
  `nim` varchar(40) NOT NULL,
  `pengambilan` int(11) NOT NULL,
  `nilai` float NOT NULL,
  KEY `id_ajar` (`id_ajar`),
  KEY `nim` (`nim`),
  CONSTRAINT `nilai_lain_ibfk_1` FOREIGN KEY (`id_ajar`) REFERENCES `ajar` (`id_ajar`),
  CONSTRAINT `nilai_lain_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nilai_uas`;
CREATE TABLE `nilai_uas` (
  `id_ajar` varchar(40) NOT NULL,
  `nim` varchar(40) NOT NULL,
  `nilai` float NOT NULL,
  KEY `id_ajar` (`id_ajar`),
  KEY `nim` (`nim`),
  CONSTRAINT `nilai_uas_ibfk_2` FOREIGN KEY (`id_ajar`) REFERENCES `ajar` (`id_ajar`),
  CONSTRAINT `nilai_uas_ibfk_3` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nilai_uts`;
CREATE TABLE `nilai_uts` (
  `id_ajar` varchar(40) NOT NULL,
  `nim` varchar(40) NOT NULL,
  `nilai` float NOT NULL,
  KEY `id_ajar` (`id_ajar`),
  KEY `nim` (`nim`),
  CONSTRAINT `nilai_uts_ibfk_1` FOREIGN KEY (`id_ajar`) REFERENCES `ajar` (`id_ajar`),
  CONSTRAINT `nilai_uts_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `orangtua`;
CREATE TABLE `orangtua` (
  `nim` varchar(40) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('0','1') NOT NULL,
  `agama` varchar(35) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  KEY `nim` (`nim`),
  CONSTRAINT `orangtua_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE `pembayaran` (
  `id_bayar` varchar(40) NOT NULL,
  `nim` varchar(40) NOT NULL,
  `tgl_bayar` date NOT NULL,
  PRIMARY KEY (`id_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tenggat_bayar`;
CREATE TABLE `tenggat_bayar` (
  `id_uangkuliah` varchar(40) NOT NULL,
  `tgl_buka` date NOT NULL,
  `tgl_tutup` date NOT NULL,
  KEY `id_uangkuliah` (`id_uangkuliah`),
  CONSTRAINT `tenggat_bayar_ibfk_1` FOREIGN KEY (`id_uangkuliah`) REFERENCES `uangkuliah` (`id_uangkuliah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `uangkuliah`;
CREATE TABLE `uangkuliah` (
  `id_uangkuliah` varchar(40) NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `edited_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `tgl_buka` date NOT NULL,
  `tgl_tutup` date NOT NULL,
  PRIMARY KEY (`id_uangkuliah`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `job` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `job`) VALUES
(33,	'Pegawai BAAK',	'baak',	'12345',	'BAAK');

-- 2017-08-16 00:15:46
