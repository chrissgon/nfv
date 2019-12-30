<?php

session_start();

require_once "conexao.php";
require_once "imagem.php";
require_once "pecas.php";

// CLASSES
$imagem = new Imagem($conexao);
$peca = new Pecas($conexao);

// OBTENDO VALORES
$fornecedor = $_SESSION["dados_fornecedor"]["id_for"];
$marca = filter_input(INPUT_POST, "marca");
$modelo = filter_input(INPUT_POST, "modelo");
$ano = filter_input(INPUT_POST, "ano");
$nome = filter_input(INPUT_POST, "nome");
$descricao = filter_input(INPUT_POST, "descricao");
$valor = str_replace(".", "", filter_input(INPUT_POST, "preco"));
$nome_img = $_FILES["img_cad"]["name"];

// IMAGEM
$imagem->setNome($nome_img);
$id_img = $imagem->cadastrar();
$largura = "350";
$altura = "300";
$imagem->redimensionar($_FILES["img_cad"]["type"], $_FILES["img_cad"], $largura, $altura, $id_img);

// OBTENDO ID ATRAVÉS DO NOME
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

// PECA
$peca->setFornecedor($fornecedor)->setMarca($id_mar)->setModelo($id_mod)->setAno($ano)->setNome($nome)->setDescricao($descricao)->setValor($valor)->setImagem($id_img);

$_SESSION["msg"] = $peca->cadastrar();
$_SESSION["tela_fornecedor"] = "cadastro";

header("location: ../tela_fornecedor.php");