<?php
require_once "../models/Pedido.php";
require_once "../models/Cliente.php";
require_once "../models/Vendedor.php";
session_start();

$pedido = new Pedido();
$pedidos = $pedido->getAll();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Listagem de Pedidos</h1>
    </div>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente ID - Nome</th>
                <th>Vendedor ID - Nome</th>
                <th>Data</th>
                <th>Forma de Pagamento</th>
                <th>Prazo de Entrega</th>
                <th>Operações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($pedidos)) {
                foreach ($pedidos as $pedido) {
                    echo "<tr data-id='" . $pedido->getId() . "' class='product-row'>";
                    echo "<td>" . $pedido->getId() . "</td>";
                    echo "<td>" . $pedido->getIdCliente() . " - " . $pedido->getNomeCliente() . "</td>";
                    echo "<td>" . $pedido->getIdVendedor() . " - " . $pedido->getNomeVendedor() . "</td>";
                    echo "<td>" . $pedido->getData() . "</td>";
                    echo "<td>" . $pedido->getFormaPagto() . "</td>";
                    echo "<td>" . $pedido->getPrazoEntrega() . "</td>";
                    echo "<td onclick='excluirPedido(this)'><img width='15px' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum pedido encontrado</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for confirmation -->
    <div id="modalCadastro" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Excluir Pedido</h2>
                <span class="close" id="btnFecharModal">&times;</span>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir este pedido?</p>
                <div class="modal-footer">
                    <button type="button" onclick="confirmarExclusao()" class="btn">Sim, excluir</button>
                    <button type="button" onclick="fecharModal()" class="btn">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Excluir pedido function (opens modal)
    function excluirPedido(el) {
        const row = $(el).closest('tr');
        const pedidoId = row.data('id');
        $('#modalCadastro').data('id', pedidoId);
        $("#modalCadastro").css("display", "flex");
    }

    // Confirmar exclusão do pedido
    function confirmarExclusao() {
        const pedidoId = $('#modalCadastro').data('id');
        $.ajax({
            url: '../controllers/pedido_controller.php',
            type: 'POST',
            data: { action: 'excluir', id: pedidoId },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Excluído!',
                        text: response.message,
                        icon: 'success',
                    });
                    $('tr[data-id="' + pedidoId + '"]').remove();
                    fecharModal();
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: response.message,
                        icon: 'error',
                    });
                }
            },
            error: function (err) {
                Swal.fire('Erro!', 'Não foi possível excluir o pedido.', 'error');
            }
        });
    }

    // Fechar o modal
    function fecharModal() {
        $('#modalCadastro').css("display", "none");
    }

    // Fechar o modal ao clicar no X
    $('#btnFecharModal').click(function () {
        fecharModal();
    });

    // Fechar o modal ao clicar fora dele
    $(window).click(function (event) {
        if (event.target === document.getElementById('modalCadastro')) {
            fecharModal();
        }
    });
</script>
