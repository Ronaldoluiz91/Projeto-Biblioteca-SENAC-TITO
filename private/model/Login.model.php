<?php
include_once('Crypt.model.php');
//Criando a classe de LOGIN
class LOGIN
{
    private $userLogin;
    private $userPassword;
    private $newUser;
    private $newEmail;
    private $whatsapp;
    private $confirmPassword;
    private $cpf;
    private $acesso;
    private $idRec;


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

    public function setWhatsapp(string $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }
    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    public function setCpf(String $cpf)
    {
        $this->cpf = $cpf;
    }
    public function getCpf()
    {
        return $this->cpf;
    }

    //Função para atualizar senha
    public function setIdRec(string $idRec)
    {
        $this->idRec = $idRec;
    }

    public function getIdRec()
    {
        return $this->idRec;
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
        $idLogin = "";

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extrai os dados do banco de dados
            $emailDB = $row['email'];
            $passwordDB = $row['senha'];
            $acesso = $row['FK_idAcesso'];
            $idLogin = $row['idLogin'];

            include_once('Crypt.model.php');
            $Crypt = new Crypt();

            // Criptografa a senha inserida pelo usuário
            $Cemail = $emailDB;
            $Cpass = $this->userPassword;

            $userPassword = $Crypt->CryptPass($Cemail, $Cpass);
            $userHash = $Crypt->CryptHash($Cemail, $Cpass);

            // Verifica se o email e a senha estão corretos 
            if ($emailDB === $this->userLogin && $passwordDB === $userPassword) {
                // Verifica o acesso (Usuario ou Admin)
                if ($acesso == 1) {
                    $result = [
                        'status' => true,
                        // 'msg' => "Usuario valido",
                        'idLogin' => $idLogin, // Adicione o idLogin ao retorno
                        'dashboard' => 'http://localhost/projeto-biblioteca/Dashboard-client.php',
                    ];
                } else {
                    $result = [
                        'status' => true,
                        // 'msg' => "Usuario valido",
                        'idLogin' => $idLogin, // Adicione o idLogin ao retorno
                        'dashboard' => 'http://localhost/projeto-biblioteca/Dashboard-adm.php',
                    ];
                }
            } else {
                // Retorna mensagem de erro se as credenciais forem inválidas
                $result = [
                    'status' => false,
                    'msg' => "Usuário ou senha inválido.",
                    'usuario' => $this->userLogin,
                ];
            }
        } else {
            $result = [
                'status' => false,
                'msg' => "Usuário não cadastrado",
                'usuario' => $this->userLogin,
            ];
        }
        // Retorna o resultado da validação
        return $this->fxLogin = $result;

        // Fechar a conexão após todas as operações
        $conn = null;
    }


    //-----------CADASTRO DE USUARIOS--------------------------------//
    public function cadastroLogin(String $fxLogin)
    {
        $newEmail = $this->newEmail;
        $newUser = $this->newUser;
        $whatsapp = $this->whatsapp;
        $cpf = $this->cpf;
        $userPassword = $this->userPassword;
        $acesso = "1";

        require "../config/db/conn.php";

        // Verifica se o email ou cpf já está registrado no banco de dados
        $sql = "SELECT * FROM tbl_login WHERE email = :email OR cpf = :cpf";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();

        $emailDB = "";
        $cpfDB = "";


        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emailDB = $row['email'];
            $cpfDB = $row['cpf'];
        }

        // Verifica se o email ou cpf  já está registrado
        if ($emailDB === $newEmail || $cpfDB === $cpf) {
            $result = [
                'status' => false,
                'msg' => "Email ou CPF já registrado",
            ];
        } else {
            $crypt = new Crypt();

            // Criptografa a senha e gera o hash
            $hashedPassword = $crypt->CryptPass($newEmail, $userPassword);
            $hash = $crypt->CryptHash($newEmail, $userPassword);

            // Insere o novo usuário no banco de dados
            $insertSql = "INSERT INTO tbl_login (idLogin, nome, email, whatsapp, cpf, senha, FK_idAcesso, hash) 
                      VALUES (null, :nome, :email, :whatsapp, :cpf, :senha, :acesso, :hash)";
            $insertStmt = $conn->prepare($insertSql);

            // Executa a inserção
            $insertStmt->execute([
                ':nome' => $newUser,
                ':email' => $newEmail,
                ':whatsapp' => $whatsapp,
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

        // Fechar a conexão após todas as operações
        $conn = null;
    }


    //-------------FUNÇÃO PARA RECUPERAÇÃO DE SENHA

    public function recoveryLogin(String $fxLogin)
    {
        require_once("../config/db/conn.php");

        $sql = "SELECT nome, email, hash FROM tbl_login WHERE email = :userEmail";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userEmail', $this->userLogin);

        $stmt->execute();

        $userEmailDB = "";

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $userEmailDB = $row['email'];
            $userHash = $row['hash'];
            $userNameDB = $row['nome'];
        }

        if ($userEmailDB != $this->userLogin) {
            $result = [
                'status' => false,
                'msg' => 'usuario ou email não cadastrado'
            ];
        } else {
            $url = "http://localhost/projeto-biblioteca/password-reset.php?idRec=$userHash";

            $result = [
                'status' => true,
                'msg' => "<h2>Recuperar Senha</h2>
            <p> Caro usuario $userNameDB , voce solicitou a recuperação de senha do Sistema</p>
            <p>Segue o link para recuperar a senha clique abaixo ou se preferir cole no seu navegador</p>
            <p><a href='$url' target='_blank'>$url<a/></p>
            <p>Caso não tenha solicitado, desconsidere este email</p> "
            ];
        }
        return $this->fxLogin = $result;

        // Fechar a conexão após todas as operações
        $conn = null;
    }

    //-------- FUNÇÃO PARA INCLUIR NOVA SENHA NO DB----------------
    public function passwordReset(string $fxLogin)
    {
        require_once("../config/db/conn.php");

        $sql = "SELECT nome, email, hash FROM tbl_login WHERE email= :userEmail ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('userEmail', $this->userLogin);
        $stmt->execute();

        $emailDB = "";
        $hashDB = "";

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emailDB = $row['email'];
            $hashDB = $row['hash'];
            $nameDB = $row['nome'];
        }

        if (!((($emailDB === $this->userLogin) && ($hashDB === $this->idRec)))) {
            $result = [
                'status' => false,
                'msg' => 'email ou seu idec invalido'
            ];
        } else {
            include_once("Crypt.model.php");
            $Crypt = new Crypt();
            $Cpass = $this->userPassword;
            $Cemail = $emailDB;

            $passCP = $Crypt->CryptPass($Cemail, $Cpass);
            $hashCP = $Crypt->CryptHash($Cemail, $Cpass);

            //Preparando update
            $sql = "UPDATE tbl_login SET senha = :passCP, hash = :hashCP WHERE email=:emailDB";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':passCP', $passCP);
            $stmt->bindParam(':hashCP', $hashCP);
            $stmt->bindParam(':emailDB', $emailDB);
            $stmt->execute();


            $result = [
                'status' => true,
                'msg' => 'Usúario sua senha foi alterada com sucesso'
            ];
        }

        return $this->fxLogin = $result;

        // Fechar a conexão após todas as operações
        $conn = null;
    }
}
