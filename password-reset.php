
<?php
$idRec = $_GET['idRec']
?>

<main>
    <h1>Recuperação de Senha </h1>
    <span id="alertMsg"></span>
    <div id="form-user-login">
        <label>Email</label><br>
        <input type="text" name="user-login" id="user-login"><br>
        <label>Senha</label><br>
        <input type="text" name="user-password" id="user-password"><br>
        <label>Confirmar Senha</label><br>
        <input type="text" name="user-confirm-password" id="user-confirm-password"><br>

        <input type="hidden" name="idRec" id="idRec" value="<?=$idRec?>">

        <input type="hidden" name="fxLogin" id="fxLogin" value="PasswordReset">
        <button type="button" onclick="resetLogin()">Recuperar Senha</button>
    </div>
    <p>
        <a href="index.php">Login</a> |
        <a href="register-user.php">Cadastrar usuário</a> 
    </p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js.acoes.js"></script>
</main>

