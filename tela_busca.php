<?php

session_start();

require_once "php/conexao.php";
require_once "php/fornecedor.php";
require_once "php/pecas.php";
require_once "php/imagem.php";
require_once "php/favoritos.php";

$fornecedor = new Fornecedor($conexao);
$peca = new Pecas($conexao);
$imagem = new Imagem($conexao);
$favoritos = new Favoritos($conexao);

// RESGATANDO SESSIONS
$marca = $_SESSION["marca"];
$modelo = $_SESSION["modelo"];
$ano = $_SESSION["ano"];
$lista_mod = $_SESSION["array_mod"];
$busca = $_SESSION["dados_pec"];
$lat_usu =$_SESSION["lat_usu"];
$lon_usu = $_SESSION["lon_usu"];
$raio = (isset($_SESSION["raio"])) ? $_SESSION["raio"]." Km" : "3 Km";
$usuario = (isset($_SESSION["dados_usuario"])) ? $_SESSION["dados_usuario"] : false;
$id_comprador = ($usuario != false) ? $usuario["id_com"] : "false";

echo "<script>let lat=$lat_usu, lon=$lon_usu; id_com=$id_comprador</script>";

// NUMERO DE RESULTADOS
$num_bus = count($busca);

// VARIAVEIS DE PREÇO
$valor = 0;
$array_valores = $peca->listar_preco();
foreach($array_valores as $lista){
    $val_pec = strval($lista["val_pec"]);
    $valor = ($val_pec > $valor) ? $val_pec : $valor;
}

// VALORES MAXIMO E MINIMO
$valMin = (isset($_SESSION["valMin"])) ? $_SESSION["valMin"] : "0";
$valMax = (isset($_SESSION["valMax"])) ? $_SESSION["valMax"] : $valor;

// OBTENDO INFORMAÇÕES DO FORNECEDORES
$array_for = array();
foreach($busca as $dados_pec){
    $for_pec = $dados_pec["id_for"];
    array_push($array_for, $for_pec);
}
$id_for = array_unique($array_for);

$dados_for = array();

foreach($id_for as $lista){
    $dados = $fornecedor->buscar($lista);
    array_push($dados_for, $dados);
}

echo "<script>let array_for=".json_encode($dados_for)."</script>";

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Peças</title>
    <!-- METAS -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="Christopher">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/tela_busca.css" />

    <!-- ICONS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

    <!-- LOGO -->
    <link rel="icon" href="img/logo.png">
