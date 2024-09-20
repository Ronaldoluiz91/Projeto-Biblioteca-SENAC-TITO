<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatório de Empréstimos por Mês</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .search-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .search-container form {
      display: inline-block;
    }

    input,
    select {
      padding: 10px;
      margin-right: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    .table-container {
      width: 90%;
      margin: 0 auto;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .no-data {
      text-align: center;
      color: #888;
      padding: 20px;
    }

    /* Estilização do botão de adicionar livros */
    .add-book-container {
      text-align: center;
      margin-top: 20px;
    }

    .add-book-container button {
      padding: 12px 20px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .add-book-container button:hover {
      background-color: #218838;
    }
  </style>
</head>

<body>

  <h2>Relatório de Empréstimos por Mês</h2>

  <div class="search-container">
    <form action="relatorio.php" method="POST">
      <label for="mes">Selecione o Mês:</label>
      <input type="month" id="mes" name="mes" required>
      <button type="submit">Buscar</button>
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

  <!-- Botão para redirecionar para a página de adicionar livros -->
  <div class="add-book-container">
    <button onclick="window.location.href='add-new-book.php'">Adicionar Novo Livro</button>
  </div>

</body>

</html>