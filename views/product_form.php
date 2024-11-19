<?php
require_once "../models/Produto.php";

$productModel = new Produto();
$produtos = $productModel->getAll();

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<div class="product-list"></div>
<div class="product-container">
    <h1>Listagem de Produtos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade em Estoque</th>
                <th>Preço</th>
                <th>Unidade de Medida</th>
                <th>Promoção</th>
                <th>Excluir</th>
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
                    echo "<td><img class='btnExcluir' src='../assets/icons/trash-solid.svg' width='15px' data-id='" . $produto['id'] . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum produto encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="buttons" style="display:flex">
        <button class="btn">Ver mais produtos</button>
        <button id="btnCadastrarProduto" class="btn">Cadastrar produto</button>
    </div>

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
                            <input type="text" id="unidade_medida" name="unidade_medida" class="input-field" required>
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

    <script>

        $(document).ready(function () {
            $('#btnCadastrarProduto').click(function () {
                $('#modalCadastro').show();
            });

            $('#btnFecharModal').click(function () {
                $('#modalCadastro').hide();
            });

            $(window).click(function (event) {
                if (event.target == document.getElementById('modalCadastro')) {
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
                    produtoId: produtoId,
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
                                confirmButtonText: 'OK'
                            });
                            document.getElementById('modalCadastro').style.display = 'none';
                            atualizarTabela();

                        } else {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Não foi possível cadastrar o produto.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao tentar cadastrar o produto.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        function excluirProduto(produtoId) {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Essa ação não pode ser desfeita!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Excluído!',
                        'O produto foi excluído com sucesso.',
                        'success'
                    );
                    $.ajax({
                        url: '../controllers/product_controller.php',
                        type: 'POST',
                        data: { action: 'excluir', productId: produtoId },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Excluído!',
                                    text: response.message,
                                    icon: 'success'
                                });
                                console.log(response)
                                document.querySelector(`tr[data-id="${produtoId}"]`).remove();
                            }
                        },
                        error: function () {
                            alert("OCORREU UM ERRO");
                        },
                    });
                } else if (result.isDismissed) {
                    Swal.fire(
                        'Cancelado!',
                        'Ação cancelada.',
                        'info'
                    );
                }
            });
        }

        document.querySelectorAll('.btnExcluir').forEach(function (btnExcluir) {
            btnExcluir.addEventListener('click', function (event) {
                event.stopPropagation();
                const produtoId = this.getAttribute('data-id');
                excluirProduto(produtoId);
            });
        });

        function atualizarTabela() {
            $.ajax({
                url: '../controllers/product_controller.php',
                type: 'POST',
                data: { action: 'listar' },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const produtos = response.produtos;
                        const tbody = document.querySelector('table tbody');
                        tbody.innerHTML = '';
                        produtos.forEach(produto => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                        <td>${produto.id}</td>
                        <td>${produto.nome}</td>
                        <td>${produto.qtde_estoque}</td>
                        <td class="price">R$ ${produto.preco}</td>
                        <td>${produto.unidade_medida}</td>
                        <td class="${produto.promocao === 'Y' ? 'promo' : 'no-promo'}">${produto.promocao === 'Y' ? 'Sim' : 'Não'}</td>
                        <td><img class="btnExcluir" src="../assets/icons/trash-solid.svg" width="15px" data-id="${produto.id}"></td>
                    `;
                            tbody.appendChild(tr);
                        });

                        document.querySelectorAll('.btnExcluir').forEach(btnExcluir => {
                            btnExcluir.addEventListener('click', function () {
                                const produtoId = this.getAttribute('data-id');
                                excluirProduto(produtoId);
                            });
                        });
                    } else {
                        alert('Erro ao listar os produtos');
                    }
                },
                error: function () {
                    alert("Erro ao carregar os produtos.");
                }
            });
        }

        function abrirModalEdicao(produto) {
            $('#formCadastrarProduto').data('id', produto.id);

            $('#formCadastrarProduto #nome').val(produto.nome);
            $('#formCadastrarProduto #preco').val(produto.preco);
            $('#formCadastrarProduto #qtde_estoque').val(produto.qtde_estoque);
            $('#formCadastrarProduto #unidade_medida').val(produto.unidade_medida);
            $('#formCadastrarProduto #promocao').val(produto.promocao);

            $('#modalCadastro').show();
        }

        $('.product-row').on('click', function () {
            const produto = {
                id: $(this).data('id'),
                nome: $(this).find('td').eq(1).text(),
                preco: $(this).find('td').eq(3).text().replace('R$ ', '').replace(',', '.'),
                qtde_estoque: $(this).find('td').eq(2).text(),
                unidade_medida: $(this).find('td').eq(4).text(),
                promocao: $(this).find('td').eq(5).text() === 'Sim' ? 'Y' : 'N'
            };

            abrirModalEdicao(produto);
        });
    </script>
</div>