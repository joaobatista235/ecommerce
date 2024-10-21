<?php
require_once "Database.php";
require_once "GenericInterface.php";

class FormaPagto implements GenericInterface
{
    private $id;
    private $nome;

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

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function save()
    {
        if ($this->id) {
            $stmt = mysqli_prepare((new Database())->getConnection(), "UPDATE forma_pagto SET nome=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "si", $this->nome, $this->id);
        } else {
            $stmt = mysqli_prepare((new Database())->getConnection(), "INSERT INTO forma_pagto (nome) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $this->nome);
        }
        return mysqli_stmt_execute($stmt);
    }

    public static function getById($id)
    {
        $stmt = mysqli_prepare((new Database())->getConnection(), "SELECT * FROM forma_pagto WHERE id = ?");
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

    public static function getAll()
    {
        $stmt = mysqli_prepare((new Database())->getConnection(), "SELECT * FROM forma_pagto");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $formas = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $formaPagto = new FormaPagto();
            $formaPagto->setId($data['id']);
            $formaPagto->setNome($data['nome']);
            $formas[] = $formaPagto;
        }
        return $formas;
    }

    public function delete()
    {
        if ($this->id) {
            $stmt = mysqli_prepare((new Database())->getConnection(), "DELETE FROM forma_pagto WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
