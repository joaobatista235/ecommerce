<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../config/global.css">
    <title>Dashboard de Vendas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../config/global.js"></script>
</head>

<body class="dashboard-body">
    <nav class="nav-container">
        <div class="nav-menu">
            <img src="../assets/icons/menu-svgrepo-com.svg" class="nav-menu-icon" alt="Burguer menu">
        </div>
    </nav>
    <main class="vendor-dashboard-container">
        <!-- Content will be dynamically loaded here -->
    </main>
</body>

<script>
    $(document).ready(function () {
        // Call the function to load content into <main>
        loadContentIntoMain('../views/assinc_content_vendor_lp.php', 'main');
    });
</script>

</html>
