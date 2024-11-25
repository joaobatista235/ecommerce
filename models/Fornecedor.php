<?php
require_once "Database.php";
require_once "GenericInterface.php";

class Fornecedor implements GenericInterface
{
    private $id;
    private $nome;
    private $contato;
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    public function getContato()
    {
        return $this->contato;
    }

    public function setContato($contato): void
    {
        $this->contato = $contato;
    }

    /**
     * Converts the Fornecedor object into an associative array.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'contato' => $this->getContato(),
        ];
    }

    /**
     * Save or update the fornecedor in the database
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "UPDATE fornecedores SET nome = ?, contato = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssi", $this->nome, $this->contato, $this->id);
        } else {
            $stmt = mysqli_prepare($this->conn, "INSERT INTO fornecedores (nome, contato) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $this->nome, $this->contato);
        }
        return mysqli_stmt_execute($stmt);
    }

    /**
     * Get a fornecedor by its ID
     * @param int $id
     * @return Fornecedor|null
     */
    public function getById(int $id): ?Fornecedor
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM fornecedores WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $fornecedor = new Fornecedor();
            $fornecedor->setId($data['id']);
            $fornecedor->setNome($data['nome']);
            $fornecedor->setContato($data['contato']);
            return $fornecedor;
        }
        return null;
    }

    /**
     * Get all fornecedores
     * @return array
     */
    /**
     * Get all fornecedores as an array of associative arrays.
     * @return array
     */
    public function getAll(): array
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM fornecedores");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $fornecedores = [];

        while ($data = mysqli_fetch_assoc($result)) {
            // Create a Fornecedor object and set its properties
            $fornecedor = new Fornecedor();
            $fornecedor->setId($data['id']);
            $fornecedor->setNome($data['nome']);
            $fornecedor->setContato($data['contato']);

            // Add the Fornecedor object to the array
            $fornecedores[] = $fornecedor;
        }

        return $fornecedores;
    }



    /**
     * Delete the current fornecedor
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM fornecedores WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    /**
     * Delete a fornecedor by ID
     * @param int|null $fornecedorId
     * @return bool
     */
    public function deleteById(?int $fornecedorId): bool
    {
        if (!empty($fornecedorId)) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM fornecedores WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $fornecedorId);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
