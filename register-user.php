<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="public/assets/style.css">
</head>

<body>
<img class="img-fundo" src="public/midias/midia-senac.jpeg">


    <main>
        <div class="container-form">
            <div class="forms">
                <h3 class="titulo-form">Cadastre-se e acesse a Biblioteca Itinerante SENAC-TITO</h3>
                <span id="alertMsg"></span>
                <form>
                    <label for="name" class="text-form">Nome</label>
                    <input class="design-input" type="text" name="name" id="name"
                        placeholder="Digite seu nome completo">
                    <br>
                    <label for="email" class="text-form">E-mail</label>
                    <input class="design-input" type="email" name="email" id="email" placeholder="Digite seu email">
                    <br>
                    <label for="whatsapp" class="text-form">Whatsapp</label>
                    <input class="design-input" type="text" name="whatsapp" id="whatsapp" placeholder="Digite seu Whatsapp">
                    <br>
                    <label for="cpf" class="text-form">CPF</label>
                    <input class="design-input" type="text" name="cpf" id="cpf" placeholder="Digite seu CPF">
                    <br>
                    <label for="password" class="text-form">Senha</label>
                    <input class="design-input" type="text" name="password" id="password"
                        placeholder="Digite sua senha">
                    <br>
                    <label for="confirm-password" class="text-form">Confirmação de Senha</label>
                    <input class="design-input" type="text" name="confirm-password" id="confirm-password"
                        placeholder="Confirme sua senha">

                    <input type="hidden" name="fxLogin" id="fxLogin" value="Cadastrar">
                    <button type="button" id="cad-btn" class="design-input">Cadastrar</button>

                    <div class="text-form">Ja possui uma conta ?</div>
                    <a class="link-cadastro" href="index.php">Faça seu Login aqui</a>
                </form>
            </div>
        </div>

        <div id="modal-alert" style="display:none;">
            <div class="modal-content">
                <p>Preencha todos os campos antes de continuar</p>
                <span class="close-btn">×</span>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js.acoes.js"></script>
</body>

</html>