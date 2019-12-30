<?php
session_start();

require_once "php/conexao.php";

$lembrar = isset($_SESSION["lembrar"]) ? $_SESSION["lembrar"] : null;

// RESETAR FORNECEDOR
if($lembrar != true){
    unset($_SESSION["dados_fornecedor"]);
}

// CONTA
$usuario = (isset($_SESSION["dados_usuario"])) ? $_SESSION["dados_usuario"] : false;
$login = $usuario != null ? true : false;

// LATITUDE E LONGITUDE DA CONTA
$lat_usu = ($usuario != false) ? $usuario["lat_com"] : null;
$lon_usu = ($usuario != false) ? $usuario["lon_com"] : null;

// INICIAIS DO USUARIO
$nome = ($usuario != false) ? $usuario["nome_com"][0] : null;
$snome = ($usuario != false) ? $usuario["snome_com"][0] : null;

echo "<script>let login='$login'; lat_usu = '$lat_usu'; lon_usu = '$lon_usu'</script>";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Nosso Ferro Velho</title>
    <!-- METAS -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="Christopher">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />

    <!-- ICONS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

    <!-- LOGO -->
    <link rel="icon" href="img/logo.png">
</head>
<body>
    <!-- USUARIO -->
    <?php
        if($usuario != false){
            echo "<section class='usuario'>
                <h3 clas='conta'>$nome$snome</h3>
                <!--<i class='material-icons'>favorite_border</i>
                <i class='material-icons'>settings</i>-->
                <a href='php/logout.php'><i class='material-icons'>exit_to_app</i></a>
            </section>";
        }
    ?>

    <!-- MODAL -->
    <section class="container-modal">
        <!-- modal - pitch -->
        <article class="modal modal-pitch">
            <iframe src="https://www.youtube.com/embed/tWugCvVKoUc?controls=0"></iframe>
        </article>

        <!-- modal - peca -->
        <form class="modal peca" action="php/buscar_peca.php" method="post">
            <!-- header -->
            <header class="header">
                <i class="material-icons">search</i>
                <p>Procure pela sua peça</p>
            </header>
            <!-- info -->
            <article class="info">
                <!-- btn-local -->
                <?php
                    if($usuario == false){
                        echo "<a class='btn-local'>";
                            echo "<input type='checkbox' name='local' id='local'>";
                            echo "<i class='material-icons local-ativado'>my_location</i>";
                            echo "<i class='material-icons'>done</i>";
                            echo "<i class='material-icons'>close</i>";
                            echo "<p>Use a minha localização</p>";
                        echo "</a>";
                    }
                    else{
                        echo "<a class='btn-conta'>";
                            echo "<input type='checkbox' name='local' id='local' checked>";
                            echo "<i class='material-icons'>account_circle</i>";
                            echo "<i class='material-icons local-ativado'>done</i>";
                            echo "<p>Localização da conta</p>";
                        echo "</a>";
                    }
                ?>
                <!-- campo -->
                <h3>Informe uma localização</h3>
                <article class="campo">
                    <input type="text" name="cep" pattern="[0-9]+$" minlength="8" maxlength="8" placeholder="CEP" required>
                    <!-- status -->
                    <article class="status">
                        <i class="material-icons erro desativado">close</i>
                        <i class="material-icons busca desativado">trip_origin</i>
                        <i class="material-icons sucesso desativado">done</i>
                    </article>
                </article>
                <article class="campo invisivel">
                    <input type="text" name="latitude" placeholder="Latitude" value="<?php echo $lat_usu?>" required>
                </article>
                <article class="campo invisivel">
                    <input type="text" name="longitude" placeholder="Longitude" value="<?php echo $lon_usu?>" required>
                </article>
                <!-- peca -->
                <h3>Preencha as informações</h3>
                <article class="peca">
                    <!-- marca -->
                    <article class="campo marca">
                        <article class="select">
                            <input type="text" name="marca" placeholder="Marca" readonly>
                            <article class="status">
                                <i class="material-icons desativado">trip_origin</i>
                            </article>
                        </article>
                        <article class="option">
                            <?php
                                $query_marca = "select * from marca";
                                $stmt_marca = $conexao->query($query_marca);
                                $marca = $stmt_marca->fetchAll(\PDO::FETCH_ASSOC);
                                foreach($marca as $lista){
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
                            <input type="text" name="modelo" placeholder="Modelo" readonly>
                        </article>
                        <article class="option">
                        </article>
                    </article>
                    <!-- ano -->
                    <article class="campo">
                        <input type="text" name="ano" pattern="[0-9]+$" minlength="4" maxlength="4" placeholder="Ano" required>
                    </article>
                </article>
            </article>
            <input type="submit" value="Procurar">
        </form>
    </section>

    <?php
        if($usuario == false){
            // BTN-NAV
            echo "<a class='btn-menu'><i class='material-icons'>menu</i></a>";

            // NAV
            echo "
            <nav class='menu'>
                <!-- guia -->
                <article class='guia'>
                    <h3>Conta</h3>
                    <a href='tela_login.php' class='aba'><i class='material-icons'>lock_open</i>Login</a>
                </article>
            </nav>
            ";
        }
    ?>

    <!-- MENU - DESKTOP -->
    <nav class="menu-desktop">
        <!-- logo -->
        <article class="logo">
            <img src="img/logo-branco.png">
        </article>
        <!-- guia -->
        <article class="guia">
            <?php
                if($usuario == false){
                    echo "<a href='tela_login.php' class='aba'>Login</a>";
                }
            ?>
        </article>
    </nav>

    <!-- HOME -->
    <section class="container home">
        <!-- info -->
        <article class="info">
            <h1>Encontre peças com apenas um toque!</h1>
            <p>O Nosso Ferro Velho é um mecanismo de pesquisa para peças automotivas que te permite encontrar peças usadas com preços mais acessíveis</p>
            <!-- opcoes -->
            <article class="opcoes">
                <a class="btn-peca"><i class="material-icons">search<strong>Pesquisar</strong></i></a>

                <a href="tela_cadastro.php" class="<?php echo $desativado = ($usuario == false) ? "" : "desativado"?>"><i class="material-icons">add <strong>Cadastrar</strong></i></a>
            </article>
        </article>
    </section>

    <!-- MOTIVOS -->
    <section class="container motivos">
        <!-- item -->
        <article class="item">
            <img src="img/icone-relogio.png">
            <h3>Poupe tempo</h3>
            <p>Encontre peças de forma rápida e prática</p>
        </article>
        <!-- item -->
        <article class="item">
            <img src="img/icone-dinheiro.png">
            <h3>Economize dinheiro</h3>
            <p>Compare peças e escolha a mais acessível</p>
        </article>
        <!-- item -->
        <article class="item">
            <img src="img/icone-mapa.png">
            <h3>Vá direto ao ponto</h3>
            <p>Localize a peça que precisa sem complicações</p>
        </article>
    </section>

    <!-- PITCH -->
    <section class="container pitch">
        <!-- info -->
        <header class="info">
            <h1>Um novo jeito de procurar por peças</h1>
            <p>Tenha a opção de filtrar as peças que deseja pela marca, modelo e ano e ainda use a sua localização para localizar a mais próxima de você</p>
        </header>
        <!-- video -->
        <article class="video">
            <a class="btn-pitch"><i class="material-icons">play_arrow</i></a>
        </article>
    </section>

    <!-- ESTATISTICAS -->
    <section class="estatisticas">
    </section>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- JS -->
    <script src="js/pred.js"></script>
    <script src="js/index.js"></script>
</body>
</html>