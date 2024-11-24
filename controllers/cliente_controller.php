<?php

require_once "../models/Cliente.php";

class ClienteController
{
    /**
     * @return void
     */
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];

            $response = match ($action) {
                'cadastrar' => $this->cadastrarCliente(),
                'editar' => $this->editarCliente(),
                'excluir' => $this->excluirCliente(),
                'listar' => $this->listarClientes(),
                default => ['success' => false, 'message' => 'Ação inválida'],
            };

            echo json_encode($response);
        }
    }

    /**
     * @return array
     */
    private function cadastrarCliente(): array
    {
        if (isset($_POST['nome'], $_POST['email'], $_POST['cpf_cnpj'])) {
            $cliente = new Cliente();

            $cliente->setNome($_POST['nome']);
            $cliente->setEndereco($_POST['endereco'] ?? '');
            $cliente->setNumero($_POST['numero'] ?? '');
            $cliente->setBairro($_POST['bairro'] ?? '');
            $cliente->setCidade($_POST['cidade'] ?? '');
            $cliente->setEstado($_POST['estado'] ?? '');
            $cliente->setEmail($_POST['email']);
            $cliente->setCpfCnpj($_POST['cpf_cnpj']);
            $cliente->setRg($_POST['rg'] ?? '');
            $cliente->setTelefone($_POST['telefone'] ?? '');
            $cliente->setCelular($_POST['celular'] ?? '');
            $cliente->setDataNasc($_POST['data_nasc'] ?? null);
            $cliente->setSalario($_POST['salario'] ?? 0.0);

            return $cliente->save()
                ? ['success' => true, 'message' => 'Cliente cadastrado com sucesso']
                : ['success' => false, 'message' => 'Erro ao cadastrar cliente'];
        }

        return ['success' => false, 'message' => 'Dados obrigatórios estão faltando'];
    }

    /**
     * @return array
     */
    private function editarCliente(): array
    {
        if (isset($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['cpf_cnpj'])) {
            $cliente = new Cliente();

            $cliente->setId($_POST['id']);
            $existingCliente = $cliente->getById($_POST['id']);

            if ($existingCliente) {
                $cliente->setNome($_POST['nome']);
                $cliente->setEndereco($_POST['endereco'] ?? '');
                $cliente->setNumero($_POST['numero'] ?? '');
                $cliente->setBairro($_POST['bairro'] ?? '');
                $cliente->setCidade($_POST['cidade'] ?? '');
                $cliente->setEstado($_POST['estado'] ?? '');
                $cliente->setEmail($_POST['email']);
                $cliente->setCpfCnpj($_POST['cpf_cnpj']);
                $cliente->setRg($_POST['rg'] ?? '');
                $cliente->setTelefone($_POST['telefone'] ?? '');
                $cliente->setCelular($_POST['celular'] ?? '');
                $cliente->setDataNasc($_POST['data_nasc'] ?? null);
                $cliente->setSalario($_POST['salario'] ?? 0.0);

                return $cliente->save()
                    ? ['success' => true, 'message' => 'Cliente atualizado com sucesso']
                    : ['success' => false, 'message' => 'Erro ao atualizar cliente'];
            }

            return ['success' => false, 'message' => 'Cliente não encontrado'];
        }

        return ['success' => false, 'message' => 'Dados obrigatórios estão faltando'];
    }

    /**
     * @return array
     */
    private function excluirCliente(): array
    {
        if (isset($_POST['clienteId'])) {
            $cliente = new Cliente();

            $cliente->setId($_POST['clienteId']);
            $existingCliente = $cliente->getById($_POST['clienteId']);

            if ($existingCliente) {
                return $cliente->deleteById($cliente->getId())
                    ? ['success' => true, 'message' => 'Cliente excluído com sucesso']
                    : ['success' => false, 'message' => 'Erro ao excluir cliente'];
            }

            return ['success' => false, 'message' => 'Cliente não encontrado'];
        }

        return ['success' => false, 'message' => 'ID do cliente não fornecido'];
    }

    /**
     * @return array
     */
    private function listarClientes(): array
    {
        $cliente = new Cliente();
        $clientes = $cliente->getAll();

        return $clientes
            ? ['success' => true, 'clientes' => $clientes]
            : ['success' => false, 'message' => 'Nenhum cliente encontrado'];
    }
}

$controller = new ClienteController();
$controller->handleRequest();
