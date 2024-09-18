<?php
session_start();

//Destroi todas as variaveis de sessão
session_destroy();
//Redireciona a pagina de login
header("Location: index.php");
exit();
?>