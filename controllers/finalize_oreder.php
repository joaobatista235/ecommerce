<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'finalizar') {
    if (isset($_SESSION['id_pedido'])) {
        unset($_SESSION['id_pedido']);
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
