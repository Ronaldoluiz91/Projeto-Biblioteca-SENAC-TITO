<?php
 include_once('Crypt.model.php');
//Criando a classe de LOGIN
class LOGIN
{
    private $userLogin;
    private $userPassword;
    private $newUser;
    private $newEmail;
    private $confirmPassword;
    private $cpf;
    private $acesso;


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

    //-----------VALIDAÇÃO DE LOGIN ----------------//
    public function validateLogin(String $fxLogin)
    {
        require "../config/db/conn.php";
    
        $sql = "SELECT * FROM tbl_login WHERE email = :userLogin";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userLogin', $this->userLogin, PDO::PARAM_STR);
    
        // Executa a consulta
        $stmt->execute();
    
        // Variáveis para armazenar resultados
        $emailDB = "";
        $passwordDB = "";
        $acesso = "";
    
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extrai os dados do banco de dados
            $emailDB = $row['email'];
            $passwordDB = $row['senha'];
            $acesso = $row['FK_idAcesso'];
    
            include_once('Crypt.model.php');
            $Crypt = new Crypt();
    
            // Criptografa a senha inserida pelo usuário
            $Cemail = $emailDB;
            $Cpass = $this->userPassword;
    
            $userPassword = $Crypt->CryptPass($Cemail, $Cpass);
            $userHash = $Crypt->CryptHash($Cemail, $Cpass);
    
            // Verifica se o email e a senha estão corretos
            if ($emailDB === $this->userLogin && $passwordDB === $userPassword) {
                // Inicia a sessão e armazena o usuário logado
              
                session_start();
                $_SESSION['usuario'] = $this->userLogin;
                // Redireciona para a página de empréstimos
                header('Location: http://localhost/projeto-biblioteca/emprestimo.php');
                 // Interrompe a execução do script após o redirecionamento
                exit();


            } else {
                // Retorna mensagem de erro se as credenciais forem inválidas
                $result = [
                    'status' => false,
                    'msg' => "Usuário ou senha inválidos.",
                    'usuario' => $this->userLogin,
                ];
            }
        } else {
            // Retorna mensagem de erro se o usuário não for encontrado
            $result = [
                'status' => false,
                'msg' => "Usuário não encontrado.",
                'usuario' => $this->userLogin,
            ];
        }
    
        // Retorna o resultado da validação
        return $this->fxLogin = $result;
    }
    

//-----------CADASTRO DE USUARIOS--------------------------------//
    public function cadastroLogin(String $fxLogin)
{
    $newEmail = $this->newEmail;
    $newUser = $this->newUser;
    $cpf = $this->cpf;
    $userPassword = $this->userPassword;
    $acesso = "1";

    require "../config/db/conn.php";

    // Verifica se o email já está registrado no banco de dados
    $sql = "SELECT * FROM tbl_login WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $newEmail);
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
            'usuario_banco' => $emailDB
        ];
    } else {
        $crypt = new Crypt();

        // Criptografa a senha e gera o hash
        $hashedPassword = $crypt->CryptPass($newEmail, $userPassword);
        $hash = $crypt->CryptHash($newEmail, $userPassword);

        // Insere o novo usuário no banco de dados
        $insertSql = "INSERT INTO tbl_login (idLogin, nome, email, cpf, senha, FK_idAcesso, hash) 
                      VALUES (null, :nome, :email, :cpf, :senha, :acesso, :hash)";
        $insertStmt = $conn->prepare($insertSql);

        // Executa a inserção
        $insertStmt->execute([
            ':nome' => $newUser,
            ':email' => $newEmail,
            ':cpf' => $cpf,
            ':senha' => $hashedPassword,
            ':acesso' => $acesso,
            ':hash' => $hash
        ]);

        $result = [
            'status' => true,
            'msg' => "Cadastro realizado com sucesso",
        ];
    }

    // Retorna o resultado da operação
    return $this->fxLogin = $result;
}

    
}