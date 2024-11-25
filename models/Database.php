<?php
class Database
{
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "100senha";
    private $database = "ecommerce";
    protected $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database, 55000);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConnection()
    {
        mysqli_close($this->connection);
    }
}
