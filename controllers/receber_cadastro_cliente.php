<?php 
require_once "../models/Database.php"; 
require_once "../models/Cliente.php"; 

$connexao = new Database();
$conn = $connexao->getConnection(); // This is the mysqli connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
    $endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : null;
    $numero = isset($_POST['numero']) ? trim($_POST['numero']) : null;
    $bairro = isset($_POST['bairro']) ? trim($_POST['bairro']) : null;
    $cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : null;
    $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $cpf_cnpj = isset($_POST['cpf_cnpj']) ? trim($_POST['cpf_cnpj']) : null;
    $rg = isset($_POST['rg']) ? trim($_POST['rg']) : null;
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : null;
    $celular = isset($_POST['celular']) ? trim($_POST['celular']) : null;
    $data_nasc = isset($_POST['data_nasc']) ? trim($_POST['data_nasc']) : null;
    $salario = isset($_POST['salario']) ? trim($_POST['salario']) : null;
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;
    $confirmar_senha = isset($_POST['confirmar_senha']) ? trim($_POST['confirmar_senha']) : null;

    // Basic validation
    $errors = [];
    
    if (empty($nome) || !is_string($nome) || strlen($nome) < 2) {
        $errors[] = "Nome inválido.";
    }
    if (empty($endereco) || !is_string($endereco)) {
        $errors[] = "Endereço inválido.";
    }
    if (empty($numero) || !is_numeric($numero)) {
        $errors[] = "Número inválido.";
    }
    if (empty($bairro) || !is_string($bairro)) {
        $errors[] = "Bairro inválido.";
    }
    if (empty($cidade) || !is_string($cidade)) {
        $errors[] = "Cidade inválida.";
    }
    if (empty($estado) || !is_string($estado) || strlen($estado) != 2) {
        $errors[] = "Estado inválido.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }
    if (empty($cpf_cnpj) || !preg_match("/^\d{11}|\d{14}$/", $cpf_cnpj)) {
        $errors[] = "CPF/CNPJ inválido.";
    }
    if (empty($rg) || !is_string($rg)) {
        $errors[] = "RG inválido.";
    }
    if (empty($telefone) || !is_string($telefone)) {
        $errors[] = "Telefone inválido.";
    }
    if (empty($celular) || !is_string($celular)) {
        $errors[] = "Celular inválido.";
    }
    if (empty($data_nasc) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_nasc)) {
        $errors[] = "Data de Nascimento inválida.";
    }
    if (empty($salario) || !is_numeric($salario)) {
        $errors[] = "Salário inválido.";
    }
    if (empty($senha) || strlen($senha) < 6) {
        $errors[] = "Senha deve ter pelo menos 6 caracteres.";
    }
    if ($senha !== $confirmar_senha) {
        $errors[] = "As senhas não coincidem.";
    }

    if (empty($errors)) {
        // Create new Cliente instance
        $cliente = new Cliente($connexao); // Pass the Database instance
        $cliente->setNome($nome);
        $cliente->setEndereco($endereco);
        $cliente->setNumero($numero);
        $cliente->setBairro($bairro);
        $cliente->setCidade($cidade);
        $cliente->setEstado($estado);
        $cliente->setEmail($email);
        $cliente->setCpfCnpj($cpf_cnpj);
        $cliente->setRg($rg);
        $cliente->setTelefone($telefone);
        $cliente->setCelular($celular);
        $cliente->setDataNasc($data_nasc);
        $cliente->setSalario($salario);
        
        $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);
        $cliente->setSenha($hashedSenha);

        if ($cliente->save()) {
            header("Location: ../views/login_page.php?Cadastrado_com_sucesso_faça_login_agora");
            exit();
        } else {
            header("Location: ../views/signup_user.php?Houve_um_erro_verifique_os_dados_inseridos");
            exit();
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>
