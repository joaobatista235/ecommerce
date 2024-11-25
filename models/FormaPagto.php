<?php
require_once "Database.php";
require_once "GenericInterface.php";

class FormaPagto implements GenericInterface
{
    private $id;
    private $nome;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "UPDATE forma_pagto SET nome=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "si", $this->nome, $this->id);
        } else {
            $stmt = mysqli_prepare($this->conn, "INSERT INTO forma_pagto (nome) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $this->nome);
        }
        return mysqli_stmt_execute($stmt);
    }

    /**
     * @param int $id
     * @return FormaPagto|null
     */
    public function getById(int $id): ?FormaPagto
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM forma_pagto WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $formaPagto = new FormaPagto();
            $formaPagto->setId($data['id']);
            $formaPagto->setNome($data['nome']);
            return $formaPagto;
        }
        return null;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $stmt = mysqli_prepare($this->conn, "SELECT * FROM forma_pagto");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $formas = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $formas[] = [
                'id' => $data['id'],
                'nome' => $data['nome']
            ];
        }
        return $formas;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM forma_pagto WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    /**
     * @param int|null $pagamentoId
     * @return bool
     */
    public function deleteById(?int $pagamentoId): bool
    {
        if (!empty($pagamentoId)) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM forma_pagto WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $pagamentoId);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
