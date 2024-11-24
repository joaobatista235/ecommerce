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
    private static $conn;

    public function __construct()
    {
        // Use a singleton pattern for the database connection
        if (!self::$conn) {
            self::$conn = (new Database())->getConnection();
        }
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
        $this->promocao = ($promocao === 'Y' || $promocao === 'N') ? $promocao : 'N';
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare(self::$conn, "UPDATE produto SET nome=?, qtde_estoque=?, preco=?, unidade_medida=?, promocao=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "sisssi", $this->nome, $this->qtde_estoque, $this->preco, $this->unidade_medida, $this->promocao, $this->id);
        } else {
            $stmt = mysqli_prepare(self::$conn, "INSERT INTO produto (nome, qtde_estoque, preco, unidade_medida, promocao) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sisss", $this->nome, $this->qtde_estoque, $this->preco, $this->unidade_medida, $this->promocao);
        }

        return mysqli_stmt_execute($stmt);
    }

    /**
     * @param $id
     * @return Produto|null
     */
    public function getById($id): ?Produto
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM produto WHERE id = ?");
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

    /**
     * @return array
     */
    public function getAll(): array
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM produto");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $produtos = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $produtos[] = [
                'id' => $data['id'],
                'nome' => $data['nome'],
                'qtde_estoque' => $data['qtde_estoque'],
                'preco' => $data['preco'],
                'unidade_medida' => $data['unidade_medida'],
                'promocao' => $data['promocao']
            ];
        }
        return $produtos;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare(self::$conn, "DELETE FROM produto WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    /**
     * @param int|null $id
     * @return bool
     */
    public function deleteById(?int $id): bool
    {
        if (!empty($id)) {
            $stmt = mysqli_prepare(self::$conn, "DELETE FROM produto WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                return true;
            } else {
                error_log('Erro ao executar DELETE: ' . mysqli_error(self::$conn));
                return false;
            }
        }
        return false;
    }
}
