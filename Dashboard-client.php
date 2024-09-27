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
        <div class="container-form">
            <div class="forms">
                <h3 class="titulo-form">Preencha os campos abaixo para o Adicionar Livros</h3>
                <form id="form-emprestimo">
                    <!-- Campo Nome do livro -->
                    <label for="livro" class="text-form">Livros disponiveis:</label>
                    <select name="livro" id="livro" class="design-input" required>
                        <option value="">Selecione o livro</option>
                        <?php
                        // Conexão com o banco de dados
                        require "private/config/db/conn.php"; // Inclui a conexão com o banco de dados

                        try {
                            // Consulta SQL para buscar os livros
                            $sql = "SELECT idCadLivro, nomeLivro FROM tbl_livro"; 
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            // Verifica se a consulta retornou resultados
                            if ($stmt->rowCount() > 0) {
                                // Itera pelos resultados e cria os options
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . htmlspecialchars($row['idCadLivro']) . '">' . htmlspecialchars($row['nomeLivro']) . '</option>';
                                }
                            } else {
                                echo '<option value="">Nenhum livro disponível</option>'; // Opção se não houver livros
                            }
                        } catch (PDOException $e) {
                            echo '<option value="">Erro ao carregar livros</option>'; // Tratar erro
                            // Log do erro, se necessário
                            // error_log("Erro ao buscar livros: " . $e->getMessage());
                        }
                        ?>
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
                    <label for="andar" class="text-form">Selecione o Andar:</label>
                <select name="andar" id="andar" class="design-input" required>
                    <option value="">Selecione o andar</option>
                    <?php
                    // Conexão com o banco de dados
                    require "private/config/db/conn.php"; 

                    // Consulta SQL para buscar os andares
                    $sql = "SELECT idAndar, descricao FROM tbl_andar";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    // Itera pelos resultados e cria os options
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['idAndar'] . '">' . $row['descricao'] . '</option>';
                    }
                    ?>
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