<?php
require_once "../models/Cliente.php";
$cli_model = new Cliente();

$clientes = $cli_model->getAll();
?>

<div class="container-client">
    <div class="tabel-container">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Numero</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Email</th>
                    <th>CPF/CNPJ</th>
                    <th>RG</th>
                    <th>Telefone</th>
                    <th>Celular</th>
                    <th>Data de nascimento</th>
                    <th>Salário</th>
                    <th>Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($clientes)) {
                    foreach ($clientes as $cliente) {
                        echo "<tr data-id='" . $cliente->getId() . "' class='client-row'>";
                        echo "<td>" . $cliente->getNome() . "</td>";
                        echo "<td>" . $cliente->getEndereco() . "</td>";
                        echo "<td>" . $cliente->getNumero() . "</td>";
                        echo "<td>" . $cliente->getBairro() . "</td>";
                        echo "<td>" . $cliente->getCidade() . "</td>";
                        echo "<td>" . $cliente->getEstado() . "</td>";
                        echo "<td>" . $cliente->getEmail() . "</td>";
                        echo "<td>" . $cliente->getCpfCnpj() . "</td>";
                        echo "<td>" . $cliente->getRg() . "</td>";
                        echo "<td>" . $cliente->getTelefone() . "</td>";
                        echo "<td>" . $cliente->getCelular() . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($cliente->getDataNasc())) . "</td>";
                        echo "<td>R$ " . number_format($cliente->getSalario(), 2, ',', '.') . "</td>";
                        echo "<td>";
                        echo "<button class='btnEditar btnCli' data-id='" . $cliente->getId() . "'>Editar</button>";
                        echo " ";
                        echo "<button class='btnExcluir btnCli' data-id='" . $cliente->getId() . "'>Excluir</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='14'>Nenhum cliente encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="buttons" style="display:flex">
            <button class="btn">Ver mais produtos</button>
            <button id="btnCadastrarProduto" class="btn">Cadastrar produto</button>
        </div>


        <div id="modalCadastro" class="modal" style="display:none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Cadastrar/Editar Cliente</h2>
                    <span class="close" id="btnFecharModal">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="formCadastrarCliente">
                        <div class="form-container">
                            <!-- Nome -->
                            <div class="form-item-modal">
                                <label for="nome" class="form-item-label">Nome:</label>
                                <input type="text" id="nome" name="nome" class="input-field" required>
                            </div>

                            <!-- Endereço -->
                            <div class="form-item-modal">
                                <label for="endereco" class="form-item-label">Endereço:</label>
                                <input type="text" id="endereco" name="endereco" class="input-field" required>
                            </div>

                            <!-- Número -->
                            <div class="form-item-modal">
                                <label for="numero" class="form-item-label">Número:</label>
                                <input type="text" id="numero" name="numero" class="input-field" required>
                            </div>

                            <!-- Bairro -->
                            <div class="form-item-modal">
                                <label for="bairro" class="form-item-label">Bairro:</label>
                                <input type="text" id="bairro" name="bairro" class="input-field" required>
                            </div>

                            <!-- Cidade -->
                            <div class="form-item-modal">
                                <label for="cidade" class="form-item-label">Cidade:</label>
                                <input type="text" id="cidade" name="cidade" class="input-field" required>
                            </div>

                            <!-- Estado -->
                            <div class="form-item-modal">
                                <label for="estado" class="form-item-label">Estado:</label>
                                <input type="text" id="estado" name="estado" class="input-field" required>
                            </div>

                            <!-- Email -->
                            <div class="form-item-modal">
                                <label for="email" class="form-item-label">Email:</label>
                                <input type="email" id="email" name="email" class="input-field" required>
                            </div>

                            <!-- CPF/CNPJ -->
                            <div class="form-item-modal">
                                <label for="cpf_cnpj" class="form-item-label">CPF/CNPJ:</label>
                                <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="input-field" required>
                            </div>

                            <!-- RG -->
                            <div class="form-item-modal">
                                <label for="rg" class="form-item-label">RG:</label>
                                <input type="text" id="rg" name="rg" class="input-field" required>
                            </div>

                            <!-- Telefone -->
                            <div class="form-item-modal">
                                <label for="telefone" class="form-item-label">Telefone:</label>
                                <input type="text" id="telefone" name="telefone" class="input-field" required>
                            </div>

                            <!-- Celular -->
                            <div class="form-item-modal">
                                <label for="celular" class="form-item-label">Celular:</label>
                                <input type="text" id="celular" name="celular" class="input-field" required>
                            </div>

                            <!-- Data de Nascimento -->
                            <div class="form-item-modal">
                                <label for="data_nasc" class="form-item-label">Data de Nascimento:</label>
                                <input type="date" id="data_nasc" name="data_nasc" class="input-field" required>
                            </div>

                            <!-- Salário -->
                            <div class="form-item-modal">
                                <label for="salario" class="form-item-label">Salário:</label>
                                <input type="text" id="salario" name="salario" class="input-field" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn">Salvar Cliente</button>
                        </div>
                    </form>
                </div>
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
                e.preventDefault();
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
                                console.log(response);
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
                url: '../controllers/cliente_controller.php',
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