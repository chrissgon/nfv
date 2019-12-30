<?php

session_start();

unset($_SESSION["lembrar"]);

require_once "conexao.php";
require_once "fornecedor.php";
require_once "comprador.php";

$fornecedor = new Fornecedor($conexao);
$comprador = new Comprador($conexao);

echo $email = filter_input(INPUT_POST, "email");
echo $senha = hash("sha256", filter_input(INPUT_POST, "senha"));


$dados_for = $fornecedor->login($email, $senha);
$dados_com = $comprador->login($email, $senha);

$usuario = ($dados_for != null) ? "fornecedor" : "comprador";
$status = ($dados_for == null && $dados_com == null) ? "erro" : "sucesso";

if($status == "sucesso" && $usuario == "fornecedor"){
    $_SESSION["dados_fornecedor"] = $dados_for;
    if(filter_input(INPUT_POST, "lembrar") != null){
        $_SESSION["lembrar"] = true;
    }
    $_SESSION["tela_fornecedor"] = "edicao";
    unset($_SESSION["dados_pec_for"]);
    header("location: ../tela_fornecedor.php");
}
else if($status == "sucesso" && $usuario == "comprador"){
    $_SESSION["dados_usuario"] = $dados_com;
    header("location: ../index.php");
}
else{
    header("location: ../tela_login.php");
    $_SESSION["msg"] = "Email ou senha inválidos";
}



