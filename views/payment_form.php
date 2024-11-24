<?php
require_once "../models/FormaPagto.php";
$pagamento = new FormaPagto();

$formasPagamento = $pagamento->getAll();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Listagem de Vendedores</h1>
        <button id="btnCadastrarVendedor" class="btn ubuntu-medium">Cadastrar vendedor</button>
    </div>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th colspan="2">Operações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($formasPagamento)) {
                foreach ($formasPagamento as $pagamento) {
                    echo "<tr data-id='" . $pagamento['id'] . "' class='product-row'>";
                    echo "<td>" . $pagamento['id'] . "</td>";
                    echo "<td>" . $pagamento['nome'] . "</td>";
                    echo "<td><img width='15px' src='../assets/icons/pen-to-square-solid.svg' data-id='" . $pagamento['id'] . "' alt='Editar'></td>";
                    echo "<td><img width='15px' src='../assets/icons/trash-solid.svg' data-id='" . $pagamento['id'] . "' alt='Excluir'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhuma forma de pagamento encontrado</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>