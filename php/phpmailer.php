<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

function enviarEmail($comprador, $fornecedor, $peca, $mensagem, $data){
  $mail = new PHPMailer();

  try{
    // CONFIGURÇÕES
    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "christopher.goncalves2002@gmail.com";
    $mail->Password = "Kiko7041309339744811kiko";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->CharSet = 'utf-8';

    // REMENTENTE E DESTINATARIO
    $mail->setFrom($comprador["email_com"], $comprador["nome_com"]." ".$comprador["snome_com"]);
    $mail->AddAddress("christopher.goncalves2002@hotmail.com.br");

    // MENSAGEM
    $mail->Subject = "Nosso Ferro Velho";
    $mail->isHTML(true);
    $mail->Body = "
    <style>
      @import url('https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&display=swap');
    </style>

    <h1 style=\"font-family: Montserrat; font-weight: 400\">Contato de <span style=\" color: #cb2d3e\">".$comprador['nome_com']."</span> sobre a peça <span style=\" color: #cb2d3e\">$peca</span></h1>
    <p style=\"font-family: Montserrat;\">$mensagem</p>
    <p style=\"font-family: Montserrat; font-size: .8rem;\">$data</p>
    ";

    if ($mail->Send()) {
      echo "Email enviado com sucesso";
  } else {
      echo "Erro ao enviar o email";
  }
  }catch(Exception $e){
    echo "Erro ao enviar o email";
  }
}
?>