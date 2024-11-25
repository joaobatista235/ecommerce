<?php
require_once "Database.php";
require_once "GenericInterface.php";

class Pedido implements GenericInterface
{
    private $id;
    private $id_cliente;
    private $id_vendedor;
    private $data;
    private $observacao;
    private $forma_pagto;
    private $prazo_entrega;
    private $nome_cliente; // New property
    private $nome_vendedor; // New propert
    private $conn;

    public function getNomeCliente()
    {
        return $this->nome_cliente;
    }

    public function setNomeCliente($nome_cliente): void
    {
        $this->nome_cliente = $nome_cliente;
    }

    public function getNomeVendedor()
    {
        return $this->nome_vendedor;
    }

    public function setNomeVendedor($nome_vendedor): void
    {
        $this->nome_vendedor = $nome_vendedor;
    }

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getIdCliente()
    {
        return $this->id_cliente;
    }
    public function getIdVendedor()
    {
        return $this->id_vendedor;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getObservacao()
    {
        return $this->observacao;
    }
    public function getFormaPagto()
    {
        return $this->forma_pagto;
    }
    public function getPrazoEntrega()
    {
        return $this->prazo_entrega;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }
    public function setIdVendedor($id_vendedor)
    {
        $this->id_vendedor = $id_vendedor;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
    }
    public function setFormaPagto($forma_pagto)
    {
        $this->forma_pagto = $forma_pagto;
    }
    public function setPrazoEntrega($prazo_entrega)
    {
        $this->prazo_entrega = $prazo_entrega;
    }

    // Save Method (INSERT or UPDATE)
    public function save()
    {
        if ($this->id) {
            // Update existing Pedido
            $stmt = mysqli_prepare($this->conn, "UPDATE pedidos SET id_cliente=?, id_vendedor=?, data=?, observacao=?, forma_pagto=?, prazo_entrega=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "iissisi", $this->id_cliente, $this->id_vendedor, $this->data, $this->observacao, $this->forma_pagto, $this->prazo_entrega, $this->id);
        } else {
            // Insert new Pedido
            $stmt = mysqli_prepare($this->conn, "INSERT INTO pedidos (id_cliente, id_vendedor, data, observacao, forma_pagto, prazo_entrega) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iissis", $this->id_cliente, $this->id_vendedor, $this->data, $this->observacao, $this->forma_pagto, $this->prazo_entrega);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            // If successful, get the inserted ID
            if ($result) {
                $this->id = mysqli_insert_id($this->conn);
                return $this->id;
            }
            return false;
        }
        return mysqli_stmt_execute($stmt); // For update operation
    }


    // Get Pedido by ID
    public function getById($id)
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM pedidos WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $pedido = new Pedido();
            $pedido->setId($data['id']);
            $pedido->setIdCliente($data['id_cliente']);
            $pedido->setIdVendedor($data['id_vendedor']);
            $pedido->setData($data['data']);
            $pedido->setObservacao($data['observacao']);
            $pedido->setFormaPagto($data['forma_pagto']);
            $pedido->setPrazoEntrega($data['prazo_entrega']);
            return $pedido;
        }
        return null;
    }

    // Get All Pedidos
    public function getAll(): array
    {
        $stmt = mysqli_prepare($this->conn, "
        SELECT p.id, p.id_cliente, p.id_vendedor, p.data, p.forma_pagto, p.prazo_entrega, 
               c.nome AS nome_cliente, v.nome AS nome_vendedor
        FROM pedidos p
        LEFT JOIN clientes c ON p.id_cliente = c.id
        LEFT JOIN vendedor v ON p.id_vendedor = v.id
    ");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $pedidos = [];
        while ($data = mysqli_fetch_assoc($result)) {
            $pedido = new Pedido();
            $pedido->setId($data['id']);
            $pedido->setIdCliente($data['id_cliente']);
            $pedido->setIdVendedor($data['id_vendedor']);
            $pedido->setData($data['data']);
            $pedido->setFormaPagto($data['forma_pagto']);
            $pedido->setPrazoEntrega($data['prazo_entrega']);
            $pedido->setNomeCliente($data['nome_cliente']);
            $pedido->setNomeVendedor($data['nome_vendedor']);
            $pedidos[] = $pedido;
        }

        return $pedidos;
    }


    // Delete Pedido
    public function delete()
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM pedidos WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function deleteByID($id)
    {
        if ($id) {
            // First, delete dependent records in the 'itens_pedido' table
            $stmt = mysqli_prepare($this->conn, "DELETE FROM itens_pedido WHERE id_pedido = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Now, delete the record in 'pedidos'
                $stmt = mysqli_prepare($this->conn, "DELETE FROM pedidos WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                return mysqli_stmt_execute($stmt);
            }
        }
        return false;
    }


}
