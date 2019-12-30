<?php
require_once "conexao.php";
require_once "fornecedor.php";

$fornecedor = new Fornecedor($conexao);

$id_for = filter_input(INPUT_POST, "fornecedor");
$des_for = filter_input(INPUT_POST, "descricao");

echo $mensagem = $fornecedor->atualizar_descricao($id_for, $des_for);

?>