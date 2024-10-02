<?php
session_start();

if (!isset($_SESSION['loginValido']) || !$_SESSION['loginValido']) {
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

  <link rel="stylesheet" href="public/assets/style.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js.admin.js"></script>
</head>

<body id="relatorio">

  <h2>Relatório de Empréstimos por Mês</h2>

  <div class="search-container">
    <form id="relatorioForm">

      <div id="mensagem"></div>

      <label for="mes">Selecione o Mês:</label>
      <select id="mes">
        <option value="">Selecione um mês</option>
        <option value="1">Janeiro</option>
        <option value="2">Fevereiro</option>
        <option value="3">Março</option>
        <option value="4">Abril</option>
        <option value="5">Maio</option>
        <option value="6">Junho</option>
        <option value="7">Julho</option>
        <option value="8">Agosto</option>
        <option value="9">Setembro</option>
        <option value="10">Outubro</option>
        <option value="11">Novembro</option>
        <option value="12">Dezezembro</option>
      </select>

      <label for="ano">Ano:</label>
      <input type="text" id="ano" name="ano">


      <input type="hidden" name="mtAdmin" id="mtAdmin" value="relatorio">

      <button id="botaoBusca" type="button" class="design-inputRelatorio">Buscar</button>
    </form>
  </div>

  <div class="table-container">
    <table style="color: black;">
      <thead>
        <tr>
          <th>Nome do Livro</th>
          <th>Nome do Usuário</th>
          <th>Data do Empréstimo</th>
          <th>Data de Devolução</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="resultadoEmprestimos">
        <!-- Os dados serão preenchidos dinamicamente com JavaScript -->
      </tbody>
    </table>
  </div>



  <div class="add-book-container">
    <button onclick="window.location.href='add-new-book.php'">Adicionar Novo Livro</button>
  </div>

  <a href="logout.php">SAIR</a>

</body>

</html>