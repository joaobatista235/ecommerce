<?php
require_once "../models/ItemPedido.php";
session_start();

header('Content-Type: application/json');

// Get the session's pedido id
$id_pedido = $_SESSION['id_pedido'] ?? null;
if (!$id_pedido) {
    echo json_encode(['success' => false, 'message' => 'Pedido not found.']);
    exit();
}

// Handle POST request to add item to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the POST request
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (isset($inputData['productId']) && isset($inputData['quantity'])) {
        $productId = $inputData['productId'];
        $quantity = $inputData['quantity'];

        // Create an instance of ItemPedido and insert into the database
        $itemPedido = new ItemPedido();
        $itemPedido->setIdPedido($id_pedido);
        $itemPedido->setIdProduto($productId);
        $itemPedido->setQuantidade($quantity);

        // Save the item to the database
        if ($itemPedido->save()) {
            echo json_encode(['success' => true, 'message' => 'Item added to cart.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add item to cart.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
    }
}

// Handle GET request to fetch items in the cart
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$id_pedido) {
        echo json_encode(['success' => false, 'message' => 'Pedido not found.']);
        exit();
    }

    $itemPedido = new ItemPedido();
    $items = $itemPedido->getItemsWithProductDetails($id_pedido);

    if ($items) {
        echo json_encode(['success' => true, 'items' => $items]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No items found in the cart.']);
    }
}

// Handle DELETE request to remove item from the cart
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (isset($inputData['itemId'])) {
        $itemId = $inputData['itemId'];

        $itemPedido = new ItemPedido();
        if ($itemPedido->deleteById($itemId)) {
            echo json_encode(['success' => true, 'message' => 'Item removed from cart.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item from cart.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid item ID provided.']);
    }
}
