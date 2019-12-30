<?php
    session_start();

    require_once "php/conexao.php";
    require_once "php/fornecedor.php";
    require_once "php/pecas.php";
    require_once "php/imagem.php";

    $fornecedor = new Fornecedor($conexao);
    $peca = new Pecas($conexao);
    $imagem = new Imagem($conexao);

    if(!isset($_SESSION["dados_fornecedor"])){
        header("location: tela_login.php");
    }
    else{
        $dados = $_SESSION["dados_fornecedor"];
    }

    $filtro_mar = isset($_SESSION["filtro_mar"]) ? $_SESSION["filtro_mar"] : null;
    $filtro_mod = isset($_SESSION["filtro_mod"]) ? $_SESSION["filtro_mod"] : null;
    $filtro_ano = isset($_SESSION["filtro_ano"]) ? $_SESSION["filtro_ano"] : null;

    $tela = (isset($_SESSION["tela_fornecedor"])) ? $_SESSION["tela_fornecedor"] : "false";

    $status = ($fornecedor->verificar_descricao($dados["id_for"])["des_for"] == "") ? "false" : "true";

    $dados_pec_for = (isset($_SESSION["dados_pec_for"])) ? $_SESSION["dados_pec_for"] : $peca->buscar_responsavel($dados["id_for"]);

    echo "<script>status = $status; id_for = ".$dados["id_for"]."; tela='$tela'</script>";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Fornecedor</title>
    <!-- METAS -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="Christopher">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/tela_fornecedor.css" />

    <!-- ICONS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

    <!-- LOGO -->
    <link rel="icon" href="img/logo.png">
