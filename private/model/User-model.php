<?php
class EMPRESTIMO
{
    private $conn;

    public function __construct()
    {
        require "../config/db/conn.php";
        $this->conn = $conn;
    }

    public function alugarLivro($livroId)
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
                echo json_encode($response);
                die();
            }

            // Atualiza o status do livro para 'emprestado'
            $updateQuery = "UPDATE tbl_livro 
                SET FK_status = (SELECT idStatus FROM tbl_status WHERE descricao = 'Emprestado') 
                WHERE idCadLivro = :livroId";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bindParam(':livroId', $livroId, PDO::PARAM_INT);
            $stmt->execute();

            // Define o cabeçalho para JSON
            header('Content-Type: application/json');

            // Limpa qualquer saída anterior para evitar erros de parsing no JSON
            ob_clean();

            // Retorna a resposta JSON com a mensagem e o nome do livro
            $response = [
                "message" => "Livro alugado com sucesso!",
                "nomeLivro" => $nomeLivroDB 
            ];

            echo json_encode($response);
            die(); 

        } catch (PDOException $e) {
            // Em caso de erro, retorna uma mensagem de erro
            $response = [
                "message" => "Erro ao atualizar o status do livro: " . $e->getMessage()
            ];

            // Limpa qualquer saída anterior antes de enviar o JSON
            ob_clean();

            echo json_encode($response);
            die();
        }
    }
}
