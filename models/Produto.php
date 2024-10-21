<?php
require_once "Database.php";
require_once "GenericInterface.php";

class Produto implements GenericInterface
{
    private $id;
    private $nome;
    private $qtde_estoque;
    private $preco;
    private $unidade_medida;
    private $promocao;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getQtdeEstoque()
    {
        return $this->qtde_estoque;
    }
    public function getPreco()
    {
        return $this->preco;
    }
    public function getUnidadeMedida()
    {
        return $this->unidade_medida;
    }
    public function getPromocao()
    {
        return $this->promocao;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function setQtdeEstoque($qtde_estoque)
    {
        $this->qtde_estoque = $qtde_estoque;
    }
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }
    public function setUnidadeMedida($unidade_medida)
    {
        $this->unidade_medida = $unidade_medida;
    }
    public function setPromocao($promocao)
    {
        $this->promocao = $promocao;
    }

    public function save()
    {
        if ($this->id) {
            $stmt = mysqli_prepare((new Database())->getConnection(), "UPDATE produto SET nome=?, qtde_estoque=?, preco=?, unidade_medida=?, promocao=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "sisisi", $this->nome, $this->qtde_estoque, $this->preco, $this->unidade_medida, $this->promocao, $this->id);
        } else {
            $stmt = mysqli_prepare((new Database())->getConnection(), "INSERT INTO produto (nome, qtde_estoque, preco, unidade_medida, promocao) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sisii", $this->nome, $this->qtde_estoque, $this->preco, $this->unidade_medida, $this->promocao);
        }
        return mysqli_stmt_execute($stmt);
    }

    public static function getById($id)
    {
        $stmt = mysqli_prepare((new Database())->getConnection(), "SELECT * FROM produto WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $produto = new Produto();
            $produto->setId($data['id']);
            $produto->setNome($data['nome']);
            $produto->setQtdeEstoque($data['qtde_estoque']);
            $produto->setPreco($data['preco']);
            $produto->setUnidadeMedida($data['unidade_medida']);
            $produto->setPromocao($data['promocao']);
            return $produto;
        }
        return null;
    }

    public static function getAll()
    {
        $stmt = mysqli_prepare((new Database())->getConnection(), "SELECT * FROM produto");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $produtos = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $produto = new Produto();
            $produto->setId($data['id']);
            $produto->setNome($data['nome']);
            $produto->setQtdeEstoque($data['qtde_estoque']);
            $produto->setPreco($data['preco']);
            $produto->setUnidadeMedida($data['unidade_medida']);
            $produto->setPromocao($data['promocao']);
            $produtos[] = $produto;
        }
        return $produtos;
    }

    public function delete()
    {
        if ($this->id) {
            $stmt = mysqli_prepare((new Database())->getConnection(), "DELETE FROM produto WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
