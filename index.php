<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Itinerante - SENAC TITO</title>

    <!-- Conexão com CSS externo -->
    <link rel="stylesheet" href="public/assets/style.css">
</head>

<body>
    <main>
        <div class="container-form">
            <div class="forms">
                <h3 class="titulo-form">Bem vindo a Biblioteca itinerante SENAC- TITO !</h3>


                <span id="alertMsg"></span>
                <div id="form-user-login">
                    <label for="login-user" class="text-form">E-mail</label>
                    <input class="design-input" type="text" name="login-user" id="login-user"
                        placeholder="Digite seu email" required>

                    <label for="password-user" class="text-form">Senha</label>
                    <input class="design-input" type="password" name="password-user" id="password-user"
                        placeholder="Digite sua senha" required>

                    <input type="hidden" name="fxLogin" id="fxLogin" value="Logar">

                    <button type="button" id="login-btn" class="design-input">Entrar</button>
                </div>

                <div class="text-form">Ainda não possui um Login?</div>
                <a class="link-cadastro" href="register-user.php">Cadastre-se aqui</a> <br>
                <a href="recover-password.php" class="link-cadastro">Esqueceu sua senha?</a>
            </div>
        </div>

        <!-- Modal para aviso -->
        <div id="modal-alert-login" class="modal-login">
            <div class="modal-content-login">
                <span class="close-btn-login">&times;</span>
                <p>Por favor, preencha todos os campos antes de continuar.</p>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js.acoes.js"></script>
</body>

</html>