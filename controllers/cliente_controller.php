<?php

require_once "../models/Cliente.php";

class ClienteController
{
    /**
     * Handles incoming HTTP requests and directs to appropriate actions.
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
     * Creates a new cliente.
     * @return array
     */
    private function cadastrarCliente(): array
    {
        $cliente = new Cliente();
        $cliente->setNome($_POST['nome'] ?? '');
        $cliente->setEndereco($_POST['endereco'] ?? '');
        $cliente->setNumero($_POST['numero'] ?? '');
        $cliente->setBairro($_POST['bairro'] ?? '');
        $cliente->setCidade($_POST['cidade'] ?? '');
        $cliente->setEstado($_POST['estado'] ?? '');
        $cliente->setEmail($_POST['email'] ?? '');
        $cliente->setCpf_Cnpj($_POST['cpf_cnpj'] ?? '');
        $cliente->setRg($_POST['rg'] ?? '');
        $cliente->setTelefone($_POST['telefone'] ?? '');
        $cliente->setCelular($_POST['celular'] ?? '');
        $cliente->setDataNasc($_POST['data_nasc'] ?? null);
        $cliente->setSalario($_POST['salario'] ?? 0.0);

        return $cliente->save()
            ? ['success' => true, 'message' => 'Cliente cadastrado com sucesso']
            : ['success' => false, 'message' => 'Erro ao cadastrar cliente'];
    }

    /**
     * Updates an existing cliente.
     * @return array
     */
    private function editarCliente(): array
    {
        $cliente = new Cliente();
        $cliente->setId($_POST['id'] ?? null);

        $existingCliente = $cliente->getById($_POST['id']);
        if ($existingCliente) {
            $cliente->setNome($_POST['nome'] ?? $existingCliente->getNome());
            $cliente->setEndereco($_POST['endereco'] ?? $existingCliente->getEndereco());
            $cliente->setNumero($_POST['numero'] ?? $existingCliente->getNumero());
            $cliente->setBairro($_POST['bairro'] ?? $existingCliente->getBairro());
            $cliente->setCidade($_POST['cidade'] ?? $existingCliente->getCidade());
            $cliente->setEstado($_POST['estado'] ?? $existingCliente->getEstado());
            $cliente->setEmail($_POST['email'] ?? $existingCliente->getEmail());
            $cliente->setCpf_Cnpj($_POST['cpf_cnpj'] ?? $existingCliente->getCpf_Cnpj());
            $cliente->setRg($_POST['rg'] ?? $existingCliente->getRg());
            $cliente->setTelefone($_POST['telefone'] ?? $existingCliente->getTelefone());
            $cliente->setCelular($_POST['celular'] ?? $existingCliente->getCelular());
            $cliente->setDataNasc($_POST['data_nasc'] ?? $existingCliente->getDataNasc());
            $cliente->setSalario($_POST['salario'] ?? $existingCliente->getSalario());

            return $cliente->save()
                ? ['success' => true, 'message' => 'Cliente atualizado com sucesso']
                : ['success' => false, 'message' => 'Erro ao atualizar cliente'];
        }

        return ['success' => false, 'message' => 'Cliente não encontrado'];
    }

    /**
     * Deletes a cliente by ID.
     * @return array
     */
    private function excluirCliente(): array
    {
        $cliente = new Cliente();
        /*$cliente->setId($_POST['id'] ?? null);*/

        return $cliente->deleteById($_POST['clienteId'])
            ? ['success' => true, 'message' => 'Cliente excluído com sucesso']
            : ['success' => false, 'message' => 'Erro ao excluir cliente'];
    }

    /**
     * Retrieves all clientes.
     * @return array
     */
    private function listarClientes(): array
    {
        $cliente = new Cliente();
        $clientes = $cliente->getAll();

        if ($clientes) {
            $clientesArray = array_map(fn($cliente) => $cliente->toArray(), $clientes);
            return ['success' => true, 'clientes' => $clientesArray];
        }

        return ['success' => false, 'message' => 'Nenhum cliente encontrado'];
    }
}

session_start();

$controller = new ClienteController();
$controller->handleRequest();
