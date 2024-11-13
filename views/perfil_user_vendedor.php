<?php 
include "base/header.php";
require_once "../models/Produto.php"; // Se o arquivo Produto.php estiver em models

// Verificar se existe a ação de exclusão
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = Produto::getById($productId); // Verificar se o produto existe

    if ($product && $product->delete()) {
        // Produto excluído com sucesso
        echo "<div class='alert alert-success'>Produto excluído com sucesso!</div>";
    } else {
        // Erro ao excluir
        echo "<div class='alert alert-danger'>Erro ao excluir produto.</div>";
    }
}
?>

<div class="container mt-5">
    <section class="mb-4">
        <h2>Perfil do Vendedor</h2>
        <div class="d-flex align-items-center">
            <img src="path/to/profile-pic.jpg" alt="Foto de Perfil" class="rounded-circle" width="100" height="100">
            <div class="ms-3">
                <h5>Nome do Vendedor</h5>
                <button class="btn btn-link" title="Editar informações">
                    <i class="bi bi-pencil-fill"></i> Editar
                </button>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <h3>Informações Pessoais</h3>
        <p>Email: vendedor@example.com</p>
        <p>Telefone: (11) 91234-5678</p>
        <p>Endereço: Rua Exemplo, 123 - Cidade, Estado</p>
    </section>

    <!-- Barra de pesquisa -->
    <section class="mb-4">
        <h3>Pesquisar Produto</h3>
        <form method="GET" action="perfil_user_vendedor.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar por ID do produto" name="product_id">
                <button class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </form>
    </section>

    <!-- Tabela de Produtos -->
    <section class="mb-4">
        <h3>Lista de Produtos</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Promoção</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar se existe uma pesquisa por ID
                $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
                $products = Produto::getAll(); // Caso não tenha filtro, exibe todos os produtos
                
                if ($product_id) {
                    // Buscar produto específico por ID
                    $products = array_filter($products, function($product) use ($product_id) {
                        return $product->getId() == $product_id;
                    });
                }

                // Exibir produtos na tabela
                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td>" . $product->getId() . "</td>";
                    echo "<td>" . $product->getNome() . "</td>";
                    echo "<td>" . $product->getQtdeEstoque() . "</td>";
                    echo "<td>" . $product->getPreco() . "</td>";
                    echo "<td>" . ($product->getPromocao() == 'Y' ? 'Sim' : 'Não') . "</td>";
                    echo "<td>
                            <a href='add_product.php?id=" . $product->getId() . "' class='btn btn-warning'>Editar</a>
                            <a href='perfil_user_vendedor.php?action=delete&id=" . $product->getId() . "' class='btn btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Botão para adicionar novos produtos -->
    <section class="my-4">
        <button class="btn btn-primary" onclick="location.href='add_product.php'">Adicionar Novo Produto</button>
    </section>
</div>

<?php include "base/footer.php"; ?>
