<?php
header('Content-Type: application/json');
include("../model/Admin.model.php");

$LIVRO = new LIVRO();

$nomeLivro = $_POST['nomeLivro'];
$quantidade = $_POST['quantidade'];
$condicao = $_POST['condicao'];
$anoLancamento = $_POST['anoLancamento'];
$codigo = $_POST['codigo'];
$autor = $_POST['autor'];
$andar = $_POST['andar'];

if (empty($nomeLivro) || empty($quantidade) || empty($condicao) || empty($codigo) || empty($autor) || empty($andar) || empty($anoLancamento)) {
    $result = [
        'status' => true,
        'msg' => "preencha todos os campos bbb"
    ];
} else {

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


echo json_encode($result);
