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
            require "../config/db/conn.php";

            // Verifica o nome do livro pelo seu ID
            $sql = "SELECT nomeLivro FROM tbl_livro WHERE idCadLivro = :livroId";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':livroId', $livroId, PDO::PARAM_INT);
            $stmt->execute();

            $nomeLivroDB = "";

            // Verifica se o livro foi encontrado no banco de dados
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nomeLivroDB = $row['nomeLivro']; // Atribui o nome do livro
            } else {
                // Caso o livro não seja encontrado
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
                // Caso o usuario não seja encontrado
                $response = [
                    "message" => "Erro: Usuario não encontrado!",
                    "user" => null
                ];
            }

            // Atualiza o status do livro para 'Emprestado'
            $updateQuery = "UPDATE tbl_livro 
                SET FK_status = (SELECT idStatus FROM tbl_status WHERE descricao = 'Emprestado') 
                WHERE idCadLivro = :livroId";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bindParam(':livroId', $livroId, PDO::PARAM_INT);
            $stmt->execute();

            // Adiciona o empréstimo na tbl_emprestimo
            $insertQuery = "INSERT INTO tbl_emprestimo (dataRetirada, dataEntrega, FK_idCadLivro, FK_idStatus, FK_idLogin) 
                            VALUES (NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY), :livroId, 
                            (SELECT idStatus FROM tbl_status WHERE descricao = 'Emprestado'), :usuarioId)";
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

        // Fechar a conexão após todas as operações
        $conn = null;
    }
}
