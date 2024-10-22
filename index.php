
<?php
require_once "models/Vendedor.php";
$vendedor = new Vendedor();

$vendedor->setNome("João Silva");
$vendedor->setEndereco("Rua das Flores, 123");
$vendedor->setCidade("São Paulo");
$vendedor->setEstado("SP");
$vendedor->setCelular("(11) 91234-5678");
$vendedor->setEmail("joao.silva@example.com");
$vendedor->setPercComissao("15%");
$vendedor->setDataAdmissao("2023-10-22");
$vendedor->setSetor("Vendas");
$vendedor->setSenha(password_hash("senha123", PASSWORD_DEFAULT));

if ($vendedor->save()) {
    echo "Vendedor inserido com sucesso!";
} else {
    echo "Falha ao inserir o vendedor.";
}

?>