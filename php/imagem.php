<?php

class Imagem{
    private $db, $nome;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    public function atualizar($id){
        $query = "update imagem set nome_ima=:nome where id_ima=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome", $this->getNome());
        
        try{
            $stmt->execute();
        }
        catch(PDOException $e){
            return "Erro ao atualizar";
        }
    }

    public function buscar($id){
        $query = "select * from imagem where id_ima=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function cadastrar(){
        $query = "insert into imagem(nome_ima) values(:nome)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $this->getNome());
        $stmt->execute();
        $id = $this->db->lastInsertId();
        mkdir("../img_peca/".$id, 0755);
        return $id;
    }

    public function redimensionar($formato, $imagem, $largura, $altura, $id){
        switch($formato):
            case "image/jpeg";
                $img_temp = imagecreatefromjpeg($imagem["tmp_name"]);
                $lar_orig = imagesx($img_temp);
                $alt_orig = imagesy($img_temp);
                $lar_red = $largura ? $largura : floor(($lar_orig / $alt_orig) * $altura);
                $alt_red = $altura ? $altura : floor(($alt_orig / $lar_orig) * $largura);
                $img_red = imagecreatetruecolor($lar_red, $alt_red);
                imagecopyresampled($img_red, $img_temp, 0, 0, 0, 0, $lar_red, $alt_red, $lar_orig, $alt_orig);
                imagejpeg($img_red, "../img_peca/".$id."/".$imagem["name"]);
            break;
            case "image/png";
                $img_temp = imagecreatefrompng($imagem["tmp_name"]);
                $lar_orig = imagesx($img_temp);
                $alt_orig = imagesy($img_temp);
                $lar_red = $largura ? $largura : floor(($lar_orig / $alt_orig) * $altura);
                $alt_red = $altura ? $altura : floor(($alt_orig / $lar_orig) * $largura);
                $img_red = imagecreate($lar_red, $alt_red);
                imagecopyresampled($img_red, $img_temp, 0, 0, 0, 0, $lar_red, $alt_red, $lar_orig, $alt_orig);
                imagepng($img_red, "../img_peca/".$id."/".$imagem["name"]);
            break;
        endswitch;
    }

    // SET
    public function setNome($nome){
        $this->nome = $nome;
        return $this;
    }
    // GET
    public function getNome(){
        return $this->nome;
    }
}