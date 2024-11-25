<?php
require_once "../models/ItemPedido.php";
require_once "../models/Database.php";

$itemPedido = new ItemPedido();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'filtrar') {
        $tipoFiltro = isset($_POST['tipo_filtro']) ? $_POST['tipo_filtro'] : null;
        $valorFiltro = isset($_POST['valor_filtro']) ? $_POST['valor_filtro'] : null;

        // Validate that both filtro parameters are provided
        if ($tipoFiltro && $valorFiltro) {
            if ($tipoFiltro === 'id_pedido') {
                // Fetch items by pedido ID
                $pedidos = $itemPedido->getItemsByPedido($valorFiltro);
            } else if ($tipoFiltro === 'nome_cliente') {
                // Fetch items by cliente name
                $pedidos = $itemPedido->getItemsByCliente($valorFiltro);
            } else {
                $pedidos = [];
            }

            echo json_encode([
                'success' => true,
                'pedidos' => $pedidos,
                'message' => 'Pedidos filtrados com sucesso!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Parâmetros de filtro ausentes'
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido'
    ]);
}