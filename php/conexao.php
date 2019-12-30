<?php
    //header ('Content-type: text/html; charset=UTF-8');
    try{
        $conexao = new \PDO("mysql:host=localhost; dbname=nfv", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $conexao->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(\PDOException $e){
        die ("Não foi possivel estabelecer a conexão com o banco - Erro: ".$e->getCode());
    };