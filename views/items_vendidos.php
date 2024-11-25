<?php
require_once "../models/ItemPedido.php";
require_once "../models/Produto.php";
require_once "../models/Cliente.php";
require_once "../models/Vendedor.php";

$itemPedido = new ItemPedido();
$itemsVendidos = $itemPedido->getAll();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<?php
require_once "../models/ItemPedido.php";
require_once "../models/Produto.php";
require_once "../models/Cliente.php";
require_once "../models/Vendedor.php";
session_start();

$itemPedido = new ItemPedido();
$itemsVendidos = $itemPedido->getAllItems();

?>

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Itens Vendidos</h1>
    </div>
    <div class="table">
        <div id="relatorio">
            <div class="relatorio-container">
                <div class="relatorio-body">
                    <form id="Filtrar">
                        <div style="display: flex; gap: 20px">
                            <div class="form-item-modal">
                                <label for="tipo_filtro" class="form-item-label">Tipo de filtro</label>
                                <select class="filtrar input-field" id="tipo_filtro">
                                    <option value="">Escolha como filtrar...</option>
                                    <option value="id_pedido">ID Pedido</option>
                                    <option value="nome_cliente">Nome do Cliente</option>
                                </select>
                            </div>
                            <div class="form-item-modal">
                                <label for="valor_filtro" class="form-item-label">Valor do Filtro</label>
                                <input type="text" id="valor_filtro" name="valor_filtro" class="input-field">
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
                    <th>ID Pedido</th>
                    <th>Data</th>
                    <th>Cliente ID - Nome</th>
                    <th>Vendedor ID - Nome</th>
                    <th>Produto ID - Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($itemsVendidos)) {
                    foreach ($itemsVendidos as $item) {
                        echo "<tr data-id='" . $item['id_item'] . "' class='item-row'>";
                        echo "<td>" . $item['id_pedido'] . "</td>";
                        echo "<td>" . $item['data'] . "</td>";
                        echo "<td>" . $item['id_cliente'] . " - " . $item['nome_cliente'] . "</td>";
                        echo "<td>" . $item['id_vendedor'] . " - " . $item['nome_vendedor'] . "</td>";
                        echo "<td>" . $item['id_produto'] . " - " . $item['nome_produto'] . "</td>";
                        echo "<td>" . number_format($item['preco'], 2, ',', '.') . "</td>";
                        echo "<td>" . $item['quantidade_comprada'] . "</td>";
                        echo "<td onclick='excluirItem(this)'><img width='15px' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum item vendido encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div id="modalCadastro" class="modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Excluir Item Vendido</h2>
            <span class="close" id="btnFecharModal">&times;</span>
        </div>
        <div class="modal-body">
            <p>Tem certeza de que deseja excluir este item vendido?</p>
            <div class="modal-footer">
                <button type="button" onclick="confirmarExclusao()" class="btn">Sim, excluir</button>
                <button type="button" onclick="fecharModal()" class="btn">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
    function gerarRelatorio(event) {
        event.preventDefault();

        const tipoFiltro = $('#tipo_filtro').val();
        const valorFiltro = $('#valor_filtro').val();

        if (!tipoFiltro || !valorFiltro) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, insira um filtro de tipo e valor.',
                icon: 'error',
            });
            return;
        }

        $.ajax({
            url: '../controllers/item_vendido_controller.php',
            type: 'POST',
            data: {
                action: 'filtrar',
                tipo_filtro: tipoFiltro,
                valor_filtro: valorFiltro
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    if (response.pedidos.length === 0) {
                        Swal.fire({
                            title: 'Nenhum pedido encontrado',
                            text: 'Não há pedidos no filtro especificado.',
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
            error: function () {
                Swal.fire('Erro!', 'Não foi possível filtrar os pedidos.', 'error');
            }
        });
    }

    function updateTable(items) {
        let tableBody = $('table tbody');
        tableBody.empty();

        items.forEach(function (item) {
            const row = `<tr data-id="${item.id_item}">
                        <td>${item.id_pedido}</td>
                        <td>${item.data}</td>
                        <td>${item.id_cliente} - ${item.nome_cliente}</td>
                        <td>${item.id_vendedor} - ${item.nome_vendedor}</td>
                        <td>${item.id_produto} - ${item.nome_produto}</td>
                        <td>${item.preco}</td>
                        <td>${item.quantidade_comprada}</td>
                        <td><img width="15px" src="../assets/icons/trash-solid.svg" alt="Excluir" onclick="excluirItem(this)"></td>
                    </tr>`;
            tableBody.append(row);
        });
    }

    function excluirItem(el) {
        const row = $(el).closest('tr');
        const itemId = row.data('id');
        $('#modalCadastro').data('id', itemId);
        $("#modalCadastro").css("display", "flex");
    }

    function confirmarExclusao() {
        const itemId = $('#modalCadastro').data('id');
        console.log(itemId)
        $.ajax({
            url: '../controllers/item_vendido_controller.php',
            type: 'POST',
            data: { action: 'excluir', id: itemId },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Excluído!',
                        text: response.message,
                        icon: 'success',
                        backdrop: false
                    });
                    $('tr[data-id="' + itemId + '"]').remove();
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
                console.log(err)
                Swal.fire('Erro!', 'Não foi possível excluir o item vendido.', 'error');
            }
        });
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