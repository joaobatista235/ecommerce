<?php
require_once "Database.php";
require_once "GenericInterface.php";

class Cliente implements GenericInterface
{
    private $id;
    private $nome;
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $email;
    private $cpf_cnpj;
    private $rg;
    private $telefone;
    private $celular;
    private $data_nasc;
    private $salario;
    private $senha;
    private $conn;

    public function __construct(Database $connexao)
    {
        $this->conn = $connexao->getConnection();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getEndereco() { return $this->endereco; }
    public function getNumero() { return $this->numero; }
    public function getBairro() { return $this->bairro; }
    public function getCidade() { return $this->cidade; }
    public function getEstado() { return $this->estado; }
    public function getEmail() { return $this->email; }
    public function getCpfCnpj() { return $this->cpf_cnpj; }
    public function getRg() { return $this->rg; }
    public function getTelefone() { return $this->telefone; }
    public function getCelular() { return $this->celular; }
    public function getDataNasc() { return $this->data_nasc; }
    public function getSalario() { return $this->salario; }
    public function getSenha() { return $this->senha; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNome($nome) { $this->nome = $nome; }
    public function setEndereco($endereco) { $this->endereco = $endereco; }
    public function setNumero($numero) { $this->numero = $numero; }
    public function setBairro($bairro) { $this->bairro = $bairro; }
    public function setCidade($cidade) { $this->cidade = $cidade; }
    public function setEstado($estado) { $this->estado = $estado; }
    public function setEmail($email) { $this->email = $email; }
    public function setCpfCnpj($cpf_cnpj) { $this->cpf_cnpj = $cpf_cnpj; }
    public function setRg($rg) { $this->rg = $rg; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }
    public function setCelular($celular) { $this->celular = $celular; }
    public function setDataNasc($data_nasc) { $this->data_nasc = $data_nasc; }
    public function setSalario($salario) { $this->salario = $salario; }
    public function setSenha($senha) { $this->senha = $senha; }

    public function save()
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "UPDATE clientes SET nome=?, endereco=?, numero=?, bairro=?, cidade=?, estado=?, email=?, cpf_cnpj=?, rg=?, telefone=?, celular=?, data_nasc=?, salario=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "ssssssssssssi", $this->nome, $this->endereco, $this->numero, $this->bairro, $this->cidade, $this->estado, $this->email, $this->cpf_cnpj, $this->rg, $this->telefone, $this->celular, $this->data_nasc, $this->salario, $this->id);
        } else {
            $stmt = mysqli_prepare($this->conn, "INSERT INTO clientes (nome, endereco, numero, bairro, cidade, estado, email, cpf_cnpj, rg, telefone, celular, data_nasc, salario,senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
            mysqli_stmt_bind_param($stmt, "ssssssssssssis", $this->nome, $this->endereco, $this->numero, $this->bairro, $this->cidade, $this->estado, $this->email, $this->cpf_cnpj, $this->rg, $this->telefone, $this->celular, $this->data_nasc, $this->salario,$this->senha);
        }
        return mysqli_stmt_execute($stmt);
    }

    public static function getById($id, Database $connexao = null)
    {
        $conn = $connexao->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM clientes WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente($connexao);
            $cliente->setId($data['id']);
            $cliente->setNome($data['nome']);
            $cliente->setEndereco($data['endereco']);
            $cliente->setNumero($data['numero']);
            $cliente->setBairro($data['bairro']);
            $cliente->setCidade($data['cidade']);
            $cliente->setEstado($data['estado']);
            $cliente->setEmail($data['email']);
            $cliente->setCpfCnpj($data['cpf_cnpj']);
            $cliente->setRg($data['rg']);
            $cliente->setTelefone($data['telefone']);
            $cliente->setCelular($data['celular']);
            $cliente->setDataNasc($data['data_nasc']);
            $cliente->setSalario($data['salario']);
            return $cliente;
        }
        return null;
    }
    public static function getByEmail($email, Database $connexao = null)
    {
        $conn = $connexao->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM clientes WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "i", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente($connexao);
            $cliente->setId($data['id']);
            $cliente->setNome($data['nome']);
            $cliente->setEndereco($data['endereco']);
            $cliente->setNumero($data['numero']);
            $cliente->setBairro($data['bairro']);
            $cliente->setCidade($data['cidade']);
            $cliente->setEstado($data['estado']);
            $cliente->setEmail($data['email']);
            $cliente->setCpfCnpj($data['cpf_cnpj']);
            $cliente->setRg($data['rg']);
            $cliente->setTelefone($data['telefone']);
            $cliente->setCelular($data['celular']);
            $cliente->setDataNasc($data['data_nasc']);
            $cliente->setSalario($data['salario']);
            return $cliente;
        }
        return null;
    }

    public static function getAll(Database $connexao =null)
    {
        $conn = $connexao->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM clientes");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $clientes = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $cliente = new Cliente($connexao);
            $cliente->setId($data['id']);
            $cliente->setNome($data['nome']);
            $cliente->setEndereco($data['endereco']);
            $cliente->setNumero($data['numero']);
            $cliente->setBairro($data['bairro']);
            $cliente->setCidade($data['cidade']);
            $cliente->setEstado($data['estado']);
            $cliente->setEmail($data['email']);
            $cliente->setCpfCnpj($data['cpf_cnpj']);
            $cliente->setRg($data['rg']);
            $cliente->setTelefone($data['telefone']);
            $cliente->setCelular($data['celular']);
            $cliente->setDataNasc($data['data_nasc']);
            $cliente->setSalario($data['salario']);
            $clientes[] = $cliente;
        }
        return $clientes;
    }

    public function delete()
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM clientes WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
