<?php
include_once "../../models/Cliente.php";
include_once "../../models/FormaPagto.php";

session_start();

$cliente = new Cliente();
$clientes = $cliente->getAll();

$fomras_pagamento = new FormaPagto();
$frpagto = $fomras_pagamento->getAll();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../config/global.js"></script>

<div class="container-step1 ubuntu-medium ">
    <form id="pedidoForm" class="step1">
        <div class="form-item" data-area="data-emissao">
            <label for="dtEmissao">Data de emissão</label>
            <input type="date" name="dtEmissao" required>
        </div>
        <div class="form-item prz-entrega" data-area="prazo-entrega">
            <label for="">Prazo de entrega</label>
            <input type="text" name="prazoEntrega" required>
        </div>
        <div class="form-item" data-area="textarea">
            <label for="">Observação</label>
            <textarea name="observacao" maxlength="255"></textarea>
        </div>
        <div class="form-item" data-area="id-cliente">
            <label for="cliente-id">ID do Cliente</label>
            <select id="cliente-id" name="clienteId" required>
                <option value="">Selecione um Cliente</option>
                <?php
                foreach ($clientes as $cliente) {
                    echo '<option value="' . htmlspecialchars($cliente->getId(), ENT_QUOTES, 'UTF-8') . '">'
                        . htmlspecialchars($cliente->getId() . ' - ' . $cliente->getNome(), ENT_QUOTES, 'UTF-8')
                        . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-item" data-area="id-vendedor">
            <label for="">ID do Vendedor</label>
            <input type="text" name="vendedorId" value="<?php echo $_SESSION['usuario']['id'] ?? ''; ?>" readonly>
        </div>
        <div class="form-item" data-area="forma-pagamento">
            <label for="formaPagamento">Forma de pagamento</label>
            <select name="formaPagamento" id="formaPagamento" required>
                <option value="">Selecione uma forma de pagamento</option>
                <?php
                foreach ($frpagto as $forma) {
                    echo '<option value="' . htmlspecialchars($forma->getId(), ENT_QUOTES, 'UTF-8') . '">'
                        . htmlspecialchars($forma->getNome(), ENT_QUOTES, 'UTF-8')
                        . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-item" data-area="limpar">
            <input type="button" value="Limpar" id="limpar">
        </div>
        <div class="form-item confirmar" data-area="confirmar">
            <input type="submit" value="Confirmar" id="confirmar-btn">
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Handle the form submission for Step 1
        $('#pedidoForm').submit(function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('action', 'cadastrar');

            $.ajax({
                url: '../../controllers/pedido_controller.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.message || 'Pedido cadastrado com sucesso!');
                        $('#pedidoForm')[0].reset();

                        var id_pedido = response.id_pedido;

                        $('#step-1').addClass('hidden');
                        $('#step-2').removeClass('hidden');

                        loadContentIntoMain('../views/pedido_steps/step2.php?id_pedido=' + id_pedido, '#step-2');

                        // Update the progress bar
                        $('.step[data-step="1"]').removeClass('active');
                        $('.step[data-step="2"]').addClass('active');
                        $('#progress').css('width', '33%');
                    } else {
                        alert(response.message || 'Erro ao cadastrar o pedido.');
                    }
                },

                error: function () {
                    alert('Ocorreu um erro ao enviar o pedido.');
                }
            });
        });

        $('#limpar').click(function () {
            $('#pedidoForm')[0].reset();
        });
    });

</script>