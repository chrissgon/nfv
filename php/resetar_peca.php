<?php
    session_start();
    unset($_SESSION["dados_pec_for"]);
    unset($_SESSION["filtro_mar"]);
    unset($_SESSION["filtro_mod"]);
    unset($_SESSION["filtro_ano"]);
    $_SESSION["tela_fornecedor"] = "edicao";
    header("location: ../tela_fornecedor.php");
?>