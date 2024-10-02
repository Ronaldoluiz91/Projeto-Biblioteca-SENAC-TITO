<?php
session_start();

if (!isset($_SESSION['loginValido']) || !$_SESSION['loginValido']) {
    header("Location: index.php");
    exit();
}
$usuario =  $_SESSION['idLogin'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Itinerante - SENAC TITO</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Conexão com CSS externo -->
    <link rel="stylesheet" href="public/assets/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <main class="container">
        <!-- Primeira seção: Formulário de Aluguel -->
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="forms">
                    <h3 class="titulo-form">Preencha os campos abaixo para realizar seu empréstimo</h3>
                    <form id="form-alugar">
                        <label for="livro" class="text-form">Acervo de Livros:</label>
                        <select name="livro" id="livro" class="design-input" required>
                            <option value="">Selecione o livro</option>
                            <?php
                            try {
                                require "private/config/db/conn.php";
                                // Consulta juntando a tblLivro e tblStatus
                                $query = "SELECT l.idCadLivro, l.nomeLivro, s.descricao AS statusDescricao
                         FROM tbl_livro l
                         INNER JOIN tbl_status s ON l.FK_status = s.idStatusLivro
                         ORDER BY s.idStatusLivro  ASC; ";
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

                        <input type="hidden" id="usuarioEmail" name="usuarioEmail" value="<?php echo $usuario; ?>">
                        <input type="hidden" name="mtUser" id="mtUser" value="Emprestimo">

                        <button type="submit" id="btn-alugar" class="btn btn-primary mt-3">Alugar</button>
                    </form>
                </div>
            </div>

            <!-- Tabela de Empréstimos Ativos -->
            <div class="col-md-6 col-sm-12">
                <div class="forms">
                    <h3 class="titulo-form">Empréstimos Ativos</h3>
                    <form id="form-renovar">
                        <input type="hidden" name="mtUser" id="mtUser2" value="Renovar">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nome do Livro</th>
                                        <th>Data Retirada</th>
                                        <th>Data Entrega</th>
                                        <th>Renovações</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        require "private/config/db/conn.php";
                                        // Consulta para buscar os empréstimos ativos do usuário
                                        $sql = "SELECT e.idEmprestimo, l.nomeLivro, e.dataRetirada, e.dataEntrega, e.renovacao 
                        FROM tbl_emprestimo e 
                        INNER JOIN tbl_livro l ON e.FK_idCadLivro = l.idCadLivro 
                        WHERE e.FK_idLogin = :usuarioId 
                        AND e.FK_idStatus = (SELECT idStatusLivro FROM tbl_status WHERE descricao = 'Emprestado')";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(':usuarioId', $usuario, PDO::PARAM_INT);
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['nomeLivro']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['dataRetirada']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['dataEntrega']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['renovacao']) . '</td>';
                                            echo '<td> <button type="button" id="btn-renovar" class="btn btn-info btn-renovar" data-id="' . $row['idEmprestimo'] . '">Renovar</button></td>';


                                            echo '</tr>';
                                        }
                                    } catch (PDOException $e) {
                                        echo "<tr><td colspan='5'>Erro: " . $e->getMessage() . "</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <a href="logout.php" class="btn btn-danger">SAIR</a>
    </main>

    <?php
    // Fechar a conexão após todas as operações
    $conn = null;
    ?>

    <!-- Modal de Sucesso e erro -->
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
                    <p id="modalMessage">Seu empréstimo foi realizado com sucesso!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal de Renovação de Empréstimo -->
    <div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="renewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renewModalLabel">Resultado da Operação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage2">Mensagem aqui.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Aviso -->
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warningModalLabel">Atenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="warningMessage">Por favor, selecione um empréstimo ativo para renovar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="js.user.js"></script>

</body>

</html>