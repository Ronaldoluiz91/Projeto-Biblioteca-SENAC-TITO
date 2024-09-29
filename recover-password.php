<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="public/assets/style.css">
</head>

<body>
          <!-- <img class="img-fundo" src="public_html/midias/midia-senac.jpeg"> -->


<main>
          <h1>Recuperação de Senha</h1>
    <span id="alertMsg"></span>
    <div id="form-recover-password">
        <label> Digite seu email</label>
        <br>
        <input type="text" name="login-user" id="login-user">
        <br>
        <input type="hidden" name="fxLogin" id="fxLogin" value="Recuperar">
        <button onclick="recLogin()">Recuperar</button>
        <br>
        <a href="index.php">Login</a> | <a href="register-user.php">Cadastrar usuario</a>
    </div>
</main>


     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="js.acoes.js"></script>
    
</body>