

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
  `idAcesso` int(1) NOT NULL,
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
(3, '3° andar'),
(4, '4° andar');

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
  `anoLancamento` date NOT NULL,
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
  `FK_idAcesso` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_login`
--

INSERT INTO `tbl_login` (`idLogin`, `nome`, `email`, `whatsapp`, `cpf`, `senha`, `hash`, `FK_idAcesso`) VALUES
(30, 'Ronaldo Luiz', 'ronaldo@gmail.com', '1111111', '2222222', '$2b$09$35c9a940f021a234bd335uki1COiMHpHqtQJGgwufNIBEAabDw01m', '$2b$08$9970eed0c06dfe3b3beb0uWqkGh0Pl2RfkrhZtC92lvCWqMhUFXxK', 2),
(31, 'Ana', 'ana@gmail.com', '222222', '3333333', '$2b$09$115d3c551e205494e16a6O6DAfO45lugzdJZLRODvZrYNpwSnnQMu', '$2b$08$59ec18006207f1183c891ONLFYIm7BRSNCBNLR236GB6Q9dM7ixx6', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_relatorio`
--

CREATE TABLE `tbl_relatorio` (
  `idRelatorio` int(10) NOT NULL,
  `Fk_IdEmprestimo` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_status`
--

CREATE TABLE `tbl_status` (
  `idStatus` int(4) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_status`
--

INSERT INTO `tbl_status` (`idStatus`, `descricao`) VALUES
(2, 'DISPONIVEL'),
(3, 'EMPRESTADO');

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
  ADD KEY `FK_idLogin_idx` (`FK_idLogin`),
  ADD KEY `FK_idStatus_idx` (`FK_idStatus`);

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
-- Índices de tabela `tbl_relatorio`
--
ALTER TABLE `tbl_relatorio`
  ADD PRIMARY KEY (`idRelatorio`),
  ADD KEY `Fk_idEmprestimo` (`Fk_IdEmprestimo`);

--
-- Índices de tabela `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`idStatus`);

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
  MODIFY `idAndar` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_emprestimo`
--
ALTER TABLE `tbl_emprestimo`
  MODIFY `idEmprestimo` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_livro`
--
ALTER TABLE `tbl_livro`
  MODIFY `idCadLivro` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `idLogin` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `tbl_relatorio`
--
ALTER TABLE `tbl_relatorio`
  MODIFY `idRelatorio` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `idStatus` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbl_emprestimo`
--
ALTER TABLE `tbl_emprestimo`
  ADD CONSTRAINT `FK_idLogin` FOREIGN KEY (`FK_idLogin`) REFERENCES `tbl_login` (`idLogin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_idStatus` FOREIGN KEY (`FK_idStatus`) REFERENCES `tbl_status` (`idStatus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_emprestimo_tbl_CadLivro1` FOREIGN KEY (`FK_idCadLivro`) REFERENCES `tbl_livro` (`idCadLivro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbl_livro`
--
ALTER TABLE `tbl_livro`
  ADD CONSTRAINT `FK_idAndar` FOREIGN KEY (`FK_andar`) REFERENCES `tbl_andar` (`idAndar`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD CONSTRAINT `fk_tbl_login_tbl_acesso1` FOREIGN KEY (`FK_idAcesso`) REFERENCES `tbl_acesso` (`idAcesso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tbl_relatorio`
--
ALTER TABLE `tbl_relatorio`
  ADD CONSTRAINT `Fk_idEmprestimo` FOREIGN KEY (`Fk_IdEmprestimo`) REFERENCES `tbl_emprestimo` (`idEmprestimo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
