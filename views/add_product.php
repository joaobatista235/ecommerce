<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../config/global.css" rel="stylesheet" >
    <title>Inserir produto/editar</title>

</head>
<body>
    <div class="container-add_product">
        <h1 id="titulo_produto" >Insira ou atualize informações sobre produtos</h1>
        <form action="..\controllers\products_controller.php" method="post" class="form_produto row g-3">
            <!-- nome,qtd,preco,unidade_de_medida,promocao  -->
            <div class="col-md-6">
                <label for="prod_name" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="prod_name" name="prod_name" >
            </div>
            <div class="col-md-6">
                <label for="prod_amount" class="form-label">Quantidade  do Produto em estoque</label>
                <input type="number" class="form-control" id="prod_amount" name="prod_amount" >
            </div>
            <div class="col-md-6">
                <label for="prod_value" class="form-label">Preço</label>
                <input type="number" class="form-control" id="prod_value" name="prod_value" step=".01" >
            </div>
            <div class="col-md-6">
                <label for="prod_mesure_un" class="form-label">Unidade de medida</label>
                <input type="number" class="form-control" id="prod_mesure_un" name="prod_mesure_un" >
            </div>
            
            <div class="col-md-12">
                <label for="prod_image" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="prod_image" name="prod_image" >
            </div>
            <div class="checkbox_product form-check col-md-12">
                <label class="form-check-label" for="gridCheck">
                    Está em promoção
                </label>
                <input class="form-check-input" type="checkbox" id="gridCheck" class="checkbox_product">
            </div>
            <div class="btn_produto col-12">
                <button type="submit" class="btn btn-primary">REGISTRAR PRODUTO</button>
            </div>
        </form>
    </div>
</body>
</html>



