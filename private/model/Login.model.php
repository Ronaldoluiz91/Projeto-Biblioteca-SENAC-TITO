<?php
//  include_once('Crypt.model.php');
//Criando a classe de LOGIN
class LOGIN
{
    private $userLogin;
    private $userPassword;
    private $newUser;
    private $newEmail;
    private $confirmPassword;
    private $cpf;
    private $Acesso;


    // Métodos para email e senha de login
    public function setUserLogin(String $userLogin)
    {
        $this->userLogin = $userLogin;
    }
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    public function setUserPassword(String $userPassword)
    {
        $this->userPassword = $userPassword;
    }
    public function getUserPassword()
    {
        return $this->userPassword;
    }



    // Métodos para novo usuário e email 
    public function setNewUser(String $newUser)
    {
        $this->newUser = $newUser;
    }
    public function getNewUser()
    {
        return $this->newUser;
    }

    public function setNewEmail(String $newEmail)
    {
        $this->newEmail = $newEmail;
    }
    public function getNewEmail()
    {
        return $this->newEmail;
    }

    public function setCpf(String $cpf)
    {
        $this->cpf = $cpf;
    }
    public function getCpf()
    {
        return $this->cpf;
    }


    //CONFIRMAÇÃO DE SENHA NOVO USUARIO
    public function setConfirmPassword(String $confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    public function validateLogin(String $fxLogin)
    {
        require "../config/db/conn.php";

        $sql = "SELECT * FROM tbl_login WHERE email = :userLogin";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userLogin', $this->userLogin, PDO::PARAM_STR);

        // Executa a consulta
        $stmt->execute();

        $emailDB = "";
        $passwordDB = "";

        // Busca o resultado da consulta
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emailDB = $row['email'];
            $passwordDB = $row['senha'];

            // Verifica se o email e a senha estão corretos
            if ($emailDB === $this->userLogin && $passwordDB === $this->userPassword) {
                $result = [
                    'status' => true,
                    'msg' => "Usuário logado com sucesso.",
                    'usuario' => $this->userLogin,
                ];
            } else {
                $result = [
                    'status' => false,
                    'msg' => "Usuário ou senha inválidos.",
                    'usuario' => $this->userLogin,
                ];
            }
        } else {
            $result = [
                'status' => false,
                'msg' => "Usuário não encontrado.",
                'usuario' => $this->userLogin,
            ];
        }
        // Retorna o resultado da validação
        return $this->fxLogin = $result;
    }



    public function cadastroLogin(String $fxLogin)
    {

        $newEmail = $this->newEmail;
        $newUser = $this->newUser;
        $cpf = $this->cpf;
        $userPassword = $this->userPassword;
        $Acesso = "2";

        require "../config/db/conn.php";


        // Verifica se o email já está registrado no banco de dados
        $sql = "SELECT email FROM tbl_login WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $stmt->execute();


        $emailDB = "";


        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emailDB = $row['email'];
        }

        // Verifica se o email já está registrado
        if ($emailDB === $newEmail) {
            $result = [
                'status' => false,
                'msg' => "Email já registrado",
                'usuario' => $newEmail,
            ];
        } else {
            // Insere o novo usuário no banco de dados
            $insertSql = "INSERT INTO tbl_login (idLogin, nome, email, cpf, senha, FK_idAcesso) 
                      VALUES (null, :nome, :email, :cpf, :senha, :acesso)";
            $insertStmt = $conn->prepare($insertSql);

            // Hash da senha usando BCRYPT
            $hashedPassword = password_hash($userPassword, PASSWORD_BCRYPT);

            // Executa a inserção
            $insertStmt->execute([
                ':nome' => $newUser,
                ':email' => $newEmail,
                ':cpf' => $cpf,
                ':senha' => $hashedPassword,
                ':acesso' => $Acesso
            ]);

            $result = [
                'status' => true,
                'msg' => "Cadastro realizado com sucesso",
            ];
        }

        // Retorna o resultado da operação
        return $result;
    }
}
