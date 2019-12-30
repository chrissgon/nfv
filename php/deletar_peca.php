<?php
    session_start();

    require_once "conexao.php";
    require_once "pecas.php";

    $pecas = new Pecas($conexao);

    $id = filter_input(INPUT_POST, "id");

    $msg = $pecas->deletar($id);

    $_SESSION["msg"] = $msg;
    $_SESSION["tela_fornecedor"] = "edicao";

    header("location: ../tela_fornecedor.php");
?>