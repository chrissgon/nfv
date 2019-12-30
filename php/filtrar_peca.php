<?php
    session_start();

    // CLASSES
    require_once "conexao.php";
    require_once "pecas.php";

    // INSTANCIAS
    $peca = new Pecas($conexao);

    // VARIAVEIS
    $fornecedor = $_SESSION["dados_fornecedor"]["id_for"];
    $marca = filter_input(INPUT_POST, "marca");
    $modelo = filter_input(INPUT_POST, "modelo");
    $ano = filter_input(INPUT_POST, "ano");

    // MARCA
    $query_marca = "select * from marca where nome_mar=:marca";
    $stmt_marca = $conexao->prepare($query_marca);
    $stmt_marca->bindValue(":marca", $marca);
    $stmt_marca->execute();
    $dados_marca = $stmt_marca->fetch(\PDO::FETCH_ASSOC);

    // MODELO
    $query_modelo = "select * from modelo where nome_mod=:modelo";
    $stmt_modelo = $conexao->prepare($query_modelo);
    $stmt_modelo->bindValue(":modelo", $modelo);
    $stmt_modelo->execute();
    $dados_modelo = $stmt_modelo->fetch(\PDO::FETCH_ASSOC);

    if($marca != "" && $ano == ""){
        $query = "select * from peca where id_for=:id and id_mar=:marca and id_mod=:modelo order by nome_pec";
    }
    else if($marca == "" && $ano != ""){
        $query = "select * from peca where id_for=:id and ano_pec=:ano order by nome_pec";
    }
    else if($marca != "" && $ano != ""){
        $query = "select * from peca where id_for=:id and id_mar=:marca and id_mod=:modelo and ano_pec=:ano order by nome_pec";
    }
    else{
        $query = "select * from peca where id_for=:id order by nome_pec";
    }

    $_SESSION["filtro_mar"] = $marca;
    $_SESSION["filtro_mod"] = $modelo;
    $_SESSION["filtro_ano"] = $ano;
    $_SESSION["dados_pec_for"] = $peca->filtrar($query, $fornecedor, $dados_marca["id_mar"], $dados_modelo["id_mod"], $ano);

    $_SESSION["tela_fornecedor"] = "edicao";

    header("location: ../tela_fornecedor.php");

?>