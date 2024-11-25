<?php
require_once "Database.php";
require_once "GenericInterface.php";

class Vendedor implements GenericInterface
{
    private $id;
    private $nome;
    private $endereco;
    private $cidade;
    private $estado;
    private $celular;
    private $email;
    private $perc_comissao;
    private $data_admissao;
    private $senha;
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPercComissao()
    {
        return $this->perc_comissao;
    }

    public function setPercComissao($perc_comissao)
    {
        $this->perc_comissao = $perc_comissao;
    }

    public function getDataAdmissao()
    {
        return $this->data_admissao;
    }

    public function setDataAdmissao($data_admissao)
    {
        $this->data_admissao = $data_admissao;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @throws Exception
     */
    public function save(): bool
    {
        if (!$this->conn) {
            throw new Exception("Erro ao conectar ao banco de dados.");
        }

        try {
            if ($this->id) {
                $stmt = mysqli_prepare($this->conn, "UPDATE vendedor SET nome=?, endereco=?, cidade=?, estado=?, celular=?, email=?, perc_comissao=?, data_admissao=?, senha=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "ssssssssss", $this->nome, $this->endereco, $this->cidade, $this->estado, $this->celular, $this->email, $this->perc_comissao, $this->data_admissao, $this->senha, $this->id);
            } else {
                $stmt = mysqli_prepare($this->conn, "INSERT INTO vendedor (nome, endereco, cidade, estado, celular, email, perc_comissao, data_admissao, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sssssssss", $this->nome, $this->endereco, $this->cidade, $this->estado, $this->celular, $this->email, $this->perc_comissao, $this->data_admissao, $this->senha);
            }

            return mysqli_stmt_execute($stmt);
        } catch (mysqli_sql_exception $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    /**
     * @param $id
     * @return Vendedor|null
     */
    public function getById($id): Vendedor|null
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM vendedor WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $vendedor = new Vendedor();
            $vendedor->setId($data['id']);
            $vendedor->setNome($data['nome']);
            $vendedor->setEndereco($data['endereco']);
            $vendedor->setCidade($data['cidade']);
            $vendedor->setEstado($data['estado']);
            $vendedor->setCelular($data['celular']);
            $vendedor->setEmail($data['email']);
            $vendedor->setPercComissao($data['perc_comissao']);
            $vendedor->setDataAdmissao($data['data_admissao']);
            $vendedor->setSenha($data['senha']);
            return $vendedor;
        }
        return null;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM vendedor");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $vendedores = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $vendedores[] = [
                'id' => $data['id'],
                'nome' => $data['nome'],
                'endereco' => $data['endereco'],
                'cidade' => $data['cidade'],
                'estado' => $data['estado'],
                'celular' => $data['celular'],
                'email' => $data['email'],
                'perc_comissao' => $data['perc_comissao'],
                'data_admissao' => $data['data_admissao'],
                'senha' => $data['senha']
            ];
        }
        return $vendedores;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM vendedor WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    /**
     * @param string $email
     * @param string $senha
     * @return Vendedor|null
     */
    public function getByCredentials(string $email, string $senha): ?Vendedor
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM vendedor WHERE email = ? AND senha = ?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $senha);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($data = mysqli_fetch_assoc($result)) {
            $vendedor = new Vendedor();
            $vendedor->setId($data['id']);
            $vendedor->setNome($data['nome']);
            $vendedor->setEndereco($data['endereco']);
            $vendedor->setCidade($data['cidade']);
            $vendedor->setEstado($data['estado']);
            $vendedor->setCelular($data['celular']);
            $vendedor->setEmail($data['email']);
            $vendedor->setPercComissao($data['perc_comissao']);
            $vendedor->setDataAdmissao($data['data_admissao']);
            $vendedor->setSenha($data['senha']);
            return $vendedor;
        }

        return null;
    }

    /**
     * @param int|null $vendedorId
     * @return bool
     */
    public function deleteById(?int $vendedorId): bool
    {
        if(!empty($vendedorId)){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM vendedor WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $vendedorId);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
