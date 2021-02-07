-- Dumping structure for table simpeg.skp
CREATE TABLE IF NOT EXISTS `skp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL DEFAULT '2000',
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '',
  `pejabat_id` int(11) DEFAULT NULL,
  `atasan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table simpeg.skp_kegiatan
CREATE TABLE IF NOT EXISTS `skp_kegiatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skp_id` int(11) NOT NULL,
  `kegiatan` text NOT NULL,
  `qty_volume` float NOT NULL DEFAULT '0',
  `qty_satuan` varchar(50) NOT NULL DEFAULT '',
  `kualitas` float NOT NULL DEFAULT '0',
  `wkt_lama` float NOT NULL DEFAULT '0',
  `wkt_satuan` varchar(50) NOT NULL DEFAULT '',
  `biaya` float NOT NULL DEFAULT '0',
  `nilai` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skp_id` (`skp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
