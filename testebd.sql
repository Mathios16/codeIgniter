-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Nov-2023 às 16:01
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `testebd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle_sessoes`
--

CREATE TABLE `controle_sessoes` (
  `cts_id` int(11) NOT NULL,
  `cts_tabela` varchar(40) NOT NULL,
  `cts_usu_chave` varchar(30) NOT NULL,
  `cts_usu_id` int(11) NOT NULL,
  `cts_status` varchar(3) NOT NULL DEFAULT 'usu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tentativas`
--

CREATE TABLE `tentativas` (
  `tnt_id` int(11) NOT NULL,
  `tnt_num` int(2) NOT NULL,
  `tnt_tabela` varchar(40) NOT NULL,
  `tnt_tempo` int(11) DEFAULT NULL,
  `tnt_num_esperas` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tentativas`
--

INSERT INTO `tentativas` (`tnt_id`, `tnt_num`, `tnt_tabela`, `tnt_tempo`, `tnt_num_esperas`) VALUES
(1, 2, 'testesession', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `testesession`
--

CREATE TABLE `testesession` (
  `tsn_id` int(11) NOT NULL,
  `tsn_nome` varchar(50) NOT NULL,
  `tsn_senha` varchar(30) NOT NULL,
  `tsn_email` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `testesession`
--

INSERT INTO `testesession` (`tsn_id`, `tsn_nome`, `tsn_senha`, `tsn_email`) VALUES
(1, 'matheus', '123', 'math@e'),
(2, 'ma2', '321', 'mat@h');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `controle_sessoes`
--
ALTER TABLE `controle_sessoes`
  ADD PRIMARY KEY (`cts_id`);

--
-- Índices para tabela `tentativas`
--
ALTER TABLE `tentativas`
  ADD PRIMARY KEY (`tnt_id`);

--
-- Índices para tabela `testesession`
--
ALTER TABLE `testesession`
  ADD PRIMARY KEY (`tsn_id`),
  ADD UNIQUE KEY `tsn_senha` (`tsn_senha`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `controle_sessoes`
--
ALTER TABLE `controle_sessoes`
  MODIFY `cts_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tentativas`
--
ALTER TABLE `tentativas`
  MODIFY `tnt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `testesession`
--
ALTER TABLE `testesession`
  MODIFY `tsn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
