<?php
include("../model/Login.model.php");

//header('Content-Type: Application/json');


$LOGIN = new LOGIN();
$fxLogin = $_POST['fxLogin'];


switch ($fxLogin) {
    case 'Logar':
        $userLogin = $_POST['email'];
        $userPassword = $_POST['senha'];

        if ((!((isset($userLogin)) ||  (empty($userLogin)) || ($userLogin === "")))  ||
            (!((isset($userPassword)) || (empty($userPassword)) || ($userPassword === "")))
        ) {
            $result = [
                'status' => false,
                'msg' => "Usuario- Preencha todos os campos"
            ];
        } else {
            $LOGIN->setUserLogin($userLogin);
            $LOGIN->setUserPassword($userPassword);

            $LOGIN->validateLogin($fxLogin);

         $result = $LOGIN->fxLogin;
        }
        break;

    case 'Cadastrar':
        $newUser = $_POST['nome'];
        $newEmail = $_POST['email'];
        $cpf = $_POST['cpf'];
        $userPassword = $_POST['senha'];
        $confirmPassword = $_POST['confirmSenha'];
        $acesso = "1"; // acesso padrão esta como 'USUARIO' para novos cadastro no sistema

        if (
            (isset($newUser)) || (empty($newUser)) || ($newUser === "") ||
            (isset($newEmail)) || (empty($newEmail)) || ($newEmail === "") ||
            (isset($cpf)) || (empty($cpf)) || ($cpf === "") ||
            (isset($userPassword)) || (empty($userPassword)) || ($userPassword === "") ||
            (isset($confirmPassword)) || (empty($confirmPassword)) || ($confirmPassword === "")
        ) {

            if ($userPassword === $confirmPassword) {
                $LOGIN->setNewUser($newUser);
                $LOGIN->setNewEmail($newEmail);
                $LOGIN->setCpf($cpf);
                $LOGIN->setUserPassword($userPassword);
                $LOGIN->setConfirmPassword($confirmPassword);

                $LOGIN->cadastroLogin($fxLogin);

                $result = $LOGIN->fxLogin;
            } else {
                $result = [
                    'status' => false,
                    'msg' => "Email ja cadastrado",
                    'userLogin' => $newUser,
                    'userEmail' => $newEmail,
                    'cpf' => $cpf,
                    'userPassword' => $userPassword,
                    'userConfirmPassword' => $confirmPassword
                ];
            }
        } else {
            $result = [
                'status' => false,
                'msg' => "Usuario- Preencha todos os campos"
            ];
        }
        break;

    case 'Recuperar':
        $recLoginEmail = $_POST['recLoginEmail'];

        $LOGIN->setUserLogin($recLoginEmail);
        break;

    default:
        $result = [
            'status' => false,
            'msg' => " <p>Sistema indisponivel. Tente mais tarde... </p>"
        ];
        break;
}


header('Content-Type: Application/json');
echo json_encode($result);

// echo "<pre>";
// var_dump($LOGIN);
// echo "</pre>";

// echo "<pre>";
// var_dump($result);
// echo "</pre>";
