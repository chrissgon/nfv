<?php

class Comprador{
    private $db, $nome, $snome, $latitude, $longitude, $cep, $endereco, $email, $senha;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    // METODOS
    public function buscar($id){
        $query = "select * from comprador where id_com=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function cadastrar(){
        $query = "insert into comprador(nome_com, snome_com, lat_com, lon_com, cep_com, end_com, email_com, senha_com) values(:nome, :snome, :latitude, :longitude, :cep, :end, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $this->getNome());
        $stmt->bindValue(":snome", $this->getSNome());
        $stmt->bindValue(":latitude", $this->getLatitude());
        $stmt->bindValue(":longitude", $this->getLongitude());
        $stmt->bindValue(":cep", $this->getCep());
        $stmt->bindValue(":end", $this->getEndereco());
        $stmt->bindValue(":email", $this->getEmail());
        $stmt->bindValue(":senha", $this->getSenha());
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function login($email, $senha){
        $query = "select * from comprador where binary email_com=:email and binary senha_com=:senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar(){
        $query = "select * from comprador";
        $stmt = $this->db->query($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // SET
    public function setNome($nome){
        $this->nome = $nome;
        return $this;
    }
    public function setSNome($snome){
        $this->snome = $snome;
        return $this;
    }
    public function setLatitude($latitude){
        $this->latitude = $latitude;
        return $this;
    }
    public function setLongitude($longitude){
        $this->longitude = $longitude;
        return $this;
    }
    public function setCep($cep){
        $this->cep = $cep;
        return $this;
    }
    public function setEndereco($endereco){
        $this->endereco = $endereco;
        return $this;
    }
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }
    public function setSenha($senha){
        $this->senha = $senha;
        return $this;
    }

    // GET
    public function getNome(){
        return $this->nome;
    }
    public function getSNome(){
        return $this->snome;
    }
    public function getLatitude(){
        return $this->latitude;
    }
    public function getLongitude(){
        return $this->longitude;
    }
    public function getCep(){
        return $this->cep;
    }
    public function getEndereco(){
        return $this->endereco;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getSenha(){
        return $this->senha;
    }
}