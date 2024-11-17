<?php
/**
 * This model was created on: 16/11/2024
 * for the Admin table
 */
require_once "Database.php";
require_once "GenericInterface.php";

class Admin implements GenericInterface
{
    /* 
        Database structure:
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL 
    */
    private $id;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // Getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    // Save (Insert/Update)
    public function save(): bool
    {
        if (!$this->conn) {
            throw new Exception("Erro ao conectar no banco.");
        }

        try {
            if ($this->id) {
                $stmt = mysqli_prepare(
                    $this->conn,
                    "UPDATE admins SET username = ?, password = ? WHERE id = ?"
                );
                mysqli_stmt_bind_param($stmt, "ssi", $this->username, $this->password, $this->id);
            } else {
                $stmt = mysqli_prepare(
                    $this->conn,
                    "INSERT INTO admins (username, password) VALUES (?, ?)"
                );
                mysqli_stmt_bind_param($stmt, "ss", $this->username, $this->password);
            }

            return mysqli_stmt_execute($stmt);
        } catch (mysqli_sql_exception $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    // Get by ID
    public function getById($id): ?Admin
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM admins WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $admin = new Admin();
            $admin->setId($data['id']);
            $admin->setUsername($data['username']);
            $admin->setPassword($data['password']);
            return $admin;
        }
        return null;
    }

    /**
     * This function returns a list of all admins
     * @return array
     */
    public function getAll(): array
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM admins");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admins = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $admin = new Admin();
            $admin->setId($data['id']);
            $admin->setUsername($data['username']);
            $admin->setPassword($data['password']);
            $admins[] = $admin;
        }

        return $admins;
    }

    // Get by username and password
    public function getByCredentials(string $username, string $password): ?Admin
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM admins WHERE username = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $admin = new Admin();
            $admin->setId($data['id']);
            $admin->setUsername($data['username']);
            $admin->setPassword($data['password']);
            return $admin;
        }
        return null;
    }

    // Delete
    public function delete(): bool
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM admin WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
