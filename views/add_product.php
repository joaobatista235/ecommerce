<?php
// Include necessary files for accessing the database
require_once "../controllers/products_controller.php";

// If an ID is passed, fetch the product data to populate the form
$product = null;
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    // Fetch the product by ID (assuming a method `getById` in the Produto model)
    $product = Produto::getById($productId);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../config/global.css" rel="stylesheet">
    <title>Inserir ou atualizar produto</title>
</head>

<body>
    <div class="container-add_product">
        <h1 id="titulo_produto">Insira ou atualize informações sobre produtos</h1>

        <!-- Start of the form -->
        <form action="../controllers/products_controller.php<?= isset($_GET['id']) ? '?id=' . $_GET['id'] : ''; ?>" method="post"
            class="form_produto row g-3" enctype="multipart/form-data">

            <!-- Hidden field for product ID (only if updating) -->
            <input type="hidden" id="prod_id" name="prod_id" value="<?= isset($product) ? $product->getId() : ''; ?>">

            <!-- Product Name -->
            <div class="col-md-6">
                <label for="prod_name" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="prod_name" name="prod_name"
                    value="<?= isset($product) ? $product->getNome() : ''; ?>" required>
            </div>

            <!-- Product Quantity -->
            <div class="col-md-6">
                <label for="prod_amount" class="form-label">Quantidade do Produto em estoque</label>
                <input type="number" class="form-control" id="prod_amount" name="prod_amount"
                    value="<?= isset($product) ? $product->getQtdeEstoque() : ''; ?>" required>
            </div>

            <!-- Product Price -->
            <div class="col-md-6">
                <label for="prod_value" class="form-label">Preço</label>
                <input type="number" class="form-control" id="prod_value" name="prod_value" step=".01"
                    value="<?= isset($product) ? $product->getPreco() : ''; ?>" required>
            </div>

            <!-- Unit of Measurement -->
            <div class="col-md-6">
                <label for="prod_mesure_un" class="form-label">Unidade de medida</label>
                <input type="text" class="form-control" id="prod_mesure_un" name="prod_mesure_un"
                    value="<?= isset($product) ? $product->getUnidadeMedida() : ''; ?>" required>
            </div>

            <!-- Promotion Checkbox -->
            <div class="checkbox_product form-check col-md-12">
                <label class="form-check-label" for="gridCheck">
                    Está em promoção
                </label>
                <input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck" <?= isset($product) && $product->getPromocao() === 'Y' ? 'checked' : ''; ?>>
            </div>

            <!-- Submit Button (Change text based on action) -->
            <div class="btn_produto col-12">
                <button type="submit" class="btn btn-primary">
                    <?= isset($product) ? 'ATUALIZAR' : 'REGISTRAR PRODUTO'; ?>
                </button>
            </div>

        </form>

    </div>
</body>

</html>