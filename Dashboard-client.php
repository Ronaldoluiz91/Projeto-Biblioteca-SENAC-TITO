<?php
session_start();

if(!isset($_SESSION['loginValido']) || !$_SESSION['loginValido']){
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
        <div class="container-form">
            <div class="forms">
                <h3 class="titulo-form">Preencha os campos abaixo para o Adicionar Livros</h3>
                <form id="form-emprestimo">
                    <!-- Campo Nome do livro -->
                    <label for="livro" class="text-form">Nome do livro</label>
                    <select name="livro" id="livro" class="design-input" required>
                        <option value="">Selecione o livro</option>
                        <option value="O Pequeno Príncipe">O Pequeno Príncipe</option>
                    </select>

                    <!-- Campo Quantidade de livros -->
                    <label for="quantidade" class="text-form">Quantos livros deseja alugar</label>
                    <select name="quantidade" id="quantidade" class="design-input" required>
                        <option value="">Selecione a quantidade</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <!-- Campo Andar -->
                    <label for="andar" class="text-form">Selecione o andar que está o livro</label>
                    <select name="andar" id="andar" class="design-input" required>
                        <option value="">Selecione o andar</option>
                        <option value="1 andar">1º Andar</option>
                        <option value="2 andar">2º Andar</option>
                        <option value="3 andar">3º Andar</option>
                        <option value="4 andar">4º Andar</option>
                    </select>

                    <!-- Botão de alugar -->
                    <button type="submit" class="design-input">Alugar</button>
                    <button type="submit" class="design-input">Renovar Aluguel</button>
                </form>
            </div>
        </div>
        <br>
        <a href="logout.php">SAIR</a>
    </main>
   
    

</body>

</html>