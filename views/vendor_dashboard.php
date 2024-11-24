<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard de Vendas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../config/global.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <span class="image">
                    <img src="../assets/icons/logo-svgrepo-com.svg" alt="Logo placeholder">
                </span>
            <div class="text header-text">
                <span class="name ubuntu-bold">Bem Vindo!</span>
                <span class="subheader ubuntu-medium">
                    <?php echo $_SESSION['usuario']['nome'] ?? 'Usuário'; ?>
                </span>
            </div>
        </div>
    </header>

        <div class="menu-bar">
            <div class="menu">
                <div class="menu-links">
                    <ul class="menu-links">
                        <li class="nav-link" id="menuClientes">
                            <a href="#">
                                <i class='bx bxs-contact nav-icon'></i>
                                <span class="text nav-text ubuntu-medium">Menu de Clientes</span>
                            </a>
                        </li>
                        <li class="nav-link" id="menuProdutos">
                            <a href="#">
                                <i class='bx bxs-purchase-tag nav-icon'></i>
                                <span class="text nav-text ubuntu-medium">Menu de Produtos</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="pedidos.php">
                                <i class='bx bx-package nav-icon'></i>
                                <span class="text nav-text ubuntu-medium">Menu de Pedidos</span>
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

        loadContentIntoMain('../views/client_form.php', 'main');
        $('#menuClientes').click(function (e) {
            e.preventDefault();
            loadContentIntoMain('../views/client_form.php', 'main');
        });
        $('#menuProdutos').click(function (e) {
            e.preventDefault();
            loadContentIntoMain('../views/product_form.php', 'main');
        });
    });
</script>

</html>