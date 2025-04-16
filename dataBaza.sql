-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: job
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id_com` int(11) NOT NULL AUTO_INCREMENT,
  `name_com` varchar(30) NOT NULL,
  `boss_com` varchar(30) NOT NULL,
  `description_com` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_com`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timetable`
--

DROP TABLE IF EXISTS `timetable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timetable` (
  `time` date NOT NULL,
  `username` varchar(30) NOT NULL,
  `firm` varchar(30) NOT NULL,
  `start` time DEFAULT NULL,
  `stop` time DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=497 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timetable`
--

LOCK TABLES `timetable` WRITE;
/*!40000 ALTER TABLE `timetable` DISABLE KEYS */;
/*!40000 ALTER TABLE `timetable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL,
  `username` varchar(30) NOT NULL,
  `firm` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  CONSTRAINT `CONSTRAINT_1` CHECK (`status` in ('W','B'))
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (32,'Ziga','Pirc','$2y$10$psrOXZja1OFQY14Iv.ghKuHLlb//jbSkJ0T4V3xTwqzDlA5nSDIBK','B','Ziga123',NULL),(33,'Ziga','Pirc','$2y$10$gsPXqfs3G5ML2IHXElh3KexdnvJejQmVJUa/mjdyGS8DfA/HsVp3u','B','Ziga12456',NULL),(34,'Ziga','Pirc','$2y$10$.KqHGz9PvxYN0j7wrcYXRe9m1PjY6IWzKSacQL2i8LwfKdzVLZJ7u','W','Ziga1234',NULL),(35,'Ziga','Pirc','$2y$10$ABZ96LIHpnzWDiF7Xr2Gu.p2A1ntlshCkp7t2x1eSKoYSr3RG1v8u','W','Ziga1235',NULL),(36,'Ziga','Pirc','$2y$10$k9qQFjhOqMz5fsNbibjR4eXaaDDv/i0w6l5jg0vtznC9r7l4aPPke','W','Ziga123435 ',NULL),(37,'Ziga','Pirc','$2y$10$eyzm9apxEk9v/APnW2/9YuLYmo8H/Nurv30BBHdRrGiJczMuPL80O','W','342324',NULL),(38,'Ziga','Pirc','$2y$10$3KcnnaSiCGVF70kL4SUib.A.Nf9wVwBHQnHjUydOYNhTptKZpCH/O','W','Ziga1233',NULL),(39,'Ziga','Pirc','$2y$10$TKo2AANKlFW4oI9dO4pFGepA8Y6OeLt2FRN5CaWFVJYFiN7CpdIRe','W','Ziga12387',NULL),(40,'Ziga','Pirc','$2y$10$Av.Po/mYJgOtS4LCc0Oo8e6VGY8GlSnXZjaZhPTpG5xoKph/2iGEq','W','Ziga123456',NULL),(41,'Ziga','Pirc','$2y$10$hw.nxUZAO124GawFp6cayOMELRj1CWegaXBo7e7Ko6nfbg.Q51vBe','W','Ziga123345',NULL),(42,'Ziga','Pirc','$2y$10$uffh8gg.TJqvbijYXXDbieCfxfa6cr86GLchJfkhh3FfKPv2Ed3QC','W','Ziga123576',NULL),(43,'kliop','pio','$2y$10$t4GksygSVrz.rXmfnfTQG.Xkj0LJJEdOvEmRcN4XiScjTd7.phrWS','W','uio',NULL),(44,'Ziga','Pirc','$2y$10$uccWWYjK0PtqMAp2fxFUlubzWJIJ6Ew7KVxPdicrK9okWQ59lpyGq','W','Ziga123465',NULL),(45,'Ziga','Pirc','$2y$10$SZpbr/hpEtq/P9Vcp1Y6.Oall79p3/SOY4kN3IUO8AMwDTvPcC7PG','W','Ziga1233546',NULL),(46,'Ziga','Pirc','$2y$10$8qvH3lL0WP6mQGOMwjuMJuZqNVmRcvBn4cVFYu9hGLhjS..MmAyae','W','Ziga123563564',NULL),(47,'Ziga','Pirc','$2y$10$jFr1JConjBYNtDEjdrp20uyEmHKsCZxOrWVVKK1s.sOH5B46UliCe','W','12343425',NULL),(48,'Ziga','Pirc','$2y$10$JwJYgySpLkrFJVxuxC0AMe5nWsK7QE9Vs7b5lH0nqTGhnIqu1OYKe','W','Grega123',NULL),(49,'Tne','Novak','$2y$10$.lyGtESczTKCKLOo8VYZUuPG3aEeFLDgdvB9pH2B4TDwaP4MUaCAG','W','Tine1',NULL),(50,'Komponentko','Pirc','$2y$10$GO/qA8irFfiIhF8utdO2Uek0F/DPy.u7xwgV3Tq4MC0sfnyhFMI2m','W','Novak12',NULL),(51,'Komponentko','pio','$2y$10$71W6Y9bb3gz5j6il.uKEOuEBlMrim4zl2FspGKhqqe7EGvjPPjHle','W','Gregaaa',NULL),(52,'wererw','teyrgetyrthye','$2y$10$gIRkmiaPoFgwkelEG2HLzO7QwKIzZ2aLX8e0typoM9IxSmgHksmqC','B','Gregaaaa',NULL),(53,'gfhrtfhgthfg','fhgfhgfhg','$2y$10$aLFhcjTjYtjW18Zlpf4gMu3jACrlVyCfoTrJETRUVHJsOHJxiMX/m','B','Gregaaaaa',NULL),(54,'Komponentko','etretr','$2y$10$ptjOpLMY1j66nZg3C8ZcLOJpX89FH9ngyB0uD/sTr6DCXhG9X/FKe','W','Grega123ytre',NULL),(55,'ertyetry','etryerty','$2y$10$uInaplcCrfayiOzUkLZnL.pi7uGI8BvSC8TZLLm9kbuZU95cTybVK','B','Matej',NULL),(56,'iou','oui','$2y$10$JBTGdC8Q4jDKIAFMCpQAiel6NletaK1Ek4Hod49yTP.npvvsEErwm','W','Tine223',NULL),(57,'Ziga','Pirc','$2y$10$KJ4uvz68rYFcOSx3n4R5fuZ.LrQSmBHNA2RqG0ZHfRFiyLkP1DOKi','W','Ziga12345',NULL),(58,'Komponentko','uytiuyit','$2y$10$hVCNXI0s74LFfn5Ac33yF.5FakC8tEN2MuxLigPIRRnEjaL0xeY9y','B','Alo123',NULL),(59,'Ziga','Pirc','$2y$10$/JxvxyPgaM2WRSDtA3.JQ.yCMI2qCJ1iJYVv494Xh8hTi7eEoqGou','B','Tine2233',NULL),(60,'ukjhykuyjh','uiykyui','$2y$10$hV7OSB1LKxGusC8YD/.28O1BTcLgfVMgIBd28R8EV6Kn1jT56YyM6','W','uyiiuy',NULL),(61,'Komponentko','431','$2y$10$jFRjSSZrodAJqmJ6a.zqreHYCRjCd6t9wJ7KW0/nzJ6pJYNQ4ZwRi','W','123',NULL),(62,'Dolenc','Pirc','$2y$10$BZ4QJ6eTFPAjvgCX/Z87E.4iZ15bgAx/0xgXuvL76ZacuIINovL1m','W','Rok',NULL),(63,'Twitch','123','$2y$10$uivjZlxQWwjYr3KsJF2E3uru5Vumu1bYihD84BJiitz7/mGXjbiTa','W','A',NULL),(64,'Komponentko','123','$2y$10$SW6JNyzkMCVluM6BTB9u7ucse9mKGqqTPoOtU46qy0u.PBDeJhyEi','W','1234',NULL),(65,'5243','423','$2y$10$cHPbgW.fOUA0suP7wljRk.IHGlecC3C4YiFVnHTAY9eGe7opwrd3e','W','Ab',NULL),(66,'Komponentko','132','$2y$10$mJEsLvJ7AZwOnS7VNuWHhem35TO.DDKZOo5ycnxYun8MPmTOOIlzm','W','12345',NULL),(67,'253','2534','$2y$10$3RVfEiLQ.8wInbgZzQovf.damU5XYOsY15FH2.OpCxt9J9e6PhA1m','W','132354',NULL),(68,'143','234','$2y$10$gr8xACEappZPYp5WKeERGu/Cenm5CtNYFApZkUkKMShCqltEUQ0B6','W','234',NULL),(69,'134213','24343','$2y$10$VCqjL6lbTneCTXPofeRcZuRjZ9Fpoe8UkDFh2UoMDo.AN99YY6E4O','B','2432',NULL),(70,'Komponentko','123','$2y$10$bv7XxZJWe/TnqbcFikC7SOTlK7b9m4Al2xcLcE634.6NhbfrDG3j6','B','123456',NULL),(71,'Tine','Novak','$2y$10$Eyf2JrsoyJKnXMzdapPOu.J832rfmHqNo1NhIa7RdLm340IBtlrp2','W','TineN123',NULL),(72,'1432','4324','$2y$10$xtTUUVR9vwR.WyMwM4MpQu9rqgjC0P37SoZR8V7re8hORsv.uGR0O','W','432',NULL),(73,'IT','123','$2y$10$4PGSBf4kb2xnDMnwL2GETeg34hcDA1IWtErmzahMEXkuX.FzC9Etm','W','1234567',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-17  0:44:26
