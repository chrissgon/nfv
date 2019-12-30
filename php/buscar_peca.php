<?php

session_start();

require_once "conexao.php";
require_once "fornecedor.php";
require_once "pecas.php";

// CLASSES
$pecas = new Pecas($conexao);
$fornecedor = new Fornecedor($conexao);

// DECLARANDO VARIAVES
$lat_usu = filter_input(INPUT_POST, "latitude");
$lon_usu = filter_input(INPUT_POST, "longitude");
$marca = filter_input(INPUT_POST, "marca");
$modelo = filter_input(INPUT_POST, "modelo");
$ano = filter_input(INPUT_POST, "ano");
$proximidades = array();

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

// FUNCAO PARA CALCULAR DISTANCIA ENTRE COORDENADAS
function medirDistancia($lat1, $lon1, $lat2, $lon2) {
    // RECEBE LATITUDE E LONGITUDE
    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);
    $lon1 = deg2rad($lon1);
    $lon2 = deg2rad($lon2);

    // CALCULA A DISTANCIA
    $dist = (6371 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lon2 - $lon1 ) + sin( $lat1 ) * sin($lat2) ) );
    $dist = number_format($dist, 2, '.', '');
    return $dist;
}

// SELECIONAR PEÇAS DA MESMA MARCA E MODELO
$lista_pec = $pecas->buscar($id_mar, $id_mod, $ano);

// OBTER INFORMACOES DOS FORNECEDORES DAS PECA
foreach($lista_pec as $dados_pec){
    // DADOS DO FORNECEDOR
    $for_pec = $dados_pec["id_for"];
    $dados_for = $fornecedor->buscar($for_pec);
    // LATITUDE E LONGITUDE
    $lat_for = $dados_for["lat_for"];
    $lon_for = $dados_for["lon_for"];
    // CALCULAR DISTANCIA
    $distancia = medirDistancia($lat_for, $lon_for, $lat_usu, $lon_usu);
    // ADICIONAR CASO ESTEJA DENTRO DO RAIO DO USUARIO
    if($distancia <= "3"){
        array_push($proximidades, $dados_pec);
    }
}

// OBTENDO VALORES DE FILTRO
// MODELO
$query_mod = "select * from modelo where id_mar=:marca";
$stmt_mod = $conexao->prepare($query_mod);
$stmt_mod->bindValue(":marca", $id_mar);
$stmt_mod->execute();
$dados_mod = $stmt_mod->fetchAll(\PDO::FETCH_ASSOC);

// DEFININDO SESSIONS
$_SESSION["dados_pec"] = $proximidades;
$_SESSION["marca"] = $marca;
$_SESSION["modelo"] = $modelo;
$_SESSION["ano"] = $ano;
$_SESSION["raio"] = "3";
$_SESSION["array_mod"] = $dados_mod;
$_SESSION["lat_usu"] = $lat_usu;
$_SESSION["lon_usu"] = $lon_usu;

unset($_SESSION["valMin"]);
unset($_SESSION["valMax"]);

header("location: ../tela_busca.php");
