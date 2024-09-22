<?php
session_start();

if(!isset($_SESSION['loginValido']) || !$_SESSION['loginValido']){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatório de Empréstimos por Mês</title>

  <link rel="stylesheet" href="public_html/assets/style.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js.acoes.js"></script>
</head>

<body id="relatorio">

  <h2>Relatório de Empréstimos por Mês</h2>

  <div class="search-container">
    <form action="#" method="POST">
      <label for="mes">Selecione o Mês:</label>
      <input type="month" id="mes" name="mes" required>
      <button class="botaoBusca" type="submit">Buscar</button>
    </form>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Nome do Livro</th>
          <th>Nome do Usuário</th>
          <th>Data do Empréstimo</th>
          <th>Data de Devolução</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <!-- Os dados serão preenchidos dinamicamente com PHP -->

      </tbody>
    </table>
  </div>

  
  <div class="add-book-container">
    <button onclick="window.location.href='add-new-book.php'">Adicionar Novo Livro</button>
  </div>

  <a href="logout.php">SAIR</a>

</body>

</html>