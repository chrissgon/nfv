<?php

class Pecas{
    private $db, $fornecedor, $marca, $modelo, $ano, $nome, $descricao, $valor, $imagem;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    // METODOS
    public function atualizar($id){
        $query = "update peca set id_mar=:marca, id_mod=:modelo, ano_pec=:ano, nome_pec=:nome, des_pec=:descricao, val_pec=:valor where id_pec=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":marca", $this->getMarca());
        $stmt->bindValue(":modelo", $this->getModelo());
        $stmt->bindValue(":ano", $this->getAno());
        $stmt->bindValue(":nome", $this->getNome());
        $stmt->bindValue(":descricao", $this->getDescricao());
        $stmt->bindValue(":valor", $this->getValor());
        try{
            $stmt->execute();
        }
        catch(PDOException $e){
            return "Erro ao atualizar";
        }
    }

    public function buscar($marca, $modelo, $ano){
        $query = "select * from peca where id_mar=:marca and id_mod=:modelo and ano_pec=:ano order by nome_pec";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":marca", $marca);
        $stmt->bindValue(":modelo", $modelo);
        $stmt->bindValue(":ano", $ano);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function buscar_id($id){
        $query = "select * from peca where id_pec=:peca order by nome_pec";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":peca", $id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function buscar_preco($marca, $modelo, $ano, $valMin, $valMax){
        $query = "select * from peca where id_mar=:marca and id_mod=:modelo and ano_pec=:ano and val_pec between :valMin and :valMax order by nome_pec";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":marca", $marca);
        $stmt->bindValue(":modelo", $modelo);
        $stmt->bindValue(":ano", $ano);
        $stmt->bindValue(":valMin", $valMin);
        $stmt->bindValue(":valMax", $valMax);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function buscar_responsavel($id_for){
        $query = "select * from peca where id_for=:id order by nome_pec";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id_for);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrar($paramQuery, $id_for, $marca, $modelo, $ano){
        $stmt = $this->db->prepare($paramQuery);
        $stmt->bindValue(":id", $id_for);
        if($marca != "" && $ano == ""){
            $stmt->bindValue(":marca", $marca);
            $stmt->bindValue(":modelo", $modelo);
        }
        else if($marca == "" && $ano != ""){
            $stmt->bindValue(":ano", $ano);
        }
        else if($marca != "" && $ano != ""){
            $stmt->bindValue(":marca", $marca);
            $stmt->bindValue(":modelo", $modelo);
            $stmt->bindValue(":ano", $ano);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function cadastrar(){
        $query = "insert into peca(id_for, id_mar, id_mod, ano_pec, nome_pec, des_pec, val_pec, id_ima) values(:fornecedor, :marca, :modelo, :ano, :nome, :descricao, :valor, :imagem)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":fornecedor", $this->getFornecedor());
        $stmt->bindValue(":marca", $this->getMarca());
        $stmt->bindValue(":modelo", $this->getModelo());
        $stmt->bindValue(":ano", $this->getAno());
        $stmt->bindValue(":nome", $this->getNome());
        $stmt->bindValue(":descricao", $this->getDescricao());
        $stmt->bindValue(":valor", $this->getValor());
        $stmt->bindValue(":imagem", $this->getImagem());
        if($stmt->execute()){
            return "Peça cadastrada com sucesso";
        }
        else{
            return "Ocorreu um erro ao cadastrar";
        }
        
    }

    public function listar_preco(){
        $query = "select val_pec from peca";
        $stmt = $this->db->query($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deletar($id){
        $query = "delete from peca where id_pec=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id);
        if($stmt->execute()){
            return "Peça excluída com sucesso";
        }
        else{
            return "Ocorreu um erro ao excluir";
        }
    }

    // SET
    public function setFornecedor($fornecedor){
        $this->fornecedor = $fornecedor;
        return $this;
    }
    public function setMarca($marca){
        $this->marca = $marca;
        return $this;
    }
    public function setModelo($modelo){
        $this->modelo = $modelo;
        return $this;
    }
    public function setAno($ano){
        $this->ano = $ano;
        return $this;
    }
    public function setNome($nome){
        $this->nome = $nome;
        return $this;
    }
    public function setDescricao($descricao){
        $this->descricao = $descricao;
        return $this;
    }
    public function setValor($valor){
        $this->valor = $valor;
        return $this;
    }
    public function setImagem($imagem){
        $this->imagem = $imagem;
        return $this;
    }

    // GET
    public function getFornecedor(){
        return $this->fornecedor;
    }
    public function getMarca(){
        return $this->marca;
    }
    public function getModelo(){
        return $this->modelo;
    }
    public function getAno(){
        return $this->ano;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function getValor(){
        return $this->valor;
    }
    public function getImagem(){
        return $this->imagem;
    }
}