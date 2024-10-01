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
                $totalEmprestimosAtivos = $EMPRESTIMO->contarEmprestimosAtivos($usuarioId);
                if ($totalEmprestimosAtivos >= 5) {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Você não pode efetuar um novo empréstimo, pois já possui 5 empréstimos ativos.'
                    ]);
                    return;
                }

                $mensagem = $EMPRESTIMO->alugarLivro($livroId, $usuarioId);
                $result = [
                    'status' => true,
                    'message' => $mensagem
                ];
            }
            echo json_encode($result);
            exit; // Encerra o script
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
                    $result = [
                        'status' => false,
                        'message' => "Erro ao processar a solicitação: " . $e->getMessage()
                    ];
                }
            }
            echo json_encode($result);
            exit;
        }
        break;

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
