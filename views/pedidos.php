<?php   
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer pedido</title>
    <link rel="stylesheet" href="../config/global.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="../config/global.js"></script>
</head>
<body class="pedidos-body">
   <!-- Navigation Bar -->
   <nav class="simple-nav">
        <div class="go-back">
            <a href="../views/vendor_dashboard.php" class="go-back-link">
                <i class='bx bx-left-arrow-alt icon-simple-nav'></i>
            </a>
        </div>
   </nav>
   
   <!-- Progress Bar -->
   <div class="progress-container">
       <div class="progress-bar">
           <div class="progress" id="progress"></div>
       </div>
       <div class="step-indicators">
           <div class="step active" data-step="1">1</div>
           <div class="step" data-step="2">2</div>
           <div class="step" data-step="3">3</div>
       </div>
   </div>

   <!-- Main Content -->
   <main id="main-content">
       <div class="step-content" id="step-1">
           <h1>Step 1: Add Products</h1>
           <!-- Step 1 content here -->
       </div>
       <div class="step-content hidden" id="step-2">
           <h1>Step 2: Shipping Details</h1>
           <!-- Step 2 content here -->
       </div>
       <div class="step-content hidden" id="step-3">
           <h1>Step 3: Payment</h1>
           <!-- Step 3 content here -->
       </div>
   </main>

   <script>
        loadContentIntoMain('../views/pedido_steps/step1.php', '#step-1');
        
   </script>
</body>
</html>
