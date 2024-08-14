-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql203.infinityfree.com
-- Tempo de geração: 19/11/2023 às 17:21
-- Versão do servidor: 10.4.17-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_34812691_guilavi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `sobrenome` varchar(50) DEFAULT NULL,
  `cpf` char(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `senha`) VALUES
(1, 'Vitoria', 'Cardoso', '123.456.789-01', 'vs@gmail.com', 'teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `foto`
--

CREATE TABLE `foto` (
  `id_turma` int(11) NOT NULL,
  `nomeArqFoto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `foto`
--

INSERT INTO `foto` (`id_turma`, `nomeArqFoto`) VALUES
(1, 'ppi.png'),
(2, 'programacao.png'),
(3, 'mat_fin.jpg'),
(4, 'mat1.jpg'),
(5, 'mat2.jpg'),
(7, 'contabilidade.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fotoUsuario`
--

CREATE TABLE `fotoUsuario` (
  `id_fotoUsuario` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nomeArqFoto` varchar(255) DEFAULT '../img/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `fotoUsuario`
--

INSERT INTO `fotoUsuario` (`id_fotoUsuario`, `id_usuario`, `nomeArqFoto`) VALUES
(1, 1, 'default.jpg'),
(2, 2, 'default.jpg'),
(3, 3, 'perfil_1700403007.png'),
(5, 5, 'default.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome_turma` varchar(50) DEFAULT NULL,
  `descricao` varchar(350) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome_turma`, `descricao`, `id_usuario`) VALUES
(1, 'PPI', 'ConteÃºdo ofertado para interessados em programaÃ§Ã£o Web. Nesta pÃ¡gina vocÃª encontra informaÃ§Ãµes e matÃ©rias relacionados a front-end e back-end.', 1),
(2, 'ProgramaÃ§Ã£o em Java', 'Aprenda a programar em java. Aqui vocÃª encontra material sobre a linguagem e exercÃ­cios para praticar', 1),
(3, 'MatemÃ¡tica Financeira I', 'ConteÃºdo sobre matemÃ¡tica financeira. Aprenda os conceitos iniciais de finanÃ§as.', 3),
(4, 'MatemÃ¡tica I', 'Material de apoio relacionado a matemÃ¡tica de cÃ¡lculo I.', 5),
(5, 'MatemÃ¡tica II', 'Material de apoio relacionado a matemÃ¡tica de cÃ¡lculo II.', 5),
(7, 'Contabilidade', 'Oferta de conteÃºdo para interessados em apender sobre conceitos iniciais de contabilidade.', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `sobrenome` varchar(50) DEFAULT NULL,
  `cpf` char(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `interesse` varchar(50) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `descricao` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `senha`, `interesse`, `tipo`, `descricao`) VALUES
(1, 'JoÃ£o', 'Silva', '000.000.000-00', 'joao@email.com', '$2y$10$jSHXxQxdEgk.z7kMWQra4OcOpfhBUo6IUtfOehS608B5fuR2mmqbO', 'Tecnologia', 'professor', 'Professor de Sistemas de InformaÃ§Ã£o na Universidade Federal de UberlÃ¢ndia (UFU) desde 2010.'),
(2, 'Maria', 'Silva', '111.111.111-11', 'maria@email.com', '$2y$10$A5cB.QPS.N2rdn8QKnaFA.ueE8NSkhxzkVVBCGf.CyKPnaHP9uhh.', 'Tecnologia', 'aluno', 'Aluna de Sistemas de InformaÃ§Ã£o na Universidade Federal de UberlÃ¢ndia (UFU).'),
(3, 'Carla', 'Oliveira', '222.222.222-22', 'carla@email.com', '$2y$10$xMXFy1RckhNb3V/UpK0Mke0J1dSZFsDJnjsBnv8hGmVw38JIedXSK', 'MatemÃ¡tica Financeira', 'professor', 'Professora de MatemÃ¡tica Financeira.'),
(5, 'JosÃ©', 'Rodrigues', '333.333.333-33', 'jose@email.com', '$2y$10$OEcFajtA3hXTADR0CDuIguCdvllDXHKLHBbCzUL8zPFWiHUR2T/ga', 'Outros', 'professor', 'Formado em Engenharia Civil pela Federal de UberlÃ¢ndia, professor de cÃ¡lculo desde 2001.');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `foto`
--
ALTER TABLE `foto`
  ADD KEY `id_turma` (`id_turma`);

--
-- Índices de tabela `fotoUsuario`
--
ALTER TABLE `fotoUsuario`
  ADD PRIMARY KEY (`id_fotoUsuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_fk` (`id_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `fotoUsuario`
--
ALTER TABLE `fotoUsuario`
  MODIFY `id_fotoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `fotoUsuario`
--
ALTER TABLE `fotoUsuario`
  ADD CONSTRAINT `fotoUsuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `turmas`
--
ALTER TABLE `turmas`
  ADD CONSTRAINT `id_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;