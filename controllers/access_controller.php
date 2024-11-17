<?php
require_once "../models/Admin.php";
require_once "../models/Vendedor.php";

header('Content-Type: application/json');

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password from the POST data 
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
        exit;
    }

    // Check if the user is an Admin
    $admin = new Admin();
    $adminCredentials = $admin->getByCredentials($email, $password);
    if ($adminCredentials) {
        // If the user is an admin, send a success response with the role
        echo json_encode([
            'success' => true,
            'message' => 'Admin login successful.',
            'role' => 'admin',  // Include the role as 'admin'
            'redirectUrl' => 'admin_dashboard.php', // Redirect URL for admin
        ]);
        exit;
    }

    // Check if the user is a Vendedor (Vendor)
    $vendedor = new Vendedor();
    $vendedorGetByCredentials = $vendedor->getByCredentials($email, $password);
    if ($vendedorGetByCredentials) {
        // If the user is a vendedor, send a success response with the role
        echo json_encode([
            'success' => true,
            'message' => 'Vendedor login successful.',
            'role' => 'vendedor',  // Include the role as 'vendedor'
            'redirectUrl' => 'vendor_dashboard.php', // Redirect URL for vendedor
        ]);
        exit;
    }

    // If no match found (neither admin nor vendedor)
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
} else {
    // If the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
