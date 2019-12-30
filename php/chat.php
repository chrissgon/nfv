<?php
session_start();

// REQUERINDO
require_once "conexao.php";
require_once "fornecedor.php";
require_once "pecas.php";
require_once "phpmailer.php";

// INSTANCIAS
$fornecedor = new Fornecedor($conexao);
$peca = new Pecas($conexao);

// PEGANDO DADOS
$id_for = filter_input(INPUT_POST, "fornecedor");
$id_pec = filter_input(INPUT_POST, "peca");
$mensagem = filter_input(INPUT_POST, "mensagem");

// METODOS
$dados_for = $fornecedor->buscar($id_for);
$dados_pec = $peca->buscar_id($id_pec);
$dados_com = $_SESSION["dados_usuario"];

// VARIAVEIS
$email_for = $dados_for["email_for"];
$nome_pec = $dados_pec[0]["nome_pec"];

// data
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$data = "Enviada no dia ".strftime('%d de %B de %Y', strtotime('today'));

$status = enviarEmail($dados_com, $email_for, $nome_pec, $mensagem, $data);

echo $status;
?>