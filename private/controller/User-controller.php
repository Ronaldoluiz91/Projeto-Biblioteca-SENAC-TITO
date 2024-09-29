<?php
header('Content-Type: application/json');
include("../model/User-model.php");

session_start();

$EMPRESTIMO = new EMPRESTIMO();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['livroId'])) {
    $livroId = $_POST['livroId'];
    $andar = $_POST['andar'];
    $usuarioId = $_POST['usuario'];
   

    if (empty($livroId) || empty($andar)) {
        $result = [
            'status' => false,
            'message' => "Preencha todos os campos para realizar o empréstimo"
        ];
    } else {
        $mensagem = $EMPRESTIMO->alugarLivro($livroId, $usuarioId); // Chama o método para alugar o livro
        $result = [
            'status' => true,
            'message' => $mensagem
        ];
    }

    echo json_encode($result); // Retorna a mensagem como resposta JSON
    exit; // Para garantir que o script PHP pare após enviar a resposta
}
