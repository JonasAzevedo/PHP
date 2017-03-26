-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema bd_camisetas
--

CREATE DATABASE IF NOT EXISTS bd_camisetas;
USE bd_camisetas;

--
-- Definition of table `avaliacao_produto`
--

DROP TABLE IF EXISTS `avaliacao_produto`;
CREATE TABLE `avaliacao_produto` (
  `idAvaliacaoProduto` int(10) unsigned NOT NULL auto_increment,
  `tipo_produto` varchar(20) NOT NULL,
  `cdFkProduto` int(10) unsigned NOT NULL,
  `cdFkUsuario` int(10) unsigned NOT NULL,
  `avaliacao` int(10) unsigned NOT NULL,
  `data_avaliacao` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`idAvaliacaoProduto`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `avaliacao_produto`
--

/*!40000 ALTER TABLE `avaliacao_produto` DISABLE KEYS */;
INSERT INTO `avaliacao_produto` (`idAvaliacaoProduto`,`tipo_produto`,`cdFkProduto`,`cdFkUsuario`,`avaliacao`,`data_avaliacao`) VALUES 
 (14,'camiseta',9,9,5,'2011-03-18 21:51:44'),
 (15,'camiseta',9,9,5,'2011-03-18 21:51:44'),
 (16,'camiseta',9,9,4,'2011-03-18 21:51:44'),
 (17,'camiseta',9,9,4,'2011-03-18 17:59:14'),
 (18,'camiseta',9,20,1,'2011-03-18 18:15:11'),
 (19,'camiseta',9,18,1,'2011-03-18 18:15:11'),
 (20,'camiseta',9,15,2,'2011-03-18 18:15:11'),
 (21,'camiseta',9,14,2,'2011-03-18 18:15:11'),
 (22,'camiseta',9,12,3,'2011-03-18 18:15:11'),
 (23,'camiseta',9,11,3,'2011-03-18 18:15:11'),
 (24,'camiseta',9,8,4,'2011-03-18 18:15:11'),
 (25,'camiseta',9,7,5,'2011-03-18 18:15:11'),
 (26,'camiseta',9,6,5,'2011-03-18 18:15:11'),
 (27,'camiseta',9,5,5,'2011-03-18 18:15:11'),
 (28,'camiseta',9,1,5,'2011-03-18 18:15:11'),
 (29,'camiseta',9,4,4,'2011-03-18 18:15:11'),
 (30,'camiseta',9,2,4,'2011-03-18 18:15:11'),
 (31,'camiseta',9,3,4,'2011-03-18 18:15:11'),
 (32,'camiseta',9,9,3,'2011-03-18 21:51:44'),
 (33,'camiseta',9,1,5,'2011-03-18 21:52:47'),
 (34,'camiseta',9,1,5,'2011-03-18 21:52:48'),
 (35,'camiseta',9,1,5,'2011-03-18 21:52:49'),
 (36,'camiseta',9,1,5,'2011-03-18 21:52:49'),
 (37,'camiseta',9,1,5,'2011-03-18 21:52:49'),
 (38,'camiseta',9,1,5,'2011-03-18 21:52:49'),
 (39,'camiseta',9,1,5,'2011-03-18 21:52:50'),
 (40,'camiseta',9,1,5,'2011-03-18 21:52:50'),
 (41,'camiseta',9,1,5,'2011-03-18 21:52:50'),
 (42,'camiseta',9,1,5,'2011-03-18 21:52:50'),
 (43,'camiseta',9,1,5,'2011-03-18 21:52:50'),
 (44,'camiseta',9,1,5,'2011-03-18 21:52:51'),
 (45,'camiseta',9,1,5,'2011-03-18 21:52:51'),
 (46,'camiseta',9,1,5,'2011-03-18 21:52:51'),
 (47,'camiseta',9,1,5,'2011-03-18 21:52:51'),
 (48,'camiseta',9,1,5,'2011-03-18 21:53:00'),
 (49,'camiseta',9,1,5,'2011-03-18 21:53:00'),
 (50,'camiseta',9,1,5,'2011-03-18 21:53:00'),
 (51,'camiseta',9,1,5,'2011-03-18 21:53:00'),
 (52,'camiseta',9,1,5,'2011-03-18 21:53:00'),
 (53,'camiseta',9,1,5,'2011-03-18 21:53:01'),
 (54,'camiseta',9,1,5,'2011-03-18 21:53:01'),
 (55,'camiseta',9,1,5,'2011-03-18 21:53:01'),
 (56,'camiseta',9,1,5,'2011-03-18 21:53:01'),
 (57,'camiseta',9,1,5,'2011-03-18 21:53:02'),
 (58,'camiseta',9,1,4,'2011-03-18 21:53:09'),
 (59,'camiseta',9,1,4,'2011-03-18 21:53:09'),
 (60,'camiseta',9,1,4,'2011-03-18 21:53:10'),
 (61,'camiseta',9,1,4,'2011-03-18 21:53:10'),
 (62,'camiseta',9,1,4,'2011-03-18 21:53:11'),
 (63,'camiseta',9,1,4,'2011-03-18 21:53:17'),
 (64,'camiseta',9,1,4,'2011-03-18 21:53:17'),
 (65,'camiseta',9,1,4,'2011-03-18 21:53:17'),
 (66,'camiseta',9,1,4,'2011-03-18 21:53:17'),
 (67,'camiseta',9,1,4,'2011-03-18 21:53:18'),
 (68,'camiseta',9,1,4,'2011-03-18 21:53:18'),
 (69,'camiseta',9,1,3,'2011-03-18 21:53:25'),
 (70,'camiseta',9,1,2,'2011-03-18 21:53:36'),
 (71,'camiseta',5,9,2,'2011-03-21 11:37:37'),
 (72,'camiseta',3,9,5,'2011-03-21 12:08:28'),
 (73,'camiseta',23,9,2,'2011-03-21 12:15:01'),
 (74,'camiseta',8,9,4,'2011-03-21 12:17:29'),
 (75,'camiseta',2,9,2,'2011-03-21 14:17:48'),
 (76,'camiseta',4,9,1,'2011-03-21 14:18:01'),
 (77,'camiseta',7,9,3,'2011-03-21 17:21:32'),
 (78,'camiseta',1,9,2,'2011-03-24 10:04:27');
/*!40000 ALTER TABLE `avaliacao_produto` ENABLE KEYS */;


--
-- Definition of table `camiseta`
--

DROP TABLE IF EXISTS `camiseta`;
CREATE TABLE `camiseta` (
  `cdCamiseta` int(10) unsigned NOT NULL auto_increment,
  `cdFkSubGrupo` int(10) unsigned NOT NULL,
  `nome` varchar(50) NOT NULL,
  `valor` double NOT NULL,
  `desconto` double default NULL,
  `flAtivo` varchar(1) NOT NULL,
  `descricao` varchar(200) default NULL,
  `peso` double NOT NULL,
  PRIMARY KEY  (`cdCamiseta`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `camiseta`
--

/*!40000 ALTER TABLE `camiseta` DISABLE KEYS */;
INSERT INTO `camiseta` (`cdCamiseta`,`cdFkSubGrupo`,`nome`,`valor`,`desconto`,`flAtivo`,`descricao`,`peso`) VALUES 
 (1,2,'ACDC',31,2,'S','Camiseta raglan cinza , com costura de arremate vivo , 100% algodão.',300),
 (2,8,'Bob Marley',29.5,0,'S','Camiseta básica, preta, 100% algodão.',300),
 (3,8,'Bob Marley',27,0,'S','Camiseta branca, punho da gola e mangas pretas, 100% algodão.',300),
 (4,12,'Yes',26.45,0,'S','Camiseta básica preta 100% algodão.',300),
 (5,3,'Deep Purple',29,1.2,'S','Camiseta básica preta.',300),
 (6,5,'Led Zeppelin',22,0,'S','Camiseta básica, preta,100% algodão.',300),
 (7,5,'Led Zeppelin',28.6,0,'S','Camiseta com tingimento especial cinza , costura de arremate vivo , 100% algodão.',300),
 (8,13,'Rush',33,2.45,'S','Camiseta básica, preta,100% algodão.',300),
 (9,14,'Nirvana',25,0,'S','Camiseta básica preta 100% algodão.',300),
 (10,15,'Jimi Hendrix',22,0,'S','Camiseta básica, preta,100% algodão.',300),
 (11,16,'Janis Joplin',28,0,'S','Camiseta básica, preta,100% algodão.',300),
 (12,17,'Lynyr Skynyrd ',35,0,'S','Camiseta básica preta, 100% algodão.',300),
 (13,18,'Elvis Presley',31,0,'S','Camiseta básica preta, 100% algodão.',300),
 (14,19,'Ramones',32,0,'S','Camiseta básica preta, 100% algodão.',300),
 (15,19,'Ramones',26,0,'S','Camiseta básica, branca,100% algodão.',300),
 (16,19,'Ramones',38.5,2.5,'S','camiseta cinza ,com costura de arremate vivo , 100% algodão.',300),
 (17,20,'Iron Maiden',23.6,0,'S','Camiseta básica, branca,100% algodão.',300),
 (18,21,'Metallica',26,1.5,'S','Camiseta básica preta, 100% algodão.',300),
 (19,22,'The Doors',28,0,'S','Camiseta básica preta 100% algodão.',300),
 (20,4,'Pink Floyd - The Wall',29,2,'S','camiseta básica branca,100% algodão.',300),
 (21,23,'Ozzy Osbourne',32,3,'S','Camiseta básica, preta.',300),
 (22,6,'Rolling Stones',26,0,'S','Camiseta básica branca 100% algodão.',300),
 (23,7,'The Who',23,0,'S','Camiseta básica grafite, 100% algodão.',300),
 (24,10,'Simpsons',26,0,'S',NULL,300);
/*!40000 ALTER TABLE `camiseta` ENABLE KEYS */;


--
-- Definition of table `configuracoes_sistema`
--

DROP TABLE IF EXISTS `configuracoes_sistema`;
CREATE TABLE `configuracoes_sistema` (
  `cdConfiguracoesSistema` int(10) unsigned NOT NULL auto_increment,
  `cep_origem` varchar(8) NOT NULL,
  PRIMARY KEY  USING BTREE (`cdConfiguracoesSistema`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuracoes_sistema`
--

/*!40000 ALTER TABLE `configuracoes_sistema` DISABLE KEYS */;
INSERT INTO `configuracoes_sistema` (`cdConfiguracoesSistema`,`cep_origem`) VALUES 
 (1,'89665000');
/*!40000 ALTER TABLE `configuracoes_sistema` ENABLE KEYS */;


--
-- Definition of table `email_enviado`
--

DROP TABLE IF EXISTS `email_enviado`;
CREATE TABLE `email_enviado` (
  `cdEmailEnviado` int(10) unsigned NOT NULL auto_increment,
  `tipo_envio` varchar(30) NOT NULL,
  `servidor_host` varchar(100) default NULL,
  `servidor_porta` int(10) unsigned default NULL,
  `servidor_username` varchar(50) default NULL,
  `servidor_password` varchar(50) default NULL,
  `remetente_from` varchar(100) NOT NULL,
  `remetente_from_name` varchar(100) default NULL,
  `destinatario_cdUsuario` int(10) unsigned default NULL,
  `destinatario_email_destinatario` varchar(100) NOT NULL,
  `destinatario_nome_destinatario` varchar(100) default NULL,
  `destinatario_email_destinatariocc` varchar(100) default NULL,
  `destinatario_nome_destinatariocc` varchar(100) default NULL,
  `destinatario_email_destinatariocco` varchar(100) default NULL,
  `destinatario_nome_destinatariocco` varchar(100) default NULL,
  `mensagem_assunto` varchar(200) NOT NULL,
  `mensagem_html` varchar(3) NOT NULL,
  `mensagem_body` blob,
  `anexo` varchar(2000) default NULL,
  `enviado` varchar(3) NOT NULL,
  PRIMARY KEY  (`cdEmailEnviado`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_enviado`
--

/*!40000 ALTER TABLE `email_enviado` DISABLE KEYS */;
INSERT INTO `email_enviado` (`cdEmailEnviado`,`tipo_envio`,`servidor_host`,`servidor_porta`,`servidor_username`,`servidor_password`,`remetente_from`,`remetente_from_name`,`destinatario_cdUsuario`,`destinatario_email_destinatario`,`destinatario_nome_destinatario`,`destinatario_email_destinatariocc`,`destinatario_nome_destinatariocc`,`destinatario_email_destinatariocco`,`destinatario_nome_destinatariocco`,`mensagem_assunto`,`mensagem_html`,`mensagem_body`,`anexo`,`enviado`) VALUES 
 (3,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'jonassazevedo@hotmail.com','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20323C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (4,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'jonassazevedo@hotmail.com','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20323C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (5,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20343C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (6,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20343C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (7,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20343C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (8,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20343C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (9,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20343C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (10,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20343C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (11,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20343C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (12,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20353C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (13,'indicar_produto','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',0,'','','','','ubanoide@gmail.com','Ubanoide','Indicar produto','sim',0x4F2070726F6475746F20666F6920696E64696361646F20706172612076633C6272202F3E5449504F5F50524F4455544F203D2063616D69736574613C6272202F3E43445F50524F4455544F203D20353C6272202F3E3C6120687265663D27687474703A2F2F6C6F63616C686F73742F56454E44415F43414D4953455441273E4163657373652061676F7261206F20736974653C2F613E,'','sim'),
 (14,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','não'),
 (15,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','não'),
 (16,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','não'),
 (17,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','não'),
 (18,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim'),
 (19,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim'),
 (20,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim'),
 (21,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim'),
 (22,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim'),
 (23,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim'),
 (24,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim'),
 (25,'recuperar_senha','smtp.gmail.com',465,'bugrii@gmail.com','qwe370268','bugrii@gmail.com','Jonas',9,'ajonassazevedo@hotmail.com','j','','','ubanoide@gmail.com','Ubanoide','Sua Senha no Midwest.','sim',0x5072657A61646F206A6F6A6F2C203C6272202F3E436F6E666F726D652073756120736F6C6963697461E7E36F2064652072656375706572617220612073656E686120706172612061636573736F20616F204D6964776573742C20656E7669616D6F732073657573206461646F732064652061636573736F206E6F76616D656E74652E3C6272202F3E3C6272202F3E557375E172696F3A206C6F67696E3C6272202F3E53656E68613A2061736466673C6272202F3E3C6272202F3E456D206361736F2064652064FA766964617320656E74726520656D20636F6E7461746F20656D206E6F7373612043656E7472616C206465204174656E64696D656E746F20706F7220652D6D61696C2C2063686174206F752074656C65666F6E652E3C6272202F3E4174656E63696F73616D656E74652C3C6272202F3E457175697065204D696477657374,'','sim');
/*!40000 ALTER TABLE `email_enviado` ENABLE KEYS */;


--
-- Definition of table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `cdGrupo` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY  (`cdGrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo`
--

/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` (`cdGrupo`,`nome`) VALUES 
 (1,'Rock'),
 (2,'Reggae'),
 (3,'Desenho Animado');
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;


--
-- Definition of table `imagem_camiseta`
--

DROP TABLE IF EXISTS `imagem_camiseta`;
CREATE TABLE `imagem_camiseta` (
  `cdImagemCamiseta` int(10) unsigned NOT NULL auto_increment,
  `cdFkCamiseta` int(10) unsigned NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `nome` varchar(20) default NULL,
  `is_principal` varchar(1) NOT NULL,
  `descricao` varchar(200) default NULL,
  PRIMARY KEY  (`cdImagemCamiseta`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imagem_camiseta`
--

/*!40000 ALTER TABLE `imagem_camiseta` DISABLE KEYS */;
INSERT INTO `imagem_camiseta` (`cdImagemCamiseta`,`cdFkCamiseta`,`imagem`,`nome`,`is_principal`,`descricao`) VALUES 
 (1,1,'./figuras_produto/acdc1_frente.jpg','frente','S',NULL),
 (2,1,'./figuras_produto/acdc1_costas.jpg','costas','N',NULL),
 (3,1,'./figuras_produto/acdc1_comp.jpg','frente X','N',NULL),
 (4,2,'./figuras_produto/bobmarley1_frente.jpg','frente','S',NULL),
 (5,2,'./figuras_produto/bobmarley1_costas.jpg','costas','N',NULL),
 (6,2,'complemento',NULL,'N',NULL),
 (7,3,'./figuras_produto/bobmarley2_frente.jpg','frente','S',NULL),
 (8,3,'complemento',NULL,'N',NULL),
 (9,3,'complemento',NULL,'N',NULL),
 (10,4,'./figuras_produto/yes1_frente.jpg','frente','S',NULL),
 (11,4,'./figuras_produto/yes1_costas.jpg','costas','N',NULL),
 (12,5,'./figuras_produto/deeppurple1_frente.jpg','frente','S',NULL),
 (13,5,'./figuras_produto/deeppurple1_costas.jpg','costas','N',NULL),
 (14,6,'./figuras_produto/ledzeppelin1_frente.jpg','frente','S',NULL),
 (15,6,'./figuras_produto/ledzeppelin1_costas.jpg','costas','N',NULL),
 (16,6,'complemento',NULL,'N',NULL),
 (17,4,'complemento',NULL,'N',NULL),
 (18,5,'complemento',NULL,'N',NULL),
 (19,7,'./figuras_produto/ledzeppelin2_frente.jpg','frente','S',NULL),
 (20,7,'./figuras_produto/ledzeppelin2_costas.jpg','costas','N',NULL),
 (21,7,'complemento',NULL,'N',NULL),
 (22,8,'./figuras_produto/rush1_frente.jpg','frente','S',NULL),
 (23,8,'./figuras_produto/rush1_costas.jpg','costas','N',NULL),
 (24,8,'complemento',NULL,'N',NULL),
 (25,9,'./figuras_produto/nirvana1_frente.jpg','frente','S',NULL),
 (26,9,'./figuras_produto/nirvana1_costas.jpg','costas','N',NULL),
 (27,9,'complemento',NULL,'N',NULL),
 (28,10,'./figuras_produto/jimihendrix1_frente.jpg','frente','S',NULL),
 (29,10,'./figuras_produto/jimihendrix1_costas.jpg','costas','N',NULL),
 (30,10,'complemento',NULL,'N',NULL),
 (31,11,'./figuras_produto/janisjoplin1_frente.jpg','frente','S',NULL),
 (32,11,'./figuras_produto/janisjoplin1_costas.jpg','costas','N',NULL),
 (33,11,'complemento',NULL,'N',NULL),
 (34,12,'./figuras_produto/lynyrdskynyrd1_frente.jpg','frente','S',NULL),
 (35,12,'./figuras_produto/lynyrdskynyrd1_costas.jpg','costas','N',NULL),
 (36,12,'complemento',NULL,'N',NULL),
 (37,13,'./figuras_produto/elvispresley1_frente.jpg','frente','S',NULL),
 (38,13,'./figuras_produto/elvispresley1_costas.jpg','costas','N',NULL),
 (39,13,'complemento',NULL,'N',NULL),
 (40,14,'./figuras_produto/ramones1_frente.jpg','frente','S',NULL),
 (41,14,'./figuras_produto/ramones1_costas.jpg','costas','N',NULL),
 (42,14,'complemento',NULL,'N',NULL),
 (43,15,'./figuras_produto/ramones2_frente.jpg','frente','S',NULL),
 (44,15,'./figuras_produto/ramones2_costas.jpg','costas','N',NULL),
 (45,15,'complemento',NULL,'N',NULL),
 (46,16,'./figuras_produto/ramones3_frente.jpg','frente','S',NULL),
 (47,16,'./figuras_produto/ramones3_costas.jpg','costas','N',NULL),
 (48,16,'complemento',NULL,'N',NULL),
 (49,17,'./figuras_produto/ironmaiden1_frente.jpg','frente','S',NULL),
 (50,17,'./figuras_produto/ironmaiden1_costas.jpg','costas','N',NULL),
 (51,17,'complemento',NULL,'N',NULL),
 (52,18,'./figuras_produto/metallica1_frente.jpg','frente','S',NULL),
 (53,18,'./figuras_produto/metallica1_costas.jpg','costas','N',NULL),
 (54,18,'complemento',NULL,'N',NULL),
 (55,19,'./figuras_produto/thedoors1_frente.jpg','frente','S',NULL),
 (56,19,'./figuras_produto/thedoors1_costas.jpg','costas','N',NULL),
 (57,19,'complemento',NULL,'N',NULL),
 (58,20,'./figuras_produto/pinkfloyd1_frente.jpg','frente','S',NULL),
 (59,20,'./figuras_produto/pinkfloyd1_costas.jpg','costas','N',NULL),
 (60,20,'complemento',NULL,'N',NULL),
 (61,21,'./figuras_produto/ozzy1_frente.jpg','frente','S',NULL),
 (62,21,'./figuras_produto/ozzy1_costas.jpg','costas','N',NULL),
 (63,21,'complemento',NULL,'N',NULL),
 (64,22,'./figuras_produto/rollingstones1_frente.jpg','frente','S',NULL),
 (65,22,'complemento',NULL,'N',NULL),
 (66,22,'complemento',NULL,'N',NULL),
 (67,23,'./figuras_produto/thewho1_frente.jpg','frente','S',NULL),
 (68,23,'complemento',NULL,'N',NULL),
 (69,23,'complemento',NULL,'N',NULL),
 (70,24,'complemento',NULL,'S',NULL),
 (71,24,'complemento',NULL,'N',NULL),
 (72,24,'complemento',NULL,'N',NULL);
/*!40000 ALTER TABLE `imagem_camiseta` ENABLE KEYS */;


--
-- Definition of table `item_pedido_compra`
--

DROP TABLE IF EXISTS `item_pedido_compra`;
CREATE TABLE `item_pedido_compra` (
  `cdItemPedidoCompra` int(10) unsigned NOT NULL auto_increment,
  `cdFkPedidoCompra` int(10) unsigned NOT NULL,
  `tipo_produto` varchar(20) NOT NULL,
  `cdFkProduto` int(10) unsigned NOT NULL,
  `quantidade` int(10) unsigned NOT NULL,
  `valor_unitario` double NOT NULL,
  `valor_total` double NOT NULL,
  `status` varchar(20) NOT NULL,
  `tamanho_camiseta` varchar(5) default NULL,
  PRIMARY KEY  (`cdItemPedidoCompra`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_pedido_compra`
--

/*!40000 ALTER TABLE `item_pedido_compra` DISABLE KEYS */;
INSERT INTO `item_pedido_compra` (`cdItemPedidoCompra`,`cdFkPedidoCompra`,`tipo_produto`,`cdFkProduto`,`quantidade`,`valor_unitario`,`valor_total`,`status`,`tamanho_camiseta`) VALUES 
 (65,11,'camiseta',6,1,22,22,'aberto','P'),
 (66,12,'camiseta',7,1,28.6,28.6,'aberto','G'),
 (67,13,'camiseta',8,1,30.55,30.55,'aberto','M'),
 (68,14,'camiseta',8,1,30.55,30.55,'aberto','M'),
 (69,14,'camiseta',1,1,29,29,'aberto','M'),
 (70,14,'camiseta',9,1,25,25,'aberto','M'),
 (71,14,'camiseta',8,1,30.55,30.55,'aberto','M'),
 (72,14,'camiseta',6,1,22,22,'aberto','M'),
 (73,14,'camiseta',3,1,27,27,'aberto','M'),
 (74,14,'camiseta',5,1,27.8,27.8,'aberto','M'),
 (75,14,'camiseta',4,1,26.45,26.45,'aberto','M'),
 (76,14,'camiseta',7,1,28.6,28.6,'aberto','M'),
 (77,14,'camiseta',5,1,27.8,27.8,'aberto','M'),
 (78,14,'camiseta',15,1,26,26,'aberto','M'),
 (79,14,'camiseta',12,1,35,35,'aberto','M'),
 (80,14,'camiseta',13,1,31,31,'aberto','M'),
 (81,14,'camiseta',18,1,24.5,24.5,'aberto','M'),
 (82,14,'camiseta',10,1,22,22,'aberto','M'),
 (83,14,'camiseta',16,1,36,36,'aberto','M'),
 (84,14,'camiseta',11,1,28,28,'aberto','M'),
 (85,14,'camiseta',14,1,32,32,'aberto','M'),
 (86,14,'camiseta',17,1,23.6,23.6,'aberto','M'),
 (87,14,'camiseta',19,1,28,28,'aberto','M'),
 (88,14,'camiseta',22,1,26,26,'aberto','M'),
 (89,14,'camiseta',20,1,27,27,'aberto','M'),
 (90,14,'camiseta',23,1,23,23,'aberto','M'),
 (91,16,'camiseta',21,1,29,29,'aberto','M'),
 (92,16,'camiseta',9,1,25,25,'aberto','P'),
 (93,16,'camiseta',9,1,25,25,'aberto','P'),
 (94,17,'camiseta',3,1,27,27,'aberto','P'),
 (95,17,'camiseta',7,1,28.6,28.6,'aberto','P'),
 (96,17,'camiseta',0,1,0,0,'aberto','G'),
 (97,17,'camiseta',6,1,22,22,'aberto','G'),
 (98,17,'camiseta',8,1,30.55,30.55,'aberto','G'),
 (99,17,'camiseta',7,1,28.6,28.6,'aberto','P'),
 (100,17,'camiseta',2,1,29.5,29.5,'aberto','P'),
 (101,17,'camiseta',4,1,26.45,26.45,'aberto','G'),
 (102,18,'camiseta',8,1,30.55,30.55,'aberto','P'),
 (103,19,'camiseta',9,1,25,25,'aberto','P'),
 (104,19,'camiseta',9,1,25,25,'aberto','P'),
 (105,19,'camiseta',1,1,29,29,'aberto','P'),
 (106,19,'camiseta',3,1,27,27,'aberto','P'),
 (107,19,'camiseta',8,1,30.55,30.55,'aberto','P'),
 (108,19,'camiseta',5,1,27.8,27.8,'aberto','P'),
 (109,19,'camiseta',2,1,29.5,29.5,'aberto','P'),
 (110,19,'camiseta',5,1,27.8,27.8,'aberto','P'),
 (111,19,'camiseta',9,1,25,25,'aberto','P'),
 (112,19,'camiseta',9,1,25,25,'aberto','P'),
 (113,19,'camiseta',8,1,30.55,30.55,'aberto','P'),
 (114,19,'camiseta',4,1,26.45,26.45,'aberto','P'),
 (115,19,'camiseta',7,1,28.6,28.6,'aberto','P'),
 (116,19,'camiseta',2,1,29.5,29.5,'aberto','P'),
 (117,19,'camiseta',1,1,29,29,'aberto','P'),
 (118,19,'camiseta',7,1,28.6,28.6,'aberto','P'),
 (119,19,'camiseta',1,1,29,29,'aberto','P'),
 (120,19,'camiseta',9,1,25,25,'aberto','P'),
 (121,19,'camiseta',4,1,26.45,26.45,'aberto','P'),
 (122,19,'camiseta',3,1,27,27,'aberto','P'),
 (123,19,'camiseta',3,1,27,27,'aberto','P'),
 (124,19,'camiseta',5,166,27.8,4614.8,'aberto','P'),
 (125,20,'camiseta',3,1,27,27,'aberto','P'),
 (126,20,'camiseta',4,1,26.45,26.45,'aberto','G');
/*!40000 ALTER TABLE `item_pedido_compra` ENABLE KEYS */;


--
-- Definition of table `log_login_usuario`
--

DROP TABLE IF EXISTS `log_login_usuario`;
CREATE TABLE `log_login_usuario` (
  `cdLogLoginUsuario` int(10) unsigned NOT NULL auto_increment,
  `cdFkUsuario` int(10) unsigned default NULL,
  `data_entrada` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `data_saida` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`cdLogLoginUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_login_usuario`
--

/*!40000 ALTER TABLE `log_login_usuario` DISABLE KEYS */;
INSERT INTO `log_login_usuario` (`cdLogLoginUsuario`,`cdFkUsuario`,`data_entrada`,`data_saida`) VALUES 
 (1,7,'2011-03-15 15:42:06','2011-03-15 15:42:06'),
 (2,7,'2011-03-15 15:58:25','2011-03-15 15:58:25'),
 (3,7,'2011-03-15 16:46:27','2011-03-15 16:46:27'),
 (4,7,'2011-03-16 11:25:56','0000-00-00 00:00:00'),
 (5,9,'2011-03-18 15:52:43','0000-00-00 00:00:00'),
 (6,9,'2011-03-18 17:59:30','2011-03-18 17:59:30'),
 (7,9,'2011-03-18 18:56:08','2011-03-18 18:56:08'),
 (8,9,'2011-03-21 09:55:49','2011-03-21 09:55:49'),
 (9,9,'2011-03-21 10:31:31','2011-03-21 10:31:31'),
 (10,9,'2011-03-21 17:25:55','2011-03-21 17:25:55'),
 (11,9,'2011-03-21 17:26:27','0000-00-00 00:00:00'),
 (12,9,'2011-03-24 10:04:03','0000-00-00 00:00:00'),
 (13,9,'2011-03-27 15:30:09','0000-00-00 00:00:00'),
 (14,9,'2011-03-27 20:51:21','2011-03-27 20:51:21'),
 (15,9,'2011-03-27 21:07:59','2011-03-27 21:07:59'),
 (16,9,'2011-03-27 22:05:08','2011-03-27 22:05:08'),
 (17,9,'2011-03-27 22:08:07','2011-03-27 22:08:07'),
 (18,9,'2011-03-27 22:08:52','2011-03-27 22:08:52'),
 (19,9,'2011-03-27 22:13:00','2011-03-27 22:13:00'),
 (20,9,'2011-03-27 22:22:04','2011-03-27 22:22:04'),
 (21,9,'2011-03-27 22:23:25','2011-03-27 22:23:25'),
 (22,9,'2011-03-28 09:22:37','2011-03-28 09:22:37'),
 (23,9,'2011-03-28 09:41:41','2011-03-28 09:41:41'),
 (24,9,'2011-03-28 09:42:46','2011-03-28 09:42:46'),
 (25,9,'2011-03-28 10:26:32','2011-03-28 10:26:32'),
 (26,9,'2011-03-28 10:34:19','2011-03-28 10:34:19'),
 (27,9,'2011-03-28 11:06:22','2011-03-28 11:06:22'),
 (28,9,'2011-03-28 11:06:50','0000-00-00 00:00:00'),
 (29,9,'2011-03-28 14:11:50','2011-03-28 14:11:50'),
 (30,9,'2011-03-28 14:12:21','0000-00-00 00:00:00'),
 (31,9,'2011-03-28 18:11:12','0000-00-00 00:00:00'),
 (32,9,'2011-03-29 09:34:00','0000-00-00 00:00:00'),
 (33,9,'2011-04-01 09:08:34','0000-00-00 00:00:00'),
 (34,9,'2011-04-04 09:55:09','0000-00-00 00:00:00'),
 (35,9,'2011-04-04 15:43:48','2011-04-04 15:43:48'),
 (36,9,'2011-04-04 16:56:08','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `log_login_usuario` ENABLE KEYS */;


--
-- Definition of table `log_usuario`
--

DROP TABLE IF EXISTS `log_usuario`;
CREATE TABLE `log_usuario` (
  `cdLogUsuario` int(10) unsigned NOT NULL auto_increment,
  `cdFkUsuario` int(10) unsigned NOT NULL,
  `cdFkCamiseta` int(10) unsigned default NULL,
  `acao` varchar(50) NOT NULL,
  `data_log` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`cdLogUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_usuario`
--

/*!40000 ALTER TABLE `log_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_usuario` ENABLE KEYS */;


--
-- Definition of table `pedido_compra`
--

DROP TABLE IF EXISTS `pedido_compra`;
CREATE TABLE `pedido_compra` (
  `cdPedidoCompra` int(10) unsigned NOT NULL auto_increment,
  `cdFkUsuario` int(10) unsigned NOT NULL,
  `data_hora_inicio` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `data_hora_finalizacao` timestamp NOT NULL default '0000-00-00 00:00:00',
  `valor_total` double default NULL,
  `status` varchar(20) NOT NULL,
  `descricao` varchar(200) default NULL,
  `endereco_entrega_uf` varchar(2) default NULL,
  `endereco_entrega_cidade` varchar(100) default NULL,
  `endereco_entrega_cep` varchar(9) default NULL,
  `endereco_entrega_bairro` varchar(100) default NULL,
  `endereco_entrega_rua` varchar(100) default NULL,
  `endereco_entrega_numero` varchar(20) default NULL,
  `endereco_entrega_complemento` varchar(200) default NULL,
  `tipo_frete` varchar(20) default NULL,
  `valor_frete` double default NULL,
  PRIMARY KEY  (`cdPedidoCompra`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedido_compra`
--

/*!40000 ALTER TABLE `pedido_compra` DISABLE KEYS */;
INSERT INTO `pedido_compra` (`cdPedidoCompra`,`cdFkUsuario`,`data_hora_inicio`,`data_hora_finalizacao`,`valor_total`,`status`,`descricao`,`endereco_entrega_uf`,`endereco_entrega_cidade`,`endereco_entrega_cep`,`endereco_entrega_bairro`,`endereco_entrega_rua`,`endereco_entrega_numero`,`endereco_entrega_complemento`,`tipo_frete`,`valor_frete`) VALUES 
 (11,9,'2011-03-28 11:06:10','0000-00-00 00:00:00',NULL,'aberto',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (12,9,'2011-03-28 11:07:07','0000-00-00 00:00:00',NULL,'aberto',NULL,'ss','czal','111wqsasa','a','s','','',NULL,NULL),
 (13,9,'2011-03-28 14:01:12','0000-00-00 00:00:00',NULL,'aberto',NULL,'ss','czal','23232-312','a','s','','',NULL,NULL),
 (14,9,'2011-03-28 14:48:15','0000-00-00 00:00:00',NULL,'aberto',NULL,'ss','czal','23232-312','a','s','','',NULL,NULL),
 (15,9,'2011-03-28 18:11:12','0000-00-00 00:00:00',NULL,'aberto',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (16,9,'2011-03-29 13:41:12','0000-00-00 00:00:00',NULL,'aberto',NULL,'ss','czal','89663000','a','s','','',NULL,NULL),
 (17,9,'2011-04-01 22:19:41','0000-00-00 00:00:00',NULL,'aberto',NULL,'ss','czal','23232-312','a','s','','','SEDEX',13.4),
 (18,9,'2011-04-04 09:55:23','0000-00-00 00:00:00',NULL,'aberto',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'PAC',11.5),
 (19,9,'2011-04-04 15:25:58','0000-00-00 00:00:00',NULL,'aberto',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (20,0,'2011-08-21 20:16:32','0000-00-00 00:00:00',NULL,'aberto',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `pedido_compra` ENABLE KEYS */;


--
-- Definition of table `produto_destaque`
--

DROP TABLE IF EXISTS `produto_destaque`;
CREATE TABLE `produto_destaque` (
  `cdProdutoDestaque` int(10) unsigned NOT NULL auto_increment,
  `cdFkCamiseta` int(10) unsigned NOT NULL,
  `flAtivo` varchar(1) NOT NULL,
  `data_expira` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `imagem` varchar(100) NOT NULL,
  `nome` varchar(20) default NULL,
  PRIMARY KEY  (`cdProdutoDestaque`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produto_destaque`
--

/*!40000 ALTER TABLE `produto_destaque` DISABLE KEYS */;
INSERT INTO `produto_destaque` (`cdProdutoDestaque`,`cdFkCamiseta`,`flAtivo`,`data_expira`,`imagem`,`nome`) VALUES 
 (1,1,'S','2011-04-25 09:15:39','./figuras_produto/figura_teste.jpg',NULL),
 (2,8,'S','2011-04-25 10:52:09','./figuras_produto/rush1_frente.jpg','Rush');
/*!40000 ALTER TABLE `produto_destaque` ENABLE KEYS */;


--
-- Definition of table `sub_grupo`
--

DROP TABLE IF EXISTS `sub_grupo`;
CREATE TABLE `sub_grupo` (
  `cdSubGrupo` int(10) unsigned NOT NULL auto_increment,
  `cdFkGrupo` int(10) unsigned NOT NULL,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY  (`cdSubGrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_grupo`
--

/*!40000 ALTER TABLE `sub_grupo` DISABLE KEYS */;
INSERT INTO `sub_grupo` (`cdSubGrupo`,`cdFkGrupo`,`nome`) VALUES 
 (1,1,'Beatles'),
 (2,1,'ACDC'),
 (3,1,'Deep Purple'),
 (4,1,'Pink Floyd'),
 (5,1,'Led Zeppelin'),
 (6,1,'Rolling Stones'),
 (7,1,'The Who'),
 (8,2,'Bob Marley'),
 (9,2,'Peter Tosh'),
 (10,3,'Simpsons'),
 (11,3,'Bob Esponja'),
 (12,1,'Yes'),
 (13,1,'Rush'),
 (14,1,'Nirvana'),
 (15,1,'Jimi Hendrix'),
 (16,1,'Janis Joplin'),
 (17,1,'Lynyr Skynyrd '),
 (18,1,'Elvis Presley'),
 (19,1,'Ramones'),
 (20,1,'Iron Maiden'),
 (21,1,'Metallica'),
 (22,1,'The Doors'),
 (23,1,'Ozzy Osbourne');
/*!40000 ALTER TABLE `sub_grupo` ENABLE KEYS */;


--
-- Definition of table `tamanho_camiseta`
--

DROP TABLE IF EXISTS `tamanho_camiseta`;
CREATE TABLE `tamanho_camiseta` (
  `cdTamanhoCamiseta` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(20) NOT NULL,
  `largura` decimal(10,0) default NULL,
  `altura` decimal(10,0) default NULL,
  `sigla` varchar(5) NOT NULL,
  PRIMARY KEY  (`cdTamanhoCamiseta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tamanho_camiseta`
--

/*!40000 ALTER TABLE `tamanho_camiseta` DISABLE KEYS */;
INSERT INTO `tamanho_camiseta` (`cdTamanhoCamiseta`,`nome`,`largura`,`altura`,`sigla`) VALUES 
 (1,'pequeno',NULL,NULL,'P'),
 (2,'médio',NULL,NULL,'M'),
 (3,'grande',NULL,NULL,'G'),
 (4,'grande²',NULL,NULL,'GG');
/*!40000 ALTER TABLE `tamanho_camiseta` ENABLE KEYS */;


--
-- Definition of table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `cdUsuario` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date default NULL,
  `sexo` varchar(9) default NULL,
  `endereco_uf` varchar(2) default NULL,
  `endereco_cidade` varchar(100) default NULL,
  `endereco_cep` varchar(9) default NULL,
  `endereco_bairro` varchar(100) default NULL,
  `endereco_rua` varchar(100) default NULL,
  `endereco_numero` varchar(20) default NULL,
  `endereco_complemento` varchar(200) default NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) default NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `nome_chamado` varchar(25) NOT NULL,
  `data_cadastro` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`cdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`cdUsuario`,`nome`,`data_nascimento`,`sexo`,`endereco_uf`,`endereco_cidade`,`endereco_cep`,`endereco_bairro`,`endereco_rua`,`endereco_numero`,`endereco_complemento`,`email`,`telefone`,`login`,`senha`,`nome_chamado`,`data_cadastro`) VALUES 
 (9,'jojo','0000-00-00','Masculino','ss','czal','23232-312','a','s','','','ajonassazevedo@hotmail.com','','login','asdfg','j','2011-03-28 14:01:12');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
