<?php
require_once "Database.php";
require_once "GenericInterface.php";

class Pedido implements GenericInterface
{
    private $id;
    private $id_cliente;
    private $id_vendedor;
    private $data;
    private $total;

    public function __construct()
    {
    }

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
    public function getTotal()
    {
        return $this->total;
    }

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
    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function save()
    {
        if ($this->id) {
            $stmt = mysqli_prepare((new Database())->getConnection(), "UPDATE pedidos SET id_cliente=?, id_vendedor=?, data=?, total=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "iisdi", $this->id_cliente, $this->id_vendedor, $this->data, $this->total, $this->id);
        } else {
            $stmt = mysqli_prepare((new Database())->getConnection(), "INSERT INTO pedidos (id_cliente, id_vendedor, data, total) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iisd", $this->id_cliente, $this->id_vendedor, $this->data, $this->total);
        }
        return mysqli_stmt_execute($stmt);
    }

    public static function getById($id)
    {
        $stmt = mysqli_prepare((new Database())->getConnection(), "SELECT * FROM pedidos WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $pedido = new Pedido();
            $pedido->setId($data['id']);
            $pedido->setIdCliente($data['id_cliente']);
            $pedido->setIdVendedor($data['id_vendedor']);
            $pedido->setData($data['data']);
            $pedido->setTotal($data['total']);
            return $pedido;
        }
        return null;
    }

    public static function getAll()
    {
        $stmt = mysqli_prepare((new Database())->getConnection(), "SELECT * FROM pedidos");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $pedidos = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $pedido = new Pedido();
            $pedido->setId($data['id']);
            $pedido->setIdCliente($data['id_cliente']);
            $pedido->setIdVendedor($data['id_vendedor']);
            $pedido->setData($data['data']);
            $pedido->setTotal($data['total']);
            $pedidos[] = $pedido;
        }
        return $pedidos;
    }

    public function delete()
    {
        if ($this->id) {
            $stmt = mysqli_prepare((new Database())->getConnection(), "DELETE FROM pedidos WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
