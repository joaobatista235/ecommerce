$(document).ready(function () {
    $('#btnFecharModal').click(function () {
        $('#modalCadastro').hide();
    });

    $(window).click(function (event) {
        if (event.target === document.getElementById('modalCadastro')) {
            $('#modalCadastro').hide();
        }
    });
})

function abrirModalCadastro() {
    const form = $("#formCadastrarVendedor");
    form.trigger("reset");
    $("#modalCadastro").css("display", "flex");
}

$('#formCadastrarPagamento').submit(function (e) {
    e.preventDefault();
    const form = document.getElementById('formCadastrarPagamento');
    const pagamentoId = $('#formCadastrarPagamento').data('id');

    let nome = $('#nome').val();
    const formData = {
        action: pagamentoId ? 'editar' : 'cadastrar',
        id: pagamentoId,
        nome: nome
    };
    $.ajax({
        url: '../controllers/payment_controller.php',
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
                atualizarTabelaPagamentos();
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Não foi possível cadastrar a forma de pagamento.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    backdrop: false,
                });
            }
        },
        error: function (err) {
            console.log(err)
            Swal.fire({
                title: 'Erro!',
                text: 'Ocorreu um erro ao tentar cadastrar a forma de pagamento.',
                icon: 'error',
                confirmButtonText: 'OK',
                backdrop: false,
            });
        }
    });
});

function abrirModalEdicao(el) {
    const row = $(el).closest('tr');
    const pagamento = {
        id: row.find('td').eq(0).text(),
        nome: row.find('td').eq(1).text()
    };

    $('#formCadastrarPagamento').data('id', pagamento.id);
    $('#nome').val(pagamento.nome);
    $("#modalCadastro").css("display", "flex");
}

function excluirPagamento(el) {
    const pagamentoId = $(el).closest('tr').attr('data-id');
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
                url: '../controllers/payment_controller.php',
                type: 'POST',
                data: {action: 'excluir', id: pagamentoId},
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Excluído!',
                            text: response.message,
                            icon: 'success',
                            backdrop: false,
                        });
                        document.querySelector(`tr[data-id="${pagamentoId}"]`).remove();
                    }
                },
                error: function (err) {
                    console.log(err)
                    Swal.fire('Error!', 'Não foi possível excluir a forma de pagamento.', 'error');
                }
            });
        }
    });
}

function atualizarTabelaPagamentos() {
    $.ajax({
        url: '../controllers/payment_controller.php',
        type: 'POST',
        data: {action: 'listar'},
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const pagamentos = response.pagamentos;
                console.log(pagamentos)
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';
                pagamentos.forEach(pagamento => {
                    const tr = document.createElement('tr');
                    tr.setAttribute('data-id', pagamento.id);

                    tr.innerHTML = `
                        <td>${pagamento.id}</td>
                        <td>${pagamento.nome}</td>
                        <td onclick="abrirModalEdicao(this)"><img width='15px' class="btnEditar" src="../assets/icons/pen-to-square-solid.svg" alt="Editar"></td>
                        <td onclick="excluirPagamento(this)"><img width='15px' class='btnExcluir' src='../assets/icons/trash-solid.svg' alt='Excluir'></td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        },
        error: function(err){
            console.log(err)
        }
    });
}