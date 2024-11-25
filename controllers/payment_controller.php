<?php
require_once "../models/FormaPagto.php";

class PaymentController
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
                'cadastrar' => $this->cadastrarPagamento(),
                'editar' => $this->editarPagamento(),
                'excluir' => $this->excluirPagamento(),
                'listar' => $this->listarPagamento(),
                default => ['success' => false, 'message' => 'Ação inválida'],
            };

            echo json_encode($response);
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    private function cadastrarPagamento(): array
    {
        $pagamento = new FormaPagto();
        $pagamento->setNome($_POST['nome']);

        return $pagamento->save()
            ? ['success' => true, 'message' => 'Forma de pagamento cadastrada com sucesso']
            : ['success' => false, 'message' => 'Erro ao cadastrar Forma de pagamento'];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function editarPagamento(): array
    {
        $pagamento = new FormaPagto();
        $pagamento->setId($_POST['id']);

        $existingProduto = $pagamento->getById($_POST['id']);
        if ($existingProduto) {
            $pagamento->setNome($_POST['nome']);

            return $pagamento->save()
                ? ['success' => true, 'message' => 'Forma de pagamento atualizada com sucesso']
                : ['success' => false, 'message' => 'Erro ao atualizar Forma de pagamento'];
        }
        return ['success' => false, 'message' => 'Forma de pagamento não encontrada'];
    }

    /**
     * @return array
     */
    private function excluirPagamento(): array
    {
        $result = (new FormaPagto())->deleteById($_POST['id']);

        return $result ?
            ['success' => true, 'message' => 'Forma de pagamento excluída com sucesso'] :
            ['success' => false, 'message' => 'Erro ao excluir a forma de pagamento'];
    }

    /**
     * @return array
     */
    private function listarPagamento(): array
    {
        $pagamentos = (new FormaPagto())->getAll();

        return $pagamentos ?
            ['success' => true, 'pagamentos' => $pagamentos] :
            ['success' => false, 'message' => 'Nenhum forma de pagamento encontrada.'];

    }
}

$controller = new PaymentController();
$controller->handleRequest();