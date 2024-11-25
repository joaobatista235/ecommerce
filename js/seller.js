$(document).ready(function () {
    $("#btnFecharModal").click(function () {
        $("#modalCadastro").hide();
    });

    $(window).click(function (event) {
        if (event.target === document.getElementById("modalCadastro")) {
            $("#modalCadastro").hide();
        }
    });
});

function formatarData(data) {
    const partes = data.split("-");
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

function abrirModalCadastro() {
    const form = $("#formCadastrarVendedor");
    form.trigger("reset");
    $("#modalCadastro").css("display", "flex");
}

$("#formCadastrarVendedor").submit(function (e) {
    e.preventDefault();
    const form = document.getElementById("formCadastrarVendedor");
    const vendedorId = $("#formCadastrarVendedor").data("id");

    let nome = $("#nome").val();
    let endereco = $("#endereco").val();
    let cidade = $("#cidade").val();
    let estado = $("#estado").val();
    let celular = $("#celular").val();
    let email = $("#email").val();
    let comissao = $("#perc_comissao").val();
    let data_admissao = $("#data_admissao").val();
    let senha = $("#senha").val();

    const formData = {
        action: vendedorId ? "editar" : "cadastrar",
        id: vendedorId,
        nome: nome,
        endereco: endereco,
        cidade: cidade,
        estado: estado,
        celular: celular,
        email: email,
        comissao: comissao,
        data_admissao: data_admissao,
        senha: senha,
    };

    $.ajax({
        url: "../controllers/seller_controller.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                form.reset();
                $("#modalCadastro").hide();

                Swal.fire({
                    title: "Sucesso!",
                    text: response.message,
                    icon: "success",
                    confirmButtonText: "OK",
                    backdrop: false,
                });
                document.getElementById("modalCadastro").style.display = "none";
                atualizarTabela();
            } else {
                Swal.fire({
                    title: "Erro!",
                    text: "Não foi possível cadastrar o produto.",
                    icon: "error",
                    confirmButtonText: "OK",
                    backdrop: false,
                });
            }
        },
        error: function (err) {
            console.log(err);
            Swal.fire({
                title: "Erro!",
                text: "Ocorreu um erro ao tentar cadastrar o produto.",
                icon: "error",
                confirmButtonText: "OK",
                backdrop: false,
            });
        },
    });
});

function abrirModalEdicao(el) {
    const row = $(el).closest("tr");
    const vendedor = {
        id: row.find("td").eq(0).text(),
        nome: row.find("td").eq(1).text(),
        endereco: row.find("td").eq(2).text(),
        cidade: row.find("td").eq(3).text(),
        estado: row.find("td").eq(4).text(),
        celular: row.find("td").eq(5).text(),
        email: row.find("td").eq(6).text(),
        perc_comissao: row.find("td").eq(7).text(),
        data_admissao: row.find("td").eq(8).text(),
        senha: row.find("td").eq(9).text(),
    };

    $("#formCadastrarVendedor").data("id", vendedor.id);

    $("#nome").val(vendedor.nome);
    $("#endereco").val(vendedor.endereco);
    $("#cidade").val(vendedor.cidade);
    $("#estado").val(vendedor.estado);
    $("#celular").val(vendedor.celular);
    $("#email").val(vendedor.email);
    $("#perc_comissao").val(vendedor.perc_comissao);

    if (vendedor.data_admissao) {
        const dataNasc = vendedor.data_admissao.split("/");
        const dataFormatada = `${dataNasc[2]}-${dataNasc[1]}-${dataNasc[0]}`;
        $("#data_admissao").val(dataFormatada);
    }

    $("#senha").val(vendedor.senha);

    $("#modalCadastro").css("display", "flex");
}

function excluirVendedor(el) {
    const vendedorId = $(el).closest("tr").attr("data-id");
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
                url: "../controllers/seller_controller.php",
                type: "POST",
                data: {action: "excluir", id: vendedorId},
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Excluído!",
                            text: response.message,
                            icon: "success",
                            backdrop: false,
                        });
                        document.querySelector(`tr[data-id="${vendedorId}"]`).remove();
                    }
                },
                error: function (err) {
                    console.log(err);
                    Swal.fire("Error!", "Não foi possível excluir o vendedor.", "error");
                },
            });
        }
    });
}

function atualizarTabela() {
    $.ajax({
        url: "../controllers/seller_controller.php",
        type: "POST",
        data: {action: "listar"},
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const vendedores = response.vendedores;
                const tbody = document.querySelector("table tbody");
                tbody.innerHTML = "";
                vendedores.forEach((vendedor) => {
                    const tr = document.createElement("tr");
                    let data_admissao = vendedor.data_admissao
                        ? formatarData(vendedor.data_admissao)
                        : "";

                    tr.innerHTML = `
                        <td>${vendedor.id}</td>
                        <td>${vendedor.nome}</td>
                        <td>${vendedor.endereco}</td>
                        <td>${vendedor.cidade}</td>
                        <td>${vendedor.estado}</td>
                        <td>${vendedor.celular}</td>
                        <td>${vendedor.email}</td>
                        <td>${vendedor.perc_comissao}</td>
                        <td>${data_admissao}</td>
                        <td>${vendedor.senha}</td>
                        <td onclick="abrirModalEdicao(this)"><img width='15px' class="btnEditar" src="../assets/icons/pen-to-square-solid.svg" data-id="${vendedor.id}" alt="Editar"></td>
                        <td onclick="excluirVendedor(this)"><img width='15px' class='btnExcluir' src='../assets/icons/trash-solid.svg' data-id="${vendedor.id}" alt='Excluir'></td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                alert("Erro ao listar os produtos");
            }
        },
        error: function () {
            alert("Erro ao carregar os produtos.");
        },
    });
}

function gerarRelatorio() {
    const inicio = $('#inicio').val();
    const fim = $('#fim').val();
console.log(inicio)
    $.ajax({
        url: "../controllers/seller_controller.php",
        type: "POST",
        data: { action: "gerarRelatorio", inicio: inicio, fim: fim },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                let pdfData = atob(response.pdf);
                let pdfBlob = new Blob([new Uint8Array(pdfData.split("").map(function(c) { return c.charCodeAt(0); }))], { type: 'application/pdf' });

                let link = document.createElement('a');
                link.href = URL.createObjectURL(pdfBlob);
                link.download = 'relatorio_vendedores.pdf';

                link.click();
            } else {
                alert('Erro: ' + response.message);
            }
        },
        error: function() {
            alert('Erro ao gerar o relatório');
        }
    });
}

