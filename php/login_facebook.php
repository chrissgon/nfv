<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])){

  $appId = '389480381752454';
  $appSecret = 'd0f7c2ea6831a75147981c3f7acf677e';
  $redirectUri = urlencode('http://localhost/nfv_2/php/login_facebook.php');

  $code = $_GET['code'];

  $token_url = "https://graph.facebook.com/oauth/access_token?"
  . "client_id=" . $appId . "&redirect_uri=" . $redirectUri
  . "&client_secret=" . $appSecret . "&code=" . $code;

  $response = json_decode(file_get_contents($token_url));
  if($response){
    $params = (array)$response;
    if(isset($params["access_token"]) && $params["access_token"]){
      $graph_url = "https://graph.facebook.com/me?access_token="
      . $params["access_token"];
      $user = json_decode(file_get_contents($graph_url));

      if(isset($user->email) && $user->email){
        $usuario = array(
          "email" => $user->email,
          "nome" => $user->name,
          "localizacao" => $user->location->name,
          "perfil" => $user->username
        );
        print_r($usuario);
      }else{
        echo "Erro de conexão com Facebook";
      }
    }
  }else{
    echo "Erro de conexão com Facebook";
  }
}else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])){
  echo 'Permissão não concedida';
}
?>