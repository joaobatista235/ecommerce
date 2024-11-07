<?php
require_once "../models/Database.php";
require_once "../models/Cliente.php";

$connexao = new Database();

if (empty($_POST["email"]) || empty($_POST["passwd"])) {
    header("location: login_page.php?ERRO");
    exit();
}

// Get the email and password from the POST request
$email = trim($_POST["email"]);
$senha = trim($_POST["passwd"]);

// Fetch the client data by email
$data = Cliente::getByEmail($email, $connexao);

if ($data != null) { 
    session_start();   
    $_SESSION["usuario"] = $data;
    $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);

    if ($hashedSenha == $data->getSenha()) {
        if ($data->getNome() != "ADMIN") { // Change to appropriate property
            header("location: ../index.php");
            echo $_SESSION["usuario"];
        } else {
            header('location: ../pagCadProd.php');
        }
    } else {
        header('Location: ../views/login_page.php?invalid_password');
        echo '';
        exit();
    }
} else {
    header("location: ../views/login_page.php?not_found");
    exit();
}
?>
