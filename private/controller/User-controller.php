<?php
header('Content-Type: application/json');
include("../model/User-model.php");

session_start();

$EMPRESTIMO = new EMPRESTIMO();

$mtUser = $_POST['mtUser'];


switch ($mtUser) {
    case 'Emprestimo':
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
            echo json_encode($result);
            exit;
        }
        break;

    case 'Renovar':
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emprestimoId'])) {
            $emprestimoId = $_POST['emprestimoId'];
            $usuarioId = $_POST['usuario'];

            if (empty($emprestimoId)) {
                $result = [
                    'status' => false,
                    'message' => "Por favor, selecione um empréstimo para renovar."
                ];
            } else {
                try {
                    // Chame o método para renovar o empréstimo
                    $mensagem = $EMPRESTIMO->renovarEmprestimo($emprestimoId, $usuarioId);
                    $result = [
                        'status' => true,
                        'message' => $mensagem
                    ];
                } catch (Exception $e) {
                    // Captura qualquer erro que ocorra durante a renovação
                    $result = [
                        'status' => false,
                        'message' => "Erro ao processar a solicitação: " . $e->getMessage()
                    ];
                }
            }

            echo json_encode($result);
            exit; // Para garantir que o script PHP pare após enviar a resposta
        }


    default:
        $result = [
            'status' => false,
            'message' => "Ação não reconhecida."
        ];
        echo json_encode($result);
        exit;
}

// Finalizando sempre com um retorno de resultado
if (!isset($result)) {
    $result = [
        'status' => false,
        'message' => "Erro ao processar a solicitação."
    ];
}
echo json_encode($result);
exit;
