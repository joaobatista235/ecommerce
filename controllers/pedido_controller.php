<?php
require_once "../models/Pedido.php";
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

session_start();

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

    if ($_POST['action'] === 'gerarRelatorio') {
        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->gerarRelatorio($_POST['inicio'], $_POST['fim']);

        if (empty($pedidos)) {
            echo json_encode(['success' => false, 'message' => 'Nenhum pedido encontrado no período especificado']);
        }

        $linha = "";
        foreach ($pedidos as $pedido) {
            $itens = $pedidoModel->obterItensPedido($pedido['pedido_id']);

            $linha .= "
                <tr>
                    <td colspan='6' style='background-color: #f4f4f4; font-weight: bold;'>Pedido ID: {$pedido['pedido_id']} - Data: {$pedido['data']}</td>
                </tr>
                <tr>
                    <td>Cliente</td>
                    <td>Vendedor</td>
                    <td>Forma Pagto</td>
                    <td>Prazo Entrega</td>
                    <td>Observação</td>
                </tr>
                <tr>
                    <td>{$pedido['cliente_nome']}</td>
                    <td>{$pedido['vendedor_nome']}</td>
                    <td>{$pedido['forma_pagto_nome']}</td>
                    <td>{$pedido['prazo_entrega']}</td>
                    <td>{$pedido['observacao']}</td>
                </tr>
                <tr>
                    <td colspan='6' style='background-color: #e8e8e8;'>Itens do Pedido:</td>
                </tr>
                <tr>
                    <td>Produto</td>
                    <td>Quantidade</td>
                    <td>Preço Unitário</td>
                    <td>Total</td>
                </tr>
            ";

            foreach ($itens as $item) {
                $total = $item['qtde'] * $item['preco'];
                $linha .= "
                    <tr>
                        <td>{$item['produto_nome']}</td>
                        <td>{$item['qtde']}</td>
                        <td>" . number_format($item['preco'], 2, ',', '.') . "</td>
                        <td>" . number_format($total, 2, ',', '.') . "</td>
                    </tr>
                ";
            }
        }

        $dompdf = new Dompdf();
        $html = "
            <h1 style='text-align: center;'>Relatório de Pedidos</h1>
            <hr>
            <table width='100%' border='1' style='border-collapse: collapse; text-align: left;'>
                {$linha}
            </table>
        ";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $pdfOutput = $dompdf->output();

        if (!$pdfOutput) {
            echo json_encode(['success' => false, 'message' => 'Erro ao gerar o PDF']);
        }

        $base64Pdf = base64_encode($pdfOutput);

        echo json_encode(['success' => true, 'pdf' => $base64Pdf]);
    }
}
