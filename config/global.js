function loadContentIntoMain(url, mainSelector) {
    $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            $(mainSelector).html(response);
        },
        error: function () {
            $(mainSelector).html('<p>Failed to load content. Please try again later.</p>');
        },
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const body = document.querySelector("body"),
        sidebar = body.querySelector(".sidebar"),
        toggleButton = body.querySelector(".close"),
        menuIcon = document.getElementById("menu-icon"),
        closeIcon = document.getElementById("close-icon");

    toggleButton.addEventListener("click", () => {
        sidebar.classList.toggle('collapsed');

        if (sidebar.classList.contains('collapsed')) {
            menuIcon.style.display = 'none';
            closeIcon.style.display = 'block';
        } else {
            menuIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    });
});


$(document).ready(function () {

    // Show Modal for Registering a Product
    $('#btnCadastrarProduto').click(function () {
        $('#modalCadastro').show();
    });

    // Close Modal
    $('#btnFecharModal').click(function () {
        $('#modalCadastro').hide();
    });

    // Handle Form Submission for Creating or Editing Client
    $('#formCadastrarCliente').submit(function (e) {
        e.preventDefault();

        const clienteId = $(this).data('id'); // For edit
        const action = clienteId ? 'editar' : 'cadastrar'; // Determine action

        const formData = {
            action,
            id: clienteId,
            nome: $('#nome').val(),
            endereco: $('#endereco').val(),
            numero: $('#numero').val(),
            bairro: $('#bairro').val(),
            cidade: $('#cidade').val(),
            estado: $('#estado').val(),
            email: $('#email').val(),
            cpf_cnpj: $('#cpf_cnpj').val(),
            rg: $('#rg').val(),
            telefone: $('#telefone').val(),
            celular: $('#celular').val(),
            data_nasc: $('#data_nasc').val(),
            salario: $('#salario').val()
        };

        // AJAX request
        $.ajax({
            url: '../controllers/cliente_controller.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#formCadastrarCliente')[0].reset();
                    $('#modalCadastro').hide();
                    Swal.fire('Success!', response.message, 'success');
                    atualizarTabela();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error!', 'An error occurred while saving the client.', 'error');
            }
        });
    });

    // Update Table with Client Data
    function atualizarTabela() {
        $.ajax({
            url: '../controllers/cliente_controller.php',
            type: 'POST',
            data: {action: 'listar'},
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const tbody = $('table tbody');
                    tbody.empty();

                    response.clientes.forEach(client => {
                        const tr = $('<tr>')
                            .data('id', client.id)
                            .addClass('client-row')
                            .html(`
                                <td>${client.nome}</td>
                                <td>${client.endereco}</td>
                                <td>${client.numero}</td>
                                <td>${client.bairro}</td>
                                <td>${client.cidade}</td>
                                <td>${client.estado}</td>
                                <td>${client.email}</td>
                                <td>${client.cpf_cnpj}</td>
                                <td>${client.rg}</td>
                                <td>${client.telefone}</td>
                                <td>${client.celular}</td>
                                <td>${client.data_nasc}</td>
                                <td>R$ ${parseFloat(client.salario).toFixed(2).replace('.', ',')}</td>
                                <td>
                                    <button class='btnEditar btnCli' data-id='${client.id}'>Editar</button>
                                    <button class='btnExcluir btnCli' data-id='${client.id}'>Excluir</button>
                                </td>
                            `);
                        tbody.append(tr);
                    });

                    // Rebind Handlers
                    bindTableHandlers();
                } else {
                    alert('Error fetching clients');
                }
            },
            error: function () {
                alert("Error loading clients.");
            }
        });
    }

    // Bind Edit and Delete Handlers
    function bindTableHandlers() {
        $('.btnEditar').click(function () {
            const clientId = $(this).data('id');
            const row = $(this).closest('tr');

            const client = {
                id: clientId,
                nome: row.find('td').eq(0).text(),
                endereco: row.find('td').eq(1).text(),
                numero: row.find('td').eq(2).text(),
                bairro: row.find('td').eq(3).text(),
                cidade: row.find('td').eq(4).text(),
                estado: row.find('td').eq(5).text(),
                email: row.find('td').eq(6).text(),
                cpf_cnpj: row.find('td').eq(7).text(),
                rg: row.find('td').eq(8).text(),
                telefone: row.find('td').eq(9).text(),
                celular: row.find('td').eq(10).text(),
                data_nasc: row.find('td').eq(11).text(),
                salario: row.find('td').eq(12).text().replace('R$ ', '').replace(',', '.')
            };

            abrirModalEdicao(client);
        });

        $('.btnExcluir').click(function () {
            const clienteId = $(this).data('id');
            excluirCliente(clienteId);
        });
    }

    function abrirModalEdicao(client) {
        $('#formCadastrarCliente').data('id', client.id);
        $('#nome').val(client.nome);
        $('#endereco').val(client.endereco);
        $('#numero').val(client.numero);
        $('#bairro').val(client.bairro);
        $('#cidade').val(client.cidade);
        $('#estado').val(client.estado);
        $('#email').val(client.email);
        $('#cpf_cnpj').val(client.cpf_cnpj);
        $('#rg').val(client.rg);
        $('#telefone').val(client.telefone);
        $('#celular').val(client.celular);
        $('#data_nasc').val(client.data_nasc);
        $('#salario').val(client.salario);

        $('#modalCadastro').show();
    }

    function excluirCliente(clienteId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../controllers/cliente_controller.php',
                    type: 'POST',
                    data: {action: 'excluir', clienteId},
                    success: function (response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire('Deleted!', res.message, 'success');
                            $(`tr[data-id="${clienteId}"]`).remove();
                        } else {
                            Swal.fire('Error!', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Could not delete the client.', 'error');
                    }
                });
            }
        });
    }

    // Initial Binding
    bindTableHandlers();
});

