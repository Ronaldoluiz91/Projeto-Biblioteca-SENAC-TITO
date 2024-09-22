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
</head>

<body>
    <img class="img-fundo" src="public_html/midias/midia-senac.jpeg">


    <div class="forms">
        <div>
            <h3 class="titulo-form">Adicionar Novo Livro</h3>
            <br>
            <div id="mensagem"></div>

            <div>
                <label for="titulo" class="text-form">Nome do Livro:</label>
                <input type="text" id="nomeLivro" name="nomeLivro" class="design-input" placeholder="Digite o nome do Livro" required>
            </div>

            <div>
                <label for="autor" class="text-form">Quantidade:</label>
                <input type="number" id="quantLivro" name="quantLivro" class="design-input" placeholder="Digite a quantidade de Livros" required>
            </div>

            <div>
                <label for="editora" class="text-form">Condição:</label>
                <input type="text" id="condLivro" name="condLivro" class="design-input" placeholder="Digite a condição do Livro" required>
            </div>


            <div>
                <label for="editora" class="text-form">Codigo do Livro:</label>
                <input type="text" id="codigoLivro" name="codigoLivro" class="design-input" placeholder="Digite a condição do Livro" required>
            </div>

            <div>
                <label for="ano" class="text-form">Autor:</label>
                <input type="text" id="autorLivro" name="autorLivro" class="design-input" placeholder="Digite o autor do Livro" required>
            </div>

            <button type="button" class="design-input" id="cad-livro">Adicionar Livro</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="js.admin.js"></script>
</body>

</html>