<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard de Vendas</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../config/global.css"/>
    <link
            href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
            rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../config/global.js"></script>
</head>

<body class="dashboard-body">
<header class="sidebar toggle">
    <div class="sidebar__btn_close" id="btn-close-sidebar">
        <svg
                id="menu-icon"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
        >
            <path
                    d="M15.41 7.41L14 6L8 12L14 18L15.41 16.59L10.83 12L15.41 7.41Z"
                    fill="white"
            />
        </svg>
        <svg
                style="display: none"
                id="close-icon"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
        >
            <path
                    d="M10 6L8.59 7.41L13.17 12L8.59 16.59L10 18L16 12L10 6Z"
                    fill="white"
            />
        </svg>
    </div>
    <div class="siderbar__logo">
        <span class="image">
          <img
                  src="../assets/icons/logo-svgrepo-com.svg"
                  alt="Logo placeholder"
          />
        </span>
        <div class="siderbar__logo_title">
            <span class="name ubuntu-bold"> Bem Vindo! </span>
            <span class="subheader ubuntu-medium">
            <?php echo $_SESSION['usuario']['nome'] ?? 'Usuário'; ?>
          </span>
        </div>
    </div>
    <nav class="sidebar-navigation">
        <ul class="menu-links">
            <li id="menuClientes" class="nav-link">
                <a href="#">
                    <i class="bx bxs-contact nav-icon"></i>
                    <span class="text nav-text ubuntu-medium">Menu de Clientes</span>
                </a>
            </li>
            <li id="menuProdutos" class="nav-link">
                <a href="#">
                    <i class="bx bxs-purchase-tag nav-icon"></i>
                    <span class="text nav-text ubuntu-medium">Menu de Produtos</span>
                </a>
            </li>
            <li id="menuPedidos" class="nav-link">
                <a href="pedidos.php">
                    <i class="bx bx-package nav-icon"></i>
                    <span class="text nav-text ubuntu-medium">Menu de Pedidos</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="../controllers/logout.php">
                    <i class="bx bx-log-out nav-icon"></i>
                    <span class="text nav-text ubuntu-medium">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</header>

<main>
    <!-- Dynamic content will load here -->
</main>
</body>

<script>
    $(document).ready(function () {
        function loadContentIntoMain(url, target) {
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    $(target).html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error loading content:", error);
                    $(target).html("<p>Erro ao carregar o conteúdo.</p>");
                },
            });
        }

        loadContentIntoMain('./client_form.php', 'main');
        $('#menuClientes').click(function (e) {
            e.preventDefault();
            loadContentIntoMain('./client_form.php', 'main');
        });
        $('#menuProdutos').click(function (e) {
            e.preventDefault();
            loadContentIntoMain('./product_form.php', 'main');
        });
    })
</script>
</html>
