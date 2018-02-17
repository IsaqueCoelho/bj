-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25-Jan-2017 às 04:27
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bj`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bloqueado`
--

CREATE TABLE `bloqueado` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `campos`
--

CREATE TABLE `campos` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `celular` varchar(16) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `endereco` varchar(120) NOT NULL,
  `imagem` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `data` datetime NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

CREATE TABLE `notificacao` (
  `id` int(11) NOT NULL,
  `id_criaNotifi` int(11) NOT NULL,
  `id_recebeNotifi` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `tipo` int(1) NOT NULL,
  `visualizado` tinyint(1) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fim` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estrutura da tabela `partida`
--

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `id_desafiante` int(11) NOT NULL,
  `id_desafiado` int(11) NOT NULL,
  `tipo_campo` tinyint(1) NOT NULL,
  `data` date NOT NULL,
  `horario` varchar(5) NOT NULL,
  `rua` varchar(30) NOT NULL,
  `numero` varchar(4) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `usuario_pontuando_partida` int(11) NOT NULL,
  `pontuado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patrocinadores`
--

CREATE TABLE `patrocinadores` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `link` varchar(60) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `imagem` varchar(120) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `patrocinadores`
--

INSERT INTO `patrocinadores` (`id`, `nome`, `link`, `celular`, `imagem`) VALUES
(1, 'Patrocine Aqui', '#', '(000) 0000-0000', 'patrocinio.png'),
(2, 'Patrocine aqui', '#', '(000)00000-0000', 'patrocinio.png'),
(3, 'Patrocine aqui', '#', '(000)00000-0000', 'patrocinio.png'),
(4, 'Patrocine aqui', '#', '(000)00000-0000', 'patrocinio.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pontuacao`
--

CREATE TABLE `pontuacao` (
  `id` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `pontos_desafiante` int(3) NOT NULL,
  `pontos_desafiado` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ranking`
--

CREATE TABLE `ranking` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `pontos` int(5) NOT NULL,
  `tipo_campo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estrutura da tabela `reporte`
--

CREATE TABLE `reporte` (
  `id` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_reportante` int(11) NOT NULL,
  `id_reportado` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `time`
--

CREATE TABLE `time` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome_time` varchar(60) NOT NULL,
  `cor_uniforme` varchar(80) DEFAULT NULL,
  `campo_endereco` varchar(255) DEFAULT NULL,
  `campo` tinyint(1) NOT NULL,
  `foto` varchar(120) DEFAULT NULL,
  `reportes` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `rg` varchar(10) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `celular` varchar(12) NOT NULL,
  `rua` varchar(40) CHARACTER SET utf8 NOT NULL,
  `ncasa` varchar(6) NOT NULL,
  `bairro` varchar(30) CHARACTER SET utf8 NOT NULL,
  `cidade` varchar(20) CHARACTER SET utf8 NOT NULL,
  `privilegio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `senha`, `nome`, `rg`, `cpf`, `telefone`, `celular`, `rua`, `ncasa`, `bairro`, `cidade`, `privilegio`) VALUES
(1, 'admin@admin.com', 'admin.bomjogo.2017', '', '', '', '', '', '', '', '', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloqueado`
--
ALTER TABLE `bloqueado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campos`
--
ALTER TABLE `campos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificacao`
--
ALTER TABLE `notificacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patrocinadores`
--
ALTER TABLE `patrocinadores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pontuacao`
--
ALTER TABLE `pontuacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_time` (`nome_time`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloqueado`
--
ALTER TABLE `bloqueado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `campos`
--
ALTER TABLE `campos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notificacao`
--
ALTER TABLE `notificacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patrocinadores`
--
ALTER TABLE `patrocinadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pontuacao`
--
ALTER TABLE `pontuacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
