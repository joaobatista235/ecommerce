<?php
require_once "../models/Cliente.php";
$cli_model = new Cliente();

$clientes = $cli_model->getAll();
?>

<script src="../config/global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="listing-container">
    <div class="listing-header">
        <h1 class="ubuntu-bold">Listagem de Clientes</h1>
        <button id="btnCadastrarProduto" class="btn ubuntu-medium">Cadastrar cliente</button>
    </div>
    <div class="table">
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
                <th colspan="2">Operações</th>
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
                    echo "<td>" . $cliente->getCpf_Cnpj() . "</td>";
                    echo "<td>" . $cliente->getRg() . "</td>";
                    echo "<td>" . $cliente->getTelefone() . "</td>";
                    echo "<td>" . $cliente->getCelular() . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($cliente->getDataNasc())) . "</td>";
                    echo "<td>R$ " . number_format($cliente->getSalario(), 2, ',', '.') . "</td>";
                    echo "<td><img width='15px' class='btnEditar' src='../assets/icons/pen-to-square-solid.svg' data-id='" . $cliente->getId() . "' alt='Editar'></td>";
                    echo "<td><img width='15px' class='btnExcluir' src='../assets/icons/trash-solid.svg' data-id='" . $cliente->getId() . "' alt='Excluir'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>Nenhum cliente encontrado</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <div id="modalCadastro" class="modal" style="display:none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Cadastrar/Editar Cliente</h2>
                    <span class="close" id="btnFecharModal">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="formCadastrarCliente">
                        <div class="form-container">
                            <div class="form-item-modal">
                                <label for="nome" class="form-item-label">Nome:</label>
                                <input type="text" id="nome" name="nome" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="endereco" class="form-item-label">Endereço:</label>
                                <input type="text" id="endereco" name="endereco" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="numero" class="form-item-label">Número:</label>
                                <input type="text" id="numero" name="numero" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="bairro" class="form-item-label">Bairro:</label>
                                <input type="text" id="bairro" name="bairro" class="input-field" required>
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
                                <label for="email" class="form-item-label">Email:</label>
                                <input type="email" id="email" name="email" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="cpf_cnpj" class="form-item-label">CPF/CNPJ:</label>
                                <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="rg" class="form-item-label">RG:</label>
                                <input type="text" id="rg" name="rg" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="telefone" class="form-item-label">Telefone:</label>
                                <input type="text" id="telefone" name="telefone" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="celular" class="form-item-label">Celular:</label>
                                <input type="text" id="celular" name="celular" class="input-field" required>
                            </div>
                            <div class="form-item-modal">
                                <label for="data_nasc" class="form-item-label">Data de Nascimento:</label>
                                <input type="date" id="data_nasc" name="data_nasc" class="input-field" required>
                            </div>
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
    <div id="relatorio">
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
                            <label for="endereco" class="form-item-label">Endereço:</label>
                            <input type="text" id="endereco-filtro" name="endereco" class="input-field">
                        </div>
                        <div class="form-item-modal">
                            <label for="cidade-filtro" class="form-item-label">Cidade:</label>
                            <input type="text" id="cidade-filtro" name="cidade-filtro" class="input-field">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnFiltrar" type="button" class="btn" style="background-color:var(--sidebar-color);">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>