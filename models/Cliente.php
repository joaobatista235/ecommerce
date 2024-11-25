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
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // Getters and setters
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

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCpf_Cnpj()
    {
        return $this->cpf_cnpj;
    }

    public function setCpf_Cnpj($cpf_cnpj)
    {
        $this->cpf_cnpj = $cpf_cnpj;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    public function getDataNasc()
    {
        return $this->data_nasc;
    }

    public function setDataNasc($data_nasc)
    {
        $this->data_nasc = $data_nasc;
    }

    public function getSalario()
    {
        return $this->salario;
    }

    public function setSalario($salario)
    {
        $this->salario = $salario;
    }

    /**
     * Converts the Cliente object into an associative array.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'email' => $this->email,
            'cpf_cnpj' => $this->cpf_cnpj,
            'rg' => $this->rg,
            'telefone' => $this->telefone,
            'celular' => $this->celular,
            'data_nasc' => $this->data_nasc,
            'salario' => $this->salario,
        ];
    }

    /**
     * Save or update the cliente in the database.
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare(
                $this->conn,
                "UPDATE clientes SET nome = ?, endereco = ?, numero = ?, bairro = ?, cidade = ?, estado = ?, email = ?, cpf_cnpj = ?, rg = ?, telefone = ?, celular = ?, data_nasc = ?, salario = ? WHERE id = ?"
            );
            mysqli_stmt_bind_param($stmt, "ssssssssssssdi", $this->nome, $this->endereco, $this->numero, $this->bairro, $this->cidade, $this->estado, $this->email, $this->cpf_cnpj, $this->rg, $this->telefone, $this->celular, $this->data_nasc, $this->salario, $this->id);
        } else {
            $stmt = mysqli_prepare(
                $this->conn,
                "INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "ssssssssssssd", $this->nome, $this->endereco, $this->numero, $this->bairro, $this->cidade, $this->estado, $this->email, $this->cpf_cnpj, $this->rg, $this->telefone, $this->celular, $this->data_nasc, $this->salario);
        }
        return mysqli_stmt_execute($stmt);
    }

    /**
     * Get a cliente by its ID.
     * @param int $id
     * @return Cliente|null
     */
    public function getById(int $id): ?Cliente
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM clientes WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente();
            foreach ($data as $key => $value) {
                $setter = "set" . ucfirst(str_replace('_', '', $key));
                if (method_exists($cliente, $setter)) {
                    $cliente->$setter($value);
                }
            }
            return $cliente;
        }
        return null;
    }


    /**
     * Get all clientes as an array of Cliente objects.
     * @return array
     */
    public function getAll(): array
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM clientes");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $clientes = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente();

            if (isset($data['id'])) {
                $cliente->setId($data['id']);
            }
            if (isset($data['nome'])) {
                $cliente->setNome($data['nome']);
            }
            if (isset($data['endereco'])) {
                $cliente->setEndereco($data['endereco']);
            }
            if (isset($data['numero'])) {
                $cliente->setNumero($data['numero']);
            }
            if (isset($data['bairro'])) {
                $cliente->setBairro($data['bairro']);
            }
            if (isset($data['cidade'])) {
                $cliente->setCidade($data['cidade']);
            }
            if (isset($data['estado'])) {
                $cliente->setEstado($data['estado']);
            }
            if (isset($data['email'])) {
                $cliente->setEmail($data['email']);
            }
            if (isset($data['cpf_cnpj'])) {
                $cliente->setCpf_Cnpj($data['cpf_cnpj']);
            }
            if (isset($data['rg'])) {
                $cliente->setRg($data['rg']);
            }
            if (isset($data['telefone'])) {
                $cliente->setTelefone($data['telefone']);
            }
            if (isset($data['celular'])) {
                $cliente->setCelular($data['celular']);
            }
            if (isset($data['data_nasc'])) {
                $cliente->setDataNasc($data['data_nasc']);
            }
            if (isset($data['salario'])) {
                $cliente->setSalario($data['salario']);
            }

            $clientes[] = $cliente;
        }

        return $clientes;
    }


    /**
     * Delete the current cliente.
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM clientes WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    /**
     * Delete a cliente by ID.
     * @param int|null $clienteId
     * @return bool
     */
    public function deleteById(?int $clienteId): bool
    {
        if (!empty($clienteId)) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM clientes WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $clienteId);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    /**
     * @param array $options
     * @return array
     */
    public function getClients(array $options): array
    {
        $query = "SELECT * FROM clientes WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($options['nome'])) {
            $query .= " AND nome LIKE ?";
            $params[] = '%' . $options['nome'] . '%';
            $types .= "s";
        }
        if (!empty($options['endereco'])) {
            $query .= " AND endereco LIKE ?";
            $params[] = '%' . $options['endereco'] . '%';
            $types .= "s";
        }
        if (!empty($options['cidade'])) {
            $query .= " AND cidade LIKE ?";
            $params[] = '%' . $options['cidade'] . '%';
            $types .= "s";
        }

        $stmt = mysqli_prepare($this->conn, $query);

        if ($params) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $clientes = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente();

            if (isset($data['id'])) {
                $cliente->setId($data['id']);
            }
            if (isset($data['nome'])) {
                $cliente->setNome($data['nome']);
            }
            if (isset($data['endereco'])) {
                $cliente->setEndereco($data['endereco']);
            }
            if (isset($data['numero'])) {
                $cliente->setNumero($data['numero']);
            }
            if (isset($data['bairro'])) {
                $cliente->setBairro($data['bairro']);
            }
            if (isset($data['cidade'])) {
                $cliente->setCidade($data['cidade']);
            }
            if (isset($data['estado'])) {
                $cliente->setEstado($data['estado']);
            }
            if (isset($data['email'])) {
                $cliente->setEmail($data['email']);
            }
            if (isset($data['cpf_cnpj'])) {
                $cliente->setCpf_Cnpj($data['cpf_cnpj']);
            }
            if (isset($data['rg'])) {
                $cliente->setRg($data['rg']);
            }
            if (isset($data['telefone'])) {
                $cliente->setTelefone($data['telefone']);
            }
            if (isset($data['celular'])) {
                $cliente->setCelular($data['celular']);
            }
            if (isset($data['data_nasc'])) {
                $cliente->setDataNasc($data['data_nasc']);
            }
            if (isset($data['salario'])) {
                $cliente->setSalario($data['salario']);
            }

            $clientes[] = $cliente;
        }

        return $clientes;
    }
}
