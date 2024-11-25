<?php
require_once "../models/Admin.php";
require_once "../models/Vendedor.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = md5($_POST['password'] ?? '');


    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
        exit;
    }

    $admin = new Admin();
    $adminCredentials = $admin->getByCredentials($email, $password);
    if ($adminCredentials) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => $adminCredentials->getId(),
            'nome' => $adminCredentials->getUsername(),
            'role' => 'admin',
        ];

        echo json_encode([
            'success' => true,
            'message' => 'Admin login successful.',
            'role' => 'admin',
            'redirectUrl' => '/views/admin_dashboard.php',
        ]);
        exit;
    }

    $vendedor = new Vendedor();
    $vendedorCredentials = $vendedor->getByCredentials($email, $password);

    if ($vendedorCredentials) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['usuario'] = [
            'id' => $vendedorCredentials->getId(),
            'nome' => $vendedorCredentials->getNome(),
            'role' => 'vendedor',
        ];

        // Send JSON response
        echo json_encode([
            'success' => true,
            'message' => 'Vendedor login successful.',
            'role' => 'vendedor',
            'redirectUrl' => '/views/vendor_dashboard.php',
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
