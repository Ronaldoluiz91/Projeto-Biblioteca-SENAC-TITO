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

<body class="relatorio">

    <h2 class="titulo-relatorio">Relatório de Empréstimos de Livros</h2>

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
                <!-- Exemplos de dados de empréstimo -->
                <tr>
                    <td>O Senhor dos Anéis</td>
                    <td>João Silva</td>
                    <td>01/09/2024</td>
                    <td>15/09/2024</td>
                    <td>Em andamento</td>
                </tr>
                <tr>
                    <td>A Revolução dos Bichos</td>
                    <td>Maria Souza</td>
                    <td>20/08/2024</td>
                    <td>05/09/2024</td>
                    <td>Concluído</td>
                </tr>
                <!-- Outros registros serão gerados dinamicamente -->
            </tbody>
        </table>
    </div>
</body>

</html>