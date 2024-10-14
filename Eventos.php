<?php

class Evento{
    private $nome;
    private $dataInic;
    private $dataFim;
    private $ID;

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function createEvento($nome, $dataInic, $dataFim, $id){
        $sql = "INSERT INTO eventos(nome, dataInic, dataFim, ID)
                VALUES('$nome',
                        '$dataInic',
                        '$dataFim',
                        '$id')";
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function checkLoginReadOne($ID){
        $sql = "SELECT  * FROM eventos WHERE ID = $ID";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;    
        }
    }

    public function readAll(){
        $sql = "SELECT * FROM eventos";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    public function getNome($idEvento){
        $sql = "SELECT nome FROM eventos WHERE ID = $idEvento";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['nome'];
    }
    
    public function checarIdJaexistente($id){
        $sql = "SELECT ID FROM eventos";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                if ($row['ID'] == $id) {
                    return true;
                }
            }
        }
        return false;
    }

    public function updateEvento($nome, $dataInic, $dataFim, $id){
        $sql = "UPDATE eventos SET nome = '$nome', dataInic = '$dataInic', dataFim = '$dataFim' WHERE ID = $id";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function getAllDoEvento($idEvento){
        $sql = "SELECT * FROM eventos WHERE ID = $idEvento";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function deleteEvento($idEvento){
        $sql = "DELETE FROM eventos WHERE ID = $idEvento";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }
}

?>