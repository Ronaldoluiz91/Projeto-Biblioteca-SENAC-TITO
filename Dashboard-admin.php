<?php
session_start();

if (!isset($_SESSION['loginValido']) || !$_SESSION['loginValido']) {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Itinerante - SENAC TITO</title>
    <!-- Conexão com CSS externo -->
    <link rel="stylesheet" href="public_html/assets/style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js.acoes.js"></script>
</head>

<body>
    <img class="img-fundo" src="public_html/midias/midia-senac.jpeg">

    <main>

        <div class="form-add-Livro">
            <h3 class="titulo-form">Preencha os campos abaixo para adicionar Livro</h3>
            <div id="form-emprestimo">

                <label for="nome-livro" class="text-form">Nome do livro:</label>
                <input type="text" id="nome-livro" name="nome_livro" required>
                <br>

                <!-- Campo Quantidade -->
                <label for="quantidade" class="text-form">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" min="1" required>
                <br>

                <!-- Campo Condição -->
                <label for="condicao" class="text-form">Condição:</label>
                <input type="text" id="condicao" name="condicao" required>
                <br>

                <!-- Campo Autor -->
                <label for="autor" class="text-form">Autor:</label>
                <input type="text" id="autor" name="autor" required>
                <br>

                <!-- Campo Código do Livro -->
                <label for="codigo" class="text-form">Código do Livro:</label>
                <input type="text" id="codigo" name="codigo_livro" required>
                <br>

                <!-- Botão de alugar -->
                <button type="submit" class="design-input">Adicionar Livro</button>
                <div>
                </div>
            </div>

            <br>
            <a href="logout.php" color:white>SAIR</a>
    </main>



</body>

</html>