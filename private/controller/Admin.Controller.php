<?php
header('Content-Type: application/json');
include("../model/Admin.model.php");

$LIVRO = new LIVRO();

$nomeLivro = $_POST['nomeLivro'];
$quantidade = $_POST['quantidade'];
$condicao = $_POST['condicao'];
$codigo = $_POST['codigo'];
$autor = $_POST['autor'];

if (empty($nomeLivro) || empty($quantidade) || empty($condicao) || empty($codigo) || empty($autor)) {
    $result = [
        'status' => true,
        'msg' => "preencha todos os campos"
    ];
} else {

    $LIVRO->setNomeLivro($nomeLivro);
    $LIVRO->setQuantidade($quantidade);
    $LIVRO->setCondicao($condicao);
    $LIVRO->setCodigo($codigo);
    $LIVRO->setAutor($autor);

     // Tenta cadastrar o livro e captura o retorno
     $result = $LIVRO->addLivro();
}

echo json_encode($result);
