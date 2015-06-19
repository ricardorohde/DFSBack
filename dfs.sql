-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 19/06/2015 às 00:20
-- Versão do servidor: 5.5.42-cll
-- Versão do PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `pioneeri_v3`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_arquivos`
--

CREATE TABLE IF NOT EXISTS `dfs_arquivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arquivo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `produtos` text COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_arquivos_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_arquivos_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_banners`
--

CREATE TABLE IF NOT EXISTS `dfs_banners` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_banners_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_banners_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `largura` decimal(6,2) NOT NULL,
  `altura` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_cidade`
--

CREATE TABLE IF NOT EXISTS `dfs_cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddd` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_enderecos`
--

CREATE TABLE IF NOT EXISTS `dfs_enderecos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_estado`
--

CREATE TABLE IF NOT EXISTS `dfs_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uf` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_eventos`
--

CREATE TABLE IF NOT EXISTS `dfs_eventos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `data` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_frete`
--

CREATE TABLE IF NOT EXISTS `dfs_frete` (
  `ceporigem` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ativocorreio` tinyint(1) NOT NULL,
  `logincorreio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `senhacorreio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fretegratis` tinyint(1) NOT NULL,
  `apartirvalorfretegratis` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_galerias`
--

CREATE TABLE IF NOT EXISTS `dfs_galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Fazendo dump de dados para tabela `dfs_galerias`
--

INSERT INTO `dfs_galerias` (`id`, `url`, `titulo`, `descricao`, `local`, `tipo`, `data`, `video`) VALUES
(1, 37, 'Las Vegas', '', '', 'Fotos', '201506182133', ''),
(2, 38, 'Opera House - Sydney', '', '', 'Fotos', '201506182135', ''),
(3, 39, 'Seatle', '', '', 'Fotos', '201506182135', ''),
(4, 40, 'Eden''s Garden', '', '', 'Fotos', '201506182157', ''),
(5, 41, 'Beijing - China', '', '', 'Fotos', '201506182157', ''),
(6, 42, 'Portal de Brandenburgo - Alemanha', '<p style="margin: 0.5em 0px; line-height: 22px; color: rgb(37, 37, 37); font-family: sans-serif; font-size: 14px; text-align: justify;">\r\n	O&nbsp;<b>Port&atilde;o de Brandemburgo</b>, ou&nbsp;<b>Porta de Brandemburgo</b>&nbsp;(em&nbsp;<a href="https://pt.wikipedia.org/wiki/L%C3%ADngua_alem%C3%A3" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Língua alemã">alem&atilde;o</a>:&nbsp;<span lang="de" xml:lang="de"><i><b>Brandenburger Tor</b></i></span>), &eacute; uma antiga&nbsp;<a href="https://pt.wikipedia.org/wiki/Portas_da_cidade" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Portas da cidade">porta da cidade</a>, reconstru&iacute;da no final do&nbsp;<span style="white-space: nowrap;">s&eacute;culo XVIII</span>&nbsp;como um&nbsp;<a href="https://pt.wikipedia.org/wiki/Arco_do_triunfo" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Arco do triunfo">arco do triunfo</a>&nbsp;<a href="https://pt.wikipedia.org/wiki/Arquitetura_do_neoclassicismo" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Arquitetura do neoclassicismo">neocl&aacute;ssico</a>, e hoje um dos marcos mais conhecidos da&nbsp;<a href="https://pt.wikipedia.org/wiki/Alemanha" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Alemanha">Alemanha</a>.<span class="reference" id="cite_ref-Holland_Gawthrop_1-0" style="line-height: 1; height: 0px; vertical-align: baseline; position: relative; bottom: 1ex; unicode-bidi: -webkit-isolate;"><a href="https://pt.wikipedia.org/wiki/Port%C3%A3o_de_Brandemburgo#cite_note-Holland_Gawthrop-1" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;">1</a></span></p>\r\n<p style="margin: 0.5em 0px; line-height: 22px; color: rgb(37, 37, 37); font-family: sans-serif; font-size: 14px; text-align: justify;">\r\n	Est&aacute; localizado na parte ocidental do centro da cidade de&nbsp;<a href="https://pt.wikipedia.org/wiki/Berlim" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Berlim">Berlim</a>, no cruzamento da avenida&nbsp;<a href="https://pt.wikipedia.org/wiki/Unter_den_Linden" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Unter den Linden">Unter den Linden</a>&nbsp;e&nbsp;<a class="new" href="https://pt.wikipedia.org/w/index.php?title=Ebertstra%C3%9Fe&amp;action=edit&amp;redlink=1" style="text-decoration: none; color: rgb(165, 88, 88); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Ebertstraße (página não existe)">Ebertstra&szlig;e</a>, imediatamente a oeste da&nbsp;<a href="https://pt.wikipedia.org/wiki/Pariser_Platz" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Pariser Platz">Pariser Platz</a>. Um bloco ao norte fica localizado o&nbsp;<a href="https://pt.wikipedia.org/wiki/Pal%C3%A1cio_do_Reichstag" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Palácio do Reichstag">Pal&aacute;cio do&nbsp;<i>Reichstag</i></a>. O port&atilde;o &eacute; a entrada monumental para Unter den Linden, a famosa avenida de&nbsp;<a href="https://pt.wikipedia.org/wiki/Tilia" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Tilia">t&iacute;lias</a>que anteriormente levava diretamente ao&nbsp;<a href="https://pt.wikipedia.org/wiki/Berliner_Stadtschloss" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Berliner Stadtschloss">Pal&aacute;cio da Cidade</a>&nbsp;dos reis da&nbsp;<a href="https://pt.wikipedia.org/wiki/Pr%C3%BAssia" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Prússia">Pr&uacute;ssia</a>.<span class="reference" id="cite_ref-Holland_Gawthrop_1-1" style="line-height: 1; height: 0px; vertical-align: baseline; position: relative; bottom: 1ex; unicode-bidi: -webkit-isolate;"><a href="https://pt.wikipedia.org/wiki/Port%C3%A3o_de_Brandemburgo#cite_note-Holland_Gawthrop-1" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;">1</a></span>&nbsp;<span class="reference" id="cite_ref-2" style="line-height: 1; height: 0px; vertical-align: baseline; position: relative; bottom: 1ex; unicode-bidi: -webkit-isolate;"><a href="https://pt.wikipedia.org/wiki/Port%C3%A3o_de_Brandemburgo#cite_note-2" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;">2</a></span></p>\r\n<p style="margin: 0.5em 0px; line-height: 22px; color: rgb(37, 37, 37); font-family: sans-serif; font-size: 14px; text-align: justify;">\r\n	Foi encomendada pelo rei&nbsp;<a href="https://pt.wikipedia.org/wiki/Frederico_Guilherme_II_da_Pr%C3%BAssia" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Frederico Guilherme II da Prússia">Frederico Guilherme II da Pr&uacute;ssia</a>&nbsp;como um sinal de guerra e constru&iacute;da por&nbsp;<a href="https://pt.wikipedia.org/wiki/Carl_Gotthard_Langhans" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Carl Gotthard Langhans">Carl Gotthard Langhans</a>&nbsp;entre 1788 e 1791.<span class="reference" id="cite_ref-3" style="line-height: 1; height: 0px; vertical-align: baseline; position: relative; bottom: 1ex; unicode-bidi: -webkit-isolate;"><a href="https://pt.wikipedia.org/wiki/Port%C3%A3o_de_Brandemburgo#cite_note-3" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;">3</a></span>&nbsp;Tendo sofrido danos consider&aacute;veis ​​na&nbsp;<a href="https://pt.wikipedia.org/wiki/Segunda_Guerra_Mundial" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Segunda Guerra Mundial">Segunda Guerra Mundial</a>, o Port&atilde;o de Brandemburgo foi totalmente restaurado entre 2000 e 2002 pela&nbsp;<i>Stiftung Denkmalschutz Berlin</i>&nbsp;(Funda&ccedil;&atilde;o de Conserva&ccedil;&atilde;o dos Monumentos de Berlim).<span class="reference" id="cite_ref-4" style="line-height: 1; height: 0px; vertical-align: baseline; position: relative; bottom: 1ex; unicode-bidi: -webkit-isolate;"><a href="https://pt.wikipedia.org/wiki/Port%C3%A3o_de_Brandemburgo#cite_note-4" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; white-space: nowrap; background-position: initial initial; background-repeat: initial initial;">4</a></span></p>\r\n<p style="margin: 0.5em 0px; line-height: 22px; color: rgb(37, 37, 37); font-family: sans-serif; font-size: 14px; text-align: justify;">\r\n	Durante a&nbsp;<a href="https://pt.wikipedia.org/wiki/Hist%C3%B3ria_da_Alemanha_ap%C3%B3s_1945" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="História da Alemanha após 1945">parti&ccedil;&atilde;o da Alemanha no p&oacute;s-guerra</a>, o Port&atilde;o estava isolado e inacess&iacute;vel imediatamente ao lado do&nbsp;<a href="https://pt.wikipedia.org/wiki/Muro_de_Berlim" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Muro de Berlim">Muro de Berlim</a>, e a &aacute;rea ao redor do Port&atilde;o se destacou mais proeminente na cobertura da m&iacute;dia sobre a abertura do muro em 1989. Ao longo de sua exist&ecirc;ncia, o Port&atilde;o de Brandemburgo foi muitas vezes um local para grandes eventos hist&oacute;ricos e &eacute; hoje considerado um s&iacute;mbolo da tumultuada hist&oacute;ria da Europa e da Alemanha, mas tamb&eacute;m da unidade e da paz europ&eacute;ia.</p>\r\n', '', 'Fotos', '201506182203', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_galerias_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_galerias_categorias` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `dfs_galerias_categorias`
--

INSERT INTO `dfs_galerias_categorias` (`id`, `titulo`, `url`, `texto`, `largura`, `altura`, `larguram`, `alturam`, `largurap`, `alturap`, `protegido`) VALUES
(1, 'Pontos Turísticos', 36, 0, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_idiomas`
--

CREATE TABLE IF NOT EXISTS `dfs_idiomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(10) CHARACTER SET latin1 NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 NOT NULL,
  `imagem` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_idiomas_traducoes`
--

CREATE TABLE IF NOT EXISTS `dfs_idiomas_traducoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` int(11) NOT NULL,
  `conteudo` text COLLATE utf8_unicode_ci NOT NULL,
  `traducao` text COLLATE utf8_unicode_ci NOT NULL,
  `campoconteudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tabelaconteudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idconteudo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_imagens`
--

CREATE TABLE IF NOT EXISTS `dfs_imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `idsessao` int(11) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legenda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `destaque` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Fazendo dump de dados para tabela `dfs_imagens`
--

INSERT INTO `dfs_imagens` (`id`, `sessao`, `idsessao`, `imagem`, `legenda`, `destaque`) VALUES
(25, 'produtos', 14, 'zoom_variation_428_view_A_2192x2200.jpg', '', 1),
(26, 'produtos', 14, 'zoom_variation_428_view_B_2192x2200.jpg', '', 0),
(27, 'produtos', 15, 'zoom_variation_419_view_A_2192x2200.jpg', '', 1),
(28, 'produtos', 16, 'zoom_variation_101_view_A_2192x2200.jpg', '', 0),
(29, 'produtos', 16, 'zoom_variation_101_view_B_2192x2200.jpg', '', 1),
(30, 'produtos', 17, 'zoom_variation_063_view_A_2192x2200.jpg', '', 1),
(31, 'produtos', 18, 'Shirt-Woman-Long-sleeve-shirt-2-Button-slim-coton-printed-Off-WhiteBrown.jpg', '', 1),
(32, 'produtos', 19, '51M2001117Z-0089-ALT1.jpg', '', 0),
(33, 'produtos', 19, '51M2001117Z-0089-ALT2.jpg', '', 1),
(34, 'galerias', 1, 'las-vegas-day.jpg', '', 0),
(35, 'galerias', 2, 'Sydney-Opera-house-Sydney-Australia.jpg', '', 0),
(36, 'galerias', 3, 'Seattle-Washington.jpg', '', 0),
(37, 'galerias', 4, 'garden-of-eden-landscape.jpg', '', 0),
(38, 'galerias', 5, 'beijing-03.jpg', '', 0),
(39, 'galerias', 6, 'portal-brandenburgo.jpg', '', 0),
(40, 'textos', 2, '01.jpg', '', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_mailing`
--

CREATE TABLE IF NOT EXISTS `dfs_mailing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pacote` int(11) DEFAULT NULL,
  `texto` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `data` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_mailing_pacotes`
--

CREATE TABLE IF NOT EXISTS `dfs_mailing_pacotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_mailing_pacotes_emails`
--

CREATE TABLE IF NOT EXISTS `dfs_mailing_pacotes_emails` (
  `pacote` int(11) NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cidade` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datanasc` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`pacote`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_mailing_pacotes_envio`
--

CREATE TABLE IF NOT EXISTS `dfs_mailing_pacotes_envio` (
  `mailing` int(11) NOT NULL DEFAULT '0',
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`mailing`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_marcadagua`
--

CREATE TABLE IF NOT EXISTS `dfs_marcadagua` (
  `posicaohorizontal` int(11) NOT NULL,
  `posicaovertical` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `produtos` tinyint(1) NOT NULL,
  `galerias` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_musicas`
--

CREATE TABLE IF NOT EXISTS `dfs_musicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `musica` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_musicas_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_musicas_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subtitulo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravadora` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datalancamento` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capa` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_noticias`
--

CREATE TABLE IF NOT EXISTS `dfs_noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `data` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `dfs_noticias`
--

INSERT INTO `dfs_noticias` (`id`, `url`, `texto`, `data`) VALUES
(1, 44, 2, '201503150000');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_noticias_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_noticias_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `texto` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `dfs_noticias_categorias`
--

INSERT INTO `dfs_noticias_categorias` (`id`, `url`, `texto`, `ordem`) VALUES
(1, 43, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_ofertascoletivas`
--

CREATE TABLE IF NOT EXISTS `dfs_ofertascoletivas` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_ofertascoletivas_empresas`
--

CREATE TABLE IF NOT EXISTS `dfs_ofertascoletivas_empresas` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_ofertascoletivas_empresas_emails`
--

CREATE TABLE IF NOT EXISTS `dfs_ofertascoletivas_empresas_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pessoa` int(11) NOT NULL,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `principal` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_ofertascoletivas_empresas_enderecos`
--

CREATE TABLE IF NOT EXISTS `dfs_ofertascoletivas_empresas_enderecos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_ofertascoletivas_empresas_telefones`
--

CREATE TABLE IF NOT EXISTS `dfs_ofertascoletivas_empresas_telefones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ligacao` int(11) DEFAULT NULL,
  `local` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd` int(11) DEFAULT NULL,
  `telefone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ramal` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_pagamentos`
--

CREATE TABLE IF NOT EXISTS `dfs_pagamentos` (
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

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_pais`
--

CREATE TABLE IF NOT EXISTS `dfs_pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddi` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_pedidos`
--

CREATE TABLE IF NOT EXISTS `dfs_pedidos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_pedido_enderecos`
--

CREATE TABLE IF NOT EXISTS `dfs_pedido_enderecos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_pedido_itens`
--

CREATE TABLE IF NOT EXISTS `dfs_pedido_itens` (
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

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_perguntas`
--

CREATE TABLE IF NOT EXISTS `dfs_perguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL,
  `url` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_perguntas_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_perguntas_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_pessoas`
--

CREATE TABLE IF NOT EXISTS `dfs_pessoas` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_pessoas_emails`
--

CREATE TABLE IF NOT EXISTS `dfs_pessoas_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pessoa` int(11) NOT NULL,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `principal` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Fazendo dump de dados para tabela `dfs_produtos`
--

INSERT INTO `dfs_produtos` (`id`, `produtopai`, `url`, `marca`, `nome`, `codigo`, `peso`, `largura`, `altura`, `comprimento`, `valorcusto`, `valorreal`, `valorvenda`, `estoque`, `descricaopequena`, `descricao`, `especificacao`, `manual`, `palavraschaves`, `disponivel`, `promocao`, `lancamento`, `destaque`, `removido`, `cor`, `pedra`, `tamanho`, `ordem`, `tipounidade`, `quantidade`, `datacadastro`, `urlvideo`, `frete`, `tipopedido`) VALUES
(14, 0, 28, 3, 'FLAT FRONT DECK SHORT', 'B44000', '0.000', '0.00', '0.00', '0.00', '399.00', '500.00', '450.00', 0, '<p>\r\n	Our classic shorts. Made of cotton twill with a flat-front design and a clean cut look, they&#39;re an essential pair to keep around for Saturdays and vacation days.</p>\r\n', '<p>\r\n	Our classic shorts. Made of cotton twill with a flat-front design and a clean cut look, they&#39;re an essential pair to keep around for Saturdays and vacation days.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		100% Cotton</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Button and zipper closure</li>\r\n	<li>\r\n		Side pockets; buttoned back welt pockets</li>\r\n	<li>\r\n		Flat front</li>\r\n	<li>\r\n		Inseam: approx. 9-1/2 inches</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n', '', '', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, '20150615', '', 3, 0),
(15, 0, 30, 3, 'CHEST STRIPE PERFORMANCE DECK POLO SHIRT', 'K52126', '0.000', '0.00', '0.00', '0.00', '5499.00', '7950.00', '6950.00', 0, '<p>\r\n	Our best-selling polo will keep you dry, comfortable and in style wherever your adventures may take you thanks to its innovative moisture-wicking fabric and classic fit.</p>\r\n', '<p>\r\n	Our best-selling polo will keep you dry, comfortable and in style wherever your adventures may take you thanks to its innovative moisture-wicking fabric and classic fit.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		60% Cotton, 40% Polyester</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Polo collar and buttoned placket</li>\r\n	<li>\r\n		Short sleeves</li>\r\n	<li>\r\n		Moisture wicking</li>\r\n	<li>\r\n		Classic fit</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n', '', '', '', 1, 0, 1, 0, 0, 0, 0, 0, 0, '', 0, '20150615', '', 3, 0),
(16, 0, 31, 3, 'SLIM FIT FISH PRINT DECK POLO SHIRT', 'K51236', '0.000', '0.00', '0.00', '0.00', '499.00', '695.00', '0.00', 0, '<p>\r\n	Throwing out a line for fish lovers. This cotton polo will be your favorite new shirt between the slim fit and colorful graphic on the back.</p>\r\n', '<p>\r\n	Throwing out a line for fish lovers. This cotton polo will be your favorite new shirt between the slim fit and colorful graphic on the back.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		100% Cotton</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Polo collar and buttoned placket</li>\r\n	<li>\r\n		Short sleeves</li>\r\n	<li>\r\n		Fish print at back</li>\r\n	<li>\r\n		Slim fit</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n', '', '', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, '20150615', '', 3, 0),
(17, 0, 32, 3, 'TWO POCKET POLO SHIRT', '4K3903', '0.000', '0.00', '0.00', '0.00', '499.00', '795.00', '695.00', 0, '<p>\r\n	A cool new take on the polo shirt--plenty of contrasting trim to highlight the great fit.</p>\r\n', '<p>\r\n	A cool new take on the polo shirt--plenty of contrasting trim to highlight the great fit.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		100% Cotton</li>\r\n	<li>\r\n		Machine wash</li>\r\n	<li>\r\n		Polo collar and buttoned placket</li>\r\n	<li>\r\n		Short sleeves</li>\r\n	<li>\r\n		Split at sides of hem</li>\r\n	<li>\r\n		Authentic fit</li>\r\n</ul>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Ground Shipping Delivery: $8*<br />\r\n	5-7 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	2 Day Express: $12*<br />\r\n	2 business days (if ordered by 12pm EST)</p>\r\n<p>\r\n	Overnight Delivery: $20*<br />\r\n	1 business day</p>\r\n<p>\r\n	*Rates and delivery times for the 48 continuous United States</p>\r\n<p>\r\n	RETURNS</p>\r\n<p>\r\n	Returns must be made within 90 days of delivery for a refund of the purchase price, minus the shipping, handling, gift box fee and other additional charges.</p>\r\n', '', '', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, '20150615', '', 3, 0),
(18, 0, 33, 4, 'SHIRT LINDA OFF WHITEBROWN', '497', '0.000', '0.00', '0.00', '0.00', '159.00', '259.00', '0.00', 0, '<p>\r\n	<span style="color: rgb(102, 102, 102); font-family: ''Source Sans Pro'', Tahoma, sans-serif, Arial; font-size: 13.5px; line-height: 20.25px; text-align: justify;">2 Buttons Italian Collar Slim Woman Shirt Off WhiteBrown</span></p>\r\n', '<p>\r\n	<span style="color: rgb(102, 102, 102); font-family: ''Source Sans Pro'', Tahoma, sans-serif, Arial; font-size: 13.5px; line-height: 20.25px; text-align: justify;">2 Buttons Italian Collar Slim Woman Shirt Off WhiteBrown</span></p>\r\n<p>\r\n	&nbsp;</p>\r\n<table class="table-data-sheet" style="box-sizing: border-box; margin: 0px 0px 20px; padding: 0px; border-top-width: 0px; border-right-width: 0px; border-left-width: 0px; border-bottom-style: solid; border-bottom-color: rgb(229, 229, 229); font-family: ''Source Sans Pro'', Tahoma, sans-serif, Arial; font-stretch: inherit; line-height: 20.25px; font-size: 13.5px; vertical-align: baseline; border-collapse: collapse; border-spacing: 0px; max-width: 100%; width: 794px; color: rgb(102, 102, 102); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">\r\n	<tbody style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;">\r\n		<tr class="odd" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Style</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				Sportwear</td>\r\n		</tr>\r\n		<tr class="even" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Model</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				Linda</td>\r\n		</tr>\r\n		<tr class="odd" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Fit</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				Slim</td>\r\n		</tr>\r\n		<tr class="even" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Design</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				Stampa</td>\r\n		</tr>\r\n		<tr class="odd" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Colour</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				Beige</td>\r\n		</tr>\r\n		<tr class="even" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Fabric Composition</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr class="odd" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Fabric</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				Cotone</td>\r\n		</tr>\r\n		<tr class="even" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Sleeve</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				Long sleeve shirt</td>\r\n		</tr>\r\n		<tr class="odd" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Collar Type</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				2 buttons italian collar</td>\r\n		</tr>\r\n		<tr class="even" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline; background: rgb(253, 253, 253);">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Collar Buttons</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				2 button</td>\r\n		</tr>\r\n		<tr class="odd" style="box-sizing: border-box; margin: 0px; padding: 0px; border-width: 1px 0px 0px; border-top-style: solid; border-top-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; vertical-align: baseline;">\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border-top-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-right-style: solid; border-right-color: rgb(229, 229, 229); font-family: inherit; font-style: inherit; font-variant: inherit; font-weight: 700; font-stretch: inherit; line-height: inherit; vertical-align: middle; width: 238px; color: rgb(51, 51, 51);">\r\n				Vela</td>\r\n			<td style="box-sizing: border-box; margin: 0px; padding: 0px 5px; border: 0px; font-family: inherit; font-style: inherit; font-variant: inherit; font-stretch: inherit; line-height: inherit; vertical-align: middle;">\r\n				1 fold</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<span style="color: rgb(102, 102, 102); font-family: ''Source Sans Pro'', Tahoma, sans-serif, Arial; font-size: 13.3333330154419px; line-height: 20.25px; text-align: justify; background-color: rgb(250, 250, 250);">O Cliente ele tem o direito de rescindir o contrato de compra por qualquer raz&atilde;o, sem penaliza&ccedil;&atilde;o alguma e sem preju&iacute;zos, conforme o par&aacute;grafo 3 subsequente. Para exercer esse direito, o Cliente dever&aacute; enviar um e-mail com uma solicita&ccedil;&atilde;o de rescis&atilde;o. A Ottimo Ltda., por sua vez, enviar&aacute; um correio eletr&ocirc;nico com um formul&aacute;rio, a ser impresso pelo Cliente, que cont&eacute;m o n&uacute;mero de autoriza&ccedil;&atilde;o que dever&aacute; ser colocado no exterior da embalagem referente ao produto. Ser&aacute; enviado &agrave; Ottimo Ltda., dentro de 10 dias a partir da autoriza&ccedil;&atilde;o &agrave;: Ottimo s.r.l c/o Grandi Progetti, Via del Corso 101, 00186 Roma, Italia.</span></p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<span style="color: rgb(102, 102, 102); font-family: ''Source Sans Pro'', Tahoma, sans-serif, Arial; font-size: 13.3333330154419px; line-height: 20.25px; text-align: justify; background-color: rgb(250, 250, 250);">Todos os produtos vendidos pela Ottimo Ltda. est&atilde;o cobertos pela garantia do fabricante, a partir do Decreto Legislativo n. 24/2002. Para ter direito &agrave; assist&ecirc;ncia pela garantia, o Cliente dever&aacute; guardar a nota fiscal ou o DDT, que receber&aacute; junto com os bens adquiridos. O Cliente sempre poder&aacute; baixar, por meio da p&aacute;gina&nbsp;</span><a href="http://www.7camicie.com/" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-family: ''Source Sans Pro'', Tahoma, sans-serif, Arial; font-stretch: inherit; line-height: 20.25px; font-size: 13.3333320617676px; vertical-align: baseline; color: rgb(68, 68, 68); text-decoration: none; -webkit-transition: color 200ms ease-in-out, background-color 300ms ease-in-out; transition: color 200ms ease-in-out, background-color 300ms ease-in-out; text-align: justify; background-color: rgb(250, 250, 250);">www.7camicie.com</a><span style="color: rgb(102, 102, 102); font-family: ''Source Sans Pro'', Tahoma, sans-serif, Arial; font-size: 13.3333330154419px; line-height: 20.25px; text-align: justify; background-color: rgb(250, 250, 250);">, as notas fiscais relativas &agrave;s suas compras, acessando o espa&ccedil;o reservado a essa a&ccedil;&atilde;o.</span></p>\r\n', '', '', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, '20150615', '', 3, 0),
(19, 0, 34, 5, 'MARCIANO PYTHON PRINT BLAZER', '51M2001117Z', '0.000', '0.00', '0.00', '0.00', '339.00', '539.00', '439.00', 0, '<p>\r\n	<span style="color: rgb(0, 0, 0); font-family: Arial; font-size: 11px; line-height: 18px;">Two-button blazer that combines tailoring tradition with contemporary style. With a python print collar to glam up the city chic look.</span></p>\r\n', '<p>\r\n	<span style="color: rgb(0, 0, 0); font-family: Arial; font-size: 11px; line-height: 18px;">Two-button blazer that combines tailoring tradition with contemporary style. With a python print collar to glam up the city chic look.</span></p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li style="margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">\r\n		Stretch cotton blend blazer.</li>\r\n	<li style="margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">\r\n		Collar in python print synthetic material.</li>\r\n	<li style="margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">\r\n		Long sleeves.</li>\r\n	<li style="margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">\r\n		Slim fit.</li>\r\n	<li style="margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">\r\n		Two-button fastening.</li>\r\n</ul>\r\n<p style="margin: 0px; padding: 0px 0px 0px 10px; border: 0px; outline: 0px; font-size: 11px; vertical-align: baseline; line-height: 14px; list-style: circle outside; color: rgb(102, 102, 102); font-family: Arial; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">\r\n	<span style="color: rgb(0, 0, 0); line-height: 18px;">Flap pockets at the front.</span><br style="color: rgb(0, 0, 0); line-height: 18px;" />\r\n	<span style="color: rgb(0, 0, 0); line-height: 18px;">Small diagonal pocket at the front.</span><br style="color: rgb(0, 0, 0); line-height: 18px;" />\r\n	<span style="color: rgb(0, 0, 0); line-height: 18px;">49% Polyester 48% Cotton 3% Elastane.</span><br style="color: rgb(0, 0, 0); line-height: 18px;" />\r\n	<span style="color: rgb(0, 0, 0); line-height: 18px;">Dry clean.</span></p>\r\n', '', '', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, '20150615', '', 3, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_categorias` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Fazendo dump de dados para tabela `dfs_produtos_categorias`
--

INSERT INTO `dfs_produtos_categorias` (`id`, `categoriapai`, `nome`, `url`, `ordem`, `subreferencia`, `disponivel`, `visaounica`, `descricaopequena`, `descricao`, `imagem`) VALUES
(1, 0, 'Eletrônicos', '1', 0, '', 1, 1, '', '', ''),
(2, 0, 'Cosméticos', '2', 1, '', 1, 1, '', '', ''),
(3, 0, 'Pefumes', '3', 2, '', 1, 1, '', '', ''),
(4, 0, 'Roupas', '4', 3, '', 1, 1, '', '', ''),
(5, 0, 'Chocolates, Café, Bistrô', '5', 4, '', 1, 1, '', '', ''),
(6, 4, 'Camisas', '20', 0, '', 1, 0, '', '', ''),
(7, 4, 'Calças', '21', 0, '', 1, 0, '', '', ''),
(8, 4, 'Shortes', '22', 0, '', 1, 0, '', '', ''),
(9, 4, 'Vestidos', '23', 0, '', 1, 0, '', '', ''),
(10, 4, 'Bermudas', '29', 0, '', 1, 0, '', '', ''),
(11, 4, 'Terno', '35', 0, '', 1, 0, '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_configuracoes`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_configuracoes` (
  `produtosporpagina` int(11) NOT NULL,
  `listasubcategorias` int(11) NOT NULL,
  `produtosporsubcategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `dfs_produtos_configuracoes`
--

INSERT INTO `dfs_produtos_configuracoes` (`produtosporpagina`, `listasubcategorias`, `produtosporsubcategoria`) VALUES
(16, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_cores`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_cores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hexadecimal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_encomenda`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_encomenda` (
  `idproduto` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_marcas`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enderecourl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disponivel` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Fazendo dump de dados para tabela `dfs_produtos_marcas`
--

INSERT INTO `dfs_produtos_marcas` (`id`, `nome`, `url`, `enderecourl`, `descricao`, `imagem`, `disponivel`) VALUES
(3, 'Nautica', '25', '', '', '01.jpg', 1),
(4, '7 Camicie', '26', '', '', '02.png', 1),
(5, 'GUESS Man', '27', '', '', '03.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_opcoes`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_opcoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  `multi` tinyint(1) NOT NULL,
  `filtro` tinyint(1) NOT NULL,
  `aberto` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_opcoes_gerados`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_opcoes_gerados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto` int(11) NOT NULL,
  `opcao` int(11) NOT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_opcoes_valores`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_opcoes_valores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opcao` int(11) NOT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_pedras`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_pedras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_tamanhos`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_tamanhos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_produtos_termos_procurados`
--

CREATE TABLE IF NOT EXISTS `dfs_produtos_termos_procurados` (
  `termo` varchar(50) NOT NULL,
  `contador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_recados`
--

CREATE TABLE IF NOT EXISTS `dfs_recados` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_arquivos_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_arquivos_categorias` (
  `arquivo` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_banners_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_banners_categorias` (
  `banner` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_galerias_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_galerias_categorias` (
  `galeria` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `dfs_relacionamento_galerias_categorias`
--

INSERT INTO `dfs_relacionamento_galerias_categorias` (`galeria`, `categoria`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_musicas_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_musicas_categorias` (
  `musica` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_noticias_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_noticias_categorias` (
  `noticia` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_ofertascoletivas_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_ofertascoletivas_categorias` (
  `ofertacoletiva` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_produtos_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_produtos_categorias` (
  `produto` varchar(20) CHARACTER SET latin1 NOT NULL,
  `categoria` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`produto`,`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `dfs_relacionamento_produtos_categorias`
--

INSERT INTO `dfs_relacionamento_produtos_categorias` (`produto`, `categoria`) VALUES
('14', '10'),
('15', '6'),
('16', '6'),
('17', '6'),
('18', '6');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_produtos_infos`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_produtos_infos` (
  `produto` int(11) NOT NULL,
  `cor` int(11) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `pedra` int(11) NOT NULL,
  `estoque` int(11) NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_relacionamento_slides_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_relacionamento_slides_categorias` (
  `slide` int(11) NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `dfs_relacionamento_slides_categorias`
--

INSERT INTO `dfs_relacionamento_slides_categorias` (`slide`, `categoria`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_slides`
--

CREATE TABLE IF NOT EXISTS `dfs_slides` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `dfs_slides`
--

INSERT INTO `dfs_slides` (`id`, `titulo`, `legenda`, `enderecourl`, `ativo`, `tipo`, `ordem`, `segundos`, `imagem`, `flash`) VALUES
(1, 'Teste', 'Imagem de teste', '', 1, 'Imagem', 0, 5, 'edf33633Banner.png', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_slides_categorias`
--

CREATE TABLE IF NOT EXISTS `dfs_slides_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `dfs_slides_categorias`
--

INSERT INTO `dfs_slides_categorias` (`id`, `titulo`) VALUES
(1, 'Topo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_telefones`
--

CREATE TABLE IF NOT EXISTS `dfs_telefones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ligacao` int(11) DEFAULT NULL,
  `local` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd` int(11) DEFAULT NULL,
  `telefone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ramal` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_textos`
--

CREATE TABLE IF NOT EXISTS `dfs_textos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtitulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `textopequeno` text COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Fazendo dump de dados para tabela `dfs_textos`
--

INSERT INTO `dfs_textos` (`id`, `url`, `titulo`, `subtitulo`, `textopequeno`, `texto`, `imagem`, `ordem`) VALUES
(1, 0, 'Lançamentos', '', '', '', 0, 0),
(2, 0, 'Girafa', 'O dia está chegando', '', '<p style="margin: 0.5em 0px; line-height: 22px; color: rgb(37, 37, 37); font-family: sans-serif; font-size: 14px; text-align: justify;">\r\n	O termo&nbsp;<b>girafa</b>&nbsp;(do&nbsp;<a class="mw-disambig" href="https://pt.wikipedia.org/wiki/%C3%81rabe" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Árabe">&aacute;rabe</a>&nbsp;<i>zarAfa(t)</i>, pelo&nbsp;<a href="https://pt.wikipedia.org/wiki/L%C3%ADngua_italiana" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Língua italiana">italiano</a>&nbsp;<i>giraffa</i>) &eacute; a designa&ccedil;&atilde;o dada a&nbsp;<a href="https://pt.wikipedia.org/wiki/Mam%C3%ADferos" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Mamíferos">mam&iacute;feros</a>&nbsp;<a href="https://pt.wikipedia.org/wiki/Artiod%C3%A1tilos" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Artiodátilos">artiod&aacute;tilos</a>,&nbsp;<a href="https://pt.wikipedia.org/wiki/Ruminantes" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Ruminantes">ruminantes</a>, do g&ecirc;nero&nbsp;<i>Giraffa</i>, da fam&iacute;lia dos giraf&iacute;deos, no qual consta uma &uacute;nica esp&eacute;cie, a&nbsp;<i>Giraffa camelopardalis</i>, ou camelo-leopardo, como eram chamadas pelos&nbsp;<a class="mw-redirect" href="https://pt.wikipedia.org/wiki/Roma_antiga" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Roma antiga">romanos</a>&nbsp;quando elas existiam no norte da&nbsp;<a href="https://pt.wikipedia.org/wiki/%C3%81frica" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="África">&Aacute;frica</a>, pois acreditava-se que vinham de uma mistura de uma&nbsp;<a href="https://pt.wikipedia.org/wiki/F%C3%AAmea" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Fêmea">f&ecirc;mea</a>&nbsp;<a href="https://pt.wikipedia.org/wiki/Camelo" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Camelo">camelo</a>, com um&nbsp;<a href="https://pt.wikipedia.org/wiki/Macho" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Macho">macho</a>&nbsp;<a href="https://pt.wikipedia.org/wiki/Leopardo" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Leopardo">leopardo</a><span style="color: gray;"><span style="line-height: 1; height: 0px; vertical-align: baseline; position: relative; bottom: 1ex;">[</span></span><span style="line-height: 1; height: 0px; vertical-align: baseline; position: relative; bottom: 1ex;"><a href="https://pt.wikipedia.org/wiki/Wikip%C3%A9dia:Livro_de_estilo/Cite_as_fontes" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Wikipédia:Livro de estilo/Cite as fontes"><span title="Esta afirmação precisa de uma referência para confirmá-la."><span style="color: gray;"><i>carece&nbsp;de fontes</i></span></span></a><span style="color: gray;">]</span></span>. S&atilde;o&nbsp;<a class="mw-redirect" href="https://pt.wikipedia.org/wiki/Ungulado" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Ungulado">ungulados</a>&nbsp;com n&uacute;mero par de&nbsp;<a href="https://pt.wikipedia.org/wiki/Dedo" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Dedo">dedos</a>.</p>\r\n<p style="margin: 0.5em 0px; line-height: 22px; color: rgb(37, 37, 37); font-family: sans-serif; font-size: 14px; text-align: justify;">\r\n	As girafas s&atilde;o os &uacute;nicos membros de seu g&ecirc;nero e, juntas com os&nbsp;<a href="https://pt.wikipedia.org/wiki/Ocapi" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Ocapi">ocapis</a>, formam a fam&iacute;lia&nbsp;<a href="https://pt.wikipedia.org/wiki/Giraffidae" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Giraffidae">Giraffidae</a>. Atualmente est&atilde;o listadas nove subesp&eacute;cies de girafa (ver em baixo), diferenciadas pela distribui&ccedil;&atilde;o geogr&aacute;fica e pelo padr&atilde;o das manchas. Essas v&aacute;rias subesp&eacute;cies de girafas agora habitam as terras secas ao sul do&nbsp;<a class="mw-redirect" href="https://pt.wikipedia.org/wiki/Saara" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Saara">Saara</a>. As girafas se distribuem em dois grupos:&nbsp;<a class="new" href="https://pt.wikipedia.org/w/index.php?title=Girafa-do-norte&amp;action=edit&amp;redlink=1" style="text-decoration: none; color: rgb(165, 88, 88); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Girafa-do-norte (página não existe)">girafa-do-norte</a>&nbsp;que s&atilde;o tricornes, isto &eacute;, com um corno nasal interocular e dois frontoparietais, apresentando pelagem predominantemente reticulada; e&nbsp;<a class="new" href="https://pt.wikipedia.org/w/index.php?title=Girafa-do-sul&amp;action=edit&amp;redlink=1" style="text-decoration: none; color: rgb(165, 88, 88); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Girafa-do-sul (página não existe)">girafa-do-sul</a>, sem corno nasal e a pelagem tem predominantemente malhas irregulares.</p>\r\n<p style="margin: 0.5em 0px; line-height: 22px; color: rgb(37, 37, 37); font-family: sans-serif; font-size: 14px; text-align: justify;">\r\n	Os machos chegam a 6&nbsp;<a href="https://pt.wikipedia.org/wiki/Metro" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Metro">metros</a>&nbsp;de altura e com suas&nbsp;<a href="https://pt.wikipedia.org/wiki/L%C3%ADngua" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Língua">l&iacute;nguas</a>&nbsp;pre&ecirc;nseis que alcan&ccedil;am at&eacute; 50&nbsp;<a href="https://pt.wikipedia.org/wiki/Cent%C3%ADmetro" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Centímetro">cent&iacute;metros</a>&nbsp;s&atilde;o capazes de pegar as&nbsp;<a class="mw-redirect" href="https://pt.wikipedia.org/wiki/Folha_(bot%C3%A2nica)" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Folha (botânica)">folhas</a>&nbsp;de&nbsp;<a href="https://pt.wikipedia.org/wiki/Ac%C3%A1cia" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Acácia">ac&aacute;cias</a>, por entre pontiagudos&nbsp;<a href="https://pt.wikipedia.org/wiki/Espinho_(bot%C3%A2nica)" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Espinho (botânica)">espinhos</a>&nbsp;nos altos dos&nbsp;<a href="https://pt.wikipedia.org/wiki/Galho" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Galho">galhos</a>, que s&atilde;o sua principal fonte de&nbsp;<a href="https://pt.wikipedia.org/wiki/Alimenta%C3%A7%C3%A3o" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Alimentação">alimenta&ccedil;&atilde;o</a>. Elas s&atilde;o capazes de comer as folhas das &aacute;rvores at&eacute; 6 metros de altura. Para poderem pastar, t&ecirc;m de afastar uma da outra as pernas dianteiras. Devido ao baixo teor nutritivo das folhas, as girafas precisam comer grandes quantidades e passam quase 20&nbsp;<a href="https://pt.wikipedia.org/wiki/Hora" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Hora">horas</a>&nbsp;por&nbsp;<a href="https://pt.wikipedia.org/wiki/Dia" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Dia">dia</a>comendo. O comprimento do corpo pode ultrapassar os 2,25 metros e ainda possui uma cauda com 80 cent&iacute;metros de comprimento, n&atilde;o contando com o pincel final. O seu peso pode ultrapassar os 500&nbsp;<a href="https://pt.wikipedia.org/wiki/Quilograma" style="text-decoration: none; color: rgb(11, 0, 128); background-image: none; background-position: initial initial; background-repeat: initial initial;" title="Quilograma">quilogramas</a>. Apesar do seu tamanho, a girafa pode atingir a velocidade de 47&nbsp;km/h, suficiente para fugir de seus predadores.</p>\r\n', 40, 0),
(3, 45, 'DFS', 'Conheço mais sobre nós', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_tickets`
--

CREATE TABLE IF NOT EXISTS `dfs_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `nivel` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `satisfacao` int(11) NOT NULL,
  `datahora_criacao` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `datahora_alteracao` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_tickets_postagens`
--

CREATE TABLE IF NOT EXISTS `dfs_tickets_postagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` int(11) NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `arquivo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datahora` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_urls`
--

CREATE TABLE IF NOT EXISTS `dfs_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tabela` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `campo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Fazendo dump de dados para tabela `dfs_urls`
--

INSERT INTO `dfs_urls` (`id`, `url`, `tabela`, `campo`, `valor`) VALUES
(1, 'eletronicos', 'produtos_categorias', 'url', '1'),
(2, 'cosmeticos', 'produtos_categorias', 'url', '2'),
(3, 'pefumes', 'produtos_categorias', 'url', '3'),
(4, 'roupas', 'produtos_categorias', 'url', '4'),
(5, 'chocolates-cafe-bistro', 'produtos_categorias', 'url', '5'),
(20, 'roupas-camisas', 'produtos_categorias', 'url', '6'),
(21, 'roupas-calcas', 'produtos_categorias', 'url', '7'),
(22, 'roupas-shortes', 'produtos_categorias', 'url', '8'),
(23, 'roupas-vestidos', 'produtos_categorias', 'url', '9'),
(25, 'marca-nautica', 'produtos_marcas', 'url', '3'),
(26, 'marca-7-camicie', 'produtos_marcas', 'url', '4'),
(27, 'marca-guess-man', 'produtos_marcas', 'url', '5'),
(28, '14B44000-flat-front-deck-short', 'produtos', 'url', '14'),
(29, 'roupas-bermudas', 'produtos_categorias', 'url', '10'),
(30, '15K52126-chest-stripe-performance-deck-polo-shirt', 'produtos', 'url', '15'),
(31, '16K51236-slim-fit-fish-print-deck-polo-shirt', 'produtos', 'url', '16'),
(32, '174K3903-two-pocket-polo-shirt', 'produtos', 'url', '17'),
(33, '18497-shirt-linda-off-whitebrown', 'produtos', 'url', '18'),
(34, '1951M2001117Z-marciano-python-print-blazer', 'produtos', 'url', '19'),
(35, 'roupas-terno', 'produtos_categorias', 'url', '11'),
(36, 'pontos-turisticos', 'galerias_categorias', 'url', '1'),
(37, '1-las-vegas', 'galerias', 'url', '1'),
(38, '2-opera-house---sydney', 'galerias', 'url', '2'),
(39, '3-seatle', 'galerias', 'url', '3'),
(40, '4-edens-garden', 'galerias', 'url', '4'),
(41, '5-beijing---china', 'galerias', 'url', '5'),
(42, '6-portal-de-brandenburgo---alemanha', 'galerias', 'url', '6'),
(43, '1-lancamentos', 'noticias_categorias', 'url', '1'),
(44, '1-girafa', 'noticias', 'url', '1'),
(45, 'sobre', 'textos', 'url', '3');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_usuarios`
--

CREATE TABLE IF NOT EXISTS `dfs_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` int(11) NOT NULL,
  `nome` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `ensino` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `dfs_usuarios`
--

INSERT INTO `dfs_usuarios` (`id`, `nivel`, `nome`, `login`, `senha`, `imagem`, `texto`, `ensino`) VALUES
(1, 1, 'Marcelo', 'marcelo', '123', '', '', ''),
(2, 1, 'Administrador', 'dfs', '925210', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dfs_vendedores`
--

CREATE TABLE IF NOT EXISTS `dfs_vendedores` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
