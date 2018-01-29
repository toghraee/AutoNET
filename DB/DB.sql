-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: uaeu
-- ------------------------------------------------------
-- Server version	5.7.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asset`
--

DROP TABLE IF EXISTS `asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset` (
  `name` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `SRNO` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `delivered_date` date DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asset_out`
--

DROP TABLE IF EXISTS `asset_out`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_out` (
  `name` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `SRNO` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `delivered_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `av_room_boq`
--

DROP TABLE IF EXISTS `av_room_boq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `av_room_boq` (
  `type_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `av_room_types`
--

DROP TABLE IF EXISTS `av_room_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `av_room_types` (
  `name` varchar(255) DEFAULT NULL,
  `type_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `av_rooms`
--

DROP TABLE IF EXISTS `av_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `av_rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `bld_oldname` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `old_name` varchar(255) DEFAULT NULL,
  `new_name` varchar(255) DEFAULT NULL,
  `type_id` varchar(255) DEFAULT NULL,
  `installed` varchar(255) DEFAULT 'NO',
  PRIMARY KEY (`room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=617 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bld_ip`
--

DROP TABLE IF EXISTS `bld_ip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bld_ip` (
  `bld` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bld_map`
--

DROP TABLE IF EXISTS `bld_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bld_map` (
  `bld_old` varchar(255) DEFAULT NULL,
  `bld_new` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftr`
--

DROP TABLE IF EXISTS `ftr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftr` (
  `ftr_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_type` varchar(255) DEFAULT NULL,
  `old_name` varchar(255) DEFAULT NULL,
  `new_name` varchar(255) DEFAULT NULL,
  `bld_oldname` varchar(255) DEFAULT NULL,
  `bld_newname` varchar(255) DEFAULT NULL,
  `floor` varchar(255) DEFAULT NULL,
  `passive_ports` int(10) DEFAULT NULL,
  `asbuilt_passive_ports` int(10) DEFAULT NULL,
  `active_ports` int(10) DEFAULT NULL,
  `48p` int(10) DEFAULT NULL,
  `24p` int(10) DEFAULT NULL,
  `2x10g` int(10) DEFAULT NULL,
  `10g` int(10) DEFAULT NULL,
  `1g` int(10) DEFAULT NULL,
  `psu` int(10) DEFAULT NULL,
  `analyzer168p` int(10) DEFAULT NULL,
  `analyzer336p` int(10) DEFAULT NULL,
  `sfpmm` int(10) DEFAULT NULL,
  `sfpsm` int(10) DEFAULT NULL,
  `xfpmm` int(10) DEFAULT NULL,
  `xfpsm` int(10) DEFAULT NULL,
  `configured` varchar(255) DEFAULT NULL,
  `installed` varchar(255) DEFAULT NULL,
  `ups_type` varchar(255) DEFAULT NULL,
  `ups_qty` int(10) DEFAULT NULL,
  `battery_type` varchar(255) DEFAULT NULL,
  `battery_qty` int(10) DEFAULT NULL,
  `racks_avail` int(10) DEFAULT NULL,
  `required_rackunits` int(10) DEFAULT NULL,
  `fiber1` bit(1) DEFAULT NULL,
  `fiber2` bit(1) DEFAULT NULL,
  `rack1_pp` int(11) DEFAULT NULL,
  `rack2_pp` int(11) DEFAULT NULL,
  `48p_pwr` int(11) DEFAULT NULL,
  `24p_pwr` int(11) DEFAULT NULL,
  `pwr` int(11) DEFAULT NULL,
  `lo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ftr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=255 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `infopoint`
--

DROP TABLE IF EXISTS `infopoint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `infopoint` (
  `bld` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `IP` varchar(255) DEFAULT NULL,
  `FTR` varchar(255) DEFAULT NULL,
  `IP2` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `installed`
--

DROP TABLE IF EXISTS `installed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `installed` (
  `room_type` varchar(255) DEFAULT NULL,
  `room_id` int(10) DEFAULT NULL,
  `partno` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `srno` varchar(255) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `installed_date` datetime DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `configured_by` varchar(255) DEFAULT NULL,
  `uits_srno` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mtr`
--

DROP TABLE IF EXISTS `mtr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtr` (
  `mtr_id` int(11) NOT NULL AUTO_INCREMENT,
  `bld_newname` varchar(255) DEFAULT NULL,
  `bld_oldname` varchar(255) DEFAULT NULL,
  `lo` varchar(255) DEFAULT NULL,
  `pwr` int(10) DEFAULT NULL,
  `old_name` varchar(255) DEFAULT NULL,
  `new_name` varchar(255) DEFAULT NULL,
  `sw_fcx` int(10) DEFAULT NULL,
  `sw_fcx_2x10g` int(10) DEFAULT NULL,
  `sw_superx` int(10) DEFAULT NULL,
  `sw_sx1600` int(10) DEFAULT NULL,
  `sw_sx1600_2x10g` int(10) DEFAULT NULL,
  `sw_mod_24p_sfp` int(10) DEFAULT NULL,
  `sw_mod_2x10g` int(10) DEFAULT NULL,
  `sfpmm` int(10) DEFAULT NULL,
  `sfpsm` int(10) DEFAULT NULL,
  `xfpmm` int(10) DEFAULT NULL,
  `xfpsm` int(10) DEFAULT NULL,
  `analyzer168p` int(10) DEFAULT NULL,
  `analyzer336p` int(10) DEFAULT NULL,
  `ups_type` varchar(255) DEFAULT NULL,
  `ups_qty` int(10) DEFAULT NULL,
  `battery_type` varchar(255) DEFAULT NULL,
  `battery_qty` int(10) DEFAULT NULL,
  `racks_avail` int(10) DEFAULT NULL,
  `racks_req` int(10) DEFAULT NULL,
  `installed` varchar(255) DEFAULT 'NO',
  `fiber_sm_avail` varchar(255) DEFAULT NULL,
  `fiber_mm_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mtr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passive_uits`
--

DROP TABLE IF EXISTS `passive_uits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passive_uits` (
  `bld` varchar(255) DEFAULT NULL,
  `ftr` varchar(255) DEFAULT NULL,
  `room_id` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `priority` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passive_viz`
--

DROP TABLE IF EXISTS `passive_viz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passive_viz` (
  `bld` varchar(255) DEFAULT NULL,
  `ftr` varchar(255) DEFAULT NULL,
  `room_id` varchar(255) DEFAULT NULL,
  `room_type` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `portmapping`
--

DROP TABLE IF EXISTS `portmapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portmapping` (
  `src_type` varchar(255) DEFAULT NULL,
  `src_bld` varchar(255) DEFAULT NULL,
  `src_roomID` int(10) DEFAULT NULL,
  `src_switch` varchar(255) DEFAULT NULL,
  `src_slot` int(10) DEFAULT NULL,
  `src_port` int(10) DEFAULT NULL,
  `src_ip` varchar(255) DEFAULT NULL,
  `dst_type` varchar(255) DEFAULT NULL,
  `dst_bld` varchar(255) DEFAULT NULL,
  `dst_roomID` int(10) DEFAULT NULL,
  `dst_switch` varchar(255) DEFAULT NULL,
  `dst_slot` int(10) DEFAULT NULL,
  `dst_port` int(10) DEFAULT NULL,
  `dst_ip` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projectors`
--

DROP TABLE IF EXISTS `projectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projectors` (
  `ip` varchar(255) DEFAULT NULL,
  `bld` varchar(255) DEFAULT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `projector_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rack_components`
--

DROP TABLE IF EXISTS `rack_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rack_components` (
  `units` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `room_type` varchar(255) DEFAULT NULL,
  `room_id` int(10) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `report` text,
  `person` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room_boq`
--

DROP TABLE IF EXISTS `room_boq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_boq` (
  `id` int(10) DEFAULT NULL,
  `room_type` varchar(255) DEFAULT NULL,
  `partno` varchar(255) DEFAULT NULL,
  `srno` varchar(255) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room_ftr`
--

DROP TABLE IF EXISTS `room_ftr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_ftr` (
  `bld` varchar(255) DEFAULT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `ftr` varchar(255) DEFAULT NULL,
  `new_bld` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room_ip`
--

DROP TABLE IF EXISTS `room_ip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_ip` (
  `room_type` varchar(255) DEFAULT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `mpa_102A` int(10) DEFAULT NULL,
  `mpa_402V` int(11) DEFAULT NULL,
  `FTR` varchar(255) DEFAULT NULL,
  `bld` varchar(255) DEFAULT NULL,
  `ip_subnet` varchar(255) DEFAULT NULL,
  `required_ip` int(10) DEFAULT NULL,
  `IP1` varchar(255) DEFAULT NULL,
  `IP2` varchar(255) DEFAULT NULL,
  `IP3` varchar(255) DEFAULT NULL,
  `IP4` varchar(255) DEFAULT NULL,
  `IP5` varchar(255) DEFAULT NULL,
  `gw` varchar(255) DEFAULT NULL,
  `subnetmask` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room_ip_allocation`
--

DROP TABLE IF EXISTS `room_ip_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_ip_allocation` (
  `room_type` varchar(255) DEFAULT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `FTR` varchar(255) DEFAULT NULL,
  `bld` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room_reports`
--

DROP TABLE IF EXISTS `room_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_reports` (
  `room_type` varchar(255) DEFAULT NULL,
  `room_id` int(255) DEFAULT NULL,
  `report_date` datetime DEFAULT NULL,
  `report` mediumint(9) DEFAULT NULL,
  `incharge` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `new_name` varchar(255) DEFAULT NULL,
  `old_name` varchar(255) DEFAULT NULL,
  `bld` varchar(255) DEFAULT NULL,
  `flr` varchar(255) DEFAULT NULL,
  `typ` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wireless_ap`
--

DROP TABLE IF EXISTS `wireless_ap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wireless_ap` (
  `bld` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `faceplate` varchar(255) DEFAULT NULL,
  `internal_id` varchar(255) DEFAULT NULL,
  `ap_mac` varchar(255) DEFAULT NULL,
  `ap_serial` varchar(255) DEFAULT NULL,
  `ap_name` varchar(255) DEFAULT NULL,
  `ap_model` varchar(255) DEFAULT NULL,
  `installed_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wireless_ftr`
--

DROP TABLE IF EXISTS `wireless_ftr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wireless_ftr` (
  `bld` varchar(255) DEFAULT NULL,
  `ftr` varchar(255) DEFAULT NULL,
  `ap` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wireless_plan`
--

DROP TABLE IF EXISTS `wireless_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wireless_plan` (
  `bld` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `aps` int(10) DEFAULT NULL,
  `map_file` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-29 23:55:51
