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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Conexão com CSS externo -->
    <link rel="stylesheet" href="public/assets/style.css">
</head>

<body>
    <div class="container-form">
        <div class="forms">
            <h3 class="titulo-form">Adicionar Novo Livro</h3>
            <br>
            <!-- <div id="mensagem"></div> -->

            <div>
                <label for="nomeLivro" class="text-form">Nome do Livro:</label>
                <input type="text" id="nomeLivro" name="nomeLivro" class="design-input" placeholder="Digite o nome do Livro" required>
            </div>

            <div>
                <label for="quantLivro" class="text-form">Quantidade:</label>
                <input type="number" id="quantLivro" name="quantLivro" class="design-input" placeholder="Digite a quantidade de Livros" required>
            </div>

            <div>
                <label for="condLivro" class="text-form">Condição:</label>
                <input type="text" id="condLivro" name="condLivro" class="design-input" placeholder="Digite a condição do Livro" required>
            </div>

            <div>
                <label for="anoLancamento" class="text-form">Ano Lançamento:</label>
                <input type="text" id="anoLancamento" name="anoLancamento" placeholder="Digite o ano de Lançamento" class="design-input" required>
            </div>


            <div>
                <label for="codigoLivro" class="text-form">Codigo do Livro:</label>
                <input type="text" id="codigoLivro" name="codigoLivro" class="design-input" placeholder="Digite o codigo do Livro" required>
            </div>

            <div>
                <label for="autorLivro" class="text-form">Autor:</label>
                <input type="text" id="autorLivro" name="autorLivro" class="design-input" placeholder="Digite o autor do Livro" required>
            </div>
            <label for="andar" class="text-form">Andar que o Livro ficará:</label>
            <select name="andar" id="andar" class="design-input" required>
                <option value="">Selecione o andar</option>
                <?php
                // Conexão com o banco de dados
                require "private/config/db/conn.php";

                // Consulta SQL para buscar os andares
                $sql = "SELECT idAndar, descricao FROM tbl_andar";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['idAndar'] . '">' . $row['descricao'] . '</option>';
                }
                ?>
            </select>

            <input type="hidden" name="mtAdmin" id="mtAdmin" value="addLivro">

            <button type="button" class="design-input" id="cad-livro">Adicionar Livro</button>
            <br>
            <?php
            // Fechar a conexão após todas as operações
            $conn = null;
            ?>
        </div>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Mensagem</h5> <!-- Título do modal -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                    <!-- A mensagem de sucesso ou erro será exibida aqui -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <a href="Dashboard-adm.php">SAIR</a>



    <script src="js.admin.js"></script>
</body>

</html>