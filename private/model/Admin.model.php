<?php
class LIVRO
{
    private $nomeLivro;
    private $quantidade;
    private $condicao;
    private $anoLancamento;
    private $autor;
    private $codigo;
    private $andar;

    public function setNomeLivro(string $nomeLivro)
    {
        $this->nomeLivro = $nomeLivro;
    }

    public function getNomeLivro(string $nomeLivro)
    {
        return $this->nomeLivro;
    }

    public function setQuantidade(string $quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getQuantidade(string $quantidade)
    {
        return $this->quantidade;
    }


    public function setCondicao(string $condicao)
    {
        $this->condicao = $condicao;
    }

    public function getCondicao(string $condicao)
    {
        return $this->condicao;
    }

    public function setAnoLancamento(string $anoLancamento)
    {
        $this->anoLancamento = $anoLancamento;
    }
    public function getAnoLancamento()
    {
        return $this->anoLancamento;
    }

    public function setAutor(string $autor)
    {
        $this->autor = $autor;
    }

    public function getAutor(string $autor)
    {
        return $this->autor;
    }

    public function setCodigo(string $codigo)
    {
        $this->codigo = $codigo;
    }

    public function getCodigo(string $codigo)
    {
        return $this->codigo;
    }
    public function setAndar(string $andar)
    {
        $this->andar = $andar;
    }
    public function getAndar()
    {
        return $this->andar;
    }


    public function addLivro()
    {
        $nomeLivro = $this->nomeLivro;
        $quantidade = $this->quantidade;
        $condicao = $this->condicao;
        $autor = $this->autor;
        $ano = $this->anoLancamento;
        $codigo = $this->codigo;
        $andar = $this->andar;

        $statusLivro = 4;  // Cada novo cadastro de livro o status entra como 'disponível'

        require "../config/db/conn.php";

        try {
            // Insere o novo livro no banco de dados
            $insertSql = "INSERT INTO tbl_livro (idCadLivro, nomeLivro, quantidadeDisp, condicao, codigoLivro, autor, anoLancamento, FK_andar, FK_status) 
              VALUES (null, :nomeLivro, :quantidade, :condicao, :codigoLivro, :autor, :ano, :andar, :statusLivro)";
            $insertStmt = $conn->prepare($insertSql);

            // Executa a inserção
            $insertStmt->execute([
                ':nomeLivro' => $nomeLivro,
                ':quantidade' => $quantidade,
                ':condicao' => $condicao,
                ':codigoLivro' => $codigo,
                ':autor' => $autor,
                ':ano' => $ano,
                ':andar' => $andar,
                ':statusLivro' => $statusLivro,
            ]);

            // Retorna a mensagem de sucesso
            return [
                'status' => true,
                'msg' => "Cadastro realizado com sucesso",
            ];
        } catch (PDOException $e) {
            // Em caso de erro, retorna a mensagem de erro
            return [
                'status' => false,
                'msg' => "Erro ao cadastrar o livro: " . $e->getMessage(),
            ];
        }

        // Fechar a conexão após todas as operações
        $conn = null;
    }
}


class RELATORIO
{
    private $conn;

    public function __construct()
    {
        require "../config/db/conn.php";
        $this->conn = $conn; // Atribui a conexão à propriedade
    }

    public function getEmprestimosPorMes($mes, $ano)
    {
        // Prepara a consulta
        $stmt = $this->conn->prepare("SELECT e.idEmprestimo, e.dataRetirada, e.dataEntrega, l.nomeLivro, u.nome AS nomeUsuario, s.descricao AS status
         FROM tbl_emprestimo e
        INNER JOIN tbl_livro l ON e.FK_idCadLivro = l.idCadLivro
        INNER JOIN tbl_login u ON e.FK_idLogin = u.idLogin
        INNER JOIN tbl_status s ON e.FK_idStatus = s.idStatusLivro
        WHERE MONTH(e.dataRetirada) = ? AND YEAR(e.dataRetirada) = ?
        ORDER BY  s.idStatusLivro ASC;");
        $stmt->execute([$mes, $ano]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para gerar o relatório de empréstimos via AJAX
    public function relatorioEmprestimos($mes, $ano)
    {
        // Chama a função para pegar os empréstimos
        $emprestimos = $this->getEmprestimosPorMes($mes, $ano);


        if ($emprestimos) {
            echo json_encode(['status' => true, 'data' => $emprestimos]);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Nenhum empréstimo encontrado para este mês/ano.']);
        }
        exit();
    }

    public function atualizarStatusEmprestimo($idEmprestimo, $novoStatus)
    {
        try {
            // Prepara a query para atualizar o status do empréstimo
            $stmt = $this->conn->prepare("UPDATE tbl_emprestimo SET FK_idStatus = ? WHERE idEmprestimo = ?");
            $stmt->execute([$novoStatus, $idEmprestimo]);


            if ($stmt->rowCount() > 0) {
                if ($novoStatus == '6') {
                    // Obtém o ID do livro associado ao empréstimo
                    $stmtLivro = $this->conn->prepare("SELECT FK_idCadLivro FROM tbl_emprestimo WHERE idEmprestimo = ?");
                    $stmtLivro->execute([$idEmprestimo]);
                    $idLivro = $stmtLivro->fetchColumn();

                    // Atualiza o status do livro para "Disponível"
                    $stmtUpdateLivro = $this->conn->prepare("UPDATE tbl_livro SET FK_status = ? WHERE idCadLivro = ?");
                    $statusDisponivel = '4';
                    $stmtUpdateLivro->execute([$statusDisponivel, $idLivro]);
                }

                if ($novoStatus == '5') {
                    // Obtém o ID do livro associado ao empréstimo
                    $stmtLivro = $this->conn->prepare("SELECT FK_idCadLivro FROM tbl_emprestimo WHERE idEmprestimo = ?");
                    $stmtLivro->execute([$idEmprestimo]);
                    $idLivro = $stmtLivro->fetchColumn();

                    // Atualiza o status do livro para "Emprestado"
                    $stmtUpdateLivro = $this->conn->prepare("UPDATE tbl_livro SET FK_status = ? WHERE idCadLivro = ?");
                    $statusEmprestado = '5'; // Código para "Emprestado"
                    $stmtUpdateLivro->execute([$statusEmprestado, $idLivro]);
                }

                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}


class ACESSO
{

    private $conn;

    public function __construct()
    {
        require "../config/db/conn.php";
        $this->conn = $conn; // Atribui a conexão à propriedade
    }


    public function buscarUsuarioPorEmail($email)
    {
        $query = "SELECT idLogin, email FROM tbl_login WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna um único usuário
    }

    public function alterarAcesso($usuarioId, $novoAcessoId)
    {
        $query = "UPDATE tbl_login SET FK_idAcesso = :novoAcesso WHERE idLogin = :usuarioId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':novoAcesso', $novoAcessoId, PDO::PARAM_INT);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
}
