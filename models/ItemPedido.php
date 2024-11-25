<?php

require_once "Database.php";
require_once "GenericInterface.php";

class ItemPedido implements GenericInterface
{
    private $id_pedido;
    private $id_produto;
    private $quantidade;
    private $id_item_pedido;
    private static $conn;

    public function __construct()
    {
        // Use a singleton pattern for the database connection
        if (!self::$conn) {
            self::$conn = (new Database())->getConnection();
        }
    }

    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function setIdPedido($id_pedido): void
    {
        $this->id_pedido = $id_pedido;
    }

    public function getIdProduto()
    {
        return $this->id_produto;
    }

    public function setIdProduto($id_produto): void
    {
        $this->id_produto = $id_produto;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    public function getIdItemPedido()
    {
        return $this->id_item_pedido;
    }

    public function setIdItemPedido($id_item_pedido): void
    {
        $this->id_item_pedido = $id_item_pedido;
    }

    /**
     * Save an item in the order
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id_item_pedido) {
            $stmt = mysqli_prepare(self::$conn, "UPDATE itens_pedido SET id_pedido=?, id_produto=?, qtde=? WHERE id_item=?");
            mysqli_stmt_bind_param($stmt, "iiii", $this->id_pedido, $this->id_produto, $this->quantidade, $this->id_item_pedido);
        } else {
            $stmt = mysqli_prepare(self::$conn, "INSERT INTO itens_pedido (id_pedido, id_produto, qtde) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iii", $this->id_pedido, $this->id_produto, $this->quantidade);
        }
        return mysqli_stmt_execute($stmt);
    }

    /**
     * Get all items sold with product and client details
     * @return array
     */
    public function getAllItems(): array
    {
        $sql = "
    SELECT 
        ip.id_item AS id_item,     
        ped.id AS id_pedido,       
        ped.data,                  
        cli.id AS id_cliente,      
        cli.nome AS nome_cliente,  
        vend.id AS id_vendedor,    
        vend.nome AS nome_vendedor,
        ip.id_produto,
        p.nome AS nome_produto,
        p.preco,
        ip.qtde AS quantidade_comprada
    FROM pedidos ped
    JOIN clientes cli ON ped.id_cliente = cli.id 
    JOIN vendedor vend ON ped.id_vendedor = vend.id
    JOIN itens_pedido ip ON ped.id = ip.id_pedido
    JOIN produto p ON ip.id_produto = p.id;";

        $result = self::$conn->query($sql);
        $items = [];

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }

    /**
     * Get ItemPedido by ID
     * @param int $id
     * @return ItemPedido|null
     */
    public function getById(int $id): ?ItemPedido
    {
        $stmt = mysqli_prepare(self::$conn, "SELECT * FROM itens_pedido WHERE id_item = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $itemPedido = new ItemPedido();
            $itemPedido->setIdItemPedido($data['id_item']);
            $itemPedido->setIdPedido($data['id_pedido']);
            $itemPedido->setIdProduto($data['id_produto']);
            $itemPedido->setQuantidade($data['quantidade']);
            return $itemPedido;
        }
        return null;
    }

    /**
     * Get all ItemPedidos
     * @return ItemPedido[]
     */
    public function getAll(): array
    {
        $stmt = mysqli_prepare(self::$conn, "SELECT * FROM itens_pedido");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $itemsPedido = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $itemPedido = new ItemPedido();
            $itemPedido->setIdItemPedido($data['id_item']);
            $itemPedido->setIdPedido($data['id_pedido']);
            $itemPedido->setIdProduto($data['id_produto']);
            $itemPedido->setQuantidade($data['qtde']);
            $itemsPedido[] = $itemPedido;
        }
        return $itemsPedido;
    }

    /**
     * Delete the item from the order
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->id_item_pedido) {
            $stmt = mysqli_prepare(self::$conn, "DELETE FROM itens_pedido WHERE id_item = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id_item_pedido);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    /**
     * Delete ItemPedido by its ID
     * @param  $id
     * @return bool
     */
    public function deleteById($id): bool
    {
        if ($id) {
            $stmt = mysqli_prepare(self::$conn, "DELETE FROM itens_pedido WHERE id_item = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function getByPedidoId($id_pedido)
    {
        $stmt = mysqli_prepare(self::$conn, "SELECT * FROM itens_pedido WHERE id_pedido = ?");
        mysqli_stmt_bind_param($stmt, "i", $id_pedido);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $items = [];
        while ($data = mysqli_fetch_assoc($result)) {
            $items[] = $data;
        }

        return $items;
    }

    public function getItemsByPedido($idPedido) {
        $sql = "
        SELECT 
            ip.id_item,
            ped.id AS id_pedido,
            ped.data,
            cli.id AS id_cliente,
            cli.nome AS nome_cliente,
            vend.id AS id_vendedor,
            vend.nome AS nome_vendedor,
            ip.id_produto,
            p.nome AS nome_produto,
            p.preco,
            ip.qtde AS quantidade_comprada
        FROM pedidos ped
        JOIN clientes cli ON ped.id_cliente = cli.id
        JOIN vendedor vend ON ped.id_vendedor = vend.id
        JOIN itens_pedido ip ON ped.id = ip.id_pedido
        JOIN produto p ON ip.id_produto = p.id
        WHERE ped.id = ?;
        ";

        $stmt = mysqli_prepare(self::$conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idPedido);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
        mysqli_stmt_close($stmt);

        return $items;
    }
    
    
    function getItemsByCliente( $nomeCliente) {
        $sql = "
        SELECT 
            ip.id_item,
            ped.id AS id_pedido,
            ped.data,
            cli.id AS id_cliente,
            cli.nome AS nome_cliente,
            vend.id AS id_vendedor,
            vend.nome AS nome_vendedor,
            ip.id_produto,
            p.nome AS nome_produto,
            p.preco,
            ip.qtde AS quantidade_comprada
        FROM pedidos ped
        JOIN clientes cli ON ped.id_cliente = cli.id
        JOIN vendedor vend ON ped.id_vendedor = vend.id
        JOIN itens_pedido ip ON ped.id = ip.id_pedido
        JOIN produto p ON ip.id_produto = p.id
        WHERE cli.nome LIKE ?;
        ";

        if ($stmt = mysqli_prepare(self::$conn, $sql)) {
            $nomeCliente = "%" . $nomeCliente . "%";

            mysqli_stmt_bind_param($stmt, "s", $nomeCliente);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            $items = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }

            mysqli_stmt_close($stmt);
            return $items;
        } else {
            return [];
        }
    }

    public function getItemsWithProductDetails($idPedido): array
    {
        $sql = "
        SELECT 
            ip.id_item AS id_item,
            ip.id_pedido,
            ip.id_produto,
            ip.qtde,
            p.nome AS nome_produto,
            p.preco
        FROM 
            itens_pedido ip
        INNER JOIN 
            produto p ON ip.id_produto = p.id
        WHERE 
            ip.id_pedido = ?
    ";

        $stmt = self::$conn->prepare($sql);
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }

}