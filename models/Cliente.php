<?php
require_once "Database.php";
require_once "GenericInterface.php";

class Cliente implements GenericInterface
{
    private $id;
    private $nome;
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $email;
    private $cpf_cnpj;
    private $rg;
    private $telefone;
    private $celular;
    private $data_nasc;
    private $salario;
    private static $conn;

    public function __construct()
    {
        // Use a singleton pattern for the database connection
        if (!self::$conn) {
            self::$conn = (new Database())->getConnection();
        }
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCpfCnpj()
    {
        return $this->cpf_cnpj;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function getDataNasc()
    {
        return $this->data_nasc;
    }

    public function getSalario()
    {
        return $this->salario;
    }


    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCpfCnpj($cpf_cnpj)
    {
        $this->cpf_cnpj = $cpf_cnpj;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    public function setDataNasc($data_nasc)
    {
        $this->data_nasc = $data_nasc;
    }

    public function setSalario($salario)
    {
        $this->salario = $salario;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare(
                self::$conn,
                "UPDATE clientes SET nome=?, endereco=?, numero=?, bairro=?, cidade=?, estado=?, email=?, cpf_cnpj=?, rg=?, telefone=?, celular=?, data_nasc=?, salario=? WHERE id=?"
            );
            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssssssdi",
                $this->nome,
                $this->endereco,
                $this->numero,
                $this->bairro,
                $this->cidade,
                $this->estado,
                $this->email,
                $this->cpf_cnpj,
                $this->rg,
                $this->telefone,
                $this->celular,
                $this->data_nasc,
                $this->salario,
                $this->id
            );
        } else {
            $stmt = mysqli_prepare(
                self::$conn,
                "INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssssssd",
                $this->nome,
                $this->endereco,
                $this->numero,
                $this->bairro,
                $this->cidade,
                $this->estado,
                $this->email,
                $this->cpf_cnpj,
                $this->rg,
                $this->telefone,
                $this->celular,
                $this->data_nasc,
                $this->salario
            );
        }

        if (!mysqli_stmt_execute($stmt)) {
            error_log("Erro no save(): " . mysqli_error(self::$conn));
            mysqli_stmt_close($stmt);
            return false;
        }

        mysqli_stmt_close($stmt);
        return true;
    }

    /**
     * @param $id
     * @return Cliente|null
     */
    public function getById($id): ?Cliente
    {
        $stmt = mysqli_prepare(self::$conn, "SELECT * FROM clientes WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente();
            $cliente->setId($data['id']);
            $cliente->setNome($data['nome']);
            $cliente->setEndereco($data['endereco']);
            $cliente->setNumero($data['numero']);
            $cliente->setBairro($data['bairro']);
            $cliente->setCidade($data['cidade']);
            $cliente->setEstado($data['estado']);
            $cliente->setEmail($data['email']);
            $cliente->setCpfCnpj($data['cpf_cnpj']);
            $cliente->setRg($data['rg']);
            $cliente->setTelefone($data['telefone']);
            $cliente->setCelular($data['celular']);
            $cliente->setDataNasc($data['data_nasc']);
            $cliente->setSalario($data['salario']);
            return $cliente;
        }
        return null;
    }

    public static function getByEmail($email, Database $connexao = null)
    {
        $stmt = mysqli_prepare(self::$conn, "SELECT * FROM clientes WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente();
            $cliente->setId($data['id']);
            $cliente->setNome($data['nome']);
            $cliente->setEndereco($data['endereco']);
            $cliente->setNumero($data['numero']);
            $cliente->setBairro($data['bairro']);
            $cliente->setCidade($data['cidade']);
            $cliente->setEstado($data['estado']);
            $cliente->setEmail($data['email']);
            $cliente->setCpfCnpj($data['cpf_cnpj']);
            $cliente->setRg($data['rg']);
            $cliente->setTelefone($data['telefone']);
            $cliente->setCelular($data['celular']);
            $cliente->setDataNasc($data['data_nasc']);
            $cliente->setSalario($data['salario']);
            return $cliente;
        }
        return null;
    }

    /**
     * @return Cliente[]
     */
    public function getAll(): array
    {
        $stmt = mysqli_prepare(self::$conn, "SELECT * FROM clientes");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $clientes = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $cliente['id'] = $data['id'];
            $cliente['nome'] = $data['nome'];
            $cliente['endereco'] = $data['endereco'];
            $cliente['numero'] = $data['numero'];
            $cliente['bairro'] = $data['bairro'];
            $cliente['cidade'] = $data['cidade'];
            $cliente['estado'] = $data['estado'];
            $cliente['email'] = $data['email'];
            $cliente['cpf_cnpj'] = $data['cpf_cnpj'];
            $cliente['rg'] = $data['rg'];
            $cliente['telefone'] = $data['telefone'];
            $cliente['celular'] = $data['celular'];
            $cliente['data_nasc'] = $data['data_nasc'];
            $cliente['salario'] = $data['salario'];

            $clientes[] = $cliente;
        }

        return $clientes;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare(self::$conn, "DELETE FROM clientes WHERE id = ?");
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
        if ($id) {
            mysqli_begin_transaction(self::$conn);

            try {
                $query = "DELETE FROM itens_pedido WHERE id_pedido IN (SELECT id FROM pedidos WHERE id_cliente = ?)";
                $stmt = mysqli_prepare(self::$conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);

                $stmt = mysqli_prepare(self::$conn, "DELETE FROM pedidos WHERE id_cliente = ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);

                $stmt = mysqli_prepare(self::$conn, "DELETE FROM clientes WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);

                mysqli_commit(self::$conn);
                return true;
            } catch (Exception $e) {
                mysqli_rollback(self::$conn);
                return false;
            } finally {
                mysqli_stmt_close($stmt);
                mysqli_close(self::$conn);
            }
        }
        return false;
    }
}
