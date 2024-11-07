<?php
require_once "../models/Database.php";
require_once "../models/Cliente.php";

$connexao = new Database();

if (empty($_POST["email"]) || empty($_POST["passwd"])) {
    header("location: login_page.php?ERRO");
    exit();
}

// Get the email and password from the POST request
$email = $_POST["email"];
$senha = $_POST["passwd"];

// Fetch the client data by email
$data = Cliente::getByEmail($email, $connexao);

if ($data != null) {
    session_start();
    $_SESSION["usuario"] = $data;

    // Echo the name for debugging or as a greeting
    echo "Welcome, " . $data->getNome() . "!";

    // Use password_verify to check if the provided password matches the hashed password
    if (password_verify($senha, $data->getSenha())) {
        if ($data->getNome() != "ADMIN") { // Change to appropriate property
            header("location: ../index.php");
            exit();
        } else {
            header("location: ../pagCadProd.php");
            exit();
        }
    } else {
        header("location: ../views/login_page.php?invalid_password");
        exit();
    }
} else {
    header("location: ../views/login_page.php?not_found");
    exit();
}
