<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../config/global.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Dashboard de Vendas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../config/global.js"></script>
</head>

<body class="dashboard-body">
<nav class="sidebar toggle">
    <div class="close">
        <i class='bx bx-x-circle' id="menu-icon"></i>
        <i class='bx bx-menu' id="close-icon" style="display: none;"></i>
    </div>

    <header>
        <div class="image-text">
            <!-- assets\icons\logo-svgrepo-com.svg -->
            <span class="image">
                    <img src="../assets/icons/logo-svgrepo-com.svg" alt="Logo placeholder">
                </span>
            <div class="text header-text">
                    <span class="name ubuntu-bold">
                        Bem Vindo!
                    </span>
                <span class="subheader ubuntu-medium">
                        Vendedor.name
                    </span>
            </div>
        </div>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <div class="menu-links">
                <ul class="menu-links">
                    <li id="menuVendedores" class="nav-link">
                        <a href="#">
                            <i class='bx bxs-briefcase nav-icon'></i>
                            <span class="text nav-text  ubuntu-medium">Menu de Vendedores</span>
                        </a>
                    </li>
                    <li id="menuPagamentos" class="nav-link">
                        <a href="#">
                            <i class='bx bxs-credit-card nav-icon'></i>
                            <span class="text nav-text  ubuntu-medium">Formas de pagamento</span>
                        </a>
                    </li>
                    <li id="menuPedidos" class="nav-link">
                        <a href="#">
                            <i class='bx bx-package nav-icon'></i>
                            <span class="text nav-text  ubuntu-medium">Menu de Pedidos</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../controllers/logout.php">
                            <i class='bx bx-log-out nav-icon'></i>
                            <span class="text nav-text ubuntu-medium">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<main>
    <!-- Dynamic content will load here -->
</main>
</body>

<script>
    $(document).ready(function () {
        function loadContentIntoMain(url, target) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    $(target).html(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error loading content:', error);
                    $(target).html('<p>Erro ao carregar o conteúdo.</p>');
                }
            });
        }

        loadContentIntoMain('./seller_form.php', 'main');
        $('#menuVendedores').click(function (e) {
            e.preventDefault();
            loadContentIntoMain('./seller_form.php', 'main');
        });

        $('#menuPagamentos').click(function (e) {
            e.preventDefault();
            loadContentIntoMain('./payment_form.php', 'main');
        });

        $('#menuPedidos').click(function (e) {
            e.preventDefault();
            loadContentIntoMain('./orders_form.php', 'main');
        });
    });
</script>
</html>