</head>
<body>
    <!-- ALERTA -->
    <section class="alerta">
        <?php  if(isset($_SESSION["msg"])){
                echo "<p>".$_SESSION["msg"]."</p>";
                unset($_SESSION["msg"]);
            }
        ?>
    </section>

    <!-- MODAL -->
    <section class="container-modal">
        <!-- descricao -->
        <article class="modal descricao">
            <!-- header -->
            <header class="header">
                <i class="material-icons">edit</i>
                <p>Escreva uma descrição</p>
            </header>
            <article class="info">
                <p>Informe dados importantes sobre o seu estabelecimento</p>
                <p class="campo">
                    <textarea name="descricao" placeholder="Descrição"></textarea>
                </p>
                <input type="submit" value="Enviar">
            </article>
        </article>
        <!-- editar - pecas -->
        <form class="modal edicao" action="php/atualizar_peca.php" method="post" enctype="multipart/form-data">
            <!-- header -->
            <header class="header">
                <i class="material-icons">edit</i>
                <p>Edite a sua peça</p>
            </header>
            <article class="info">
                <!-- id -->
                <article class="campo invisivel">
                    <input type="text" name="id" maxlength="11" placeholder="Id" required>
                </article>
                <!-- marca -->
                <article class="campo marca">
                    <!-- select -->
                    <article class="select">
                        <input type="text" name="marca" placeholder="Marca" readonly>
                    </article>
                    <!-- option -->
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
                    <!-- select -->
                    <article class="select">
                        <input type="text" name="modelo" placeholder="Modelo" readonly>
                    </article>
                    <!-- option -->
                    <article class="option">
                    </article>
                </article>
                <!-- ano -->
                <article class="campo">
                    <input type="text" name="ano" pattern="[0-9]+$" minlength="4" maxlength="4" placeholder="Ano" required>
                </article>
                <!-- nome -->
                <article class="campo">
                    <input type="text" name="nome" pattern="[0-9a-zA-ZÀ-ž\s]+" placeholder="Nome" required>
                </article>
                <!-- descricao -->
                <article class="campo textarea">
                    <textarea name="descricao" class="descricao" pattern="[0-9a-zA-ZÀ-ž\s]+" maxlength="255" placeholder="Descrição" required></textarea>
                    <p><strong class="limite">255</strong></p>
                </article>
                <!-- preco -->
                <article class="campo">
                    <input type="text" name="preco" maxlength="9" placeholder="Preço" required>
                </article>
                <!-- imagem -->
                <article class="campo file">
                    <label for="img_edit">
                        <i class="material-icons">archive</i>
                        <p class="nome">Imagem</p>
                    </label>
                    <input type="file" name="img_edit" id="img_edit" accept="image/jpeg, image/png">
                </article>
                <!-- id image -->
                <article class="campo invisivel">
                    <input type="text" name="id_ima" maxlength="11" placeholder="Id">
                </article>
            </article>
            <footer class="footer">
                <input type="submit" value="Editar">
            </footer>
        </form>

        <!-- deletar - pecas -->
        <form class="modal excluir" action="php/deletar_peca.php" method="post">
            <!-- info -->
            <article class="info">
                <h3>Deseja excluir a peça?</h3>
                <p class="nome"></p>

                <!-- id -->
                <article class="campo invisivel">
                    <input type="text" name="id" maxlength="11" placeholder="Id" required>
                </article>

                <!-- submit -->
                <input type="submit" value="Sim">
            </article>
        </form>
    </section>

    <!-- BTN-NAV -->
    <a class="btn-menu"><i class="material-icons">menu</i></a>
    <!-- NAV -->
    <nav class="menu">
        <!-- header -->
        <header class="header">
            <article class="opcoes">
                <a href="php/logout.php"><i class="material-icons">arrow_back</i></a>
                <!-- <i class="material-icons conta">settings</i> -->
            </article>
            <article class="info">
                <h1 class="nome"><?php echo $dados["rs_for"]?></h1>
                <p class="email"><?php echo $dados["email_for"]?></p>
            </article>
        </header>
        <!-- guia -->
        <article class="guia">
            <h3>Peças</h3>
            <a class="aba edicao"><i class="material-icons">list</i>Lista</a>
            <a class="aba cadastro"><i class="material-icons">add</i>Cadastrar</a>
        </article>
    </nav>

    <!-- EDIÇÃO -->
    <section class="container edicao">

        <!-- BTN-FLOAT -->
        <a class="btn-float">
            <i class="material-icons">filter_list</i><p>Filtro</p>
        </a>

        <!-- filtro -->
        <article class="filtro">
            <!-- filtro-pecas -->
            <article class="filtro-pecas">
                <!-- header -->
                <form class="header" action="php/resetar_peca.php" method="post">
                    <h3>Filtro de Peças</h3>
                    <button class="btn-reset">
                        <i class="material-icons">cached</i>
                    </button>
                </form>
                <!-- info -->
                <form class="info" action="php/filtrar_peca.php" method="post">
                    <!-- marca -->
                    <article class="campo marca">
                        <article class="select">
                            <input type="text" name="marca" placeholder="Marca" value="<?php echo $filtro_mar?>" readonly>
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
                            <input type="text" name="modelo" placeholder="Modelo" value="<?php echo $filtro_mod?>" readonly>
                        </article>
                        <article class="option">
                           
                        </article>
                    </article>
                    <!-- ano -->
                    <article class="campo">
                        <input type="text" name="ano" pattern="[0-9]+$" minlength="4" maxlength="4" placeholder="Ano" value="<?php echo $filtro_ano?>">
                    </article>
                    <input type="submit" value="Filtrar">
                </form>
            </article>
        </article>

        <h3>Lista de peças</h3>
        
        <!-- pesquisa -->
        <article class="campo pesquisa">
            <input type="text" name="pesquisa" placeholder="Pesquise">
            <!-- BTN-PESQUISA -->
            <a class="btn-pesquisa">
                <i class="material-icons">filter_list</i><p>Filtro</p>
            </a>
        </article>
        </article>
        <article class="lista">
            <!-- peca -->
            <?php
            if($dados_pec_for == null){
                echo "<p class='msg'><i class='material-icons'>error</i>Nenhuma peça encontrada</p>";
            }
            else{
                // PAGINACAO
                $pagAtual = (isset($_GET["pag"])) ? $_GET["pag"] : 1;
                $lmtReg = 20;
                $proPag = ($pagAtual * $lmtReg) - $lmtReg;
                $lmtAtual = $pagAtual * $lmtReg;
                // NUMERO DE RESULTADOS
                $num_bus = count($dados_pec_for);
                $qtdPag = ceil($num_bus / $lmtReg);

                for($res = $proPag; $res < $lmtAtual; $res++){
                    if(isset($dados_pec_for[$res])){
                        // IMAGEM
                        $id_img = $dados_pec_for[$res]["id_ima"];
                        $dados_img = $imagem->buscar($id_img);
    
                        // MARCA
                        $query_marca = "select * from marca where id_mar=:marca";
                        $stmt_marca = $conexao->prepare($query_marca);
                        $stmt_marca->bindValue(":marca", $dados_pec_for[$res]["id_mar"]);
                        $stmt_marca->execute();
                        $dados_marca = $stmt_marca->fetch(\PDO::FETCH_ASSOC);
    
                        // MODELO
                        $query_modelo = "select * from modelo where id_mod=:modelo";
                        $stmt_modelo = $conexao->prepare($query_modelo);
                        $stmt_modelo->bindValue(":modelo", $dados_pec_for[$res]["id_mod"]);
                        $stmt_modelo->execute();
                        $dados_modelo = $stmt_modelo->fetch(\PDO::FETCH_ASSOC);
    
                        echo "<article class='peca' id='".$dados_pec_for[$res]["id_pec"]."'>";
                            // img
                            echo "
                            <figure class='img'>
                                <img src='img_peca/$id_img/".$dados_img["nome_ima"]."'>
                            </figure>
                            ";
        
                            // info
                            echo "
                            <article class='info'>
                                <h3 class='nome'>".$dados_pec_for[$res]["nome_pec"]."</h3>
                                <p class='esp'>
                                    ".$dados_marca["nome_mar"]." (".$dados_modelo["nome_mod"].") - ".$dados_pec_for[$res]["ano_pec"]."
                                </p>
                                <p class='descricao'>".$dados_pec_for[$res]["des_pec"]."</p>
                                <p class='preco'>R$ ".number_format($dados_pec_for[$res]["val_pec"], 0, ",", ".")."</p>
                            </article>
                            ";
        
                            // actions
                            echo "
                            <footer class='actions'>
                                <a class='editar'><i class='material-icons'>edit</i></a>
                                <a class='excluir'><i class='material-icons'>close</i></a>
                            </footer>
                            ";
                        echo "</article>";
                    }
                }
            }
            ?>
        </article>
        <article class="paginacao">
            <article class="pagina">
            <?php
            if(isset($num_bus) && $num_bus != 0){
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
    </section>

    <!-- CADASTRO -->
    <section class="container cadastro">
        <h3>Cadastro de peças</h3>
        <form class="info" action="php/cadastro_peca.php" method="post" enctype="multipart/form-data">
            <!-- marca -->
            <article class="campo marca">
                <!-- select -->
                <article class="select">
                    <input type="text" name="marca" placeholder="Marca" readonly>
                </article>
                <!-- option -->
                <article class="option">
                    <?php
                        $query_marca = "select * from marca";
                        $stmt_marca = $conexao->query($query_marca);
                        $dados_marca = $stmt_marca->fetchAll(\PDO::FETCH_ASSOC);
                        foreach($dados_marca as $dados_pec_for){
                            echo "<p id='".$dados_pec_for["id_mar"]."'>";
                            echo $dados_pec_for["nome_mar"];
                            echo "</p>";
                        }
                    ?>
                </article>
            </article>
            <!-- modelo -->
            <article class="campo modelo">
                <!-- select -->
                <article class="select">
                    <input type="text" name="modelo" placeholder="Modelo" readonly>
                </article>
                <!-- option -->
                <article class="option">
                   
                </article>
            </article>
            <!-- ano -->
            <article class="campo">
                <input type="text" name="ano" pattern="[0-9]+$" minlength="4" maxlength="4" placeholder="Ano" required>
            </article>
            <!-- nome -->
            <article class="campo">
                <input type="text" name="nome" pattern="[0-9a-zA-ZÀ-ž\s]+" placeholder="Nome" required>
            </article>
            <!-- descricao -->
            <article class="campo textarea">
                <textarea name="descricao" class="descricao" pattern="[0-9a-zA-ZÀ-ž\s]+" maxlength="255" placeholder="Descrição" required></textarea>
                <p><strong class="limite">255</strong></p>
            </article>
            <!-- preco -->
            <article class="campo">
                <input type="text" name="preco" maxlength="9" placeholder="Preço" required>
            </article>
            <!-- imagem -->
            <article class="campo file">
                <label for="img_cad">
                    <i class="material-icons">archive</i>
                    <p class="nome">Imagem</p>
                </label>
                <input type="file" name="img_cad" id="img_cad" accept="image/jpeg, image/png" required>
            </article>
            <input type="submit" value="Enviar">
        </form>
    </section>

    <!-- CONTA -->
    <section class="container conta">
        cccc
    </section>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- MASK PLUGIN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <!-- JS -->
    <script src="js/pred.js"></script>
    <script src="js/tela_fornecedor.js"></script>
</body>
</html>