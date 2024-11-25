<?php
require_once "../models/Fornecedor.php";
session_start();

$fornecedor = new Fornecedor();

$fornecedores = $fornecedor->getAll();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Listagem de Fornecedores</h1>
        <button onclick="abrirModalCadastro()" class="btn ubuntu-medium">Cadastrar Fornecedor</button>
    </div>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Contato</th>
                <th colspan="2">Operações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($fornecedores)) {
                foreach ($fornecedores as $fornecedor) {
                    echo "<tr data-id='" . $fornecedor->getId() . "' class='fornecedor-row'>";
                    echo "<td>" . $fornecedor->getId() . "</td>";
                    echo "<td>" . $fornecedor->getNome() . "</td>";
                    echo "<td>" . $fornecedor->getContato() . "</td>";
                    echo "<td onclick='abrirModalEdicao(this)'><img width='15px' src='../assets/icons/pen-to-square-solid.svg' alt='Editar'></td>";
                    echo "<td onclick='excluirFornecedor(this)'><img width='15px' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum fornecedor encontrado</td></tr>";
            }
            ?>


            </tbody>
        </table>
    </div>

    <div id="modalCadastro" class="modal" style="display:none;!important">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Cadastrar Novo Fornecedor</h2>
                <span class="close" id="btnFecharModal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="formCadastrarFornecedor">
                    <div class="form-container">
                        <div class="form-item-modal">
                            <label for="nome" class="form-item-label">Nome do Fornecedor:</label>
                            <input type="text" id="nome" name="nome" class="input-field" required>
                        </div>
                        <div class="form-item-modal">
                            <label for="contato" class="form-item-label">Contato:</label>
                            <input type="text" id="contato" name="contato" class="input-field" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn">Cadastrar Fornecedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#btnFecharModal').click(function () {
            $('#modalCadastro').hide();
        });

        $(window).click(function (event) {
            if (event.target === document.getElementById('modalCadastro')) {
                $('#modalCadastro').hide();
            }
        });
    });

    function abrirModalCadastro() {
        const form = $("#formCadastrarFornecedor");
        form.trigger("reset");
        form.removeData('id');
        $("#modalCadastro").css("display", "flex");
    }

    $('#formCadastrarFornecedor').submit(function (e) {
        e.preventDefault();
        const fornecedorId = $(this).data('id');
        const nome = $('#nome').val();
        const contato = $('#contato').val();

        const formData = {
            action: fornecedorId ? 'editar' : 'cadastrar',
            id: fornecedorId,
            nome: nome,
            contato: contato
        };

        $.ajax({
            url: '../controllers/fornecedor_controller.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#formCadastrarFornecedor')[0].reset();
                    $('#modalCadastro').hide();

                    Swal.fire({
                        title: 'Sucesso!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        backdrop: false,
                    });

                    atualizarTabelaFornecedores();
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Não foi possível cadastrar o fornecedor.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        backdrop: false,
                    });
                }
            },
            error: function (err) {
                console.error(err);
                Swal.fire({
                    title: 'Erro!',
                    text: 'Ocorreu um erro ao tentar cadastrar o fornecedor.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: false,
                });
            }
        });
    });

    function abrirModalEdicao(el) {
        const row = $(el).closest('tr');
        const fornecedor = {
            id: row.find('td').eq(0).text(),
            nome: row.find('td').eq(1).text(),
            contato: row.find('td').eq(2).text()
        };

        $('#formCadastrarFornecedor').data('id', fornecedor.id);
        $('#nome').val(fornecedor.nome);
        $('#contato').val(fornecedor.contato);
        $("#modalCadastro").css("display", "flex");
    }

    function excluirFornecedor(el) {
        const fornecedorId = $(el).closest('tr').attr('data-id');
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Essa ação não pode ser desfeita!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            backdrop: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../controllers/fornecedor_controller.php',
                    type: 'POST',
                    data: {action: 'excluir', id: fornecedorId},
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Excluído!',
                                text: response.message,
                                icon: 'success',
                                backdrop: false,
                            });
                            document.querySelector(`tr[data-id="${fornecedorId}"]`).remove();
                        }
                    },
                    error: function (err) {
                        console.error(err);
                        Swal.fire('Erro!', 'Não foi possível excluir o fornecedor.', 'error');
                    }
                });
            }
        });
    }

    function atualizarTabelaFornecedores() {
        $.ajax({
            url: '../controllers/fornecedor_controller.php',
            type: 'POST',
            data: {action: 'listar'},
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const fornecedores = response.fornecedores;
                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = '';
                    fornecedores.forEach(fornecedor => {
                        const tr = document.createElement('tr');
                        tr.setAttribute('data-id', fornecedor.id);

                        tr.innerHTML = `
                            <td>${fornecedor.id}</td>
                            <td>${fornecedor.nome}</td>
                            <td>${fornecedor.contato}</td>
                            <td onclick="abrirModalEdicao(this)"><img width='15px' class="btnEditar" src="../assets/icons/pen-to-square-solid.svg" alt="Editar"></td>
                            <td onclick="excluirFornecedor(this)"><img width='15px' class='btnExcluir' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            }
        });
    }
</script>
