<?php
/* 
require "connection.php"; */




if(empty($_POST["emailVerify"])|| empty($_POST["passwdVerify"])){
    header("location : pagLogin.php?ERRO" );
    
}
$email = mysqli_real_escape_string($conexao, $_POST["emailVerify"]);
$senha = mysqli_real_escape_string($conexao, md5($_POST["passwdVerify"]));

$comando = "SELECT emailUsuario, nomeUsuario, idUsuario FROM usuarios WHERE emailUsuario = '$email' AND senhaUsuario = '$senha'";
$resultado = mysqli_query($conexao, $comando);

$data = mysqli_fetch_assoc($resultado);




if($data != null){ 
    session_start();   
    $_SESSION["usuario"] = $data;
    
    if(isset($_SESSION["usuario"])){
        
        if($data["nomeUsuario"]!="ADIMIN"){
                    
            header("location:../index.php");
            
        } else {
            header('location:../pagCadProd.php');
            //print_r($_SESSION["usuario"]);                     
        }
    }else{
        
        header('Location:../pagLogin.php');
        exit();
    }
}else{
    header("location: ../pagLogin.php?p");
    
   
}


//a@gmail.com

