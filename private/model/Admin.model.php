<?php

class LIVRO
{
    private $nomeLivro;
    private $quantidade;
    private $condicao;
    private $anoLancamento;
    private $autor;
    private $codigo;
    private $andar;



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

    public function setAnoLancamento(string $anoLancamento)
    {
        $this->anoLancamento = $anoLancamento;
    }
    public function getAnoLancamento()
    {
        return $this->anoLancamento;
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
    public function setAndar(string $andar)
    {
        $this->andar = $andar;
    }
    public function getAndar()
    {
        return $this->andar;
    }


    public function addLivro()
    {
        $nomeLivro = $this->nomeLivro;
        $quantidade = $this->quantidade;
        $condicao = $this->condicao;
        $autor = $this->autor;
        $ano = $this->anoLancamento;
        $codigo = $this->codigo;
        $andar = $this->andar;

        $statusLivro = 4;  // cada novo cadastro de livro o status entra como disponivel

        require "../config/db/conn.php";

        // Insere o novo livro no banco de dados
        $insertSql = "INSERT INTO tbl_livro (idCadLivro, nomeLivro, quantidadeDisp, condicao, codigoLivro, autor, anoLancamento, FK_andar, FK_status) 
          VALUES (null, :nomeLivro, :quantidade, :condicao, :codigoLivro, :autor, :ano, :andar , :statusLivro)";
        $insertStmt = $conn->prepare($insertSql);

        // Executa a inserção
        $insertStmt->execute([
            ':nomeLivro' => $nomeLivro,
            ':quantidade' => $quantidade,
            ':condicao' => $condicao,
            ':codigoLivro' => $codigo,
            ':autor' => $autor,
            ':ano' => $ano,
            'andar' => $andar,
            'statusLivro' => $statusLivro,
        ]);

        $result = [
            'status' => true,
            'msg' => "Cadastro realizado com sucesso",
        ];

        return $result;
    }

    
}
