

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbbiblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_acesso`
--

CREATE TABLE `tbl_acesso` (
  `idAcesso` int(4) NOT NULL,
  `tipo` int(2) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_acesso`
--

INSERT INTO `tbl_acesso` (`idAcesso`, `tipo`, `descricao`) VALUES
(1, 1, 'USUARIO'),
(2, 2, 'ADMINISTRADOR');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_andar`
--

CREATE TABLE `tbl_andar` (
  `idAndar` int(1) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_andar`
--

INSERT INTO `tbl_andar` (`idAndar`, `descricao`) VALUES
(1, '1° andar'),
(2, '2° andar'),
(3, '3° andar');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_emprestimo`
--

CREATE TABLE `tbl_emprestimo` (
  `idEmprestimo` int(4) NOT NULL,
  `dataRetirada` date NOT NULL,
  `dataEntrega` date NOT NULL,
  `FK_idCadLivro` int(11) NOT NULL,
  `FK_idStatus` int(11) NOT NULL,
  `FK_idLogin` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_livro`
--

CREATE TABLE `tbl_livro` (
  `idCadLivro` int(4) NOT NULL,
  `nomeLivro` varchar(70) NOT NULL,
  `quantidadeDisp` int(4) NOT NULL,
  `condicao` varchar(50) NOT NULL,
  `codigoLivro` int(11) NOT NULL,
  `autor` varchar(45) NOT NULL,
  `FK_andar` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_login`
--

CREATE TABLE `tbl_login` (
  `idLogin` int(4) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `whatsapp` varchar(10) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `hash` varchar(60) NOT NULL,
  `FK_idAcesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_status`
--

CREATE TABLE `tbl_status` (
  `idStatus` int(4) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `FK_idEmprestimo` int(11) NOT NULL,
  `FK_idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `idUsuario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` int(15) NOT NULL,
  `whatsapp` varchar(15) NOT NULL,
  `FK_idLogin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_acesso`
--
ALTER TABLE `tbl_acesso`
  ADD PRIMARY KEY (`idAcesso`);

--
-- Índices de tabela `tbl_andar`
--
ALTER TABLE `tbl_andar`
  ADD PRIMARY KEY (`idAndar`);

--
-- Índices de tabela `tbl_emprestimo`
--
ALTER TABLE `tbl_emprestimo`
  ADD PRIMARY KEY (`idEmprestimo`),
  ADD KEY `fk_tbl_emprestimo_tbl_CadLivro1_idx` (`FK_idCadLivro`),
  ADD KEY `FK_idLogin_idx` (`FK_idLogin`);

--
-- Índices de tabela `tbl_livro`
--
ALTER TABLE `tbl_livro`
  ADD PRIMARY KEY (`idCadLivro`),
  ADD KEY `FK_idAndar_idx` (`FK_andar`);

--
-- Índices de tabela `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`idLogin`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `hash_UNIQUE` (`hash`),
  ADD UNIQUE KEY `whatsapp_UNIQUE` (`whatsapp`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  ADD KEY `fk_tbl_login_tbl_acesso1_idx` (`FK_idAcesso`);

--
-- Índices de tabela `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`idStatus`),
  ADD KEY `fk_tbl_status_tbl_emprestimo1_idx` (`FK_idEmprestimo`),
  ADD KEY `fk_tbl_status_tbl_usuario1_idx` (`FK_idUsuario`);

--
-- Índices de tabela `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_tbl_usuario_tbl_login1_idx` (`FK_idLogin`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_acesso`
--
ALTER TABLE `tbl_acesso`
  MODIFY `idAcesso` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbl_andar`
--
ALTER TABLE `tbl_andar`
  MODIFY `idAndar` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_emprestimo`
--
ALTER TABLE `tbl_emprestimo`
  MODIFY `idEmprestimo` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_livro`
--
ALTER TABLE `tbl_livro`
  MODIFY `idCadLivro` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `idLogin` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `idStatus` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbl_emprestimo`
--
ALTER TABLE `tbl_emprestimo`
  ADD CONSTRAINT `FK_idLogin` FOREIGN KEY (`FK_idLogin`) REFERENCES `tbl_login` (`idLogin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_emprestimo_tbl_CadLivro1` FOREIGN KEY (`FK_idCadLivro`) REFERENCES `tbl_livro` (`idCadLivro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD CONSTRAINT `fk_tbl_login_tbl_acesso1` FOREIGN KEY (`FK_idAcesso`) REFERENCES `tbl_acesso` (`idAcesso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD CONSTRAINT `fk_tbl_status_tbl_emprestimo1` FOREIGN KEY (`FK_idEmprestimo`) REFERENCES `tbl_emprestimo` (`idEmprestimo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_status_tbl_usuario1` FOREIGN KEY (`FK_idUsuario`) REFERENCES `tbl_usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD CONSTRAINT `fk_tbl_usuario_tbl_login1` FOREIGN KEY (`FK_idLogin`) REFERENCES `tbl_login` (`idLogin`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
