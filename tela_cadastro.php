<?php
    session_start();

    if(isset($_SESSION["msg"])){
        $mensagem = $_SESSION["msg"];
        unset($_SESSION["msg"]);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro</title>
    <!-- METAS -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="Christopher">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/tela_cadastro.css" />

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

    <!-- CADASTRO -->
    <form class="cadastro" action="php/cadastro_usuario.php" method="post">
        <h3>Tipo de conta</h3>
        <!-- conta -->
        <header class="conta">
            <article class="opcao">
                <input type="checkbox" name="fornecedor" id="fornecedor" checked>
                <label for="fornecedor" class="label-active"><i class="material-icons">build</i>Vendedor</label>
            </article>
            <article class="opcao">
                <input type="checkbox" name="comprador" id="comprador">
                <label for="comprador"><i class="material-icons">local_offer</i> Comprador</label>
            </article>
        </header>
        <!-- info - fornecedor -->
        <article class="info fornecedor">
            <article class="campo">
                <input type="text" name="cnpj" minlength="14" maxlength="14" pattern="[0-9]+$" placeholder="CNPJ" required>
                <!-- status -->
                <article class="status">
                    <i class="material-icons erro desativado">close</i>
                    <i class="material-icons busca desativado">trip_origin</i>
                    <i class="material-icons sucesso desativado">done</i>
                </article>
            </article>
            <p class="campo desativado">
                <input type="text" name="rs" tabindex="1" placeholder="Razão Social" required>
            </p>
            <p class="campo desativado">
                <input type="text" name="cep" pattern="[0-9]+$" minlength="8" maxlength="8" placeholder="CEP" required>
            </p>
            <p class="campo">
                <input type="text" name="endereco" placeholder="Endereço" required>
            </p>
            <p class="campo">
                <input type="text" name="email" placeholder="Email" required>
            </p>
            <p class="campo">
                <input type="password" name="senha" minlength="8" pattern="[a-zA-Z0-9]+" placeholder="Senha" required>
            </p>
        </article>

        <!-- info - comprador -->
        <article class="info comprador">
            <p class="campo">
                <input type="text" name="nome" pattern="[a-zA-ZÀ-ž\s]+" placeholder="Nome" required>
            </p>
            <p class="campo">
                <input type="text" name="sobrenome" pattern="[a-zA-ZÀ-ž\s]+" placeholder="Sobrenome" required>
            </p>
            <p class="campo">
                <input type="text" name="email" placeholder="Email" required>
            </p>
            <article class="campo">
                <input type="text" name="cep" pattern="[0-9]+$" minlength="8" maxlength="8" placeholder="CEP" required>
                <!-- status -->
                <article class="status">
                    <i class="material-icons erro desativado">close</i>
                    <i class="material-icons busca desativado">trip_origin</i>
                    <i class="material-icons sucesso desativado">done</i>
                </article>
            </article>
            <p class="campo desativado">
                <input type="text" name="endereco" tabindex="1" placeholder="Endereço" required>
            </p>
            <p class="campo">
                <input type="password" name="senha" minlength="8" pattern="[a-zA-Z0-9]+" placeholder="Senha" required>
            </p>
        </article>
        <input type="submit" value="Cadastrar">
    </form>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- JS -->
    <script src="js/pred.js"></script>
    <script src="js/tela_cadastro.js"></script>
</body>
</html>