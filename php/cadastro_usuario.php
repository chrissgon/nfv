<?php

session_start();

unset($_SESSION["msg"]);

require_once "conexao.php";
require_once "fornecedor.php";
require_once "comprador.php";

// CLASSES
$fornecedor = new Fornecedor($conexao);
$comprador = new Comprador($conexao);

// VALORES
$cep =  filter_input(INPUT_POST, "cep");
$endereco = filter_input(INPUT_POST, "endereco");
$email = filter_input(INPUT_POST, "email");
$senha = hash("sha256", filter_input(INPUT_POST, "senha"));
$erro = false;

// FORMATANDO ENDERECO
$endereco_valido = str_replace(",", "", $endereco);
// OBTER LATITUDE E LONGITUDE
$geo= array();
$addr = str_replace(" ", "+", $endereco_valido);
$address = utf8_encode($addr);

$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.','.$cep.'&key=AIzaSyC-5rJINp8dnT7bpltaO2b0jKE_Y1Nci9g&language=pt-BR');
$output = json_decode($geocode);
$lat = (string)$output->results[0]->geometry->location->lat;
$lon = (string)$output->results[0]->geometry->location->lng;
$endereco = $output->results[0]->formatted_address;

// CADASTRO
// FORNECEDOR
if(filter_input(INPUT_POST, "fornecedor") != null && filter_var($endereco_valido, FILTER_SANITIZE_NUMBER_INT) !== ''){
    $cnpj = filter_input(INPUT_POST, "cnpj");
    $rs = filter_input(INPUT_POST, "rs");

    // Verifica email ou cnpj já cadastrado
    $lista = $fornecedor->listar();
    foreach($lista as $dados){
        // Cadastro Negado
        if($dados["cnpj_for"] == $cnpj || $dados["email_for"] == $email){
            $_SESSION["msg"] = "CNPJ ou Email já cadastrado";
            header("location: ../tela_cadastro.php");
            exit;
        }
    }
    // Cadastro Aprovado
    $fornecedor->setRs($rs)->setCnpj($cnpj)->setLatitude($lat)->setLongitude($lon)->setCep($cep)->setEndereco($endereco)->setEmail($email)->setSenha($senha);
    $fornecedor->cadastrar();
    $_SESSION["msg"] = "Cadastro realizado com sucesso";
    header("location: ../tela_login.php");
    exit;
}
// COMPRADOR
else if(filter_input(INPUT_POST, "comprador") != null && $output->status == "OK"){
    $nome = filter_input(INPUT_POST, "nome");
    $snome = filter_input(INPUT_POST, "sobrenome");

    // Verifica email já cadastrado
    $lista = $comprador->listar();
    foreach($lista as $dados){
        // Cadastro Negado
        if($dados["email_com"] == $email){
            $_SESSION["msg"] = "Já existe uma conta com este email";
            header("location: ../tela_cadastro.php");
            exit;
        }
    }
    // Cadastro Aprovado
    $comprador->setNome($nome)->setSNome($snome)->setLatitude($lat)->setLongitude($lon)->setCep($cep)->setEndereco($endereco)->setEmail($email)->setSenha($senha);
    $comprador->cadastrar();
    $_SESSION["msg"] = "Cadastro realizado com sucesso";
    header("location: ../tela_login.php");
    exit;
}else{
    $_SESSION["msg"] = "Informações solicitadas não atendidas";
    header("location: ../tela_cadastro.php");
    exit;
}