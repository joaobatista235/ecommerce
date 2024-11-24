<?php
require_once "../models/Pedido.php";

session_start();  // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'cadastrar') {
        if (isset($_POST['clienteId'], $_POST['vendedorId'], $_POST['dtEmissao'], $_POST['prazoEntrega'], $_POST['observacao'], $_POST['formaPagamento'])) {

            $pedidoModel = new Pedido();

            // Set the Pedido data from the POST request
            $pedidoModel->setIdCliente($_POST['clienteId']);
            $pedidoModel->setIdVendedor($_POST['vendedorId']);
            $pedidoModel->setData($_POST['dtEmissao']);
            $pedidoModel->setPrazoEntrega($_POST['prazoEntrega']);
            $pedidoModel->setObservacao($_POST['observacao']);
            $pedidoModel->setFormaPagto($_POST['formaPagamento']);

            // Save the Pedido and get the id_pedido
            $id_pedido = $pedidoModel->save();

            if ($id_pedido) {
                // Store id_pedido in session
                $_SESSION['id_pedido'] = $id_pedido;

                echo json_encode([
                    'success' => true,
                    'message' => 'Pedido cadastrado com sucesso!',
                    'id_pedido' => $id_pedido // Include id_pedido in the response (optional)
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao cadastrar o pedido'
                ]);
            }

        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Todos os campos são obrigatórios'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Método inválido ou ação não fornecida'
        ]);
    }
}
