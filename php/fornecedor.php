<?php

class Fornecedor{
    private $db, $rs, $cnpj, $latitude, $longitude, $cep, $endereco, $email, $senha;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    // METODOS
    public function buscar($id){
        $query = "select * from fornecedor where id_for=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function cadastrar(){
        $query = "insert into fornecedor(rs_for, cnpj_for, lat_for, lon_for, cep_for, end_for, email_for, senha_for) values(:rs, :cnpj, :latitude, :longitude, :cep, :end, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":rs", $this->getRs());
        $stmt->bindValue(":cnpj", $this->getCnpj());
        $stmt->bindValue(":latitude", $this->getLatitude());
        $stmt->bindValue(":longitude", $this->getLongitude());
        $stmt->bindValue(":cep", $this->getCep());
        $stmt->bindValue(":end", $this->getEndereco());
        $stmt->bindValue(":email", $this->getEmail());
        $stmt->bindValue(":senha", $this->getSenha());
        $stmt->execute();
    }

    public function verificar_descricao($id){
        $query = "select des_for from fornecedor where id_for=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function atualizar_descricao($id, $descricao){
        $query = "update fornecedor set des_for=:descricao where id_for=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":descricao", $descricao);
        $stmt->execute();
    }

    public function login($email, $senha){
        $query = "select * from fornecedor where binary email_for=:email and binary senha_for=:senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function listar(){
        $query = "select * from fornecedor";
        $stmt = $this->db->query($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // SET
    public function setRs($rs){
        $this->rs = $rs;
        return $this;
    }
    public function setCnpj($cnpj){
        $this->cnpj = $cnpj;
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
    public function getRs(){
        return $this->rs;
    }
    public function getCnpj(){
        return $this->cnpj;
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