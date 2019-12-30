<?php

session_start();

require_once "conexao.php";
require_once "pecas.php";
require_once "imagem.php";

// CLASSES
$pecas = new Pecas($conexao);
$imagem = new Imagem($conexao);

// VARIAVEIS
$id = filter_input(INPUT_POST, "id");
$marca = filter_input(INPUT_POST, "marca");
$modelo = filter_input(INPUT_POST, "modelo");
$ano = filter_input(INPUT_POST, "ano");
$nome = filter_input(INPUT_POST, "nome");
$descricao = filter_input(INPUT_POST, "descricao");
$preco = str_replace(".", "", filter_input(INPUT_POST, "preco"));
$id_ima = filter_input(INPUT_POST, "id_ima");

// MARCA
$query_mar = "select * from marca where nome_mar=:marca";
$stmt_mar = $conexao->prepare($query_mar);
$stmt_mar->bindValue(":marca", $marca);
$stmt_mar->execute();
$dados_mar = $stmt_mar->fetch(\PDO::FETCH_ASSOC);
$id_mar = $dados_mar["id_mar"];
// MODELO
$query_mod = "select * from modelo where nome_mod=:modelo";
$stmt_mod = $conexao->prepare($query_mod);
$stmt_mod->bindValue(":modelo", $modelo);
$stmt_mod->execute();
$dados_mod = $stmt_mod->fetch(\PDO::FETCH_ASSOC);
$id_mod = $dados_mod["id_mod"];

// IMAGEM
if(!empty($_FILES["img_edit"]["name"])){
    // DADOS DA IMAGEM
    $dados_img = $imagem->buscar($id_ima);
    // DELETA A IMAGEM
    $dir = "../img_peca/".$id_ima."/".$dados_img["nome_ima"]."";
    unlink($dir);

    // ATUALIZA NOME IMAGEM
    $nome_img = $_FILES["img_edit"]["name"];
    $imagem->setNome($nome_img);
    $imagem->atualizar($id_ima);
    
    // SALVA IMAGEM DIRETORIO
    $largura = "350";
    $altura = "300";
    $imagem->redimensionar($_FILES["img_edit"]["type"], $_FILES["img_edit"], $largura, $altura, $id_ima);
}

// INSERINDO VALORES
$pecas->setMarca($dados_mar["id_mar"])->setModelo($dados_mod["id_mod"])->setAno($ano)->setNome($nome)->setDescricao($descricao)->setValor($preco);



$msg = $pecas->atualizar($id);

$_SESSION["msg"] = $msg;
$_SESSION["tela_fornecedor"] = "edicao";

header("location: ../tela_fornecedor.php");
