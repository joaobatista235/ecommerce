<?php
include_once "../../models/Pedido.php";
session_start();  // Start the session

// Check if the id_pedido exists in the session
if (isset($_SESSION['id_pedido'])) {
    $id_pedido = $_SESSION['id_pedido'];

} else {
    // Handle the case when id_pedido is not set in session (e.g., redirect back to Step 1)
    echo "Pedido não encontrado.";
}


?>
<div class="container-step2">
    <div class="card-step2">
        <?php echo $_SESSION['id_pedido'];?>
    </div>


</div>