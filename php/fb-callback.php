<?php
    session_start();

    require_once "../vendor/facebook/graph-sdk/src/Facebook/autoload.php";

    $fb = new \Facebook\Facebook([
      'app_id' => '389480381752454',
      'app_secret' => 'd0f7c2ea6831a75147981c3f7acf677e',
      'default_graph_version' => 'v2.9',
    ]);

    $helper = $fb->getRedirectLoginHelper();

    try {
        $accessToken = $helper->getAccessToken();
        if ($accessToken !== null) {
        $Response = $fb->get("/me?fields=email,first_name,last_name, picture", $accessToken);

        $user = $Response->getGraphUser();

        $email = $user->getEmail();
        $nome = $user->getFirstName();
        $snome = $user->getLastName();
        $foto = $user->getPicture();

        $usuario = array(
            "nome" => $nome,
            "snome" => $snome,
            "email" => $email,
        );

        $_SESSION["dados_usuario"] = $usuario;
        header("location: ../tela_social.php");

        }
    }catch(Facebook\Exceptions\FacebookResponseException $e) {
        $_SESSION["msg"] = "Erro ao entrar com o facebook";
        header("location: ../login.php");
        exit;
    }catch(Facebook\Exceptions\FacebookSDKException $e) {
        $_SESSION["msg"] = "Erro ao entrar com o facebook";
        header("location: ../login.php");
        exit;
    }
?>