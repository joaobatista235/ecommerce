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
    <div id="relatorio">
        <div class="relatorio-container">
            <div class="relatorio-header">
                <h2 class="ubuntu-bold">Gerar relatório</h2>
            </div>
            <br>
            <hr>
            <br>
            <div class="relatorio-body">
                <form id="gerarRelatorio">
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
                        <button type="button" onclick="gerarRelatorioPedidos(event)" class="btn">Gerar relatório
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
    function gerarRelatorioPedidos() {
        const inicio = $('#inicio').val();
        const fim = $('#fim').val();

        $.ajax({
            url: "../controllers/pedido_controller.php",
            type: "POST",
            data: {action: "gerarRelatorio", inicio: inicio, fim: fim},
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    let pdfData = atob(response.pdf);
                    let pdfBlob = new Blob([new Uint8Array(pdfData.split("").map(function (c) {
                        return c.charCodeAt(0);
                    }))], {type: 'application/pdf'});

                    let link = document.createElement('a');
                    link.href = URL.createObjectURL(pdfBlob);
                    link.download = 'relatorio_pedidos.pdf';

                    link.click();
                } else {
                    alert('Erro: ' + response.message);
                }
            },
            error: function () {
                alert('Erro ao gerar o relatório');
            }
        });
    }

    function excluirPedido(el) {
        const row = $(el).closest('tr');
        const pedidoId = row.data('id');
        $('#modalCadastro').data('id', pedidoId);
        $("#modalCadastro").css("display", "flex");
    }

    function confirmarExclusao() {
        const pedidoId = $('#modalCadastro').data('id');
        $.ajax({
            url: '../controllers/pedido_controller.php',
            type: 'POST',
            data: {action: 'excluir', id: pedidoId},
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Excluído!',
                        text: response.message,
                        icon: 'success',
                        backdrop: false
                    });
                    $('tr[data-id="' + pedidoId + '"]').remove();
                    fecharModal();
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: response.message,
                        icon: 'error',
                        backdrop: false
                    });
                }
            },
            error: function (err) {
                Swal.fire('Erro!', 'Não foi possível excluir o pedido.', 'error');
            }
        });
    }

    function gerarRelatorio(event) {
        event.preventDefault();
        const dt1 = $('#inicio').val();
        const dt2 = $('#fim').val();

        if (!dt1 || !dt2) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, selecione um intervalo de datas.',
                icon: 'error',
            });
            return;
        }

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
                console.log("Filtered Response:", response);

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

    function updateTable(pedidos) {
        const tableBody = $('table tbody');
        tableBody.empty();

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

    function fecharModal() {
        $('#modalCadastro').css("display", "none");
    }

    $('#btnFecharModal').click(function () {
        fecharModal();
    });

    $(window).click(function (event) {
        if (event.target === document.getElementById('modalCadastro')) {
            fecharModal();
        }
    });
</script>