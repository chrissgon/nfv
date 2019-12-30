<?php

require_once "conexao.php";
require_once "fornecedor.php";

$fornecedor = new Fornecedor($conexao);

$id_for = filter_input(INPUT_POST, "id");

$dados_for = $fornecedor->buscar($id_for);

echo json_encode($dados_for);