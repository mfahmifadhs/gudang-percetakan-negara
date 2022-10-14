-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2022 at 04:43 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kemenkes_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appletters`
--

CREATE TABLE `tbl_appletters` (
  `id_app_letter` varchar(15) NOT NULL,
  `workunit_id` int(11) NOT NULL,
  `appletter_file` text DEFAULT NULL,
  `appletter_purpose` enum('penyimpanan','pengeluaran') NOT NULL,
  `appletter_total_item` int(11) DEFAULT NULL,
  `appletter_date` datetime NOT NULL,
  `appletter_status` enum('proses','diterima','ditolak') NOT NULL,
  `appletter_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_appletters`
--

INSERT INTO `tbl_appletters` (`id_app_letter`, `workunit_id`, `appletter_file`, `appletter_purpose`, `appletter_total_item`, `appletter_date`, `appletter_status`, `appletter_note`) VALUES
('spm_123897', 17, NULL, 'penyimpanan', 5, '2022-09-23 11:24:16', 'diterima', NULL),
('spm_304322', 22, NULL, 'penyimpanan', 1, '2022-09-21 13:44:51', 'diterima', NULL),
('spm_404775', 21, NULL, 'penyimpanan', 3, '2022-09-21 13:28:39', 'diterima', NULL),
('spm_892916', 24, 'DO untuk BPFK.pdf', 'penyimpanan', 20, '2022-09-14 14:00:05', 'diterima', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appletters_entry`
--

