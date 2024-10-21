<?php
require_once "models/Database.php";
require_once "models/Vendedor.php";
require_once "models/Cliente.php";
require_once "models/Produto.php";
require_once "models/FormaPagto.php";
require_once "models/Pedido.php";

$vendedor = new Vendedor();
$vendedor->setNome("Maria Oliveira");
$vendedor->setEndereco("Rua B, 456");
$vendedor->setCidade("Rio de Janeiro");
$vendedor->setEstado("RJ");
$vendedor->setCelular("21999999999");
$vendedor->setEmail("maria@email.com");
$vendedor->setPercComissao(15.00);
$vendedor->setDataAdmissao("2024-01-01");
$vendedor->setSetor("Vendas");
$vendedor->setSenha("12345");

if ($vendedor->save()) {
    echo "Vendedor inserido com sucesso!";
} else {
    echo "Erro ao inserir vendedor.";
}
