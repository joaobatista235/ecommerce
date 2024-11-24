<?php

require_once "../models/Produto.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'excluir' && isset($_POST['productId'])) {
        $produtoId = $_POST['productId'];
        $productModel = new Produto();

        $result = $productModel->deleteById($produtoId);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Produto excluído com sucesso'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao excluir o produto'
            ]);
        }
    } elseif ($_POST['action'] === 'cadastrar' || $_POST['action'] === 'editar') {
        if (isset($_POST['nome'], $_POST['qtde_estoque'], $_POST['preco'], $_POST['unidade_medida'], $_POST['promocao'])) {

            $productModel = new Produto();

            $produtoId = $_POST['produtoId'] ?? null;

            if ($produtoId) {
                $productModel->setId($produtoId);
            }

            $productModel->setNome($_POST['nome']);
            $productModel->setQtdeEstoque($_POST['qtde_estoque']);
            $productModel->setPreco($_POST['preco']);
            $productModel->setUnidadeMedida($_POST['unidade_medida']);
            $productModel->setPromocao($_POST['promocao']);

            $success = $productModel->save();

            if ($success) {
                echo json_encode([
                    'success' => true,
                    'message' => $produtoId ? 'Produto atualizado com sucesso!' : 'Produto cadastrado com sucesso!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao cadastrar o produto'
                ]);
            }

        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Todos os campos são obrigatórios'
            ]);
        }
    } elseif ($_POST['action'] === 'listar') {
        $productModel = new Produto();
        $produtos = $productModel->getAll();
        if (!empty($produtos)) {
            echo json_encode([
                'success' => true,
                'produtos' => $produtos
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Nenhum produto encontrado.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Método inválido ou ação não fornecida'
        ]);
    }
}
