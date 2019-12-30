<?php
    session_start();

    // REQUERINDO
    require_once "conexao.php";
    require_once "comprador.php";

    // CRIANDO INSTACIA
    $comprador = new Comprador($conexao);

    // DECLARANDO VARIAVEIS
    $nome = $_SESSION["dados_usuario"]["nome"];
    $snome = $_SESSION["dados_usuario"]["snome"];
    $email = $_SESSION["dados_usuario"]["email"];
    $cep = filter_input(INPUT_POST, "cep");
    $endereco = filter_input(INPUT_POST, "endereco");
    
    // OBTER LATITUDE E LONGITUDE
    $geo = array();
    $addr = str_replace(" ", "+", $endereco);
    $address = utf8_encode($addr);

    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$address.','.$cep.'&key=AIzaSyC-5rJINp8dnT7bpltaO2b0jKE_Y1Nci9g&language=pt-BR');
    $output = json_decode($geocode);
    $lat = (string)$output->results[0]->geometry->location->lat;
    $lon = (string)$output->results[0]->geometry->location->lng;
    $endereco = $output->results[0]->formatted_address;

    // CADASTRO
    if(filter_var($endereco, FILTER_SANITIZE_NUMBER_INT) !== ''){
        $comprador->setNome($nome)->setSNome($snome)->setLatitude($lat)->setLongitude($lon)->setCep($cep)->setEndereco($endereco)->setEmail($email)->setSenha("");
        echo $id = $comprador->cadastrar();
        $dados_usu = $comprador->buscar($id);
        $_SESSION["dados_usuario"] = $dados_usu;
        print_r($dados_usu);
        header("location: ../index.php");
        exit;
    }
    else{
        $_SESSION["msg"] = "Localização não identificada";
        header("location: ../tela_facebook.php");
    }

?>