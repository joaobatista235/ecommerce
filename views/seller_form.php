<?php
require_once "../models/Vendedor.php";
$vendedor = new Vendedor();

$vendedores = $vendedor->getAll();
?>

<script src="../js/seller.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../config/global.css">

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Listagem de Vendedores</h1>
        <button onclick="abrirModalCadastro()" class="btn ubuntu-medium">Cadastrar vendedor</button>
    </div>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Celular</th>
                <th>Email</th>
                <th>% Comissão</th>
                <th>Data de admissão</th>
                <th>Senha</th>
                <th colspan="2">Operações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($vendedores)) {
                foreach ($vendedores as $vendedor) {
                    $data_admissao = $vendedor['data_admissao'];
                    $class = '';
                    if (empty($vendedor['data_admissao'])) {
                        $data_admissao = '00/00/0000';
                        $class = "style='color:#A0A1A7'";
                    }
                    $data_admissao = $vendedor['data_admissao'] ? date('d/m/Y', strtotime($vendedor['data_admissao'])) : '00/00/0000';
                    echo "<tr data-id='" . $vendedor['id'] . "' class='vendedor-row'>";
                    echo "<td>" . $vendedor['id'] . "</td>";
                    echo "<td>" . $vendedor['nome'] . "</td>";
                    echo "<td>" . $vendedor['endereco'] . "</td>";
                    echo "<td>" . $vendedor['cidade'] . "</td>";
                    echo "<td>" . $vendedor['estado'] . "</td>";
                    echo "<td>" . $vendedor['celular'] . "</td>";
                    echo "<td>" . $vendedor['email'] . "</td>";
                    echo "<td>" . $vendedor['perc_comissao'] . "</td>";
                    echo "<td " . $class . ">" . $data_admissao . "</td>";
                    echo "<td>" . $vendedor['senha'] . "</td>";
                    echo "<td onclick='abrirModalEdicao(this)'><img width='15px' src='../assets/icons/pen-to-square-solid.svg' alt='Editar'></td>";
                    echo "<td onclick='excluirVendedor(this)'><img width='15px' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum vendedor encontrado</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <div id="modalCadastro" class="modal" style="display:none;!important">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Cadastrar Novo Vendedor</h2>

                <svg class='modal-header-close-button' id="btnFecharModal" width="14" height="14" viewBox="0 0 14 14"
                     fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                          fill="black" fill-opacity="0.54"/>
                </svg>


            </div>
            <div class="modal-body">
                <form id="formCadastrarVendedor">
                    <div class="form-container">
                        <div class="form-item-modal">
                            <label for="nome" class="form-item-label">Nome do Vendedor:</label>
                            <input type="text" id="nome" name="nome" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="endereco" class="form-item-label">Endereço:</label>
                            <input type="text" id="endereco" name="endereco" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="cidade" class="form-item-label">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="estado" class="form-item-label">Estado:</label>
                            <input type="text" id="estado" name="estado" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="celular" class="form-item-label">Celular:</label>
                            <input type="text" id="celular" name="celular" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="email" class="form-item-label">Email:</label>
                            <input type="text" id="email" name="email" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="comissao" class="form-item-label">Comissão:</label>
                            <input type="text" id="comissao" name="comissao" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="data_admissao" class="form-item-label">Data de admissão:</label>
                            <input type="date" id="data_admissao" name="data_admissao" class="input-field" required>
                        </div>

                        <div class="form-item-modal">
                            <label for="senha" class="form-item-label">Senha:</label>
                            <input type="text" id="senha" name="senha" class="input-field" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn">Cadastrar vendedor</button>
                    </div>
                </form>
            </div>
        </div>
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
                        <button type="button" onclick="gerarRelatorio(event)" class="btn">Gerar relatório</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>