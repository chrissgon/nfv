<?php
    session_start();

    require_once "google_config.php";
    require_once "google_api.php";

    // Google passes a parameter 'code' in the Redirect Url
    if(isset($_GET['code'])) {
        try {
            $gapi = new GoogleLoginApi();
            
            // Get the access token 
            $data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
            
            // Get user information
            $user_info = $gapi->GetUserProfileInfo($data['access_token']);

            $nom_array = explode(" ", $user_info["name"]);
            $nome = $nom_array[0];
            $snome = $nom_array[1];
            $email = $user_info["email"];

            $usuario = array(
                "nome" => $nome,
                "snome" => $snome,
                "email" => $email,
            );

            $_SESSION["dados_usuario"] = $usuario;
            header("location: ../tela_social.php");
        }
        catch(Exception $e) {
            $_SESSION["msg"] = "Erro ao entrar com o google";
            header("location: ../login.php");
            exit;
        }
    }
?>