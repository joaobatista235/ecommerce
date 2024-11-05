<?php include "base/header.php"; ?>
<div class="chose container mt-5">
    <div class="row flex m-auto justify-content-between">
        <!-- CLIENTE Card -->
        <div class="card" style="width: 18rem; margin-right: 12rem;" onclick="redirectToCliente()">
            <img src="../assets/icons/user-svgrepo-com.svg" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text text-center fs-2">CLIENTE</p>
            </div>
        </div>
        <!-- VENDEDOR Card -->
        <div class="card" style="width: 18rem;" onclick="redirectToVendedor()">
            <img src="../assets/icons/laptop-user-svgrepo-com.svg" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text text-center fs-2">VENDEDOR</p>
            </div>
        </div>
    </div>
</div>
<?php include "base/footer.php"; ?>
