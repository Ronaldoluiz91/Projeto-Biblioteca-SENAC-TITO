<?php
header('Content-Type: application/json');
include("../model/Admin.model.php");

$LIVRO = new LIVRO();
$RELATORIO = new RELATORIO();
$ACESSO = new ACESSO();

$mtAdmin = $_POST['mtAdmin'];


switch ($mtAdmin) {
    case 'addLivro':
        // Obtém os dados enviados via POST
        $nomeLivro = $_POST['nomeLivro'];
        $quantidade = $_POST['quantidade'];
        $condicao = $_POST['condicao'];
        $anoLancamento = $_POST['anoLancamento'];
        $codigo = $_POST['codigo'];
        $autor = $_POST['autor'];
        $andar = $_POST['andar'];
        $mtAdmin = $_POST['mtAdmin'];

        if (empty($nomeLivro) || empty($quantidade) || empty($condicao) || empty($codigo) || empty($autor) || empty($andar) || empty($anoLancamento)) {
            $result = [
                'status' => false,
                'msg' => "Por favor, preencha todos os campos."
            ];
        } else {
            // Define os valores no objeto LIVRO
            $LIVRO->setNomeLivro($nomeLivro);
            $LIVRO->setQuantidade($quantidade);
            $LIVRO->setCondicao($condicao);
            $LIVRO->setAnoLancamento($anoLancamento);
            $LIVRO->setCodigo($codigo);
            $LIVRO->setAutor($autor);
            $LIVRO->setAndar($andar);

            // Tenta cadastrar o livro e captura o retorno
            $result = $LIVRO->addLivro();
        }
        break;

    case 'relatorio':
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];
        $mtAdmin = $_POST['mtAdmin'];

        if (empty($mes) || empty($ano)) {
            $result = [
                'status' => false,
                'msg' => "Por favor, preencha o mês e ano para obter um relatório."
            ];
        } else {
            // Chama a função para gerar o relatório
            $result = $RELATORIO->relatorioEmprestimos($mes, $ano);
        }
        break;

    case 'atualizarStatusEmprestimo':
        // Recebe os dados via POST
        $idEmprestimo = $_POST['emprestimoId'];
        $novoStatus = $_POST['novoStatus'];

        // Verifica se os campos obrigatórios foram preenchidos
        if (empty($idEmprestimo) || empty($novoStatus)) {
            $result = [
                'status' => false,
                'msg' => "ID do empréstimo ou novo status ausente."
            ];
        } else {
            // Chama o método para atualizar o status
            $atualizado = $RELATORIO->atualizarStatusEmprestimo($idEmprestimo, $novoStatus);

            if ($atualizado) {
                $result = [
                    'status' => true,
                    'msg' => "Status do empréstimo atualizado com sucesso!"
                ];
            } else {
                $result = [
                    'status' => false,
                    'msg' => "Erro ao atualizar o status. Tente novamente."
                ];
            }
        }
        break;

    case 'alterarAcesso':
        if (isset($_POST['usuario'])) {
            $email = $_POST['usuario'];

            // Verifique se o usuário existe no banco de dados
            $usuario = $ACESSO->buscarUsuarioPorEmail($email);

            if ($usuario) {
                $usuarioId = $usuario['idLogin'];
                $novoAcessoId = $_POST['acesso'];

                $resultado = $ACESSO->alterarAcesso($usuarioId, $novoAcessoId);

                if ($resultado) {
                    $result = [
                        'status' => true,
                        'message' => 'Acesso alterado com sucesso.'
                    ];
                } else {
                    $result = [
                        'status' => false,
                        'message' => 'Erro ao alterar o acesso.'
                    ];
                }
            } else {
                $result = [
                    'status' => false,
                    'message' => 'Usuário não encontrado.'
                ];
            }
        } else {
            $result = [
                'status' => false,
                'message' => 'Dados incompletos.'
            ];
        }
        break;

    default:
        $result = [
            'status' => false,
            'msg' => " <p>Sistema indisponivel. Tente mais tarde... </p>"
        ];
        break;
}

// Retorna a resposta como JSON
echo json_encode($result);
exit;
