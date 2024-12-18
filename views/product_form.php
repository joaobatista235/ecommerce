<?php
require_once "../models/Produto.php";

$productModel = new Produto();
$produtos = $productModel->getAll();

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Listagem de Produtos</h1>
        <button id="btnCadastrarProduto" class="btn ubuntu-medium">Cadastrar produto</button>
    </div>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade em Estoque</th>
                <th>Preço</th>
                <th>Unidade de Medida</th>
                <th>Promoção</th>
                <th colspan="2">Operações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($produtos)) {
                foreach ($produtos as $produto) {
                    echo "<tr data-id='" . $produto['id'] . "' class='product-row'>";
                    echo "<td>" . $produto['id'] . "</td>";
                    echo "<td>" . $produto['nome'] . "</td>";
                    echo "<td>" . $produto['qtde_estoque'] . "</td>";
                    echo "<td class='price'>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>";
                    echo "<td>" . $produto['unidade_medida'] . "</td>";
                    echo "<td class='" . ($produto['promocao'] == 'Y' ? 'promo' : 'no-promo') . "'>" . ($produto['promocao'] == 'Y' ? 'Sim' : 'Não') . "</td>";
                    echo "<td onclick='abrirModalEdicao(this)'><img width='15px' class='btnEditar btnCli' src='../assets/icons/pen-to-square-solid.svg' data-id='" . $produto['id'] . "' alt='Editar'></td>";
                    echo "<td onclick='excluirProduto(this)'><img width='15px' class='btnExcluir btnCli' src='../assets/icons/trash-solid.svg' data-id='" . $produto['id'] . "' alt='Excluir'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum produto encontrado</td></tr>";
            }
            ?>
            </tbody>
        </table>

        <div id="modalCadastro" class="modal" style="display:none;!important">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Cadastrar Novo Produto</h2>
                    <span class="close" id="btnFecharModal">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="formCadastrarProduto">
                        <div class="form-container">
                            <div class="form-item-modal">
                                <label for="nome" class="form-item-label">Nome do Produto:</label>
                                <input type="text" id="nome" name="nome" class="input-field" required>
                            </div>

                            <div class="form-item-modal">
                                <label for="qtde_estoque" class="form-item-label">Quantidade em Estoque:</label>
                                <input type="number" id="qtde_estoque" name="qtde_estoque" class="input-field" required>
                            </div>

                            <div class="form-item-modal">
                                <label for="preco" class="form-item-label">Preço:</label>
                                <input type="text" id="preco" name="preco" class="input-field" required>
                            </div>

                            <div class="form-item-modal">
                                <label for="unidade_medida" class="form-item-label">Unidade de Medida:</label>
                                <input type="text" id="unidade_medida" name="unidade_medida" class="input-field"
                                       required>
                            </div>

                            <div class="form-item-modal">
                                <label for="promocao" class="form-item-label">Promoção:</label>
                                <select id="promocao" name="promocao" class="input-field" required>
                                    <option value="N">Não</option>
                                    <option value="Y">Sim</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn">Salvar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="relatorio" style="margin-top:30px">
        <div class="relatorio-container">
            <div class="relatorio-header">
                <h2 class="ubuntu-bold" style="color:#6a1b9a">Filtrar Dados</h2>
            </div>
            <br>
            <hr>
            <br>
            <div class="relatorio-body">
                <form id="gerarRelatorio">
                    <div style="display: flex; gap: 20px">
                        <div class="form-item-modal">
                            <label for="nome-filtro" class="form-item-label">Nome:</label>
                            <input type="text" id="nome-filtro" name="nome-filtro" class="input-field">
                        </div>
                        <div class="form-item-modal">
                            <label for="preco-filtro" class="form-item-label">Preço:</label>
                            <input type="text" id="preco-filtro" name="preco-filtro" class="input-field">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnFiltrar" onclick="atualizarTabela(true)" type="button" class="btn"
                                style="background-color:var(--sidebar-color);">Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#btnCadastrarProduto').click(function () {
                $('#modalCadastro').css("display", "flex");
            });

            $('#btnFecharModal').click(function () {
                $('#modalCadastro').hide();
            });

            $(window).click(function (event) {
                if (event.target === document.getElementById('modalCadastro')) {
                    $('#modalCadastro').hide();
                }
            });

            $('#formCadastrarProduto').submit(function (e) {
                e.preventDefault()
                const form = document.getElementById('formCadastrarProduto');
                const produtoId = $('#formCadastrarProduto').data('id');

                let nome = $('#nome').val();
                let qtde_estoque = $('#qtde_estoque').val();
                let preco = $('#preco').val();
                let unidade_medida = $('#unidade_medida').val();
                let promocao = $('#promocao').val();

                const formData = {
                    action: produtoId ? 'editar' : 'cadastrar',
                    id: produtoId,
                    nome: nome,
                    preco: preco,
                    qtde_estoque: qtde_estoque,
                    unidade_medida: unidade_medida,
                    promocao: promocao
                };

                $.ajax({
                    url: '../controllers/product_controller.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            form.reset();
                            $('#modalCadastro').hide();

                            Swal.fire({
                                title: 'Sucesso!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                backdrop: false,
                            });
                            document.getElementById('modalCadastro').style.display = 'none';
                            atualizarTabela();

                        } else {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Não foi possível cadastrar o produto.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                backdrop: false,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao tentar cadastrar o produto.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            backdrop: false,
                        });
                    }
                });
            });
        });

        function excluirProduto(el) {
            const produtoId = $(el).closest('tr').attr('data-id');
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Essa ação não pode ser desfeita!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                backdrop: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../controllers/product_controller.php',
                        type: 'POST',
                        data: {action: 'excluir', productId: produtoId},
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Excluído!',
                                    text: 'O produto foi excluído com sucesso.',
                                    icon: 'success',
                                    backdrop: false
                                });
                                atualizarTabela();
                            }
                        },
                        error: function (err) {
                            console.log(err)
                        }
                    });
                } else if (result.isDismissed) {
                    Swal.fire({
                        title: 'Cancelado!',
                        text: 'Ação cancelada.',
                        icon: 'info',
                        backdrop: false
                    });
                }
            });
        }

        function atualizarTabela(filtro = false) {
            let data = {action: "listar", filtro: false};
            if (filtro) {
                data.filtro = true;
                data.nome = $('#nome-filtro').val();
                data.preco = $('#preco-filtro').val()
            }

            $.ajax({
                url: '../controllers/product_controller.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const produtos = response.produtos;
                        const tbody = document.querySelector('table tbody');

                        tbody.innerHTML = '';
                        produtos.forEach(produto => {
                            const tr = document.createElement('tr');
                            tr.setAttribute('data-id', produto.id);
                            tr.innerHTML = `
                                    <td>${produto.id}</td>
                                    <td>${produto.nome}</td>
                                    <td>${produto.qtde_estoque}</td>
                                    <td class="price">R$ ${produto.preco}</td>
                                    <td>${produto.unidade_medida}</td>
                                    <td class="${produto.promocao === 'Y' ? 'promo' : 'no-promo'}">${produto.promocao === 'Y' ? 'Sim' : 'Não'}</td>
                                    <td onclick="abrirModalEdicao(this)"><img width='15px' class="btnEditar" src="../assets/icons/pen-to-square-solid.svg" alt="Excluir"></td>
                                    <td onclick="excluirProduto(this)"><img width='15px' class='btnExcluir' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>
                                `;
                            tbody.appendChild(tr);
                        });
                    }
                }
            });
        }

        function abrirModalEdicao(el) {
            const row = $(el).closest('tr');
            const produto = {
                id: row.find('td').eq(0).text(),
                nome: row.find('td').eq(1).text(),
                qtde_estoque: row.find('td').eq(2).text(),
                preco: row.find('td').eq(3).text().replace('R$ ', '').replace(',', '.'),
                unidade_medida: row.find('td').eq(4).text(),
                promocao: row.find('td').eq(5).text() === 'Sim' ? 'Y' : 'N'
            };

            $('#formCadastrarProduto').data('id', produto.id);

            $('#formCadastrarProduto #nome').val(produto.nome);
            $('#formCadastrarProduto #preco').val(produto.preco);
            $('#formCadastrarProduto #qtde_estoque').val(produto.qtde_estoque);
            $('#formCadastrarProduto #unidade_medida').val(produto.unidade_medida);
            $('#formCadastrarProduto #promocao').val(produto.promocao);

            $('#modalCadastro').css("display", "flex");
        }

    </script>
</div>