</head>
<body>
    <!-- LOAD -->
    <section class="load">
        <div class="loader"></div>
    </section>

    <!-- MENSAGEM -->
    <section class="mensagem">
        <p>Necessário efetuar o <a href="tela_login.php">login</a> na sua conta</p>
    </section>

    <!-- BTN-FLOAT -->
    <a href="index.php" class="btn-float">
        <i class="material-icons">home</i>
    </a>

    <!-- MODAL -->
    <section class="container-modal">
        <!-- fornecedores -->
        <article class="modal fornecedores">
            <header class="header">
                <i class="material-icons">settings</i>
                <p>Informações</p>
            </header>
            <article class="info">
                <article class="mapaFornecedor">
                    <a id="mapaFornecedor" target="_blank"></a>
                </article>
                <article class="sobre">
                    <h3 class="rs"></h3>
                    <p class="descricao"></p>
                    <a class="link" target="_blank"><i class="material-icons">place</i>Ver local</a>
                </article>
            </article>
        </article>
        <!-- chat -->
        <article class="modal chat">
            <header class="header">
                <i class="material-icons">forum</i>
                <p>Qual a sua pergunta?</p>
            </header>
            <article class="info">
                <p>Enviaremos a sua mensagem ao fornecedor através do email</p>
                <p class="campo">
                    <textarea name="mensagem" placeholder="Mensagem"></textarea>
                </p>
                <p class="campo invisivel">
                    <input type="text" name="fornecedor">
                </p>
                <p class="campo invisivel">
                    <input type="text" name="peca">
                </p>
                <button class="submitChat">Enviar</button>
            </article>
        </article>
    </section>

    <!-- BTN-NAV -->
    <a class="btn-menu"><i class="material-icons">filter_list</i><p>Filtro</p></a>
    <!-- NAV -->
    <nav class="menu">
        <!-- guia -->
        <article class="guia">
            <!-- info -->
            <form class="info" method="post" action="php/filtrar_busca.php">
                <h3>Peça</h3>
                <!-- marca -->
                <article class="campo marca">
                    <article class="select">
                        <input type="text" name="marca" placeholder="Marca" value="<?php echo $marca?>" readonly>
                    </article>
                    <article class="option">
                        <?php
                            $query_marca = "select * from marca";
                            $stmt_marca = $conexao->query($query_marca);
                            $dados_marca = $stmt_marca->fetchAll(\PDO::FETCH_ASSOC);
                            foreach($dados_marca as $lista){
                                echo "<p id='".$lista["id_mar"]."'>";
                                echo $lista["nome_mar"];
                                echo "</p>";
                            }
                        ?>
                    </article>
                </article>
                <!-- modelo -->
                <article class="campo modelo">
                    <article class="select">
                        <input type="text" name="modelo" placeholder="Modelo" value="<?php echo $modelo?>" readonly>
                    </article>
                    <article class="option">
                        <?php
                            foreach($lista_mod as $modelos){
                                echo "<p id='".$modelos["id_mod"]."'>";
                                echo $modelos["nome_mod"];
                                echo "</p>";
                            }
                        ?>
                    </article>
                </article>
                <!-- ano -->
                <article class="campo">
                    <input type="text" name="ano" pattern="[0-9]+$" minlength="4" maxlength="4" placeholder="Ano" value="<?php echo $ano?>" required>
                </article>

                <h3>Distância</h3>
                <!-- distancia -->
                <article class="campo">
                    <article class="select">
                        <input type="text" name="raio" placeholder="Raio" value="<?php echo $raio?>" readonly>
                    </article>
                    <article class="option">
                        <p>3 Km</p>
                        <p>5 Km</p>
                        <p>10 Km</p>
                        <p>15 Km</p>
                        <p>20 Km</p>
                        <p>25 Km</p>
                    </article>
                </article>

                <h3>Preço</h3>
                <!-- preço -->
                <article class="campo range">
                        <input type="range" class="min" name="valMin" step="any" value="<?php echo $valMin?>" min="0" max="<?php echo $valor?>">
                        <input type="range" class="max" name="valMax" step="any" value="<?php echo $valMax?>" min="0" max="<?php echo $valor?>">
                        <p class="preco min"><?php echo $valMin?></p>
                        <p class="preco max"><?php echo $valMax?></p>
                </article>

                <h3>Fornecedores</h3>
                <!-- fornecedores -->
                <p id="todos" class="fornecedor">
                    <i class="material-icons check">done</i>
                    <i class="material-icons">radio_button_unchecked</i>
                    <input type='radio' name='fornecedor' value="todos" checked>
                    <strong>Todos</strong>
                </p>
                <?php
                    foreach($id_for as $lista){
                        $dados_for = $fornecedor->buscar($lista);
                        echo "<p class='fornecedor' id=".$dados_for["id_for"].">";
                        echo "<i class='material-icons'>done</i>";
                        echo "<i class='material-icons check'>radio_button_unchecked</i>";
                        echo "<input type='radio' name='fornecedor' value='".$dados_for["id_for"]."'>";
                        echo "<strong>".$dados_for["rs_for"]."</strong>";
                        echo "</p>";
                    }
                ?>
                <article class="btn-filtro">
                    <input type="submit" class="btn-filtro" value="">
                    <i class="material-icons">filter_list <p>Filtrar</p></i>
                </article>
            </form>
        </article>
    </nav>

    <!-- BANNER -->
    <section class="banner">
        <h1>Encontre a peça que precisar aonde você estiver</h1>
        <p>Refine sua busca e encontre a peça que deseja de uma forma simples e prática</p>
    </section>

    <!-- RESULTADOS -->
    <section class="container resultados">
        <!-- filtro -->
        <form class="filtro" method="post" action="php/filtrar_busca.php">
            <article class="btn-filtro">
                <input type="submit" class="btn-filtro" value="">
                <i class="material-icons">filter_list <p>Filtrar</p></i>
            </article>
            <!-- info -->
            <article class="info">
                <h3>Peça</h3>
                <!-- marca -->
                <article class="campo marca">
                    <article class="select">
                        <input type="text" name="marca" placeholder="Marca" value="<?php echo $marca?>" readonly>
                    </article>
                    <article class="option">
                        <?php
                            $query_marca = "select * from marca";
                            $stmt_marca = $conexao->query($query_marca);
                            $dados_marca = $stmt_marca->fetchAll(\PDO::FETCH_ASSOC);
                            foreach($dados_marca as $lista){
                                echo "<p id='".$lista["id_mar"]."'>";
                                echo $lista["nome_mar"];
                                echo "</p>";
                            }
                        ?>
                    </article>
                </article>
                <!-- modelo -->
                <article class="campo modelo">
                    <article class="select">
                        <input type="text" name="modelo" placeholder="Modelo" value="<?php echo $modelo?>" readonly>
                    </article>
                    <article class="option">
                        <?php
                            foreach($lista_mod as $modelos){
                                echo "<p id='".$modelos["id_mod"]."'>";
                                echo $modelos["nome_mod"];
                                echo "</p>";
                            }
                        ?>
                    </article>
                </article>
                <!-- ano -->
                <article class="campo">
                    <input type="text" name="ano" pattern="[0-9]+$" minlength="4" maxlength="4" placeholder="Ano" value="<?php echo $ano?>" required>
                </article>

                <h3>Distância</h3>
                <!-- distancia -->
                <article class="campo">
                    <article class="select">
                        <input type="text" name="raio" placeholder="Raio" value="<?php echo $raio?>" readonly>
                    </article>
                    <article class="option">
                        <p>3 Km</p>
                        <p>5 Km</p>
                        <p>10 Km</p>
                        <p>15 Km</p>
                        <p>20 Km</p>
                        <p>25 Km</p>
                    </article>
                </article>

                <h3>Preço</h3>
                <!-- preço -->
                <article class="campo range">
                        <input type="range" class="min" name="valMin" step="any" value="<?php echo $valMin?>" min="0" max="<?php echo $valor?>">
                        <input type="range" class="max" name="valMax" step="any" value="<?php echo $valMax?>" min="0" max="<?php echo $valor?>">
                        <p class="preco min"><?php echo $valMin?></p>
                        <p class="preco max"><?php echo $valMax?></p>
                </article>

                <h3>Fornecedores</h3>
                <!-- fornecedores -->
                <p id="todos" class="fornecedor">
                    <i class="material-icons check">done</i>
                    <i class="material-icons">radio_button_unchecked</i>
                    <input type='radio' name='fornecedor' value="todos" checked>
                    <strong>Todos</strong>
                </p>
                <?php
                    foreach($id_for as $lista){
                        $dados_for = $fornecedor->buscar($lista);
                        echo "<p class='fornecedor' id=".$dados_for["id_for"].">";
                        echo "<i class='material-icons'>done</i>";
                        echo "<i class='material-icons check'>radio_button_unchecked</i>";
                        echo "<input type='radio' name='fornecedor' value='".$dados_for["id_for"]."'>";
                        echo "<strong>".$dados_for["rs_for"]."</strong>";
                        echo "</p>";
                    }
                ?>
            </article>
        </form>

        <!-- peca -->
        <article class="peca">
            <article class="organizador">
                <!-- pesquisa -->
                <a class="pesquisa pesquisa-ativa">
                    <i class="material-icons pesquisa-ativa">search</i>
                    <input type="text" name="pesquisa">
                </a>
                <!-- visualizacao -->
                <a class="visualizacao">
                    <i class="material-icons visualizacao-ativa" id="mapa">map</i>
                    <i class="material-icons" id="lista">list</i>
                </a>
            </article>

            <h1>Encontrado um total de <?php echo $num_bus?> peça(s)</h1>

            <!-- lista -->
            <article class="container lista">
                <?php
                    $pagAtual = (isset($_GET["pag"])) ? $_GET["pag"] : 1;
                    $lmtReg = 20;
                    $proPag = ($pagAtual * $lmtReg) - $lmtReg;
                    $lmtAtual = $pagAtual * $lmtReg;
                    $qtdPag = ceil($num_bus / $lmtReg);

                    for($res = $proPag; $res < $lmtAtual; $res++){
                        if(isset($busca[$res])){
                            $id = $busca[$res]["id_for"];
                            $id_pec = $busca[$res]["id_pec"];
                            $nome = $busca[$res]["nome_pec"];
                            $descricao = $busca[$res]["des_pec"];
                            $val = number_format($busca[$res]["val_pec"], 0, ",", ".");
                            $id_img = $busca[$res]["id_ima"];

                            $dados_img = $imagem->buscar($id_img);
                            $nome_img = $dados_img["nome_ima"];

                            $dados_fav = $favoritos->buscar($id_pec, $id_comprador);
                            $status_fav = false;

                            foreach($dados_fav as $lista){
                                $com_fav = $lista["id_com"];
                                $pec_fav = $lista["id_pec"];

                                if($com_fav == $id_comprador && $pec_fav == $id_pec){
                                    $status_fav = true;
                                }
                            }

                            $favoritado = ($status_fav == true) ? "favoritado" : null;
                            $fav_checked = ($status_fav == true) ? "checked" : null;

                            $status_chat = ($id_comprador == "false") ? "" : "ativado";

                            // item
                            echo "<article class='item' id='".$id."'>";
                                // img
                                echo "<figure class='img'>";
                                    echo "<img src='img_peca/".$id_img."/".$nome_img."'>";
                                echo "</figure>";

                                // info
                                echo "<header class='info'>";
                                    echo "<h3 class='nome'>".$nome."</h3>";
                                    echo "<p class='descricao'>".$descricao."</p>";
                                    echo "<p class='preco'>R$".$val."</p>";
                                echo "</header>";
                                // footer
                                echo "<footer class='opcoes' id='$id_pec'>";
                                    echo "<a class='opcao sobre'><i class='material-icons'>search</i></a>";
                                    echo "<a class='opcao chat'><i class='material-icons $status_chat'>chat_bubble</i></a>";
                                    echo "<a class='opcao favoritos'>
                                            <input type='checkbox' class='status_fav' $fav_checked>
                                            <i class='material-icons $favoritado'>favorite</i>
                                        </a>";
                                echo "</footer>";
                            echo "</article>";
                        }
                    }
                ?>
                <article class="paginacao">
                    <article class="pagina">
                    <?php
                    if($num_bus != 0){
                        for ($i=$pagAtual - 2, $numInd = $i + 4; $i <= $numInd; $i++) { 
                          if($i < 1){
                              $i = 1;
                              $numInd = 5;
                          }
                          if($numInd > $qtdPag){
                              $numInd = $qtdPag;
                              $i = $numInd - 4;
                          }
                          if($i < 1) {
                              $i = 1;
                              $numInd = $qtdPag;
                          }
                          if($i == $pagAtual){
                              echo "<a class='indice disabled'>$i</a>";
                          }
                          else{
                              echo "<a href='?pag=$i' class='indice'>$i</a>";
                          }
                        }
                    }
                    ?>
                    </article>
                </article>
            </article>

            <article class="container mapa" id="mapaContainer">
                
            </article>
        </article>

    </section>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- JS -->
    <!-- AIzaSyC-5rJINp8dnT7bpltaO2b0jKE_Y1Nci9g -->
    <script src="js/pred.js"></script>
    <script src="js/tela_busca.js"></script>
</body>
</html>