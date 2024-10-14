-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/08/2024 às 01:19
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `EventControlDB`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
--

CREATE TABLE `curso` (
  `Titulo` varchar(100) NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `data` date NOT NULL,
  `horarioInic` time NOT NULL,
  `horarioFim` time NOT NULL,
  `IDeventos` int(10) NOT NULL,
  `ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curso`
--

INSERT INTO `curso` (`Titulo`, `descricao`, `data`, `horarioInic`, `horarioFim`, `IDeventos`, `ID`) VALUES
('Sistemas Operacionais', 'Aulas introdutorias de SO', '2024-08-30', '14:30:00', '16:30:00', 201, 7),
('', '', '2024-08-25', '17:00:00', '18:00:00', 201, 10),
('Sistemas Operacionais 2024', 'so pra testar essa parte2.0', '2024-08-25', '17:00:00', '18:00:00', 201, 12),
('Teoria da computação ', 'Aulas sobre teoria da computação', '2024-08-26', '14:00:00', '15:45:00', 201, 14),
('Programação', 'Nesse curso será introduzido a materia de programação', '2024-08-30', '14:00:00', '15:45:00', 201, 2011);

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `nome` varchar(100) NOT NULL,
  `dataInic` date NOT NULL,
  `dataFim` date NOT NULL,
  `ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`nome`, `dataInic`, `dataFim`, `ID`) VALUES
('Sacsis2024', '2024-08-21', '2024-08-28', 201);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Matricula` int(5) NOT NULL,
  `Curso` varchar(100) NOT NULL,
  `Senha` varchar(25) NOT NULL,
  `Tipo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`Nome`, `Email`, `Matricula`, `Curso`, `Senha`, `Tipo`) VALUES
('Thiago Matheus de Oliveira Costa', 'thiagocosta.bsb@gmail.com', 8101, 'Sistemas', 'thicosta2004', 'aluno'),
('Luis Paulo Costa', 'lupa.bsb@gmail.com', 8102, 'Moda', 'lupa.bsb', 'aluno'),
('João Gabriel de Oliveira Costa ', 'joaoGO.bsb@gmail.com', 8103, 'Engenharia Civil', 'jgoc123', 'aluno'),
('Luma de Oliveira Costa ', 'luma.bsb@gmail.co', 8104, 'Psicologia', 'luma123', 'aluno'),
('Pedro ', 'pedro.bsb@gmail.com', 8123, 'TI', '12345', 'gerente'),
('Pedro Lucas de Oliveira Costa', 'peluca.bsb@gmail.com', 8127, 'TI ', 'pedro0708', 'gerente'),
('Madair de Oliveira Costa ', 'madairoc.bsb@gmail.com', 8900, 'Ciência de Dados', 'madairoc2024', 'gerente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_curso`
--

CREATE TABLE `usuario_curso` (
  `matriculaCurso` int(5) NOT NULL,
  `IDcurso` int(10) NOT NULL,
  `IDeventos` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_curso`
--

INSERT INTO `usuario_curso` (`matriculaCurso`, `IDcurso`, `IDeventos`) VALUES
(8101, 2011, 201),
(8102, 7, 201),
(8104, 7, 201),
(8103, 7, 201);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDeventos` (`IDeventos`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Matricula`);

--
-- Índices de tabela `usuario_curso`
--
ALTER TABLE `usuario_curso`
  ADD KEY `matriculaCurso` (`matriculaCurso`),
  ADD KEY `IDcurso` (`IDcurso`),
  ADD KEY `IDeventos` (`IDeventos`);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`IDeventos`) REFERENCES `eventos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_curso`
--
ALTER TABLE `usuario_curso`
  ADD CONSTRAINT `usuario_curso_ibfk_1` FOREIGN KEY (`matriculaCurso`) REFERENCES `usuario` (`Matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_curso_ibfk_2` FOREIGN KEY (`IDcurso`) REFERENCES `curso` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_curso_ibfk_3` FOREIGN KEY (`IDeventos`) REFERENCES `eventos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
