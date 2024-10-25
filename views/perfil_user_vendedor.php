<?php include "base/header.php"; ?>
<div class=" vendedor container mt-5">
    <section class="mb-4">
        <h2>Perfil do Vendedor</h2>
        <div class="d-flex align-items-center">
            <img src="path/to/profile-pic.jpg" alt="Foto de Perfil" class="rounded-circle" width="100" height="100">
            <div class="ms-3">
                <h5>Nome do Vendedor</h5>
                <button class="btn btn-link" title="Editar informações">
                    <i class="bi bi-pencil-fill"></i> Editar
                </button>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <h3>Informações Pessoais</h3>
        <p>Email: vendedor@example.com</p>
        <p>Telefone: (11) 91234-5678</p>
        <p>Endereço: Rua Exemplo, 123 - Cidade, Estado</p>
    </section>

    <section class="my-4 porduto-vendedor">
        <h3 class="text-left" >Adicionar Produtos</h3>
        <button class="btn btn-primary my-4" onclick="location.href='add_product.php'">Adicionar Produto</button>
    </section>

    <!-- <section>
        <h3>Produtos</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="path/to/product1.jpg" class="card-img-top" alt="Produto 1">
                    <div class="card-body">
                        <h5 class="card-title">Produto 1</h5>
                        <p class="card-text">Descrição do Produto 1.</p>
                        <button class="btn btn-link" title="Editar Produto">
                            <i class="bi bi-pencil-fill"></i> Editar
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="path/to/product2.jpg" class="card-img-top" alt="Produto 2">
                    <div class="card-body">
                        <h5 class="card-title">Produto 2</h5>
                        <p class="card-text">Descrição do Produto 2.</p>
                        <button class="btn btn-link" title="Editar Produto">
                            <i class="bi bi-pencil-fill"></i> Editar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
</div>
<?php include "base/footer.php";?>