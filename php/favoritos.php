<?php

class  Favoritos{
    private $db, $peca, $comprador;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    public function buscar($peca, $comprador){
        $query = "select * from favoritos where id_pec=:peca and id_com=:comprador";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":peca", $peca);
        $stmt->bindValue(":comprador", $comprador);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function favoritar(){
        $query = "insert into favoritos(id_pec, id_com) values(:peca, :comprador)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":peca", $this->getPeca());
        $stmt->bindValue(":comprador", $this->getComprador());
        $stmt->execute();
    }

    public function desfavoritar(){
        $query = "delete from favoritos where id_pec=:peca and id_com=:comprador";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":peca", $this->getPeca());
        $stmt->bindValue(":comprador", $this->getComprador());
        $stmt->execute();
    }

    // SET
    public function setPeca($peca){
        $this->peca = $peca;
        return $this;
    }
    public function setComprador($comprador){
        $this->comprador = $comprador;
        return $this;
    }

    // GET
    public function getPeca(){
        return $this->peca;
    }
    public function getComprador(){
        return $this->comprador;
    }

}
?>