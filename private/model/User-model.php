<?php
// Define o cabeçalho para JSON
header('Content-Type: application/json');

class EMPRESTIMO
{
    private $conn;

    public function __construct()
    {
        require "../config/db/conn.php";
        $this->conn = $conn;
    }

    public function alugarLivro($livroId, $usuarioId)
    {
        try {
            // Verifica o status do livro antes de alugar
            $statusAtual = $this->verificarStatus($livroId);

            if ($statusAtual === 'Emprestado') {
                $response = [
                    "message" => "Erro: Este livro já está emprestado! <br> Verifique com a biblioteca a data de disponibilidade do livro",
                    "nomeLivro" => null
                ];
                echo json_encode($response);
                exit();
            }

            require "../config/db/conn.php";

            // Verifica o nome do livro pelo seu ID
            $sql = "SELECT nomeLivro FROM tbl_livro WHERE idCadLivro = :livroId";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':livroId', $livroId, PDO::PARAM_INT);
            $stmt->execute();

            $nomeLivroDB = "";

            // Verifica se o livro foi encontrado no banco de dados
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nomeLivroDB = $row['nomeLivro'];
            } else {
                $response = [
                    "message" => "Erro: Livro não encontrado!",
                    "bookName" => null
                ];
            }

            // Verifica se o usuário existe no banco de dados
            $sql = "SELECT idLogin FROM tbl_login WHERE idLogin = :usuarioId";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();

            $nomeUsuarioDB = "";

            // Verifica se o usuário foi encontrado no banco de dados
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nomeUsuarioDB = $row['nome'];
            } else {
                $response = [
                    "message" => "Erro: Usuario não encontrado!",
                    "user" => null
                ];
            }

            // Atualiza o status do livro para 'Emprestado'
            $updateQuery = "UPDATE tbl_livro 
                SET FK_status = (SELECT idStatusLivro FROM tbl_status WHERE descricao = 'Emprestado') 
                WHERE idCadLivro = :livroId";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bindParam(':livroId', $livroId, PDO::PARAM_INT);
            $stmt->execute();

            // Adiciona o empréstimo na tbl_emprestimo
            $insertQuery = "INSERT INTO tbl_emprestimo (dataRetirada, dataEntrega, FK_idCadLivro, FK_idStatus, FK_idLogin) 
                            VALUES (NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY), :livroId, 
                            (SELECT idStatusLivro FROM tbl_status WHERE descricao = 'Emprestado'), :usuarioId)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bindParam(':livroId', $livroId, PDO::PARAM_INT);
            $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();

            // Retorna a resposta JSON com a mensagem e o nome do livro
            $response = [
                "message" => "Seu empréstimo foi realizado com sucesso!",
                "nomeLivro" => $nomeLivroDB
            ];
        } catch (PDOException $e) {
            // Em caso de erro, retorna uma mensagem de erro
            $response = [
                "message" => "Erro ao atualizar o status do livro: " . $e->getMessage()
            ];
        }

        ob_clean();

        echo json_encode($response);
        exit();

        $conn = null;
    }

    public function verificarStatus($idLivro)
    {
        try {
            // Verifica o status do livro no banco
            $query = "SELECT s.descricao FROM tbl_livro l
                      INNER JOIN tbl_status s ON l.FK_status = s.idStatusLivro
                      WHERE l.idCadLivro = :idLivro";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idLivro', $idLivro, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['descricao'] : null;
        } catch (PDOException $e) {
            return null;
        }
    }


    public function renovarEmprestimo($emprestimoId, $usuarioId)
    {
        // Verifique se o empréstimo existe e obtenha seu status e número de renovações
        $query = "SELECT renovacao, dataEntrega FROM tbl_emprestimo WHERE idEmprestimo = :emprestimoId AND FK_idLogin = :usuarioId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':emprestimoId', $emprestimoId);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $renovacao = $row['renovacao'];
            $dataEntrega = new DateTime($row['dataEntrega']);
            $dataAtual = new DateTime();

            // Verifique se já foram feitas duas renovações
            if ($renovacao >= 2) {
                throw new Exception("Você já renovou este empréstimo duas vezes.");
            }

            // Verifique se faltam 5 dias para a data de entrega
            $intervalo = $dataAtual->diff($dataEntrega);
            if ($intervalo->days > 5) {
                throw new Exception("Não é possível renovar o empréstimo. Faltam mais de 5 dias para a data de entrega.");
            }

            // Se tudo estiver certo, atualize o empréstimo
            $renovacao++;

            // Adiciona 15 dias à data de entrega
            $dataEntrega->modify('+15 days');
            $dataEntregaFormatada = $dataEntrega->format('Y-m-d');

            $updateQuery = "UPDATE tbl_emprestimo SET renovacao = :renovacao, dataEntrega = :dataEntrega WHERE idEmprestimo = :emprestimoId";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':renovacao', $renovacao);
            $updateStmt->bindParam(':dataEntrega', $dataEntregaFormatada);
            $updateStmt->bindParam(':emprestimoId', $emprestimoId);
            $updateStmt->execute();

            return "Empréstimo renovado com sucesso!";
        } else {
            throw new Exception("Empréstimo não encontrado.");
        }
    }
}
