<?php include "base/header.php"; ?>
<div class="cliente container mt-5">
    <section class="mb-4">
        <h2>Perfil do Cliente</h2>
        <div class="d-flex align-items-center">
            <img src="path/to/profile-pic.jpg" alt="Foto de Perfil" class="rounded-circle" width="100" height="100">
            <div class="ms-3">
                <h5>Nome do Cliente</h5>
                <button class="btn btn-link" title="Editar informações">
                    <i class="bi bi-pencil-fill"></i> Editar
                </button>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <h3>Informações Pessoais</h3>
        <p>Email: cliente@example.com</p>
        <p>Telefone: (11) 91234-5678</p>
        <p>Endereço: Rua Exemplo, 123 - Cidade, Estado</p>
    </section>

    <section class="mb-4">
        <h3>Compras Anteriores</h3>
        <div class="list-group">
            <!-- <a href="#" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Produto 1</h5>
                <p class="mb-1">Data da Compra: 01/01/2024</p>
                <small>Preço: R$ 100,00</small>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Produto 2</h5>
                <p class="mb-1">Data da Compra: 15/01/2024</p>
                <small>Preço: R$ 200,00</small>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Produto 3</h5>
                <p class="mb-1">Data da Compra: 22/01/2024</p>
                <small>Preço: R$ 150,00</small>
            </a> -->
        </div>
    </section>
</div>
<?php include "base/footer.php";?>