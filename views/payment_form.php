<?php
require_once "../models/FormaPagto.php";
$pagamento = new FormaPagto();

$formasPagamento = $pagamento->getAll();
?>

<script src="../js/payment.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Listagem de Métodos de pagamento</h1>
        <button onclick="abrirModalCadastro()" class="btn ubuntu-medium">Cadastrar Forma de pagamento</button>
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
                    echo "<td onclick='abrirModalEdicao(this)'><img width='15px' src='../assets/icons/pen-to-square-solid.svg' alt='Editar'></td>";
                    echo "<td onclick='excluirPagamento(this)'><img width='15px' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhuma forma de pagamento encontrado</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <div id="modalCadastro" class="modal" style="display:none;!important">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Cadastrar Nova Forma de pagamento</h2>
                <span class="close" id="btnFecharModal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="formCadastrarPagamento">
                    <div class="form-container">
                        <div class="form-item-modal">
                            <label for="nome" class="form-item-label">Forma de pagamento:</label>
                            <input type="text" id="nome" name="nome" class="input-field" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn">Cadastrar Forma de pagamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>