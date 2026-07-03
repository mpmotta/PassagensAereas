/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for osx10.20 (arm64)
--
-- Host: localhost    Database: senactur
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `agendamentos`
--

DROP TABLE IF EXISTS `agendamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voo_ida_id` int(11) NOT NULL,
  `voo_volta_id` int(11) DEFAULT NULL,
  `qtd_adultos` int(11) NOT NULL,
  `qtd_criancas` int(11) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `status` enum('Confirmada','Cancelada') DEFAULT 'Confirmada',
  PRIMARY KEY (`id`),
  KEY `voo_ida_id` (`voo_ida_id`),
  KEY `voo_volta_id` (`voo_volta_id`),
  CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`voo_ida_id`) REFERENCES `voos` (`id`),
  CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`voo_volta_id`) REFERENCES `voos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendamentos`
--

LOCK TABLES `agendamentos` WRITE;
/*!40000 ALTER TABLE `agendamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `agendamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locais`
--

DROP TABLE IF EXISTS `locais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `locais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `tipo` enum('Capital','Turismo') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locais`
--

LOCK TABLES `locais` WRITE;
/*!40000 ALTER TABLE `locais` DISABLE KEYS */;
INSERT INTO `locais` VALUES
(1,'Aracaju','Brasil','Capital'),
(2,'Belém','Brasil','Capital'),
(3,'Belo Horizonte','Brasil','Capital'),
(4,'Boa Vista','Brasil','Capital'),
(5,'Brasília','Brasil','Capital'),
(6,'Campo Grande','Brasil','Capital'),
(7,'Cuiabá','Brasil','Capital'),
(8,'Curitiba','Bra(il','Capital'),
(9,'Florianópolis','Brasil','Capital'),
(10,'Fortaleza','Brasil','Capital'),
(11,'Goiânia','Brasil','Capital'),
(12,'João Pessoa','Brasil','Capital'),
(13,'Macapá','Brasil','Capital'),
(14,'Maceió','Brasil','Capital'),
(15,'Manaus','Brasil','Capital'),
(16,'Natal','Brasil','Capital'),
(17,'Palmas','Brasil','Capital'),
(18,'Porto Alegre','Brasil','Capital'),
(19,'Porto Velho','Brasil','Capital'),
(20,'Recife','Brasil','Capital'),
(21,'Rio Branco','Brasil','Capital'),
(22,'Rio de Janeiro','Brasil','Capital'),
(23,'Salvador','Brasil','Capital'),
(24,'São Luís','Brasil','Capital'),
(25,'São Paulo','Brasil','Capital'),
(26,'Teresina','Brasil','Capital'),
(27,'Vitória','Brasil','Capital'),
(28,'Buenos Aires','Argentina','Turismo'),
(29,'Santiago','Chile','Turismo'),
(30,'Lima','Peru','Turismo'),
(31,'Bogotá','Colômbia','Turismo'),
(32,'Orlando','EUA','Turismo'),
(33,'Nova York','EUA','Turismo'),
(34,'Cancún','México','Turismo'),
(35,'Cidade do Panamá','Panamá','Turismo');
/*!40000 ALTER TABLE `locais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voos`
--

DROP TABLE IF EXISTS `voos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `voos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origem_id` int(11) NOT NULL,
  `destino_id` int(11) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
  `data_voo` date NOT NULL,
  `horario` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `origem_id` (`origem_id`),
  KEY `destino_id` (`destino_id`),
  CONSTRAINT `voos_ibfk_1` FOREIGN KEY (`origem_id`) REFERENCES `locais` (`id`),
  CONSTRAINT `voos_ibfk_2` FOREIGN KEY (`destino_id`) REFERENCES `locais` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voos`
--

LOCK TABLES `voos` WRITE;
/*!40000 ALTER TABLE `voos` DISABLE KEYS */;
/*!40000 ALTER TABLE `voos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-07-02 22:34:46
