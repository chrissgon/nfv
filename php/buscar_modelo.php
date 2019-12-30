<?php

require_once "conexao.php";

$marca = filter_input(INPUT_GET, "marca");

$query = "select * from modelo where id_mar=:marca";
$stmt = $conexao->prepare($query);
$stmt->bindValue(":marca", $marca);
$stmt->execute();
$modelo = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo json_encode($modelo);