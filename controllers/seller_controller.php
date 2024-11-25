<?php
require_once "../models/Vendedor.php";
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

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
                'gerarRelatorio' => $this->gerarRelatorio(),
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
            $vendedor->setDataAdmissao($_POST['data_admissao']);
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

    /**
     * @return array
     */
    private function gerarRelatorio(): array
    {
        $vendedores = (new Vendedor())->gerarRelatorioPeriodo($_POST['inicio'], $_POST['fim']);

        $linha = "";
        foreach ($vendedores as $vendedor) {
            $linha .= "
            <tr>
                <td>{$vendedor['vendedor_nome']}</td>
                <td>{$vendedor['total_vendido']}</td>
                <td>{$vendedor['comissao']}</td>
            </tr>";
        }

        if (empty($linha)) {
            return ['success' => false, 'message' => 'Nenhum vendedor encontrado'];
        }

        $dompdf = new Dompdf();
        $html = "
        <h1 style='text-align: center;'>Relatório de Vendedores</h1>
        <hr>
        <table width='100%' border='1' style='border-collapse: collapse; text-align: left;'>
            <thead>
                <tr>
                    <th>Nome do vendedor</th>
                    <th>Total vendido</th>
                    <th>Comissão</th>
                </tr>
            </thead>
            <tbody>
                {$linha}
            </tbody>
        </table>";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        $pdfOutput = $dompdf->output();

        if (!$pdfOutput) {
            return ['success' => false, 'message' => 'Erro ao gerar o PDF'];
        }

        $base64Pdf = base64_encode($pdfOutput);

        return ['success' => true, 'pdf' => $base64Pdf];
    }

}

$controller = new SellerController();
$controller->handleRequest();