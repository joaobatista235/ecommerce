<?php
require_once "../models/Pedido.php";
session_start();  // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $pedidoModel = new Pedido();

    // Handle "Cadastrar" (Create) action
    if ($_POST['action'] === 'cadastrar') {
        if (isset($_POST['clienteId'], $_POST['vendedorId'], $_POST['dtEmissao'], $_POST['prazoEntrega'], $_POST['observacao'], $_POST['formaPagamento'])) {
            $pedidoModel->setIdCliente($_POST['clienteId']);
            $pedidoModel->setIdVendedor($_POST['vendedorId']);
            $pedidoModel->setData($_POST['dtEmissao']);
            $pedidoModel->setPrazoEntrega($_POST['prazoEntrega']);
            $pedidoModel->setObservacao($_POST['observacao']);
            $pedidoModel->setFormaPagto($_POST['formaPagamento']);

            // Save the Pedido and get the id_pedido
            $id_pedido = $pedidoModel->save();

            if ($id_pedido) {
                $_SESSION['id_pedido'] = $id_pedido;
                echo json_encode([
                    'success' => true,
                    'message' => 'Pedido cadastrado com sucesso!',
                    'id_pedido' => $id_pedido
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
    }

    // Handle "Excluir" (Delete) action
    if ($_POST['action'] === 'excluir' && isset($_POST['id'])) {
        $id_pedido = $_POST['id'];
        $resultado = $pedidoModel->deleteByID($id_pedido); // Assuming a delete method exists in your Pedido model

        if ($resultado) {
            echo json_encode([
                'success' => true,
                'message' => 'Pedido excluído com sucesso!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao excluir o pedido'
            ]);
        }
    }

    // Handle "Filtrar" (Filter) action for date range
    if ($_POST['action'] === 'filtrar' && isset($_POST['dt1'], $_POST['dt2'])) {
        $dt1 = $_POST['dt1'];
        $dt2 = $_POST['dt2'];
    
        // Call the Pedido model to fetch filtered pedidos based on the date range
        $pedidos = $pedidoModel->getByPeriodo($dt1, $dt2); // getByPeriodo returns an array or null
    
        // Check if there are any pedidos
        if ($pedidos && is_array($pedidos)) {
            // Convert Pedido objects to arrays
            $pedidosArray = [];
            foreach ($pedidos as $pedido) {
                $pedidosArray[] = [
                    'id' => $pedido->getId(),
                    'id_cliente' => $pedido->getIdCliente(),
                    'id_vendedor' => $pedido->getIdVendedor(),
                    'data' => $pedido->getData(),
                    'forma_pagto' => $pedido->getFormaPagto(),
                    'prazo_entrega' => $pedido->getPrazoEntrega(),
                    'nome_cliente' => $pedido->getNomeCliente(),
                    'nome_vendedor' => $pedido->getNomeVendedor()
                ];
            }
        
            echo json_encode([
                'success' => true,
                'pedidos' => $pedidosArray
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Nenhum pedido encontrado para o intervalo de datas fornecido.'
            ]);
        }
        
    }
    
}
