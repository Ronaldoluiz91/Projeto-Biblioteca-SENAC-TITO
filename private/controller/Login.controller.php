<?php
include("../model/Login.model.php");
header('Content-Type: Application/json');

//Inicia uma sessão
session_start();

$LOGIN = new LOGIN();
$fxLogin = $_POST['fxLogin'];

switch ($fxLogin) {
    case 'Logar':
        $userLogin = $_POST['email'];
        $userPassword = $_POST['senha'];
        
        // Verificando se algum dos campos está vazio
        if (empty($userLogin) || empty($userPassword)) {
            $result = [
                'status' => false,
                'msg' => "Preencha todos os campos"
            ];
        } else {
            // Configurando as credenciais de login
            $LOGIN->setUserLogin($userLogin);
            $LOGIN->setUserPassword($userPassword);

            // Validando o login
            $LOGIN->validateLogin($fxLogin);

            // Retornando o resultado do login
            $result = $LOGIN->fxLogin;

            if ($result['status']) {
                //Criando a sessão com o login bem sucedido
                $_SESSION['userLogin'] = $userLogin;
                $_SESSION['loginValido'] = true;
                $_SESSION['idLogin'] = $result['idLogin'];
            }
        }
        break;

    case 'Cadastrar':
        $newUser = $_POST['nome'];
        $newEmail = $_POST['email'];
        $whatsapp = $_POST['whatsapp'];
        $cpf = $_POST['cpf'];
        $userPassword = $_POST['senha'];
        $confirmPassword = $_POST['confirmSenha'];
        $acesso = "1"; // acesso padrão para novos cadastros

        // Verificando se algum dos campos está vazio
        if (
            empty($newUser) ||
            empty($newEmail) ||
            empty($whatsapp) ||
            empty($cpf) ||
            empty($userPassword) ||
            empty($confirmPassword)
        ) {
            $result = [
                'status' => false,
                'msg' => "Preencha todos os campos"
            ];
        } else {
            // Verificando se as senhas coincidem
            if ($userPassword === $confirmPassword) {
                $LOGIN->setNewUser($newUser);
                $LOGIN->setNewEmail($newEmail);
                $LOGIN->setWhatsapp($whatsapp);
                $LOGIN->setCpf($cpf);
                $LOGIN->setUserPassword($userPassword);
                // Função de cadastro
                $LOGIN->cadastroLogin($fxLogin);
                // Retornando o resultado do cadastro
                $result = $LOGIN->fxLogin;
            } else {
                $result = [
                    'status' => false,
                    'msg' => "Senhas não combinam",
                ];
            }
        }
        break;

    case 'Recuperar':
        $recLoginEmail = $_POST['recLoginEmail'];

        // Verifica se o campo está vazio
        if (!isset($recLoginEmail) || empty($recLoginEmail) || $recLoginEmail === "") {
            $result = [
                'status' => false,
                'msg' => 'Preencha o campo'
            ];
        } else {
            $LOGIN->setUserLogin($recLoginEmail);
            $LOGIN->recoveryLogin($fxLogin);

            $result = $LOGIN->fxLogin;
        }
        break;

    case 'PasswordReset':
        $userLogin = $_POST['userLogin'];
        $userPassword = $_POST['userPassword'];
        $userConfirmPassword = $_POST['userConfirmPassword'];
        $idRec = $_POST['idRec'];

        $LOGIN->setUserLogin($userLogin);
        $LOGIN->setUserPassword($userPassword);
        $LOGIN->setIdRec($idRec);

        $LOGIN->PasswordReset($fxLogin);

        $result = $LOGIN->fxLogin;
        break;

    default:
        $result = [
            'status' => false,
            'msg' => " <p>Sistema indisponivel. Tente mais tarde... </p>"
        ];
        break;
}

echo json_encode($result);

// echo "<pre>";
// var_dump($LOGIN);
// echo "</pre>";

// echo "<pre>";
// var_dump($result);
// echo "</pre>";
