<?php

require_once "../models/Produto.php";

class ProductController
{
    /**
     * @return void
     */
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];

            $response = match ($action) {
                'cadastrar' => $this->cadastrarProduto(),
                'editar' => $this->editarProduto(),
                'excluir' => $this->excluirProduto(),
                'listar' => $this->listarProduto(),
                default => ['success' => false, 'message' => 'Ação inválida'],
            };

            echo json_encode($response);
        }
    }

    /**
     * @return array
     */
    private function cadastrarProduto(): array
    {
        $produto = new Produto();

        $produto->setNome($_POST['nome']);
        $produto->setQtdeEstoque($_POST['qtde_estoque']);
        $produto->setPreco($_POST['preco']);
        $produto->setUnidadeMedida($_POST['unidade_medida']);
        $produto->setPromocao($_POST['promocao']);

        return $produto->save()
            ? ['success' => true, 'message' => 'Produto cadastrado com sucesso']
            : ['success' => false, 'message' => 'Erro ao cadastrar produto'];
    }

    /**
     * @return array
     */
    private function editarProduto(): array
    {
        $produto = new Produto();
        $produto->setId($_POST['id']);

        $existingProduto = $produto->getById($_POST['id']);
        if ($existingProduto) {
            $produto->setNome($_POST['nome']);
            $produto->setQtdeEstoque($_POST['qtde_estoque']);
            $produto->setPreco($_POST['preco']);
            $produto->setUnidadeMedida($_POST['unidade_medida']);
            $produto->setPromocao($_POST['promocao']);

            return $produto->save()
                ? ['success' => true, 'message' => 'Produto atualizado com sucesso']
                : ['success' => false, 'message' => 'Erro ao atualizar produto'];
        }
        return ['success' => false, 'message' => 'Produto não encontrado'];
    }

    /**
     * @return array
     */
    private function excluirProduto(): array
    {
        $result = (new Produto())->deleteById($_POST['productId']);

        return $result ?
            ['success' => true, 'message' => 'Produto excluído com sucesso'] :
            ['success' => false, 'message' => 'Erro ao excluir o produto'];
    }

    /**
     * @return array
     */
    private function listarProduto(): array
    {
        $filtros = [];
        if (!empty($_POST['filtro']) && $_POST['filtro'] === 'true') {
            $filtros['nome'] = $_POST['nome'] ?? '';
            $filtros['preco'] = $_POST['preco'] ?? '';
        }
        $produtos = (new Produto())->getAll($filtros);

        return $produtos ?
            ['success' => true, 'produtos' => $produtos] :
            ['success' => false, 'message' => 'Nenhum produto encontrado.'];

    }
}

$controller = new ProductController();
$controller->handleRequest();
