-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Mar 11, 2010 as 10:07 AM
-- Versão do Servidor: 5.0.45
-- Versão do PHP: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `os_sac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ajuda`
--

CREATE TABLE `ajuda` (
  `codigo` int(10) unsigned NOT NULL auto_increment,
  `cod_usuario` int(10) unsigned NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `data_cadastro` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `data_atendimento` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `ajuda`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `codigo` int(10) unsigned NOT NULL auto_increment,
  `cod_usuario` int(10) unsigned NOT NULL,
  `data_entrada` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `data_saida` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `log`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `os`
--

CREATE TABLE `os` (
  `codigo` int(10) unsigned NOT NULL auto_increment,
  `cod_usuario` int(10) unsigned NOT NULL,
  `filial` varchar(5) NOT NULL,
  `circuito` varchar(7) default NULL,
  `velocidade` varchar(10) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `data_executou` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `flag_pendencia` int(10) NOT NULL,
  `pendencia` varchar(20) NOT NULL,
  `descricao_pendencia` varchar(200) NOT NULL,
  `flag_objectel` int(10) unsigned NOT NULL,
  `status_objectel` varchar(10) NOT NULL,
  `descricao_objectel` varchar(200) NOT NULL,
  `obs_cadastro_mesma_data` varchar(100) NOT NULL,
  `obs_finalizacao_os` varchar(100) NOT NULL,
  `data_cadastro` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `os`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(10) unsigned NOT NULL auto_increment,
  `TR` varchar(8) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(10) NOT NULL,
  `nivel` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `TR`, `nome`, `senha`, `nivel`) VALUES
(1, 'cptx', 'cptx', 'cptx', 1),
(2, 'CPTX', 'CPTX', 'CPTX', 1);
