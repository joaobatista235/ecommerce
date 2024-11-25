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
        <div id="relatorio">
            <div class="relatorio-container">
                <div class="relatorio-header">
                    <h2>Gerar relatório</h2>
                </div>
                <div class="relatorio-body">
                    <form id="Filtrar">
                        <div style="display: flex; gap: 20px">
                            <div class="form-item-modal">
                                <label for="inicio" class="form-item-label">De:</label>
                                <input type="date" id="inicio" name="inicio" class="input-field">
                            </div>
                            <div class="form-item-modal">
                                <label for="fim" class="form-item-label">Até:</label>
                                <input type="date" id="fim" name="fim" class="input-field">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="gerarRelatorio(event)" class="btn">Filtrar pedidos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

    // Function to filter pedidos based on date range
    function gerarRelatorio(event) {
        event.preventDefault(); // Prevent the default form submission
        const dt1 = $('#inicio').val();  // Start date
        const dt2 = $('#fim').val();     // End date

        if (!dt1 || !dt2) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, selecione um intervalo de datas.',
                icon: 'error',
            });
            return;
        }

        // Send an AJAX request to filter pedidos by the date range
        $.ajax({
            url: '../controllers/pedido_controller.php',
            type: 'POST',
            data: {
                action: 'filtrar',
                dt1: dt1,
                dt2: dt2
            },
            dataType: 'json',
            success: function (response) {
                console.log("Filtered Response:", response);  // Debugging

                if (response.success) {
                    if (response.pedidos.length === 0) {
                        Swal.fire({
                            title: 'Nenhum pedido encontrado',
                            text: 'Não há pedidos no intervalo de datas especificado.',
                            icon: 'info',
                        });
                    } else {
                        updateTable(response.pedidos);
                    }
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: response.message,
                        icon: 'error',
                    });
                }
            },
            error: function (err) {
                Swal.fire('Erro!', 'Não foi possível filtrar os pedidos.', 'error');
            }
        });
    }

    // Function to update the table with the filtered pedidos
    function updateTable(pedidos) {
        const tableBody = $('table tbody');
        tableBody.empty();  // Clear the current table rows

        if (pedidos.length > 0) {
            pedidos.forEach(pedido => {
                tableBody.append(`
                    <tr data-id="${pedido.id}" class="product-row">
                        <td>${pedido.id}</td>
                        <td>${pedido.id_cliente} - ${pedido.nome_cliente}</td>
                        <td>${pedido.id_vendedor} - ${pedido.nome_vendedor}</td>
                        <td>${pedido.data}</td>
                        <td>${pedido.forma_pagto}</td>
                        <td>${pedido.prazo_entrega}</td>
                        <td onclick="excluirPedido(this)"><img width="15px" src="../assets/icons/trash-solid.svg" alt="Excluir"></td>
                    </tr>
                `);
            });
        } else {
            tableBody.append('<tr><td colspan="7">Nenhum pedido encontrado</td></tr>');
        }
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