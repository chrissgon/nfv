<?php
require_once "conexao.php";
require_once "favoritos.php";

$favoritos = new Favoritos($conexao);

$status = filter_input(INPUT_POST, "status");
$peca = filter_input(INPUT_POST, "peca");
$comprador =  filter_input(INPUT_POST, "comprador");

if($status == "false"){
    $favoritos->setPeca($peca)->setComprador($comprador);
    $favoritos->favoritar();
}
else{
    $favoritos->setPeca($peca)->setComprador($comprador);
    $favoritos->desfavoritar();
}

?>