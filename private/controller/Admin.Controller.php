<?php
header('Content-Type: application/json');
include("../model/Admin.model.php");

$LIVRO = new LIVRO();

$RELATORIO = new RELATORIO();

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

        // Verifica se algum campo obrigatório está vazio
        if (empty($nomeLivro) || empty($quantidade) || empty($condicao) || empty($codigo) || empty($autor) || empty($andar) || empty($anoLancamento)) {
            // Retorna erro se algum campo estiver vazio
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

            // Supondo que o método addLivro() retorna um array com 'status' e 'msg'
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
    default:
        $result = [
            'status' => false,
            'msg' => " <p>Sistema indisponivel. Tente mais tarde... </p>"
        ];
        break;
}

// Retorna a resposta como JSON
echo json_encode($result);
