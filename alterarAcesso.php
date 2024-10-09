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
    <!-- Conexão com CSS externo -->
    <link rel="stylesheet" href="public/assets/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
   
        <div class="forms">
            <h3 class="titulo-form">Alterar Acesso de Usuário</h3>
            <form id="form-alterar-acesso">
                <label for="usuario" class="text-form">email do Usuário:</label>
                <input type="text" name="usuario" id="usuario" class="design-input" required placeholder="Digite o email do usuário" />


                <label for="acesso" class="text-form">Novo Acesso:</label>
                <select name="acesso" id="acesso" class="design-input" required>
                    <option value="">Selecione o novo acesso</option>
                    <?php
                    // Conectar ao banco de dados e buscar usuários
                    try {
                        require "private/config/db/conn.php";
                        $query = "SELECT idAcesso, descricao FROM tbl_acesso";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['idAcesso'] . '">' . htmlspecialchars($row['descricao']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum acesso encontrado</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                    ?>
                </select>

                <input type="hidden" name="mtAdmin" id="mtAdmin" value="alterarAcesso">

                <button type="submit" id="btn-alterar" class="btn btn-primary mt-3">Alterar Acesso</button>
            </form>
            <div id="resultado"></div>
        </div>
   
    <a href="Dashboard-adm.php" class="btn btn-danger">SAIR</a>

    <script src="js.admin.js"></script>

</body>

</html>