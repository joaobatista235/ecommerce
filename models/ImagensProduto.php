<?php
require_once "Database.php";

class ImagensProduto
{
    private $id;
    private $id_produto;
    private $url;
    private $descricao;
    private $data_criacao;
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getIdProduto()
    {
        return $this->id_produto;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    // Setters
    public function setIdProduto($id_produto)
    {
        $this->id_produto = $id_produto;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    // Save method (Insert or Update)
    public function save()
    {
        if ($this->id) {
            // Update existing image
            $stmt = mysqli_prepare($this->conn, "UPDATE imagens_produto SET id_produto=?, url=?, descricao=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "issi", $this->id_produto, $this->url, $this->descricao, $this->id);
        } else {
            // Insert new image
            $stmt = mysqli_prepare($this->conn, "INSERT INTO imagens_produto (id_produto, url, descricao) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iss", $this->id_produto, $this->url, $this->descricao);
        }
        return mysqli_stmt_execute($stmt);
    }

    // Get image by ID
    public static function getById($id)
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM imagens_produto WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            $image = new ImagensProduto();
            $image->id = $data['id'];
            $image->id_produto = $data['id_produto'];
            $image->url = $data['url'];
            $image->descricao = $data['descricao'];
            $image->data_criacao = $data['data_criacao'];
            return $image;
        }
        return null;
    }

    // Get all images for a specific product
    public static function getByProductId($id_produto)
    {
        $conn = (new Database())->getConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM imagens_produto WHERE id_produto = ?");
        mysqli_stmt_bind_param($stmt, "i", $id_produto);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $images = [];

        while ($data = mysqli_fetch_assoc($result)) {
            $image = new ImagensProduto();
            $image->id = $data['id'];
            $image->id_produto = $data['id_produto'];
            $image->url = $data['url'];
            $image->descricao = $data['descricao'];
            $image->data_criacao = $data['data_criacao'];
            $images[] = $image;
        }
        return $images;
    }

    // Delete image
    public function delete()
    {
        if ($this->id) {
            $stmt = mysqli_prepare($this->conn, "DELETE FROM imagens_produto WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $this->id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
