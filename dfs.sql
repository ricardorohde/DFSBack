CREATE DATABASE  IF NOT EXISTS `jnt_dfs` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `jnt_dfs`;
-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: jnt_dfs
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `tta_arquivos`
--

DROP TABLE IF EXISTS `tta_arquivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_arquivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arquivo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `produtos` text COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_arquivos`
--

LOCK TABLES `tta_arquivos` WRITE;
/*!40000 ALTER TABLE `tta_arquivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_arquivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_arquivos_categorias`
--

DROP TABLE IF EXISTS `tta_arquivos_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_arquivos_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_arquivos_categorias`
--

LOCK TABLES `tta_arquivos_categorias` WRITE;
/*!40000 ALTER TABLE `tta_arquivos_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_arquivos_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_banners`
--

DROP TABLE IF EXISTS `tta_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datainicio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `datafim` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `clicks` int(11) NOT NULL,
  `enderecourl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ativo` int(11) NOT NULL,
  `tipo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `largura` decimal(6,2) NOT NULL,
  `altura` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_banners`
--

LOCK TABLES `tta_banners` WRITE;
/*!40000 ALTER TABLE `tta_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_banners_categorias`
--

DROP TABLE IF EXISTS `tta_banners_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_banners_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `largura` decimal(6,2) NOT NULL,
  `altura` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_banners_categorias`
--

LOCK TABLES `tta_banners_categorias` WRITE;
/*!40000 ALTER TABLE `tta_banners_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_banners_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_cidade`
--

DROP TABLE IF EXISTS `tta_cidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddd` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_cidade`
--

LOCK TABLES `tta_cidade` WRITE;
/*!40000 ALTER TABLE `tta_cidade` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_cidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_enderecos`
--

DROP TABLE IF EXISTS `tta_enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ligacao` int(11) DEFAULT NULL,
  `logradouro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bairro` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cidade` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pais` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_enderecos`
--

LOCK TABLES `tta_enderecos` WRITE;
/*!40000 ALTER TABLE `tta_enderecos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_estado`
--

DROP TABLE IF EXISTS `tta_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uf` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_estado`
--

LOCK TABLES `tta_estado` WRITE;
/*!40000 ALTER TABLE `tta_estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_eventos`
--

DROP TABLE IF EXISTS `tta_eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `data` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_eventos`
--

LOCK TABLES `tta_eventos` WRITE;
/*!40000 ALTER TABLE `tta_eventos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_frete`
--

DROP TABLE IF EXISTS `tta_frete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_frete` (
  `ceporigem` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ativocorreio` tinyint(1) NOT NULL,
  `logincorreio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `senhacorreio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fretegratis` tinyint(1) NOT NULL,
  `apartirvalorfretegratis` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_frete`
--

LOCK TABLES `tta_frete` WRITE;
/*!40000 ALTER TABLE `tta_frete` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_frete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_galerias`
--

DROP TABLE IF EXISTS `tta_galerias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_galerias`
--

LOCK TABLES `tta_galerias` WRITE;
/*!40000 ALTER TABLE `tta_galerias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_galerias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_galerias_categorias`
--

DROP TABLE IF EXISTS `tta_galerias_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_galerias_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `largura` decimal(6,2) NOT NULL,
  `altura` decimal(6,2) NOT NULL,
  `larguram` decimal(6,2) NOT NULL,
  `alturam` decimal(6,2) NOT NULL,
  `largurap` decimal(6,2) NOT NULL,
  `alturap` decimal(6,2) NOT NULL,
  `protegido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_galerias_categorias`
--

LOCK TABLES `tta_galerias_categorias` WRITE;
/*!40000 ALTER TABLE `tta_galerias_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_galerias_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_idiomas`
--

DROP TABLE IF EXISTS `tta_idiomas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_idiomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(10) CHARACTER SET latin1 NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 NOT NULL,
  `imagem` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_idiomas`
--

LOCK TABLES `tta_idiomas` WRITE;
/*!40000 ALTER TABLE `tta_idiomas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_idiomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_idiomas_traducoes`
--

DROP TABLE IF EXISTS `tta_idiomas_traducoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_idiomas_traducoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` int(11) NOT NULL,
  `conteudo` text COLLATE utf8_unicode_ci NOT NULL,
  `traducao` text COLLATE utf8_unicode_ci NOT NULL,
  `campoconteudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tabelaconteudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idconteudo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_idiomas_traducoes`
--

LOCK TABLES `tta_idiomas_traducoes` WRITE;
/*!40000 ALTER TABLE `tta_idiomas_traducoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_idiomas_traducoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_imagens`
--

DROP TABLE IF EXISTS `tta_imagens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idsessao` int(11) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legenda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `destaque` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_imagens`
--

LOCK TABLES `tta_imagens` WRITE;
/*!40000 ALTER TABLE `tta_imagens` DISABLE KEYS */;
INSERT INTO `tta_imagens` VALUES (25,'produtos',14,'zoom_variation_428_view_A_2192x2200.jpg','',1),(26,'produtos',14,'zoom_variation_428_view_B_2192x2200.jpg','',0),(27,'produtos',15,'zoom_variation_419_view_A_2192x2200.jpg','',1),(28,'produtos',16,'zoom_variation_101_view_A_2192x2200.jpg','',0),(29,'produtos',16,'zoom_variation_101_view_B_2192x2200.jpg','',1),(30,'produtos',17,'zoom_variation_063_view_A_2192x2200.jpg','',1),(31,'produtos',18,'Shirt-Woman-Long-sleeve-shirt-2-Button-slim-coton-printed-Off-WhiteBrown.jpg','',1),(32,'produtos',19,'51M2001117Z-0089-ALT1.jpg','',0),(33,'produtos',19,'51M2001117Z-0089-ALT2.jpg','',1);
/*!40000 ALTER TABLE `tta_imagens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_mailing`
--

DROP TABLE IF EXISTS `tta_mailing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_mailing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pacote` int(11) DEFAULT NULL,
  `texto` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `data` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_mailing`
--

LOCK TABLES `tta_mailing` WRITE;
/*!40000 ALTER TABLE `tta_mailing` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_mailing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_mailing_pacotes`
--

DROP TABLE IF EXISTS `tta_mailing_pacotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_mailing_pacotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_mailing_pacotes`
--

LOCK TABLES `tta_mailing_pacotes` WRITE;
/*!40000 ALTER TABLE `tta_mailing_pacotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_mailing_pacotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_mailing_pacotes_emails`
--

DROP TABLE IF EXISTS `tta_mailing_pacotes_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_mailing_pacotes_emails` (
  `pacote` int(11) NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cidade` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datanasc` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`pacote`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_mailing_pacotes_emails`
--

LOCK TABLES `tta_mailing_pacotes_emails` WRITE;
/*!40000 ALTER TABLE `tta_mailing_pacotes_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_mailing_pacotes_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_mailing_pacotes_envio`
--

DROP TABLE IF EXISTS `tta_mailing_pacotes_envio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_mailing_pacotes_envio` (
  `mailing` int(11) NOT NULL DEFAULT '0',
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`mailing`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_mailing_pacotes_envio`
--

LOCK TABLES `tta_mailing_pacotes_envio` WRITE;
/*!40000 ALTER TABLE `tta_mailing_pacotes_envio` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_mailing_pacotes_envio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_marcadagua`
--

DROP TABLE IF EXISTS `tta_marcadagua`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_marcadagua` (
  `posicaohorizontal` int(11) NOT NULL,
  `posicaovertical` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `produtos` tinyint(1) NOT NULL,
  `galerias` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_marcadagua`
--

LOCK TABLES `tta_marcadagua` WRITE;
/*!40000 ALTER TABLE `tta_marcadagua` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_marcadagua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_musicas`
--

DROP TABLE IF EXISTS `tta_musicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_musicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `musica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_musicas`
--

LOCK TABLES `tta_musicas` WRITE;
/*!40000 ALTER TABLE `tta_musicas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_musicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_musicas_categorias`
--

DROP TABLE IF EXISTS `tta_musicas_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_musicas_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subtitulo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravadora` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datalancamento` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capa` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_musicas_categorias`
--

LOCK TABLES `tta_musicas_categorias` WRITE;
/*!40000 ALTER TABLE `tta_musicas_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_musicas_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_noticias`
--

DROP TABLE IF EXISTS `tta_noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `data` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_noticias`
--

LOCK TABLES `tta_noticias` WRITE;
/*!40000 ALTER TABLE `tta_noticias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_noticias_categorias`
--

DROP TABLE IF EXISTS `tta_noticias_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_noticias_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_noticias_categorias`
--

LOCK TABLES `tta_noticias_categorias` WRITE;
/*!40000 ALTER TABLE `tta_noticias_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_noticias_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_ofertascoletivas`
--

DROP TABLE IF EXISTS `tta_ofertascoletivas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_ofertascoletivas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtitulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `destaques` text COLLATE utf8_unicode_ci NOT NULL,
  `regulamento` text COLLATE utf8_unicode_ci NOT NULL,
  `valororiginal` decimal(6,2) NOT NULL,
  `desconto` decimal(6,2) NOT NULL,
  `economia` decimal(6,2) NOT NULL,
  `valor` decimal(6,2) NOT NULL,
  `datainicio` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `datafim` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `comprasminima` int(11) NOT NULL,
  `comprasefetuadas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_ofertascoletivas`
--

LOCK TABLES `tta_ofertascoletivas` WRITE;
/*!40000 ALTER TABLE `tta_ofertascoletivas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_ofertascoletivas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_ofertascoletivas_empresas`
--

DROP TABLE IF EXISTS `tta_ofertascoletivas_empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_ofertascoletivas_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `tipo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailsecundario` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rg` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datanasc` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razaosocial` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnpj` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datacadastro` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_ofertascoletivas_empresas`
--

LOCK TABLES `tta_ofertascoletivas_empresas` WRITE;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_ofertascoletivas_empresas_emails`
--

DROP TABLE IF EXISTS `tta_ofertascoletivas_empresas_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_ofertascoletivas_empresas_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pessoa` int(11) NOT NULL,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `principal` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_ofertascoletivas_empresas_emails`
--

LOCK TABLES `tta_ofertascoletivas_empresas_emails` WRITE;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_ofertascoletivas_empresas_enderecos`
--

DROP TABLE IF EXISTS `tta_ofertascoletivas_empresas_enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_ofertascoletivas_empresas_enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ligacao` int(11) DEFAULT NULL,
  `logradouro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bairro` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cidade` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pais` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_ofertascoletivas_empresas_enderecos`
--

LOCK TABLES `tta_ofertascoletivas_empresas_enderecos` WRITE;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas_enderecos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas_enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_ofertascoletivas_empresas_telefones`
--

DROP TABLE IF EXISTS `tta_ofertascoletivas_empresas_telefones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_ofertascoletivas_empresas_telefones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ligacao` int(11) DEFAULT NULL,
  `local` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd` int(11) DEFAULT NULL,
  `telefone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ramal` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_ofertascoletivas_empresas_telefones`
--

LOCK TABLES `tta_ofertascoletivas_empresas_telefones` WRITE;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas_telefones` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_ofertascoletivas_empresas_telefones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_pagamentos`
--

DROP TABLE IF EXISTS `tta_pagamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_pagamentos` (
  `tiposite` tinyint(1) NOT NULL,
  `tipopedido` tinyint(1) NOT NULL,
  `tipopedidoprodutostodosite` int(11) NOT NULL,
  `ativodesconto` tinyint(1) NOT NULL,
  `codigodesconto` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `porcentagemdesconto` decimal(11,2) NOT NULL,
  `ativopagseguro` tinyint(1) NOT NULL,
  `emailpagseguro` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tokenpagseguro` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `urlretornopagseguro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fretepagseguro` tinyint(1) NOT NULL,
  `ativodeposito` tinyint(1) NOT NULL,
  `textodeposito` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_pagamentos`
--

LOCK TABLES `tta_pagamentos` WRITE;
/*!40000 ALTER TABLE `tta_pagamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_pagamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_pais`
--

DROP TABLE IF EXISTS `tta_pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddi` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_pais`
--

LOCK TABLES `tta_pais` WRITE;
/*!40000 ALTER TABLE `tta_pais` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_pedido_enderecos`
--

DROP TABLE IF EXISTS `tta_pedido_enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_pedido_enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ligacao` int(11) DEFAULT NULL,
  `logradouro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bairro` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cidade` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pais` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `valor` decimal(4,2) DEFAULT NULL,
  `prazo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_pedido_enderecos`
--

LOCK TABLES `tta_pedido_enderecos` WRITE;
/*!40000 ALTER TABLE `tta_pedido_enderecos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_pedido_enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_pedido_itens`
--

DROP TABLE IF EXISTS `tta_pedido_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_pedido_itens` (
  `id` int(11) NOT NULL DEFAULT '0',
  `idpedido` int(11) NOT NULL,
  `marca` int(11) DEFAULT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `peso` decimal(7,3) NOT NULL,
  `largura` decimal(7,2) NOT NULL,
  `altura` decimal(7,2) NOT NULL,
  `comprimento` decimal(7,2) NOT NULL,
  `valorcusto` decimal(7,2) NOT NULL,
  `valorreal` decimal(7,2) NOT NULL,
  `valorvenda` decimal(7,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  `descricaopequena` text COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `disponivel` int(11) NOT NULL,
  `promocao` int(11) NOT NULL,
  `lancamento` int(11) NOT NULL,
  `destaque` int(11) NOT NULL,
  `removido` tinyint(1) NOT NULL,
  `cor` int(11) NOT NULL,
  `pedra` int(11) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `tipounidade` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quantidadeu` int(11) NOT NULL,
  `datacadastro` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `urlvideo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `frete` int(11) NOT NULL,
  `tipopedido` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `fretevalor` decimal(20,3) NOT NULL,
  `observacao` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_pedido_itens`
--

LOCK TABLES `tta_pedido_itens` WRITE;
/*!40000 ALTER TABLE `tta_pedido_itens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_pedido_itens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_pedidos`
--

DROP TABLE IF EXISTS `tta_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessao` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `observacoes` text COLLATE utf8_unicode_ci,
  `tipopagamento` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `valor` decimal(7,2) DEFAULT NULL,
  `desconto` decimal(20,2) NOT NULL,
  `data` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `estoque` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_pedidos`
--

LOCK TABLES `tta_pedidos` WRITE;
/*!40000 ALTER TABLE `tta_pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_perguntas`
--

DROP TABLE IF EXISTS `tta_perguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_perguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL,
  `url` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_perguntas`
--

LOCK TABLES `tta_perguntas` WRITE;
/*!40000 ALTER TABLE `tta_perguntas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_perguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_perguntas_categorias`
--

DROP TABLE IF EXISTS `tta_perguntas_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_perguntas_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_perguntas_categorias`
--

LOCK TABLES `tta_perguntas_categorias` WRITE;
/*!40000 ALTER TABLE `tta_perguntas_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_perguntas_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_pessoas`
--

DROP TABLE IF EXISTS `tta_pessoas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_pessoas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sobrenome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailsecundario` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rg` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datanasc` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razaosocial` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnpj` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atacadista` int(11) NOT NULL,
  `datacadastro` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `origemcadastro` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vendedor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_pessoas`
--

LOCK TABLES `tta_pessoas` WRITE;
/*!40000 ALTER TABLE `tta_pessoas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_pessoas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_pessoas_emails`
--

DROP TABLE IF EXISTS `tta_pessoas_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_pessoas_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pessoa` int(11) NOT NULL,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `principal` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_pessoas_emails`
--

LOCK TABLES `tta_pessoas_emails` WRITE;
/*!40000 ALTER TABLE `tta_pessoas_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_pessoas_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos`
--

DROP TABLE IF EXISTS `tta_produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produtopai` int(11) NOT NULL,
  `url` int(11) NOT NULL,
  `marca` int(11) DEFAULT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `peso` decimal(7,3) NOT NULL,
  `largura` decimal(7,2) NOT NULL,
  `altura` decimal(7,2) NOT NULL,
  `comprimento` decimal(7,2) NOT NULL,
  `valorcusto` decimal(7,2) NOT NULL,
  `valorreal` decimal(7,2) NOT NULL,
  `valorvenda` decimal(7,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  `descricaopequena` text COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `especificacao` text COLLATE utf8_unicode_ci NOT NULL,
  `manual` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `palavraschaves` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disponivel` int(11) NOT NULL,
  `promocao` int(11) NOT NULL,
  `lancamento` int(11) NOT NULL,
  `destaque` int(11) NOT NULL,
  `removido` int(2) NOT NULL,
  `cor` int(11) NOT NULL,
  `pedra` int(11) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `tipounidade` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quantidade` int(11) NOT NULL,
  `datacadastro` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `urlvideo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `frete` int(11) NOT NULL,
  `tipopedido` int(11) NOT NULL,
  `view` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos`
--

LOCK TABLES `tta_produtos` WRITE;
/*!40000 ALTER TABLE `tta_produtos` DISABLE KEYS */;
INSERT INTO `tta_produtos` VALUES (14,0,28,3,'FLAT FRONT DECK SHORT','B44000',0.000,0.00,0.00,0.00,399.00,500.00,450.00,0,'<p>\r\n	Our classic shorts. Made of cotton twill with a flat-front design and a clean cut look, they&#39;re an essential pair to keep around for Saturdays and vacation days.</p>\r\n','<p>\r\n	Our classic shorts. Made of cotton twill with a flat-front design and a clean cut look, they&#39;re an essential pair to keep around for Saturdays and vacation days.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		100% Cotton</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Button and zipper closure</li>\r\n	<li>\r\n		Side pockets; buttoned back welt pockets</li>\r\n	<li>\r\n		Flat front</li>\r\n	<li>\r\n		Inseam: approx. 9-1/2 inches</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n','','','',1,0,0,0,0,0,0,0,0,'',0,'20150615','',3,0,NULL),(15,0,30,3,'CHEST STRIPE PERFORMANCE DECK POLO SHIRT','K52126',0.000,0.00,0.00,0.00,5499.00,7950.00,6950.00,0,'<p>\r\n	Our best-selling polo will keep you dry, comfortable and in style wherever your adventures may take you thanks to its innovative moisture-wicking fabric and classic fit.</p>\r\n','<p>\r\n	Our best-selling polo will keep you dry, comfortable and in style wherever your adventures may take you thanks to its innovative moisture-wicking fabric and classic fit.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		60% Cotton, 40% Polyester</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Polo collar and buttoned placket</li>\r\n	<li>\r\n		Short sleeves</li>\r\n	<li>\r\n		Moisture wicking</li>\r\n	<li>\r\n		Classic fit</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n','','','',1,0,1,0,0,0,0,0,0,'',0,'20150615','',3,0,3),(16,0,31,3,'SLIM FIT FISH PRINT DECK POLO SHIRT','K51236',0.000,0.00,0.00,0.00,499.00,695.00,0.00,0,'<p>\r\n	Throwing out a line for fish lovers. This cotton polo will be your favorite new shirt between the slim fit and colorful graphic on the back.</p>\r\n','<p>\r\n	Throwing out a line for fish lovers. This cotton polo will be your favorite new shirt between the slim fit and colorful graphic on the back.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		100% Cotton</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Polo collar and buttoned placket</li>\r\n	<li>\r\n		Short sleeves</li>\r\n	<li>\r\n		Fish print at back</li>\r\n	<li>\r\n		Slim fit</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n','','','',1,0,0,0,0,0,0,0,0,'',0,'20150615','',3,0,NULL),(17,0,32,3,'TWO POCKET POLO SHIRT','4K3903',0.000,0.00,0.00,0.00,499.00,795.00,695.00,0,'<p>\r\n	A cool new take on the polo shirt--plenty of contrasting trim to highlight the great fit.</p>\r\n','<p>\r\n	A cool new take on the polo shirt--plenty of contrasting trim to highlight the great fit.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		100% Cotton</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Polo collar and buttoned placket</li>\r\n	<li>\r\n		Short sleeves</li>\r\n	<li>\r\n		Split at sides of hem</li>\r\n	<li>\r\n		Authentic fit</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n','','','',1,0,0,0,0,0,0,0,0,'',0,'20150615','',3,0,NULL),(18,0,33,4,'SHIRT LINDA OFF WHITEBROWN','497',0.000,0.00,0.00,0.00,159.00,259.00,0.00,0,'<p>\r\n	<span style=\"color: rgb(102, 102, 102); font-family: \'Source Sans Pro\', Tahoma, sans-serif, Arial; font-size: 13.5px; line-height: 20.25px; text-align: justify;\">2 Buttons Italian Collar Slim Woman Shirt Off WhiteBrown</span></p>\r\n','<p>\r\n	<span style=\"color: rgb(102, 102, 102); font-family: \'Source Sans Pro\', Tahoma, sans-serif, Arial; font-size: 13.5px; line-height: 20.25px; text-align: justify;\">2 Buttons Italian Collar Slim Woman Shirt Off WhiteBrown</span></p>\r\n<p>\r\n	&nbsp;</p>\r\n<table class=\"table-data-sheet\" style=\"box-sizing: border-box; margin: 0px 0px 20px; padding: 0px; border-top-width: 0px; border-right-width: 0px; border-left-width: 0px; border-bottom-style: solid; border-bottom-color: rgb(229, 229, 229); font-family: \'Source Sans Pro\', Tahoma, sans-serif, Arial; font-stretch: inherit; line-height: 20.25px; font-size: 13.5px; vertical-align: baseline; border-collapse: collapse; border-spacing: 0px; max-width: 100%; width: 794px; color: rgb(102, 102, 102); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">\r\n	<tbody style=\"box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;\">\r\n		<tr class=\"odd\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Style</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				Sportwear</td>\r\n		</tr>\r\n		<tr class=\"even\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Model</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				Linda</td>\r\n		</tr>\r\n		<tr class=\"odd\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Fit</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				Slim</td>\r\n		</tr>\r\n		<tr class=\"even\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Design</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				Stampa</td>\r\n		</tr>\r\n		<tr class=\"odd\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Colour</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				Beige</td>\r\n		</tr>\r\n		<tr class=\"even\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Fabric Composition</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr class=\"odd\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Fabric</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				Cotone</td>\r\n		</tr>\r\n		<tr class=\"even\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Sleeve</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				Long sleeve shirt</td>\r\n		</tr>\r\n		<tr class=\"odd\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Collar Type</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				2 buttons italian collar</td>\r\n		</tr>\r\n		<tr class=\"even\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Collar Buttons</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				2 button</td>\r\n		</tr>\r\n		<tr class=\"odd\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;\">\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);\">\r\n				Vela</td>\r\n			<td style=\"box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;\">\r\n				1 fold</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<span style=\"color: rgb(102, 102, 102); font-family: \'Source Sans Pro\', Tahoma, sans-serif, Arial; font-size: 13.3333330154419px; line-height: 20.25px; text-align: justify; background-color: rgb(250, 250, 250);\">O Cliente ele tem o direito de rescindir o contrato de compra por qualquer raz&atilde;o, sem penaliza&ccedil;&atilde;o alguma e sem preju&iacute;zos, conforme o par&aacute;grafo 3 subsequente. Para exercer esse direito, o Cliente dever&aacute; enviar um e-mail com uma solicita&ccedil;&atilde;o de rescis&atilde;o. A Ottimo Ltda., por sua vez, enviar&aacute; um correio eletr&ocirc;nico com um formul&aacute;rio, a ser impresso pelo Cliente, que cont&eacute;m o n&uacute;mero de autoriza&ccedil;&atilde;o que dever&aacute; ser colocado no exterior da embalagem referente ao produto. Ser&aacute; enviado &agrave; Ottimo Ltda., dentro de 10 dias a partir da autoriza&ccedil;&atilde;o &agrave;: Ottimo s.r.l c/o Grandi Progetti, Via del Corso 101, 00186 Roma, Italia.</span></p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<span style=\"color: rgb(102, 102, 102); font-family: \'Source Sans Pro\', Tahoma, sans-serif, Arial; font-size: 13.3333330154419px; line-height: 20.25px; text-align: justify; background-color: rgb(250, 250, 250);\">Todos os produtos vendidos pela Ottimo Ltda. est&atilde;o cobertos pela garantia do fabricante, a partir do Decreto Legislativo n. 24/2002. Para ter direito &agrave; assist&ecirc;ncia pela garantia, o Cliente dever&aacute; guardar a nota fiscal ou o DDT, que receber&aacute; junto com os bens adquiridos. O Cliente sempre poder&aacute; baixar, por meio da p&aacute;gina&nbsp;</span><a href=\"http://www.7camicie.com/\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-family: \'Source Sans Pro\', Tahoma, sans-serif, Arial; font-stretch: inherit; line-height: 20.25px; font-size: 13.3333320617676px; vertical-align: baseline; color: rgb(68, 68, 68); text-decoration: none; -webkit-transition: color 200ms ease-in-out, background-color 300ms ease-in-out; transition: color 200ms ease-in-out, background-color 300ms ease-in-out; text-align: justify; background-color: rgb(250, 250, 250);\">www.7camicie.com</a><span style=\"color: rgb(102, 102, 102); font-family: \'Source Sans Pro\', Tahoma, sans-serif, Arial; font-size: 13.3333330154419px; line-height: 20.25px; text-align: justify; background-color: rgb(250, 250, 250);\">, as notas fiscais relativas &agrave;s suas compras, acessando o espa&ccedil;o reservado a essa a&ccedil;&atilde;o.</span></p>\r\n','','','',1,0,0,0,0,0,0,0,0,'',0,'20150615','',3,0,NULL),(19,0,34,5,'MARCIANO PYTHON PRINT BLAZER','51M2001117Z',0.000,0.00,0.00,0.00,339.00,539.00,439.00,0,'<p>\r\n	<span style=\"color: rgb(0, 0, 0); font-family: Arial; font-size: 11px; line-height: 18px;\">Two-button blazer that combines tailoring tradition with contemporary style. With a python print collar to glam up the city chic look.</span></p>\r\n','<p>\r\n	<span style=\"color: rgb(0, 0, 0); font-family: Arial; font-size: 11px; line-height: 18px;\">Two-button blazer that combines tailoring tradition with contemporary style. With a python print collar to glam up the city chic look.</span></p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li style=\"margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">\r\n		Stretch cotton blend blazer.</li>\r\n	<li style=\"margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">\r\n		Collar in python print synthetic material.</li>\r\n	<li style=\"margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">\r\n		Long sleeves.</li>\r\n	<li style=\"margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">\r\n		Slim fit.</li>\r\n	<li style=\"margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">\r\n		Two-button fastening.</li>\r\n</ul>\r\n<p style=\"margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\">\r\n	<span style=\"color: rgb(0, 0, 0); line-height: 18px;\">Flap pockets at the front.</span><br style=\"color: rgb(0, 0, 0); line-height: 18px;\" />\r\n	<span style=\"color: rgb(0, 0, 0); line-height: 18px;\">Small diagonal pocket at the front.</span><br style=\"color: rgb(0, 0, 0); line-height: 18px;\" />\r\n	<span style=\"color: rgb(0, 0, 0); line-height: 18px;\">49% Polyester 48% Cotton 3% Elastane.</span><br style=\"color: rgb(0, 0, 0); line-height: 18px;\" />\r\n	<span style=\"color: rgb(0, 0, 0); line-height: 18px;\">Dry clean.</span></p>\r\n','','','',1,0,0,0,0,0,0,0,0,'',0,'20150615','',3,0,0);
/*!40000 ALTER TABLE `tta_produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_categorias`
--

DROP TABLE IF EXISTS `tta_produtos_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_categorias` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `categoriapai` bigint(20) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `subreferencia` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `disponivel` tinyint(1) NOT NULL,
  `visaounica` tinyint(1) NOT NULL,
  `descricaopequena` text COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_categorias`
--

LOCK TABLES `tta_produtos_categorias` WRITE;
/*!40000 ALTER TABLE `tta_produtos_categorias` DISABLE KEYS */;
INSERT INTO `tta_produtos_categorias` VALUES (1,0,'Eletrônicos','1',0,'',1,1,'','',''),(2,0,'Cosméticos','2',1,'',1,1,'','',''),(3,0,'Pefumes','3',2,'',1,1,'','',''),(4,0,'Roupas','4',3,'',1,1,'','',''),(5,0,'Chocolates, Café, Bistrô','5',4,'',1,1,'','',''),(6,4,'Camisas','20',0,'',1,0,'','',''),(7,4,'Calças','21',0,'',1,0,'','',''),(8,4,'Shortes','22',0,'',1,0,'','',''),(9,4,'Vestidos','23',0,'',1,0,'','',''),(10,4,'Bermudas','29',0,'',1,0,'','',''),(11,4,'Terno','35',0,'',1,0,'','','');
/*!40000 ALTER TABLE `tta_produtos_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_configuracoes`
--

DROP TABLE IF EXISTS `tta_produtos_configuracoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_configuracoes` (
  `produtosporpagina` int(11) NOT NULL,
  `listasubcategorias` int(11) NOT NULL,
  `produtosporsubcategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_configuracoes`
--

LOCK TABLES `tta_produtos_configuracoes` WRITE;
/*!40000 ALTER TABLE `tta_produtos_configuracoes` DISABLE KEYS */;
INSERT INTO `tta_produtos_configuracoes` VALUES (16,0,16);
/*!40000 ALTER TABLE `tta_produtos_configuracoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_cores`
--

DROP TABLE IF EXISTS `tta_produtos_cores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_cores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hexadecimal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_cores`
--

LOCK TABLES `tta_produtos_cores` WRITE;
/*!40000 ALTER TABLE `tta_produtos_cores` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_cores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_encomenda`
--

DROP TABLE IF EXISTS `tta_produtos_encomenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_encomenda` (
  `idproduto` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_encomenda`
--

LOCK TABLES `tta_produtos_encomenda` WRITE;
/*!40000 ALTER TABLE `tta_produtos_encomenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_encomenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_marcas`
--

DROP TABLE IF EXISTS `tta_produtos_marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enderecourl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disponivel` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_marcas`
--

LOCK TABLES `tta_produtos_marcas` WRITE;
/*!40000 ALTER TABLE `tta_produtos_marcas` DISABLE KEYS */;
INSERT INTO `tta_produtos_marcas` VALUES (3,'Nautica','25','','','01.jpg',1),(4,'7 Camicie','26','','','02.png',1),(5,'GUESS Man','27','','','03.jpg',1),(6,'Animale','36','','','1b1873c507.png',1),(7,'Vince Camuto','37','','','8b09c5e814.png',1),(8,'Jeep','38','','','13836f7d08.png',1),(9,'Lacoste','39','','','394534e616.png',1),(10,'Hummer','40','','','a50403b409.png',1),(11,'Tommy Hilfiger','41','','','11.png',1);
/*!40000 ALTER TABLE `tta_produtos_marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_opcoes`
--

DROP TABLE IF EXISTS `tta_produtos_opcoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_opcoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  `multi` tinyint(1) NOT NULL,
  `filtro` tinyint(1) NOT NULL,
  `aberto` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_opcoes`
--

LOCK TABLES `tta_produtos_opcoes` WRITE;
/*!40000 ALTER TABLE `tta_produtos_opcoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_opcoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_opcoes_gerados`
--

DROP TABLE IF EXISTS `tta_produtos_opcoes_gerados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_opcoes_gerados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto` int(11) NOT NULL,
  `opcao` int(11) NOT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_opcoes_gerados`
--

LOCK TABLES `tta_produtos_opcoes_gerados` WRITE;
/*!40000 ALTER TABLE `tta_produtos_opcoes_gerados` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_opcoes_gerados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_opcoes_valores`
--

DROP TABLE IF EXISTS `tta_produtos_opcoes_valores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_opcoes_valores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opcao` int(11) NOT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_opcoes_valores`
--

LOCK TABLES `tta_produtos_opcoes_valores` WRITE;
/*!40000 ALTER TABLE `tta_produtos_opcoes_valores` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_opcoes_valores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_pedras`
--

DROP TABLE IF EXISTS `tta_produtos_pedras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_pedras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_pedras`
--

LOCK TABLES `tta_produtos_pedras` WRITE;
/*!40000 ALTER TABLE `tta_produtos_pedras` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_pedras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_tamanhos`
--

DROP TABLE IF EXISTS `tta_produtos_tamanhos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_tamanhos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_tamanhos`
--

LOCK TABLES `tta_produtos_tamanhos` WRITE;
/*!40000 ALTER TABLE `tta_produtos_tamanhos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_tamanhos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_produtos_termos_procurados`
--

DROP TABLE IF EXISTS `tta_produtos_termos_procurados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_produtos_termos_procurados` (
  `termo` varchar(50) NOT NULL,
  `contador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_produtos_termos_procurados`
--

LOCK TABLES `tta_produtos_termos_procurados` WRITE;
/*!40000 ALTER TABLE `tta_produtos_termos_procurados` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_produtos_termos_procurados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_recados`
--

DROP TABLE IF EXISTS `tta_recados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_recados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessao` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idsessao` int(11) DEFAULT NULL,
  `texto` int(11) NOT NULL,
  `data` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `liberado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_recados`
--

LOCK TABLES `tta_recados` WRITE;
/*!40000 ALTER TABLE `tta_recados` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_recados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_arquivos_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_arquivos_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_arquivos_categorias` (
  `arquivo` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_arquivos_categorias`
--

LOCK TABLES `tta_relacionamento_arquivos_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_arquivos_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_relacionamento_arquivos_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_banners_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_banners_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_banners_categorias` (
  `banner` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_banners_categorias`
--

LOCK TABLES `tta_relacionamento_banners_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_banners_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_relacionamento_banners_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_galerias_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_galerias_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_galerias_categorias` (
  `galeria` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_galerias_categorias`
--

LOCK TABLES `tta_relacionamento_galerias_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_galerias_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_relacionamento_galerias_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_musicas_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_musicas_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_musicas_categorias` (
  `musica` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_musicas_categorias`
--

LOCK TABLES `tta_relacionamento_musicas_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_musicas_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_relacionamento_musicas_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_noticias_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_noticias_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_noticias_categorias` (
  `noticia` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_noticias_categorias`
--

LOCK TABLES `tta_relacionamento_noticias_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_noticias_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_relacionamento_noticias_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_ofertascoletivas_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_ofertascoletivas_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_ofertascoletivas_categorias` (
  `ofertacoletiva` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_ofertascoletivas_categorias`
--

LOCK TABLES `tta_relacionamento_ofertascoletivas_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_ofertascoletivas_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_relacionamento_ofertascoletivas_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_produtos_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_produtos_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_produtos_categorias` (
  `produto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `categoria` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`produto`,`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_produtos_categorias`
--

LOCK TABLES `tta_relacionamento_produtos_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_produtos_categorias` DISABLE KEYS */;
INSERT INTO `tta_relacionamento_produtos_categorias` VALUES ('14','10'),('15','6'),('16','6'),('17','6'),('18','6'),('19','11');
/*!40000 ALTER TABLE `tta_relacionamento_produtos_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_produtos_infos`
--

DROP TABLE IF EXISTS `tta_relacionamento_produtos_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_produtos_infos` (
  `produto` int(11) NOT NULL,
  `cor` int(11) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `pedra` int(11) NOT NULL,
  `estoque` int(11) NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_produtos_infos`
--

LOCK TABLES `tta_relacionamento_produtos_infos` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_produtos_infos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_relacionamento_produtos_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_relacionamento_slides_categorias`
--

DROP TABLE IF EXISTS `tta_relacionamento_slides_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_relacionamento_slides_categorias` (
  `slide` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_relacionamento_slides_categorias`
--

LOCK TABLES `tta_relacionamento_slides_categorias` WRITE;
/*!40000 ALTER TABLE `tta_relacionamento_slides_categorias` DISABLE KEYS */;
INSERT INTO `tta_relacionamento_slides_categorias` VALUES (1,1);
/*!40000 ALTER TABLE `tta_relacionamento_slides_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_slides`
--

DROP TABLE IF EXISTS `tta_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `legenda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enderecourl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ativo` int(11) NOT NULL,
  `tipo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `segundos` int(11) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_slides`
--

LOCK TABLES `tta_slides` WRITE;
/*!40000 ALTER TABLE `tta_slides` DISABLE KEYS */;
INSERT INTO `tta_slides` VALUES (1,'Teste','Imagem de teste','',1,'Imagem',0,5,'edf33633Banner.png','');
/*!40000 ALTER TABLE `tta_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_slides_categorias`
--

DROP TABLE IF EXISTS `tta_slides_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_slides_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_slides_categorias`
--

LOCK TABLES `tta_slides_categorias` WRITE;
/*!40000 ALTER TABLE `tta_slides_categorias` DISABLE KEYS */;
INSERT INTO `tta_slides_categorias` VALUES (1,'Topo');
/*!40000 ALTER TABLE `tta_slides_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_telefones`
--

DROP TABLE IF EXISTS `tta_telefones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_telefones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ligacao` int(11) DEFAULT NULL,
  `local` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd` int(11) DEFAULT NULL,
  `telefone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ramal` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_telefones`
--

LOCK TABLES `tta_telefones` WRITE;
/*!40000 ALTER TABLE `tta_telefones` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_telefones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_textos`
--

DROP TABLE IF EXISTS `tta_textos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_textos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtitulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `textopequeno` text COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_textos`
--

LOCK TABLES `tta_textos` WRITE;
/*!40000 ALTER TABLE `tta_textos` DISABLE KEYS */;
INSERT INTO `tta_textos` VALUES (1,42,'About','','<p>\r\n	Por ser o mais novo e exclusivo Shopping DFS do Paraguai.</p>\r\n','<p>\r\n	Por ser o mais novo e exclusivo Shopping DFS do Paraguai cujo diferencia-se de todos que por desde sua arquitetura moderna est&aacute; trazendo principalmente ao acesso de todos os produtos que antes vistos somente na Europa, como presentes acess&iacute;veis mudando totalmente o mercado local para um novo conceito em compras com os principais segmentos.</p>\r\n',0,0);
/*!40000 ALTER TABLE `tta_textos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_tickets`
--

DROP TABLE IF EXISTS `tta_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `nivel` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `satisfacao` int(11) NOT NULL,
  `datahora_criacao` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `datahora_alteracao` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_tickets`
--

LOCK TABLES `tta_tickets` WRITE;
/*!40000 ALTER TABLE `tta_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_tickets_postagens`
--

DROP TABLE IF EXISTS `tta_tickets_postagens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_tickets_postagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` int(11) NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `arquivo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datahora` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_tickets_postagens`
--

LOCK TABLES `tta_tickets_postagens` WRITE;
/*!40000 ALTER TABLE `tta_tickets_postagens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_tickets_postagens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_urls`
--

DROP TABLE IF EXISTS `tta_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tabela` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `campo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_urls`
--

LOCK TABLES `tta_urls` WRITE;
/*!40000 ALTER TABLE `tta_urls` DISABLE KEYS */;
INSERT INTO `tta_urls` VALUES (1,'eletronicos','produtos_categorias','url','1'),(2,'cosmeticos','produtos_categorias','url','2'),(3,'pefumes','produtos_categorias','url','3'),(4,'roupas','produtos_categorias','url','4'),(5,'chocolates-cafe-bistro','produtos_categorias','url','5'),(20,'roupas-camisas','produtos_categorias','url','6'),(21,'roupas-calcas','produtos_categorias','url','7'),(22,'roupas-shortes','produtos_categorias','url','8'),(23,'roupas-vestidos','produtos_categorias','url','9'),(25,'marca-nautica','produtos_marcas','url','3'),(26,'marca-7-camicie','produtos_marcas','url','4'),(27,'marca-guess-man','produtos_marcas','url','5'),(28,'14B44000-flat-front-deck-short','produtos','url','14'),(29,'roupas-bermudas','produtos_categorias','url','10'),(30,'15K52126-chest-stripe-performance-deck-polo-shirt','produtos','url','15'),(31,'16K51236-slim-fit-fish-print-deck-polo-shirt','produtos','url','16'),(32,'174K3903-two-pocket-polo-shirt','produtos','url','17'),(33,'18497-shirt-linda-off-whitebrown','produtos','url','18'),(34,'1951M2001117Z-marciano-python-print-blazer','produtos','url','19'),(35,'roupas-terno','produtos_categorias','url','11'),(36,'marca-animale','produtos_marcas','url','6'),(37,'marca-vince-camuto','produtos_marcas','url','7'),(38,'marca-jeep','produtos_marcas','url','8'),(39,'marca-lacoste','produtos_marcas','url','9'),(40,'marca-hummer','produtos_marcas','url','10'),(41,'marca-tommy-hilfiger','produtos_marcas','url','11'),(42,'about','textos','url','1');
/*!40000 ALTER TABLE `tta_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_usuarios`
--

DROP TABLE IF EXISTS `tta_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` int(11) NOT NULL,
  `nome` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `ensino` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_usuarios`
--

LOCK TABLES `tta_usuarios` WRITE;
/*!40000 ALTER TABLE `tta_usuarios` DISABLE KEYS */;
INSERT INTO `tta_usuarios` VALUES (1,1,'Marcelo','marcelo','123','','','');
/*!40000 ALTER TABLE `tta_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tta_vendedores`
--

DROP TABLE IF EXISTS `tta_vendedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tta_vendedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `skype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `voip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ramal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `msn` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tta_vendedores`
--

LOCK TABLES `tta_vendedores` WRITE;
/*!40000 ALTER TABLE `tta_vendedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `tta_vendedores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-18  3:22:38
