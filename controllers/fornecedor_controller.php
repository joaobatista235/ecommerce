<?php
require_once "../models/Fornecedor.php";

class FornecedorController
{
    /**
     * Handles incoming HTTP requests and directs to appropriate actions.
     * @return void
     * @throws Exception
     */
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];

            $response = match ($action) {
                'cadastrar' => $this->cadastrarFornecedor(),
                'editar' => $this->editarFornecedor(),
                'excluir' => $this->excluirFornecedor(),
                'listar' => $this->listarFornecedores(),
                default => ['success' => false, 'message' => 'Ação inválida'],
            };

            echo json_encode($response);
        }
    }

    /**
     * Creates a new fornecedor.
     * @return array
     */
    private function cadastrarFornecedor(): array
    {
        $fornecedor = new Fornecedor();
        $fornecedor->setNome($_POST['nome']);
        $fornecedor->setContato($_POST['contato']);

        return $fornecedor->save()
            ? ['success' => true, 'message' => 'Fornecedor cadastrado com sucesso']
            : ['success' => false, 'message' => 'Erro ao cadastrar fornecedor'];
    }

    /**
     * Updates an existing fornecedor.
     * @return array
     * @throws Exception
     */
    private function editarFornecedor(): array
    {
        $fornecedor = new Fornecedor();
        $fornecedor->setId($_POST['id']);

        $existingFornecedor = $fornecedor->getById($_POST['id']);
        if ($existingFornecedor) {
            $fornecedor->setNome($_POST['nome']);
            $fornecedor->setContato($_POST['contato']);

            return $fornecedor->save()
                ? ['success' => true, 'message' => 'Fornecedor atualizado com sucesso']
                : ['success' => false, 'message' => 'Erro ao atualizar fornecedor'];
        }
        return ['success' => false, 'message' => 'Fornecedor não encontrado'];
    }

    /**
     * Deletes a fornecedor by ID.
     * @return array
     */
    private function excluirFornecedor(): array
    {
        $result = (new Fornecedor())->deleteById($_POST['id']);

        return $result
            ? ['success' => true, 'message' => 'Fornecedor excluído com sucesso']
            : ['success' => false, 'message' => 'Erro ao excluir fornecedor'];
    }

    /**
     * Retrieves all fornecedores.
     * @return array
     */
    private function listarFornecedores(): array
    {
        $fornecedores = (new Fornecedor())->getAll();

        if ($fornecedores) {
            $fornecedoresArray = array_map(fn($fornecedor) => $fornecedor->toArray(), $fornecedores);
            return ['success' => true, 'fornecedores' => $fornecedoresArray];
        }
        return ['success' => false, 'message' => 'Nenhum fornecedor encontrado'];
    }



}

session_start();

$controller = new FornecedorController();
$controller->handleRequest();
