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
    <script src="js.user.js"></script>
    <!-- Conexão com CSS externo -->
    <link rel="stylesheet" href="public_html/assets/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <img class="img-fundo" src="public_html/midias/midia-senac.jpeg">

    <main>
        <div class="container-form">
            <div class="forms">
                <h3 class="titulo-form">Preencha os campos abaixo para realizar seu empréstimo</h3>


                <label for="livro" class="text-form">Acervo de Livros:</label>
                <select name="livro" id="livro" class="design-input" required>
                    <option value="">Selecione o livro</option>
                    <?php
                    try {
                        require "private/config/db/conn.php";
                        // Consulta juntando a tblLivro e tblStatus
                        $query = "SELECT l.idCadLivro, l.nomeLivro, s.descricao AS statusDescricao
                                      FROM tbl_livro l
                                      INNER JOIN tbl_status s ON l.FK_status = s.idStatus";

                        $stmt = $conn->prepare($query);
                        $stmt->execute();

                        // Verifica se a consulta retornou algum resultado
                        if ($stmt->rowCount() > 0) {
                            // Iterar sobre os resultados e criar os options
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $id = htmlspecialchars($row['idCadLivro']);
                                $nomeLivro = htmlspecialchars($row['nomeLivro']);
                                $status = htmlspecialchars($row['statusDescricao']);

                                // Criar as opções do select
                                echo '<option value="' . $id . '">' . $nomeLivro . ' - ' . $status . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum livro encontrado</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }

                    ?>
                </select>

                <label for="andar" class="text-form">Selecione o Andar:</label>
                <select name="andar" id="andar" class="design-input" required>
                    <option value="">Selecione o andar</option>
                    <?php
                    try {
                        require "private/config/db/conn.php";
                        // Consulta SQL para buscar os andares
                        $sql = "SELECT idAndar, descricao FROM tbl_andar";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        //  cria os options
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['idAndar'] . '">' . $row['descricao'] . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }

                    ?>
                </select>

                <button type="submit" id="btn-alugar" class="design-input">Alugar</button>

                <button type="submit" class="design-input">Renovar Aluguel</button>

            </div>
        </div>
        <br>
        <a href="logout.php">SAIR</a>
    </main>

    <!-- Modal de Sucesso -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Boa leitura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Seu empréstimo foi realizado com sucesso !
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



</body>

</html>