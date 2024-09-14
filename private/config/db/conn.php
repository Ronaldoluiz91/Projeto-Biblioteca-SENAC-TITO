<?php
//Define o fuso horario com o script em PHP para São Paulo
date_default_timezone_set('America/Sao_Paulo');

$DBserver = "127.0.0.1:3306";
$DBuser = "root";
$DBpass = "";
$DBname = "dbbiblioteca";

try {
    $conn = new PDO(
        "mysql:host=$DBserver;dbname=$DBname",
        $DBuser,
        $DBpass
    );

    //Configura o PDO para lançar exceções (ERROS) quando ocorrer um problema, o que facilita a detecção e tratamento de erros.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Saida de conectado com sucesso
    $resp = "Conectado com sucesso!";

    //Captura exceções se ocorrer um erro ao tentar concectar- se ao banco de dados.
} catch (PDOException $erro) {

    //Saida de mensagem de erro com a descrição do problema
    $resp = "ERRO" . $erro->getMessage();
}
