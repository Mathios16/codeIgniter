-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Dez-2023 às 16:08
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
  `cts_usu_chave` varchar(255) NOT NULL,
  `cts_tempo` int(11) NOT NULL
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
(2, 0, 'usuarios', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usu_id` int(11) NOT NULL,
  `usu_nome` varchar(50) NOT NULL,
  `usu_email` varchar(40) NOT NULL,
  `usu_senha` varchar(40) NOT NULL,
  `usu_identificador` varchar(15) NOT NULL,
  `usu_tp_identificador` varchar(4) DEFAULT NULL,
  `usu_telefone` varchar(14) NOT NULL,
  `usu_cep` varchar(9) NOT NULL,
  `usu_logradouro` varchar(255) NOT NULL,
  `usu_bairro` varchar(60) NOT NULL,
  `usu_cidade` varchar(40) NOT NULL,
  `usu_estado` char(2) NOT NULL,
  `usu_github` varchar(50) DEFAULT NULL,
  `usu_acesso` varchar(3) NOT NULL DEFAULT 'usu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`usu_id`, `usu_nome`, `usu_email`, `usu_senha`, `usu_identificador`, `usu_tp_identificador`, `usu_telefone`, `usu_cep`, `usu_logradouro`, `usu_bairro`, `usu_cidade`, `usu_estado`, `usu_github`, `usu_acesso`) VALUES
(1, 'matheus', 'matheussalomao12m@gmail.com', 'Mathios', '477.236.858', 'cpf', '+55(11)94613-1', '08830-792', 'Rua Expedicionário Francisco Lopes da Cruz', 'Villa Di Cesar', 'Mogi das Cruzes', 'SP', 'Mathios16', 'adm'),
(2, 'Camill', 'camillasalomao@gmail.com', 'c0312', '477', 'cpf', '+11(94)61311-1', '08830-792', '', '', '', '', '', 'usu'),
(9, 'eu1', 'eu@gmail.com', '123', '1', 'cnpj', '12345', '', '', '', '', '', '', 'usu'),
(10, 'teste', 'teste@outlook.com', '321', '321', 'cnpj', '321', '', '', '', '', '', '', 'usu'),
(39, 'math', 'matheus.salomao@fatec.sp.gov.br', '123', '123', 'cpf', '+55(11)94613-1', '08830-792', 'Rua Expedicionário Francisco Lopes da Cruz', 'Villa Di Cesar', 'Mogi das Cruzes', 'SP', '', 'usu');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `controle_sessoes`
--
ALTER TABLE `controle_sessoes`
  ADD PRIMARY KEY (`cts_id`),
  ADD UNIQUE KEY `cts_usu_chave` (`cts_usu_chave`);

--
-- Índices para tabela `tentativas`
--
ALTER TABLE `tentativas`
  ADD PRIMARY KEY (`tnt_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usu_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `controle_sessoes`
--
ALTER TABLE `controle_sessoes`
  MODIFY `cts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT de tabela `tentativas`
--
ALTER TABLE `tentativas`
  MODIFY `tnt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
