<?php

require_once "../models/Cliente.php";
require_once "../models/Database.php";  // Make sure to include the Database class

class ClienteController
{
    private $database;

    public function __construct()
    {
        $this->database = new Database(); // Initialize the database connection
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            $response = [];

            switch ($action) {
                case 'cadastrar':
                    $response = $this->cadastrarCliente();
                    break;

                case 'editar':
                    $response = $this->editarCliente();
                    break;

                case 'excluir':
                    $response = $this->excluirCliente();
                    break;

                case 'listar':
                    $response = $this->listarClientes();
                    break;

                default:
                    $response = ['success' => false, 'message' => 'Ação inválida'];
            }

            echo json_encode($response);
        }
    }

    private function cadastrarCliente()
    {
        if (isset($_POST['nome'], $_POST['email'], $_POST['cpf_cnpj'])) {
            $cliente = new Cliente();  // No need to pass the connection here

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

    private function editarCliente()
    {
        if (isset($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['cpf_cnpj'])) {
            $cliente = new Cliente();  // No need to pass the connection here

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

    private function excluirCliente()
    {
        if (isset($_POST['clienteId'])) {
            $cliente = new Cliente();  // No need to pass the connection here

            $cliente->setId($_POST['clienteId']);
            $existingCliente = $cliente->getById($_POST['clienteId']);

            if ($existingCliente) {
                return $cliente->delete()
                    ? ['success' => true, 'message' => 'Cliente excluído com sucesso']
                    : ['success' => false, 'message' => 'Erro ao excluir cliente'];
            }

            return ['success' => false, 'message' => 'Cliente não encontrado'];
        }

        return ['success' => false, 'message' => 'ID do cliente não fornecido'];
    }

    private function listarClientes()
    {
        $cliente = new Cliente();  // No need to pass the connection here
        $clientes = $cliente->getAll();

        return $clientes
            ? ['success' => true, 'clientes' => $clientes]
            : ['success' => false, 'message' => 'Nenhum cliente encontrado'];
    }
}

$controller = new ClienteController();
$controller->handleRequest();
