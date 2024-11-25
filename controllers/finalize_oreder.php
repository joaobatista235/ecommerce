<?php
session_start();

// Check if the action is 'finalizar'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'finalizar') {
    // Optionally, save or log any finalization logic you need (like closing the order in the DB)

    // Example: If you need to clear the session data after completing the order
    if (isset($_SESSION['id_pedido'])) {
        unset($_SESSION['id_pedido']);  // Clear the order session data after finalizing
    }

    // Respond with success
    echo json_encode([
        'success' => true,
        'message' => 'Pedido finalizado com sucesso!'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Ação inválida ou não fornecida.'
    ]);
}
