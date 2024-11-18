<?php
require_once "../models/Admin.php";
require_once "../models/Vendedor.php";

header('Content-Type: application/json');

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password from the POST data 
    $email = $_POST['email'] ?? '';
    $password = md5($_POST['password'] ?? '');


    // Validate input
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
        exit;
    }

    // Check if the user is an Admin
    $admin = new Admin();
    $adminCredentials = $admin->getByCredentials($email, $password);
    if ($adminCredentials) {
        // Start session if not already started
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Regenerate session ID for security
        session_regenerate_id(true);

        // Store essential user data in session
        $_SESSION['usuario'] = [
            'id' => $adminCredentials->getId(),
            'nome' => $adminCredentials->getUsername(),
            'role' => 'admin',
        ];

        // Send JSON response
        echo json_encode([
            'success' => true,
            'message' => 'Admin login successful.',
            'role' => 'admin',
            'redirectUrl' => 'admin_dashboard.php',
        ]);
        exit;
    }

    // Check if the user is a Vendedor (Vendor)
    $vendedor = new Vendedor();
    $vendedorCredentials = $vendedor->getByCredentials($email, $password); // Fetch vendedor by email and password

    if ($vendedorCredentials) {
        // Start session if not already started
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Store essential vendedor data in session
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
            'redirectUrl' => '../views/vendor_dashboard.php',
        ]);
        exit;
    }

    // If no match found (neither admin nor vendedor)
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
} else {
    // If the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
