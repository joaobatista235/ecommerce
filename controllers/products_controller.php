<?php
require_once "../models/Produto.php";
require_once "../models/ImagensProduto.php"; // Include image model

class ProductsController
{
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['prod_id']) ? $_POST['prod_id'] : null; // Get the product ID from POST (hidden field)

            if ($id) {
                // Update product
                if ($this->updateProduct($id)) {
                    /* $_SESSION['response_message'] = "Produto atualizado com sucesso!"; */
                    header("Location: ../views/add_product.php?id=".$id."?atualizado com sucesso"); // Corrected URL format
                    exit();
                } else {
                   /*  $_SESSION['response_message'] = "Falha ao atualizar o produto."; */
                    header("Location: ../views/add_product.php?id=".$id."?Erro ao atualizar"); // Corrected URL format
                    exit();
                }
            } else {
                // Insert new product
                if ($this->insertProduct()) {
                   /*  $_SESSION['response_message'] = "Produto inserido com sucesso!"; */
                    header("Location: ../views/add_product.php?Inserido com sucesso");
                    exit();
                } else {
                    /* $_SESSION['response_message'] = "Falha ao inserir o produto."; */
                    header("Location: ../views/add_product.php?Erro ao inserir");
                    exit();
                }
            }
        } else {
            $id = isset($_GET['id']) ? $_GET['id'] : null; // Get the ID from the URL for view/update

            $action = isset($_GET['action']) ? $_GET['action'] : 'view';

            if ($action === 'delete' && $id) {
                $this->deleteProduct($id);
            } elseif ($id) {
                // View product details when ID is provided in the URL
                $this->viewProduct($id);
            } else {
                // View all products if no ID is provided
                $this->viewAllProducts();
            }
        }
    }

    private function insertProduct()
    {
        // Get the data from POST request
        $nome = $_POST['prod_name'];
        $qtde_estoque = $_POST['prod_amount'];
        $preco = $_POST['prod_value'];
        $unidade_medida = $_POST['prod_mesure_un'];

        // Ensure promocao is 'Y' or 'N' based on checkbox
        $promocao = isset($_POST['gridCheck']) && $_POST['gridCheck'] === 'on' ? 'Y' : 'N';

        // Create a new product instance
        $product = new Produto();
        $product->setNome($nome);
        $product->setQtdeEstoque($qtde_estoque);
        $product->setPreco($preco);
        $product->setUnidadeMedida($unidade_medida);
        $product->setPromocao($promocao);

        // Save the product to the database
        if ($product->save()) {
            // Handle image upload if a file is provided
            if (isset($_FILES['prod_image']) && $_FILES['prod_image']['error'] === UPLOAD_ERR_OK) {
                $this->addProductImage($product->getId(), $_FILES['prod_image']);
            }
        } else {
            // Product insertion failed
            return false;
        }

        return true;
    }

    private function updateProduct($id)
    {
        // Fetch the existing product by ID
        $product = Produto::getById($id);
        if ($product) {
            // Update product details from POST data
            $product->setNome($_POST['prod_name']);
            $product->setQtdeEstoque($_POST['prod_amount']);
            $product->setPreco($_POST['prod_value']);
            $product->setUnidadeMedida($_POST['prod_mesure_un']);
            $product->setPromocao(isset($_POST['gridCheck']) && $_POST['gridCheck'] === 'on' ? 'Y' : 'N');

            // Save the updated product
            if ($product->save()) {
                // Handle image upload if a file is provided
                if (isset($_FILES['prod_image']) && $_FILES['prod_image']['error'] === UPLOAD_ERR_OK) {
                    $this->addProductImage($id, $_FILES['prod_image']);
                }
            } else {
                // Product update failed
                return false;
            }
        } else {
            // Product not found
            return false;
        }

        return true;
    }

    private function deleteProduct($id)
    {
        // Fetch the product by ID
        $product = Produto::getById($id);
        if ($product) {
            // Attempt to delete the product
            if ($product->delete()) {
                return true; // Product deleted successfully
            }
        }

        return false; // Product not found or delete failed
    }

    private function viewProduct($id)
    {
        // Fetch the product by ID
        $product = Produto::getById($id);
        if ($product) {
            // Return the product details as an array
            return [
                'id' => $product->getId(),
                'name' => $product->getNome(),
                'quantity' => $product->getQtdeEstoque(),
                'price' => $product->getPreco(),
                'unit' => $product->getUnidadeMedida(),
                'promotion' => $product->getPromocao(),
                'images' => $this->getProductImages($id) // Get images associated with the product
            ];
        } else {
            return null; // Product not found
        }
    }

    private function viewAllProducts()
    {
        // Fetch all products
        $products = Produto::getAll();
        $productList = [];

        foreach ($products as $product) {
            // Return an array with product details
            $productList[] = [
                'id' => $product->getId(),
                'name' => $product->getNome(),
                'quantity' => $product->getQtdeEstoque(),
                'price' => $product->getPreco(),
                'unit' => $product->getUnidadeMedida(),
                'promotion' => $product->getPromocao()
            ];
        }

        return $productList;
    }

    private function addProductImage($productId, $imageFile)
    {
        $uploadDir = "../uploads/";
        $fileName = basename($imageFile["name"]);
        $targetFilePath = $uploadDir . $fileName;

        // Upload the image file
        if (move_uploaded_file($imageFile["tmp_name"], $targetFilePath)) {
            // Create a new image record for the product
            $image = new ImagensProduto();
            $image->setIdProduto($productId);
            $image->setUrl($targetFilePath);
            $image->setDescricao($_POST['prod_image_desc'] ?? ''); // Optional description

            // Save the image to the database
            if ($image->save()) {
                return true; // Image added successfully
            }
        }

        return false; // Failed to upload image
    }

    private function getProductImages($productId)
    {
        // Fetch images associated with the product
        return ImagensProduto::getByProductId($productId);
    }
}

// Create an instance of the controller and handle the request
$controller = new ProductsController();
$response = $controller->handleRequest();

// The $response will now contain data about the operations instead of being echoed
