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

    public function getEmprestimosPorMes($mes)
    {
        // Prepara a consulta
        $stmt = $this->conn->prepare("SELECT e.idEmprestimo, e.dataRetirada, e.dataEntrega, l.nomeLivro, u.nome AS nomeUsuario, s.descricao AS status
         FROM tbl_emprestimo e
        INNER JOIN tbl_livro l ON e.FK_idCadLivro = l.idCadLivro
        INNER JOIN tbl_login u ON e.FK_idLogin = u.idLogin
        INNER JOIN tbl_status s ON e.FK_idStatus = s.idStatusLivro
        WHERE MONTH(e.dataRetirada) = ? 
        ORDER BY e.dataRetirada ASC;");
        $stmt->execute([$mes]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os registros
    }

    // Função para gerar o relatório de empréstimos via AJAX
    public function relatorioEmprestimos($mes)
    {
        // Chama a função para pegar os empréstimos
        $emprestimos = $this->getEmprestimosPorMes($mes);

        // Verifica se a consulta retornou resultados
        if ($emprestimos) {
            // Retorna os dados em formato JSON
            echo json_encode(['status' => true, 'data' => $emprestimos]);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Nenhum empréstimo encontrado para este mês.']);
        }
        exit(); // Não esquecer de encerrar a execução após o echo
    }
}
