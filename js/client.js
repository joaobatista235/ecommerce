function abrirModalCadastro() {
    const form = $("#formCadastrarCliente");
    form.trigger("reset");
    $("#modalCadastro").css("display", "flex");
}

function formatarData(data) {
    const partes = data.split("-");
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

function fecharModal() {
    $("#modalCadastro").hide();
}

function atualizarTabela() {
    $.ajax({
        url: "../controllers/cliente_controller.php",
        type: "POST",
        data: {action: "listar"},
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const tbody = $("table tbody");
                tbody.empty();
                const clientes = response.clientes;
                clientes.forEach((client) => {
                    let data_nasc = client.data_nasc ? formatarData(client.data_nasc) : '00/00/0000';

                    const tr = $("<tr>")
                        .data("id", client.id)
                        .attr("data-id", client.id)
                        .addClass("client-row").html(`
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
                                <td>${data_nasc}</td>
                                <td>R$ ${parseFloat(client.salario)
                            .toFixed(2)
                            .replace(".", ",")}</td>
                                <td><img width='15px' class='btnEditar' src='../assets/icons/pen-to-square-solid.svg' alt='Editar'></td>
                                <td><img width='15px' class='btnExcluir' src='../assets/icons/trash-solid.svg' alt='Editar'></td>
                            `);
                    tbody.append(tr);
                });
            }
        },
    });
}

function cadastrarCliente() {
    const clienteId = $("#formCadastrarCliente").data("id");
    const action = clienteId ? "editar" : "cadastrar";

    const formData = {
        action: action,
        id: clienteId,
        nome: $("#nome").val(),
        endereco: $("#endereco").val(),
        numero: $("#numero").val(),
        bairro: $("#bairro").val(),
        cidade: $("#cidade").val(),
        estado: $("#estado").val(),
        email: $("#email").val(),
        cpf_cnpj: $("#cpf_cnpj").val(),
        rg: $("#rg").val(),
        telefone: $("#telefone").val(),
        celular: $("#celular").val(),
        data_nasc: $("#data_nasc").val(),
        salario: $("#salario").val(),
    };

    $.ajax({
        url: "../controllers/cliente_controller.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (response) {
            console.log(response)
            if (response.success) {
                $("#formCadastrarCliente")[0].reset();
                $("#modalCadastro").hide();
                Swal.fire({
                    title: "Sucesso!",
                    text: response.message,
                    icon: "success",
                    backdrop: false,
                });
                atualizarTabela();
            }
        },
        error: function (err, a) {
            console.log(err, a)
            Swal.fire({
                title: "Erro!",
                text: "Ocorreu um erro ao salvar o cliente!",
                icon: "error",
                backdrop: false,
            });
        },
    });
}

function excluirCliente(el) {
    const clienteId = $(el).closest("tr").attr("data-id");
    Swal.fire({
        title: "Tem certeza?",
        text: "Essa ação não pode ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        backdrop: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/cliente_controller.php",
                type: "POST",
                data: {action: "excluir", clienteId},
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            title: "Excluído!",
                            text: res.message,
                            icon: "success",
                            backdrop: false,
                        });
                        document.querySelector(`tr[data-id="${clienteId}"]`).remove();
                    }
                },
                error: function () {
                    Swal.fire("Error!", "Could not delete the client.", "error");
                },
            });
        }
    });
}

function abrirModalEdicao(el) {
    const clienteId = $(el).closest("tr").attr("data-id");
    const row = $(el).closest("tr");
    const client = {
        id: clienteId,
        nome: row.find("td").eq(0).text(),
        endereco: row.find("td").eq(1).text(),
        numero: row.find("td").eq(2).text(),
        bairro: row.find("td").eq(3).text(),
        cidade: row.find("td").eq(4).text(),
        estado: row.find("td").eq(5).text(),
        email: row.find("td").eq(6).text(),
        cpf_cnpj: row.find("td").eq(7).text(),
        rg: row.find("td").eq(8).text(),
        telefone: row.find("td").eq(9).text(),
        celular: row.find("td").eq(10).text(),
        data_nasc: row.find("td").eq(11).text(),
        salario: row.find("td").eq(12).text().replace("R$ ", "").replace(",", "."),
    };

    $("#formCadastrarCliente").data("id", client.id);
    $("#nome").val(client.nome);
    $("#endereco").val(client.endereco);
    $("#numero").val(client.numero);
    $("#bairro").val(client.bairro);
    $("#cidade").val(client.cidade);
    $("#estado").val(client.estado);
    $("#email").val(client.email);
    $("#cpf_cnpj").val(client.cpf_cnpj);
    $("#rg").val(client.rg);
    $("#telefone").val(client.telefone);
    $("#celular").val(client.celular);

    if (client.data_nasc) {
        const dataNasc = client.data_nasc.split("/");
        const dataFormatada = `${dataNasc[2]}-${dataNasc[1]}-${dataNasc[0]}`;
        $("#data_nasc").val(dataFormatada);
    }

    $("#salario").val(client.salario);
    $("#modalCadastro").css("display", "flex");
}