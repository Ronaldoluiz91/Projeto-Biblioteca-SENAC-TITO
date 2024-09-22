<?php

class LIVRO
{
    private $nomeLivro;
    private $quantidade;
    private $condicao;
    private $autor;
    private $codigo;



    public function setNomeLivro(string $nomeLivro)
    {
        $this->nomeLivro = $nomeLivro;
    }

    public function getNomeLivro(string $nomeLivro)
    {
        return $this->nomeLivro;
    }

    public function setQuantidade(string $quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getQuantidade(string $quantidade)
    {
        return $this->quantidade;
    }


    public function setCondicao(string $condicao)
    {
        $this->condicao = $condicao;
    }

    public function getCondicao(string $condicao)
    {
        return $this->condicao;
    }

    public function setAutor(string $autor)
    {
        $this->autor = $autor;
    }

    public function getAutor(string $autor)
    {
        return $this->autor;
    }

    public function setCodigo(string $codigo)
    {
        $this->codigo = $codigo;
    }

    public function getCodigo(string $codigo)
    {
        return $this->codigo;
    }

    public function addLivro()
    {
        $nomeLivro = $this->nomeLivro;
        $quantidade = $this->quantidade;
        $condicao = $this->condicao;
        $autor = $this->autor;
        $codigo = $this->codigo;

        require "../config/db/conn.php";

        // Insere o novo livro no banco de dados
        $insertSql = "INSERT INTO tbl_livro (idCadLivro, nomeLivro, quantidadeDisp, condicao, codigoLivro, autor) 
          VALUES (null, :nomeLivro, :quantidade, :condicao, :codigoLivro, :autor)";
        $insertStmt = $conn->prepare($insertSql);

        // Executa a inserção
        $insertStmt->execute([
            ':nomeLivro' => $nomeLivro,
            ':quantidade' => $quantidade,
            ':condicao' => $condicao,
            ':codigoLivro' => $codigo,
            ':autor' => $autor
        ]);

        $result = [
            'status' => true,
            'msg' => "Cadastro realizado com sucesso",
        ];

        return $result;
    }
}
