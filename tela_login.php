<?php
    session_start();

    require_once "php/google_config.php";

    $lembrar = (isset($_SESSION["lembrar"])) ? $_SESSION["lembrar"] : null;

    if(isset($_SESSION["msg"])){
        $mensagem = $_SESSION["msg"];
        unset($_SESSION["msg"]);
    }

    if(isset($_SESSION["dados_usuario"])){
        header("location: index.php");
    }

    if($lembrar != null){
        $_SESSION["tela_fornecedor"] = "edicao";
        unset($_SESSION["dados_pec_for"]);
        header("location: tela_fornecedor.php");
    }

    // FACEBOOK LOGIN
    require_once "vendor/facebook/graph-sdk/src/Facebook/autoload.php";

    $fb = new \Facebook\Facebook([
      'app_id' => '389480381752454',
      'app_secret' => 'd0f7c2ea6831a75147981c3f7acf677e',
      'default_graph_version' => 'v2.9',
    ]);

    $helper = $fb->getRedirectLoginHelper();

    $permissions = ["email"];

    $loginUrl = $helper->getLoginUrl("http://localhost/nfv_2/php/fb-callback.php", $permissions);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Entrar</title>
    <!-- METAS -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="Christopher">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/tela_login.css" />

    <!-- ICONS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

    <!-- LOGO -->
    <link rel="icon" href="img/logo.png">
</head>
<body>
    <!-- BTN-FLOAT -->
    <a href="index.php" class="btn-float">
        <i class="material-icons">home</i>
    </a>

    <!-- ALERTA -->
    <section class="alerta">
        <?php  if(isset($mensagem)){
                echo "<p>".$mensagem."</p>";
            }
        ?>
    </section>

    <!-- LOGIN -->
    <section class="login">
        <!-- mensagem -->
        <article class="mensagem">
            <h1>Rápido, fácil e simples</h1>
            <p>Ache a peça ideal para você através da nossa plataforma</p>
            <a href="tela_cadastro.php" class="btn-cadastro">Cadastre-se</a>
        </article>
        <!-- formulario -->
        <form action="php/login.php" method="post" class="formulario">
            <h3>Entrar</h3>
            <article class="info">
                <!-- campo -->
                <article class="campo">
                    <input type="text" name="email" placeholder="Email">
                </article>
                <!-- campo -->
                <article class="campo">
                    <input type="password" name="senha" placeholder="Senha">
                </article>
                <article class="opcao">
                    <p>
                        <input type="checkbox" name="lembrar" id="lembrar">
                        <label for="lembrar">
                            <i class="material-icons checked">check_box_outline_blank</i>
                            <i class="material-icons">check_box</i>
                            Manter conectado
                        </label>
                    </p>
                    <!-- <a href="">Esqueceu a senha?</a> -->
                </article>
                <input type="submit" value="Entrar">
                <p class="divisao">ou</p>
                <article class="social">
                    <a href="<?php echo $loginUrl?>"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>"><i class="fab fa-google"></i></a>
                </article>
            </article>
        </form>
    </section>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- JS -->
    <script src="js/pred.js"></script>
    <script src="js/tela_login.js"></script>
</body>
</html>