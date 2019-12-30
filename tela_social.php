<?php
    session_start();
    
    // REQURINDO
    require_once "php/conexao.php";
    require_once "php/comprador.php";

    // CRIANDO INSTANCIA
    $comprador = new Comprador($conexao);

    // DECLARANDO VARIAVEIS
    $email_usu = $_SESSION["dados_usuario"]["email"];
    $lista_com = $comprador->listar();

    foreach($lista_com as $lista){
        if($lista["email_com"] == $email_usu){
            $_SESSION["dados_usuario"] = $lista;
            header("location: index.php");
            exit;
        }
    }

    if(isset($_SESSION["msg"])){
        $mensagem = $_SESSION["msg"];
        unset($_SESSION["msg"]);
    }
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
    <link rel="stylesheet" type="text/css" href="css/tela_social.css" />

    <!-- ICONS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

    <!-- LOGO -->
    <link rel="icon" href="img/logo.png">
</head>
<body>
     <!-- ALERTA -->
     <section class="alerta">
        <?php  if(isset($mensagem)){
                echo "<p>".$mensagem."</p>";
            }
        ?>
    </section>

    <!-- CONTAINER -->
    <section class="container">
        <!-- PROGRESSO -->
        <header class="progresso">
            <!-- INDICADOR -->
            <p class="indicador">
                Entrar <br>com a conta
                <strong><i class="material-icons">done</i></strong>
            </p>
            <!-- INDICADOR -->
            <p class="indicador">
                Definir <br>localização
                <strong>
                    <i class="material-icons desativado">done</i>
                    <i class="material-icons desativado">trip_origin</i>
                    <i class="material-icons">close</i>
                </strong>
            </p>
            <!-- INDICADOR -->
            <p class="indicador">
                Procurar <br>por peças
                <strong><i class="material-icons">more_horiz</i></strong>
            </p>
        </header>

        <!-- LOCALIZACAO -->
        <form class="localizacao" method="post" action="php/cadastro_facebook.php">
            <article class="campo">
                <input type="text" name="cep" pattern="[0-9]+$" minlength="8" maxlength="8" placeholder="CEP" required>
            </article>
            <p class="campo desativado">
                <input type="text" name="endereco" placeholder="Endereço" required>
            </p>
            <input type="submit" value="Continuar">
        </form>
    </section>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- JS -->
    <script src="js/pred.js"></script>
    <script src="js/tela_social.js"></script>
</body>
</html>