$(document).ready(function () {
    const body = $("body");
    const sidebar = body.find(".sidebar");
    const toggleButton = $("#btn-close-sidebar");
    const menuIcon = $("#menu-icon");
    const closeIcon = $("#close-icon");

    toggleButton.off("click").on("click", function () {
        if (sidebar.hasClass("collapsed")) {
            sidebar.removeClass("collapsed");
            menuIcon.show();
            closeIcon.hide();
        } else {
            sidebar.addClass("collapsed");
            menuIcon.hide();
            closeIcon.show();
        }
    });

    $("#btnCadastrarProduto").click(function () {
        $("#modalCadastro").css("display", "flex");
    });

    $("#btnFecharModal").click(function () {
        $("#modalCadastro").hide();
    });

    $("#formCadastrarCliente").submit(function (e) {
        e.preventDefault();

        const clienteId = $(this).data("id");
        const action = clienteId ? "editar" : "cadastrar";

        const formData = {
            action,
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
                if (response.success) {
                    $("#formCadastrarCliente")[0].reset();
                    $("#modalCadastro").hide();
                    Swal.fire("Success!", response.message, "success");
                    atualizarTabela();
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function () {
                Swal.fire(
                    "Error!",
                    "An error occurred while saving the client.",
                    "error"
                );
            },
        });
    });

    function formatarData(data) {
        const partes = data.split("-");
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }

    function atualizarTabela(filtro = false) {
        let data = {action: "listar", filtro: false};
        if (filtro) {
            data.filtro = true;
            data.nome = $('#nome-filtro').val();
            data.endereco = $('#endereco-filtro').val();
            data.cidade = $('#cidade-filtro').val()
        }

        $.ajax({
            url: "../controllers/cliente_controller.php",
            type: "POST",
            data: data,
            dataType: "json",
            success: function (response) {

                if (response.success) {
                    const tbody = $("table tbody");
                    tbody.empty();

                    const clientes = response.clientes;
                    clientes.forEach((client) => {
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
                    <td>${formatarData(client.data_nasc)}</td>
                    <td>R$ ${parseFloat(client.salario)
                                .toFixed(2)
                                .replace(".", ",")}</td>
                    <td><img width='15px' class='btnEditar' src='../assets/icons/pen-to-square-solid.svg' data-id=${
                                client.id
                            } alt='Editar'></td>
                    <td><img width='15px' class='btnExcluir' src='../assets/icons/trash-solid.svg' data-id=${
                                client.id
                            } alt='Excluir'></td>
                `);
                        tbody.append(tr);
                    });

                    bindTableHandlers();
                } else {
                    alert("Error fetching clients");
                }
            },

            error: function () {
                alert("Error loading clients.");
            },
        });
    }

    function bindTableHandlers() {
        $(".btnEditar").click(function () {
            const clientId = $(this).data("id");
            const row = $(this).closest("tr");

            const client = {
                id: clientId,
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
                salario: row
                    .find("td")
                    .eq(12)
                    .text()
                    .replace("R$ ", "")
                    .replace(",", "."),
            };

            abrirModalEdicao(client);
        });

        $(".btnExcluir").click(function () {
            const clienteId = $(this).data("id");
            excluirCliente(clienteId);
        });

        $("#btnFiltrar").click(function () {
            atualizarTabela(true);
        });
    }

    function abrirModalEdicao(client) {
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

    function excluirCliente(clienteId) {
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

    bindTableHandlers();
});
