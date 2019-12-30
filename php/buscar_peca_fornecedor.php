<?php
    require_once "conexao.php";
    require_once "pecas.php";

    $peca = new Pecas($conexao);
    $id = filter_input(INPUT_POST, "id");
    
    // PECAS
    $dados = $peca->buscar_id($id);

    // MARCA
    $query_mar = "select * from marca where id_mar=:marca";
    $stmt_mar = $conexao->prepare($query_mar);
    $stmt_mar->bindValue(":marca", $dados[0]["id_mar"]);
    $stmt_mar->execute();
    $dados_mar = $stmt_mar->fetch(\PDO::FETCH_ASSOC);
    // MODELO
    $query_mod = "select * from modelo where id_mod=:modelo";
    $stmt_mod = $conexao->prepare($query_mod);
    $stmt_mod->bindValue(":modelo", $dados[0]["id_mod"]);
    $stmt_mod->execute();
    $dados_mod = $stmt_mod->fetch(\PDO::FETCH_ASSOC);

    $array_pec = array(
        "id_peca" => $dados[0]["id_pec"],
        "id_marca" => $dados_mar["id_mar"],
        "marca" => $dados_mar["nome_mar"],
        "modelo" => $dados_mod["nome_mod"],
        "ano" => $dados[0]["ano_pec"],
        "nome" => $dados[0]["nome_pec"],
        "descricao" => $dados[0]["des_pec"],
        "preco" => $dados[0]["val_pec"],
        "imagem" => $dados[0]["id_ima"]
    );

    echo json_encode($array_pec);
?>