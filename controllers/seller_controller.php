<?php
require_once "../models/Vendedor.php";

class SellerController
{
    /**
     * @return void
     * @throws Exception
     */
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];

            $response = match ($action) {
                'cadastrar' => $this->cadastrarVendedor(),
                'editar' => $this->editarVendedor(),
                'excluir' => $this->excluirVendedor(),
                'listar' => $this->listarVendedor(),
                default => ['success' => false, 'message' => 'Ação inválida'],
            };

            echo json_encode($response);
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    private function cadastrarVendedor(): array
    {
        $vendedor = new Vendedor();
        $vendedor->setNome($_POST['nome']);
        $vendedor->setEndereco($_POST['endereco']);
        $vendedor->setCidade($_POST['cidade']);
        $vendedor->setEstado($_POST['estado']);
        $vendedor->setCelular($_POST['celular']);
        $vendedor->setEmail($_POST['email']);
        $vendedor->setPercComissao($_POST['comissao']);
        $vendedor->setDataAdmissao($_POST['data_admissao']);
        $vendedor->setSenha($_POST['senha']);

        return $vendedor->save()
            ? ['success' => true, 'message' => 'Vendedor cadastrado com sucesso']
            : ['success' => false, 'message' => 'Erro ao cadastrar vendedor'];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function editarVendedor(): array
    {
        $vendedor = new Vendedor();
        $vendedor->setId($_POST['id']);

        $existingProduto = $vendedor->getById($_POST['id']);
        if ($existingProduto) {
            $vendedor->setNome($_POST['nome']);
            $vendedor->setEndereco($_POST['endereco']);
            $vendedor->setCidade($_POST['cidade']);
            $vendedor->setEstado($_POST['estado']);
            $vendedor->setCelular($_POST['celular']);
            $vendedor->setEmail($_POST['email']);
            $vendedor->setPercComissao($_POST['comissao']);
            $vendedor->setSenha($_POST['senha']);

            return $vendedor->save()
                ? ['success' => true, 'message' => 'Vendedor atualizado com sucesso']
                : ['success' => false, 'message' => 'Erro ao atualizar vendedor'];
        }
        return ['success' => false, 'message' => 'Vendedor não encontrado'];
    }

    /**
     * @return array
     */
    private function excluirVendedor(): array
    {
        $result = (new Vendedor())->deleteById($_POST['id']);

        //return ['msg' => $result];
        return $result ?
            ['success' => true, 'message' => 'Vendedor excluído com sucesso'] :
            ['success' => false, 'message' => 'Erro ao excluir o vendedor'];
    }

    /**
     * @return array
     */
    private function listarVendedor(): array
    {
        $vendedores = (new Vendedor())->getAll();

        return $vendedores ?
            ['success' => true, 'vendedores' => $vendedores] :
            ['success' => false, 'message' => 'Nenhum vendedor encontrado.'];

    }
}

$controller = new SellerController();
$controller->handleRequest();