CREATE TABLE `tbl_appletters_entry` (
  `id_appletter_entry` varchar(20) NOT NULL,
  `appletter_id` varchar(15) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `appletter_item_code` bigint(30) DEFAULT NULL,
  `appletter_item_nup` bigint(30) DEFAULT NULL,
  `appletter_item_name` text NOT NULL,
  `appletter_item_description` text DEFAULT NULL,
  `appletter_item_qty` int(11) NOT NULL,
  `appletter_item_unit` text NOT NULL,
  `item_condition_id` int(11) NOT NULL,
  `appletter_item_status` enum('terima','tolak') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_appletters_entry`
--

INSERT INTO `tbl_appletters_entry` (`id_appletter_entry`, `appletter_id`, `item_category_id`, `appletter_item_code`, `appletter_item_nup`, `appletter_item_name`, `appletter_item_description`, `appletter_item_qty`, `appletter_item_unit`, `item_condition_id`, `appletter_item_status`) VALUES
('spm_item_10940', 'spm_123897', 1, NULL, NULL, 'HFNC', NULL, 12, 'box', 1, NULL),
('spm_item_11908', 'spm_892916', 1, NULL, NULL, 'Capp plate Shaker', NULL, 1, 'unit', 1, 'terima'),
('spm_item_22780', 'spm_892916', 1, NULL, NULL, 'Tende Vav Incubator', NULL, 1, 'unit', 1, 'terima'),
('spm_item_229817', 'spm_892916', 1, NULL, NULL, 'Capp Refregate Centrifuge', NULL, 1, 'unit', 1, 'terima'),
('spm_item_245413', 'spm_892916', 1, NULL, NULL, 'Capp Tube rotator', NULL, 1, 'unit', 1, 'terima'),
('spm_item_292712', 'spm_892916', 1, NULL, NULL, 'Capp universal centrifuge', NULL, 1, 'unit', 1, 'terima'),
('spm_item_309018', 'spm_892916', 1, NULL, NULL, 'Capp Microplate Centrifuge', NULL, 1, 'unit', 1, 'terima'),
('spm_item_332716', 'spm_892916', 1, NULL, NULL, 'Capp 3D shaker', NULL, 1, 'unit', 1, 'terima'),
('spm_item_363211', 'spm_892916', 1, NULL, NULL, 'Capp 4 Place plat shaker', NULL, 1, 'unit', 1, 'terima'),
('spm_item_37745', 'spm_892916', 1, NULL, NULL, 'Capp vortex mixer 4500 rpm', NULL, 1, 'unit', 1, 'terima'),
('spm_item_38070', 'spm_404775', 2, NULL, NULL, 'masker medis', 'ada 70 dus, 1 dus isi 40 box', 2880, 'box', 1, 'terima'),
('spm_item_381215', 'spm_892916', 1, NULL, NULL, 'Capp Mini Incubator', NULL, 1, 'unit', 1, 'terima'),
('spm_item_38349', 'spm_892916', 1, NULL, NULL, 'Capp Plate shaker incubating', NULL, 1, 'unit', 1, 'terima'),
('spm_item_40031', 'spm_123897', 1, NULL, NULL, 'Aksesoris HFNC', NULL, 14, 'box', 1, NULL),
('spm_item_45404', 'spm_123897', 1, NULL, NULL, 'Ventilator', NULL, 19, 'box', 1, NULL),
('spm_item_45731', 'spm_892916', 1, NULL, NULL, 'Tende CareBlue', NULL, 1, 'unit', 1, 'terima'),
('spm_item_48981', 'spm_404775', 2, NULL, NULL, 'Air Purifier (2020)', NULL, 75, 'unit', 1, 'terima'),
('spm_item_55930', 'spm_304322', 2, NULL, NULL, 'Antigen', 'COVID-19 Antigen Rapid Test (Taishan Indonesia)', 50, 'box', 1, 'terima'),
('spm_item_58523', 'spm_123897', 1, NULL, NULL, 'Goggles kacamata', NULL, 25, 'box', 1, NULL),
('spm_item_60494', 'spm_892916', 1, NULL, NULL, 'Capp Vortex mixer 3000 rpm', NULL, 1, 'unit', 1, 'terima'),
('spm_item_68642', 'spm_404775', 2, NULL, NULL, 'Polybag sampah medis L (2021)', '15 karung isi 400 lembar dan 2 karung isi 500 lembar', 7000, 'lembar', 1, 'terima'),
('spm_item_69043', 'spm_892916', 1, NULL, NULL, 'Capp Oven Medium', NULL, 1, 'unit', 1, 'terima'),
('spm_item_719219', 'spm_892916', 1, NULL, NULL, 'Capp Micro centrifuge', NULL, 1, 'unit', 1, 'terima'),
('spm_item_813710', 'spm_892916', 1, NULL, NULL, 'Capp Magnetic Stirer 1500 rpm', NULL, 1, 'unit', 1, 'terima'),
('spm_item_86946', 'spm_892916', 1, NULL, NULL, 'Capp Mini Centrifuge', NULL, 1, 'unit', 1, 'terima'),
('spm_item_881114', 'spm_892916', 1, NULL, NULL, 'Capp Magnetik stirer 2200', NULL, 1, 'unit', 1, 'terima'),
('spm_item_90147', 'spm_892916', 1, NULL, NULL, 'Capp Clinical Centrifuge 6500 rpm', NULL, 1, 'unit', 1, 'terima'),
('spm_item_90942', 'spm_123897', 1, NULL, NULL, 'Aksesoris Ventilator', NULL, 82, 'box', 1, NULL),
('spm_item_97352', 'spm_892916', 1, NULL, NULL, 'Capp Incubator', NULL, 1, 'unit', 1, 'terima');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appletters_exit`
--

CREATE TABLE `tbl_appletters_exit` (
  `id_appletter_exit` varchar(20) NOT NULL,
  `appletter_id` varchar(15) NOT NULL,
  `item_id` varchar(20) NOT NULL,
  `slot_id` varchar(20) NOT NULL,
  `item_pick` int(11) DEFAULT NULL,
  `appletter_item_status` enum('terima','tolak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_historys`
--

CREATE TABLE `tbl_historys` (
  `id_history` varchar(100) NOT NULL,
  `hist_date` datetime NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `item_id` varchar(20) NOT NULL,
  `slot_id` varchar(20) NOT NULL,
  `hist_total_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_historys`
--

INSERT INTO `tbl_historys` (`id_history`, `hist_date`, `order_id`, `item_id`, `slot_id`, `hist_total_item`) VALUES
('hist_0210220857160', '2022-10-02 20:57:16', 'PBM_020210224', 'ITEM100222175', 'G09-11', 15),
('hist_0210220857161', '2022-10-02 20:57:16', 'PBM_020210224', 'ITEM100222175', 'G09-12', 15),
('hist_0210220857162', '2022-10-02 20:57:16', 'PBM_020210224', 'ITEM100222175', 'G09-13', 20),
('hist_0210220901270', '2022-10-02 21:01:27', 'PBK_020210225', 'ITEM100222175', 'G09-13', 20),
('hist_0210220901271', '2022-10-02 21:01:27', 'PBK_020210225', 'ITEM100222175', 'G09-11', 15),
('hist_0210220901272', '2022-10-02 21:01:27', 'PBK_020210225', 'ITEM100222175', 'G09-12', 15),
('hist_2109220152150', '2022-09-21 13:52:15', 'PBM_212109221', 'ITEM092122745', 'G05B-IIA1', 10),
('hist_2109220152151', '2022-09-21 13:52:15', 'PBM_212109221', 'ITEM092122745', 'G05B-IIA2', 10),
('hist_2109220152152', '2022-09-21 13:52:15', 'PBM_212109221', 'ITEM092122745', 'G05B-IIA3', 10),
('hist_2109220152153', '2022-09-21 13:52:15', 'PBM_212109221', 'ITEM092122745', 'G05B-IIA4', 10),
('hist_2109220152154', '2022-09-21 13:52:15', 'PBM_212109221', 'ITEM092122745', 'G05B-IIB1', 4),
('hist_2109220152155', '2022-09-21 13:52:15', 'PBM_212109221', 'ITEM092122745', 'G05B-IIB2', 4),
('hist_2109220152156', '2022-09-21 13:52:15', 'PBM_212109221', 'ITEM092122745', 'G05B-IIB3', 2),
('hist_2109220207180', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122123', 'G02A', 1),
('hist_2109220207181', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122165', 'G02A', 1),
('hist_2109220207182', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122209', 'G02A', 1),
('hist_2109220207183', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122217', 'G02A', 1),
('hist_2109220207184', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122345', 'G02A', 1),
('hist_2109220207185', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122362', 'G02A', 1),
('hist_2109220207186', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122433', 'G02A', 1),
('hist_2109220207187', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122451', 'G02A', 1),
('hist_2109220207188', '2022-09-21 14:07:18', 'PBM_212109222', 'ITEM092122502', 'G02A', 1),
('hist_21092202071910', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122588', 'G02A', 1),
('hist_21092202071911', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122592', 'G02A', 1),
('hist_21092202071912', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122639', 'G02A', 1),
('hist_21092202071913', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122641', 'G02A', 1),
('hist_21092202071914', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122644', 'G02A', 1),
('hist_21092202071915', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122728', 'G02A', 1),
('hist_21092202071916', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122865', 'G02A', 1),
('hist_21092202071917', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122910', 'G02A', 1),
('hist_21092202071918', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122920', 'G02A', 1),
('hist_21092202071919', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122969', 'G02A', 1),
('hist_2109220207199', '2022-09-21 14:07:19', 'PBM_212109222', 'ITEM092122571', 'G02A', 1),
('hist_212109220', '2022-09-21 13:36:27', 'PBM_212109220', 'ITEM092122535', 'G05B-IA1', 15),
('hist_212109221', '2022-09-21 13:36:27', 'PBM_212109220', 'ITEM092122535', 'G05B-IA2', 15),
('hist_2121092210', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122537', 'G05B-IB3', 3000),
('hist_2121092211', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122537', 'G05B-IB4', 3000),
('hist_212109222', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122535', 'G05B-IA3', 15),
('hist_212109223', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122535', 'G05B-IB1', 15),
('hist_212109224', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122535', 'G05B-IB2', 15),
('hist_212109225', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122922', 'G05B-IA4', 576),
('hist_212109226', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122922', 'G05B-IA5', 576),
('hist_212109227', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122922', 'G05B-IA6', 576),
('hist_212109228', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122922', 'G05B-IB5', 576),
('hist_212109229', '2022-09-21 13:36:28', 'PBM_212109220', 'ITEM092122922', 'G05B-IB6', 576),
('hist_2309221128360', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322110', 'G09-01', 12),
('hist_2309221128361', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322236', 'G09-02', 14),
('hist_2309221128362', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322453', 'G09-03', 14),
('hist_2309221128363', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322273', 'G09-04', 25),
('hist_2309221128364', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322453', 'G09-05', 15),
('hist_2309221128365', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322453', 'G09-06', 17),
('hist_2309221128366', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322453', 'G09-07', 12),
('hist_2309221128367', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322453', 'G09-08', 7),
('hist_2309221128368', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322442', 'G09-09', 19),
('hist_2309221128369', '2022-09-23 11:28:36', 'PBM_232309223', 'ITEM092322453', 'G09-10', 17);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id_item` varchar(50) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `item_code` bigint(20) DEFAULT NULL,
  `item_nup` int(11) DEFAULT NULL,
  `item_name` varchar(200) DEFAULT NULL,
  `item_description` text DEFAULT NULL,
  `item_qty` int(11) DEFAULT NULL,
  `item_unit` varchar(50) DEFAULT NULL,
  `item_purchase` int(11) DEFAULT NULL,
  `item_condition_id` int(11) DEFAULT NULL,
  `item_img` timestamp NULL DEFAULT NULL,
  `item_status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id_item`, `order_id`, `item_category_id`, `item_code`, `item_nup`, `item_name`, `item_description`, `item_qty`, `item_unit`, `item_purchase`, `item_condition_id`, `item_img`, `item_status_id`) VALUES
('ITEM092122123', 'PBM_212109222', 1, NULL, NULL, 'Capp Mini Incubator', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122165', 'PBM_212109222', 1, NULL, NULL, 'Capp universal centrifuge', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122209', 'PBM_212109222', 1, NULL, NULL, 'Capp 4 Place plat shaker', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122217', 'PBM_212109222', 1, NULL, NULL, 'Capp Clinical Centrifuge 6500 rpm', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122345', 'PBM_212109222', 1, NULL, NULL, 'Capp Magnetik stirer 2200', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122362', 'PBM_212109222', 1, NULL, NULL, 'Capp Mini Centrifuge', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122433', 'PBM_212109222', 1, NULL, NULL, 'Tende Vav Incubator', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122451', 'PBM_212109222', 1, NULL, NULL, 'Capp 3D shaker', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122502', 'PBM_212109222', 1, NULL, NULL, 'Capp vortex mixer 4500 rpm', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122535', 'PBM_212109220', 2, NULL, NULL, 'Air Purifier (2020)', NULL, 75, 'unit', NULL, 1, NULL, NULL),
('ITEM092122537', 'PBM_212109220', 2, NULL, NULL, 'Polybag sampah medis L (2021)', '15 karung isi 400 lembar dan 2 karung isi 500 lembar', 7000, 'lembar', NULL, 1, NULL, NULL),
('ITEM092122571', 'PBM_212109222', 1, NULL, NULL, 'Capp Vortex mixer 3000 rpm', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122588', 'PBM_212109222', 1, NULL, NULL, 'Capp Incubator', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122592', 'PBM_212109222', 1, NULL, NULL, 'Capp Oven Medium', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122639', 'PBM_212109222', 1, NULL, NULL, 'Tende CareBlue', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122641', 'PBM_212109222', 1, NULL, NULL, 'Capp Magnetic Stirer 1500 rpm', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122644', 'PBM_212109222', 1, NULL, NULL, 'Capp Micro centrifuge', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122728', 'PBM_212109222', 1, NULL, NULL, 'Capp Microplate Centrifuge', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122745', 'PBM_212109221', 2, NULL, NULL, 'Antigen', 'COVID-19 Antigen Rapid Test (Taishan Indonesia)', 50, 'box', NULL, 1, NULL, NULL),
('ITEM092122865', 'PBM_212109222', 1, NULL, NULL, 'Capp plate Shaker', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122910', 'PBM_212109222', 1, NULL, NULL, 'Capp Plate shaker incubating', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122920', 'PBM_212109222', 1, NULL, NULL, 'Capp Tube rotator', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092122922', 'PBM_212109220', 2, NULL, NULL, 'masker medis', 'ada 70 dus, 1 dus isi 40 box', 2880, 'box', NULL, 1, NULL, NULL),
('ITEM092122969', 'PBM_212109222', 1, NULL, NULL, 'Capp Refregate Centrifuge', NULL, 1, 'unit', NULL, 1, NULL, NULL),
('ITEM092322110', 'PBM_232309223', 1, NULL, NULL, 'HFNC', NULL, 12, 'box', NULL, 1, NULL, NULL),
('ITEM092322236', 'PBM_232309223', 1, NULL, NULL, 'Aksesoris HFNC', NULL, 14, 'box', NULL, 1, NULL, NULL),
('ITEM092322273', 'PBM_232309223', 1, NULL, NULL, 'Goggles kacamata', NULL, 25, 'box', NULL, 1, NULL, NULL),
('ITEM092322442', 'PBM_232309223', 1, NULL, NULL, 'Ventilator', NULL, 19, 'box', NULL, 1, NULL, NULL),
('ITEM092322453', 'PBM_232309223', 1, NULL, NULL, 'Aksesoris Ventilator', NULL, 82, 'box', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items_category`
--

CREATE TABLE `tbl_items_category` (
  `id_item_category` int(11) NOT NULL,
  `item_category_name` varchar(100) NOT NULL,
  `item_category_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_items_category`
--

INSERT INTO `tbl_items_category` (`id_item_category`, `item_category_name`, `item_category_description`) VALUES
(1, 'Barang Milik Negara (BMN)', 'Batas waktu penyimpanan 1 tahun, kode barang dan nup harus diisi'),
(2, 'Barang Persediaan', 'Batas waktu penyimpanan 1 tahun, jumlah barang harus sesuai'),
(3, 'Bongkaran', 'Meliputi barang hibah, barang bantuan maupun barang titipan'),
(4, 'Alat Angkutan Darat Bermotor', 'AADB meliputi kendaraan roda 2, roda 4, kapal dan lainya');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items_condition`
--

CREATE TABLE `tbl_items_condition` (
  `id_item_condition` int(11) NOT NULL,
  `item_condition_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_items_condition`
--

INSERT INTO `tbl_items_condition` (`id_item_condition`, `item_condition_name`) VALUES
(1, 'baik'),
(2, 'rusak ringan'),
(3, 'rusak berat');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items_screening`
--

CREATE TABLE `tbl_items_screening` (
  `id_item_screening` int(11) NOT NULL,
  `warrent_id` varchar(15) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `item_id` varchar(30) NOT NULL,
  `item_volume` int(11) NOT NULL,
  `item_received` int(11) NOT NULL,
  `status_screening` enum('sesuai','tidak sesuai') DEFAULT NULL,
  `screening_notes` text DEFAULT NULL,
  `screening_notes_workunit` text DEFAULT NULL,
  `approve_petugas` int(11) NOT NULL,
  `approve_workunit` int(11) DEFAULT NULL,
  `screening_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_items_screening`
--

INSERT INTO `tbl_items_screening` (`id_item_screening`, `warrent_id`, `order_id`, `item_id`, `item_volume`, `item_received`, `status_screening`, `screening_notes`, `screening_notes_workunit`, `approve_petugas`, `approve_workunit`, `screening_date`) VALUES
(21092200, 'warr_092122231', 'PBM_212109221', 'warr_entry_092122535', 75, 75, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092201, 'warr_092122231', 'PBM_212109221', 'warr_entry_092122537', 7000, 7000, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092202, 'warr_092122231', 'PBM_212109221', 'warr_entry_092122922', 2880, 2880, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092230, 'warr_092122135', 'PBM_212109221', 'warr_entry_092122745', 50, 50, 'sesuai', 'barang pindah dari gudang 06 B', NULL, 1, 1, '2022-09-21'),
(21092240, 'warr_092122135', 'PBM_212109221', 'warr_entry_092122745', 50, 50, 'sesuai', 'pindahan dari gudang 06 b', NULL, 1, NULL, '2022-09-21'),
(21092250, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122123', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092251, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122165', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092252, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122209', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092253, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122217', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092254, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122345', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092255, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122362', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092256, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122433', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092257, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122451', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092258, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122502', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(21092259, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122571', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922510, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122588', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922511, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122592', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922512, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122639', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922513, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122641', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922514, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122644', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922515, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122728', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922516, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122865', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922517, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122910', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922518, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122920', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(210922519, 'warr_092122881', 'PBM_212109222', 'warr_entry_092122969', 1, 1, 'sesuai', NULL, NULL, 1, 1, '2022-09-21'),
(230922250, 'warr_092322329', 'PBM_232309223', 'warr_entry_092322110', 12, 12, 'sesuai', NULL, NULL, 1, 1, '2022-09-23'),
(230922251, 'warr_092322329', 'PBM_232309223', 'warr_entry_092322236', 14, 14, 'sesuai', NULL, NULL, 1, 1, '2022-09-23'),
(230922252, 'warr_092322329', 'PBM_232309223', 'warr_entry_092322273', 25, 25, 'sesuai', NULL, NULL, 1, 1, '2022-09-23'),
(230922253, 'warr_092322329', 'PBM_232309223', 'warr_entry_092322442', 19, 19, 'sesuai', NULL, NULL, 1, 1, '2022-09-23'),
(230922254, 'warr_092322329', 'PBM_232309223', 'warr_entry_092322453', 82, 82, 'sesuai', NULL, NULL, 1, 1, '2022-09-23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items_status`
--

CREATE TABLE `tbl_items_status` (
  `id_item_status` int(11) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `item_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mainunits`
--

CREATE TABLE `tbl_mainunits` (
  `id_mainunit` int(11) NOT NULL,
  `mainunit_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_mainunits`
--

INSERT INTO `tbl_mainunits` (`id_mainunit`, `mainunit_name`) VALUES
(1, 'Sekretariat Jenderal'),
(2, 'Inspektorat Jenderal'),
(3, 'Direktorat Jenderal Kesehatan Masyarakat'),
(4, 'Direktorat Jenderal Pencegahan dan Pengendalian Penyakit'),
(5, 'Direktorat Jenderal Pelayanan Kesehatan'),
(6, 'Direktorat Jenderal Kefarmasian dan Alat Kesehatan'),
(7, 'Badan Penelitian dan Pengembangan Kesehatan'),
(8, 'Badan Pengembangan dan Pemberdayaan SDM Kesehatan'),
(9, 'Menteri Kesehatan'),
(10, '-');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id_order` varchar(100) NOT NULL,
  `warrent_id` varchar(30) DEFAULT NULL,
  `adminuser_id` varchar(50) DEFAULT NULL,
  `workunit_id` int(11) NOT NULL,
  `order_license_vehicle` varchar(50) NOT NULL,
  `order_emp_name` varchar(50) NOT NULL,
  `order_emp_position` varchar(50) NOT NULL,
  `order_total_item` int(11) DEFAULT NULL,
  `order_category` enum('penyimpanan','pengeluaran') NOT NULL,
  `order_tm` time NOT NULL,
  `order_dt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id_order`, `warrent_id`, `adminuser_id`, `workunit_id`, `order_license_vehicle`, `order_emp_name`, `order_emp_position`, `order_total_item`, `order_category`, `order_tm`, `order_dt`) VALUES
('PBK_020210225', 'warr_100222957', '2', 1, 'B9233PIA', 'nurdin', 'staff', 3, 'pengeluaran', '21:00:17', '2022-10-02'),
('PBM_020210224', 'warr_100222671', '2', 1, 'B9233PIA', 'nurdin', 'staff', 1, 'penyimpanan', '20:53:43', '2022-10-02'),
('PBM_212109220', 'warr_092122231', '2', 10, 'B9233PIA', 'sulistawan', 'staff', 3, 'penyimpanan', '13:31:12', '2022-09-21'),
('PBM_212109221', 'warr_092122135', '2', 22, '-', '-', '-', 1, 'penyimpanan', '13:51:08', '2022-09-21'),
('PBM_212109222', 'warr_092122881', '2', 24, 'D8913FJ', 'Rian', 'PT. Multiguna Ciptasentosa', 20, 'penyimpanan', '14:02:47', '2022-09-21'),
('PBM_232309223', 'warr_092322329', '2', 17, '-', '-', '-', 5, 'penyimpanan', '11:25:40', '2022-09-23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders_data`
--

CREATE TABLE `tbl_orders_data` (
  `id_order_data` varchar(100) NOT NULL,
  `item_id` varchar(30) DEFAULT NULL,
  `slot_id` varchar(50) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `total_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_orders_data`
--

INSERT INTO `tbl_orders_data` (`id_order_data`, `item_id`, `slot_id`, `deadline`, `total_item`) VALUES
('DATA2109221076', 'ITEM092122433', 'G02A', '2022-09-21', 1),
('DATA21092216010', 'ITEM092122588', 'G02A', '2022-09-21', 1),
('DATA2109221744', 'ITEM092122345', 'G02A', '2022-09-21', 1),
('DATA21092229015', 'ITEM092122728', 'G02A', '2022-09-21', 1),
('DATA2109223370', 'ITEM092122123', 'G02A', '2022-09-21', 1),
('DATA2109223481', 'ITEM092122535', 'G05B-IA2', '2023-08-31', 15),
('DATA21092237718', 'ITEM092122920', 'G02A', '2022-09-21', 1),
('DATA21092239919', 'ITEM092122969', 'G02A', '2022-09-21', 1),
('DATA21092248411', 'ITEM092122592', 'G02A', '2022-09-21', 1),
('DATA21092250312', 'ITEM092122639', 'G02A', '2022-09-21', 1),
('DATA2109225423', 'ITEM092122217', 'G02A', '2022-09-21', 1),
('DATA2109225580', 'ITEM092122535', 'G05B-IA1', '2023-08-31', 15),
('DATA2109226148', 'ITEM092122502', 'G02A', '2022-09-21', 1),
('DATA21092266716', 'ITEM092122865', 'G02A', '2022-09-21', 1),
('DATA2109227047', 'ITEM092122451', 'G02A', '2022-09-21', 1),
('DATA2109227225', 'ITEM092122362', 'G02A', '2022-09-21', 1),
('DATA2109227299', 'ITEM092122571', 'G02A', '2022-09-21', 1),
('DATA2109227472', 'ITEM092122209', 'G02A', '2022-09-21', 1),
('DATA21092276517', 'ITEM092122910', 'G02A', '2022-09-21', 1),
('DATA2109227722', 'ITEM092122745', 'G05B-IIA2', '2022-09-21', 10),
('DATA2109227723', 'ITEM092122745', 'G05B-IIA3', '2022-09-21', 10),
('DATA2109227724', 'ITEM092122745', 'G05B-IIA4', '2022-09-21', 10),
('DATA2109227725', 'ITEM092122745', 'G05B-IIB1', '2022-09-21', 4),
('DATA2109227726', 'ITEM092122745', 'G05B-IIB2', '2022-09-21', 4),
('DATA2109227727', 'ITEM092122745', 'G05B-IIB3', '2022-09-21', 2),
('DATA21092277513', 'ITEM092122641', 'G02A', '2022-09-21', 1),
('DATA2109228342', 'ITEM092122535', 'G05B-IA3', '2023-08-31', 15),
('DATA2109228970', 'ITEM092122745', 'G05B-IIA1', '2022-09-21', 10),
('DATA21092290414', 'ITEM092122644', 'G02A', '2022-09-21', 1),
('DATA21092291210', 'ITEM092122922', 'G05B-IB6', '2023-08-31', 576),
('DATA21092291211', 'ITEM092122537', 'G05B-IB3', '2023-08-31', 3000),
('DATA21092291212', 'ITEM092122537', 'G05B-IB4', '2023-08-31', 3000),
('DATA2109229124', 'ITEM092122535', 'G05B-IB1', '2023-08-31', 15),
('DATA2109229125', 'ITEM092122535', 'G05B-IB2', '2023-08-31', 15),
('DATA2109229126', 'ITEM092122922', 'G05B-IA4', '2023-08-31', 576),
('DATA2109229127', 'ITEM092122922', 'G05B-IA5', '2023-08-31', 576),
('DATA2109229128', 'ITEM092122922', 'G05B-IA6', '2023-08-31', 576),
('DATA2109229129', 'ITEM092122922', 'G05B-IB5', '2023-08-31', 576),
('DATA2109229631', 'ITEM092122165', 'G02A', '2022-09-21', 1),
('DATA2309221332', 'ITEM092322453', 'G09-03', '2022-09-23', 14),
('DATA2309221690', 'ITEM092322110', 'G09-01', '2022-09-23', 12),
('DATA2309222201', 'ITEM092322236', 'G09-02', '2022-09-23', 14),
('DATA2309224633', 'ITEM092322273', 'G09-04', '2022-09-23', 25),
('DATA2309227664', 'ITEM092322453', 'G09-05', '2022-09-23', 15),
('DATA23092294410', 'ITEM092322453', 'G09-10', '2022-09-23', 17),
('DATA2309229446', 'ITEM092322453', 'G09-06', '2022-09-23', 17),
('DATA2309229447', 'ITEM092322453', 'G09-07', '2022-09-23', 12),
('DATA2309229448', 'ITEM092322453', 'G09-08', '2022-09-23', 7),
('DATA2309229449', 'ITEM092322442', 'G09-09', '2022-09-23', 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rack_details`
--

CREATE TABLE `tbl_rack_details` (
  `warehouse_id` varchar(50) NOT NULL,
  `rack_id` enum('I','II','III','IV') NOT NULL,
  `rack_level` enum('Atas','Bawah') NOT NULL,
  `id_slot_rack` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rack_details`
--

INSERT INTO `tbl_rack_details` (`warehouse_id`, `rack_id`, `rack_level`, `id_slot_rack`) VALUES
('G05B', 'I', 'Bawah', 'G05B-IA1'),
('G05B', 'I', 'Bawah', 'G05B-IA2'),
('G05B', 'I', 'Bawah', 'G05B-IA3'),
('G05B', 'I', 'Bawah', 'G05B-IA4'),
('G05B', 'I', 'Bawah', 'G05B-IA5'),
('G05B', 'I', 'Bawah', 'G05B-IA6'),
('G05B', 'I', 'Bawah', 'G05B-IA7'),
('G05B', 'I', 'Bawah', 'G05B-IA8'),
('G05B', 'I', 'Atas', 'G05B-IB1'),
('G05B', 'I', 'Atas', 'G05B-IB2'),
('G05B', 'I', 'Atas', 'G05B-IB3'),
('G05B', 'I', 'Atas', 'G05B-IB4'),
('G05B', 'I', 'Atas', 'G05B-IB5'),
('G05B', 'I', 'Atas', 'G05B-IB6'),
('G05B', 'I', 'Atas', 'G05B-IB7'),
('G05B', 'I', 'Atas', 'G05B-IB8'),
('G05B', 'II', 'Bawah', 'G05B-IIA1'),
('G05B', 'II', 'Bawah', 'G05B-IIA2'),
('G05B', 'II', 'Bawah', 'G05B-IIA3'),
('G05B', 'II', 'Bawah', 'G05B-IIA4'),
('G05B', 'II', 'Bawah', 'G05B-IIA5'),
('G05B', 'II', 'Bawah', 'G05B-IIA6'),
('G05B', 'II', 'Bawah', 'G05B-IIA7'),
('G05B', 'II', 'Bawah', 'G05B-IIA8'),
('G05B', 'II', 'Atas', 'G05B-IIB1'),
('G05B', 'II', 'Atas', 'G05B-IIB2'),
('G05B', 'II', 'Atas', 'G05B-IIB3'),
('G05B', 'II', 'Atas', 'G05B-IIB4'),
('G05B', 'II', 'Atas', 'G05B-IIB5'),
('G05B', 'II', 'Atas', 'G05B-IIB6'),
('G05B', 'II', 'Atas', 'G05B-IIB7'),
('G05B', 'II', 'Atas', 'G05B-IIB8'),
('G05B', 'III', 'Bawah', 'G05B-IIIA1'),
('G05B', 'III', 'Bawah', 'G05B-IIIA2'),
('G05B', 'III', 'Bawah', 'G05B-IIIA3'),
('G05B', 'III', 'Bawah', 'G05B-IIIA4'),
('G05B', 'III', 'Bawah', 'G05B-IIIA5'),
('G05B', 'III', 'Bawah', 'G05B-IIIA6'),
('G05B', 'III', 'Atas', 'G05B-IIIB1'),
('G05B', 'III', 'Atas', 'G05B-IIIB2'),
('G05B', 'III', 'Atas', 'G05B-IIIB3'),
('G05B', 'III', 'Atas', 'G05B-IIIB4'),
('G05B', 'III', 'Atas', 'G05B-IIIB5'),
('G05B', 'III', 'Atas', 'G05B-IIIB6'),
('G05B', 'IV', 'Bawah', 'G05B-IVA1'),
('G05B', 'IV', 'Bawah', 'G05B-IVA2'),
('G05B', 'IV', 'Bawah', 'G05B-IVA3'),
('G05B', 'IV', 'Bawah', 'G05B-IVA4'),
('G05B', 'IV', 'Bawah', 'G05B-IVA5'),
('G05B', 'IV', 'Bawah', 'G05B-IVA6'),
('G05B', 'IV', 'Bawah', 'G05B-IVA7'),
('G05B', 'IV', 'Atas', 'G05B-IVB1'),
('G05B', 'IV', 'Atas', 'G05B-IVB2'),
('G05B', 'IV', 'Atas', 'G05B-IVB3'),
('G05B', 'IV', 'Atas', 'G05B-IVB4'),
('G05B', 'IV', 'Atas', 'G05B-IVB5'),
('G05B', 'IV', 'Atas', 'G05B-IVB6'),
('G05B', 'IV', 'Atas', 'G05B-IVB7');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id_role` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id_role`, `role_name`) VALUES
(1, 'ADMIN MASTER'),
(2, 'TIM KERJA SARPEN GUDANG'),
(3, 'UNIT KERJA'),
(4, 'PETUGAS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slots`
--

CREATE TABLE `tbl_slots` (
  `id_slot` varchar(50) NOT NULL,
  `warehouse_id` varchar(50) NOT NULL,
  `slot_status` enum('tersedia','kosong','penuh') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_slots`
--

INSERT INTO `tbl_slots` (`id_slot`, `warehouse_id`, `slot_status`) VALUES
('0', 'G01', 'kosong'),
('G02A', 'G02', 'tersedia'),
('G03', 'G03', 'kosong'),
('G04B', 'G04B', 'kosong'),
('G05B-IA1', 'G05B', 'penuh'),
('G05B-IA2', 'G05B', 'penuh'),
('G05B-IA3', 'G05B', 'penuh'),
('G05B-IA4', 'G05B', 'penuh'),
('G05B-IA5', 'G05B', 'penuh'),
('G05B-IA6', 'G05B', 'penuh'),
('G05B-IA7', 'G05B', 'kosong'),
('G05B-IA8', 'G05B', 'kosong'),
('G05B-IB1', 'G05B', 'penuh'),
('G05B-IB2', 'G05B', 'penuh'),
('G05B-IB3', 'G05B', 'penuh'),
('G05B-IB4', 'G05B', 'penuh'),
('G05B-IB5', 'G05B', 'penuh'),
('G05B-IB6', 'G05B', 'penuh'),
('G05B-IB7', 'G05B', 'kosong'),
('G05B-IB8', 'G05B', 'kosong'),
('G05B-IIA1', 'G05B', 'penuh'),
('G05B-IIA2', 'G05B', 'penuh'),
('G05B-IIA3', 'G05B', 'penuh'),
('G05B-IIA4', 'G05B', 'penuh'),
('G05B-IIA5', 'G05B', 'kosong'),
('G05B-IIA6', 'G05B', 'kosong'),
('G05B-IIA7', 'G05B', 'kosong'),
('G05B-IIA8', 'G05B', 'kosong'),
('G05B-IIB1', 'G05B', 'tersedia'),
('G05B-IIB2', 'G05B', 'tersedia'),
('G05B-IIB3', 'G05B', 'tersedia'),
('G05B-IIB4', 'G05B', 'kosong'),
('G05B-IIB5', 'G05B', 'kosong'),
('G05B-IIB6', 'G05B', 'kosong'),
('G05B-IIB7', 'G05B', 'kosong'),
('G05B-IIB8', 'G05B', 'kosong'),
('G05B-IIIA1', 'G05B', 'kosong'),
('G05B-IIIA2', 'G05B', 'kosong'),
('G05B-IIIA3', 'G05B', 'kosong'),
('G05B-IIIA4', 'G05B', 'kosong'),
('G05B-IIIA5', 'G05B', 'kosong'),
('G05B-IIIA6', 'G05B', 'kosong'),
('G05B-IIIB1', 'G05B', 'kosong'),
('G05B-IIIB2', 'G05B', 'kosong'),
('G05B-IIIB3', 'G05B', 'kosong'),
('G05B-IIIB4', 'G05B', 'kosong'),
('G05B-IIIB5', 'G05B', 'kosong'),
('G05B-IIIB6', 'G05B', 'kosong'),
('G05B-IVA1', 'G05B', 'kosong'),
('G05B-IVA2', 'G05B', 'kosong'),
('G05B-IVA3', 'G05B', 'kosong'),
('G05B-IVA4', 'G05B', 'kosong'),
('G05B-IVA5', 'G05B', 'kosong'),
('G05B-IVA6', 'G05B', 'kosong'),
('G05B-IVA7', 'G05B', 'kosong'),
('G05B-IVB1', 'G05B', 'kosong'),
('G05B-IVB2', 'G05B', 'kosong'),
('G05B-IVB3', 'G05B', 'kosong'),
('G05B-IVB4', 'G05B', 'kosong'),
('G05B-IVB5', 'G05B', 'kosong'),
('G05B-IVB6', 'G05B', 'kosong'),
('G05B-IVB7', 'G05B', 'kosong'),
('G09-01', 'G09B', 'penuh'),
('G09-02', 'G09B', 'penuh'),
('G09-03', 'G09B', 'penuh'),
('G09-04', 'G09B', 'penuh'),
('G09-05', 'G09B', 'penuh'),
('G09-06', 'G09B', 'penuh'),
('G09-07', 'G09B', 'penuh'),
('G09-08', 'G09B', 'penuh'),
('G09-09', 'G09B', 'penuh'),
('G09-10', 'G09B', 'penuh'),
('G09-11', 'G09B', 'kosong'),
('G09-12', 'G09B', 'kosong'),
('G09-13', 'G09B', 'kosong'),
('G09-14', 'G09B', 'kosong'),
('G09-15', 'G09B', 'kosong'),
('G09-16', 'G09B', 'kosong'),
('G09-17', 'G09B', 'kosong'),
('G09-18', 'G09B', 'kosong'),
('G09-19', 'G09B', 'kosong'),
('G09-20', 'G09B', 'kosong'),
('G09-21', 'G09B', 'kosong'),
('G09-22', 'G09B', 'kosong'),
('G09-23', 'G09B', 'kosong'),
('G09-24', 'G09B', 'kosong'),
('G09-25', 'G09B', 'kosong'),
('G09-26', 'G09B', 'kosong'),
('G09-27', 'G09B', 'kosong'),
('G09-28', 'G09B', 'kosong'),
('G09-29', 'G09B', 'kosong'),
('G09-30', 'G09B', 'kosong'),
('G09-31', 'G09B', 'kosong'),
('G09-32', 'G09B', 'kosong'),
('G09-33', 'G09B', 'kosong'),
('G09-34', 'G09B', 'kosong'),
('G09-35', 'G09B', 'kosong'),
('G09-36', 'G09B', 'kosong'),
('G09-37', 'G09B', 'kosong'),
('G09-38', 'G09B', 'kosong'),
('G09-39', 'G09B', 'kosong'),
('G09-40', 'G09B', 'kosong'),
('G09-41', 'G09B', 'kosong'),
('G09-42', 'G09B', 'kosong'),
('G09-43', 'G09B', 'kosong'),
('G09-44', 'G09B', 'kosong'),
('G09-45', 'G09B', 'kosong'),
('G09-46', 'G09B', 'kosong'),
('G09-47', 'G09B', 'kosong'),
('G09-48', 'G09B', 'kosong'),
('G09-49', 'G09B', 'kosong'),
('G09-50', 'G09B', 'kosong'),
('G09-51', 'G09B', 'kosong'),
('G09A', 'G09A', 'kosong');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slots_names`
--

CREATE TABLE `tbl_slots_names` (
  `id` int(11) NOT NULL,
  `pallet_id` varchar(50) DEFAULT NULL,
  `pallet_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_slots_names`
--

INSERT INTO `tbl_slots_names` (`id`, `pallet_id`, `pallet_name`) VALUES
(1, 'G09-10', 'G09-10'),
(2, 'G09-20', 'G09-20'),
(3, 'G09-30', 'G09-30'),
(4, 'G09-40', 'G09-40'),
(5, 'G09-51', 'G09-51'),
(6, 'G09-09', 'G09-09'),
(7, 'G09-19', 'G09-19'),
(8, 'G09-29', 'G09-29'),
(9, 'G09-39', 'G09-39'),
(10, 'G09-50', 'G09-50'),
(11, 'G09-08', 'G09-08'),
(12, 'G09-18', 'G09-18'),
(13, 'G09-28', 'G09-28'),
(14, 'G09-38', 'G09-38'),
(15, 'G09-49', 'G09-49'),
(16, 'G09-07', 'G09-07'),
(17, 'G09-17', 'G09-17'),
(18, 'G09-27', 'G09-27'),
(19, 'G09-37', 'G09-37'),
(20, 'G09-48', 'G09-48'),
(21, 'G09-06', 'G09-06'),
(22, 'G09-16', 'G09-16'),
(23, 'G09-26', 'G09-26'),
(24, 'G09-36', 'G09-36'),
(25, 'G09-47', 'G09-47'),
(26, 'G09-05', 'G09-05'),
(27, 'G09-15', 'G09-15'),
(28, 'G09-25', 'G09-25'),
(29, 'G09-35', 'G09-35'),
(30, 'G09-46', 'G09-46'),
(31, 'G09-04', 'G09-04'),
(32, 'G09-14', 'G09-14'),
(33, 'G09-24', 'G09-24'),
(34, 'G09-34', 'G09-34'),
(35, 'G09-45', 'G09-45'),
(36, 'G09-03', 'G09-03'),
(37, 'G09-13', 'G09-13'),
(38, 'G09-23', 'G09-23'),
(39, 'G09-33', 'G09-33'),
(40, 'G09-44', 'G09-44'),
(41, 'G09-02', 'G09-02'),
(42, 'G09-12', 'G09-12'),
(43, 'G09-22', 'G09-22'),
(44, 'G09-32', 'G09-32'),
(45, 'G09-43', 'G09-43'),
(46, 'G09-01', 'G09-01'),
(47, 'G09-11', 'G09-11'),
(48, 'G09-21', 'G09-21'),
(49, 'G09-31', 'G09-31'),
(50, 'G09-42', 'G09-42'),
(51, '0', '----------'),
(52, 'G09-41', 'G09-41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `id_status` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`id_status`, `status_name`) VALUES
(1, 'Aktif'),
(2, 'Tidak Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouses`
--

CREATE TABLE `tbl_warehouses` (
  `id_warehouse` varchar(50) NOT NULL,
  `warehouse_category` enum('Racking','Palleting','Lainya') NOT NULL,
  `warehouse_name` varchar(100) NOT NULL,
  `warehouse_description` text DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_warehouses`
--

INSERT INTO `tbl_warehouses` (`id_warehouse`, `warehouse_category`, `warehouse_name`, `warehouse_description`, `status_id`) VALUES
('G01', 'Lainya', 'Gedung 01', '<p>Gedung Laboratorium Penelitian Penyakit Infeksi</p>', 2),
('G02', 'Lainya', 'Gedung 02 A', '<p>Gudang Obat, Logistik Covid-19, Alat Kesehatan, dan Barang Persediaan. Posisi Gudang di Sebelah Kiri<br></p>', 1),
('G03', 'Lainya', 'Gedung 03', '<div style=\"text-align: left;\">Gudang Obat, Logistik Covid-19,&nbsp; Alat Kesehatan, Barang Persediaan, Cetakan, dan Meubelair</div>', 1),
('G04A', 'Lainya', 'Gedung 04 A', '<ol><li>Biro Umum</li><li>Biro Perencanaan dan Anggaran</li></ol>', 2),
('G04B', 'Lainya', 'Gedung 04 B', NULL, 1),
('G04C', 'Lainya', 'Gedung 04 C', '<ol><li>RSCM</li><li>RS Kanker Dharmais</li><li>Sekretariat Direktorat Jenderal Pelayanan Kesehatan</li></ol>', 2),
('G04D', 'Lainya', 'Gedung 04 D', '<ol><li>RSCM</li><li>Sekretariat Direktorat Jenderal Pelayanan Kesehatan</li></ol>', 2),
('G04E', 'Lainya', 'Gedung 04 E', '<ol><li>Biro Umum</li></ol>', 2),
('G04F', 'Lainya', 'Gedung 04 F', '<ol><li>Biro Umum</li></ol>', 2),
('G05A', 'Lainya', 'Gedung 05 A', '<p>Meubelair dan Alat Komputer</p><p>SATKER Pengguna :</p><ol><li>Biro Keuangan</li><li>BMN</li></ol>', 2),
('G05B', 'Racking', 'Gedung 05 B', 'Belum terisi', 1),
('G05C', 'Lainya', 'Gedung 05 C', '<p>Meubelair, Barang Persediaan dan Logistik Covid-19</p><p>SATKER Pengguna :</p><ol><li>Biro Umum</li><li>Direktorat Promosi Kesehatan</li><li>Fasilitas Layanan Kesehatan</li></ol>', 2),
('G05D', 'Lainya', 'Gedung 05 D', '<p>Peralatan Evakuasi</p><p>SATKER Pengguna :</p><ol><li>Pusat Krisis Kesehatan</li></ol>', 2),
('G05E', 'Lainya', 'Gedung 05 E', '<p>Peralatan Evakuasi</p><p>SATKER Pengguna :</p><ol><li>Pusat Krisis Kesehatan</li></ol>', 2),
('G05F', 'Lainya', 'Gedung 05 F', '<p>Cetakan, Persediaan</p><p>SATKER Pengguna :</p><ol><li>Sekretariat Direktorat Jenderal Kesehatan Masyarakat</li></ol>', 2),
('G06A', 'Lainya', 'Gedung 06 A', '<ol><li>Gedung Dr. Soejoto Records Center Kemenkes RI</li></ol>', 2),
('G06B', 'Lainya', 'Gedung 06 B', '<ol><li>Gedung Pusat Krisis Kesehatan</li></ol>', 2),
('G06C', 'Lainya', 'Gedung 06 C', NULL, 2),
('G07', 'Lainya', 'Gedung 07', '<p>Peralatan Evakuasi</p><p>SATKER Pengguna :</p><ol><li>Pusat Krisis Kesehatan</li></ol>', 2),
('G08', 'Lainya', 'Gedung 08', '<p>Perkantoran dan Penyimpanan Peralatan Evakuasi Bencana</p><p>SATKER Pengguna :</p><ol><li>Pusat Krisis Kesehatan</li></ol>', 2),
('G09A', 'Lainya', 'Gedung 09 Atas', NULL, 2),
('G09B', 'Palleting', 'Gedung 09 Bawah', NULL, 1),
('G10', 'Lainya', 'Gedung 10', '<p>Gedung Perkantoran Biomedis</p>', 2),
('G11', 'Lainya', 'Gedung 11', '<p>Gedung Perkantoran Biro Umum</p>', 2),
('G12', 'Lainya', 'Gedung 12', '<p>Gedung Meubelair Biro Umum</p>', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warrents`
--

CREATE TABLE `tbl_warrents` (
  `id_warrent` varchar(15) NOT NULL,
  `appletter_id` varchar(15) NOT NULL,
  `warr_file` text DEFAULT NULL,
  `workunit_id` int(11) NOT NULL,
  `warr_emp_name` varchar(100) DEFAULT NULL,
  `warr_emp_position` varchar(100) DEFAULT NULL,
  `warr_purpose` enum('penyimpanan','pengeluaran') NOT NULL,
  `warr_total_item` int(11) NOT NULL,
  `warr_date` date NOT NULL,
  `warr_status` enum('proses','konfirmasi','proses barang','selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_warrents`
--

INSERT INTO `tbl_warrents` (`id_warrent`, `appletter_id`, `warr_file`, `workunit_id`, `warr_emp_name`, `warr_emp_position`, `warr_purpose`, `warr_total_item`, `warr_date`, `warr_status`) VALUES
('warr_092122135', 'spm_304322', NULL, 22, '-', '-', 'penyimpanan', 1, '2022-09-21', 'selesai'),
('warr_092122231', 'spm_404775', NULL, 21, 'sulistawan', 'staff', 'penyimpanan', 3, '2022-09-21', 'selesai'),
('warr_092122881', 'spm_892916', 'DO untuk BPFK.pdf', 24, 'Rian', 'Dari PT. Multiguna Ciptasentosa', 'penyimpanan', 20, '2022-09-21', 'selesai'),
('warr_092322329', 'spm_123897', NULL, 17, '-', '-', 'penyimpanan', 5, '2022-09-23', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warrents_entry`
--

CREATE TABLE `tbl_warrents_entry` (
  `id_warr_entry` varchar(30) NOT NULL,
  `warrent_id` varchar(15) NOT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `warr_item_code` bigint(50) DEFAULT NULL,
  `warr_item_nup` int(11) DEFAULT NULL,
  `warr_item_name` varchar(255) DEFAULT NULL,
  `warr_item_description` text DEFAULT NULL,
  `warr_item_qty` int(11) DEFAULT NULL,
  `warr_item_unit` varchar(50) DEFAULT NULL,
  `item_condition_id` int(11) DEFAULT NULL,
  `warr_item_status` enum('sesuai','tidak sesuai') DEFAULT NULL,
  `warr_item_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_warrents_entry`
--

INSERT INTO `tbl_warrents_entry` (`id_warr_entry`, `warrent_id`, `item_category_id`, `warr_item_code`, `warr_item_nup`, `warr_item_name`, `warr_item_description`, `warr_item_qty`, `warr_item_unit`, `item_condition_id`, `warr_item_status`, `warr_item_note`) VALUES
('warr_entry_092122123', 'warr_092122881', 1, NULL, NULL, 'Capp Mini Incubator', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122165', 'warr_092122881', 1, NULL, NULL, 'Capp universal centrifuge', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122209', 'warr_092122881', 1, NULL, NULL, 'Capp 4 Place plat shaker', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122217', 'warr_092122881', 1, NULL, NULL, 'Capp Clinical Centrifuge 6500 rpm', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122345', 'warr_092122881', 1, NULL, NULL, 'Capp Magnetik stirer 2200', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122362', 'warr_092122881', 1, NULL, NULL, 'Capp Mini Centrifuge', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122433', 'warr_092122881', 1, NULL, NULL, 'Tende Vav Incubator', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122451', 'warr_092122881', 1, NULL, NULL, 'Capp 3D shaker', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122502', 'warr_092122881', 1, NULL, NULL, 'Capp vortex mixer 4500 rpm', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122535', 'warr_092122231', 2, NULL, NULL, 'Air Purifier (2020)', NULL, 75, 'unit', 1, NULL, NULL),
('warr_entry_092122537', 'warr_092122231', 2, NULL, NULL, 'Polybag sampah medis L (2021)', '15 karung isi 400 lembar dan 2 karung isi 500 lembar', 7000, 'lembar', 1, NULL, NULL),
('warr_entry_092122571', 'warr_092122881', 1, NULL, NULL, 'Capp Vortex mixer 3000 rpm', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122588', 'warr_092122881', 1, NULL, NULL, 'Capp Incubator', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122592', 'warr_092122881', 1, NULL, NULL, 'Capp Oven Medium', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122639', 'warr_092122881', 1, NULL, NULL, 'Tende CareBlue', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122641', 'warr_092122881', 1, NULL, NULL, 'Capp Magnetic Stirer 1500 rpm', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122644', 'warr_092122881', 1, NULL, NULL, 'Capp Micro centrifuge', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122728', 'warr_092122881', 1, NULL, NULL, 'Capp Microplate Centrifuge', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122745', 'warr_092122135', 2, NULL, NULL, 'Antigen', 'COVID-19 Antigen Rapid Test (Taishan Indonesia)', 50, 'box', 1, NULL, NULL),
('warr_entry_092122865', 'warr_092122881', 1, NULL, NULL, 'Capp plate Shaker', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122910', 'warr_092122881', 1, NULL, NULL, 'Capp Plate shaker incubating', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122920', 'warr_092122881', 1, NULL, NULL, 'Capp Tube rotator', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092122922', 'warr_092122231', 2, NULL, NULL, 'masker medis', 'ada 70 dus, 1 dus isi 40 box', 2880, 'box', 1, NULL, NULL),
('warr_entry_092122969', 'warr_092122881', 1, NULL, NULL, 'Capp Refregate Centrifuge', NULL, 1, 'unit', 1, NULL, NULL),
('warr_entry_092322110', 'warr_092322329', 1, NULL, NULL, 'HFNC', NULL, 12, 'box', 1, NULL, NULL),
('warr_entry_092322236', 'warr_092322329', 1, NULL, NULL, 'Aksesoris HFNC', NULL, 14, 'box', 1, NULL, NULL),
('warr_entry_092322273', 'warr_092322329', 1, NULL, NULL, 'Goggles kacamata', NULL, 25, 'box', 1, NULL, NULL),
('warr_entry_092322442', 'warr_092322329', 1, NULL, NULL, 'Ventilator', NULL, 19, 'box', 1, NULL, NULL),
('warr_entry_092322453', 'warr_092322329', 1, NULL, NULL, 'Aksesoris Ventilator', NULL, 82, 'box', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warrents_exit`
--

CREATE TABLE `tbl_warrents_exit` (
  `id_warr_exit` varchar(20) NOT NULL,
  `warrent_id` varchar(15) NOT NULL,
  `item_id` varchar(20) NOT NULL,
  `slot_id` varchar(20) NOT NULL,
  `warr_item_pick` int(11) NOT NULL,
  `warr_item_status` enum('sesuai','tidak sesuai') DEFAULT NULL,
  `warr_item_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_workunits`
--

CREATE TABLE `tbl_workunits` (
  `id_workunit` int(11) NOT NULL,
  `mainunit_id` int(11) NOT NULL,
  `workunit_name` varchar(100) NOT NULL,
  `workunit_head_nip` varchar(50) DEFAULT NULL,
  `workunit_head_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_workunits`
--

INSERT INTO `tbl_workunits` (`id_workunit`, `mainunit_id`, `workunit_name`, `workunit_head_nip`, `workunit_head_name`) VALUES
(1, 1, 'Biro Umum', NULL, NULL),
(2, 3, 'Administrasi Umum', NULL, NULL),
(3, 1, 'Biro Perencanaan dan Anggaran', NULL, NULL),
(4, 1, 'Biro Keuangan dan Barang Milik Negara', NULL, NULL),
(5, 1, 'Biro Hukum dan Organisasi', NULL, NULL),
(6, 1, 'Biro Kepegawaian', NULL, NULL),
(7, 1, 'Biro Kerjasama Luar Negeri', NULL, NULL),
(8, 1, 'Biro Komunikasi dan Pelayanan Masyarakat', NULL, NULL),
(9, 3, 'Direktorat Kesehatan Keluarga', NULL, NULL),
(10, 3, 'Direktorat Penyehatan Lingkungan', NULL, NULL),
(11, 3, 'Direktorat Kesehatan Kerja dan Olahraga', NULL, NULL),
(12, 3, 'Direktorat Gizi Masyarakat', NULL, NULL),
(13, 3, 'Direktorat Promosi Kesehatan dan Pemberdayaan Masyarakat', NULL, NULL),
(14, 5, 'Direktorat Pelayanan Kesehatan Primer', NULL, NULL),
(15, 5, 'Direktorat Pelayanan Kesehatan Rujukan', NULL, NULL),
(16, 5, 'Direktorat Pelayanan Kesehatan Tradisional', NULL, NULL),
(17, 5, 'Direktorat Fasilitas Pelayanan Kesehatan', NULL, NULL),
(18, 5, 'Direktorat Mutu dan Akreditasi Pelayanan Kesehatan', NULL, NULL),
(20, 2, 'Sekretaris Inspektorat Jenderal (Sesitjen)', NULL, NULL),
(21, 3, 'Direktorat Kesehatan Jiwa', NULL, NULL),
(22, 1, 'Pusat Krisis Kesehatan', NULL, NULL),
(24, 10, 'Balai Pengamanan Fasilitas Kesehatan (BPFK)', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `workunit_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nip` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `password_text` text NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `workunit_id`, `full_name`, `email`, `nip`, `password`, `password_text`, `status_id`, `created_at`) VALUES
(1, 1, 1, 'Admin Master', NULL, 'adminmaster', '$2y$10$oDbT9QUsWgxJUL5fIfD5eueBOS5YWMcUWYEJRHJIOR5/NK4NSJsf2', '123123123', 1, '2021-10-11'),
(2, 4, 1, 'Nurhuda', NULL, 'admin_gudang', '$2y$10$Q5OktyiFlAJKviO1Rz8xyu4jzYz8IhoAbFJNejMGD67.1GTqL20DG', '12345678', 1, '2022-03-02'),
(3, 3, 1, 'Biro Umum', NULL, 'admin_roum', '$2y$10$Ovwgm7uQqYn4eSnidA6/KuSCxz3j2ReasiR6fCK8vj1q5gLD68.Fm', '12345678', 1, '2022-03-02'),
(7, 3, 5, 'nadhifa', 'tes', 'adum_hukor', '$2y$10$4JDGv.dvIJYWg/3GetKKaeYEKvqGNrk702uGH6zSlBNEfTUTIq.U2', '12345678', 1, '0000-00-00'),
(8, 2, NULL, 'Wahyu Sapto P', NULL, '8', '$2y$10$TDSTtM74f1k9lWGWC4U6fup3jKJ9zlOurvVsAzrfzEJ.Gp.4VTte2', '123123123', 1, '2022-08-23'),
(9, 3, 11, 'dirkesor', NULL, 'adum_dirkesor', '$2y$10$u.rSsUmrKtMSysazldgjIuqZEuiJnmiUWJgPz60ne83gT5oT/fOQq', '123123123', 1, '2022-08-24'),
(10, 2, 1, 'bu anggi', NULL, 'ketua_tiker', '$2y$10$58fpaCyl5WFLY.km94K4O.vAa4Dc66vbMiHvCSYDXXUvKgkvcbpDi', '12345678', 1, '2022-08-29'),
(11, 3, 21, 'adum_dirkeswa', NULL, 'adum_dirkeswa', '$2y$10$VLZ0yk/uqmUASXz3pCvVQeThOhgmoulmMtslBWWYUu8uPo8Go78A6', '12345678', 1, '2022-09-15'),
(12, 3, 22, 'Adum Pusat Krisis', NULL, 'adum_puskris', '$2y$10$y.9C7iokwcVHJPNQ0YHwzOWq6kLoWopurUcL/ZfjbXLk.OeRCVtwi', '12345678', 1, '2022-09-21'),
(13, 3, 24, 'bpfk_gudang_pn', NULL, 'bpfk_jakarta', '$2y$10$3/Zyq3mkAtFyI8AZkTeMROLK4nfb5Ee1nX6xH7WleOTfs7Obt.zl6', '12345678', 1, '2022-09-21'),
(14, 3, 17, 'admin_fasyankes', NULL, 'admin_fasyankes', '$2y$10$jr.2JcNgzmdfH2AHZlOba.n4EYGPKFghMkAeSMip04rIk1bEKBNT6', '12345678', 1, '2022-09-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_appletters`
--
ALTER TABLE `tbl_appletters`
  ADD PRIMARY KEY (`id_app_letter`),
  ADD KEY `workunit_id` (`workunit_id`);

--
-- Indexes for table `tbl_appletters_entry`
--
ALTER TABLE `tbl_appletters_entry`
  ADD PRIMARY KEY (`id_appletter_entry`),
  ADD KEY `item_category_id` (`item_category_id`),
  ADD KEY `appletter_id` (`appletter_id`),
  ADD KEY `item_condition_id` (`item_condition_id`);

--
-- Indexes for table `tbl_appletters_exit`
--
ALTER TABLE `tbl_appletters_exit`
  ADD PRIMARY KEY (`id_appletter_exit`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `appletter_id` (`appletter_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `tbl_historys`
--
ALTER TABLE `tbl_historys`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `order_data_id` (`order_id`),
  ADD KEY `item_category_id` (`item_category_id`),
  ADD KEY `item_condition` (`item_condition_id`),
  ADD KEY `item_status_id` (`item_status_id`);

--
-- Indexes for table `tbl_items_category`
--
ALTER TABLE `tbl_items_category`
  ADD PRIMARY KEY (`id_item_category`);

--
-- Indexes for table `tbl_items_condition`
--
ALTER TABLE `tbl_items_condition`
  ADD PRIMARY KEY (`id_item_condition`);

--
-- Indexes for table `tbl_items_screening`
--
ALTER TABLE `tbl_items_screening`
  ADD PRIMARY KEY (`id_item_screening`),
  ADD KEY `warrent_id` (`warrent_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tbl_items_status`
--
ALTER TABLE `tbl_items_status`
  ADD PRIMARY KEY (`id_item_status`);

--
-- Indexes for table `tbl_mainunits`
--
ALTER TABLE `tbl_mainunits`
  ADD PRIMARY KEY (`id_mainunit`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `adminuser_id` (`adminuser_id`),
  ADD KEY `workunit_id` (`workunit_id`);

--
-- Indexes for table `tbl_orders_data`
--
ALTER TABLE `tbl_orders_data`
  ADD PRIMARY KEY (`id_order_data`),
  ADD KEY `slot_id` (`slot_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `tbl_rack_details`
--
ALTER TABLE `tbl_rack_details`
  ADD PRIMARY KEY (`id_slot_rack`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `id_slot_rack` (`id_slot_rack`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `tbl_slots`
--
ALTER TABLE `tbl_slots`
  ADD PRIMARY KEY (`id_slot`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `id_slot` (`id_slot`),
  ADD KEY `id_slot_2` (`id_slot`);

--
-- Indexes for table `tbl_slots_names`
--
ALTER TABLE `tbl_slots_names`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pallet_id` (`pallet_id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `tbl_warehouses`
--
ALTER TABLE `tbl_warehouses`
  ADD PRIMARY KEY (`id_warehouse`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `tbl_warrents`
--
ALTER TABLE `tbl_warrents`
  ADD PRIMARY KEY (`id_warrent`),
  ADD KEY `workunit_id` (`workunit_id`),
  ADD KEY `appletter_id` (`appletter_id`);

--
-- Indexes for table `tbl_warrents_entry`
--
ALTER TABLE `tbl_warrents_entry`
  ADD PRIMARY KEY (`id_warr_entry`),
  ADD KEY `item_condition_id` (`item_condition_id`),
  ADD KEY `warrent_id` (`warrent_id`),
  ADD KEY `item_category_id` (`item_category_id`);

--
-- Indexes for table `tbl_warrents_exit`
--
ALTER TABLE `tbl_warrents_exit`
  ADD PRIMARY KEY (`id_warr_exit`),
  ADD KEY `warrent_id` (`warrent_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `tbl_workunits`
--
ALTER TABLE `tbl_workunits`
  ADD PRIMARY KEY (`id_workunit`),
  ADD KEY `mainunit_id` (`mainunit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `workunit_id` (`workunit_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_items_category`
--
ALTER TABLE `tbl_items_category`
  MODIFY `id_item_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_items_condition`
--
ALTER TABLE `tbl_items_condition`
  MODIFY `id_item_condition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_items_status`
--
ALTER TABLE `tbl_items_status`
  MODIFY `id_item_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mainunits`
--
ALTER TABLE `tbl_mainunits`
  MODIFY `id_mainunit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_slots_names`
--
ALTER TABLE `tbl_slots_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_workunits`
--
ALTER TABLE `tbl_workunits`
  MODIFY `id_workunit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `tbl_orders_ibfk_1` FOREIGN KEY (`workunit_id`) REFERENCES `tbl_workunits` (`id_workunit`);

--
-- Constraints for table `tbl_orders_data`
--
ALTER TABLE `tbl_orders_data`
  ADD CONSTRAINT `tbl_orders_data_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `tbl_slots` (`id_slot`);

--
-- Constraints for table `tbl_rack_details`
--
ALTER TABLE `tbl_rack_details`
  ADD CONSTRAINT `tbl_rack_details_ibfk_1` FOREIGN KEY (`id_slot_rack`) REFERENCES `tbl_slots` (`id_slot`);

--
-- Constraints for table `tbl_slots`
--
ALTER TABLE `tbl_slots`
  ADD CONSTRAINT `tbl_slots_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouses` (`id_warehouse`);

--
-- Constraints for table `tbl_slots_names`
--
ALTER TABLE `tbl_slots_names`
  ADD CONSTRAINT `tbl_slots_names_ibfk_1` FOREIGN KEY (`pallet_id`) REFERENCES `tbl_slots` (`id_slot`);

--
-- Constraints for table `tbl_warrents`
--
ALTER TABLE `tbl_warrents`
  ADD CONSTRAINT `tbl_warrents_ibfk_1` FOREIGN KEY (`workunit_id`) REFERENCES `tbl_workunits` (`id_workunit`);

--
-- Constraints for table `tbl_workunits`
--
ALTER TABLE `tbl_workunits`
  ADD CONSTRAINT `tbl_workunits_ibfk_1` FOREIGN KEY (`mainunit_id`) REFERENCES `tbl_mainunits` (`id_mainunit`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `tbl_status` (`id_status`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id_role`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`workunit_id`) REFERENCES `tbl_workunits` (`id_workunit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
