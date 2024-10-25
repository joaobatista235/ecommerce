<?php
/* require_once "Cliente.php";

$clientes = Cliente::getAll(); */
?>
<?php include "base/header.php"; ?>

<div class="container my-5">
        <form action="process_add_cliente.php" method="POST">
            <input type="hidden" name="action" value="create">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="endereco" class="form-label">Endereço:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
                <div class="col">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="text" class="form-control" id="numero" name="numero" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="bairro" class="form-label">Bairro:</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="cidade" class="form-label">Cidade:</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" required>
                </div>
                <div class="col">
                    <label for="estado" class="form-label">Estado:</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="">Escolha...</option>
                        <option value="AC">AC</option>
                        <option value="AL">AL</option>
                        <option value="AP">AP</option>
                        <option value="AM">AM</option>
                        <option value="BA">BA</option>
                        <option value="CE">CE</option>
                        <option value="DF">DF</option>
                        <option value="ES">ES</option>
                        <option value="GO">GO</option>
                        <option value="MA">MA</option>
                        <option value="MT">MT</option>
                        <option value="MS">MS</option>
                        <option value="MG">MG</option>
                        <option value="PA">PA</option>
                        <option value="PB">PB</option>
                        <option value="PR">PR</option>
                        <option value="PE">PE</option>
                        <option value="PI">PI</option>
                        <option value="RJ">RJ</option>
                        <option value="RN">RN</option>
                        <option value="RS">RS</option>
                        <option value="RO">RO</option>
                        <option value="RR">RR</option>
                        <option value="SC">SC</option>
                        <option value="SP">SP</option>
                        <option value="SE">SE</option>
                        <option value="TO">TO</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="cpf_cnpj" class="form-label">CPF/CNPJ:</label>
                <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
            </div>
            <div class="mb-3">
                <label for="rg" class="form-label">RG:</label>
                <input type="text" class="form-control" id="rg" name="rg" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
            </div>
            <div class="mb-3">
                <label for="celular" class="form-label">Celular:</label>
                <input type="text" class="form-control" id="celular" name="celular" required>
            </div>
            <div class="mb-3">
                <label for="data_nasc" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
            </div>
            <div class="mb-3">
                <label for="salario" class="form-label">Salário:</label>
                <input type="number" class="form-control" id="salario" name="salario" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="confirmar_senha" class="form-label">Confirmar Senha:</label>
                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        </form>
    </div>

    <?php include "base/footer.php";?>