-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dbsurat
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.38-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2022_04_16_060511_create_t_surat_masuk',1),(6,'2022_04_19_211315_create_t_jabatan',1),(7,'2022_04_20_035446_create_disposisi',1),(8,'2022_08_05_004241_create_suratkeluar_models_table',1),(9,'2022_08_05_033512_create_ref_klasifikasis_table',1),(10,'2022_08_08_024524_create_role_models_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`(191),`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_klasifikasi`
--

DROP TABLE IF EXISTS `ref_klasifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_klasifikasi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_parent` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_klasifikasi`
--

LOCK TABLES `ref_klasifikasi` WRITE;
/*!40000 ALTER TABLE `ref_klasifikasi` DISABLE KEYS */;
INSERT INTO `ref_klasifikasi` VALUES (1,80,'OT.00','OT.00 Organisasi','Surat yang berhubungan dengan pembentukan, perubahan organisasi, uraian pekerjaan, pembahasan dan pertanggungjawabannya.',0,NULL,NULL,0),(2,80,'OT.01.1','OT.01.1 Perencanaan','Surat yang berhugungan dengan penyusunan perencanaan/program kerja oleh unit-unit MA secara keseluruhan, termasuk segala jenis pertemuan dalam rangka penentuan kebijaksanaan perencanaan.',0,NULL,NULL,0),(3,80,'OT.01.2','OT.01.2 Laporan','Surat yang berhubungan dengan laporan umum, monitoring dan unit kerja, laporan bulanan, laporan triwulan, laporan semester, laporan tahunan',0,NULL,NULL,0),(4,80,'OT.01.3','OT.01.3 Penyusunan Prosedur Kerja','Surat yang berkenaan dengan penyusunan sistem, prosedur, pedoman, petunjuk pelaksanaan, tata kerja dan hubungan kerja',0,NULL,NULL,0),(5,80,'OT.01.4','OT.01.4 Penyusunan Pembakuan Sarana Kerja','Surat yang berhubungan dengan segala kegiatan yang berhubungan dengan penyusuanan pembakuan sarana kerja yakni penentuan kualitas dan kuantitas yang meliputi: ukuran, jenis, merk, dan sebagainya',0,NULL,NULL,0),(6,76,'HM.00','HM.00 Penerangan','Surat yang berkenaan dengan segala kegiatan yang berkenaan dengan penerangan terhadap masyarakat tentang kegiatan MARI seperti konferensi pers, pameran, wawancara, dan penerangan dalam media massa lainnya.',0,NULL,NULL,0),(7,76,'HM.01.1','HM.01.1 Hubungan','Surat yang berkenaan dengan segala kegiatan intern MARI dengan pihak lain, baik dalam maupun luar negeri dalam bidang keumasan, koordinasi bakohumas, hearing DPR, POKJA, dan organisasi mass media.',0,NULL,NULL,0),(8,76,'HM.01.2','HM.01.2 Keprotokolan','Surat yang berkenaan dengan masalah keprotokolan, seperti: tamu-tamu pimpinan MARI dalam maupun luar negeri, kunjungan kerja pimpinan dan pejabat MARI, upacara hari nasional, HUT MARI.',0,NULL,NULL,0),(9,76,'HM.02.1','HM.02.1 Dokumentasi','Surat yang berkenaan dengan kegiatan yang berhubungan dengan penyediaan/pengumpulan bahan/dokumentasi termasuk penyebarannya',0,NULL,NULL,0),(10,76,'HM.02.2','HM.02.2 Kepustakaan','Surat yang berkenaan dengan penyediaan, pengumpulan, dan penataan bahan-bahan kepustakaan.',0,NULL,NULL,0),(11,76,'HM.02.3','HM.02.3 Teknologi Informasi','Surat yang berhubungan dengan kegiatan, perencanaan, pemeliharaan, penyediaan, pengelolaan IT',0,NULL,NULL,0),(12,77,'KP.00.1','KP.00.1 Formasi Kepegawaian','Surat yang berkenaan dengan perencanaan pengadaan pegawai, nota usul formasi, sampai dengan persetujuan termasuk di dalamnya besetting',0,NULL,NULL,0),(13,77,'KP.00.2','KP.00.2 Penerimaan Pegawai','Surat yang berkenaan dengan penerimaan pegawai baru, mulai dan pengumuman penerimaan, panggilan testing/psikotes/clearance test, sampai dengan pengumuman yang diterima termasuk di dalamnya pegawai honorer, seperti: satpam, petugas pramusaji, supir.',0,NULL,NULL,0),(14,77,'KP.00.3','KP.00.3 Pengangkatan Pegawai','Surat yang berkenaan dengan seluruh proses pengangkatan dan penempatan CPNS sampai menjadi PNS mulai dari persyaratan, pemeriksaan kesehatan dan keterangan-keterangan lainnya yang berhubungan dengan penangkatan',0,NULL,NULL,0),(15,77,'KP.01.1','KP.01.1 Izin/Dispensasi','Surat izin tidak masuk kerja oleh pegawai yang bersangkutan maupun dispensasi olah instansi lain, izin belajar.',0,NULL,NULL,0),(16,77,'KP.01.2','KP.01.2 Keterangan Pegawai','Surat yang berkenaan dengan data dan keterangan pegawai dan keluarganya termasuk NIP, KARPEG, KARSU/KARSI',0,NULL,NULL,0),(17,77,'KP.02.1','KP.02.1 Penilaian Pegawai','surat yang berkenaan dengan pekerjaan, disiplin pegawai, pemalsuan administrasi kepegawaian, rehabilitasi dan pemulihan nama baik.',0,NULL,NULL,0),(18,77,'KP.02.2','KP.02.2 Hukuman Pegawai','Surat yang berkenaan dengan teguran tertulis, penundaan kenaikan gaji berkala, penurunan gaji, penurunan pangkat, pembebasan jabatan, pemberhentian dengan hormat tidak atas permintaan sendiri, pemberhentian tidak dengan hormat sebagai PNS.',0,NULL,NULL,0),(19,77,'KP.03','KP.03 Pembinaan Mental','Surat yang berkenaan dengan pembinaan mental pegawai serta pembinaan kerohanian.',0,NULL,NULL,0),(20,77,'KP.04.1','KP.04.1 Kepangkatan','Surat yang berkenaan dengan kenaikan pangkat/golongan, termasuk ujian dinas, penyesuaian ijazah, dan daftar urut kepangkatan.',0,NULL,NULL,0),(21,77,'KP.04.2','KP.04.2 Kenaikan Gaji Berkala','Surat yang berkenaan dengan kenaikan gaji berkala.',0,NULL,NULL,0),(22,77,'KP.04.3','KP.04.3 Penyesuaian Masa Kerja','Surat yang berkenaan dengan penyesuaian masa kerja untuk perubahan ruang gaji dan impassing.',0,NULL,NULL,0),(23,77,'KP.04.4','KP.04.4 Penyesuaian Tunjangan Keluarga','Surat yang berkenaan dengan penyesuaian tunjangan keluarga',0,NULL,NULL,0),(24,77,'KP.04.5','KP.04.5 Alih Tugas','Surat-surat yang berkenanaan dengan alih tugas bagi para pelaksana/staf, perpindahan dalam rangka pemantapan tugas kerja termasuk mengenai fasilitasnya.',0,NULL,NULL,0),(25,77,'KP.04.6','KP.04.6 Jabatan Struktural/Fungsional','Surat-surat yang berkenaan dengan pengangkatan dan pemberhentian dalam jabatan struktural/fungsional, termasuk tunjangan jabatan sewaktu penugasan atau pemberian kuasa untuk menjabat sementara',0,NULL,NULL,0),(26,77,'KP.05.1','KP.05.1 Kesehatan Pegawai','Surat-surat yang berkenaan dengan penyelenggaraan kesehatan bagi pegawai meliputi: asuransi kesehatan, general check up bagi pimpinan dan pejabat',0,NULL,NULL,0),(27,77,'KP.05.2','KP.05.2 Cuti Pegawai','Surat-surat yang berkenaan dengan cuti pegawai, meliputi:cuti sakit;cuti hamil;cuti diluar tanggungan negara',0,NULL,NULL,0),(28,77,'KP.05.3','KP.05.3 Rekreasi dan Olahraga','Surat-surat yang berkenaan dengan rekreasi dan olahraga',0,NULL,NULL,0),(29,77,'KP.05.4','KP.05.4 Bantuan Sosial','Surat-surat yang berkenaan dengan pemberian bantuan/tunjangan sosial kepada pegawai dan keluarga yang mengalami musibah, termasuk ucapan bela sungkawa',0,NULL,NULL,0),(30,77,'KP.05.5','KP.05.5 Koperasi','Surat-surat yang berkenaan dengan organisasi koperasi termasuk didalamnya masalah pengurusan kebutuhan bahan pokok',0,NULL,NULL,0),(31,77,'KP.05.6','KP.05.6 Perumahan Pegawai','Surat-surat yang berkenaan dengan perumahan pegawai, pejabat struktural/fungsional, pimpinan dan hakim agung',0,NULL,NULL,0),(32,77,'KP.05.7','KP.05.7 Antar Jemput','Surat-surat yang berkenaan dengan transportasi pegawai',0,NULL,NULL,0),(33,77,'KP.05.8','KP.05.8 Penghargaan','Surat-surat yang berkenaan dengan penghargaan, tanda jasa, satya lancana, dan sejenisnya',0,NULL,NULL,0),(34,79,'KU.00','KU.00 Akuntansi','Surat yang berkenaan dengan penyiapan bahan pelaksanaan dan pembinaan pembukuan keuangan serta penyusunan perhitungan anggaran',0,NULL,NULL,0),(35,79,'KU.01','KU.01 Pelaksanaan Anggaran','Surat yang berkenaan dengan penyiapan bahan bimbingan dalam pelaksanaan penggunaan anggaran dan pertanggung jawaban keuangan',0,NULL,NULL,0),(36,79,'KU.02','KU.02 Verifikasi dan Tuntutan Ganti Rugi','Surat yang berkenaan dengan penyiapan bahan pencatatan, penelitian, pembinaan dan penyusunan laporan tentang perivikasi dan tuntutan ganti rugi.',0,NULL,NULL,0),(37,79,'KU.03','KU.03 Perbendaharaan','Surat yang berkenaan dengan penyiapan bahan bimbingan dalam ketatausahan perbendaharaan, penyelesaian masalah dan pelaksanaan pembinaan perbendaharaan .',0,NULL,NULL,0),(38,79,'KU.04.1','KU.04.1 Pajak','Pajak',0,NULL,NULL,0),(39,79,'KU.04.2','KU.04.2 Bukan Pajak','Bukan Pajak',0,NULL,NULL,0),(40,79,'KU.05','KU.05 Perbankan','Perbankan',0,NULL,NULL,0),(41,79,'KU.06','KU.06 Sumbangan/Bantuan','Sumbangan/Bantuan',0,NULL,NULL,0),(42,78,'KS.00','KS.00 Kerumahtanggaan','Kerumahtanggaan',0,NULL,NULL,0),(43,82,'PL.01','PL.01 Gedung dan Rumah Dinas','Surat yang berhubungan dengan perencanaan,pengadaan,pemeliharaan dll gedung dan rumah',0,NULL,NULL,0),(44,82,'PL.02','PL.02 Tanah','Tanah',0,NULL,NULL,0),(45,82,'PL.03','PL.03 Alat Kantor','surat- yang berhubungan dengan perencanaan,pengadaan,pemeliharaan Alat Kantor',0,NULL,NULL,0),(46,82,'PL.04','PL.04 Mesin Kantor/Alat-Alat Elektronik','Surat yang berhubungan dengan perencanaan,pengadaan,pemeliharaan Mesin Kantor/Alat-Alat Elektronik',0,NULL,NULL,0),(47,82,'PL.05','PL.05 Perabotan Kantor','surat yang berhubungan dengan perencanaan,pengadaan,pemeliharaan,pengahpusan perabotan kantor',0,NULL,NULL,0),(48,82,'PL.06','PL.06 Kendaraan Bermotor','Kendaraan Bermotor Roda Empat, Roda Dua, dll',0,NULL,NULL,0),(49,82,'PL.07','PL.07 Inventarisasi Kantor','Surat yang berhubungan dengan Inventarisasi kantor',0,NULL,NULL,0),(50,82,'PL.08','PL.08 Penawaran Umum','Penawaran Umum',0,NULL,NULL,0),(51,82,'PL.09','PL.09 Ketatausahaan','Ketatausahaan',0,NULL,NULL,0),(52,75,'HK.00','HK.00 Peraturan Perundang-Undangan','Peraturan Perundang-Undangan',0,NULL,NULL,0),(53,75,'HK.01','HK.01 Pidana','Pidana',0,NULL,NULL,0),(54,75,'HK.02','HK.02 Perdata','Perdata',0,NULL,NULL,0),(55,75,'HK.03','HK.03 Perdata Niaga','Perdata Niaga',0,NULL,NULL,0),(56,75,'HK.04','HK.04 Pidana Militer','Pidana Militer',0,NULL,NULL,0),(57,75,'HK.05','HK.05 Perdata Agama','Perdata Agama',0,NULL,NULL,0),(58,75,'HK.06','HK.06 Tata Usaha Negara','Tata Usaha Negara',0,NULL,NULL,0),(59,75,'HK.07','HK.07 Pidana Khusus','Pidana Khusus',0,NULL,NULL,0),(60,83,'PP.00.1','PP.00.1 Hakim','Surat yang bekenaan dengan perencanaan, pelaksanaan dan evaluasi penyelenggaraan pendidikan dan pelatihan hakim',0,NULL,NULL,0),(61,83,'PP.00.2','PP.00.2 Panitera','Surat yang bekenaan dengan perencanaan, pelaksanaan dan evaluasi penyelenggaraan pendidikan dan pelatihan panitera',0,NULL,NULL,0),(62,83,'PP.00.3','PP.00.3 Jurusita','Surat yang berkenaan dengan perencaan, pelaksanaan dan evaluasi penyelenggaraan pendidikan dan pelatihan jurusita.',0,NULL,NULL,0),(63,83,'PP.00.4','PP.00.4 Teknis lainnya',' Surat yang berkenaan dengan perencanaan, pelaksanaan dan evaluasi pendidikan dan pelatihan teknis lainnya.',0,NULL,NULL,0),(64,83,'PP.01.1','PP.01.1 Pendidikan dan Latihan Manajemen Penjenjangan ','Surat yang berkenanan dengan pendidikan penjenjangan Diklatpim, LEMHANAS',0,NULL,NULL,0),(65,83,'PP.01.2','PP.01.2 Pendidikan dan Pelatihan Manajemen Kepangkatan','Pendidikan dan Pelatihan Manajemen Kepangkatan',0,NULL,NULL,0),(66,83,'PP.01.3','PP.01.3 Pendidikan dan Pelatihan Manajemen Latihan/Kursus/Penataran','Pendidikan dan Pelatihan Manajemen Latihan/Kursus/Penataran',0,NULL,NULL,0),(67,81,'PB.00','PB.00 Penelitian Hukum','Surat yang berkenaan dengan penelitian dan pengembangan hukum, sejak perencanaan, perizinan, pelaksanaan sampai pelaporan hasil penelitian.',0,NULL,NULL,0),(68,81,'PB.01','PB.01 Penelitian Peradilan','Surat yang berkenaan dengan penelitian dan pengembangan peradilan sejak perncanaan, perizinan, pelaksanaan sampai pelaporan hasil penelitian.',0,NULL,NULL,0),(69,81,'PB.02','PB.02 Pengembangan Penelitian','Surat yang berkenaan dengan masalah pengembangan penelitian dan perencanaan , pelaksanaan sampai pelaporan.',0,NULL,NULL,0),(70,84,'PS.00','PS.00 Penyelenggaraan Peradilan','Surat yang berkenaan pengawasan atas penyelenggaraan pelaksanaan peradilan.',0,NULL,NULL,0),(71,84,'PS.01','PS.01 Administrasi Peradilan','Surat yang berkenaan dengan pengawasan pengelolaan admistrasi peradilan, perkara dan umum.',0,NULL,NULL,0),(72,84,'PS.02','PS.02 Penanganan Pengaduan Masyarakat','Surat yang berkenaan dengan pengawasan pengaduan masyarakat terhadap perilaku aparat peradilan dan pelayanan publik oleh lembaga peradilan.',0,NULL,NULL,0),(73,76,'HM.02.2','HM.02.2 Kepustakaan','',0,NULL,NULL,0),(74,77,'KP.06','KP.06 Pemutusan Hubungan Kerja','Surat-surat yang berkenaan dengan pensiun pegawai termasuk jaminan-jaminan asuransi karena berhenti atas permintaan sendiri, berhenti dengan hormat bukan karena hukuman, pindah/keluar dari MARI dan meninggal dunia',0,NULL,NULL,0),(75,0,'HK','HUKUM',NULL,1,NULL,NULL,0),(76,0,'HM','HUBUNGAN MASYARAKAT ',NULL,1,NULL,NULL,0),(77,0,'KP','KEPEGAWAIAN',NULL,1,NULL,NULL,0),(78,0,'KS','KESEKRETARIATAN',NULL,1,NULL,NULL,0),(79,0,'KU','KEUANGAN',NULL,1,NULL,NULL,0),(80,0,'OT','ORGANISASI DAN TATA LAKSANA',NULL,1,NULL,NULL,0),(81,0,'PB','PENELITIAN DAN PENGEMBANGAN',NULL,1,NULL,NULL,0),(82,0,'PL','PERLENGKAPAN',NULL,1,NULL,NULL,0),(83,0,'PP','PENDIDIKAN DAN PELATIHAN',NULL,1,NULL,NULL,0),(84,0,'PS','PENGAWASAN',NULL,1,NULL,NULL,0);
/*!40000 ALTER TABLE `ref_klasifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_klasifikasi_baru`
--

DROP TABLE IF EXISTS `ref_klasifikasi_baru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_klasifikasi_baru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(45) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `uraian` text,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_klasifikasi_baru`
--

LOCK TABLES `ref_klasifikasi_baru` WRITE;
/*!40000 ALTER TABLE `ref_klasifikasi_baru` DISABLE KEYS */;
INSERT INTO `ref_klasifikasi_baru` VALUES (1,'HK1','Peraturan Perundang-undangan','Peraturan Perundang-undangan',0,0,NULL,NULL),(2,'HK1.1','Peraturan Perundang-Undangan Eksternal','Peraturan Perundang-Undangan Eksternal',1,0,NULL,NULL),(3,'HK1.1.1','Perpu','Peraturan Pemerintah Pengganti Undang-Undang',2,0,NULL,NULL),(4,'HK1.1.2','Peraturan Pemerintah','Peraturan Pemerintah',2,0,NULL,NULL),(5,'HK1.1.3','Peraturan Presiden','Peraturan Presiden',2,0,NULL,NULL),(6,'HK1.1.4','Keputusan Presiden','Keputusan Presiden',2,0,NULL,NULL),(7,'HK1.1.5','Instruksi Presiden','Instruksi Presiden',2,0,NULL,NULL),(8,'HK1.2','Peraturan Perundang-Undangan Internal','Peraturan Perundang-Undangan Internal',1,0,NULL,NULL),(9,'HK1.2.1','Peraturan Mahkamah Agung','Peraturan Mahkamah Agung',8,0,NULL,NULL),(10,'HK1.2.2','Instruksi','Instruksi',8,0,NULL,NULL),(11,'HK1.2.3','Surat Edaran','Surat Edaran',8,0,NULL,NULL),(12,'HK1.2.4','Maklumat Ketua Mahkamah Agung','Maklumat Ketua Mahkamah Agung',8,0,NULL,NULL),(13,'HK1.2.5','Keputusan','Keputusan',8,0,NULL,NULL),(14,'HK1.3','Surat Perjanjian/Nota Kesepahaman','Surat Perjanjian/Nota Kesepahaman',1,0,NULL,NULL),(15,'HK1.3.1','Dalam Negeri','Dalam Negeri',14,0,NULL,NULL),(16,'HK1.3.2','Luar Negeri','Luar Negeri',14,0,NULL,NULL),(17,'HK2','Penyelesaian perkara','Penyelesaian perkara Arsip yang berkaitan dengan penyelesaian perkara',0,0,NULL,NULL),(18,'HK2.1 ','Pidana umum','Pidana umum',17,0,NULL,NULL),(19,'HK2.2','Pidana khusus','Pidana khusus',17,0,NULL,NULL),(20,'HK2.3','Pidana militer','Pidana militer',17,0,NULL,NULL),(21,'HK2.4','Perdata Umum','Perdata Umum',17,0,NULL,NULL),(22,'HK2.5','Perdata niaga','Perdata niaga',17,0,NULL,NULL),(23,'HK2.6','Perdata agama','Perdata agama',17,0,NULL,NULL),(24,'HK2.7','Tata usaha negara','Tata usaha negara',17,0,NULL,NULL),(25,'HM','Humas dan Protokol','Humas dan Protokol',0,0,NULL,NULL),(26,'HM1 ','Hubungan Masyarakat','Hubungan Masyarakat',25,0,NULL,NULL),(27,'HM1.1','Publikasi informasi','Publikasi informasi',26,0,NULL,NULL),(28,'HM1.1.1','Penerangan dan publikasi','Penerangan dan publikasi Naskah',27,0,NULL,NULL),(29,'HM1.1.2','Pidato','Arsip yang berkaitan dengan pidato',27,0,NULL,NULL),(30,'HM1.2','Dokumentasi dan peliputan','Arsip yang berkaitan dengan dokumentasi acara yang diselenggarakan di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',26,0,NULL,NULL),(31,'HM2','Hubungan Kelembagaan','Hubungan Kelembagaan',25,0,NULL,NULL),(32,'HM2.1','Hubungan antar Lembaga','Hubungan antar Lembaga',31,0,NULL,NULL),(33,'HM2.1.1','Lembaga Pemerintah','Naskah yang berkaitan dengan kegiatan hubungan yang dijalan an tar Kernenterian, Lembaga dan Pemerintah Daerah',32,0,NULL,NULL),(34,'HM2.1.2','Lembaga Swasta','Naskah yang berkaitan dengan kegiatan hubungan dengan pihak swasta',32,0,NULL,NULL),(35,'HM2.1.3','Organisasi Sosial LSM','Naskah yang berkaitan dengan kegiatan hubungan dengan organisasi sosial LSM',32,0,NULL,NULL),(36,'HM2.1.4','Perguruan Tinggi','Naskah yang berkaitan dengan kegiatan hubungan dengan perguruan tinggi',32,0,NULL,NULL),(37,'HM3','Keprotokolan','Keprotokolan',25,0,NULL,NULL),(38,'HM3.1','Upacara dan Kegiatan resmi','Arsip yang berkaitan dengan kegiatan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya dalam bidang upacara , hari peringatan dan keprotokolan.',37,0,NULL,NULL),(39,'HM3.1.1','Upacaraj Acara Kedinasan','Arsip yang berkaitan dengan kegiatan protokoler termasuk upacara bendera, upacara hari besar nasional, hari jadi organisasi, upacara pelantikan, upacara serah terima dan hari besar keagamaan.',38,0,NULL,NULL),(40,'HM3.1.2','Kunjungan Dinas','Arsip yang berkaitan dengan kegiatan kunjungan dinas dalam dan luar negeri',38,0,NULL,NULL),(41,'HM3.1.3','Agenda pimpinan','Arsip yang berkaitan dengan kegiatan perencanaan, penjadwalan dan pelaksanaan agenda pimpinan seperti rapat pimpinan',38,0,NULL,NULL),(42,'KA','Kearsipan','Klasifikasi kearsipan meliputi melakukan pelaksanaan urusan persuratan, serta melakukan pengelolaan, pemeliharaan pemindahan, penyusunan jadwal retensi arsip dan penyusutan arsip di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya.',0,0,NULL,NULL),(43,'KA1','Kendali Arsip','Kendali Arsip',42,0,NULL,NULL),(44,'KA1.1','Pengendalian Dan Pengurusan Arsip','Arsip yang berkaitan dengan administrasi pengendalian Arsip masuk dan/ atau ke1uar meliputi kartu, lembaran, dan buku',43,0,NULL,NULL),(45,'KA1.2','Layanan Penggunaan Arsip','Arsip yang berkaitan dengan layanan penggunaan arsip meliputi permintaan fotokopi, pemmjaman dan/ atau legalisasi arsip',43,0,NULL,NULL),(46,'KA2','Pengelolaan Arsip','Pengelolaan Arsip',42,0,NULL,NULL),(47,'KA2.1','Penyimpanan Dan Pemeliharaan Arsip','Arsip yang berkaitan dengan kegiatan pemeliharaan dan perawatan arsip',46,0,NULL,NULL),(48,'KA2.1.1','Pengelolaan Arsip Aktif',NULL,47,0,NULL,NULL),(49,'KA2.1.2','Pengelolaan Arsip Inaktif',NULL,47,0,NULL,NULL),(50,'KA2.1.3','Pengelolaan Arsip Vital',NULL,47,0,NULL,NULL),(51,'KA2.1.4','Pengelolaan Arsip Terjaga',NULL,47,0,NULL,NULL),(52,'KA2.1.5','Perawatan Arsip',NULL,47,0,NULL,NULL),(53,'KA2.1.6','Penyelamatan dan Pemulihan Arsip',NULL,47,0,NULL,NULL),(54,'KA2.2','Penyusutan Arsip','Penyusutan Arsip',46,0,NULL,NULL),(55,'KA2.2.1','Pemindahan Arsip Inaktif',NULL,54,0,NULL,NULL),(56,'KA2.2.2','Pemusnahan Arsip',NULL,54,0,NULL,NULL),(57,'KA2.2.3','Penyerahan Arsip',NULL,54,0,NULL,NULL),(58,'KA2.3','Pengawasan Kearsipan','Pengawasan Kearsipan',46,0,NULL,NULL),(59,'KP','Kepegawaian','Kepegawaian',0,0,NULL,NULL),(60,'KP1','Pengadaan SDM',NULL,59,0,NULL,NULL),(61,'KP1.1','Perencanaan dan Seleksi',NULL,60,0,NULL,NULL),(62,'KP1.1.1','Hakim Agung',NULL,61,0,NULL,NULL),(63,'KP1.1.2','Hakim',NULL,61,0,NULL,NULL),(64,'KP1.1.3','Hakim Ad Hoc',NULL,61,0,NULL,NULL),(65,'KP1.1.4','Pejabat Pimpinan Tinggi Madya',NULL,61,0,NULL,NULL),(66,'KP1.1.5','Pejabat Pimpinan Tinggi Pratama',NULL,61,0,NULL,NULL),(67,'KP1.1.6','PNS',NULL,61,0,NULL,NULL),(68,'KP1.1.7','PPPK',NULL,61,0,NULL,NULL),(69,'KP1.1.8','Tenaga Ahli dan lain -lain',NULL,61,0,NULL,NULL),(70,'KP1.2','Pengangkatan',NULL,60,0,NULL,NULL),(71,'KP1.2.1','Hakim Agung',NULL,70,0,NULL,NULL),(72,'KP1.2.2','Hakim',NULL,70,0,NULL,NULL),(73,'KP1.2.3','Hakim Ad Hoc',NULL,70,0,NULL,NULL),(74,'KP1.2.4','Pejabat Pimpinan Tinggi Madya',NULL,70,0,NULL,NULL),(75,'KP1.2.5','Pejabat Pimpinan Tinggi Pratama',NULL,70,0,NULL,NULL),(76,'KP1.2.6','PNS',NULL,70,0,NULL,NULL),(77,'KP1.2.7','PPPK',NULL,70,0,NULL,NULL),(78,'KP1.2.8','Tenaga Ahli dan lain-lain',NULL,70,0,NULL,NULL),(79,'KP1.2.9','Pegawai Pindah Instansi','Pegawai Pindah Instansi masuk keluar Mahkamah Agung Pengisian Jabatan',70,0,NULL,NULL),(80,'KP2','Kepangkatan','Arsip yang berkaitan dengan pangkat / golongan',59,0,NULL,NULL),(81,'KP2.1','Pangkat / Golongan','Pangkat / Golongan',80,0,NULL,NULL),(82,'KP2.1.1','Kenaikan pangkat / golongan',NULL,81,0,NULL,NULL),(83,'KP2.1.2','Kenaikan gaji berkala',NULL,81,0,NULL,NULL),(84,'KP2.1.3','Penyesuaian masa kerja',NULL,81,0,NULL,NULL),(85,'KP3','Pengelolaan Kompetensi dan Manajemen Kinerja',NULL,59,0,NULL,NULL),(86,'KP3.1','Standar Kompetensi Jabatan',NULL,85,0,NULL,NULL),(87,'KP3.1.1','Standar Kompetensi Teknis Jabatan',NULL,86,0,NULL,NULL),(88,'KP3.1.2','Asesmen Sumber Daya Manusia',NULL,86,0,NULL,NULL),(89,'KP3.1.3','Profiling Pegawai',NULL,86,0,NULL,NULL),(90,'KP3.2','Ujian Kenaikan Pangkat / Ijazah',NULL,85,0,NULL,NULL),(91,'KP3.2.1','Ujian Penyesuaian Ijazah',NULL,90,0,NULL,NULL),(92,'KP3.2.2','Ujian Dinas',NULL,90,0,NULL,NULL),(93,'KP3.2.3','Ujian Kompetensi',NULL,90,0,NULL,NULL),(94,'KP3.3','Tugas Belajar / Izin Belajar',NULL,85,0,NULL,NULL),(95,'KP3.3.1','Tugas Belajar',NULL,94,0,NULL,NULL),(96,'KP3.3.2','Izin Belajar',NULL,94,0,NULL,NULL),(97,'KP3.4','Manajemen Kinerja Pegawai','Arsip yang berkaitan dengan manajemen kinerja',85,0,NULL,NULL),(98,'KP3.4.1','Perencanaan dan Pelaksanaan Kinerja Pegawai','Arsip yang berkaitan dengan kegiatan perencanaan dan pelaksanaan kinerja pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',97,0,NULL,NULL),(99,'KP3.4.2','Pembinaan Kinerja Pegawai','Arsip yang berkaitan dengan pembinaan kinerja pegawai seperti konseling kinerja, bimbingan kinerja, training kinerja, coaching kinerja dan mentoring kinerja pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya.',97,0,NULL,NULL),(100,'KP3.4.3','Evaluasi Kinerja Pegawai','Arsip yang berkaitan dengan kegiatan evaluasi kinerja pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',97,0,NULL,NULL),(101,'KP3.4.4','Penilaian Kinerja Jabatan Fungsional','Arsip yang berkaitan dengan kegiatan penilaian jabatan fungsional di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',97,0,NULL,NULL),(102,'KP3.4.5','Penetapan Jabatan dan Peringkat Pegawai','Arsip yang berkaitan dengan proses dan penetapan pelaksana dalam jabatan dan peringkat di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',97,0,NULL,NULL),(103,'KP3.4.6','Pemetaan Pegawai','Arsip yang berkaitan dengan kegiatan pemetaan pegawai',97,0,NULL,NULL),(104,'KP4','Manajemen Karier','Arsip yang berkaitan dengan manajemen karier di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',59,0,NULL,NULL),(105,'KP4.1','Pengembangan Karier','Arsip yang berkaitan dengan kegiatan Mahkamah Agung dalam pengembangan karier pegawai meliputi manajemen talenta, mutasi dan promosi, tim penilai kinerja, kenaikan pangkat, penghargaan dan tanda jasa',104,0,NULL,NULL),(106,'KP4.1.1','Pengembangan Karier Pegawai','Arsip yang berkaitan dengan rencana, pelaksanaan, pemantauan, dan evaluasi pengembangan karier dalam manajemen karier di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',105,0,NULL,NULL),(107,'KP4.1.2','Manajemen Talenta','Arsip yang berkaitan dengan analisis kebutuhan, identifikasi, pengembangan, retensi, dan evaluasi talent dalam rangka pola karir di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',105,0,NULL,NULL),(108,'KP4.1.3','Mutasi, Promosi dan Demosi','Arsip yang berkaitan dengan pelaksanaan promosi dan mutasi pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',105,0,NULL,NULL),(109,'KP4.1.4','Tim Penilai Kinerja Jabatan','Arsip yang berkaitan dengan persiapan, pelaksanaan, laporan sidang Tim Penilai Kinerja di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',105,0,NULL,NULL),(110,'KP4.1.5','Pemberhentian jabatan',NULL,105,0,NULL,NULL),(111,'KP5','Kesejahteraan Pegawai','Arsip yang berkaitan dengan kesejahteraan pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',59,0,NULL,NULL),(112,'KP5.1','Mutasi Keluarga','Arsip yang berkaitan dengan kegiatan pengelolaan data keluarga meliputi laporan perkawinan/perceraian dan laporan kelahiran/kematian keluarga',111,0,NULL,NULL),(113,'KP5.2','Layanan Kesehatan','Arsip yang berkaitan dengan kegiatan Surat Keterangan Sehat, Surat Keterangan Sakit, donor darah, medical checkup, perawatan gigi, pelayanan kesehatan, kartu berobat dan catatan medis',111,0,NULL,NULL),(114,'KP5.3','Cuti dan izin bepergian ke Luar Negeri di luar Kedinasan','Arsip yang berkaitan dengan cuti pegawai dan izin bepergian ke luar negeri, nota persetujuan, permohonan pengaktifan dan penetapan kembali setelah cuti diluar tanggungan negara',111,0,NULL,NULL),(115,'KP5.4','Kegiatan Sosial','Arsip yang berkaitan dengan pelayanan sosial dan kesejahteraan pegawai terkait rekreasi, olahraga, bantuan sosial, dan asuransi pegawai',111,0,NULL,NULL),(116,'KP5.5','Perumahan','Arsip yang berkaitan dengan perumahan pegawai, pejabat struktural / fungsional, pimpinan dan Hakim Agung',111,0,NULL,NULL),(117,'KP5.6','Koperasi','Arsip yang berkaitan dengan organisasi koperasi termasuk perencanaan, pengelolaan, laporan dan evaluasi',111,0,NULL,NULL),(118,'KP5.7','Transportasi antar jemput','Arsip yang berkaitan dengan pengelolaan transportasi menuju unit kerja',111,0,NULL,NULL),(119,'KP5.8','Penghargaan dan Tanda Jasa','Arsip Yang Berkaitan Dengan Penghargaan Dan Tanda Jasa Di Lingkungan Mahkamah Agung Dan Badan Peradilan yang Berada Di Bawahnya',111,0,NULL,NULL),(120,'KP6','Pemberhentian pegawai','Arsip yang berkaitan dengan pemberhentian pegawai Mahkamah Agung dan Badan Peradilan yang Berada Di Bawahnya, pemberhentian atas permintaan sendiri, mencapai batas usia pensiun, meninggal dunia, meninggal dunia karena tugas, perampingan organisasi/kebijakan pemerintah, tidak cakap jasmani dan/atau rohani, serta hilang/tewas',59,0,NULL,NULL),(121,'KP6.1','Pemberhentian Pegawai dengan Hak Pensiun','Arsip yang berkaitan dengan pemberhentian pegawai Mahkamah Agung dan Badan Peradilan yang Berada Di Bawahnya dengan hak pensiun',120,0,NULL,NULL),(122,'KP6.2','Pemberhentian Pegawai Tanpa Hak Pensiun','Arsip yang berkaitan dengan pemberhentian pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada Di Bawahnya dengan hak pensiun',120,0,NULL,NULL),(123,'KP6.3','Tewas, Hilang, Meninggal Dalam Tugas','Arsip yang berkaitan dengan berkas proses pemberhentian pegawai karena meninggal dunia, tewas, atau hilang dalam tugas',120,0,NULL,NULL),(124,'KP6.4','Pembinaan Mental, Agama dan Konseling','Arsip yang berkaitan dengan pembinaan komunitas dan kegiatan keagamaan, serta pengoordinasian program kegiatan kerohaniawanan di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada Di Bawahnya',120,0,NULL,NULL),(125,'KP7','Administrasi Sumber Daya Manusia','Arsip yang berkaitan dengan kegiatan Mahkamah Agung dalam administrasi pegawai meliputi perjalanan dinas dan identitas pegawai',59,0,NULL,NULL),(126,'KP7.1','Pelaksanaan Tugas Dalam Jabatan','Arsip yang berkaitan dengan kegiatan pelaksanaan tugas dalam jabatan di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',125,0,NULL,NULL),(127,'KP7.2','Dokumentasi Identitas Pegawai','Arsip yang berkaitan dengan dokumentasi identitas pegawai Mahkamah Agung',125,0,NULL,NULL),(128,'KP7.3','Laporan Pajak-Pajak Pribadi (LP2P) dan Laporan Harta Kekayaan (LHK)','Arsip yang berkaitan dengan dengan pelaporan perpajakan dan harta kekayaan pegawai Mahkamah Agung',125,0,NULL,NULL),(129,'KP7.4','Surat Penunjukan Pelaksana Tugas (Plt) dan Pelaksana Harian (Plh)','Arsip yang berkaitan dengan penunjukan Plt. (Pelaksana Tugas) dan/atau Plh. (Pelaksana Harian) di di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',125,0,NULL,NULL),(130,'KP7.5','Izin Perkawinan / Perceraian Pegawai','Arsip yang berkaitan dengan pemberian atau penolakan pemberian Izin beristri lebih dari satu orang / perceraian pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan Yang Berada di Bawahnya',125,0,NULL,NULL),(131,'KP8','Kode Etik dan Disiplin','Arsip yang berkaitan dengan kode etik, disiplin hakim / pegawai dan sanksi/hukuman disiplin hakim / pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada Di Bawahnya',59,0,NULL,NULL),(132,'KP8.1','Kode Etik dan Perilaku','Arsip yang berkaitan dengan penegakan dan peningkatan penerapan kode etik, kode perilaku, tata tertib, daftar hadir pegawai serta catatan pelanggaran pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada Di Bawahnya',131,0,NULL,NULL),(133,'KP8.2','Sanksi/Hukuman Disiplin Pegawai','Arsip yang berkaitan dengan proses pemberian sanksi/hukuman yang diberikan kepada pegawai yang melanggar peraturan atau tidak mematuhi tata tertib pegawai',131,0,NULL,NULL),(134,'KP8.3','Penyelesaian Keberatan/Banding','Arsip yang berkaitan dengan proses penyelesaian keberatan/banding administratif terkait dengan hukuman disiplin',131,0,NULL,NULL),(135,'KP8.4','Pemberhentian Berdasarkan Permasalahan Kepegawaian Lainnya','Arsip yang berkaitan dengan proses pemberian pemberhentian karena permasalahan kepegawaian lainnya seperti tidak lapor setelah selesai menjalankan Cuti di Luar Tanggungan Negara (CLTN),menjadi anggota partai politik, tidak lapor setelah menyelesaikan tugas belajar, pemberhetian sementara karena menjadi tersangka dan ditahan, pemberhentian karena melakukan tindak pidana/penyelewengan, pemberhentian sebagai CPNS, pemberhentian karena pemalsuan administrasi kepegawaian dan permasalahan kepegawaian lainnya',131,0,NULL,NULL),(136,'PL','Perlengkapan','Klasifikasi perlengkapan meliputi melaksanakan kegiatan pengelolaan Barang Milik Negara (BMN) dan pengadaan barang/jasa di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',0,0,NULL,NULL),(137,'PL1','Pengadaan Barang/Jasa, Pengelolaan dan Penatausahaan Barang Milik Negara ',NULL,136,0,NULL,NULL),(138,'PL1.1','Pengadaan Barang/Jasa',NULL,137,0,NULL,NULL),(139,'PL1.1.1','Pengadaan Barang Persediaan','Arsip yang berkaitan dengan kegiatan pengadaan barang di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',138,0,NULL,NULL),(140,'PL1.1.2','Pengadaan Barang Inventaris','Arsip yang berkaitan dengan kegiatan pengadaan barang di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',138,0,NULL,NULL),(141,'PL1.1.3','Pengadaan Barang','Arsip yang berkaitan dengan kegiatan pengadaan barang di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',138,0,NULL,NULL),(142,'PL1.1.4','Pengadaan Jasa','Arsip yang berkaitan dengan kegiatan pengadaan barang di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',138,0,NULL,NULL),(143,'PL1.1.5','Pengadaan Jasa Konsultansi','Arsip yang berkaitan dengan kegiatan pengadaan jasa konsultansi di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',138,0,NULL,NULL),(144,'PL1.1.6','Pengadaan Jasa Lainnya','Arsip yang berkaitan dengan kegiatan pengadaan jasa lainnya di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',138,0,NULL,NULL),(145,'PL1.1.7','Pengadaan J asa Konstruksi',NULL,138,0,NULL,NULL),(146,'PL1.2','Pengelolaan dan Penatausahaan Barang Milik Negara',NULL,136,0,NULL,NULL),(147,'PL1.2.1','Perencanaan Barang Milik Negara','Arsip yang berkaitan dengan kegiatan perencanaan BMN',146,0,NULL,NULL),(148,'PL1.2.2','Standar Barang dan Standar Kebutuhan BMN (SBSK) dari Unit Kerja/Unit Organisasi','Arsip yang berkaitan dengan SBSK dari Unit Kerja/Unit Organisasi ',146,0,NULL,NULL),(149,'PL1.2.3','Penghapusan dan Pemusnahan BMN',NULL,146,0,NULL,NULL),(150,'PL1.2.4','Hibah',NULL,146,0,NULL,NULL),(151,'PL1.2.5','Pencatatan BMN',NULL,146,0,NULL,NULL),(152,'PL1.2.6','Revaluasi dan Rekonsiliasi BMN',NULL,146,0,NULL,NULL),(153,'PL1.2.7','Pelaporan BMN',NULL,146,0,NULL,NULL),(154,'PS','Perpustakaan','Klasifikasi perpustakaan meliputi melaksanakan kegiatan perpustakaan dari pengadaan bahan pustaka sampai dengan layanan perpustakaan',0,0,NULL,NULL),(155,'PS1','Pengelolaan dan Pengembangan koleksi pustaka','Arsip yang berkaitan dengan kegiatan pengembangan koleksi dan bahan pustaka di Lingkungan Mahkamah Agung dan Badan Peradilan di Bawahnya',154,0,NULL,NULL),(156,'PS1.1','Akuisisi Koleksi/Bahan pustaka','Arsip yang terkait dengan akusisi koleksi/bahan pustaka di Lingkungan Mahkamah Agung dan Badan Peradilan di Bawahnya',155,0,NULL,NULL),(157,'PS1.2','Hibah Koleksi/Bahan Pustaka','Arsip yang berkaitan dengan kegiatan hibah koleksi bahan pustaka Mahkamah Agung, baik milik perpustakaan maupun hibah pegawai',155,0,NULL,NULL),(158,'PS1.3','Layanan Kepustakaan','Arsip yang berkaitan dengan penyediaan pengumpulan, dan penataan bahan-bahan kepustakaan',155,0,NULL,NULL),(159,'PS1.4','Keanggotaan Perpustakaan','Arsip yang berkaitan dengan keanggotaan perpustakaan seperti formulir keanggotaan dan data anggota perpustakaan di Lingkungan Mahkamah Agung dan badan Peradilan di Bawahnya',155,0,NULL,NULL),(160,'PS1.4.1','Form Keanggotaan Perpustakaan','Arsip yang berkaitan dengan keanggotaan perpustakaan, seperti formulir anggota perpustakaan',159,0,NULL,NULL),(161,'PS1.4.2','Data Anggota Perpustakaan','Arsip yang berkaitan dengan keanggotaan perpustakaan, seperti data anggota perpustakaan',159,0,NULL,NULL),(162,'PS1.5','Sirkulasi Koleksi/ Bahan Pustaka','Arsip yang berkaitan dengan kegiatan berupa pemberian bantuan kepada pengguna perpustakaan dalam proses peminjaman dan pengembalian bahan pustaka serta permintaan informasi lainnya baik di loket maupun online (via teleporr/ email/web/ social media)',155,0,NULL,NULL),(163,'PS1.6','Preservasi Koleksi / Bahan Pustaka','Arsip yang berkaitan dengan pelestarian bahan pustaka meliputi pemeliharaan, perbaikan, dan alih media',155,0,NULL,NULL),(164,'PS1.7','Pengembangan Perpustakaan dan Pengembangan Minat Baca','Arsip yang berkaitan dengan kegiatan pengembangan perpustakaan dan pengembangan minat baca, meliputi pengembangan perpustakaan, akreditasi perpustakaan, pemasyarakatan minat dan organisasi perpustakaan',155,0,NULL,NULL),(165,'PW','Pengawasan','Klasifikasi pelaksanaan meliputi pengawasan pengawasan internal dan eksternal di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',0,0,NULL,NULL),(166,'PW1','Pengawasan / Pemantauan Internal','Arsip yang berkaitan dengan kegiatan pengawasan internal meliputi proses audit, reviu, evaluasi, dan pemantauan baik yang dilaksanakan oleh auditor maupun unit yang menangani kepatuhan internal',165,0,NULL,NULL),(167,'PW1.1','Pengawasan dengan Tindak lanjut','Arsip yang berkaitan dengan hasil pengawasan atau pemantauan yang memerlukan tindak lanjut',166,0,NULL,NULL),(168,'PW1.1.1','Pengawasan/Pemantauan yang Memerlukan Tindak Lanjut','Arsip yang berkaitan dengan kegiatan pengawasan internal (audit, reviu, evaluasi, dan pemantauan) yang meliputi pengawasan sumber daya manusia, audit investigatif, pengawasan keuangan tindak lanjut, teknologi informasi, dan pengawasan keuangan memerlukan tindak lanjut',167,0,NULL,NULL),(169,'PW1.1.2','Pengawasan/Pemantauan yang Mengandung Unsur Pelanggaran Non Administratif/Fraud yang Memerlukan Tind','Arsip yang berkaitan dengan kegiatan pengawasan internal (audit, reviu, evaluasi, dan pemantauan) yang meliputi pengawasan sumber daya manusia, audit investigatif, pengawasan keuangan tindak lanjut, dan teknologi informasi',167,0,NULL,NULL),(170,'PW1.2','Pengawasan yang tidak memerlukan Tindak lanjut','Arsip yang berkaitan dengan hasil pengawasan atau pemantauan yang tidak memerlukan tindak lanjut',166,0,NULL,NULL),(171,'PW1.2.1','Pengawasan/Pemantauan Yang Tidak Memerlukan Tindak Lanjut','Arsip yang berkaitan dengan kegiatan pengawasan internal (audit, reviu, evaluasi, dan pemantauan) yang meliputi pengawasan sumber daya manusia, audit investigatif, pengawasan keuangan tindak lanjut, teknologi informasi, dan pengawasan keuangan tidak tindak lanjut',170,0,NULL,NULL),(172,'PW1.2.2','Pengawasanj Pemantauan yang Mengandung Unsur Pe1anggaran Non Administratif/Fraud yang Tidak Memerluk','Arsip yang berkaitan dengan kegiatan pengawasan internal (audit, reviu, evaluasi, dan pemantauan) yang meliputi pengawasan sumber daya manusia, audit investigatif, teknologi informasi, dan pengawasan keuangan tidak memerlukan tindak lanjut',170,0,NULL,NULL),(173,'PW1.3','Pengawasan/Pemantauan Pegawai','Arsip yang berkaitan dengan pelaksanaan pengawasan/pemantauan pegawai di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',166,0,NULL,NULL),(174,'PW1.4','Pengawasan Eksternal','Arsip yang berkaitan dengan tindak lanjut temuan hasil pemeriksaan auditor eksternal',166,0,NULL,NULL),(175,'RT','Rumah Tangga','Klasifikasi rumah tangga meliputi pengelolaan bangunan gedung dan lingkungan, peralatan operasional, mekanikal elektrikal, ketertiban dan keamanan, serta kegiatan operasional lainnya terkait kerumahtanggaan',0,0,NULL,NULL),(176,'RT1','Penggunaan Gedung dan Fasilitas Kantor','Arsip yang berkaitan dengan penggunaan bangunan gedung dan lingkungan, fasilitas kantor, peralatan operasional (seperti rumah dinas, kendaraan dinas, perlengkapan kerja, peralatan kesehatan), dan mekanikal elektrikal di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',175,0,NULL,NULL),(177,'RT1.1','Pemeliharaan Gedung dan Fasilitas Kantor','Arsip yang berkaitan dengan kegiatan pemeliharaan bangunan gedung dan lingkungan, fasilitas kantor, peralatan operasional (seperti kendaraan dinas, perlengkapan kerja, perlengkapan kesehatan) dan mekanikal elektrikal di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',176,0,NULL,NULL),(178,'RT1.1.1','Bangunan Gedung dan Lingkungan','Arsip yang berkaitan dengan administrasi pemeliharaan bangunan gedung, lingkungan, dan fasilitas kantor (gedung kantor dan rumah dinas) meliputi struktural, arsitektural, tata graha, dan halaman',177,0,NULL,NULL),(179,'RT1.1.2','Peralatan Operasional','Arsip yang berkaitan dengan administrasi pemeliharaan peralatan operasional, seperti kendaraan dinas, perlengkapan kerja, perlengkapan kesehatan, dan peralatan operasional lainnya',177,0,NULL,NULL),(180,'RT1.1.3','Mekanikal Elektrikal','Arsip yang berkaitan dengan administrasi pemeliharaan mekanikal elektrikal seperti sistem kelistrikan, sistem tata udara, sistem tata air, sistem keamanan, sistem telekomunikasi, dan sistem mekanikal elektrikal lainnya, serta manajemen penggunaan energi',177,0,NULL,NULL),(181,'RT1.1.4','Ketertiban dan keamanan','Arsip yang berkaitan dengan kegiatan Mahkamah Agung dalam ketertiban dan keamanan kantor dan rumah dinas terhadap kehilangan, kerusakan, kecelakaan, dan bencana, serta penjagaan dan pengawalan pejabat',177,0,NULL,NULL),(182,'RT1.1.5','Pengelolaan Parkir','Arsip yang berkaitan dengan kegiatan pengelolaan parkir di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',177,0,NULL,NULL),(183,'RT2','Pengelolaan Museum','Arsip Yang Berkaitan Dengan Pengelolaan Museum di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',175,0,NULL,NULL),(184,'RT2.1','Pendaftaran Museum','Arsip yang berkaitan dengan kegiatan pendaftaran museum',183,0,NULL,NULL),(185,'RT2.2','Pelindungan Museum','Arsip yang berkaitan dengan pelindungan penyimpanan koleksi, baik kegiatan penyelamatan, pengamanan, maupun pemeliharaan',183,0,NULL,NULL),(186,'RT2.3','Pengembangan dan Pemanfaatan Museum','Arsip yang berkaitan dengan pengembangan serta pemanfaatan museum',183,0,NULL,NULL),(187,'TI','Teknologi Informasi','Klasifikasi teknologi informasi meliputi penyusunan rencana strategis teknologi informasi dan komunikasi',0,0,NULL,NULL),(188,'TI1','Sistem Informasi','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan sistem informasi, termasuk di dalamnya monitoring dan evaluasi. (tidak termasuk dokumen pengadaan)',187,0,NULL,NULL),(189,'TI1.1','Aplikasi','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan aplikasi umum dan aplikasi khusus',188,0,NULL,NULL),(190,'TI1.1.1','Aplikasi Umum','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan aplikasi umum (aplikasi kepegawaian, aplikasi tata naskah dinas, dan sejenisnya)',189,0,NULL,NULL),(191,'TI1.1.2','Aplikasi Khusus','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan aplikasi khusus (aplikasi perpajakan, aplikasi penganggaran, aplikasi perbendaharaan, aplikasi bea cukai dan sejenisnya)',189,0,NULL,NULL),(192,'TI1.2','Jaringan Komunikasi','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan jaringan komunikasi',187,0,NULL,NULL),(193,'TI1.2.1','Jaringan Internet dan Ekstranet','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan Jaringan Internet dan Ekstranet',192,0,NULL,NULL),(194,'TI1.2.2','Jaringan Intranet','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan jaringan intranet',192,0,NULL,NULL),(195,'TI1.2.3','Pengelolaan Sistem Kolaborasi','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan sistem kolaborasi',192,0,NULL,NULL),(196,'TI1.3','Basis Data','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan basis data serta penyajian data dan sistem layanan data baik yang memanfaatkan server fisik, server virtual, maupun layanan cloud',187,0,NULL,NULL),(197,'TI1.3.1','Operasional Basis Data','Arsip yang berkaitan dengan kegiatan perencanaan,pembangunan, pengelolaan, dan pengembangan basis data',196,0,NULL,NULL),(198,'TI1.3.2','Penyajian Data','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan sistem penyajian data',196,0,NULL,NULL),(199,'TI1.3.3','Sistem Layanan Data','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan sistem layanan data',196,0,NULL,NULL),(200,'TI1.3.4','Web Service (API)','Web Service (API)',196,0,NULL,NULL),(201,'TI1.4','Server','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan server',187,0,NULL,NULL),(202,'TI1.4.1','Server Fisik','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan server fisik',201,0,NULL,NULL),(203,'TI1.4.2','Server Virtual','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, penge1olaan, dan pengembangan server virtual termasuk cloud',201,0,NULL,NULL),(204,'TI2','Tata Kelola Teknologi Informasi dan Komunikasi (TIK)','Arsip yang berkaitan dengan kegiatan pengelolaan TIK, pemanfaatan TIK dan transformasi digital (di luar Sistem Informasi)',187,0,NULL,NULL),(205,'TI2.1','Layanan Teknologi Informasi dan Komunikasi','Arsip yang berkaitan dengan pengelolaan layanan TIK yang dilaksanakan oleh Unit TIK',204,0,NULL,NULL),(206,'TI2.1.1','Perencanaan, Monitoring dan Evaluasi Layanan Teknologi Informasi dan Komunikasi','Arsip yang berkaitan dengan kegiatan perencanaan, monitoring dan evaluasi layanan Teknologi Informasi dan Komunikasi (TIK)',205,0,NULL,NULL),(207,'TI2.1.2','Tingkat Layanan Teknologi Informasi dan Komunikasi','Arsip yang berkaitan dengan pengelolaan tingkat layanan Teknologi Informasi dan Komunikasi',205,0,NULL,NULL),(208,'TI2.2','Keamanan Informasi','Arsip yang berkaitan dengan penerapan sistem manajemen keamanan informasi, diantaranya termasuk perencanaan, pengelolaan, monitoring dan evaluasi keamanan informasi',204,0,NULL,NULL),(209,'TI2.2.1','Pengelolaan Keamanan Informasi','Arsip yang berkaitan dengan kegiatan perencanaan, pembangunan, pengelolaan, dan pengembangan keamanan informasi',208,0,NULL,NULL),(210,'TI2.2.2','Pengendalian Keamanan Informasi','Arsip yang berkaitan dengan pemantauan dan evaluasi hak akses pengguna, deteksi dan tindak lanjut upaya penerobosan keamanan informasi',208,0,NULL,NULL),(211,'DL','Pendidikan dan Pelatihan','Klasifikasi pendidikan dan pelatihan meliputi melaksanakan pendidikan dan pelatihan di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya.',0,0,NULL,NULL),(212,'DL1','Pendidikan dan Pelatihan','Arsip yang berkaitan dengan kegiatan pendidikan dan pelatihan di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya dalam peningkatan Sumber Daya Manusia Aparatur',211,0,NULL,NULL),(213,'DL1.1','Beasiswa',NULL,212,0,NULL,NULL),(214,'DL1.2','Sertifikasi Keahlian','',212,0,NULL,NULL),(215,'DL1.3','Perencanaan Pembelajaran dan Pengembangan Program','Arsip yang berkaitan dengan perencanaan dan pengembangan program pembelajaran',212,0,NULL,NULL),(216,'DL1.4','Kurikulum dan Silabus','Arsip yang berkaitan dengan kurikulum dan silabus pembelajaran',212,0,NULL,NULL),(217,'DL1.5','Tenaga Pengajar','Arsip yang berkaitan dengan tenaga pengajar',212,0,NULL,NULL),(218,'DL1.6','Penyelenggaraan Pembelajaran','Arsip yang berkaitan dengan penyelenggaraan pembelajaran pegawai Mahkamah Agung meliputi daftar hadir, ujian, tugas akhir, pelaporan, dan evaluasi',212,0,NULL,NULL),(219,'DL1.7','Evaluasi Pembelajaran','Arsip yang berkaitan dengan pelaksanaan dan evaluasi program pembelajaran',212,0,NULL,NULL),(220,'DL1.8','Monitoring dan Evaluasi Program Pembelajaran','Arsip yang berkaitan dengan pelaksanaan monitoring dan evaluasi program pembelajaran',212,0,NULL,NULL),(221,'DL1.9','Penerbitan Surat Keterangan Pembelajaran','Arsip yang berkaitan dengan penerbitan Surat Keterangan Pembelajaran serta pemutakhiran database alumni pembelajaran',212,0,NULL,NULL),(222,'DL1.10','Sosialisasi, Bimbingan teknis, Konsultasi, dan Asistensi','Arsip yang berkaitan dengan kegiatan Mahkamah Agung dalam memberikan sosialisasi, bimbingan teknis, konsultasi dan asistensi',212,0,NULL,NULL),(223,'RA','Perencanaan Anggaran','Klasifikasi perencanaan meliputi kegiatan penyusunan program dan anggaran di lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',0,0,NULL,NULL),(224,'RA1','Perencanaan Anggaran',NULL,223,0,NULL,NULL),(225,'RA1.1','Penyusunan Rencana Program',NULL,224,0,NULL,NULL),(226,'RA1.2','Rencana Jangka Panjang Strategis Mahkamah Agung',NULL,224,0,NULL,NULL),(227,'RA1.3','Rencana Kerja Strategis Lima Tahunan (RENSTRA)','Arsip yang berkaitan dengan RENSTRA di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',224,0,NULL,NULL),(228,'RA1.4','Perencanaan Lintas Kementerian / Lembaga','Arsip yang berkaitan dengan tema lintas sektoral',224,0,NULL,NULL),(229,'RA1.5','Rencana Kerja (RENJA)','Arsip yang berkaitan dengan RENJA Mahkamah Agung dan RENJA unit organisasi di Lingkungan Mahkamah Agung dan badan Peradilan yang Berada di Bawahnya',224,0,NULL,NULL),(230,'RA1.6','Usulan Anggaran',NULL,224,0,NULL,NULL),(231,'RA1.7','Penyusunan Anggaran',NULL,224,0,NULL,NULL),(232,'RA1.8','Revisi Anggaran',NULL,224,0,NULL,NULL),(233,'RA1.9','Rencana Kinerja Tahunan (RKT)',NULL,224,0,NULL,NULL),(234,'RA1.10','Perjanjian Kinerja Tahunan (PKT)',NULL,224,0,NULL,NULL),(235,'KU','Keuangan','Klasifikasi keuangan meliputi pelaksanaan anggaran dan pertanggungjawaban serta pelaporan atas beban APBN di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',0,0,NULL,NULL),(236,'KU1','Pelaksanaan Anggaran dan Pertanggungjawaban',NULL,235,0,NULL,NULL),(237,'KU1.1','Perbendaharaan',NULL,236,0,NULL,NULL),(238,'KU1.1.1','Penetapan PA, KPA,PPK, Bendahara, dan Pengelola Keuangan',NULL,237,0,NULL,NULL),(239,'KU1.1.2','Dokumen Pertanggungjawaban atas beban APBN',NULL,237,0,NULL,NULL),(240,'KU1.1.3','Laporan Pembayaran dan Pertanggungjawaban atas beban APBN',NULL,237,0,NULL,NULL),(241,'KU1.1.4','Asistensi Pelaksanaan Anggaran',NULL,237,0,NULL,NULL),(242,'KU1.1.5','Data rekening BUN',NULL,237,0,NULL,NULL),(243,'KU1.2','Laporan Perkembangan Penyelesaian Kerugian Negara',NULL,236,0,NULL,NULL),(244,'KU1.3','Pelaksanaan Tuntutan Ganti Rugi',NULL,236,0,NULL,NULL),(245,'KU1.4','Penerimaan Negara Bukan Pajak',NULL,236,0,NULL,NULL),(246,'KU2','Pelaporan',NULL,235,0,NULL,NULL),(247,'KU2.1','Penyusunan Laporan Keuangan',NULL,246,0,NULL,NULL),(248,'KU2.2','Rekonsiliasi Laporan Keuangan',NULL,246,0,NULL,NULL),(249,'OT','Organisasi Tatalaksana','Klasifikasi organisasi tatalaksana meliputi penyusunan rancangan kebijakan dan standarisasi teknis di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',0,0,NULL,NULL),(250,'OT1','Organisasi dan Tatalaksana',NULL,249,0,NULL,NULL),(251,'OT1.1','Pembentukan / Perubahan / Penghapusan Organisasi','Arsip yang berkaitan dengan kegiatan Mahkamah Agung berupa pembentukan, perubahan, dan penghapusan orgarusasi dan unit kerja di Lingkungan Mahkamah Agung dan Badan Peradilan yang Berada di Bawahnya',250,0,NULL,NULL),(252,'OT1.2','Tatalaksana / Mekanisrne Kerja','Arsip yang berkaitan dengan tatalaksana Mahkamah Agung meliputi, standardisasi / pembakuan sistem / work instruction, proses bisnis, enterprise arsitektur',250,0,NULL,NULL),(253,'OT1.3','Analisis Jabatan dan Analisis Beban Kerja',NULL,250,0,NULL,NULL),(254,'OT1.4','Evaluasi Jabatan',NULL,250,0,NULL,NULL),(255,'OT1.5','Peta Jabatan',NULL,250,0,NULL,NULL),(256,'OT1.6','Kinerja Organisasi',NULL,250,0,NULL,NULL),(257,'OT1.7','Penilaian Maturitas Sistem Pengendalian Intern Pemerintah (SPIP)',NULL,250,0,NULL,NULL);
/*!40000 ALTER TABLE `ref_klasifikasi_baru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin',NULL,NULL),(2,'User',NULL,NULL),(3,'Super User',NULL,NULL),(4,'Operator',NULL,NULL),(5,'Ajudan',NULL,NULL);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_disposisi`
--

DROP TABLE IF EXISTS `t_disposisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_disposisi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_surat_masuk` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disposisi_oleh` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disposisi_kepada` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plh` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_disposisi` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_disposisi` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tindaklanjut` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arsipkan` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teruskan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_disposisi`
--

LOCK TABLES `t_disposisi` WRITE;
/*!40000 ALTER TABLE `t_disposisi` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_disposisi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_jabatan`
--

DROP TABLE IF EXISTS `t_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_jabatan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_atasan` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bagian` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teruskan` tinyint(4) DEFAULT '0',
  `disposisi` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_jabatan`
--

LOCK TABLES `t_jabatan` WRITE;
/*!40000 ALTER TABLE `t_jabatan` DISABLE KEYS */;
INSERT INTO `t_jabatan` VALUES (1,'Ketua','','1','0',1,1,NULL,NULL),(2,'Wakil Ketua','1','1','0',1,1,NULL,NULL),(3,'Panitera','1','2','1',1,1,NULL,NULL),(4,'Sekretaris','1','2','2',1,1,NULL,NULL),(5,'Panitera Muda Hukum','3','3','1',1,1,NULL,NULL),(6,'Panitera Muda Gugatan','3','3','1',1,1,NULL,NULL),(7,'Panitera Muda Permohonan','3','3','1',1,1,NULL,NULL),(8,'Kasubbag Kepegawaian dan Ortala','4','4','2',1,1,NULL,NULL),(9,'Kasubbag Umum dan Keuangan','4','4','2',1,1,NULL,NULL),(10,'Kasubbag PTIP','4','4','2',1,1,NULL,NULL),(11,'Panitera Pengganti','3','4','1',0,0,NULL,NULL),(12,'Analis Tatalaksana','8','5','2',0,1,NULL,NULL),(13,'Bendahara','9','5','2',0,1,NULL,NULL),(14,'Pengelola BMN','9','5','2',0,1,NULL,NULL),(15,'Analis Perencanaan Evaluasi dan Pelaporan','10','5','2',0,1,NULL,NULL),(16,'Pengelola Kepegawaian','8','5','2',0,1,NULL,NULL),(17,'Pengelola Akuntansi','9','5','2',0,1,NULL,NULL),(18,'Penyusun Laporan Keuangan','9','5','2',0,1,NULL,NULL),(19,'Analis Organisasi','8','5','2',0,1,NULL,NULL),(20,'Pranata Komputer','10','5','2',0,1,NULL,NULL),(21,'Hakim','1','2','0',0,0,NULL,NULL),(22,'Analis Perkara Peradilan (P. Permohonan)','7','5','1',0,1,NULL,NULL),(23,'Analis Perkara Peradilan (P. Gugatan)','6','5','1',0,1,NULL,NULL),(24,'Analis Perkara Peradilan (P. Hukum)','5','5','1',0,1,NULL,NULL),(25,'Pengelola Perkara (P. Permohonan)','7','5','1',0,1,NULL,NULL),(26,'Pengelola Perkara (P. Gugatan)','6','5','1',0,1,NULL,NULL),(27,'Pengelola Perkara (P. Hukum)','5','5','1',0,1,NULL,NULL),(28,'Jurusita','3','5','2',0,1,NULL,NULL),(29,'Jurusita Pengganti','3','5','2',0,1,NULL,NULL),(99,'Resepsionis','0','6','0',0,1,NULL,NULL),(999,'Administrator','0','0','0',0,0,NULL,NULL);
/*!40000 ALTER TABLE `t_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_plh`
--

DROP TABLE IF EXISTS `t_plh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_plh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jabatan` int(3) DEFAULT NULL,
  `nip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_awal` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `user_input` varchar(100) DEFAULT NULL,
  `user_update` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_plh`
--

LOCK TABLES `t_plh` WRITE;
/*!40000 ALTER TABLE `t_plh` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_plh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_setting_nomor`
--

DROP TABLE IF EXISTS `t_setting_nomor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_setting_nomor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_setting_nomor`
--

LOCK TABLES `t_setting_nomor` WRITE;
/*!40000 ALTER TABLE `t_setting_nomor` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_setting_nomor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_surat_keluar`
--

DROP TABLE IF EXISTS `t_surat_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_surat_keluar` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_agenda` int(11) DEFAULT '0',
  `id_klasifikasi` int(11) DEFAULT NULL,
  `klasifikasi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifat_surat` int(11) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `isi_ringkas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penerima` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_penerima` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penandatangan_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_penandatangan_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_anggaran` int(11) DEFAULT NULL,
  `user_input` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_update` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_surat_keluar`
--

LOCK TABLES `t_surat_keluar` WRITE;
/*!40000 ALTER TABLE `t_surat_keluar` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_surat_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_surat_keluar_baru`
--

DROP TABLE IF EXISTS `t_surat_keluar_baru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_surat_keluar_baru` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_agenda` int(11) DEFAULT '0',
  `no_urut` int(11) DEFAULT NULL,
  `id_klasifikasi` int(11) DEFAULT NULL,
  `kode_penetapan` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klasifikasi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifat_surat` int(11) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `isi_ringkas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penerima` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_penerima` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penandatangan_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_penandatangan_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_anggaran` int(11) DEFAULT NULL,
  `user_input` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_update` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_surat_keluar_baru`
--

LOCK TABLES `t_surat_keluar_baru` WRITE;
/*!40000 ALTER TABLE `t_surat_keluar_baru` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_surat_keluar_baru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_surat_masuk`
--

DROP TABLE IF EXISTS `t_surat_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_surat_masuk` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_agenda` int(11) DEFAULT NULL,
  `id_klasifikasi` int(11) DEFAULT NULL,
  `klasifikasi` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sifat_surat` int(11) DEFAULT NULL,
  `isi_ringkas` text COLLATE utf8mb4_unicode_ci,
  `dari` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_surat` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_surat` date DEFAULT NULL,
  `tgl_diterima` date DEFAULT NULL,
  `keterangan` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_anggaran` int(11) DEFAULT NULL,
  `user_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arsipkan` tinyint(4) DEFAULT '0',
  `jenis_arsip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_arsip` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_surat_idx` (`no_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_surat_masuk`
--

LOCK TABLES `t_surat_masuk` WRITE;
/*!40000 ALTER TABLE `t_surat_masuk` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_surat_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_surat_masuk_satker`
--

DROP TABLE IF EXISTS `t_surat_masuk_satker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_surat_masuk_satker` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_klasifikasi` int(11) DEFAULT NULL,
  `klasifikasi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sifat_surat` int(11) DEFAULT NULL,
  `isi_ringkas` text COLLATE utf8mb4_unicode_ci,
  `dari` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_surat` date DEFAULT NULL,
  `tgl_diterima` date DEFAULT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_anggaran` int(11) DEFAULT NULL,
  `user_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_surat_idx` (`no_surat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_surat_masuk_satker`
--

LOCK TABLES `t_surat_masuk_satker` WRITE;
/*!40000 ALTER TABLE `t_surat_masuk_satker` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_surat_masuk_satker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_tembusan`
--

DROP TABLE IF EXISTS `t_tembusan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_tembusan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_disposisi` int(11) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `read` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_tembusan`
--

LOCK TABLES `t_tembusan` WRITE;
/*!40000 ALTER TABLE `t_tembusan` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_tembusan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `pengaduan` tinyint(4) DEFAULT '0',
  `urutan` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip_UNIQUE` (`nip`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','Administrator','admin@ptabdg.com',NULL,'$2y$10$X46Nml85GgkkPr7qKDvQ0.MEG74ETsaJMK204esti5cUA9Bb0AtPm','CpV51e1Q0q2pPGG2lW0qudAnlUcz8t8UWVGrTUw4OhZnzXthbeYC03X4hhKi',NULL,'2023-01-17 01:32:11',NULL,1,999,'08',1,0,0),(2,'surat','Operator Surat','surat@pa-bogor.go.id',NULL,'$2y$10$X46Nml85GgkkPr7qKDvQ0.MEG74ETsaJMK204esti5cUA9Bb0AtPm',NULL,'2023-08-31 02:48:02','2023-08-31 02:48:02',NULL,4,99,'08',1,0,0),(3,'resepsionis','Resepsionis','resepsionis@a.a',NULL,'$2y$10$X46Nml85GgkkPr7qKDvQ0.MEG74ETsaJMK204esti5cUA9Bb0AtPm','HyDu8xclhP5qGy3pR8UeVOrLprLWu9DufXOwfuMSQzzaN0LYHcwgNcTfn86l','2023-12-07 02:32:54','2023-12-07 02:32:54',NULL,4,99,'08',1,0,0),(24,'196810031994032002','Dra. Hj. ERPI DESRINA HASIBUAN, S.H., M.H.','196810031994032002@a.a',NULL,'$2y$10$k70GpMSWRYcjBC/9Ziad1ebBpYY6UewOLKUE.GvRQhsjke92tKeL6','WL1AyPjwk4cPbZY0JPCyQawMxyUsMebFHdwHyRwrLRdirQYCk1hlWqb7w4yP','2024-01-23 07:09:10','2024-01-23 07:10:02',NULL,3,1,'08',1,0,1),(25,'197603062005021001','Dr. H. ABDUL MAJID, S.H.I., M.H.','197603062005021001@a.a',NULL,'$2y$10$McarPLYVz6fYI4ReXVWg6efQ3Q3xJYToLyPmmbU6Fp/ysdGfWxYNO','27UZuMKPhmgAmon9m25SObL84ay0P7ijiygaCUjBFqsWljUCMyZ0WqdZEzH2','2024-01-23 07:11:58','2024-01-23 07:11:58',NULL,3,2,'08',1,0,2),(26,'196507201993031002','NANANG PATONI, S.H., M.H.','196507201993031002@a.a',NULL,'$2y$10$.m9j5GtSPNYYOxk1dZC/eu056PzngU8ahSfGCtNJ5CsxT3Cntmlo6',NULL,'2024-01-23 07:12:27','2024-01-23 07:12:27',NULL,2,3,'08',1,0,3),(27,'196908051991031014','WAWAN, S.AP, M.M','196908051991031014@a.a',NULL,'$2y$10$KVQKXsKt4Vj2kO6DjBId2OSPI6U9zUipZV9gL9/tRYQ8DCsQzTrX6',NULL,'2024-01-23 07:13:01','2024-01-23 07:13:01',NULL,2,4,'08',1,0,4),(28,'197904091998032001','WARDAH HAMZAH, S.H.I.','197904091998032001@a.a',NULL,'$2y$10$1HYD9LQArTVIzKDvxu4hte1MXkTl83.OzNfeR5dgQEGbGaKOAow2O',NULL,'2024-01-23 07:13:41','2024-01-23 07:13:41',NULL,2,7,'08',1,0,20),(29,'198208102009041005','HERMANSYAH, S.H.I.','198208102009041005@a.a',NULL,'$2y$10$ZzHWPEXjNNWjlOI26RZn0.TjfEMgznSW4B17enZrKkGy3lWsgNTQO',NULL,'2024-01-23 07:14:18','2024-01-23 07:14:18',NULL,2,5,'08',1,0,20),(30,'196812291994021001','AGUS YUSPIAIN, S.Ag., M.H.','196812291994021001@a.a',NULL,'$2y$10$MCP6k/wFZnVPi5tb8u4aFOVmwWHyC9ynXQe4S0S61k/4dOYuGYxse',NULL,'2024-01-23 07:15:44','2024-01-23 07:15:44',NULL,2,6,'08',1,0,20),(31,'198606062011011009','HAFIES YUDHA KUSUMA, S.Kom, S.H.','198606062011011009@a.a',NULL,'$2y$10$3g1aIBEvoaLDxqC0n9mqiOX1rKoCfol4FKH00bwxqNTElgB9V0CmW',NULL,'2024-01-23 07:16:46','2024-01-23 07:16:46',NULL,1,9,'08',1,0,30),(32,'198501282009041002','ARIF WIJI HASTOMO, S.H.','198501282009041002@a.a',NULL,'$2y$10$nZYtixNkSl0v0Ps/Bp1ZxuGzl8gIoipfzK1.ACk5Lo.4uyp2NhLZW',NULL,'2024-01-23 07:17:13','2024-01-23 07:17:13',NULL,3,10,'08',1,0,30),(33,'199307292019032005','KARINA DIAN AFYANI, S.E.','199307292019032005@a.a',NULL,'$2y$10$yEmSoptBC9SVtNmCDz4vmu0clJVQ6QdqBemzCJnqVfS/maDqQ20.a',NULL,'2024-01-23 07:17:41','2024-01-23 07:17:56',NULL,3,8,'08',1,0,30),(34,'198904172019031003','MAULANA TARMIZI, S.T.','198904172019031003@a.a',NULL,'$2y$10$EMJ6ruWXXtop4Jr2696WV.fqIit8etmaxpcOa1C9KWpgaYBfIowv2',NULL,'2024-01-23 07:28:49','2024-01-23 07:28:49',NULL,2,20,'08',1,0,40);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-23 14:42:13
