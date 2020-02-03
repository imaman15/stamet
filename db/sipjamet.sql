-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2020 at 09:56 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipjamet`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `applicant_id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `photo` varchar(128) NOT NULL DEFAULT 'default.jpg',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `nin` varchar(50) NOT NULL COMMENT 'National Identity Number',
  `address` text,
  `job_category` int(11) NOT NULL,
  `institute` varchar(128) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Pemohon';

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`applicant_id`, `email`, `password`, `photo`, `first_name`, `last_name`, `nin`, `address`, `job_category`, `institute`, `phone`, `is_active`, `date_created`, `date_update`) VALUES
(1, 'imamagustiannugraha@ymail.com', '$2y$10$zP8MNsqylcycGghlhVK6/uFoj.oDyL9.ICvZeYktwaKmm1GFciw8K', 'default.jpg', 'Imam', 'Agustian Nugraha', '3621011708970010', 'Kp. Kabayan Citiis. RT.03/01 No.54 \r\nPandeglang-Banten\r\nKodepos 42212', 3, 'PT. Senskay Development', '+6289671843158', 1, 1575893015, '2020-01-18 09:54:56'),
(2, 'nisarahma@gmail.com', '$2y$10$21MoWjIVn3FCDib6LoCPc.KHNp.S44syrkVwlIY7q8uy5WTrUYe92', 'default.jpg', 'Nisa', 'Rahma', '3601211805199700', 'Pandeglang - Banten', 2, 'Pemerintahan Kabupaten Pandeglang', '+6289671856983', 1, 1575893015, '2020-01-13 10:27:54'),
(3, 'selamat@gmail.com', '$2y$10$/S3YOGBrYEks/mz8lFtd1eCYzhMjo2oAFFZgZ7hOZBNLOc2As4vVu', 'default.jpg', 'Selamat', '', '3601215895656565', 'Serang', 1, 'Pertamina', '+6289589562555', 1, 1575894855, '2020-01-27 08:22:21'),
(4, 'nufus@gmail.com', '$2y$10$lQkvWEQ8wo9uryBlf1NLBe0I2Tj25yEJ2XMwgeI49GTKU0cciopiS', 'default.jpg', 'Fitrotun', 'Nufus', '3621589150055555', 'Pandeglang - Banten', 3, 'Bank Darah', '+6285698659874', 1, 1575895166, '2020-01-27 08:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `cands`
--

CREATE TABLE `cands` (
  `cands_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `applicant_name` varchar(128) NOT NULL,
  `applicant_email` varchar(128) NOT NULL,
  `applicant_phone` varchar(50) NOT NULL,
  `cands_message` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `comp_id` int(11) NOT NULL,
  `comp_code` varchar(30) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `comp_title` varchar(128) NOT NULL,
  `comp_message` text NOT NULL,
  `reply_message` text,
  `emp_id` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`comp_id`, `comp_code`, `applicant_id`, `comp_title`, `comp_message`, `reply_message`, `emp_id`, `date_created`, `date_update`, `status`) VALUES
(1, 'CT270120BLXCM9TD', 1, 'Komplain Transaksi TC260120MULNHVFY', '<p>tolong ini diperbaiki&nbsp;</p><p><img src=\"http://localhost/sipjamet/assets/img-sn/Screenshot_13.png\" style=\"width: 330.656px;\"><br></p>', NULL, NULL, '2020-01-27 10:37:00', '2020-01-27 03:37:00', 'diajukan'),
(3, 'CT270120YGNINT5Z', 1, 'Lanjutan Komplain Transaksi TC260120MULNHVFY', '<p>Masih saja seperti ini<br>tolong di perbaiki</p><p><img src=\"http://localhost/sipjamet/assets/img-sn/44d46634-ff9c-423c-828b-c4fdb187b9403.jpg\" style=\"width: 330.656px;\"><br></p>', '<p>ini mencoba</p><p></p>', 1, '2020-01-27 10:40:22', '2020-01-30 11:16:40', 'tertunda'),
(4, 'CT27012085YXHKLY', 1, 'Masih Lanjutan Komplain Transaksi TC260120MULNHVFY', '<p>cuaca cerah<br><img src=\"http://localhost/sipjamet/assets/img-sn/IMG_20181202_123332.jpg\" style=\"width: 776.484px;\"></p>', '<p>Percobaan ke 2<br><img src=\"http://localhost/sipjamet/assets/img-sn/IMG_20181202_123332.jpg\" style=\"width: 776.484px;\"></p>', 1, '2020-01-27 10:43:57', '2020-01-30 11:12:16', 'diproses');

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(128) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `account_name` varchar(128) DEFAULT NULL,
  `email_reply` varchar(50) DEFAULT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id`, `bank_name`, `account_number`, `account_name`, `email_reply`, `date_update`) VALUES
(1, 'Bank Negara Indonesia (BNI)', '025613564568', 'Kantor Sipjamet Serang', 'reply-sipjamet@gmail.com', '2020-01-29 19:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `doc_id` int(11) NOT NULL,
  `doc_name` varchar(128) NOT NULL,
  `doc_storage` varchar(256) NOT NULL,
  `doc_information` text NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_upload` varchar(128) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `trans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`doc_id`, `doc_name`, `doc_storage`, `doc_information`, `user_type`, `user_id`, `user_upload`, `date_update`, `trans_id`) VALUES
(1, 'Surat Pengantar', '1580120286183.pdf', '', 'applicant', 1, 'Imam Agustian Nugraha - Pemohon', '2020-01-27 10:18:06', 1),
(5, 'awdawd', '1580568331489.pdf', 'awdawd', 'employee', 1, 'Administrator  - Petugas', '2020-02-01 14:45:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `photo` varchar(128) NOT NULL DEFAULT 'default.jpg',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `csidn` varchar(50) NOT NULL COMMENT 'Civil Service ID Number / Nomor Identitas Pegawai Negeri Sipil',
  `position_name` int(11) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  `level` int(1) NOT NULL COMMENT '1: Administrator, 2:Petugas CS, 3:Petugas Layanan',
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Pegawai';

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `email`, `password`, `photo`, `first_name`, `last_name`, `csidn`, `position_name`, `address`, `phone`, `level`, `is_active`, `date_created`, `date_update`) VALUES
(1, 'imamagustiannugraha@ymail.com', '$2y$10$UoH0.7GTDJD55fJpX.7Um.sOrXUwzN0KUuFxJDubfJ9n22mO7uoru', 'default.jpg', 'Administrator', '', '216549879879879889', 1, 'Kp. Kabayan Citiis RT.03/01 No.54', '+6285665486546', 1, 1, 1578434364, '2020-01-27 05:08:14'),
(21, 'awdawd@adaw.com', '$2y$10$06Um3XJlAOersQ3UeLAakOJvce4ZeOGnqBCO1vOo1jupXaDPJaAJ.', 'default.jpg', 'Annisa', 'Rahma', '345345346453643537', 6, 'adadada', '+62856968494465', 3, 1, 1578502071, '2020-01-15 08:58:46'),
(23, 'nova@gmail.com', '$2y$10$fM3lxIe.lVz7VaWPd.QoVelnTPUCL0AfLyfa54PXghkz.rUszIrnK', 'default.jpg', 'Nova', 'Andriatna Salam', '654987654175669854', 5, 'Kp. Kabayan Citiis', '+6285965489875', 2, 1, 1578707965, '2020-01-11 01:59:25'),
(24, 'lela@gmail.com', '$2y$10$1SDfQaIhOuLgK1FwcGl2tupW3mWJsDYbB.pI6bNlK.cJI7V/OJ2me', 'default.jpg', 'Lela', 'Nurlaela', '478568975315687654', 4, 'Kp. Kabayan Citiis', '+6285645687895', 2, 1, 1578708242, '2020-01-15 08:58:38'),
(25, 'azam@gmail.com', '$2y$10$7l24XU0Qu/ilQ8Z/KaZGp.ZXPC27SM6qqz2/V76A0zFyzHyzDkk6m', 'default.jpg', 'Muhammad', 'Azam', '654987615875631687', 7, 'Kp. Kabayan Citiis', '+6285965486548', 3, 1, 1578708313, '2020-01-11 02:05:13'),
(26, 'andreputra@gmail.com', '$2y$10$Jaimcj0uE.ppSymgAbFr8.Rq.BsI8UWsM0T/9nW.KJ85TeXX8HHWO', 'default.jpg', 'Andre', 'Putra Krisna', '477864135402596873', 6, 'Cadasari. Pandeglang-Banten', '+6285648975462', 1, 1, 1578708368, '2020-01-11 02:06:08'),
(27, 'taufik@gmail.com', '$2y$10$5O7tJaQRLVDBx4jIRTuGnOcVCrrvP2CNCIIeAaShn05qTgHUSl.gG', 'default.jpg', 'Taufik', 'Hidayat', '145686548787965465', 1, 'Makassar', '+6285645687961', 1, 1, 1578708410, '2020-01-11 02:06:50'),
(28, 'febriyanti@gmail.com', '$2y$10$XQWd/fBxsAM0uxkU.m1rYO/gIjoEPVhfs.BqK1R29k8tEc3hqQwva', 'default.jpg', 'Febriyanti', 'Putri', '135487956468721654', 2, 'Ciekek, Pandeglang - Banten', '+628548798654987', 2, 1, 1578708479, '2020-01-14 13:45:30'),
(29, 'nisa@gmail.com', '$2y$10$cC1zWj6J50m1gQzAjG7tYuO/UvuJq1oLmdBn5rl3.BRd1mYL08hle', 'default.jpg', 'Nisa ', 'Rahma Sanjaya', '654128740200584865', 4, 'Majasari, Pandeglang-Banten', '+6285645987102', 2, 1, 1578708536, '2020-01-13 05:00:30'),
(30, 'ilham@gmail.com', '$2y$10$GlzEBPO21Hman/wBBRluReSY4A4/Y9ZZpvheUdvFYWiS59ES8fYBu', 'default.jpg', 'Ilham', 'Ari Susanto', '132654876500055454', 5, 'Jakarta Barat', '+628560215568', 3, 1, 1578708579, '2020-01-12 19:28:34'),
(33, 'adawd@gmail.com', '$2y$10$j44iJ6d4.E/WgFvh6sp2TOTvnlvzn8civvlq8o1dx7Bw44SPFsIhG', 'default.jpg', 'Kim ', 'So Hyun', '002565416540006546', 3, 'Jakarta Barat', '+6285265495454', 1, 1, 1578761507, '2020-01-12 19:28:18'),
(36, 'cracker10indo@gmail.com', '$2y$10$fRAfHubqDIiDYSvzo0pJ1e9YdVFeE.6oEU07zVRW/6hSLM/YdCkOm', 'default.jpg', 'Raditya', '', '000354678765640055', 2, 'Kp. Kabayan', '+62856454876543', 3, 1, 1578762062, '2020-01-20 08:59:04'),
(37, 'alvinkhan@gmail.com', '$2y$10$UoH0.7GTDJD55fJpX.7Um.sOrXUwzN0KUuFxJDubfJ9n22mO7uoru', 'default.jpg', 'Alvin', 'Khan Risyad', '687645643132132131', 3, 'CIekek Karaton', '+6285265498765', 2, 1, 1578860103, '2020-01-20 08:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faqs_id` int(11) NOT NULL,
  `faqs_questions` varchar(256) NOT NULL,
  `faqs_answers` text NOT NULL,
  `status` int(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faqs_id`, `faqs_questions`, `faqs_answers`, `status`, `date_created`, `date_update`) VALUES
(1, 'Berita tentang Stasiun Meteorologi Klas I Serang', '<p style=\"text-align: center; \">BMKG Serang mencatat 58 Kali Gempa Susulan</p><p style=\"text-align: center; \"><iframe frameborder=\"0\" src=\"https://www.youtube.com/embed/vE-Pt_fGBYo\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', 1, '2020-01-30 01:25:00', '2020-01-29 18:25:00'),
(2, 'Apa itu SIPJAMET', '<p>Sipjamet adalah Sistem Informasi Pelayanan Jasa Meteorologi.</p><p>Kantor = Stasiun Meteorologi Klas I Maritim Serang.</p>', 1, '2020-01-30 02:09:08', '2020-01-29 19:09:08'),
(7, 'Ini Pertanyaan yang ke 3', '<p>Di coba adawd</p>', 1, '2020-01-30 17:14:15', '2020-01-30 10:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `job_category`
--

CREATE TABLE `job_category` (
  `jobcat_id` int(11) NOT NULL,
  `jobcat` varchar(128) NOT NULL,
  `jobcat_information` varchar(256) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_category`
--

INSERT INTO `job_category` (`jobcat_id`, `jobcat`, `jobcat_information`, `date_update`) VALUES
(1, 'BUMN', '', '2020-01-01 13:16:27'),
(2, 'Instansi Pemerintah', '', '2020-01-01 13:16:27'),
(3, 'Swasta', '', '2020-01-01 13:16:27'),
(4, 'Peneliti', '', '2020-01-01 13:16:27'),
(5, 'Mahasiswa', '', '2020-01-01 13:16:27'),
(6, 'SMA', '', '2020-01-01 13:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `pos_id` int(11) NOT NULL,
  `pos_name` varchar(128) NOT NULL,
  `pos_information` varchar(256) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Jabatan Pegawai';

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`pos_id`, `pos_name`, `pos_information`, `date_update`) VALUES
(1, 'Kepala Stasiun', '', '2020-01-01 13:39:36'),
(2, 'Kasubag TU', 'Kepala Bagian Tata Usaha', '2020-01-01 13:39:36'),
(3, 'Kasi Observasi', 'Kepala Seksi Observasi', '2020-01-01 13:39:36'),
(4, 'Kasi Datin', 'Kepala Seksi Data dan Informasi', '2020-01-01 13:39:36'),
(5, 'Staf TU', 'Staf Tata Usaha', '2020-01-01 13:39:36'),
(6, 'Staf Observasi', '', '2020-01-01 13:39:36'),
(7, 'Staf Datin', 'Staf Data dan Informasi', '2020-01-17 06:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `rate_answer`
--

CREATE TABLE `rate_answer` (
  `ratans_id` int(11) NOT NULL,
  `ratque_id` int(11) NOT NULL,
  `cands_id` int(11) NOT NULL,
  `answer` varchar(1) NOT NULL,
  `answerA` int(11) NOT NULL,
  `answerB` int(11) NOT NULL,
  `answerC` int(11) NOT NULL,
  `answerD` int(11) NOT NULL,
  `answerE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rate_questions`
--

CREATE TABLE `rate_questions` (
  `ratque_id` int(11) NOT NULL,
  `description` varchar(256) NOT NULL,
  `information` varchar(256) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rate_questions`
--

INSERT INTO `rate_questions` (`ratque_id`, `description`, `information`, `date_created`, `date_update`) VALUES
(1, 'Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di unit ini.', '', '2020-02-03 13:22:59', '2020-02-03 06:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `request_subtype`
--

CREATE TABLE `request_subtype` (
  `subtype_id` int(11) NOT NULL,
  `sub_description` varchar(256) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `rates` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Sub Jenis Informasi dan Tarif';

--
-- Dumping data for table `request_subtype`
--

INSERT INTO `request_subtype` (`subtype_id`, `sub_description`, `unit`, `rates`, `type_id`, `date_update`) VALUES
(1, 'Analisis dan Prakiraan Hujan Bulanan', 'per buku', 65000, 1, '2020-02-01 08:44:12'),
(2, 'Prakiraan Musim Kemarau', 'per buku', 230000, 1, '2020-02-01 08:24:47'),
(3, 'Prakiraan Musim Hujan', 'per buku', 230000, 1, '2020-02-01 08:21:48'),
(4, 'Atlas Normal Temperatur Periode 1981 - 2010', 'per buku', 470000, 1, '2020-02-01 08:22:33'),
(5, 'Atlas Windrose Wilayah Indonesia Periode 1981 - 2010', 'per buku', 1500000, 1, '2020-02-01 08:25:26'),
(6, 'Atlas Curah Hujan di Indonesia Rata - Rata Periode 1981 - 2010 ', 'per buku', 1500000, 1, '2020-02-01 08:26:15'),
(7, 'Informasi Meteorologi', 'per lokasi, per hari', 175000, 2, '2020-02-01 08:45:30'),
(8, 'Informasi Cuaca Khusus untuk Kegiatan Olah Raga', 'per lokasi, per hari', 100000, 3, '2020-02-01 08:31:22'),
(9, 'Informasi Cuaca Khusus untuk Kegiatan Komersial Outdoor / Indoor', 'per lokasi, per hari', 100000, 3, '2020-02-01 08:32:25'),
(10, 'Informasi Meteorologi Khusus untuk Pendukung Kegiatan Proyek, Survey, dan Penelitian Komersial', 'per lokasi', 3750000, 4, '2020-02-03 06:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `request_type`
--

CREATE TABLE `request_type` (
  `type_id` int(11) NOT NULL,
  `description` varchar(256) NOT NULL,
  `information` varchar(256) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Jenis Informasi dan Tarif';

--
-- Dumping data for table `request_type`
--

INSERT INTO `request_type` (`type_id`, `description`, `information`, `date_update`) VALUES
(1, 'Informasi Iklim untuk Agro Industri', 'Informasi Khusus Meteorologi Klimatologi dan Geofisika', '2020-01-17 06:52:33'),
(2, 'Informasi Meteorologi, Klimatologi dan Geofisika untuk Keperluan Klaim Asuransi', 'Informasi Khusus Meteorologi, Klimatologi, dan Geofisika\r\n', '2020-01-17 06:54:05'),
(3, 'Informasi Khusus Meteorologi, Klimatologi, dan Geofisika Sesuai Permintaan', '', '2020-01-17 06:55:22'),
(4, 'Jasa Konsultasi Meteorologi', 'Jasa Konsultasi Meteorologi. Klimatologi, dan Geofisika', '2020-01-19 21:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sch_id` int(11) NOT NULL,
  `sch_code` varchar(30) NOT NULL,
  `sch_title` varchar(128) NOT NULL,
  `sch_type` varchar(50) NOT NULL,
  `sch_date` datetime NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `sch_message` text NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `responsible_person` varchar(256) DEFAULT NULL,
  `sch_reply` text,
  `sch_status` int(3) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sch_id`, `sch_code`, `sch_title`, `sch_type`, `sch_date`, `applicant_id`, `sch_message`, `emp_id`, `responsible_person`, `sch_reply`, `sch_status`, `date_created`, `date_update`) VALUES
(1, 'SC260120BGYXW7GT', 'Konsultasi Data Curah Hujan', 'Konsultasi Data', '2020-01-31 00:00:00', 1, '<p>Saya mau konsultasi data curah hujan untuk wilayah pandeglang Banten</p><p>seperti berikut ini gambar yang kami butuhkan :</p><p><img src=\"http://localhost/sipjamet/assets/img-sn/Screenshot_12.png\" style=\"width: 730.25px;\"><br></p>', 1, 'Administrator <hr class=\"my-0\">Kepala Stasiun<hr class=\"my-0\">imamagustiannugraha@ymail.com<hr class=\"my-0\">+6285665486546', NULL, 4, '0000-00-00 00:00:00', '2020-01-30 18:39:48'),
(2, 'SC260120SLUY95KH', 'SMAN 1 Pandeglang', 'Kunjungan Sekolah', '2020-01-31 09:00:00', 1, '<p>Kunjungan Sekolah untuk penelitian mengenai Geografi&nbsp;</p><p><img src=\"http://localhost/sipjamet/assets/img-sn/WhatsApp_Image_2019-03-21_at_4_29_03_PM.jpeg\" style=\"width: 730.25px;\"><br></p>', 1, 'Administrator <hr class=\"my-0\">Kepala Stasiun<hr class=\"my-0\">imamagustiannugraha@ymail.com<hr class=\"my-0\">+6285665486546', '<p style=\"text-align: center;\">Pertemuan sudah selesai di lakukan</p><p style=\"text-align: center;\">untuk berkas dan lain2 silahkan kirmkan via email ke&nbsp;</p><p style=\"text-align: center;\">sipjamet@gmail.com</p>', 4, '2020-02-01 09:00:00', '2020-01-30 18:39:59'),
(3, 'SC260120Q5CLYC98', 'Konsultasi Data untuk Gedung Graha Pancasila', 'Konsultasi Data', '2020-04-01 08:50:00', 1, '<p>Konsultasi untuk Pembangunan Gedung Graha Pancasila</p><p><br></p>', 1, 'Administrator <hr class=\"my-0\">Kepala Stasiun<hr class=\"my-0\">imamagustiannugraha@ymail.com<hr class=\"my-0\">+6285665486546', NULL, 3, '2020-04-01 08:50:00', '2020-01-30 18:01:50'),
(4, 'SC030220P4C3KF0X', 'Konsultasi Data Curah Hujan', 'Konsultasi Data', '2020-02-03 13:00:00', 4, '<p>Konsultasi Data Curah Hujan Untuk Penelitian</p>', 1, 'Administrator <hr class=\"my-0\">Kepala Stasiun<hr class=\"my-0\">imamagustiannugraha@ymail.com<hr class=\"my-0\">+6285665486546', NULL, 2, '2020-02-03 09:30:45', '2020-02-03 02:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `trans_id` int(11) NOT NULL,
  `trans_code` varchar(30) NOT NULL,
  `transcode_storage` varchar(30) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `apply_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `subtype_id` int(11) DEFAULT NULL,
  `trans_status` int(1) DEFAULT NULL,
  `trans_message` text NOT NULL,
  `trans_information` text,
  `trans_request` text,
  `trans_unit` varchar(50) DEFAULT NULL,
  `trans_amount` int(11) DEFAULT NULL,
  `trans_rates` int(11) DEFAULT NULL,
  `trans_sum` int(11) DEFAULT NULL,
  `payment_to` varchar(128) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_bank` varchar(50) DEFAULT NULL,
  `payment_number` varchar(20) DEFAULT NULL,
  `payment_from` varchar(30) DEFAULT NULL,
  `payment_amount` int(11) DEFAULT NULL,
  `payment_img` varchar(128) DEFAULT NULL,
  `payment_status` int(1) DEFAULT NULL,
  `apply_name` varchar(128) DEFAULT NULL,
  `apply_institute` varchar(128) DEFAULT NULL,
  `apply_email` varchar(128) DEFAULT NULL,
  `apply_phone` varchar(50) DEFAULT NULL,
  `emp_name` varchar(128) DEFAULT NULL,
  `emp_posname` varchar(128) DEFAULT NULL,
  `emp_csidn` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`trans_id`, `trans_code`, `transcode_storage`, `date_created`, `date_update`, `apply_id`, `emp_id`, `subtype_id`, `trans_status`, `trans_message`, `trans_information`, `trans_request`, `trans_unit`, `trans_amount`, `trans_rates`, `trans_sum`, `payment_to`, `payment_date`, `payment_bank`, `payment_number`, `payment_from`, `payment_amount`, `payment_img`, `payment_status`, `apply_name`, `apply_institute`, `apply_email`, `apply_phone`, `emp_name`, `emp_posname`, `emp_csidn`) VALUES
(1, 'TC270120MITSRALA', NULL, '2019-11-01 14:46:51', '2020-02-02 04:23:45', 1, 1, 8, 4, '<p>saya mau mengajukan permintaan data&nbsp;<span style=\"background-color: rgba(0, 0, 0, 0.05); color: rgb(133, 135, 150); font-size: 1rem;\">Informasi Meteorologi&nbsp;&nbsp;</span>untuk wilayah pandeglang - Banten.</p><p>hari senin - minggu.&nbsp;</p>', 'Alhamdulillah ini percobaan', 'Informasi Khusus Meteorologi, Klimatologi, dan Geofisika Sesuai Permintaan<li>Informasi Cuaca Khusus untuk Kegiatan Olah Raga</li>', 'per lokasi, per hari', 1, 100000, 0, 'Bank Negara Indonesia (BNI) - 025613564568 A/N Kantor Sipjamet Serang', '2020-01-31 13:50:00', 'Bank Rakyat Indonesia (BRI)', '02564569654', 'Imam Agustian Nugraha', 100000, '1580538327393.jpg', 0, 'Imam Agustian Nugraha', 'PT. Senskay Development', 'imamagustiannugraha@ymail.com', '+6289671843158', 'Administrator ', 'Kepala Stasiun', '216549879879879889'),
(2, 'TC270120WFZVX3B8', NULL, '2019-11-28 15:21:38', '2020-02-02 04:22:54', 2, 1, NULL, 4, '<p><span style=\"background-color: rgb(255, 255, 255);\">Saya mau meminta data</span><span style=\"color: rgb(133, 135, 150); background-color: rgba(0, 0, 0, 0.05);\">&nbsp;Informasi Meteorologi Khusus untuk Pendukung Kegiatan Proyek, Survey, dan Penelitian Komersial&nbsp;</span><span style=\"font-size: 1rem;\">untuk wilayah Ciruas</span></p><p>data diperuntukkan penelitian mahasiswa Universitas Serang Raya.</p><p><br></p>', NULL, 'Informasi Iklim untuk Agro Industri<li>Prakiraan Musim Hujan</li>', NULL, 1, 230000, 230000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'Imam Agustian Nugraha', 'PT. Senskay Development', NULL, NULL, NULL, NULL, NULL),
(3, 'TC270120ZVJEKITP', '(m)Data', '2019-12-10 15:23:43', '2020-02-02 04:23:59', 3, 1, NULL, 4, '<p>Jenis Permintaan&nbsp;<span style=\"background-color: rgba(0, 0, 0, 0.05); color: rgb(133, 135, 150); font-size: 1rem;\">Informasi Cuaca Khusus untuk Kegiatan Olah Raga&nbsp; </span>untuk lokasi Alun-alun Serang&nbsp;</p><p><span style=\"background-color: rgba(0, 0, 0, 0.05); color: rgb(133, 135, 150); font-size: 1rem;\"><br></span></p>', NULL, 'Informasi Iklim untuk Agro Industri<li>Prakiraan Musim Hujan</li>', NULL, 1, 230000, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Imam Agustian Nugraha', 'PT. Senskay ', NULL, NULL, NULL, NULL, NULL),
(4, 'TC270120PA9BEMFI', NULL, '2019-12-26 15:25:40', '2020-02-02 04:22:59', 4, 1, 3, 4, '<p>jenis permintaan&nbsp;<span style=\"color: rgb(133, 135, 150); font-size: 1rem;\">Atlas Normal Temperatur Periode 1981 - 2010&nbsp;</span></p><p><span style=\"color: rgb(133, 135, 150); font-size: 1rem;\"><br></span></p>', NULL, 'Informasi Iklim untuk Agro Industri<li>Prakiraan Musim Hujan</li>', 'per buku', 1, 230000, 230000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'Imam ', 'PT. Senskay Development', NULL, NULL, NULL, NULL, NULL),
(5, 'TC010220GDA74CRJ', NULL, '2019-12-28 00:00:00', '2020-02-02 04:23:02', 1, 1, 3, 4, '<p>Percobaan Ke 2</p>', 'Segera melakukan Pembayaran', 'Informasi Iklim untuk Agro Industri<li>Prakiraan Musim Hujan</li>', 'per buku', 1, 230000, 230000, 'Bank Negara Indonesia (BNI) - 025613564568 A/N Kantor Sipjamet Serang', '2020-02-01 08:50:00', 'awdawd', '23422342', 'Imam Agustian Nugraha', 230000, '1580576232768.jpg', 3, 'Imam Agustian Nugraha', 'PT. Senskay Development', 'imamagustiannugraha@ymail.com', '+6289671843158', 'Administrator ', 'Kepala Stasiun', '216549879879879889'),
(6, 'TC010220W5EH31M8', NULL, '2020-01-13 22:05:51', '2020-02-02 04:24:05', 1, 1, NULL, 4, '<p>awdawd</p>', NULL, 'Informasi Iklim untuk Agro Industri<li>Prakiraan Musim Kemarau</li>', NULL, 1, 230000, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Annisa', 'PT. Senskay ', NULL, NULL, NULL, NULL, NULL),
(7, 'TC010220ONZF9GLB', NULL, '2020-01-29 23:51:22', '2020-02-02 04:23:07', 1, 1, 2, 4, '<p>eet</p>', NULL, 'Informasi Iklim untuk Agro Industri<li>Prakiraan Musim Kemarau</li>', 'per buku', 1, 230000, 230000, 'Bank Negara Indonesia (BNI) - 025613564568 A/N Kantor Sipjamet Serang', '2020-02-02 23:03:00', 'awdawd', '234234', 'Imam Agustian Nugraha', 230000, '1580576804136.jpg', 3, 'Imam Agustian Nugraha', 'PT. Senskay Development', 'imamagustiannugraha@ymail.com', '+6289671843158', 'Administrator ', 'Kepala Stasiun', '216549879879879889'),
(8, 'TC030220XJKGNLE1', NULL, '2020-02-03 09:27:40', '2020-02-03 02:27:40', 4, NULL, NULL, 0, '<p>Meminta data curah hujan untuk keperluan penelitian</p><p>mahasiswa Universitas Serang Raya</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `user` varchar(128) NOT NULL,
  `action` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`applicant_id`),
  ADD KEY `job_category` (`job_category`);

--
-- Indexes for table `cands`
--
ALTER TABLE `cands`
  ADD PRIMARY KEY (`cands_id`),
  ADD KEY `applicant_id` (`applicant_id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`comp_id`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`doc_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trans_id` (`trans_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faqs_id`);

--
-- Indexes for table `job_category`
--
ALTER TABLE `job_category`
  ADD PRIMARY KEY (`jobcat_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `rate_answer`
--
ALTER TABLE `rate_answer`
  ADD PRIMARY KEY (`ratans_id`),
  ADD KEY `ratque_id` (`ratque_id`),
  ADD KEY `cands_id` (`cands_id`);

--
-- Indexes for table `rate_questions`
--
ALTER TABLE `rate_questions`
  ADD PRIMARY KEY (`ratque_id`);

--
-- Indexes for table `request_subtype`
--
ALTER TABLE `request_subtype`
  ADD PRIMARY KEY (`subtype_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `request_type`
--
ALTER TABLE `request_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sch_id`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `apply_id` (`apply_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `subtype_id` (`subtype_id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cands`
--
ALTER TABLE `cands`
  MODIFY `cands_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faqs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `job_category`
--
ALTER TABLE `job_category`
  MODIFY `jobcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rate_answer`
--
ALTER TABLE `rate_answer`
  MODIFY `ratans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rate_questions`
--
ALTER TABLE `rate_questions`
  MODIFY `ratque_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `request_subtype`
--
ALTER TABLE `request_subtype`
  MODIFY `subtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `request_type`
--
ALTER TABLE `request_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
