<?php
class EMPRESTIMO {
    private $conn;

    public function __construct() {
        require "../config/db/conn.php"; // Certifique-se de que a conexão é estabelecida
        $this->conn = $conn;
    }

    public function alugarLivro($livroId) {
        try {
            // Atualiza o status do livro para 'emprestado'
            $updateQuery = "UPDATE tbl_livro 
                            SET FK_status = (SELECT idStatus FROM tbl_status WHERE descricao = 'Emprestado') 
                            WHERE idCadLivro = :livroId";
            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam(':livroId', $livroId);
            $stmt->execute();

            return "Livro alugado com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao atualizar o status do livro: " . $e->getMessage();
        }
    }
}
?>
