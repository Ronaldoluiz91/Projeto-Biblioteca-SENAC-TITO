<?php
header('Content-Type: application/json');
include("../model/User-model.php");

$EMPRESTIMO = new EMPRESTIMO();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['livroId'])) {
    $livroId = $_POST['livroId'];

    if (empty($livroId)) {
        $result = [
            'status' => false,
            'message' => "Preencha todos os campos backend"
        ];
    } else {
        $mensagem = $EMPRESTIMO->alugarLivro($livroId); // Chama o método para alugar o livro
        $result = [
            'status' => true,
            'message' => $mensagem
        ];
    }

    echo json_encode($result); // Retorna a mensagem como resposta JSON
    exit; // Para garantir que o script PHP pare após enviar a resposta
}
?>


