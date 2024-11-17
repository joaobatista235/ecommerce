<?php
require_once "../models/Vendedor.php";

class VendedorController {

    public function create() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $vendedor = new Vendedor();

            $vendedor->setNome($_POST['nome']);
            $vendedor->setEndereco($_POST['endereco']);
            $vendedor->setCidade($_POST['cidade']);
            $vendedor->setEstado($_POST['estado']);
            $vendedor->setCelular($_POST['celular']);
            $vendedor->setEmail($_POST['email']);
            $vendedor->setPercComissao($_POST['perc_comissao']);
            $vendedor->setDataAdmissao($_POST['data_admissao']);
            $vendedor->setSetor($_POST['setor']);
            $vendedor->setSenha(password_hash($_POST['senha'], PASSWORD_DEFAULT));

            if ($vendedor->save()) {
                echo "Vendedor inserido com sucesso!";
            } else {
                echo "Falha ao inserir o vendedor.";
            }
        }
    }

    public function read($id) {
        $vendedor = Vendedor::getById($id);
        if ($vendedor) {
            
            return $vendedor;
        }
        return null;
    }
    
    /**
     * @return  Vendedor
     * Essa função verfica vededor por email/senha
     */
    public function getByEmailAndPasswdord($email, $password){
        
    }

    public function update() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $vendedor = Vendedor::getById($_POST['id']);
            if ($vendedor) {
                $vendedor->setNome($_POST['nome']);
                $vendedor->setEndereco($_POST['endereco']);
                $vendedor->setCidade($_POST['cidade']);
                $vendedor->setEstado($_POST['estado']);
                $vendedor->setCelular($_POST['celular']);
                $vendedor->setEmail($_POST['email']);
                $vendedor->setPercComissao($_POST['perc_comissao']);
                $vendedor->setDataAdmissao($_POST['data_admissao']);
                $vendedor->setSetor($_POST['setor']);


                if (!empty($_POST['senha'])) {
                    $vendedor->setSenha(password_hash($_POST['senha'], PASSWORD_DEFAULT));
                }
                if ($vendedor->save()) {
                    echo "Vendedor atualizado com sucesso!";
                } else {
                    echo "Falha ao atualizar o vendedor.";
                }
            }
        }
    }

    public function delete($id) {
        $vendedor = new Vendedor();
        $vendedor->setId($id);
        if ($vendedor->delete()) {
            echo "Vendedor deletado com sucesso!";
        } else {
            echo "Falha ao deletar o vendedor.";
        }
    }
}